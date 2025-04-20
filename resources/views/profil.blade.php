<x-landing-layout>
    <main
        class="bg-white bg-opacity-10 backdrop-blur-lg w-full max-w-4xl min-h-screen my-12 mx-auto rounded-3xl shadow-2xl overflow-hidden text-gray-800">

        <!-- Header Profile -->
        <section
            class="bg-gradient-to-r from-blue-700 to-indigo-900 text-white p-10 text-center rounded-b-3xl shadow-md">
            <h2 class="text-4xl font-bold drop-shadow">👤 My Profile</h2>
        </section>

        <!-- Profile Info -->
        <section class="flex flex-col items-center py-6 px-4">
            <div class="relative group w-28 h-28">
                <img src="{{ asset('images/google.png') }}" alt="Profile Image"
                    class="w-full h-full rounded-full object-cover border-4 border-white shadow-lg" />
            </div>
            <h3 class="text-2xl font-bold mt-4">{{ $user->name }}</h3>
            <p class="text-lg text-gray-600">{{ $user->email }}</p>
        </section>

        <hr class="border-t border-gray-300 my-4">

        <!-- Personal Info -->
        <section class="p-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-2">📋 Personal Details</h3>
            <p class="text-gray-600">Phone Number: <span class="font-medium">{{ $user->nomor_hp }}</span></p>
        </section>

        <hr class="border-t border-gray-300 my-4">

        <!-- Booking Details -->
        <section class="p-6" x-data="{ selectedBooking: null }">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">📅 Booking History</h3>

            @forelse($bookings as $booking)
            <div
                class="bg-white rounded-xl p-4 mb-4 shadow-md hover:shadow-lg transition flex justify-between items-center">
                <div>
                    <p class="text-gray-800 font-medium">Name: <span class="font-semibold">{{ $user->name }}</span></p>
                    <p class="text-gray-800 font-medium">Services:
                        @foreach($booking->layanans as $layanan)
                        <span class="font-semibold text-blue-700">{{ $layanan->nama_layanan }}</span>@if(!$loop->last),
                        @endif
                        @endforeach
                    </p>
                    <p class="text-gray-800 font-medium">Time: <span
                            class="font-semibold">{{ $booking->jam_booking }}</span></p>
                </div>
                <button @click="selectedBooking = {{ json_encode($booking) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    View
                </button>
            </div>
            @empty
            <p class="text-gray-500 italic">No bookings found.</p>
            @endforelse

            <!-- Modal Detail -->
            <div x-show="selectedBooking" x-cloak
                class="fixed inset-0 z-50 bg-black bg-opacity-60 flex items-center justify-center p-4">
                <div x-transition
                    class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full p-8 relative overflow-hidden text-gray-800">
                    <button @click="selectedBooking = null"
                        class="absolute top-4 right-4 bg-red-600 text-white w-8 h-8 rounded-full text-xl leading-none hover:bg-red-700 transition">
                        ×
                    </button>
                    <h2 class="text-3xl font-bold text-center mb-6 text-blue-800">Detail Booking</h2>
                    <table class="w-full text-left">
                        <tbody>
                            <tr class="border-b hover:bg-blue-50">
                                <td class="py-3 font-semibold w-40">Name</td>
                                <td x-text="selectedBooking.user.name"></td>
                            </tr>
                            <tr class="border-b hover:bg-blue-50">
                                <td class="py-3 font-semibold">Booking ID</td>
                                <td x-text="selectedBooking.id"></td>
                            </tr>
                            <tr class="border-b hover:bg-blue-50">
                                <td class="py-3 font-semibold">Service(s)</td>
                                <td>
                                    <template x-for="layanan in selectedBooking.layanans">
                                        <span
                                            class="inline-block mr-2 px-2 py-1 bg-blue-100 text-blue-700 rounded text-sm"
                                            x-text="layanan.nama_layanan + ' | '"></span>
                                    </template>
                                </td>
                            </tr>
                            <tr class="border-b hover:bg-blue-50">
                                <td class="py-3 font-semibold">Time</td>
                                <td x-text="selectedBooking.jam_booking"></td>
                            </tr>
                            <tr class="border-b hover:bg-blue-50">
                                <td class="py-3 font-semibold">Chair</td>
                                <td x-text="selectedBooking.kursi"></td>
                            </tr>
                            <tr class="border-b hover:bg-blue-50">
                                <td class="py-3 font-semibold">Status</td>
                                <td x-text="selectedBooking.status"></td>
                            </tr>
                            <tr class="border-b hover:bg-blue-50">
                                <td class="py-3 font-semibold">Total Price</td>
                                <td class="font-bold text-green-600">Rp
                                    <span
                                        x-text="Number(selectedBooking.checkout.total_harga).toLocaleString('id-ID', {minimumFractionDigits: 2})"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <hr class="border-t border-gray-300 my-4">

        <!-- Action Buttons -->
        <div class="flex justify-between p-6">
            <a href="{{ route('editprofil') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow font-semibold transition">
                ✏️ Edit Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg shadow font-semibold transition">
                    🔒 Logout
                </button>
            </form>
        </div>
    </main>

</x-landing-layout>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>