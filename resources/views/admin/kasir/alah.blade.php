<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-4">
                    <h2 class="mb-4">Admin Kasir - Barbershop</h2>

                    <!-- Form Input Customer Non-Booking -->
                    <div class="card mb-4">
                        <div class="card-header">Tambah Customer Non-Booking</div>
                        <div class="card-body">
                            <form id="customerForm">
                                <div class="mb-3">
                                    <label class="form-label">Nama Customer</label>
                                    <input type="text" class="form-control" id="namaCustomer" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pilih Layanan</label>
                                    <div class="row" id="layananContainer">
                                        <div class="col-md-4">
                                            <div class="card layanan-card" onclick="pilihLayanan('Haircut', '50.000')">
                                                <img src="{{ asset('images/logo.png') }}" class="card-img-top" alt="Haircut">
                                                <div class="card-body">
                                                    <h5 class="card-title">Haircut</h5>
                                                    <p class="card-text">Potong rambut stylish dan rapi.</p>
                                                    <p class="fw-bold">Rp50.000</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card layanan-card" onclick="pilihLayanan('Shave', '30.000')">
                                                <img src="{{ asset('images/logo.png') }}" class="card-img-top" alt="Shave">
                                                <div class="card-body">
                                                    <h5 class="card-title">Shave</h5>
                                                    <p class="card-text">Cukur jenggot atau kumis dengan rapi.</p>
                                                    <p class="fw-bold">Rp30.000</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card layanan-card"
                                                onclick="pilihLayanan('Haircut & Shave', '70.000')">
                                                <img src="{{ asset('images/logo.png') }}" class="card-img-top" alt="Haircut & Shave">
                                                <div class="card-body">
                                                    <h5 class="card-title">Haircut & Shave</h5>
                                                    <p class="card-text">Paket lengkap potong rambut dan cukur.</p>
                                                    <p class="fw-bold">Rp70.000</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="layanan" value="">
                                <button type="button" class="btn btn-primary" onclick="tambahBooking()">Tambah</button>
                            </form>
                        </div>
                    </div>

                    <!-- Tabel Riwayat Booking -->
                    <div class="card">
                        <div class="card-header">Riwayat Booking</div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Customer</th>
                                        <th>Layanan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody id="riwayatBooking">
                                    <!-- Data akan ditambahkan melalui JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <script>
                function pilihLayanan(nama, harga) {
                    document.getElementById("layanan").value = `${nama} - Rp${harga}`;
                    alert(`Layanan ${nama} dipilih!`);
                }

                function tambahBooking() {
                    let nama = document.getElementById("namaCustomer").value;
                    let layanan = document.getElementById("layanan").value;
                    let tanggal = new Date().toLocaleDateString();

                    if (nama === "" || layanan === "") {
                        alert("Nama customer dan layanan harus dipilih!");
                        return;
                    }

                    let table = document.getElementById("riwayatBooking");
                    let newRow = table.insertRow();
                    newRow.innerHTML = `<td>${nama}</td><td>${layanan}</td><td>${tanggal}</td>`;

                    document.getElementById("customerForm").reset();
                    document.getElementById("layanan").value = "";
                }
                </script>
            </div>
        </div>
    </div>
</x-admin.admin-layout>