<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com/3.2.0"></script>
    <title>Booking</title>
</head>

<body class="bg-gradient-to-b flex items-center justify-center min-h-screen"
    style="background-image: linear-gradient(to bottom right, #0C102B, #0E2094);">
    <div class="max-w-3xl w-full bg-white p-8 rounded-lg shadow-lg m-4">
        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">Asgar Book</h1>
        <form action="{{ route('formbook.store') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="tipe_customer" class="block text-sm font-medium text-gray-700">Tipe Customer</label>
                <select name="tipe_customer" id="tipe_customer"
                    class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" required>
                    <option value="">Pilih Tipe Customer</option>
                    <option value="anak">Anak</option>
                    <option value="dewasa">Dewasa</option>
                </select>
                @error('tipe_customer')
                <small class="text-red-500 text-xs">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="layanan_tambahan" class="block text-sm font-medium text-gray-700">Layanan Tambahan</label>
                <select name="layanan_tambahan" id="layanan_tambahan"
                    class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" required>
                    <option value="">Pilih Layanan Tambahan</option>
                    <option value="cukur_jenggot">Cukur Jenggot</option>
                    <option value="cukur_kumis">Cukur Kumis</option>
                    <option value="cukur_jenggot_kumis">Cukur Jenggot & Kumis</option>
                    <option value="tidak_ada">Tidak Ada</option>
                </select>
                @error('layanan_tambahan')
                <small class="text-red-500 text-xs">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kursi" class="block text-sm font-medium text-gray-700">Kursi</label>
                <select name="kursi" id="kursi" class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md"
                    required>
                    <option value="">Pilih Kursi</option>
                    <option value="satu">Satu</option>
                    <option value="dua">Dua</option>
                </select>
                @error('kursi')
                <small class="text-red-500 text-xs">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="jam_booking" class="block text-sm font-medium text-gray-700">Jam Booking</label>
                <input type="datetime-local" name="jam_booking" id="jam_booking"
                    class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" required>
                @error('jam_booking')
                <small class="text-red-500 text-xs">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="text" name="harga" id="harga"
                    class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" value="15000" readonly>
                @error('harga')
                <small class="text-red-500 text-xs">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi"
                    class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" rows="4"></textarea>
                @error('deskripsi')
                <small class="text-red-500 text-xs">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex justify-between items-center mt-6">
                <button type="submit"
                    class="w- py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">Submit</button>
                <a href="{{ route('booking') }}">
                    <button type="button"
                        class="w- py-2 px-4 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400">Back</button>
                </a>
            </div>
        </form>
    </div>

    <!-- harga -->
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
</body>

</html>