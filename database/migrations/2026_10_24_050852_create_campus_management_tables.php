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
        Schema::create('campus_students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('student_id', 100)->unique();
            $table->string('email', 191)->unique();
            $table->string('major', 191);
            $table->string('gender', 50);
            $table->string('avatar', 255);
            $table->string('status', 50)->default('Active');
            $table->string('attendance_rate', 50)->default('90%');
            $table->string('valid_until', 50)->default('08/2028');
            $table->timestamps();
        });

        Schema::create('campus_classes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->string('code', 50);
            $table->string('room', 100);
            $table->string('prof', 191);
            $table->string('schedule_time', 100);
            $table->string('status', 50)->default('Upcoming');
            $table->string('type', 100)->default('Lecture & Lab');
            $table->string('border_color', 50)->default('#3b82f6');
            $table->timestamps();
        });

        Schema::create('campus_attendances', function (Blueprint $table) {
            $table->id();
            $table->string('student_name', 191);
            $table->string('student_id', 100);
            $table->string('subject', 191);
            $table->string('code', 50);
            $table->string('status', 50)->default('Present');
            $table->string('check_in_time', 100);
            $table->timestamps();
        });

        Schema::create('campus_exams', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->string('course', 191);
            $table->string('exam_date', 100);
            $table->string('room', 100);
            $table->string('type', 50)->default('Mid-Term Exam');
            $table->string('status', 50)->default('Scheduled');
            $table->timestamps();
        });

        Schema::create('campus_challenges', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->text('description')->nullable();
            $table->integer('points')->default(500);
            $table->string('deadline', 100);
            $table->string('status', 50)->default('Active');
            $table->string('badge', 50)->default('NEW');
            $table->timestamps();
        });

        Schema::create('campus_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->string('recipient', 191);
            $table->string('issue_date', 100);
            $table->string('credential_id', 100);
            $table->string('status', 50)->default('Verified');
            $table->timestamps();
        });

        Schema::create('campus_resources', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->string('course', 191);
            $table->string('file_name', 191);
            $table->string('file_size', 50);
            $table->integer('download_count')->default(0);
            $table->timestamps();
        });

        Schema::create('campus_collaborations', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->text('description')->nullable();
            $table->string('required_role', 100);
            $table->integer('current_members')->default(1);
            $table->integer('max_members')->default(4);
            $table->string('status', 50)->default('Open');
            $table->timestamps();
        });

        Schema::create('campus_qr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->string('type', 50);
            $table->string('code_value', 191);
            $table->string('expires_at', 100);
            $table->integer('scans_count')->default(0);
            $table->string('status', 50)->default('Active');
            $table->timestamps();
        });

        Schema::create('campus_teaching_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191);
            $table->string('course', 191);
            $table->integer('current_slide')->default(1);
            $table->integer('total_slides')->default(5);
            $table->text('slide_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('campus_screen_broadcasts', function (Blueprint $table) {
            $table->id();
            $table->string('student_name', 191);
            $table->string('student_id', 100);
            $table->string('room', 100);
            $table->boolean('is_broadcasting')->default(false);
            $table->string('preview_title', 191)->default('UI Prototype Preview');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campus_screen_broadcasts');
        Schema::dropIfExists('campus_teaching_slides');
        Schema::dropIfExists('campus_qr_codes');
        Schema::dropIfExists('campus_collaborations');
        Schema::dropIfExists('campus_resources');
        Schema::dropIfExists('campus_certificates');
        Schema::dropIfExists('campus_challenges');
        Schema::dropIfExists('campus_exams');
        Schema::dropIfExists('campus_attendances');
        Schema::dropIfExists('campus_classes');
        Schema::dropIfExists('campus_students');
    }
};
