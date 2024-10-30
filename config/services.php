<?php

return [
    // ... other services config

    'slack' => [
        'webhook_url' => env('SLACK_WEBHOOK_URL'),
        'token' => env('SLACK_BOT_TOKEN'),
    ],

    'microsoft' => [
        'teams' => [
            'webhook_url' => env('MS_TEAMS_WEBHOOK_URL'),
        ],
    ],
];