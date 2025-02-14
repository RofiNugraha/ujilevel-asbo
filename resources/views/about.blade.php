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

    <div class="image-container flex items-center justify-center text-center px-6 md:px-12">
        <div class="max-w-2xl">
            <h1 class="text-4xl md:text-6xl font-extrabold text-yellow-500 animate-pulse">
                Welcome to Our Barbershop!
            </h1>
            <p class="mt-4 text-lg md:text-xl text-gray-200">Experience the best haircut and grooming services.</p>
            <a href="#booking"
                class="mt-6 inline-block px-6 py-3 text-lg font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700">
                Book an Appointment
            </a>
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

    <main
        class="container mx-auto px-6 py-16 text-white flex flex-col md:flex-row items-center space-y-12 md:space-y-0 md:space-x-12">
        <img src="{{ asset('images/logogold.png') }}" alt="Logo" class="w-32 md:w-1/3 rounded-lg shadow-lg mr-64">
        <div class="text-center md:text-left">
            <h1 class="text-4xl font-bold text-yellow-500 text-center mb-8">Jam Operasi</h1>
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
                Welcome to Our Barbershop!
            </h1>
            <p class="mt-4 text-lg md:text-xl text-gray-200">Experience the best haircut and grooming services.</p>
            <a href="#booking"
                class="mt-6 inline-block px-6 py-3 text-lg font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700">
                Book an Appointment
            </a>
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

    <main
        class="container mx-auto px-6 py-16 text-white flex flex-col md:flex-row items-center space-y-12 md:space-y-0 md:space-x-12">
        <img src="{{ asset('images/logogold.png') }}" alt="Logo" class="w-32 md:w-1/3 rounded-lg shadow-lg mr-64">
        <div class="text-center md:text-left">
            <h1 class="text-4xl font-bold text-yellow-500 text-center mb-8">Jam Operasi</h1>
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
</x-admin.home-layout>
@endguest