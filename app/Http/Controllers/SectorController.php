<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\SectorRequest;
use App\Repositories\SectorRepository;

final class SectorController extends Controller
{
    public function index(): string
    {
        $sectors = (new SectorRepository())->all();
        return $this->render('admin/sectors/index', ['sectors' => $sectors]);
    }

    public function create(): string
    {
        return $this->render('admin/sectors/create', ['errors' => []]);
    }

    public function store(Request $request): string
    {
        $validator = new SectorRequest();
        if (!$validator->validate($request->body)) {
            return $this->render('admin/sectors/create', ['errors' => $validator->errors()]);
        }

        (new SectorRepository())->create((string) $request->input('name'));
        redirect('/admin/sectors');
        return '';
    }
}
