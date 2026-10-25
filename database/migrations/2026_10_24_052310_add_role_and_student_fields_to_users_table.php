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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 50)->default('student')->after('email'); // 'admin' or 'student'
            $table->string('student_id', 100)->nullable()->after('role');
            $table->string('major', 191)->nullable()->after('student_id');
            $table->string('gender', 50)->nullable()->after('major');
            $table->string('avatar', 255)->nullable()->after('gender');
            $table->string('status', 50)->default('Active')->after('avatar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'student_id', 'major', 'gender', 'avatar', 'status']);
        });
    }
};
