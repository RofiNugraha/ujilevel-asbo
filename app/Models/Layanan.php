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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($layanan) {
            $lastLayanan = Layanan::where('id', 'LIKE', '1%')->orderBy('id', 'desc')->first();
            $nextNumber = $lastLayanan ? ((int) substr($lastLayanan->id, 1)) + 1 : 100;
            $layanan->id = '1' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        });
    }

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