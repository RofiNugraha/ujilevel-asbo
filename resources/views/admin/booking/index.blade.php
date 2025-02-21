<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 mt-4">
                        <div>
                            <h1 class="fw-semibold">Bookingan</h1>
                            <p class="text-gray mb-0">Hallo, selamat datang di halaman Booking</p>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Booking List
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="bookings-table">
                                    <thead class="bg-warning">
                                        <tr class="text-dark">
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Layanan</th>
                                            <th>Booking</th>
                                            <th>Kursi</th>
                                            <th>Status</th>
                                            <th>Status Pembayaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($bookings as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>
                                                @php
                                                $layananItems = json_decode($item->layanan_id, true) ?? [];
                                                @endphp
                                                @foreach($layananItems as $layananItem)
                                                @php
                                                $layanan = App\Models\Layanan::find($layananItem['id']);
                                                @endphp
                                                @if($layanan)
                                                <span class="badge bg-primary">
                                                    {{ $layanan->nama_layanan }} (x{{ $layananItem['quantity'] }})
                                                </span>
                                                @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $item->jam_booking }}</td>
                                            <td>{{ $item->kursi }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ $item->status_pembayaran }}</td>
                                            <td>
                                                <a href="{{ route('admin.booking.edit', $item->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    Konfirmasi Booking
                                                </a>
                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('admin.booking.destroy', $item->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="confirmDelete({{ $item->id }})">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                function confirmDelete(bookingId) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "This action cannot be undone!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form-' + bookingId).submit();
                        }
                    });
                }
                </script>
            </main>
        </div>
    </div>
</x-admin.admin-layout>