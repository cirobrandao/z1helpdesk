<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\UserRequest;
use App\Repositories\CustomerRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Security\PasswordHasher;

final class UserController extends Controller
{
    public function index(): string
    {
        $users = (new UserRepository())->all();
        return $this->render('admin/users/index', ['users' => $users]);
    }

    public function create(): string
    {
        $roles = (new RoleRepository())->all();
        $customers = (new CustomerRepository())->all();
        return $this->render('admin/users/create', [
            'errors' => [],
            'roles' => $roles,
            'customers' => $customers,
        ]);
    }

    public function store(Request $request): string
    {
        $validator = new UserRequest();
        if (!$validator->validate($request->body)) {
            $roles = (new RoleRepository())->all();
            $customers = (new CustomerRepository())->all();
            return $this->render('admin/users/create', [
                'errors' => $validator->errors(),
                'roles' => $roles,
                'customers' => $customers,
            ]);
        }

        $repo = new UserRepository();
        $userId = $repo->create([
            'name' => (string) $request->input('name'),
            'username' => (string) $request->input('username'),
            'email' => (string) $request->input('email'),
            'password_hash' => PasswordHasher::hash((string) $request->input('password')),
            'locale' => (string) ($request->input('locale') ?: 'en-US'),
            'customer_id' => $request->input('customer_id') ? (int) $request->input('customer_id') : null,
        ]);
        $repo->assignRole($userId, (int) $request->input('role_id'));

        redirect('/admin/users');
        return '';
    }
}
