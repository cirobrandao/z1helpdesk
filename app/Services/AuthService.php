<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\AuditRepository;
use App\Repositories\UserRepository;
use App\Security\PasswordHasher;
use App\Security\RateLimiter;

final class AuthService
{
    public static function attempt(string $login, string $password, string $ip): bool
    {
        $key = 'login:' . $ip . ':' . strtolower($login);
        if (RateLimiter::tooManyAttempts($key)) {
            return false;
        }

        $repo = new UserRepository();
        $user = $repo->findByLogin($login);
        if (!$user || !PasswordHasher::verify($password, (string) $user['password_hash'])) {
            RateLimiter::hit($key);
            (new AuditRepository())->log([
                'user_id' => $user['id'] ?? null,
                'action' => 'login_failed',
                'ip_address' => $ip,
                'details' => json_encode(['login' => $login], JSON_UNESCAPED_SLASHES),
            ]);
            return false;
        }

        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_locale'] = $user['locale'] ?? null;
        session_regenerate_id(true);

        (new AuditRepository())->log([
            'user_id' => $user['id'],
            'action' => 'login_success',
            'ip_address' => $ip,
            'details' => json_encode(['login' => $login], JSON_UNESCAPED_SLASHES),
        ]);

        return true;
    }

    public static function logout(int $userId, string $ip): void
    {
        (new AuditRepository())->log([
            'user_id' => $userId,
            'action' => 'logout',
            'ip_address' => $ip,
            'details' => '{}',
        ]);
        session_destroy();
    }

    public static function userHasPermission(string $permission): bool
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return false;
        }
        $repo = new UserRepository();
        $permissions = $repo->permissionsForUser((int) $userId);
        foreach ($permissions as $perm) {
            if (($perm['name'] ?? '') === $permission) {
                return true;
            }
        }
        return false;
    }

    public static function currentUser(): ?array
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return null;
        }
        return (new UserRepository())->findById((int) $userId);
    }
}
