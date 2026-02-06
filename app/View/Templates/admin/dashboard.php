<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../Components/admin_nav.php';
?>
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h5">Admin Dashboard</h2>
                <p>Welcome back, <?= htmlspecialchars((string) ($user['name'] ?? 'Admin')) ?>.</p>
                <div class="list-group">
                    <a class="list-group-item" href="/admin/departments">Manage Departments</a>
                    <a class="list-group-item" href="/admin/sectors">Manage Sectors</a>
                    <a class="list-group-item" href="/admin/faqs">Manage FAQ</a>
                    <a class="list-group-item" href="/admin/tickets">View Tickets</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Admin Dashboard';
require __DIR__ . '/../../Components/layout.php';
