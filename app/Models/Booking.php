<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'layanan_id', 
        'produk_id',
        'jam_booking', 
        'kursi',
        'status', 
        'metode_pembayaran'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function layanan(): BelongsTo {
        return $this->belongsTo(Layanan::class);
    }

    public function produk(): BelongsTo {
        return $this->belongsTo(Produk::class);
    }
}