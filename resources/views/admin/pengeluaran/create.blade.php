<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Tambah Pengeluaran</h1>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Pengeluaran</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.pengeluaran.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="nama">Nama Pengeluaran <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" value="{{ old('nama') }}" required>
                                    @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="kategori">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-control @error('kategori') is-invalid @enderror" id="kategori"
                                        name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="pribadi" {{ old('kategori') == 'pribadi' ? 'selected' : '' }}>
                                            Pribadi</option>
                                        <option value="toko" {{ old('kategori') == 'toko' ? 'selected' : '' }}>Toko
                                        </option>
                                    </select>
                                    @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="harga">Jumlah Pengeluaran (Rp) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                        id="harga" name="harga" value="{{ old('harga') }}" min="1" required>
                                    @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="bukti_pembayaran">Bukti Pembayaran <span
                                            class="text-danger">*</span></label>
                                    <input type="file"
                                        class="form-control-file @error('bukti_pembayaran') is-invalid @enderror"
                                        id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*" required>
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal ukuran:
                                        2MB.</small>
                                    @error('bukti_pembayaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('admin.pengeluaran.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
    document.getElementById('bukti_pembayaran').onchange = function() {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image-preview').src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    };
    </script>
</x-admin.admin-layout>