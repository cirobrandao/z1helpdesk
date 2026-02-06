<?php

declare(strict_types=1);

namespace App\Repositories;

final class AttachmentRepository extends BaseRepository
{
    public function create(array $data): void
    {
        $stmt = $this->pdo()->prepare('INSERT INTO attachments (ticket_id, message_id, filename, original_name, mime_type, size_bytes, created_at) VALUES (:ticket_id, :message_id, :filename, :original_name, :mime_type, :size_bytes, NOW())');
        $stmt->execute([
            'ticket_id' => $data['ticket_id'],
            'message_id' => $data['message_id'],
            'filename' => $data['filename'],
            'original_name' => $data['original_name'],
            'mime_type' => $data['mime_type'],
            'size_bytes' => $data['size_bytes'],
        ]);
    }
}
