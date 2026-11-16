<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';

/* מונה כניסות לעמוד הניהול: לפי עמוד, ולפי יום, בטווח של days ימים (0 = מההתחלה). */
require_admin();
$days = max(0, min(3650, (int)($_GET['days'] ?? 30)));
$from = $days ? now_sql('-' . $days . ' days') : '1970-01-01 00:00:00';
$pdo = get_pdo();
ensure_views_table($pdo);

$q = $pdo->prepare('SELECT path,
        COUNT(*) AS views,
        COUNT(DISTINCT visitor) AS visitors,
        SUM(CASE WHEN user_id IS NULL THEN 1 ELSE 0 END) AS anon_views,
        SUM(CASE WHEN user_id IS NULL THEN 0 ELSE 1 END) AS user_views,
        COUNT(DISTINCT user_id) AS users,
        MAX(created_at) AS last_at
    FROM page_views WHERE created_at >= ? GROUP BY path ORDER BY views DESC');
$q->execute([$from]);
$pages = array_map(function ($r) {
    foreach (['views', 'visitors', 'anon_views', 'user_views', 'users'] as $k) $r[$k] = (int)$r[$k];
    return $r;
}, $q->fetchAll());

$t = $pdo->prepare('SELECT COUNT(*) AS views, COUNT(DISTINCT visitor) AS visitors, COUNT(DISTINCT user_id) AS users,
        SUM(CASE WHEN user_id IS NULL THEN 1 ELSE 0 END) AS anon_views FROM page_views WHERE created_at >= ?');
$t->execute([$from]);
$tot = array_map('intval', $t->fetch());

$d = $pdo->prepare('SELECT SUBSTR(created_at, 1, 10) AS day, COUNT(*) AS views, COUNT(DISTINCT visitor) AS visitors
    FROM page_views WHERE created_at >= ? GROUP BY SUBSTR(created_at, 1, 10) ORDER BY day');
$d->execute([now_sql('-13 days')]);
$daily = array_map(fn($r) => ['day' => $r['day'], 'views' => (int)$r['views'], 'visitors' => (int)$r['visitors']], $d->fetchAll());

json_out(['ok' => true, 'days' => $days, 'total' => $tot, 'pages' => $pages, 'daily' => $daily]);
