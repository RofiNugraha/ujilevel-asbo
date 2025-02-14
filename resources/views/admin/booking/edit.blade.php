<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="">.</h1>
                    <h1 class=" mt-2">Booking Confirmation</h1>
                    <form action="{{ route('admin.booking.update', $bookings->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @foreach ($layanans as $layanan)
                        <div>
                            <img src="{{ asset('storage/' . $layanan->gambar) }}" alt="{{ $layanan->nama_layanan }}"
                                width="100">
                            <p><strong>Nama:</strong> {{ $layanan->nama_layanan }}</p>
                            <p><strong>Deskripsi:</strong> {{ $layanan->deskripsi }}</p>
                        </div>
                        @endforeach
                        <label for="layanan_id">ID Layanan:</label>
                        <input type="text" name="layanan_id" value="{{ old('layanan_id', $bookings->layanan_id) }}"
                            readonly>

                        @foreach ($produks as $produk)
                        <div>
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}"
                                width="100">
                            <p><strong>Nama:</strong> {{ $produk->nama_produk }}</p>
                            <p><strong>Deskripsi:</strong> {{ $produk->deskripsi }}</p>
                        </div>
                        @endforeach
                        <label for="produk_id">ID Produk:</label>
                        <input type="text" name="produk_id" value="{{ old('produk_id', $bookings->produk_id) }}"
                            readonly>

                        <label for="jam_booking">Jam Booking:</label>
                        <input type="datetime-local" name="jam_booking" id="jam_booking"
                            value="{{ old('jam_booking', \Carbon\Carbon::parse($bookings->jam_booking)->format('Y-m-d\TH:i')) }}"
                            class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" required>


                        <label for="kursi">Kursi:</label>
                        <input type="text" name="kursi" value="{{ old('kursi', $bookings->kursi) }}" readonly>

                        <label for="deskripsi">Deskripsi:</label>
                        <textarea name="deskripsi" readonly>{{ old('deskripsi', $bookings->deskripsi) }}</textarea>

                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md">
                            <option value="pending"
                                {{ old('status', $bookings->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="batal" {{ old('status', $bookings->status) == 'batal' ? 'selected' : '' }}>
                                Batal</option>
                            <option value="konfirmasi"
                                {{ old('status', $bookings->status) == 'konfirmasi' ? 'selected' : '' }}>Konfirmasi
                            </option>
                            <option value="selesai"
                                {{ old('status', $bookings->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                        <small class="text-red-500 text-xs">{{ $message }}</small>
                        @enderror

                        <button type="submit">Update Booking</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</x-admin.admin-layout>