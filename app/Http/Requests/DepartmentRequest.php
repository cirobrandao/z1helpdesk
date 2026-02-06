<?php

declare(strict_types=1);

namespace App\Http\Requests;

final class DepartmentRequest extends BaseRequest
{
    public function validate(array $data): bool
    {
        $this->requireField($data, 'name', 'Name is required.');
        $this->minLength($data, 'name', 2, 'Name is too short.');
        return $this->errors === [];
    }
}
