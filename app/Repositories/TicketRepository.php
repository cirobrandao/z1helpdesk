<?php

declare(strict_types=1);

namespace App\Repositories;

final class TicketRepository extends BaseRepository
{
    public function all(): array
    {
        $sql = 'SELECT t.*, c.name AS customer_name FROM tickets t
            LEFT JOIN customers c ON c.id = t.customer_id
            ORDER BY t.created_at DESC';
        $stmt = $this->pdo()->query($sql);
        return $stmt->fetchAll() ?: [];
    }

    public function forCustomer(?int $customerId): array
    {
        if (!$customerId) {
            return [];
        }
        $sql = 'SELECT t.* FROM tickets t WHERE t.customer_id = :customer_id ORDER BY t.created_at DESC';
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute(['customer_id' => $customerId]);
        return $stmt->fetchAll() ?: [];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo()->prepare('SELECT * FROM tickets WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $ticket = $stmt->fetch();
        return $ticket ?: null;
    }

    public function findByPublicToken(string $token): ?array
    {
        $stmt = $this->pdo()->prepare('SELECT * FROM tickets WHERE public_token = :token');
        $stmt->execute(['token' => $token]);
        $ticket = $stmt->fetch();
        return $ticket ?: null;
    }

    public function messages(int $ticketId): array
    {
        $stmt = $this->pdo()->prepare('SELECT * FROM ticket_messages WHERE ticket_id = :id ORDER BY created_at ASC');
        $stmt->execute(['id' => $ticketId]);
        return $stmt->fetchAll() ?: [];
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo()->prepare('INSERT INTO tickets (subject, status, customer_id, public_token, created_at) VALUES (:subject, :status, :customer_id, :public_token, NOW())');
        $stmt->execute([
            'subject' => $data['subject'],
            'status' => $data['status'],
            'customer_id' => $data['customer_id'],
            'public_token' => $data['public_token'],
        ]);

        return (int) $this->pdo()->lastInsertId();
    }

    public function addMessage(int $ticketId, int $userId, string $message): int
    {
        $stmt = $this->pdo()->prepare('INSERT INTO ticket_messages (ticket_id, user_id, message, created_at) VALUES (:ticket_id, :user_id, :message, NOW())');
        $stmt->execute([
            'ticket_id' => $ticketId,
            'user_id' => $userId,
            'message' => $message,
        ]);
        return (int) $this->pdo()->lastInsertId();
    }

    public function updateStatus(int $ticketId, string $status): void
    {
        $stmt = $this->pdo()->prepare('UPDATE tickets SET status = :status WHERE id = :id');
        $stmt->execute(['status' => $status, 'id' => $ticketId]);
    }

    public function addStatusHistory(int $ticketId, string $status, int $userId): void
    {
        $stmt = $this->pdo()->prepare('INSERT INTO ticket_status_history (ticket_id, status, changed_by, created_at) VALUES (:ticket_id, :status, :changed_by, NOW())');
        $stmt->execute([
            'ticket_id' => $ticketId,
            'status' => $status,
            'changed_by' => $userId,
        ]);
    }
}
