<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kasir;
use Illuminate\Http\Request;

class AdminRiwayatController extends Controller
{
    public function index() {
        $transactions = Kasir::where('status_transaksi', 'success')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.riwayat.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Kasir::with(['user', 'booking'])->findOrFail($id);
        return view('admin.riwayat.show', compact('transaction'));
    }
}