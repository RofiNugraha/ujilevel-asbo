<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-4">
                    <h2 class="mb-4">Pembayaran Customer Non-Booking</h2>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-money-bill me-1"></i>
                            Detail Pembayaran
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>ID Transaksi</th>
                                            <td>{{ $kasir->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Customer</th>
                                            <td>{{ $kasir->customer_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Pembayaran</th>
                                            <td>Rp {{ number_format($kasir->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kursi</th>
                                            <td>{{ $kasir->kursi }}</td>
                                        </tr>
                                        <tr>
                                            <th>Layanan</th>
                                            <td>
                                                @php
                                                // Check if the data is already an array
                                                $layananItems = is_array($kasir->layanan_id) ? $kasir->layanan_id :
                                                json_decode($kasir->layanan_id, true);
                                                $layananItems = $layananItems ?? []; // Ensure it's not null
                                                @endphp

                                                @foreach($layananItems as $layananItem)
                                                @php
                                                if (is_array($layananItem) && isset($layananItem['id'])) {
                                                $layananId = $layananItem['id'];
                                                $quantity = $layananItem['quantity'] ?? 1;
                                                } else {
                                                $layananId = $layananItem;
                                                $quantity = 1;
                                                }

                                                $layanan = \App\Models\Layanan::find($layananId);
                                                @endphp

                                                @if($layanan)
                                                <div class="badge bg-info mb-1">
                                                    {{ $layanan->nama_layanan }} (x{{ $quantity }})
                                                </div>
                                                @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h4 class="mt-4">Pilih Metode Pembayaran</h4>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <form action="{{ route('admin.kasir.process-non-booking-payment', $kasir->id) }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="tunai">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <i class="fas fa-money-bill me-2"></i> Pembayaran Tunai
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal"
                                        data-bs-target="#midtransModal">
                                        <i class="fas fa-credit-card me-2"></i> Pembayaran Non-Tunai
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal untuk data customer Midtrans -->
    <div class="modal fade" id="midtransModal" tabindex="-1" aria-labelledby="midtransModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="midtransModalLabel">Data Customer untuk Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.kasir.process-non-booking-payment', $kasir->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="payment_method" value="midtrans">

                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Nama Customer</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                value="{{ $kasir->customer_name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Email Customer</label>
                            <input type="email" class="form-control" id="customer_email" name="customer_email"
                                placeholder="customer@example.com" required>
                            <small class="text-muted">Diperlukan untuk proses pembayaran</small>
                        </div>

                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">No. HP Customer</label>
                            <input type="text" class="form-control" id="customer_phone" name="customer_phone"
                                placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Lanjutkan Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.admin-layout>