<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-4">
                    <h2 class="mb-4">Admin Kasir - Barbershop</h2>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-history me-1"></i>
                            Riwayat Booking
                        </div>
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#tambahCustomerModal">
                                <i class="fas fa-plus me-1"></i> Tambah Customer Non-Booking
                            </button>
                        </div>
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
                                            <th>Pembayaran</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($bookings as $item)
                                        @php
                                        // Hitung total harga
                                        $totalHarga = 0;
                                        $layananItems = json_decode($item->layanan_id, true) ?? [];
                                        foreach ($layananItems as $layananItem) {
                                        // Ekstrak ID dan quantity
                                        if (is_array($layananItem) && isset($layananItem['id'])) {
                                        $layananId = $layananItem['id'];
                                        $quantity = $layananItem['quantity'] ?? 1;
                                        } else {
                                        $layananId = $layananItem;
                                        $quantity = 1;
                                        }

                                        // Ambil data layanan - PASTIKAN single model
                                        $layanan = App\Models\Layanan::where('id', $layananId)->first();

                                        if ($layanan) {
                                        $totalHarga += $layanan->harga * $quantity;
                                        }
                                        }

                                        // Cek status DP
                                        $dpPaid = false;
                                        $dpAmount = 0;
                                        if ($item->order_id) {
                                        $order = App\Models\Order::find($item->order_id);
                                        if ($order && $order->status == 'Paid') {
                                        $dpPaid = true;
                                        $dpAmount = $order->dp;
                                        }
                                        }

                                        // Cek status pembayaran
                                        $checkout = App\Models\Checkout::where('booking_id', $item->id)->first();
                                        $status_pembayaran = $checkout ? $checkout->status_pembayaran : 'unpaid';
                                        @endphp
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>
                                                @foreach($layananItems as $layananItem)
                                                @php
                                                if (is_array($layananItem) && isset($layananItem['id'])) {
                                                $layananId = $layananItem['id'];
                                                $quantity = $layananItem['quantity'] ?? 1;
                                                } else {
                                                $layananId = $layananItem;
                                                $quantity = 1;
                                                }

                                                // Pastikan mendapatkan single model, bukan Collection
                                                $layanan = App\Models\Layanan::where('id', $layananId)->first();
                                                @endphp

                                                @if($layanan)
                                                <span class="badge bg-primary">
                                                    {{ $layanan->nama_layanan }} (x{{ $quantity }})
                                                </span><br>
                                                @endif
                                                @endforeach
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->jam_booking)->format('d M Y H:i') }}
                                            </td>
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
                                                @if($status_pembayaran == 'unpaid')
                                                <span class="badge bg-danger">Unpaid</span>
                                                @else
                                                <span class="badge bg-success">Paid</span>
                                                @endif
                                                @if($dpPaid)
                                                <div class="small text-success mt-1">
                                                    DP: Rp {{ number_format($dpAmount, 0, ',', '.') }}
                                                </div>
                                                @endif
                                            </td>
                                            <td>
                                                Rp
                                                {{ number_format($totalHarga - ($dpPaid ? $dpAmount : 0), 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @if($status_pembayaran == 'unpaid')
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button"
                                                        id="paymentDropdown{{ $item->id }}" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        Bayar
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="paymentDropdown{{ $item->id }}">
                                                        <li>
                                                            <form
                                                                action="{{ route('admin.kasir.process-payment', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="payment_method"
                                                                    value="tunai">
                                                                <button type="submit"
                                                                    class="dropdown-item">Tunai</button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('admin.kasir.process-payment', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="payment_method"
                                                                    value="midtrans">
                                                                <button type="submit" class="dropdown-item">Non
                                                                    Tunai</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @else
                                                <button class="btn btn-success" disabled>Sudah Dibayar</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-users me-1"></i>
                            Customer Non-Booking
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="non-booking-table">
                                    <thead class="bg-info">
                                        <tr class="text-dark">
                                            <th>No.</th>
                                            <th>ID Transaksi</th>
                                            <th>Nama</th>
                                            <th>Layanan</th>
                                            <th>Status</th>
                                            <th>Pembayaran</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($nonBookingTransactions as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->customer_name }}</td>
                                            <td>
                                                @php
                                                $layananItems = is_array($item->layanan_id)
                                                ? $item->layanan_id
                                                : (json_decode($item->layanan_id, true) ?? []);
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

                                                $layanan = App\Models\Layanan::where('id', $layananId)->first();
                                                @endphp

                                                @if($layanan)
                                                <span class="badge bg-primary">
                                                    {{ $layanan->nama_layanan }} (x{{ $quantity }})
                                                </span><br>
                                                @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @php
                                                $badgeColor = match($item->status_transaksi) {
                                                'pending' => 'bg-warning',
                                                'success' => 'bg-success',
                                                'failed' => 'bg-danger',
                                                default => 'bg-secondary'
                                                };
                                                @endphp
                                                <span
                                                    class="badge {{ $badgeColor }}">{{ $item->status_transaksi }}</span>
                                            </td>
                                            <td>
                                                @if($item->metode_pembayaran)
                                                {{ ucfirst($item->metode_pembayaran) }}
                                                @else
                                                <span class="badge bg-danger">Belum Dibayar</span>
                                                @endif
                                            </td>
                                            <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                            <td>
                                                @if($item->status_transaksi == 'pending')
                                                <a href="{{ route('admin.kasir.payment-options', $item->id) }}"
                                                    class="btn btn-sm btn-primary">Bayar</a>
                                                @else
                                                <button class="btn btn-sm btn-success" disabled>Selesai</button>
                                                @endif
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

    <!-- Di dalam modal tambah customer -->
    <div class="modal fade" id="tambahCustomerModal" tabindex="-1" aria-labelledby="tambahCustomerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahCustomerModalLabel">Tambah Customer Non-Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.kasir.add-non-booking') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                value="customer" hidden>
                        </div>
                        <div class="mb-3">
                            <label for="layanan" class="form-label">Layanan</label>
                            <select class="form-select" id="layanan" name="layanan_id[]" multiple required>
                                @foreach(\App\Models\Layanan::all() as $layanan)
                                <option value="{{ $layanan->id }}">{{ $layanan->nama_layanan }} -
                                    Rp{{ number_format($layanan->harga, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kursi" class="form-label">Kursi</label>
                            <select class="form-select" id="kursi" name="kursi" required>
                                <option value="satu">Kursi 1</option>
                                <option value="dua">Kursi 2</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1"
                                hidden>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.admin-layout>