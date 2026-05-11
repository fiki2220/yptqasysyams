<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('grade_level')->nullable(); // Kelas / Jenjang yg dituju
            $table->date('birth_date')->nullable();    // Tanggal Lahir
            $table->string('mother_name')->nullable(); // Nama Ibu Kandung
            $table->string('school_origin')->nullable(); // Asal Sekolah
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['grade_level', 'birth_date', 'mother_name', 'school_origin']);
        });
    }
};
