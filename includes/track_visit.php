<?php
/**
 * includes/track_visit.php
 * تسجيل الزيارات تلقائيًا في جميع Pages العامة.
 * لا يُسجّل الزيارة أكثر من مرة من نفس الجلسة خلال 30 دقيقة.
 */
declare(strict_types=1);

if (!defined('APP_INIT')) {
    return;
}

// منع التس registering المتكرر داخل نفس الجلسة (30 دقيقة)
$session_key = 'last_visit_' . md5($_SERVER['REQUEST_URI'] ?? '');
$now         = time();
$cooldown    = 1800; // 30 دقيقة

if (isset($_SESSION[$session_key]) && ($now - $_SESSION[$session_key]) < $cooldown) {
    return;
}
$_SESSION[$session_key] = $now;

try {
    $pdo = getDB();

    // تحليل User Agent بسيط
    $ua        = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $device    = 'Unknown';
    $browser  = 'Unknown';

    if (preg_match('/(iPad|iPhone|iPod)/i', $ua)) {
        $device = (stripos($ua, 'iPad') !== false) ? 'Tablet' : 'Mobile';
    } elseif (preg_match('/Android/i', $ua)) {
        $device = (stripos($ua, 'Mobile') !== false || stripos($ua, 'tablet') === false) ? 'Mobile' : 'Tablet';
    } elseif (preg_match('/Windows|Macintosh|X11|Linux/i', $ua)) {
        $device = 'Desktop';
    }

    if (stripos($ua, 'Chrome') !== false && stripos($ua, 'Edg') === false) {
        $browser = 'Chrome';
    } elseif (stripos($ua, 'Firefox') !== false) {
        $browser = 'Firefox';
    } elseif (stripos($ua, 'Safari') !== false && stripos($ua, 'Chrome') === false) {
        $browser = 'Safari';
    } elseif (stripos($ua, 'Edg') !== false) {
        $browser = 'Edge';
    } elseif (stripos($ua, 'Opera') !== false || stripos($ua, 'OPR') !== false) {
        $browser = 'Opera';
    }

    $page      = $_SERVER['REQUEST_URI'] ?? '/';
    $sess_id   = session_id() ?: (string)($_SESSION['session_id'] ?? '');
    $referrer  = $_SERVER['HTTP_REFERER'] ?? null;
    $ip        = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

    $stmt = $pdo->prepare(<<<SQL
        INSERT INTO visits (visited_at, page, session_id, user_agent, device, browser, referrer, ip)
        VALUES (datetime('now'), ?, ?, ?, ?, ?, ?, ?)
    SQL);
    $stmt->execute([$page, $sess_id, $ua, $device, $browser, $referrer, $ip]);

} catch (PDOException $e) {
    // لا نعرض أخطاء للمستخدم
    error_log('track_visit error: ' . $e->getMessage());
}