<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com/3.2.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.all.min.js"></script>
    @include('partials.sweetalert');
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

<body class="h-screen flex items-center justify-center"
    style="background-image: url('{{ asset('images/bgd.jpg') }}'); background-size: cover; background-position: center;">
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
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-black text-xl" />
                    <x-text-input id="name" class="w-full h-12 p-3 bg-[#d9d9d9] rounded-lg" type="text" name="name"
                        :value="old('name')" autofocus placeholder="Masukan Nama Lengkap" />
                    @error('name')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message == 'validation.required' ? 'Nama harus diisi.' : $message }}
                    </p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-black text-xl" />
                    <x-text-input id="email" class="w-full h-12 p-3 bg-[#d9d9d9] rounded-lg" type="email" name="email"
                        :value="old('email')" placeholder="Masukan Email" />
                    @error('email')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message == 'validation.required' ? 'Email harus diisi.' : ($message == 'validation.email' ? 'Format email tidak valid.' : $message) }}
                    </p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-black text-xl" />
                    <x-text-input id="password" class="w-full h-12 p-3 bg-[#d9d9d9] rounded-lg" type="password"
                        name="password" placeholder="Masukan Password" />
                    @error('password')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message == 'validation.required' ? 'Password harus diisi.' : $message }}
                    </p>
                    @enderror
                    <p class="text-sm text-gray-700 mt-1">
                        Password harus minimal 8 karakter dan cocok dengan konfirmasi password.
                    </p>
                </div>

                <!-- Password Confirmation -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')"
                        class="text-black text-xl" />
                    <x-text-input id="password_confirmation" class="w-full h-12 p-3 bg-[#d9d9d9] rounded-lg"
                        type="password" name="password_confirmation" placeholder="Konfirmasi Password" />
                    @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message == 'validation.confirmed' ? 'Konfirmasi password tidak cocok.' : $message }}
                    </p>
                    @enderror
                    <p class="text-sm text-gray-700 mt-1">
                        Password harus minimal 8 karakter dan cocok dengan konfirmasi password.
                    </p>
                </div>


                <!-- Submit button -->
                <div class="flex justify-center mt-4">
                    <x-primary-button
                        class="bg-[#212E80] text-white rounded-lg w-44 h-12 text-lg flex items-center justify-center hover:bg-[#212E80] transition duration-300 shadow-md hover:shadow-lg">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
            <div class="w-full md:w-auto">
                <img class="w-full max-w-xs h-auto object-cover" src="{{ asset('images/Logo.png') }}" alt="Logo">
            </div>
        </div>
    </div>

    <script>
    if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('
            success ') }}',
            confirmButtonColor: '#212E80',
        });
    endif

    if ($errors - > any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: `
                <ul class="text-left">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
            confirmButtonColor: '#212E80',
        });
    endif
    </script>
</body>


</html>