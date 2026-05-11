<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Penulis
            $table->string('title');
            $table->string('slug')->unique(); // Untuk URL (judul-berita)
            $table->string('category')->default('Pendidikan'); // MTS, SMAIT, Umum
            $table->text('content');
            $table->string('image')->nullable();
            $table->string('image_caption')->nullable();
            $table->date('published_at')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedBigInteger('views')->default(0); // Hitung jumlah lihat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
