<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASBO - Asgar System Booking Online</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com/3.2.0"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="flex flex-col min-h-screen" style="background-color:#1C1C1C;">
    <header class="navbar transparent fixed w-full sticky top-0 z-10 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">
            <!-- <img src="{{ asset('images/asboiii.png')}}" alt="ASBO Logo" class="w-[100px]"> -->
            @if($siteCustom && $siteCustom->logo)
            <img src="{{ asset($siteCustom->logo) }}" alt="Logo" class="w-[100px]">
            @endif
            <div class="hidden lg:flex space-x-6 text-lg font-medium text-gray-900">
                <a href="{{ route('dashboard') }}"
                    class="nav-item text-white hover:text-[gold] hover:underline">Home</a>
                <a href="{{ route('about') }}" class="nav-item text-white hover:text-[gold] hover:underline">About</a>
                <a href="{{ route('overview') }}"
                    class="nav-item text-white hover:text-[gold] hover:underline">Overview</a>
                <a href="{{ route('booking') }}"
                    class="nav-item text-white hover:text-[gold] hover:underline">Booking</a>
                <a href="{{ route('contact') }}"
                    class="nav-item text-white hover:text-[gold] hover:underline">Contact</a>
                <a href="{{ route('notifikasi') }}">
                    <button class="nav-item relative text-white hover:text-[gold]">
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
                <a href="{{ route('profil') }}" class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-white">{{ auth()->user()->name }}</h2>
                    <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('images/default-avatar.jpg') }}"
                        alt="Profile Photo"
                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-300 hover:border-gray-500 transition">
                </a>
            </div>

            <script>
            function updateCartBadge() {
                fetch("{{ route('cart.count') }}")
                    .then(response => response.json())
                    .then(data => {
                        let cartCount = data.cart_count;
                        let badge = document.getElementById('cart-badge');

                        if (cartCount > 0) {
                            badge.textContent = cartCount;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    })
                    .catch(error => console.error('Error fetching cart count:', error));
            }

            document.addEventListener("DOMContentLoaded", updateCartBadge);
            </script>

            <button id="menu-button" class="lg:hidden text-gray-700 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
            </a>
            <div id="menu"
                class="hidden flex-col space-y-4 text-lg font-medium text-gray-900 lg:hidden bg-white shadow-lg p-4">
                <a href="{{ route('dashboard') }}" class="block text-gray-700 hover:text-gray-900">Home</a>
                <a href="{{ route('about') }}" class="block hover:text-gray-900">About</a>
                <a href="{{ route('overview') }}" class="block hover:text-gray-900">Overview</a>
                <a href="{{ route('booking') }}" class="block hover:text-gray-900">Booking</a>
                <a href="{{ route('notifikasi') }}">
                    <button class="nav-item relative text-gray-400 hover:text-[gold]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V4a1 1 0 10-2 0v1.083A6.002 6.002 0 006 11v3.159c0 .417-.152.823-.405 1.136L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                </a>
                <a href="{{ route('profil') }}">
                    <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('images/default-avatar.jpg') }}"
                        alt="Profile Photo"
                        class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 hover:border-gray-500 transition">
                </a>

            </div>
    </header>

    <!-- Image Section -->
    <!-- <div class="image-container">
        <div class="text-white px-12">
            <h1 class="text-5xl font-bold text-center m-64">WELCOME | ASBO</h1>
        </div>
    </div> -->
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
    <footer class="bg-[#1C1C1C] text-white py-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('/path-to-pattern.png')] bg-cover"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                <!-- Logo dan Deskripsi -->
                <div class="flex flex-col items-center md:items-start">
                    @if($siteCustom && $siteCustom->logo)
                    <img src="{{ asset($siteCustom->logo) }}" alt="Logo"
                        class="w-[160px] transition-transform duration-300 hover:scale-105">
                    @endif
                    <p class="mt-3 text-gray-400 leading-relaxed">
                        Mitra terpercaya Anda dalam solusi manajemen keuangan.
                    </p>
                </div>
                <!-- Bagian Tautan -->
                <div class="flex flex-col items-center md:items-start">
                    <h2 class="text-lg text-white font-semibold border-b-2 border-white pb-2">Tautan Cepat</h2>
                    <ul class="mt-4 space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-gold transition duration-300">Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-gold transition duration-300">About</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-gold transition duration-300">Overview</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-gold transition duration-300">Booking</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-gold transition duration-300">Contact</a></li>
                    </ul>
                </div>
                <!-- Bagian Media Sosial -->
                <div class="flex flex-col items-center md:items-start">
                    <h2 class="text-lg text-white font-semibold border-b-2 border-white pb-2">Ikuti Kami</h2>
                    <div class="flex mt-4 space-x-4">
                        @if($siteCustom)
                        <a href="{{ $siteCustom->link_facebook }}"
                            class="text-gray-400 hover:text-gold transition duration-300">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="{{ $siteCustom->link_whatsapp }}"
                            class="text-gray-400 hover:text-gold transition duration-300">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                        <a href="{{ $siteCustom->link_instagram }}"
                            class="text-gray-400 hover:text-gold transition duration-300">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        @endif
                    </div>
                    <p class="mt-4 text-gray-500 text-sm">Tetap terhubung dengan kami untuk info terbaru.</p>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-4 text-center">
                <p class="text-sm text-gray-500">© 2025 ASBO. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>


    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>