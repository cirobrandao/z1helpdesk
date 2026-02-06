<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\AuditRepository;
use App\Repositories\TicketRepository;

final class TicketService
{
    public function create(array $data, int $actorId): int
    {
        $repo = new TicketRepository();
        $ticketId = $repo->create($data);
        $repo->addStatusHistory($ticketId, $data['status'], $actorId);

        (new AuditRepository())->log([
            'user_id' => $actorId,
            'action' => 'ticket_created',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
            'details' => json_encode(['ticket_id' => $ticketId], JSON_UNESCAPED_SLASHES),
        ]);

        return $ticketId;
    }

    public function reply(int $ticketId, int $userId, string $message): int
    {
        $messageId = (new TicketRepository())->addMessage($ticketId, $userId, $message);

        (new AuditRepository())->log([
            'user_id' => $userId,
            'action' => 'ticket_replied',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
            'details' => json_encode(['ticket_id' => $ticketId], JSON_UNESCAPED_SLASHES),
        ]);

        return $messageId;
    }

    public function close(int $ticketId, int $userId): void
    {
        $repo = new TicketRepository();
        $repo->updateStatus($ticketId, 'closed');
        $repo->addStatusHistory($ticketId, 'closed', $userId);

        (new AuditRepository())->log([
            'user_id' => $userId,
            'action' => 'ticket_closed',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
            'details' => json_encode(['ticket_id' => $ticketId], JSON_UNESCAPED_SLASHES),
        ]);
    }

    public function assign(int $ticketId, int $userId, int $assignedUserId): void
    {
        (new TicketRepository())->assign($ticketId, $assignedUserId);

        (new AuditRepository())->log([
            'user_id' => $userId,
            'action' => 'ticket_assigned',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
            'details' => json_encode(['ticket_id' => $ticketId, 'assigned_user_id' => $assignedUserId], JSON_UNESCAPED_SLASHES),
        ]);
    }
}
