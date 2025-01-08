<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Layanan;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booking = Booking::with(['user', 'layanan'])->get();
        return response()->json($booking);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        $layanan = Layanan::all();
        return view('adin.booking.create', compact('user', 'layanan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'status_pembayaran' => 'required|in:sudah,belum',
        ]);

        $layanan = Layanan::findOrFail($validated['layanan_id']);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'layanan_id' => $layanan->id,
            'status' => 'dibooking',
            'status_pembayaran' => $validated['status_pembayaran'],
        ]);

        Notifikasi::create([
            'user_id' => Auth::id(),
            'booking_id' => $booking->id,
            'pesan' => 'Pemesanan layanan ' . $layanan->tipe_customer . ' berhasil.',
            'tanggal_notifikasi' => now(),
            'status_dibaca' => false,
        ]);

        return response()->json([
            'message' => 'Pemesanan berhasil dilakukan dan notifikasi telah dikirim.',
            'booking' => $booking,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::with(['user', 'layanan'])->findOrFail($id);
        return response()->json($booking);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $user = User::all();
        $layanan = Layanan::all();
        return view('admin.bookings.edit', compact('booking', 'user', 'layanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'layanan_id' => 'required|exists:layanans,id',
            'status' => 'required|in:dibooking,selesai,dibatalkan',
            'status_pembayaran' => 'required|in:sudah,belum',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update($request->all());

        return response()->json(['message' => 'Booking updated successfully.', 'data' => $booking]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully.']);
    }
}