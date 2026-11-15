<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
require_post();

/* איפוס ההתקדמות השמורה בשרת של משתמש אחד. */
require_admin();
$in = json_input();
$email = normalize_email((string)($in['email'] ?? ''));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) json_error('bad_email');
$pdo = get_pdo();
$q = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$q->execute([$email]);
$u = $q->fetch();
if (!$u) json_error('not_found', 404);
$pdo->prepare('DELETE FROM progress WHERE user_id = ?')->execute([$u['id']]);
json_out(['ok' => true, 'email' => $email]);
