<?php

declare(strict_types=1);

return [
    'session' => [
        'name' => env('SESSION_NAME', 'z1helpdesk_session'),
        'secure' => filter_var(env('SESSION_SECURE', false), FILTER_VALIDATE_BOOLEAN),
        'samesite' => env('SESSION_SAMESITE', 'Lax'),
    ],
    'upload' => [
        'max_bytes' => (int) env('UPLOAD_MAX_BYTES', 5242880),
        'allowed_ext' => array_filter(array_map('trim', explode(',', env('UPLOAD_ALLOWED_EXT', 'jpg,jpeg,png,pdf,txt')))),
    ],
    'rate_limit' => [
        'window' => (int) env('RATE_LIMIT_WINDOW', 900),
        'max' => (int) env('RATE_LIMIT_MAX', 5),
    ],
];
