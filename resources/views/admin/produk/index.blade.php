<a href="{{ route('admin.produk.create') }}">create</a>

<h1>Produk List</h1>
<table>
    <thead>
        <tr>
            <th>Nama Produk</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Gambar</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produks as $produk)
        <tr>
            <td>{{ $produk->nama_produk }}</td>
            <td>{{ $produk->deskripsi }}</td>
            <td>{{ $produk->harga }}</td>
            <td><img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar" width="100"></td>
            <td>
                <a href="{{ route('admin.produk.edit', $produk->id) }}">Edit</a>
                <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>