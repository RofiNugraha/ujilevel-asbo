<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class AdminKasirController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user')->whereIn('status', ['konfirmasi', 'batal'])->paginate(10);

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

        return view('admin.kasir.index', compact('bookings'));
    }
}