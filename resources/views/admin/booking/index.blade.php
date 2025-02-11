<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Booking List</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Booking List
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="bookings-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>ID User</th>
                                            <th>ID Layanan</th>
                                            <th>ID Produk</th>
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
                                            <td>{{ $item->user_id }}</td>
                                            <td>{{ $item->layanan_id }}</td>
                                            <td>{{ $item->produk_id }}</td>
                                            <td>{{ $item->jam_booking }}</td>
                                            <td>{{ $item->kursi }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ $item->status_pembayaran }}</td>
                                            <td>
                                                <a href="" class="btn btn-warning btn-sm">Konfirmasi Booking</a>
                                                <button class="btn btn-danger btn-sm">Delete</button>
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

                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.booking.destroy', $item->id) }}"
                    method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </main>
        </div>
    </div>
</x-admin.admin-layout>