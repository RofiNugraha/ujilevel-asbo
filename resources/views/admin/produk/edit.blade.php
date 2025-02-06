<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit Produk</h1>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary mb-3">Kembali</a>

                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-edit me-1"></i>
                            Form Edit Produk
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="nama_produk" class="form-label">Nama Produk</label>
                                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3">{{ $produk->deskripsi }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" name="harga" id="harga" class="form-control" value="{{ $produk->harga }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Gambar</label>
                                    <input type="file" name="gambar" id="gambar" class="form-control">
                                </div>

                                @if($produk->gambar)
                                <div class="mb-3">
                                    <label class="form-label">Gambar Saat Ini</label><br>
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk" width="150" class="img-thumbnail">
                                </div>
                                @endif

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-admin.admin-layout>
