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

    <!-- Hero Section -->
    <div class="image-container relative w-full h-screen flex items-center justify-center">
        <div class="container text-center px-8 py-12 rounded-lg">
            <h1
                class="text-5xl md:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 animate-pulse">
                Selamat Datang di Barbershop Kami!
            </h1>
            <p class="mt-6 text-xl text-gray-200">Rasakan layanan potong rambut dan perawatan terbaik untuk penampilan
                maksimal.</p>
            <div class="mt-8">
                <a href="#booking"
                    class="inline-flex items-center px-6 py-3 text-lg font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-calendar-check mr-2"></i>Buat Janji Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- Services Title -->
    <h1
        class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 mt-20 flex justify-center animate-pulse">
        LAYANAN KAMI
    </h1>

    <!-- Services List -->
    <main class="m-16 flex flex-wrap justify-center items-center gap-16">
        @foreach ($layanans as $layanan)
        <div
            class="bg-white rounded-3xl shadow-lg p-6 w-60 flex flex-col items-center text-center hover:scale-105 transition-transform duration-300">
            <img src="{{ asset('storage/' . $layanan->gambar) }}" alt="Gambar Layanan"
                class="rounded-3xl mb-4 w-40 h-40 object-cover">
            <h2 class="text-2xl font-semibold mb-2">{{ $layanan->nama_layanan }}</h2>
            <p class="text-gray-600 text-sm mb-2">{{ $layanan->deskripsi }}</p>
            <h5 class="font-semibold text-blue-700">Rp{{ number_format($layanan->harga, 0, ',', '.') }}</h5>
            @auth
            <form action="{{ route('cart.addItem') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                    class="bg-blue-600 text-white rounded-full px-6 py-2 mt-2 shadow-md hover:translate-y-1 hover:shadow-lg transition-all duration-300">
                    Tambahkan ke Keranjang
                </button>
            </form>
            @else
            <button
                class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-md hover:translate-y-1 hover:shadow-lg transition-all duration-300">
                Pesan Sekarang
            </button>
            @endauth
        </div>
        @endforeach
    </main>

    <!-- Modal Pop-up -->
    @if (session('error'))
    <div x-data="{ show: true }" x-show="show"
        class="fixed inset-0 z-[999] flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold text-red-600">Terjadi Kesalahan</h2>
            <p class="mt-2 text-sm text-gray-700">{{ session('error') }}</p>
            <button @click="show = false"
                class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                Tutup
            </button>
        </div>
    </div>
    @endif
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
                Add to cart
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
    @endguest

</x-admin.home-layout>