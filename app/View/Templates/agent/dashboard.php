<?php

declare(strict_types=1);

ob_start();
require __DIR__ . '/../../Components/admin_nav.php';
?>
<h2 class="h5">Agent Dashboard</h2>
<p>Use the admin ticket list to manage assigned tickets.</p>
<?php
$content = ob_get_clean();
$title = 'Agent Dashboard';
require __DIR__ . '/../../Components/layout.php';
