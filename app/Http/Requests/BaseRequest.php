<?php

declare(strict_types=1);

namespace App\Http\Requests;

abstract class BaseRequest
{
    protected array $errors = [];

    abstract public function validate(array $data): bool;

    public function errors(): array
    {
        return $this->errors;
    }

    protected function requireField(array $data, string $key, string $message): void
    {
        $value = trim((string) ($data[$key] ?? ''));
        if ($value === '') {
            $this->errors[$key] = $message;
        }
    }

    protected function minLength(array $data, string $key, int $min, string $message): void
    {
        $value = (string) ($data[$key] ?? '');
        if (strlen($value) < $min) {
            $this->errors[$key] = $message;
        }
    }
}
