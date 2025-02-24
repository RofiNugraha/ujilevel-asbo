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
                    <tr>
                        <td class="px-4 py-2 font-bold text-gray-700">Nama</td>
                        <td class="px-4 py-2 text-gray-600">{{ $booking->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold text-gray-700">ID Booking</td>
                        <td class="px-4 py-2 text-gray-600">{{ $booking->id }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold text-gray-700">Layanan</td>
                        <td class="px-4 py-2 text-gray-600">belum beres
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold text-gray-700">Jam Booking</td>
                        <td class="px-4 py-2 text-gray-600">{{ $booking->jam_booking }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold text-gray-700">Kursi</td>
                        <td class="px-4 py-2 text-gray-600">{{ $booking->kursi }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold text-gray-700">Status</td>
                        <td class="px-4 py-2 text-gray-600">{{ $booking->status }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold text-gray-700">Total Harga</td>
                        <td class="px-4 py-2 text-gray-600">Rp
                            {{ number_format(optional($booking->checkout)->total_harga, 2, ',', '.') }}</td>
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