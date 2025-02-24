<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::post('/admin/kasir/{id}', [PaymentController::class, 'createPayment']);
    Route::post('/admin/kasir/callback', [PaymentController::class, 'callback']);
    Route::get('/admin/kasir/{id}', [PaymentController::class, 'getPaymentToken']);
});