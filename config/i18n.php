<?php

declare(strict_types=1);

return [
    'default' => env('APP_DEFAULT_LOCALE', 'en-US'),
    'fallback' => env('APP_FALLBACK_LOCALE', 'en-US'),
    'supported' => [
        'en-US',
        'pt-BR',
    ],
];
