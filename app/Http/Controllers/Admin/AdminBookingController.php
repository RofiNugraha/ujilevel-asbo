<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CartItem;
use App\Models\Layanan;
use App\Models\Produk;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user')->paginate(10);

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
        $layananIds = json_decode($bookings->layanan_id, true);
        $layanans = Layanan::whereIn('id', $layananIds)->get();
        $produkIds = json_decode($bookings->produk_id, true);
        $produks = Produk::whereIn('id', $produkIds)->get();

        return view('admin.booking.edit', compact('bookings', 'layanans', 'produks'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'layanan_id' => 'required|json',
            'produk_id' => 'nullable|json',
            'jam_booking' => 'required|date_format:Y-m-d H:i:s',
            'kursi' => 'required|in:satu,dua',
            'deskripsi' => 'required|string',
        ]);

        $bookings = Booking::findOrFail($id);
        $bookings->update($request->all());

        return view('admin.booking.index')->with('success', 'Booking berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.booking.index');
    }
}