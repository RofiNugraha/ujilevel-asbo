<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with(['user', 'booking'])
        ->where('user_id', Auth::id())
        ->orderBy('tanggal_notifikasi', 'desc')
        ->get();

        return view('notifikasi', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->status_dibaca = true;
        $notification->save();

        return response()->json([ 'message' => 'Notifikasi telah dibaca.' ]);
    }
}