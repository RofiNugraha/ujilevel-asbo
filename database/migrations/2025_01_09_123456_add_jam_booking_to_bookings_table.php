<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJamBookingToBookingsTable extends Migration
{
public function up()
{
Schema::table('bookings', function (Blueprint $table) {
$table->datetime('jam_booking')->nullable()->after('layanan_id');
});
}

public function down()
{
Schema::table('bookings', function (Blueprint $table) {
$table->dropColumn('jam_booking');
});
}
}