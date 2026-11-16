<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
require_post();

/* מחיקת משתמש עם כל ההיסטוריה שלו: התקדמות, חיבורים פעילים, קודי כניסה, והמשתמש עצמו. מנהלים לא נמחקים. */
require_admin();
$in = json_input();
$email = normalize_email((string)($in['email'] ?? ''));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) json_error('bad_email');
if (in_array($email, admin_emails(), true)) json_error('is_admin', 403);
$pdo = get_pdo();
$q = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$q->execute([$email]);
$u = $q->fetch();
$pdo->beginTransaction();
if ($u) {
    $pdo->prepare('DELETE FROM progress WHERE user_id = ?')->execute([$u['id']]);
    $pdo->prepare('DELETE FROM sessions WHERE user_id = ?')->execute([$u['id']]);
    ensure_views_table($pdo);
    $pdo->prepare('DELETE FROM page_views WHERE user_id = ?')->execute([$u['id']]);
    $pdo->prepare('DELETE FROM users WHERE id = ?')->execute([$u['id']]);
}
$pdo->prepare('DELETE FROM login_codes WHERE email = ?')->execute([$email]);
$pdo->commit();
json_out(['ok' => true, 'email' => $email]);
