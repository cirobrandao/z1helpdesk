<?php

declare(strict_types=1);

namespace App\Http;

final class Request
{
    public function __construct(
        public readonly string $method,
        public readonly string $path,
        public readonly array $params,
        public readonly array $query,
        public readonly array $body,
        public readonly array $files,
        public readonly string $ip
    ) {
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->body[$key] ?? $this->query[$key] ?? $default;
    }
}
