<div class="container">
    <h2>Pembayaran Booking</h2>
    <p>Silakan lakukan pembayaran untuk booking kursi nomor: {{ $bookingData['kursi'] }}</p>

    <form action="{{ route('checkout') }}" method="POST">
        @csrf
        <label for="metode_pembayaran">Pilih Metode Pembayaran:</label>
        <select name="metode_pembayaran" required>
            <option value="transfer">Transfer Bank</option>
            <option value="cod">Cash on Delivery (COD)</option>
        </select>
        <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
    </form>
</div>