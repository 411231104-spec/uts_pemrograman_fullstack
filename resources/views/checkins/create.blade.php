@extends('layouts.app')
@section('title', 'Proses Check-in')
@section('page-title', 'Proses Check-in')

@section('content')
<div class="page-header">
    <div>
        <h4>Proses Check-in</h4>
        <span style="font-size:12px;color:#94a3b8;">Konfirmasi pengembalian peralatan</span>
    </div>
    <a href="{{ route('checkins.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        {{-- Info Peminjaman --}}
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-info-circle me-2 text-info"></i>Detail Peminjaman
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div style="font-size:11px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.8px;margin-bottom:4px;">Peminjam</div>
                        <div style="font-weight:600;color:#0f172a;">{{ $booking->user->name }}</div>
                        <div style="font-size:12px;color:#64748b;">{{ $booking->user->email }}</div>
                    </div>
                    <div class="col-md-6">
                        <div style="font-size:11px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.8px;margin-bottom:4px;">Peralatan</div>
                        <div style="font-weight:600;color:#0f172a;">{{ $booking->equipment->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div style="font-size:11px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.8px;margin-bottom:4px;">Tanggal Pinjam</div>
                        <div style="font-weight:500;">{{ $booking->borrow_date->format('d M Y') }}</div>
                    </div>
                    <div class="col-md-6">
                        <div style="font-size:11px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.8px;margin-bottom:4px;">Tanggal Kembali</div>
                        <div style="font-weight:500;">{{ $booking->return_date->format('d M Y') }}
                            @if($booking->return_date->isPast())
                            <span class="badge badge-borrowed ms-1">Terlambat</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Check-in --}}
        <div class="card">
            <div class="card-header">
                <i class="bi bi-check2-circle me-2 text-success"></i>Form Konfirmasi Check-in
            </div>
            <div class="card-body">
                <form action="{{ route('checkins.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                    <div class="mb-4">
                        <label class="form-label">Catatan Kondisi Alat</label>
                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"
                            rows="3" placeholder="Contoh: Kondisi baik, tidak ada kerusakan. / Layar sedikit tergores.">{{ old('notes') }}</textarea>
                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="alert d-flex gap-2" style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;border-radius:10px;font-size:13px;">
                        <i class="bi bi-check-circle-fill" style="flex-shrink:0;margin-top:1px;"></i>
                        <span>Setelah check-in dikonfirmasi, status peralatan akan kembali menjadi <strong>Tersedia</strong>.</span>
                    </div>

                    <div class="d-flex gap-3 mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check2-circle me-1"></i> Konfirmasi Check-in
                        </button>
                        <a href="{{ route('checkins.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
