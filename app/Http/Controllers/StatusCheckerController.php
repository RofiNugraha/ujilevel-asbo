<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
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
            $data = $request->json()->all();
            Log::info('Status check request:', $data);
            
            $validated = validator($data, [
                'order_id' => 'required|numeric'
            ])->validate();

            $order = Order::find($validated['order_id']);
            
            if (!$order) {
                Log::error('Order not found', ['order_id' => $validated['order_id']]);
                return response()->json([
                    'success' => false,
                    'status' => 'not_found',
                    'message' => 'Order not found'
                ], 404);
            }

            Log::info('Order found:', $order->toArray());
            
            if (!$order->transaction_id) {
                Log::error('Transaction ID missing', ['order_id' => $order->id]);
                return response()->json([
                    'success' => false,
                    'status' => 'undefined',
                    'message' => 'Transaction ID not found for this order',
                    'order_data' => $order->toArray()
                ], 400);
            }

            $status = Transaction::status($order->transaction_id);
            Log::info('Midtrans status response:', (array) $status);

            if ($status && isset($status->transaction_status)) {
                $appStatus = $this->mapStatus($status->transaction_status);
                
                if ($appStatus === 'success') {
                    $order->status = 'Paid';
                    $order->save();
                    Session::put('dp_paid', true);
                    Session::put('order_id', $order->id);
                }

                return response()->json([
                    'success' => $appStatus === 'success',
                    'status' => $status->transaction_status,
                    'message' => $status->status_message ?? 'Payment status retrieved',
                    'app_status' => $appStatus,
                    'transaction_id' => $order->transaction_id
                ]);
            }
            
            return response()->json([
                'success' => false,
                'status' => 'unknown',
                'message' => 'Invalid response from payment gateway'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Status check error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if (strpos($e->getMessage(), '404') !== false) {
                return response()->json([
                    'success' => false,
                    'status' => 'not_found',
                    'message' => 'Transaction not found in payment gateway'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error checking payment status: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function mapStatus($transactionStatus)
    {
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            return 'success';
        } elseif ($transactionStatus == 'pending') {
            return 'pending';
        } else {
            return 'failed';
        }
    }

    public function handleNotification(Request $request)
    {
        try {
            // Log the raw notification for debugging
            Log::info('Raw Midtrans notification received: ' . $request->getContent());
            
            $notificationBody = $request->getContent();
            $notification = json_decode($notificationBody);
            
            if (!$notification) {
                Log::error('Failed to parse notification JSON');
                return response()->json(['success' => false, 'message' => 'Invalid JSON']);
            }
            
            Log::info('Midtrans notification processed:', ['data' => (array)$notification]);
            
            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            
            // Extract the actual order ID from the formatted string
            // If format is 'DP-{id}-{timestamp}'
            $actualOrderId = null;
            if (strpos($orderId, 'DP-') === 0) {
                $parts = explode('-', $orderId);
                if (count($parts) > 1) {
                    $actualOrderId = $parts[1];
                }
            }
            
            // Try to find the order using different methods
            $order = null;
            if ($actualOrderId) {
                $order = Order::find($actualOrderId);
            }
            
            if (!$order && isset($notification->transaction_id)) {
                $order = Order::where('transaction_id', $notification->transaction_id)->first();
            }
            
            if (!$order) {
                $order = Order::where('transaction_id', $orderId)->first();
            }
            
            if ($order) {
                Log::info('Order found:', ['order_id' => $order->id, 'transaction_status' => $transactionStatus]);
                
                // Update order status based on transaction status
                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    $order->update(['status' => 'Paid']);
                    // Also set session data if needed
                    Session::put('dp_paid', true);
                    Session::put('order_id', $order->id);
                    Session::flash('dp_paid_now', true);
                    
                    Log::info('Order marked as paid:', ['order_id' => $order->id]);
                } elseif ($transactionStatus == 'pending') {
                    $order->update(['status' => 'Pending']);
                    Log::info('Order marked as pending:', ['order_id' => $order->id]);
                } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                    $order->update(['status' => 'Failed']);
                    Log::info('Order marked as failed:', ['order_id' => $order->id]);
                }
                
                return response()->json(['success' => true]);
            }
            
            Log::warning('Order not found for notification:', ['order_id' => $orderId]);
            return response()->json(['success' => false, 'message' => 'Order not found']);
            
        } catch (\Exception $e) {
            Log::error('Error handling Midtrans notification: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}