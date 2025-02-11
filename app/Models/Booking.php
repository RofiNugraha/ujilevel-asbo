<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 
        'user_id', 
        'layanan_id', 
        'produk_id',
        'jam_booking', 
        'kursi',
        'status', 
        'deskripsi', 
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