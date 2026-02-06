<?php

declare(strict_types=1);

namespace App\Http\Requests;

final class UserRequest extends BaseRequest
{
    public function validate(array $data): bool
    {
        $this->requireField($data, 'name', 'Name is required.');
        $this->requireField($data, 'username', 'Username is required.');
        $this->requireField($data, 'email', 'Email is required.');
        $this->requireField($data, 'password', 'Password is required.');
        $this->requireField($data, 'role_id', 'Role is required.');
        return $this->errors === [];
    }
}
