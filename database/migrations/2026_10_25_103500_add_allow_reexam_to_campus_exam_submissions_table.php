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
        if (Schema::hasTable('campus_exam_submissions')) {
            Schema::table('campus_exam_submissions', function (Blueprint $table) {
                if (!Schema::hasColumn('campus_exam_submissions', 'allow_reexam')) {
                    $table->boolean('allow_reexam')->default(false)->after('is_passed');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('campus_exam_submissions')) {
            Schema::table('campus_exam_submissions', function (Blueprint $table) {
                if (Schema::hasColumn('campus_exam_submissions', 'allow_reexam')) {
                    $table->dropColumn('allow_reexam');
                }
            });
        }
    }
};
