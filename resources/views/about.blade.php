@auth
<x-landing-layout>
    <h1
        class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 mt-20 flex justify-center items-center animate-pulse">
        WELCOME TO ABOUT ASGAR
    </h1>
    <main class="container mx-auto px-6 py-16 text-white flex items-center justify-center">
        <div class="flex flex-col md:flex-row items-center space-y-12 md:space-y-0 md:space-x-12">
            <img src="{{ asset('images/tempat.jpg') }}" alt="Barbershop Image"
                class="md:w-1/2 max-w-[485px] max-h-[361px] rounded-lg shadow-lg">
            <div class="md:w-1/2 text-center md:text-left">
                <h1 class="text-4xl font-bold mb-4 text-[gold]">Asgar System Booking Online</h1>
                <p class="text-lg leading-relaxed">Asgar System Booking Online merupakan solusi modern untuk memesan
                    layanan barbershop dengan mudah dan praktis. Kami hadir untuk memberikan pengalaman baru dalam
                    merawat penampilan Anda dengan teknologi yang menghubungkan Anda langsung dengan layanan potong
                    rambut profesional terbaik.</p>
            </div>
        </div>
    </main>
</x-landing-layout>
@endauth

@guest
<x-admin.home-layout>
    <main class="container mx-auto px-6 py-16 text-white flex items-center justify-center">
        <div class="flex flex-col md:flex-row items-center space-y-12 md:space-y-0 md:space-x-12">
            <img src="{{ asset('images/tempat.jpg') }}" alt="Barbershop Image"
                class="md:w-1/2 max-w-[485px] max-h-[361px] rounded-lg shadow-lg">
            <div class="md:w-1/2 text-center md:text-left">
                <h1 class="text-4xl font-bold mb-4 text-[gold]">Asgar System Booking Online</h1>
                <p class="text-lg leading-relaxed">Asgar System Booking Online merupakan solusi modern untuk memesan
                    layanan barbershop dengan mudah dan praktis. Kami hadir untuk memberikan pengalaman baru dalam
                    merawat penampilan Anda dengan teknologi yang menghubungkan Anda langsung dengan layanan potong
                    rambut profesional terbaik.</p>
            </div>
        </div>
    </main>
</x-admin.home-layout>
@endguest