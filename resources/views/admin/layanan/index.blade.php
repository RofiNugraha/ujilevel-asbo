<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Layanan List</h1>
                    <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary mb-3">Tambah Layanan</a>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Layanan
                        </div>
                        <div class="card-body">
                            <table class="table" id="myTable">
                                <thead class="table-dark">
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
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="showDeleteModal({{ $layanan->id }})">Delete</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus layanan ini?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form id="deleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <script>
            function showDeleteModal(layananId) {
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `/admin/layanan/${layananId}`;

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            }
            </script>
        </div>
    </div>
</x-admin.admin-layout>