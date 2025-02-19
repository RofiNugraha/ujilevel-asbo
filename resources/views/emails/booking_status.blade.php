<!DOCTYPE html>
<html>

<head>
    <title>Update Status Booking</title>
</head>

<body>
    <p>Halo, {{ $booking->user->name }}!</p>
    <p>{{ $pesan }}</p>
    <p>Detail Booking:</p>
    <ul>
        <li>ID Booking: {{ $booking->id }}</li>
        <li>Jadwal: {{ $booking->jam_booking }}</li>
        <li>Kursi: {{ $booking->kursi }}</li>
    </ul>
    <p>Terima kasih telah menggunakan layanan kami.</p>
</body>

</html>