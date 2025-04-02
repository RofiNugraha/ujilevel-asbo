<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Transaction;

class StatusCheckerController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
    }
    
    public function checkStatus(Request $request)
    {
        try {
            $orderId = $request->input('order_id');
            $order = Order::findOrFail($orderId);
            
            // Ambil transaction_id untuk dicek ke Midtrans
            $transactionId = $order->transaction_id;
            
            if (empty($transactionId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction ID tidak ditemukan'
                ]);
            }
            
            // Cek status transaksi ke Midtrans
            $status = Transaction::status($transactionId);
            
            Log::info('Midtrans status check response:', ['status' => $status]);
            
            // Jika transaksi sudah settlement atau capture
            if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                // Update status order
                $order->update(['status' => 'Paid']);
                
                // Set session
                session(['dp_paid' => true, 'order_id' => $order->id]);
                
                return response()->json([
                    'success' => true,
                    'status' => $status->transaction_status,
                    'message' => 'Pembayaran berhasil'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'status' => $status->transaction_status,
                'message' => 'Pembayaran belum selesai'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error checking transaction status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}