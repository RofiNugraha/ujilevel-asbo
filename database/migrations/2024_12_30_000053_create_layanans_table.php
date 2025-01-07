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
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe_customer', ['anak', 'dewasa']);
            $table->enum('layanan_tambahan', ['cukur_jenggot', 'cukur_kumis', 'cukur_jenggot_kumis', 'tidak_ada']);
            $table->enum('kursi', ['satu', 'dua']);
            $table->dateTime('jam_booking');
            $table->decimal('harga');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};