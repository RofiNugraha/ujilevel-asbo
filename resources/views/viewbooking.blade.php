<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com/3.2.0"></script>
    <title>Document</title>
</head>

<body class="bg-gradient-to-b from-[#0c102b] to-[#0e2094] min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-8 md:p-12 space-y-6">
        <h1 class="text-center text-4xl font-bold mb-6">Detail Booking</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg">
                <tbody>
                    <tr class="">
                        <td class="px-4 py-2 font-bold text-gray-700">Nama</td>
                        <td class="px-4 py-2 text-gray-600">Ayu</td>
                    </tr>
                    <tr class="">
                        <td class="px-4 py-2 font-bold text-gray-700">Tipe Customer</td>
                        <td class="px-4 py-2 text-gray-600">Dewasa</td>
                    </tr>
                    <tr class="">
                        <td class="px-4 py-2 font-bold text-gray-700">Layanan</td>
                        <td class="px-4 py-2 text-gray-600">Style Hair</td>
                    </tr>
                    <tr class="">
                        <td class="px-4 py-2 font-bold text-gray-700">Layanan Tambahan</td>
                        <td class="px-4 py-2 text-gray-600">Tidak Ada</td>
                    </tr>
                    <tr class="">
                        <td class="px-4 py-2 font-bold text-gray-700">Jam Booking</td>
                        <td class="px-4 py-2 text-gray-600">12.00</td>
                    </tr>
                    <tr class="">
                        <td class="px-4 py-2 font-bold text-gray-700">Kursi</td>
                        <td class="px-4 py-2 text-gray-600">2</td>
                    </tr>
                    <tr class="">
                        <td class="px-4 py-2 font-bold text-gray-700">Harga</td>
                        <td class="px-4 py-2 text-gray-600">15.000</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold text-gray-700">Deskripsi</td>
                        <td class="px-4 py-2 text-gray-600">Gaya model cepmek</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-8 flex justify-between">
            <button class="bg-yellow-400 text-white px-4 py-2 rounded-lg">
                <a href="{{ route('profil') }}">Back</a>
            </button>
            <div class="flex gap-2">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Edit</button>
                <button class="bg-red-700 text-white px-4 py-2 rounded-lg">Batalkan Booking</button>
            </div>
        </div>
    </div>
</body>

</html>