<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-4">
                    <h2 class="mb-4">Pembayaran Non-Tunai</h2>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-credit-card me-1"></i>
                            Pembayaran via Midtrans
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Detail Booking</h5>
                                    <table class="table">
                                        <tr>
                                            <th>Nama</th>
                                            <td>{{ $booking->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal & Jam</th>
                                            <td>{{ \Carbon\Carbon::parse($booking->jam_booking)->format('d M Y H:i') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Kursi</th>
                                            <td>{{ $booking->kursi }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5>Layanan</h5>
                                    <ul class="list-group">
                                        @php
                                        $layananItems = json_decode($booking->layanan_id, true) ?? [];
                                        $totalHarga = 0;
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

                                        $layanan = App\Models\Layanan::find($layananId);
                                        if($layanan) {
                                        $totalHarga += $layanan->harga * $quantity;
                                        }
                                        @endphp
                                        @if(isset($layanan) && $layanan)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $layanan->nama_layanan }}
                                            <span>{{ $quantity }} x Rp
                                                {{ number_format($layanan->harga, 0, ',', '.') }}</span>
                                        </li>
                                        @endif
                                        @endforeach

                                        @if(isset($dpPaid) && $dpPaid && isset($dpAmount) && $dpAmount > 0)
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center text-danger">
                                            Pembayaran DP (Sudah Dibayar)
                                            <span>- Rp {{ number_format($dpAmount, 0, ',', '.') }}</span>
                                        </li>
                                        @php
                                        $totalHarga -= $dpAmount;
                                        @endphp
                                        @endif

                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                                            Total
                                            <span>Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Midtrans JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    <script>
    document.getElementById('pay-button').onclick = function() {
        // Trigger snap popup
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = '{{ route("admin.kasir.midtrans-finish") }}?' +
                    'order_id=' + result.order_id +
                    '&transaction_status=' + result.transaction_status;
            },
            onPending: function(result) {
                window.location.href = '{{ route("admin.kasir.midtrans-finish") }}?' +
                    'order_id=' + result.order_id +
                    '&transaction_status=' + result.transaction_status;
            },
            onError: function(result) {
                window.location.href = '{{ route("admin.kasir.midtrans-finish") }}?' +
                    'order_id=' + result.order_id +
                    '&transaction_status=' + result.transaction_status;
            },
            onClose: function() {
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    };
    </script>
</x-admin.admin-layout>