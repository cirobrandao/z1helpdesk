<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\DepartmentRequest;
use App\Repositories\DepartmentRepository;

final class DepartmentController extends Controller
{
    public function index(): string
    {
        $departments = (new DepartmentRepository())->all();
        return $this->render('admin/departments/index', ['departments' => $departments]);
    }

    public function create(): string
    {
        return $this->render('admin/departments/create', ['errors' => []]);
    }

    public function store(Request $request): string
    {
        $validator = new DepartmentRequest();
        if (!$validator->validate($request->body)) {
            return $this->render('admin/departments/create', ['errors' => $validator->errors()]);
        }

        (new DepartmentRepository())->create((string) $request->input('name'));
        redirect('/admin/departments');
        return '';
    }
}
