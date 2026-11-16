<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
require_post();

/* עריכת השם של משתמש על ידי המנהל. ריק = מחיקת השם. */
require_admin();
ensure_schema();
$in = json_input();
$email = normalize_email((string)($in['email'] ?? ''));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) json_error('bad_email');
$name = clean_name((string)($in['name'] ?? ''));
$q = get_pdo()->prepare('UPDATE users SET display_name = ? WHERE email = ?');
$q->execute([$name, $email]);
if ($q->rowCount() === 0) {
    $c = get_pdo()->prepare('SELECT 1 FROM users WHERE email = ?');
    $c->execute([$email]);
    if (!$c->fetch()) json_error('not_found', 404);
}
json_out(['ok' => true, 'email' => $email, 'name' => $name]);
