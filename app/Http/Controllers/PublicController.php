<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\TicketReplyRequest;
use App\Http\Requests\TicketRequest;
use App\Repositories\TicketRepository;
use App\Services\TicketService;
use App\Services\UploadService;

final class PublicController extends Controller
{
    public function home(): string
    {
        return $this->render('public/home');
    }

    public function createTicket(): string
    {
        return $this->render('public/tickets/create', ['errors' => []]);
    }

    public function storeTicket(Request $request): string
    {
        $validator = new TicketRequest();
        if (!$validator->validate($request->body)) {
            return $this->render('public/tickets/create', ['errors' => $validator->errors()]);
        }

        $token = bin2hex(random_bytes(16));
        $ticketId = (new TicketService())->create([
            'subject' => (string) $request->input('subject'),
            'status' => 'open',
            'customer_id' => null,
            'public_token' => $token,
        ], 0);

        (new TicketRepository())->addMessage($ticketId, 0, (string) $request->input('message'));

        redirect('/public/tickets/' . $token);
        return '';
    }

    public function showTicket(Request $request): string
    {
        $token = (string) ($request->params['token'] ?? '');
        $repo = new TicketRepository();
        $ticket = $repo->findByPublicToken($token);
        if (!$ticket) {
            http_response_code(404);
            return 'Ticket not found.';
        }

        $messages = $repo->messages((int) $ticket['id']);
        return $this->render('public/tickets/show', [
            'ticket' => $ticket,
            'messages' => $messages,
            'errors' => [],
        ]);
    }

    public function replyTicket(Request $request): string
    {
        $token = (string) ($request->params['token'] ?? '');
        $repo = new TicketRepository();
        $ticket = $repo->findByPublicToken($token);
        if (!$ticket) {
            http_response_code(404);
            return 'Ticket not found.';
        }

        $validator = new TicketReplyRequest();
        if (!$validator->validate($request->body)) {
            return $this->render('public/tickets/show', [
                'ticket' => $ticket,
                'messages' => $repo->messages((int) $ticket['id']),
                'errors' => $validator->errors(),
            ]);
        }

        $messageId = $repo->addMessage((int) $ticket['id'], 0, (string) $request->input('message'));
        (new UploadService())->handle($request->files['attachment'] ?? null, (int) $ticket['id'], $messageId);

        redirect('/public/tickets/' . $token);
        return '';
    }
}
