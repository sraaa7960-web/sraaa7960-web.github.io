-- ═══════════════════════════════════════════════════════════════════════════════
-- database.sql
-- شظائع - قاعدة البيانات (SQLite)
-- يحتوي على جميع الجداول المطلوبة والمستخدم الإداري التجريبي
-- ═══════════════════════════════════════════════════════════════════════════════
--
-- طريقة الاستخدام:
--   sqlite3 uploads/shaya.db < database.sql
--   أو: php -r "require 'config/database.php';"  (ينشئ الج_tables تلقائيًا)
--
-- ═══════════════════════════════════════════════════════════════════════════════

PRAGMA foreign_keys = ON;

-- ── جدول Admins ─────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS admins (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    username   VARCHAR(64)  NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    full_name  VARCHAR(128),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ── جدول الزيارات ───────────────────────────────────────────────────────────
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
);

-- ── جدول الإعدادات ──────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS settings (
    id    INTEGER PRIMARY KEY AUTOINCREMENT,
    key  VARCHAR(128) NOT NULL UNIQUE,
    value TEXT
);

-- ── الفهارس لتسريع الاستفسارات ──────────────────────────────────────────────
CREATE INDEX IF NOT EXISTS idx_visits_visited ON visits(visited_at);
CREATE INDEX IF NOT EXISTS idx_visits_session ON visits(session_id);
CREATE INDEX IF NOT EXISTS idx_visits_page ON visits(page);

-- ═══════════════════════════════════════════════════════════════════════════════
-- مستخدم إداري تجريبي
-- اسم المستخدم: admin
-- كلمة المرور: admin123
-- تمت تشفيرة باستخدام password_hash()
-- ═══════════════════════════════════════════════════════════════════════════════
-- عدّل المستخدم والكلمة المرور التالية حسب رغبتك:
--   UPDATE admins SET username='admin', password='$2y$10$...' WHERE id = 1;
-- أو أضف مستخدمًا جديدًا:
--   INSERT INTO admins (username, password, full_name)
--   VALUES ('admin', '$2y$10$B12E6Q0F4L8R9X3T5V7W9Y2Z4A6B8C0D2E4F6H8J0K2L4N6P8Q0R2S4U6W8X0Y2Z4', 'اسمك');
--
-- كلمة المرور التشفيرة التالية هي لـ "admin123" (مثال فقط - استخدم password_hash() لcreates جديدة)
-- ═══════════════════════════════════════════════════════════════════════════════

INSERT OR IGNORE INTO admins (id, username, password, full_name) VALUES (
    1,
    'admin',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'محمد ميثاق'
);

-- ═══════════════════════════════════════════════════════════════════════════════
-- ملاحظات:
-- - يُنصح بتغيير اسم المستخدم ("admin") والكلمة المرور ("admin123") فورًا.
-- - ل tạo كلمة مرور جديدة:
--     php -r "echo password_hash('كلمة_جديدة', PASSWORD_DEFAULT);"
-- - قاعدة البيانات تُنشئ تلقائيًا عند أول تشغيل للموقع عبر config/database.php
-- ═══════════════════════════════════════════════════════════════════════════════