<?php

return [

    'environment' => 'sandbox',

    'sandbox' => [
        'base_url' => 'https://sandbox-api.agoda.com',
        'api_key'  => 'SANDBOX_API_KEY',
        'secret'   => 'SANDBOX_SECRET'
    ],

    'production' => [
        'base_url' => 'https://api.agoda.com',
        'api_key'  => 'PROD_API_KEY',
        'secret'   => 'PROD_SECRET'
    ],

    'database' => [
        'host' => '127.0.0.1',
        'name' => 'channel_manager',
        'user' => 'root',
        'pass' => ''
    ]

];