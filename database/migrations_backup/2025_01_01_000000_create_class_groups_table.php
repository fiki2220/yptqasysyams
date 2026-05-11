<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tilawah A, Tilawah B, Murottal A, dst
            $table->string('slug')->unique();
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade');
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Tabel pivot untuk many-to-many antara ClassGroup dan User (Santri)
        Schema::create('class_group_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_group_id')->constrained('class_groups')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('joined_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['class_group_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_group_student');
        Schema::dropIfExists('class_groups');
    }
};
