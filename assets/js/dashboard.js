/* ═══════════════════════════════════════════════════════════════
   شظائع - dashboard.js
   Vanilla JS: SVG daily chart, delete-visits AJAX, toast
   ═══════════════════════════════════════════════════════════════ */
(function () {
  'use strict';

  /* ── Draw SVG daily chart ───────────────────────────────────── */
  var svg = document.getElementById('dailyChart');
  var dataEl = document.getElementById('chartData');
  if (svg && dataEl) {
    try {
      var raw = JSON.parse(dataEl.textContent || '[]');
      var w = 700, h = 220, padL = 30, padR = 10, padT = 10, padB = 22;
      var cw = w - padL - padR;
      var ch = h - padT - padB;

      var max = 1;
      raw.forEach(function (d) { if (d.count > max) max = d.count; });

      var stepX = raw.length > 1 ? cw / (raw.length - 1) : cw;
      var pts = raw.map(function (d, i) {
        var x = padL + i * stepX;
        var y = padT + ch - (d.count / max) * ch;
        return { x: x, y: y, count: d.count, day: d.day };
      });

      var areaD = 'M ' + padL + ' ' + (padT + ch) + ' ' +
        pts.map(function (p) { return 'L ' + p.x.toFixed(1) + ' ' + p.y.toFixed(1); }).join(' ') +
        ' L ' + (padL + cw) + ' ' + (padT + ch) + ' Z';
      var lineD = pts.map(function (p, i) { return (i === 0 ? 'M' : 'L') + ' ' + p.x.toFixed(1) + ' ' + p.y.toFixed(1); }).join(' ');

      var html = '';
      html += '<defs><linearGradient id="areaGrad" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#d4af37" stop-opacity="0.35"/><stop offset="100%" stop-color="#d4af37" stop-opacity="0"/></linearGradient></defs>';
      html += '<path d="' + areaD + '" fill="url(#areaGrad)"/>';
      html += '<path d="' + lineD + '" fill="none" stroke="#d4af37" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>';
      pts.forEach(function (p) {
        html += '<circle cx="' + p.x.toFixed(1) + '" cy="' + p.y.toFixed(1) + '" r="3.5" fill="#0a0a0f" stroke="#d4af37" stroke-width="2"/>';
      });

      // Y axis grid + labels
      var gridLines = 4;
      for (var g = 0; g <= gridLines; g++) {
        var gy = padT + (ch / gridLines) * g;
        var val = Math.round(max - (max / gridLines) * g);
        html += '<line x1="' + padL + '" y1="' + gy.toFixed(1) + '" x2="' + (padL + cw) + '" y2="' + gy.toFixed(1) + '" stroke="#2a2a3d" stroke-width="1"/>';
        html += '<text x="' + (padL - 8) + '" y="' + (gy + 4).toFixed(1) + '" text-anchor="end" fill="#6b6b80" font-size="10" font-family="Space Mono, monospace">' + val + '</text>';
      }

      // X labels (day of week)
      pts.forEach(function (p) {
        html += '<text x="' + p.x.toFixed(1) + '" y="' + (padT + ch + 16) + '" text-anchor="middle" fill="#6b6b80" font-size="10" font-family="Space Mono, monospace">' + p.day + '</text>';
      });

      svg.innerHTML = html;
      svg.setAttribute('viewBox', '0 0 ' + w + ' ' + h);
      svg.setAttribute('preserveAspectRatio', 'none');
    } catch (err) {
      console.error('chart error', err);
    }
  }

  /* ── Delete visits ──────────────────────────────────────────── */
  var delBtn = document.getElementById('deleteVisitsBtn');
  var delForm = document.getElementById('deleteVisitsForm');
  if (delBtn && delForm) {
    delBtn.addEventListener('click', function () {
      var days = delForm.querySelector('input[name="days"]:checked');
      if (!days) { showToast('يرجى اختيار فترة الحذف', 'error'); return; }
      if (!confirm('Are you sure you want to delete records older than ' + days.value + ' days?')) return;

      var fd = new FormData(delForm);
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'admin/delete-visits.php');
      xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
          try {
            var res = JSON.parse(xhr.responseText);
            showToast('حُذفت ' + (res.deleted || 0) + ' سجل', 'success');
            setTimeout(function () { location.reload(); }, 1200);
          } catch (e) {
            showToast('حدث خطأ في الحذف', 'error');
          }
        } else {
          showToast('حدث خطأ في الحذف', 'error');
        }
      };
      xhr.onerror = function () { showToast('حدث خطأ في الاتصال', 'error'); };
      xhr.send(fd);
    });
  }

  /* ── Toast ──────────────────────────────────────────────────── */
  function showToast(msg, type) {
    var t = document.createElement('div');
    t.className = 'toast ' + (type || '');
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(function () { t.style.opacity = '0'; t.style.transition = 'opacity 0.4s'; }, 2500);
    setTimeout(function () { if (t.parentNode) t.parentNode.removeChild(t); }, 2900);
  }
})();