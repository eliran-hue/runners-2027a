<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';

/* שער התוכן של שני הקורסים. כל בקשה ל-/branch/ או ל-/science/ מגיעה לכאן (ראו branch/.htaccess, science/.htaccess)
   דרך branch_gate.php / science_gate.php, שמגדירים את $GATE_AREA. התוכן עצמו נמצא ב-branch_src/ וב-science_src/.
   הקבצים מוגשים רק למשתמש מחובר שאושר לאותו קורס, או למנהל. */
$area = $GATE_AREA ?? '';
if (!in_array($area, ['branch', 'science'], true)) { http_response_code(404); exit; }
$u = current_user();
/* כתובות נקיות: לכל דף יש תיקייה משלו (/branch/training/), ובה index.php קטן שמגדיר את $GATE_PAGE ומגיע לכאן.
   למה תיקיות: ב-Cloudways, Nginx עונה בעצמו על כל כתובת ‎.html (ומחזיר 404 כשאין קובץ), וגם כתובת בלי סיומת
   לא מגיעה ל-Apache. רק כתובת של תיקייה עם index.php מגיעה ל-PHP. */
if (isset($GATE_PAGE)) {
    $path = (string)$GATE_PAGE;
} else {
    $path = ltrim(isset($_GET['p']) ? (string)$_GET['p'] : (string)($_GET['f'] ?? ''), '/');
    // הכתובות הישנות (/branch/?p=training) עוברות לכתובת הנקייה.
    if (isset($_GET['p']) && $path !== '' && preg_match('#^[\w\-/]+$#', $path)) {
        header('Location: /' . $area . '/' . rtrim($path, '/') . '/', true, 301);
        exit;
    }
}
$isPage = $path === '' || substr($path, -1) === '/' || preg_match('/\.html?$/i', $path) || !preg_match('/\.[a-z0-9]+$/i', $path);

$allowed = $area === 'science' ? has_science($u) : has_branch($u);
if (!$allowed) {
    header('Cache-Control: private, no-store');
    // Not logged in: to the login screen, and back here afterwards. Logged in without access: the home page explains.
    $back = '/' . $area . '/' . ($path === '' ? '' : rtrim($path, '/') . '/');
    if ($isPage) { header('Location: ' . ($u ? '/?locked=' . $area : '/?next=' . rawurlencode($back)), true, 302); exit; }
    http_response_code(403);
    exit;
}

$base = realpath(__DIR__ . '/../' . $area . '_src');
if ($path !== '' && substr($path, -1) !== '/' && is_dir($base . '/' . $path) && !preg_match('/(^|\/)\./', $path)) {
    header('Location: /' . $area . '/' . $path . '/', true, 301);
    exit;
}
/* "training/" (דף, לא תיקייה) → training.html */
if (substr($path, -1) === '/' && !is_dir($base . '/' . $path) && is_file($base . '/' . rtrim($path, '/') . '.html.php')) $path = rtrim($path, '/') . '.html';
if ($path === '' || substr($path, -1) === '/') $path .= 'index.html';
/* כתובת בלי סיומת (/branch/training): Nginx של Cloudways מגיש בעצמו כל כתובת ‎.html (ומחזיר 404 כשהקובץ לא קיים),
   ולכן הקישורים באתר הם בלי סיומת, וכך הם מגיעים לכאן. */
if (!preg_match('/\.[a-z0-9]+$/i', $path) && is_file($base . '/' . $path . '.html.php')) $path .= '.html';
/* הדפים שמורים ב-<קורס>_src/ בשם <קובץ>.php, עם שורת הגנה ראשונה (בקשה ישירה מחזירה 404). */
$file = realpath($base . '/' . $path . '.php');
if ($file === false || strpos($file, $base . DIRECTORY_SEPARATOR) !== 0 || !is_file($file)
    || preg_match('/(^|\/)\.|\.php$/i', $path)) {
    http_response_code(404);
    exit;
}
$body = file_get_contents($file);
$nl = strpos($body, "\n");
$body = $nl === false ? '' : substr($body, $nl + 1);

$types = ['html' => 'text/html; charset=utf-8', 'htm' => 'text/html; charset=utf-8', 'css' => 'text/css',
          'js' => 'application/javascript', 'json' => 'application/json', 'png' => 'image/png',
          'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'svg' => 'image/svg+xml', 'webp' => 'image/webp', 'pdf' => 'application/pdf'];
$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
header('Content-Type: ' . ($types[$ext] ?? 'application/octet-stream'));
header('Cache-Control: private, no-store');
header('Vary: Cookie');
header('X-Robots-Tag: noindex, nofollow, noarchive, nosnippet, noimageindex');
header('Content-Length: ' . strlen($body));
echo $body;
