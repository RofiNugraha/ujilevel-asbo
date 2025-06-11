<x-landing-layout>
    <main
        class="bg-white bg-opacity-95 backdrop-blur-lg w-full max-w-4xl min-h-screen mx-auto my-12 rounded-3xl shadow-2xl overflow-hidden text-gray-800">
        <div class="p-6">
            <!-- Header Section -->
            <div class="bg-gradient-to-r bg-black text-white p-6 rounded-t-xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-history text-xl"></i>
                        <h1 class="text-2xl font-bold">Riwayat Pesanan</h1>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            @if($transactions->isEmpty())
            <div class="text-center py-12 bg-gray-50 rounded-xl">
                <img src="{{ asset('images/empty-cart.svg') }}" alt="No Orders" class="w-48 mx-auto mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Pesanan</h3>
                <p class="text-gray-600 mb-6">Anda belum memiliki riwayat pesanan.</p>
                <a href="{{ route('layanan.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 text-white font-medium rounded-full shadow-md hover:shadow-lg transition">
                    <i class="fas fa-store mr-2"></i>Lihat Layanan Kami
                </a>
            </div>
            @else
            <!-- Transactions Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                ID Pesanan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                Metode Pembayaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-blue-800">#{{ $transaction->id }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-gray-700">
                                    {{ $transaction->created_at->format('d M Y, H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">
                                Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 border">
                                    @if($transaction->metode_pembayaran == 'transfer')
                                    <i class="fas fa-university mr-1"></i>
                                    @elseif($transaction->metode_pembayaran == 'qris')
                                    <i class="fas fa-qrcode mr-1"></i>
                                    @elseif($transaction->metode_pembayaran == 'cash')
                                    <i class="fas fa-money-bill-wave mr-1"></i>
                                    @endif
                                    {{ ucfirst($transaction->metode_pembayaran) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($transaction->status_transaksi == 'pending')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Menunggu
                                    Pembayaran
                                </span>
                                @elseif($transaction->status_transaksi == 'success')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">Berhasil
                                </span>
                                @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Gagal
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="{{ route('lihat_riwayat_pesanan', $transaction->id) }}"
                                        class="inline-flex items-center px-3 py-2 border border-blue-500 rounded-md text-sm font-medium text-blue-700 bg-white hover:bg-blue-50 transition">
                                        Detail
                                    </a>

                                    @if($transaction->status_transaksi == 'pending')
                                    <a href="{{ route('payment.show', $transaction->id) }}"
                                        class="inline-flex items-center px-3 py-2 border border-transparent rounded-md text-sm font-medium text-yellow-800 bg-yellow-400 hover:bg-yellow-500 transition">
                                        <i class="fas fa-credit-card mr-1"></i>Bayar
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </main>
</x-landing-layout>