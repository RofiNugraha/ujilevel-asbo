<x-admin.sidebar>
</x-admin.sidebar>
<h1 class="h3 mb-4 text-gray-800">Create Layanan</h1>
<div class="card">
    <div class="card-body" style="width: 850px;">
        <form action="{{ route('admin.layanan.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="tipe_customer" class="form-label">Tipe Customer</label>
                <select name="tipe_customer" id="tipe_customer" class="form-control" required>
                    <option value="">Pilih Tipe Customer</option>
                    <option value="anak">Anak</option>
                    <option value="dewasa">Dewasa</option>
                </select>
                @error('tipe_customer')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="layanan_tambahan" class="form-label">Layanan Tambahan</label>
                <select name="layanan_tambahan" id="layanan_tambahan" class="form-control" required>
                    <option value="">Pilih Layanan Tambahan</option>
                    <option value="cukur_jenggot">Cukur Jenggot</option>
                    <option value="cukur_kumis">Cukur Kumis</option>
                    <option value="cukur_jenggot_kumis">Cukur Jenggot & Kumis</option>
                    <option value="tidak_ada">Tidak Ada</option>
                </select>
                @error('layanan_tambahan')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="kursi" class="form-label">Kursi</label>
                <select name="kursi" id="kursi" class="form-control" required>
                    <option value="">Pilih Kursi</option>
                    <option value="satu">Satu</option>
                    <option value="dua">Dua</option>
                </select>
                @error('kursi')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jam_booking" class="form-label">Jam Booking</label>
                <input type="datetime-local" name="jam_booking" id="jam_booking" class="form-control" required>
                @error('jam_booking')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" name="harga" id="harga" class="form-control" required>
                @error('harga')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                @error('deskripsi')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('admin.layanan.store') }}">
                <button type="button" class="btn btn-warning">Back</button>
            </a>
        </form>
    </div>
</div>