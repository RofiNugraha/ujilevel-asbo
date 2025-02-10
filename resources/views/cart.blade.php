<x-landing-layout>
    <h1
        class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-green-500 to-green-600 mt-12 flex justify-center items-center">
        Shopping Cart
    </h1>
    <main class="m-8 flex flex-col items-center">
        <!-- Cart Items -->
        <div class="bg-white rounded-3xl shadow-lg w-full max-w-4xl p-8">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h2 class="text-2xl font-semibold">Your Cart</h2>
                <p class="text-gray-500">{{ $cartItems->count() }} items</p>
            </div>
            <div class="space-y-6">
                @forelse ($cartItems as $item)
                <div class="flex items-center justify-between border-b pb-4">
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="Item Image"
                        class="w-20 h-20 object-cover rounded-xl">
                    <div class="flex-1 ml-4">
                        <h3 class="font-semibold text-lg">
                            {{ $item->produk_id ? $item->produk->nama_produk : $item->layanan->nama_layanan }}
                        </h3>
                        <p class="text-gray-500">
                            {{ $item->produk_id ? $item->produk->deskripsi : $item->layanan->deskripsi }}
                        </p>
                        <p class="text-gray-700">Qty: {{ $item->quantity }}</p>
                    </div>
<<<<<<< HEAD
                    <!-- Display Subtotal -->
                    <p class="font-semibold text-xl text-gray-800 mr-2">Rp
=======
                    <p class="font-semibold text-xl text-gray-800 mr-2">Rp.
>>>>>>> 7106edab443dc92df1b6933a1857d8fecaa66043
                        {{ number_format($item->subtotal, 0, ',', '.') }}</p>
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
            </div>
        </div>
        <div class="max-w-3xl w-full bg-white p-8 rounded-lg shadow-lg m-4">
            <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">Asgar Book</h1>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="" method="post">
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
                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi"
                        class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" rows="4"></textarea>
                    @error('deskripsi')
                    <small class="text-red-500 text-xs">{{ $message }}</small>
                    @enderror
                </div>
                <div class="flex justify-between items-center mt-6">
                    <button type="submit"
                        class="w- py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">Submit</button>
                    <a href="/cart">
                        <button type="button"
                            class="w- py-2 px-4 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400">Back</button>
                    </a>
                </div>
            </form>
        </div>

        <!-- Summary Section -->
        <div class="bg-white rounded-3xl shadow-lg w-full max-w-4xl mt-8 p-6">
            <div class="flex justify-between items-center">
                <h3 class="font-semibold text-lg">Total Price:</h3>
                <p class="font-bold text-2xl text-gray-800">Rp
                    {{ number_format($cartItems->sum('subtotal'), 0, ',', '.') }}</p>
            </div>
            <div class="flex mt-6 gap-4">
                <button
                    class="bg-green-500 text-white font-semibold px-6 py-3 rounded-full shadow-md hover:bg-green-600 transition w-full">
                    <a href="{{ route('formbook') }}">Proceed to Checkout</a>
                </button>
<<<<<<< HEAD
                <a href="/booking"
=======
                <a href="{{ route('booking') }}"
>>>>>>> 7106edab443dc92df1b6933a1857d8fecaa66043
                    class="bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-full shadow-md hover:bg-gray-300 transition w-full text-center">
                    Continue Shopping
                </a>
            </div>
        </div>
    </main>
</x-landing-layout>