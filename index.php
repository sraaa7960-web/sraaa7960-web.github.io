<?php
declare(strict_types=1);
define('APP_INIT', true);
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/functions.php';
?>
<!-- HERO -->
<section class="hero">
    <div class="container hero-grid">
        <div class="hero-content reveal">
            <span class="hero-eyebrow"><span class="dot"></span> Software Engineer &amp; CS Student</span>
            <h1 class="reveal">أحوّل الأفكار إلى <span class="grad">جارب رقمية</span><br><span class="dim">نابضة بالحياة</span></h1>
            <p class="hero-subtitle reveal">أنا <strong>محمد ميثاق</strong>، مطور وطالب علوم حاسوب. أصمم وأbins وأطور واجهات وظم وقاعدة بيانات تجمع بين الجمال والقوة.</p>
            <div class="hero-actions reveal">
                <a href="cv.php" class="btn btn-primary">السيرة الذاتية</a>
                <a href="#projects" class="btn btn-ghost">المشاريع</a>
            </div>
        </div>
        <div class="hero-visual reveal">
            <div class="visual-card">
                <div class="vc-tag">// profile.json</div>
                <div class="vc-title">محمد ميثاق</div>
                <div class="vc-bar"><span></span></div>
                <div class="vc-bar"><span></span></div>
                <div class="vc-bar"><span></span></div>
                <div class="vc-row">
                    <span class="vc-chip">Front-End</span>
                    <span class="vc-chip">Back-End</span>
                    <span class="vc-chip">SQL</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About preview -->
<section class="section" style="background:var(--bg-2)">
    <div class="container" style="display:grid;grid-template-columns:1fr 1fr;gap:50px;align-items:center;">
        <div class="reveal">
            <div style="width:100%;max-width:320px;margin:0 auto;border-radius:20px;overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow)">
                <img src="assets/images/profile.png" alt="الصورة Personal لمحمد ميثاق" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'" style="width:100%;height:auto;display:block">
                <div style="display:none;width:100%;aspect-ratio:1;background:linear-gradient(145deg,#14141f,#1a1a2e);align-items:center;justify-content:center;flex-direction:column;gap:12px;padding:40px">
                    <svg width="120" height="120" viewBox="0 0 44 44" fill="none"><polygon points="22,2 42,13 42,31 22,42 2,31 2,13" stroke="#d4af37" stroke-width="2" fill="none"/><polygon points="22,8 38,17 38,27 22,36 6,27 6,17" stroke="#38bdf8" stroke-width="1.5" fill="none"/><circle cx="22" cy="22" r="3" fill="#d4af37"/></svg>
                    <span style="font-family:'Space Mono',monospace;color:#d4af37;letter-spacing:2px">محمد ميثاق</span>
                </div>
            </div>
        </div>
        <div class="reveal">
            <span class="section-eyebrow">// about</span>
            <h2 class="section-title">من هو <span class="grad">محمد ميثاق</span>؟</h2>
            <p style="color:var(--text-dim);margin-bottom:16px">مطور وطالب علوم حاسوب، تخصص في تطوير الواجهات الأمامية (Front-End) والghosts أنظمة الخلفية (Back-End) و quotas البيانات. أbuild الأدوات والتقنيات لبناء تجارب رقمية مtna واحترافية.</p>
            <p style="color:var(--text-dim);margin-bottom:24px">أهتم بالdetail التصميم، تجربة المستخدم، الأداء، والوصولية. أibn جعل التقنية وسيلة للعمل، وليس هدفًا في ذاتها.</p>
            <a href="about.php" class="btn btn-ghost">اقرأ عندي بالكامل ←</a>
        </div>
    </div>
</section>
