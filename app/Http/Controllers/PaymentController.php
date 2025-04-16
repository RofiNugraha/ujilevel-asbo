<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Kasir;
use App\Models\Booking;
use App\Models\Checkout;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function createTransaction(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $kasir = new Kasir();
        $kasir->id = 'KSR-' . Str::random(8);
        $kasir->user_id = $request->user_id;
        
        if ($request->booking_id) {
            $booking = Booking::find($request->booking_id);
            if (!$booking) {
                return response()->json(['message' => 'Booking tidak ditemukan'], 404);
            }
            $kasir->layanan_id = $booking->layanan_id;
            $checkout = Checkout::where('user_id', $booking->user_id)->first();
            $kasir->total_harga = $checkout ? $checkout->total_harga : 0;
        } else {
            $kasir->layanan_id = $request->layanan_id;
            $kasir->total_harga = $request->total_harga;
        }

        $kasir->metode_pembayaran = 'Midtrans';
        $kasir->status_transaksi = 'pending';
        $kasir->save();

        try {
            $transaction_details = [
                'order_id' => $kasir->id,
                'gross_amount' => $kasir->total_harga,
            ];

            $customer_details = [
                'user_id' => $request->user_id,
                'email' => $request->email,
            ];

            $params = [
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
            ];

            $snapToken = Snap::getSnapToken($params);

            return response()->json(['snap_token' => $snapToken]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mendapatkan token pembayaran', 'error' => $e->getMessage()], 500);
        }
    }

    public function transactionNotification(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed != $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $kasir = Kasir::where('id', $request->order_id)->first();
        if (!$kasir) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($request->transaction_status == 'settlement') {
            $kasir->status_transaksi = 'success';
        } elseif ($request->transaction_status == 'pending') {
            $kasir->status_transaksi = 'pending';
        } else {
            $kasir->status_transaksi = 'failed';
        }

        $kasir->save();
        return response()->json(['message' => 'Transaction updated']);
    }
}