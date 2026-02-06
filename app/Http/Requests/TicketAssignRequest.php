<?php

declare(strict_types=1);

namespace App\Http\Requests;

final class TicketAssignRequest extends BaseRequest
{
    public function validate(array $data): bool
    {
        $this->requireField($data, 'assigned_user_id', 'Assigned user is required.');
        return $this->errors === [];
    }
}
