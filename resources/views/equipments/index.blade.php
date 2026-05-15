<h1>Daftar Equipment</h1>

<a href="{{ route('equipments.create') }}">Tambah Equipment Baru</a>

<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Stok</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($equipments as $equipment)
        <tr>
            <td>{{ $equipment->id }}</td>
            <td>{{ $equipment->name }}</td>
            <td>{{ $equipment->description }}</td>
            <td>{{ $equipment->stock }}</td>
            <td>{{ $equipment->status }}</td>
            <td>
                <form action="{{ route('equipments.destroy', $equipment->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
