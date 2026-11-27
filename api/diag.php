<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
/* אבחון לפריסה: מה באמת קיים בשרת. רק למנהל. */
require_admin();
header('Content-Type: text/plain; charset=utf-8');
header('Cache-Control: private, no-store');
$root = realpath(__DIR__ . '/..');
echo "root: $root\n";
$head = @file_get_contents($root . '/.git/HEAD');
echo "git HEAD: " . trim((string)$head) . "\n";
if ($head && preg_match('#ref: (\S+)#', $head, $m)) echo "commit: " . trim((string)@file_get_contents($root . '/.git/' . $m[1])) . "\n";
echo "gate.php: " . date('Y-m-d H:i:s', (int)@filemtime(__DIR__ . '/gate.php')) . (strpos((string)@file_get_contents(__DIR__ . '/gate.php'), "'.html.php')") !== false ? ' (גרסה חדשה)' : ' (גרסה ישנה)') . "\n";
foreach (['branch', 'branch_src', 'science', 'science_src', 'science_src/anatomy'] as $d) {
    $p = $root . '/' . $d;
    echo "\n[$d] " . (is_dir($p) ? '' : 'לא קיים') . "\n";
    if (is_dir($p)) foreach (scandir($p) as $f) if ($f !== '.' && $f !== '..') echo "  $f" . (is_file("$p/$f") ? ' ' . filesize("$p/$f") . 'B ' . date('m-d H:i', filemtime("$p/$f")) : '/') . "\n";
}
