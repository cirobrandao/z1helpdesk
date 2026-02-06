<?php

declare(strict_types=1);

namespace App\Security;

final class Csrf
{
    public static function token(): string
    {
        return $_SESSION['_csrf'] ?? '';
    }

    public static function ensureToken(): void
    {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
    }

    public static function validate(?string $token): bool
    {
        return is_string($token) && hash_equals((string) ($_SESSION['_csrf'] ?? ''), $token);
    }
}
