<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h5">Users</h2>
    <a class="btn btn-primary btn-sm" href="/admin/users/new">New</a>
</div>
<table class="table table-striped bg-white">
    <thead>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Username</th></tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars((string) $user['id']) ?></td>
                <td><?= htmlspecialchars((string) $user['name']) ?></td>
                <td><?= htmlspecialchars((string) $user['email']) ?></td>
                <td><?= htmlspecialchars((string) $user['username']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = 'Users';
require __DIR__ . '/../../../Components/layout.php';
