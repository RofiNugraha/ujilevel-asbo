<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Midtrans\Config;
use Illuminate\Support\Facades\View;
use App\View\Composers\CustomViewComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        View::composer('*', CustomViewComposer::class);
    }
}