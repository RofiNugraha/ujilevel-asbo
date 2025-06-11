<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASBO - Asgar System Booking Online</title>
    <script src="https://cdn.tailwindcss.com/3.2.0"></script>

    <!-- cdn midtrans -->
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
</head>

<body class="flex flex-col min-h-screen" style="background-color: #1C1C1C;">
    <header class="navbar transparent fixed w-full sticky top-0 z-10 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">
            <img src="{{ asset('images/logogold.png')}}" alt="ASBO Logo" class="w-[80px]">
            <div class=" hidden lg:flex space-x-6 text-lg font-medium text-white">
                <a href="{{ route('/') }}" class="nav-item hover:text-[gold] hover:underline">Home</a>
                <a href="{{ route('about') }}" class="nav-item hover:text-[gold] hover:underline">About</a>
                <a href="{{ route('overview') }}" class="nav-item hover:text-[gold] hover:underline">Overview</a>
                <a href="{{ route('booking') }}" class="nav-item hover:text-[gold] hover:underline">Booking</a>
                <a href="{{ route('contact') }}" class="nav-item hover:text-[gold] hover:underline">Contact</a>
                <a href="{{ route('notifikasi') }}">
                    <button class="nav-item relative hover:text-[gold]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V4a1 1 0 10-2 0v1.083A6.002 6.002 0 006 11v3.159c0 .417-.152.823-.405 1.136L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/cart" class="relative">
                    <button class="p-3 rounded-full bg-gray-100 hover:bg-[gold] shadow-lg transition relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 text-gray-800">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2 6h12M7 13L5.4 7M17 13l2 6M9 20a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                        <!-- Badge Notifikasi -->
                        <span id="cart-badge"
                            class="hidden absolute -bottom-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                        </span>
                    </button>
                </a>
                <a href="{{ route('login') }}"
                    class="block bg-gray-200 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-300">Login</a>
            </div>
            <button id="menu-button" class="lg:hidden text-gray-700 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
        <div id="menu"
            class="hidden flex-col space-y-4 text-lg font-medium text-gray-900 lg:hidden bg-white shadow-lg p-4">
            <a href="{{ route('/') }}" class="block text-gray-700 hover:text-gray-900">Home</a>
            <a href="{{ route('about') }}" class="block hover:text-gray-900">About</a>
            <a href="#{{ route('overview') }}" class="block hover:text-gray-900">Overview</a>
            <a href="{{ route('booking') }}" class="block hover:text-gray-900">Booking</a>
            <button class="nav-item relative text-gray-400 hover:text-[gold]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V4a1 1 0 10-2 0v1.083A6.002 6.002 0 006 11v3.159c0 .417-.152.823-.405 1.136L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>
            <a class="bg-gray-200 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-300 hidden lg:inline-block"
                href="{{ route('login') }}">Login</a>
        </div>
    </header>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <script>
    // JavaScript to handle scroll event and toggle navbar background
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 0) {
            navbar.classList.remove('transparent');
            navbar.classList.add('solid');
        } else {
            navbar.classList.remove('solid');
            navbar.classList.add('transparent');
        }
    });

    // JavaScript to toggle the navbar menu on mobile screens
    const menuButton = document.getElementById('menu-button');
    const menu = document.getElementById('menu');

    menuButton.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
    </script>

    <!-- Footer -->
    <footer class="bg-[#1C1C1C] text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Logo and Description -->
                <div class="flex flex-col items-center md:items-start">
                    <img src="{{ asset('images/logogold.png')}}" alt="ASBO Logo" class="w-[150px]">
                    <p class="mt-2 text-gray-400 text-center md:text-left">
                        Your trusted partner for financial management solutions.
                    </p>
                </div>
                <!-- Links Section -->
                <div class="flex flex-col items-center md:items-start">
                    <h2 class="text-lg text-[gold] font-semibold">Quick Links</h2>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Services</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a></li>
                    </ul>
                </div>
                <!-- Social Media Section -->
                <div class="flex flex-col items-center md:items-start">
                    <h2 class="text-lg text-[gold] font-semibold">Follow Us</h2>
                    <div class="flex mt-4 space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <!-- Social Media SVG Icons -->
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-4 text-center">
                <p class="text-sm text-gray-500">© 2025 ASBO. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>