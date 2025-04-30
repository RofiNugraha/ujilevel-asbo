<x-landing-layout>
    <main
        class="bg-white bg-opacity-10 backdrop-blur-lg w-full max-w-4xl min-h-screen my-12 mx-auto rounded-3xl shadow-2xl overflow-hidden text-gray-800">

        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-center">
                <div class="w-24 h-24 mx-auto mb-4 relative">
                    <img src="{{ $user->image ? asset('storage/'.$user->image) : asset('images/default-avatar.jpg') }}"
                        alt="Profile Photo"
                        class="w-full h-full rounded-full object-cover border-4 border-white shadow-md" />
                </div>
                <h2 class="text-xl font-bold text-white">{{ $user->name }}</h2>
                <p class="text-blue-100">{{ $user->email }}</p>
            </div>

            <!-- Profile Content -->
            <div class="p-6 space-y-6">
                <!-- Personal Info Section -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-8 text-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700">Informasi Pribadi</h3>
                    </div>
                    <table class="w-full">
                        <tr>
                            <td class="text-gray-500 w-1/4">Nama Lengkap</td>
                            <td class="text-gray-800 font-medium">{{ $user->nama_lengkap ?? 'Belum diisi' }}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-500">Nomor HP</td>
                            <td class="text-gray-800 font-medium">{{ $user->phone ?? 'Belum diisi' }}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-500">Alamat</td>
                            <td class="text-gray-800 font-medium">{{ $user->address ?? 'Belum diisi' }}</td>
                        </tr>
                    </table>
                </div>
                <hr class="border-t border-black my-4">

                <!-- Account Info Section -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-8 text-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700">Informasi Akun</h3>
                    </div>

                    <table class="w-full">
                        <tr>
                            <td class="text-gray-500 w-1/4">Username</td>
                            <td class="text-gray-800 font-medium">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-500">Email</td>
                            <td class="text-gray-800 font-medium">{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-500">Tipe Akun</td>
                            <td class="text-gray-800 font-medium">{{ $user->usertype }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr class="border-t border-black my-4 mx-6">
            <section class="p-6" x-data="{ selectedBooking: null }">
                <h3 class="text-xl font-semibold text-gray-700 mb-4"><i class="fas fa-calendar-check"></i> Pesanan Anda
                </h3>

                @forelse($bookings as $booking)
                <div
                    class="bg-white rounded-xl p-4 mb-4 shadow-md hover:shadow-lg transition flex justify-between items-center">
                    <div>
                        <p class="text-gray-800 font-medium">Nama: <span class="font-semibold">{{ $user->name }}</span>
                        </p>
                        <p class="text-gray-800 font-medium">Layanan:
                            @foreach($booking->layanans as $layanan)
                            <span
                                class="font-semibold text-blue-700">{{ $layanan->nama_layanan }}</span>@if(!$loop->last),
                            @endif
                            @endforeach
                        </p>
                        <p class="text-gray-800 font-medium">Jam: <span
                                class="font-semibold">{{ $booking->jam_booking }}</span></p>
                    </div>
                    <form id="cancel-booking-form" method="POST"
                        action="{{ route('bookings.cancel', ['id' => $booking->id]) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')"
                            class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition">
                            Batalkan Pesanan
                        </button>
                    </form>
                    @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                    @endif

                    <button @click='selectedBooking = {{ json_encode($booking) }}'
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                        Lihat
                    </button>
                </div>
                @empty
                <p class="text-gray-500 italic">Belum ada booking.</p>
                @endforelse

                <!-- Modal Detail -->
                <div x-show="selectedBooking" x-cloak
                    class="fixed inset-0 z-50 bg-black bg-opacity-60 flex items-center justify-center p-4">
                    <div x-transition
                        class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full p-8 relative overflow-hidden text-gray-800">
                        <button @click='selectedBooking = null'
                            class="absolute top-4 right-4 bg-red-600 text-white w-8 h-8 rounded-full text-xl leading-none hover:bg-red-700 transition">
                            ×
                        </button>
                        <h2 class="text-3xl font-bold text-center mb-6 text-blue-800">Detail Booking</h2>
                        <table class="w-full text-left">
                            <tbody>
                                <tr class="border-b hover:bg-blue-50">
                                    <td class="py-3 font-semibold w-40">Nama</td>
                                    <td x-text="selectedBooking.user.name"></td>
                                </tr>
                                <tr class="border-b hover:bg-blue-50">
                                    <td class="py-3 font-semibold">ID Booking</td>
                                    <td x-text="selectedBooking.id"></td>
                                </tr>
                                <tr class="border-b hover:bg-blue-50">
                                    <td class="py-3 font-semibold">Layanan</td>
                                    <td>
                                        <template x-for="layanan in selectedBooking.layanans">
                                            <span
                                                class="inline-block mr-2 px-2 py-1 bg-blue-100 text-blue-700 rounded text-sm"
                                                x-text="layanan.nama_layanan + ' | '"></span>
                                        </template>
                                    </td>
                                </tr>
                                <tr class="border-b hover:bg-blue-50">
                                    <td class="py-3 font-semibold">Jam</td>
                                    <td x-text="selectedBooking.jam_booking"></td>
                                </tr>
                                <tr class="border-b hover:bg-blue-50">
                                    <td class="py-3 font-semibold">Kursi</td>
                                    <td x-text="selectedBooking.kursi"></td>
                                </tr>
                                <tr class="border-b hover:bg-blue-50">
                                    <td class="py-3 font-semibold">Status</td>
                                    <td x-text="selectedBooking.status"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <hr class="border-t border-black my-4 mx-6">
            <div class="flex justify-between p-6">
                <a href="{{ route('editprofil') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow font-semibold transition">
                    <i class="fas fa-user-edit"></i> Edit Profil
                </a>
                <a href="{{ route('riwayat_pesanan') }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg shadow font-semibold transition">Lihat
                    Riwayat Pesanan
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg shadow font-semibold transition">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
    function bookingDetail() {
        return {
            selectedBooking: null,
            cancelBooking(bookingId) {
                if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
                    fetch(`/bookings/${bookingId}/cancel`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.selectedBooking.status = 'batal';
                                alert('Pesanan berhasil dibatalkan');
                            } else {
                                alert('Gagal membatalkan pesanan');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan');
                        });
                }
            }
        }
    }
    </script>
</x-landing-layout>