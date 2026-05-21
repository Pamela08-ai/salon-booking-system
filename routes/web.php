<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        // Send users to the correct starting page based on the role they registered with.
        if (Auth::user()->role === 'business_owner') {
            return redirect('/business/profile');
        }

        if (Auth::user()->role === 'customer') {
            return redirect('/businesses');
        }
    }

    return view('welcome');
});

// Public pages can be viewed before logging in, so guests can explore salons first.
Route::get('/businesses', [BusinessController::class, 'index']);
Route::get('/businesses/{business}', [BusinessController::class, 'show']);

// These routes are only for customers because business owners should not book as customers.
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/book/{service}', [BookingController::class, 'create']);
    Route::post('/book', [BookingController::class, 'store']);
    Route::get('/my-bookings', [BookingController::class, 'myBookings']);
    Route::post('/bookings/{id}/pay', [BookingController::class, 'payDeposit']);
});

// Business owners use these pages to manage their business, services, bookings, and dashboard.
Route::middleware(['auth', 'business_owner'])->group(function () {
    Route::get('/dashboard', [BookingController::class, 'dashboard'])->name('dashboard');

    Route::get('/business/create', [BusinessController::class, 'create']);
    Route::post('/business', [BusinessController::class, 'store']);
    Route::get('/business/profile', [BusinessController::class, 'profile']);
    Route::get('/business/edit', [BusinessController::class, 'edit']);
    Route::put('/business', [BusinessController::class, 'update']);

    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/create', [ServiceController::class, 'create']);
    Route::post('/services', [ServiceController::class, 'store']);

    Route::get('/services/{service}/edit', [ServiceController::class, 'edit']);
    Route::put('/services/{service}', [ServiceController::class, 'update']);
    Route::post('/services/{service}/deactivate', [ServiceController::class, 'deactivate']);

    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings/{id}/reminder', [BookingController::class, 'sendReminder']);

    Route::post('/bookings/{id}/confirm', [BookingController::class, 'confirm']);
    Route::post('/bookings/{id}/complete', [BookingController::class, 'complete']);
});

Route::middleware('auth')->group(function () {
    // Both customers and business owners can cancel, but the controller checks ownership first.
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel']);
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
