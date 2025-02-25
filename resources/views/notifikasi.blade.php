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

                    $icon = match ($status) {
                    'konfirmasi' => 'success',
                    'batal' => 'error',
                    'selesai' => 'info',
                    default => 'question',
                    };
                    @endphp

                    <div class="{{ $bgColor }} text-black bg-gray-200 p-3 rounded-lg my-2 cursor-pointer"
                        onclick="showNotification({{ $notification->id }}, '{{ $notification->user->name ?? 'Tidak diketahui' }}', '{{ $notification->pesan }}', '{{ $notification->tanggal_notifikasi }}', '{{ $icon }}')">
                        <strong>{{ $notification->user->name ?? 'Tidak diketahui' }}</strong>:
                        {{ $notification->pesan }}
                        <br>
                        <small>{{ $notification->tanggal_notifikasi }}</small>
                    </div>
                    @empty
                    <p class="text-gray-500">Tidak ada notifikasi</p>
                    @endforelse

                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function showNotification(id, user, message, date, icon) {
        fetch(`/notifikasi/${id}/read`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: `📢 Dari: ${user}`,
                    html: `<p style='font-size: 18px; font-weight: 500;'>${message}</p>`,
                    footer: `<small style='color: gray;'>📅 ${date}</small>`,
                    icon: icon,
                    showConfirmButton: false,
                    timer: 5000,
                    background: '#f9f9f9',
                    color: '#333',
                    toast: true,
                    position: 'top-end',
                    showCloseButton: true
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