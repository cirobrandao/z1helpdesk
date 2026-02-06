<?php

declare(strict_types=1);

return [
    'name' => getenv('APP_NAME') ?: 'Z1 Helpdesk',
    'env' => getenv('APP_ENV') ?: 'production',
    'url' => getenv('APP_URL') ?: 'http://localhost',
    'key' => getenv('APP_KEY') ?: 'base64:change_me',
    'timezone' => getenv('APP_TIMEZONE') ?: 'UTC',
];
