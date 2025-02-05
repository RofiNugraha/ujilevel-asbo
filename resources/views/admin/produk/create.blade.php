<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Tambah Produk</h1>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary mb-3">Kembali</a>

                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-plus-circle me-1"></i>
                            Form Tambah Produk
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="nama_produk" class="form-label">Nama Produk</label>
                                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" name="harga" id="harga" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Gambar</label>
                                    <input type="file" name="gambar" id="gambar" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-admin.admin-layout>
