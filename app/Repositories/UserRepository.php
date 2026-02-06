<?php

declare(strict_types=1);

namespace App\Repositories;

final class UserRepository extends BaseRepository
{
    public function findByLogin(string $login): ?array
    {
        $sql = 'SELECT * FROM users WHERE email = :login OR username = :login LIMIT 1';
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute(['login' => $login]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo()->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function permissionsForUser(int $id): array
    {
        $sql = 'SELECT p.name FROM permissions p
            INNER JOIN permission_role pr ON pr.permission_id = p.id
            INNER JOIN role_user ru ON ru.role_id = pr.role_id
            WHERE ru.user_id = :id';
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll() ?: [];
    }

    public function rolesForUser(int $id): array
    {
        $sql = 'SELECT r.name FROM roles r
            INNER JOIN role_user ru ON ru.role_id = r.id
            WHERE ru.user_id = :id';
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll() ?: [];
    }
}
