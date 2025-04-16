<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function layanan(): BelongsTo {
        return $this->belongsTo(Layanan::class);
    }
    
    public function checkout()
    {
        return $this->belongsTo(Checkout::class, 'checkout_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}