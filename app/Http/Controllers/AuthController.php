<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Security\RateLimiter;
use App\Services\AuthService;

final class AuthController extends Controller
{
    public function loginForm(): string
    {
        return $this->render('public/login', ['errors' => []]);
    }

    public function login(Request $request): string
    {
        $validator = new LoginRequest();
        if (!$validator->validate($request->body)) {
            return $this->render('public/login', ['errors' => $validator->errors()]);
        }

        $login = (string) $request->input('login');
        $password = (string) $request->input('password');

        if (!AuthService::attempt($login, $password, $request->ip)) {
            $key = 'login:' . $request->ip . ':' . strtolower($login);
            $retry = RateLimiter::retryAfter($key);
            return $this->render('public/login', [
                'errors' => ['login' => 'Invalid credentials. Retry in ' . $retry . 's.'],
            ]);
        }

        redirect('/admin');
        return '';
    }

    public function logout(Request $request): string
    {
        $userId = (int) ($_SESSION['user_id'] ?? 0);
        AuthService::logout($userId, $request->ip);
        redirect('/admin/login');
        return '';
    }
}
