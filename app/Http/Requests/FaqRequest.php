<?php

declare(strict_types=1);

namespace App\Http\Requests;

final class FaqRequest extends BaseRequest
{
    public function validate(array $data): bool
    {
        $this->requireField($data, 'question', 'Question is required.');
        $this->requireField($data, 'answer', 'Answer is required.');
        $this->requireField($data, 'category_id', 'Category is required.');
        return $this->errors === [];
    }
}
