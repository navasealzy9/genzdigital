<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_courses', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('code')->unique();
            $t->text('description')->nullable();
            $t->string('instructor');
            $t->string('status')->default('draft');
            $t->boolean('self_enrollment')->default(false);
            $t->timestamps();
        });
        Schema::create('learning_lessons', function (Blueprint $t) {
            $t->id();
            $t->foreignId('course_id')->constrained('learning_courses')->cascadeOnDelete();
            $t->string('section')->default('Getting started');
            $t->string('title');
            $t->longText('content');
            $t->string('video_url', 2048)->nullable();
            $t->string('file_path')->nullable();
            $t->string('file_name')->nullable();
            $t->unsignedInteger('position')->default(1);
            $t->boolean('published')->default(false);
            $t->timestamps();
        });
        Schema::create('learning_enrollments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('course_id')->constrained('learning_courses')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('status')->default('active');
            $t->timestamps();
            $t->unique(['course_id', 'user_id']);
        });
        Schema::create('learning_completions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('lesson_id')->constrained('learning_lessons')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->timestamps();
            $t->unique(['lesson_id', 'user_id']);
        });
        Schema::create('learning_assignments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('course_id')->constrained('learning_courses')->cascadeOnDelete();
            $t->string('title');
            $t->longText('instructions');
            $t->dateTime('due_at')->nullable();
            $t->unsignedInteger('max_score')->default(100);
            $t->unsignedInteger('pass_score')->default(50);
            $t->boolean('published')->default(false);
            $t->timestamps();
        });
        Schema::create('learning_submissions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('assignment_id')->constrained('learning_assignments')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->longText('answer');
            $t->string('file_path')->nullable();
            $t->string('file_name')->nullable();
            $t->decimal('score', 8, 2)->nullable();
            $t->text('feedback')->nullable();
            $t->foreignId('graded_by')->nullable()->constrained('users')->nullOnDelete();
            $t->dateTime('submitted_at');
            $t->dateTime('graded_at')->nullable();
            $t->timestamps();
            $t->unique(['assignment_id', 'user_id']);
        });
        Schema::create('learning_quizzes', function (Blueprint $t) {
            $t->id();
            $t->foreignId('course_id')->constrained('learning_courses')->cascadeOnDelete();
            $t->string('title');
            $t->unsignedInteger('duration_minutes')->default(30);
            $t->unsignedInteger('pass_percentage')->default(50);
            $t->unsignedInteger('max_attempts')->default(1);
            $t->dateTime('opens_at')->nullable();
            $t->dateTime('closes_at')->nullable();
            $t->boolean('published')->default(false);
            $t->timestamps();
        });
        Schema::create('learning_questions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('quiz_id')->constrained('learning_quizzes')->cascadeOnDelete();
            $t->text('prompt');
            $t->json('options');
            $t->string('correct_option', 1);
            $t->unsignedInteger('points')->default(1);
            $t->timestamps();
        });
        Schema::create('learning_attempts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('quiz_id')->constrained('learning_quizzes')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->json('questions');
            $t->json('answers')->nullable();
            $t->dateTime('started_at');
            $t->dateTime('expires_at');
            $t->dateTime('submitted_at')->nullable();
            $t->unsignedInteger('earned_points')->nullable();
            $t->unsignedInteger('total_points');
            $t->decimal('percentage', 5, 2)->nullable();
            $t->boolean('passed')->default(false);
            $t->timestamps();
        });
        Schema::create('learning_certificates', function (Blueprint $t) {
            $t->id();
            $t->foreignId('course_id')->constrained('learning_courses')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->uuid('credential')->unique();
            $t->dateTime('issued_at');
            $t->timestamps();
            $t->unique(['course_id', 'user_id']);
        });

        // Existing classroom records remain intact. Imported courses start as drafts for review.
        if (Schema::hasTable('campus_classes')) {
            foreach (DB::table('campus_classes')->orderBy('id')->get() as $class) {
                DB::table('learning_courses')->insertOrIgnore([
                    'title' => $class->title, 'code' => $class->code,
                    'description' => 'Imported classroom. Add lessons and review before publishing.',
                    'instructor' => $class->prof, 'status' => 'draft',
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }
        }
        if (Schema::hasTable('campus_course_carts')) {
            foreach (DB::table('campus_course_carts')->where('status', 'Enrolled')->get() as $row) {
                $course = DB::table('learning_courses')->where('code', $row->course_code)->first();
                $user = DB::table('users')->where('student_id', $row->student_id)->where('role', 'student')->first();
                if ($course && $user) {
                    DB::table('learning_enrollments')->insertOrIgnore([
                        'course_id' => $course->id, 'user_id' => $user->id, 'status' => 'active',
                        'created_at' => now(), 'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        foreach (['certificates', 'attempts', 'questions', 'quizzes', 'submissions', 'assignments', 'completions', 'enrollments', 'lessons', 'courses'] as $name) {
            Schema::dropIfExists('learning_'.$name);
        }
    }
};
