<?php

return [
    'coinbase' => [
        'api_key' => env('COINBASE_API_KEY'),
        'secret_key' => env('COINBASE_SECRET_KEY'),
    ],
    'coinbase_pro' => [
        'api_key' => env('COINBASE_PRO_API_KEY'),
        'secret_key' => env('COINBASE_PRO_SECRET_KEY'),
        'passphrase' => env('COINBASE_PASS_PHRASE'),
    ],
    'coinbase_platform' => 'coinbase_pro', //''
    'xanpool' => [
        'api_key' => env('XANPOOL_API_KEY'),
        'secret_key' => env('XANPOOL_SECRET_KEY'),
    ],
    'flutterwave' => [
        'public_key' => env('FLUTTERWAVE_PUBLIC_KEY'),
        'secret_key' => env('FLUTTERWAVE_SECRET_KEY'),
        'encryption_key' => env('FLUTTERWAVE_ENCRYPTION_KEY'),
        'env' => env('FLUTTERWAVE_ENV'),
    ],
    'cryptocurrencyapi' => [
        'api_key' => env('CRYPTOCURRENCYAPI_API_KEY'),
        'ipn' => env('CRYPTOCURRENCYAPI_IPN_URL'),
    ]
];
