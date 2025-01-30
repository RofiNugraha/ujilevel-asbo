<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_layanan', 
        'deskripsi', 
        'harga',
        'gambar',
    ];

    public function bookings(): HasMany {
        return $this->hasMany(Booking::class);
    }

    public function cartItems(): HasMany {
        return $this->hasMany(CartItem::class);
    }
}