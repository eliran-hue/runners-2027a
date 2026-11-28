/* Site dialogs instead of the browser's alert()/confirm():
   runnersDialog({title, text, ok, cancel, danger}) → Promise<boolean>   (cancel:false = message with one button)
   runnersAlert(text, title) → Promise */
(function(){
  "use strict";
  if (window.runnersDialog) return;
  var css = ".rd{border:0;padding:0;background:transparent;max-width:min(440px,calc(100vw - 32px));width:100%;color:var(--ink,#111)}"
    + ".rd::backdrop{background:rgba(6,10,24,.55);backdrop-filter:blur(3px)}"
    + ".rd .rd-box{background:var(--paper,#fff);border:1px solid var(--line,#ddd);border-radius:20px;padding:22px 22px 18px;box-shadow:0 24px 60px rgba(0,0,0,.35);font-family:var(--body,inherit);direction:rtl;text-align:right}"
    + ".rd[open] .rd-box{animation:rdIn .18s ease-out}@keyframes rdIn{from{opacity:0;transform:translateY(10px) scale(.97)}to{opacity:1;transform:none}}"
    + ".rd .rd-ic{width:44px;height:44px;border-radius:14px;display:grid;place-items:center;font-size:22px;background:color-mix(in srgb,var(--accent,#4f7cff) 16%,transparent);margin-bottom:12px}"
    + ".rd.danger .rd-ic{background:rgba(229,72,77,.16)}"
    + ".rd h3{margin:0 0 6px;font:800 19px var(--body,inherit)}"
    + ".rd p{margin:0;color:var(--muted,#555);font-size:16px;line-height:1.6;white-space:pre-line}"
    + ".rd .rd-act{display:flex;gap:10px;justify-content:flex-start;margin-top:20px;flex-wrap:wrap}"
    + ".rd button{font:700 15.5px var(--body,inherit);border-radius:999px;padding:9px 20px;cursor:pointer;border:1px solid var(--line,#ccc);background:transparent;color:var(--ink,#111)}"
    + ".rd button.ok{background:var(--accent,#4f7cff);border-color:var(--accent,#4f7cff);color:#fff}"
    + ".rd.danger button.ok{background:#E5484D;border-color:#E5484D}"
    + ".rd button:focus-visible{outline:3px solid var(--accent,#4f7cff);outline-offset:2px}"
    + "@media (prefers-reduced-motion:reduce){.rd[open] .rd-box{animation:none}}";
  var st = document.createElement("style"); st.textContent = css; document.head.appendChild(st);
  function esc(x){ return String(x == null ? "" : x).replace(/[&<>"]/g, function(c){ return {"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;"}[c]; }); }
  window.runnersDialog = function(o){
    o = o || {};
    return new Promise(function(res){
      var d = document.createElement("dialog");
      if (!d.showModal) { res(o.cancel === false ? (window.alert(o.text), true) : window.confirm(o.text)); return; }
      d.className = "rd" + (o.danger ? " danger" : "");
      d.setAttribute("aria-labelledby", "rdT"); d.setAttribute("aria-describedby", "rdP");
      d.innerHTML = '<form method="dialog" class="rd-box"><div class="rd-ic" aria-hidden="true">' + (o.icon || (o.danger ? "⚠️" : o.cancel === false ? "ℹ️" : "❓")) + '</div>'
        + '<h3 id="rdT">' + esc(o.title || (o.cancel === false ? "הודעה" : "לאשר?")) + '</h3><p id="rdP">' + esc(o.text) + '</p>'
        + '<div class="rd-act"><button value="ok" class="ok">' + esc(o.ok || (o.cancel === false ? "הבנתי" : "אישור")) + '</button>'
        + (o.cancel === false ? "" : '<button value="cancel">' + esc(o.cancel || "ביטול") + '</button>') + '</div></form>';
      document.body.appendChild(d);
      d.addEventListener("click", function(e){ if (e.target === d) d.close("cancel"); });
      d.addEventListener("close", function(){ var v = d.returnValue === "ok"; d.remove(); res(o.cancel === false ? true : v); });
      d.showModal();
      var f = d.querySelector(o.danger ? 'button[value=cancel]' : "button.ok"); if (f) f.focus();
    });
  };
  window.runnersAlert = function(text, title){ return window.runnersDialog({text: text, title: title, cancel: false}); };
})();

/* Sticky header for every page: logo, hamburger menu with the site tree, and the theme/account buttons.
   Each course is shown as a locked item (no sub-items) unless the visitor has access to it; logged-out or pending visitors see only the home page (see sync.js → runners:auth). */
(function(){
  "use strict";
  if (document.getElementById("topbar")) return;

  var BRANCH = [
    ["/branch/tools/", "מחשבונים וכלי עזר"],
    ["/branch/body/", "אנטומיה ופיזיולוגיה", [["/branch/anatomy/", "האנטומיה של הריצה"], ["/branch/physiology/", "הפיזיולוגיה של הריצה"]]],
    ["/branch/theory/", "תורת האימון", [["/branch/training/", "עקרונות תורת האימון"], ["/branch/planning/", "תכנון אימונים"], ["/branch/methodology/", "מתודיקה באימון"]]]
  ];
  var SCIENCE = [
    ["/science/anatomy/", "אנטומיה", [["/science/anatomy/skeleton/", "סימולטור שלד"], ["/science/anatomy/unit1/", "יחידה 1: מבנה מערכות הגוף"], ["/science/anatomy/unit3/", "יחידות 2–3: מערכת שלד-שריר ומפרקים"], ["/science/anatomy/unit4/", "יחידה 4: מערכת שלד-שריר: שרירים"]]],
    [null, "פיזיולוגיה"],
    [null, "קניזיולוגיה"]
  ];

  /* An icon beside every item in the site menu (by address; items without an address by their name). */
  var ICON = {
    "/": "🏠", "/admin/": "⚙️",
    "/branch/": "🏃", "/branch/tools/": "🧮",
    "/branch/body/": "🫀", "/branch/anatomy/": "🦵", "/branch/physiology/": "🫁",
    "/branch/theory/": "📈", "/branch/training/": "📘", "/branch/planning/": "🗓️", "/branch/methodology/": "📣",
    "/science/": "🔬", "/science/anatomy/": "🩻", "/science/anatomy/skeleton/": "🦴",
    "/science/anatomy/unit1/": "🧍", "/science/anatomy/unit3/": "🦿", "/science/anatomy/unit4/": "💪",
    "פיזיולוגיה": "⚡", "קניזיולוגיה": "🤸", "branch": "🏃", "science": "🔬"
  };
  function ic(k){ return ICON[k] ? '<span class="ic" aria-hidden="true">' + ICON[k] + '</span>' : ''; }

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
    + ".tb-tree .ic{flex:none;width:26px;text-align:center;font-size:18px;line-height:1;font-family:'Apple Color Emoji','Segoe UI Emoji','Noto Color Emoji',sans-serif}"
    + ".tb-tree ul ul .ic{font-size:16px;width:24px}"
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

  /* Pages live at folder addresses (/branch/training/, see api/gate.php). */
  function canon(href){ return new URL(href, location.href).pathname.replace(/index\.html$/, ""); }
  var here = canon(location.href);
  function esc(s){ return String(s).replace(/[&<>"]/g, function(c){ return {"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;"}[c]; }); }
  /* Pages that contain enrichment chapters (marked in the admin page) get a small tag in the menu. */
  var EXP = {};
  function link(href, text){ return '<a href="' + href + '"' + (here === canon(href) ? ' aria-current="page"' : '') + '>' + ic(href) + '<span>' + esc(text) + '</span>' + (EXP[href] ? '<span class="ex-tag">העשרה</span>' : '') + '</a>'; }
  function tree(){
    var a = window.runnersAuth || {}, br = !!(a.branch || a.admin), sci = !!(a.science || a.admin);
    var h = '<ul>' + '<li>' + link("/", "דף הבית") + '</li>';
    /* Not logged in, or waiting for approval: the site is closed, so the menu has only the home page. */
    if (!a.email || a.pending) {
      return h + '</ul><p class="lock">' + (a.pending ? "הבקשה שלך ממתינה לאישור של מנהל האתר." : "האתר פתוח רק למשתתפי הקורס. נכנסים או נרשמים בדף הבית.") + '</p>';
    }
    function locked(area, name){
      return '<li><a href="/?locked=' + area + '">' + ic(area) + '<span>' + name + '</span> <span aria-hidden="true">🔒</span><span class="soon">נעול</span></a>'
        + '<span class="lock">הגישה לקורס הזה עוד לא אושרה לך. לפרטים ←</span></li>';
    }
    h += br ? '<li>' + link("/branch/", "קורס ענפי") + '<ul>' + BRANCH.map(function(b){ return '<li>' + link(b[0], b[1]) + (b[2] ? '<ul>' + b[2].map(function(u){ return '<li>' + link(u[0], u[1]) + '</li>'; }).join("") + '</ul>' : '') + '</li>'; }).join("") + '</ul></li>'
            : locked("branch", "קורס ענפי");
    if (sci) {
      h += '<li>' + link("/science/", "קורס מדעי") + '<ul>' + SCIENCE.map(function(t){
        if (!t[0]) return '<li><span class="na">' + ic(t[1]) + '<span>' + esc(t[1]) + '</span><span class="soon">בקרוב</span></span></li>';
        return '<li>' + link(t[0], t[1]) + (t[2] ? '<ul>' + t[2].map(function(u){ return '<li>' + link(u[0], u[1]) + '</li>'; }).join("") + '</ul>' : '') + '</li>';
      }).join("") + '</ul></li>';
    } else {
      h += locked("science", "קורס מדעי");
    }
    if (a.admin) h += '<li>' + link("/admin/", "ניהול האתר") + '</li>';
    return h + '</ul>';
  }
  function render(){
    drawer.innerHTML = '<div class="tb-dh"><b>ניווט באתר</b><button type="button" class="tb-close" aria-label="סגירת התפריט">×</button></div><div class="tb-tree">' + tree() + '</div>';
    drawer.querySelector(".tb-close").onclick = close;
  }
  render();
  function loadClass(){
    window.runnersClass = fetch("/api/notyet.php", {credentials: "same-origin", cache: "no-store"})
      .then(function(r){ return r.ok ? r.json() : null; }).catch(function(){ return null; });
    window.runnersClass.then(function(j){
      EXP = {}; var e = (j && j.extra) || {};
      for (var k in e) if (e[k] && e[k].length) EXP[k] = true;
      if (drawer.hidden) render();
    });
  }
  loadClass();
  document.addEventListener("runners:auth", function(){ render(); loadClass(); });

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

/* Chapters: a topic page opens with cards for all its chapters (title, what's in it, done or not).
   A card opens the chapter (address #c=<id>, so the browser's Back returns to the cards). While reading, a short
   bar on top shows "all chapters", the chapter number and previous / next. The page's own chapter buttons (#rail)
   stay in the DOM, hidden, and still do the actual switching, so every page keeps its own logic. */
(function(){
  "use strict";
  var nav = document.querySelector("nav.rail"), rail = nav && document.getElementById("rail"), main = document.getElementById("main");
  if (!rail || !main) return;
  var css = document.createElement("style");
  css.textContent = ""
    + "nav.rail.cp-on>#rail{display:none!important}"
    + "nav.rail.cp-idx{display:none}"
    + ".cp{display:flex;align-items:center;gap:8px;padding-block:8px}"
    + "nav.rail .cp.wrap{overflow:visible}"
    + ".cp button{font:700 15px var(--body);color:var(--ink);background:var(--paper);border:1px solid var(--line);border-radius:999px;cursor:pointer;min-height:40px;display:inline-flex;align-items:center;gap:6px;padding:0 14px}"
    + ".cp button:focus-visible,.chx button:focus-visible{outline:3px solid var(--accent);outline-offset:2px}"
    + ".cp button:disabled{opacity:.35;cursor:default}"
    + ".cp .cp-all{flex:0 0 auto;color:var(--accent);border-color:var(--accent)}"
    + ".cp .cp-where{flex:1 1 auto;min-width:0;display:flex;align-items:center;gap:8px;font-weight:700;overflow:hidden}"
    + ".cp .cp-n{flex:0 0 auto;font-size:12.5px;color:var(--accent);background:var(--accent-soft);border-radius:999px;padding:2px 9px}"
    + ".cp .cp-t{min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}"
    + ".cp .cp-step{flex:0 0 auto}"
    + ".cp .cp-all .cp-c{font-size:12px;transition:transform .15s}"
    + ".cp .cp-all[aria-expanded=true] .cp-c{transform:rotate(180deg)}"
    + ".cp-panel{position:absolute;inset-inline:0;top:100%;background:var(--paper);border-bottom:1px solid var(--line);box-shadow:0 18px 30px -18px rgba(0,0,0,.5);max-height:min(70vh,560px);overflow:auto;z-index:5}"
    + ".cp-panel[hidden]{display:none}"
    + "nav.rail .cp-panel .wrap{display:block;overflow:visible;padding-block:0}"
    + ".cp-panel .cp-head{display:flex;justify-content:space-between;gap:10px;font-size:13.5px;color:var(--muted);padding:12px 2px 8px}"
    + ".cp-panel .cp-head button{font:600 13.5px var(--body);color:var(--accent);background:none;border:0;padding:0;cursor:pointer;text-decoration:underline}"
    + ".cp-panel .cp-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:6px;padding-bottom:14px}"
    + ".cp-panel .cp-grid button{display:flex;align-items:center;gap:10px;text-align:start;font:600 15px var(--body);color:var(--ink);background:var(--bg);border:1px solid var(--line);border-radius:10px;padding:10px 12px;cursor:pointer}"
    + ".cp-panel .cp-grid button:hover{border-color:var(--accent)}"
    + ".cp-panel .cp-grid button[aria-current=true]{border-color:var(--accent);background:var(--accent-soft);color:var(--accent)}"
    + ".cp-panel .cp-grid .k{flex:0 0 auto;min-width:24px;height:24px;border-radius:50%;display:grid;place-items:center;font-size:12.5px;font-weight:800;background:var(--line);color:var(--ink)}"
    + ".cp-panel .cp-grid .k.on{background:var(--ok);color:#fff}"
    + ".chx{padding-block:8px 28px}"
    + ".chx-top{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:10px;margin:6px 0 14px}"
    + ".chx-top h2{margin:0;font-size:22px}"
    + ".chx-top .sum{color:var(--muted);font-size:15px}"
    + ".chx-go{font:700 16px var(--body);color:#fff;background:var(--accent);border:0;border-radius:999px;padding:10px 20px;cursor:pointer}"
    + ".chx-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px}"
    + ".chx-card{display:flex;flex-direction:column;gap:6px;text-align:start;font:inherit;color:var(--ink);background:var(--paper);border:1px solid var(--line);border-top:5px solid var(--accent);border-radius:14px;padding:14px 16px 16px;cursor:pointer;position:relative;transition:transform .12s,border-color .12s}"
    + ".chx-card:hover{transform:translateY(-2px);border-color:var(--accent)}"
    + ".chx-card .no{font-size:13px;font-weight:700;color:var(--accent)}"
    + ".chx-card b{font-size:18px;line-height:1.3}"
    + ".chx-card .sub{font-size:14.5px;color:var(--muted);line-height:1.45}"
    + ".chx-card .st{margin-top:auto;padding-top:6px;font-size:13.5px;font-weight:700;color:var(--muted)}"
    + ".chx-card.done{border-top-color:var(--ok)}"
    + ".chx-card.done .st{color:var(--ok)}"
    + ".chx-card.next{box-shadow:0 0 0 2px var(--accent)}"
    + ".chx-card{overflow:hidden}"
    + ".chx-card.ny{opacity:.92}"
    + ".chx-card .ny-rib{position:absolute;top:22px;left:-46px;width:190px;transform:rotate(-35deg);background:#E0A100;color:#1b1400;font:800 12.5px var(--body);text-align:center;padding:5px 0;box-shadow:0 2px 6px rgba(0,0,0,.3);pointer-events:none}"
    + ".ex-tag{display:inline-block;vertical-align:middle;margin-inline-start:8px;font:800 11.5px var(--body);color:#fff;background:#8B5CF6;border-radius:999px;padding:1px 8px;white-space:nowrap;line-height:1.5}"
    + ".ny-badge.ex{background:#8B5CF6;color:#fff}"
    + ".chx-card .ny-rib.lr{background:#3B82F6;color:#fff}"
    + ".ny-badge.lr,.cp-panel .ny-tag.lr{background:#3B82F6;color:#fff}"
    + ".ny-badge{display:inline-flex;align-items:center;gap:4px;vertical-align:middle;margin-inline-start:10px;font:800 13px var(--body);color:#1b1400;background:#E0A100;border-radius:999px;padding:3px 10px;white-space:nowrap}"
    + ".cp-panel .ny-tag{margin-inline-start:auto;font:700 11.5px var(--body);color:#1b1400;background:#E0A100;border-radius:999px;padding:1px 7px;white-space:nowrap}"
    + "@media (max-width:560px){.cp .cp-l,.cp .cp-t{display:none}.cp button{padding:0 12px}.chx-grid{grid-template-columns:1fr}.chx-card b{font-size:17px}}";
  document.head.appendChild(css);

  var CH = (typeof chapters !== "undefined" && chapters) || null; // the page's chapter list (title, sub)
  nav.classList.add("cp-on");
  var bar = document.createElement("div"); bar.className = "cp wrap";
  bar.innerHTML = '<button type="button" class="cp-all" aria-expanded="false" aria-controls="cpPanel"><span aria-hidden="true">☰</span><span>כל הפרקים</span><span class="cp-c" aria-hidden="true">▾</span></button>'
    + '<span class="cp-where"><span class="cp-n"></span><span class="cp-t"></span></span>'
    + '<button type="button" class="cp-step" data-d="-1" aria-label="לפרק הקודם"><span aria-hidden="true">→</span><span class="cp-l">הקודם</span></button>'
    + '<button type="button" class="cp-step" data-d="1" aria-label="לפרק הבא"><span class="cp-l">הבא</span><span aria-hidden="true">←</span></button>';
  nav.appendChild(bar);
  /* "all chapters" opens a drop-down list of the chapters, right here (no leaving the chapter). */
  var panel = document.createElement("div"); panel.className = "cp-panel"; panel.id = "cpPanel"; panel.hidden = true;
  panel.innerHTML = '<div class="wrap"><div class="cp-head"><span class="cp-sum"></span><button type="button" class="cp-cards">לתצוגת הכרטיסים</button></div><div class="cp-grid"></div></div>';
  nav.appendChild(panel);
  if (getComputedStyle(nav).position === "static") nav.style.position = "relative";
  var idx = document.createElement("section"); idx.className = "chx wrap"; idx.setAttribute("aria-label", "פרקי הנושא");
  main.parentNode.insertBefore(idx, main);

  function tabs(){ return Array.prototype.slice.call(rail.querySelectorAll("button")); }
  function sel(t){ for (var i = 0; i < t.length; i++) if (t[i].getAttribute("aria-selected") === "true") return i; return 0; }
  function isDone(b){ var d = b.querySelector(".done"); return !!(d && d.classList.contains("on")); }
  function esc(x){ return String(x == null ? "" : x).replace(/[&<>"]/g, function(c){ return {"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;"}[c]; }); }
  function info(b, j){
    var c = CH && CH[j], lab = (b.textContent || "").trim(), m = lab.match(/^(\d+)\.\s+(.*)$/);
    return {id: b.getAttribute("data-id"), short: m && +m[1] === j + 1 ? m[2] : lab, title: c && c.title || lab, sub: c && c.sub || ""};
  }
  function idFromHash(){ var m = location.hash.match(/^#c=([\w-]+)$/); return m ? m[1] : null; }

  function drawIndex(){
    var t = tabs(); if (!t.length) return;
    var n = t.filter(isDone).length, firstOpen = -1;
    for (var j = 0; j < t.length; j++) if (!isDone(t[j])) { firstOpen = j; break; }
    var go = firstOpen < 0 ? 0 : firstOpen;
    idx.innerHTML = '<div class="chx-top"><div><h2>' + t.length + ' פרקים</h2><div class="sum">' + (n ? "הושלמו " + n + " מתוך " + t.length : "בוחרים פרק ומתחילים. בסוף כל פרק יש בוחן קצר.") + '</div></div>'
      + '<button type="button" class="chx-go" data-i="' + go + '">' + (n === 0 ? "להתחיל מפרק 1" : firstOpen < 0 ? "לחזור על הנושא מההתחלה" : "להמשיך לפרק " + (go + 1)) + ' ←</button></div>'
      + '<div class="chx-grid">' + t.map(function(b, j){
        var f = info(b, j), d = isDone(b);
        return '<button type="button" class="chx-card' + (d ? " done" : "") + (j === firstOpen && n ? " next" : "") + '" data-i="' + j + '">'
          + '<span class="no">פרק ' + (j + 1) + '</span><b>' + esc(f.title) + '</b>' + (f.sub ? '<span class="sub">' + esc(f.sub) + '</span>' : "")
          + '<span class="st">' + (d ? "✓ הושלם" : j === firstOpen && n ? "הפרק הבא שלך" : "עוד לא הושלם") + '</span></button>';
      }).join("") + '</div>';
  }
  function drawBar(){
    var t = tabs(); if (!t.length) return;
    var i = sel(t), f = info(t[i], i);
    bar.querySelector(".cp-n").textContent = "פרק " + (i + 1) + " מתוך " + t.length;
    bar.querySelector(".cp-t").textContent = f.short;
    bar.querySelector('[data-d="-1"]').disabled = i === 0;
    bar.querySelector('[data-d="1"]').disabled = i === t.length - 1;
    panel.querySelector(".cp-sum").textContent = "הושלמו " + t.filter(isDone).length + " מתוך " + t.length;
    panel.querySelector(".cp-grid").innerHTML = t.map(function(b, j){
      var f = info(b, j);
      return '<button type="button" data-p="' + j + '"' + (j === i ? ' aria-current="true"' : "") + '><span class="k' + (isDone(b) ? " on" : "") + '">' + (isDone(b) ? "✓" : j + 1) + '</span><span>' + esc(f.title) + '</span></button>';
    }).join("");
  }
  function openPanel(v){
    panel.hidden = !v; bar.querySelector(".cp-all").setAttribute("aria-expanded", v ? "true" : "false");
    if (v) { var a = panel.querySelector("[aria-current]"); if (a) a.focus({preventScroll: true}); }
  }
  var showing = null;
  function showIndex(){
    showing = "index"; openPanel(false); drawIndex();
    idx.hidden = false; main.hidden = true; nav.classList.add("cp-idx");
    var nx = document.getElementById("nextChap"); if (nx) nx.hidden = true;
  }
  function showChapter(id){
    var t = tabs(), b = null;
    for (var j = 0; j < t.length; j++) if (t[j].getAttribute("data-id") === id) b = t[j];
    if (!b) { showIndex(); return; }
    showing = "chapter";
    idx.hidden = true; main.hidden = false; nav.classList.remove("cp-idx");
    if (b.getAttribute("aria-selected") !== "true") b.click(); else drawBar();
    window.scrollTo({top: 0});
  }
  function openAt(j){ var t = tabs(); if (t[j]) location.hash = "c=" + t[j].getAttribute("data-id"); }
  function route(){ var id = idFromHash(); if (id) showChapter(id); else showIndex(); }

  idx.addEventListener("click", function(e){ var c = e.target.closest && e.target.closest("[data-i]"); if (c) openAt(+c.getAttribute("data-i")); });
  bar.querySelector(".cp-all").onclick = function(){ openPanel(panel.hidden); };
  panel.addEventListener("click", function(e){
    var c = e.target.closest && e.target.closest("[data-p]");
    if (c) { openPanel(false); openAt(+c.getAttribute("data-p")); return; }
    if (e.target.closest && e.target.closest(".cp-cards")) {
      openPanel(false);
      if (idFromHash()) history.pushState(null, "", location.pathname + location.search);
      showIndex(); window.scrollTo({top: 0});
    }
  });
  document.addEventListener("click", function(e){ if (!panel.hidden && !nav.contains(e.target)) openPanel(false); });
  document.addEventListener("keydown", function(e){ if (e.key === "Escape" && !panel.hidden) { openPanel(false); bar.querySelector(".cp-all").focus(); } });
  bar.querySelectorAll(".cp-step").forEach(function(s){ s.onclick = function(){ openPanel(false); openAt(sel(tabs()) + (+s.getAttribute("data-d"))); }; });
  window.addEventListener("hashchange", route);
  window.addEventListener("popstate", route);
  /* The page also switches chapters by itself ("next chapter" button): keep the address and the bar in step. */
  new MutationObserver(function(){
    drawBar();
    if (showing === "chapter") {
      var t = tabs(), id = t.length && t[sel(t)].getAttribute("data-id");
      if (id && idFromHash() !== id) history.replaceState(null, "", "#c=" + id);
    } else if (showing === "index") drawIndex();
  }).observe(rail, {childList: true, subtree: true, attributes: true, attributeFilter: ["aria-selected", "class"]});
  /* Chapters the teacher hasn't reached in class yet (set in the admin page): a diagonal ribbon on the card,
     a badge beside the chapter title, and a tag in the drop-down list. */
  /* NY = עוד לא נלמד, LR = בלימוד עכשיו */
  var NY = [], LR = [];
  var NYS = {ny: {rib: "עוד לא נלמד בכיתה", tag: "עוד לא נלמד", badge: "🕓 עוד לא נלמד בכיתה", cls: ""},
             lr: {rib: "בלימוד בכיתה", tag: "בלימוד", badge: "📖 בלימוד בכיתה", cls: " lr"}};
  var EX = [];
  function isEx(b){ return !!(b && EX.indexOf(b.getAttribute("data-id")) >= 0); }
  function stateOf(b){ if (!b) return null; var id = b.getAttribute("data-id"); return NY.indexOf(id) >= 0 ? "ny" : LR.indexOf(id) >= 0 ? "lr" : null; }
  function decorate(){
    var t = tabs();
    idx.querySelectorAll(".chx-card[data-i]").forEach(function(c){
      var s = stateOf(t[+c.getAttribute("data-i")]);
      c.classList.toggle("ny", s === "ny");
      var r = c.querySelector(".ny-rib");
      if (r && r.getAttribute("data-s") !== s) { r.remove(); r = null; }
      if (s && !r) c.insertAdjacentHTML("afterbegin", '<span class="ny-rib' + NYS[s].cls + '" data-s="' + s + '" aria-hidden="true">' + NYS[s].rib + '</span>');
      var no = c.querySelector(".no"), et = no && no.querySelector(".ex-tag"), ex = isEx(t[+c.getAttribute("data-i")]);
      if (ex && no && !et) no.insertAdjacentHTML("beforeend", '<span class="ex-tag">העשרה</span>');
      if (!ex && et) et.remove();
      var stx = c.querySelector(".st");
      if (stx) { stx.textContent = stx.textContent.replace(/ · (עוד לא נלמד|בלימוד) בכיתה$/, ""); if (s) stx.textContent += " · " + NYS[s].rib; }
    });
    panel.querySelectorAll("[data-p]").forEach(function(x){
      var s = stateOf(t[+x.getAttribute("data-p")]), g = x.querySelector(".ny-tag");
      if (g && g.getAttribute("data-s") !== s) { g.remove(); g = null; }
      if (s && !g) x.insertAdjacentHTML("beforeend", '<span class="ny-tag' + NYS[s].cls + '" data-s="' + s + '">' + NYS[s].tag + '</span>');
      if (isEx(t[+x.getAttribute("data-p")]) && !x.querySelector(".ex-tag")) x.insertAdjacentHTML("beforeend", '<span class="ex-tag">העשרה</span>');
    });
    var h = main.querySelector(".chap-head h2"), cur = t.length && t[sel(t)];
    if (h) {
      var s2 = stateOf(cur), bd = h.querySelector(".ny-badge");
      if (bd && bd.getAttribute("data-s") !== s2) { bd.remove(); bd = null; }
      if (s2 && !bd) h.insertAdjacentHTML("beforeend", '<span class="ny-badge' + NYS[s2].cls + '" data-s="' + s2 + '">' + NYS[s2].badge + '</span>');
      var e2 = isEx(cur), eb = h.querySelector(".ny-badge.ex");
      if (e2 && !eb) h.insertAdjacentHTML("beforeend", '<span class="ny-badge ex">✨ חומר העשרה</span>');
      if (!e2 && eb) eb.remove();
    }
  }
  new MutationObserver(function(){ if (NY.length || LR.length || EX.length) decorate(); }).observe(main, {childList: true});
  new MutationObserver(function(){ if (NY.length || LR.length || EX.length) decorate(); }).observe(idx, {childList: true});
  new MutationObserver(function(){ if (NY.length || LR.length || EX.length) decorate(); }).observe(panel, {childList: true, subtree: true});
  drawBar(); route();
  try {
    (window.runnersClass || fetch("/api/notyet.php", {credentials: "same-origin", cache: "no-store"}).then(function(r){ return r.ok ? r.json() : null; }))
      .then(function(j){ if (j && j.notyet) { var p = location.pathname; NY = j.notyet[p] || []; LR = (j.learning || {})[p] || []; EX = (j.extra || {})[p] || []; decorate(); } })
      .catch(function(){});
  } catch(e) {}
})();

/* Site search (inside a course only): a 🔍 button in the header (also "/" or Ctrl+K) opens a search dialog.
   The index of the current course (all chapter text, split into sections) comes from /api/search_index.php,
   which serves it only to users with access to that course; it is built with scripts/build_search.js.
   Matching is done here: every word must appear; Hebrew niqqud, quote marks and final letters are ignored.
   Choosing a result opens the chapter, scrolls to the passage and highlights the word. */
(function(){
  "use strict";
  var m = location.pathname.match(/^\/(branch|science)\//);
  if (!m || !document.getElementById("topbar")) return;
  var COURSE = m[1], NAME = COURSE === "branch" ? "בקורס הענפי" : "בקורס המדעי";
  var FIND = "runners.find";

  var css = ""
    + ".ss-btn{width:40px;height:40px;border-radius:12px;border:1px solid var(--line,#D3DCE3);background:var(--paper,#fff);color:var(--ink,#1A2530);cursor:pointer;display:grid;place-items:center;flex:none}"
    + ".ss-btn:hover{border-color:var(--accent,#1F5FD6);color:var(--accent,#1F5FD6)}.ss-btn:focus-visible{outline:3px solid var(--accent,#1F5FD6);outline-offset:2px}"
    + ".ss-btn svg{width:20px;height:20px}"
    + ".ss{border:0;padding:0;background:transparent;width:min(680px,calc(100vw - 24px));max-width:none;max-height:calc(100dvh - 40px);margin:min(9vh,80px) auto auto;color:var(--ink,#111);overflow:visible}"
    + ".ss::backdrop{background:rgba(6,10,24,.55);backdrop-filter:blur(3px)}"
    + ".ss-box{background:var(--paper,#fff);border:1px solid var(--line,#ddd);border-radius:20px;box-shadow:0 24px 60px rgba(0,0,0,.35);direction:rtl;text-align:right;display:flex;flex-direction:column;max-height:calc(100dvh - min(9vh,80px) - 24px);overflow:hidden;font-family:var(--body,'Assistant',system-ui,sans-serif)}"
    + ".ss[open] .ss-box{animation:rdIn .18s ease-out}"
    + ".ss-top{display:flex;align-items:center;gap:10px;padding:12px 14px;border-bottom:1px solid var(--line,#ddd)}"
    + ".ss-top svg{width:20px;height:20px;flex:none;color:var(--muted,#5B6B78)}"
    + ".ss-in{flex:1;min-width:0;font:600 18px var(--body,'Assistant',system-ui,sans-serif);border:0;background:transparent;color:inherit;padding:8px 2px;outline:none}"
    + ".ss-in::-webkit-search-cancel-button{display:none}"
    + ".ss-x{width:36px;height:36px;border-radius:10px;border:1px solid var(--line,#ddd);background:none;color:inherit;font-size:20px;cursor:pointer;line-height:1;flex:none}"
    + ".ss-x:focus-visible,.ss-r:focus-visible{outline:3px solid var(--accent,#1F5FD6);outline-offset:2px}"
    + ".ss-st{padding:8px 16px;font-size:14px;color:var(--muted,#5B6B78);min-height:20px}"
    + ".ss-list{overflow:auto;padding:0 10px 12px;overscroll-behavior:contain}"
    + ".ss-pg{font:800 13px var(--body,'Assistant',system-ui,sans-serif);color:var(--muted,#5B6B78);padding:12px 8px 4px;display:flex;gap:6px;align-items:center}"
    + ".ss-r{display:block;text-decoration:none;color:inherit;padding:10px 12px;border-radius:12px;border:1px solid transparent}"
    + ".ss-r:hover,.ss-r:focus{background:var(--accent-soft,#E8EEF8);border-color:color-mix(in srgb,var(--accent,#1F5FD6) 30%,transparent);outline:none}"
    + ".ss-w{font:700 15.5px var(--body,'Assistant',system-ui,sans-serif);display:flex;flex-wrap:wrap;gap:4px 8px;align-items:baseline}"
    + ".ss-w .sec{color:var(--accent,#1F5FD6)}.ss-w .ch{color:var(--muted,#5B6B78);font-weight:600;font-size:13.5px}"
    + ".ss-k{font:700 11.5px var(--body,'Assistant',system-ui,sans-serif);border:1px solid var(--line,#ddd);border-radius:999px;padding:0 7px;color:var(--muted,#5B6B78)}"
    + ".ss-sn{font-size:14.5px;line-height:1.55;color:var(--muted,#5B6B78);margin-top:3px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}"
    + ".ss mark,mark.ss-hit{background:color-mix(in srgb,#F5C242 55%,transparent);color:inherit;border-radius:3px;padding:0 1px}"
    + "mark.ss-hit{animation:ssHit 2.2s ease-out 1;box-shadow:0 0 0 3px color-mix(in srgb,#F5C242 45%,transparent)}"
    + "@keyframes ssHit{0%,40%{box-shadow:0 0 0 7px color-mix(in srgb,#F5C242 65%,transparent)}100%{box-shadow:0 0 0 3px color-mix(in srgb,#F5C242 45%,transparent)}}"
    + ".ss-ft{border-top:1px solid var(--line,#ddd);padding:8px 16px;font-size:12.5px;color:var(--muted,#5B6B78);display:flex;gap:14px;flex-wrap:wrap}"
    + "@media (max-width:560px){.ss{margin-top:8px;width:calc(100vw - 16px)}.ss-box{max-height:calc(100dvh - 16px)}.ss-ft{display:none}.ss-in{font-size:17px}}"
    + "@media (prefers-reduced-motion:reduce){.ss[open] .ss-box,mark.ss-hit{animation:none}}";
  var st = document.createElement("style"); st.textContent = css; document.head.appendChild(st);

  function esc(x){ return String(x == null ? "" : x).replace(/[&<>"]/g, function(c){ return {"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;"}[c]; }); }
  var FIN = {"ך":"כ","ם":"מ","ן":"נ","ף":"פ","ץ":"צ"};
  /* Normalised text + map from each normalised char back to its index in the original. */
  function norm(s){
    s = String(s || ""); var out = "", map = [], sp = true;
    for (var i = 0; i < s.length; i++) {
      var c = s[i], code = c.charCodeAt(0);
      if (code >= 0x591 && code <= 0x5C7 && code !== 0x5BE) continue;           /* niqqud and cantillation */
      if (/["'׳״`’‘“”]/.test(c)) continue;                                      /* quote marks: צח״מ = צחמ */
      if (/[\s\-–—־_\/·|,.:;!?()\[\]{}«»]/.test(c)) { if (!sp) { out += " "; map.push(i); sp = true; } continue; }
      c = FIN[c] || c.toLowerCase(); out += c; map.push(i); sp = false;
    }
    return {s: out, map: map};
  }
  function terms(q){
    var n = norm(q).s.trim();
    return n ? n.split(" ").filter(function(t, i, a){ return t && a.indexOf(t) === i; }).sort(function(a, b){ return b.length - a.length; }) : [];
  }

  /* ---------- index ---------- */
  var IDX = null, loading = null;
  function load(){
    if (IDX) return Promise.resolve(IDX);
    if (loading) return loading;
    loading = fetch("/api/search_index.php?course=" + COURSE, {credentials: "same-origin"})
      .then(function(r){ return r.json().catch(function(){ return {ok: false}; }).then(function(j){ if (!r.ok || !j.ok) throw new Error(j.error || r.status); return j.items; }); })
      .then(function(items){
        IDX = items.map(function(r){
          return {r: r, x: norm(r.x), h: norm(r.s + " " + r.t).s, s: norm(r.s).s, t: norm(r.t).s};
        });
        return IDX;
      })
      .catch(function(e){ loading = null; throw e; });
    return loading;
  }
  function count(hay, t){ var n = 0, i = hay.indexOf(t); while (i >= 0 && n < 6) { n++; i = hay.indexOf(t, i + t.length); } return n; }
  function search(q){
    var T = terms(q); if (!T.length || !IDX) return [];
    var phrase = norm(q).s.trim(), multi = T.length > 1, res = [];
    IDX.forEach(function(e){
      var sc = 0;
      for (var i = 0; i < T.length; i++) {
        var t = T[i], inX = count(e.x.s, t), inS = e.s.indexOf(t) >= 0, inT = e.t.indexOf(t) >= 0;
        if (!inX && !inS && !inT) return;
        sc += inX + (inS ? 6 : 0) + (inT ? 3 : 0) + (e.x.s.indexOf(" " + t) >= 0 || e.x.s.indexOf(t) === 0 ? 1 : 0);
      }
      if (multi && (e.x.s.indexOf(phrase) >= 0 || e.s.indexOf(phrase) >= 0)) sc += 8;
      if (e.r.k === "quiz") sc *= 0.55; else if (e.r.k === "cards") sc *= 0.7;
      res.push({e: e, sc: sc});
    });
    res.sort(function(a, b){ return b.sc - a.sc; });
    return res.slice(0, 60);
  }
  /* A short passage around the first match, with every search word marked. */
  function snippet(e, T, ph){
    var n = e.x, raw = e.r.x, at = ph ? n.s.indexOf(ph) : -1;
    if (at >= 0) T = [ph].concat(T);
    for (var i = 0; i < T.length && at < 0; i++) at = n.s.indexOf(T[i]);
    if (at < 0) return esc(raw.slice(0, 150)) + (raw.length > 150 ? "…" : "");
    var a = Math.max(0, n.map[at] - 55), b = Math.min(raw.length, n.map[at] + 150);
    if (a > 0) { var sp = raw.indexOf(" ", a); if (sp > 0 && sp < n.map[at]) a = sp + 1; }
    var marks = [];
    T.forEach(function(t){
      var p = n.s.indexOf(t);
      while (p >= 0) {
        var s0 = n.map[p], s1 = n.map[p + t.length - 1] + 1;
        if (s0 >= a && s1 <= b) marks.push([s0, s1]);
        p = n.s.indexOf(t, p + t.length);
      }
    });
    marks.sort(function(x, y){ return x[0] - y[0] || y[1] - x[1]; });
    var html = a > 0 ? "…" : "", pos = a;
    marks.forEach(function(mk){ if (mk[0] < pos) return; html += esc(raw.slice(pos, mk[0])) + "<mark>" + esc(raw.slice(mk[0], mk[1])) + "</mark>"; pos = mk[1]; });
    return html + esc(raw.slice(pos, b)) + (b < raw.length ? "…" : "");
  }

  /* ---------- dialog ---------- */
  var ICON_S = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="10.5" cy="10.5" r="6.5" fill="none" stroke="currentColor" stroke-width="2.2"/><path d="M15.5 15.5 21 21" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>';
  var btn = document.createElement("button");
  btn.type = "button"; btn.className = "ss-btn"; btn.setAttribute("aria-label", "חיפוש " + NAME); btn.title = "חיפוש " + NAME + " (/)";
  btn.innerHTML = ICON_S;
  var host = document.getElementById("topActions");
  if (host) host.insertBefore(btn, host.firstChild);

  var dlg = null, inp, list, stat, timer = null;
  var KIND = {quiz: "בוחן", cards: "כרטיסיות", tool: "כלי"};
  function build(){
    dlg = document.createElement("dialog");
    dlg.className = "ss"; dlg.setAttribute("aria-label", "חיפוש " + NAME);
    dlg.innerHTML = '<div class="ss-box"><div class="ss-top">' + ICON_S
      + '<input class="ss-in" type="search" placeholder="מה לחפש ' + NAME + '?" aria-label="חיפוש ' + NAME + '" autocomplete="off" enterkeyhint="search">'
      + '<button type="button" class="ss-x" aria-label="סגירת החיפוש">×</button></div>'
      + '<div class="ss-st" role="status" aria-live="polite"></div><div class="ss-list"></div>'
      + '<div class="ss-ft"><span>↑ ↓ מעבר בין תוצאות</span><span>Enter לפתיחה</span><span>Esc לסגירה</span></div></div>';
    document.body.appendChild(dlg);
    inp = dlg.querySelector(".ss-in"); list = dlg.querySelector(".ss-list"); stat = dlg.querySelector(".ss-st");
    dlg.querySelector(".ss-x").onclick = function(){ dlg.close(); };
    dlg.addEventListener("click", function(e){ if (e.target === dlg) dlg.close(); });
    dlg.addEventListener("close", function(){ document.documentElement.classList.remove("tb-lock"); btn.focus({preventScroll: true}); });
    inp.addEventListener("input", function(){ clearTimeout(timer); timer = setTimeout(run, 120); });
    inp.addEventListener("keydown", function(e){
      if (e.key === "ArrowDown") { var f = list.querySelector(".ss-r"); if (f) { e.preventDefault(); f.focus(); } }
      if (e.key === "Enter") { var g = list.querySelector(".ss-r"); if (g) { e.preventDefault(); g.click(); } }
    });
    list.addEventListener("keydown", function(e){
      if (e.key !== "ArrowDown" && e.key !== "ArrowUp") return;
      var all = Array.prototype.slice.call(list.querySelectorAll(".ss-r")), i = all.indexOf(document.activeElement);
      if (i < 0) return; e.preventDefault();
      if (e.key === "ArrowUp" && i === 0) { inp.focus(); return; }
      var n = all[i + (e.key === "ArrowDown" ? 1 : -1)]; if (n) n.focus();
    });
    list.addEventListener("click", function(e){
      var a = e.target.closest && e.target.closest(".ss-r"); if (!a) return;
      e.preventDefault(); go(+a.getAttribute("data-i"));
    });
  }
  var last = [];
  function run(){
    var q = inp.value.trim();
    if (norm(q).s.trim().length < 2) { list.innerHTML = ""; stat.textContent = q ? "כותבים לפחות 2 אותיות." : "מחפשים בכל הפרקים, הבחנים והכרטיסיות " + NAME + "."; last = []; return; }
    if (!IDX) { stat.textContent = "טוען..."; load().then(run, fail); return; }
    var T = terms(q); last = search(q);
    if (!last.length) { list.innerHTML = ""; stat.textContent = "לא נמצאו תוצאות ל\"" + q + "\". נסו מילה אחרת או חלק ממנה."; return; }
    stat.textContent = last.length >= 60 ? "נמצאו יותר מ-60 תוצאות. מוצגות הטובות ביותר." : "נמצאו " + last.length + " תוצאות.";
    /* group by page, pages ordered by their best result */
    var order = [], groups = {};
    last.forEach(function(h, i){ var u = h.e.r.u; if (!groups[u]) { groups[u] = []; order.push(u); } groups[u].push(i); });
    list.innerHTML = order.map(function(u){
      var g = groups[u];
      return '<div class="ss-pg">' + esc(last[g[0]].e.r.p) + ' <span aria-hidden="true">·</span> ' + g.length + '</div>' + g.map(function(i){
        var r = last[i].e.r, chap = r.n ? "פרק " + r.n + ": " + r.t : "";
        var sec = r.s && r.s !== r.t ? r.s : "";
        return '<a class="ss-r" href="' + esc(r.u + (r.c ? "#c=" + r.c : "")) + '" data-i="' + i + '"><div class="ss-w">'
          + (sec ? '<span class="sec">' + esc(sec) + '</span>' : "") + (chap ? '<span class="ch">' + esc(chap) + '</span>' : "")
          + (KIND[r.k] ? '<span class="ss-k">' + KIND[r.k] + '</span>' : "") + '</div>'
          + '<div class="ss-sn">' + snippet(last[i].e, T, T.length > 1 ? norm(q).s.trim() : "") + '</div></a>';
      }).join("");
    }).join("");
  }
  function fail(e){
    var s = String(e && e.message || e);
    stat.textContent = s === "401" || s === "not_logged_in" ? "צריך להתחבר כדי לחפש." : s === "403" || s === "forbidden" ? "אין לך גישה לחיפוש בקורס הזה." : "החיפוש לא נטען. בדקו את החיבור ונסו שוב.";
  }
  function open(){
    if (!dlg) build();
    if (!dlg.open) { dlg.showModal(); document.documentElement.classList.add("tb-lock"); }
    inp.focus(); inp.select();
    run();
    load().then(function(){ if (dlg.open) run(); }, function(e){ if (dlg.open && inp.value.trim()) fail(e); });
  }
  btn.onclick = open;
  document.addEventListener("keydown", function(e){
    var t = e.target, typing = t && (t.isContentEditable || /^(INPUT|TEXTAREA|SELECT)$/.test(t.tagName));
    if ((e.key === "k" || e.key === "K") && (e.ctrlKey || e.metaKey)) { e.preventDefault(); open(); return; }
    if (e.key === "/" && !typing && !e.ctrlKey && !e.metaKey && !e.altKey && !(dlg && dlg.open)) { e.preventDefault(); open(); }
  });

  /* ---------- go to a result ---------- */
  function go(i){
    var h = last[i]; if (!h) return;
    var r = h.e.r;
    try { sessionStorage.setItem(FIND, JSON.stringify({u: r.u, c: r.c, s: r.s, k: r.k, q: inp.value.trim()})); } catch (e) {}
    dlg.close();
    if (r.u !== location.pathname) { location.href = r.u + (r.c ? "#c=" + r.c : ""); return; }
    var want = r.c ? "#c=" + r.c : "";
    if (location.hash !== want) location.hash = want; else setTimeout(spot, 60);
  }
  /* Find the passage on the page: start from the section heading, mark the first search word after it. */
  function spot(){
    var f; try { f = JSON.parse(sessionStorage.getItem(FIND) || "null"); } catch (e) { f = null; }
    if (!f || f.u !== location.pathname) return;
    if (f.c && location.hash !== "#c=" + f.c) return;
    sessionStorage.removeItem(FIND);
    document.querySelectorAll("mark.ss-hit").forEach(function(mk){ mk.replaceWith(document.createTextNode(mk.textContent)); });
    var root = (f.c && document.getElementById("main")) || document.querySelector("main") || document.body;
    var T = terms(f.q), ns = norm(f.s).s.trim();
    var start = null;
    if (f.k === "quiz") start = root.querySelector(".quiz");
    else if (f.k === "cards") start = document.getElementById("fcCard");
    if (!start && ns) {
      var hs = root.querySelectorAll("h2,h3,summary");
      for (var j = 0; j < hs.length && !start; j++) if (norm(hs[j].textContent).s.trim() === ns) start = hs[j];
    }
    if (f.k === "cards" && start) { reveal(start); return; }
    var ph = norm(f.q).s.trim(), P = T.length > 1 && ph ? [ph].concat(T) : T;   /* the whole phrase first, then single words */
    var hit = T.length ? mark(root, start, P) : null;
    reveal(hit || start);
  }
  function mark(root, start, T){
    var w = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, {acceptNode: function(n){
      var p = n.parentNode; if (!p || /^(SCRIPT|STYLE|BUTTON)$/.test(p.nodeName) || p.closest(".ss,.cp-panel,nav")) return NodeFilter.FILTER_REJECT;
      return n.nodeValue.trim() ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
    }});
    var first = null, n;
    while ((n = w.nextNode())) {
      if (start && !(start.compareDocumentPosition(n) & Node.DOCUMENT_POSITION_FOLLOWING) && !start.contains(n)) continue;
      var nn = norm(n.nodeValue);
      for (var i = 0; i < T.length; i++) {
        var p = nn.s.indexOf(T[i]);
        if (p < 0) continue;
        var a = nn.map[p], b = nn.map[p + T[i].length - 1] + 1;
        var mid = n.splitText(a); mid.splitText(b - a);
        var mk = document.createElement("mark"); mk.className = "ss-hit"; mid.parentNode.replaceChild(mk, mid); mk.appendChild(mid);
        return mk;
      }
      if (!first) first = n;
    }
    return null;
  }
  function reveal(el){
    if (!el) return;
    for (var d = el.parentNode; d && d !== document.body; d = d.parentNode) if (d.tagName === "DETAILS" && !d.open) d.open = true;
    el.scrollIntoView({block: "center", behavior: matchMedia("(prefers-reduced-motion: reduce)").matches ? "auto" : "smooth"});
    setTimeout(function(){ document.querySelectorAll("mark.ss-hit").forEach(function(mk){ mk.classList.add("done"); }); }, 6000);
  }
  function later(){ setTimeout(spot, 250); }
  window.addEventListener("hashchange", later);
  if (document.readyState === "complete") later(); else window.addEventListener("load", later);
})();
