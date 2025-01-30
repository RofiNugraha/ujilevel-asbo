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
    </style>
    <div class="image-container flex items-center justify-center text-center px-6 md:px-12">
        <div class="max-w-2xl">
            <h1 class="text-4xl md:text-6xl font-extrabold text-yellow-500 animate-pulse">
                Welcome to Our Barbershop!
            </h1>
            <p class="mt-4 text-lg md:text-xl text-gray-200">Experience the best haircut and grooming services.</p>
            <a href="#booking"
                class="mt-6 inline-block px-6 py-3 text-lg font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700">
                Book an Appointment
            </a>
        </div>
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

</x-landing-layout>