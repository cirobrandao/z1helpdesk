<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\AttachmentRepository;
use App\Support\Config;

final class UploadService
{
    public function handle(?array $file, int $ticketId, int $messageId): ?string
    {
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }

        $maxBytes = (int) Config::get('security.upload.max_bytes', 5242880);
        if (($file['size'] ?? 0) > $maxBytes) {
            return null;
        }

        $originalName = (string) ($file['name'] ?? '');
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = Config::get('security.upload.allowed_ext', []);
        if (!in_array($ext, $allowed, true)) {
            return null;
        }

        $mime = mime_content_type($file['tmp_name']) ?: 'application/octet-stream';
        $uuid = bin2hex(random_bytes(16));
        $filename = $uuid . '.' . $ext;
        $targetDir = dirname(__DIR__, 2) . '/storage/private_uploads';
        $targetPath = $targetDir . '/' . $filename;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return null;
        }

        (new AttachmentRepository())->create([
            'ticket_id' => $ticketId,
            'message_id' => $messageId,
            'filename' => $filename,
            'original_name' => $originalName,
            'mime_type' => $mime,
            'size_bytes' => (int) $file['size'],
        ]);

        return $filename;
    }
}
