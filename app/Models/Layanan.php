<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'nama_layanan', 'deskripsi', 'harga', 'gambar'
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function ($layanan) {
            $initials = strtoupper(implode('', array_map(fn($word) => $word[0], explode(' ', $layanan->nama_layanan))));
            
            do {
                $randomNumber = mt_rand(100, 999);
                $id = $initials . '-' . $randomNumber;
            } while (Layanan::where('id', $id)->exists());

            $layanan->id = $id;
        });
    }

    public function cartItems() {
        return $this->hasMany(CartItem::class, 'layanan_id');
    }

    public function bookings() {
        return $this->hasMany(Booking::class, 'layanan_id');
    }
}