<?php

declare(strict_types=1);

use App\Bootstrap\App;
use Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

$app = new App();
$app->run();
