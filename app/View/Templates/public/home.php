<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../Components/public_nav.php';
?>
<div class="p-5 mb-4 bg-white rounded shadow-sm">
    <h1 class="display-6">Welcome to Z1 Helpdesk</h1>
    <p class="lead">Open a ticket or track an existing request using your public token.</p>
    <a class="btn btn-primary" href="/public/tickets/new">Open Ticket</a>
</div>
<?php
$content = ob_get_clean();
$title = 'Helpdesk Home';
require __DIR__ . '/../../Components/layout.php';
