<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
/* פרקים שעוד לא נלמדו בכיתה.
   GET (כל משתמש מחובר): {notyet: {"/branch/training/": ["zones", ...]}}
   GET ?catalog=1 (מנהל): גם רשימת כל העמודים והפרקים, לעמוד הניהול.
   POST (מנהל): {url, chapter, on} מסמן או מבטל סימון של פרק. */
header('Cache-Control: private, no-store');
$u = current_user();
if (!$u) json_error('not_logged_in', 401);
$catalog = require __DIR__ . '/_catalog.php';
$valid = [];
foreach ($catalog as $p) foreach ($p['chapters'] as $c) $valid[$p['url']][$c['id']] = true;

$map = setting_get('notyet', []);
if (!is_array($map)) $map = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_admin();
    $in = json_input();
    $url = (string)($in['url'] ?? ''); $ch = (string)($in['chapter'] ?? '');
    if (empty($valid[$url][$ch])) json_error('bad_chapter');
    $list = array_values(array_filter($map[$url] ?? [], fn($x) => $x !== $ch && !empty($valid[$url][$x])));
    if (!empty($in['on'])) $list[] = $ch;
    if ($list) $map[$url] = $list; else unset($map[$url]);
    setting_set('notyet', $map);
}
$out = ['ok' => true, 'notyet' => (object)$map];
if (!empty($_GET['catalog']) && is_admin($u)) $out['catalog'] = $catalog;
json_out($out);
