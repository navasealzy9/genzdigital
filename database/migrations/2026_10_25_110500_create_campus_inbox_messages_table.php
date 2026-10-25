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
        Schema::create('campus_inbox_messages', function (Blueprint $table) {
            $table->id();
            $table->string('room_id', 50)->index();
            $table->string('room_name', 191);
            $table->string('room_category', 50)->default('academic');
            $table->string('sender_id', 100)->index();
            $table->string('sender_name', 191);
            $table->text('sender_avatar')->nullable();
            $table->string('sender_role', 50)->default('student');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campus_inbox_messages');
    }
};
