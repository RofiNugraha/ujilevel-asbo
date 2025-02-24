<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Midtrans\Snap;
use Midtrans\Transaction;

class Kasir extends Model
{
    use HasFactory;

    protected $table = 'kasirs';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'user_id',
        'layanan_id',
        'total_harga',
        'metode_pembayaran',
    ];

    protected $casts = [
        'layanan_id' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function processPayment()
    {
        $params = [
            'transaction_details' => [
                'order_id' => $this->id,
                'gross_amount' => $this->total_harga,
            ],
            'customer_details' => [
                'first_name' => $this->nama_customer,
                'email' => 'customer@example.com',
            ],
        ];

        return Snap::getSnapToken($params);
    }
}