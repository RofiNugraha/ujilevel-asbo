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
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view your cart.');
        }

        $cart = Cart::where('user_id', $user->id)->first();
        $cartItems = $cart ? $cart->cartItems()->with('layanan')->get() : [];

        $total = $cartItems->sum('subtotal');

        return view('cart', compact('cartItems', 'total'));
    }                   

    public function addItem(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to add to cart.');
        }

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $layanan = Layanan::findOrFail($request->layanan_id);

        if ($layanan->nama_layanan === 'Haircut') {
            $existingHaircut = CartItem::where('cart_id', $cart->id)
                                        ->whereHas('layanan', function ($query) {
                                            $query->where('nama_layanan', 'Haircut');
                                        })
                                        ->first();

            if ($existingHaircut) {
                return redirect()->route('cart')->with('error', 'Layanan Haircut sudah ada di keranjang!');
            }
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('layanan_id', $layanan->id)
                            ->first();

        if ($cartItem) {
            return redirect()->route('cart')->with('error', 'Layanan ini sudah ada di keranjang!');
        }

        CartItem::create([
            'cart_id' => $cart->id,
            'layanan_id' => $layanan->id,
            'quantity' => $request->quantity,
            'subtotal' => $request->quantity * $layanan->harga
        ]);

        return redirect()->route('cart')->with('success', 'Item berhasil ditambahkan ke keranjang!');
    }

    public function removeItem($id)
    {
        $cartItem = CartItem::findOrFail($id);
        
        if ($cartItem->cart->user_id !== Auth::id()) {
            return redirect()->route('cart')->with('error', 'Unauthorized action.');
        }
        
        $cartItem->delete();

        return redirect()->route('cart')->with('success', 'Item removed from cart.');
    }

    public function totalPrice()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        $total = $cart ? $cart->cartItems->sum('subtotal') : 0;

        return response()->json(['total_harga' => $total]);
    }

    public function cartCount()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        $count = $cart ? $cart->cartItems->sum('quantity') : 0;

        return response()->json(['cart_count' => $count]);
    }
}