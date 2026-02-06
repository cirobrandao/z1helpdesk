<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\FaqRequest;
use App\Repositories\FaqRepository;

final class FaqController extends Controller
{
    public function index(): string
    {
        $faqs = (new FaqRepository())->all();
        return $this->render('admin/faqs/index', ['faqs' => $faqs]);
    }

    public function create(): string
    {
        $categories = (new FaqRepository())->categories();
        return $this->render('admin/faqs/create', ['errors' => [], 'categories' => $categories]);
    }

    public function store(Request $request): string
    {
        $validator = new FaqRequest();
        if (!$validator->validate($request->body)) {
            $categories = (new FaqRepository())->categories();
            return $this->render('admin/faqs/create', ['errors' => $validator->errors(), 'categories' => $categories]);
        }

        (new FaqRepository())->create(
            (int) $request->input('category_id'),
            (string) $request->input('question'),
            (string) $request->input('answer')
        );

        redirect('/admin/faqs');
        return '';
    }
}
