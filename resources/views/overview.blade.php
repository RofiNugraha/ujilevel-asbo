@auth
<style>
@keyframes marquee {
    0% {
        transform: translateX(100%);
    }

    100% {
        transform: translateX(-100%);
    }
}

.marquee {
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    animation: marquee 10s linear infinite;
}

.marquee-container {
    width: 100%;
    overflow: hidden;
    position: relative;
}
</style>
<x-landing-layout>
    <h1
        class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 mt-20 flex justify-center items-center animate-pulse">
        OVERVIEW BOOKING!
    </h1>
    <div class="flex items-center justify-center mx-6">
        <div class="container mx-auto mt-12 mb-12 w-full max-w-4xl">
            <div class="bg-[#ffff] rounded-[39px] shadow-lg p-4 h-[60px] flex items-center marquee-container">
                <h1 class="text-1xl px-4 font-semibold text-[gold] marquee">
                    List Booking: {{ \Carbon\Carbon::today()->format('l, d-m-Y') }}
                </h1>
            </div>
            <div class="flex justify-center mt-6">
                <div
                    class="card mb-4 shadow-2xl rounded-lg overflow-hidden w-full bg-white transform hover:-translate-y-1 hover:shadow-3xl transition">
                    <div class="card-header bg-gray-100 text-[#0e2094] font-bold flex items-center justify-between p-4">
                        <span><i class="fas fa-table me-1"></i> Skill List</span>
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
                                    @forelse($bookings as $booking)
                                    <tr class="border-b border-gray-300">
                                        <td class="p-4">{{ $loop->iteration }}</td>
                                        <td class="p-4">{{ $booking->user->name }}</td>
                                        <td class="p-4">{{ $booking->kursi }}</td>
                                        <td class="p-4">{{ $booking->jam_booking }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center p-4">Tidak ada booking hari ini.</td>
                                    </tr>
                                    @endforelse
                                    <!-- Add more rows as needed -->
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

@guest
<x-admin.home-layout>
    <div class="flex items-center justify-center mx-6">
        <div class="container mx-auto mt-12 mb-12 w-full max-w-4xl">
            <div class="bg-[#0e2094] rounded-[39px] shadow-lg p-4 h-[60px] flex items-center">
                <h1 class="text-1xl px-4 font-semibold text-white">
                    List Booking: {{ \Carbon\Carbon::today()->format('l, d-m-Y') }}
                </h1>
            </div>
            <div class="flex justify-center mt-6">
                <div
                    class="card mb-4 shadow-2xl rounded-lg overflow-hidden w-full bg-white transform hover:-translate-y-1 hover:shadow-3xl transition">
                    <div class="card-header bg-gray-100 text-[#0e2094] font-bold flex items-center justify-between p-4">
                        <span><i class="fas fa-table me-1"></i> Skill List</span>
                        <button class="bg-[#0e2094] text-white px-4 py-2 rounded hover:bg-[#0c1a7a] transition">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table-auto w-full text-center mb-0 shadow-lg">
                                <thead class="bg-[#fffff] text-[#0e2094]">
                                    <tr class="">
                                        <th class="py-4">No.</th>
                                        <th class="py-4">Nama</th>
                                        <th class="py-4">Kursi</th>
                                        <th class="py-4">Jam Booking</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse($bookings as $booking)
                                    <tr class="bg-white border-b-2 border-black">
                                        <td
                                            class="p-4 text-2xl font-normal text-black text-center border-r-2 border-black">
                                            {{ $loop->iteration }}</td>
                                        <td
                                            class="p-4 text-2xl font-normal text-black text-center border-r-2 border-black">
                                            {{ $booking->user->name }}</td>
                                        <td
                                            class="p-4 text-2xl font-normal text-black text-center border-r-2 border-black">
                                            {{ $booking->kursi }}</td>
                                        <td class="p-4 text-2xl font-normal text-black text-center">
                                            {{ $booking->jam_booking }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center p-4">Tidak ada booking hari ini.</td>
                                    </tr>
                                    @endforelse
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.home-layout>
@endguest