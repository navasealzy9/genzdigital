<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campus_homeworks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('class_code')->nullable();
            $table->string('subject')->default('Digital Media & Tech');
            $table->text('questions');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('deadline');
            $table->integer('max_score')->default(100);
            $table->string('status')->default('Active'); // Active, Closed
            $table->string('created_by')->default('Admin Academic');
            $table->timestamps();
        });

        Schema::create('campus_homework_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('homework_id');
            $table->string('student_id');
            $table->string('student_name');
            $table->string('student_avatar')->nullable();
            $table->longText('answer_text');
            $table->dateTime('submitted_at');
            $table->double('score', 8, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->string('status')->default('Submitted'); // Submitted, Graded
            $table->string('graded_by')->nullable();
            $table->dateTime('graded_at')->nullable();
            $table->timestamps();

            $table->index(['homework_id', 'student_id']);
        });

        // Insert initial sample homework
        $nowPhnomPenh = Carbon::now('Asia/Phnom_Penh');
        DB::table('campus_homeworks')->insert([
            [
                'title' => 'UI/UX Interactive System Design & Case Study',
                'class_code' => 'CS101',
                'subject' => 'UI/UX Design',
                'questions' => "1. ចូរពន្យល់ពីគោលការណ៍ចម្បងនៃ User-Centered Design (UCD) ក្នុងការអភិវឌ្ឍ Modern Web & Mobile App?\n2. តើ Micro-interactions និង Spring Physics Animations មានឥទ្ធិពលអ្វីខ្លះទៅលើ User Retention Rate?\n3. ចូរលើកឧទាហរណ៍ពីការរចនា Wireframe និង Information Architecture សម្រាប់ Digital Campus Portal។",
                'start_date' => $nowPhnomPenh->copy()->subDay(),
                'deadline' => $nowPhnomPenh->copy()->addDays(7)->setTime(23, 59, 59),
                'max_score' => 100,
                'status' => 'Active',
                'created_by' => 'Office of Academic Affairs',
                'created_at' => $nowPhnomPenh,
                'updated_at' => $nowPhnomPenh,
            ],
            [
                'title' => 'Responsive Web Architecture & State Management',
                'class_code' => null,
                'subject' => 'Web Development',
                'questions' => "1. ចូរប្រៀបធៀប Server-Side Rendering (SSR) និង Single Page Applications (SPA) លើផ្នែក Performance និង SEO?\n2. តើការប្រើប្រាស់ RESTful API និង Real-Time Polling ត្រូវរៀបចំដូចម្តេចដើម្បីកុំឱ្យប៉ះពាល់ Server Load?",
                'start_date' => $nowPhnomPenh->copy()->subHours(5),
                'deadline' => $nowPhnomPenh->copy()->addDays(3)->setTime(23, 59, 59),
                'max_score' => 100,
                'status' => 'Active',
                'created_by' => 'Lead Instructor',
                'created_at' => $nowPhnomPenh,
                'updated_at' => $nowPhnomPenh,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campus_homework_submissions');
        Schema::dropIfExists('campus_homeworks');
    }
};
