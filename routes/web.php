<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('/lu', function () {
    return view('loginuser');
})->name('lu');

Route::get('/regis', function () {
    return view('registeruser');
})->name('regis');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
});

require __DIR__.'/auth.php';