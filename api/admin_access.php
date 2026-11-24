<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
require_post();

/* מתן או ביטול גישה לקורס הענפי ו/או לקורס המדעי (שולחים רק את מה שמשתנה: branch / science).
   מייל שעוד לא נרשם נוסף לרשימה כמאושר מראש. כשמשתמש שחיכה לאישור מקבל גישה, נשלח אליו מייל. */
require_admin();
ensure_schema();
$in = json_input();
$email = normalize_email((string)($in['email'] ?? ''));
if (strlen($email) > 190 || !filter_var($email, FILTER_VALIDATE_EMAIL)) json_error('bad_email');
$set = [];
foreach (['branch', 'science'] as $k) if (array_key_exists($k, $in)) $set[$k . '_access'] = !empty($in[$k]) ? 1 : 0;
if (!$set) json_error('nothing_to_change');

$pdo = get_pdo();
$q = $pdo->prepare('SELECT id, display_name, last_login_at, branch_access, science_access FROM users WHERE email = ?');
$q->execute([$email]);
$before = $q->fetch();
if ($before) {
    $sql = implode(', ', array_map(fn($c) => "$c = ?", array_keys($set)));
    $pdo->prepare("UPDATE users SET $sql WHERE email = ?")->execute([...array_values($set), $email]);
} else {
    $pdo->prepare('INSERT INTO users (email, created_at, branch_access, science_access) VALUES (?, ?, ?, ?)')
        ->execute([$email, now_sql(), $set['branch_access'] ?? 0, $set['science_access'] ?? 0]);
}
$q->execute([$email]);
$u = $q->fetch();
$branch = (int)$u['branch_access'] === 1; $science = (int)$u['science_access'] === 1;
$notified = false;
// A user who registered and was waiting: tell them the site is open now (only on the first approval).
if ($before && !empty($before['last_login_at']) && (int)$before['branch_access'] !== 1 && (int)$before['science_access'] !== 1 && ($branch || $science)
    && !in_array($email, admin_emails(), true)) {
    notify_approved($email, $u['display_name'] ?: null, $branch, $science);
    $notified = true;
}
json_out(['ok' => true, 'email' => $email, 'branch' => $branch, 'science' => $science, 'notified' => $notified]);
