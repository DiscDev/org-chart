<?php

return [
    'app' => [
        'debug' => false,
        'log_level' => 'error',
        'maintenance_mode' => false,
    ],

    'session' => [
        'secure' => true,
        'http_only' => true,
        'same_site' => 'lax',
    ],

    'queue' => [
        'default' => 'redis',
        'failed' => [
            'driver' => 'redis',
            'database' => 'redis',
            'table' => 'failed_jobs',
        ],
    ],

    'cache' => [
        'default' => 'redis',
        'prefix' => 'spikeup_prod_',
    ],
];