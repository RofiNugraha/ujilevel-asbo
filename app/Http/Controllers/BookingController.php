<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Layanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            'items.*.produk_id' => 'nullable|exists:produks,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->back()->withErrors(['msg' => 'Keranjang Anda kosong. Silakan tambahkan layanan atau produk sebelum checkout.']);
        }

        $jam_booking = Carbon::parse($request->jam_booking);

        $existingBooking = Booking::where('kursi', $request->kursi)
            ->whereBetween('jam_booking', [$jam_booking->copy()->subMinutes(40), $jam_booking->copy()->addMinutes(40)])
            ->exists();

        if ($existingBooking) {
            return redirect()->back()->withErrors(['msg' => 'Jam booking berbenturan dengan customer lain.']);
        }

        $layananIds = [];
        $produkIds = [];
        $total_harga = 0;

        foreach ($request->items as $item) {
            if (!empty($item['layanan_id'])) {
                $layanan = Layanan::find($item['layanan_id']);
                if ($layanan) {
                    $layananIds[] = $item['layanan_id'];
                    $total_harga += $layanan->harga * $item['quantity'];
                }
            }
            if (!empty($item['produk_id'])) {
                $produk = Produk::find($item['produk_id']);
                if ($produk) {
                    $produkIds[] = $item['produk_id'];
                    $total_harga += $produk->harga * $item['quantity'];
                }
            }
        }

        $userId = Auth::id();

        $layananId = !empty($layananIds) ? min($layananIds) : null;
        $produkId = !empty($produkIds) ? min($produkIds) : null;

        $idComponents = [$userId];
        if ($layananId) {
            $idComponents[] = $layananId;
        }
        if ($produkId) {
            $idComponents[] = $produkId;
        }
        $uniqueSuffix = date('y');
        $generatedId = substr(implode('', $idComponents) . $uniqueSuffix, 0, 10);

        Booking::create([
            'id' => $generatedId,
            'user_id' => $userId,
            'kursi' => $request->kursi,
            'jam_booking' => $jam_booking,
            'layanan_id' => json_encode($layananIds),
            'produk_id' => json_encode($produkIds),
            'status' => 'pending',
            'deskripsi' => $request->deskripsi ?? '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Checkout::create([
            'user_id' => $user->id,
            'cart_id' => $cart->id,
            'total_harga' => $total_harga,
            'status_pembayaran' => 'belum bayar',
            'metode_pembayaran' => '',
        ]);

        $cart->cartItems()->delete();

        return redirect()->route('dashboard')->with('success', 'Booking berhasil!');
    }
}