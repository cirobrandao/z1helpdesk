<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/public_nav.php';
?>
<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="h5">Ticket #<?= htmlspecialchars((string) $ticket['id']) ?></h2>
        <p><strong>Subject:</strong> <?= htmlspecialchars((string) $ticket['subject']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars((string) $ticket['status']) ?></p>
        <hr>
        <h3 class="h6">Messages</h3>
        <?php foreach ($messages as $message): ?>
            <div class="border rounded p-2 mb-2 bg-light">
                <p class="mb-1"><?= nl2br(htmlspecialchars((string) $message['message'])) ?></p>
                <small class="text-muted"><?= htmlspecialchars((string) $message['created_at']) ?></small>
            </div>
        <?php endforeach; ?>
        <div class="alert alert-info">Save this link to track your ticket.</div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Ticket';
require __DIR__ . '/../../../Components/layout.php';
