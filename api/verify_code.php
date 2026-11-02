<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
require_post();

$in = json_input();
$email = normalize_email((string)($in['email'] ?? ''));
$code = preg_replace('/\D/', '', (string)($in['code'] ?? ''));
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($code) !== 6) json_error('bad_code');

$pdo = get_pdo();
$q = $pdo->prepare('SELECT id, code_hash, attempts FROM login_codes WHERE email = ? AND expires_at > ? ORDER BY id DESC LIMIT 1');
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

$q = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$q->execute([$email]);
$user = $q->fetch();
if (!$user) {
    $pdo->prepare('INSERT INTO users (email, created_at) VALUES (?, ?)')->execute([$email, now_sql()]);
    $userId = (int)$pdo->lastInsertId();
} else {
    $userId = (int)$user['id'];
}
$pdo->prepare('UPDATE users SET last_login_at = ? WHERE id = ?')->execute([now_sql(), $userId]);

$token = bin2hex(random_bytes(32));
$pdo->prepare('INSERT INTO sessions (token, user_id, expires_at) VALUES (?, ?, ?)')
    ->execute([$token, $userId, now_sql('+' . SESSION_DAYS . ' days')]);
$pdo->prepare('DELETE FROM sessions WHERE expires_at < ?')->execute([now_sql()]);
set_session_cookie($token, SESSION_DAYS);

json_out_with_progress(load_progress($userId), ['email' => $email]);
