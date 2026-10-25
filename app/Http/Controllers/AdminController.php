<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard with all 13 modules.
     */
    public function index(Request $request)
    {
        $students = DB::table('campus_students')->orderBy('id', 'desc')->get()->map(function ($st) {
            $enrolled = DB::table('campus_course_carts')
                ->where('student_id', $st->student_id)
                ->where('status', 'Enrolled')
                ->get();
            $st->enrolled_classes = $enrolled;
            $st->is_enrolled = $enrolled->count() > 0;
            return $st;
        });

        // Students Manage displays unassigned/pending students who registered and need class enrollment
        $pendingStudents = $students->filter(fn($st) => !$st->is_enrolled);
        $enrolledStudents = $students->filter(fn($st) => $st->is_enrolled);

        $classes = DB::table('campus_classes')->orderBy('id', 'asc')->get()->map(function ($cl) {
            $cl->enrolled_count = DB::table('campus_course_carts')
                ->where('course_code', $cl->code)
                ->where('status', 'Enrolled')
                ->count();
            return $cl;
        });
        $attendances = DB::table('campus_attendances')->orderBy('id', 'desc')->get();
        $exams = DB::table('campus_exams')->orderBy('id', 'asc')->get();
        $examQuestions = DB::table('campus_exam_questions')->orderBy('id', 'asc')->get();
        $challenges = DB::table('campus_challenges')->orderBy('id', 'desc')->get();
        $totalCertificatesCount = DB::table('campus_certificates')->count();
        $certificates = DB::table('campus_certificates')->orderBy('id', 'desc')->take(100)->get();
        $resources = DB::table('campus_resources')->orderBy('id', 'desc')->get();
        $collaborations = DB::table('campus_collaborations')->orderBy('id', 'desc')->get();
        $qrCodes = DB::table('campus_qr_codes')->orderBy('id', 'desc')->get();
        $teachingSlides = DB::table('campus_teaching_slides')->first();
        $screenBroadcast = DB::table('campus_screen_broadcasts')->first();
        $screenSpotlights = DB::table('campus_screen_spotlights')->orderBy('display_order', 'asc')->get();
        $books = DB::table('campus_books')->orderBy('id', 'desc')->get();
        $posts = DB::table('campus_posts')->orderBy('id', 'desc')->get();

        // Analytics / Reports stats
        $stats = [
            'total_students' => $students->count(),
            'active_students' => $students->where('status', 'Active')->count(),
            'total_classes' => $classes->count(),
            'ongoing_classes' => $classes->where('status', 'Ongoing')->count(),
            'overall_attendance' => '88.7%',
            'active_challenges' => $challenges->where('status', 'Active')->count(),
            'issued_certificates' => $totalCertificatesCount,
            'total_downloads' => $resources->sum('download_count'),
            'spotlight_count' => $screenSpotlights->count(),
        ];

        return view('admin.index', compact(
            'students',
            'pendingStudents',
            'enrolledStudents',
            'classes',
            'attendances',
            'exams',
            'examQuestions',
            'challenges',
            'certificates',
            'resources',
            'collaborations',
            'qrCodes',
            'teachingSlides',
            'screenBroadcast',
            'screenSpotlights',
            'stats',
            'books',
            'posts'
        ));
    }

    // =========================================================================
    // 1. MANAGE USERS
    // =========================================================================
    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'student_id' => 'required|string|max:100|unique:campus_students,student_id',
            'email' => 'required|email|max:191|unique:campus_students,email',
            'major' => 'required|string|max:191',
            'gender' => 'required|string|max:50',
            'class_id' => 'nullable|integer',
        ]);

        $studentId = DB::table('campus_students')->insertGetId([
            'name' => $request->name,
            'student_id' => $request->student_id,
            'email' => $request->email,
            'major' => $request->major,
            'gender' => $request->gender,
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250',
            'status' => 'Active',
            'attendance_rate' => '100%',
            'valid_until' => '08/2028',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // If class specified upon creation, enroll immediately
        if ($request->filled('class_id')) {
            $class = DB::table('campus_classes')->where('id', $request->class_id)->first();
            if ($class) {
                DB::table('campus_course_carts')->insert([
                    'student_id' => $request->student_id,
                    'course_code' => $class->code,
                    'course_title' => $class->title,
                    'credits' => 3,
                    'instructor' => $class->prof,
                    'schedule' => $class->schedule_time,
                    'status' => 'Enrolled',
                    'fee' => 'Paid',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.index', ['tab' => 'users'])->with('success', 'Student created successfully!');
    }

    public function toggleStudentStatus($id)
    {
        $student = DB::table('campus_students')->where('id', $id)->first();
        if ($student) {
            $newStatus = $student->status === 'Active' ? 'Inactive' : 'Active';
            DB::table('campus_students')->where('id', $id)->update([
                'status' => $newStatus,
                'updated_at' => now(),
            ]);
        }
        return redirect()->route('admin.index', ['tab' => 'users'])->with('success', 'Student status updated!');
    }

    public function deleteStudent($id)
    {
        DB::table('campus_students')->where('id', $id)->delete();
        return redirect()->route('admin.index', ['tab' => 'users'])->with('success', 'Student removed.');
    }

    public function assignStudentToClass(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string',
            'class_id' => 'required|integer',
        ]);

        $class = DB::table('campus_classes')->where('id', $request->class_id)->first();
        $student = DB::table('campus_students')->where('student_id', $request->student_id)->first();

        if ($class && $student) {
            DB::table('campus_course_carts')->updateOrInsert(
                [
                    'student_id' => $student->student_id,
                    'course_code' => $class->code,
                ],
                [
                    'course_title' => $class->title,
                    'credits' => 3,
                    'instructor' => $class->prof,
                    'schedule' => $class->schedule_time,
                    'status' => 'Enrolled',
                    'fee' => 'Paid',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            // Also ensure an attendance log exists for this student in this class
            $exists = DB::table('campus_attendances')
                ->where('student_id', $student->student_id)
                ->where('code', $class->code)
                ->exists();

            if (!$exists) {
                DB::table('campus_attendances')->insert([
                    'student_name' => $student->name,
                    'student_id' => $student->student_id,
                    'subject' => $class->title,
                    'code' => $class->code,
                    'session_name' => 'Enrolled',
                    'session_date' => null,
                    'status' => 'Present',
                    'check_in_time' => 'Enrolled',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return redirect()->route('admin.index', ['tab' => 'users'])->with('success', "សិស្ស {$student->name} ត្រូវបានបញ្ចូលទៅក្នុងថ្នាក់ {$class->title} ({$class->code}) ដោយជោគជ័យ! សិស្សនេះត្រូវបានផ្លាស់ទៅកាន់ Class Manage។");
        }

        return redirect()->route('admin.index', ['tab' => 'users'])->with('error', 'Class or student not found.');
    }

    public function batchAssignStudentsToClass(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'string',
            'class_id' => 'required|integer',
        ]);

        $class = DB::table('campus_classes')->where('id', $request->class_id)->first();
        if (!$class) {
            return redirect()->route('admin.index', ['tab' => 'users'])->with('error', 'រកមិនឃើញថ្នាក់រៀនដែលបានជ្រើសរើសឡើយ (Class not found).');
        }

        $count = 0;
        foreach ($request->student_ids as $stId) {
            $student = DB::table('campus_students')->where('student_id', $stId)->first();
            if ($student) {
                DB::table('campus_course_carts')->updateOrInsert(
                    [
                        'student_id' => $student->student_id,
                        'course_code' => $class->code,
                    ],
                    [
                        'course_title' => $class->title,
                        'credits' => 3,
                        'instructor' => $class->prof,
                        'schedule' => $class->schedule_time,
                        'status' => 'Enrolled',
                        'fee' => 'Paid',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );

                $exists = DB::table('campus_attendances')
                    ->where('student_id', $student->student_id)
                    ->where('code', $class->code)
                    ->exists();

                if (!$exists) {
                    DB::table('campus_attendances')->insert([
                        'student_name' => $student->name,
                        'student_id' => $student->student_id,
                        'subject' => $class->title,
                        'code' => $class->code,
                        'session_name' => 'Enrolled',
                        'session_date' => null,
                        'status' => 'Present',
                        'check_in_time' => 'Enrolled',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $count++;
            }
        }

        return redirect()->route('admin.index', ['tab' => 'users'])->with('success', "បាន Enroll សិស្សចំនួន {$count} នាក់ ទៅកាន់ថ្នាក់ {$class->title} ({$class->code}) ដោយជោគជ័យ! សិស្សទាំងនេះត្រូវបានបញ្ជូនទៅកាន់ Class Manage។");
    }

    public function unassignStudentFromClass(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string',
            'course_code' => 'required|string',
        ]);

        DB::table('campus_course_carts')
            ->where('student_id', $request->student_id)
            ->where('course_code', $request->course_code)
            ->delete();

        return redirect()->route('admin.index', ['tab' => 'classes'])->with('success', 'បានដកសិស្សចេញពីថ្នាក់ដោយជោគជ័យ! សិស្សនេះបានត្រឡប់មកកាន់ Students Manage វិញ។');
    }

    // =========================================================================
    // 2. SHOW USERS ON SCREEN (FULLSCREEN 4-USER ROTATION)
    // =========================================================================
    public function screenFullscreen()
    {
        $spotlights = DB::table('campus_screen_spotlights')->orderBy('display_order', 'asc')->get();
        $broadcast = DB::table('campus_screen_broadcasts')->first();
        return view('admin.screen_fullscreen', compact('spotlights', 'broadcast'));
    }

    public function getSpotlightsData()
    {
        $spotlights = DB::table('campus_screen_spotlights')->orderBy('display_order', 'asc')->get();
        return response()->json([
            'success' => true,
            'count' => $spotlights->count(),
            'users' => $spotlights,
        ]);
    }

    public function addSpotlightUser(Request $request)
    {
        $studentId = $request->input('student_id');
        $student = DB::table('campus_students')->where('student_id', $studentId)->first();

        if (!$student && $request->filled('id')) {
            $student = DB::table('campus_students')->where('id', $request->input('id'))->first();
        }

        if ($student) {
            $maxOrder = DB::table('campus_screen_spotlights')->max('display_order') ?: 0;
            DB::table('campus_screen_spotlights')->updateOrInsert(
                ['student_id' => $student->student_id],
                [
                    'student_name' => $student->name,
                    'room' => $request->input('room', 'Lab 402 • Media Wing'),
                    'avatar' => $student->avatar,
                    'major' => $student->major,
                    'preview_title' => $request->input('preview_title', 'Live Project Prototype Showcase'),
                    'display_order' => $maxOrder + 1,
                    'is_active' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            // Also update screen broadcast
            DB::table('campus_screen_broadcasts')->updateOrInsert(
                ['id' => 1],
                [
                    'student_name' => $student->name,
                    'student_id' => $student->student_id,
                    'room' => $request->input('room', 'Lab 402 • Media Wing'),
                    'is_broadcasting' => true,
                    'preview_title' => $request->input('preview_title', 'Live Project Prototype Showcase'),
                    'updated_at' => now(),
                ]
            );

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => "User {$student->name} added to Fullscreen Spotlight!"]);
            }
            return redirect()->route('admin.index', ['tab' => 'screen'])->with('success', "{$student->name} បានដាក់បង្ហាញលើ Full Screen!");
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Student not found.'], 404);
        }
        return redirect()->route('admin.index', ['tab' => 'screen'])->with('error', 'Student not found.');
    }

    public function removeSpotlightUser(Request $request)
    {
        $id = $request->input('id');
        DB::table('campus_screen_spotlights')->where('id', $id)->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.index', ['tab' => 'screen'])->with('success', 'User removed from spotlight.');
    }

    public function clearSpotlights()
    {
        DB::table('campus_screen_spotlights')->truncate();
        return redirect()->route('admin.index', ['tab' => 'screen'])->with('success', 'Screen spotlight queue cleared.');
    }

    public function toggleScreenBroadcast(Request $request)
    {
        $studentName = $request->input('student_name', 'Maya Chen');
        $studentId = $request->input('student_id', 'GZ20260482');
        $status = $request->boolean('is_broadcasting');
        $room = $request->input('room', 'Lab 402 • Media Wing');
        $title = $request->input('preview_title', 'Live Project Prototype');

        DB::table('campus_screen_broadcasts')->updateOrInsert(
            ['id' => 1],
            [
                'student_name' => $studentName,
                'student_id' => $studentId,
                'room' => $room,
                'is_broadcasting' => $status,
                'preview_title' => $title,
                'updated_at' => now(),
            ]
        );

        return response()->json(['success' => true, 'is_broadcasting' => $status, 'student_name' => $studentName]);
    }

    // =========================================================================
    // 3. REPORT
    // =========================================================================
    public function exportReports(Request $request)
    {
        $classCode = $request->input('class_code');
        $query = DB::table('campus_students');

        if ($classCode) {
            $enrolledStudentIds = DB::table('campus_course_carts')
                ->where('course_code', $classCode)
                ->where('status', 'Enrolled')
                ->pluck('student_id');
            $query->whereIn('student_id', $enrolledStudentIds);
        }

        $students = $query->get();
        $filename = 'genz_teaching_report_' . ($classCode ?: 'all') . '_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($students, $classCode) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($handle, ['Student ID', 'Full Name', 'Email', 'Major', 'Status', 'Attendance Rate', 'Enrolled Courses']);

            foreach ($students as $st) {
                $enrolled = DB::table('campus_course_carts')
                    ->where('student_id', $st->student_id)
                    ->where('status', 'Enrolled')
                    ->pluck('course_code')
                    ->join(', ');

                fputcsv($handle, [
                    $st->student_id,
                    $st->name,
                    $st->email,
                    $st->major,
                    $st->status,
                    $st->attendance_rate,
                    $enrolled ?: 'None',
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // =========================================================================
    // 4. EXAM & QCM MANAGEMENT
    // =========================================================================
    public function storeExam(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'exam_date' => 'required|string|max:100',
            'room' => 'required|string|max:100',
            'category' => 'required|string|in:Lesson Exam,Midterm exam,Final exam,Test exam,Dig4.0 exam',
            'duration_minutes' => 'nullable|integer',
            'total_points' => 'nullable|integer',
        ]);

        $examId = DB::table('campus_exams')->insertGetId([
            'title' => $request->title,
            'course' => $request->course,
            'class_code' => $request->input('class_code', $request->course),
            'exam_date' => $request->exam_date,
            'room' => $request->room,
            'type' => $request->category,
            'category' => $request->category,
            'duration_minutes' => $request->input('duration_minutes', 45),
            'total_points' => $request->input('total_points', 100),
            'status' => 'Scheduled',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.index', ['tab' => 'exams'])->with('success', "Exam {$request->title} ({$request->category}) scheduled successfully!");
    }

    public function deleteExam($id)
    {
        DB::table('campus_exam_questions')->where('exam_id', $id)->delete();
        DB::table('campus_exams')->where('id', $id)->delete();
        return redirect()->route('admin.index', ['tab' => 'exams'])->with('success', 'Exam removed.');
    }

    public function toggleExamStatus($id)
    {
        $exam = DB::table('campus_exams')->where('id', $id)->first();
        if ($exam) {
            $newStatus = ($exam->status === 'Active') ? 'Scheduled' : 'Active';
            DB::table('campus_exams')->where('id', $id)->update([
                'status' => $newStatus,
                'updated_at' => now(),
            ]);
            return redirect()->route('admin.index', ['tab' => 'exams'])->with('success', "Exam {$exam->title} status updated to {$newStatus}!");
        }
        return redirect()->route('admin.index', ['tab' => 'exams'])->with('error', 'Exam not found.');
    }

    public function storeExamQuestion(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|integer',
            'question_text' => 'required|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_option' => 'required|string|in:A,B,C,D',
            'points' => 'required|integer|min:1',
        ]);

        DB::table('campus_exam_questions')->insert([
            'exam_id' => $request->exam_id,
            'question_text' => $request->question_text,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_option' => $request->correct_option,
            'points' => $request->points,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.index', ['tab' => 'exams'])->with('success', 'សំណួរ QCM ត្រូវបានបញ្ចូលដោយជោគជ័យ!');
    }

    public function deleteExamQuestion($id)
    {
        DB::table('campus_exam_questions')->where('id', $id)->delete();
        return redirect()->route('admin.index', ['tab' => 'exams'])->with('success', 'សំណួរត្រូវបានលុបចេញ។');
    }

    // =========================================================================
    // 5. CHALLENGE & FULLSCREEN LEADERBOARD
    // =========================================================================
    public function storeChallenge(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'points' => 'required|integer',
            'duration_minutes' => 'nullable|integer',
            'deadline' => 'required|string|max:100',
        ]);

        $options = null;
        if ($request->filled('option_a')) {
            $options = json_encode([
                'A' => $request->input('option_a'),
                'B' => $request->input('option_b'),
                'C' => $request->input('option_c'),
                'D' => $request->input('option_d'),
            ]);
        }

        DB::table('campus_challenges')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'question_text' => $request->input('question_text', $request->description),
            'options_json' => $options,
            'correct_answer' => $request->input('correct_answer', 'A'),
            'points' => $request->points,
            'duration_minutes' => $request->input('duration_minutes', 15),
            'deadline' => $request->deadline,
            'badge' => $request->input('badge', 'NEW'),
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.index', ['tab' => 'challenges'])->with('success', 'New challenge published with real-time leaderboard!');
    }

    public function toggleChallengeStatus($id)
    {
        $ch = DB::table('campus_challenges')->where('id', $id)->first();
        if ($ch) {
            $newStatus = $ch->status === 'Active' ? 'Closed' : 'Active';
            DB::table('campus_challenges')->where('id', $id)->update(['status' => $newStatus, 'updated_at' => now()]);
        }
        return redirect()->route('admin.index', ['tab' => 'challenges'])->with('success', 'Challenge status updated.');
    }

    public function challengeFullscreen($id = null)
    {
        $challenge = null;
        if ($id) {
            $challenge = DB::table('campus_challenges')->where('id', $id)->first();
        }
        if (!$challenge) {
            $challenge = DB::table('campus_challenges')->where('status', 'Active')->first()
                ?: DB::table('campus_challenges')->first();
        }

        $participants = collect();
        if ($challenge) {
            $participants = DB::table('campus_challenge_participants')
                ->where('challenge_id', $challenge->id)
                ->orderBy('score', 'desc')
                ->orderBy('completion_time', 'asc')
                ->get();
        }

        return view('admin.challenge_fullscreen', compact('challenge', 'participants'));
    }

    // =========================================================================
    // 6. CERTIFICATE & BATCH GENERATE
    // =========================================================================
    public function storeCertificate(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'recipient' => 'required|string|max:191',
            'issue_date' => 'required|string|max:100',
        ]);

        $credentialId = 'GZ-' . strtoupper(substr(uniqid(), -6));

        DB::table('campus_certificates')->insert([
            'title' => $request->title,
            'recipient' => $request->recipient,
            'issue_date' => $request->issue_date,
            'credential_id' => $credentialId,
            'status' => 'Verified',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.index', ['tab' => 'certificates'])->with('success', 'Certificate issued!');
    }

    public function batchGenerateCertificates(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'class_code' => 'required|string',
            'cert_type' => 'required|string',
        ]);

        $query = DB::table('campus_students');
        if ($request->class_code !== 'ALL') {
            $studentIds = DB::table('campus_course_carts')
                ->where('course_code', $request->class_code)
                ->where('status', 'Enrolled')
                ->pluck('student_id');
            $query->whereIn('student_id', $studentIds);
        }

        $students = $query->get();
        $count = 0;
        $issueDate = $request->input('issue_date', date('M d, Y'));

        foreach ($students as $st) {
            $credentialId = 'GZ-' . strtoupper(substr(md5(uniqid($st->student_id, true)), 0, 8));
            DB::table('campus_certificates')->insert([
                'title' => $request->title . ' (' . $request->cert_type . ')',
                'recipient' => $st->name,
                'issue_date' => $issueDate,
                'credential_id' => $credentialId,
                'status' => 'Verified',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $count++;
        }

        return redirect()->route('admin.index', ['tab' => 'certificates'])->with('success', "វិញ្ញាបនបត្រចំនួន {$count} ត្រូវបានបង្កើតស្វ័យប្រវត្តិ (Batch Auto Generated)!");
    }

    // =========================================================================
    // 7. SHOW SLIDE TEACHING & CAMERA GESTURE FULLSCREEN
    // =========================================================================
    public function slidesFullscreen()
    {
        $teachingSlides = DB::table('campus_teaching_slides')->first();
        return view('admin.slides_fullscreen', compact('teachingSlides'));
    }

    public function uploadSlideFile(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'slide_file' => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,png,jpg,jpeg,webp|max:51200',
        ]);

        $filePath = null;
        $fileType = 'pdf';

        if ($request->hasFile('slide_file')) {
            $file = $request->file('slide_file');
            $ext = strtolower($file->getClientOriginalExtension());
            $filename = 'slides_' . time() . '.' . $ext;
            if (!file_exists(public_path('uploads/slides'))) {
                mkdir(public_path('uploads/slides'), 0777, true);
            }
            $file->move(public_path('uploads/slides'), $filename);
            $filePath = '/uploads/slides/' . $filename;
            
            if (in_array($ext, ['png', 'jpg', 'jpeg', 'webp'])) {
                $fileType = 'image';
            } elseif (in_array($ext, ['ppt', 'pptx'])) {
                $fileType = 'presentation';
            } elseif (in_array($ext, ['doc', 'docx'])) {
                $fileType = 'word';
            } else {
                $fileType = 'pdf';
            }
        }

        $existing = DB::table('campus_teaching_slides')->where('id', 1)->first();
        $finalPath = $filePath ?: ($existing ? $existing->file_path : '/uploads/slides/slides_1792829007.pdf');
        $finalType = $request->hasFile('slide_file') ? $fileType : ($existing ? $existing->file_type : 'pdf');

        DB::table('campus_teaching_slides')->updateOrInsert(
            ['id' => 1],
            [
                'title' => $request->title,
                'course' => $request->course,
                'file_path' => $finalPath,
                'file_type' => $finalType,
                'gesture_enabled' => true,
                'current_slide' => 1,
                'total_slides' => 6,
                'slide_notes' => 'Presentation file updated with AI Hand Gesture Tracking.',
                'updated_at' => now(),
            ]
        );

        return redirect()->route('admin.index', ['tab' => 'slides'])->with('success', 'Slide deck uploaded successfully! Ready for AI Gesture Presentation.');
    }

    public function updateSlide(Request $request)
    {
        $slideIndex = $request->input('current_slide', 1);
        DB::table('campus_teaching_slides')->where('id', 1)->update([
            'current_slide' => $slideIndex,
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'current_slide' => $slideIndex]);
    }

    // =========================================================================
    // 8. COLLABORATION
    // =========================================================================
    public function storeCollaboration(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'required_role' => 'required|string|max:100',
            'max_members' => 'required|integer|min:2',
        ]);

        DB::table('campus_collaborations')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'required_role' => $request->required_role,
            'current_members' => $request->input('current_members', 1),
            'max_members' => $request->max_members,
            'status' => 'Open',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Also create a real-time group QCM exercise session
        DB::table('campus_collaboration_sessions')->insert([
            'title' => $request->title,
            'class_code' => $request->input('class_code', 'DES302'),
            'exercise_prompt' => $request->input('exercise_prompt', $request->description ?: 'Group QCM problem solving sprint.'),
            'option_a' => $request->input('option_a', 'Solution Approach A'),
            'option_b' => $request->input('option_b', 'Solution Approach B'),
            'option_c' => $request->input('option_c', 'Solution Approach C'),
            'option_d' => $request->input('option_d', 'Solution Approach D'),
            'correct_option' => $request->input('correct_option', 'B'),
            'status' => 'Open',
            'active_users' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.index', ['tab' => 'collab'])->with('success', 'Collaboration project & live QCM room created!');
    }

    // =========================================================================
    // 10. ATTENDANCE & EXPORT
    // =========================================================================
    public function updateAttendanceStatus(Request $request, $id)
    {
        $status = $request->input('status', 'Present');
        DB::table('campus_attendances')->where('id', $id)->update([
            'status' => $status,
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'id' => $id, 'status' => $status]);
    }

    public function exportAttendance(Request $request)
    {
        $format = $request->input('format', 'excel');
        $classCode = $request->input('class_code');

        $query = DB::table('campus_attendances');
        if ($classCode) {
            $query->where('code', $classCode);
        }
        $attendances = $query->orderBy('id', 'desc')->get();

        if ($format === 'pdf') {
            return view('admin.attendance_pdf', [
                'attendances' => $attendances,
                'classCode' => $classCode ?: 'All Classes',
                'date' => date('d F Y'),
            ]);
        }

        // Default: Excel / CSV
        $filename = 'attendance_' . ($classCode ?: 'all') . '_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($attendances) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($handle, ['Student Name', 'Student ID', 'Subject', 'Class Code', 'Status', 'Check-in Time', 'Record Date']);

            foreach ($attendances as $att) {
                fputcsv($handle, [
                    $att->student_name,
                    $att->student_id,
                    $att->subject,
                    $att->code,
                    $att->status,
                    $att->check_in_time,
                    $att->created_at,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // =========================================================================
    // 11. QR CODE MANAGE & SHORT PASSCODE
    // =========================================================================
    public function storeQrCode(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'type' => 'required|string|max:50',
            'class_code' => 'nullable|string|max:50',
            'session_name' => 'nullable|string|max:50',
            'session_date' => 'nullable|string|max:50',
            'expires_at' => 'required|string|max:100',
        ]);

        $shortCode = str_pad((string)rand(1000, 9999), 4, '0', STR_PAD_LEFT);
        $codeValue = 'GZ-QR-' . strtoupper($request->type) . '-' . ($request->class_code ?: 'CAMPUS') . '-' . rand(1000, 9999);

        DB::table('campus_qr_codes')->insert([
            'title' => $request->title,
            'type' => $request->type,
            'class_code' => $request->class_code,
            'session_name' => $request->input('session_name', 'Session 1 (ព្រឹក)'),
            'session_date' => $request->input('session_date', date('Y-m-d')),
            'code_value' => $codeValue,
            'short_code' => $shortCode,
            'expires_at' => $request->expires_at,
            'scans_count' => 0,
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.index', ['tab' => 'qr'])->with('success', "QR Code & លេខកូដខ្លី [{$shortCode}] សម្រាប់ {$request->input('session_name', 'Session 1 (ព្រឹក)')} ត្រូវបានបង្កើតដោយជោគជ័យ!");
    }

    public function activateQrCode($id)
    {
        DB::table('campus_qr_codes')->update(['status' => 'Standby', 'updated_at' => now()]);
        DB::table('campus_qr_codes')->where('id', $id)->update(['status' => 'Active', 'updated_at' => now()]);

        return response()->json(['success' => true, 'message' => 'QR Code activated for classroom projection!']);
    }

    // =========================================================================
    // 12. RESOURCE & PDF ONLINE VIEWER
    // =========================================================================
    public function storeResource(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'class_code' => 'nullable|string|max:50',
            'pdf_file' => 'nullable|file|mimes:pdf|max:30720',
        ]);

        $fileName = $request->input('file_name', 'Lesson_Material.pdf');
        $fileSize = '5.2 MB';
        $fileUrl = '/assets/docs/lesson_sample.pdf';

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $fileName = $file->getClientOriginalName();
            $fileSize = round($file->getSize() / 1048576, 1) . ' MB';
            $uniqueName = 'res_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/resources'), $uniqueName);
            $fileUrl = '/uploads/resources/' . $uniqueName;
        }

        DB::table('campus_resources')->insert([
            'title' => $request->title,
            'course' => $request->course,
            'class_code' => $request->input('class_code', $request->course),
            'file_name' => $fileName,
            'file_type' => 'pdf',
            'file_url' => $fileUrl,
            'file_size' => $fileSize,
            'download_count' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.index', ['tab' => 'resources'])->with('success', 'PDF Lesson resource uploaded! Students can view online.');
    }

    public function deleteResource($id)
    {
        DB::table('campus_resources')->where('id', $id)->delete();
        return redirect()->route('admin.index', ['tab' => 'resources'])->with('success', 'Resource deleted.');
    }

    // =========================================================================
    // 13. CLASS MANAGE & 4-TAB DETAIL
    // =========================================================================
    public function storeClass(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'code' => 'required|string|max:50',
            'room' => 'required|string|max:100',
            'prof' => 'required|string|max:191',
            'schedule_time' => 'required|string|max:100',
        ]);

        DB::table('campus_classes')->insert([
            'title' => $request->title,
            'code' => $request->code,
            'room' => $request->room,
            'prof' => $request->prof,
            'schedule_time' => $request->schedule_time,
            'status' => $request->input('status', 'Upcoming'),
            'type' => $request->input('type', 'Lecture & Lab'),
            'border_color' => '#3b82f6',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.index', ['tab' => 'classes'])->with('success', 'Class created successfully!');
    }

    public function toggleClassStatus($id)
    {
        $class = DB::table('campus_classes')->where('id', $id)->first();
        if ($class) {
            $newStatus = $class->status === 'Ongoing' ? 'Upcoming' : 'Ongoing';
            DB::table('campus_classes')->where('id', $id)->update(['status' => $newStatus, 'updated_at' => now()]);
        }
        return redirect()->route('admin.index', ['tab' => 'classes'])->with('success', 'Class status updated.');
    }

    public function deleteClass($id)
    {
        DB::table('campus_classes')->where('id', $id)->delete();
        return redirect()->route('admin.index', ['tab' => 'classes'])->with('success', 'Class deleted.');
    }

    public function getClassDetails($id)
    {
        $class = DB::table('campus_classes')->where('id', $id)->first();
        if (!$class) {
            return response()->json(['error' => 'Class not found'], 404);
        }

        // Tab 1: Students in this class
        $studentIds = DB::table('campus_course_carts')
            ->where('course_code', $class->code)
            ->where('status', 'Enrolled')
            ->pluck('student_id');

        $students = DB::table('campus_students')->whereIn('student_id', $studentIds)->get();

        // Tab 2: Subject details
        $subject = [
            'title' => $class->title,
            'code' => $class->code,
            'prof' => $class->prof,
            'room' => $class->room,
            'schedule' => $class->schedule_time,
            'type' => $class->type,
            'credits' => 3,
            'syllabus' => [
                'Unit 1: Fundamentals & Theory Overview',
                'Unit 2: Practical Studio Laboratory & Hands-on Tools',
                'Unit 3: Mid-Term Project Sprint & Peer Review',
                'Unit 4: Production Deployment & Final Showcase',
            ],
        ];

        // Tab 3: Scores
        $scores = DB::table('campus_scores')
            ->where('code', $class->code)
            ->get();

        // If empty, generate score breakdown based on enrolled students
        if ($scores->isEmpty() && $students->isNotEmpty()) {
            $sampleScores = [94, 88, 92, 85, 78, 96];
            $scores = $students->map(function ($st, $idx) use ($sampleScores, $class) {
                $sc = $sampleScores[$idx % count($sampleScores)];
                return [
                    'student_id' => $st->student_id,
                    'student_name' => $st->name,
                    'course_code' => $class->code,
                    'score' => $sc,
                    'grade' => $sc >= 90 ? 'A' : ($sc >= 80 ? 'B' : 'C'),
                ];
            });
        }

        // Tab 4: Attendance
        $attendances = DB::table('campus_attendances')
            ->where('code', $class->code)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'class' => $class,
            'students' => $students,
            'subject' => $subject,
            'scores' => $scores,
            'attendances' => $attendances,
        ]);
    }

    /**
     * Store new Library Book
     */
    public function storeBook(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:100',
        ]);

        $fileName = 'Book_' . time() . '.pdf';
        if ($request->hasFile('file')) {
            $fileName = $request->file('file')->getClientOriginalName();
        }

        DB::table('campus_books')->insert([
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'category' => $request->input('category'),
            'file_name' => $fileName,
            'file_size' => $request->input('file_size', '15.4 MB'),
            'total_pages' => $request->input('total_pages', 200),
            'description' => $request->input('description', 'Academic learning resource uploaded by faculty.'),
            'cover_image' => $request->input('cover_image', 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&q=80&w=350'),
            'status' => 'Available',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.index', ['tab' => 'library'])->with('success', 'សៀវភៅបណ្ណាល័យត្រូវបាន Upload ជោគជ័យ!');
    }

    /**
     * Delete Library Book
     */
    public function deleteBook($id)
    {
        DB::table('campus_books')->where('id', $id)->delete();
        return redirect()->route('admin.index', ['tab' => 'library'])->with('success', 'សៀវភៅត្រូវបានលុបជោគជ័យ!');
    }

    /**
     * Store new Announcement / Post
     */
    public function storePost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        DB::table('campus_posts')->insert([
            'title' => $request->input('title'),
            'category' => $request->input('category', 'Campus Announcement'),
            'content' => $request->input('content'),
            'author' => $request->input('author', 'Campus Administration'),
            'badge' => $request->input('badge', 'NEW'),
            'is_pinned' => $request->has('is_pinned'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.index', ['tab' => 'news'])->with('success', 'សេចក្តីជូនដំណឹងត្រូវបានផ្សព្វផ្សាយជោគជ័យ!');
    }

    /**
     * Delete Announcement / Post
     */
    public function deletePost($id)
    {
        DB::table('campus_posts')->where('id', $id)->delete();
        return redirect()->route('admin.index', ['tab' => 'news'])->with('success', 'សេចក្តីជូនដំណឹងត្រូវបានលុបជោគជ័យ!');
    }
}
