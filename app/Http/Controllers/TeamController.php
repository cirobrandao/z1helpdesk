<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\TeamRequest;
use App\Repositories\TeamRepository;
use App\Repositories\UserRepository;

final class TeamController extends Controller
{
    public function index(): string
    {
        $teams = (new TeamRepository())->all();
        return $this->render('admin/teams/index', ['teams' => $teams]);
    }

    public function create(): string
    {
        $agents = (new UserRepository())->assignableAgents();
        return $this->render('admin/teams/create', [
            'errors' => [],
            'agents' => $agents,
        ]);
    }

    public function store(Request $request): string
    {
        $validator = new TeamRequest();
        if (!$validator->validate($request->body)) {
            $agents = (new UserRepository())->assignableAgents();
            return $this->render('admin/teams/create', [
                'errors' => $validator->errors(),
                'agents' => $agents,
            ]);
        }

        $repo = new TeamRepository();
        $teamId = $repo->create((string) $request->input('name'));
        $members = $request->body['members'] ?? [];
        if (is_array($members)) {
            $repo->attachUsers($teamId, $members);
        }

        redirect('/admin/teams');
        return '';
    }
}
