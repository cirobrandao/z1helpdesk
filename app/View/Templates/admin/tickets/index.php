<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
?>
<h2 class="h5 mb-3">Tickets</h2>
<table class="table table-striped bg-white">
    <thead>
        <tr><th>ID</th><th>Subject</th><th>Status</th><th>Customer</th><th>Assigned</th><th></th></tr>
    </thead>
    <tbody>
        <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td><?= htmlspecialchars((string) $ticket['id']) ?></td>
                <td><?= htmlspecialchars((string) $ticket['subject']) ?></td>
                <td><?= htmlspecialchars((string) $ticket['status']) ?></td>
                <td><?= htmlspecialchars((string) ($ticket['customer_name'] ?? 'Public')) ?></td>
                <td><?= htmlspecialchars((string) ($ticket['assigned_name'] ?? 'Unassigned')) ?></td>
                <td><a class="btn btn-sm btn-outline-primary" href="/admin/tickets/<?= htmlspecialchars((string) $ticket['id']) ?>">View</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = 'Tickets';
require __DIR__ . '/../../../Components/layout.php';
