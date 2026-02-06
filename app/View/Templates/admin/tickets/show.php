<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
?>
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h2 class="h5">Ticket #<?= htmlspecialchars((string) $ticket['id']) ?></h2>
        <p><strong>Subject:</strong> <?= htmlspecialchars((string) $ticket['subject']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars((string) $ticket['status']) ?></p>
        <p><strong>Assigned:</strong> <?= htmlspecialchars((string) ($ticket['assigned_name'] ?? 'Unassigned')) ?></p>
    </div>
</div>
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h3 class="h6">Assign Ticket</h3>
        <?php if (!empty($errors['assigned_user_id'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errors['assigned_user_id']) ?></div>
        <?php endif; ?>
        <form method="post" action="/admin/tickets/<?= htmlspecialchars((string) $ticket['id']) ?>/assign">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Security\Csrf::token()) ?>">
            <div class="mb-3">
                <select class="form-select" name="assigned_user_id" required>
                    <option value="">Select agent</option>
                    <?php foreach ($agents as $agent): ?>
                        <option value="<?= htmlspecialchars((string) $agent['id']) ?>" <?= (string) $agent['id'] === (string) ($ticket['assigned_user_id'] ?? '') ? 'selected' : '' ?>>
                            <?= htmlspecialchars((string) $agent['name']) ?> (<?= htmlspecialchars((string) $agent['email']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn btn-outline-primary btn-sm" type="submit">Assign</button>
        </form>
    </div>
</div>
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h3 class="h6">Messages</h3>
        <?php foreach ($messages as $message): ?>
            <div class="border rounded p-2 mb-2 bg-light">
                <p class="mb-1"><?= nl2br(htmlspecialchars((string) $message['message'])) ?></p>
                <small class="text-muted"><?= htmlspecialchars((string) $message['created_at']) ?></small>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <h3 class="h6">Reply</h3>
        <?php if (!empty($errors['message'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errors['message']) ?></div>
        <?php endif; ?>
        <form method="post" action="/admin/tickets/<?= htmlspecialchars((string) $ticket['id']) ?>/reply" enctype="multipart/form-data">
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
        <form method="post" action="/admin/tickets/<?= htmlspecialchars((string) $ticket['id']) ?>/close" class="mt-2">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Security\Csrf::token()) ?>">
            <button class="btn btn-outline-danger btn-sm" type="submit">Close Ticket</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Ticket Details';
require __DIR__ . '/../../../Components/layout.php';
