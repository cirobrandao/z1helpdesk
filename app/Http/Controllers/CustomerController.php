<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Repositories\CustomerRepository;
use App\Repositories\OrganizationRepository;

final class CustomerController extends Controller
{
    public function index(): string
    {
        $customers = (new CustomerRepository())->all();
        return $this->render('admin/customers/index', ['customers' => $customers]);
    }

    public function create(): string
    {
        $organizations = (new OrganizationRepository())->all();
        return $this->render('admin/customers/create', [
            'errors' => [],
            'organizations' => $organizations,
        ]);
    }

    public function store(Request $request): string
    {
        $validator = new CustomerRequest();
        if (!$validator->validate($request->body)) {
            $organizations = (new OrganizationRepository())->all();
            return $this->render('admin/customers/create', [
                'errors' => $validator->errors(),
                'organizations' => $organizations,
            ]);
        }

        $repo = new CustomerRepository();
        $customerId = $repo->create([
            'name' => (string) $request->input('name'),
            'email' => (string) $request->input('email'),
            'phone' => (string) $request->input('phone'),
        ]);

        $orgId = $request->input('organization_id');
        if ($orgId) {
            $repo->attachOrganization($customerId, (int) $orgId);
        }

        redirect('/admin/customers');
        return '';
    }
}
