/* Sticky header for every page: logo, hamburger menu with the site tree, and the theme/account buttons.
   The science course is shown as a locked item (no sub-items) unless the visitor has access (see sync.js → runners:auth). */
(function(){
  "use strict";
  if (document.getElementById("topbar")) return;

  var BRANCH = [
    ["/branch/tools.html", "מחשבונים וכלי עזר"],
    ["/branch/anatomy.html", "האנטומיה של הריצה"],
    ["/branch/physiology.html", "הפיזיולוגיה של הריצה"],
    ["/branch/training.html", "תורת האימון"],
    ["/branch/methodology.html", "מתודיקה באימון"]
  ];
  var SCIENCE = [
    ["/science/anatomy/", "אנטומיה", [["/science/anatomy/skeleton.html", "🦴 סימולטור שלד"], ["/science/anatomy/unit1.html", "יחידה 1: מבנה מערכות הגוף"], ["/science/anatomy/unit3.html", "יחידות 2–3: מערכת שלד-שריר ומפרקים"], ["/science/anatomy/unit4.html", "יחידה 4: מערכת שלד-שריר: שרירים"]]],
    [null, "פיזיולוגיה"],
    [null, "קניזיולוגיה"]
  ];

  /* Logo: a man and a woman running together (also /favicon.svg). */
  var LOGO = '<svg class="tb-mark" viewBox="0 0 40 40" aria-hidden="true" focusable="false">'
    + '<rect width="40" height="40" rx="11" class="tb-mark-bg"/><path d="M27.60 13.20 L25.80 20.80 M27.00 15.20 L30.00 17.50 L32.20 15.00 M27.00 15.20 L24.00 17.00 L23.20 20.00 M25.80 20.80 L29.80 24.00 L29.00 29.00 M25.80 20.80 L24.00 25.00 L20.00 26.20" fill="none" stroke="#fff" stroke-width="2.30" stroke-linecap="round" stroke-linejoin="round"/><circle cx="28.50" cy="10.20" r="2.55" fill="#fff"/><path d="M13.40 15.78 L11.82 22.47 M12.87 17.54 L15.51 19.57 L17.45 17.37 M12.87 17.54 L10.23 19.13 L9.53 21.77 M11.82 22.47 L15.34 25.29 L14.63 29.69 M11.82 22.47 L10.23 26.17 L6.71 27.22" fill="none" stroke="#fff" stroke-width="2.02" stroke-linecap="round" stroke-linejoin="round"/><circle cx="14.19" cy="13.14" r="2.24" fill="#fff"/><path d="M12.52 11.91 Q9.70 11.74 9.18 14.90" fill="none" stroke="#fff" stroke-width="1.67" stroke-linecap="round"/>'
    + '</svg>';

  var css = ""
    + ":root{--tb-h:58px}"
    + "html{scroll-padding-top:calc(var(--tb-h) + 70px)}"
    + ".topbar{position:sticky;top:0;z-index:40;background:color-mix(in srgb,var(--paper,#fff) 92%,transparent);-webkit-backdrop-filter:saturate(1.4) blur(10px);backdrop-filter:saturate(1.4) blur(10px);border-bottom:1px solid var(--line,#D3DCE3);padding-top:env(safe-area-inset-top,0px)}"
    + ".topbar .tb-in{max-width:1100px;margin:0 auto;height:var(--tb-h);display:flex;align-items:center;gap:10px;padding:0 max(14px,env(safe-area-inset-right)) 0 max(14px,env(safe-area-inset-left))}"
    + ".tb-burger{flex:none;width:44px;height:44px;border-radius:12px;border:1px solid var(--line,#D3DCE3);background:var(--paper,#fff);color:var(--ink,#1A2530);cursor:pointer;display:grid;place-items:center}"
    + ".tb-burger:hover{border-color:var(--accent,#1F5FD6);color:var(--accent,#1F5FD6)}"
    + ".tb-burger:focus-visible,.tb-logo:focus-visible,.tb-drawer a:focus-visible,.tb-close:focus-visible{outline:3px solid var(--accent,#1F5FD6);outline-offset:2px}"
    + ".tb-burger svg{width:22px;height:22px}"
    + ".tb-logo{display:flex;align-items:center;gap:9px;text-decoration:none;color:var(--ink,#1A2530);min-width:0;border-radius:10px}"
    + ".tb-mark{width:36px;height:36px;flex:none}.tb-mark-bg{fill:var(--accent,#1F5FD6)}"
    + ".tb-name{display:flex;flex-direction:column;line-height:1.1;min-width:0}"
    + ".tb-name b{font:800 18px 'Assistant',system-ui,sans-serif;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}"
    + ".tb-name small{font:600 12px 'Assistant',system-ui,sans-serif;color:var(--muted,#5B6B78)}"
    + ".tb-actions{margin-inline-start:auto;display:flex;align-items:center;gap:8px;flex:none}"
    + ".tb-actions > *{margin:0!important}"
    + ".tb-actions .theme-btn{width:40px;height:40px}.tb-actions .acct-btn{min-height:40px;position:relative}"
    + "@media (max-width:560px){.tb-name small{display:none}.tb-name b{font-size:15px}.tb-mark{width:32px;height:32px}"
    + ".tb-actions .acct-btn{width:40px;height:40px;padding:0!important;justify-content:center;font-size:0!important;gap:0}"
    + ".tb-actions .acct-btn::before{content:'';width:20px;height:20px;background:currentColor;-webkit-mask:var(--tb-user) center/contain no-repeat;mask:var(--tb-user) center/contain no-repeat}"
    + ".tb-actions .acct-btn .dot{position:absolute;top:5px;inset-inline-end:5px}.tb-actions .admin-link{display:none}}"
    + ":root{--tb-user:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Ccircle cx='12' cy='8' r='4.2'/%3E%3Cpath d='M3.5 21c.8-4.4 4.2-7 8.5-7s7.7 2.6 8.5 7z'/%3E%3C/svg%3E\")}"
    + "nav.rail{top:calc(var(--tb-h) + env(safe-area-inset-top,0px))!important}"
    + "body::before{display:none!important}"
    + ".tb-scrim{position:fixed;inset:0;z-index:60;background:rgba(10,18,26,.45);opacity:0;transition:opacity .2s;pointer-events:none}"
    + ".tb-scrim.open{opacity:1;pointer-events:auto}"
    + ".tb-drawer{position:fixed;top:0;bottom:0;inset-inline-start:0;z-index:61;width:min(340px,88vw);background:var(--paper,#fff);color:var(--ink,#1A2530);box-shadow:0 0 40px rgba(0,0,0,.25);transform:translateX(105%);transition:transform .22s ease;display:flex;flex-direction:column;padding-top:env(safe-area-inset-top,0px)}"
    + "[dir=ltr] .tb-drawer{transform:translateX(-105%)}"
    + ".tb-drawer.open{transform:none}"
    + "@media (prefers-reduced-motion:reduce){.tb-drawer,.tb-scrim{transition:none}}"
    + ".tb-dh{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:12px 14px;border-bottom:1px solid var(--line,#D3DCE3)}"
    + ".tb-dh b{font:800 18px 'Assistant',system-ui,sans-serif}"
    + ".tb-close{width:40px;height:40px;border-radius:10px;border:1px solid var(--line,#D3DCE3);background:none;color:inherit;font-size:22px;cursor:pointer;line-height:1}"
    + ".tb-tree{overflow:auto;padding:10px 10px 24px;font:600 16px 'Assistant',system-ui,sans-serif;flex:1}"
    + ".tb-tree ul{list-style:none;margin:0;padding:0}"
    + ".tb-tree > ul > li + li{margin-top:6px;padding-top:6px;border-top:1px solid var(--line,#D3DCE3)}"
    + ".tb-tree ul ul{margin:2px 0 6px;padding-inline-start:14px;border-inline-start:2px solid var(--line,#D3DCE3);margin-inline-start:14px}"
    + ".tb-tree a,.tb-tree .na{display:flex;align-items:center;gap:8px;padding:10px 10px;border-radius:10px;color:inherit;text-decoration:none;min-height:44px;box-sizing:border-box}"
    + ".tb-tree ul ul a,.tb-tree ul ul .na{font-weight:400;font-size:15.5px;min-height:40px;padding:8px 10px}"
    + ".tb-tree a:hover{background:var(--accent-soft,#E8EEF8);color:var(--accent,#1F5FD6)}"
    + ".tb-tree a[aria-current=page]{background:var(--accent-soft,#E8EEF8);color:var(--accent,#1F5FD6);box-shadow:inset -3px 0 0 var(--accent,#1F5FD6)}"
    + ".tb-tree .grp{font:600 12.5px 'Assistant',system-ui,sans-serif;color:var(--muted,#5B6B78);padding:14px 10px 2px;letter-spacing:.02em}"
    + ".tb-tree .na{color:var(--muted,#5B6B78)}"
    + ".tb-tree .soon{font-size:12px;font-weight:600;border:1px solid var(--line,#D3DCE3);border-radius:999px;padding:0 8px;margin-inline-start:auto}"
    + ".tb-tree .lock{display:block;font-weight:400;font-size:14px;color:var(--muted,#5B6B78);padding:0 10px 6px}"
    + "html.tb-lock{overflow:hidden}";
  var st = document.createElement("style"); st.textContent = css; document.head.appendChild(st);
  if (!document.querySelector("link[rel~=icon]")) {
    var ic = document.createElement("link"); ic.rel = "icon"; ic.type = "image/svg+xml";
    ic.href = "data:image/svg+xml," + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg"' + LOGO.slice(4).replace('class="tb-mark-bg"', 'fill="#1F5FD6"'));
    document.head.appendChild(ic);
  }

  /* ---------- header ---------- */
  var bar = document.createElement("header");
  bar.className = "topbar"; bar.id = "topbar";
  bar.innerHTML = '<div class="tb-in">'
    + '<button type="button" class="tb-burger" aria-label="תפריט ניווט" aria-expanded="false" aria-controls="tbDrawer">'
    + '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" fill="none"/></svg></button>'
    + '<a class="tb-logo" href="/" aria-label="קורס מדריכי ריצות ארוכות, לדף הבית">' + LOGO
    + '<span class="tb-name"><b>קורס מדריכי ריצות ארוכות</b><small>סמסטר 2027א</small></span></a>'
    + '<div class="tb-actions" id="topActions"></div></div>';
  document.body.insertBefore(bar, document.body.firstChild);

  /* ---------- drawer ---------- */
  var scrim = document.createElement("div"); scrim.className = "tb-scrim";
  var drawer = document.createElement("nav");
  drawer.className = "tb-drawer"; drawer.id = "tbDrawer"; drawer.setAttribute("aria-label", "תפריט האתר");
  drawer.hidden = true;
  document.body.appendChild(scrim); document.body.appendChild(drawer);

  var here = location.pathname.replace(/index\.html$/, "");
  function esc(s){ return String(s).replace(/[&<>"]/g, function(c){ return {"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;"}[c]; }); }
  function link(href, text){ return '<a href="' + href + '"' + (here === href ? ' aria-current="page"' : '') + '>' + esc(text) + '</a>'; }
  function tree(){
    var a = window.runnersAuth || {}, sci = !!(a.science || a.admin);
    var h = '<ul>' + '<li>' + link("/", "דף הבית") + '</li>'
      + '<li>' + link("/branch/", "קורס ענפי") + '<ul>' + BRANCH.map(function(b){ return '<li>' + link(b[0], b[1]) + '</li>'; }).join("") + '</ul></li>';
    if (sci) {
      h += '<li>' + link("/science/", "קורס מדעי") + '<ul>' + SCIENCE.map(function(t){
        if (!t[0]) return '<li><span class="na">' + esc(t[1]) + '<span class="soon">בקרוב</span></span></li>';
        return '<li>' + link(t[0], t[1]) + (t[2] ? '<ul>' + t[2].map(function(u){ return '<li>' + link(u[0], u[1]) + '</li>'; }).join("") + '</ul>' : '') + '</li>';
      }).join("") + '</ul></li>';
    } else {
      h += '<li><a href="/?science=locked#sciLockCard">קורס מדעי <span aria-hidden="true">🔒</span><span class="soon">נעול</span></a>'
        + '<span class="lock">פתוח רק למשתתפי הקורס המדעי. לפרטים על קבלת גישה ←</span></li>';
    }
    if (a.admin) h += '<li>' + link("/admin/", "ניהול האתר") + '</li>';
    return h + '</ul>';
  }
  function render(){
    drawer.innerHTML = '<div class="tb-dh"><b>ניווט באתר</b><button type="button" class="tb-close" aria-label="סגירת התפריט">×</button></div><div class="tb-tree">' + tree() + '</div>';
    drawer.querySelector(".tb-close").onclick = close;
  }
  render();
  document.addEventListener("runners:auth", render);

  var burger = bar.querySelector(".tb-burger"), lastFocus = null, closeT = null;
  function open(){
    clearTimeout(closeT);
    render(); drawer.hidden = false; lastFocus = document.activeElement;
    requestAnimationFrame(function(){ drawer.classList.add("open"); scrim.classList.add("open"); });
    burger.setAttribute("aria-expanded", "true");
    document.documentElement.classList.add("tb-lock");
    var cur = drawer.querySelector("[aria-current]") || drawer.querySelector("a");
    setTimeout(function(){ (cur || drawer.querySelector(".tb-close")).focus(); }, 30);
  }
  function close(){
    drawer.classList.remove("open"); scrim.classList.remove("open");
    burger.setAttribute("aria-expanded", "false");
    document.documentElement.classList.remove("tb-lock");
    closeT = setTimeout(function(){ drawer.hidden = true; }, 230);
    if (lastFocus && lastFocus.focus) lastFocus.focus();
  }
  burger.onclick = function(){ burger.getAttribute("aria-expanded") === "true" ? close() : open(); };
  scrim.onclick = close;
  document.addEventListener("keydown", function(e){
    if (drawer.hidden) return;
    if (e.key === "Escape") { e.preventDefault(); close(); return; }
    if (e.key === "Tab") {   /* keep focus inside the open menu */
      var f = drawer.querySelectorAll("a,button"); if (!f.length) return;
      var first = f[0], last = f[f.length - 1];
      if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
      else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    }
  });
  drawer.addEventListener("click", function(e){ if (e.target.closest && e.target.closest("a")) close(); });

  /* The breadcrumb row loses its buttons to the header; hide it when nothing else is left (home page). */
  function tidy(){
    var sb = document.querySelector("nav.sb");
    if (sb && !sb.querySelector("a,span")) sb.style.display = "none";
  }
  window.addEventListener("load", tidy);
})();

/* Celebration when a chapter is completed (quiz passed for the first time):
   confetti burst, a short toast, and a pulse on the "next chapter" button. Pages don't need to change:
   after a quiz answer we compare the *.done progress keys before and after. */
(function(){
  "use strict";
  function snap(){
    var o = {};
    try { for (var i = 0; i < localStorage.length; i++) { var k = localStorage.key(i); if (/\.done$/.test(k)) o[k] = localStorage.getItem(k); } } catch (e) {}
    return o;
  }
  function count(v){ try { var d = JSON.parse(v || "{}") || {}; return Object.keys(d).filter(function(k){ return d[k]; }).length; } catch (e) { return 0; } }
  var css = document.createElement("style");
  css.textContent = ""
    + "#confettiCv{position:fixed;inset:0;width:100vw;height:100vh;pointer-events:none;z-index:90}"
    + ".cele-toast{position:fixed;left:50%;bottom:calc(22px + env(safe-area-inset-bottom,0px));transform:translate(-50%,20px);opacity:0;z-index:91;"
    + "background:var(--paper,#fff);color:var(--ink,#0B1C30);border:1px solid var(--line,#E2E8F0);border-inline-start:4px solid var(--ok,#059669);"
    + "border-radius:14px;padding:12px 18px;font:700 16px 'Assistant',system-ui,sans-serif;box-shadow:0 16px 36px -10px rgba(15,23,42,.35);transition:opacity .25s,transform .25s;max-width:92vw;width:max-content;white-space:nowrap;text-align:center}"
    + ".cele-toast.show{opacity:1;transform:translate(-50%,0)}"
    + "@keyframes nextPulse{0%,100%{box-shadow:0 0 0 0 color-mix(in srgb,var(--accent,#2563EB) 55%,transparent)}50%{box-shadow:0 0 0 10px transparent}}"
    + "#nextChap.pulse{animation:nextPulse 1.8s ease-in-out 4}"
    + "@media (prefers-reduced-motion:reduce){#nextChap.pulse{animation:none}.cele-toast{transition:none}}";
  document.head.appendChild(css);

  function confetti(){
    if (window.matchMedia && matchMedia("(prefers-reduced-motion: reduce)").matches) return;
    var cv = document.getElementById("confettiCv");
    if (!cv) { cv = document.createElement("canvas"); cv.id = "confettiCv"; cv.setAttribute("aria-hidden", "true"); document.body.appendChild(cv); }
    var dpr = Math.min(2, window.devicePixelRatio || 1), W = innerWidth, H = innerHeight;
    cv.width = W * dpr; cv.height = H * dpr; cv.style.display = "block";
    var ctx = cv.getContext("2d"); ctx.scale(dpr, dpr);
    var colors = ["#2563EB", "#059669", "#D97706", "#7C3AED", "#F59E0B", "#10B981", "#EC4899", "#38BDF8"];
    var P = [], bursts = [[W * .5, H * .42], [W * .22, H * .5], [W * .78, H * .5]];
    bursts.forEach(function(b, bi){
      for (var i = 0; i < (bi ? 45 : 80); i++) {
        var a = Math.random() * Math.PI * 2, sp = 4 + Math.random() * (bi ? 6 : 9);
        P.push({x: b[0], y: b[1], vx: Math.cos(a) * sp, vy: Math.sin(a) * sp - 4, s: 5 + Math.random() * 6, r: Math.random() * 6, vr: (Math.random() - .5) * .35,
          c: colors[(Math.random() * colors.length) | 0], shape: Math.random() < .55 ? 0 : 1, life: 0, delay: bi * 9});
      }
    });
    var t = 0;
    (function frame(){
      t++; ctx.clearRect(0, 0, W, H); var alive = false;
      P.forEach(function(p){
        if (t < p.delay) { alive = true; return; }
        p.life++; p.vy += .22; p.vx *= .985; p.vy *= .985; p.x += p.vx; p.y += p.vy; p.r += p.vr;
        var o = Math.max(0, 1 - p.life / 110); if (o <= 0 || p.y > H + 20) return; alive = true;
        ctx.save(); ctx.globalAlpha = o; ctx.translate(p.x, p.y); ctx.rotate(p.r); ctx.fillStyle = p.c;
        if (p.shape) { ctx.beginPath(); ctx.arc(0, 0, p.s / 2.2, 0, 6.283); ctx.fill(); } else ctx.fillRect(-p.s / 2, -p.s / 4, p.s, p.s / 2);
        ctx.restore();
      });
      if (alive) requestAnimationFrame(frame); else { ctx.clearRect(0, 0, W, H); cv.style.display = "none"; }
    })();
  }
  function toast(msg){
    var el = document.createElement("div"); el.className = "cele-toast"; el.setAttribute("role", "status"); el.textContent = msg;
    document.body.appendChild(el);
    requestAnimationFrame(function(){ el.classList.add("show"); });
    setTimeout(function(){ el.classList.remove("show"); setTimeout(function(){ el.remove(); }, 400); }, 3800);
  }
  function celebrate(){
    confetti();
    var nb = document.getElementById("nextChap");
    toast(nb ? "🎉 כל הכבוד! הפרק הושלם" : "🎉 כל הכבוד! סיימת את כל הפרקים בנושא");
    if (nb) { nb.classList.remove("pulse"); void nb.offsetWidth; nb.classList.add("pulse"); }
  }
  document.addEventListener("click", function(e){
    if (!e.target.closest || !e.target.closest(".quiz .opt")) return;
    var before = snap();
    setTimeout(function(){
      var after = snap();
      for (var k in after) if (count(after[k]) > count(before[k])) { celebrate(); return; }
    }, 60);
  }, true);
  window.runnersCelebrate = celebrate; /* handy for testing */
})();
