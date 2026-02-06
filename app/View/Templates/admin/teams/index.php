<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h5">Teams</h2>
    <a class="btn btn-primary btn-sm" href="/admin/teams/new">New</a>
</div>
<table class="table table-striped bg-white">
    <thead>
        <tr><th>ID</th><th>Name</th></tr>
    </thead>
    <tbody>
        <?php foreach ($teams as $team): ?>
            <tr>
                <td><?= htmlspecialchars((string) $team['id']) ?></td>
                <td><?= htmlspecialchars((string) $team['name']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = 'Teams';
require __DIR__ . '/../../../Components/layout.php';
