<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Requests\TicketRequest;
use App\Repositories\TicketRepository;
use App\Services\AuthService;
use App\Services\TicketService;

final class ClientController extends Controller
{
    public function dashboard(): string
    {
        $user = AuthService::currentUser();
        $tickets = (new TicketRepository())->forCustomer($user['customer_id'] ?? null);
        return $this->render('client/dashboard', ['tickets' => $tickets]);
    }

    public function createTicket(): string
    {
        return $this->render('client/tickets/create', ['errors' => []]);
    }

    public function storeTicket(Request $request): string
    {
        $validator = new TicketRequest();
        if (!$validator->validate($request->body)) {
            return $this->render('client/tickets/create', ['errors' => $validator->errors()]);
        }

        $user = AuthService::currentUser();
        $ticketId = (new TicketService())->create([
            'subject' => (string) $request->input('subject'),
            'status' => 'open',
            'customer_id' => $user['customer_id'] ?? null,
            'public_token' => bin2hex(random_bytes(16)),
        ], (int) $_SESSION['user_id']);

        (new TicketRepository())->addMessage($ticketId, (int) $_SESSION['user_id'], (string) $request->input('message'));

        redirect('/admin/tickets/' . $ticketId);
        return '';
    }
}
