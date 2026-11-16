<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
require_post();

/* שם להצגה (לא חובה). ריק = מחיקת השם. */
$u = require_user();
$name = clean_name((string)(json_input()['name'] ?? ''));
get_pdo()->prepare('UPDATE users SET display_name = ? WHERE id = ?')->execute([$name, (int)$u['id']]);
json_out(['ok' => true, 'name' => $name]);
