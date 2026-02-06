<?php

declare(strict_types=1);

namespace App\Repositories;

final class SectorRepository extends BaseRepository
{
    public function all(): array
    {
        $stmt = $this->pdo()->query('SELECT * FROM sectors ORDER BY name');
        return $stmt->fetchAll() ?: [];
    }

    public function create(string $name): void
    {
        $stmt = $this->pdo()->prepare('INSERT INTO sectors (name) VALUES (:name)');
        $stmt->execute(['name' => $name]);
    }
}
