<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Equipment;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEquipments     = Equipment::count();
        $availableEquipments = Equipment::where('status', 'available')->count();
        $pendingBookings     = Booking::where('status', 'pending')->count();
        $totalBookings       = Booking::count();
        $recentBookings      = Booking::with(['user', 'equipment'])->latest()->take(5)->get();
        $equipments          = Equipment::latest()->take(6)->get();

        return view('dashboard', compact(
            'totalEquipments',
            'availableEquipments',
            'pendingBookings',
            'totalBookings',
            'recentBookings',
            'equipments'
        ));
    }
}
