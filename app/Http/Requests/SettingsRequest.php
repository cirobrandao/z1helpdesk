<?php

declare(strict_types=1);

namespace App\Http\Requests;

final class SettingsRequest extends BaseRequest
{
    public function validate(array $data): bool
    {
        $this->requireField($data, 'app_name', 'App name is required.');
        $this->requireField($data, 'default_locale', 'Default locale is required.');
        return $this->errors === [];
    }
}
