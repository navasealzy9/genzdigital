<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gen5_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('learning_courses')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->string('title', 160);
            $table->string('team_one', 60)->default('Emerald');
            $table->string('team_two', 60)->default('Coral');
            $table->unsignedInteger('duration_minutes');
            $table->string('status', 20)->default('lobby');
            $table->json('board');
            $table->json('events');
            $table->unsignedBigInteger('revision')->default(0);
            $table->dateTime('started_at', 3)->nullable();
            $table->dateTime('ends_at', 3)->nullable();
            $table->dateTime('finished_at', 3)->nullable();
            $table->unsignedTinyInteger('winner')->nullable(); // 0 = draw, 1 or 2 = winning team
            $table->unsignedInteger('score_one')->default(0);
            $table->unsignedInteger('score_two')->default(0);
            $table->timestamps();
            $table->index(['course_id', 'status']);
            $table->index(['status', 'ends_at']);
        });
        Schema::create('gen5_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained('gen5_matches')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('team');
            $table->unsignedTinyInteger('x');
            $table->unsignedTinyInteger('y');
            $table->unsignedBigInteger('next_move_at')->default(0);
            $table->unsignedBigInteger('next_action_at')->default(0);
            $table->unsignedInteger('builds')->default(0);
            $table->unsignedInteger('attacks')->default(0);
            $table->timestamps();
            $table->unique(['match_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gen5_players');
        Schema::dropIfExists('gen5_matches');
    }
};
