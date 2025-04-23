<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@heroicons/vue@2.0.0/dist/heroicons.min.js"></script>
    <title>Edit Profile</title>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .glass {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    </style>
</head>

<body
    class="bg-gradient-to-br from-[#0C102B] via-[#111843] to-[#0E2094] min-h-screen flex items-center justify-center p-4">

    <div class="glass rounded-3xl max-w-3xl w-full p-10 text-white shadow-xl">
        <h1 class="text-4xl font-extrabold text-center mb-10 text-white drop-shadow-lg">✨ Edit Profile</h1>
        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Profile Image -->
            <div class="flex flex-col items-center space-y-2">
                <div class="relative group w-32 h-32">
                    <img id="previewImage"
                        src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : 'https://via.placeholder.com/150' }}"
                        class="w-full h-full rounded-full object-cover border-4 border-white shadow-md transition duration-300" />
                    <label for="image"
                        class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 text-sm text-white rounded-full opacity-0 group-hover:opacity-100 transition cursor-pointer">
                        Change
                    </label>
                </div>
                <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="previewFile()" />
            </div>

            <!-- Input Fields -->
            <div>
                <label for="name" class="block mb-1 font-semibold">👤 Username</label>
                <input type="text" id="name" name="name"
                    class="w-full p-3 rounded-lg bg-white bg-opacity-10 border border-white border-opacity-30 placeholder-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ old('name', auth()->user()->name) }}" placeholder="Enter your username" />
            </div>

            <div>
                <label for="nama_lengkap" class="block mb-1 font-semibold">👤 Full Name</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap"
                    class="w-full p-3 rounded-lg bg-white bg-opacity-10 border border-white border-opacity-30 placeholder-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}"
                    placeholder="Enter your full name" />
            </div>

            <div>
                <label for="phone" class="block mb-1 font-semibold">📱 Phone</label>
                <input type="text" id="phone" name="phone"
                    class="w-full p-3 rounded-lg bg-white bg-opacity-10 border border-white border-opacity-30 placeholder-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ old('phone', auth()->user()->phone) }}" placeholder="Enter your phone number" />
            </div>

            <div>
                <label for="address" class="block mb-1 font-semibold">🏠 Address</label>
                <textarea id="address" name="address"
                    class="w-full p-3 rounded-lg bg-white bg-opacity-10 border border-white border-opacity-30 placeholder-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your address">{{ old('address', auth()->user()->address) }}</textarea>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full py-3 bg-blue-600 hover:bg-blue-700 transition text-white text-lg font-bold rounded-xl shadow-lg transform hover:scale-105">
                💾 Save Changes
            </button>
        </form>

        <script>
        function previewFile() {
            const preview = document.getElementById('previewImage');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src =
                    "{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : 'https://via.placeholder.com/150' }}";
            }
        }
        </script>
    </div>

    <script>
    function previewFile() {
        const input = document.getElementById('profile_image');
        const preview = document.getElementById('previewImage');
        const file = input.files[0];
        const reader = new FileReader();

        reader.addEventListener("load", function() {
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }
    </script>
</body>

</html>