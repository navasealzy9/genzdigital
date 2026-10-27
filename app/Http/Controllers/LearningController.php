<?php

namespace App\Http\Controllers;

use App\Services\LearningProgress;
use App\Services\QuizGrader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LearningController extends Controller
{
    public function index(Request $request, LearningProgress $progress)
    {
        if ($request->user()->role === 'admin') {
            return redirect()->route('admin.index');
        }
        app(QuizGrader::class)->expire($request->user()->id);
        $courses = DB::table('learning_courses')->where('status', 'published')->orderBy('title')->get();
        $enrollments = DB::table('learning_enrollments')->where('user_id', $request->user()->id)->get()->keyBy('course_id');
        foreach ($courses as $course) {
            $course->progress = $progress->forStudent($course->id, $request->user()->id);
        }

        return view('learning.dashboard', compact('courses', 'enrollments'));
    }

    public function enroll(Request $request, int $course)
    {
        $course = $this->publishedCourse($course);
        abort_unless($course->self_enrollment, 403, 'Contact the administrator to enroll.');
        DB::transaction(function () use ($request, $course) {
            $fresh = DB::table('learning_courses')->where('id', $course->id)->lockForUpdate()->first();
            abort_unless($fresh->status === 'published' && $fresh->self_enrollment, 403, 'This course is no longer open for self-enrollment.');
            $existing = DB::table('learning_enrollments')->where('course_id', $course->id)->where('user_id', $request->user()->id)->first();
            abort_if($existing && $existing->status !== 'active', 403, 'Your enrollment is suspended.');
            if (! $existing) {
                DB::table('learning_enrollments')->insert(['course_id' => $course->id, 'user_id' => $request->user()->id, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()]);
            }
        });

        return redirect()->route('learning.course', $course->id)->with('success', 'You are enrolled. Start your first lesson.');
    }

    public function show(Request $request, int $course, LearningProgress $progress)
    {
        $course = $this->access($request, $course);
        app(QuizGrader::class)->expire($request->user()->id);
        $lessons = DB::table('learning_lessons')->where('course_id', $course->id)->where('published', true)->orderBy('position')->orderBy('id')->get();
        $completed = DB::table('learning_completions')->where('user_id', $request->user()->id)->pluck('lesson_id')->all();
        $assignments = DB::table('learning_assignments')->where('course_id', $course->id)->where('published', true)->get();
        $submissions = DB::table('learning_submissions')->where('user_id', $request->user()->id)->whereIn('assignment_id', $assignments->pluck('id'))->get()->keyBy('assignment_id');
        $quizzes = DB::table('learning_quizzes')->where('course_id', $course->id)->where('published', true)->get();
        $attempts = DB::table('learning_attempts')->where('user_id', $request->user()->id)->whereIn('quiz_id', $quizzes->pluck('id'))->orderByDesc('id')->get()->groupBy('quiz_id');
        $progress = $progress->forStudent($course->id, $request->user()->id);

        return view('learning.course', compact('course', 'lessons', 'completed', 'assignments', 'submissions', 'quizzes', 'attempts', 'progress'));
    }

    public function lesson(Request $request, int $lesson)
    {
        $lesson = $this->find('lessons', $lesson);
        $course = $this->access($request, $lesson->course_id);
        abort_unless($lesson->published, 404);
        $complete = DB::table('learning_completions')->where('lesson_id', $lesson->id)->where('user_id', $request->user()->id)->exists();

        return view('learning.lesson', compact('course', 'lesson', 'complete'));
    }

    public function complete(Request $request, int $lesson)
    {
        $lesson = $this->find('lessons', $lesson);
        $this->access($request, $lesson->course_id);
        abort_unless($lesson->published, 404);
        DB::table('learning_completions')->insertOrIgnore(['lesson_id' => $lesson->id, 'user_id' => $request->user()->id, 'created_at' => now(), 'updated_at' => now()]);

        return redirect()->route('learning.course', $lesson->course_id)->with('success', 'Lesson marked complete.');
    }

    public function submitAssignment(Request $request, int $assignment)
    {
        $assignment = $this->find('assignments', $assignment);
        $this->access($request, $assignment->course_id);
        abort_unless($assignment->published, 404);
        abort_if($assignment->due_at && now()->gt(Carbon::parse($assignment->due_at)), 422, 'The submission deadline has passed.');
        $data = $request->validate(['answer' => 'required|string|max:100000', 'attachment' => 'nullable|file|mimes:pdf,txt,doc,docx,zip,png,jpg,jpeg|max:20480']);
        DB::transaction(function () use ($request, $assignment, $data) {
            $assignment = DB::table('learning_assignments')->where('id', $assignment->id)->lockForUpdate()->first();
            DB::table('learning_enrollments')->where('course_id', $assignment->course_id)->where('user_id', $request->user()->id)->lockForUpdate()->first();
            $this->access($request, $assignment->course_id);
            abort_unless($assignment->published, 404);
            abort_if($assignment->due_at && now()->gt(Carbon::parse($assignment->due_at)), 422, 'The submission deadline has passed.');
            $existing = DB::table('learning_submissions')->where('assignment_id', $assignment->id)->where('user_id', $request->user()->id)->first();
            abort_if($existing && $existing->graded_at, 422, 'This work is already graded.');
            $values = ['answer' => $data['answer'], 'submitted_at' => now(), 'updated_at' => now()];
            if ($request->hasFile('attachment')) {
                $values['file_path'] = $request->file('attachment')->store('learning/submissions', 'local');
                $values['file_name'] = $request->file('attachment')->getClientOriginalName();
            }
            if ($existing) {
                DB::table('learning_submissions')->where('id', $existing->id)->update($values);
            } else {
                DB::table('learning_submissions')->insert($values + ['assignment_id' => $assignment->id, 'user_id' => $request->user()->id, 'created_at' => now()]);
            }
        });

        return back()->with('success', 'Assignment submitted for review.');
    }

    public function startQuiz(Request $request, int $quiz)
    {
        $quiz = $this->find('quizzes', $quiz);
        $this->access($request, $quiz->course_id);
        abort_unless($quiz->published, 404);
        abort_if($quiz->opens_at && now()->lt(Carbon::parse($quiz->opens_at)), 422, 'This quiz has not opened yet.');
        abort_if($quiz->closes_at && now()->gte(Carbon::parse($quiz->closes_at)), 422, 'This quiz has closed.');
        $attemptId = DB::transaction(function () use ($request, $quiz) {
            $quiz = DB::table('learning_quizzes')->where('id', $quiz->id)->lockForUpdate()->first();
            DB::table('learning_enrollments')->where('course_id', $quiz->course_id)->where('user_id', $request->user()->id)->lockForUpdate()->first();
            $this->access($request, $quiz->course_id);
            abort_unless($quiz->published, 404);
            abort_if($quiz->opens_at && now()->lt(Carbon::parse($quiz->opens_at)), 422, 'This quiz has not opened yet.');
            abort_if($quiz->closes_at && now()->gte(Carbon::parse($quiz->closes_at)), 422, 'This quiz has closed.');
            $attempts = DB::table('learning_attempts')->where('quiz_id', $quiz->id)->where('user_id', $request->user()->id)->get();
            $open = $attempts->first(fn ($a) => ! $a->submitted_at);
            if ($open) {
                return $open->id;
            }
            abort_if($attempts->count() >= $quiz->max_attempts, 422, 'You have used all attempts.');
            $questions = DB::table('learning_questions')->where('quiz_id', $quiz->id)->orderBy('id')->get();
            abort_if($questions->isEmpty(), 422, 'No questions are available.');
            $expires = now()->addMinutes($quiz->duration_minutes);
            if ($quiz->closes_at && $expires->gt(Carbon::parse($quiz->closes_at))) {
                $expires = Carbon::parse($quiz->closes_at);
            }

            return DB::table('learning_attempts')->insertGetId([
                'quiz_id' => $quiz->id, 'user_id' => $request->user()->id, 'questions' => $questions->toJson(),
                'started_at' => now(), 'expires_at' => $expires, 'total_points' => $questions->sum('points'), 'created_at' => now(), 'updated_at' => now(),
            ]);
        });

        return redirect()->route('learning.attempt', $attemptId);
    }

    public function attempt(Request $request, int $attempt)
    {
        $attempt = $this->find('attempts', $attempt);
        abort_unless($attempt->user_id === $request->user()->id, 403);
        $quiz = $this->find('quizzes', $attempt->quiz_id);
        $this->access($request, $quiz->course_id);
        if (! $attempt->submitted_at && now()->gte(Carbon::parse($attempt->expires_at))) {
            app(QuizGrader::class)->finish($attempt->id);

            return redirect()->route('learning.attempt', $attempt->id)->with('success', 'Time expired. The attempt has closed.');
        }
        $questions = collect(json_decode($attempt->questions, true))->map(fn ($q) => collect($q)->except(['correct_option'])->all());
        $answers = json_decode($attempt->answers ?? '{}', true);

        return view('learning.attempt', compact('attempt', 'quiz', 'questions', 'answers'));
    }

    public function submitQuiz(Request $request, int $attempt)
    {
        $attempt = $this->find('attempts', $attempt);
        abort_unless($attempt->user_id === $request->user()->id, 403);
        $quiz = $this->find('quizzes', $attempt->quiz_id);
        $this->access($request, $quiz->course_id);
        $data = $request->validate(['answers' => 'sometimes|array', 'answers.*' => 'nullable|in:A,B,C,D']);
        app(QuizGrader::class)->finish($attempt->id, $data['answers'] ?? []);

        return redirect()->route('learning.attempt', $attempt->id)->with('success', 'Your quiz has been graded.');
    }

    public function saveAnswers(Request $request, int $attempt)
    {
        $row = $this->find('attempts', $attempt);
        abort_unless($row->user_id === $request->user()->id, 403);
        $this->access($request, $this->find('quizzes', $row->quiz_id)->course_id);
        $data = $request->validate(['answers' => 'sometimes|array', 'answers.*' => 'nullable|in:A,B,C,D']);
        DB::transaction(function () use ($attempt, $data) {
            $row = DB::table('learning_attempts')->where('id', $attempt)->lockForUpdate()->first();
            abort_if($row->submitted_at || now()->gte(Carbon::parse($row->expires_at)), 409, 'This attempt has ended.');
            $questions = collect(json_decode($row->questions, true));
            $answers = array_intersect_key($data['answers'] ?? [], $questions->keyBy('id')->all());
            DB::table('learning_attempts')->where('id', $attempt)->update(['answers' => json_encode($answers), 'updated_at' => now()]);
        });

        return response()->json(['saved' => true]);
    }

    public function material(Request $request, int $lesson)
    {
        $lesson = $this->find('lessons', $lesson);
        if ($request->user()->role !== 'admin') {
            $this->access($request, $lesson->course_id);
            abort_unless($lesson->published, 404);
        }
        abort_unless($lesson->file_path && Storage::disk('local')->exists($lesson->file_path), 404);

        return Storage::disk('local')->download($lesson->file_path, $lesson->file_name, ['X-Content-Type-Options' => 'nosniff']);
    }

    public function attachment(Request $request, int $submission)
    {
        $submission = $this->find('submissions', $submission);
        if ($request->user()->role !== 'admin') {
            abort_unless($submission->user_id === $request->user()->id, 403);
            $this->access($request, $this->find('assignments', $submission->assignment_id)->course_id);
        }
        abort_unless($submission->file_path && Storage::disk('local')->exists($submission->file_path), 404);

        return Storage::disk('local')->download($submission->file_path, $submission->file_name, ['X-Content-Type-Options' => 'nosniff']);
    }

    public function certificate(Request $request, int $course, LearningProgress $progress)
    {
        $course = $this->access($request, $course);
        app(QuizGrader::class)->expire($request->user()->id);
        abort_unless($progress->forStudent($course->id, $request->user()->id)['eligible'], 403, 'Complete all lessons and pass all assignments and quizzes first.');
        DB::table('learning_certificates')->insertOrIgnore(['course_id' => $course->id, 'user_id' => $request->user()->id, 'credential' => (string) Str::uuid(), 'issued_at' => now(), 'created_at' => now(), 'updated_at' => now()]);
        $certificate = DB::table('learning_certificates')->where('course_id', $course->id)->where('user_id', $request->user()->id)->first();

        return view('learning.certificate', compact('course', 'certificate'));
    }

    private function find(string $table, int $id)
    {
        $row = DB::table('learning_'.$table)->find($id);
        abort_unless($row, 404);

        return $row;
    }

    private function publishedCourse(int $id)
    {
        $course = $this->find('courses', $id);
        abort_unless($course->status === 'published', 404);

        return $course;
    }

    private function access(Request $request, int $id)
    {
        $course = $this->publishedCourse($id);
        abort_unless(DB::table('learning_enrollments')->where('course_id', $id)->where('user_id', $request->user()->id)->where('status', 'active')->exists(), 403, 'An active course enrollment is required.');

        return $course;
    }
}
