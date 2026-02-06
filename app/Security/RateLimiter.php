<?php

declare(strict_types=1);

namespace App\Security;

use App\Support\Config;

final class RateLimiter
{
    public static function hit(string $key): void
    {
        $window = (int) Config::get('security.rate_limit.window', 900);
        $bucket = $_SESSION['_rate_limit'][$key] ?? ['count' => 0, 'expires' => time() + $window];

        if ($bucket['expires'] < time()) {
            $bucket = ['count' => 0, 'expires' => time() + $window];
        }

        $bucket['count']++;
        $_SESSION['_rate_limit'][$key] = $bucket;
    }

    public static function tooManyAttempts(string $key): bool
    {
        $max = (int) Config::get('security.rate_limit.max', 5);
        $bucket = $_SESSION['_rate_limit'][$key] ?? null;
        if (!$bucket) {
            return false;
        }
        if ($bucket['expires'] < time()) {
            return false;
        }
        return $bucket['count'] >= $max;
    }

    public static function retryAfter(string $key): int
    {
        $bucket = $_SESSION['_rate_limit'][$key] ?? ['expires' => time()];
        return max(0, (int) ($bucket['expires'] - time()));
    }
}
