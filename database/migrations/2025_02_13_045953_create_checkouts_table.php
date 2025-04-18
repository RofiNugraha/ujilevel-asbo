2025_02_13_045906_create_checkouts_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() { 
        Schema::create('checkouts', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique()->primary();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade');
            $table->string('booking_id', 20)->nullable();
            $table->decimal('total_harga', 10, 2);
            $table->string('status_pembayaran', 20);
            $table->string('metode_pembayaran', 20);
            $table->timestamps();
            
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('checkouts');
    }
};