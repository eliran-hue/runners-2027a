<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
require_post();

/* מונה כניסות: רישום צפייה בעמוד. לא נשמרים IP או פרטי דפדפן, רק עמוד, מזהה מבקר אקראי ומשתמש (אם מחובר).
   כניסות של המנהל לא נספרות. רענון של אותו עמוד על ידי אותו מבקר תוך 5 דקות לא נספר שוב. */
$in = json_input();
$path = (string)($in['path'] ?? '');
$visitor = (string)($in['v'] ?? '');
$path = preg_replace('~/index\.html$~', '/', $path);
if (!preg_match('~^/[a-z0-9/_.-]{0,90}$~', $path) || !preg_match('~^[a-f0-9]{32}$~', $visitor)) json_error('bad_input');

$pdo = get_pdo();
ensure_views_table($pdo);
$user = current_user();
if ($user && is_admin($user)) json_out(['ok' => true, 'skipped' => 'admin']);

$q = $pdo->prepare('SELECT 1 FROM page_views WHERE visitor = ? AND path = ? AND created_at > ? LIMIT 1');
$q->execute([$visitor, $path, now_sql('-5 minutes')]);
if (!$q->fetch()) {
    $pdo->prepare('INSERT INTO page_views (path, visitor, user_id, created_at) VALUES (?, ?, ?, ?)')
        ->execute([$path, $visitor, $user ? (int)$user['id'] : null, now_sql()]);
}
json_out(['ok' => true]);
