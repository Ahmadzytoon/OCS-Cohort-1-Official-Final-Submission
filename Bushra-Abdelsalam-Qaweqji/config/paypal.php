<?php

return [

    'mode' => env('PAYPAL_MODE', 'sandbox'),

    'sandbox' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'secret' => env('PAYPAL_CLIENT_SECRET'),
        'base_url' => 'https://api-m.sandbox.paypal.com',
    ],

    'live' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'secret' => env('PAYPAL_CLIENT_SECRET'),
        'base_url' => 'https://api-m.paypal.com',
    ],

    'return_url' => env('PAYPAL_RETURN_URL'),
    'cancel_url' => env('PAYPAL_CANCEL_URL'),

    'webhook_id' => env('PAYPAL_WEBHOOK_ID'),
];
