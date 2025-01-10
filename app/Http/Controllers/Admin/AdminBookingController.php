<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Layanan;
use App\Models\Notifikasi;
use App\Models\User;
use App\Models\RiwayatTransaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booking = Booking::with(['user', 'layanan'])->get();
        return view('admin.booking.index', compact('booking'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        $layanan = Layanan::all();
        return view('admin.booking.create', compact('user', 'layanan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'jam_booking' => 'required|date|after_or_equal:now',
            'status_pembayaran' => 'required|in:sudah,belum',
            'kursi' => 'required|in:satu,dua',
        ]);

        $jamBooking = Carbon::parse($validated['jam_booking']);
        $start = $jamBooking->copy()->subMinutes(30);
        $end = $jamBooking->copy()->addMinutes(30);

        $conflict = Booking::where('layanan_id', $validated['layanan_id'])
            ->where('kursi', $validated['kursi'])
            ->whereBetween('jam_booking', [$start, $end])
            ->exists();

        if ($conflict) {
            return response()->json([
                'message' => 'Jam booking berbenturan dengan pemesanan lain pada kursi yang sama. Silakan pilih jam lain.',
            ], 422);
        }

        $layanan = Layanan::findOrFail($validated['layanan_id']);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'layanan_id' => $layanan->id,
            'jam_booking' => $jamBooking,
            'status' => 'pending',
            'status_pembayaran' => $validated['status_pembayaran'],
        ]);

        Notifikasi::create([
            'user_id' => Auth::id(),
            'booking_id' => $booking->id,
            'pesan' => 'Pesanan Anda berhasil dilakukan dan menunggu konfirmasi.',
            'tanggal_notifikasi' => now(),
            'status_dibaca' => false,
        ]);

        return response()->json([
            'message' => 'Pemesanan berhasil dilakukan dan notifikasi telah dikirim.',
            'booking' => $booking,
        ]);
    }

    public function edit($id)
    {
        $booking = Booking::with(['user', 'layanan'])->findOrFail($id);
        return view('admin.booking.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:dibooking,selesai,dibatalkan',
            'status_pembayaran' => 'required|in:sudah,belum',
        ]);

        $booking = Booking::findOrFail($id);

        $oldStatus = $booking->status;

        $booking->update($request->all());

        $pesan = null;
        if ($oldStatus !== $request->status) {
            if ($request->status === 'dibooking') {
                $pesan = "Pesanan Anda berhasil dibooking. Harap hadir sesuai waktu yang telah ditentukan.";
            } elseif ($request->status === 'dibatalkan') {
                $pesan = "Pesanan dibatalkan oleh pemilik barber. Harap hubungi kami untuk informasi lebih lanjut.";
            } elseif ($request->status === 'selesai') {
                RiwayatTransaksi::create([
                    'user_id' => $booking->user_id,
                    'layanan_id' => $booking->layanan_id,
                    'tanggal_transaksi' => now(),
                    'jumlah_bayar' => $booking->layanan->harga,
                    'metode_pembayaran' => '?',
                ]);
                $pesan = "Pesanan Anda telah selesai. Terima kasih atas kepercayaan Anda.";
            }

            if ($pesan) {
                Notifikasi::create([
                    'user_id' => $booking->user_id,
                    'booking_id' => $booking->id,
                    'pesan' => $pesan,
                    'tanggal_notifikasi' => now(),
                    'status_dibaca' => false,
                ]);
            }
        }

        return redirect()->route('admin.booking.index')->with('success', 'Data berhasil diupdate.');
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