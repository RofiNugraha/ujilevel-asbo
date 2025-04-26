<x-admin.admin-layout>
    <style>
    .badge {
        font-size: 0.85em;
        font-weight: 600;
        padding: 0.35em 0.65em;
    }
    </style>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container">
                    <h1 class="mb-4">Riwayat Transaksi</h1>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi Sukses</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Transaksi</th>
                                            <th>Customer</th>
                                            <th>ID Booking/User</th>
                                            <th>Total Harga</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Payment Type</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $index => $transaction)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $transaction->id }}</td>
                                            <td>
                                                @if($transaction->user_id)
                                                {{ $transaction->user->name }}
                                                @else
                                                Non-booking
                                                @endif
                                            </td>
                                            <td>
                                                @if($transaction->booking_id && $transaction->user_id)
                                                Booking ID: {{ $transaction->booking_id }}<br>
                                                User ID: {{ $transaction->user_id }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                            <td>{{ $transaction->metode_pembayaran }}</td>
                                            <td>{{ $transaction->payment_type ?? '-' }}</td>
                                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('admin.riwayat.show', $transaction->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
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

    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [
                [7, "desc"]
            ]
        });
    });
    </script>
</x-admin.admin-layout>