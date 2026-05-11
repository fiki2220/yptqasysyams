<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_group_id')->constrained('class_groups')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('assessment_type', ['ziyadah', 'murojaah', 'tahsin', 'tilawah']);
            // data JSON menyimpan: surah, ayat, dan nilai L/C/TL
            // Contoh: [{"surah": 1, "ayat": 1, "nilai": "L"}, {...}]
            $table->json('data')->nullable();
            $table->timestamps();

            $table->unique(['class_group_id', 'user_id', 'assessment_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
