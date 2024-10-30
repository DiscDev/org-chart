<?php

return [
    'build' => [
        'environment' => env('APP_ENV', 'production'),
        'node_env' => env('NODE_ENV', 'production'),
        'public_path' => 'public/build',
    ],

    'cache' => [
        'views' => true,
        'routes' => true,
        'config' => true,
        'events' => true,
    ],

    'optimize' => [
        'autoloader' => true,
        'classmap' => true,
        'packages' => true,
    ],

    'assets' => [
        'minify' => true,
        'versioning' => true,
    ],

    'security' => [
        'headers' => [
            'X-Frame-Options' => 'DENY',
            'X-XSS-Protection' => '1; mode=block',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
        ],
    ],
];