<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com/3.2.0"></script>
    <title>Registrasi</title>
    <style>
        /* General Reset */
        a,
        button,
        input,
        select,
        h1,
        h2,
        h3,
        h4,
        h5,
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            border: none;
            text-decoration: none;
            background: none;
            -webkit-font-smoothing: antialiased;
        }

        menu,
        ol,
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body class="bg-[#795757] min-h-screen flex items-center justify-center">
        <!-- Form Section -->
        <form action="#" method="POST" class="bg-[#cccccc] rounded-[50px] w-[90%] max-w-[1006px] p-8 shadow-lg space-y-4">
            <div class="flex justify-center text-[#000000] font-['Righteous-Regular',_sans-serif] text-2xl md:text-3xl mb-6">
                Registrasi
            </div>
            <!-- Nama Lengkap -->
            <div>
                <label for="fullName" class="text-gray-600 font-['Roboto-Regular',_sans-serif] text-xl">Nama Lengkap</label>
                <input type="text" id="fullName" name="fullName" placeholder="Masukkan Nama Lengkap"
                    class="w-full h-12 p-3 bg-[#d9d9d9] rounded-lg text-base border-2 border-transparent focus:outline-none focus:ring-2 focus:ring-[#795757] focus:border-transparent transition duration-300" />
            </div>

            <!-- Username -->
            <div>
                <label for="username" class="text-gray-600 font-['Roboto-Regular',_sans-serif] text-xl">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan Username"
                    class="w-full h-12 p-3 bg-[#d9d9d9] rounded-lg text-base border-2 border-transparent focus:outline-none focus:ring-2 focus:ring-[#795757] focus:border-transparent transition duration-300" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="text-gray-600 font-['Roboto-Regular',_sans-serif] text-xl">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password"
                    class="w-full h-12 p-3 bg-[#d9d9d9] rounded-lg text-base border-2 border-transparent focus:outline-none focus:ring-2 focus:ring-[#795757] focus:border-transparent transition duration-300" />
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="confirmPassword" class="text-gray-600 font-['Roboto-Regular',_sans-serif] text-xl">Konfirmasi Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Konfirmasi Password"
                    class="w-full h-12 p-3 bg-[#d9d9d9] rounded-lg text-base border-2 border-transparent focus:outline-none focus:ring-2 focus:ring-[#795757] focus:border-transparent transition duration-300" />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit"
                    class="bg-[#795757] text-white rounded-lg w-44 h-12 text-lg hover:bg-[#5e4646] transition duration-300 shadow-md hover:shadow-lg">
                    Registrasi
                </button>
            </div>
        </form>
    </div>

    <script>
        // Example form validation
        document.querySelector('form').addEventListener('submit', function (e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert("Password dan Konfirmasi Password tidak cocok!");
            }
        });
    </script>
</body>

</html>
