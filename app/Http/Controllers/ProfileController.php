<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Booking;
use App\Models\CartItem;
use App\Models\Layanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function show()
    {
        $user = Auth::user();
        
        $bookings = Booking::with(['user', 'checkout'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'konfirmasi'])
            ->get();

            foreach ($bookings as $booking) {
                $layananIds = json_decode($booking->layanan_id, true);
                $booking->layanans = Layanan::whereIn('id', $layananIds)->get();
            }

        return view('profil', compact('user', 'bookings'));
    }

    
    public function showBooking(string $id) {
        $user = Auth::user();
        
        $booking = Booking::with(['user', 'checkout'])
                ->where('id', $id)
                ->firstOrFail();

        $layananIds = json_decode($booking->layanan_id, true);
        $booking->layanans = Layanan::whereIn('id', $layananIds)->get();
        
        return view('viewbooking', compact('booking'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}