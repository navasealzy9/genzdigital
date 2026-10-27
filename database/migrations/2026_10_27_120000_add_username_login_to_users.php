<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 100)->nullable()->unique();
            $table->string('email')->nullable()->change();
        });
        $users = DB::table('users')->orderBy('id')->get();
        $reserved = $users->filter(fn ($u) => filled($u->student_id))->groupBy(fn ($u) => Str::lower(trim($u->student_id)));
        $used = [];
        foreach ($users as $user) {
            $studentId = Str::lower(trim($user->student_id ?? ''));
            $base = $studentId && $reserved[$studentId]->count() === 1 ? $studentId : Str::before($user->email ?? '', '@');
            $base = substr(preg_replace('/[^a-z0-9_.-]/', '', Str::lower($base)), 0, 85);
            if (strlen($base) < 3) {
                $base = 'user'.$user->id;
            }
            $candidate = $base;
            $suffix = 0;
            while (isset($used[$candidate]) || (isset($reserved[$candidate]) && ! ($candidate === $studentId && $reserved[$candidate]->count() === 1))) {
                $candidate = $base.'-'.(++$suffix);
            }
            DB::table('users')->where('id', $user->id)->update(['username' => $candidate]);
            $used[$candidate] = true;
        }
    }

    public function down(): void
    {
        // Keep email nullable: accounts created without email must not be deleted or assigned fake emails.
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn('username');
        });
    }
};
