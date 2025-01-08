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

<body class="h-screen flex items-center justify-center" style="background-image: url('{{ asset('images/bgd.jpg') }}'); background-size: cover; background-position: center;">
    <div class="bg-[#cccccc] rounded-[50px] w-[90%] max-w-[1006px] p-8 shadow-lg flex flex-col items-center space-y-8">
        <!-- Title -->
        <div class="text-[#000000] font-['Righteous-Regular',_sans-serif] font-bold text-2xl md:text-3xl text-center">
            {{ __('Registrasi') }}
        </div>

        <div class="flex flex-col md:flex-row items-center w-full space-y-6 md:space-y-0 md:space-x-8">
            <form method="POST" action="{{ route('register') }}" class="flex-1 w-full space-y-4">
                @csrf
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-black font-['Roboto-Regular',_sans-serif] text-xl" />
                    <x-text-input id="name" class="w-full h-12 p-3 bg-[#d9d9d9] rounded-lg text-base border-2 border-transparent focus:outline-none focus:ring-2 focus:ring-[#795757] focus:border-transparent transition duration-300" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan Nama Lengkap" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-black font-['Roboto-Regular',_sans-serif] text-xl" />
                    <x-text-input id="email" class="w-full h-12 p-3 bg-[#d9d9d9] rounded-lg text-base border-2 border-transparent focus:outline-none focus:ring-2 focus:ring-[#795757] focus:border-transparent transition duration-300" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Masukkan Email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-black font-['Roboto-Regular',_sans-serif] text-xl" />
                    <x-text-input id="password" class="w-full h-12 p-3 bg-[#d9d9d9] rounded-lg text-base border-2 border-transparent focus:outline-none focus:ring-2 focus:ring-[#795757] focus:border-transparent transition duration-300" type="password" name="password" required autocomplete="new-password" placeholder="Masukkan Password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-black font-['Roboto-Regular',_sans-serif] text-xl" />
                    <x-text-input id="password_confirmation" class="w-full h-12 p-3 bg-[#d9d9d9] rounded-lg text-base border-2 border-transparent focus:outline-none focus:ring-2 focus:ring-[#795757] focus:border-transparent transition duration-300" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi Password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <!-- Submit button -->
                <div class="flex justify-center mt-4">
                    <x-primary-button class="bg-[#212E80] text-white rounded-lg w-44 h-12 text-lg flex items-center justify-center hover:bg-[#212E80] transition duration-300 shadow-md hover:shadow-lg">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
            <div class="w-full md:w-auto">
                <img class="w-full max-w-xs h-auto object-cover" src="{{ asset('images/Logo.png') }}" alt="Logo">
            </div>
        </div>
    </div>
</body>


</html>