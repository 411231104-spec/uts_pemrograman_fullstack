<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Checkin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckinController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $pendingCheckins = Booking::with(['user', 'equipment'])
            ->whereIn('status', ['approved', 'borrowed'])
            ->doesntHave('checkin')
            ->latest()
            ->get();

        $checkins = Checkin::with(['booking.user', 'booking.equipment'])
            ->latest()
            ->get();

        return view('checkins.index', compact('pendingCheckins', 'checkins'));
    }

    public function create(Request $request)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $booking = Booking::with(['user', 'equipment'])->findOrFail($request->booking_id);
        return view('checkins.create', compact('booking'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'notes'      => 'nullable|string|max:500',
        ]);

        $booking = Booking::with(['equipment'])->findOrFail($validated['booking_id']);

        if ($booking->checkin) {
            return redirect()->route('checkins.index')
                ->with('error', 'Peminjaman ini sudah dilakukan check-in sebelumnya.');
        }

        Checkin::create([
            'booking_id'    => $booking->id,
            'checked_in_at' => now(),
            'notes'         => $validated['notes'] ?? null,
        ]);

        $booking->update(['status' => 'returned']);
        $booking->equipment->update(['status' => 'available']);

        return redirect()->route('checkins.index')
            ->with('success', 'Check-in berhasil! Peralatan sudah kembali tersedia.');
    }
}
