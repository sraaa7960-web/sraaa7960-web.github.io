<?php
/**
 * includes/functions.php
 * وظائف مساعدة مستخدمة في جميع صفحات الموقع
 */
declare(strict_types=1);

if (!defined('APP_INIT')) {
    return;
}

/**
 * تنظيف وaskaة المدخلات ل protection من XSS
 */
function e($value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8', true);
}

/**
 * إرجاع قيمة من المصفوفة أو قيمة افتراضية
 */
function old(string $key, $default = '')
{
    return $_SESSION['_old_input'][$key] ?? $default;
}

/**
 * توليد CSRF Token
 */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * التحقق من CSRF Token
 */
function verify_csrf(): bool
{
    $token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? '';
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

/**
 * حساب عدد الزيارات
 */
function count_visits(string $period = 'all'): int
{
    try {
        $pdo = getDB();
        $sql = "SELECT COUNT(*) FROM visits";
        $params = [];

        if ($period === 'today') {
            $sql .= " WHERE DATE(visited_at) = DATE('now', 'localtime')";
        } elseif ($period === '7days') {
            $sql .= " WHERE visited_at >= datetime('now', '-7 days', 'localtime')";
        } elseif ($period === '30days') {
            $sql .= " WHERE visited_at >= datetime('now', '-30 days', 'localtime')";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}

/**
 * جلب آخر الزيارات
 */
function get_recent_visits(int $limit = 10): array
{
    try {
        $pdo = getDB();
        $stmt = $pdo->prepare(<<<SQL
            SELECT visited_at, page, device, browser, referrer
            FROM visits
            ORDER BY id DESC
            LIMIT ?
        SQL);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * توليد رابط نسبي آمن
 */
function url(string $path): string
{
    $path = ltrim($path, '/');
    return $path;
}

/**
 * التحقق من أن المستخدم مسجّل دخوله
 */
function is_logged_in(): bool
{
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

/**
 * توليد رمز عشوائي آمن
 */
function random_str(int $length = 16): string
{
    return bin2hex(random_bytes((int)ceil($length / 2)));
}