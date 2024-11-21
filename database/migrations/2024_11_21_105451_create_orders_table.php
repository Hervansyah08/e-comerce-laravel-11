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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_price', 15, 2);
            $table->enum('status', [
                'pending',
                'dibayar',
                'sedang diproses',
                'dikirim',
                'terkirim',
                'dibatalkan'
            ])->default('pending');
            $table->text('alamat_pengiriman');
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('midtrans_payment_type')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('resi_code')->nullable();
            $table->timestamps();

            // index ini agar ketika mencari sesuatu di tabel yang memiliki index, database dapat langsung menuju data yang Anda cari tanpa membaca seluruh tabel.
            $table->index('status');
            $table->index('midtrans_transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
