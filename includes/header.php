<?php
/**
 * includes/header.php
 * الرأس للموقع - يُستخدم في جميع Pages
 */
declare(strict_types=1);

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

require_once __DIR__ . '/../config/database.php';

$site_name  = 'شظائع';
$site_title = 'محمد ميثاق | مطور وطالب علوم حاسوب';
$site_desc  = 'أحوّل الأفكار إلى تجارب رقمية نابضة بالحياة - موقع شخصي احترافي لمحمد ميثاق';

$track_file = __DIR__ . '/track_visit.php';
if (file_exists($track_file) && (!isset($_SERVER['REQUEST_URI']) || strpos($_SERVER['REQUEST_URI'], '/admin/') === false)) {
    require_once $track_file;
}

$current_page = basename($_SERVER['PHP_SELF'] ?? 'index.php');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title><?php echo e($site_title); ?></title>
    <meta name="description" content="<?php echo e($site_desc); ?>">
    <meta name="author" content="محمد ميثاق">
    <meta name="robots" content="index, follow">

    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg">
    <link rel="apple-touch-icon" href="assets/images/favicon.svg">

    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo e($site_title); ?>">
    <meta property="og:description" content="<?php echo e($site_desc); ?>">
    <meta property="og:site_name" content="شظائع">
    <meta property="og:locale" content="ar_SA">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">

    <?php if ($current_page === 'dashboard.php'): ?>
        <link rel="stylesheet" href="assets/css/dashboard.css">
    <?php endif; ?>
</head>
<body class="page <?php echo e($current_page); ?>">
    <a class="skip-link" href="#main-content">انتقل إلى المحتوى الرئيسي</a>

    <!-- ════════════════════════════════════════════════════════
         شعار وناوين
    ════════════════════════════════════════════════════════ -->
    <header class="site-header" id="top">
        <div class="container header-inner">
            <a href="index.php" class="brand" aria-label="الصفحة الرئيسية">
                <span class="brand-logo" aria-hidden="true">
                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <polygon points="22,2 42,13 42,31 22,42 2,31 2,13" stroke="url(#g1)" stroke-width="2" fill="none"/>
                        <polygon points="22,8 38,17 38,27 22,36 6,27 6,17" stroke="url(#g2)" stroke-width="1.5" fill="none"/>
                        <circle cx="22" cy="22" r="3" fill="#d4af37"/>
                        <defs>
                            <linearGradient id="g1" x1="2" y1="2" x2="42" y2="42">
                                <stop offset="0%" stop-color="#d4af37"/>
                                <stop offset="100%" stop-color="#7c3aed"/>
                            </linearGradient>
                            <linearGradient id="g2" x1="6" y1="8" x2="38" y2="36">
                                <stop offset="0%" stop-color="#38bdf8"/>
                                <stop offset="100%" stop-color="#6366f1"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </span>
                <span class="brand-name">شظائع</span>
            </a>

            <!-- قائمة التصفح -->
            <nav class="main-nav" aria-label="القائمة الرئيسية">
                <button class="nav-toggle" id="navToggle" aria-label="فتح القائمة" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>
                <ul class="nav-list">
                    <li><a href="index.php" class="nav-link<?php echo $current_page === 'index.php' ? ' active' : ''; ?>">الصفحة الرئيسية</a></li>
                    <li><a href="cv.php" class="nav-link<?php echo $current_page === 'cv.php' ? ' active' : ''; ?>">السيرة الذاتية</a></li>
                    <li><a href="about.php" class="nav-link<?php echo $current_page === 'about.php' ? ' active' : ''; ?>">من أنا</a></li>
                    <li><a href="index.php#projects" class="nav-link">المشاريع</a></li>
                    <li><a href="index.php#contact" class="nav-link">التواصل</a></li>
                    <li><a href="admin/login.php" class="nav-link nav-login">لوحة التحكم</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- خلفية تفاعلية SVG -->
    <div class="bg-interactive" aria-hidden="true" id="bgInteractive"></div>

    <!-- شعار متحرك خلفي -->
    <div class="bg-shards" aria-hidden="true" id="bgShards"></div>

    <main id="main-content" class="site-main">