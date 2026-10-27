<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class AdvancedFeaturesTest extends TestCase
{
    /**
     * Test 1. Manage Users & Class Assignment
     */
    public function test_manage_users_and_class_assignment(): void
    {
        $response = $this->get('/admin?tab=users');
        $response->assertStatus(200);
        $response->assertSee('Manage Users & Students', false);
        $response->assertSee('គ្រប់គ្រងសិស្សតាមថ្នាក់');
        $response->assertSee('user-class-filter');

        // Test Checkbox Batch Enroll feature
        $newStudentId = 'GZ_TEST_' . uniqid() . '_' . rand(100, 999);
        DB::table('campus_students')->insert([
            'name' => 'Kosal Dev',
            'student_id' => $newStudentId,
            'email' => 'kosal.' . uniqid() . '@genzdigital.edu',
            'major' => 'Digital & AI',
            'gender' => 'Male',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250',
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $class = DB::table('campus_classes')->first();

        // Batch enroll via checkboxes
        $batchResponse = $this->post('/admin/students/batch-assign-class', [
            'student_ids' => [$newStudentId],
            'class_id' => $class->id,
        ]);
        $batchResponse->assertRedirect('/admin?tab=users');

        // Verify student is now enrolled in course carts
        $isEnrolled = DB::table('campus_course_carts')
            ->where('student_id', $newStudentId)
            ->where('course_code', $class->code)
            ->where('status', 'Enrolled')
            ->exists();
        $this->assertTrue($isEnrolled);

        // Verify student now appears in Class Details roster
        $detailsResponse = $this->get("/admin/classes/{$class->id}/details");
        $detailsResponse->assertStatus(200);
        $this->assertTrue(collect($detailsResponse->json('students'))->contains('student_id', $newStudentId));
    }

    /**
     * Test 2. Show Users on Screen (Fullscreen 4-User Rotation)
     */
    public function test_fullscreen_spotlight_screen_and_rotation(): void
    {
        // 1. Visit Fullscreen projector view
        $response = $this->get('/admin/screen/fullscreen');
        $response->assertStatus(200);
        $response->assertSee('LIVE CLASSROOM SPOTLIGHT');
        $response->assertSee('4-USER MULTI-SCREEN');

        // 2. Fetch spotlights data API
        $apiResponse = $this->get('/admin/screen/spotlights/data');
        $apiResponse->assertStatus(200);
        $apiResponse->assertJsonStructure(['success', 'count', 'users']);

        // 3. Add student to spotlight queue
        $student = DB::table('campus_students')->first();
        $addResponse = $this->postJson('/admin/screen/spotlights/add', [
            'student_id' => $student->student_id,
            'preview_title' => 'Feature Test Prototype',
        ]);
        $addResponse->assertStatus(200);
        $addResponse->assertJson(['success' => true]);
    }

    /**
     * Test 3. Teaching Reports by Class
     */
    public function test_teaching_reports_by_class(): void
    {
        $response = $this->get('/admin?tab=reports');
        $response->assertStatus(200);
        $response->assertSee('Teaching Reports & Analytics', false);
        $response->assertSee('report-class-filter');

        // Export CSV for specific class
        $exportResponse = $this->get('/admin/reports/export?class_code=DES302');
        $exportResponse->assertStatus(200);
        $this->assertEquals('text/csv; charset=UTF-8', $exportResponse->headers->get('Content-Type'));
    }

    /**
     * Test 4. Exam QCM & Auto-Scoring
     */
    public function test_exam_qcm_and_auto_scoring(): void
    {
        $exam = DB::table('campus_exams')->first();
        if (!$exam) {
            $examId = DB::table('campus_exams')->insertGetId([
                'title' => 'Digital Product Design Mid-Term',
                'course' => 'DES302',
                'class_code' => 'DES302',
                'date' => date('Y-m-d'),
                'start_time' => '09:00 AM',
                'duration' => '60 Mins',
                'total_questions' => 20,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $exam = DB::table('campus_exams')->where('id', $examId)->first();
        }
        DB::table('campus_exam_submissions')->where('exam_id', $exam->id)->delete();

        // 1. Admin adds QCM question
        $qcmResponse = $this->post('/admin/exams/qcm-question', [
            'exam_id' => $exam->id,
            'question_text' => 'Unit Test Sample Question?',
            'option_a' => 'Option A',
            'option_b' => 'Option B',
            'option_c' => 'Option C',
            'option_d' => 'Option D',
            'correct_option' => 'A',
            'points' => 25,
        ]);
        $qcmResponse->assertRedirect('/admin?tab=exams');

        // 2. Client fetches questions API
        $getQuestions = $this->getJson("/api/exams/{$exam->id}/questions");
        $getQuestions->assertStatus(200);
        $getQuestions->assertJsonStructure(['success', 'exam', 'questions']);

        // 3. Client submits answers & auto-calculates score
        $question = DB::table('campus_exam_questions')->where('exam_id', $exam->id)->first();
        $submitResponse = $this->postJson("/api/exams/{$exam->id}/submit", [
            'answers' => [
                $question->id => $question->correct_option,
            ]
        ]);
        $submitResponse->assertStatus(200);
        $submitResponse->assertJsonStructure(['success', 'earned_score', 'total_possible', 'percentage', 'grade']);
        $this->assertTrue($submitResponse->json('earned_score') > 0);
    }

    /**
     * Test 5. Real-Time Challenge & Fullscreen Leaderboard
     */
    public function test_challenge_and_fullscreen_leaderboard(): void
    {
        $challenge = DB::table('campus_challenges')->first();
        if (!$challenge) {
            $chId = DB::table('campus_challenges')->insertGetId([
                'title' => 'UI Speed Prototyping',
                'category' => 'Design Sprint',
                'points' => 500,
                'participants_count' => 12,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $challenge = DB::table('campus_challenges')->where('id', $chId)->first();
        }

        // 1. Visit Fullscreen Leaderboard
        $response = $this->get("/admin/challenges/{$challenge->id}/fullscreen");
        $response->assertStatus(200);
        $response->assertSee('REAL-TIME LEADERBOARD');
        $response->assertSee('clock-display');

        // 2. Fetch Leaderboard API
        $leaderboardResponse = $this->getJson("/api/challenges/{$challenge->id}/leaderboard");
        $leaderboardResponse->assertStatus(200);
        $leaderboardResponse->assertJsonStructure(['success', 'participants']);

        // 3. Client submits Challenge answer
        $submitResponse = $this->postJson("/api/challenges/{$challenge->id}/submit", [
            'answer' => 'A',
        ]);
        $submitResponse->assertStatus(200);
        $submitResponse->assertJsonStructure(['success', 'score', 'rank']);
    }

    /**
     * Test 6. Certificate Batch Generation
     */
    public function test_certificate_batch_generation(): void
    {
        $response = $this->post('/admin/certificates/batch', [
            'title' => 'Full-Stack Digital Innovation Award',
            'class_code' => 'ALL',
            'cert_type' => 'Honor Roll',
            'issue_date' => 'October 2026',
        ]);
        $response->assertRedirect('/admin?tab=certificates');
        $response->assertSessionHas('success');

        // Verify certificates in database
        $count = DB::table('campus_certificates')
            ->where('title', 'like', '%Full-Stack Digital Innovation Award%')
            ->count();
        $this->assertTrue($count > 0);
    }

    /**
     * Test 7. Slide Teaching with AI Camera Gesture
     */
    public function test_slide_teaching_fullscreen(): void
    {
        $response = $this->get('/admin/slides/fullscreen');
        $response->assertStatus(200);
        $response->assertSee('AI GESTURE TRACKER');
        $response->assertSee('webcam-feed');
        $response->assertSee('toggleWebCam');
        $response->assertSee('office-slide-iframe');
        $response->assertSee('slide-nav-overlay-btn');

        // Verify Admin Tab Live Preview & Controls
        $adminResponse = $this->get('/admin?tab=slides');
        $adminResponse->assertStatus(200);
        $adminResponse->assertSee('admin-tab-slides');
        $adminResponse->assertSee('LIVE SLIDE PREVIEW');
        $adminResponse->assertSee('adminPreviewNav');
    }

    /**
     * Test 8. Collaboration Real-Time QCM Sprint
     */
    public function test_collaboration_realtime_qcm(): void
    {
        $collab = DB::table('campus_collaborations')->first();
        if (!$collab) {
            $collabId = DB::table('campus_collaborations')->insertGetId([
                'title' => 'UX Team Heuristic Review',
                'team_name' => 'Team Alpha',
                'question' => 'Which heuristic applies to visibility of system status?',
                'options' => json_encode(['A' => 'Aesthetic design', 'B' => 'System feedback', 'C' => 'Error prevention', 'D' => 'Help docs']),
                'correct_option' => 'B',
                'points' => 100,
                'status' => 'Open',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $collab = DB::table('campus_collaborations')->where('id', $collabId)->first();
        }
        $response = $this->postJson("/api/collaborations/{$collab->id}/answer", [
            'answer' => 'B',
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'is_correct', 'message', 'team_points']);
    }

    /**
     * Test 9. Game Random Modal
     */
    public function test_game_random_modal(): void
    {
        $response = $this->get('/admin?tab=game');
        $response->assertStatus(200);
        $response->assertSee('Game Random');
        $response->assertSee('winnerProfileModal');
        $response->assertSee('spinRandomStudentWithPopup');
    }

    /**
     * Test 10. Attendance Roster Table & Exports (Excel, PDF, Print)
     */
    public function test_attendance_table_and_exports(): void
    {
        // 1. Tab view
        $response = $this->get('/admin?tab=attendance');
        $response->assertStatus(200);
        $response->assertSee('Attendance Tracker');

        // 2. Export Excel (CSV)
        $excelResponse = $this->get('/admin/attendance/export?format=excel');
        $excelResponse->assertStatus(200);
        $this->assertEquals('text/csv; charset=UTF-8', $excelResponse->headers->get('Content-Type'));

        // 3. Export PDF
        $pdfResponse = $this->get('/admin/attendance/export?format=pdf');
        $pdfResponse->assertStatus(200);
        $pdfResponse->assertSee('OFFICIAL CLASSROOM ATTENDANCE ROSTER');
    }

    /**
     * Test 11. Scan QR & Short 4-Digit Passcode Check-In
     */
    public function test_scan_qr_and_short_passcode_checkin(): void
    {
        // 1. QR code admin tab
        $response = $this->get('/admin?tab=qr');
        $response->assertStatus(200);
        $response->assertSee('QR Code & Short Passcode Manager', false);

        // 2. Find or create an active QR code with short code for testing
        $qr = DB::table('campus_qr_codes')->where('status', 'Active')->first();
        if (!$qr || \App\Http\Controllers\CampusController::isQrExpired($qr)) {
            $qrId = DB::table('campus_qr_codes')->insertGetId([
                'title' => 'Lab 402 Active QR',
                'type' => 'Attendance',
                'class_code' => 'DES302',
                'session_name' => 'Session 1 (ព្រឹក)',
                'session_date' => date('Y-m-d'),
                'code_value' => 'GZ-QR-ACTIVE-TEST-' . uniqid(),
                'short_code' => '8492',
                'expires_at' => date('Y-m-d H:i:s', time() + 86400),
                'scans_count' => 0,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $qr = DB::table('campus_qr_codes')->where('id', $qrId)->first();
        } else {
            DB::table('campus_qr_codes')->where('id', $qr->id)->update([
                'short_code' => $qr->short_code ?: '8492',
                'expires_at' => date('Y-m-d H:i:s', time() + 86400),
                'status' => 'Active',
            ]);
            $qr = DB::table('campus_qr_codes')->where('id', $qr->id)->first();
        }
        $this->assertNotNull($qr);

        // Clear prior attendance records for Maya Chen so testing is deterministic
        DB::table('campus_attendances')->where('student_id', 'GZ20260482')->delete();

        // 3. Student (enrolled) checks in Session 1 using 4-digit passcode
        $checkInResponse = $this->postJson('/api/attendance/passcode', [
            'passcode' => $qr->short_code ?: '8492',
        ]);
        $checkInResponse->assertStatus(200);
        $checkInResponse->assertJson(['success' => true]);
        $this->assertEquals('Session 1 (ព្រឹក)', $checkInResponse->json('session_name'));

        // 4. Scanning the same session again on same day fails (422)
        $duplicateResponse = $this->postJson('/api/attendance/passcode', [
            'passcode' => $qr->short_code ?: '8492',
        ]);
        $duplicateResponse->assertStatus(422);
        $duplicateResponse->assertJson(['success' => false, 'error_code' => 'ALREADY_SCANNED_SESSION']);

        // 5. Unenrolled student scanning class QR gets rejected (403)
        $unenrolledResponse = $this->postJson('/api/attendance/check-in', [
            'code' => 'MKT204',
            'student_id' => 'GZ_UNENROLLED_9999',
            'student_name' => 'Stranger Student',
        ]);
        $unenrolledResponse->assertStatus(403);
        $unenrolledResponse->assertJson(['success' => false, 'error_code' => 'NOT_ENROLLED_IN_CLASS']);

        // 6. Expired QR / Passcode rejection (422 QR_EXPIRED)
        $expiredQrId = DB::table('campus_qr_codes')->insertGetId([
            'title' => 'Expired Test QR',
            'type' => 'Attendance',
            'class_code' => 'DES302',
            'session_name' => 'Session 2 (រសៀល)',
            'session_date' => date('Y-m-d'),
            'code_value' => 'GZ-QR-EXP-9999',
            'short_code' => '9999',
            'expires_at' => date('Y-m-d H:i:s', time() - 300),
            'scans_count' => 0,
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $expiredResponse = $this->postJson('/api/attendance/passcode', [
            'passcode' => '9999',
            'student_id' => 'GZ20260482',
        ]);
        $expiredResponse->assertStatus(422);
        $expiredResponse->assertJson(['success' => false, 'error_code' => 'QR_EXPIRED']);

        // Clean up temporary expired QR so it doesn't affect subsequent tests
        DB::table('campus_qr_codes')->where('id', $expiredQrId)->delete();
    }

    /**
     * Test 12. Learning Resources PDF View
     */
    public function test_learning_resources_pdf_view(): void
    {
        $response = $this->get('/admin?tab=resources');
        $response->assertStatus(200);
        $response->assertSee('Learning Resources & PDF Upload', false);
    }

    /**
     * Test 13. Class Management with 4 Interactive Tabs Details
     */
    public function test_class_management_4_tabs_details(): void
    {
        $class = DB::table('campus_classes')->first();
        $response = $this->getJson("/admin/classes/{$class->id}/details");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'class',
            'students',
            'subject',
            'scores',
            'attendances',
        ]);
    }

    /**
     * Test 14. Dedicated Resource Reading View and Copy Link Share
     */
    public function test_client_resource_view_and_share_link(): void
    {
        $res = DB::table('campus_resources')->first();
        $response = $this->get("/resources/{$res->id}/view");
        $response->assertStatus(200);
        $response->assertSee('Resource Reader');
        $response->assertSee('Copy Link Share');
        $response->assertSee('copyShareableLink');
    }

    /**
     * Test 15. Exam QCM Scoring: >=50% Pass (Color Green) & <50% Fail (Color Red) + ReExam Lock & Unlock
     */
    public function test_client_exam_qcm_green_pass_and_red_fail_scoring(): void
    {
        $exam = DB::table('campus_exams')->first();
        // Clear previous submissions for test isolation
        DB::table('campus_exam_submissions')->where('exam_id', $exam->id)->delete();

        $allQuestions = DB::table('campus_exam_questions')->where('exam_id', $exam->id)->get();

        if ($allQuestions->count() > 0) {
            // Correct answers for all questions -> 100% >= 50% PASS (Green: #10b981)
            $allCorrectAnswers = [];
            foreach ($allQuestions as $q) {
                $allCorrectAnswers[$q->id] = $q->correct_option;
            }

            $passResponse = $this->postJson("/api/exams/{$exam->id}/submit", [
                'answers' => $allCorrectAnswers
            ]);
            $passResponse->assertStatus(200);
            $passResponse->assertJson([
                'success' => true,
                'is_passed' => true,
                'status_color' => '#10b981'
            ]);

            // Attempting to submit again without Admin clicking ReExam must be blocked with 422!
            $blockedResponse = $this->postJson("/api/exams/{$exam->id}/submit", [
                'answers' => $allCorrectAnswers
            ]);
            $blockedResponse->assertStatus(422);
            $blockedResponse->assertJson([
                'success' => false,
                'error_code' => 'ALREADY_SUBMITTED'
            ]);

            // Admin clicks ReExam button for this submission
            $sub = DB::table('campus_exam_submissions')->where('exam_id', $exam->id)->first();
            $this->assertNotNull($sub);
            $adminReExam = $this->post("/admin/exams/submissions/{$sub->id}/re-exam");
            $adminReExam->assertRedirect();

            // Verify allow_reexam is now true
            $subUpdated = DB::table('campus_exam_submissions')->where('id', $sub->id)->first();
            $this->assertEquals(1, $subUpdated->allow_reexam);

            // All wrong answers -> 0% < 50% FAIL (Red: #ef4444)
            $allWrongAnswers = [];
            foreach ($allQuestions as $q) {
                $allWrongAnswers[$q->id] = ($q->correct_option === 'A') ? 'B' : 'A';
            }

            $failResponse = $this->postJson("/api/exams/{$exam->id}/submit", [
                'answers' => $allWrongAnswers
            ]);
            $failResponse->assertStatus(200);
            $failResponse->assertJson([
                'success' => true,
                'is_passed' => false,
                'status_color' => '#ef4444'
            ]);

            // Verify allow_reexam is automatically locked back to 0 after retake
            $subLocked = DB::table('campus_exam_submissions')->where('id', $sub->id)->first();
            $this->assertEquals(0, $subLocked->allow_reexam);
        }
    }

    /**
     * Test 16. Real-Time Show Screen Live Poll API
     */
    public function test_client_realtime_showscreen_live_poll(): void
    {
        $response = $this->getJson('/api/showscreen/live');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'is_broadcasting',
            'student_name',
            'room',
            'preview_title',
            'slide_index',
            'total_slides',
            'slide_title',
        ]);
    }

    /**
     * Test 17. Library Books and News Posts Endpoints
     */
    public function test_library_books_and_news_posts(): void
    {
        $book = DB::table('campus_books')->first();
        $downloadResponse = $this->get("/api/books/{$book->id}/download");
        $downloadResponse->assertStatus(200);

        // Admin add new book
        $newBookResponse = $this->post('/admin/books', [
            'title' => 'Mobile UX Architecture 2026',
            'author' => 'Prof. Alex Vance',
            'category' => 'Engineering',
            'total_pages' => 240,
            'description' => 'Advanced patterns in reactive hybrid and native mobile app UI frameworks.',
        ]);
        $newBookResponse->assertRedirect('/admin?tab=library');

        // Admin add new post
        $newPostResponse = $this->post('/admin/posts', [
            'title' => 'Global Hackathon Registrations Open',
            'category' => 'EVENT',
            'author' => 'Student Affairs',
            'content' => 'Join the 48-hour student sprint with over $10,000 in total prizes.',
        ]);
        $newPostResponse->assertRedirect('/admin?tab=news');
    }

    /**
     * Test 18. New Features: Student Checkbox Enroll, Class Manage Roster, Class QR Restriction & 2 Sessions/Day
     */
    public function test_student_enrollment_lifecycle_and_qr_two_sessions(): void
    {
        // 1. New student registers
        $uniqueId = 'GZ_REG_' . time() . '_' . rand(100, 999);
        $studentEmail = 'newstudent.' . uniqid() . '@genzdigital.edu';
        DB::table('campus_students')->insert([
            'name' => 'Sophea Dara',
            'student_id' => $uniqueId,
            'email' => $studentEmail,
            'major' => 'Digital & AI',
            'gender' => 'Female',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250',
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Student is not yet enrolled in any class -> visible in pendingStudents in Students Manage
        $adminUsersPage = $this->get('/admin?tab=users');
        $adminUsersPage->assertStatus(200);
        $pendingStudents = $adminUsersPage->viewData('pendingStudents');
        $this->assertTrue($pendingStudents->contains('student_id', $uniqueId));

        // Find target class (e.g. DGT01 or first class)
        $targetClass = DB::table('campus_classes')->first();
        if (!$targetClass) {
            $targetClassId = DB::table('campus_classes')->insertGetId([
                'code' => 'DES302',
                'title' => 'UI/UX Design Systems',
                'prof' => 'Dr. Aris Thorne',
                'room' => 'Lab 402',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $targetClass = DB::table('campus_classes')->where('id', $targetClassId)->first();
        }

        // 2. Admin selects checkbox and performs batch enroll
        $batchEnrollResponse = $this->post('/admin/students/batch-assign-class', [
            'student_ids' => [$uniqueId],
            'class_id' => $targetClass->id,
        ]);
        $batchEnrollResponse->assertRedirect('/admin?tab=users');

        // 3. Once enrolled, the student NO LONGER appears in pendingStudents in Students Manage!
        $adminUsersPageAfter = $this->get('/admin?tab=users');
        $pendingAfter = $adminUsersPageAfter->viewData('pendingStudents');
        $this->assertFalse($pendingAfter->contains('student_id', $uniqueId));

        // 4. The student now APPEARS in Class Manage roster!
        $classDetailsResponse = $this->get("/admin/classes/{$targetClass->id}/details");
        $classDetailsResponse->assertStatus(200);
        $classStudents = collect($classDetailsResponse->json('students'));
        $this->assertTrue($classStudents->contains('student_id', $uniqueId));

        // 5. Test QR Code scanning with class restriction:
        // A student NOT in class MKT204 attempts to scan MKT204 -> rejected 403
        $unenrolledScan = $this->postJson('/api/attendance/check-in', [
            'code' => 'MKT204',
            'student_id' => $uniqueId,
            'student_name' => 'Sophea Dara',
        ]);
        $unenrolledScan->assertStatus(403);
        $unenrolledScan->assertJson(['success' => false, 'error_code' => 'NOT_ENROLLED_IN_CLASS']);

        // Clean any attendance for today to test 2-session workflow
        DB::table('campus_attendances')->where('student_id', $uniqueId)->delete();

        // Ensure target class has a valid, active QR code for testing check-in
        DB::table('campus_qr_codes')->where('class_code', $targetClass->code)->delete();
        $classQrId = DB::table('campus_qr_codes')->insertGetId([
            'title' => 'Class Session QR',
            'type' => 'Attendance',
            'class_code' => $targetClass->code,
            'session_name' => 'Session 1 (ព្រឹក)',
            'session_date' => date('Y-m-d'),
            'code_value' => 'GZ-QR-CLASS-' . $targetClass->code . '-' . uniqid(),
            'short_code' => '8492',
            'expires_at' => date('Y-m-d H:i:s', time() + 86400),
            'scans_count' => 0,
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 6. Enrolled student scans Session 1 (Morning) -> succeeds 200
        $session1Scan = $this->postJson('/api/attendance/check-in', [
            'code' => $targetClass->code,
            'student_id' => $uniqueId,
            'student_name' => 'Sophea Dara',
            'session_name' => 'Session 1 (ព្រឹក)',
        ]);
        $session1Scan->assertStatus(200);
        $session1Scan->assertJson(['success' => true]);
        $this->assertEquals('Session 1 (ព្រឹក)', $session1Scan->json('session_name'));

        // 7. Scanning Session 1 again on same day fails (422 ALREADY_SCANNED_SESSION)
        $dupScan = $this->postJson('/api/attendance/check-in', [
            'code' => $targetClass->code,
            'student_id' => $uniqueId,
            'student_name' => 'Sophea Dara',
            'session_name' => 'Session 1 (ព្រឹក)',
        ]);
        $dupScan->assertStatus(422);
        $dupScan->assertJson(['success' => false, 'error_code' => 'ALREADY_SCANNED_SESSION']);

        // 8. Scanning Session 2 (Afternoon) on same day succeeds 200 (2 sessions per day!)
        $session2Scan = $this->postJson('/api/attendance/check-in', [
            'code' => $targetClass->code,
            'student_id' => $uniqueId,
            'student_name' => 'Sophea Dara',
            'session_name' => 'Session 2 (រសៀល)',
        ]);
        $session2Scan->assertStatus(200);
        $session2Scan->assertJson(['success' => true]);
        $this->assertEquals('Session 2 (រសៀល)', $session2Scan->json('session_name'));

        // 9. Scanning Session 2 again fails (422)
        $dupSession2 = $this->postJson('/api/attendance/check-in', [
            'code' => $targetClass->code,
            'student_id' => $uniqueId,
            'student_name' => 'Sophea Dara',
            'session_name' => 'Session 2 (រសៀល)',
        ]);
        $dupSession2->assertStatus(422);

        // 10. Admin unassigns student from class -> removed from class and returns to pending!
        $unassignResponse = $this->post('/admin/students/unassign-class', [
            'student_id' => $uniqueId,
            'course_code' => $targetClass->code,
        ]);
        $unassignResponse->assertRedirect('/admin?tab=classes');

        $adminUsersPageUnassigned = $this->get('/admin?tab=users');
        $pendingReturned = $adminUsersPageUnassigned->viewData('pendingStudents');
        $this->assertTrue($pendingReturned->contains('student_id', $uniqueId));

        // Clean up temporary class QR
        DB::table('campus_qr_codes')->where('id', $classQrId)->delete();
    }

    /**
     * Test 21. Real-time Class Group Chat and Inbox Messaging
     */
    public function test_class_group_chat_and_inbox_messaging(): void
    {
        // 1. Visit campus index and verify inbox contains class group chats
        $user = \App\Models\User::first();
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => 'Maya Chen',
                'email' => 'maya.' . uniqid() . '@genzdigital.edu',
                'password' => bcrypt('password'),
                'student_id' => 'GZ20260482',
                'role' => 'student',
            ]);
        }

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertSee('Inbox & Messages', false);
        $response->assertSee('Class Group', false);
        $response->assertSee('chatModal', false);

        $chats = $response->viewData('chats');
        $this->assertNotEmpty($chats);

        // Find a class room
        $classRoom = collect($chats)->first(function ($c) {
            return $c['category'] === 'academic';
        });
        $this->assertNotNull($classRoom);
        $roomId = $classRoom['room_id'];

        // 2. Fetch messages for that room
        $fetchRes = $this->actingAs($user)->getJson("/api/inbox/messages?room={$roomId}");
        $fetchRes->assertStatus(200);
        $fetchRes->assertJson([
            'success' => true,
            'room_id' => $roomId,
        ]);
        $this->assertNotEmpty($fetchRes->json('messages'));

        // 3. Send a message to the class group chat
        $testMsg = 'Hello classmates! This is a test group message ' . uniqid();
        $sendRes = $this->actingAs($user)->postJson('/api/inbox/send', [
            'room_id' => $roomId,
            'message' => $testMsg,
        ]);
        $sendRes->assertStatus(200);
        $sendRes->assertJson([
            'success' => true,
            'message' => 'Message sent successfully',
            'data' => [
                'room_id' => $roomId,
                'message' => $testMsg,
            ],
        ]);

        // 4. Verify message persisted in database and appears in room messages
        $exists = DB::table('campus_inbox_messages')
            ->where('room_id', $roomId)
            ->where('message', $testMsg)
            ->exists();
        $this->assertTrue($exists);

        $reFetch = $this->actingAs($user)->getJson("/api/inbox/messages?room={$roomId}");
        $reFetch->assertStatus(200);
        $found = collect($reFetch->json('messages'))->contains('message', $testMsg);
        $this->assertTrue($found);

        // 5. Empty message validation
        $emptyRes = $this->actingAs($user)->postJson('/api/inbox/send', [
            'room_id' => $roomId,
            'message' => '   ',
        ]);
        $emptyRes->assertStatus(422);

        while (ob_get_level() > 1) {
            ob_end_flush();
        }
    }

    /**
     * Test 22. Score Screen Displays Course Grades, All Exam Results, and Challenge Arena
     */
    public function test_score_screen_displays_course_grades_exam_results_and_challenges(): void
    {
        $user = \App\Models\User::where('role', 'student')->first();
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => 'Maya Chen',
                'email' => 'maya.score.' . uniqid() . '@genzdigital.edu',
                'password' => bcrypt('password'),
                'student_id' => 'GZ20260482',
                'role' => 'student',
            ]);
        }

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);

        // Score header & KPI
        $response->assertSee('Academic Score & Official Transcript', false);
        $response->assertSee('GPA 3.88', false);
        $response->assertSee('score-filter-pills', false);

        // Section 1: Course Grades
        $response->assertSee('score-sec-grades', false);
        $response->assertSee('Course Grade Breakdown', false);

        // Section 2: All Exam Results
        $response->assertSee('score-sec-exams', false);
        $response->assertSee('លទ្ធផលប្រឡងទាំងអស់', false);

        // Section 3: Challenge Arena
        $response->assertSee('score-sec-challenges', false);
        $response->assertSee('លទ្ធផលប្រកួតប្រជែង Challenges', false);

        while (ob_get_level() > 1) {
            ob_end_flush();
        }
    }

    /**
     * Test 23. Homework Feature: Admin Topic Creation, Student Typing Text Answer,
     * Submission Timestamp, Deadline Enforcement, and Admin Scoring
     */
    public function test_homework_management_submission_deadline_and_grading(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first();
        if (!$admin) {
            $admin = \App\Models\User::create([
                'name' => 'Campus Admin',
                'email' => 'admin.hw.' . uniqid() . '@genzdigital.edu',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        $student = \App\Models\User::where('role', 'student')->first();
        if (!$student) {
            $student = \App\Models\User::create([
                'name' => 'Chhai Mengly',
                'email' => 'mengly.hw.' . uniqid() . '@genzdigital.edu',
                'password' => bcrypt('password'),
                'student_id' => 'GZ-2026-081',
                'role' => 'student',
            ]);
        }

        // 1. Admin creates new Homework Topic with start date and deadline
        $hwTitle = 'Mobile UX & Spring Physics Research ' . uniqid();
        $deadlineFuture = \Carbon\Carbon::now('Asia/Phnom_Penh')->addDays(5)->format('Y-m-d\TH:i');
        $createResponse = $this->actingAs($admin)->post('/admin/homework', [
            'title' => $hwTitle,
            'subject' => 'UI/UX Design',
            'class_code' => 'CS101',
            'max_score' => 100,
            'start_date' => \Carbon\Carbon::now('Asia/Phnom_Penh')->subHour()->format('Y-m-d\TH:i'),
            'deadline' => $deadlineFuture,
            'questions' => "1. What are spring physics in micro-interactions?\n2. Provide examples of 60fps animations.",
        ]);
        $createResponse->assertRedirect('/admin?tab=homework');

        $homework = DB::table('campus_homeworks')->where('title', $hwTitle)->first();
        $this->assertNotNull($homework);

        // 2. Student views Homework screen on Campus Portal
        $studentPortalResponse = $this->actingAs($student)->get('/');
        $studentPortalResponse->assertStatus(200);
        $studentPortalResponse->assertSee($hwTitle);
        $studentPortalResponse->assertSee('id="screen-homework"', false);
        $studentPortalResponse->assertSee('id="screen-news"', false);

        // 3. Student submits typed text answer
        $answerText = "1. Spring physics use damped harmonic oscillator models.\n2. iOS swipe to dismiss and bouncy sheet modal.";
        $submitResponse = $this->actingAs($student)->postJson("/api/homework/{$homework->id}/submit", [
            'answer_text' => $answerText,
        ]);
        $submitResponse->assertStatus(200);
        $submitResponse->assertJson(['success' => true]);
        $this->assertNotNull($submitResponse->json('submitted_at'));

        // Verify in database that submission has timestamp
        $sub = DB::table('campus_homework_submissions')
            ->where('homework_id', $homework->id)
            ->where('student_id', $student->student_id)
            ->first();
        $this->assertNotNull($sub);
        $this->assertEquals($answerText, $sub->answer_text);
        $this->assertNotNull($sub->submitted_at);

        // 4. Test Deadline Enforcement: past deadline cannot submit
        $expiredHwId = DB::table('campus_homeworks')->insertGetId([
            'title' => 'Expired Homework Topic',
            'subject' => 'History of Web',
            'questions' => 'Who created WWW?',
            'start_date' => \Carbon\Carbon::now('Asia/Phnom_Penh')->subDays(10),
            'deadline' => \Carbon\Carbon::now('Asia/Phnom_Penh')->subDay(), // Expired yesterday
            'max_score' => 100,
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $expiredSubmitResponse = $this->actingAs($student)->postJson("/api/homework/{$expiredHwId}/submit", [
            'answer_text' => 'Tim Berners-Lee',
        ]);
        $expiredSubmitResponse->assertStatus(422);
        $expiredSubmitResponse->assertJson(['success' => false]);
        $this->assertStringContainsString('ហួសកាលបរិច្ឆេទផុតកំណត់', $expiredSubmitResponse->json('message'));

        // 5. Admin grades student's submission and inputs score
        $gradeResponse = $this->actingAs($admin)->postJson("/admin/homework/submissions/{$sub->id}/score", [
            'score' => 95,
            'feedback' => 'Excellent understanding of animation physics!',
        ]);
        $gradeResponse->assertStatus(200);
        $gradeResponse->assertJson([
            'success' => true,
            'score' => 95,
            'status' => 'Graded',
        ]);

        // 6. Student visits portal and sees their graded score
        $studentGradedResponse = $this->actingAs($student)->get('/');
        $studentGradedResponse->assertStatus(200);
        $studentGradedResponse->assertSee('95');
        $studentGradedResponse->assertSee('Graded');
        $studentGradedResponse->assertSee('Excellent understanding of animation physics!');

        while (ob_get_level() > 1) {
            ob_end_flush();
        }
    }

    /**
     * Test 24. Classmates Roster Feature: Real Enrolled Students, Profile Modal, Search & Chat
     */
    public function test_classmates_roster_feature_and_interaction(): void
    {
        $user = \App\Models\User::where('role', 'student')->first();
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => 'Maya Chen',
                'email' => 'maya.roster.' . uniqid() . '@genzdigital.edu',
                'password' => bcrypt('password'),
                'student_id' => 'GZ20260482',
                'role' => 'student',
            ]);
        }

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);

        // Check Classmates Roster heading and elements
        $response->assertSee('មិត្តរួមថ្នាក់ (Classmates Roster)');
        $response->assertSee('id="classmate-search-input"', false);
        $response->assertSee('id="classmate-class-select"', false);
        $response->assertSee('openClassmateModal', false);
        $response->assertSee('id="classmateDetailModal"', false);
        $response->assertSee('id="cm-btn-chat"', false);
        $response->assertSee('id="cm-btn-spotlight"', false);

        while (ob_get_level() > 1) {
            ob_end_flush();
        }
    }

    /**
     * Test 25. Exam Visibility Restricted: Student sees ONLY exams for Admin-enrolled classes
     */
    public function test_student_sees_only_exams_for_admin_enrolled_class_and_not_other_classes(): void
    {
        $uniqueStudentId = 'GZ_EXAM_' . uniqid();
        $studentUser = \App\Models\User::create([
            'name' => 'Kosal Vuthy',
            'email' => 'kosal.exam.' . uniqid() . '@genzdigital.edu',
            'password' => bcrypt('password'),
            'student_id' => $uniqueStudentId,
            'role' => 'student',
            'status' => 'Active',
        ]);

        DB::table('campus_students')->insert([
            'name' => 'Kosal Vuthy',
            'student_id' => $uniqueStudentId,
            'email' => $studentUser->email,
            'major' => 'Digital Tech',
            'gender' => 'Male',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250',
            'attendance_rate' => '95%',
            'valid_until' => '08/2028',
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $enrolledClassCode = 'DGT01_' . uniqid();
        $otherClassCode = 'DGT02_' . uniqid();

        // 1. Admin enrolls this student into DGT01 only
        DB::table('campus_course_carts')->insert([
            'student_id' => $uniqueStudentId,
            'course_code' => $enrolledClassCode,
            'course_title' => 'Digital AI Class 01',
            'instructor' => 'Dr. Sok',
            'credits' => 3,
            'schedule' => 'Mon 09:00 AM',
            'status' => 'Enrolled',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Create Exam A for enrolled class
        $examAId = DB::table('campus_exams')->insertGetId([
            'title' => 'DGITAI-GEN0 (' . $enrolledClassCode . ')',
            'course' => $enrolledClassCode,
            'class_code' => $enrolledClassCode,
            'exam_date' => date('M d, Y • h:i A'),
            'room' => 'G9-01',
            'type' => 'Test exam',
            'category' => 'Test exam',
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Create Exam B for another class that student is NOT enrolled in
        $examBId = DB::table('campus_exams')->insertGetId([
            'title' => 'DGTAI02 (' . $otherClassCode . ')',
            'course' => $otherClassCode,
            'class_code' => $otherClassCode,
            'exam_date' => date('M d, Y • h:i A'),
            'room' => 'G7-05',
            'type' => 'Test exam',
            'category' => 'Test exam',
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Student views exam screen: Must see Exam A, must NOT see Exam B
        $response = $this->actingAs($studentUser)->get('/');
        $response->assertStatus(200);
        $response->assertSee('DGITAI-GEN0 (' . $enrolledClassCode . ')');
        $response->assertDontSee('DGTAI02 (' . $otherClassCode . ')');

        // 5. Student cannot access questions API for unenrolled Exam B (403)
        $unenrolledQuestions = $this->actingAs($studentUser)->getJson("/api/exams/{$examBId}/questions");
        $unenrolledQuestions->assertStatus(403);
        $unenrolledQuestions->assertJson(['success' => false]);

        // 6. Student can access questions API for enrolled Exam A (200)
        $enrolledQuestions = $this->actingAs($studentUser)->getJson("/api/exams/{$examAId}/questions");
        $enrolledQuestions->assertStatus(200);

        // 7. Student cannot submit exam for unenrolled Exam B (403)
        $unenrolledSubmit = $this->actingAs($studentUser)->postJson("/api/exams/{$examBId}/submit", [
            'answers' => [1 => 'A'],
        ]);
        $unenrolledSubmit->assertStatus(403);
        $unenrolledSubmit->assertJson(['success' => false]);

        // Clean up test records
        DB::table('campus_exams')->whereIn('id', [$examAId, $examBId])->delete();
        DB::table('campus_course_carts')->where('student_id', $uniqueStudentId)->delete();
        DB::table('campus_students')->where('student_id', $uniqueStudentId)->delete();
        $studentUser->delete();

        while (ob_get_level() > 1) {
            ob_end_flush();
        }
    }
}
