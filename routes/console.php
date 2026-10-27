<?php

use App\Models\User;
use App\Services\AccountIdentity;
use App\Services\Gen5Game;
use App\Services\QuizGrader;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Validation\ValidationException;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('learning:expire-attempts', function () {
    app(QuizGrader::class)->expire();
    $this->info('Expired attempts graded from their saved answers.');
})->purpose('Finalize expired learning assessments');

Schedule::command('learning:expire-attempts')->everyMinute()->withoutOverlapping();

Artisan::command('gen5:finish-expired', function () {
    app(Gen5Game::class)->expire();
    $this->info('GEN5 expired matches finalized.');
})->purpose('Finalize GEN5 matches at their server deadline');
Schedule::command('gen5:finish-expired')->everyMinute()->withoutOverlapping();

Artisan::command('learning:status', function () {
    $this->table(['Record type', 'Count'], [
        ['Active administrators', User::where('role', 'admin')->where('status', 'Active')->count()],
        ['Student accounts', User::where('role', 'student')->count()],
        ['Draft courses', DB::table('learning_courses')->where('status', 'draft')->count()],
        ['Published courses', DB::table('learning_courses')->where('status', 'published')->count()],
        ['Enrollments', DB::table('learning_enrollments')->count()],
    ]);
})->purpose('Check learning platform data without exposing personal information');

Artisan::command('learning:admin {username}', function () {
    $username = mb_strtolower(trim($this->argument('username')));
    if (! preg_match('/\A[a-z0-9][a-z0-9_.-]{2,99}\z/', $username)) {
        $this->error('Use 3–100 letters, digits, dots, underscores or hyphens for the username.');

        return 1;
    }
    if (User::whereRaw('LOWER(username) = ?', [$username])->orWhereRaw('LOWER(student_id) = ?', [$username])->exists()) {
        $this->error('This username or student ID already has an account. Existing accounts are not modified.');

        return 1;
    }
    $name = $this->ask('Administrator name');
    $password = $this->secret('Password (at least 12 characters)');
    if (! $name || ! $password || strlen($password) < 12) {
        $this->error('Name and a password of at least 12 characters are required.');

        return 1;
    }
    if ($password !== $this->secret('Confirm password')) {
        $this->error('Passwords do not match.');

        return 1;
    }
    try {
        app(AccountIdentity::class)->create(['name' => $name, 'username' => $username, 'password' => $password, 'password_confirmation' => $password], 'admin');
    } catch (ValidationException $exception) {
        $this->error(implode(' ', $exception->validator->errors()->all()));

        return 1;
    }
    $this->info('Administrator created. Sign in with username: '.$username);

    return 0;
})->purpose('Create an administrator interactively without a default password');

Artisan::command('learning:accounts {--admins : Show only administrator accounts}', function () {
    $query = User::query()->orderBy('id');
    if ($this->option('admins')) {
        $query->where('role', 'admin');
    }
    $this->table(['Name', 'Username', 'Student ID', 'Role'], $query->get()->map(fn ($user) => [$user->name, $user->username, $user->student_id ?: '—', $user->role])->all());
})->purpose('Look up account login identifiers without exposing passwords');
