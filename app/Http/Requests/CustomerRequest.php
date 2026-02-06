<?php

declare(strict_types=1);

namespace App\Http\Requests;

final class CustomerRequest extends BaseRequest
{
    public function validate(array $data): bool
    {
        $this->requireField($data, 'name', 'Name is required.');
        $this->requireField($data, 'email', 'Email is required.');
        return $this->errors === [];
    }
}
