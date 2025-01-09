<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Booking;
use App\Models\Notifikasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

class AdminLayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $layanan = Layanan::all();
        return view('admin.layanan.index', compact('layanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.layanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe_customer' => 'required|in:anak,dewasa',
            'layanan_tambahan' => 'required|in:cukur_jenggot,cukur_kumis,cukur_jenggot_kumis,tidak_ada',
            'kursi' => 'required|in:satu,dua',
            'jam_booking' => 'required|date|after_or_equal:now',
            'deskripsi' => 'nullable|string',
        ]);

        $jamBooking = Carbon::parse($request->jam_booking)->timezone('Asia/Jakarta');

        $start = $jamBooking->copy()->subMinutes(30);
        $end = $jamBooking->copy()->addMinutes(30);

        $conflict = Booking::whereBetween('jam_booking', [$start, $end])->exists();

        if ($conflict) {
            return redirect()->back()
                ->withErrors(['jam_booking' => 'Jam booking berbenturan dengan pemesanan lain. Silakan pilih jam yang lain.'])
                ->withInput();
        }

        $hargaAwal = 15000;
        $hargaTambahan = $request->layanan_tambahan !== 'tidak_ada' ? 5000 : 0;
        $validated['harga'] = $hargaAwal + $hargaTambahan;

        $layanan = Layanan::create($validated);

        if ($layanan) {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'layanan_id' => $layanan->id,
                'jam_booking' => $jamBooking,
                'status' => 'dibooking',
                'status_pembayaran' => 'belum',
            ]);

            Notifikasi::create([
                'user_id' => Auth::id(),
                'booking_id' => $booking->id,
                'pesan' => 'Pemesanan layanan Anda berhasil untuk tipe customer ' . $layanan->tipe_customer . '.',
                'tanggal_notifikasi' => now(),
                'status_dibaca' => false,
            ]);
        }

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan dan pemesanan serta notifikasi telah dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Layanan $layanan)
    {
        return view('admin.layanan.show', compact('layanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('admin.layanan.edit', compact('layanan'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tipe_customer' => 'required|in:anak,dewasa',
            'layanan_tambahan' => 'required|in:cukur_jenggot,cukur_kumis,cukur_jenggot_kumis,tidak_ada',
            'kursi' => 'required|in:satu,dua',
            'jam_booking' => 'required|date',
            'harga' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        $layanan = Layanan::findOrFail($id);

        $layanan->update($request->all());
        return redirect()->route('admin.layanan.index')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Temukan layanan berdasarkan ID
        $layanan = Layanan::findOrFail($id);

        // Mengambil semua data booking yang terkait dengan layanan
        $bookings = Booking::where('layanan_id', $layanan->id)->get();

        // Menghapus notifikasi yang terkait dengan setiap booking
        foreach ($bookings as $booking) {
            Notifikasi::where('booking_id', $booking->id)->delete();
        }

        // Menghapus semua booking yang terkait dengan layanan
        foreach ($bookings as $booking) {
            $booking->delete();
        }

        // Menghapus layanan
        $layanan->delete();

        // Mengarahkan kembali dengan pesan sukses
        return redirect()->route('admin.layanan.index')->with('success', 'Layanan beserta data terkait (booking dan notifikasi) telah berhasil dihapus.');
    }

}