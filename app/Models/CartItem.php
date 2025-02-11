<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id', 
        'layanan_id', 
        'produk_id', 
        'jenis_pesanan', 
        'quantity', 
        'subtotal', 
    ];

    public function cart(): BelongsTo {
        return $this->belongsTo(Cart::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id')->withDefault();
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id')->withDefault();
    }

}