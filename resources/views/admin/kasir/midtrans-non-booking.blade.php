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
                        <div class="card-body text-center">
                            <h4>Total Pembayaran: Rp {{ number_format($kasir->total_harga, 0, ',', '.') }}</h4>
                            <p>Silakan melakukan pembayaran dengan metode yang tersedia.</p>

                            <button id="pay-button" class="btn btn-primary btn-lg mt-3">Bayar Sekarang</button>

                            <div class="mt-4">
                                <a href="{{ route('admin.kasir.index') }}" class="btn btn-secondary">Kembali ke Daftar
                                    Transaksi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    <script>
    document.getElementById('pay-button').onclick = function() {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href =
                    '{{ route("admin.kasir.midtrans-finish") }}?order_id={{ $kasir->id }}&transaction_status=settlement';
            },
            onPending: function(result) {
                window.location.href =
                    '{{ route("admin.kasir.midtrans-finish") }}?order_id={{ $kasir->id }}&transaction_status=pending';
            },
            onError: function(result) {
                window.location.href =
                    '{{ route("admin.kasir.midtrans-finish") }}?order_id={{ $kasir->id }}&transaction_status=error';
            },
            onClose: function() {
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    };
    </script>
</x-admin.admin-layout>