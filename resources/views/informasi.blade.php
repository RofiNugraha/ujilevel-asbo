<x-landing-layout>
    <div class="max-w-3xl mx-auto mt-16 p-8 bg-white shadow-lg rounded-xl">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Checkout Information</h1>
        <form action="" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Full Name</label>
                <input type="text" id="name" name="name" required
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone Number</label>
                <input type="text" id="phone" name="phone" required
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="address" class="block text-gray-700 font-semibold mb-2">Address</label>
                <textarea id="address" name="address" rows="3" required
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="flex justify-between items-center">
                <a href=""
                    class="text-blue-600 hover:underline">Back to Cart</a>
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition-all">
                    Confirm Order
                </button>
            </div>
        </form>
    </div>
</x-landing-layout>
