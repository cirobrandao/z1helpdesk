<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
?>
<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="h5">Create FAQ</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">Please fix the errors.</div>
        <?php endif; ?>
        <form method="post" action="/admin/faqs">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Security\Csrf::token()) ?>">
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select class="form-select" name="category_id" required>
                    <option value="">Select</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars((string) $category['id']) ?>">
                            <?= htmlspecialchars((string) $category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['category_id'])): ?><div class="text-danger"><?= htmlspecialchars($errors['category_id']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Question</label>
                <input class="form-control" name="question" required>
                <?php if (!empty($errors['question'])): ?><div class="text-danger"><?= htmlspecialchars($errors['question']) ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Answer</label>
                <textarea class="form-control" name="answer" rows="4" required></textarea>
                <?php if (!empty($errors['answer'])): ?><div class="text-danger"><?= htmlspecialchars($errors['answer']) ?></div><?php endif; ?>
            </div>
            <button class="btn btn-primary" type="submit">Save</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Create FAQ';
require __DIR__ . '/../../../Components/layout.php';
