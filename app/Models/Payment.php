<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkout_id', 
        'metode_pembayaran', 
        'status'
    ];
    
    public function checkout(): BelongsTo {
        return $this->belongsTo(Checkout::class);
    }
}