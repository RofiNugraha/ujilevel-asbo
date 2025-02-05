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
        /* Dark overlay with 40% opacity */
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
    <h1
        class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 mt-20 flex justify-center items-center animate-pulse">
        PRICELIST!
    </h1>
    <main class="m-16 flex flex-wrap justify-center items-center gap-16">
        @foreach ($layanans as $layanan)
        <div class="bg-white rounded-3xl shadow-lg p-6 w-60 h-86 flex flex-col items-center">
            <img src="{{ asset('storage/' . $layanan->gambar) }}" alt="Service Image"
                class="rounded-3xl mb-4 w-40 h-40 object-cover">
            <h2 class="text-2xl font-semibold mb-2 text-center">{{ $layanan->nama_layanan }}</h2>
            <p class="mb-2 text-center">{{ $layanan->deskripsi }}</p>
            <h5 class="font-semibold mb-2 text-center">Rp.{{ $layanan->harga }}</h5>
            @auth
            <form action="{{ route('cart.addItem') }}" method="POST">
                @csrf
                <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                    class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-md transform hover:translate-y-1 hover:shadow-lg transition-all duration-300">
<<<<<<< HEAD
                    <a href="{{ route('form') }}">Add to Cart</a>
=======
                    Book Now
>>>>>>> 75f1c1f01840acf6a6fc7b643c4a420920754903
                </button>
            </form>
            @else
            <button
                class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-md transform hover:translate-y-1 hover:shadow-lg transition-all duration-300">
                <a href="{{ route('login') }}">Login to Book</a>
            </button>
            @endauth
        </div>
        @endforeach
    </main>
    <h1
        class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 mt-20 flex justify-center items-center animate-pulse">
        PRODUCTS!
    </h1>
    <main class="m-16 flex flex-wrap justify-center items-center gap-16">
        @foreach ($produks as $produk)
        <div class="bg-white rounded-3xl shadow-lg p-6 w-60 h-86 flex flex-col items-center">
            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Service Image"
                class="rounded-3xl mb-4 w-40 h-40 object-cover">
            <h2 class="text-2xl font-semibold mb-2 text-center">{{ $produk->nama_produk }}</h2>
            <p class="text-2xl font-semibold mb-2 text-center">{{ $produk->deskripsi }}</p>
            <h5 class="font-semibold mb-2 text-center">Rp.{{ $produk->harga }}</h5>
            @auth
            <form action="{{ route('cart.addItem') }}" method="POST">
                @csrf
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                    class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-md transform hover:translate-y-1 hover:shadow-lg transition-all duration-300">
                    Book Now
                </button>
            </form>
            @else
            <button
                class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-md transform hover:translate-y-1 hover:shadow-lg transition-all duration-300">
                <a href="{{ route('login') }}">Login to Book</a>
            </button>
            @endauth
        </div>
        @endforeach
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
        @foreach ($layanans as $layanan)
        <div class="bg-white rounded-3xl shadow-lg p-6 w-60 h-86 flex flex-col items-center">
            <img src="{{ asset('storage/' . $layanan->gambar) }}" alt="Service Image"
                class="rounded-3xl mb-4 w-40 h-40 object-cover">
            <h2 class="text-2xl font-semibold mb-2 text-center">{{ $layanan->nama_layanan }}</h2>
            <h5 class="font-semibold mb-2 text-center">{{ $layanan->harga }}</h5>
            @auth
            <button
                class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-md transform hover:translate-y-1 hover:shadow-lg transition-all duration-300">
                <a href="">Book Now</a>
            </button>
            @else
            <button
                class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-md transform hover:translate-y-1 hover:shadow-lg transition-all duration-300">
                <a href="{{ route('login') }}">Login to Book</a>
            </button>
            @endauth
        </div>
        @endforeach
    </main>
    <h1
        class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 mt-20 flex justify-center items-center animate-pulse">
        PRODUCTS!
    </h1>
    <main class="m-16 flex flex-wrap justify-center items-center gap-16">
        @foreach ($produks as $produk)
        <div class="bg-white rounded-3xl shadow-lg p-6 w-60 h-86 flex flex-col items-center">
            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Service Image"
                class="rounded-3xl mb-4 w-40 h-40 object-cover">
            <h2 class="text-2xl font-semibold mb-2 text-center">{{ $produk->nama_produk }}</h2>
            <p class="text-2xl font-semibold mb-2 text-center">{{ $produk->deskripsi }}</p>
            <h5 class="font-semibold mb-2 text-center">Rp.{{ $produk->harga }}</h5>
            @auth
            <button
                class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-md transform hover:translate-y-1 hover:shadow-lg transition-all duration-300">
                <a href="">Book Now</a>
            </button>
            @else
            <button
                class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-md transform hover:translate-y-1 hover:shadow-lg transition-all duration-300">
                <a href="{{ route('login') }}">Login to Book</a>
            </button>
            @endauth
        </div>
        @endforeach
    </main>
</x-admin.home-layout>
@endguest