<?php
/**
 * includes/footer.php
 * التذييل للموقع - يحتوي على شعار، قائمة تصفح، روابط اجتماعيّة، وحقوق النشر
 */
declare(strict_types=1);

if (!defined('APP_INIT')) {
    return;
}

// روابط الحسابات - قابلة للتعديل في هذا الملف
$social_links = [
    'github'     => 'https://github.com/USERNAME',
    'linkedin'   => 'https://linkedin.com/in/USERNAME',
    'instagram'  => 'https://instagram.com/USERNAME',
    'x'          => 'https://x.com/USERNAME',
    'telegram'   => 'https://t.me/USERNAME',
    'email'      => 'mailto:email@example.com',
];

$current_page = basename($_SERVER['PHP_SELF'] ?? 'index.php');
?>

    </main><!-- /.site-main -->

    <!-- ════════════════════════════════════════════════════════
         التذييل
    ════════════════════════════════════════════════════════ -->
    <footer class="site-footer" role="contentinfo">
        <div class="container footer-inner">
            <div class="footer-brand">
                <a href="index.php" class="brand">
                    <span class="brand-logo" aria-hidden="true">
                        <svg width="36" height="36" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <polygon points="22,2 42,13 42,31 22,42 2,31 2,13" stroke="#d4af37" stroke-width="2" fill="none"/>
                            <polygon points="22,8 38,17 38,27 22,36 6,27 6,17" stroke="#38bdf8" stroke-width="1.5" fill="none"/>
                            <circle cx="22" cy="22" r="3" fill="#d4af37"/>
                        </svg>
                    </span>
                    <span class="brand-name">شظائع</span>
                </a>
                <p class="footer-tagline">أحوّل الأفكار إلى تجارب رقمية نابضة بالحياة.</p>
            </div>

            <nav class="footer-links" aria-label="روابط سريعة">
                <a href="index.php">الصفحة الرئيسية</a>
                <a href="cv.php">السيرة الذاتية</a>
                <a href="about.php">من أنا</a>
                <a href="index.php#projects">المشاريع</a>
                <a href="index.php#contact">التواصل</a>
                <a href="admin/login.php">لوحة التحكم</a>
            </nav>

            <div class="footer-social">
                <span class="footer-social-label"> Sever Follow</span>
                <a href="<?php echo e($social_links['github']); ?>" target="_blank" rel="noopener noreferrer" aria-label="GitHub" class="social-link">GitHub</a>
                <a href="<?php echo e($social_links['linkedin']); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" class="social-link">LinkedIn</a>
                <a href="<?php echo e($social_links['instagram']); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="social-link">Instagram</a>
                <a href="<?php echo e($social_links['x']); ?>" target="_blank" rel="noopener noreferrer" aria-label="X" class="social-link">X</a>
                <a href="<?php echo e($social_links['telegram']); ?>" target="_blank" rel="noopener noreferrer" aria-label="Telegram" class="social-link">Telegram</a>
                <a href="<?php echo e($social_links['email']); ?>" aria-label="البريد الإلكتروني" class="social-link">Email</a>
            </div>
        </div>

        <div class="container footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> محمد ميثاق - شظائع. جميع الحقوق محفوظة.</p>
            <p class="footer-tech">مُ(bin) باستخدام HTML5 · CSS3 · JavaScript · PHP · SQLite · PDO</p>
        </div>
    </footer>

    <!-- Main JS -->
    <script src="assets/js/main.js" defer></script>
    <?php if ($current_page === 'dashboard.php'): ?>
        <script src="assets/js/dashboard.js" defer></script>
    <?php endif; ?>
</body>
</html>