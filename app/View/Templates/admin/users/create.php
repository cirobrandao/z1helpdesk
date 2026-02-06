<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
?>
<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="h5">Create User</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">Please fix the errors.</div>
        <?php endif; ?>
        <form method="post" action="/admin/users">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Security\Csrf::token()) ?>">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input class="form-control" name="name" required>
                <?php if (!empty($errors['name'])): ?><div class="text-danger"><?= htmlspecialchars($errors['name']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input class="form-control" name="username" required>
                <?php if (!empty($errors['username'])): ?><div class="text-danger"><?= htmlspecialchars($errors['username']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input class="form-control" name="email" type="email" required>
                <?php if (!empty($errors['email'])): ?><div class="text-danger"><?= htmlspecialchars($errors['email']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input class="form-control" name="password" type="password" required>
                <?php if (!empty($errors['password'])): ?><div class="text-danger"><?= htmlspecialchars($errors['password']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select class="form-select" name="role_id" required>
                    <option value="">Select</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= htmlspecialchars((string) $role['id']) ?>"><?= htmlspecialchars((string) $role['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['role_id'])): ?><div class="text-danger"><?= htmlspecialchars($errors['role_id']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Customer (optional)</label>
                <select class="form-select" name="customer_id">
                    <option value="">None</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= htmlspecialchars((string) $customer['id']) ?>">
                            <?= htmlspecialchars((string) $customer['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Locale</label>
                <select class="form-select" name="locale">
                    <option value="en-US">en-US</option>
                    <option value="pt-BR">pt-BR</option>
                </select>
            </div>
            <button class="btn btn-primary" type="submit">Save</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Create User';
require __DIR__ . '/../../../Components/layout.php';
