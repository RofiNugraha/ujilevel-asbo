<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Checkout;
use App\Models\Kasir;
use App\Models\Layanan;
use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;

class AdminKasirController extends Controller
{
    protected $midtransService;
    
    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }
    
    public function index()
    {
        $bookings = Booking::with(['user', 'checkout', 'order'])->whereIn('status', ['konfirmasi', 'batal'])->paginate(10);
        $nonBookingTransactions = Kasir::whereNull('booking_id')->whereNull('user_id')->orderBy('created_at', 'desc')->get();

        foreach ($bookings as $booking) {
            $layananIds = json_decode($booking->layanan_id, true) ?? [];
            $processedLayanan = [];
            
            foreach ($layananIds as $key => $item) {
                // Normalisasi struktur data
                if (is_array($item) && isset($item['id'])) {
                    $layananId = $item['id'];
                    $quantity = $item['quantity'] ?? 1;
                } else {
                    $layananId = $item;
                    $quantity = 1;
                }
                
                $processedLayanan[] = [
                    'id' => $layananId,
                    'quantity' => $quantity
                ];
            }

            foreach ($nonBookingTransactions as $transaction) {
                if (!is_null($transaction->layanan_id)) {
                    // Pastikan layanan_id selalu berbentuk array (bukan string JSON)
                    if (is_string($transaction->layanan_id)) {
                        $transaction->layanan_id = json_decode($transaction->layanan_id, true) ?? [];
                    }
                } else {
                    $transaction->layanan_id = [];
                }
            }

            $produkIds = json_decode($booking->produk_id, true) ?? [];
            $processedProduk = [];
            
            foreach ($produkIds as $key => $item) {
                if (is_array($item) && isset($item['id'])) {
                    $produkId = $item['id'];
                    $quantity = $item['quantity'] ?? 1;
                } else {
                    $produkId = $item;
                    $quantity = 1;
                }
                
                $processedProduk[] = [
                    'id' => $produkId,
                    'quantity' => $quantity
                ];
            }

            $booking->layanan_id = json_encode($processedLayanan);
            $booking->produk_id = json_encode($processedProduk);
            
            // Tambahkan informasi DP
            $booking->dp_paid = false;
            $booking->dp_amount = 0;
            
            if ($booking->order_id) {
                $order = Order::find($booking->order_id);
                if ($order && $order->status == 'Paid') {
                    $booking->dp_paid = true;
                    $booking->dp_amount = $order->dp;
                }
            }
        }

        return view('admin.kasir.index', compact('bookings', 'nonBookingTransactions'));
    }
    
    public function processPayment(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);
        $paymentMethod = $request->payment_method;
        
        // Cek apakah sudah bayar DP
        $dpPaid = false;
        $dpAmount = 0;
        if ($booking->order_id) {
            $order = Order::find($booking->order_id);
            if ($order && $order->status == 'Paid') {
                $dpPaid = true;
                $dpAmount = $order->dp;
            }
        }

        // Temukan atau buat record kasir
        $kasir = Kasir::where('booking_id', $booking->id)
            ->where('status_transaksi', 'pending')
            ->first();

        if (!$kasir) {
            $kasir = $this->createKasirRecord($booking);
        }

        if ($paymentMethod === 'tunai') {
            // Proses pembayaran tunai
            DB::transaction(function () use ($kasir, $booking) {
                // Update kasir record
                $kasir->metode_pembayaran = 'tunai';
                $kasir->status_transaksi = 'success';
                $kasir->save();
                
                // Update booking record
                $booking->status = 'selesai';
                $booking->metode_pembayaran = 'tunai';
                $booking->save();
                
                // Update checkout record
                $checkout = Checkout::where('booking_id', $booking->id)->first();
                if ($checkout) {
                    $checkout->status_pembayaran = 'paid';
                    $checkout->metode_pembayaran = 'tunai';
                    $checkout->save();
                }
            });
            
            return redirect()->route('admin.kasir.index')->with('success', 'Pembayaran tunai berhasil diproses.');
        } elseif ($paymentMethod === 'midtrans') {
            $kasir->metode_pembayaran = 'midtrans';
            $kasir->save();
            
            $checkout = Checkout::where('booking_id', $booking->id)->first();
            if ($checkout) {
                $checkout->metode_pembayaran = 'midtrans';
                $checkout->save();
            }
            
            // Proses pembayaran via Midtrans
            $result = $this->midtransService->createFullPaymentTransaction($booking, $kasir);
            
            if (isset($result['error'])) {
                return redirect()->back()->with('error', 'Gagal membuat transaksi: ' . $result['error']);
            }
            
            return view('admin.kasir.midtrans', [
                'snapToken' => $result['snap_token'],
                'booking' => $booking,
                'clientKey' => env('MIDTRANS_CLIENT_KEY'),
                'dpPaid' => $dpPaid,
                'dpAmount' => $dpAmount
            ]);
        }
        
        return redirect()->back()->with('error', 'Metode pembayaran tidak valid.');
    }

    protected function createKasirRecord(Booking $booking)
{
    // Hitung total harga
    $total = 0;
    $layananItems = json_decode($booking->layanan_id, true) ?? [];
    
    foreach ($layananItems as $layananItem) {
        if (is_array($layananItem) && isset($layananItem['id'])) {
            $layananId = $layananItem['id'];
            $quantity = $layananItem['quantity'] ?? 1;
        } else {
            $layananId = $layananItem;
            $quantity = 1;
        }
        
        // Ensure we get a single model instance
        $layanan = Layanan::where('id', $layananId)->first();
        
        if ($layanan && isset($layanan->harga)) {
            $total += $layanan->harga * $quantity;
        } else {
            Log::warning("Layanan not found or missing harga for ID: " . $layananId);
        }
    }
    
    // Rest of the method remains the same...
    $transactionId = 'TRX-' . time() . '-' . \Illuminate\Support\Str::random(5);
    
    $kasir = Kasir::create([
        'id' => $transactionId,
        'user_id' => $booking->user_id,
        'layanan_id' => $booking->layanan_id,
        'booking_id' => $booking->id,
        'total_harga' => $total,
        'metode_pembayaran' => '',
        'transaction_id' => $transactionId,
        'status_transaksi' => 'pending',
        'payment_type' => 'full',
        'dp_order_id' => $booking->order_id ?? null,
    ]);
    
    $checkout = Checkout::where('booking_id', $booking->id)->first();
    if (!$checkout) {
        Checkout::create([
            'id' => 'CHK-' . time() . '-' . \Illuminate\Support\Str::random(5),
            'user_id' => $booking->user_id,
            'cart_id' => null,
            'booking_id' => $booking->id,
            'total_harga' => $total,
            'status_pembayaran' => 'unpaid',
            'metode_pembayaran' => '',
        ]);
    }
    
    return $kasir;
}
    
    public function midtransCallback(Request $request)
    {
        $notificationJson = json_decode($request->getContent(), true);
        $orderId = $notificationJson['order_id'];
        $transactionStatus = $notificationJson['transaction_status'];
        $fraudStatus = $notificationJson['fraud_status'] ?? null;
        
        $status = 'pending';
        
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $status = 'pending';
            } else if ($fraudStatus == 'accept') {
                $status = 'success';
            }
        } else if ($transactionStatus == 'settlement') {
            $status = 'success';
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $status = 'failed';
        } else if ($transactionStatus == 'pending') {
            $status = 'pending';
        }
        
        // Find the Kasir record
        $kasir = Kasir::where('id', $orderId)->orWhere('transaction_id', $orderId)->first();
        
        if ($kasir) {
            // Update the Kasir record
            $kasir->status_transaksi = $status;
            $kasir->save();
            
            // If payment is successful, update related records
            if ($status == 'success') {
                // Get the booking directly using the booking_id from kasir
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
        
        return response()->json(['status' => 'OK']);
    }

    public function midtransFinish(Request $request)
    {
        $orderId = $request->order_id;
        $status = $request->transaction_status;
        
        Log::info("Midtrans Finish: Order ID = $orderId, Status = $status");
        
        if ($status == 'settlement' || $status == 'capture') {
            $kasir = Kasir::where('id', $orderId)->orWhere('transaction_id', $orderId)->first();
            
            if ($kasir) {
                Log::info("Kasir found: " . $kasir->id . ", Booking ID: " . $kasir->booking_id);
                
                $kasir->status_transaksi = 'success';
                $kasir->save();
                
                $booking = Booking::find($kasir->booking_id);
                
                if ($booking) {
                    Log::info("Booking found: " . $booking->id);
                    
                    $booking->status = 'selesai';
                    $booking->metode_pembayaran = 'non-tunai';
                    $booking->save();
                    
                    $checkout = Checkout::where('booking_id', $booking->id)->first();
                    if ($checkout) {
                        Log::info("Checkout found: " . $checkout->id);
                        
                        $checkout->status_pembayaran = 'paid';
                        $checkout->metode_pembayaran = 'non-tunai';
                        $checkout->save();
                    } else {
                        Log::warning("Checkout not found for booking: " . $booking->id);
                    }
                } else {
                    Log::warning("Booking not found for kasir: " . $kasir->id . " with booking_id: " . $kasir->booking_id);
                }
            } else {
                Log::warning("Kasir not found for order ID: " . $orderId);
            }
            
            return redirect()->route('admin.kasir.index')->with('success', 'Pembayaran berhasil.');
        } else {
            return redirect()->route('admin.kasir.index')->with('error', 'Pembayaran belum selesai atau gagal.');
        }
    }

    public function addNonBookingCustomer(Request $request)
    {
        // Validasi request
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'layanan_id' => 'required|array',
            'quantity' => 'required|integer|min:1',
            'kursi' => 'required|string'
        ]);
        
        // Proses layanan yang dipilih
        $layananItems = [];
        foreach ($request->layanan_id as $layananId) {
            $layananItems[] = [
                'id' => $layananId,
                'quantity' => $request->quantity
            ];
        }
        
        // Hitung total harga
        $totalHarga = 0;
        foreach ($layananItems as $item) {
            $layanan = Layanan::find($item['id']);
            if ($layanan) {
                $totalHarga += $layanan->harga * $item['quantity'];
            }
        }
        
        // Buat ID transaksi
        $transactionId = 'TRX-' . time() . '-' . Str::random(5);
        
        // Simpan ke tabel kasirs tanpa user_id dan booking_id
        $kasir = Kasir::create([
            'id' => $transactionId,
            'user_id' => null, // Customer non-booking
            'booking_id' => null, // Tidak ada booking
            'layanan_id' => json_encode($layananItems),
            'total_harga' => $totalHarga,
            'metode_pembayaran' => '',
            'transaction_id' => $transactionId,
            'status_transaksi' => 'pending',
            'payment_type' => 'full',
            'customer_name' => $request->customer_name, // Simpan nama customer
            'kursi' => $request->kursi
        ]);
        
        // Redirect ke halaman pembayaran
        return redirect()->route('admin.kasir.payment-options', $kasir->id)
            ->with('success', 'Customer non-booking berhasil ditambahkan');
    }

    public function paymentOptions($kasirId)
    {
        $kasir = Kasir::findOrFail($kasirId);
        return view('admin.kasir.payment-options', compact('kasir'));
    }

    public function processNonBookingPayment(Request $request, $kasirId)
    {
        $kasir = Kasir::findOrFail($kasirId);
        $paymentMethod = $request->payment_method;
        
        if ($paymentMethod === 'tunai') {
            // Proses pembayaran tunai
            $kasir->metode_pembayaran = 'tunai';
            $kasir->status_transaksi = 'success';
            $kasir->save();
            
            return redirect()->route('admin.kasir.index')
                ->with('success', 'Pembayaran tunai berhasil diproses');
        } elseif ($paymentMethod === 'midtrans') {
            $kasir->metode_pembayaran = 'midtrans';
            $kasir->save();
            
            // Siapkan data customer untuk midtrans
            $customerName = $request->customer_name ?? $kasir->customer_name;
            $customerEmail = $request->customer_email ?? 'guest@example.com';
            $customerPhone = $request->customer_phone ?? '';
            
            // Proses pembayaran via Midtrans
            $result = $this->processNonBookingMidtrans($kasir, $customerName, $customerEmail, $customerPhone);
            
            if (isset($result['error'])) {
                return redirect()->back()->with('error', 'Gagal membuat transaksi: ' . $result['error']);
            }
            
            return view('admin.kasir.midtrans-non-booking', [
                'snapToken' => $result['snap_token'],
                'kasir' => $kasir,
                'clientKey' => env('MIDTRANS_CLIENT_KEY'),
            ]);
        }
        
        return redirect()->back()->with('error', 'Metode pembayaran tidak valid.');
    }

    protected function processNonBookingMidtrans($kasir, $customerName, $customerEmail, $customerPhone)
    {
        $layananItems = is_array($kasir->layanan_id) ? $kasir->layanan_id  : (json_decode($kasir->layanan_id, true) ?? []);

        $items = [];
        
        foreach ($layananItems as $item) {
            if (is_array($item) && isset($item['id'])) {
                $layananId = $item['id'];
                $quantity = $item['quantity'] ?? 1;
            } else {
                $layananId = $item;
                $quantity = 1;
            }
            
            $layanan = Layanan::where('id', $layananId)->first();
            
            if ($layanan) {
                $items[] = [
                    'id' => $layanan->id,
                    'price' => $layanan->harga,
                    'quantity' => $quantity,
                    'name' => $layanan->nama_layanan,
                ];
            }
        }
        
        $transactionData = [
            'transaction_details' => [
                'order_id' => $kasir->id,
                'gross_amount' => $kasir->total_harga,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $customerName,
                'email' => $customerEmail,
                'phone' => $customerPhone,
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
}