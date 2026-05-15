<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Equipment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Untuk Admin: tampilkan semua peminjaman.
     * Untuk Member: tampilkan peminjaman milik sendiri.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            $bookings = Booking::with(['user', 'equipment'])->latest()->get();
        } else {
            $bookings = Booking::with(['equipment'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Daftar peminjaman berhasil diambil.',
            'data'    => BookingResource::collection($bookings),
        ]);
    }

    /**
     * Member membuat peminjaman baru.
     */
    public function store(Request $request)
    {
        if ($request->user()->isAdmin()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Admin tidak dapat membuat peminjaman.',
            ], 403);
        }

        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'borrow_date'  => 'required|date|after_or_equal:today',
            'return_date'  => 'required|date|after:borrow_date',
        ]);

        $equipment = Equipment::findOrFail($validated['equipment_id']);

        if ($equipment->stock <= 0 || $equipment->status !== 'available') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Peralatan tidak tersedia untuk dipinjam.',
            ], 422);
        }

        $booking = Booking::create([
            'user_id'      => $request->user()->id,
            'equipment_id' => $validated['equipment_id'],
            'borrow_date'  => $validated['borrow_date'],
            'return_date'  => $validated['return_date'],
            'status'       => 'pending',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Peminjaman berhasil dibuat. Menunggu persetujuan admin.',
            'data'    => new BookingResource($booking->load(['user', 'equipment'])),
        ], 201);
    }

    /**
     * Admin menyetujui peminjaman.
     */
    public function approve(Request $request, string $id)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Hanya admin yang dapat menyetujui peminjaman.',
            ], 403);
        }

        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['status' => 'error', 'message' => 'Peminjaman tidak ditemukan.'], 404);
        }

        if ($booking->status !== 'pending') {
            return response()->json(['status' => 'error', 'message' => 'Hanya peminjaman berstatus pending yang dapat disetujui.'], 422);
        }

        $booking->update(['status' => 'approved']);
        $booking->equipment->update(['status' => 'borrowed']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Peminjaman berhasil disetujui.',
            'data'    => new BookingResource($booking->load(['user', 'equipment'])),
        ]);
    }

    /**
     * Admin menolak peminjaman.
     */
    public function reject(Request $request, string $id)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Hanya admin yang dapat menolak peminjaman.',
            ], 403);
        }

        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['status' => 'error', 'message' => 'Peminjaman tidak ditemukan.'], 404);
        }

        if ($booking->status !== 'pending') {
            return response()->json(['status' => 'error', 'message' => 'Hanya peminjaman berstatus pending yang dapat ditolak.'], 422);
        }

        $booking->update(['status' => 'rejected']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Peminjaman berhasil ditolak.',
            'data'    => new BookingResource($booking->load(['user', 'equipment'])),
        ]);
    }
}
