<!DOCTYPE html>
<html>

<head>
    <style>
    .email-container {
        max-width: 600px;
        margin: 0 auto;
        font-family: 'Arial', sans-serif;
        color: #333;
    }

    .header {
        background-color: #4F46E5;
        color: white;
        padding: 20px;
        text-align: center;
        border-radius: 5px 5px 0 0;
    }

    .content {
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 0 0 5px 5px;
    }

    .reminder-box {
        background-color: white;
        border-left: 4px solid #4F46E5;
        padding: 15px;
        margin: 15px 0;
    }

    .reminder-time {
        display: inline-block;
        background-color: #4F46E5;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .footer {
        text-align: center;
        font-size: 12px;
        color: #777;
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h2>Pengingat Jadwal Booking</h2>
        </div>
        <div class="content">
            <p>Halo {{ $userName }},</p>

            <div class="reminder-box">
                <div class="reminder-time">Pengingat {{ $reminderInterval }} sebelumnya</div>
                <p>Anda memiliki jadwal booking pada:</p>
                <h3 style="color: #4F46E5; margin: 10px 0;">{{ $bookingTime }}</h3>
                <p>Jangan sampai terlewat ya!</p>
            </div>

            <p>Terima kasih telah menggunakan layanan kami.</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>