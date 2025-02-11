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
    <div class="w-full text-center mb-6">
        <h2 class="text-4xl font-bold text-[gold]">Book an Appointment</h2>
        <p class="mt-2 text-gray-300">Choose your service and preferred time.</p>
    </div>
    <div class="max-w-3xl w-full bg-white p-8 rounded-lg shadow-lg m-4">
        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">Asgar Book</h1>
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('booking.store') }}" method="post">
            @csrf
            @if($cartItems->isNotEmpty())
            @foreach ($cartItems as $index => $item)
            <div class="flex items-center gap-4 border-b pb-4 mb-4">
                <img src="{{ asset('storage/' . ($item->produk->gambar ?? $item->layanan->gambar ?? 'default.jpg')) }}"
                    alt="Gambar" class="w-20 h-20 object-cover rounded-lg">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ $item->produk->nama_produk ?? $item->layanan->nama_layanan ?? 'Tidak Diketahui' }}
                    </h3>
                    <p class="text-gray-600 text-sm">
                        {{ $item->produk->deskripsi ?? $item->layanan->deskripsi ?? 'Tidak ada deskripsi.' }}
                    </p>
                    <p class="text-gray-800 font-medium">
                        Quantity: {{ $item->quantity }}
                    </p>
                </div>

                <input type="hidden" name="items[{{ $index }}][layanan_id]" value="{{ $item->layanan->id }}">
                <input type="hidden" name="items[{{ $index }}][produk_id]" value="{{ $item->produk->id }}">

                <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}">
            </div>
            @endforeach
            @else
            <p class="text-red-500">Keranjang Anda kosong!</p>
            @endif

            <div class="mb-4">
                <label for="subtotal" class="block text-sm font-medium text-gray-700">Subtotal</label>
                <input type="text" class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md"
                    value="{{ number_format($cartCount->sum('subtotal'), 0, ',', '.') }}" disabled readonly>
            </div>

            <div class="mb-4">
                <label for="kursi" class="block text-sm font-medium text-gray-700">Kursi</label>
                <select name="kursi" id="kursi" class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md"
                    required>
                    <option value="">Pilih Kursi</option>
                    <option value="satu">Kursi 1</option>
                    <option value="dua">Kursi 2</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="jam_booking" class="block text-sm font-medium text-gray-700">Jam Booking</label>
                <input type="datetime-local" name="jam_booking" id="jam_booking"
                    class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi"
                    class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md"
                    rows="4">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex justify-between items-center mt-6">
                <button type="submit"
                    class="py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Submit</button>
                <a href="/cart" class="py-2 px-4 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Back</a>
            </div>
        </form>

    </div>
</body>

</html>