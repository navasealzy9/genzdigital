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
        Schema::create('campus_books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author')->default('GenZ Faculty');
            $table->string('category')->default('Design & Technology');
            $table->string('cover_image')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->default('document.pdf');
            $table->string('file_size')->default('14.2 MB');
            $table->integer('total_pages')->default(240);
            $table->text('description')->nullable();
            $table->string('status')->default('Available');
            $table->integer('reads_count')->default(0);
            $table->timestamps();
        });

        Schema::create('campus_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('Campus Announcement');
            $table->text('content');
            $table->string('author')->default('Campus Administration');
            $table->string('image')->nullable();
            $table->string('badge')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
        });

        // Insert default library books
        \Illuminate\Support\Facades\DB::table('campus_books')->insert([
            [
                'title' => 'Design Systems Handbook: Enterprise Scaling',
                'author' => 'Dr. Alex Vance & Marco Silva',
                'category' => 'UI/UX Design',
                'cover_image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&q=80&w=350',
                'file_name' => 'Design_Systems_Enterprise_2026.pdf',
                'file_size' => '18.4 MB',
                'total_pages' => 312,
                'description' => 'Comprehensive masterclass on crafting tokens, component libraries, and scalable design architectures.',
                'status' => 'Available',
                'reads_count' => 142,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Modern Web Animation & Spring Physics',
                'author' => 'Elena Rostova',
                'category' => 'Interactive Media',
                'cover_image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=350',
                'file_name' => 'Web_Animation_Physics_v2.pdf',
                'file_size' => '12.8 MB',
                'total_pages' => 184,
                'description' => 'In-depth guide to micro-interactions, gesture tracking, and high-performance 60fps animations.',
                'status' => 'Available',
                'reads_count' => 98,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Typography in Digital Age: Variable Fonts',
                'author' => 'Kenji Tanaka',
                'category' => 'Graphic Arts',
                'cover_image' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&q=80&w=350',
                'file_name' => 'Variable_Fonts_Typography_Guide.pdf',
                'file_size' => '24.1 MB',
                'total_pages' => 260,
                'description' => 'Essential reading for visual communicators focusing on layout hierarchy, rhythm, and kinetic typography.',
                'status' => 'Available',
                'reads_count' => 76,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert default admin posts
        \Illuminate\Support\Facades\DB::table('campus_posts')->insert([
            [
                'title' => 'សេចក្តីជូនដំណឹងស្តីពីកាលវិភាគប្រឡងឆមាសទី ១ ឆ្នាំសិក្សា ២០២៦',
                'category' => 'Academic Notice',
                'content' => 'ការិយាល័យសិក្សាបានកំណត់កាលបរិច្ឆេទប្រឡងឆមាសទី ១ ចាប់ពីថ្ងៃទី ១០ ដល់ ១៥ ខែវិច្ឆិកា។ សូមសិស្សានុសិស្សទាំងអស់ពិនិត្យមើលកាលវិភាគក្នុងផ្ទាំង Exam ឱ្យបានរួចរាល់។',
                'author' => 'Office of Academic Affairs',
                'badge' => 'URGENT',
                'is_pinned' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'កម្មវិធីប្រកួតប្រជែង UI/UX Campus Hackathon 2026 (រង្វាន់ 500 ពិន្ទុ)',
                'category' => 'Campus Event',
                'content' => 'បើកទទួលការចុះឈ្មោះចូលរួមប្រកួតបង្កើត Digital Educational Dashboard។ សិស្សអាចបង្កើតក្រុម Collaboration ឬប្រកួតជាឯកត្តជនក្នុង Challenge Arena។',
                'author' => 'GenZ Innovation Club',
                'badge' => 'EVENT',
                'is_pinned' => false,
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
            [
                'title' => 'ការប្រើប្រាស់ប្រព័ន្ធស្កេនវត្តមាន QR Code & Short Passcode ថ្មី',
                'category' => 'Campus Tech',
                'content' => 'ប្រព័ន្ធ Check-in ថ្មីត្រូវបានដាក់ឱ្យដំណើរការ។ សិស្សអាចស្កេន QR Code ផ្ទាល់តាម Camera ឬវាយបញ្ចូលលេខកូដ ៤ ខ្ទង់លើផ្ទាំង Scan ដើម្បីកត់ត្រាវត្តមានភ្លាមៗ។',
                'author' => 'Digital Campus Tech Team',
                'badge' => 'NEW SYSTEM',
                'is_pinned' => false,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campus_posts');
        Schema::dropIfExists('campus_books');
    }
};
