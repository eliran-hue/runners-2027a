<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
require_post();

/* mode=login: only for emails that are already registered (or approved in advance by the admin).
   mode=register: full name + course; the details are kept with the code and the user is created only after the email is verified. */
$in = json_input();
$email = normalize_email((string)($in['email'] ?? ''));
if (strlen($email) > 190 || !filter_var($email, FILTER_VALIDATE_EMAIL)) json_error('bad_email');
$register = ($in['mode'] ?? 'login') === 'register';
$regName = $regCourse = null;
if ($register) {
    $regName = clean_name((string)($in['name'] ?? ''));
    if ($regName === null || mb_strlen($regName) < 2) json_error('bad_name');
    $regCourse = clean_course($in['course'] ?? '');
    if ($regCourse === null) json_error('bad_course');
}

ensure_schema();
$pdo = get_pdo();
$q = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$q->execute([$email]);
$exists = (bool)$q->fetch();
if (!$register && !$exists && !in_array($email, admin_emails(), true)) json_error('not_registered', 404);
$ip = client_ip();

// Limits: one code per email per minute, 5 per email per hour, 20 per IP per hour.
$q = $pdo->prepare('SELECT COUNT(*) n, MAX(created_at) last FROM login_codes WHERE email = ? AND created_at > ?');
$q->execute([$email, now_sql('-1 hour')]);
$r = $q->fetch();
if ((int)$r['n'] >= 5) json_error('too_many', 429);
if ($r['last'] && strtotime((string)$r['last']) > time() - 60) json_error('wait', 429);
$q = $pdo->prepare('SELECT COUNT(*) n FROM login_codes WHERE ip = ? AND created_at > ?');
$q->execute([$ip, now_sql('-1 hour')]);
if ((int)$q->fetch()['n'] >= 20) json_error('too_many', 429);

$code = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
$pdo->prepare('INSERT INTO login_codes (email, code_hash, ip, expires_at, created_at, reg_name, reg_course) VALUES (?, ?, ?, ?, ?, ?, ?)')
    ->execute([$email, password_hash($code, PASSWORD_DEFAULT), $ip, now_sql('+' . CODE_MINUTES . ' minutes'), now_sql(), $regName, $regCourse]);

// Old rows are only needed for the rate limits above.
$pdo->prepare('DELETE FROM login_codes WHERE created_at < ?')->execute([now_sql('-1 day')]);

if (!send_code_email($email, $code)) json_error('mail_failed', 500);
// registered: the email already has an account, so the code simply logs in.
json_out(['ok' => true, 'registered' => $exists]);
