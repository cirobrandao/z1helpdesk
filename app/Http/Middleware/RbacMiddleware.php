<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Request;
use App\Services\AuthService;

final class RbacMiddleware implements Middleware
{
    public function __construct(private readonly string $permission)
    {
    }

    public function handle(Request $request, callable $next): mixed
    {
        if (!AuthService::userHasPermission($this->permission)) {
            http_response_code(403);
            return 'Forbidden.';
        }

        return $next($request);
    }
}
