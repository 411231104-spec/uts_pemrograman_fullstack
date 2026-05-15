@extends('layouts.app')
@section('title', 'Riwayat Check-in')
@section('page-title', 'Sistem Check-in')

@section('content')
<div class="page-header">
    <div>
        <h4>Check-in Peralatan</h4>
        <span style="font-size:12px;color:#94a3b8;">Konfirmasi pengembalian peralatan oleh anggota</span>
    </div>
</div>

{{-- BOOKING YANG MENUNGGU CHECK-IN --}}
@if($pendingCheckins->count() > 0)
<div class="card mb-4" style="border-left: 3px solid #3b82f6;">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-hourglass-split text-primary"></i>
        <span>Peminjaman Menunggu Check-in</span>
        <span class="badge bg-primary ms-auto" style="border-radius:50px;">{{ $pendingCheckins->count() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Peralatan</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingCheckins as $booking)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:30px;height:30px;background:linear-gradient(135deg,#3b82f6,#6366f1);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:12px;font-weight:700;flex-shrink:0;">
                                    {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                </div>
                                <span style="font-weight:500;">{{ $booking->user->name }}</span>
                            </div>
                        </td>
                        <td style="font-weight:500;">{{ $booking->equipment->name }}</td>
                        <td style="font-size:13px;">{{ $booking->borrow_date->format('d M Y') }}</td>
                        <td style="font-size:13px;">
                            {{ $booking->return_date->format('d M Y') }}
                            @if($booking->return_date->isPast())
                            <span class="badge badge-borrowed ms-1">Terlambat</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('checkins.create', ['booking_id' => $booking->id]) }}"
                                class="btn btn-sm btn-primary">
                                <i class="bi bi-check2-circle me-1"></i>Proses Check-in
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- RIWAYAT CHECK-IN --}}
<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-clock-history text-success"></i>
        <span>Riwayat Check-in</span>
        <span class="badge bg-success ms-auto" style="border-radius:50px;">{{ $checkins->count() }}</span>
    </div>
    <div class="card-body p-0">
        @if($checkins->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Peminjam</th>
                        <th>Peralatan</th>
                        <th>Waktu Check-in</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($checkins as $i => $checkin)
                    <tr>
                        <td style="color:#94a3b8;font-size:12px;">{{ $i + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:28px;height:28px;background:linear-gradient(135deg,#10b981,#059669);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:11px;font-weight:700;flex-shrink:0;">
                                    {{ strtoupper(substr($checkin->booking->user->name, 0, 1)) }}
                                </div>
                                <span style="font-weight:500;">{{ $checkin->booking->user->name }}</span>
                            </div>
                        </td>
                        <td style="font-weight:500;">{{ $checkin->booking->equipment->name }}</td>
                        <td style="font-size:13px;">{{ $checkin->checked_in_at->format('d M Y, H:i') }}</td>
                        <td style="font-size:13px;color:#64748b;">{{ $checkin->notes ?: '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-check2-circle"></i>
            <p>Belum ada riwayat check-in pengembalian alat.</p>
        </div>
        @endif
    </div>
</div>
@endsection
