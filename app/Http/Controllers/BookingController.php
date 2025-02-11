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
            'kursi' => 'required',
            'jam_booking' => 'required|date|after:now',
            'items' => 'required|array',
            'items.*.layanan_id' => 'nullable|exists:layanans,id',
            'items.*.produk_id' => 'nullable|exists:produks,id',
            'items.*.quantity' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
        ]);

        $jam_booking = Carbon::parse($request->jam_booking);
        $existingBooking = Booking::where('kursi', $request->kursi)
            ->whereBetween('jam_booking', [$jam_booking->copy()->subMinutes(40), $jam_booking->copy()->addMinutes(40)])
            ->exists();

        if ($existingBooking) {
            return redirect()->back()->withErrors(['msg' => 'Jam booking berbenturan dengan customer lain.']);
        }

        foreach ($request->items as $item) {
            if (!isset($item['layanan_id']) && !isset($item['produk_id'])) {
                return redirect()->back()->withErrors(['msg' => 'Harap pilih minimal satu layanan atau produk.']);
            }

            Booking::create([
                'user_id' => Auth::id(),
                'layanan_id' => $item['layanan_id'],
                'produk_id' => $item['produk_id'],
                'kursi' => $request->kursi,
                'jam_booking' => $jam_booking,
                'deskripsi' => $request->deskripsi,
                'status' => 'pending',
                'metode_pembayaran' => null,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Booking berhasil!');
    }

    public function formBook($layanan_id = null, $produk_id = null)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        $cartItems = $cart ? $cart->cartItems()->with(['layanan', 'produk'])->get() : collect();

        $layanan_ids = $layanan_id ? explode(',', $layanan_id) : [];
        $produk_ids = $produk_id ? explode(',', $produk_id) : [];

        $layanans = Layanan::whereIn('id', $layanan_ids)->get();
        $produks = Produk::whereIn('id', $produk_ids)->get();

        $cartCount = $cart->cartItems()->with(['layanan', 'produk'])->get();

        foreach ($cartCount as $item) {
            if ($item->produk_id) {
                $item->gambar = $item->produk->gambar ?? 'default.jpg';
            } elseif ($item->layanan_id) {
                $item->gambar = $item->layanan->gambar ?? 'default.jpg';
            } else {
                $item->gambar = 'default.jpg';
            }

            if ($item->produk_id) {
                $item->subtotal = $item->produk->harga * $item->quantity;
            } elseif ($item->layanan_id) {
                $item->subtotal = $item->layanan->harga * $item->quantity;
            } else {
                $item->subtotal = 0;
            }
        }

        return view('formbook', compact('cartItems', 'cartCount', 'layanan_ids', 'produk_ids', 'layanans', 'produks'));
    }
}