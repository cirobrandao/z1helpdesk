<?php

declare(strict_types=1);

namespace App\Support;

final class Logger
{
    private static string $path;

    public static function init(): void
    {
        self::$path = dirname(__DIR__, 2) . '/storage/logs/app.log';
        if (!file_exists(self::$path)) {
            @touch(self::$path);
        }
    }

    public static function info(string $message): void
    {
        self::write('INFO', $message);
    }

    public static function error(string $message): void
    {
        self::write('ERROR', $message);
    }

    private static function write(string $level, string $message): void
    {
        $line = sprintf("[%s] %s %s\n", date('c'), $level, $message);
        file_put_contents(self::$path, $line, FILE_APPEND);
    }
}
