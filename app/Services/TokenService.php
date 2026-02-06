<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\TokenRepository;
use App\Support\Config;

final class TokenService
{
    public function createMagicLink(int $userId): string
    {
        $token = bin2hex(random_bytes(32));
        $hash = hash('sha256', $token);
        $ttl = (int) Config::get('helpdesk.ticket.magic_link_ttl_minutes', 45);
        $expiresAt = date('Y-m-d H:i:s', time() + ($ttl * 60));

        (new TokenRepository())->store([
            'user_id' => $userId,
            'token_hash' => $hash,
            'type' => 'magic',
            'scopes' => 'tickets:read,tickets:write',
            'expires_at' => $expiresAt,
        ]);

        return $token;
    }

    public function createApiToken(int $userId, string $scopes): string
    {
        $token = bin2hex(random_bytes(40));
        $hash = hash('sha256', $token);
        $ttlDays = (int) Config::get('helpdesk.ticket.api_token_ttl_days', 90);
        $expiresAt = date('Y-m-d H:i:s', time() + ($ttlDays * 86400));

        (new TokenRepository())->store([
            'user_id' => $userId,
            'token_hash' => $hash,
            'type' => 'api',
            'scopes' => $scopes,
            'expires_at' => $expiresAt,
        ]);

        return $token;
    }
}
