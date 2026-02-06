<?php

declare(strict_types=1);

namespace App\Http\Requests;

final class LoginRequest extends BaseRequest
{
    public function validate(array $data): bool
    {
        $this->requireField($data, 'login', 'Login is required.');
        $this->requireField($data, 'password', 'Password is required.');
        return $this->errors === [];
    }
}
