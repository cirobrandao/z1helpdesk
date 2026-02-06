<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\SettingsRequest;
use App\Repositories\SettingsRepository;
use App\Services\SettingsService;

final class SettingsController extends Controller
{
    public function edit(): string
    {
        $settings = (new SettingsRepository())->all();
        return $this->render('admin/settings/edit', [
            'errors' => [],
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): string
    {
        $validator = new SettingsRequest();
        if (!$validator->validate($request->body)) {
            $settings = (new SettingsRepository())->all();
            return $this->render('admin/settings/edit', [
                'errors' => $validator->errors(),
                'settings' => $settings,
            ]);
        }

        (new SettingsService())->update([
            'app_name' => (string) $request->input('app_name'),
            'default_locale' => (string) $request->input('default_locale'),
        ]);

        redirect('/admin/settings');
        return '';
    }
}
