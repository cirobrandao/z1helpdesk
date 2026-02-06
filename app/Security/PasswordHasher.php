<?php

declare(strict_types=1);

namespace App\Security;

final class PasswordHasher
{
    public static function hash(string $plain): string
    {
        $algo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_DEFAULT;
        return password_hash($plain, $algo);
    }

    public static function verify(string $plain, string $hash): bool
    {
        return password_verify($plain, $hash);
    }
}
