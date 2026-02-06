<?php

declare(strict_types=1);

namespace App\View;

final class View
{
    public static function render(string $template, array $data = []): string
    {
        $path = dirname(__DIR__, 2) . '/app/View/Templates/' . $template . '.php';
        if (!file_exists($path)) {
            return 'Template not found.';
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $path;
        return (string) ob_get_clean();
    }
}
