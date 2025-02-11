<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($produk) {
            $lastProduk = Produk::where('id', 'LIKE', '9%')->orderBy('id', 'desc')->first();
            $nextNumber = $lastProduk ? ((int) substr($lastProduk->id, 1)) + 1 : 900;
            $produk->id = '9' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        });
    }

    protected $fillable = [
        'nama_produk', 
        'deskripsi', 
        'harga',
        'gambar',
    ];


    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}