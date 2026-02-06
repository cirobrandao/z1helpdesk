<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Request;
use App\Security\Csrf;

final class CsrfMiddleware implements Middleware
{
    public function handle(Request $request, callable $next): mixed
    {
        if ($request->method !== 'GET') {
            $token = $request->input('_csrf');
            if (!Csrf::validate(is_string($token) ? $token : null)) {
                http_response_code(419);
                return 'Invalid CSRF token.';
            }
        }

        return $next($request);
    }
}
