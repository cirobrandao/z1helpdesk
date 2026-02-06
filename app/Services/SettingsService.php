<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\SettingsRepository;
use App\Support\Config;
use App\Support\Logger;

final class SettingsService
{
    public function load(): void
    {
        try {
            $settings = (new SettingsRepository())->all();
            if (isset($settings['app_name'])) {
                Config::set('app.name', $settings['app_name']);
            }
            if (isset($settings['default_locale'])) {
                Config::set('i18n.default', $settings['default_locale']);
            }
        } catch (\Throwable $e) {
            Logger::error('Settings load failed: ' . $e->getMessage());
        }
    }

    public function update(array $data): void
    {
        $repo = new SettingsRepository();
        $repo->upsert('app_name', $data['app_name']);
        $repo->upsert('default_locale', $data['default_locale']);
        Config::set('app.name', $data['app_name']);
        Config::set('i18n.default', $data['default_locale']);
    }
}
