<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [BookingController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/create', [ServiceController::class, 'create']);
Route::post('/services', [ServiceController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/book/{service}', [BookingController::class, 'create']);
    Route::post('/book', [BookingController::class, 'store']);
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/my-bookings', [BookingController::class, 'myBookings']);
    Route::post('/bookings/{id}/pay', [BookingController::class, 'payDeposit']);
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel']);
});