<?php

declare(strict_types=1);

use App\Support\Config;

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
$appName = $settings['app_name'] ?? Config::get('app.name', 'Z1 Helpdesk');
$defaultLocale = $settings['default_locale'] ?? Config::get('i18n.default', 'en-US');
?>
<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="h5">Settings</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">Please fix the errors.</div>
        <?php endif; ?>
        <form method="post" action="/admin/settings">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Security\Csrf::token()) ?>">
            <div class="mb-3">
                <label class="form-label">App Name</label>
                <input class="form-control" name="app_name" value="<?= htmlspecialchars((string) $appName) ?>" required>
                <?php if (!empty($errors['app_name'])): ?><div class="text-danger"><?= htmlspecialchars($errors['app_name']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Default Locale</label>
                <select class="form-select" name="default_locale" required>
                    <option value="en-US" <?= $defaultLocale === 'en-US' ? 'selected' : '' ?>>en-US</option>
                    <option value="pt-BR" <?= $defaultLocale === 'pt-BR' ? 'selected' : '' ?>>pt-BR</option>
                </select>
                <?php if (!empty($errors['default_locale'])): ?><div class="text-danger"><?= htmlspecialchars($errors['default_locale']) ?></div><?php endif; ?>
            </div>
            <button class="btn btn-primary" type="submit">Save</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Settings';
require __DIR__ . '/../../../Components/layout.php';
