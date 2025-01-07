<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminLayananController;
use App\Http\Middleware\AdminMiddleware;
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

    Route::get('/admin/layanan', [AdminLayananController::class, 'index'])->name('admin.layanan.index');
    Route::get('layanan/create', [AdminLayananController::class, 'create'])->name('admin.layanan.create');
    Route::post('layanan', [AdminLayananController::class, 'store'])->name('admin.layanan.store');
    Route::get('layanan/{layanan}', [AdminLayananController::class, 'show'])->name('admin.layanan.show');
    Route::get('layanan/{layanan}/edit', [AdminLayananController::class, 'edit'])->name('admin.layanan.edit');
    Route::put('layanan/{layanan}', [AdminLayananController::class, 'update'])->name('admin.layanan.update');
    Route::delete('layanan/{layanan}', [AdminLayananController::class, 'destroy'])->name('admin.layanan.destroy');
});

require __DIR__.'/auth.php';