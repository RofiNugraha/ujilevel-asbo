<h1>Edit Produk</h1>

<form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label for="nama_produk">Nama Produk</label>
    <input type="text" name="nama_produk" id="nama_produk" value="{{ $produk->nama_produk }}" required>

    <label for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi">{{ $produk->deskripsi }}</textarea>

    <label for="harga">Harga</label>
    <input type="number" name="harga" id="harga" value="{{ $produk->harga }}" required>

    <label for="gambar">Gambar</label>
    <input type="file" name="gambar" id="gambar">

    @if($produk->gambar)
    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar" width="100">
    @endif

    <button type="submit">Update</button>
</form>