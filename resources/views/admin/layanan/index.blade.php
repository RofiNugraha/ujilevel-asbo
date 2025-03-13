<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 mt-4">
                        <div>
                            <h1 class="fw-semibold">Layanan</h1>
                            <p class="text-gray mb-0">Hallo, selamat datang di halaman Layanan</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i> Tambah Layanan
                    </a>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i> Daftar Layanan
                        </div>
                        <div class="card-body">
                            <table class="table" id="myTable">
                                <thead class="bg-warning">
                                    <tr>
                                        <th>Nama Layanan</th>
                                        <th>Deskripsi</th>
                                        <th>Harga</th>
                                        <th>Gambar</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($layanans as $layanan)
                                    <tr>
                                        <td>{{ $layanan->nama_layanan }}</td>
                                        <td>{{ $layanan->deskripsi }}</td>
                                        <td>Rp {{ number_format($layanan->harga, 0, ',', '.') }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $layanan->gambar) }}" alt="Gambar"
                                                width="100" class="img-thumbnail">
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.layanan.edit', $layanan->id) }}"
                                                class="btn btn-warning btn-sm rounded-circle" data-bs-toggle="tooltip"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Form Delete -->
                                            <form id="deleteForm-{{ $layanan->id }}"
                                                action="{{ route('admin.layanan.destroy', $layanan->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm rounded-circle delete-btn"
                                                    data-id="{{ $layanan->id }}" data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <script>
            document.addEventListener("DOMContentLoaded", function() {
                $('#myTable').DataTable();

                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const layananId = this.getAttribute('data-id');
                        Swal.fire({
                            title: "Apakah Anda yakin?",
                            text: "Data yang dihapus tidak bisa dikembalikan!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Ya, hapus!",
                            cancelButtonText: "Batal"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById(`deleteForm-${layananId}`)
                                    .submit();
                            }
                        });
                    });
                });

                // Inisialisasi tooltip
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
            </script>
        </div>
    </div>
</x-admin.admin-layout>