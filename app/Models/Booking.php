<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'user_id', 'layanan_id', 'checkout_id', 
        'jam_booking', 'kursi', 'status', 'metode_pembayaran',
    ];

    protected $casts = [
        'id' => 'string',
        'jam_booking' => 'datetime',
        'kursi' => 'string',
        'status' => 'string'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function layanan(): BelongsTo {
        return $this->belongsTo(Layanan::class);
    }

    public function checkout(): BelongsTo {
        return $this->belongsTo(Checkout::class);
    }
}