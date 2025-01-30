<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay(Request $request, $checkoutId)
    {
        $checkout = Checkout::findOrFail($checkoutId);

        if ($checkout->status_pembayaran === 'sudah') {
            return redirect()->route('checkout.show', $checkout->id)->with('success', 'Pembayaran sudah dilakukan');
        }

        $payment = Payment::create([
            'checkout_id' => $checkout->id,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => 'pending', 
        ]);

        $payment->update(['status' => 'berhasil']);

        $checkout->update(['status_pembayaran' => 'sudah']);

        return redirect()->route('checkout.show', $checkout->id)->with('success', 'Pembayaran berhasil');
    }
}