<x-landing-layout>
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
</x-landing-layout>