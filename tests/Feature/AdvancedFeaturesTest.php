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
        $newStudentId = 'GZ_TEST_' . rand(1000, 9999);
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

        // 2. Find an active QR code with short code
        $qr = DB::table('campus_qr_codes')->where('status', 'Active')->first();
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
     * Test 15. Exam QCM Scoring: >=50% Pass (Color Green) & <50% Fail (Color Red)
     */
    public function test_client_exam_qcm_green_pass_and_red_fail_scoring(): void
    {
        $exam = DB::table('campus_exams')->first();
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
    }
}
