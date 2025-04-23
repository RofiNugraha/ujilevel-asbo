<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', 'G251811598'),
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-ai36iqTIQ7pL8k9J'),
    'server_key' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-Kkx4B5jstQCb8vakIhrHBM4N'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => true,
    'is_3ds' => true,
];