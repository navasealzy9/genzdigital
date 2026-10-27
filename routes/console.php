<?php

use App\Models\User;
use App\Services\Gen5Game;
use App\Services\QuizGrader;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

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

Artisan::command('learning:admin {email}', function () {
    $email = $this->argument('email');
    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->error('A valid email is required.');

        return 1;
    }
    if (User::where('email', $email)->exists()) {
        $this->error('This email already has an account. Existing accounts are not modified by this command.');

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
    User::create(['name' => $name, 'email' => $email, 'password' => $password, 'role' => 'admin', 'status' => 'Active']);
    $this->info('Administrator created.');

    return 0;
})->purpose('Create an administrator interactively without a default password');
