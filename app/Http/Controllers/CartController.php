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
            return redirect()->back()->with('error', 'Pilih hanya satu item: layanan atau produk.');
        }

        if ($request->filled('layanan_id')) {
            $jenis_pesanan = 'layanan';

            $layanan = Layanan::findOrFail($request->layanan_id);

            // Cek jika layanan masih ada di cart
            $cartItem = $cart->cartItems()->where('layanan_id', $request->layanan_id)->first();
            if ($cartItem) {
                return redirect()->back()->with('error', 'Layanan ini masih ada di keranjang. Harap hapus sebelum menambah lagi.');
            }

            // Cek jika layanan bernama "Haircut" dan sudah ada di cart
            $existingHaircut = $cart->cartItems()->whereHas('layanan', function ($query) {
                $query->where('nama_layanan', 'Haircut');
            })->exists();

            if ($layanan->nama_layanan === 'Haircut' && $existingHaircut) {
                return redirect()->back()->with('error', 'Layanan Haircut masih ada di keranjang. Harap hapus sebelum menambah lagi.');
            }

            // Tambahkan layanan ke cart jika belum ada
            $cart->cartItems()->create([
                'layanan_id' => $request->layanan_id,
                'produk_id' => null,
                'jenis_pesanan' => $jenis_pesanan,
                'quantity' => 1,
                'subtotal' => $layanan->harga,
            ]);
        }

        if ($request->filled('produk_id')) {
            $jenis_pesanan = $cart->cartItems()->exists() ? 'keduanya' : 'produk';

            $produk = Produk::findOrFail($request->produk_id);

            // Cek jika produk sudah ada di cart
            $cartItem = $cart->cartItems()->where('produk_id', $request->produk_id)->first();
            if ($cartItem) {
                $cartItem->increment('quantity', 1);
                $cartItem->update(['subtotal' => $cartItem->quantity * $produk->harga]);
            } else {
                $cart->cartItems()->create([
                    'layanan_id' => null,
                    'produk_id' => $request->produk_id,
                    'jenis_pesanan' => $jenis_pesanan,
                    'quantity' => 1,
                    'subtotal' => $produk->harga,
                ]);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Item berhasil ditambahkan ke keranjang!');
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

    public function cartCount()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        $count = $cart ? $cart->cartItems->sum('quantity') : 0;

        return response()->json(['cart_count' => $count]);
    }
}