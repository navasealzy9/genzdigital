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
        if (Schema::hasTable('campus_attendances')) {
            Schema::table('campus_attendances', function (Blueprint $table) {
                if (!Schema::hasColumn('campus_attendances', 'session_name')) {
                    $table->string('session_name', 50)->default('Session 1 (ព្រឹក)')->after('code');
                }
                if (!Schema::hasColumn('campus_attendances', 'session_date')) {
                    $table->string('session_date', 30)->nullable()->after('session_name');
                }
            });
        }

        if (Schema::hasTable('campus_qr_codes')) {
            Schema::table('campus_qr_codes', function (Blueprint $table) {
                if (!Schema::hasColumn('campus_qr_codes', 'session_name')) {
                    $table->string('session_name', 50)->default('Session 1 (ព្រឹក)')->after('session_date');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('campus_attendances')) {
            Schema::table('campus_attendances', function (Blueprint $table) {
                if (Schema::hasColumn('campus_attendances', 'session_name')) {
                    $table->dropColumn('session_name');
                }
                if (Schema::hasColumn('campus_attendances', 'session_date')) {
                    $table->dropColumn('session_date');
                }
            });
        }

        if (Schema::hasTable('campus_qr_codes')) {
            Schema::table('campus_qr_codes', function (Blueprint $table) {
                if (Schema::hasColumn('campus_qr_codes', 'session_name')) {
                    $table->dropColumn('session_name');
                }
            });
        }
    }
};
