<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com/3.2.0"></script>
    <title>Responsive Login Page</title>
</head>

<body class="bg-cover bg-center bg-no-repeat h-screen flex items-center justify-center" style="background-image: url('{{ asset('images/bgd.jpg') }}'); background-size: cover; background-position: center;">
    <form method="POST" action="{{ route('login') }}" class="bg-[#cccccc] rounded-[50px] w-[90%] max-w-[1006px] p-5 md:p-10 flex flex-col md:flex-row items-center justify-between shadow-lg">
        @csrf <!-- Laravel directive for CSRF protection -->

        <!-- Left side - Form -->
        <div class="flex flex-col items-center justify-center w-full md:w-1/2 p-4">
            <h1 class="text-4xl font-['Righteous-Regular',_sans-serif] font-bold mb-6 text-center">LOGIN</h1>

            <!-- Email input -->
            <div class="w-full max-w-md mb-4">
                <input type="email" name="email" placeholder="Email" required
                    class="w-full h-12 bg-[#d9d9d9] rounded px-4 text-lg focus:outline-none @error('email') border-red-500 @enderror">
                @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password input -->
            <div class="w-full max-w-md mb-4">
                <input type="password" name="password" placeholder="Password" required
                    class="w-full h-12 bg-[#d9d9d9] rounded px-4 text-lg focus:outline-none @error('password') border-red-500 @enderror">
                @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit button -->
            <button type="submit" class="bg-[#212E80] text-white rounded-lg w-32 h-12 text-xl">LOGIN</button>

            <!-- Additional options -->
            <div class="flex items-center mt-3 justify-center align-items-center">
                <div class="border-t border-black w-24"></div>
                <p class="text-lg ml-4">Or sign in with</p>
                <img src="{{ asset('images/google.png') }}" alt="Google" class="w-6 h-6 mr-4">
                <div class="border-t border-black w-24"></div>
            </div>

            <!-- Register link -->
            <p class="text-lg mt-4 text-center">
                Belum memiliki akun? <a href="{{ route('register') }}" class="text-blue-500">Buat akun</a>
            </p>
        </div>

        <!-- Right side - Logo -->
        <div class="w-full md:w-1/2 flex justify-center items-center mt-6 md:mt-0 p-4">
            <img class="w-3/4 max-w-xs h-auto object-cover" src="{{ asset('images/Logo.png') }}" alt="Logo">
        </div>
    </form>
</body>

</html>
