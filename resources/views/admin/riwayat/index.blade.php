<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Riwayat Transaksi</h1>
                    <a href="{{ route('admin.riwayat.create') }}" class="btn btn-primary mb-3">Create Riwayat</a>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Riwayat Transaksi
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="riwayats-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>ID User</th>
                                            <th>ID Layanan</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Jumlah Bayar</th>
                                            <th>Pembayaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($riwayat as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->user_id }}</td>
                                            <td>{{ $item->layanan_id }}</td>
                                            <td>{{ $item->tanggal_transaksi }}</td>
                                            <td>{{ $item->jumlah_bayar }}</td>
                                            <td>{{ $item->metode_pembayaran }}</td>
                                            <td>
                                                <a href="{{ route('admin.riwayat.edit', $item) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete('{{ $item->id }}')">Delete</button>
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
                function confirmDelete(riwayatId) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "This action cannot be undone!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form-' + riwayatId).submit();
                        }
                    });
                }
                </script>

                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.riwayat.destroy', $item->id) }}"
                    method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>

            </main>
        </div>
    </div>
</x-admin.admin-layout>