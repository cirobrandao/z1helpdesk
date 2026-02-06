<?php

declare(strict_types=1);

namespace App\Http\Controllers;

final class AgentController extends Controller
{
    public function dashboard(): string
    {
        return $this->render('agent/dashboard');
    }
}
