<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkout_id');
            $table->string('metode_pembayaran', 20);
            $table->string('status', 20);
            $table->timestamps();

            $table->foreign('checkout_id')->references('id')->on('checkouts')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('payments');
    }
};