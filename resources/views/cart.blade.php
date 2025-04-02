<x-landing-layout>
    <h1
        class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 mt-20 flex justify-center items-center animate-pulse">
        KERANJANG ANDA
    </h1>

    <main class="m-8 flex flex-col items-center">
        <div class="bg-white rounded-3xl shadow-lg w-full max-w-4xl p-8">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h2 class="text-2xl font-semibold">Your Cart</h2>
                <p class="text-gray-500">{{ $cartItems->count() }} items</p>
            </div>

            <div class="space-y-6">
                @forelse ($cartItems as $item)
                <div class="flex items-center justify-between border-b pb-4">
                    <img src="{{ Storage::url($item->layanan->gambar) }}" alt="Item Image"
                        class="w-20 h-20 object-cover rounded-xl">

                    <div class="flex-1 ml-4">
                        <h3 class="font-semibold text-lg">
                            {{ optional($item->layanan)->nama_layanan ?? 'No Service Name' }}
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
                            Remove
                        </button>
                    </form>
                </div>
                @empty
                <p class="text-center text-gray-500">Your cart is empty.</p>
                @endforelse

                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-lg">Total Price:</h3>
                    <p class="font-bold text-2xl text-gray-800">Rp.
                        {{ number_format($total, 0, ',', '.') }}</p>
                </div>
            </div>

            @if ($cartItems->isNotEmpty())
            <div id="dp-payment-section" class="mt-8 border-t pt-6">
                <h3 class="text-xl font-semibold mb-4">Pay Down Payment (DP)</h3>
                <p class="text-gray-600 mb-4">Before proceeding to checkout, please pay a down payment of Rp. 5.000</p>

                <div id="dp-form" class="{{ session('dp_paid') ? 'hidden' : 'block' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" id="name" name="name"
                                class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" required>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" id="phone" name="phone"
                                class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea id="address" name="address" rows="2"
                            class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" required></textarea>
                    </div>

                    <button type="button" id="pay-dp-button"
                        class="bg-blue-500 text-white font-semibold px-6 py-3 rounded-full shadow-md hover:bg-blue-600 transition w-full">
                        Pay Down Payment (Rp. 5.000)
                    </button>
                </div>

                <div id="dp-success" class="{{ session('dp_paid') ? 'block' : 'hidden' }}" x-data="{}">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        <span class="block sm:inline">Down payment has been successfully paid.</span>
                        <input type="hidden" id="order_id" name="order_id" value="{{ session('order_id') ?? '' }}">
                    </div>
                </div>
            </div>

            <h1 class="text-3xl font-semibold text-center text-gray-800 mb-4 mt-8">Pengisian Data Customer</h1>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('booking.store') }}" method="post" id="booking-form">
                @csrf
                <div class="mb-4">
                    <label for="kursi" class="block text-sm font-medium text-gray-700">Kursi</label>
                    <select name="kursi" id="kursi" class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md"
                        required>
                        <option value="">Pilih Kursi</option>
                        <option value="satu">Satu</option>
                        <option value="dua">Dua</option>
                    </select>
                    @error('kursi')
                    <small class="text-red-500 text-xs">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="jam_booking" class="block text-sm font-medium text-gray-700">Jam Booking</label>
                    <input type="datetime-local" name="jam_booking" id="jam_booking"
                        class="mt-1 block w-full p-2.5 border-2 border-gray-300 rounded-md" required>
                    @error('jam_booking')
                    <small class="text-red-500 text-xs">{{ $message }}</small>
                    @enderror
                </div>

                @foreach ($cartItems as $index => $item)
                <input type="hidden" name="items[{{ $index }}][layanan_id]" value="{{ optional($item->layanan)->id }}">
                <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}">
                @endforeach

                <input type="hidden" name="order_id" id="form_order_id" value="{{ session('order_id') ?? '' }}">

                <div class="bg-white rounded-3xl shadow-lg w-full max-w-4xl mt-8 p-6">
                    <div class="flex mt-6 gap-4">
                        <button type="submit" id="checkout-button"
                            class="bg-green-500 text-white font-semibold px-6 py-3 rounded-full shadow-md hover:bg-green-600 transition w-full {{ session('dp_paid') ? '' : 'opacity-50 cursor-not-allowed' }}"
                            {{ session('dp_paid') ? '' : 'disabled' }}>
                            Proceed to Checkout
                        </button>
                        <a href="{{ route('booking') }}" class="bg-gray-200 text-gray-700 font-semibold px-6 py-3 rounded-full shadow-md
                            hover:bg-gray-300 transition w-full text-center">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </form>
            @else
            <p class="text-red-500">Keranjang Anda kosong!</p>
            @endif
        </div>
    </main>

    <!-- Modal for payment loading -->
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
            <h2 class="text-lg font-semibold text-red-600">Error</h2>
            <p class="mt-2 text-red-500">{{ session('error') }}</p>
            @endif

            @if(session('success'))
            <h2 class="text-lg font-semibold text-green-600">Success</h2>
            <p class="mt-2 text-green-500">{{ session('success') }}</p>
            @endif

            <button @click="show = false"
                class="mt-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Close
            </button>
        </div>
    </div>
    @endif

    <!-- Midtrans Script -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const payDpButton = document.getElementById('pay-dp-button');
        const checkoutButton = document.getElementById('checkout-button');
        const paymentModal = document.getElementById('payment-modal');
        let transactionData = null;

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
            // Show loading
            const statusBtn = document.getElementById('check-status-button');
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
                    statusBtn.textContent = 'Check Payment Status';
                    statusBtn.disabled = false;

                    if (data.success) {
                        handlePaymentSuccess(orderId);
                    } else {
                        alert('Payment status: ' + data.status + '. ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error checking status:', error);
                    statusBtn.textContent = 'Check Payment Status';
                    statusBtn.disabled = false;
                    alert('Error checking payment status: ' + error.message);
                });
        }

        function handlePaymentSuccess(orderId) {
            // Update the UI to show success message
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
                        document.getElementById('dp-form').classList.add('hidden');
                        document.getElementById('dp-success').classList.remove('hidden');
                        document.getElementById('order_id').value = orderId;
                        document.getElementById('form_order_id').value = orderId;

                        // Enable checkout button
                        checkoutButton.classList.remove('opacity-50', 'cursor-not-allowed');
                        checkoutButton.removeAttribute('disabled');

                        paymentModal.classList.add('hidden');
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