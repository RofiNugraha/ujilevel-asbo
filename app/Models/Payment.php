<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkout_id', 'total_harga', 'metode_pembayaran', 'status'
    ];

    protected $casts = [
        'metode_pembayaran' => 'string',
        'status' => 'string'
    ];

    public function checkout(): BelongsTo {
        return $this->belongsTo(Checkout::class);
    }
}