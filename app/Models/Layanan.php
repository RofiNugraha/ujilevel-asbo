<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipe_customer',
        'layanan_tambahan',
        'kursi',
        'jam_booking',
        'harga',
        'deskripsi',
    ];

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    public function riwayatTransaksi() {
        return $this->hasMany(RiwayatTransaksi::class);
    }
}