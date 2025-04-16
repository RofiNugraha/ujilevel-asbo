<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Midtrans\Config;
use Midtrans\Snap;

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
        try {
            // Konversi request JSON menjadi array
            $data = $request->json()->all();
            
            // Validasi data
            $validated = validator($data, [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'dp' => 'required|numeric'
            ])->validate();

            // Create order dengan status yang sesuai enum di migrasi
            $order = Order::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'dp' => $validated['dp'],
                'status' => 'Unpaid' // Sesuaikan dengan enum di migrasi
            ]);

            // Prepare transaction data for Midtrans
            $transaction_details = [
                'order_id' => 'DP-' . $order->id . '-' . time(),
                'gross_amount' => (int)$validated['dp'],
            ];

            $customer_details = [
                'first_name' => $validated['name'],
                'phone' => $validated['phone'],
                'billing_address' => [
                    'address' => $validated['address'],
                ]
            ];

            $item_details = [
                [
                    'id' => 'DP-1',
                    'price' => (int)$validated['dp'],
                    'quantity' => 1,
                    'name' => 'Down Payment for Booking',
                ]
            ];

            $transaction_data = [
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
                'item_details' => $item_details
            ];

            // Get Snap token
            $snapToken = Snap::getSnapToken($transaction_data);

            // Update the order with transaction ID
            $order->update([
                'transaction_id' => $transaction_details['order_id']
            ]);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $order->id
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating order: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            // Perbaikan konversi JSON request
            $data = $request->json()->all();
            
            // Validasi data
            $validated = validator($data, [
                'order_id' => 'required|numeric',
                'status' => 'required|string'
            ])->validate();

            $order = Order::findOrFail($validated['order_id']);
            
            // Update status sesuai enum di migrasi
            $order->update(['status' => 'Paid']);

            // Store in session that DP is paid
            Session::put('dp_paid', true);
            Session::put('order_id', $order->id);
            
            // Set flash message only for this request
            Session::flash('dp_paid_now', true);

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating order status: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
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