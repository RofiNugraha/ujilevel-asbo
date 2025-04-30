<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
use App\Models\Booking;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPesananController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu.');
        }
        
        // Get all transactions (kasir records) for the current user
        $transactions = Kasir::where('user_id', $user->id)
                           ->orderBy('created_at', 'desc')
                           ->with('booking') // Assuming there's a relationship defined
                           ->get();
        
        return view('riwayat_pesanan', compact('transactions'));
    }
    
    /**
     * Display the details of a specific order.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu.');
        }
        
        // Find the transaction and make sure it belongs to the current user
        $transaction = Kasir::where('id', $id)
                          ->where('user_id', $user->id)
                          ->with('booking') // Assuming there's a relationship defined
                          ->firstOrFail();
        
        // Make sure layanan_id is an array
        $layananIds = $transaction->layanan_id;
        
        // If layanan_id is somehow still a JSON string, decode it
        if (is_string($layananIds)) {
            $layananIds = json_decode($layananIds, true);
        }
        
        // If it's not an array at this point, convert it to an empty array
        if (!is_array($layananIds)) {
            $layananIds = [];
        }
        
        // Try to load layanan details
        try {
            $layananDetails = Layanan::whereIn('id', $layananIds)->get();
        } catch (\Exception $e) {
            $layananDetails = collect([]);
        }
        
        return view('lihat_riwayat_pesanan', compact('transaction', 'layananIds'));
    }
    
    /**
     * Filter orders by status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function filter(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu.');
        }
        
        $status = $request->input('status');
        
        $query = Kasir::where('user_id', $user->id);
        
        if ($status && $status !== 'all') {
            $query->where('status_transaksi', $status);
        }
        
        $transactions = $query->orderBy('created_at', 'desc')
                            ->with('booking')
                            ->get();
        
        return view('pesanan_filter', compact('transactions', 'status'));
    }
}