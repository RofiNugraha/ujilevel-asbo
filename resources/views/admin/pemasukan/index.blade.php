 <x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Laporan Pemasukan</h1>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
                            <a href="{{ route('admin.pemasukan.export', request()->query()) }}"
                                class="btn btn-sm btn-success">
                                <i class="fas fa-file-excel mr-1"></i> Export Excel
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.pemasukan.index') }}" method="GET" class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="start_date">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ $startDate->format('Y-m-d') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="end_date">Tanggal Akhir</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ $endDate->format('Y-m-d') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="customer_type">Jenis Customer</label>
                                    <select name="customer_type" id="customer_type" class="form-control">
                                        <option value="all" {{ $customerType == 'all' ? 'selected' : '' }}>Semua
                                        </option>
                                        <option value="booking" {{ $customerType == 'booking' ? 'selected' : '' }}>
                                            Booking</option>
                                        <option value="non-booking"
                                            {{ $customerType == 'non-booking' ? 'selected' : '' }}>
                                            Non-Booking</option>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end mb-3">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('admin.pemasukan.index') }}"
                                        class="btn btn-secondary ml-2">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Dashboard Summary Cards -->
                    <div class="row">
                        <!-- Total Pemasukan Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Pemasukan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                                {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Customer Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Pemasukan Customer Booking</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                                {{ number_format($summaryByCustomerType['booking'], 0, ',', '.') }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Non-Booking Customer Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Pemasukan Customer Non-Booking</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                                {{ number_format($summaryByCustomerType['non_booking'], 0, ',', '.') }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Summary -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pemasukan Berdasarkan Metode Pembayaran</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Metode Pembayaran</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($summaryByPaymentMethod as $method => $total)
                                        <tr>
                                            <td>{{ $method }}</td>
                                            <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak ada data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction List -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID Transaksi</th>
                                            <th>Tanggal</th>
                                            <th>Booking ID</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->id }}</td>
                                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $transaction->booking_id ?? '-' }}</td>
                                            <td>{{ $transaction->metode_pembayaran }}</td>
                                            <td>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data transaksi</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-4">
                                    {{ $transactions->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Script untuk memastikan tanggal akhir tidak lebih awal dari tanggal mulai
        $('#start_date').on('change', function() {
            var startDate = $(this).val();
            if (startDate && $('#end_date').val() && new Date(startDate) > new Date($(
                        '#end_date')
                    .val())) {
                $('#end_date').val(startDate);
            }
        });

        $('#end_date').on('change', function() {
            var endDate = $(this).val();
            if (endDate && $('#start_date').val() && new Date(endDate) < new Date($(
                        '#start_date')
                    .val())) {
                $('#start_date').val(endDate);
            }
        });
    });
    </script>
</x-admin.admin-layout>