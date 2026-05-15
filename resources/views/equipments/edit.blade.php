@extends('layouts.app')
@section('title', 'Edit Peralatan')
@section('page-title', 'Edit Peralatan')

@section('content')
<div class="page-header">
    <div>
        <h4>Edit Peralatan</h4>
        <span style="font-size:12px;color:#94a3b8;">Perbarui informasi peralatan</span>
    </div>
    <a href="{{ route('equipments.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil-square me-2 text-warning"></i>Edit: {{ $equipment->name }}
            </div>
            <div class="card-body">
                <form action="{{ route('equipments.update', $equipment->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-4">
                        <label class="form-label">Nama Peralatan <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $equipment->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                            rows="3">{{ old('description', $equipment->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                value="{{ old('stock', $equipment->stock) }}" min="0" required>
                            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="available" {{ old('status', $equipment->status) == 'available' ? 'selected' : '' }}>✅ Tersedia</option>
                                <option value="borrowed" {{ old('status', $equipment->status) == 'borrowed' ? 'selected' : '' }}>📦 Dipinjam</option>
                                <option value="maintenance" {{ old('status', $equipment->status) == 'maintenance' ? 'selected' : '' }}>🔧 Perbaikan</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="bi bi-floppy me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('equipments.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
