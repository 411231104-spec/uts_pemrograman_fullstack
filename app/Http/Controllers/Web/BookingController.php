<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'equipment'])->latest();

        // Member hanya melihat miliknya sendiri
        if (!Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        // Filter berdasarkan status
        if ($request->status && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $bookings = $query->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('bookings.index')->with('error', 'Admin tidak dapat membuat peminjaman.');
        }
        $equipments = Equipment::where('status', 'available')->where('stock', '>', 0)->get();
        return view('bookings.create', compact('equipments'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('bookings.index')->with('error', 'Admin tidak dapat membuat peminjaman.');
        }

        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'borrow_date'  => 'required|date|after_or_equal:today',
            'return_date'  => 'required|date|after:borrow_date',
        ], [
            'equipment_id.required' => 'Pilih peralatan terlebih dahulu.',
            'borrow_date.after_or_equal' => 'Tanggal pinjam tidak boleh sebelum hari ini.',
            'return_date.after'     => 'Tanggal kembali harus setelah tanggal pinjam.',
        ]);

        $equipment = Equipment::findOrFail($validated['equipment_id']);

        if ($equipment->stock <= 0 || $equipment->status !== 'available') {
            return back()->with('error', 'Peralatan tidak tersedia untuk dipinjam.');
        }

        Booking::create([
            'user_id'      => Auth::id(),
            'equipment_id' => $validated['equipment_id'],
            'borrow_date'  => $validated['borrow_date'],
            'return_date'  => $validated['return_date'],
            'status'       => 'pending',
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Peminjaman berhasil diajukan! Menunggu persetujuan admin.');
    }

    public function approve(Request $request, string $id)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya peminjaman pending yang dapat disetujui.');
        }

        $booking->update(['status' => 'approved']);
        $booking->equipment->update(['status' => 'borrowed']);

        return back()->with('success', "Peminjaman oleh {$booking->user->name} berhasil disetujui.");
    }

    public function reject(Request $request, string $id)
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya peminjaman pending yang dapat ditolak.');
        }

        $booking->update(['status' => 'rejected']);

        return back()->with('success', "Peminjaman oleh {$booking->user->name} telah ditolak.");
    }
}
