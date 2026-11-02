<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_reset_requires_a_new_password_before_access_and_temporary_password_stops_working(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'Active']);
        $student = User::factory()->create(['role' => 'student', 'status' => 'Active', 'username' => 'reset.student']);
        $this->actingAs($admin)->post(route('admin.students.password', $student))
            ->assertRedirect('/admin?section=students')->assertSessionHas('temporary_password');
        $temporary = session('temporary_password');
        $this->assertTrue(Hash::check($temporary, $student->fresh()->password));
        $this->assertTrue($student->fresh()->must_change_password);
        $this->get('/admin?section=students')->assertOk()->assertSee($temporary)->assertSee('Change Password');
        $this->post('/logout');
        $this->post('/login', ['login' => 'reset.student', 'password' => 'password'])->assertSessionHasErrors('login');
        $this->post('/login', ['login' => 'reset.student', 'password' => $temporary])->assertRedirect('/create-new-password');
        $this->get('/')->assertRedirect('/create-new-password');
        $this->get('/profile')->assertRedirect('/create-new-password');
        $this->get('/create-new-password')->assertOk()->assertSee('Create New Password');
        $this->post('/create-new-password', ['password' => $temporary, 'password_confirmation' => $temporary])->assertSessionHasErrors('password');
        $this->post('/create-new-password', ['password' => 'new-secure-password', 'password_confirmation' => 'mismatch'])->assertSessionHasErrors('password');
        $this->post('/create-new-password', ['password' => 'new-secure-password', 'password_confirmation' => 'new-secure-password'])->assertRedirect('/');
        $this->assertFalse($student->fresh()->must_change_password);
        $this->get('/')->assertOk();
        $this->post('/logout');
        $this->post('/login', ['login' => 'reset.student', 'password' => $temporary])->assertSessionHasErrors('login');
        $this->post('/login', ['login' => 'reset.student', 'password' => 'new-secure-password'])->assertRedirect('/');
    }

    public function test_students_and_guests_cannot_reset_passwords_and_admin_accounts_cannot_be_targeted(): void
    {
        $student = User::factory()->create(['role' => 'student', 'status' => 'Active']);
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'Active']);
        $this->post(route('admin.students.password', $student))->assertRedirect('/login');
        $this->get('/create-new-password')->assertRedirect('/login');
        $this->actingAs($student)->post(route('admin.students.password', $student))->assertForbidden();
        $this->actingAs($admin)->post(route('admin.students.password', $admin))->assertNotFound();
        $this->assertFalse($student->fresh()->must_change_password);
    }
}
