<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cart;
use App\Models\Checkout;
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
            'deskripsi' => 'nullable|string',
        ]);

        $jam_booking = Carbon::parse($request->jam_booking);
        $existingBooking = Booking::where('kursi', $request->kursi)
            ->whereBetween('jam_booking', [$jam_booking->subMinutes(40), $jam_booking->addMinutes(40)]) // Cek selisih 40 menit
            ->exists();

        if ($existingBooking) {
            return redirect()->back()->withErrors(['msg' => 'Jam booking Anda berbenturan dengan customer lain di kursi yang sama.']);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'kursi' => $request->kursi,
            'jam_booking' => $request->jam_booking,
            'deskripsi' => $request->deskripsi,
            'status_pembayaran' => 'pending',
        ]);

        return redirect()->route('pembayaran', ['booking_id' => $booking->id]);
    }

    public function pembayaran($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('pembayaran', compact('booking'));
    }

    public function prosesPembayaran(Request $request, $booking_id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string',
        ]);

        $booking = Booking::findOrFail($booking_id);

        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $booking->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => 'menunggu konfirmasi',
        ]);

        return redirect()->route('checkout', ['booking_id' => $booking->id]);
    }

    public function checkout($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        if ($booking->status_pembayaran !== 'menunggu konfirmasi') {
            return redirect()->route('pembayaran', ['booking_id' => $booking->id])
                ->withErrors(['msg' => 'Silakan pilih metode pembayaran terlebih dahulu.']);
        }

        Checkout::create([
            'user_id' => Auth::id(),
            'cart_id' => $booking->id,
            'total_harga' => 15000,
            'status_pembayaran' => 'berhasil',
            'metode_pembayaran' => $booking->metode_pembayaran,
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking berhasil diproses.');
    }
}