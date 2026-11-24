<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
require_post();

$in = json_input();
$email = normalize_email((string)($in['email'] ?? ''));
$code = preg_replace('/\D/', '', (string)($in['code'] ?? ''));
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($code) !== 6) json_error('bad_code');

ensure_schema();
$pdo = get_pdo();
$q = $pdo->prepare('SELECT id, code_hash, attempts, reg_name, reg_course FROM login_codes WHERE email = ? AND expires_at > ? ORDER BY id DESC LIMIT 1');
$q->execute([$email, now_sql()]);
$row = $q->fetch();
if (!$row) json_error('expired');
if ((int)$row['attempts'] >= MAX_ATTEMPTS) json_error('too_many', 429);
if (!password_verify($code, $row['code_hash'])) {
    $pdo->prepare('UPDATE login_codes SET attempts = attempts + 1 WHERE id = ?')->execute([$row['id']]);
    json_error('bad_code');
}
// A code works once.
$pdo->prepare('UPDATE login_codes SET expires_at = ? WHERE email = ?')->execute([now_sql('-1 second'), $email]);

$q = $pdo->prepare('SELECT id, last_login_at, science_access, branch_access, display_name, requested_course FROM users WHERE email = ?');
$q->execute([$email]);
$user = $q->fetch();
$regName = $row['reg_name'] ?: null;
$regCourse = clean_course($row['reg_course'] ?? '');
if (!$user) {
    $isAdmin = in_array($email, admin_emails(), true);
    // New users only come through registration (name + course); they wait for the admin's approval.
    if (!$isAdmin && ($regName === null || $regCourse === null)) json_error('not_registered', 404);
    $pdo->prepare('INSERT INTO users (email, created_at, display_name, requested_course, branch_access, science_access) VALUES (?, ?, ?, ?, 0, 0)')
        ->execute([$email, now_sql(), $regName, $regCourse]);
    $userId = (int)$pdo->lastInsertId();
    if (!$isAdmin) notify_registration($email, $regName, $regCourse);
} else {
    $userId = (int)$user['id'];
    $waiting = (int)$user['branch_access'] !== 1 && (int)$user['science_access'] !== 1;
    if ($regName !== null && $regCourse !== null && $waiting) {
        // Registered again while still waiting (or approved in advance with no access): keep the newest details.
        $pdo->prepare('UPDATE users SET display_name = COALESCE(display_name, ?), requested_course = ? WHERE id = ?')
            ->execute([$regName, $regCourse, $userId]);
        if (empty($user['requested_course'])) notify_registration($email, $regName, $regCourse);
    } elseif (empty($user['last_login_at']) && !$waiting) {
        // Approved in advance by the admin and logging in for the first time.
        notify_new_user($email, (int)$user['branch_access'] === 1, (int)$user['science_access'] === 1);
    }
    if ($regName !== null && empty($user['display_name'])) {
        $pdo->prepare('UPDATE users SET display_name = ? WHERE id = ?')->execute([$regName, $userId]);
    }
}
$first = !$user || empty($user['last_login_at']);
$pdo->prepare('UPDATE users SET last_login_at = ? WHERE id = ?')->execute([now_sql(), $userId]);

$token = bin2hex(random_bytes(32));
$pdo->prepare('INSERT INTO sessions (token, user_id, expires_at) VALUES (?, ?, ?)')
    ->execute([$token, $userId, now_sql('+' . SESSION_DAYS . ' days')]);
$pdo->prepare('DELETE FROM sessions WHERE expires_at < ?')->execute([now_sql()]);
set_session_cookie($token, SESSION_DAYS);

$q = $pdo->prepare('SELECT id, email, science_access, branch_access, requested_course, display_name FROM users WHERE id = ?');
$q->execute([$userId]);
$u = $q->fetch();
// first: the client offers to set a name (optional) the first time someone logs in.
json_out_with_progress(load_progress($userId), auth_fields($u) + ['first' => $first && empty($u['display_name'])]);
