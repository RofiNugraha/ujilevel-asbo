<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;

class AdminLayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::all();
        return view('admin.layanan.index', compact('layanans'));
    }

    public function create()
    {
        return view('admin.layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $layanan = new Layanan;
        $layanan->nama_layanan = $request->nama_layanan;
        $layanan->deskripsi = $request->deskripsi;
        $layanan->harga = $request->harga;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = storage_path('app/public/images');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $layanan->gambar = 'images/' . $filename;
        }
        
        $layanan->save();

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('admin.layanan.edit', compact('layanan'));
    }
    
    public function update(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

        $request->validate([
            'nama_layanan' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $layanan->nama_layanan = $request->nama_layanan;
        $layanan->deskripsi = $request->deskripsi;
        $layanan->harga = $request->harga;

        if ($request->hasFile('gambar')) {
            // Delete old image if it exists
            if ($layanan->gambar && file_exists(public_path('storage/' . $layanan->gambar))) {
                unlink(public_path('storage/' . $layanan->gambar));
            }
            
            // Get the file from the request
            $file = $request->file('gambar');
            
            // Generate a unique filename with original extension
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            $destinationPath = public_path('storage/images');
            
            // Make sure the directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $fileName);
            
            // Save the relative path to the database
            $layanan->gambar = 'images/' . $fileName;
        }

        $layanan->save();

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil diperbarui');
    }       

    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('admin.layanan.index');
    }
}