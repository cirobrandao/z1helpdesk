<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Request;

interface Middleware
{
    public function handle(Request $request, callable $next): mixed;
}
