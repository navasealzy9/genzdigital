<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampusController extends Controller
{
    /**
     * Display the GenZ Digital Campus OS dashboard for students (Client Side).
     * Fully connected with the Admin Portal database.
     */
    public function index()
    {
        // 1. Fetch authenticated user profile or handle guest
        if (\Illuminate\Support\Facades\Auth::check()) {
            $authUser = \Illuminate\Support\Facades\Auth::user();
            $studentRecord = DB::table('campus_students')->where('email', $authUser->email)->first();
            $student = [
                'name' => $authUser->name,
                'id' => $authUser->student_id ?: ($studentRecord ? $studentRecord->student_id : 'GZ' . str_pad($authUser->id, 6, '0', STR_PAD_LEFT)),
                'major' => $authUser->major ?: ($studentRecord ? $studentRecord->major : 'Visual Communication'),
                'gender' => $authUser->gender ?: ($studentRecord ? $studentRecord->gender : 'Female'),
                'status' => $authUser->status ?: 'Active',
                'valid_until' => '08/2028',
                'pass_id' => '#99' . str_pad($authUser->id, 3, '0', STR_PAD_LEFT),
                'overall_attendance' => $studentRecord ? $studentRecord->attendance_rate : '92.4%',
                'avatar' => $authUser->avatar ?: ($studentRecord ? $studentRecord->avatar : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250'),
            ];

            // 2. Check if student is enrolled in any active class
            $enrolledClasses = DB::table('campus_course_carts')
                ->where('student_id', $student['id'])
                ->where('status', 'Enrolled')
                ->get();

            // Admin can preview all features, while students must be enrolled by Admin
            if ($authUser->role === 'admin') {
                $isEnrolled = true;
            } else {
                $isEnrolled = $enrolledClasses->count() > 0;
            }

            if (!$isEnrolled) {
                $student['status'] = 'Pending Enrollment';
            }

            // 3. Fetch live attendance summary from database
            $attendanceList = DB::table('campus_attendances')
                ->where('student_name', $student['name'])
                ->orWhere('student_id', $student['id'])
                ->get()
                ->map(function ($att) {
                    return [
                        'id' => $att->id,
                        'subject' => $att->subject,
                        'code' => $att->code,
                        'rate' => $att->status === 'Present' ? '100%' : ($att->status === 'Late' ? '80%' : '50%'),
                        'status' => $att->status === 'Present' ? 'Good' : $att->status,
                        'last_check' => $att->check_in_time,
                    ];
                })->toArray();

            if (empty($attendanceList) && $isEnrolled) {
                $attendanceList = [
                    ['id' => 1, 'subject' => 'UI/UX Design Systems', 'code' => 'DES302', 'rate' => '92%', 'status' => 'Good', 'last_check' => 'Today, 09:15 AM'],
                    ['id' => 2, 'subject' => 'Motion Graphics & 3D', 'code' => 'DES305', 'rate' => '88%', 'status' => 'Good', 'last_check' => 'Yesterday'],
                    ['id' => 3, 'subject' => 'Design Thinking & Research', 'code' => 'RES201', 'rate' => '100%', 'status' => 'Excellent', 'last_check' => 'Oct 22'],
                    ['id' => 4, 'subject' => 'Brand Identity Strategy', 'code' => 'MKT204', 'rate' => '75%', 'status' => 'Warning', 'last_check' => 'Oct 18'],
                ];
            }

            // Scores and Carts
            $scores = DB::table('campus_scores')->where('student_id', $student['id'])->orderBy('score', 'desc')->get();
            $gpa = '3.88';
            $totalCredits = $scores->sum('credits') ?: ($enrolledClasses->count() * 4 ?: 10);
            $courseCarts = DB::table('campus_course_carts')->where('student_id', $student['id'])->get();
        } else {
            // Guest State: Not logged in
            $student = [
                'name' => 'Guest Student',
                'id' => 'GUEST',
                'major' => 'Digital Campus Studies',
                'gender' => 'N/A',
                'status' => 'Not Logged In',
                'valid_until' => 'N/A',
                'pass_id' => '#GUEST',
                'overall_attendance' => '0%',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250',
            ];
            $enrolledClasses = collect();
            $isEnrolled = false;
            $attendanceList = [];
            $scores = collect();
            $gpa = '0.00';
            $totalCredits = 0;
            $courseCarts = collect();
        }

        // 3. Days for schedule
        $scheduleDays = [
            ['day' => 'Mon', 'date' => 26],
            ['day' => 'Tue', 'date' => 27],
            ['day' => 'Wed', 'date' => 28],
            ['day' => 'Thu', 'date' => 29],
            ['day' => 'Fri', 'date' => 30],
        ];

        // 4. Fetch classes from database
        $scheduleData = DB::table('campus_classes')
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'time' => $c->schedule_time,
                    'title' => $c->title,
                    'code' => $c->code,
                    'room' => $c->room,
                    'prof' => $c->prof,
                    'status' => $c->status,
                    'type' => $c->type,
                    'border_color' => $c->border_color ?? '#3b82f6',
                ];
            })->toArray();

        // 5. Fetch live exams, challenges, resources, certificates, collaborations, books, posts from DB
        $exams = DB::table('campus_exams')->orderBy('id', 'asc')->get();
        $challenges = DB::table('campus_challenges')->where('status', 'Active')->orderBy('id', 'desc')->get();
        $resources = DB::table('campus_resources')->orderBy('id', 'desc')->get();
        $certificates = DB::table('campus_certificates')->where('recipient', $student['name'])->orderBy('id', 'desc')->get();
        $collaborations = DB::table('campus_collaborations')->where('status', 'Open')->orderBy('id', 'desc')->get();
        $screenBroadcast = DB::table('campus_screen_broadcasts')->first();
        $teachingSlides = DB::table('campus_teaching_slides')->first();
        $activeQrCode = DB::table('campus_qr_codes')->where('status', 'Active')->first();
        $books = DB::table('campus_books')->orderBy('id', 'desc')->get();
        $posts = DB::table('campus_posts')->orderBy('is_pinned', 'desc')->orderBy('created_at', 'desc')->get();

        // My Enrolled Classes (for Class Classroom View)
        $myClasses = DB::table('campus_classes')
            ->whereIn('code', $enrolledClasses->pluck('course_code')->toArray())
            ->get();
        if ($myClasses->isEmpty() && $isEnrolled) {
            $myClasses = DB::table('campus_classes')->take(2)->get();
        }

        // 6. Student Scores and Class Cart (Only if logged in)
        if (\Illuminate\Support\Facades\Auth::check()) {
            $scores = DB::table('campus_scores')->where('student_id', $student['id'])->orderBy('score', 'desc')->get();
            $gpa = '3.88';
            $totalCredits = $scores->sum('credits') ?: ($enrolledClasses->count() * 4 ?: 10);
            $courseCarts = DB::table('campus_course_carts')->where('student_id', $student['id'])->get();
        } else {
            $scores = collect();
            $gpa = '0.00';
            $totalCredits = 0;
            $courseCarts = collect();
        }

        // 7. Chats
        $chats = [
            [
                'id' => 1,
                'category' => 'chats',
                'name' => 'Design Team Gamma',
                'role' => 'Group Project • UI/UX',
                'avatar' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=150',
                'last_message' => 'Maya: I just uploaded the Figma prototype link!',
                'time' => '10:42 AM',
                'unread' => 2,
            ],
            [
                'id' => 2,
                'category' => 'academic',
                'name' => 'Dr. Alex Vance',
                'role' => 'Professor • DES302',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=150',
                'last_message' => 'Great job on your mid-term wireframe draft.',
                'time' => 'Yesterday',
                'unread' => 0,
            ],
            [
                'id' => 3,
                'category' => 'announcements',
                'name' => 'Campus Academic Office',
                'role' => 'Official Announcement',
                'avatar' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&q=80&w=150',
                'last_message' => 'Reminder: Registration for Hackathon closes Friday.',
                'time' => 'Oct 24',
                'unread' => 1,
            ]
        ];

        // 8. 12 Tools categorized for filter & search
        $tools = [
            ['modal' => 'classCart', 'icon' => 'school', 'bg' => '#6366f1', 'title' => 'Class', 'desc' => 'ថ្នាក់រៀន & Course Cart', 'badge' => $enrolledClasses->count() . ' Classes', 'category' => 'academic'],
            ['modal' => 'score', 'icon' => 'graduation-cap', 'bg' => '#ec4899', 'title' => 'Score & GPA', 'desc' => 'ពិន្ទុ & Transcript', 'badge' => 'GPA ' . $gpa, 'category' => 'academic'],
            ['modal' => 'resource', 'icon' => 'folder-down', 'bg' => '#2563eb', 'title' => 'Resource', 'desc' => 'PDF Online & Share', 'badge' => $resources->count() . ' Files', 'category' => 'academic'],
            ['modal' => 'scan', 'icon' => 'scan-line', 'bg' => '#10b981', 'title' => 'Scan', 'desc' => 'Camera QR & Passcode', 'badge' => null, 'category' => 'classroom'],
            ['modal' => 'exam', 'icon' => 'file-text', 'bg' => '#4f46e5', 'title' => 'Exam', 'desc' => 'QCM tests & auto-score', 'badge' => $exams->where('status', 'Active')->count() ? 'OPEN' : null, 'category' => 'academic'],
            ['modal' => 'certificates', 'icon' => 'award', 'bg' => '#3b82f6', 'title' => 'Certificate', 'desc' => 'Official Credentials', 'badge' => $certificates->count() ? $certificates->count() . ' Verified' : null, 'category' => 'academic'],
            ['modal' => 'showscreen', 'icon' => 'monitor', 'bg' => '#14b8a6', 'title' => 'Show screen', 'desc' => 'Real-time broadcast', 'badge' => ($screenBroadcast && $screenBroadcast->is_broadcasting ? 'LIVE' : null), 'category' => 'classroom'],
            ['modal' => 'collab', 'icon' => 'users', 'bg' => '#7c3aed', 'title' => 'Collaboration', 'desc' => 'Real-time QCM sprint', 'badge' => $collaborations->count() . ' Teams', 'category' => 'community'],
            ['modal' => 'challenge', 'icon' => 'trophy', 'bg' => '#f59e0b', 'title' => 'Challenge', 'desc' => 'Live arena & score', 'badge' => 'NEW', 'category' => 'community'],
            ['modal' => 'attendance', 'icon' => 'check-circle-2', 'bg' => '#2563eb', 'title' => 'Attendance', 'desc' => 'វត្តមានតាមមុខវិជ្ជា & ម៉ោង', 'badge' => $student['overall_attendance'], 'category' => 'classroom'],
            ['modal' => 'library', 'icon' => 'book-open', 'bg' => '#8b5cf6', 'title' => 'Library', 'desc' => 'E-Books by Admin', 'badge' => $books->count() . ' Books', 'category' => 'academic'],
            ['modal' => 'news', 'icon' => 'newspaper', 'bg' => '#0d9488', 'title' => 'News', 'desc' => 'Admin announcements', 'badge' => $posts->count() . ' Posts', 'category' => 'community'],
        ];

        // 9. Daily 2-Session Attendance Checks & History
        $today = date('Y-m-d');
        $todayAttendance = DB::table('campus_attendances')
            ->where(function ($q) use ($student) {
                $q->where('student_id', $student['id'])
                  ->orWhere('student_name', $student['name']);
            })
            ->where(function ($q) use ($today) {
                $q->where('session_date', $today)
                  ->orWhereDate('created_at', $today);
            })
            ->get();

        $session1Check = $todayAttendance->first(function ($a) {
            return str_contains($a->session_name ?? '', '1') || str_contains($a->check_in_time ?? '', 'Morning');
        });
        $session2Check = $todayAttendance->first(function ($a) {
            return str_contains($a->session_name ?? '', '2') || str_contains($a->check_in_time ?? '', 'Afternoon');
        });

        $myAttendanceHistory = DB::table('campus_attendances')
            ->where('student_id', $student['id'])
            ->orWhere('student_name', $student['name'])
            ->orderBy('id', 'desc')
            ->get();

        return view('campus.index', compact(
            'student',
            'attendanceList',
            'scheduleDays',
            'scheduleData',
            'chats',
            'tools',
            'exams',
            'challenges',
            'resources',
            'certificates',
            'collaborations',
            'screenBroadcast',
            'teachingSlides',
            'activeQrCode',
            'scores',
            'gpa',
            'totalCredits',
            'courseCarts',
            'isEnrolled',
            'enrolledClasses',
            'books',
            'posts',
            'myClasses',
            'session1Check',
            'session2Check',
            'myAttendanceHistory'
        ));
    }

    /**
     * Client Attendance Check-in API (e.g. from Class modal or QR Scan).
     */
    /**
     * Unified Client Attendance Check-in API (Camera QR Scan or Direct Check-in).
     * Rule 1: Student must be enrolled in the target class.
     * Rule 2: 2 Sessions per day (Session 1 ព្រឹក & Session 2 រសៀល).
     */
    public function checkIn(Request $request)
    {
        $studentName = 'Maya Chen';
        $studentId = 'GZ20260482';

        if ($request->filled('student_id')) {
            $studentId = $request->input('student_id');
            $st = DB::table('campus_students')->where('student_id', $studentId)->first();
            if ($st) {
                $studentName = $st->name;
            } elseif ($request->filled('student_name')) {
                $studentName = $request->input('student_name');
            }
        } elseif (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $studentName = $user->name;
            $studentId = $user->student_id ?: 'GZ' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
        }

        $code = trim($request->input('code', 'DES302'));
        $subject = $request->input('subject');

        // Find active matching QR code by code_value, short_code, or class_code
        $qr = DB::table('campus_qr_codes')
            ->where(function ($q) use ($code) {
                $q->where('code_value', $code)
                  ->orWhere('short_code', $code)
                  ->orWhere('class_code', $code);
            })
            ->where('status', 'Active')
            ->first();

        // If no active QR found by code, look for any QR matching class
        if (!$qr && $code) {
            $qr = DB::table('campus_qr_codes')->where('class_code', $code)->first();
        }

        $classCode = $qr ? ($qr->class_code ?: $code) : $code;
        $subjectName = $qr ? $qr->title : ($subject ?: "Classroom Session: {$classCode}");
        $today = date('Y-m-d');

        // RULE 1: Student must be enrolled in this class!
        if ($classCode && $classCode !== 'CAMPUS' && $classCode !== 'ALL') {
            $isEnrolledInClass = DB::table('campus_course_carts')
                ->where('student_id', $studentId)
                ->where('course_code', $classCode)
                ->where('status', 'Enrolled')
                ->exists();

            if (!$isEnrolledInClass) {
                return response()->json([
                    'success' => false,
                    'error_code' => 'NOT_ENROLLED_IN_CLASS',
                    'message' => "⚠️ អ្នកមិនមែនជាសិស្សនៅក្នុងថ្នាក់ [{$classCode}] នេះទេ! មិនអាចស្កេនវត្តមាន ឬបំពេញកូដបានឡើយ។ ទាល់តែសិស្សមានឈ្មោះក្នុងថ្នាក់នេះទើបអាចស្កេនបាន។",
                ], 403);
            }
        }

        // RULE 2: 2 Sessions per day (Session 1 ព្រឹក & Session 2 រសៀល)
        $todayScans = DB::table('campus_attendances')
            ->where('student_id', $studentId)
            ->where('code', $classCode)
            ->where(function ($q) use ($today) {
                $q->where('session_date', $today)
                  ->orWhereDate('created_at', $today);
            })
            ->get();

        // Determine session name: prioritize explicit request session_name, then active QR session_name
        $sessionName = $request->input('session_name') ?: ($qr && $qr->session_name ? $qr->session_name : null);
        if (!$sessionName) {
            $hasSession1 = $todayScans->first(fn($a) => str_contains($a->session_name ?? '', '1'));
            $hasSession2 = $todayScans->first(fn($a) => str_contains($a->session_name ?? '', '2'));

            if (!$hasSession1) {
                $sessionName = 'Session 1 (ព្រឹក)';
            } elseif (!$hasSession2) {
                $sessionName = 'Session 2 (រសៀល)';
            } else {
                $sessionName = 'Session 1 (ព្រឹក)';
            }
        }

        // Check if student already scanned this exact session today
        $alreadyScannedThisSession = $todayScans->first(function ($a) use ($sessionName) {
            return ($a->session_name ?? '') === $sessionName;
        });

        if ($alreadyScannedThisSession && !$request->has('force')) {
            return response()->json([
                'success' => false,
                'error_code' => 'ALREADY_SCANNED_SESSION',
                'message' => "ℹ️ អ្នកបានស្កេនវត្តមានសម្រាប់ {$sessionName} រួចរាល់ហើយក្នុងថ្ងៃនេះ! ក្នុង ១ ថ្ងៃត្រូវស្កេនចំនួន ២ ដង (Session 1 ព្រឹក & Session 2 រសៀល)។",
                'session_name' => $sessionName,
            ], 422);
        }

        // Insert attendance record
        DB::table('campus_attendances')->insert([
            'student_name' => $studentName,
            'student_id' => $studentId,
            'subject' => $subjectName,
            'code' => $classCode,
            'session_name' => $sessionName,
            'session_date' => $today,
            'status' => 'Present',
            'check_in_time' => 'Today, ' . date('h:i A'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($qr) {
            DB::table('campus_qr_codes')->where('id', $qr->id)->increment('scans_count');
        }

        $sessionNumber = str_contains($sessionName, '1') ? '១' : '២';
        return response()->json([
            'success' => true,
            'message' => "🎉 វត្តមានជោគជ័យសម្រាប់ {$sessionName}! អ្នកបានកត់ត្រាវត្តមានលើកទី {$sessionNumber} នៃថ្ងៃនេះ។",
            'session_name' => $sessionName,
            'time' => date('h:i A'),
            'status' => 'Present',
            'subject' => $subjectName,
            'code' => $classCode,
        ]);
    }

    /**
     * Upload and update user profile avatar (cropped image).
     */
    public function updateAvatar(Request $request)
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please sign in to update your avatar.'], 401);
        }

        $request->validate([
            'avatar_data' => 'required|string',
        ]);

        $data = $request->input('avatar_data');

        // Parse base64 string from Cropper.js canvas
        if (preg_match('/^data:image\/(\w+);base64,/', $data, $typeMatch)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($typeMatch[1]); // jpg, png, jpeg, webp

            if (!in_array($type, ['jpg', 'jpeg', 'png', 'webp'])) {
                $type = 'jpg';
            }

            $decoded = base64_decode($data);
            if ($decoded === false) {
                return response()->json(['success' => false, 'message' => 'Failed to decode image data.'], 422);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid image format.'], 422);
        }

        // Ensure target upload directory exists in public folder
        $uploadDir = public_path('uploads/avatars');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $user = \Illuminate\Support\Facades\Auth::user();
        $filename = 'avatar_' . $user->id . '_' . time() . '.' . ($type === 'jpeg' ? 'jpg' : $type);
        $filePath = $uploadDir . DIRECTORY_SEPARATOR . $filename;

        file_put_contents($filePath, $decoded);

        $avatarUrl = asset('uploads/avatars/' . $filename);

        // Update in users table
        DB::table('users')->where('id', $user->id)->update([
            'avatar' => $avatarUrl,
            'updated_at' => now(),
        ]);

        // Sync to campus_students table
        DB::table('campus_students')->where('email', $user->email)->update([
            'avatar' => $avatarUrl,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'avatar_url' => $avatarUrl,
            'message' => 'Profile image updated successfully!',
        ]);
    }

    /**
     * Client: Enroll in Course (Class Cart)
     */
    public function enrollCartCourse(Request $request)
    {
        $courseCode = $request->input('course_code');
        $studentId = 'GZ20260482';
        $studentName = 'Maya Chen';

        if (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $studentId = $user->student_id ?: 'GZ' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
            $studentName = $user->name;
        }

        // Check if course exists in class list
        $class = DB::table('campus_classes')->where('code', $courseCode)->first();
        $title = $class ? $class->title : ($request->input('course_title') ?: 'Elective Course');
        $instructor = $class ? $class->prof : ($request->input('instructor') ?: 'Faculty Instructor');
        $schedule = $class ? $class->schedule_time : ($request->input('schedule') ?: 'TBA');

        DB::table('campus_course_carts')->updateOrInsert(
            [
                'student_id' => $studentId,
                'course_code' => $courseCode,
            ],
            [
                'course_title' => $title,
                'credits' => 3,
                'instructor' => $instructor,
                'schedule' => $schedule,
                'status' => 'Enrolled',
                'fee' => 'Paid',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Record attendance placeholder
        DB::table('campus_attendances')->insert([
            'student_name' => $studentName,
            'student_id' => $studentId,
            'subject' => $title,
            'code' => $courseCode,
            'status' => 'Present',
            'check_in_time' => now()->format('h:i A') . ' (Enrolled)',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $enrolledCount = DB::table('campus_course_carts')
            ->where('student_id', $studentId)
            ->where('status', 'Enrolled')
            ->count();

        $totalCredits = $enrolledCount * 3;

        return response()->json([
            'success' => true,
            'message' => "Enrolled successfully in {$title} ({$courseCode})!",
            'enrolled_count' => $enrolledCount,
            'total_credits' => $totalCredits,
            'course_code' => $courseCode,
        ]);
    }

    /**
     * Client: Drop Course (Class Cart)
     */
    public function dropCartCourse(Request $request)
    {
        $courseCode = $request->input('course_code');
        $studentId = 'GZ20260482';

        if (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $studentId = $user->student_id ?: 'GZ' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
        }

        DB::table('campus_course_carts')
            ->where('student_id', $studentId)
            ->where('course_code', $courseCode)
            ->update([
                'status' => 'In Cart',
                'updated_at' => now(),
            ]);

        $enrolledCount = DB::table('campus_course_carts')
            ->where('student_id', $studentId)
            ->where('status', 'Enrolled')
            ->count();

        $totalCredits = $enrolledCount * 3;

        return response()->json([
            'success' => true,
            'message' => "Course {$courseCode} dropped and moved to cart electives.",
            'enrolled_count' => $enrolledCount,
            'total_credits' => $totalCredits,
            'course_code' => $courseCode,
        ]);
    }

    /**
     * Client: Join Campus Collaboration Team Project
     */
    public function joinCollaboration($id)
    {
        $collab = DB::table('campus_collaborations')->where('id', $id)->first();
        if (!$collab) {
            return response()->json(['success' => false, 'message' => 'Project not found.'], 404);
        }

        if ($collab->current_members >= $collab->max_members) {
            return response()->json(['success' => false, 'message' => 'This team project is already full!']);
        }

        $newMembers = $collab->current_members + 1;
        $newStatus = ($newMembers >= $collab->max_members) ? 'Full' : 'Open';

        DB::table('campus_collaborations')->where('id', $id)->update([
            'current_members' => $newMembers,
            'status' => $newStatus,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Congratulations! You joined the team for '{$collab->title}'!",
            'current_members' => $newMembers,
            'max_members' => $collab->max_members,
            'status' => $newStatus,
        ]);
    }

    /**
     * Client: Join Campus Challenge
     */
    public function joinChallenge($id)
    {
        $challenge = DB::table('campus_challenges')->where('id', $id)->first();
        if (!$challenge) {
            return response()->json(['success' => false, 'message' => 'Challenge not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => "Challenge Accepted! You've entered '{$challenge->title}'! Complete before {$challenge->deadline} to claim +{$challenge->points} points.",
            'points' => $challenge->points,
            'title' => $challenge->title,
        ]);
    }

    /**
     * Client: View Resource in dedicated new page/tab with share link capability.
     */
    public function viewResource($id)
    {
        $resource = DB::table('campus_resources')->where('id', $id)->first();
        if (!$resource) {
            abort(404, 'Resource not found');
        }

        DB::table('campus_resources')->where('id', $id)->increment('download_count');

        return view('campus.resource_view', compact('resource'));
    }

    /**
     * Client: Real-Time Poll Show Screen & Slide Teaching Broadcast
     */
    public function getLiveShowScreen()
    {
        $broadcast = DB::table('campus_screen_broadcasts')->first();
        $slides = DB::table('campus_teaching_slides')->first();
        $spotlights = DB::table('campus_screen_spotlights')->orderBy('display_order', 'asc')->get();

        return response()->json([
            'success' => true,
            'is_broadcasting' => $broadcast ? (bool)$broadcast->is_broadcasting : false,
            'student_name' => $broadcast ? $broadcast->student_name : 'Faculty Presenter',
            'room' => $broadcast ? $broadcast->room : 'Lab 402 • Media Wing',
            'preview_title' => $broadcast ? $broadcast->preview_title : 'Classroom Presentation',
            'slide_index' => $slides ? $slides->current_slide : 1,
            'total_slides' => $slides ? $slides->total_slides : 12,
            'slide_title' => $slides ? $slides->title : 'Digital Innovation Lecture',
            'spotlights_count' => $spotlights->count(),
            'spotlights' => $spotlights,
        ]);
    }

    /**
     * Client: Download Library Book E-Book
     */
    public function downloadBook($id)
    {
        $book = DB::table('campus_books')->where('id', $id)->first();
        if (!$book) {
            abort(404, 'Book not found');
        }

        DB::table('campus_books')->where('id', $id)->increment('reads_count');

        $fileName = $book->file_name ?: 'E-Book.pdf';
        $content = "=========================================================\n" .
            "           GENZ DIGITAL CAMPUS LIBRARY E-BOOK           \n" .
            "=========================================================\n" .
            "Title:       {$book->title}\n" .
            "Author:      {$book->author}\n" .
            "Category:    {$book->category}\n" .
            "Pages:       {$book->total_pages} Pages\n" .
            "File Size:   {$book->file_size}\n" .
            "Description: {$book->description}\n" .
            "---------------------------------------------------------\n" .
            "Status: OFFICIAL REPOSITORY COPY\n" .
            "GenZ Digital Library & Academic Knowledge Center\n" .
            "=========================================================\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }

    /**
     * Client: Download Course Resource & Increment Counter
     */
    public function downloadResource($id)
    {
        $resource = DB::table('campus_resources')->where('id', $id)->first();
        if (!$resource) {
            return response()->json(['success' => false, 'message' => 'Resource not found.'], 404);
        }

        DB::table('campus_resources')->where('id', $id)->increment('download_count');

        $fileName = $resource->file_name;

        // 1. If actual uploaded file exists on disk, serve the real file
        if (!empty($resource->file_url) && file_exists(public_path($resource->file_url))) {
            $mimeType = str_ends_with(strtolower($resource->file_url), '.pdf') ? 'application/pdf' : 'application/octet-stream';
            return response()->download(public_path($resource->file_url), $fileName, [
                'Content-Type' => $mimeType,
            ]);
        }

        // 2. Fallback text response for default/mock seeded resources
        $content = "GENZ DIGITAL CAMPUS RESOURCE FILE\n" .
            "Course: {$resource->course}\n" .
            "Title: {$resource->title}\n" .
            "File Name: {$resource->file_name}\n" .
            "Downloaded: " . now()->toDayDateTimeString() . "\n\n" .
            "--- Lecture Notes and Syllabus Content ---\n" .
            "Welcome to {$resource->title}. All study materials are verified by GenZ Campus Administration.";

        return response($content, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }

    /**
     * Client: Download Official Academic Transcript (PDF/Text)
     */
    public function downloadTranscript()
    {
        $studentName = 'Maya Chen';
        $studentId = 'GZ20260482';
        $major = 'Visual Communication & Digital Media';

        if (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $studentName = $user->name;
            $studentId = $user->student_id ?: 'GZ' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
            $major = $user->major ?: $major;
        }

        $scores = DB::table('campus_scores')->where('student_id', $studentId)->get();

        $content = "=========================================================\n" .
            "            GENZ DIGITAL ACADEMIC TRANSCRIPT            \n" .
            "=========================================================\n" .
            "Student Name: {$studentName}\n" .
            "Student ID:   {$studentId}\n" .
            "Major:        {$major}\n" .
            "Date Issued:  " . date('F d, Y') . "\n" .
            "Academic Standing: Dean's Honors List (GPA 3.88 / 4.00)\n" .
            "---------------------------------------------------------\n" .
            "Course Code | Subject Name                   | Grade\n" .
            "---------------------------------------------------------\n";

        if ($scores->isNotEmpty()) {
            foreach ($scores as $s) {
                $content .= sprintf("%-11s | %-30s | %s (%s)\n", $s->code, substr($s->subject, 0, 30), $s->grade, $s->score);
            }
        } else {
            $content .= "DES302      | UI/UX Design Systems           | A+ (94)\n";
            $content .= "DES305      | Motion Graphics & 3D Visual    | A  (91)\n";
            $content .= "RES201      | Design Thinking & Research     | A  (92)\n";
            $content .= "MKT204      | Brand Identity Strategy        | B+ (86)\n";
        }

        $content .= "---------------------------------------------------------\n" .
            "Status: OFFICIAL REGISTRAR VERIFIED COPY\n" .
            "GenZ Digital Campus OS • Academic Records Division\n" .
            "=========================================================\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => "attachment; filename=\"transcript_{$studentId}.txt\"",
        ]);
    }

    /**
     * Client: Request Spotlight Screen Share in Classroom
     */
    public function requestScreenShare(Request $request)
    {
        $studentName = 'Maya Chen';
        $studentId = 'GZ20260482';

        if (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $studentName = $user->name;
            $studentId = $user->student_id ?: 'GZ' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
        }

        DB::table('campus_screen_broadcasts')->updateOrInsert(
            ['id' => 1],
            [
                'student_name' => $studentName,
                'student_id' => $studentId,
                'room' => 'Lab 402 • Media Wing',
                'is_broadcasting' => true,
                'preview_title' => "Student Spotlight: {$studentName}'s Live Interface Demo",
                'updated_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => "Your screen spotlight request is approved! Now broadcasting live to classroom projector.",
            'student_name' => $studentName,
        ]);
    }

    /**
     * Client: Check-in using 4-digit Short Passcode (Option 2)
     */
    public function checkInWithPasscode(Request $request)
    {
        $request->validate([
            'passcode' => 'required|string|max:20',
        ]);

        $passcode = trim($request->input('passcode'));
        $qr = DB::table('campus_qr_codes')
            ->where('short_code', $passcode)
            ->where('status', 'Active')
            ->first();

        // If not found by short_code, also check code_value
        if (!$qr) {
            $qr = DB::table('campus_qr_codes')
                ->where('code_value', $passcode)
                ->where('status', 'Active')
                ->first();
        }

        if (!$qr) {
            return response()->json([
                'success' => false,
                'message' => 'លេខកូដសម្ងាត់មិនត្រឹមត្រូវ ឬផុតកំណត់ហើយ! សូមពិនិត្យលេខកូដនៅលើអេក្រង់សាជាថ្មី។',
            ], 422);
        }

        $studentName = 'Maya Chen';
        $studentId = 'GZ20260482';

        if ($request->filled('student_id')) {
            $studentId = $request->input('student_id');
            $st = DB::table('campus_students')->where('student_id', $studentId)->first();
            if ($st) {
                $studentName = $st->name;
            } elseif ($request->filled('student_name')) {
                $studentName = $request->input('student_name');
            }
        } elseif (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $studentName = $user->name;
            $studentId = $user->student_id ?: 'GZ' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
        }

        $classCode = $qr->class_code ?: 'CAMPUS';
        $subjectName = $qr->title;
        $sessionName = $request->input('session_name') ?: ($qr->session_name ?: 'Session 1 (ព្រឹក)');
        $today = date('Y-m-d');

        // RULE 1: Student must be enrolled in this class!
        if ($classCode && $classCode !== 'CAMPUS' && $classCode !== 'ALL') {
            $isEnrolledInClass = DB::table('campus_course_carts')
                ->where('student_id', $studentId)
                ->where('course_code', $classCode)
                ->where('status', 'Enrolled')
                ->exists();

            if (!$isEnrolledInClass) {
                return response()->json([
                    'success' => false,
                    'error_code' => 'NOT_ENROLLED_IN_CLASS',
                    'message' => "⚠️ អ្នកមិនមែនជាសិស្សនៅក្នុងថ្នាក់ [{$classCode}] នេះទេ! មិនអាចស្កេនវត្តមាន ឬបំពេញកូដបានឡើយ។ ទាល់តែសិស្សមានឈ្មោះក្នុងថ្នាក់នេះទើបអាចស្កេនបាន។",
                ], 403);
            }
        }

        // RULE 2: 2 Sessions per day (Session 1 ព្រឹក & Session 2 រសៀល)
        $todayScans = DB::table('campus_attendances')
            ->where('student_id', $studentId)
            ->where('code', $classCode)
            ->where(function ($q) use ($today) {
                $q->where('session_date', $today)
                  ->orWhereDate('created_at', $today);
            })
            ->get();

        $alreadyScannedThisSession = $todayScans->first(function ($a) use ($sessionName) {
            return ($a->session_name ?? '') === $sessionName;
        });

        if ($alreadyScannedThisSession && !$request->has('force')) {
            return response()->json([
                'success' => false,
                'error_code' => 'ALREADY_SCANNED_SESSION',
                'message' => "ℹ️ អ្នកបានស្កេនវត្តមានសម្រាប់ {$sessionName} រួចរាល់ហើយក្នុងថ្ងៃនេះ! ក្នុង ១ ថ្ងៃត្រូវស្កេនចំនួន ២ ដង (Session 1 ព្រឹក & Session 2 រសៀល)។",
                'session_name' => $sessionName,
            ], 422);
        }

        DB::table('campus_attendances')->insert([
            'student_name' => $studentName,
            'student_id' => $studentId,
            'subject' => $subjectName,
            'code' => $classCode,
            'session_name' => $sessionName,
            'session_date' => $today,
            'status' => 'Present',
            'check_in_time' => 'Today, ' . date('h:i A'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('campus_qr_codes')->where('id', $qr->id)->increment('scans_count');

        $sessionNumber = str_contains($sessionName, '1') ? '១' : '២';
        return response()->json([
            'success' => true,
            'message' => "🎉 វត្តមានជោគជ័យតាមរយៈលេខកូដ [{$passcode}] សម្រាប់ {$sessionName}! អ្នកបានកត់ត្រាវត្តមានលើកទី {$sessionNumber} នៃថ្ងៃនេះ។",
            'session_name' => $sessionName,
            'time' => date('h:i A'),
            'status' => 'Present',
            'subject' => $subjectName,
            'code' => $classCode,
        ]);
    }

    /**
     * Client: Get QCM Questions for an Exam
     */
    public function getExamQuestions($id)
    {
        $exam = DB::table('campus_exams')->where('id', $id)->first();
        if (!$exam) {
            return response()->json(['error' => 'Exam not found'], 404);
        }

        $questions = DB::table('campus_exam_questions')
            ->where('exam_id', $id)
            ->get(['id', 'exam_id', 'question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'points']);

        if ($questions->isEmpty()) {
            $courseLabel = $exam->course ?: 'Campus';
            DB::table('campus_exam_questions')->insert([
                [
                    'exam_id' => $id,
                    'question_text' => "តើគោលការណ៍គ្រឹះនៃមុខវិជ្ជា {$courseLabel} ({$exam->title}) ផ្ដោតសំខាន់លើអ្វី?",
                    'option_a' => 'ការយល់ដឹងពីប្រព័ន្ធ Architecture និង Standards ស្របតាមបច្ចេកវិទ្យា',
                    'option_b' => 'ការដំឡើង Hardware ដោយដៃផ្ទាល់',
                    'option_c' => 'ការគូររូបលើក្រដាសដោយមិនប្រើ Software',
                    'option_d' => 'ការបិទដំណើរការប្រព័ន្ធកុំព្យូទ័រ',
                    'correct_option' => 'A',
                    'points' => 30,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'exam_id' => $id,
                    'question_text' => "នៅក្នុងការអនុវត្តជាក់ស្ដែង តើវិធីសាស្ត្រណាដែលផ្ដល់ប្រសិទ្ធភាពខ្ពស់បំផុតសម្រាប់ {$exam->title}?",
                    'option_a' => 'ការសាកល្បងដោយគ្មានការរៀបចំផែនការ',
                    'option_b' => 'ការអនុវត្តតាម Best Practices & Agile Iterations',
                    'option_c' => 'ការចម្លងកូដដោយមិនយល់ពី Structure',
                    'option_d' => 'ការមិនធ្វើ Testing មុនពេល Deploy',
                    'correct_option' => 'B',
                    'points' => 35,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'exam_id' => $id,
                    'question_text' => "តើឧបករណ៍ ឬ Framework ណាដែលស័ក្តិសមបំផុតសម្រាប់ Modern Workflows?",
                    'option_a' => 'Legacy Command Line Tools ជំនាន់ចាស់',
                    'option_b' => 'Automated CI/CD & Modern Reactive Systems',
                    'option_c' => 'Manual File Copying តាម USB',
                    'option_d' => 'Single Threaded Uncached Scripts',
                    'correct_option' => 'B',
                    'points' => 35,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            $questions = DB::table('campus_exam_questions')
                ->where('exam_id', $id)
                ->get(['id', 'exam_id', 'question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'points']);
        }

        return response()->json([
            'success' => true,
            'exam' => $exam,
            'questions' => $questions,
        ]);
    }

    /**
     * Client: Submit QCM Exam and Auto-Calculate Score
     */
    public function submitExam(Request $request, $id)
    {
        $exam = DB::table('campus_exams')->where('id', $id)->first();
        if (!$exam) {
            return response()->json(['error' => 'Exam not found'], 404);
        }

        $questions = DB::table('campus_exam_questions')->where('exam_id', $id)->get();
        $answers = $request->input('answers', []);

        $earnedScore = 0;
        $totalPossible = 0;
        $correctCount = 0;
        $questionDetails = [];

        foreach ($questions as $q) {
            $totalPossible += $q->points;
            $submitted = isset($answers[$q->id]) ? strtoupper(trim($answers[$q->id])) : null;
            $isCorrect = ($submitted === strtoupper(trim($q->correct_option)));

            if ($isCorrect) {
                $earnedScore += $q->points;
                $correctCount++;
            }

            $questionDetails[] = [
                'id' => $q->id,
                'is_correct' => $isCorrect,
                'submitted' => $submitted,
                'correct_option' => $q->correct_option,
                'points_earned' => $isCorrect ? $q->points : 0,
            ];
        }

        // If no questions exist, provide default full score simulation
        if ($totalPossible === 0) {
            $totalPossible = 100;
            $earnedScore = 90;
            $correctCount = 4;
        }

        $percentage = round(($earnedScore / $totalPossible) * 100);
        $isPassed = ($percentage >= 50);
        $statusLabel = $isPassed ? 'PASSED (ជាប់)' : 'FAILED (ធ្លាក់)';
        $statusColor = $isPassed ? '#10b981' : '#ef4444';
        $grade = $percentage >= 90 ? 'A' : ($percentage >= 80 ? 'B' : ($percentage >= 70 ? 'C' : ($percentage >= 50 ? 'D' : 'F')));

        // Save score into campus_scores for this student
        $studentId = 'GZ20260482';
        if (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $studentId = $user->student_id ?: 'GZ' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
        }

        DB::table('campus_scores')->updateOrInsert(
            [
                'student_id' => $studentId,
                'code' => $exam->course,
            ],
            [
                'subject' => $exam->title,
                'score' => $earnedScore,
                'grade' => $grade,
                'credits' => 3,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => $isPassed
                ? "អបអរសាទរ! អ្នកបានប្រឡងជាប់ ({$percentage}%) និទ្ទេស {$grade}"
                : "សូមព្យាយាមម្តងទៀត! ពិន្ទុរបស់អ្នកគឺ {$percentage}% (ក្រោម 50% ធ្លាក់)",
            'earned_score' => $earnedScore,
            'total_possible' => $totalPossible,
            'percentage' => $percentage,
            'grade' => $grade,
            'is_passed' => $isPassed,
            'status_label' => $statusLabel,
            'status_color' => $statusColor,
            'correct_count' => $correctCount,
            'total_questions' => $questions->count(),
            'details' => $questionDetails,
        ]);
    }

    /**
     * Client: Get Real-Time Leaderboard for Challenge
     */
    public function getChallengeLeaderboard($id)
    {
        $participants = DB::table('campus_challenge_participants')
            ->where('challenge_id', $id)
            ->orderBy('score', 'desc')
            ->orderBy('completion_time', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'participants' => $participants,
        ]);
    }

    /**
     * Client: Submit Challenge Answer
     */
    public function submitChallenge(Request $request, $id)
    {
        $challenge = DB::table('campus_challenges')->where('id', $id)->first();
        if (!$challenge) {
            return response()->json(['error' => 'Challenge not found'], 404);
        }

        $studentName = 'Maya Chen';
        $studentId = 'GZ20260482';
        $avatar = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250';

        if (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $studentName = $user->name;
            $studentId = $user->student_id ?: 'GZ' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
            $avatar = $user->avatar ?: $avatar;
        }

        $submittedAnswer = $request->input('answer');
        $isCorrect = true;
        if ($challenge->correct_answer && $submittedAnswer) {
            $isCorrect = (strtoupper(trim($submittedAnswer)) === strtoupper(trim($challenge->correct_answer)));
        }

        $earnedPoints = $isCorrect ? $challenge->points : (int)($challenge->points * 0.6);
        $completionTime = sprintf('%02d:%02d', rand(1, 3), rand(10, 59));

        DB::table('campus_challenge_participants')->updateOrInsert(
            [
                'challenge_id' => $id,
                'student_id' => $studentId,
            ],
            [
                'student_name' => $studentName,
                'avatar' => $avatar,
                'score' => $earnedPoints,
                'completion_time' => $completionTime,
                'rank' => 1,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Recalculate ranks
        $all = DB::table('campus_challenge_participants')
            ->where('challenge_id', $id)
            ->orderBy('score', 'desc')
            ->orderBy('completion_time', 'asc')
            ->get();

        $rank = 1;
        $studentRank = 1;
        foreach ($all as $p) {
            DB::table('campus_challenge_participants')->where('id', $p->id)->update(['rank' => $rank]);
            if ($p->student_id === $studentId) {
                $studentRank = $rank;
            }
            $rank++;
        }

        return response()->json([
            'success' => true,
            'message' => "អ្នកទទួលបានពិន្ទុ +{$earnedPoints} Points! ចំណាត់ថ្នាក់បច្ចុប្បន្ន: #{$studentRank}",
            'score' => $earnedPoints,
            'rank' => $studentRank,
            'time' => $completionTime,
        ]);
    }

    /**
     * Client: Submit Group Collaboration Answer
     */
    public function submitCollabAnswer(Request $request, $id)
    {
        $session = DB::table('campus_collaboration_sessions')->where('id', $id)->first();
        $submitted = strtoupper(trim($request->input('answer', 'B')));
        $isCorrect = ($session && $session->correct_option) ? ($submitted === strtoupper(trim($session->correct_option))) : true;

        return response()->json([
            'success' => true,
            'is_correct' => $isCorrect,
            'message' => $isCorrect ? 'ចម្លើយត្រឹមត្រូវ! ក្រុមទទួលបាន +50 Innovation Points!' : 'ចម្លើយមិនទាន់ត្រឹមត្រូវទេ សូមពិភាក្សាជាមួយសមាជិកក្រុមឡើងវិញ។',
            'team_points' => 50,
        ]);
    }
}
