<?php

declare(strict_types=1);

namespace App\Repositories;

final class RoleRepository extends BaseRepository
{
    public function all(): array
    {
        $stmt = $this->pdo()->query('SELECT * FROM roles ORDER BY name');
        return $stmt->fetchAll() ?: [];
    }
}
