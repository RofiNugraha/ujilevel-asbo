<x-admin.home-layout>
    <main class="bg-gray-100 w-full max-w-4xl min-h-schreen my-16 p-8 rounded-lg shadow-md m-auto">
        <!-- User Info Section -->
        <section class="bg-blue-900 text-white p-6 rounded-t-lg">
            <h2 class="text-2xl font-semibold text-center">User Profile</h2>
        </section>
        <section class="flex flex-col items-center mt-4">
            <h3 class="text-2xl font-bold mt-4">Sri Ayu Apriliani</h3>
            <p class="text-xl mt-2">ayueo</p>
        </section>
        <hr class="border-t mt-6">

        <!-- Personal Details Section -->
        <section class="mt-4 px-4">
            <h3 class="text-2xl font-bold">Personal Details</h3>
            <p class="mt-2">Phone: 0812-3456-7890</p>
            <p>Address: Jl. Merdeka No. 123, Jakarta</p>
        </section>
        <hr class="border-t mt-6">

        <!-- Booking Details Section -->
        <section class="mt-4 px-4">
            <h3 class="text-2xl font-bold">Detail Bookings</h3>
            <div class="bg-gray-300 p-4 rounded-lg mt-2 flex justify-between items-center">
                <div>
                    <p>Nama: Ayu</p>
                    <p>Layanan: Style Hair</p>
                    <p>Jam Booking: 12.00</p>
                </div>
                <div>
                    <button class="bg-green-600 text-white py-2 px-4 rounded">
                        <a href="{{ route('logout') }}">View Detail</a>
                    </button>
                </div>
            </div>
        </section>
        <!-- Actions Section -->
        <div class="flex justify-between mx-4 mt-6">
            <button class="bg-blue-600 text-white py-2 px-4 rounded">
                <a href="{{ route('editprofil') }}">Edit Prodil</a>
            </button>
            <button class="bg-red-600 text-white py-2 px-4 rounded">
                <a href="{{ route('logout') }}">Logout</a>
            </button>
        </div>
    </main>
</x-admin.home-layout>