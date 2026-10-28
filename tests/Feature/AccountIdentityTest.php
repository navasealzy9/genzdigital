<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountIdentityTest extends TestCase
{
    use RefreshDatabase;

    private function registration(array $extra = []): array
    {
        return $extra + ['name' => 'Sok Dara', 'username' => 'sok.dara', 'password' => 'strong-password', 'password_confirmation' => 'strong-password'];
    }

    public function test_classes_publish_automatically_and_existing_drafts_are_published(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'Active']);
        $this->actingAs($admin)->post('/admin/courses', ['title' => 'Automatic class', 'code' => 'AUTO', 'instructor' => 'Teacher'])->assertSessionHasNoErrors()->assertRedirect();
        $this->assertDatabaseHas('learning_courses', ['code' => 'AUTO', 'status' => 'published']);
        $course = DB::table('learning_courses')->where('code', 'AUTO')->value('id');
        $this->put('/admin/courses/'.$course, ['title' => 'Automatic class', 'code' => 'AUTO', 'instructor' => 'Teacher', 'status' => 'draft'])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('learning_courses', ['id' => $course, 'status' => 'published']);
        DB::table('learning_courses')->where('id', $course)->update(['status' => 'draft']);
        $migration = require database_path('migrations/2026_10_28_100000_publish_existing_draft_classes.php');
        $migration->up();
        $this->assertDatabaseHas('learning_courses', ['id' => $course, 'status' => 'published']);
    }

    public function test_registered_student_can_login_after_admin_waiting_list_enrollment(): void
    {
        $this->post('/register', $this->registration(['student_id' => 'FLOW-001']))->assertRedirect('/');
        $student = User::where('username', 'sok.dara')->firstOrFail();
        $this->post('/logout');
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'Active']);
        $course = DB::table('learning_courses')->insertGetId(['title' => 'Enrolled class', 'code' => 'FLOW-CLASS', 'instructor' => 'Teacher', 'status' => 'published', 'self_enrollment' => false, 'created_at' => now(), 'updated_at' => now()]);
        $this->actingAs($admin)->post('/admin/waiting-list/enroll', ['course_id' => $course, 'students' => [$student->id]])->assertSessionHasNoErrors()->assertRedirect();
        $this->post('/logout');
        foreach (['sok.dara', 'FLOW-001'] as $identifier) {
            $this->post('/login', ['login' => $identifier, 'password' => 'strong-password', 'remember' => 'on'])->assertSessionHasNoErrors()->assertRedirect('/');
            $this->assertAuthenticatedAs($student);
            $this->get('/')->assertOk()->assertSee('Enrolled class');
            $this->get('/courses/'.$course)->assertOk();
            $this->post('/logout');
        }
    }

    public function test_register_without_email_and_login_by_username_or_student_id(): void
    {
        $this->post('/register', $this->registration(['username' => 'Sok.Dara', 'student_id' => 'GZ2026999']))->assertRedirect('/');
        $user = User::where('username', 'sok.dara')->firstOrFail();
        $this->assertNull($user->email);
        $this->assertTrue(Hash::check('strong-password', $user->password));
        $this->post('/logout');
        $this->post('/login', ['login' => 'SOK.DARA', 'password' => 'strong-password'])->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
        $this->post('/logout');
        $this->post('/login', ['login' => 'gz2026999', 'password' => 'strong-password'])->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_registration_with_only_student_id_creates_a_usable_username(): void
    {
        $this->post('/register', $this->registration(['username' => '', 'student_id' => 'GZ2026007']))->assertRedirect('/');
        $this->assertDatabaseHas('users', ['username' => 'gz2026007', 'student_id' => 'GZ2026007', 'email' => null]);
    }

    public function test_missing_identity_and_email_as_username_are_rejected(): void
    {
        $this->post('/register', $this->registration(['username' => '']))->assertSessionHasErrors('username');
        $this->post('/register', $this->registration(['username' => 'name@gmail.com']))->assertSessionHasErrors('username');
        $this->get('/login')->assertSee('name="login"', false)->assertDontSee('name="email"', false);
        $this->get('/register')->assertDontSee('name="email"', false);
    }

    public function test_existing_ids_and_usernames_are_reserved_case_insensitively_across_both_fields(): void
    {
        User::factory()->create(['username' => 'existing.name', 'student_id' => 'GZ2026001']);
        foreach (['EXISTING.NAME', 'gz2026001'] as $identifier) {
            $this->post('/register', $this->registration(['username' => $identifier]))->assertSessionHasErrors('username');
            $this->post('/register', $this->registration(['student_id' => $identifier]))->assertSessionHasErrors('student_id');
        }
        $this->assertDatabaseCount('users', 1);
    }

    public function test_email_login_is_not_accepted_and_inactive_or_ambiguous_ids_cannot_sign_in(): void
    {
        $a = User::factory()->create(['username' => 'one.user', 'student_id' => 'DUP123', 'role' => 'student', 'status' => 'Active']);
        User::factory()->create(['username' => 'two.user', 'student_id' => 'DUP123', 'role' => 'student', 'status' => 'Active']);
        $this->post('/login', ['login' => $a->email, 'password' => 'password'])->assertSessionHasErrors('login');
        $this->post('/login', ['login' => 'DUP123', 'password' => 'password'])->assertSessionHasErrors('login');
        $this->assertGuest();
        $a->update(['status' => 'Inactive']);
        $this->post('/login', ['login' => $a->username, 'password' => 'password'])->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_old_accounts_receive_distinct_usernames_while_passwords_and_student_ids_are_preserved(): void
    {
        $migration = require database_path('migrations/2026_10_27_120000_add_username_login_to_users.php');
        $migration->down();
        $hash = Hash::make('old-password');
        DB::table('users')->insert([
            ['name' => 'Admin', 'email' => 'admin@example.test', 'password' => $hash, 'role' => 'admin', 'status' => 'Active', 'student_id' => null],
            ['name' => 'First', 'email' => 'first@example.test', 'password' => $hash, 'role' => 'student', 'status' => 'Active', 'student_id' => 'GZ123'],
            ['name' => 'Duplicate', 'email' => 'admin@other.test', 'password' => $hash, 'role' => 'student', 'status' => 'Active', 'student_id' => null],
        ]);
        $migration->up();
        $this->assertDatabaseHas('users', ['username' => 'admin', 'email' => 'admin@example.test', 'password' => $hash]);
        $this->assertDatabaseHas('users', ['username' => 'gz123', 'student_id' => 'GZ123', 'password' => $hash]);
        $this->assertSame(3, DB::table('users')->distinct()->count('username'));
        $this->post('/login', ['login' => 'admin', 'password' => 'old-password'])->assertRedirect('/admin');
        $this->post('/logout');
        $this->post('/login', ['login' => 'GZ123', 'password' => 'old-password'])->assertRedirect('/');
    }
}
