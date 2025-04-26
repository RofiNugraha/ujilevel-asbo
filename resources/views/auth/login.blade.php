<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com/3.2.0"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.all.min.js"></script>
    <title>Halaman Login Responsif</title>
    <style>
    /* Custom SweetAlert styles for white and yellow theme */
    .custom-swal-container {
        background-color: rgba(255, 255, 255, 0.9);
    }

    .custom-swal-popup {
        background-color: white;
        border: 2px solid #FFD700;
        border-radius: 20px;
    }

    .custom-swal-title {
        color: #212E80;
    }

    .custom-swal-content {
        color: #333;
    }

    .custom-swal-confirm {
        background-color: #FFD700 !important;
        color: #212E80 !important;
        border-radius: 10px !important;
        font-weight: bold !important;
    }

    .custom-swal-cancel {
        background-color: #f1f1f1 !important;
        color: #333 !important;
        border-radius: 10px !important;
    }
    </style>
</head>

<body class="bg-cover bg-center bg-no-repeat h-screen flex items-center justify-center"
    style="background-image: url('{{ asset('images/bgd.jpg') }}'); background-size: cover; background-position: center;">
    <form method="POST" action="{{ route('login') }}" id="loginForm"
        class="bg-[#cccccc] rounded-[50px] w-[90%] max-w-[1006px] p-5 md:p-10 flex flex-col md:flex-row items-center justify-between shadow-lg">
        @csrf
        <!-- Laravel directive untuk perlindungan CSRF -->

        <!-- Sisi kiri - Form -->
        <div class="flex flex-col items-center justify-center w-full md:w-1/2 p-4">
            <h1 class="text-4xl font-['Righteous-Regular',_sans-serif] font-bold mb-6 text-center">LOGIN</h1>

            <!-- Input Email -->
            <div class="w-full max-w-md mb-4">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Masukan Email"
                    class="w-full h-12 bg-[#d9d9d9] rounded px-4 text-lg focus:outline-none @error('email') border-red-500 @enderror">
                @error('email')
                <span class="text-red-500 text-sm">
                    {{ $message == 'validation.required' ? 'Email harus diisi' : 'Email tidak valid atau tidak terdaftar' }}
                </span>
                @enderror
            </div>

            <!-- Input Password -->
            <div class="w-full max-w-md mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukan Password"
                    class="w-full h-12 bg-[#d9d9d9] rounded px-4 text-lg focus:outline-none @error('password') border-red-500 @enderror">
                @error('password')
                <span class="text-red-500 text-sm">
                    {{ $message == 'validation.required' ? 'Kata sandi harus diisi' : 'Kata sandi salah atau tidak sesuai' }}
                </span>
                @enderror
                <p class="text-sm text-gray-700 mt-1">
                    Password harus minimal 8 karakter dan cocok dengan konfirmasi password.
                </p>
            </div>

            <!-- Tombol Login -->
            <button type="button" id="loginButton"
                class="bg-[#212E80] text-white rounded-lg w-32 h-12 text-xl">LOGIN</button>

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('auth.google') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M21.35,11.1H12.18V13.83H18.69C18.36,15.64 17.5,17 16.24,17.83C15.24,18.5 13.94,18.89 12.18,18.89C9.03,18.89 6.39,16.81 5.51,13.83H2.82C3.72,17.75 7.57,20.67 12.18,20.67C15.22,20.67 17.66,19.67 19.38,17.83C21.02,16.09 21.91,13.83 21.91,11.1C21.91,10.41 21.82,9.76 21.65,9.1L21.35,11.1M12.18,3.33C13.9,3.33 15.55,3.97 16.86,5.21L19.12,2.95C17.19,1.13 14.83,0 12.18,0C7.57,0 3.72,2.92 2.82,6.83H5.51C6.39,4.03 9.03,1.95 12.18,1.95" />
                    </svg>
                    Login with Google
                </a>
            </div>

            <!-- Tautan Daftar -->
            <p class="text-lg mt-4 text-center">
                Belum punya akun? <a href="{{ route('register') }}" class="text-blue-500">Daftar sekarang</a>
            </p>
        </div>

        <!-- Sisi kanan - Logo -->
        <div class="w-full md:w-1/2 flex justify-center items-center mt-6 md:mt-0 p-4">
            <img class="w-3/4 max-w-xs h-auto object-cover" src="{{ asset('images/Logo.png') }}" alt="Logo">
        </div>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Flash message dari Laravel
        @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('
            success ') }}',
            icon: 'success',
            customClass: {
                container: 'custom-swal-container',
                popup: 'custom-swal-popup',
                title: 'custom-swal-title',
                content: 'custom-swal-content',
                confirmButton: 'custom-swal-confirm'
            },
            buttonsStyling: false
        });
        @endif

        @if(session('error'))
        Swal.fire({
            title: 'Gagal!',
            text: '{{ session('
            error ') }}',
            icon: 'error',
            customClass: {
                container: 'custom-swal-container',
                popup: 'custom-swal-popup',
                title: 'custom-swal-title',
                content: 'custom-swal-content',
                confirmButton: 'custom-swal-confirm'
            },
            buttonsStyling: false
        });
        @endif

        // Validasi Login
        document.getElementById('loginButton').addEventListener('click', function() {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();

            if (!email || !password) {
                Swal.fire({
                    title: 'Perhatian!',
                    text: 'Email dan password harus diisi.',
                    icon: 'warning',
                    customClass: {
                        container: 'custom-swal-container',
                        popup: 'custom-swal-popup',
                        title: 'custom-swal-title',
                        content: 'custom-swal-content',
                        confirmButton: 'custom-swal-confirm'
                    },
                    buttonsStyling: false
                });
            } else {
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang memverifikasi data login Anda',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    customClass: {
                        container: 'custom-swal-container',
                        popup: 'custom-swal-popup',
                        title: 'custom-swal-title',
                        content: 'custom-swal-content'
                    }
                });

                // Submit form
                document.getElementById('loginForm').submit();
            }
        });
    });
    </script>

</body>

</html>