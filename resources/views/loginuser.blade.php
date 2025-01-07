<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com/3.2.0"></script>
    <style>
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
    <title>Responsive Login Page</title>
</head>

<body class="bg-[#795757] h-screen flex items-center justify-center">
    <form class="bg-[#cccccc] rounded-[50px] w-[90%] max-w-[1006px] p-5 md:p-10 flex flex-col md:flex-row items-center justify-between shadow-lg">
        <!-- Left side - Form -->
        <div class="flex flex-col items-center justify-center w-full md:w-1/2 p-4">
            <h1 class="text-4xl font-['Righteous-Regular',_sans-serif] mb-6 text-center">LOGIN</h1>

            <div class="w-full max-w-md mb-4">
                <input type="text" placeholder="Username" class="w-full h-12 bg-[#d9d9d9] rounded px-4 text-lg focus:outline-none">
            </div>

            <div class="w-full max-w-md mb-4">
                <input type="password" placeholder="Password" class="w-full h-12 bg-[#d9d9d9] rounded px-4 text-lg focus:outline-none">
            </div>

            <button class="bg-[#795757] text-white rounded-lg w-32 h-12 text-xl">LOGIN</button>

            <p class="text-lg mt-4 text-center">Or sign in with</p>
            <div class="flex items-center mt-3 justify-center">
                <div class="border-t border-black w-24"></div>
                <img  src="{{ asset('images/google.png') }}" alt="Google" class="w-6 h-6 mx-4">
                <div class="border-t border-black w-24"></div>
            </div>

            <p class="text-lg mt-4 text-center">
                Belum memiliki akun? <a href="{{ route('regis') }}" class="text-blue-500">Buat akun</a>
            </p>
        </div>

        <!-- Right side - Logo -->
        <div class="w-full md:w-1/2 flex justify-center items-center mt-6 md:mt-0 p-4">
            <img class="w-3/4 max-w-xs h-auto object-cover" src="{{ asset('images/Logo.png') }}" alt="Logo">
        </div>
    </form>
</body>

</html>
