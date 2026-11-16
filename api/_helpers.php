<?php
declare(strict_types=1);

/* All dates are stored and shown in Israel time (page-view counter buckets by local day). */
date_default_timezone_set('Asia/Jerusalem');

set_exception_handler(function (Throwable $e) {
    error_log('[runners api] ' . get_class($e) . ': ' . $e->getMessage());
    json_error('server_error', 500);
});

const SESSION_DAYS = 60;
const CODE_MINUTES = 10;
const MAX_ATTEMPTS = 5;
const MAX_PROGRESS_BYTES = 65536;

function config(): array {
    static $config = null;
    if ($config !== null) return $config;
    $path = __DIR__ . '/config.php';
    if (!file_exists($path)) json_error('not_configured', 500);
    $config = require $path;
    return $config;
}

function get_pdo(): PDO {
    static $pdo = null;
    if ($pdo !== null) return $pdo;
    $c = config();
    $dsn = $c['dsn'] ?? "mysql:host={$c['db_host']};dbname={$c['db_name']};charset=utf8mb4";
    $pdo = new PDO($dsn, $c['db_user'] ?? null, $c['db_pass'] ?? null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    return $pdo;
}

function json_input(): array {
    $data = json_decode((string)file_get_contents('php://input'), true);
    return is_array($data) ? $data : [];
}

function json_out(array $data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: private, no-store, no-cache, max-age=0');
    header('Vary: Cookie');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function json_error(string $code, int $status = 400): void {
    json_out(['ok' => false, 'error' => $code], $status);
}

function require_post(): void {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_error('post_only', 405);
}

function now_sql(string $modify = 'now'): string {
    return (new DateTime($modify))->format('Y-m-d H:i:s');
}

function normalize_email(string $email): string {
    return strtolower(trim($email));
}

function client_ip(): string {
    return substr((string)($_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? ''), 0, 45);
}

/** Returns the logged-in user row (id, email) or null. */
/** Adds columns introduced after the first release, so no manual SQL is needed on the server. */
function ensure_schema(): void {
    static $done = false;
    if ($done) return;
    $done = true;
    $pdo = get_pdo();
    try {
        $pdo->query('SELECT science_access FROM users LIMIT 1');
    } catch (PDOException $e) {
        $pdo->exec('ALTER TABLE users ADD COLUMN science_access INT NOT NULL DEFAULT 0');
    }
    try {
        $pdo->query('SELECT display_name FROM users LIMIT 1');
    } catch (PDOException $e) {
        $pdo->exec('ALTER TABLE users ADD COLUMN display_name VARCHAR(60) NULL');
    }
    ensure_views_table($pdo);
}

/** Page-view counter table (added after the first release). */
function ensure_views_table(PDO $pdo): void {
    static $done = false;
    if ($done) return;
    $done = true;
    if ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite') {
        $pdo->exec('CREATE TABLE IF NOT EXISTS page_views (id INTEGER PRIMARY KEY AUTOINCREMENT, path VARCHAR(100) NOT NULL, visitor CHAR(32) NOT NULL, user_id INT NULL, created_at DATETIME NOT NULL)');
        $pdo->exec('CREATE INDEX IF NOT EXISTS pv_time ON page_views (created_at)');
        $pdo->exec('CREATE INDEX IF NOT EXISTS pv_dedupe ON page_views (visitor, path, created_at)');
    } else {
        $pdo->exec('CREATE TABLE IF NOT EXISTS page_views (
            id INT AUTO_INCREMENT PRIMARY KEY,
            path VARCHAR(100) NOT NULL,
            visitor CHAR(32) NOT NULL,
            user_id INT NULL,
            created_at DATETIME NOT NULL,
            INDEX pv_time (created_at),
            INDEX pv_dedupe (visitor, path, created_at),
            INDEX pv_user (user_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
    }
}

/** Admins come from config.php ('admin_emails'); this is the fallback. */
function admin_emails(): array {
    $list = config()['admin_emails'] ?? ['eliranh84@gmail.com'];
    return array_map('normalize_email', $list);
}

function is_admin(?array $u): bool {
    return $u !== null && in_array(normalize_email((string)$u['email']), admin_emails(), true);
}

function has_science(?array $u): bool {
    return $u !== null && (is_admin($u) || (int)($u['science_access'] ?? 0) === 1);
}

/** Returns the logged-in user row (id, email, science_access) or null. */
function current_user(): ?array {
    $token = $_COOKIE['runners_session'] ?? '';
    if (!preg_match('/^[a-f0-9]{64}$/', $token)) return null;
    ensure_schema();
    $stmt = get_pdo()->prepare('SELECT u.id, u.email, u.science_access, u.display_name FROM sessions s JOIN users u ON u.id = s.user_id WHERE s.token = ? AND s.expires_at > ?');
    $stmt->execute([$token, now_sql()]);
    return $stmt->fetch() ?: null;
}

function require_admin(): array {
    $u = require_user();
    if (!is_admin($u)) json_error('forbidden', 403);
    return $u;
}

/** Fields every auth response carries, so the pages know what to show. */
function auth_fields(?array $u): array {
    return ['email' => $u['email'] ?? null, 'name' => ($u['display_name'] ?? null) ?: null, 'science' => has_science($u), 'admin' => is_admin($u)];
}

function require_user(): array {
    $u = current_user();
    if (!$u) json_error('not_authenticated', 401);
    return $u;
}

function set_session_cookie(string $token, int $days): void {
    setcookie('runners_session', $token, [
        'expires' => $days > 0 ? time() + 86400 * $days : time() - 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']) || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https'),
    ]);
}

/** Returns the stored progress as a raw JSON string ("{}" if none). */
function load_progress(int $userId): string {
    $stmt = get_pdo()->prepare('SELECT data FROM progress WHERE user_id = ?');
    $stmt->execute([$userId]);
    $row = $stmt->fetch();
    return $row ? (string)$row['data'] : '{}';
}

/** Echoes {"ok":true, ...$extra, "progress": <raw json>} without a decode/encode round trip. */
function json_out_with_progress(string $raw, array $extra = []): void {
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: private, no-store, no-cache, max-age=0');
    header('Vary: Cookie');
    $extra = ['ok' => true] + $extra;
    $env = json_encode($extra, JSON_UNESCAPED_UNICODE);
    echo substr($env, 0, -1) . ',"progress":' . $raw . '}';
    exit;
}

/** Cleans a display name: single spaces, no control characters, at most 40 characters. Empty means none. */
function clean_name(string $s): ?string {
    $s = preg_replace('/[\x00-\x1F\x7F<>]+/u', '', $s) ?? '';
    $s = trim(preg_replace('/\s+/u', ' ', $s) ?? '');
    if ($s === '') return null;
    return mb_substr($s, 0, 40);
}

/** Plain-text mail from the site address. */
function send_site_mail(string $to, string $subject, string $body): bool {
    $c = config();
    $from = $c['mail_from'] ?? 'noreply@runners2027.fyi';
    $fromName = $c['mail_from_name'] ?? 'מדריכי ריצות ארוכות 2027א';
    $headers = [
        'From' => '=?UTF-8?B?' . base64_encode($fromName) . '?= <' . $from . '>',
        'Reply-To' => $from,
        'MIME-Version' => '1.0',
        'Content-Type' => 'text/plain; charset=UTF-8',
        'Content-Transfer-Encoding' => '8bit',
    ];
    return mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers, '-f' . $from);
}

/** Tells the admins that someone logged in to the site for the first time. Never blocks the login. */
function notify_new_user(string $email, bool $preApproved, bool $science): void {
    $admins = admin_emails();
    if (in_array($email, $admins, true)) return;
    $c = config();
    $site = $c['site_url'] ?? 'https://runners2027.fyi';
    $subject = 'משתמש חדש באתר: ' . $email;
    $body = "שלום,\n\n"
          . "משתמש חדש התחבר לאתר מדריכי ריצות ארוכות 2027א בפעם הראשונה:\n\n"
          . "    $email\n\n"
          . "זמן: " . (new DateTime())->format('d.m.Y H:i') . "\n"
          . "גישה לקורס המדעי: " . ($science ? 'מאושרת' . ($preApproved ? ' (אישרת מראש)' : '') : 'אין') . "\n\n"
          . "כדי לאשר לו גישה לקורס המדעי, או לראות את כל המשתמשים:\n"
          . rtrim($site, '/') . "/admin/\n";
    foreach ($admins as $a) {
        try { send_site_mail($a, $subject, $body); } catch (Throwable $e) { error_log('[runners api] notify: ' . $e->getMessage()); }
    }
}

function send_code_email(string $to, string $code): bool {
    $c = config();
    $from = $c['mail_from'] ?? 'noreply@runners2027.fyi';
    $fromName = $c['mail_from_name'] ?? 'מדריכי ריצות ארוכות 2027א';
    $subject = 'קוד הכניסה שלך: ' . $code;
    $body = "שלום,\n\n"
          . "קוד הכניסה שלך לאתר מדריכי ריצות ארוכות 2027א הוא:\n\n"
          . "    $code\n\n"
          . "הקוד בתוקף ל-" . CODE_MINUTES . " דקות.\n"
          . "אם לא ביקשת את הקוד, אפשר להתעלם מהמייל הזה.\n";
    $headers = [
        'From' => '=?UTF-8?B?' . base64_encode($fromName) . '?= <' . $from . '>',
        'Reply-To' => $from,
        'MIME-Version' => '1.0',
        'Content-Type' => 'text/plain; charset=UTF-8',
        'Content-Transfer-Encoding' => '8bit',
    ];
    return mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers, '-f' . $from);
}
