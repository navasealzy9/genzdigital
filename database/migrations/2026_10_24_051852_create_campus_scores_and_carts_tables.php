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
        Schema::create('campus_scores', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 100);
            $table->string('student_name', 191);
            $table->string('subject', 191);
            $table->string('code', 50);
            $table->integer('credits')->default(3);
            $table->double('score')->default(90);
            $table->string('grade', 10)->default('A');
            $table->double('mid_term')->default(36);
            $table->double('assignment')->default(20);
            $table->double('final_exam')->default(38);
            $table->string('semester', 50)->default('Semester 1 - 2026');
            $table->string('status', 50)->default('Passed');
            $table->timestamps();
        });

        Schema::create('campus_course_carts', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 100);
            $table->string('course_title', 191);
            $table->string('course_code', 50);
            $table->integer('credits')->default(3);
            $table->string('instructor', 191);
            $table->string('schedule', 100);
            $table->string('status', 50)->default('Enrolled'); // Enrolled, In Cart
            $table->string('fee', 50)->default('Included');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campus_course_carts');
        Schema::dropIfExists('campus_scores');
    }
};
