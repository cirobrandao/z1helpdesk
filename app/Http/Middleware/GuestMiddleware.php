<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Request;

final class GuestMiddleware implements Middleware
{
    public function handle(Request $request, callable $next): mixed
    {
        if (!empty($_SESSION['user_id'])) {
            redirect('/admin');
        }
        return $next($request);
    }
}
