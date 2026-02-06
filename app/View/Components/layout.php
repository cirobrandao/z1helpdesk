<?php

declare(strict_types=1);

use App\Support\Config;
use App\Support\I18n;

$title = $title ?? Config::get('app.name', 'Z1 Helpdesk');
$content = $content ?? '';
?>
<!doctype html>
<html lang="<?= htmlspecialchars(I18n::getLocale()) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <main class="container py-4">
        <?= $content ?>
    </main>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
