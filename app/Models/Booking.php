<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'layanan_id',
        'status',
        'status_pembayaran',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function layanan() {
        return $this->belongsTo(Layanan::class);
    }
}