<h1>Tambah Equipment</h1>

<form action="{{ route('equipments.store') }}" method="POST">
    @csrf

    <div>
        <label>Nama Equipment</label>
        <input type="text" name="name">
    </div>

    <br>

    <div>
        <label>Description</label>
        <textarea name="description"></textarea>
    </div>

    <br>

    <div>
        <label>Stock</label>
        <input type="number" name="stock">
    </div>

    <br>

    <div>
        <label>Status</label>

        <select name="status">
            <option value="available">Available</option>
            <option value="borrowed">Borrowed</option>
            <option value="maintenance">Maintenance</option>
        </select>
    </div>

    <br>

    <button type="submit">
        Simpan
    </button>

</form>