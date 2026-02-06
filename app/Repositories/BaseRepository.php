<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Support\Database;
use PDO;

abstract class BaseRepository
{
    protected function pdo(): PDO
    {
        return Database::pdo();
    }
}
