<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Custom;

class CustomDashboardController extends Controller
{
    public function index() { 
            $custom = Custom::latest()->first();
            return view('dashboard', compact('custom'));
    }
    
    public function about() { 
            $custom = Custom::latest()->first();
            return view('about', compact('custom'));
    }
    
    public function contact() { 
            $custom = Custom::latest()->first();
            return view('contact', compact('custom'));
    }
}