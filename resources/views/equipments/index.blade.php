@extends('layouts.app')
@section('title', 'Daftar Peralatan')
@section('page-title', 'Manajemen Peralatan')

@section('content')
<div class="page-header">
    <div>
        <h4>Peralatan</h4>
        <span style="font-size:12px;color:#94a3b8;">Daftar inventaris peralatan studio</span>
    </div>
    @if(Auth::user()->isAdmin())
    <a href="{{ route('equipments.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Peralatan
    </a>
    @endif
</div>

<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-box-seam text-primary"></i>
        <span>Daftar Peralatan</span>
        <span class="badge bg-primary ms-auto" style="border-radius:50px;">{{ $equipments->count() }} alat</span>
    </div>
    <div class="card-body p-0">
        @if($equipments->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th>Nama Peralatan</th>
                        <th>Deskripsi</th>
                        <th style="width:80px">Stok</th>
                        <th style="width:130px">Status</th>
                        @if(Auth::user()->isAdmin())
                        <th style="width:120px">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipments as $i => $equipment)
                    <tr>
                        <td style="color:#94a3b8;font-size:12px;">{{ $i + 1 }}</td>
                        <td>
                            <div style="font-weight:600;color:#0f172a;">{{ $equipment->name }}</div>
                        </td>
                        <td style="max-width:260px;">
                            <span style="color:#64748b;font-size:13px;">{{ Str::limit($equipment->description, 60) ?: '—' }}</span>
                        </td>
                        <td>
                            <span style="font-weight:700;font-size:16px;color:#0f172a;">{{ $equipment->stock }}</span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $equipment->status }}">
                                @if($equipment->status == 'available') Tersedia
                                @elseif($equipment->status == 'borrowed') Dipinjam
                                @else Perbaikan @endif
                            </span>
                        </td>
                        @if(Auth::user()->isAdmin())
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('equipments.edit', $equipment->id) }}"
                                    class="btn btn-icon btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil" style="font-size:13px;"></i>
                                </a>
                                <form action="{{ route('equipments.destroy', $equipment->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus peralatan \'{{ $equipment->name }}\'?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash" style="font-size:13px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-box-seam"></i>
            <p>Belum ada peralatan. Klik "Tambah Peralatan" untuk mulai.</p>
        </div>
        @endif
    </div>
</div>
@endsection
