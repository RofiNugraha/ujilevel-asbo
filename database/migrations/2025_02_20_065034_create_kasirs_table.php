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
        Schema::create('kasirs', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->json('layanan_id');
            $table->string('booking_id', 20)->nullable();
            $table->integer('total_harga');
            $table->string('metode_pembayaran', 20);
            $table->string('transaction_id')->nullable();
            $table->enum('status_transaksi', ['pending', 'success', 'failed'])->default('pending');
            $table->string('payment_type')->nullable();
            $table->string('dp_order_id')->nullable();
            $table->timestamps();
            
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kasirs');
    }
};