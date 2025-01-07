<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;

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
        $request->validate([
            'tipe_customer' => 'required|in:anak,dewasa',
            'layanan_tambahan' => 'required|in:cukur_jenggot,cukur_kumis,cukur_jenggot_kumis,tidak_ada',
            'kursi' => 'required|in:satu,dua',
            'jam_booking' => 'required|date',
            'harga' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        Layanan::create($request->all());

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
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
    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'tipe_customer' => 'required|in:anak,dewasa',
            'layanan_tambahan' => 'required|in:cukur_jenggot,cukur_kumis,cukur_jenggot_kumis,tidak_ada',
            'kursi' => 'required|in:satu,dua',
            'jam_booking' => 'required|date',
            'harga' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        $layanan->update($request->all());

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layanan $layanan)
    {
        $layanan->delete();

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}