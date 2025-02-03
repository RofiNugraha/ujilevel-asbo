<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        $totalHarga = $cart->cartItems->sum('subtotal');

        return view('checkout.index', compact('cart', 'totalHarga'));
    }

    public function store(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        $checkout = Checkout::create([
            'user_id' => Auth::id(),
            'cart_id' => $cart->id,
            'total_harga' => $cart->cartItems->sum('subtotal'),
            'status_pembayaran' => 'belum',
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        return redirect()->route('checkout.show', $checkout->id);
    }

    public function show($id)
    {
        $checkout = Checkout::findOrFail($id);
        return view('checkout.show', compact('checkout'));
    }
}