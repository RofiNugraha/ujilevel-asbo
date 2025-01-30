<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminKasirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminLayananController;
use App\Http\Controllers\Admin\AdminNotifikasiController;
use App\Http\Controllers\CekLoginController;
use App\Http\Controllers\Admin\AdminRiwayatTransaksiController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\UpdateProfileController;
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

Route::get('/viewbooking', function () {
    return view('viewbooking');
})->name('viewbooking');

Route::get('/notif', function () {
    return view('notifikasi');
})->name('notif');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware(['auth'])->group(function () {

    //input layanan
    Route::post('/', [LayananController::class, 'store'])->name('layanan.store');

    // profil
    Route::get('/profil', [ProfileController::class, 'show'])->name('profil');
    Route::put('/profil', [UpdateProfileController::class, 'updateProfile'])->name('profil.update');
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
    
    // CRUD admin kasir
    Route::get('/admin/kasir', [AdminKasirController::class, 'index'])->name('admin.kasir.index');
    Route::get('/admin/kasir/create', [AdminKasirController::class, 'create'])->name('admin.kasir.create');
    Route::post('/admin/kasir', [AdminKasirController::class, 'store'])->name('admin.kasir.store');
    Route::get('/admin/kasir/{id}', [AdminKasirController::class, 'show'])->name('admin.kasir.show');
    Route::get('/admin/kasir/{id}/edit', [AdminKasirController::class, 'edit'])->name('admin.kasir.edit');
    Route::put('/admin/kasir/{id}', [AdminKasirController::class, 'update'])->name('admin.kasir.update');
    Route::delete('/admin/kasir/{id}', [AdminKasirController::class, 'destroy'])->name('admin.kasir.destroy');
});

require __DIR__.'/auth.php';