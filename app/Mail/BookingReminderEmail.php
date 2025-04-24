<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $reminderInterval;
    public $bookingTime;
    public $userName;

    public function __construct(Booking $booking, $reminderInterval)
    {
        $this->booking = $booking;
        $this->reminderInterval = $reminderInterval;
        $this->bookingTime = $booking->jam_booking->format('l, d F Y H:i');
        $this->userName = $booking->user->name;
    }

    public function build()
    {
        return $this->subject("Pengingat {$this->reminderInterval} - Jadwal Booking Anda")
            ->markdown('emails.booking_reminder') // Changed to markdown (recommended)
            ->with([
                'booking' => $this->booking,
                'reminderInterval' => $this->reminderInterval,
                'bookingTime' => $this->bookingTime,
                'userName' => $this->userName
            ]);
    }
}