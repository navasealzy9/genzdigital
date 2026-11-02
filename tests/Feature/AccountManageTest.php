<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountManageTest extends TestCase
{
    use RefreshDatabase;

    private function account(string $role): array
    {
        return ['name' => 'New '.ucfirst($role), 'username' => 'new.'.$role, 'role' => $role,
            'password' => 'secure-password', 'password_confirmation' => 'secure-password'];
    }

    public function test_admin_can_create_both_account_types_and_they_can_login(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'Active']);
        foreach (['student', 'admin'] as $role) {
            $this->actingAs($admin)->get('/admin/accounts')->assertOk()->assertSee('Account Manage')->assertSee('name="role"', false);
            $this->post('/admin/accounts', $this->account($role))->assertSessionHasNoErrors()->assertRedirect('/admin/accounts');
            $user = User::where('username', 'new.'.$role)->firstOrFail();
            $this->assertSame($role, $user->role);
            $this->assertSame('Active', $user->status);
            $this->assertTrue(Hash::check('secure-password', $user->password));
            if ($role === 'student') {
                $this->assertNotEmpty($user->student_id);
            }
            $this->post('/logout');
            $this->post('/login', ['login' => $user->username, 'password' => 'secure-password'])
                ->assertRedirect($role === 'admin' ? '/admin' : '/');
            $this->assertAuthenticatedAs($user);
            $this->post('/logout');
        }
    }

    public function test_guests_students_and_public_registration_cannot_create_admins(): void
    {
        $this->get('/admin/accounts')->assertRedirect('/login');
        $this->post('/admin/accounts', $this->account('admin'))->assertRedirect('/login');
        $student = User::factory()->create(['role' => 'student', 'status' => 'Active']);
        $this->actingAs($student)->get('/admin/accounts')->assertForbidden();
        $this->post('/admin/accounts', $this->account('admin'))->assertForbidden();
        $this->post('/logout');
        $this->post('/register', $this->account('admin'))->assertSessionHasErrors('role');
        $this->assertDatabaseMissing('users', ['username' => 'new.admin']);
    }

    public function test_account_creation_validates_roles_passwords_and_duplicate_identity(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'Active', 'username' => 'existing.admin']);
        $this->actingAs($admin)->post('/admin/accounts', $this->account('owner'))->assertSessionHasErrors('role');
        $this->post('/admin/accounts', array_replace($this->account('admin'), ['password_confirmation' => 'wrong']))->assertSessionHasErrors('password');
        $this->post('/admin/accounts', array_replace($this->account('admin'), ['username' => 'EXISTING.ADMIN']))->assertSessionHasErrors('username');
        $this->post('/admin/accounts', array_replace($this->account('admin'), ['student_id' => 'existing.admin']))->assertSessionHasErrors('student_id');
        $this->assertDatabaseCount('users', 1);
    }

    public function test_accounts_can_be_filtered_by_role_and_searched(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'Active', 'name' => 'Existing Administrator']);
        User::factory()->create(['role' => 'student', 'status' => 'Active', 'name' => 'Searchable Student']);
        $this->actingAs($admin)->get('/admin/accounts?role=admin')->assertOk()->assertSee('Existing Administrator')->assertDontSee('Searchable Student');
        $this->get('/admin/accounts?q=Searchable')->assertOk()->assertSee('Searchable Student')
            ->assertViewHas('accounts', fn ($accounts) => $accounts->total() === 1 && $accounts->first()->role === 'student');
    }
}
