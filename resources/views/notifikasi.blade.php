@auth
<x-landing-layout>
    <style>
    .reminder-pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(99, 102, 241, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(99, 102, 241, 0);
        }
    }
    </style>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container mx-auto px-4 py-6">
                    <h1 class="text-3xl font-bold text-[gold] mb-6">Notifikasi Anda</h1>

                    <div class="bg-[#2F2F2F] mt-8 mx-8 shadow-md p-4 rounded-lg">
                        <h1 class="text-2xl font-medium text-black mb-4">Notifikasi</h1>

                        @forelse ($notifications as $notification)
                        @php
                        $isReminder = str_contains($notification->pesan, 'Pengingat');
                        $reminderType = $isReminder ? explode(':', $notification->pesan)[0] : '';

                        $bgColor = $isReminder ? 'bg-blue-50 border-l-4 border-blue-500' :
                        ($notification->booking->status == 'konfirmasi' ? 'bg-green-50 border-l-4 border-green-500' :
                        ($notification->booking->status == 'batal' ? 'bg-red-50 border-l-4 border-red-500' :
                        'bg-gray-50 border-l-4 border-gray-500'));

                        $icon = $isReminder ? '⏰' :
                        ($notification->booking->status == 'konfirmasi' ? '✅' :
                        ($notification->booking->status == 'batal' ? '❌' : 'ℹ️'));
                        @endphp

                        <div class="{{ $bgColor }} p-4 rounded-r-lg my-2 cursor-pointer transition-all hover:shadow-md"
                            onclick="showNotification({{ $notification->id }}, '{{ $notification->user->name ?? 'System' }}', 
                            '{{ $notification->pesan }}', '{{ $notification->tanggal_notifikasi->format('d M Y H:i') }}', 
                            '{{ $icon }}')">
                            <div class="flex items-start">
                                <span class="text-xl mr-3">{{ $icon }}</span>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <strong
                                            class="text-gray-800">{{ $notification->user->name ?? 'System' }}</strong>
                                        <small
                                            class="text-gray-500 ml-2">{{ $notification->tanggal_notifikasi->format('H:i') }}</small>
                                    </div>
                                    <p class="text-gray-700 mt-1">{{ $notification->pesan }}</p>
                                    @if($isReminder)
                                    <span
                                        class="inline-block mt-1 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                        {{ $reminderType }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500">Tidak ada notifikasi</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function showNotification(id, message) {
        fetch(`/notifikasi/${id}/read`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                Swal.fire({
                    html: `<div class="text-left">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="ml-3 text-xl font-bold text-gray-800">Pengingat Booking</h3>
                        </div>
                        <p class="text-gray-700 text-lg mb-4">${message}</p>
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <p class="text-sm text-blue-700">Terima kasih telah menggunakan layanan kami!</p>
                        </div>
                    </div>`,
                    showConfirmButton: false,
                    showCloseButton: true,
                    background: '#ffffff',
                    width: '500px',
                    padding: '2rem',
                    customClass: {
                        popup: 'rounded-xl shadow-xl'
                    }
                });
            });
    }
    </script>
</x-landing-layout>
@endauth

@guest
<x-admin.home-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="bg-white mt-8 mx-8 rounded-lg shadow-md">
                    <h1 class="text-2xl font-medium m-2 text-black">Halo DEAR</h1>
                    <p class="text-2xl font-light text-black m-2">
                        Terima kasih atas pesanan anda!, Kami ...
                    </p>
                </div>
            </main>
        </div>
    </div>
</x-admin.home-layout>
@endguest