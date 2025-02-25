<x-landing-layout>
    <h1
        class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 mt-20 flex justify-center items-center animate-pulse">
        KERANJANG ANDA
    </h1>

    <main class="m-8 flex flex-col items-center">
        <div class="bg-white rounded-3xl shadow-lg w-full max-w-4xl p-8">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h2 class="text-2xl font-semibold">Your Cart</h2>
                <p class="text-gray-500">{{ $cartItems->count() }} items</p>
            </div>

            <div class="space-y-6">
                @forelse ($cartItems as $item)
                <div class="flex items-center justify-between border-b pb-4">
                    <img src="{{ Storage::url($item->layanan->gambar) }}" alt="Item Image"
                        class="w-20 h-20 object-cover rounded-xl">

                    <div class="flex-1 ml-4">
                        <h3 class="font-semibold text-lg">
                            {{ optional($item->layanan)->nama_layanan ?? 'No Service Name' }}
                        </h3>
                        <p class="text-gray-500">
                            {{ $item->produk_id ? optional($item->produk)->deskripsi : optional($item->layanan)->deskripsi }}
                        </p>
                        <p class="text-gray-700">Qty: {{ $item->quantity }}</p>
                    </div>

                    <p class="font-semibold text-xl text-gray-800 mr-2">Rp.
                        {{ number_format($item->layanan->harga * $item->quantity, 0, ',', '.') }}</p>

                    <form action="{{ route('cart.removeItem', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded-full shadow-md hover:bg-red-600 transition">
                            Remove
                        </button>
                    </form>
                </div>
                @empty
                <p class="text-center text-gray-500">Your cart is empty.</p>
                @endforelse

                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-lg">Total Price:</h3>
                    <p class="font-bold text-2xl text-gray-800">Rp.
                        {{ number_format($total, 0, ',', '.') }}</p>
                </div>
            </div>

            @if ($cartItems->isNotEmpty())
            <h1 class="text-3xl font-semibold text-center text-gray-800 mb-4 mt-8">Pengisian Data Customer</h1>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('booking.store') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="kursi" class="block text-sm font-medium text-gray-700">Kursi</label>
                    <select name="kursi" id="kursi" class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md"
                        required>
                        <option value="">Pilih Kursi</option>
                        <option value="satu">Satu</option>
                        <option value="dua">Dua</option>
                    </select>
                    @error('kursi')
                    <small class="text-red-500 text-xs">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="jam_booking" class="block text-sm font-medium text-gray-700">Jam Booking</label>
                    <input type="datetime-local" name="jam_booking" id="jam_booking"
                        class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" required>
                    @error('jam_booking')
                    <small class="text-red-500 text-xs">{{ $message }}</small>
                    @enderror
                </div>

                @foreach ($cartItems as $index => $item)
                <input type="hidden" name="items[{{ $index }}][layanan_id]" value="{{ optional($item->layanan)->id }}">
                <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}">
                @endforeach
                @else
                <p class="text-red-500">Keranjang Anda kosong!</p>
                @endif
                <div class="bg-white rounded-3xl shadow-lg w-full max-w-4xl mt-8 p-6">
                    <div class=" flex mt-6 gap-4">
                        <button type="submit"
                            class="bg-[gold] text-white font-semibold px-6 py-3 rounded-full shadow-md hover:[gold]-600 transition w-full">
                            Proceed to Checkout</button>
                        <a href="{{ route('booking') }}" class="bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-full shadow-md
                            hover:bg-gray-300 transition w-full text-center">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </main>
    @if(session('error') || session('success'))
    <div x-data="{ show: true }" x-show="show"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
            @if(session('error'))
            <h2 class="text-lg font-semibold text-red-600">Error</h2>
            <p class="mt-2 text-red-500">{{ session('error') }}</p>
            @endif

            @if(session('success'))
            <h2 class="text-lg font-semibold text-green-600">Success</h2>
            <p class="mt-2 text-green-500">{{ session('success') }}</p>
            @endif

            <button @click="show = false"
                class="mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Close
            </button>
        </div>
    </div>
    @endif

</x-landing-layout>