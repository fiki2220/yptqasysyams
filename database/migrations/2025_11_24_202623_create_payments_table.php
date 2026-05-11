<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // ID Transaksi Midtrans
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('semester_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('status')->default('pending'); // pending, success, failed, expired
            $table->string('snap_token')->nullable(); // Token untuk popup midtrans
            $table->string('payment_type')->nullable(); // bank_transfer, gopay, dll
            $table->json('payment_detail')->nullable(); // Simpan response lengkap (opsional)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};