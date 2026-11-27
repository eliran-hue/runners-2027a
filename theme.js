/* מצב כהה/בהיר. נטען בראש העמוד (בלי defer) כדי שלא יהבהב צבע לא נכון.
   ברירת המחדל: מצב כהה (בלי קשר להגדרות המכשיר). אחרי לחיצה על הכפתור, הבחירה נשמרת בדפדפן. */
(function(){
  "use strict";
  var KEY = "site.theme", root = document.documentElement;
  function saved(){ try { var v = localStorage.getItem(KEY); return v === "dark" || v === "light" ? v : null; } catch(e) { return null; } }
  function current(){ return saved() || "dark"; }
  root.setAttribute("data-theme", current());

  var SUN = '<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="4.5"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>';
  var MOON = '<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"><path d="M20.5 14.5A8.5 8.5 0 0 1 9.5 3.5a8.5 8.5 0 1 0 11 11z"/></svg>';

  function mount(){
    var css = document.createElement("style");
    css.textContent = ".theme-btn{margin-inline-start:auto;width:34px;height:30px;display:inline-grid;place-items:center;border-radius:999px;border:1px solid var(--line);background:var(--paper);color:var(--ink);cursor:pointer;padding:0;flex:0 0 auto}"
      + ".theme-btn:hover{border-color:var(--accent);color:var(--accent)}"
      + ".theme-btn:focus-visible{outline:3px solid var(--accent);outline-offset:2px}"
      + ".theme-btn + .acct-btn{margin-inline-start:8px}";
    document.head.appendChild(css);
    var btn = document.createElement("button");
    btn.type = "button"; btn.className = "theme-btn";
    function paint(){
      var dark = current() === "dark";
      btn.innerHTML = dark ? SUN : MOON;
      btn.title = dark ? "מעבר למצב בהיר" : "מעבר למצב כהה";
      btn.setAttribute("aria-label", btn.title);
    }
    btn.onclick = function(){
      var next = current() === "dark" ? "light" : "dark";
      root.setAttribute("data-theme", next);
      try { localStorage.setItem(KEY, next); } catch(e) {}
      paint();
    };
    var host = document.getElementById("topActions") || document.getElementById("acct") || document.querySelector("nav.sb");
    if (host) host.insertBefore(btn, host.querySelector(".acct-btn"));
    paint();
  }
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", mount); else mount();
})();

/* Runs in <head> on every page, before the page reads its progress. */
/* Science anatomy was split into unit pages: move old local progress (sci.anat.*) to sci.anat1 / sci.anat3. */
(function migrateLocal(){
  try {
    var old = localStorage.getItem("sci.anat.done");
    if (old != null) {
      var o = JSON.parse(old) || {}, U = {"sci.anat1":["cell","tissues","bone"], "sci.anat3":["skeleton","spine","jointtypes","limbjoints","planes"]};
      Object.keys(U).forEach(function(k){
        var cur = JSON.parse(localStorage.getItem(k + ".done") || "{}") || {}, any = false;
        U[k].forEach(function(id){ if (o[id]) { cur[id] = true; any = true; } });
        if (any || localStorage.getItem(k + ".done") != null) localStorage.setItem(k + ".done", JSON.stringify(cur));
      });
      localStorage.removeItem("sci.anat.done");
    }
    localStorage.removeItem("sci.anat.cur");
  } catch (e) {}
})();

/* "חזרה למעלה" at the end of every page/chapter; shown only when the page is long enough to need it. */
(function backToTop(){
  function mount(){
    if (document.getElementById("toTop")) return;
    var st = document.createElement("style");
    st.textContent = ".totop-wrap{display:flex;justify-content:center;margin:12px auto 8px;padding:0 16px}"
      + ".totop-wrap[hidden]{display:none}"
      + ".totop{display:inline-flex;align-items:center;gap:8px;font:600 15px inherit;font-family:inherit;color:var(--accent,#1F5FD6);background:var(--paper,#fff);"
      + "border:1px solid var(--line,#D3DCE3);border-radius:999px;padding:10px 20px;cursor:pointer;min-height:44px}"
      + ".totop:hover{border-color:var(--accent,#1F5FD6)}"
      + ".totop:focus-visible{outline:3px solid var(--accent,#1F5FD6);outline-offset:2px}"
      + ".totop .ar{font-size:18px;line-height:1}"
      + "@media print{.totop-wrap{display:none}}";
    document.head.appendChild(st);
    var wrap = document.createElement("div");
    wrap.className = "totop-wrap"; wrap.hidden = true;
    wrap.innerHTML = '<button type="button" class="totop" id="toTop"><span class="ar" aria-hidden="true">↑</span>חזרה למעלה</button>';
    var foot = document.querySelector("body > footer, footer.wrap");
    if (foot && foot.parentNode) foot.parentNode.insertBefore(wrap, foot); else document.body.appendChild(wrap);
    wrap.querySelector("button").onclick = function(){
      var reduce = window.matchMedia && matchMedia("(prefers-reduced-motion: reduce)").matches;
      window.scrollTo({top: 0, behavior: reduce ? "auto" : "smooth"});
      var h = document.querySelector("h1");
      if (h) { if (!h.hasAttribute("tabindex")) h.setAttribute("tabindex", "-1"); h.focus({preventScroll: true}); }
    };
    function check(){ wrap.hidden = document.documentElement.scrollHeight < window.innerHeight * 1.6; }
    check();
    window.addEventListener("resize", check);
    if (window.ResizeObserver) new ResizeObserver(check).observe(document.body);
    else setInterval(check, 1000);
  }
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", mount); else mount();
})();
