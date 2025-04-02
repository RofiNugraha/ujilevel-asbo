<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
            // Ini perbaikan pertama: kita konversi request JSON menjadi array
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

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating order status: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Webhook for Midtrans notifications
    public function notification(Request $request)
    {
        try {
            $notificationBody = json_decode($request->getContent(), true);
            $transactionStatus = $notificationBody['transaction_status'];
            $orderId = $notificationBody['order_id'];
            
            // Extract the actual order ID from the Midtrans order ID format (DP-{id}-{timestamp})
            $orderIdParts = explode('-', $orderId);
            if (count($orderIdParts) > 1) {
                $actualOrderId = $orderIdParts[1];
                
                $order = Order::findOrFail($actualOrderId);
                
                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    $order->update(['status' => 'Paid']); // Sesuaikan dengan enum di migrasi
                } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                    $order->update(['status' => 'Unpaid']); // Sesuaikan dengan enum di migrasi
                }
            }
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error handling notification: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}