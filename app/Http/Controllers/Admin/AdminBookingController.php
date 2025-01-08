<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Layanan;
use App\Models\User;
use Illuminate\Http\Request;

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
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'layanan_id' => 'required|exists:layanans,id',
            'status' => 'required|in:dibooking,selesai,dibatalkan',
            'status_pembayaran' => 'required|in:sudah,belum',
        ]);

        $booking = Booking::create($request->all());

        return response()->json(['message' => 'Booking created successfully.', 'data' => $booking], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
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
    public function update(Request $request, $id)
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
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully.']);
    }
}