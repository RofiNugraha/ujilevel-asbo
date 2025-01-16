<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Tambah Layanan</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-plus me-1"></i>
                            Tambah Layanan Baru
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.layanan.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="tipe_customer" class="form-label">Tipe Customer</label>
                                    <input type="text" class="form-control" id="tipe_customer" name="tipe_customer" required>
                                </div>
                                <div class="mb-3">
                                    <label for="layanan_tambahan" class="form-label">Layanan Tambahan</label>
                                    <input type="text" class="form-control" id="layanan_tambahan" name="layanan_tambahan" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kursi" class="form-label">Kursi</label>
                                    <input type="number" class="form-control" id="kursi" name="kursi" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jam_booking" class="form-label">Jam Booking</label>
                                    <input type="time" class="form-control" id="jam_booking" name="jam_booking" required>
                                </div>
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" class="form-control" id="harga" name="harga" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
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
