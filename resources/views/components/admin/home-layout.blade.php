<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASBO - Asgar System Booking Online</title>
    <script src="https://cdn.tailwindcss.com/3.2.0"></script>
    <style>
    <style>.nav-item {
        position: relative;
        display: inline-block;
        padding-bottom: 0.5rem;
        transition: all 0.3s ease-in-out;
    }

    .nav-item::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: #0E2094;
        transition: width 0.3s ease-in-out;
    }

    .nav-item:hover::after {
        width: 100%;
    }
    </style>

    </style>
</head>

<body class="flex flex-col min-h-screen" style="background-image: linear-gradient(to bottom right, #0C102B, #0E2094);">
    <main class="flex-grow">
        <header class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">
                <img src="{{ asset('images/logo.png')}}" alt="ASBO Logo" class="w-[50px]">
                <div class="hidden lg:flex space-x-6 text-lg font-medium text-gray-900">
                    <a href="{{ route('/') }}"
                        class="nav-item text-gray-700 hover:text-gray-900 hover:underline">Home</a>
                    <a href="{{ route('about') }}"
                        class="nav-item text-gray-700 hover:text-gray-900 hover:underline">About</a>
                    <a href="{{ route('overview') }}"
                        class="nav-item text-gray-700 hover:text-gray-900 hover:underline">Overview</a>
                    <a href="{{ route('booking') }}"
                        class="nav-item text-gray-700 hover:text-gray-900 hover:underline">Booking</a>
                    <button class="nav-item relative text-gray-700 hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V4a1 1 0 10-2 0v1.083A6.002 6.002 0 006 11v3.159c0 .417-.152.823-.405 1.136L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                </div>

                <button id="menu-button" class="lg:hidden text-gray-700 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
                <a class="bg-gray-200 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-300 hidden lg:inline-block"
                    href="{{ route('login') }}">Login</a>
            </div> 
            <div id="menu"
                class="hidden flex-col space-y-4 text-lg font-medium text-gray-900 lg:hidden bg-white shadow-lg p-4">
                <a href="{{ route('/') }}" class="block text-gray-700 hover:text-gray-900">Home</a>
                <a href="#overview" class="block hover:text-gray-900">Overview</a>
                <a href="#booking" class="block hover:text-gray-900">Booking</a>
                <a href="#about" class="block hover:text-gray-900">About</a>
                <a href="{{ route('login') }}"
                    class="block bg-gray-200 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-300">Login</a>
            </div>
        </header>
        {{ $slot }}
    </main>

    <script>
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('mouseover', () => {
            item.querySelector('::after').style.width = '100%';
        });

        item.addEventListener('mouseout', () => {
            item.querySelector('::after').style.width = '0';
        });
    });
    </script>


    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-auto">
        <div class="max-w-7xl mx-auto text-center">
            <p>© 2025 ASBO. All Rights Reserved.</p>
        </div>
    </footer>
</body>

</html>