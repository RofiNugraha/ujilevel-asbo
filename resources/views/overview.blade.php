@auth
<style>
@keyframes marquee {
    0% {
        transform: translateX(100%);
    }

    100% {
        transform: translateX(-70vw);
    }
}

.marquee {
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    animation: marquee 20s linear infinite;
    background: linear-gradient(to left, #0e2094, #1a3cb3);
    color: gold;
    padding: 10px;
    border-radius: 20px;
    position: absolute;
    right: 0;
}

.marquee-container {
    width: 100%;
    overflow: hidden;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: flex-start;
}

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
<x-landing-layout>
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
        OVERVIEW BOOKING!
    </h1>
    <div class="flex items-center justify-center mx-6">
        <div class="container mx-auto mt-12 mb-12 w-full max-w-4xl">
            <div class="bg-[#ffff] rounded-[39px] shadow-lg p-4 h-[60px] flex items-center marquee-container">
                <h1 class="text-1xl px-4 font-semibold marquee">
                    Booking List:
                </h1>
            </div>
            <div class="flex justify-center mt-6">
                <div
                    class="card mb-4 shadow-2xl rounded-lg overflow-hidden w-full bg-white transform hover:-translate-y-1 hover:shadow-3xl transition">
                    <div class="card-header bg-gray-100 text-[#0e2094] font-bold flex items-center justify-between p-4">
                        <span><i class="fas fa-table me-1"></i> View List</span>
                        <div class="flex items-center space-x-2">
                            <div class="relative">
                                <input type="text"
                                    class="px-4 py-2 pl-10 border border-[#0e2094] rounded focus:outline-none focus:ring-2 focus:ring-[#0e2094]"
                                    placeholder="Search...">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-[#0e2094]"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11 2a9 9 0 011 17.9V21l6-6-6-6v3.1A7 7 0 1011 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-center border-separate border-spacing-0">
                                <thead class="bg-[gold] text-black">
                                    <tr>
                                        <th class="py-4 border-b-2 border-gray-300">No.</th>
                                        <th class="py-4 border-b-2 border-gray-300">Nama</th>
                                        <th class="py-4 border-b-2 border-gray-300">Kursi</th>
                                        <th class="py-4 border-b-2 border-gray-300">Jam Booking</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-gray-300">
                                        <td class="p-4"></td>
                                        <td class="p-4"></td>
                                        <td class="p-4"></td>
                                        <td class="p-4"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-landing-layout>
@endauth