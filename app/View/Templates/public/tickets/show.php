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
<div class="card shadow-sm mt-3">
    <div class="card-body">
        <h3 class="h6">Reply</h3>
        <?php if (!empty($errors['message'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errors['message']) ?></div>
        <?php endif; ?>
        <form method="post" action="/public/tickets/<?= htmlspecialchars((string) $ticket['public_token']) ?>/reply" enctype="multipart/form-data">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Security\Csrf::token()) ?>">
            <div class="mb-3">
                <textarea class="form-control" name="message" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Attachment</label>
                <input class="form-control" type="file" name="attachment">
            </div>
            <button class="btn btn-primary" type="submit">Send Reply</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Ticket';
require __DIR__ . '/../../../Components/layout.php';
