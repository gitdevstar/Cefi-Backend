<?php

return [
    'coinbase' => [
        'api_key' => env('COINBASE_API_KEY'),
        'secret_key' => env('COINBASE_SECRET_KEY'),
    ],
    'coinbase_pro' => [
        'pro_api_key' => env('COINBASE_PRO_API_KEY'),
        'pro_secret_key' => env('COINBASE_PRO_SECRET_KEY'),
        'passphrase' => env('COINBASE_PASS_PHRASE'),
    ],
    'coinbase_platform' => 'pro', //''
    'xanpool' => [
        'api_key' => env('XANPOOL_API_KEY'),
        'secret_key' => env('XANPOOL_SECRET_KEY'),
    ],
    'flutterwave' => [
        'public_key' => env('PUBLIC_KEY'),
        'secret_key' => env('SECRET_KEY'),
        'encryption_key' => env('ENCRYPTION_KEY'),
        'env' => env('ENV'),
    ]
];
