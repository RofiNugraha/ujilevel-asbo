<?php

namespace App\Http\Controllers\Admin;

use App\Events\BookingUpdated;
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

        if ($status_lama !== $status_baru) {
            event(new BookingUpdated($booking, $status_baru));
        }

        return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil diperbarui.');
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