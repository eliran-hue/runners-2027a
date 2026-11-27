<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
/* פרקים שעוד לא נלמדו בכיתה.
   GET (כל משתמש מחובר): {notyet: {"/branch/training/": ["zones", ...]}, learning: {...}}
   notyet = עוד לא נלמד בכיתה, learning = בלימוד עכשיו. פרק שלא מופיע באף אחד מהם = נלמד.
   GET ?catalog=1 (מנהל): גם רשימת כל העמודים והפרקים, לעמוד הניהול.
   POST (מנהל): {url, chapter, state: "done"|"learning"|"notyet"} (או on=true/false כמו פעם). */
header('Cache-Control: private, no-store');
$u = current_user();
if (!$u) json_error('not_logged_in', 401);
$catalog = require __DIR__ . '/_catalog.php';
$valid = [];
foreach ($catalog as $p) foreach ($p['chapters'] as $c) $valid[$p['url']][$c['id']] = true;

$maps = ['notyet' => setting_get('notyet', []), 'learning' => setting_get('learning', [])];
foreach ($maps as $k => $m) if (!is_array($m)) $maps[$k] = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_admin();
    $in = json_input();
    $url = (string)($in['url'] ?? ''); $ch = (string)($in['chapter'] ?? '');
    if (empty($valid[$url][$ch])) json_error('bad_chapter');
    $state = (string)($in['state'] ?? (!empty($in['on']) ? 'notyet' : 'done'));
    if (!in_array($state, ['done', 'learning', 'notyet'], true)) json_error('bad_state');
    foreach ($maps as $k => $map) {
        $list = array_values(array_filter($map[$url] ?? [], fn($x) => $x !== $ch && !empty($valid[$url][$x])));
        if ($state === $k) $list[] = $ch;
        if ($list) $map[$url] = $list; else unset($map[$url]);
        $maps[$k] = $map;
        setting_set($k, $map);
    }
}
$out = ['ok' => true, 'notyet' => (object)$maps['notyet'], 'learning' => (object)$maps['learning']];
if (!empty($_GET['catalog']) && is_admin($u)) $out['catalog'] = $catalog;
json_out($out);
