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
                <p class="text-gray-500">3 items</p>
            </div>
            <div class="space-y-6">
                <!-- Item 1 -->
                <div class="flex items-center justify-between border-b pb-4">
                    <img src="{{ asset('images/book.jpg') }}" alt="Item Image"
                        class="w-20 h-20 object-cover rounded-xl">
                    <div class="flex-1 ml-4">
                        <h3 class="font-semibold text-lg">Item Name</h3>
                        <p class="text-gray-500">Description of the item</p>
                    </div>
                    <p class="font-semibold text-xl text-gray-800 mr-2">Rp. 15.000,00</p>
                    <button
                        class="bg-red-500 text-white px-4 py-2 rounded-full shadow-md hover:bg-red-600 transition">
                        Remove
                    </button>
                </div>
                <!-- Item 2 -->
                <div class="flex items-center justify-between border-b pb-4">
                    <img src="{{ asset('images/book.jpg') }}" alt="Item Image"
                        class="w-20 h-20 object-cover rounded-xl">
                    <div class="flex-1 ml-4">
                        <h3 class="font-semibold text-lg">Item Name</h3>
                        <p class="text-gray-500">Description of the item</p>
                    </div>
                    <p class="font-semibold text-xl text-gray-800 mr-2">Rp. 20.000,00</p>
                    <button
                        class="bg-red-500 text-white px-4 py-2 rounded-full shadow-md hover:bg-red-600 transition">
                        Remove
                    </button>
                </div>
                <!-- Item 3 -->
                <div class="flex items-center justify-between border-b pb-4">
                    <img src="{{ asset('images/book.jpg') }}" alt="Item Image"
                        class="w-20 h-20 object-cover rounded-xl">
                    <div class="flex-1 ml-4">
                        <h3 class="font-semibold text-lg">Item Name</h3>
                        <p class="text-gray-500">Description of the item</p>
                    </div>
                    <p class="font-semibold text-xl text-gray-800 mr-2">Rp. 25.000,00</p>
                    <button
                        class="bg-red-500 text-white px-4 py-2 rounded-full shadow-md hover:bg-red-600 transition">
                        Remove
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="bg-white rounded-3xl shadow-lg w-full max-w-4xl mt-8 p-6">
            <div class="flex justify-between items-center">
                <h3 class="font-semibold text-lg">Total Price:</h3>
                <p class="font-bold text-2xl text-gray-800">Rp. 60.000,00</p>
            </div>
            <div class="flex mt-6 gap-4">
                <button
                    class="bg-green-500 text-white font-semibold px-6 py-3 rounded-full shadow-md hover:bg-green-600 transition w-full">
                    Proceed to Checkout
                </button>
                <button
                    class="bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-full shadow-md hover:bg-gray-300 transition w-full">
                    Continue Shopping
                </button>
            </div>
        </div>
    </main>
</x-landing-layout>
