<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('status', 'konfirmasi')->whereDate('jam_booking', Carbon::today())->with('user')->get();
        return view('overview', compact('bookings'));
    }
}