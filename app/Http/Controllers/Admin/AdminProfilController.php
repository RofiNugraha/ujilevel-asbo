<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Layanan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $bookings = Booking::with(['user', 'checkout'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'konfirmasi'])
            ->get()
            ->each(function ($booking) {
                $booking->layanans = Layanan::whereIn('id', json_decode($booking->layanan_id, true))->get();
            });
        
        return view('admin.profil.profil', compact('user', 'bookings'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to update your profile.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'nama_lengkap' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15|unique:users,phone,' . Auth::id(),
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        $user->name = $request->input('name');
        $user->nama_lengkap = $request->input('nama_lengkap');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        if ($request->hasFile('image')) {
            if ($user->image && file_exists(public_path('storage/profile_images/' . $user->image))) {
                unlink(public_path('storage/profile_images/' . $user->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            if (!file_exists(public_path('storage/profile_images'))) {
                mkdir(public_path('storage/profile_images'), 0777, true);
            }

            // Move image to public directory
            $image->move(public_path('storage/profile_images'), $imageName);
            
            // Save relative path to database
            $user->image = 'profile_images/' . $imageName;
        }

        User::where('id', $user->id)->update([
            'name' => $request->name,
            'nama_lengkap' => $request->nama_lengkap,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $user->image
        ]);

        return redirect()->route('admin.profil.profil')->with('success', 'Profile updated successfully.');
    }
}