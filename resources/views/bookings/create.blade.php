@extends('layouts.app')
@section('title', 'Buat Peminjaman')
@section('page-title', 'Buat Peminjaman Baru')

@section('content')
<div class="page-header">
    <div>
        <h4>Buat Peminjaman</h4>
        <span style="font-size:12px;color:#94a3b8;">Ajukan peminjaman peralatan studio</span>
    </div>
    <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-calendar-plus me-2 text-primary"></i>Form Peminjaman
            </div>
            <div class="card-body">
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">Peralatan <span class="text-danger">*</span></label>
                        <select name="equipment_id" class="form-select @error('equipment_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Peralatan --</option>
                            @foreach($equipments as $equipment)
                            <option value="{{ $equipment->id }}" {{ old('equipment_id') == $equipment->id ? 'selected' : '' }}>
                                {{ $equipment->name }} (Stok: {{ $equipment->stock }})
                            </option>
                            @endforeach
                        </select>
                        @error('equipment_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                            <input type="date" name="borrow_date" class="form-control @error('borrow_date') is-invalid @enderror"
                                value="{{ old('borrow_date') }}" min="{{ date('Y-m-d') }}" required>
                            @error('borrow_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Kembali <span class="text-danger">*</span></label>
                            <input type="date" name="return_date" class="form-control @error('return_date') is-invalid @enderror"
                                value="{{ old('return_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            @error('return_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="alert alert-info d-flex gap-2" style="background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af;border-radius:10px;font-size:13px;">
                        <i class="bi bi-info-circle-fill" style="flex-shrink:0;margin-top:1px;"></i>
                        <span>Peminjaman yang Anda ajukan akan berstatus <strong>Pending</strong> hingga disetujui oleh Admin.</span>
                    </div>

                    <div class="d-flex gap-3 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> Ajukan Peminjaman
                        </button>
                        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
