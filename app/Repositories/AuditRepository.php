<?php

declare(strict_types=1);

namespace App\Repositories;

final class AuditRepository extends BaseRepository
{
    public function log(array $data): void
    {
        $stmt = $this->pdo()->prepare('INSERT INTO audit_logs (user_id, action, ip_address, details, created_at) VALUES (:user_id, :action, :ip_address, :details, NOW())');
        $stmt->execute([
            'user_id' => $data['user_id'],
            'action' => $data['action'],
            'ip_address' => $data['ip_address'],
            'details' => $data['details'],
        ]);
    }
}
