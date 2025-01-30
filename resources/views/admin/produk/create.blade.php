<h1>Create produk</h1>
<a href="{{ route('admin.produk.index') }}">back</a>
<form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="nama_produk">Nama produk</label>
    <input type="text" name="nama_produk" id="nama_produk" required>

    <label for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi"></textarea>

    <label for="harga">Harga</label>
    <input type="number" name="harga" id="harga" required>

    <label for="gambar">Gambar</label>
    <input type="file" name="gambar" id="gambar">

    <button type="submit">Save</button>
</form>