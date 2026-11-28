<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';

/* אינדקס החיפוש של קורס אחד: GET ?course=branch|science.
   מוחזר רק למשתמש שיש לו גישה לאותו קורס (או למנהל), כי הוא מכיל את כל טקסט הפרקים.
   הקובץ _search_index.php נבנה עם scripts/build_search.js. החיפוש עצמו נעשה בדפדפן (nav.js). */
$course = (string)($_GET['course'] ?? '');
if (!in_array($course, ['branch', 'science'], true)) json_error('bad_course');
$u = current_user();
if (!$u) json_error('not_logged_in', 401);
if (!($course === 'science' ? has_science($u) : has_branch($u))) json_error('forbidden', 403);

$all = require __DIR__ . '/_search_index.php';
$json = (string)($all[$course] ?? '[]');
$etag = '"' . md5($json) . '"';
header('Cache-Control: private, no-cache');
header('ETag: ' . $etag);
header('Vary: Cookie');
if (trim((string)($_SERVER['HTTP_IF_NONE_MATCH'] ?? '')) === $etag) { http_response_code(304); exit; }
header('Content-Type: application/json; charset=utf-8');
echo '{"ok":true,"items":', $json, '}';
