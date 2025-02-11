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
        Schema::create('bookings', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->json('layanan_id');
            $table->json('produk_id')->nullable();
            $table->dateTime('jam_booking');
            $table->enum('kursi', ['satu', 'dua']);
            $table->text('deskripsi');
            $table->string('status', 20);
            $table->string('metode_pembayaran', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};