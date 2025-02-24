<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_PRODUCTION'),
    'merchant_id'   => env('MIDTRANS_MERCHANT_ID'),
    'is_sanitized' => true,
    'is_3ds' => true,
];