<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            $user = Auth::user(); 
            
            if ($user && $user->usertype === 'admin') {
                return redirect()->intended(route('admin.dashboard', ['show_welcome' => true]));
            }

            return redirect()->intended(route('dashboard', ['show_welcome' => true]));
        } catch (\Exception $e) {
            session()->flash('error', 'Login gagal! Periksa email dan password Anda.');
            return back()->withInput($request->only('email'));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Add success message for SweetAlert
        session()->flash('success', 'Anda telah berhasil logout.');

        return redirect('/login');
    }
}