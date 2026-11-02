<?php
declare(strict_types=1);

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
    header('Cache-Control: no-store');
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
function current_user(): ?array {
    $token = $_COOKIE['runners_session'] ?? '';
    if (!preg_match('/^[a-f0-9]{64}$/', $token)) return null;
    $stmt = get_pdo()->prepare('SELECT u.id, u.email FROM sessions s JOIN users u ON u.id = s.user_id WHERE s.token = ? AND s.expires_at > ?');
    $stmt->execute([$token, now_sql()]);
    return $stmt->fetch() ?: null;
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
    header('Cache-Control: no-store');
    $extra = ['ok' => true] + $extra;
    $env = json_encode($extra, JSON_UNESCAPED_UNICODE);
    echo substr($env, 0, -1) . ',"progress":' . $raw . '}';
    exit;
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
