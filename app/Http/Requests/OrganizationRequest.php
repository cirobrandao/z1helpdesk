<?php

declare(strict_types=1);

namespace App\Http\Requests;

final class OrganizationRequest extends BaseRequest
{
    public function validate(array $data): bool
    {
        $this->requireField($data, 'name', 'Name is required.');
        return $this->errors === [];
    }
}
