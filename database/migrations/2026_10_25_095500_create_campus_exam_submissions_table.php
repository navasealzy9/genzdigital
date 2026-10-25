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
        if (!Schema::hasTable('campus_exam_submissions')) {
            Schema::create('campus_exam_submissions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('exam_id');
                $table->string('exam_title', 191);
                $table->string('course_code', 50)->nullable();
                $table->string('student_id', 100);
                $table->string('student_name', 191);
                $table->string('student_avatar')->nullable();
                $table->double('earned_score')->default(0);
                $table->double('total_possible')->default(100);
                $table->double('percentage')->default(0);
                $table->string('grade', 10)->default('A');
                $table->string('status', 50)->default('Passed');
                $table->boolean('is_passed')->default(true);
                $table->text('answers_json')->nullable();
                $table->text('question_details_json')->nullable();
                $table->timestamp('submitted_at')->nullable();
                $table->timestamps();

                $table->index(['exam_id', 'student_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campus_exam_submissions');
    }
};
