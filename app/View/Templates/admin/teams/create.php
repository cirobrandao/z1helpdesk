<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
?>
<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="h5">Create Team</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">Please fix the errors.</div>
        <?php endif; ?>
        <form method="post" action="/admin/teams">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Security\Csrf::token()) ?>">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input class="form-control" name="name" required>
                <?php if (!empty($errors['name'])): ?><div class="text-danger"><?= htmlspecialchars($errors['name']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Members</label>
                <select class="form-select" name="members[]" multiple size="6">
                    <?php foreach ($agents as $agent): ?>
                        <option value="<?= htmlspecialchars((string) $agent['id']) ?>">
                            <?= htmlspecialchars((string) $agent['name']) ?> (<?= htmlspecialchars((string) $agent['email']) ?>)
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
$title = 'Create Team';
require __DIR__ . '/../../../Components/layout.php';
