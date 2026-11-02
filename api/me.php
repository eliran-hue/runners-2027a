<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';

$u = current_user();
if (!$u) json_out(['ok' => true, 'email' => null]);
json_out_with_progress(load_progress((int)$u['id']), ['email' => $u['email']]);
