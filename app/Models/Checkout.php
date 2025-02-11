<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 
        'cart_id', 
        'total_harga', 
        'status_pembayaran', 
        'metode_pembayaran',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function cart(): BelongsTo {
        return $this->belongsTo(Cart::class);
    }

    public function payment(): HasOne {
        return $this->hasOne(Payment::class);
    }
}