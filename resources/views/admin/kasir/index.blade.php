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
                                            <div class="card layanan-card"
                                                onclick="tambahLayanan('Haircut', 50000, '{{ asset('images/google.png') }}')">
                                                <img src="{{ asset('images/google.png') }}" class="card-img-top"
                                                    alt="Haircut">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Haircut</h5>
                                                    <p class="card-text">Potong rambut stylish dan rapi.</p>
                                                    <p class="fw-bold">Rp50.000</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card layanan-card"
                                                onclick="tambahLayanan('Shave', 30000, '{{ asset('images/google.png') }}')">
                                                <img src="{{ asset('images/google.png') }}" class="card-img-top"
                                                    alt="Shave">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Shave</h5>
                                                    <p class="card-text">Cukur jenggot atau kumis dengan rapi.</p>
                                                    <p class="fw-bold">Rp30.000</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card layanan-card"
                                                onclick="tambahLayanan('Haircut & Shave', 70000, '{{ asset('images/google.png') }}')">
                                                <img src="{{ asset('images/google.png') }}" class="card-img-top"
                                                    alt="Haircut & Shave">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Haircut & Shave</h5>
                                                    <p class="card-text">Paket lengkap potong rambut dan cukur.</p>
                                                    <p class="fw-bold">Rp70.000</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Keranjang Layanan -->
                                <div class="card mt-3 shadow-lg">
                                    <div class="card-header text-white d-flex align-items-center"
                                        style="background-color: gold;">
                                        <i class="bi bi-cart-fill me-2"></i> Keranjang Layanan
                                    </div>
                                    <div class="card-body">
                                        <ul id="keranjang" class="list-group mb-3"></ul>
                                        <h5 class="text-end">Total: <span id="totalHarga" class="fw-bold"
                                                style="color: gold;">Rp0</span></h5>
                                    </div>
                                </div>

                                <button type="button" class="btn text-white mt-3 w-100 fw-bold"
                                    style="background-color: gold;" onclick="tambahBooking()">
                                    <i class="bi bi-plus-circle"></i> Tambah
                                </button>


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
                                        <th>Total Harga</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody id="riwayatBooking"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <script>
                let layananTerpilih = [];

                function tambahLayanan(nama, harga, gambar) {
                    layananTerpilih.push({
                        nama,
                        harga,
                        gambar
                    });
                    updateKeranjang();
                }

                function updateKeranjang() {
                    let keranjang = document.getElementById("keranjang");
                    keranjang.innerHTML = "";
                    let total = 0;

                    layananTerpilih.forEach((item, index) => {
                        total += item.harga;
                        let li = document.createElement("li");
                        li.className = "list-group-item d-flex justify-content-between align-items-center";
                        li.innerHTML =
                            `<img src="${item.gambar}" alt="${item.nama}" width="50" class="me-2"> ${item.nama} - Rp${item.harga.toLocaleString()} <button class='btn btn-danger btn-sm' onclick='hapusLayanan(${index})'>X</button>`;
                        keranjang.appendChild(li);
                    });

                    document.getElementById("totalHarga").textContent = `Rp${total.toLocaleString()}`;
                }

                function hapusLayanan(index) {
                    layananTerpilih.splice(index, 1);
                    updateKeranjang();
                }

                function tambahBooking() {
                    let nama = document.getElementById("namaCustomer").value;
                    if (nama === "" || layananTerpilih.length === 0) {
                        alert("Nama customer dan layanan harus dipilih!");
                        return;
                    }
                    let tanggal = new Date().toLocaleDateString();
                    let totalHarga = layananTerpilih.reduce((acc, item) => acc + item.harga, 0);
                    let layananList = layananTerpilih.map(item => item.nama).join(", ");

                    let table = document.getElementById("riwayatBooking");
                    let newRow = table.insertRow();
                    newRow.innerHTML =
                        `<td>${nama}</td><td>${layananList}</td><td>Rp${totalHarga.toLocaleString()}</td><td>${tanggal}</td>`;

                    document.getElementById("customerForm").reset();
                    layananTerpilih = [];
                    updateKeranjang();
                }
                </script>
            </main>
        </div>
    </div>
</x-admin.admin-layout>