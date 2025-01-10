<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifikasi;

class AdminNotifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifikasi = Notifikasi::with(['user', 'booking'])->get();
        return view('admin.notifikasi.index', compact('notifikasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'booking_id' => 'required|exists:bookings,id',
            'pesan' => 'required|string',
            'tanggal_notifikasi' => 'required|date',
        ]);

        $notifikasi = Notifikasi::create([
            'user_id' => $validated['user_id'],
            'booking_id' => $validated['booking_id'],
            'pesan' => $validated['pesan'],
            'tanggal_notifikasi' => $validated['tanggal_notifikasi'],
            'status_dibaca' => false,
        ]);

        return response()->json($notifikasi, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $notifikasi = Notifikasi::with(['user', 'booking'])->findOrFail($id);
        return response()->json($notifikasi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $notifikasi = Notifikasi::findOrFail($id);

        $validated = $request->validate([
            'pesan' => 'sometimes|string',
            'tanggal_notifikasi' => 'sometimes|date',
            'status_dibaca' => 'sometimes|boolean',
        ]);

        $notifikasi->update($validated);

        return response()->json($notifikasi);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $notifikasi->delete();

        return response()->json(['message' => 'Notifikasi deleted successfully.']);
    }
}