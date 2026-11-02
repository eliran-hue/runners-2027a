<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
require_post();

$u = require_user();
$raw = (string)file_get_contents('php://input');
if (strlen($raw) > MAX_PROGRESS_BYTES) json_error('too_large', 413);
$data = json_decode($raw);
if (!($data instanceof stdClass)) json_error('bad_json');

$pdo = get_pdo();
$pdo->beginTransaction();
$pdo->prepare('DELETE FROM progress WHERE user_id = ?')->execute([$u['id']]);
$pdo->prepare('INSERT INTO progress (user_id, data, updated_at) VALUES (?, ?, ?)')
    ->execute([$u['id'], $raw, now_sql()]);
$pdo->commit();
json_out(['ok' => true]);
