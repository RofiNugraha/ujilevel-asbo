<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    public function index() {

        $notifications = Notification::where('user_id', Auth::id())
            ->with('booking')
            ->orderBy('tanggal_notifikasi', 'desc')
            ->get();
  
    
        return view('notifikasi', compact('notifications'));
    }
    
}