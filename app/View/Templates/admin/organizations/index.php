<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h5">Organizations</h2>
    <a class="btn btn-primary btn-sm" href="/admin/organizations/new">New</a>
</div>
<table class="table table-striped bg-white">
    <thead>
        <tr><th>ID</th><th>Name</th></tr>
    </thead>
    <tbody>
        <?php foreach ($organizations as $organization): ?>
            <tr>
                <td><?= htmlspecialchars((string) $organization['id']) ?></td>
                <td><?= htmlspecialchars((string) $organization['name']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = 'Organizations';
require __DIR__ . '/../../../Components/layout.php';
