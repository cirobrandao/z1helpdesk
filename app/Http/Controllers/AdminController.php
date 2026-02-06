<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;
use App\Services\AuthService;

final class AdminController extends Controller
{
    public function dashboard(Request $request): string
    {
        $user = AuthService::currentUser();
        return $this->render('admin/dashboard', ['user' => $user]);
    }
}
