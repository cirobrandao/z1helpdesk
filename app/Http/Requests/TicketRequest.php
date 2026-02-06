<?php

declare(strict_types=1);

namespace App\Http\Requests;

final class TicketRequest extends BaseRequest
{
    public function validate(array $data): bool
    {
        $this->requireField($data, 'subject', 'Subject is required.');
        $this->requireField($data, 'message', 'Message is required.');
        return $this->errors === [];
    }
}
