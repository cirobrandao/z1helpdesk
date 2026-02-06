<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../Components/public_nav.php';
?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">Admin Login</h2>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($errors['login'] ?? $errors['password'] ?? 'Login failed.') ?></div>
                <?php endif; ?>
                <form method="post" action="/admin/login">
                    <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Security\Csrf::token()) ?>">
                    <div class="mb-3">
                        <label class="form-label">Email or Username</label>
                        <input class="form-control" name="login" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Login';
require __DIR__ . '/../../Components/layout.php';
