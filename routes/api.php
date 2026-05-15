<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\CheckinController;

/*
|--------------------------------------------------------------------------
| API Routes - Smart-Hub Management System
|--------------------------------------------------------------------------
*/

// ─── Auth (Publik) ────────────────────────────────────────────────────────────
Route::post('/login', [AuthController::class, 'login']);

// ─── Route yang memerlukan autentikasi token ───────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Info pengguna yang sedang login
    Route::get('/user', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'id'    => $request->user()->id,
                'nama'  => $request->user()->name,
                'email' => $request->user()->email,
                'role'  => $request->user()->role,
            ],
        ]);
    });

    // ─── Peralatan (Equipment) ─────────────────────────────────────────────
    Route::get('/equipments', [EquipmentController::class, 'index']);
    Route::get('/equipments/{id}', [EquipmentController::class, 'show']);

    // Hanya Admin yang bisa membuat, mengubah, menghapus peralatan
    Route::middleware(\App\Http\Middleware\IsAdmin::class)->group(function () {
        Route::post('/equipments', [EquipmentController::class, 'store']);
        Route::put('/equipments/{id}', [EquipmentController::class, 'update']);
        Route::delete('/equipments/{id}', [EquipmentController::class, 'destroy']);
    });

    // ─── Peminjaman (Booking) ──────────────────────────────────────────────
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);

    // Approve & Reject hanya untuk Admin
    Route::middleware(\App\Http\Middleware\IsAdmin::class)->group(function () {
        Route::put('/bookings/{id}/approve', [BookingController::class, 'approve']);
        Route::put('/bookings/{id}/reject', [BookingController::class, 'reject']);
    });

    // ─── Check-in (Pengembalian Alat) ─────────────────────────────────────
    Route::middleware(\App\Http\Middleware\IsAdmin::class)->group(function () {
        Route::get('/checkins', [CheckinController::class, 'index']);
        Route::post('/checkins', [CheckinController::class, 'store']);
    });
});
