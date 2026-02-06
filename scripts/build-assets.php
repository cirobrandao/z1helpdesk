<?php

declare(strict_types=1);

$source = __DIR__ . '/../vendor/twbs/bootstrap/dist';
$target = __DIR__ . '/../public/assets/vendor/bootstrap';

if (!is_dir($source)) {
    fwrite(STDERR, "Bootstrap not installed. Run composer install first.\n");
    exit(1);
}

if (!is_dir($target)) {
    mkdir($target, 0775, true);
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $item) {
    $dest = $target . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
    if ($item->isDir()) {
        if (!is_dir($dest)) {
            mkdir($dest, 0775, true);
        }
    } else {
        copy($item->getPathname(), $dest);
    }
}

fwrite(STDOUT, "Bootstrap assets copied to public/assets/vendor/bootstrap\n");
