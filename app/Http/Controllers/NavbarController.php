<?php

namespace App\Http\Controllers;

use App\Models\Custom;
use Illuminate\Http\Request;

class NavbarController extends Controller
{
    public function index()
    {
        $custom = Custom::latest()->first();
        return view('components.landing-layout', compact('custom'));
    }
}