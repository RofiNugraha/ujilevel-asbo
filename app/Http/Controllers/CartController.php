<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Layanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->firstOrCreate(['user_id' => Auth::id()]);

        $cartItems = $cart->cartItems()->with(['layanan', 'produk'])->get();

        foreach ($cartItems as $item) {
            if ($item->produk_id) {
                $item->gambar = $item->produk->gambar ?? 'default.jpg';
            } elseif ($item->layanan_id) {
                $item->gambar = $item->layanan->gambar ?? 'default.jpg';
            } else {
                $item->gambar = 'default.jpg';
            }

            if ($item->produk_id) {
                $item->subtotal = $item->produk->harga * $item->quantity;
            } elseif ($item->layanan_id) {
                $item->subtotal = $item->layanan->harga * $item->quantity;
            } else {
                $item->subtotal = 0;
            }
        }

        return view('cart', compact('cart', 'cartItems'));
    }                   

    public function addItem(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $request->validate([
            'layanan_id' => 'nullable|exists:layanans,id',
            'produk_id' => 'nullable|exists:produks,id',
        ]);

        if ($request->has('layanan_id') && $request->has('produk_id')) {
            return redirect()->back()->with('error', 'Please select only one item: service or product.');
        }

        $item = null;
        $cartItem = null;

        if ($request->filled('layanan_id')) {
            $item = Layanan::findOrFail($request->layanan_id);

            $existingHaircut = $cart->cartItems()->whereHas('layanan', function ($query) {
                $query->where('nama_layanan', 'Haircut');
            })->exists();

            if ($item->nama_layanan === 'Haircut' && $existingHaircut) {
                return redirect()->back()->with('error', 'You have already added Haircut to your cart. Please checkout before ordering again.');
            }

            $cartItem = $cart->cartItems()->where('layanan_id', $request->layanan_id)->first();
        } elseif ($request->filled('produk_id')) {
            $item = Produk::findOrFail($request->produk_id);
            $cartItem = $cart->cartItems()->where('produk_id', $request->produk_id)->first();
        } else {
            return redirect()->back()->with('error', 'Invalid item selection. Please choose a service or product.');
        }

        if ($cartItem) {
            $cartItem->increment('quantity', 1);
            $cartItem->update(['subtotal' => $cartItem->quantity * $item->harga]);
        } else {
            $cart->cartItems()->create([
                'layanan_id' => $request->layanan_id ?? null,
                'produk_id' => $request->produk_id ?? null,
                'quantity' => 1,
                'subtotal' => $item->harga,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Item added to cart!');
    }

    public function removeItem($id)
    {
        $cartItem = CartItem::findOrFail($id);
        
        if ($cartItem->cart->user_id !== Auth::id()) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
        }
        
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function totalPrice()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        $total = $cart ? $cart->cartItems->sum('subtotal') : 0;

        return response()->json(['total_harga' => $total]);
    }
}