<x-landing-layout>
    @include('partials.sweetalert')
    <style>
    .image-container {
        height: 550px;
        background: url('{{ asset('images/asgar.jpg') }}') no-repeat center center;
        background-size: cover;
        position: relative;
    }

    .image-container::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        z-index: 1;
    }

    .image-container>* {
        position: relative;
        z-index: 2;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    </style>

    <div class="min-h-screen bg-black from-gray-50 to-gray-200">
        <!-- Hero Section -->
        <div class="image-container relative w-full h-screen bg-cover bg-center flex items-center justify-center">
            <div class="container text-center p-8 rounded-lg">
                <h1
                    class="text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 animate-pulse">
                    </i>Selamat Datang di Barbershop Kami!
                </h1>
                <p class="mt-6 text-xl text-gray-200"></i>Rasakan layanan potong rambut dan perawatan terbaik.
                </p>
                <div class="mt-8">
                    <a href="{{ route('booking') }}"
                        class="px-6 py-3 text-lg font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-calendar-check mr-2"></i>Buat Janji Sekarang
                    </a>
                </div>
            </div>
        </div>


        <!-- Contact Section -->
        <div class="min-h-screen bg-black">
            <section id="contact" class="py-16">
                <div class="container mx-auto px-6 text-center">
                    <h2 class="text-4xl font-bold text-[gold]">Hubungi Kami</h2>
                    <p class="mt-4 text-gray-300">Kami senang mendengar dari Anda! Hubungi kami kapan saja.</p>

                    <div class="mt-8 flex justify-center">
                        <div
                            class="bg-gray-800 p-6 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 items-center gap-2 max-w-4xl w-full">
                            <!-- Informasi (Kiri) -->
                            <div class="bg-gray-800 p-6 rounded-lg shadow-lg text-left">
                                <h3 class="text-2xl font-bold text-[gold]">Alamat Kami</h3>
                                <p class="text-gray-300 mt-2"><i class="fas fa-map-marker-alt mr-2"></i>Jl. Barber No.
                                    10,
                                    Jakarta, Indonesia</p>

                                <h3 class="text-2xl font-bold text-[gold] mt-6">Telepon</h3>
                                <p class="text-gray-300 mt-2"><i class="fas fa-phone-alt mr-2"></i>+62 812 3456 7890</p>

                                <h3 class="text-2xl font-bold text-[gold] mt-6">Email</h3>
                                <p class="text-gray-300 mt-2"><i class="fas fa-envelope mr-2"></i>info@barbershop.com
                                </p>

                                <h3 class="text-2xl font-bold text-[gold] mt-6">Jam Operasional</h3>
                                <p class="text-gray-300 mt-2"><i class="fas fa-clock mr-2"></i>Senin - Minggu: 10:00 -
                                    21:00
                                </p>
                            </div>

                            <!-- Logo (Kanan) -->
                            <div class="flex justify-center md:justify-end">
                                <img src="{{ asset('images/logogold.png') }}" alt="Logo Barbershop"
                                    class="h-80 w-full object-contain">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- In your dashboard view -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if the URL has the show_welcome parameter
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('show_welcome')) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Login berhasil! Selamat datang kembali.',
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

                // Clean up the URL by removing the parameter (optional)
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
        </script>
</x-landing-layout>