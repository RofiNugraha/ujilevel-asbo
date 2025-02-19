<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\BookingUpdated;
use App\Listeners\SendBookingNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Daftar event dan listener yang terdaftar.
     *
     * @var array
     */
    protected $listen = [
        BookingUpdated::class => [
            SendBookingNotification::class,
        ],
    ];

    /**
     * Daftar event yang harus otomatis ditemukan oleh Laravel.
     *
     * @var bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}