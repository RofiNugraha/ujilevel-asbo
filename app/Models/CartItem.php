<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'layanan_id', 'quantity', 'subtotal'];

    public function cart(): BelongsTo {
        return $this->belongsTo(Cart::class);
    }

    public function layanan(): BelongsTo {
        return $this->belongsTo(Layanan::class);
    }
}