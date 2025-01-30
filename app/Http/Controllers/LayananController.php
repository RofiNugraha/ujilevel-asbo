<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
        ]);

        Layanan::create($request->all());

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan!');
    }
}