<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingReminderEmail;
use Carbon\Carbon;

class SendBookingReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send booking reminders to customers at various intervals';

    // Daftar interval pengingat (dalam menit) dengan format pesan
    protected $reminderIntervals = [
        1440 => ['label' => '1 hari', 'message' => '⏰ Pengingat 1 hari: Booking Anda akan dimulai pada %s. Jangan sampai terlewat!'],
        60   => ['label' => '1 jam', 'message' => '⏰ Pengingat 1 jam: Booking Anda akan dimulai pada %s. Siapkan diri Anda!'],
        30   => ['label' => '30 menit', 'message' => '⏰ Pengingat 30 menit: Booking Anda akan segera dimulai pada %s.'],
        15   => ['label' => '15 menit', 'message' => '⏰ Pengingat 15 menit: Booking Anda akan dimulai sebentar lagi pada %s.'],
        5    => ['label' => '5 menit', 'message' => '⏰ Pengingat 5 menit: Booking Anda akan dimulai segera pada %s!']
    ];

    public function handle()
    {
        try {
            Log::info('Starting booking reminders sending process');
            
            foreach ($this->reminderIntervals as $minutes => $reminder) {
                $this->sendRemindersForInterval($minutes, $reminder);
            }

            Log::info('Booking reminders sent successfully');
            $this->info('Booking reminders sent successfully.');
        } catch (\Exception $e) {
            Log::error('Error sending booking reminders: ' . $e->getMessage());
            $this->error('Error sending booking reminders: ' . $e->getMessage());
        }
    }

    protected function sendRemindersForInterval($minutes, $reminder)
    {
        $now = now();
        $targetTime = $now->copy()->addMinutes($minutes);
        
        Log::debug("Processing reminders for {$reminder['label']} interval (target time: {$targetTime})");

        $bookings = Booking::whereBetween('jam_booking', [
                $targetTime->copy()->subMinute(),
                $targetTime->copy()->addMinute()
            ])
            ->where('status', 'konfirmasi')
            ->whereDoesntHave('notifications', function($query) use ($reminder) {
                $query->where('pesan', 'like', "%Pengingat {$reminder['label']}%");
            })
            ->with('user')
            ->get();

        Log::debug("Found {$bookings->count()} bookings for {$reminder['label']} reminder");

        foreach ($bookings as $booking) {
            try {
                $formattedTime = $booking->jam_booking->format('H:i');
                $message = sprintf($reminder['message'], $formattedTime);

                // Create notification
                Notification::create([
                    'user_id' => $booking->user_id,
                    'booking_id' => $booking->id,
                    'pesan' => $message,
                    'tanggal_notifikasi' => $now
                ]);

                // Send email
                Mail::to($booking->user->email)->send(
                    new BookingReminderEmail($booking, $reminder['label'])
                );

                Log::info("Sent {$reminder['label']} reminder for booking ID: {$booking->id}");
            } catch (\Exception $e) {
                Log::error("Failed to send reminder for booking ID: {$booking->id}. Error: " . $e->getMessage());
            }
        }
    }
}