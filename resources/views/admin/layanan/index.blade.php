<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Layanan</h1>
                    <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary mb-3">Add Contact</a>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Skill List
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="myTabel">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Tipe Customer</th>
                                            <th>Layanan Tambahan</th>
                                            <th>Kursi</th>
                                            <th>Jam Booking</th>
                                            <th>Harga</th>
                                            <th>Deskripsi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($layanan as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->tipe_customer }}</td>
                                            <td>{{ $item->layanan_tambahan }}</td>
                                            <td>{{ $item->kursi }}</td>
                                            <td>{{ $item->jam_booking }}</td>
                                            <td>{{ $item->harga }}</td>
                                            <td>{{ $item->deskripsi }}</td>
                                            <td>
                                                <a href="{{ route('admin.layanan.edit', $item) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="showDeleteModal({{ $item->id }})">Delete</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

<<<<<<< HEAD
                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                    aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus layanan ini?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form id="delete-form-{{ $item->id }}"
                                    action="{{ route('admin.layanan.destroy', $item->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
=======

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <table class="table table-striped table-hover" id="layanans-table" style="width: 850px;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tipe Customer</th>
                <th>Layanan Tambahan</th>
                <th>Kursi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($layanan as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->tipe_customer }}</td>
                <td>{{ $item->layanan_tambahan }}</td>
                <td>{{ $item->kursi }}</td>
                <td>{{ $item->jam_booking }}</td>
                <td>{{ $item->harga }}</td>
                <td>{{ $item->deskripsi }}</td>
                <td><a href="{{ route('admin.layanan.edit', $item) }}" class="mb-4">
                        <button class="btn btn-primary" type="button" style="align-items: center; gap: 5px;"><i
                                class="material-icons">edit</i></button>
                    </a>
                    <form id="delete-form-{{ $item->id }}" action="{{ route('admin.layanan.destroy', $item->id) }}"
                        method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $item->id }}')">
                            <i class="material-icons">delete</i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
>>>>>>> 3098cb802d558bf17e06e9af168cef7719efad9c

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('success'))
        Swal.fire({
            title: "Good Job!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK"
        });
        @endif
    });

    function showDeleteModal(skillId) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/admin/skills/${skillId}`;

        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                deleteForm.submit();
            }
        });
    }
    </script>
</x-admin.admin-layout>
