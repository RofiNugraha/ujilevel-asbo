<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminCustomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customs = Custom::latest()->get();
        return view('admin.custom.index', compact('customs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.custom.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'jam_operasional' => 'nullable|string|max:255',
            'link_instagram' => 'nullable|url|max:255',
            'link_facebook' => 'nullable|url|max:255',
            'link_whatsapp' => 'nullable|url|max:255',
        ]);

        $data = $request->all();

        // Handle logo upload using move method
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            
            // Create directory if not exists
            $uploadPath = public_path('uploads/logos');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            // Move file to destination
            $logo->move($uploadPath, $logoName);
            $data['logo'] = 'uploads/logos/' . $logoName;
        }

        Custom::create($data);

        return redirect()->route('admin.custom.index')
                        ->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Custom $custom)
    {
        return view('admin.custom.edit', compact('custom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Custom $custom)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'jam_operasional' => 'nullable|string|max:255',
            'link_instagram' => 'nullable|url|max:255',
            'link_facebook' => 'nullable|url|max:255',
            'link_whatsapp' => 'nullable|url|max:255',
        ]);

        $data = $request->all();

        // Handle logo upload using move method
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($custom->logo && File::exists(public_path($custom->logo))) {
                File::delete(public_path($custom->logo));
            }

            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            
            // Create directory if not exists
            $uploadPath = public_path('uploads/logos');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            
            // Move file to destination
            $logo->move($uploadPath, $logoName);
            $data['logo'] = 'uploads/logos/' . $logoName;
        }

        $custom->update($data);

        return redirect()->route('admin.custom.index')
                        ->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Custom $custom)
    {
        // Delete logo file if exists
        if ($custom->logo && File::exists(public_path($custom->logo))) {
            File::delete(public_path($custom->logo));
        }

        $custom->delete();

        return redirect()->route('admin.custom.index')
                        ->with('success', 'Data berhasil dihapus!');
    }
}