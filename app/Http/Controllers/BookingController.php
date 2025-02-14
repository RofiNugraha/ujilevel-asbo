<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kursi' => 'required|string',
            'jam_booking' => 'required|date|after:now',
            'deskripsi' => 'required|string',
            'items' => 'required|array',
            'items.*.layanan_id' => 'nullable|exists:layanans,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->back()->withErrors(['msg' => 'Keranjang Anda kosong. Silakan tambahkan layanan sebelum checkout.']);
        }

        $jam_booking = Carbon::parse($request->jam_booking);

        $existingBooking = Booking::where('kursi', $request->kursi)
            ->whereBetween('jam_booking', [$jam_booking->copy()->subMinutes(40), $jam_booking->copy()->addMinutes(40)])
            ->exists();

        if ($existingBooking) {
            return redirect()->back()->withErrors(['msg' => 'Jam booking berbenturan dengan customer lain.']);
        }

        $layananIds = [];
        $total_harga = 0;

        foreach ($request->items as $item) {
            if (!empty($item['layanan_id'])) {
                $layanan = Layanan::find($item['layanan_id']);
                if ($layanan) {
                    $layananIds[] = $item['layanan_id'];
                    $total_harga += $layanan->harga * $item['quantity'];
                }
            }
        }

        if (empty($layananIds)) {
            return redirect()->back()->withErrors(['msg' => 'Silakan pilih minimal satu layanan sebelum melanjutkan booking.']);
        }

        $userId = Auth::id();
        $layananKey = implode('', $layananIds);
        $timestamp = now()->format('ymdHis');
        $randomString = Str::random(5);

        $generatedId = substr(md5($userId . $layananKey . $timestamp . $randomString), 0, 10);

        while (Booking::where('id', $generatedId)->exists()) {
            $randomString = Str::random(5);
            $generatedId = substr(md5($userId . $layananKey . now()->format('ymdHis') . $randomString), 0, 10);
        }

        Booking::create([
            'id' => $generatedId,
            'user_id' => $userId,
            'kursi' => $request->kursi,
            'jam_booking' => $jam_booking,
            'layanan_id' => json_encode($layananIds),
            'status' => 'pending',
            'metode_pembayaran' => 'belum dipilih',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        do {
            $checkoutId = random_int(1000000000, 9999999999);
        } while (Checkout::where('id', $checkoutId)->exists());

        Checkout::create([
            'id' => $checkoutId,
            'user_id' => $user->id,
            'cart_id' => $cart->id,
            'total_harga' => $total_harga,
            'status_pembayaran' => 'belum bayar',
            'metode_pembayaran' => 'belum dipilih',
        ]);

        $cart->cartItems()->delete();

        return redirect()->route('dashboard')->with('success', 'Booking berhasil!');
    }
}