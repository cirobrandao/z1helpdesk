<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\OrganizationRequest;
use App\Repositories\OrganizationRepository;

final class OrganizationController extends Controller
{
    public function index(): string
    {
        $organizations = (new OrganizationRepository())->all();
        return $this->render('admin/organizations/index', ['organizations' => $organizations]);
    }

    public function create(): string
    {
        return $this->render('admin/organizations/create', ['errors' => []]);
    }

    public function store(Request $request): string
    {
        $validator = new OrganizationRequest();
        if (!$validator->validate($request->body)) {
            return $this->render('admin/organizations/create', ['errors' => $validator->errors()]);
        }

        (new OrganizationRepository())->create((string) $request->input('name'));
        redirect('/admin/organizations');
        return '';
    }
}
