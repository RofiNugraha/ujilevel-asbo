<?php

namespace App\Http\Controllers\Admin;

use App\Events\BookingUpdated;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CartItem;
use App\Models\Checkout;
use App\Models\Kasir;
use App\Models\Layanan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user')->whereIn('status', ['pending', 'batal'])->paginate(10);

        foreach ($bookings as $booking) {
            $layananIds = json_decode($booking->layanan_id, true) ?? [];
            foreach ($layananIds as $key => $layananId) {
                $cartItem = CartItem::where('layanan_id', $layananId)
                    ->whereHas('cart', function ($query) use ($booking) {
                        $query->where('user_id', $booking->user_id);
                    })->first();
                $layananIds[$key] = [
                    'id' => $layananId,
                    'quantity' => $cartItem->quantity ?? 1
                ];
            }

            $produkIds = json_decode($booking->produk_id, true) ?? [];
            foreach ($produkIds as $key => $produkId) {
                $cartItem = CartItem::where('produk_id', $produkId)
                    ->whereHas('cart', function ($query) use ($booking) {
                        $query->where('user_id', $booking->user_id);
                    })->first();
                $produkIds[$key] = [
                    'id' => $produkId,
                    'quantity' => $cartItem->quantity ?? 1
                ];
            }

            $booking->layanan_id = json_encode($layananIds);
            $booking->produk_id = json_encode($produkIds);
        }

        return view('admin.booking.index', compact('bookings'));
    }

    public function edit(string $id)
    {
        $bookings = Booking::findOrFail($id);

        $layananIds = json_decode($bookings->layanan_id, true) ?? [];
        $layananIdList = is_array($layananIds) ? $layananIds : [];
        $layanans = Layanan::whereIn('id', $layananIdList)->get();

        return view('admin.booking.edit', compact('bookings', 'layanans'));
    }

    public function update(Request $request, string $id)
    {
        $request->merge([
            'layanan_id' => is_string($request->layanan_id) ? json_decode($request->layanan_id, true) : $request->layanan_id,
        ]);

        $request->validate([
            'layanan_id' => 'required|array',
            'jam_booking' => 'required|date_format:Y-m-d\TH:i',
            'kursi' => 'required|in:satu,dua',
            'status' => 'required|string|max:20',
        ]);

        $booking = Booking::findOrFail($id);

        $status_lama = $booking->status;
        $status_baru = $request->status;

        $booking->update([
            'layanan_id' => json_encode($request->layanan_id),
            'jam_booking' => \Carbon\Carbon::parse($request->jam_booking)->format('Y-m-d H:i:s'),
            'kursi' => $request->kursi,
            'status' => $status_baru,
        ]);

        // If status is updated to "konfirmasi", create a kasir record
        if ($status_lama !== $status_baru && $status_baru === 'konfirmasi') {
            $this->createKasirRecord($booking);
        }

        if ($status_lama !== $status_baru) {
            event(new \App\Events\BookingUpdated($booking, $status_baru));
        }

        return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil diperbarui.');
    }

    /**
     * Create a new kasir record for the booking
     *
     * @param Booking $booking
     * @return void
     */
    private function createKasirRecord($booking)
    {
        // Calculate total price
        $total = 0;
        $layananItems = json_decode($booking->layanan_id, true) ?? [];
        
        foreach ($layananItems as $layananItem) {
            // Periksa apakah $layananItem adalah array atau string
            if (is_array($layananItem) && isset($layananItem['id'])) {
                $layananId = $layananItem['id'];
                $quantity = $layananItem['quantity'] ?? 1;
            } else {
                // Jika $layananItem adalah string, maka itu adalah ID layanan langsung
                $layananId = $layananItem;
                $quantity = 1;
            }
            
            $layanan = \App\Models\Layanan::find($layananId);
            if ($layanan) {
                $total += $layanan->harga * $quantity;
            }
        }
        
        // Generate transaction ID
        $transactionId = 'TRX-' . time() . '-' . \Illuminate\Support\Str::random(5);
        
        // Create kasir record
        \App\Models\Kasir::create([
            'id' => $transactionId,
            'user_id' => $booking->user_id,
            'layanan_id' => $booking->layanan_id,
            'booking_id' => $booking->id, // Tambahkan booking_id dari objek booking
            'total_harga' => $total,
            'metode_pembayaran' => '', // Will be filled when payment is processed
            'transaction_id' => $transactionId,
            'status_transaksi' => 'pending',
        ]);
        
        // Check if checkout record exists, if not create one
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
    }

    public function destroy($id)
    {
        $booking = Booking::where('id', $id)->firstOrFail();

        if ($booking) {
            $booking->delete();
            return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil dihapus.');
        }

        return redirect()->route('admin.booking.index')->with('error', 'Booking tidak ditemukan.');
    }
}