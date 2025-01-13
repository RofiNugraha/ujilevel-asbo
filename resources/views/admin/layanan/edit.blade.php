<x-admin.sidebar>
</x-admin.sidebar>
<h1 class="h3 mb-0 text-gray-800">Edit Layanan</h1>
<div class="card">
    <div class="card-body" style="width: 850px;">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('admin.layanan.update', $layanan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="tipe_customer">Tipe Customer</label>
            <select name="tipe_customer" id="tipe_customer" required>
                <option value="anak" {{ $layanan->tipe_customer == 'anak' ? 'selected' : '' }}>Anak</option>
                <option value="dewasa" {{ $layanan->tipe_customer == 'dewasa' ? 'selected' : '' }}>Dewasa</option>
            </select>

            <label for="layanan_tambahan">Layanan Tambahan</label>
            <select name="layanan_tambahan" id="layanan_tambahan" required>
                <option value="cukur_jenggot" {{ $layanan->layanan_tambahan == 'cukur_jenggot' ? 'selected' : '' }}>
                    Cukur
                    Jenggot</option>
                <option value="cukur_kumis" {{ $layanan->layanan_tambahan == 'cukur_kumis' ? 'selected' : '' }}>Cukur
                    Kumis
                </option>
                <option value="cukur_jenggot_kumis"
                    {{ $layanan->layanan_tambahan == 'cukur_jenggot_kumis' ? 'selected' : '' }}>Cukur Jenggot dan Kumis
                </option>
                <option value="tidak_ada" {{ $layanan->layanan_tambahan == 'tidak_ada' ? 'selected' : '' }}>Tidak Ada
                </option>
            </select>

            <label for="kursi">Kursi</label>
            <select name="kursi" id="kursi" required>
                <option value="satu" {{ $layanan->kursi == 'satu' ? 'selected' : '' }}>Satu</option>
                <option value="dua" {{ $layanan->kursi == 'dua' ? 'selected' : '' }}>Dua</option>
            </select>

            <label for="jam_booking">Jam Booking</label>
            <input type="datetime-local" name="jam_booking" id="jam_booking" value="{{ $layanan->jam_booking }}"
                required>

            <label for="harga">Harga</label>
            <input type="text" name="harga" id="harga" value="{{ $layanan->harga }}" class="form-control" readonly>

            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi">{{ $layanan->deskripsi }}</textarea>

            <button type="submit">Update</button>
            <a href="{{ route('admin.layanan.index') }}"><button type="" class=" btn btn-warning">Back</button></a>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const layananTambahan = document.getElementById("layanan_tambahan");
    const hargaField = document.getElementById("harga");
    const tipeCustomer = document.getElementById("tipe_customer");

    layananTambahan.addEventListener("change", function() {
        let basePrice = tipeCustomer.value === "anak" ? 13000 : 15000;
        let additionalPrice = 0;

        if (this.value === "cukur_jenggot" || this.value === "cukur_kumis" || this.value ===
            "cukur_jenggot_kumis") {
            additionalPrice = 5000;
        }

        const totalPrice = basePrice + additionalPrice;

        hargaField.value = totalPrice;
    });

    tipeCustomer.addEventListener("change", function() {
        let basePrice = this.value === "anak" ? 13000 : 15000;
        let additionalPrice = 0;

        if (layananTambahan.value === "cukur_jenggot" || layananTambahan.value === "cukur_kumis" ||
            layananTambahan.value === "cukur_jenggot_kumis") {
            additionalPrice = 5000;
        }

        const totalPrice = basePrice + additionalPrice;

        hargaField.value = totalPrice;
    });
});
</script>