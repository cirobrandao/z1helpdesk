<?php

declare(strict_types=1);

namespace App\Repositories;

final class OrganizationRepository extends BaseRepository
{
    public function all(): array
    {
        $stmt = $this->pdo()->query('SELECT * FROM organizations ORDER BY name');
        return $stmt->fetchAll() ?: [];
    }

    public function create(string $name): int
    {
        $stmt = $this->pdo()->prepare('INSERT INTO organizations (name) VALUES (:name)');
        $stmt->execute(['name' => $name]);
        return (int) $this->pdo()->lastInsertId();
    }
}
