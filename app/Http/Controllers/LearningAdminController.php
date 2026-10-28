<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AccountIdentity;
use App\Services\LearningProgress;
use App\Services\QuizGrader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LearningAdminController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'section' => 'nullable|in:overview,courses,students,waiting,create',
            'q' => 'nullable|string|max:100',
            'status' => 'nullable|in:draft,published,archived',
            'account' => 'nullable|in:Active,Inactive',
        ]);
        $section = $filters['section'] ?? 'overview';
        $search = trim($filters['q'] ?? '');
        $courseCounts = DB::table('learning_courses')->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $studentCount = User::where('role', 'student')->count();
        $activeStudentCount = User::where('role', 'student')->where('status', 'Active')->count();
        $courses = DB::table('learning_courses')
            ->select('learning_courses.*')
            ->selectSub(DB::table('learning_enrollments')->selectRaw('COUNT(*)')->whereColumn('course_id', 'learning_courses.id')->where('status', 'active'), 'students')
            ->selectSub(DB::table('learning_lessons')->selectRaw('COUNT(*)')->whereColumn('course_id', 'learning_courses.id'), 'lessons');
        if ($section === 'courses') {
            if ($search !== '') {
                $courses->where(fn ($q) => $q->where('title', 'like', '%'.$search.'%')->orWhere('code', 'like', '%'.$search.'%')->orWhere('instructor', 'like', '%'.$search.'%'));
            }
            if (! empty($filters['status'])) {
                $courses->where('status', $filters['status']);
            }
        }
        $courses = $courses->orderByDesc('id')->paginate(8, ['*'], 'course_page')->withQueryString();
        $students = User::where('role', 'student');
        if ($section === 'students') {
            if ($search !== '') {
                $students->where(fn ($q) => $q->where('name', 'like', '%'.$search.'%')->orWhere('username', 'like', '%'.$search.'%')->orWhere('student_id', 'like', '%'.$search.'%'));
            }
            if (! empty($filters['account'])) {
                $students->where('status', $filters['account']);
            }
        }
        $students = $students->orderBy('name')->paginate(12, ['*'], 'student_page')->withQueryString();
        $pendingGrades = DB::table('learning_submissions')->whereNull('graded_at')->count();
        $reviewQueue = DB::table('learning_submissions as s')->join('learning_assignments as a', 'a.id', '=', 's.assignment_id')
            ->join('learning_courses as c', 'c.id', '=', 'a.course_id')->whereNull('s.graded_at')
            ->select('c.id', 'c.title')->selectRaw('COUNT(*) as pending')->groupBy('c.id', 'c.title')->orderByDesc('pending')->limit(4)->get();

        $waitingStudents = $this->waitingStudents()->orderBy('created_at')->get();
        $enrollmentCourses = DB::table('learning_courses')->whereIn('status', ['draft', 'published'])->orderBy('title')->get();
        return view('learning.admin', compact('waitingStudents', 'enrollmentCourses', 'courses', 'students', 'pendingGrades', 'section', 'search', 'courseCounts', 'studentCount', 'activeStudentCount', 'reviewQueue'));
    }

    private function waitingStudents()
    {
        return User::where('role', 'student')->whereNotExists(function ($query) {
            $query->selectRaw('1')->from('learning_enrollments')->whereColumn('learning_enrollments.user_id', 'users.id');
        });
    }

    public function enrollWaiting(Request $request)
    {
        $data = $request->validate([
            'course_id' => ['required', 'integer', Rule::exists('learning_courses', 'id')->whereIn('status', ['draft', 'published'])],
            'students' => 'required|array|min:1',
            'students.*' => ['required', 'integer', 'distinct', Rule::exists('users', 'id')->where('role', 'student')],
        ]);
        $count = DB::transaction(function () use ($data) {
            $course = DB::table('learning_courses')->where('id', $data['course_id'])->lockForUpdate()->first();
            abort_unless($course && in_array($course->status, ['draft', 'published'], true), 422, 'Choose an available class.');
            $students = User::where('role', 'student')->whereIn('id', $data['students'])->orderBy('id')->lockForUpdate()->get();
            $count = 0;
            foreach ($students as $student) {
                if (DB::table('learning_enrollments')->where('user_id', $student->id)->exists()) {
                    continue;
                }
                DB::table('learning_enrollments')->insert([
                    'course_id' => $course->id, 'user_id' => $student->id, 'status' => 'active',
                    'created_at' => now(), 'updated_at' => now(),
                ]);
                $count++;
            }
            return $count;
        });
        return redirect()->route('admin.index', ['section' => 'waiting'])->with('success', $count.' students enrolled.');
    }

    public function saveCourse(Request $request, ?int $course = null)
    {
        if ($course) {
            $this->course($course);
        }
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'code' => ['required', 'string', 'max:100', Rule::unique('learning_courses', 'code')->ignore($course)],
            'description' => 'nullable|string|max:20000', 'instructor' => 'required|string|max:255',
            'status' => 'required|in:draft,published,archived', 'self_enrollment' => 'sometimes|boolean',
        ]);
        $data['self_enrollment'] = $request->boolean('self_enrollment');
        $data['updated_at'] = now();
        if ($data['status'] === 'published') {
            abort_unless($course && DB::table('learning_lessons')->where('course_id', $course)->where('published', true)->exists(), 422, 'Publish at least one lesson before publishing a course.');
        }
        if ($course) {
            DB::table('learning_courses')->where('id', $course)->update($data);
        } else {
            $course = DB::table('learning_courses')->insertGetId($data + ['created_at' => now()]);
        }

        return redirect()->route('admin.courses.show', $course)->with('success', 'Course saved.');
    }

    public function show(int $course, LearningProgress $progress)
    {
        $course = $this->course($course);
        app(QuizGrader::class)->expire();
        $lessons = DB::table('learning_lessons')->where('course_id', $course->id)->orderBy('position')->orderBy('id')->get();
        $assignments = DB::table('learning_assignments')->where('course_id', $course->id)->get();
        $submissions = DB::table('learning_submissions as s')->join('learning_assignments as a', 'a.id', '=', 's.assignment_id')->join('users as u', 'u.id', '=', 's.user_id')->where('a.course_id', $course->id)->select('s.*', 'a.title', 'a.max_score', 'u.name')->orderByDesc('s.submitted_at')->get();
        $quizzes = DB::table('learning_quizzes')->where('course_id', $course->id)->get();
        foreach ($quizzes as $quiz) {
            $quiz->questions = DB::table('learning_questions')->where('quiz_id', $quiz->id)->get();
            $quiz->started = DB::table('learning_attempts')->where('quiz_id', $quiz->id)->exists();
        }
        $students = User::where('role', 'student')->orderBy('name')->get();
        $enrollments = DB::table('learning_enrollments as e')->join('users as u', 'u.id', '=', 'e.user_id')->where('e.course_id', $course->id)->select('e.*', 'u.name', 'u.username', 'u.student_id')->get();
        foreach ($enrollments as $e) {
            $e->progress = $progress->forStudent($course->id, $e->user_id);
        }
        $attempts = DB::table('learning_attempts as a')->join('learning_quizzes as q', 'q.id', '=', 'a.quiz_id')->join('users as u', 'u.id', '=', 'a.user_id')->where('q.course_id', $course->id)->select('a.*', 'q.title', 'u.name')->orderByDesc('a.id')->get();

        return view('learning.manage-course', compact('course', 'lessons', 'assignments', 'submissions', 'quizzes', 'students', 'enrollments', 'attempts'));
    }

    public function saveLesson(Request $request, int $course, ?int $lesson = null)
    {
        $this->course($course);
        if ($lesson) {
            $this->child('lessons', $lesson, $course);
        }
        $data = $request->validate([
            'title' => 'required|string|max:255', 'section' => 'required|string|max:255',
            'content' => 'required|string|max:100000', 'video_url' => 'nullable|url:http,https|max:2048',
            'position' => 'required|integer|min:1|max:10000', 'published' => 'sometimes|boolean',
            'material' => 'nullable|file|mimes:pdf,txt,doc,docx,ppt,pptx,zip|max:20480',
        ]);
        unset($data['material']);
        $data['published'] = $request->boolean('published');
        if ($request->hasFile('material')) {
            $data['file_path'] = $request->file('material')->store('learning/materials', 'local');
            $data['file_name'] = $request->file('material')->getClientOriginalName();
        }
        $this->save('lessons', $data, $course, $lesson);

        return back()->with('success', 'Lesson saved.');
    }

    public function saveAssignment(Request $request, int $course, ?int $assignment = null)
    {
        $this->course($course);
        if ($assignment) {
            $this->child('assignments', $assignment, $course);
            abort_if(DB::table('learning_submissions')->where('assignment_id', $assignment)->exists(), 422, 'This assignment has submissions. Create a new assignment to change its requirements.');
        }
        $data = $request->validate([
            'title' => 'required|string|max:255', 'instructions' => 'required|string|max:100000',
            'due_at' => 'nullable|date', 'max_score' => 'required|integer|min:1|max:10000',
            'pass_score' => 'required|integer|min:0|lte:max_score', 'published' => 'sometimes|boolean',
        ]);
        $data['published'] = $request->boolean('published');
        DB::transaction(function () use ($data, $course, $assignment) {
            if ($assignment) {
                DB::table('learning_assignments')->where('id', $assignment)->lockForUpdate()->first();
                abort_if(DB::table('learning_submissions')->where('assignment_id', $assignment)->exists(), 422, 'This assignment already has submissions and is locked.');
            }
            $this->save('assignments', $data, $course, $assignment);
        });

        return back()->with('success', 'Assignment saved.');
    }

    public function saveQuiz(Request $request, int $course, ?int $quiz = null)
    {
        $this->course($course);
        if ($quiz) {
            $this->child('quizzes', $quiz, $course);
            abort_if(DB::table('learning_attempts')->where('quiz_id', $quiz)->exists(), 422, 'This quiz has started attempts and is locked. Create a new quiz instead.');
        }
        $data = $request->validate([
            'title' => 'required|string|max:255', 'duration_minutes' => 'required|integer|min:1|max:240',
            'pass_percentage' => 'sometimes|integer|in:50', 'max_attempts' => 'required|integer|min:1|max:10',
            'opens_at' => 'nullable|date', 'closes_at' => ['nullable', 'date', Rule::when($request->filled('opens_at'), 'after:opens_at')], 'published' => 'sometimes|boolean',
        ]);
        $data['pass_percentage'] = 50;
        $questions = $request->has('questions') ? $request->validate($this->questionRules())['questions'] : [];
        $data['published'] = $request->boolean('published');
        DB::transaction(function () use ($data, $course, $quiz, $questions) {
            if ($quiz) {
                DB::table('learning_quizzes')->where('id', $quiz)->lockForUpdate()->first();
                abort_if(DB::table('learning_attempts')->where('quiz_id', $quiz)->exists(), 422, 'This quiz has started attempts and is locked.');
            }
            abort_if($data['published'] && (! $quiz || ! DB::table('learning_questions')->where('quiz_id', $quiz)->exists()), 422, 'Add questions before publishing the quiz.');
            $id = $quiz ?: DB::table('learning_quizzes')->insertGetId($data + ['course_id' => $course, 'created_at' => now(), 'updated_at' => now()]);
            if ($quiz) {
                $this->save('quizzes', $data, $course, $quiz);
            }
            $this->insertQuestions($id, $questions);
        });

        return back()->with('success', 'Quiz saved.');
    }

    public function addQuestion(Request $request, int $course, int $quiz)
    {
        $this->child('quizzes', $quiz, $course);
        abort_if(DB::table('learning_attempts')->where('quiz_id', $quiz)->exists(), 422, 'Questions are locked after the first attempt.');
        $request->merge(['questions' => $request->input('questions', [$request->only('prompt', 'options', 'correct_option', 'points')])]);
        $data = $request->validate($this->questionRules());
        DB::transaction(function () use ($quiz, $data) {
            DB::table('learning_quizzes')->where('id', $quiz)->lockForUpdate()->first();
            abort_if(DB::table('learning_attempts')->where('quiz_id', $quiz)->exists(), 422, 'Questions are locked after the first attempt.');
            $this->insertQuestions($quiz, $data['questions']);
        });
        return back()->with('success', 'Questions added.');
    }

    private function questionRules(): array
    {
        return [
            'questions' => 'required|array|min:1|max:100',
            'questions.*.prompt' => 'required|string|max:10000', 'questions.*.options' => 'required|array:A,B,C,D|size:4',
            'questions.*.options.*' => 'required|string|max:2000', 'questions.*.correct_option' => 'required|in:A,B,C,D',
            'questions.*.points' => 'required|integer|min:1|max:1000',
        ];
    }

    private function insertQuestions(int $quiz, array $questions): void
    {
        foreach ($questions as $question) {
            $question['options'] = json_encode($question['options']);
            DB::table('learning_questions')->insert($question + ['quiz_id' => $quiz, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    public function deleteQuestion(int $course, int $quiz, int $question)
    {
        $this->child('quizzes', $quiz, $course);
        abort_if(DB::table('learning_attempts')->where('quiz_id', $quiz)->exists(), 422, 'Questions are locked after the first attempt.');
        DB::transaction(function () use ($quiz, $question) {
            DB::table('learning_quizzes')->where('id', $quiz)->lockForUpdate()->first();
            abort_if(DB::table('learning_attempts')->where('quiz_id', $quiz)->exists(), 422, 'Questions are locked after the first attempt.');
            DB::table('learning_questions')->where('quiz_id', $quiz)->where('id', $question)->delete();
            if (! DB::table('learning_questions')->where('quiz_id', $quiz)->exists()) {
                DB::table('learning_quizzes')->where('id', $quiz)->update(['published' => false]);
            }
        });

        return back()->with('success', 'Question removed.');
    }

    public function enroll(Request $request, int $course)
    {
        $this->course($course);
        $data = $request->validate(['user_id' => ['required', Rule::exists('users', 'id')->where('role', 'student')], 'status' => 'required|in:active,suspended']);
        DB::transaction(function () use ($course, $data) {
            DB::table('learning_courses')->where('id', $course)->lockForUpdate()->first();
            DB::table('learning_enrollments')->updateOrInsert(['course_id' => $course, 'user_id' => $data['user_id']], ['status' => $data['status'], 'updated_at' => now(), 'created_at' => now()]);
        });

        return back()->with('success', 'Enrollment updated. Learning history is preserved.');
    }

    public function grade(Request $request, int $submission)
    {
        $row = DB::table('learning_submissions')->where('id', $submission)->first();
        abort_unless($row, 404);
        $assignment = DB::table('learning_assignments')->where('id', $row->assignment_id)->first();
        $data = $request->validate(['score' => 'required|numeric|min:0|max:'.$assignment->max_score, 'feedback' => 'required|string|max:10000']);
        DB::transaction(function () use ($submission, $data, $request, $row, $assignment) {
            DB::table('learning_assignments')->where('id', $assignment->id)->lockForUpdate()->first();
            DB::table('learning_enrollments')->where('course_id', $assignment->course_id)->where('user_id', $row->user_id)->lockForUpdate()->first();
            DB::table('learning_submissions')->where('id', $submission)->update($data + ['graded_by' => $request->user()->id, 'graded_at' => now(), 'updated_at' => now()]);
        });

        return back()->with('success', 'Grade and feedback saved.');
    }

    public function reopen(Request $request, int $submission)
    {
        $row = DB::table('learning_submissions')->find($submission);
        abort_unless($row, 404);
        $data = $request->validate(['due_at' => 'required|date|after:now']);
        DB::transaction(function () use ($row, $data) {
            $assignment = DB::table('learning_assignments')->where('id', $row->assignment_id)->lockForUpdate()->first();
            DB::table('learning_enrollments')->where('course_id', $assignment->course_id)->where('user_id', $row->user_id)->lockForUpdate()->first();
            DB::table('learning_assignments')->where('id', $row->assignment_id)->update(['due_at' => $data['due_at'], 'updated_at' => now()]);
            DB::table('learning_submissions')->where('id', $row->id)->update(['score' => null, 'graded_at' => null, 'graded_by' => null, 'updated_at' => now()]);
        });

        return back()->with('success', 'Submission reopened. The course assignment deadline was extended for all students.');
    }

    public function extendAttempts(Request $request, int $course, int $quiz)
    {
        $this->child('quizzes', $quiz, $course);
        $data = $request->validate(['max_attempts' => 'required|integer|min:1|max:10']);
        $row = DB::table('learning_quizzes')->find($quiz);
        abort_unless($data['max_attempts'] > $row->max_attempts, 422, 'The new attempt limit must be higher.');
        DB::table('learning_quizzes')->where('id', $quiz)->update($data + ['updated_at' => now()]);

        return back()->with('success', 'Attempt limit increased for all enrolled students.');
    }

    public function saveStudent(Request $request, AccountIdentity $identity)
    {
        $identity->create($request->all());

        return redirect()->route('admin.index', ['section' => 'students'])->with('success', 'Student account created. Assign a course to begin learning.');
    }

    public function studentStatus(Request $request, int $student)
    {
        $data = $request->validate(['status' => 'required|in:Active,Inactive']);
        User::where('role', 'student')->findOrFail($student)->update($data);

        return back()->with('success', 'Account status updated.');
    }

    public function export(int $course, LearningProgress $progress)
    {
        $this->course($course);
        $rows = DB::table('learning_enrollments as e')->join('users as u', 'u.id', '=', 'e.user_id')->where('course_id', $course)->select('u.id', 'u.name', 'u.username', 'u.student_id', 'e.status')->get();

        return response()->streamDownload(function () use ($rows, $progress, $course) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Student', 'Username', 'Student ID', 'Enrollment', 'Progress %', 'Lessons completed', 'Assignments passed', 'Quizzes passed', 'Completion requirements met']);
            foreach ($rows as $row) {
                $p = $progress->forStudent($course, $row->id);
                $safe = fn ($v) => preg_match('/^[=+@\-\t\r]/u', $v) ? "'".$v : $v;
                fputcsv($file, [$safe($row->name), $safe($row->username ?? ''), $safe($row->student_id ?? ''), $row->status, $p['percentage'], $p['completed_lessons'], $p['passed_assignments'], $p['passed_quizzes'], $p['eligible'] ? 'Yes' : 'No']);
            }
            fclose($file);
        }, 'course-'.$course.'-progress.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function course(int $id)
    {
        $course = DB::table('learning_courses')->find($id);
        abort_unless($course, 404);

        return $course;
    }

    private function child(string $table, int $id, int $course)
    {
        abort_unless(DB::table('learning_'.$table)->where('id', $id)->where('course_id', $course)->exists(), 404);
    }

    private function save(string $table, array $data, int $course, ?int $id)
    {
        $data['updated_at'] = now();
        if ($id) {
            DB::table('learning_'.$table)->where('id', $id)->where('course_id', $course)->update($data);
        } else {
            DB::table('learning_'.$table)->insert($data + ['course_id' => $course, 'created_at' => now()]);
        }
    }
}
