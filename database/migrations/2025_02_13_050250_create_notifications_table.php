<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('booking_id', 20);
            $table->bigInteger('checkout_id')->unsigned()->nullable();
            $table->text('pesan');
            $table->dateTime('tanggal_notifikasi');
            $table->boolean('status_dibaca')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('checkout_id')->references('id')->on('checkouts')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('notifications');
    }
};