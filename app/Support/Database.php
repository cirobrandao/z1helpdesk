<?php

declare(strict_types=1);

namespace App\Support;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $pdo = null;

    public static function init(): void
    {
        if (self::$pdo !== null) {
            return;
        }

        $config = Config::get('database.connections.mysql', []);
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['host'] ?? '127.0.0.1',
            $config['port'] ?? 3306,
            $config['database'] ?? 'z1helpdesk',
            $config['charset'] ?? 'utf8mb4'
        );

        try {
            self::$pdo = new PDO(
                $dsn,
                (string) ($config['username'] ?? 'root'),
                (string) ($config['password'] ?? ''),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            throw new PDOException('Database connection failed.');
        }
    }

    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            self::init();
        }
        return self::$pdo;
    }
}
