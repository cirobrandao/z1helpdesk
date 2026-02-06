<?php

declare(strict_types=1);

namespace App\Repositories;

final class TokenRepository extends BaseRepository
{
    public function store(array $data): void
    {
        $stmt = $this->pdo()->prepare('INSERT INTO auth_tokens (user_id, token_hash, type, scopes, expires_at, created_at) VALUES (:user_id, :token_hash, :type, :scopes, :expires_at, NOW())');
        $stmt->execute([
            'user_id' => $data['user_id'],
            'token_hash' => $data['token_hash'],
            'type' => $data['type'],
            'scopes' => $data['scopes'],
            'expires_at' => $data['expires_at'],
        ]);
    }
}
