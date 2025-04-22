<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluarans';
    
    protected $fillable = [
        'id',
        'nama',
        'kategori',
        'harga',
        'bukti_pembayaran',
    ];

    protected $casts = [
        'harga' => 'integer',
    ];
    
    protected $appends = ['bukti_pembayaran_url'];

    const KATEGORI_PRIBADI = 'pribadi';
    const KATEGORI_TOKO = 'toko';
    
    public function getBuktiPembayaranUrlAttribute()
    {
        if ($this->bukti_pembayaran) {
            return asset('storage/bukti_pembayaran/'.$this->bukti_pembayaran);
        }
        return null;
    }

    public function isStoreCost()
    {
        return $this->kategori === 'toko';
    }

    public function isPersonalCost()
    {
        return $this->kategori === 'pribadi';
    }
}