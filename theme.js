/* מצב כהה/בהיר. נטען בראש העמוד (בלי defer) כדי שלא יהבהב צבע לא נכון.
   ברירת המחדל: לפי הגדרות המכשיר. אחרי לחיצה, הבחירה נשמרת בדפדפן. */
(function(){
  "use strict";
  var KEY = "site.theme", root = document.documentElement, mq = window.matchMedia ? matchMedia("(prefers-color-scheme: dark)") : null;
  function saved(){ try { var v = localStorage.getItem(KEY); return v === "dark" || v === "light" ? v : null; } catch(e) { return null; } }
  function current(){ return saved() || (mq && mq.matches ? "dark" : "light"); }
  var s = saved(); if (s) root.setAttribute("data-theme", s);

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
    if (mq && mq.addEventListener) mq.addEventListener("change", function(){ if (!saved()) paint(); });
    var host = document.getElementById("acct") || document.querySelector("nav.sb");
    if (host) host.insertBefore(btn, host.querySelector(".acct-btn"));
    paint();
  }
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", mount); else mount();
})();
