<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="h3 mb-0 text-gray-800">Edit Layanan</h1>
                    <div class="card">
                        <div class="card-body" style="width: 850px;">
                            <form action="{{ route('admin.riwayat.update', $riwayat->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label for="user_id">ID User</label>
                                <input type="text" name="user_id" id="user_id" value="{{ $riwayat->user_id }}" readonly>

                                <label for="layanan_id">ID Layanan</label>
                                <input type="text" name="layanan_id" id="layanan_id" value="{{ $riwayat->layanan_id }}"
                                    readonly>

                                <label for="tanggal_transaksi">Tanggal Transaksi</label>
                                <input type="datetime-local" name="tanggal_transaksi" id="tanggal_transaksi"
                                    value="{{ $riwayat->tanggal_transaksi }}" readonly>

                                <label for="jumlah_bayar">Jumlah Bayar</label>
                                <input type="text" name="jumlah_bayar" id="jumlah_bayar"
                                    value="{{ $riwayat->jumlah_bayar }}" readonly>

                                <label for="metode_pembayaran">Metode Pembayaran</label>
                                <input type="text" name="metode_pembayaran" id="metode_pembayaran"
                                    value="{{ $riwayat->metode_pembayaran }}" required>

                                <button type="submit">Update</button>
                                <a href="{{ route('admin.riwayat.index') }}"><button type=""
                                        class=" btn btn-warning">Back</button></a>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-admin.admin-layout>