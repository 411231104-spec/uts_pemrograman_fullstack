@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h4>Dashboard</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" style="font-size:12px;color:#94a3b8;">Ringkasan Sistem</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span style="font-size:12px;color:#94a3b8;"><i class="bi bi-clock me-1"></i>{{ now()->format('d M Y, H:i') }}</span>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-primary-gradient">
            <i class="bi bi-box-seam stat-icon"></i>
            <div class="stat-value">{{ $totalEquipments }}</div>
            <div class="stat-label">Total Peralatan</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-success-gradient">
            <i class="bi bi-check-circle stat-icon"></i>
            <div class="stat-value">{{ $availableEquipments }}</div>
            <div class="stat-label">Peralatan Tersedia</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-warning-gradient">
            <i class="bi bi-hourglass-split stat-icon"></i>
            <div class="stat-value">{{ $pendingBookings }}</div>
            <div class="stat-label">Peminjaman Pending</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-danger-gradient">
            <i class="bi bi-calendar-check stat-icon"></i>
            <div class="stat-value">{{ $totalBookings }}</div>
            <div class="stat-label">Total Peminjaman</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- PEMINJAMAN TERBARU --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-calendar-check me-2 text-primary"></i>Peminjaman Terbaru</span>
                <a href="{{ route('bookings.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @if($recentBookings->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Peralatan</th>
                                <th>Tgl Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentBookings as $booking)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:30px;height:30px;background:linear-gradient(135deg,#3b82f6,#6366f1);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:12px;font-weight:700;flex-shrink:0;">
                                            {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $booking->user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $booking->equipment->name }}</td>
                                <td>{{ $booking->borrow_date->format('d M Y') }}</td>
                                <td><span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <i class="bi bi-calendar-x"></i>
                    <p>Belum ada peminjaman</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- PERALATAN TERBARU --}}
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-box-seam me-2 text-success"></i>Status Peralatan</span>
                <a href="{{ route('equipments.index') }}" class="btn btn-sm btn-outline-success">Kelola</a>
            </div>
            <div class="card-body p-0">
                @if($equipments->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Alat</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($equipments as $eq)
                            <tr>
                                <td>{{ Str::limit($eq->name, 22) }}</td>
                                <td><strong>{{ $eq->stock }}</strong></td>
                                <td><span class="badge badge-{{ $eq->status }}">{{ ucfirst($eq->status) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <i class="bi bi-box"></i>
                    <p>Belum ada peralatan</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
