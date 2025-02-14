<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'booking_id', 'pesan', 'tanggal_notifikasi', 'status_dibaca'];

    protected $casts = [
        'tanggal_notifikasi' => 'datetime',
        'status_dibaca' => 'boolean'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function booking(): BelongsTo {
        return $this->belongsTo(Booking::class);
    }
}