<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com/3.2.0"></script>
    <title>Edit Profile</title>
</head>

<body class="bg-gradient-to-b from-[#0C102B] to-[#0E2094] min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl w-full max-w-4xl p-8 shadow-lg relative">
        <h1 class="text-4xl font-bold text-center mb-8">Edit Profile</h1>
        <form action="{{ route('profil.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-lg font-semibold">Name</label>
                <input type="text" id="name" name="name" class="w-full p-3 border border-gray-300 rounded-lg mt-2"
                    value="{{ old('name', auth()->user()->name) }}" />
            </div>
            <div>
                <label for="email" class="block text-lg font-semibold">Email</label>
                <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-lg mt-2"
                    value="{{ old('email', auth()->user()->email) }}" />
            </div>
            <div>
                <label for="nomor_hp" class="block text-lg font-semibold">Phone</label>
                <input type="text" id="nomor_hp" name="nomor_hp"
                    class="w-full p-3 border border-gray-300 rounded-lg mt-2"
                    value="{{ old('phone', auth()->user()->nomor_hp) }}" />
            </div>
            <button type="submit"
                class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center">
                Save Changes
            </button>
        </form>
    </div>
</body>

</html>