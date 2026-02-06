<?php

declare(strict_types=1);

return [
    'ticket' => [
        'public_token_ttl_minutes' => 60,
        'magic_link_ttl_minutes' => 45,
        'api_token_ttl_days' => 90,
    ],
    'status' => [
        'open',
        'pending',
        'closed',
    ],
];
