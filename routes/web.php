<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminKasirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminLayananController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminPaymentKasirController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DownPaymentController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\StatusCheckerController;
use App\Http\Controllers\UpdateProfileController;
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

Route::get('/notifikasi', function () {
    return view('notifikasi');
})->name('notifikasi');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/informasi', function () {
    return view('informasi');
})->name('informasi');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
    // layanan
    Route::get('/booking', [LayananController::class, 'index'])->name('booking');
    
    // Overview
    Route::get('/overview', [OverviewController::class, 'index'])->name('overview');

    // Profil
    Route::get('/profil', [ProfileController::class, 'show'])->name('profil');
    Route::put('/profil', [UpdateProfileController::class, 'updateProfile'])->name('profil.update');
    Route::get('/viewbooking/{id}', [ProfileController::class, 'showBooking'])->name('viewbooking.show');

    // Cart 
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/addItem', [CartController::class, 'addItem'])->name('cart.addItem');
    Route::get('cart/total/{cartId}', [CartController::class, 'totalPrice'])->name('cart.totalPrice');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'removeItem'])->name('cart.removeItem');
    Route::get('/cart/count', [CartController::class, 'cartCount'])->name('cart.count');

    // Booking
    Route::get('/formbook/{layanan_id?}/{produk_id?}', [BookingController::class, 'formBook'])->name('formbook');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/checkout', [BookingController::class, 'checkout'])->name('checkout.store');

    // notification
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi');
    Route::patch('/notifikasi/{id}/read', [NotificationController::class, 'markAsRead']);

    // contact
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

    Route::post('/orders/create', [DownPaymentController::class, 'create'])->name('order.create');
    Route::post('/orders/update-status', [DownPaymentController::class, 'updateStatus'])->name('order.update-status');
    Route::post('/orders/notification', [DownPaymentController::class, 'notification'])->name('order.notification');
    Route::post('/check-payment-status', [StatusCheckerController::class, 'checkStatus'])->name('payment.check-status');

    Route::post('/cart', [DownPaymentController::class, 'create'])->name('dp.create');
    Route::post('/cart/update-status', [DownPaymentController::class, 'updateStatus'])->name('dp.update-status');
    Route::post('/cart/notification', [DownPaymentController::class, 'notification'])->name('dp.notification');
    Route::get('/cart/check-status', [DownPaymentController::class, 'checkStatus'])->name('dp.check-status');
    Route::get('/cart/payment-dp', [DownPaymentController::class, 'showPaymentPage'])->name('payment.dp');
    Route::get('/cart/payment-status/{order_id}', [DownPaymentController::class, 'paymentStatus'])->name('payment.status');
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
    
    // booking
    Route::get('/admin/booking', [AdminBookingController::class, 'index'])->name('admin.booking.index');
    Route::get('/admin/booking/create', [AdminBookingController::class, 'create'])->name('admin.booking.create');
    Route::post('/admin/booking', [AdminBookingController::class, 'store'])->name('admin.booking.store');
    Route::get('/admin/booking/{id}/edit', [AdminBookingController::class, 'edit'])->name('admin.booking.edit');
    Route::put('/admin/booking/{id}', [AdminBookingController::class, 'update'])->name('admin.booking.update');
    Route::delete('/admin/booking/{booking}', [AdminBookingController::class, 'destroy'])->name('admin.booking.destroy');
    
    // CRUD admin kasir
    Route::get('/admin/kasir', [AdminKasirController::class, 'index'])->name('admin.kasir.index');
    Route::get('/admin/kasir/create', [AdminKasirController::class, 'create'])->name('admin.kasir.create');
    Route::post('/admin/kasir', [AdminKasirController::class, 'store'])->name('admin.kasir.store');
    Route::get('/admin/kasir/{id}/edit', [AdminKasirController::class, 'edit'])->name('admin.kasir.edit');
    Route::put('/admin/kasir/{id}', [AdminKasirController::class, 'update'])->name('admin.kasir.update');
    Route::delete('/admin/kasir/{id}', [AdminKasirController::class, 'destroy'])->name('admin.kasir.destroy');

    // payment
    Route::get('admin/belajar_midtrans', [AdminOrderController::class, 'index'])->name('admin.order.index');
    Route::post('/admin/belajar_midtrans/checkout', [AdminOrderController::class, 'checkout']);

    // CRUD midtrans
    Route::post('/admin/kasir/midtrans/{id}', [AdminKasirController::class, 'processPayment'])->name('admin.kasir.process-payment');
    Route::post('/admin/kasir/add-non-booking', [AdminKasirController::class, 'addNonBookingCustomer'])->name('admin.kasir.add-non-booking');
    Route::get('/admin/kasir/payment-options/{id}', [AdminKasirController::class, 'paymentOptions'])->name('admin.kasir.payment-options');
    Route::post('/admin/kasir/process-non-booking-payment/{id}', [AdminKasirController::class, 'processNonBookingPayment'])->name('admin.kasir.process-non-booking-payment');
    Route::post('/admin/kasir/midtrans-callback', [AdminKasirController::class, 'midtransCallback'])->name('admin.kasir.midtrans-callback');
    Route::get('/admin/kasir/midtrans/midtrans-finish', [AdminKasirController::class, 'midtransFinish'])->name('admin.kasir.midtrans-finish');
    Route::get('/admin/kasir/midtrans/midtrans-unfinish', [AdminKasirController::class, 'midtransUnfinish'])->name('admin.kasir.midtrans-unfinish');
    Route::get('/admin/kasir/midtrans-error', [AdminKasirController::class, 'midtransError'])->name('admin.kasir.midtrans-error');
});

Route::post('/midtrans/callback', [App\Http\Controllers\Admin\AdminKasirController::class, 'midtransCallback'])->name('midtrans.callback');

require __DIR__.'/auth.php';