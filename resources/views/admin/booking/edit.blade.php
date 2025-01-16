<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-4">
                    <h2>Edit Booking</h2>
                    <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="user" class="form-label">User</label>
                            <input type="text" class="form-control" id="user" value="{{ $booking->user->name }}"
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label for="layanan" class="form-label">Layanan</label>
                            <input type="text" class="form-control" id="layanan"
                                value="{{ $booking->layanan->tipe_customer }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status Booking</label>
                            <select name="status" id="status"
                                class="form-control @error('status') is-invalid @enderror">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="dibooking" {{ $booking->status == 'dibooking' ? 'selected' : '' }}>
                                    Dibooking</option>
                                <option value="selesai" {{ $booking->status == 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="dibatalkan" {{ $booking->status == 'dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                            <select name="status_pembayaran" id="status_pembayaran"
                                class="form-control @error('status_pembayaran') is-invalid @enderror">
                                <option value="sudah" {{ $booking->status_pembayaran == 'sudah' ? 'selected' : '' }}>
                                    Sudah</option>
                                <option value="belum" {{ $booking->status_pembayaran == 'belum' ? 'selected' : '' }}>
                                    Belum</option>
                            </select>
                            @error('status_pembayaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Update Booking</button>
                        <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </main>
        </div>
    </div>
</x-admin.admin-layout>