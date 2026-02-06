<?php

declare(strict_types=1);

use App\Support\Config;
use App\Support\I18n;
use App\View\View;

if (!function_exists('config')) {
    function config(string $key, mixed $default = null): mixed
    {
        return Config::get($key, $default);
    }
}

if (!function_exists('__')) {
    function __(string $key, array $params = []): string
    {
        return I18n::get($key, $params);
    }
}

if (!function_exists('view')) {
    function view(string $template, array $data = []): string
    {
        return View::render($template, $data);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }
}
