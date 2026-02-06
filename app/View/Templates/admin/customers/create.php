<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
?>
<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="h5">Create Customer</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">Please fix the errors.</div>
        <?php endif; ?>
        <form method="post" action="/admin/customers">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Security\Csrf::token()) ?>">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input class="form-control" name="name" required>
                <?php if (!empty($errors['name'])): ?><div class="text-danger"><?= htmlspecialchars($errors['name']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input class="form-control" name="email" type="email" required>
                <?php if (!empty($errors['email'])): ?><div class="text-danger"><?= htmlspecialchars($errors['email']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input class="form-control" name="phone">
            </div>
            <div class="mb-3">
                <label class="form-label">Organization (optional)</label>
                <select class="form-select" name="organization_id">
                    <option value="">None</option>
                    <?php foreach ($organizations as $organization): ?>
                        <option value="<?= htmlspecialchars((string) $organization['id']) ?>">
                            <?= htmlspecialchars((string) $organization['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn btn-primary" type="submit">Save</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Create Customer';
require __DIR__ . '/../../../Components/layout.php';
