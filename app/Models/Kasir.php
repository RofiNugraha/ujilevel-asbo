<?php

namespace App\Models;

use App\Services\MidtransService;
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
        'booking_id',
        'total_harga',
        'metode_pembayaran',
        'transaction_id',
        'status_transaksi',
        'payment_type', 
        'dp_order_id'
    ];

    protected $casts = [
        'layanan_id' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLayananIdAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setLayananIdAttribute($value)
    {
        $this->attributes['layanan_id'] = is_array($value) ? json_encode($value) : $value;
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function checkout()
    {
        return $this->belongsTo(Checkout::class, 'user_id', 'user_id');
    }

    public function dpOrder()
    {
        return $this->belongsTo(Order::class, 'dp_order_id');
    }   

    public function processMidtransPayment()
    {
        $midtransService = app()->make(MidtransService::class);
        
        if ($this->payment_type === 'dp') {
            return $midtransService->createDpTransaction($this);
        } else {
            return $midtransService->createFullPaymentTransaction($this->booking, $this);
        }
    }

    public function updatePaymentStatus($status)
    {
        $this->status_transaksi = $status;
        $this->save();

        if ($status === 'success') {
            if ($this->payment_type === 'full') {
                $this->booking->status = 'selesai';
                $this->booking->save();

                if ($this->checkout) {
                    $this->checkout->update([
                        'status_pembayaran' => 'paid',
                        'metode_pembayaran' => 'midtrans'
                    ]);
                }
            }
        }
    }
}