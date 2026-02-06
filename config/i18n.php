<?php

declare(strict_types=1);

return [
    'default' => getenv('APP_DEFAULT_LOCALE') ?: 'en-US',
    'fallback' => getenv('APP_FALLBACK_LOCALE') ?: 'en-US',
    'supported' => [
        'en-US',
        'pt-BR',
    ],
];
