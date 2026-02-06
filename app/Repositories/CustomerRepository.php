<?php

declare(strict_types=1);

namespace App\Repositories;

final class CustomerRepository extends BaseRepository
{
    public function all(): array
    {
        $stmt = $this->pdo()->query('SELECT * FROM customers ORDER BY name');
        return $stmt->fetchAll() ?: [];
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo()->prepare('INSERT INTO customers (name, email, phone) VALUES (:name, :email, :phone)');
        $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);
        return (int) $this->pdo()->lastInsertId();
    }

    public function attachOrganization(int $customerId, int $organizationId): void
    {
        $stmt = $this->pdo()->prepare('INSERT IGNORE INTO organization_customer (organization_id, customer_id) VALUES (:org_id, :customer_id)');
        $stmt->execute(['org_id' => $organizationId, 'customer_id' => $customerId]);
    }
}
