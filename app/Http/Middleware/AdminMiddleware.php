<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in to access this page.');
        }

        // Periksa apakah pengguna memiliki role admin
        if (Auth::user()->usertype !== 'admin') {
            return redirect('/')->with('error', 'You are not authorized to access this page.');
        }

        // Lanjutkan permintaan jika pengguna adalah admin
        return $next($request);
    }
}