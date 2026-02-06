<?php

declare(strict_types=1);

$dirs = [
    __DIR__ . '/../storage/logs',
    __DIR__ . '/../storage/cache',
    __DIR__ . '/../storage/sessions',
    __DIR__ . '/../storage/private_uploads',
    __DIR__ . '/../public/assets/build',
    __DIR__ . '/../public/assets/vendor',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
}
