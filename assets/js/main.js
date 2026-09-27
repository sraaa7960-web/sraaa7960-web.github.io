/* ═══════════════════════════════════════════════════════════════
   شظائع - main.js
   Vanilla JS: scroll reveal, nav, 3D shards, interactive bg
   ═══════════════════════════════════════════════════════════════ */
(function () {
  'use strict';

  var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ── Scroll reveal ──────────────────────────────────────────── */
  var reveals = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && !prefersReduced) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    reveals.forEach(function (el) { io.observe(el); });
  } else {
    reveals.forEach(function (el) { el.classList.add('visible'); });
  }

  /* ── Header scroll ──────────────────────────────────────────── */
  var header = document.querySelector('.site-header');
  if (header) {
    var onScroll = function () {
      header.classList.toggle('scrolled', window.scrollY > 20);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ── Mobile nav ─────────────────────────────────────────────── */
  var toggle = document.getElementById('navToggle');
  var navList = document.querySelector('.nav-list');
  if (toggle && navList) {
    toggle.addEventListener('click', function () {
      var open = navList.classList.toggle('open');
      toggle.classList.toggle('active', open);
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    navList.querySelectorAll('.nav-link').forEach(function (link) {
      link.addEventListener('click', function () {
        navList.classList.remove('open');
        toggle.classList.remove('active');
        toggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  /* ── Interactive background: mouse parallax on shards ───────── */
  var shardsHost = document.getElementById('bgShards');
  if (shardsHost && !prefersReduced) {
    var shardCount = 14;
    var shards = [];
    for (var i = 0; i < shardCount; i++) {
      var s = document.createElement('div');
      s.className = 'shard';
      var size = 20 + Math.random() * 50;
      s.style.width = size + 'px';
      s.style.height = size + 'px';
      s.style.left = Math.random() * 100 + '%';
      s.style.top = Math.random() * 100 + '%';
      s.style.opacity = 0.15 + Math.random() * 0.25;
      s.style.animationDelay = (Math.random() * 8) + 's';
      s.style.animationDuration = (6 + Math.random() * 8) + 's';
      shardsHost.appendChild(s);
      shards.push(s);
    }

    var mouse = { x: 0.5, y: 0.5 };
    document.addEventListener('mousemove', function (e) {
      mouse.x = e.clientX / window.innerWidth;
      mouse.y = e.clientY / window.innerHeight;
    });

    var tick = 0;
    function drift() {
      tick += 0.002;
      shards.forEach(function (s, idx) {
        var ox = (mouse.x - 0.5) * 20 * (idx % 3 + 1);
        var oy = (mouse.y - 0.5) * 20 * (idx % 3 + 1);
        var driftX = Math.sin(tick + idx) * 10;
        var driftY = Math.cos(tick + idx * 1.3) * 10;
        s.style.transform = 'translate(' + (ox + driftX) + 'px, ' + (oy + driftY) + 'px) rotate(' + (tick * 20) + 'deg)';
      });
      requestAnimationFrame(drift);
    }
    if (!prefersReduced) drift();
  }

  /* ── Hero visual card bars animate on view ──────────────────── */
  var vcard = document.querySelector('.visual-card');
  if (vcard && 'IntersectionObserver' in window && !prefersReduced) {
    var vio = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.querySelectorAll('.vc-bar > span').forEach(function (bar, k) {
            setTimeout(function () { bar.style.width = bar.style.width || '0%'; }, k * 200);
          });
          vio.unobserve(entry.target);
        }
      });
    }, { threshold: 0.3 });
    vio.observe(vcard);
  }

  /* ── Smooth anchor scroll fallback ──────────────────────────── */
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var id = a.getAttribute('href');
      if (id.length <= 1) return;
      var target = document.querySelector(id);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: prefersReduced ? 'auto' : 'smooth', block: 'start' });
      }
    });
  });
})();