<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('email', $user->email)->first();

            if ($finduser) {
                Auth::login($finduser);
                
                // Add success message for SweetAlert
                $message = 'Login dengan Google berhasil! Selamat datang kembali, ' . $finduser->name;
                
                // Redirect berdasarkan usertype
                if ($finduser->usertype === 'admin') {
                    return redirect()->route('admin.dashboard', ['sweet_alert' => base64_encode($message)]);
                }
                return redirect()->intended(route('dashboard', ['sweet_alert' => base64_encode($message)]));
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => bcrypt(rand(100000, 999999)),
                    'usertype' => 'user',
                    'image' => $user->avatar,
                    'nama_lengkap' => $user->name,
                ]);

                Auth::login($newUser);
                
                session()->flash('success', 'Pendaftaran dengan Google berhasil! Selamat datang, ' . $newUser->name);
                
                return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            session()->flash('error', 'Autentikasi Google gagal. Silakan coba lagi.');
            return redirect('login');
        }
    }
}