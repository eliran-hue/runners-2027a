<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';

/* כל בקשה לתיקיית /science/ מגיעה לכאן (ראו science/.htaccess).
   הקבצים מוגשים רק למשתמש מחובר שאושר לקורס המדעי, או למנהל. */
$u = current_user();
$path = (string)($_GET['f'] ?? '');
$isPage = $path === '' || substr($path, -1) === '/' || preg_match('/\.html?$/i', $path);

if (!has_science($u)) {
    header('Cache-Control: private, no-store');
    if ($isPage) { header('Location: /?science=locked', true, 302); exit; }
    http_response_code(403);
    exit;
}

if ($path === '' || substr($path, -1) === '/') $path .= 'index.html';
$base = realpath(__DIR__ . '/../science');
$file = realpath($base . '/' . $path);
if ($file === false || strpos($file, $base . DIRECTORY_SEPARATOR) !== 0 || !is_file($file)
    || preg_match('/(^|\/)\.|\.php$/i', $path)) {
    http_response_code(404);
    exit;
}

$types = ['html' => 'text/html; charset=utf-8', 'htm' => 'text/html; charset=utf-8', 'css' => 'text/css',
          'js' => 'application/javascript', 'json' => 'application/json', 'png' => 'image/png',
          'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'svg' => 'image/svg+xml', 'webp' => 'image/webp', 'pdf' => 'application/pdf'];
$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
header('Content-Type: ' . ($types[$ext] ?? 'application/octet-stream'));
header('Cache-Control: private, no-store');
header('Vary: Cookie');
header('X-Robots-Tag: noindex, nofollow, noarchive, nosnippet, noimageindex');
header('Content-Length: ' . filesize($file));
readfile($file);
