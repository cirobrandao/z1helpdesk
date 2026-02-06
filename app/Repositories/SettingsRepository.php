<?php

declare(strict_types=1);

namespace App\Repositories;

final class SettingsRepository extends BaseRepository
{
    public function all(): array
    {
        $stmt = $this->pdo()->query('SELECT name, value FROM settings');
        $rows = $stmt->fetchAll() ?: [];
        $result = [];
        foreach ($rows as $row) {
            $result[$row['name']] = $row['value'];
        }
        return $result;
    }

    public function upsert(string $name, string $value): void
    {
        $stmt = $this->pdo()->prepare('INSERT INTO settings (name, value) VALUES (:name, :value)
            ON DUPLICATE KEY UPDATE value = VALUES(value)');
        $stmt->execute(['name' => $name, 'value' => $value]);
    }
}
