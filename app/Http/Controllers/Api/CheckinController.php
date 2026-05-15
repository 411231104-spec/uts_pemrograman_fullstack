<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CheckinResource;
use App\Models\Booking;
use App\Models\Checkin;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    /**
     * Admin melihat semua riwayat check-in.
     */
    public function index(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Hanya admin yang dapat melihat riwayat check-in.',
            ], 403);
        }

        $checkins = Checkin::with(['booking.user', 'booking.equipment'])->latest()->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Riwayat check-in berhasil diambil.',
            'data'    => CheckinResource::collection($checkins),
        ]);
    }

    /**
     * Admin melakukan check-in (konfirmasi pengembalian alat).
     */
    public function store(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Hanya admin yang dapat melakukan check-in peralatan.',
            ], 403);
        }

        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'notes'      => 'nullable|string',
        ]);

        $booking = Booking::find($validated['booking_id']);

        if (!in_array($booking->status, ['approved', 'borrowed'])) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Check-in hanya bisa dilakukan pada peminjaman yang sudah disetujui.',
            ], 422);
        }

        if ($booking->checkin) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Peminjaman ini sudah dilakukan check-in sebelumnya.',
            ], 422);
        }

        $checkin = Checkin::create([
            'booking_id'   => $booking->id,
            'checked_in_at' => now(),
            'notes'        => $validated['notes'] ?? null,
        ]);

        // Update status booking dan kembalikan status equipment
        $booking->update(['status' => 'returned']);
        $booking->equipment->update(['status' => 'available']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Check-in berhasil. Peralatan telah dikembalikan.',
            'data'    => new CheckinResource($checkin->load(['booking.user', 'booking.equipment'])),
        ], 201);
    }
}
