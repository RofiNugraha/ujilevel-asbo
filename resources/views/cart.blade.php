<x-landing-layout>
    <h1
        class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 mt-20 flex justify-center items-center animate-pulse">
        KERANJANG ANDA
    </h1>

    <main class="m-8 flex flex-col items-center">
        <div class="bg-white rounded-3xl shadow-lg w-full max-w-4xl p-8">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h2 class="text-2xl font-semibold">Keranjang Anda</h2>
                <p class="text-gray-500">{{ $cartItems->count() }} barang</p>
            </div>

            <div class="space-y-6">
                @forelse ($cartItems as $item)
                <div class="flex items-center justify-between border-b pb-4">
                    <img src="{{ Storage::url($item->layanan->gambar) }}" alt="Gambar Item"
                        class="w-20 h-20 object-cover rounded-xl">

                    <div class="flex-1 ml-4">
                        <h3 class="font-semibold text-lg">
                            {{ optional($item->layanan)->nama_layanan ?? 'Nama Layanan Tidak Ada' }}
                        </h3>
                        <p class="text-gray-500">
                            {{ $item->produk_id ? optional($item->produk)->deskripsi : optional($item->layanan)->deskripsi }}
                        </p>
                        <p class="text-gray-700">Qty: {{ $item->quantity }}</p>
                    </div>

                    <p class="font-semibold text-xl text-gray-800 mr-2">Rp.
                        {{ number_format($item->layanan->harga * $item->quantity, 0, ',', '.') }}</p>

                    <form action="{{ route('cart.removeItem', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded-full shadow-md hover:bg-red-600 transition">
                            Hapus
                        </button>
                    </form>
                </div>
                @empty
                <p class="text-center text-gray-500">Keranjang Anda kosong.</p>
                @endforelse

                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-lg">Total Harga:</h3>
                    <p class="font-bold text-2xl text-gray-800">Rp.
                        {{ number_format($total, 0, ',', '.') }}</p>
                </div>
            </div>

            @if ($cartItems->isNotEmpty())
            <!-- Peringatan Cek Profil -->
            @if(Auth::check() && (!Auth::user()->name || !Auth::user()->email || !Auth::user()->phone))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-4" role="alert">
                <strong class="font-bold">Profil Tidak Lengkap!</strong>
                <span class="block sm:inline">Anda perlu melengkapi profil Anda sebelum melanjutkan pemesanan.</span>
                <a href="{{ route('profile.edit') }}" class="underline font-semibold">Lengkapi profil Anda di sini</a>
            </div>
            @endif

            <div id="dp-payment-section" class="mt-8 border-t pt-6">
                <h3 class="text-xl font-semibold mb-4">Bayar Uang Muka (DP)</h3>
                <p class="text-gray-600 mb-4">Sebelum melanjutkan ke checkout, silakan bayar uang muka sebesar Rp. 5.000
                </p>

                <div id="dp-form" class="{{ session('dp_paid_now') ? 'hidden' : 'block' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" id="name" name="name"
                                class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" required>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <input type="text" id="phone" name="phone"
                                class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea id="address" name="address" rows="2"
                            class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" required></textarea>
                    </div>

                    <button type="button" id="pay-dp-button"
                        class="bg-blue-500 text-white font-semibold px-6 py-3 rounded-full shadow-md hover:bg-blue-600 transition w-full"
                        {{ (auth()->check() && (!auth()->user()->name || !auth()->user()->email || !auth()->user()->phone)) ? 'disabled' : '' }}>
                        Bayar Uang Muka (Rp. 5.000)
                    </button>
                </div>

                <div id="dp-success" class="{{ session('dp_paid_now') ? 'block' : 'hidden' }}">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        <span class="block sm:inline">Uang muka telah berhasil dibayar.</span>
                        <input type="hidden" id="order_id" name="order_id" value="{{ session('order_id') ?? '' }}">
                    </div>
                </div>
            </div>

            <!-- Form Pemesanan - Hanya tampil setelah pembayaran DP -->
            <div id="booking-section" class="{{ session('dp_paid_now') ? 'block' : 'hidden' }} mt-8 border-t pt-6">
                <h1 class="text-3xl font-semibold text-center text-gray-800 mb-4">Pengisian Data Pemesanan</h1>

                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('booking.store') }}" method="post" id="booking-form">
                    @csrf

                    <!-- Pilihan Tanggal -->
                    <div class="mb-6">
                        <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-2">Pilih
                            Tanggal</label>
                        <input type="date" id="booking_date" name="booking_date"
                            class="block w-full p-2.5 border-2 border-gray-300 rounded-md" min="{{ date('Y-m-d') }}"
                            required>
                    </div>

                    <!-- Tabel Jam dan Kursi -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Pilih Jam & Kursi</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b">Jam</th>
                                        <th class="py-2 px-4 border-b">Kursi 1 (Satu)</th>
                                        <th class="py-2 px-4 border-b">Kursi 2 (Dua)</th>
                                    </tr>
                                </thead>
                                <tbody id="booking-slots">
                                    <!-- Slot waktu akan diisi dinamis -->
                                    <tr>
                                        <td colspan="3" class="py-4 text-center text-gray-500">
                                            Silakan pilih tanggal untuk melihat slot waktu yang tersedia
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Input tersembunyi untuk pengiriman formulir -->
                    <input type="hidden" name="kursi" id="selected_kursi" required>
                    <input type="hidden" name="jam_booking" id="selected_jam_booking" required>

                    @foreach ($cartItems as $index => $item)
                    <input type="hidden" name="items[{{ $index }}][layanan_id]"
                        value="{{ optional($item->layanan)->id }}">
                    <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}">
                    @endforeach

                    <input type="hidden" name="order_id" id="form_order_id" value="{{ session('order_id') ?? '' }}">

                    <div class="bg-white rounded-3xl shadow-lg w-full max-w-4xl mt-8 p-6">
                        <div class="flex mt-6 gap-4">
                            <button type="submit" id="checkout-button"
                                class="bg-green-500 text-white font-semibold px-6 py-3 rounded-full shadow-md hover:bg-green-600 transition w-full opacity-50 cursor-not-allowed"
                                disabled>
                                Lanjutkan ke Checkout
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bg-white rounded-3xl shadow-lg w-full max-w-4xl mt-8 p-6">
                <div class="flex mt-6 gap-4">
                    <a href="{{ route('booking') }}" class="bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-full shadow-md
                                hover:bg-gray-300 transition w-full text-center">
                        Lanjutkan Belanja
                    </a>
                </div>
            </div>
            @else
            <p class="text-red-500">Keranjang Anda kosong!</p>
            @endif
        </div>
    </main>

    <!-- Modal untuk pembayaran loading -->
    <div id="payment-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <div id="snap-container"></div>
        </div>
    </div>

    @if(session('error') || session('success'))
    <div x-data="{ show: true }" x-show="show"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
            @if(session('error'))
            <h2 class="text-lg font-semibold text-red-600">Kesalahan</h2>
            <p class="mt-2 text-red-500">{{ session('error') }}</p>
            @endif

            @if(session('success'))
            <h2 class="text-lg font-semibold text-green-600">Berhasil</h2>
            <p class="mt-2 text-green-500">{{ session('success') }}</p>
            @endif

            <button @click="show = false"
                class="mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Tutup
            </button>
        </div>
    </div>
    @endif

    <!-- Midtrans Script -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const payDpButton = document.getElementById('pay-dp-button');
        const checkoutButton = document.getElementById('checkout-button');
        const paymentModal = document.getElementById('payment-modal');
        const bookingDateInput = document.getElementById('booking_date');
        let transactionData = null;

        // Initialize with today's date
        if (bookingDateInput) {
            bookingDateInput.valueAsDate = new Date();
            fetchAvailableSlots(bookingDateInput.value);
        }

        // Event listener for date change
        if (bookingDateInput) {
            bookingDateInput.addEventListener('change', function() {
                fetchAvailableSlots(this.value);
            });
        }

        // Function to fetch available slots for a date
        function fetchAvailableSlots(date) {
            const tableBody = document.getElementById('booking-slots');

            // Show loading state
            tableBody.innerHTML = `
                <tr>
                    <td colspan="3" class="py-4 text-center text-gray-500">
                        Loading available slots...
                    </td>
                </tr>
            `;

            // Fetch available slots from server
            fetch('{{ route("booking.available-slots") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        date: date
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Clear previous slots
                    tableBody.innerHTML = '';

                    const startHour = 8; // 8 AM
                    const endHour = 20; // 8 PM

                    for (let hour = startHour; hour < endHour; hour++) {
                        const timeString = `${hour.toString().padStart(2, '0')}:00`;
                        const dateTimeString = `${date}T${timeString}:00`;

                        // Check if this slot is available for each chair
                        const chair1Booked = data.booked_slots.some(slot =>
                            slot.kursi === 'satu' &&
                            isTimeInRange(slot.jam_booking, dateTimeString, 60)
                        );

                        const chair2Booked = data.booked_slots.some(slot =>
                            slot.kursi === 'dua' &&
                            isTimeInRange(slot.jam_booking, dateTimeString, 60)
                        );

                        // Create row
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td class="py-3 px-4 border-b">${formatTimeDisplay(hour)}</td>
                        <td class="py-3 px-4 border-b text-center">
                            ${chair1Booked ? 
                                '<span class="px-4 py-2 bg-red-100 text-red-600 rounded">Booked</span>' : 
                                `<button type="button" class="slot-btn px-4 py-2 bg-green-100 text-green-600 rounded hover:bg-green-200" 
                                  data-kursi="satu" data-time="${dateTimeString}">Available</button>`
                            }
                        </td>
                        <td class="py-3 px-4 border-b text-center">
                            ${chair2Booked ? 
                                '<span class="px-4 py-2 bg-red-100 text-red-600 rounded">Booked</span>' : 
                                `<button type="button" class="slot-btn px-4 py-2 bg-green-100 text-green-600 rounded hover:bg-green-200" 
                                  data-kursi="dua" data-time="${dateTimeString}">Available</button>`
                            }
                        </td>
                    `;

                        tableBody.appendChild(row);
                    }

                    // Add event listeners to slot buttons
                    document.querySelectorAll('.slot-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            selectTimeSlot(this);
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching available slots:', error);
                    tableBody.innerHTML = `
                    <tr>
                        <td colspan="3" class="py-4 text-center text-red-500">
                            Error loading available slots. Please try again.
                        </td>
                    </tr>
                `;
                });
        }

        // Helper function to format time display
        function formatTimeDisplay(hour) {
            if (hour === 0) return '12:00 AM';
            if (hour === 12) return '12:00 PM';
            return hour < 12 ? `${hour}:00 AM` : `${hour-12}:00 PM`;
        }

        // Helper function to check if a time is within a range
        function isTimeInRange(bookedTime, checkTime, rangeMinutes) {
            const bookedDate = new Date(bookedTime);
            const checkDate = new Date(checkTime);

            const diffMs = Math.abs(bookedDate - checkDate);
            const diffMinutes = Math.floor(diffMs / 1000 / 60);

            return diffMinutes < rangeMinutes;
        }

        // Function to handle time slot selection
        function selectTimeSlot(button) {
            // Clear previous selections
            document.querySelectorAll('.slot-btn').forEach(btn => {
                btn.classList.remove('bg-blue-500', 'text-white');
                btn.classList.add('bg-green-100', 'text-green-600');
            });

            // Highlight selected slot
            button.classList.remove('bg-green-100', 'text-green-600');
            button.classList.add('bg-blue-500', 'text-white');

            // Update hidden inputs
            document.getElementById('selected_kursi').value = button.dataset.kursi;
            document.getElementById('selected_jam_booking').value = button.dataset.time;

            // Enable checkout button
            checkoutButton.classList.remove('opacity-50', 'cursor-not-allowed');
            checkoutButton.removeAttribute('disabled');
        }

        if (payDpButton) {
            payDpButton.addEventListener('click', function() {
                const name = document.getElementById('name').value;
                const phone = document.getElementById('phone').value;
                const address = document.getElementById('address').value;

                if (!name || !phone || !address) {
                    alert('Please fill in all required fields');
                    return;
                }

                // Show loading
                paymentModal.classList.remove('hidden');

                // Send AJAX request to create order
                fetch('{{ route("order.create") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name: name,
                            phone: phone,
                            address: address,
                            dp: 5000
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.snap_token) {
                            // Simpan data transaksi untuk digunakan nanti
                            transactionData = data;

                            // Open Midtrans Snap
                            window.snap.pay(data.snap_token, {
                                onSuccess: function(result) {
                                    handlePaymentSuccess(data.order_id);
                                },
                                onPending: function(result) {
                                    alert(
                                        'Payment is pending, please complete your payment'
                                    );
                                    // Tambahkan tombol check status
                                    addCheckStatusButton(data.order_id);
                                    paymentModal.classList.add('hidden');
                                },
                                onError: function(result) {
                                    console.error('Payment error:', result);
                                    alert('Payment failed: ' + (result.status_message ||
                                        'Unknown error'));
                                    paymentModal.classList.add('hidden');
                                },
                                onClose: function() {
                                    console.log(
                                        'Customer closed the popup without finishing payment'
                                    );
                                    // Jika pengguna menutup popup, beri opsi untuk cek status
                                    if (transactionData) {
                                        addCheckStatusButton(transactionData.order_id);
                                    }
                                    paymentModal.classList.add('hidden');
                                }
                            });
                        } else {
                            console.error('No snap token received:', data);
                            alert('Failed to create payment: ' + (data.error ||
                                'No token received'));
                            paymentModal.classList.add('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred: ' + error.message);
                        paymentModal.classList.add('hidden');
                    });
            });
        }

        function addCheckStatusButton(orderId) {
            // Cek apakah tombol sudah ada
            if (document.getElementById('check-status-button')) {
                return;
            }

            // Buat tombol cek status
            const checkStatusBtn = document.createElement('button');
            checkStatusBtn.id = 'check-status-button';
            checkStatusBtn.type = 'button';
            checkStatusBtn.className =
                'mt-4 bg-yellow-500 text-white font-semibold px-6 py-3 rounded-full shadow-md hover:bg-yellow-600 transition w-full';
            checkStatusBtn.textContent = 'Check Payment Status';

            checkStatusBtn.addEventListener('click', function() {
                checkPaymentStatus(orderId);
            });

            // Tambahkan tombol ke form
            document.getElementById('dp-form').appendChild(checkStatusBtn);
        }

        function checkPaymentStatus(orderId) {
            const statusBtn = document.getElementById('check-status-button');
            const originalText = statusBtn.textContent;
            statusBtn.textContent = 'Checking...';
            statusBtn.disabled = true;

            fetch('{{ route("payment.check-status") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order_id: orderId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    statusBtn.textContent = originalText;
                    statusBtn.disabled = false;

                    if (data.app_status === 'success') {
                        handlePaymentSuccess(orderId);
                    } else {
                        let message = data.message || 'Payment status unknown';
                        if (data.status === 'not_found') {
                            message = 'Transaction not found. Please try making payment again.';
                        }
                        alert('Payment status: ' + (data.status || 'unknown') + '. ' + message);
                    }
                })
                .catch(error => {
                    statusBtn.textContent = originalText;
                    statusBtn.disabled = false;
                    alert('Error checking payment status: ' + error.message);
                });
        }

        function handlePaymentSuccess(orderId) {
            fetch('{{ route("order.update-status") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order_id: orderId,
                        status: 'Paid'
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Hide payment form and show success message
                        document.getElementById('dp-form').classList.add('hidden');
                        document.getElementById('dp-success').classList.remove('hidden');
                        document.getElementById('booking-section').classList.remove('hidden');

                        // Update order ID in both places
                        document.getElementById('order_id').value = orderId;
                        document.getElementById('form_order_id').value = orderId;

                        paymentModal.classList.add('hidden');

                        // Fetch available slots for today
                        if (bookingDateInput) {
                            fetchAvailableSlots(bookingDateInput.value);
                        }
                    } else {
                        console.error('Failed to update status:', data);
                        alert('Payment successful, but failed to update status');
                        paymentModal.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Payment successful, but an error occurred while updating status: ' + error
                        .message);
                    paymentModal.classList.add('hidden');
                });
        }
    });
    </script>
</x-landing-layout>