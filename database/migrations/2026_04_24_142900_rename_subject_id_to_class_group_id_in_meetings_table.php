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
    Schema::table('meetings', function (Blueprint $table) {
        $table->renameColumn('subject_id', 'class_group_id');
    });
}

public function down(): void
{
    Schema::table('meetings', function (Blueprint $table) {
        $table->renameColumn('class_group_id', 'subject_id');
    });
}
};
