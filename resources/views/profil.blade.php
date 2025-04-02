<x-landing-layout>
    <main class="bg-gray-100 w-full max-w-3xl min-h-screen my-12 mx-auto rounded-lg shadow-lg overflow-hidden">
        <!-- User Info Section -->
        <section class="bg-gradient-to-r from-blue-700 to-blue-900 text-white p-8 text-center">
            <h2 class="text-3xl font-semibold">Profile</h2>
        </section>

        <section class="flex flex-col items-center py-6">
            <div>
                <img src="{{ asset('images/google.png') }}" alt="Profile Image" class="w-24 h-24 rounded-full bg-gray-300">
                <!-- {{ substr($user->name, 0, 1) }} -->
            </div>
            <h3 class="text-2xl font-bold mt-4">{{ $user->name }}</h3>
            <p class="text-lg text-gray-600 mt-1">{{ $user->email }}</p>
        </section>

        <hr class="border-t border-gray-300">

        <!-- Personal Details Section -->
        <section class="p-6">
            <h3 class="text-xl font-semibold text-gray-700">Personal Details</h3>
            <p class="mt-2 text-gray-600">No. Handphone: <span class="font-medium">{{ $user->nomor_hp }}</span></p>
        </section>

        <hr class="border-t border-gray-300">

        <!-- Booking Details Section with Modal -->
        <section class="p-6" x-data="{ selectedBooking: null }">
            <h3 class="text-xl font-semibold text-gray-700">Detail Bookings</h3>
            @foreach($bookings as $booking)
            <div class="bg-white p-4 rounded-lg mt-3 shadow-md flex justify-between items-center">
                <div>
                    <p class="text-gray-800 font-medium">Nama: <span class="font-semibold">{{ $user->name }}</span></p>
                    <p class="text-gray-800 font-medium">Pesanan:
                        @foreach($booking->layanans as $layanan)
                        <span class="font-medium">{{ $layanan->nama_layanan }} | </span>
                        @endforeach
                    </p>
                    <p class="text-gray-800 font-medium">Jam Booking: <span
                            class="font-medium">{{ $booking->jam_booking }}</span>
                    </p>
                </div>
                <button @click="selectedBooking = {{ json_encode($booking) }}"
                    class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg shadow">
                    View Detail
                </button>
            </div>
            @endforeach

            <!-- Modal Detail Booking -->
            <div x-show="selectedBooking" x-cloak
                class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
                <div x-transition.opacity x-transition.scale
                    class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl p-6 md:p-10 relative">

                    <button @click="selectedBooking = null"
                        class="absolute top-4 right-4 bg-red-600 text-white p-2 rounded-full shadow hover:bg-red-700 transition">
                        &times;
                    </button>

                    <h1 class="text-center text-3xl md:text-4xl font-extrabold text-gray-800 mb-6">Detail Booking</h1>

                    <div class="overflow-hidden rounded-lg shadow-lg">
                        <table class="w-full bg-white border-collapse">
                            <tbody>
                                <tr class="border-b hover:bg-[gold] transition">
                                    <td class="px-6 py-3 font-semibold text-gray-700">Nama</td>
                                    <td class="px-6 py-3 text-gray-600" x-text="selectedBooking.user.name"></td>
                                </tr>
                                <tr class="border-b hover:bg-[gold] transition">
                                    <td class="px-6 py-3 font-semibold text-gray-700">ID Booking</td>
                                    <td class="px-6 py-3 text-gray-600" x-text="selectedBooking.id"></td>
                                </tr>
                                <tr class="border-b hover:bg-[gold] transition">
                                    <td class="px-6 py-3 font-semibold text-gray-700">Layanan</td>
                                    <td class="px-6 py-3 text-gray-600" x-text="selectedBooking.layanan.nama"></td>
                                </tr>
                                <tr class="border-b hover:bg-[gold] transition">
                                    <td class="px-6 py-3 font-semibold text-gray-700">Jam Booking</td>
                                    <td class="px-6 py-3 text-gray-600" x-text="selectedBooking.jam_booking"></td>
                                </tr>
                                <tr class="border-b hover:bg-[gold] transition">
                                    <td class="px-6 py-3 font-semibold text-gray-700">Kursi</td>
                                    <td class="px-6 py-3 text-gray-600" x-text="selectedBooking.kursi"></td>
                                </tr>
                                <tr class="border-b hover:bg-[gold] transition">
                                    <td class="px-6 py-3 font-semibold text-gray-700">Status</td>
                                    <td class="px-6 py-3 text-gray-600" x-text="selectedBooking.status"></td>
                                </tr>
                                <tr class="border-b hover:bg-[gold] transition">
                                    <td class="px-6 py-3 font-semibold text-gray-700">Total Harga</td>
                                    <td class="px-6 py-3 text-gray-600 font-bold text-lg">Rp <span
                                            x-text="Number(selectedBooking.checkout.total_harga).toLocaleString('id-ID', {minimumFractionDigits: 2})"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>

        <hr class="border-t border-gray-300">

        <!-- Actions Section -->
        <div class="flex justify-between p-6">
            <a href="{{ route('editprofil') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg shadow">
                Edit Profil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg shadow">Logout</button>
            </form>
        </div>
    </main>
</x-landing-layout>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>