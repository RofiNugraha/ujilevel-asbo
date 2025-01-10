<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatTransaksi;
use Illuminate\Http\Request;

class AdminRiwayatTransaksiController extends Controller
{
    public function index()
    {
        $riwayat = RiwayatTransaksi::with(['user', 'layanan'])->get();
        return view('admin.riwayat.index', compact('riwayat'));
    }

    public function edit($id)
    {
        $riwayat = RiwayatTransaksi::with(['user', 'layanan'])->findOrFail($id);
        return view('admin.riwayat.edit', compact('riwayat'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'layanan_id' => 'required|exists:layanans,id',
            'tanggal_transaksi' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string|max:255',
        ]);

        $riwayatTransaksi = RiwayatTransaksi::findOrFail($id);

        $riwayatTransaksi->update([
            'user_id' => $request->user_id,
            'layanan_id' => $request->layanan_id,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'jumlah_bayar' => $request->jumlah_bayar,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        return redirect()->route('admin.riwayat.index')->with('success', 'Data riwayat transaksi berhasil diperbarui.');
    }

}