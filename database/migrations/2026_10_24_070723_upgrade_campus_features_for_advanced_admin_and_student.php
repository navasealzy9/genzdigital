<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. QCM Exam Questions table
        if (!Schema::hasTable('campus_exam_questions')) {
            Schema::create('campus_exam_questions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('exam_id');
                $table->text('question_text');
                $table->string('option_a', 255);
                $table->string('option_b', 255);
                $table->string('option_c', 255);
                $table->string('option_d', 255);
                $table->string('correct_option', 10); // A, B, C, D
                $table->integer('points')->default(10);
                $table->timestamps();
            });
        }

        // 2. Add columns to campus_exams if not exists
        Schema::table('campus_exams', function (Blueprint $table) {
            if (!Schema::hasColumn('campus_exams', 'class_code')) {
                $table->string('class_code', 50)->nullable()->after('course');
            }
            if (!Schema::hasColumn('campus_exams', 'category')) {
                $table->string('category', 100)->default('Midterm exam')->after('type'); // Lesson Exam, Midterm exam, Final exam, Test exam, Dig4.0 exam
            }
            if (!Schema::hasColumn('campus_exams', 'duration_minutes')) {
                $table->integer('duration_minutes')->default(45)->after('category');
            }
            if (!Schema::hasColumn('campus_exams', 'total_points')) {
                $table->integer('total_points')->default(100)->after('duration_minutes');
            }
        });

        // 3. Add columns to campus_qr_codes (Class QR, Session Date, Short Code)
        Schema::table('campus_qr_codes', function (Blueprint $table) {
            if (!Schema::hasColumn('campus_qr_codes', 'class_code')) {
                $table->string('class_code', 50)->nullable()->after('type');
            }
            if (!Schema::hasColumn('campus_qr_codes', 'session_date')) {
                $table->string('session_date', 50)->nullable()->after('class_code');
            }
            if (!Schema::hasColumn('campus_qr_codes', 'short_code')) {
                $table->string('short_code', 20)->nullable()->after('code_value');
            }
        });

        // 4. Add columns to campus_challenges
        Schema::table('campus_challenges', function (Blueprint $table) {
            if (!Schema::hasColumn('campus_challenges', 'duration_minutes')) {
                $table->integer('duration_minutes')->default(15)->after('points');
            }
            if (!Schema::hasColumn('campus_challenges', 'question_text')) {
                $table->text('question_text')->nullable()->after('description');
            }
            if (!Schema::hasColumn('campus_challenges', 'options_json')) {
                $table->text('options_json')->nullable()->after('question_text');
            }
            if (!Schema::hasColumn('campus_challenges', 'correct_answer')) {
                $table->string('correct_answer', 10)->nullable()->after('options_json');
            }
        });

        // 5. Challenge Participants / Live Leaderboard
        if (!Schema::hasTable('campus_challenge_participants')) {
            Schema::create('campus_challenge_participants', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('challenge_id');
                $table->string('student_name', 191);
                $table->string('student_id', 100);
                $table->string('avatar', 255)->nullable();
                $table->integer('score')->default(0);
                $table->string('completion_time', 50)->default('02:45');
                $table->integer('rank')->default(1);
                $table->timestamps();
            });
        }

        // 6. Multi-user Screen Spotlight Queue (4 at a time rotation)
        if (!Schema::hasTable('campus_screen_spotlights')) {
            Schema::create('campus_screen_spotlights', function (Blueprint $table) {
                $table->id();
                $table->string('student_name', 191);
                $table->string('student_id', 100);
                $table->string('room', 100)->default('Lab 402 • Media Wing');
                $table->string('avatar', 255)->nullable();
                $table->string('major', 191)->nullable();
                $table->string('preview_title', 191)->default('Project Prototype Showcase');
                $table->integer('display_order')->default(1);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 7. Collaboration Sessions table
        if (!Schema::hasTable('campus_collaboration_sessions')) {
            Schema::create('campus_collaboration_sessions', function (Blueprint $table) {
                $table->id();
                $table->string('title', 191);
                $table->string('class_code', 50)->nullable();
                $table->text('exercise_prompt');
                $table->string('option_a', 255)->nullable();
                $table->string('option_b', 255)->nullable();
                $table->string('option_c', 255)->nullable();
                $table->string('option_d', 255)->nullable();
                $table->string('correct_option', 10)->nullable();
                $table->string('status', 50)->default('Open');
                $table->integer('active_users')->default(1);
                $table->timestamps();
            });
        }

        // 8. Add class_code & file_path to campus_resources
        Schema::table('campus_resources', function (Blueprint $table) {
            if (!Schema::hasColumn('campus_resources', 'class_code')) {
                $table->string('class_code', 50)->nullable()->after('course');
            }
            if (!Schema::hasColumn('campus_resources', 'file_type')) {
                $table->string('file_type', 50)->default('pdf')->after('file_name');
            }
            if (!Schema::hasColumn('campus_resources', 'file_url')) {
                $table->string('file_url', 255)->nullable()->after('file_type');
            }
        });

        // 9. Add file_path & gesture support to campus_teaching_slides
        Schema::table('campus_teaching_slides', function (Blueprint $table) {
            if (!Schema::hasColumn('campus_teaching_slides', 'file_path')) {
                $table->string('file_path', 255)->nullable()->after('course');
            }
            if (!Schema::hasColumn('campus_teaching_slides', 'file_type')) {
                $table->string('file_type', 50)->default('pdf')->after('file_path');
            }
            if (!Schema::hasColumn('campus_teaching_slides', 'gesture_enabled')) {
                $table->boolean('gesture_enabled')->default(true)->after('file_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campus_collaboration_sessions');
        Schema::dropIfExists('campus_screen_spotlights');
        Schema::dropIfExists('campus_challenge_participants');
        Schema::dropIfExists('campus_exam_questions');
    }
};
