<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart) {
            $cart = Cart::create(['user_id' => Auth::id()]);
        }

        $cartItems = $cart->cartItems;

        return view('cart', compact('cart', 'cartItems'));
    }

    public function addItem(Request $request, $layananId)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $layanan = Layanan::findOrFail($layananId);

        $cartItem = $cart->cartItems()->where('layanan_id', $layananId)->first();
        
        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->subtotal = $cartItem->quantity * $layanan->harga;
            $cartItem->save();
        } else {
            $cart->cartItems()->create([
                'layanan_id' => $layananId,
                'quantity' => $request->quantity,
                'subtotal' => $request->quantity * $layanan->harga,
            ]);
        }

        return redirect()->route('cart.index');
    }

    public function totalPrice($cartId)
    {
        $cart = Cart::findOrFail($cartId);
        $total = $cart->cartItems->sum('subtotal');
        return response()->json(['total_harga' => $total]);
    }
}