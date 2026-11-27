<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';
/* ניקוי חד-פעמי: קובצי HTML ישנים שנשארו בשרת בתיקיות branch/ ו-science/.
   Nginx מגיש קבצים כאלה ישירות, בלי לעבור בשער (api/gate.php), ולכן הם עוקפים את ההתחברות ומציגים גרסה ישנה.
   הדפים האמיתיים נמצאים ב-branch_src/ וב-science_src/. רק למנהל. */
require_admin();
header('Content-Type: text/plain; charset=utf-8');
header('Cache-Control: private, no-store');
$root = realpath(__DIR__ . '/..');
$found = 0; $deleted = 0; $failed = [];
foreach (['branch', 'science'] as $dir) {
    $base = $root . '/' . $dir;
    if (!is_dir($base)) continue;
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS));
    foreach ($it as $f) {
        if (!$f->isFile()) continue;
        if (!preg_match('/\.html?$/i', $f->getFilename())) continue;
        $found++;
        $rel = substr($f->getPathname(), strlen($root) + 1);
        if (@unlink($f->getPathname())) { $deleted++; echo "נמחק: $rel\n"; }
        else { $failed[] = $rel; echo "לא הצלחתי למחוק: $rel\n"; }
    }
}
echo "\nנמצאו $found קבצים, נמחקו $deleted.\n";
if (!$found) echo "אין קבצים ישנים. התיקיות נקיות.\n";
if ($failed) echo "חלק מהקבצים לא נמחקו (הרשאות). צריך למחוק אותם ידנית ב-SFTP.\n";
