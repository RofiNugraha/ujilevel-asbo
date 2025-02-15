<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Booking Confirmation</h1>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Pelanggan</label>
                        <input type="text" class="form-control" value="{{ $bookings->user->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Layanan yang Dipesan</label>
                        <div class="row justify-content-left">
                            @foreach($layanans as $layanan)
                            <div class="col-md-2 mb-3">
                                <div class="card shadow-sm border-0 text-center p-2">
                                    <img src="{{ asset('storage/' . $layanan->gambar) }}" class="mx-auto"
                                        alt="{{ $layanan->nama_layanan }}"
                                        style="height: 120px; width: 120px; object-fit: cover; border-radius: 10px;">

                                    <div class="card-body">
                                        <p class="card-title fw-bold mb-1" style="font-size: 14px;">
                                            {{ $layanan->nama_layanan }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <form action="{{ route('admin.booking.update', $bookings->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">ID Layanan</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-2">
                                @foreach($layanans as $layanan)
                                <div class="p-3 border rounded-lg bg-white shadow-sm mb-4">
                                    <p class="text-sm font-semibold">{{ $layanan->nama_layanan }}</p>
                                    <p class="text-xs text-gray-500">ID: <span
                                            class="font-mono text-blue-600">{{ $layanan->id }}</span></p>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <select name="layanan_id[]" class="form-select" multiple hidden>
                            @foreach($layanans as $layanan)
                            <option value="{{ $layanan->id }}"
                                {{ in_array($layanan->id, json_decode($bookings->layanan_id, true)) ? 'selected' : '' }}>
                                {{ $layanan->nama_layanan }}
                            </option>
                            @endforeach
                        </select>


                        <div class="mb-3">
                            <label for="jam_booking" class="form-label fw-bold">Jam Booking</label>
                            <input type="datetime-local" name="jam_booking" id="jam_booking"
                                value="{{ old('jam_booking', \Carbon\Carbon::parse($bookings->jam_booking)->format('Y-m-d\TH:i')) }}"
                                class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kursi</label>
                            <input type="text" name="kursi" class="form-control" value="{{ $bookings->kursi }}"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending"
                                    {{ old('status', $bookings->status) == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="batal"
                                    {{ old('status', $bookings->status) == 'batal' ? 'selected' : '' }}>
                                    Batal</option>
                                <option value="konfirmasi"
                                    {{ old('status', $bookings->status) == 'konfirmasi' ? 'selected' : '' }}>Konfirmasi
                                </option>
                                <option value="selesai"
                                    {{ old('status', $bookings->status) == 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Booking</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</x-admin.admin-layout>