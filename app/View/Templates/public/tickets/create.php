<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/public_nav.php';
?>
<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="h5 mb-3">Open a Ticket</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">Please fix the highlighted fields.</div>
        <?php endif; ?>
        <form method="post" action="/public/tickets">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Security\Csrf::token()) ?>">
            <div class="mb-3">
                <label class="form-label">Subject</label>
                <input class="form-control" name="subject" required>
                <?php if (!empty($errors['subject'])): ?><div class="text-danger"><?= htmlspecialchars($errors['subject']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea class="form-control" name="message" rows="5" required></textarea>
                <?php if (!empty($errors['message'])): ?><div class="text-danger"><?= htmlspecialchars($errors['message']) ?></div><?php endif; ?>
            </div>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Open Ticket';
require __DIR__ . '/../../../Components/layout.php';
