<?php

declare(strict_types=1);

namespace App\Support;

final class I18n
{
    private static string $locale = 'en-US';
    private static array $cache = [];

    public static function setLocale(string $locale): void
    {
        self::$locale = $locale;
    }

    public static function getLocale(): string
    {
        return self::$locale;
    }

    public static function get(string $key, array $params = []): string
    {
        $locale = self::$locale;
        $fallback = (string) Config::get('i18n.fallback', 'en-US');
        $value = self::loadValue($locale, $key) ?? self::loadValue($fallback, $key) ?? $key;

        foreach ($params as $param => $replacement) {
            $value = str_replace(':' . $param, (string) $replacement, $value);
        }

        return $value;
    }

    private static function loadValue(string $locale, string $key): ?string
    {
        if (!isset(self::$cache[$locale])) {
            self::$cache[$locale] = self::loadLocale($locale);
        }

        $segments = explode('.', $key);
        $value = self::$cache[$locale];
        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return null;
            }
            $value = $value[$segment];
        }

        return is_string($value) ? $value : null;
    }

    private static function loadLocale(string $locale): array
    {
        $basePath = dirname(__DIR__, 2) . '/resources/lang/' . $locale;
        $data = [];
        foreach (glob($basePath . '/*.php') ?: [] as $file) {
            $name = basename($file, '.php');
            $data[$name] = require $file;
        }
        return $data;
    }
}
