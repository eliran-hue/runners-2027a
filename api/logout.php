<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
require_post();

$token = $_COOKIE['runners_session'] ?? '';
if (preg_match('/^[a-f0-9]{64}$/', $token)) {
    get_pdo()->prepare('DELETE FROM sessions WHERE token = ?')->execute([$token]);
}
set_session_cookie('', 0);
json_out(['ok' => true]);
