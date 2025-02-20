@auth
<x-landing-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="bg-white mt-8 mx-8 shadow-md p-4">
                    <h1 class="text-2xl font-medium text-black">Notifikasi</h1>

                    @if(isset($notifications) && $notifications->isNotEmpty())
                    @foreach ($notifications as $notification)
                    @php
                    $bgColor = match($notification->booking->status ?? '') {
                    'batal' => 'bg-red-500',
                    'konfirmasi' => 'bg-green-500',
                    'selesai' => 'bg-blue-500',
                    default => 'bg-gray-200',
                    };
                    @endphp

                    <div class="{{ $bgColor }} text-white p-3 rounded-lg my-2">
                        <p class="font-medium">{{ $notification->pesan }}</p>
                        <p class="text-sm">{{ $notification->tanggal_notifikasi }}</p>
                    </div>
                    @endforeach
                    @else
                    <p class="text-gray-500">Tidak ada notifikasi.</p>
                    @endif

                </div>
            </main>
        </div>
    </div>
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