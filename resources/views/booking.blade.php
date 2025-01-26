@auth
<x-landing-layout>
    <h1
        class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 mt-20 flex justify-center items-center animate-pulse">
        PRICELIST!
    </h1>
    <main class="m-16 flex flex-wrap justify-center items-center gap-16">
        @for ($i = 1; $i <= 8; $i++) <!-- Menampilkan 6 kotak -->
        <div class="bg-white rounded-3xl shadow-lg p-6 w-60 h-86 flex flex-col items-center">
            <img src="{{ asset('images/book.jpg') }}" alt="Service Image" class="rounded-3xl mb-4 w-40 h-40 object-cover">
            <h2 class="text-2xl font-semibold mb-2 text-center">Lorem, ipsum.</h2>
            <h5 class="font-semibold mb-2 text-center">Rp. 15.000,00</h5>
            @auth
            <button
                class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-md transform hover:translate-y-1 hover:shadow-lg transition-all duration-300">
                <a href="{{ route('form') }}">Book Now</a>
            </button>
            @else
            <button
                class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-md transform hover:translate-y-1 hover:shadow-lg transition-all duration-300">
                <a href="{{ route('login') }}">Login to Book</a>
            </button>
            @endauth
        </div>
        @endfor
    </main>
</x-landing-layout>
@endauth

@guest
<x-admin.home-layout>
    <h1
        class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 mt-20 flex justify-center items-center animate-pulse">
        PRICELIST!
    </h1>
    <main class="m-16 flex flex-wrap justify-center items-center gap-16">
        @for ($i = 1; $i <= 8; $i++) <!-- Menampilkan 6 kotak -->
        <div class="bg-white rounded-3xl shadow-lg p-6 w-60 h-86 flex flex-col items-center">
            <img src="{{ asset('images/book.jpg') }}" alt="Service Image" class="rounded-3xl mb-4 w-40 h-40 object-cover">
            <h2 class="text-2xl font-semibold mb-2 text-center">Lorem, ipsum.</h2>
            <h5 class="font-semibold mb-2 text-center">Rp. 15.000,00</h5>
            @auth
            <button
                class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-md transform hover:translate-y-1 hover:shadow-lg transition-all duration-300">
                <a href="{{ route('form') }}">Book Now</a>
            </button>
            @else
            <button
                class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-md transform hover:translate-y-1 hover:shadow-lg transition-all duration-300">
                <a href="{{ route('login') }}">Login to Book</a>
            </button>
            @endauth
        </div>
        @endfor
    </main>
</x-admin.home-layout>
@endguest
