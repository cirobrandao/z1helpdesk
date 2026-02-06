<?php

declare(strict_types=1);

namespace App\Bootstrap;

use App\Http\Router;
use App\I18n\LocaleResolver;
use App\Security\Csrf;
use App\Support\Config;
use App\Support\Database;
use App\Support\ErrorHandler;
use App\Support\Logger;

final class App
{
    public function run(): void
    {
        Config::load(dirname(__DIR__, 2) . '/config');
        date_default_timezone_set((string) Config::get('app.timezone', 'UTC'));

        Logger::init();
        ErrorHandler::register();

        $this->startSession();
        Csrf::ensureToken();

        Database::init();
        (new \App\Services\SettingsService())->load();
        LocaleResolver::resolve();

        $router = new Router();
        $router->registerRoutes();
        $router->dispatch();
    }

    private function startSession(): void
    {
        $sessionConfig = Config::get('security.session', []);
        session_name((string) ($sessionConfig['name'] ?? 'z1helpdesk_session'));

        session_set_cookie_params([
            'httponly' => true,
            'secure' => (bool) ($sessionConfig['secure'] ?? false),
            'samesite' => (string) ($sessionConfig['samesite'] ?? 'Lax'),
            'path' => '/',
        ]);

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}
