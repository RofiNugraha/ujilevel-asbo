<x-admin.sidebar>
    Create
    <a href="{{ route('admin.layanan.create') }}" class="mb-4">
        <button type="button" class="btn text-white">Create</button>
    </a>
    <hr>

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

    <script>
    function confirmDelete(id) {
        if (confirm("Apakah Anda yakin ingin menghapus layanan ini?")) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
    </script>
</x-admin.sidebar>