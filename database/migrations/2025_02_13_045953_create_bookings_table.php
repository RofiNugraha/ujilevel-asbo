<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('bookings', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->bigInteger('user_id')->unsigned();
            $table->json('layanan_id');
            $table->dateTime('jam_booking');
            $table->enum('kursi', ['satu', 'dua']);
            $table->string('status', 20);
            $table->string('metode_pembayaran', 20);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('bookings');
    }
};