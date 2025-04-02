<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-4">
                    <h2 class="mb-4">Admin Kasir - Barbershop</h2>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-history me-1"></i>
                            Riwayat Booking Anda
                        </div>
                        <div class="card-header">Tambah Customer Non-Booking</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="riwayat-table">
                                    <thead class="bg-warning">
                                        <tr class="text-dark">
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Layanan</th>
                                            <th>Booking</th>
                                            <th>Kursi</th>
                                            <th>Status</th>
                                            <th>Status Pembayaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($bookings as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>
                                                @php
                                                $layananItems = json_decode($item->layanan_id, true) ?? [];
                                                @endphp
                                                @foreach($layananItems as $layananItem)
                                                <span class="badge bg-primary">
                                                    @php
                                                    $layanan = App\Models\Layanan::find($layananItem['id']);
                                                    @endphp
                                                    @if($layanan)
                                                    <span class="badge bg-primary">
                                                        {{ $layanan->nama_layanan }} (x{{ $layananItem['quantity'] }})
                                                    </span>
                                                    @endif
                                                </span><br>
                                                @endforeach
                                            </td>
                                            <td>{{ $item->jam_booking }}</td>
                                            <td>{{ $item->kursi }}</td>
                                            <td>
                                                @php
                                                $badgeColor = match($item->status) {
                                                'pending' => 'bg-warning',
                                                'konfirmasi' => 'bg-success',
                                                'batal' => 'bg-danger',
                                                'selesai' => 'bg-primary',
                                                default => 'bg-secondary'
                                                };
                                                @endphp

                                                <span class="badge {{ $badgeColor }}">{{ $item->status }}</span>
                                            </td>
                                            <td>
                                                @if($item->status_pembayaran == 'unpaid')
                                                <span class="badge bg-danger">Unpaid</span>
                                                @else
                                                <span class="badge bg-success">Paid</span>
                                                @endif
                                            </td>
                                            <td>
                                                <<<<<<< HEAD <button id="pay-button">Pay!</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td>2</td>
                                            <td>popay</td>
                                            <td><span class="badge bg-primary">Layanan B (x1)</span></td>
                                            <td>2:00 PM</td>
                                            <td>2</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                            <td><span class="badge bg-success">Paid</span></td>
                                            <td>
                                                <button id="pay-button">Bayar Sekarang</button>
                                                =======
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i> Batalkan
                                                </button>
                                                <button class="btn btn-success btn-sm" onclick="openPaymentModal()">
                                                    <i class="fas fa-wallet"></i> Bayar
                                                </button>
                                                >>>>>>> 3b5ee3fce06cace15269c31e20053cf50a1b6255
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <<<<<<< HEAD <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
        window.snap.embed('data.snap_token', {
        embedId: 'snap-container'
        });
        });
        =======
        <!-- Modal Pembayaran -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="paymentModalLabel">💳 Pilih Metode Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="fw-bold">Silakan pilih metode pembayaran yang tersedia:</p>
                        <div class="d-grid gap-3">
                            <button
                                class="btn btn-outline-primary py-3 fs-5 d-flex align-items-center justify-content-center">
                                <i class="fas fa-university me-2"></i> Transfer Bank
                            </button>
                            <button
                                class="btn btn-outline-warning py-3 fs-5 d-flex align-items-center justify-content-center">
                                <i class="fas fa-mobile-alt me-2"></i> E-Wallet (GoPay, OVO, Dana)
                            </button>
                            <button
                                class="btn btn-outline-danger py-3 fs-5 d-flex align-items-center justify-content-center">
                                <i class="fas fa-credit-card me-2"></i> Kartu Kredit/Debit
                            </button>
                            <button
                                class="btn btn-outline-success py-3 fs-5 d-flex align-items-center justify-content-center">
                                <i class="fas fa-money-bill-wave me-2"></i> Bayar di Tempat (Cash)
                            </button>
                        </div>
                        <p class="mt-4 text-muted">Pastikan pembayaran sesuai dengan total biaya layanan.</p>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>


        <script>
        $(document).ready(function() {
            $('#riwayat-table').DataTable();
        });

        function openPaymentModal() {
            var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            paymentModal.show();
        } >>>
        >>>
        >
        3 b5ee3fce06cace15269c31e20053cf50a1b6255
        </script>
</x-admin.admin-layout>