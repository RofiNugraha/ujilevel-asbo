<x-landing-layout>
    <main class="mt-16 flex justify-center items-center">
        <div class="bg-white rounded-3xl shadow-lg p-6 w-80 flex flex-col items-center">
            <img src="{{ asset('images/book.jpg') }}" alt="Cut and Style Hair" class="rounded-3xl mb-4">
            <h2 class="text-2xl font-semibold mb-2 text-center">Cut and Style Hair</h2>
            @auth
            <button
                class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-[0_4px_6px_rgba(0,0,0,0.1),0_10px_15px_rgba(0,0,0,0.05),0_20px_25px_rgba(0,0,0,0.1)] transform hover:translate-y-1 hover:shadow-[0_10px_15px_rgba(0,0,0,0.2),0_25px_30px_rgba(0,0,0,0.15)] transition-all duration-300">
                <a href="{{ route('form') }}">Book Now</a>
            </button>
            @else
            <button
                class="bg-blue-600 mt-4 mb-2 text-white rounded-full px-6 py-2 shadow-[0_4px_6px_rgba(0,0,0,0.1),0_10px_15px_rgba(0,0,0,0.05),0_20px_25px_rgba(0,0,0,0.1)] transform hover:translate-y-1 hover:shadow-[0_10px_15px_rgba(0,0,0,0.2),0_25px_30px_rgba(0,0,0,0.15)] transition-all duration-300">
                <a href="{{ route('login') }}">Login to Book</a>
            </button>
            @endauth
        </div>
    </main>
</x-landing-layout>