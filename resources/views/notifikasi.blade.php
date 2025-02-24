@auth
<x-landing-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="bg-white mt-8 mx-8 shadow-md p-4">
                    <h1 class="text-2xl font-medium text-black">Notifikasi</h1>

                    @forelse ($notifications as $notification)
                    @php
                    $status = $notification->booking->status ?? 'default';

                    $bgColor = match ($status) {
                    'konfirmasi' => 'bg-green-500', // Hijau
                    'batal' => 'bg-red-500', // Merah
                    'selesai' => 'bg-blue-500', // Biru
                    default => 'bg-gray-300', // Default abu-abu
                    };
                    @endphp

                    <div class="{{ $bgColor }} text-black bg-gray-200 p-3 rounded-lg my-2">
                        <strong>{{ $notification->user->name ?? 'Tidak diketahui' }}</strong>:
                        {{ $notification->pesan }}
                        <br>
                        <small>{{ $notification->tanggal_notifikasi }}</small>
                        @if (!$notification->status_dibaca)
                        <button onclick="markAsRead({{ $notification->id }})"
                            class="bg-blue-500 text-white px-2 py-1 rounded">Tandai Dibaca</button>
                        @endif
                    </div>
                    @empty
                    <p class="text-gray-500">Tidak ada notifikasi</p>
                    @endforelse

                </div>
            </main>
        </div>
    </div>

    <script>
    function markAsRead(id) {
        fetch(`/notifikasi/${id}/read`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload();
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