<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
require_post();

/* מתן או ביטול גישה לקורס המדעי. מייל שעוד לא נרשם נוסף לרשימה כמאושר מראש. */
require_admin();
$in = json_input();
$email = normalize_email((string)($in['email'] ?? ''));
if (strlen($email) > 190 || !filter_var($email, FILTER_VALIDATE_EMAIL)) json_error('bad_email');
$science = !empty($in['science']) ? 1 : 0;

$pdo = get_pdo();
$q = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$q->execute([$email]);
if ($q->fetch()) {
    $pdo->prepare('UPDATE users SET science_access = ? WHERE email = ?')->execute([$science, $email]);
} else {
    $pdo->prepare('INSERT INTO users (email, created_at, science_access) VALUES (?, ?, ?)')->execute([$email, now_sql(), $science]);
}
json_out(['ok' => true, 'email' => $email, 'science' => (bool)$science]);
