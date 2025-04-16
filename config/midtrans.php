<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', 'G257383347'),
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-Y97L1qTRynijJhbW'),
    'server_key' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-TFSXzdULglkkm8WduuYCu_US'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => true,
    'is_3ds' => true,
];