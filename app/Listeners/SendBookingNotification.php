<?php

namespace App\Listeners;

use App\Events\BookingUpdated;
use App\Mail\BookingStatusMail;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendBookingNotification
{
    /**
     * Handle the event.
     */
    public function handle(BookingUpdated $event)
    {
        $booking = $event->booking;
        $user = $booking->user;
        $status = $event->status;

        $pesan = match ($status) {
            'pending' => 'Booking Anda telah berhasil dibuat. Menunggu konfirmasi admin.',
            'konfirmasi' => 'Booking Anda telah dikonfirmasi. Silakan datang sesuai jadwal.',
            'batal' => 'Booking Anda telah dibatalkan oleh admin.',
            'selesai' => 'Terima kasih! Booking Anda telah selesai.',
            default => 'Status booking diperbarui.',
        };

        Notification::create([
            'user_id' => $user->id,
            'booking_id' => $booking->id,
            'pesan' => $pesan,
            'tanggal_notifikasi' => Carbon::now('Asia/Jakarta'),
            'status_dibaca' => false,
        ]);

        Mail::to($user->email)->send(new BookingStatusMail($booking, $pesan));
    }
}