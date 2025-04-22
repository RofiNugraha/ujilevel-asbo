<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <!-- Header -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 mt-4">
                        <div>
                            <h1 class="fw-semibold"><i class="fas fa-concierge-bell text-primary me-2"></i>Layanan</h1>
                            <p class="text-gray mb-0"><i class="fas fa-handshake text-success me-1"></i>Hallo, selamat
                                datang di halaman Layanan</p>
                        </div>
                    </div>

                    <!-- Tombol Tambah -->
                    <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus me-1"></i> Tambah Layanan
                    </a>

                    <!-- Tabel Layanan -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-list-alt me-2 text-warning"></i> Daftar Layanan
                        </div>
                        <div class="card-body">
                            <table class="table" id="myTable">
                                <thead class="bg-warning text-white">
                                    <tr>
                                        <th><i class="fas fa-tag me-1"></i>Nama Layanan</th>
                                        <th><i class="fas fa-align-left me-1"></i>Deskripsi</th>
                                        <th><i class="fas fa-money-bill-wave me-1"></i>Harga</th>
                                        <th><i class="fas fa-image me-1"></i>Gambar</th>
                                        <th><i class="fas fa-cogs me-1"></i>Action</th>
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
                                                width="100" class="img-thumbnail shadow-sm">
                                        </td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.layanan.edit', $layanan->id) }}"
                                                class="btn btn-warning btn-sm rounded-circle" data-bs-toggle="tooltip"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Tombol Delete -->
                                            <form id="deleteForm-{{ $layanan->id }}"
                                                action="{{ route('admin.layanan.destroy', $layanan->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm rounded-circle delete-btn"
                                                    data-id="{{ $layanan->id }}" data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
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

            <!-- Script -->
            <script>
            document.addEventListener("DOMContentLoaded", function() {
                $('#myTable').DataTable();

                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
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

                // Tooltip Bootstrap
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
            </script>
        </div>
    </div>
</x-admin.admin-layout>