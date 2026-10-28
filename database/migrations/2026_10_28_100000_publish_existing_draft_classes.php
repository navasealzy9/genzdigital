<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('learning_courses')->where('status', 'draft')->update([
            'status' => 'published', 'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Publishing cannot be reversed safely without knowing each class's history.
    }
};
