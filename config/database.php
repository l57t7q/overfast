<?php
return [
    'default' => [
        'driver'   => 'mysql',
        'host'     => env('DB_HOST', 'localhost'),
        'port'     => env('DB_PORT', 3306),
        'database' => env('DB_DATABASE', 'demo'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', 'password'),
        'charset'  => 'utf8',
        ],
];
