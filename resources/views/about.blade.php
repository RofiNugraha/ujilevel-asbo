@auth
<x-landing-layout>
    <style>
    .image-container {
        height: 550px;
        background: url('{{ asset('images/asgar.jpg') }}') no-repeat center center;
        background-size: cover;
        position: relative;
    }

    .image-container::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        z-index: 1;
    }

    .image-container>* {
        position: relative;
        z-index: 2;
    }
    </style>

    <div class="image-container relative w-full h-screen bg-cover bg-center flex items-center justify-center">
        <div class="image-container relative w-full h-screen bg-cover bg-center flex items-center justify-center">
            <div class="container text-center p-8 rounded-lg">
                <h1
                    class="text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 animate-pulse">
                    </i>Selamat Datang di Barbershop Kami!
                </h1>
                <p class="mt-6 text-xl text-gray-200"></i>Rasakan layanan potong rambut dan perawatan terbaik.
                </p>
                <div class="mt-8">
                    <a href="{{ route('booking') }}"
                        class="px-6 py-3 text-lg font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-calendar-check mr-2"></i>Buat Janji Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
    <main
        class="container mx-auto px-6 py-16 text-white flex flex-col md:flex-row items-center space-y-12 md:space-y-0 md:space-x-12">
        <img src="{{ asset('images/tempat.jpg') }}" alt="Barbershop"
            class="w-full md:w-1/2 max-w-sm md:max-w-md rounded-lg shadow-lg">
        <div class="md:w-1/2 text-center md:text-left">
            <h1 class="text-4xl font-bold text-yellow-500">Asgar System Booking Online</h1>
            <p class="mt-4 text-lg leading-relaxed">Asgar System Booking Online merupakan solusi modern untuk memesan
                layanan barbershop dengan mudah dan praktis.</p>
        </div>
    </main>

    <main class="container mx-auto px-6 py-16 text-white flex flex-col items-center space-y-12">
        <div class="text-center w-full md:w-2/3">
            <h1 class="text-5xl font-extrabold text-yellow-500 text-center mb-8 drop-shadow-lg">Jam Operasi ASBO</h1>
            <div
                class="bg-gradient-to-br from-gray-800 to-gray-900 p-8 rounded-xl shadow-xl border border-gray-700 relative">
                <img src="{{ asset('images/logogold.png') }}" alt="Logo"
                    class="w-24 md:w-1/4 rounded-lg shadow-xl transform hover:scale-105 transition duration-300 ease-in-out mx-auto mb-6">
                <ul class="text-lg space-y-4">
                    <li
                        class="flex justify-between items-center border-b border-gray-700 pb-2 hover:text-yellow-400 transition duration-300">
                        <span>Senin</span> <span>10.00 - 21.00</span>
                    </li>
                    <li
                        class="flex justify-between items-center border-b border-gray-700 pb-2 hover:text-yellow-400 transition duration-300">
                        <span>Selasa</span> <span>10.00 - 21.00</span>
                    </li>
                    <li
                        class="flex justify-between items-center border-b border-gray-700 pb-2 hover:text-yellow-400 transition duration-300">
                        <span>Rabu</span> <span>10.00 - 21.00</span>
                    </li>
                    <li
                        class="flex justify-between items-center border-b border-gray-700 pb-2 hover:text-yellow-400 transition duration-300">
                        <span>Kamis</span> <span>10.00 - 21.00</span>
                    </li>
                    <li
                        class="flex justify-between items-center border-b border-gray-700 pb-2 hover:text-yellow-400 transition duration-300">
                        <span>Jumat</span> <span>10.00 - 21.00</span>
                    </li>
                    <li
                        class="flex justify-between items-center border-b border-gray-700 pb-2 hover:text-yellow-400 transition duration-300">
                        <span>Sabtu</span> <span>10.00 - 22.00</span>
                    </li>
                    <li class="flex justify-between items-center text-yellow-400 font-semibold">
                        <span>Minggu</span> <span>10.00 - 22.00</span>
                    </li>
                </ul>
            </div>
        </div>
    </main>

    <main
        class="container mx-auto px-6 py-16 text-white flex flex-col md:flex-row items-center space-y-12 md:space-y-0 md:space-x-12">
        <div class="md:w-1/2 text-center md:text-left">
            <h1 class="text-4xl font-bold text-yellow-500">Cara Booking</h1>
            <ul class="mt-4 space-y-6">
                <li class="flex items-start space-x-4">
                    <span
                        class="bg-yellow-500 text-black font-bold w-8 h-8 flex items-center justify-center rounded-full">1</span>
                    <p>Buka website dan pilih layanan yang diinginkan.</p>
                </li>
                <li class="flex items-start space-x-4">
                    <span
                        class="bg-yellow-500 text-black font-bold w-8 h-8 flex items-center justify-center rounded-full">2</span>
                    <p>Masukkan detail pemesanan dan pilih jadwal yang tersedia.</p>
                </li>
                <li class="flex items-start space-x-4">
                    <span
                        class="bg-yellow-500 text-black font-bold w-8 h-8 flex items-center justify-center rounded-full">3</span>
                    <p>Konfirmasi pemesanan dan lakukan pembayaran jika diperlukan.</p>
                </li>
                <li class="flex items-start space-x-4">
                    <span
                        class="bg-yellow-500 text-black font-bold w-8 h-8 flex items-center justify-center rounded-full">4</span>
                    <p>Datang ke lokasi sesuai jadwal dan nikmati layanan terbaik.</p>
                </li>
            </ul>
        </div>
        <img src="{{ asset('images/hem.png') }}" alt="Cara Booking"
            class="w-full md:w-1/2 max-w-sm md:max-w-md rounded-lg shadow-lg">
    </main>
</x-landing-layout>
@endauth

@guest
<x-admin.home-layout>
    <style>
    .image-container {
        height: 550px;
        background: url('{{ asset('images/asgar.jpg') }}') no-repeat center center;
        background-size: cover;
        position: relative;
    }

    .image-container::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        z-index: 1;
    }

    .image-container>* {
        position: relative;
        z-index: 2;
    }
    </style>

    <div class="image-container flex items-center justify-center text-center px-6 md:px-12">
        <div class="max-w-2xl">
            <h1 class="text-4xl md:text-6xl font-extrabold text-yellow-500 animate-pulse">
                Selamat Datang di Barbershop Kami!
            </h1>
            <p class="mt-4 text-lg md:text-xl text-gray-200">Rasakan pengalaman potong rambut dan perawatan terbaik.</p>
            <a href="#booking"
                class="mt-6 inline-block px-6 py-3 text-lg font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700">
                Pesan Sekarang
            </a>
        </div>
    </div>

    <main
        class="container mx-auto px-6 py-16 text-white flex flex-col md:flex-row items-center space-y-12 md:space-y-0 md:space-x-12">
        <img src="{{ asset('images/tempat.jpg') }}" alt="Barbershop"
            class="w-full md:w-1/2 max-w-sm md:max-w-md rounded-lg shadow-lg">
        <div class="md:w-1/2 text-center md:text-left">
            <h1 class="text-4xl font-bold text-yellow-500">Sistem Booking Online Asgar</h1>
            <p class="mt-4 text-lg leading-relaxed">Sistem Booking Online Asgar adalah solusi modern untuk memesan
                layanan barbershop secara mudah dan praktis.</p>
        </div>
    </main>

    <main
        class="container mx-auto px-6 py-16 text-white flex flex-col md:flex-row items-center space-y-12 md:space-y-0 md:space-x-12">
        <img src="{{ asset('images/logogold.png') }}" alt="Logo" class="w-32 md:w-1/3 rounded-lg shadow-lg mr-64">
        <div class="text-center md:text-left">
            <h1 class="text-4xl font-bold text-yellow-500 text-center mb-8">Jam Operasional</h1>
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <ul class="text-lg space-y-2">
                    <li class="flex justify-between border-b border-gray-700 pb-2"><span>Senin</span> <span>10.00 -
                            21.00</span></li>
                    <li class="flex justify-between border-b border-gray-700 pb-2"><span>Selasa</span> <span>10.00 -
                            21.00</span></li>
                    <li class="flex justify-between border-b border-gray-700 pb-2"><span>Rabu</span> <span>10.00 -
                            21.00</span></li>
                    <li class="flex justify-between border-b border-gray-700 pb-2"><span>Kamis</span> <span>10.00 -
                            21.00</span></li>
                    <li class="flex justify-between border-b border-gray-700 pb-2"><span>Jumat</span> <span>10.00 -
                            21.00</span></li>
                    <li class="flex justify-between border-b border-gray-700 pb-2"><span>Sabtu</span> <span>10.00 -
                            22.00</span></li>
                    <li class="flex justify-between"><span class="mr-4">Minggu</span> <span>10.00 - 22.00</span></li>
                </ul>
            </div>
        </div>
    </main>

    <main
        class="container mx-auto px-6 py-16 text-white flex flex-col md:flex-row items-center space-y-12 md:space-y-0 md:space-x-12">
        <div class="md:w-1/2 text-center md:text-left">
            <h1 class="text-4xl font-bold text-yellow-500">Cara Melakukan Booking</h1>
            <ul class="mt-4 space-y-6">
                <li class="flex items-start space-x-4">
                    <span
                        class="bg-yellow-500 text-black font-bold w-8 h-8 flex items-center justify-center rounded-full">1</span>
                    <p>Buka website dan pilih layanan yang Anda inginkan.</p>
                </li>
                <li class="flex items-start space-x-4">
                    <span
                        class="bg-yellow-500 text-black font-bold w-8 h-8 flex items-center justify-center rounded-full">2</span>
                    <p>Masukkan detail pemesanan dan pilih jadwal yang tersedia.</p>
                </li>
                <li class="flex items-start space-x-4">
                    <span
                        class="bg-yellow-500 text-black font-bold w-8 h-8 flex items-center justify-center rounded-full">3</span>
                    <p>Konfirmasi pemesanan dan lakukan pembayaran jika diperlukan.</p>
                </li>
                <li class="flex items-start space-x-4">
                    <span
                        class="bg-yellow-500 text-black font-bold w-8 h-8 flex items-center justify-center rounded-full">4</span>
                    <p>Datang ke lokasi sesuai jadwal dan nikmati layanan terbaik dari kami.</p>
                </li>
            </ul>
        </div>
        <img src="{{ asset('images/hem.png') }}" alt="Cara Booking"
            class="w-full md:w-1/2 max-w-sm md:max-w-md rounded-lg shadow-lg">
    </main>
</x-admin.home-layout>
@endguest