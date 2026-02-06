<?php

declare(strict_types=1);

namespace App\Http\Controllers;

abstract class Controller
{
    protected function render(string $template, array $data = []): string
    {
        return view($template, $data);
    }
}
