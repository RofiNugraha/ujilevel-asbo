<x-landing-layout>
    <main
        class="bg-white bg-opacity-95 backdrop-blur-lg w-full max-w-4xl min-h-screen mx-auto my-12 rounded-3xl shadow-2xl overflow-hidden text-gray-800">
        <div class="p-6">
            <!-- Header Section -->
            <div class="bg-gradient-to-r bg-black text-white p-6 rounded-t-xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-file-invoice text-xl"></i>
                        <h1 class="text-2xl font-bold">Detail Pesanan</h1>
                    </div>
                    <a href="{{ route('riwayat_pesanan') }}"
                        class="inline-flex items-center px-4 py-2 bg-white text-blue-800 rounded-full shadow-sm hover:bg-gray-100 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>

            <!-- Status Banner -->
            <!-- <div class="mt-6 rounded-lg p-4 
                @if($transaction->status_transaksi == 'pending')
                    bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800
                @elseif($transaction->status_transaksi == 'success')
                    bg-blue-50 border-l-4 border-blue-400 text-blue-800
                @else
                    bg-red-50 border-l-4 border-red-400 text-red-800
                @endif
            ">
                <div class="flex items-center">
                    @if($transaction->status_transaksi == 'pending')
                    <i class="fas fa-hourglass-half text-2xl mr-4 text-yellow-500"></i>
                    @elseif($transaction->status_transaksi == 'success')
                    <i class="fas fa-check-circle text-2xl mr-4 text-blue-500"></i>
                    @else
                    <i class="fas fa-times-circle text-2xl mr-4 text-red-500"></i>
                    @endif
                    <div>
                        <h3 class="font-bold text-lg">
                            @if($transaction->status_transaksi == 'pending')
                            Menunggu Pembayaran
                            @elseif($transaction->status_transaksi == 'success')
                            Pembayaran Berhasil
                            @else
                            Pembayaran Gagal
                            @endif
                        </h3>
                        <p class="text-sm">
                            @if($transaction->status_transaksi == 'pending')
                            Silahkan selesaikan pembayaran untuk melanjutkan proses
                            @elseif($transaction->status_transaksi == 'success')
                            Terima kasih, pembayaran Anda telah dikonfirmasi
                            @else
                            Mohon maaf, terjadi kesalahan pada pembayaran Anda
                            @endif
                        </p>
                    </div>
                </div>
            </div> -->

            <!-- Order Information Sections -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Order Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-black text-white px-5 py-4">
                        <h3 class="font-bold flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>Informasi Pesanan
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 flex items-center">
                                    <i class="far fa-calendar-alt mr-2 text-blue-500"></i>Tanggal Pesanan:
                                </span>
                                <span>{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-tag mr-2 text-blue-500"></i>Status:
                                </span>
                                @if($transaction->status_transaksi == 'pending')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>Menunggu Pembayaran
                                </span>
                                @elseif($transaction->status_transaksi == 'success')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-check-circle mr-1"></i>Berhasil
                                </span>
                                @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>Gagal
                                </span>
                                @endif
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-credit-card mr-2 text-blue-500"></i>Metode Pembayaran:
                                </span>
                                <span>{{ ucfirst($transaction->metode_pembayaran) }}</span>
                            </div>
                            @if($transaction->payment_type)
                            <div class="flex justify-between">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-money-check-alt mr-2 text-blue-500"></i>Tipe Pembayaran:
                                </span>
                                <span>{{ $transaction->payment_type }}</span>
                            </div>
                            @endif
                            @if($transaction->transaction_id)
                            <div class="flex justify-between">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-receipt mr-2 text-blue-500"></i>ID Transaksi:
                                </span>
                                <span class="truncate max-w-[150px]" title="{{ $transaction->transaction_id }}">
                                    {{ $transaction->transaction_id }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Booking Info Card -->
                @if($transaction->booking)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-black text-white px-5 py-4">
                        <h3 class="font-bold flex items-center">
                            <i class="fas fa-calendar-check mr-2"></i>Informasi Booking
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-ticket-alt mr-2 text-blue-500"></i>ID Booking:
                                </span>
                                <span class="font-semibold">{{ $transaction->booking_id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 flex items-center">
                                    <i class="far fa-calendar mr-2 text-blue-500"></i>Tanggal Booking:
                                </span>
                                <span>{{ \Carbon\Carbon::parse($transaction->booking->tanggal_booking)->format('d M Y') }}</span>
                            </div>
                            @if(isset($transaction->booking->waktu_mulai) &&
                            isset($transaction->booking->waktu_selesai))
                            <div class="flex justify-between">
                                <span class="text-gray-600 flex items-center">
                                    <i class="far fa-clock mr-2 text-blue-500"></i>Waktu:
                                </span>
                                <span>{{ $transaction->booking->waktu_mulai }} -
                                    {{ $transaction->booking->waktu_selesai }}</span>
                            </div>
                            @endif
                            @if(isset($transaction->booking->status_booking))
                            <div class="flex justify-between">
                                <span class="text-gray-600 flex items-center">
                                    <i class="fas fa-info-circle mr-2 text-black"></i>Status Booking:
                                </span>
                                @if($transaction->booking->status_booking == 'confirmed')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Dikonfirmasi
                                </span>
                                @elseif($transaction->booking->status_booking == 'pending')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Menunggu Konfirmasi
                                </span>
                                @elseif($transaction->booking->status_booking == 'completed')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Selesai
                                </span>
                                @elseif($transaction->booking->status_booking == 'canceled')
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Dibatalkan
                                </span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Service Details -->
            <!-- <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-900 text-white px-5 py-4">
                    <h3 class="font-bold flex items-center">
                        <i class="fas fa-list-alt mr-2"></i>Detail Layanan
                    </h3>
                </div>
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">
                                        Layanan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider text-right">
                                        Harga</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if(isset($layananDetails) && $layananDetails->count() > 0)
                                @foreach($layananDetails as $layanan)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <i class="fas fa-spa mr-4 text-blue-500"></i>
                                            <div>
                                                <div class="font-semibold">{{ $layanan->nama_layanan }}</div>
                                                @if(isset($layanan->deskripsi))
                                                <div class="text-sm text-gray-500 mt-1">
                                                    {{ Str::limit($layanan->deskripsi, 50) }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold">
                                        Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                @foreach($layananIds as $layananId)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <i class="fas fa-spa mr-4 text-blue-500"></i>
                                            <div class="font-semibold">Layanan ID: {{ $layananId }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">-</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td class="px-6 py-4 font-medium">Total</td>
                                    <td class="px-6 py-4 text-right font-bold text-blue-700 text-lg">
                                        Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div> -->

            <!-- Action Buttons -->
            <!-- <div class="mt-6 text-center">
                @if($transaction->status_transaksi == 'pending')
                <a href="{{ route('payment.show', $transaction->id) }}"
                    class="inline-flex items-center px-6 py-3 bg-yellow-400 text-yellow-900 font-medium rounded-full shadow-md hover:bg-yellow-500 hover:shadow-lg transition">
                    <i class="fas fa-credit-card mr-2"></i>Bayar Sekarang
                </a>
                @elseif($transaction->status_transaksi == 'success' && $transaction->booking &&
                isset($transaction->booking->status_booking) && $transaction->booking->status_booking == 'completed')
                <a href="{{ route('reviews.create', ['booking_id' => $transaction->booking_id]) }}"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-full shadow-md hover:bg-blue-700 hover:shadow-lg transition">
                    <i class="fas fa-star mr-2"></i>Berikan Ulasan
                </a>
                @endif
            </div> -->
        </div>
    </main>
</x-landing-layout>