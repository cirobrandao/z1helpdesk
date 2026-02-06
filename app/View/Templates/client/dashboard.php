<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../Components/admin_nav.php';
?>
<h2 class="h5">Client Portal</h2>
<p><a class="btn btn-primary btn-sm" href="/client/tickets/new">Open Ticket</a></p>
<table class="table table-striped bg-white">
    <thead>
        <tr><th>ID</th><th>Subject</th><th>Status</th></tr>
    </thead>
    <tbody>
        <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td><?= htmlspecialchars((string) $ticket['id']) ?></td>
                <td><?= htmlspecialchars((string) $ticket['subject']) ?></td>
                <td><?= htmlspecialchars((string) $ticket['status']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = 'Client Portal';
require __DIR__ . '/../../Components/layout.php';
