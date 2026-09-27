<?php
/**
 * config/database.php
 * إعدادات اتصال قاعدة البيانات PDO - SQLite
 * جميع الإعدادات قابلة للتعديل هنا.
 */

declare(strict_types=1);

// منع accessed مباشرة
if (!defined('APP_INIT')) {
    http_response_code(403);
    exit('الوصول غير مصرح به');
}

// ╔══════════════════════════════════════════════════════════════╗
// ║  إعدادات قاعدة البيانات - عدّل القيم التالية حسبneeds     ║
// ╚══════════════════════════════════════════════════════════════╝

// مسار الملف (relative to project root)
const DB_FILE = __DIR__ . '/../uploads/shaya.db';

// ═══════════════════════════════════════════════════════════════
// إنشاء اتصال PDO بـ SQLite
// ═══════════════════════════════════════════════════════════════

function getDB(): PDO
{
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    // إنشاء المجلد إذا لم يكن موجودًا
    $dir = dirname(DB_FILE);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    try {
        $pdo = new PDO('sqlite:' . DB_FILE);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        // تفعيل المفتاح الأجنبي
        $pdo->exec('PRAGMA foreign_keys = ON');

        // تحسين الأداء
        $pdo->exec('PRAGMA journal_mode = WAL');
        $pdo->exec('PRAGMA synchronous = NORMAL');
        $pdo->exec('PRAGMA cache_size = -20000');

        // تأكد من وجود الجدول admin
        ensureTables($pdo);

        return $pdo;
    } catch (PDOException $e) {
        error_log('Database connection failed: ' . $e->getMessage());
        die('حدث خطأ في الاتصال بقاعدة البيانات. يرجى التأكد من أن الملف قابل للكتابة.');
    }
}

// ═══════════════════════════════════════════════════════════════
// إنشاء الجداول تلقائيًا إذا لم تكن موجودة
// ═══════════════════════════════════════════════════════════════

function ensureTables(PDO $pdo): void
{
    $pdo->exec(<<<SQL
    CREATE TABLE IF NOT EXISTS admins (
        id         INTEGER PRIMARY KEY AUTOINCREMENT,
        username   VARCHAR(64)  NOT NULL UNIQUE,
        password   VARCHAR(255) NOT NULL,
        full_name  VARCHAR(128),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
    SQL);

    $pdo->exec(<<<SQL
    CREATE TABLE IF NOT EXISTS visits (
        id         INTEGER PRIMARY KEY AUTOINCREMENT,
        visited_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        page       VARCHAR(255) NOT NULL,
        session_id VARCHAR(128),
        user_agent TEXT,
        device     VARCHAR(32),
        browser   VARCHAR(64),
        referrer  TEXT,
        ip        VARCHAR(64)
    )
    SQL);

    $pdo->exec(<<<SQL
    CREATE TABLE IF NOT EXISTS settings (
        id    INTEGER PRIMARY KEY AUTOINCREMENT,
        key  VARCHAR(128) NOT NULL UNIQUE,
        value TEXT
    )
    SQL);

    // الفهارس لتسريع الاستفسارات
    $pdo->exec('CREATE INDEX IF NOT EXISTS idx_visits_visited ON visits(visited_at)');
    $pdo->exec('CREATE INDEX IF NOT EXISTS idx_visits_session ON visits(session_id)');
    $pdo->exec('CREATE INDEX IF NOT EXISTS idx_visits_page ON visits(page)');

    // مستخدم إداري تجريبي إذا لم يكن موجودًا
    $check = $pdo->query("SELECT COUNT(*) FROM admins WHERE username = 'admin'");
    if ((int)$check->fetchColumn() === 0) {
        $hash = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO admins (username, password, full_name) VALUES (?, ?, ?)");
        $stmt->execute(['admin', $hash, 'محمد ميثاق']);
    }
}