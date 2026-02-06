<?php

declare(strict_types=1);

return [
    'session' => [
        'name' => getenv('SESSION_NAME') ?: 'z1helpdesk_session',
        'secure' => filter_var(getenv('SESSION_SECURE') ?: false, FILTER_VALIDATE_BOOLEAN),
        'samesite' => getenv('SESSION_SAMESITE') ?: 'Lax',
    ],
    'upload' => [
        'max_bytes' => (int) (getenv('UPLOAD_MAX_BYTES') ?: 5242880),
        'allowed_ext' => array_filter(array_map('trim', explode(',', getenv('UPLOAD_ALLOWED_EXT') ?: 'jpg,jpeg,png,pdf,txt'))),
    ],
    'rate_limit' => [
        'window' => (int) (getenv('RATE_LIMIT_WINDOW') ?: 900),
        'max' => (int) (getenv('RATE_LIMIT_MAX') ?: 5),
    ],
];
