<?php

declare(strict_types=1);

namespace App\Support;

final class ErrorHandler
{
    public static function register(): void
    {
        $env = Config::get('app.env', 'production');
        $display = $env === 'development';
        ini_set('display_errors', $display ? '1' : '0');
        ini_set('display_startup_errors', $display ? '1' : '0');
        error_reporting(E_ALL);

        set_exception_handler(static function (\Throwable $e) use ($display): void {
            if ($display) {
                http_response_code(500);
                echo '<pre>' . htmlspecialchars((string) $e) . '</pre>';
                return;
            }

            Logger::error('Unhandled exception: ' . $e->getMessage());
            http_response_code(500);
            echo 'An error occurred.';
        });
    }
}
