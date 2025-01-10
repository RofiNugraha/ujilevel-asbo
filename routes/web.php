<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminLayananController;
use App\Http\Controllers\Admin\AdminNotifikasiController;
use App\Http\Controllers\CekLoginController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/overview', function () {
    return view('overview');
})->name('overview');

Route::get('/booking', function () {
    return view('booking');
})->name('booking');

Route::get('/form', function () {
    return view('formbook');
})->name('form');

Route::get('/lu', function () {
    return view('loginuser');
})->name('lu');

Route::get('/regis', function () {
    return view('registeruser');
})->name('regis');

Route::get('/profil', function () {
    return view('profil');
})->name('profil');

Route::get('/editprofil', function () {
    return view('editprofil');
})->name('editprofil');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware(['auth'])->group(function () {

    // formbook
    Route::get('/formbook', [CekLoginController::class, 'form'])->name('form');
    Route::post('/formbook', [CekLoginController::class, 'store'])->name('formbook.store');
    });
    
});

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

    // CRUD admin layanan
    Route::get('/admin/layanan', [AdminLayananController::class, 'index'])->name('admin.layanan.index');
    Route::get('/admin/layanan/create', [AdminLayananController::class, 'create'])->name('admin.layanan.create');
    Route::post('/admin/layanan', [AdminLayananController::class, 'store'])->name('admin.layanan.store');
    Route::get('/admin/layanan/{layanan}', [AdminLayananController::class, 'show'])->name('admin.layanan.show');
    Route::get('/admin/layanan/{id}/edit', [AdminLayananController::class, 'edit'])->name('admin.layanan.edit');
    Route::put('/admin/layanan/{id}', [AdminLayananController::class, 'update'])->name('admin.layanan.update');
    Route::delete('/admin/layanan/{layanan}', [AdminLayananController::class, 'destroy'])->name('admin.layanan.destroy');

    // CRUD admin booking
    Route::get('/admin/booking', [AdminBookingController::class, 'index'])->name('admin.booking.index');
    Route::get('/admin/booking/create', [AdminBookingController::class, 'create'])->name('admin.booking.create');
    Route::post('/admin/booking', [AdminBookingController::class, 'store'])->name('admin.booking.store');
    Route::get('/admin/booking/{id}', [AdminBookingController::class, 'show'])->name('admin.booking.show');
    Route::get('/admin/booking/{id}/edit', [AdminBookingController::class, 'edit'])->name('admin.booking.edit');
    Route::put('/admin/booking/{id}', [AdminBookingController::class, 'update'])->name('admin.booking.update');
    Route::delete('/admin/booking/{id}', [AdminBookingController::class, 'destroy'])->name('admin.booking.destroy');
    
    // CRUD admin notifikasi
    Route::get('/admin/notifikasi', [AdminNotifikasiController::class, 'index'])->name('admin.notifikasi.index');
    Route::get('/admin/notifikasi/create', [AdminNotifikasiController::class, 'create'])->name('admin.notifikasi.create');
    Route::post('/admin/notifikasi', [AdminNotifikasiController::class, 'store'])->name('admin.notifikasi.store');
    Route::get('/admin/notifikasi/{id}', [AdminNotifikasiController::class, 'show'])->name('admin.notifikasi.show');
    Route::get('/admin/notifikasi/{id}/edit', [AdminNotifikasiController::class, 'edit'])->name('admin.notifikasi.edit');
    Route::put('/admin/notifikasi/{id}', [AdminNotifikasiController::class, 'update'])->name('admin.notifikasi.update');
    Route::delete('/admin/notifikasi/{id}', [AdminNotifikasiController::class, 'destroy'])->name('admin.notifikasi.destroy');
});

require __DIR__.'/auth.php';