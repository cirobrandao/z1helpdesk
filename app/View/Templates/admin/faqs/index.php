<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../../Components/admin_nav.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h5">FAQ</h2>
    <a class="btn btn-primary btn-sm" href="/admin/faqs/new">New</a>
</div>
<table class="table table-striped bg-white">
    <thead>
        <tr><th>ID</th><th>Question</th><th>Category</th></tr>
    </thead>
    <tbody>
        <?php foreach ($faqs as $faq): ?>
            <tr>
                <td><?= htmlspecialchars((string) $faq['id']) ?></td>
                <td><?= htmlspecialchars((string) $faq['question']) ?></td>
                <td><?= htmlspecialchars((string) $faq['category']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = 'FAQ';
require __DIR__ . '/../../../Components/layout.php';
