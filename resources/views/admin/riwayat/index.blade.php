<x-admin.sidebar>
</x-admin.sidebar>
Create
<a href="{{ route('admin.riwayat.create') }}" class="mb-4">
    <button type="button" class="btn text-white">Create</button>
</a>
<hr>

<table class="table table-striped table-hover" id="riwayats-table" style="width: 850px;">
    <thead>
        <tr>
            <th>No.</th>
            <th>ID User</th>
            <th>ID Layanan</th>
            <th>Tanggal Transaksi</th>
            <th>Jumlah Bayar</th>
            <th>Pembayaran</th>
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
                <a href="{{ route('admin.riwayat.edit', $item) }}" class="mb-4">
                    <button class="btn btn-primary" type="button" style="align-items: center; gap: 5px;"><i
                            class="material-icons">edit</i></button>
                </a>
                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.riwayat.destroy', $item->id) }}"
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