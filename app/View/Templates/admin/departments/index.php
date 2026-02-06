<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h5">Departments</h2>
    <a class="btn btn-primary btn-sm" href="/admin/departments/new">New</a>
</div>
<table class="table table-striped bg-white">
    <thead>
        <tr><th>ID</th><th>Name</th></tr>
    </thead>
    <tbody>
        <?php foreach ($departments as $department): ?>
            <tr>
                <td><?= htmlspecialchars((string) $department['id']) ?></td>
                <td><?= htmlspecialchars((string) $department['name']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = 'Departments';
require __DIR__ . '/../../../Components/layout.php';
