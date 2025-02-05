<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Tambah Layanan</h1>
                    <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary mb-3">Kembali</a>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-plus me-1"></i>
                            Form Tambah Layanan
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.layanan.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama_layanan" class="form-label">Nama Layanan</label>
                                    <input type="text" name="nama_layanan" id="nama_layanan" class="form-control"
                                        required>
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