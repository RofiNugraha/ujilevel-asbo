<h1>Create Layanan</h1>
<a href="{{ route('admin.layanan.index') }}">back</a>
<form action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="nama_layanan">Nama Layanan</label>
    <input type="text" name="nama_layanan" id="nama_layanan" required>

    <label for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi"></textarea>

    <label for="harga">Harga</label>
    <input type="number" name="harga" id="harga" required>

    <label for="gambar">Gambar</label>
    <input type="file" name="gambar" id="gambar">

    <button type="submit">Save</button>
</form>