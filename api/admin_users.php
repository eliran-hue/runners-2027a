<?php
declare(strict_types=1);
require __DIR__ . '/_helpers.php';

/* רשימת המשתמשים לעמוד הניהול: מייל, תאריכים, פרקים שהושלמו, וגישה לקורס המדעי. */
require_admin();
ensure_schema();
$rows = get_pdo()->query('SELECT u.id, u.email, u.display_name, u.created_at, u.last_login_at, u.science_access, u.branch_access, u.requested_course, p.data, p.updated_at
    FROM users u LEFT JOIN progress p ON p.user_id = u.id ORDER BY u.created_at DESC')->fetchAll();

$out = [];
foreach ($rows as $r) {
    $done = [];
    $raw = (string)($r['data'] ?? '{}');
    $new = migrate_progress($raw);
    if ($new !== null) {
        get_pdo()->prepare('UPDATE progress SET data = ? WHERE user_id = ?')->execute([$new, $r['id']]);
        $raw = $new;
    }
    $keys = json_decode($raw, true)['keys'] ?? [];
    foreach ($keys as $k => $v) {
        if (substr($k, -5) !== '.done') continue;
        $d = json_decode((string)$v, true);
        $done[substr($k, 0, -5)] = is_array($d) ? count(array_filter($d)) : 0;
    }
    $u = ['email' => $r['email'], 'science_access' => $r['science_access'], 'branch_access' => $r['branch_access']];
    $out[] = [
        'email' => $r['email'],
        'name' => $r['display_name'] ?? null,
        'created_at' => $r['created_at'],
        'last_login_at' => $r['last_login_at'],
        'progress_at' => $r['updated_at'],
        'done' => (object)$done,
        'branch' => has_branch($u),
        'science' => has_science($u),
        'course' => $r['requested_course'] ?? null,
        'admin' => is_admin($u),
    ];
}
json_out(['ok' => true, 'users' => $out]);
