<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->firstOrFail();
        $totalHarga = $cart->items->sum('harga');

        return view('checkout', compact('cart', 'totalHarga'));
    }

    /**
     * Memproses checkout dan pembayaran
     */
    public function process()
    {
    }

    /**
     * Menampilkan halaman sukses setelah checkout
     */
    public function success()
    {
        return view('checkout_success');
    }
}