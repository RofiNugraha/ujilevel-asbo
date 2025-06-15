@auth
<x-landing-layout>
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
    </style>

    <div class="image-container relative w-full h-screen bg-cover bg-center flex items-center justify-center">
        <div class="container text-center p-8 rounded-lg">
            <h1
                class="text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-200 via-white to-gray-300 animate-pulse">
                Selamat Datang di Barbershop Kami!
            </h1>
            <p class="mt-6 text-xl text-gray-200">Rasakan layanan potong rambut dan perawatan terbaik.</p>
            <div class="mt-8">
                <a href="{{ route('booking') }}"
                    class="px-6 py-3 text-lg font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-calendar-check mr-2"></i>Buat Janji Sekarang
                </a>
            </div>
        </div>
    </div>

    <div class="min-h-screen bg-[#1C1C1C]">
        <!-- Contact Section -->
        <section id="contact" class="py-16">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-4xl font-bold text-white">Hubungi Kami</h2>
                <p class="mt-4 text-gray-300">Kami senang mendengar dari Anda! Hubungi kami kapan saja.</p>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Contact Info -->
                    <div class="bg-[#2F2F2F] p-6 rounded-lg shadow-lg text-left">
                        @if($siteCustom)
                        <div class="bg-[#2F2F2F] p-6 rounded-lg shadow-lg text-left">
                            <h3 class="text-2xl font-bold text-white">Alamat Kami</h3>
                            <p class="text-gray-300 mt-2"><i
                                    class="fas fa-map-marker-alt mr-2"></i>{{ $siteCustom->alamat }}</p>

                            <h3 class="text-2xl font-bold text-white mt-6">Telepon</h3>
                            <p class="text-gray-300 mt-2"><i class="fas fa-phone-alt mr-2"></i>{{ $siteCustom->no_hp }}
                            </p>

                            <h3 class="text-2xl font-bold text-white mt-6">Email</h3>
                            <p class="text-gray-300 mt-2"><i class="fas fa-envelope mr-2"></i>{{ $siteCustom->email }}
                            </p>

                            <h3 class="text-2xl font-bold text-white mt-6">Jam Operasional</h3>
                            <p class="text-gray-300 mt-2"><i
                                    class="fas fa-clock mr-2"></i>{{ $siteCustom->jam_operasional }}
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Contact Form -->
                    <div class="bg-[#2F2F2F] p-6 rounded-lg shadow-lg text-left">
                        <h3 class="text-2xl font-bold text-white text-center">Berikan Penilaian Layanan Kami</h3>
                        <form action="{{ route('contact.store') }}" method="post" class="mt-4 space-y-4">
                            @csrf
                            <input type="number" id="rating-input" name="rating" min="1" max="5" step="1"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                placeholder="Masukkan angka (1 - 5)" oninput="updateStars(this.value)" hidden>
                            <label class="text-white block">Rate Layanan Kami:</label>

                            <div class="flex space-x-1 mb-2" id="rating-container">
                                <span class="cursor-pointer text-gray-500 text-2xl" data-value="1"
                                    onclick="setRating(1)">&#9733;</span>
                                <span class="cursor-pointer text-gray-500 text-2xl" data-value="2"
                                    onclick="setRating(2)">&#9733;</span>
                                <span class="cursor-pointer text-gray-500 text-2xl" data-value="3"
                                    onclick="setRating(3)">&#9733;</span>
                                <span class="cursor-pointer text-gray-500 text-2xl" data-value="4"
                                    onclick="setRating(4)">&#9733;</span>
                                <span class="cursor-pointer text-gray-500 text-2xl" data-value="5"
                                    onclick="setRating(5)">&#9733;</span>
                            </div>

                            <textarea name="feedback" rows="5" placeholder="Masukkan Umpan Balik Anda"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>

                            <button type="submit"
                                class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold text-lg transition"><i
                                    class="fas fa-paper-plane mr-2"></i>Kirim Penilaian</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
    function setRating(rating) {
        document.getElementById('rating-input').value = rating;
        updateStars(rating);
    }

    function updateStars(rating) {
        let stars = document.querySelectorAll('#rating-container span');
        stars.forEach((star) => {
            let starValue = parseFloat(star.getAttribute('data-value'));
            if (rating >= starValue) {
                star.classList.add('text-yellow-500');
                star.classList.remove('text-gray-500');
            } else {
                star.classList.add('text-gray-500');
                star.classList.remove('text-yellow-500');
            }
        });
    }
    </script>
</x-landing-layout>
@endauth


@guest
<x-admin.home-layout>
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
        /* Dark overlay with 40% opacity */
        z-index: 1;
    }

    .image-container>* {
        position: relative;
        z-index: 2;
    }
    </style>
    <div class="image-container relative w-full h-screen bg-cover bg-center flex items-center justify-center">
        <div class="container text-center p-8 rounded-lg">
            <h1
                class="text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 animate-pulse">
                Welcome to Our Barbershop!
            </h1>
            <p class="mt-6 text-xl text-gray-200">Experience the best haircut and grooming services.</p>
            <div class="mt-8">
                <a href="#booking"
                    class="px-6 py-3 text-lg font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700">
                    Book an Appointment
                </a>
            </div>
        </div>
    </div>
    <div class="min-h-scrbg-[#1C1C1C] items-center justify-center" style="heigh: 100px;">
        <!-- Contact Section -->
        <section id="contact" class="py-16">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-4xl font-bold text-[gold]">Contact Us</h2>
                <p class="mt-4 text-gray-300">We'd love to hear from you! Reach out to us anytime.</p>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Contact Info -->
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg text-left">
                        <h3 class="text-2xl font-bold text-[gold]">Our Address</h3>
                        <p class="text-gray-300 mt-2">Jl. Barber No. 10, Jakarta, Indonesia</p>

                        <h3 class="text-2xl font-bold text-[gold] mt-6">Phone</h3>
                        <p class="text-gray-300 mt-2">+62 812 3456 7890</p>

                        <h3 class="text-2xl font-bold text-[gold] mt-6">Email</h3>
                        <p class="text-gray-300 mt-2">info@barbershop.com</p>

                        <h3 class="text-2xl font-bold text-[gold] mt-6">Opening Hours</h3>
                        <p class="text-gray-300 mt-2">Monday - Sunday: 10:00 AM - 9:00 PM</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-admin.home-layout>
@endguest