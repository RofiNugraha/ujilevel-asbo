<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="">.</h1>
                    <h1 class="mt-2">Kasir - Barbershop</h1>
                    <a href="" class="btn btn-primary mb-3">Tambah Layanan</a>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Booking
                        </div>
                        <div class="card-body">
                            <!-- Pencarian Pelanggan -->
                            <div class="mb-3">
                                <input type="text" class="form-control" id="searchCustomer"
                                    placeholder="Cari pelanggan...">
                            </div>
                            <table class="table table-hover" id="myTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Layanan</th>
                                        <th>Produk</th>
                                        <th>Tanggal</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>John Doe</td>
                                        <td>Haircut</td>
                                        <td>Pomade</td>
                                        <td>10 Feb 2025</td>
                                        <td>Rp50.000</td>
                                        <td><button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#paymentModal">Bayar</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal Pembayaran -->
                <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="paymentModalLabel">Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="mb-3">
                                        <label class="form-label">Total Harga</label>
                                        <input type="text" class="form-control" value="Rp50.000" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Metode Pembayaran</label>
                                        <select class="form-control" id="paymentMethod">
                                            <option value="Tunai">Tunai</option>
                                            <option value="QRIS">QRIS</option>
                                        </select>
                                    </div>
                                    <div id="qrisContainer" class="text-center d-none">
                                        <p>Scan QR Code untuk pembayaran</p>
                                        <img id="qrisImage" src="" alt="QRIS Code" class="img-fluid">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 mt-3">Konfirmasi
                                        Pembayaran</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("paymentMethod").addEventListener("change", function() {
                    var qrisContainer = document.getElementById("qrisContainer");
                    var qrisImage = document.getElementById("qrisImage");
                    if (this.value === "QRIS") {
                        qrisImage.src = "{{ asset('images/qr.png') }}"; // Ganti dengan URL QRIS asli
                        qrisContainer.classList.remove("d-none");
                    } else {
                        qrisContainer.classList.add("d-none");
                    }
                });
            });
            </script>
        </div>
    </div>
</x-admin.admin-layout>