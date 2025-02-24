<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Riwayat Booking</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-history me-1"></i>
                            Riwayat Booking Anda
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="riwayat-table">
                                    <thead class="bg-warning">
                                        <tr class="text-dark">
                                            <th>No.</th>
                                            <th>Layanan</th>
                                            <th>Booking</th>
                                            <th>Kursi</th>
                                            <th>Status</th>
                                            <th>Status Pembayaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><span class="badge bg-primary">Layanan A (x2)</span></td>
                                            <td>10:00 AM</td>
                                            <td>3</td>
                                            <td><span class="badge bg-success">Confirmed</span></td>
                                            <td><span class="badge bg-danger">Unpaid</span></td>
                                            <td>
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i> Batalkan
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><span class="badge bg-primary">Layanan B (x1)</span></td>
                                            <td>2:00 PM</td>
                                            <td>2</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                            <td><span class="badge bg-success">Paid</span></td>
                                            <td>
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="fas fa-lock"></i> Tidak dapat dibatalkan
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                $(document).ready(function () {
                    $('#riwayat-table').DataTable();
                });
                </script>
            </main>
        </div>
    </div>
</x-admin.admin-layout>
