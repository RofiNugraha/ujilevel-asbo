<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi #{{ $transaction->id }}</h6>
                            <a href="{{ route('admin.riwayat.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Informasi Transaksi</h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">ID Transaksi</th>
                                            <td>{{ $transaction->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tipe Customer</th>
                                            <td>
                                                @if($transaction->user_id)
                                                {{ $transaction->user->name }}
                                                @else
                                                Non-booking
                                                @endif
                                            </td>
                                        </tr>
                                        @if($transaction->booking_id && $transaction->user_id)
                                        <tr>
                                            <th>Booking ID</th>
                                            <td>{{ $transaction->booking_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>User ID</th>
                                            <td>{{ $transaction->user_id }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>Total Harga</th>
                                            <td>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Metode Pembayaran</th>
                                            <td>{{ $transaction->metode_pembayaran }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                {{ $transaction->status_transaksi }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Transaksi</th>
                                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5>Detail Layanan</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID Layanan</th>
                                                <th>Nama Layanan</th>
                                                <th>Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transaction->layanan_details as $layanan)
                                            <tr>
                                                <td>{{ $layanan['id'] ?? $layanan['id'] }}</td>
                                                <td>{{ $layanan['nama_layanan'] ?? 'N/A' }}</td>
                                                <td>Rp {{ number_format($layanan['harga'] ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-admin.admin-layout>