<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\BookingController;
use App\Http\Controllers\Web\CheckinController;

/*
|--------------------------------------------------------------------------
| Web Routes - Smart-Hub Management System
|--------------------------------------------------------------------------
*/

// ─── Auth (Tamu) ────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/', [AuthController::class, 'login']);
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// ─── Route yang memerlukan login ─────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Peralatan (Equipment) - CRUD
    Route::resource('equipments', EquipmentController::class);

    // Peminjaman (Booking)
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::post('/bookings/{id}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{id}/reject', [BookingController::class, 'reject'])->name('bookings.reject');

    // Check-in (hanya Admin)
    Route::get('/checkins', [CheckinController::class, 'index'])->name('checkins.index');
    Route::get('/checkins/create', [CheckinController::class, 'create'])->name('checkins.create');
    Route::post('/checkins', [CheckinController::class, 'store'])->name('checkins.store');
});