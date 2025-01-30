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
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => Auth::id()]);
        }

        $cartItems = $cart->cartItems()->with(['layanan', 'produk'])->get(); // Retrieve related layanan and produk

        return view('cart', compact('cart', 'cartItems'));
    }

    public function addItem(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

    // Validasi input, memastikan bahwa hanya salah satu id yang dikirim
    $request->validate([
        'layanan_id' => 'nullable|exists:layanans,id',
        'produk_id' => 'nullable|exists:produks,id',
    ]);

    // Cek apakah layanan atau produk yang dipilih
    if ($request->has('layanan_id') && $request->has('produk_id')) {
        return redirect()->back()->with('error', 'Please select only one item: service or product.');
    }

    // Jika layanan_id ada
    if ($request->has('layanan_id')) {
        $item = Layanan::findOrFail($request->layanan_id);
        $cartItem = $cart->cartItems()->where('layanan_id', $request->layanan_id)->first();
    }
    // Jika produk_id ada
    elseif ($request->has('produk_id')) {
        $item = Produk::findOrFail($request->produk_id);
        $cartItem = $cart->cartItems()->where('produk_id', $request->produk_id)->first();
    } else {
        return redirect()->back()->with('error', 'Invalid item selection. Please choose a service or product.');
    }

    // Jika item sudah ada, tambahkan quantity
    if ($cartItem) {
        $cartItem->increment('quantity', 1);
        $cartItem->update(['subtotal' => $cartItem->quantity * $item->harga]);
    } else {
        // Jika item belum ada, buat item baru di cart
        $cart->cartItems()->create([
            'layanan_id' => $request->layanan_id ?? null, // Pastikan layanan_id atau produk_id yang dipilih
            'produk_id' => $request->produk_id ?? null, // Hanya satu yang akan diset, yang lainnya null
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