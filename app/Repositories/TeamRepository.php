<?php

declare(strict_types=1);

namespace App\Repositories;

final class TeamRepository extends BaseRepository
{
    public function all(): array
    {
        $stmt = $this->pdo()->query('SELECT * FROM teams ORDER BY name');
        return $stmt->fetchAll() ?: [];
    }

    public function create(string $name): int
    {
        $stmt = $this->pdo()->prepare('INSERT INTO teams (name) VALUES (:name)');
        $stmt->execute(['name' => $name]);
        return (int) $this->pdo()->lastInsertId();
    }

    public function attachUsers(int $teamId, array $userIds): void
    {
        $stmt = $this->pdo()->prepare('INSERT IGNORE INTO team_user (team_id, user_id) VALUES (:team_id, :user_id)');
        foreach ($userIds as $userId) {
            $stmt->execute(['team_id' => $teamId, 'user_id' => (int) $userId]);
        }
    }
}
