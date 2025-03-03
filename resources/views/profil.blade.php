<x-landing-layout>
    <main class="bg-gray-100 w-full max-w-3xl min-h-screen my-12 mx-auto rounded-lg shadow-lg overflow-hidden">
        <!-- User Info Section -->
        <section class="bg-gradient-to-r from-blue-700 to-blue-900 text-white p-8 text-center">
            <h2 class="text-3xl font-semibold">Profile</h2>
        </section>

        <section class="flex flex-col items-center py-6">
            <div
                class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center text-3xl font-bold text-gray-600">
                {{ substr($user->name, 0, 1) }}
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

        <!-- Booking Details Section -->
        <section class="p-6">
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
                <a href="{{ route('viewbooking.show', $booking->id) }}"
                    class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg shadow">
                    View Detail
                </a>
            </div>
            @endforeach
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