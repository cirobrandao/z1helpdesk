<?php

declare(strict_types=1);

namespace App\I18n;

use App\Support\Config;
use App\Support\I18n;

final class LocaleResolver
{
    public static function resolve(): void
    {
        $supported = Config::get('i18n.supported', ['en-US']);
        $default = (string) Config::get('i18n.default', 'en-US');

        $locale = $default;
        if (isset($_GET['lang']) && in_array($_GET['lang'], $supported, true)) {
            $locale = (string) $_GET['lang'];
            $_SESSION['locale'] = $locale;
        } elseif (!empty($_SESSION['locale']) && in_array($_SESSION['locale'], $supported, true)) {
            $locale = (string) $_SESSION['locale'];
        } elseif (!empty($_SESSION['user_locale']) && in_array($_SESSION['user_locale'], $supported, true)) {
            $locale = (string) $_SESSION['user_locale'];
        }

        I18n::setLocale($locale);
    }
}
