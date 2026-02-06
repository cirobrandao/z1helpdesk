<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h5">Sectors</h2>
    <a class="btn btn-primary btn-sm" href="/admin/sectors/new">New</a>
</div>
<table class="table table-striped bg-white">
    <thead>
        <tr><th>ID</th><th>Name</th></tr>
    </thead>
    <tbody>
        <?php foreach ($sectors as $sector): ?>
            <tr>
                <td><?= htmlspecialchars((string) $sector['id']) ?></td>
                <td><?= htmlspecialchars((string) $sector['name']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = 'Sectors';
require __DIR__ . '/../../../Components/layout.php';
