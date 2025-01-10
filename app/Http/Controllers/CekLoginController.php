<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Booking;
use App\Models\Notifikasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CekLoginController extends Controller
{
    public function form()
        {
            return view('formbook');
        }
        
        public function store(Request $request)
        {
            $validated = $request->validate([
                'tipe_customer' => 'required|in:anak,dewasa',
                'layanan_tambahan' => 'required|in:cukur_jenggot,cukur_kumis,cukur_jenggot_kumis,tidak_ada',
                'kursi' => 'required|in:satu,dua',
                'jam_booking' => 'required|date|after_or_equal:now',
                'deskripsi' => 'nullable|string',
            ]);
    
            $jamBooking = Carbon::parse($request->jam_booking);
    
            $start = $jamBooking->copy()->subMinutes(30);
            $end = $jamBooking->copy()->addMinutes(30);
    
            $conflict = Booking::where('jam_booking', '>=', $start)
                ->where('jam_booking', '<=', $end)
                ->where('kursi', $request->kursi)
                ->exists();
    
            if ($conflict) {
                return redirect()->back()
                    ->withErrors(['jam_booking' => 'Jam booking berbenturan dengan pemesanan lain pada kursi yang sama. Silakan pilih jam yang lain.'])
                    ->withInput();
            }
    
            $hargaAwal = $request->tipe_customer === 'anak' ? 13000 : 15000;
            $hargaTambahan = $request->layanan_tambahan !== 'tidak_ada' ? 5000 : 0;
            $validated['harga'] = $hargaAwal + $hargaTambahan;
    
            $layanan = Layanan::create($validated);
    
            if ($layanan) {
                $booking = Booking::create([
                    'user_id' => Auth::id(),
                    'layanan_id' => $layanan->id,
                    'jam_booking' => $jamBooking,
                    'status' => 'pending',
                    'status_pembayaran' => 'belum',
                    'kursi' => $request->kursi,
                ]);
                
                Notifikasi::create([
                    'user_id' => Auth::id(),
                    'booking_id' => $booking->id,
                    'pesan' => 'Pemesanan layanan Anda berhasil untuk tipe customer ' . $layanan->tipe_customer . '.',
                    'tanggal_notifikasi' => now(),
                    'status_dibaca' => false,
                ]);
            }
    
            return redirect()->route('dashboard')
                ->with('success', 'Layanan berhasil ditambahkan dan pemesanan serta notifikasi telah dibuat.');
        }
}   