<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;

class DownPaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->json()->all();
            Log::info('DP create request:', $data);
            
            $validated = validator($data, [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'dp' => 'required|numeric'
            ])->validate();

            $order = Order::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'dp' => $validated['dp'],
                'status' => 'Unpaid'
            ]);

            $midtransService = new MidtransService();
            $transaction = $midtransService->createDpTransaction($order);

            if (isset($transaction['error'])) {
                throw new \Exception($transaction['error']);
            }

            DB::commit();

            Log::info('DP created successfully', [
                'order_id' => $order->id,
                'transaction_id' => $order->transaction_id
            ]);

            return response()->json([
                'snap_token' => $transaction['snap_token'],
                'order_id' => $order->id,
                'transaction_id' => $order->transaction_id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('DP create error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => $e->getMessage(),
                'debug' => env('APP_DEBUG') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $data = $request->json()->all();
            Log::info('Update status request:', $data);
            
            $validated = validator($data, [
                'order_id' => 'required|numeric',
                'status' => 'required|string'
            ])->validate();

            $order = Order::findOrFail($validated['order_id']);
            
            $order->status = 'Paid';
            $order->save();

            Session::put('dp_paid', true);
            Session::put('order_id', $order->id);
            Session::flash('dp_paid_now', true);

            Log::info('Order status updated', $order->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'order' => $order
            ]);
        } catch (\Exception $e) {
            Log::error('Update status error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => $e->getMessage(),
                'debug' => env('APP_DEBUG') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    public function notification(Request $request)
    {
        try {
            $notificationBody = json_decode($request->getContent(), true);
            $transactionStatus = $notificationBody['transaction_status'];
            $orderId = $notificationBody['order_id'];
            
            $midtransService = new MidtransService();
            
            if (strpos($orderId, 'DP-') === 0) {
                // Pembayaran DP
                $midtransService->updateTransactionStatus($orderId, $this->mapStatus($transactionStatus));
            } else {
                // Pembayaran full
                $midtransService->updateTransactionStatus($orderId, $this->mapStatus($transactionStatus));
            }
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error handling notification: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
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
}