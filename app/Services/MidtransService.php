<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use App\Models\Booking;
use App\Models\Checkout;
use App\Models\Kasir;
use App\Models\Layanan;
use App\Models\Order;
use Illuminate\Support\Str;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // Untuk pembayaran DP
    public function createDpTransaction(Order $order)
    {
        $transactionData = [
            'transaction_details' => [
                'order_id' => 'DP-' . $order->id . '-' . time(),
                'gross_amount' => $order->dp,
            ],
            'item_details' => [
                [
                    'id' => 'DP-1',
                    'price' => $order->dp,
                    'quantity' => 1,
                    'name' => 'Down Payment Booking',
                ]
            ],
            'customer_details' => [
                'first_name' => $order->name,
                'phone' => $order->phone,
                'billing_address' => [
                    'address' => $order->address,
                ]
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($transactionData);
            $order->update(['transaction_id' => $transactionData['transaction_details']['order_id']]);
            
            return [
                'snap_token' => $snapToken,
                'order_id' => $order->id,
                'transaction_id' => $transactionData['transaction_details']['order_id']
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function createFullPaymentTransaction(Booking $booking, Kasir $kasir)
    {
        $total = 0;
    $items = [];
    
    $layananItems = json_decode($booking->layanan_id, true) ?? [];
    
    foreach ($layananItems as $item) {
        if (is_array($item) && isset($item['id'])) {
            $layananId = $item['id'];
            $quantity = $item['quantity'] ?? 1;
        } else {
            $layananId = $item;
            $quantity = 1;
        }
        
        // Gunakan first() untuk memastikan single model
        $layanan = Layanan::where('id', $layananId)->first();
        
        if ($layanan) {
            $price = $layanan->harga;
            $total += $price * $quantity;
            
            $items[] = [
                'id' => $layanan->id,
                'price' => $price,
                'quantity' => $quantity,
                'name' => $layanan->nama_layanan,
            ];
        }
    }

        $dpPaid = 0;
        if ($booking->order_id) {
            $order = Order::find($booking->order_id);
            if ($order && $order->status == 'Paid') {
                $dpPaid = $order->dp;
                $items[] = [
                    'id' => 'DP-DEDUCTION',
                    'price' => -$dpPaid,
                    'quantity' => 1,
                    'name' => 'Potongan DP',
                ];
            }
        }

        $transactionData = [
            'transaction_details' => [
                'order_id' => $kasir->id,
                'gross_amount' => $total - $dpPaid,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
                'phone' => $booking->user->phone ?? '',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($transactionData);
            return [
                'snap_token' => $snapToken,
                'transaction_id' => $kasir->id,
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    public function updateTransactionStatus($orderId, $status)
    {
        $kasir = Kasir::where('id', $orderId)->orWhere('transaction_id', $orderId)->first();
        
        if ($kasir) {
            $kasir->status_transaksi = $status;
            $kasir->save();
            
            if ($status == 'success') {
                // Get booking from kasir's booking_id field
                $booking = Booking::find($kasir->booking_id);
                
                if ($booking) {
                    // Update booking status
                    $booking->status = 'selesai';
                    $booking->metode_pembayaran = 'non-tunai';
                    $booking->save();
                    
                    // Update checkout record
                    $checkout = Checkout::where('booking_id', $booking->id)->first();
                    if ($checkout) {
                        $checkout->status_pembayaran = 'paid';
                        $checkout->metode_pembayaran = 'non-tunai';
                        $checkout->save();
                    }
                }
            }
        }
        
        return true;
    }

    public function handleNonBookingCallback($orderId, $status)
    {
        $kasir = Kasir::where('id', $orderId)->orWhere('transaction_id', $orderId)->first();
        
        if ($kasir) {
            $kasir->status_transaksi = $status;
            $kasir->save();
        }
        
        return true;
    }
}