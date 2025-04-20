<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::post('admin/kasir', [PaymentController::class, 'createTransaction']);
    Route::post('admin/kasir/notification', [PaymentController::class, 'transactionNotification']);
});