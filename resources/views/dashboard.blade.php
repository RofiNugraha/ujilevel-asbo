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
        /* Dark overlay with 40% opacity */
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

        <!-- Services Section -->
        <section id="services" class="py-16 bg-black">
            <div class="container mx-auto px-6 text-center m-4">
                <h2 class="text-4xl font-bold text-[gold]">Our Services</h2>
                <p class="mt-4 text-gray-300">We provide top-quality grooming services for men.</p>
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 bg-gray-50 rounded-lg shadow-lg">
                        <img src="{{ asset('images/haircut.jpg') }}" alt="Pomade"
                            class="w-full h-40 object-cover rounded-lg">
                        <h3 class="text-2xl font-bold text-gray-800 mt-4">Potong Rambut</h3>
                    </div>
                    <div class="p-6 bg-gray-50 rounded-lg shadow-lg">
                        <img src="{{ asset('images/semir.jpg') }}" alt="Pomade"
                            class="w-full h-40 object-cover rounded-lg">
                        <h3 class="text-2xl font-bold text-gray-800 mt-4">Semir Rambut</h3>
                    </div>
                    <div class="p-6 bg-gray-50 rounded-lg shadow-lg">
                        <img src="{{ asset('images/pijat.jpg') }}" alt="Pomade"
                            class="w-full h-40 object-cover rounded-lg">
                        <h3 class="text-2xl font-bold text-gray-800 mt-4">Pijat Kepala</h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- Catalog Section -->
        <section id="catalog" class="py-16 bg-black">
            <div class="container mx-auto px-6 text-center m-4">
                <h2 class="text-4xl font-bold text-[gold]">Our Products</h2>
                <p class="mt-4 text-gray-300">Discover our range of grooming products.</p>
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 bg-gray-200 rounded-lg shadow-lg">
                        <img src="{{ asset('images/pomade.jpg') }}" alt="Pomade"
                            class="w-full h-40 object-cover rounded-lg">
                        <h3 class="mt-4 text-2xl font-bold text-gray-800">Pomade</h3>
                        <p class="mt-2 text-gray-600">Tampil rapi dan stylish dengan daya tahan maksimal</p>
                    </div>
                    <div class="p-6 bg-gray-200 rounded-lg shadow-lg">
                        <img src="{{ asset('images/vit.jpg') }}" alt="Beard Oil"
                            class="w-full h-40 object-cover rounded-lg">
                        <h3 class="mt-4 text-2xl font-bold text-gray-800">Vitamin Rambut</h3>
                        <p class="mt-2 text-gray-600">Nutrisi terbaik untuk rambut sehat dan berkilau</p>
                    </div>
                    <div class="p-6 bg-gray-200 rounded-lg shadow-lg">
                        <img src="{{ asset('images/produk.jpg') }}" alt="Shaving Cream"
                            class="w-full h-40 object-cover rounded-lg">
                        <h3 class="mt-4 text-2xl font-bold text-gray-800">Creambath</h3>
                        <p class="mt-2 text-gray-600">Perawatan intensif untuk rambut lembut dan segar</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Booking Section -->
    </div>
    <div class="min-h-screen bg-black">
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

                    <!-- Contact Form -->
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg text-left">
                        <h3 class="text-2xl font-bold text-[gold]">Send Us a Message</h3>
                        <form action="" method="post" class="mt-4 space-y-4">
                            <input type="text" name="name" placeholder="Your Name"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500">

                            <input type="email" name="email" placeholder="Your Email"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500">

                            <textarea name="message" rows="5" placeholder="Your Message"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>

                            <button type="submit"
                                class="w-full bg-yellow-500 text-white px-6 py-3 rounded-lg font-semibold text-lg hover:bg-yellow-600 transition">Send
                                Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="container mx-auto my-10 px-4">
        <div class="relative flex items-center">
            <button class="absolute left-0 z-10 p-2 bg-gray-200 rounded-full shadow-md hover:bg-gray-300"
                onclick="scrollLeft()">❮</button>
            <div id="reviewCarousel" class="flex overflow-x-auto gap-4 scrollbar-hide scroll-smooth">
                <div class="min-w-[250px] bg-white shadow-lg rounded-lg p-4 flex flex-col items-center text-center">
                    <img src="{{ asset('images/google.png') }}" class="w-20 h-20 rounded-full object-cover">
                    <h5 class="mt-3 font-semibold text-lg">John Doe</h5>
                    <p class="mt-2 text-gray-600 min-h-[60px]">This is an amazing service! Highly recommended.</p>
                    <div class="text-yellow-500 mt-2">
                        ⭐⭐⭐⭐⭐
                    </div>
                </div>
            </div>
            <button class="absolute right-0 z-10 p-2 bg-gray-200 rounded-full shadow-md hover:bg-gray-300"
                onclick="scrollRight()">❯</button>
        </div>
    </div>

</x-landing-layout>