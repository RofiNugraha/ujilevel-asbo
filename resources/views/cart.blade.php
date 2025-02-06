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
                    <!-- Display Image -->
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="Item Image"
                        class="w-20 h-20 object-cover rounded-xl">
                    <div class="flex-1 ml-4">
                        <!-- Display Product or Service Name -->
                        <h3 class="font-semibold text-lg">
                            {{ $item->produk_id ? $item->produk->nama_produk : $item->layanan->nama_layanan }}
                        </h3>
                        <!-- Display Product or Service Description -->
                        <p class="text-gray-500">
                            {{ $item->produk_id ? $item->produk->deskripsi : $item->layanan->deskripsi }}
                        </p>
                        <!-- Display Quantity -->
                        <p class="text-gray-700">Qty: {{ $item->quantity }}</p>
                    </div>
                    <!-- Display Subtotal -->
                    <p class="font-semibold text-xl text-gray-800 mr-2">Rp.
                        {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    <!-- Remove Item Form -->
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

        <!-- Summary Section -->
        <div class="bg-white rounded-3xl shadow-lg w-full max-w-4xl mt-8 p-6">
            <div class="flex justify-between items-center">
                <h3 class="font-semibold text-lg">Total Price:</h3>
                <p class="font-bold text-2xl text-gray-800">Rp.
                    {{ number_format($cartItems->sum('subtotal'), 0, ',', '.') }}</p>
            </div>
            <div class="flex mt-6 gap-4">
                <button
                    class="bg-green-500 text-white font-semibold px-6 py-3 rounded-full shadow-md hover:bg-green-600 transition w-full">
                    <a href="/formbook">Proceed to Checkout</a>
                </button>
                <a href="{{ route('booking') }}"
                    class="bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-full shadow-md hover:bg-gray-300 transition w-full text-center">
                    Continue Shopping
                </a>
            </div>
        </div>
    </main>
</x-landing-layout>