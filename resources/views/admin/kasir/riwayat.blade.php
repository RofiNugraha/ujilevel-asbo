<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-4">
                    <h2 class="mb-4">Riwayat Transaksi Selesai</h2>

                    {{-- Booking Transaksi Selesai --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-check-circle me-1"></i>
                            Booking - Transaksi Selesai
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="booking-riwayat-table">
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Layanan</th>
                                            <th>Waktu Booking</th>
                                            <th>Kursi</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Ahmad Fauzi</td>
                                            <td>
                                                <span class="badge bg-primary">Cukur Rambut (x1)</span>
                                                <span class="badge bg-primary">Cuci Rambut (x1)</span>
                                            </td>
                                            <td>20 Apr 2025 14:00</td>
                                            <td>A1</td>
                                            <td>Rp 50.000</td>
                                            <td><span class="badge bg-success">Paid</span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Siti Nurhaliza</td>
                                            <td>
                                                <span class="badge bg-primary">Facial (x1)</span>
                                            </td>
                                            <td>19 Apr 2025 16:00</td>
                                            <td>B3</td>
                                            <td>Rp 75.000</td>
                                            <td><span class="badge bg-success">Paid</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Non-Booking Transaksi Selesai --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-user-check me-1"></i>
                            Non-Booking - Transaksi Selesai
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="nonbooking-riwayat-table">
                                    <thead class="bg-info text-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th>ID Transaksi</th>
                                            <th>Nama</th>
                                            <th>Layanan</th>
                                            <th>Total</th>
                                            <th>Pembayaran</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>TRX-00123</td>
                                            <td>Bayu Saputra</td>
                                            <td>
                                                <span class="badge bg-primary">Cukur Rambut (x1)</span>
                                            </td>
                                            <td>Rp 30.000</td>
                                            <td>Tunai</td>
                                            <td><span class="badge bg-success">Success</span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>TRX-00124</td>
                                            <td>Dewi Lestari</td>
                                            <td>
                                                <span class="badge bg-primary">Hair Spa (x1)</span>
                                            </td>
                                            <td>Rp 100.000</td>
                                            <td>QRIS</td>
                                            <td><span class="badge bg-success">Success</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</x-admin.admin-layout>
