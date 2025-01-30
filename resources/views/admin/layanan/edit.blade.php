<h1>Edit Layanan</h1>
<form action="{{ route('admin.layanan.update', $layanan->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label for="nama_layanan">Nama Layanan</label>
    <input type="text" name="nama_layanan" id="nama_layanan" value="{{ $layanan->nama_layanan }}" required>

    <label for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi">{{ $layanan->deskripsi }}</textarea>

    <label for="harga">Harga</label>
    <input type="number" name="harga" id="harga" value="{{ $layanan->harga }}" required>

    <label for="gambar">Gambar</label>
    <input type="file" name="gambar" id="gambar">

    @if($layanan->gambar)
    <img src="{{ asset('storage/' . $layanan->gambar) }}" alt="Gambar" width="100">
    @endif

    <button type="submit">Update</button>
</form>