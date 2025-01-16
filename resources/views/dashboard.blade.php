<x-landing-layout>
    <main class="flex-grow mt-16 mb-16 px-8">
        <!-- Home Section -->
        <section id="home" class="relative px-6">
            <div class="relative">
                <img src="{{ asset('images/tempat.jpg') }}" alt="Background"
                    class="w-full max-h-[450px] object-cover rounded-[50px]">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center rounded-[50px]">
                    <div class="text-white px-12">
                        <h1 class="text-5xl font-bold">ASBO</h1>
                        <p class="text-xl mt-4">Asgar System Booking Online</p>
                        <p class="mt-2">ASBO adalah aplikasi booking pangkas rambut yang memudahkan anda untuk
                            memesan
                            jadwal tanpa antre. Tentukan jadwal yang sesuai, dan nikmati layanan terbaik dengan
                            mudah,
                            Hemat Waktu, Praktis, dan terpercaya!!!</p>
                        <div class="mt-6">
                            <a href="#booking"
                                class="bg-white text-black px-6 py-2 rounded-lg shadow hover:bg-gray-100 transition"
                                onclick="toggleDropdown('booking-dropdown')">Jam Operasi</a>
                            <a href="#overview"
                                class="bg-white text-black px-6 py-2 rounded-lg shadow hover:bg-gray-100 transition"
                                onclick="toggleDropdown('overview-dropdown')">Lokasi</a>

                            <!-- Dropdown for Jam Operasi -->
                            <div id="booking-dropdown"
                                class="hidden mt-4 p-4 bg-gray-200 rounded-lg shadow-lg text-gray-600">
                                <p>Jam operasional kami adalah dari 09:00 AM hingga 05:00 PM setiap hari.</p>
                            </div>
                            <!-- Dropdown for Lokasi -->
                            <div id="overview-dropdown"
                                class="hidden mt-4 p-4 bg-gray-200 rounded-lg shadow-lg text-gray-600">
                                <p>Lokasi kami berada di Jalan XYZ, No. 123, Kota ABC.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        dropdown.classList.toggle('hidden'); // Toggle visibility
    }
    </script>

    <script>
    const menuButton = document.getElementById('menu-button');
    const menu = document.getElementById('menu');

    menuButton.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
    </script>

    </body>
</x-admin.home-layout>