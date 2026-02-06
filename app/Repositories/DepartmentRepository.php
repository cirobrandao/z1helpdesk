<?php

declare(strict_types=1);

namespace App\Repositories;

final class DepartmentRepository extends BaseRepository
{
    public function all(): array
    {
        $stmt = $this->pdo()->query('SELECT * FROM departments ORDER BY name');
        return $stmt->fetchAll() ?: [];
    }

    public function create(string $name): void
    {
        $stmt = $this->pdo()->prepare('INSERT INTO departments (name) VALUES (:name)');
        $stmt->execute(['name' => $name]);
    }
}
