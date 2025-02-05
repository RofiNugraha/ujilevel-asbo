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
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="" method="post">
            @csrf
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
                <a href="/cart">
                    <button type="button"
                        class="w- py-2 px-4 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400">Back</button>
                </a>
            </div>
        </form>
    </div>
</body>

</html>