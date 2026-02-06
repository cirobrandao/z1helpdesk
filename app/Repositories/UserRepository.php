<?php

declare(strict_types=1);

namespace App\Repositories;

final class UserRepository extends BaseRepository
{
    public function all(): array
    {
        $stmt = $this->pdo()->query('SELECT * FROM users ORDER BY created_at DESC');
        return $stmt->fetchAll() ?: [];
    }

    public function findByLogin(string $login): ?array
    {
        $sql = 'SELECT * FROM users WHERE email = :login_email OR username = :login_username LIMIT 1';
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute([
            'login_email' => $login,
            'login_username' => $login,
        ]);
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

    public function create(array $data): int
    {
        $stmt = $this->pdo()->prepare('INSERT INTO users (name, username, email, password_hash, locale, customer_id) VALUES (:name, :username, :email, :password_hash, :locale, :customer_id)');
        $stmt->execute([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password_hash' => $data['password_hash'],
            'locale' => $data['locale'],
            'customer_id' => $data['customer_id'],
        ]);
        return (int) $this->pdo()->lastInsertId();
    }

    public function assignRole(int $userId, int $roleId): void
    {
        $stmt = $this->pdo()->prepare('INSERT INTO role_user (user_id, role_id) VALUES (:user_id, :role_id)');
        $stmt->execute(['user_id' => $userId, 'role_id' => $roleId]);
    }

    public function assignableAgents(): array
    {
        $sql = 'SELECT u.id, u.name, u.email FROM users u
            INNER JOIN role_user ru ON ru.user_id = u.id
            INNER JOIN roles r ON r.id = ru.role_id
            WHERE r.name IN ("agent", "admin")
            GROUP BY u.id, u.name, u.email
            ORDER BY u.name';
        $stmt = $this->pdo()->query($sql);
        return $stmt->fetchAll() ?: [];
    }
}
