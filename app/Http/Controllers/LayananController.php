<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Produk;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::all();
        return view('booking', compact('layanans'));
    }
}