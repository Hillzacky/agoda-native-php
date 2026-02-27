<?php
require_once __DIR__ . '/../core/Env.php';

return [
    'environment' => Env::get('APP_ENV', 'sandbox'),

    'sandbox' => [
        'base_url' => 'https://sandbox-api.agoda.com',
        'api_key'  => Env::get('AGODA_API_KEY_SANDBOX'),
        'secret'   => Env::get('AGODA_SECRET_SANDBOX')
    ],

    'production' => [
        'base_url' => 'https://api.agoda.com',
        'api_key'  => Env::get('AGODA_API_KEY_PRODUCTION'),
        'secret'   => Env::get('AGODA_SECRET_PRODUCTION')
    ],

    'database' => [
        'host' => Env::get('DB_HOST', '127.0.0.1'),
        'name' => Env::get('DB_NAME', 'db_agoda'),
        'user' => Env::get('DB_USER', 'root'),
        'pass' => Env::get('DB_PASS', '')
    ]
];