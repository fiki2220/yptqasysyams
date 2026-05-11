<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_group_id')->constrained('class_groups')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('evaluation_number'); // 1, 2, 3, 4
            // data JSON menyimpan items dengan checkbox dan nilai angka
            // Contoh: [{"name": "Lancar Membaca", "checked": true, "score": 85}, {...}]
            $table->json('items')->nullable();
            $table->timestamps();

            $table->unique(['class_group_id', 'user_id', 'evaluation_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
