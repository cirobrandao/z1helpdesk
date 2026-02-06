<?php

declare(strict_types=1);

namespace App\Http\Requests;

final class TicketReplyRequest extends BaseRequest
{
    public function validate(array $data): bool
    {
        $this->requireField($data, 'message', 'Message is required.');
        return $this->errors === [];
    }
}
