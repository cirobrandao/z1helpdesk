<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
?>
<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="h5">Open Ticket</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">Please fix the errors.</div>
        <?php endif; ?>
        <form method="post" action="/client/tickets">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Security\Csrf::token()) ?>">
            <div class="mb-3">
                <label class="form-label">Subject</label>
                <input class="form-control" name="subject" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea class="form-control" name="message" rows="4" required></textarea>
            </div>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Open Ticket';
require __DIR__ . '/../../../Components/layout.php';
