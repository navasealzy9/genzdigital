<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $initialLevel = ob_get_level();
        // 1. Guest visits home: Sees Guest Welcome Portal, NO Profile Card, NO Tools
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Campus OS v26.0');
        $response->assertSee('Welcome to');
        $response->assertSee('Sign In to Student Pass');
        $response->assertSee('Register New Account');
        $response->assertDontSee('Campus Tools & Services');
        $response->assertDontSee('GENZ DIGITAL STUDENT PASS');

        // 2. Admin Console access
        $adminResponse = $this->get('/admin');
        $adminResponse->assertStatus(200);
        $adminResponse->assertSee('Admin Console');
        $adminResponse->assertSee('Manage User');
        $adminResponse->assertSee('Show User on Screen');
        $adminResponse->assertSee('Game Random');

        // 3. Auth Pages
        $loginPage = $this->get('/login');
        $loginPage->assertStatus(200);
        $loginPage->assertSee('Sign In to Campus');

        $registerPage = $this->get('/register');
        $registerPage->assertStatus(200);
        $registerPage->assertSee('Create Your Campus Account');

        // 4. Test Student Login as Maya Chen (Enrolled Student): All features unlocked!
        $studentLogin = $this->post('/login', [
            'email' => 'maya.chen@genzdigital.edu',
            'password' => 'password',
        ]);
        $studentLogin->assertRedirect('/');

        $enrolledResponse = $this->get('/');
        $enrolledResponse->assertStatus(200);
        $enrolledResponse->assertSee('Maya Chen');
        $enrolledResponse->assertSee('GZ20260482');
        $enrolledResponse->assertSee('tools-container', false);
        $enrolledResponse->assertSee('Class Cart');
        $enrolledResponse->assertSee('GPA 3.88');
        $enrolledResponse->assertSee('UI/UX Design Systems');
        $enrolledResponse->assertSee('id="screen-classCart"', false);
        $enrolledResponse->assertSee('id="screen-score"', false);
        $enrolledResponse->assertSee('id="screen-resource"', false);
        $enrolledResponse->assertSee('id="screen-scan"', false);
        $enrolledResponse->assertSee('id="screen-exam"', false);
        $enrolledResponse->assertSee('id="screen-certificates"', false);
        $enrolledResponse->assertSee('id="screen-showscreen"', false);
        $enrolledResponse->assertSee('id="screen-collab"', false);
        $enrolledResponse->assertSee('id="screen-challenge"', false);
        $enrolledResponse->assertSee('id="screen-attendance"', false);
        $enrolledResponse->assertSee('id="screen-library"', false);
        $enrolledResponse->assertSee('id="screen-news"', false);
        $enrolledResponse->assertSee('id="screen-qrpass"', false);

        // Logout Maya Chen
        $this->get('/logout');

        // 5. Test Admin Login
        $adminLogin = $this->post('/login', [
            'email' => 'admin@genzdigital.edu',
            'password' => 'password',
        ]);
        $adminLogin->assertRedirect('/admin');

        // Logout Admin
        $this->get('/logout');

        // Test New Student Registration: Features Locked until Admin assigns a class
        $randomEmail = 'test_student_' . uniqid() . '@genzdigital.edu';
        $randomStudentId = 'GZ' . rand(100000, 999999);

        $newRegister = $this->post('/register', [
            'name' => 'Rathana Tech',
            'email' => $randomEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'student',
            'student_id' => $randomStudentId,
            'major' => 'Software Engineering',
            'gender' => 'Male',
        ]);
        $newRegister->assertRedirect('/');

        // Student visits dashboard: Only Profile Card & Pending Assignment should show, Tools should be hidden!
        $dashboardResponse = $this->get('/');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Rathana Tech');
        $dashboardResponse->assertSee('Pending Class Assignment');
        $dashboardResponse->assertDontSee('tools-container');

        // Admin assigns Rathana to a class
        $class = \Illuminate\Support\Facades\DB::table('campus_classes')->first();
        $assignResponse = $this->post('/admin/students/assign-class', [
            'student_id' => $randomStudentId,
            'class_id' => $class->id,
        ]);
        $assignResponse->assertRedirect('/admin?tab=users');

        // Student visits dashboard again: Tools & Services are now UNLOCKED!
        $unlockedDashboard = $this->get('/');
        $unlockedDashboard->assertStatus(200);
        $unlockedDashboard->assertSee('tools-container', false);
        $unlockedDashboard->assertSee('Class Cart');

        // Test Avatar Upload & Crop API
        $tinyJpegBase64 = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////wgALCAABAAEBAREA/8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPxA=';
        $avatarUploadResponse = $this->postJson('/profile/avatar', [
            'avatar_data' => $tinyJpegBase64,
        ]);
        $avatarUploadResponse->assertStatus(200);
        $avatarUploadResponse->assertJson(['success' => true]);
        $avatarUploadResponse->assertJsonStructure(['success', 'avatar_url', 'message']);

        // 6. Test Admin Report Export (CSV)
        $csvResponse = $this->get('/admin/reports/export');
        $csvResponse->assertStatus(200);
        $this->assertEquals('text/csv; charset=UTF-8', $csvResponse->headers->get('Content-Type'));

        // 7. Test Admin QR Code Activate
        $qrCode = \Illuminate\Support\Facades\DB::table('campus_qr_codes')->first();
        if ($qrCode) {
            $qrActivateResponse = $this->postJson("/admin/qr-codes/{$qrCode->id}/activate");
            $qrActivateResponse->assertStatus(200);
            $qrActivateResponse->assertJson(['success' => true]);
        }

        // 8. Test Client Attendance Check-in API
        \Illuminate\Support\Facades\DB::table('campus_attendances')->where('student_id', 'GZ20260482')->delete();
        $checkInResponse = $this->postJson('/api/attendance/check-in', [
            'subject' => 'UI/UX Design Systems',
            'code' => 'DES302',
            'student_name' => 'Maya Chen',
            'student_id' => 'GZ20260482',
        ]);
        $checkInResponse->assertStatus(200);
        $checkInResponse->assertJson(['success' => true]);

        // 9. Test Client Course Enrollment & Drop in Class Cart
        $cartEnrollResponse = $this->postJson('/api/cart/enroll', [
            'course_code' => 'DES302',
            'course_title' => 'UI/UX Design Systems',
        ]);
        $cartEnrollResponse->assertStatus(200);
        $cartEnrollResponse->assertJson(['success' => true]);

        $cartDropResponse = $this->postJson('/api/cart/drop', [
            'course_code' => 'DES302',
        ]);
        $cartDropResponse->assertStatus(200);
        $cartDropResponse->assertJson(['success' => true]);

        // 10. Test Client Collaboration Join
        $collab = \Illuminate\Support\Facades\DB::table('campus_collaborations')->first();
        if ($collab) {
            \Illuminate\Support\Facades\DB::table('campus_collaborations')->where('id', $collab->id)->update([
                'current_members' => 1,
                'max_members' => 5,
                'status' => 'Open',
            ]);
            $collabResponse = $this->postJson("/api/collaborations/{$collab->id}/join");
            $collabResponse->assertStatus(200);
            $collabResponse->assertJson(['success' => true]);
        }

        // 11. Test Client Challenge Join
        $challenge = \Illuminate\Support\Facades\DB::table('campus_challenges')->first();
        if ($challenge) {
            $challengeResponse = $this->postJson("/api/challenges/{$challenge->id}/join");
            $challengeResponse->assertStatus(200);
            $challengeResponse->assertJson(['success' => true]);
        }

        // 12. Test Client Resource Download
        $resource = \Illuminate\Support\Facades\DB::table('campus_resources')->first();
        if ($resource) {
            $resourceResponse = $this->get("/api/resources/{$resource->id}/download");
            $resourceResponse->assertStatus(200);
            $resourceResponse->assertSee('GENZ DIGITAL CAMPUS RESOURCE FILE');
        }

        // 13. Test Client Transcript Download
        $transcriptResponse = $this->get('/transcript/download');
        $transcriptResponse->assertStatus(200);
        $transcriptResponse->assertSee('GENZ DIGITAL ACADEMIC TRANSCRIPT');

        // 14. Test Client Screen Spotlight Request
        $screenReqResponse = $this->postJson('/api/screenshare/request');
        $screenReqResponse->assertStatus(200);
        $screenReqResponse->assertJson(['success' => true]);

        while (ob_get_level() > $initialLevel) {
            ob_end_clean();
        }
    }
}
