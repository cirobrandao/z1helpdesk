<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\TicketReplyRequest;
use App\Repositories\TicketRepository;
use App\Services\TicketService;

final class TicketController extends Controller
{
    public function index(): string
    {
        $tickets = (new TicketRepository())->all();
        return $this->render('admin/tickets/index', ['tickets' => $tickets]);
    }

    public function show(Request $request): string
    {
        $ticketId = (int) ($request->params['id'] ?? 0);
        $repo = new TicketRepository();
        $ticket = $repo->find($ticketId);
        $messages = $repo->messages($ticketId);

        if (!$ticket) {
            http_response_code(404);
            return 'Ticket not found.';
        }

        return $this->render('admin/tickets/show', [
            'ticket' => $ticket,
            'messages' => $messages,
            'errors' => [],
        ]);
    }

    public function reply(Request $request): string
    {
        $ticketId = (int) ($request->params['id'] ?? 0);
        $validator = new TicketReplyRequest();
        if (!$validator->validate($request->body)) {
            $repo = new TicketRepository();
            return $this->render('admin/tickets/show', [
                'ticket' => $repo->find($ticketId),
                'messages' => $repo->messages($ticketId),
                'errors' => $validator->errors(),
            ]);
        }

        $messageId = (new TicketService())->reply($ticketId, (int) $_SESSION['user_id'], (string) $request->input('message'));
        (new \App\Services\UploadService())->handle($request->files['attachment'] ?? null, $ticketId, $messageId);
        redirect('/admin/tickets/' . $ticketId);
        return '';
    }

    public function close(Request $request): string
    {
        $ticketId = (int) ($request->params['id'] ?? 0);
        (new TicketService())->close($ticketId, (int) $_SESSION['user_id']);
        redirect('/admin/tickets/' . $ticketId);
        return '';
    }
}
