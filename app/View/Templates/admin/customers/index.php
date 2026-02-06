<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h5">Customers</h2>
    <a class="btn btn-primary btn-sm" href="/admin/customers/new">New</a>
</div>
<table class="table table-striped bg-white">
    <thead>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= htmlspecialchars((string) $customer['id']) ?></td>
                <td><?= htmlspecialchars((string) $customer['name']) ?></td>
                <td><?= htmlspecialchars((string) $customer['email']) ?></td>
                <td><?= htmlspecialchars((string) $customer['phone']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = 'Customers';
require __DIR__ . '/../../../Components/layout.php';
