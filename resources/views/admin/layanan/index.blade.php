<a href="{{ route('admin.layanan.create') }}">create</a>

<h1>Layanan List</h1>
<table>
    <thead>
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
            <td>{{ $layanan->harga }}</td>
            <td><img src="{{ asset('storage/' . $layanan->gambar) }}" alt="Gambar" width="100"></td>
            <td>
                <a href="{{ route('admin.layanan.edit', $layanan->id) }}">Edit</a>
                <form action="{{ route('admin.layanan.destroy', $layanan->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>