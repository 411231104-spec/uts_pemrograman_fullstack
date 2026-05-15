@extends('layouts.app')
@section('title', 'Daftar Peminjaman')
@section('page-title', 'Manajemen Peminjaman')

@section('content')
<div class="page-header">
    <div>
        <h4>Peminjaman</h4>
        <span style="font-size:12px;color:#94a3b8;">Kelola jadwal peminjaman peralatan</span>
    </div>
    @if(!Auth::user()->isAdmin())
    <a href="{{ route('bookings.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Buat Peminjaman
    </a>
    @endif
</div>

{{-- FILTER TABS (status) --}}
<div class="d-flex gap-2 mb-4 flex-wrap">
    @foreach(['semua' => 'Semua', 'pending' => 'Pending', 'approved' => 'Disetujui', 'returned' => 'Selesai', 'rejected' => 'Ditolak'] as $val => $label)
    <a href="{{ route('bookings.index', ['status' => $val == 'semua' ? null : $val]) }}"
        class="btn btn-sm {{ (request('status', 'semua') == $val) ? 'btn-primary' : 'btn-outline-secondary' }}"
        style="border-radius:50px;">
        {{ $label }}
    </a>
    @endforeach
</div>

<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-calendar-check text-primary"></i>
        <span>Daftar Peminjaman</span>
        <span class="badge bg-primary ms-auto" style="border-radius:50px;">{{ $bookings->count() }} data</span>
    </div>
    <div class="card-body p-0">
        @if($bookings->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        @if(Auth::user()->isAdmin())<th>Peminjam</th>@endif
                        <th>Peralatan</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $i => $booking)
                    <tr>
                        <td style="color:#94a3b8;font-size:12px;">{{ $i + 1 }}</td>
                        @if(Auth::user()->isAdmin())
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:28px;height:28px;background:linear-gradient(135deg,#3b82f6,#6366f1);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:11px;font-weight:700;flex-shrink:0;">
                                    {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:13px;">{{ $booking->user->name }}</div>
                                    <div style="font-size:11px;color:#94a3b8;">{{ ucfirst($booking->user->role) }}</div>
                                </div>
                            </div>
                        </td>
                        @endif
                        <td style="font-weight:500;">{{ $booking->equipment->name }}</td>
                        <td style="font-size:13px;">{{ $booking->borrow_date->format('d M Y') }}</td>
                        <td style="font-size:13px;">{{ $booking->return_date->format('d M Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $booking->status }}">
                                @switch($booking->status)
                                    @case('pending') ⏳ Pending @break
                                    @case('approved') ✅ Disetujui @break
                                    @case('borrowed') 📦 Dipinjam @break
                                    @case('returned') 🔙 Selesai @break
                                    @case('rejected') ❌ Ditolak @break
                                @endswitch
                            </span>
                        </td>
                        <td>
                            @if(Auth::user()->isAdmin() && $booking->status == 'pending')
                            <div class="d-flex gap-1">
                                <form action="{{ route('bookings.approve', $booking->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-success" title="Setujui">
                                        <i class="bi bi-check-lg"></i> Setujui
                                    </button>
                                </form>
                                <form action="{{ route('bookings.reject', $booking->id) }}" method="POST"
                                    onsubmit="return confirm('Tolak peminjaman ini?')">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger" title="Tolak">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            </div>
                            @elseif(Auth::user()->isAdmin() && in_array($booking->status, ['approved','borrowed']) && !$booking->checkin)
                            <a href="{{ route('checkins.create', ['booking_id' => $booking->id]) }}"
                                class="btn btn-sm btn-outline-info">
                                <i class="bi bi-check2-circle me-1"></i>Check-in
                            </a>
                            @else
                            <span style="font-size:12px;color:#cbd5e1;">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-calendar-x"></i>
            <p>Tidak ada data peminjaman.</p>
        </div>
        @endif
    </div>
</div>
@endsection
