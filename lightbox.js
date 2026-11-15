/* הגדלת תמונות: לחיצה על תמונה בתוך איור פותחת אותה על כל המסך.
   סגירה: כפתור X, לחיצה על הרקע או מקש Escape. התמונות בכרטיסיות השינון לא נפתחות, כי לחיצה עליהן הופכת את הכרטיס. */
(function(){
  "use strict";
  var SEL = ".fig .plate img, figure.block img";
  var css = ""
    + SEL.split(",").map(function(s){ return s.trim(); }).join(",") + "{cursor:zoom-in}"
    + "dialog.lb{border:0;padding:0;margin:0;width:100vw;height:100vh;max-width:100vw;max-height:100vh;background:transparent;color:#fff;overflow:hidden}"
    + "dialog.lb::backdrop{background:rgba(8,14,20,.88)}"
    + "dialog.lb .lb-wrap{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;"
    +   "padding:calc(56px + env(safe-area-inset-top,0px)) max(16px,env(safe-area-inset-right,0px)) calc(20px + env(safe-area-inset-bottom,0px)) max(16px,env(safe-area-inset-left,0px));box-sizing:border-box}"
    /* התמונה ממלאת את כל השטח הפנוי (גם אם היא קטנה מהמסך), ושומרת על היחס שלה */
    + "dialog.lb img{flex:1 1 auto;min-height:0;width:100%;object-fit:contain;cursor:zoom-out;filter:drop-shadow(0 10px 30px rgba(0,0,0,.5))}"
    + "dialog.lb .lb-cap{max-width:70ch;text-align:center;font:500 15.5px/1.5 'Assistant',system-ui,sans-serif;color:#e6edf2;direction:rtl}"
    + "dialog.lb .lb-x{position:absolute;top:calc(12px + env(safe-area-inset-top,0px));left:max(12px,env(safe-area-inset-left,0px));width:44px;height:44px;border-radius:50%;"
    +   "border:1px solid rgba(255,255,255,.35);background:rgba(255,255,255,.12);color:#fff;font-size:26px;line-height:1;cursor:pointer;display:grid;place-items:center}"
    + "dialog.lb .lb-x:hover{background:rgba(255,255,255,.22)}"
    + "dialog.lb .lb-x:focus-visible{outline:3px solid #7FA8FF;outline-offset:2px}";
  var st = document.createElement("style"); st.textContent = css; document.head.appendChild(st);

  var dlg = null, img, cap, lastFocus = null;
  function build(){
    dlg = document.createElement("dialog");
    dlg.className = "lb";
    dlg.setAttribute("aria-label", "תמונה מוגדלת");
    dlg.innerHTML = '<div class="lb-wrap"><img alt=""><div class="lb-cap"></div></div><button type="button" class="lb-x" aria-label="סגירה">×</button>';
    img = dlg.querySelector("img"); cap = dlg.querySelector(".lb-cap");
    dlg.querySelector(".lb-x").onclick = close;
    /* לחיצה על הרקע או על התמונה סוגרת; לחיצה על הכיתוב לא */
    dlg.addEventListener("click", function(e){ if (!e.target.closest(".lb-cap") && !e.target.closest(".lb-x")) close(); });
    dlg.addEventListener("close", function(){ document.documentElement.style.overflow = ""; if (lastFocus) lastFocus.focus(); });
    document.body.appendChild(dlg);
  }
  function open(src, alt, caption){
    if (!dlg) build();
    lastFocus = document.activeElement;
    img.src = src; img.alt = alt || "";
    cap.textContent = caption || ""; cap.hidden = !caption;
    document.documentElement.style.overflow = "hidden";
    if (dlg.showModal) dlg.showModal(); else dlg.setAttribute("open", "");
    dlg.querySelector(".lb-x").focus();
  }
  function close(){ if (dlg && dlg.open) dlg.close(); }

  function target(e){
    var t = e.target;
    if (!(t instanceof Element) || t.tagName !== "IMG" || !t.matches(SEL) || t.closest(".card")) return null;
    return t;
  }
  document.addEventListener("click", function(e){
    var t = target(e); if (!t) return;
    e.preventDefault();
    var fig = t.closest("figure"), fc = fig && fig.querySelector("figcaption");
    open(t.currentSrc || t.src, t.alt, fc ? fc.textContent : t.alt);
  });
  /* נגישות במקלדת: התמונות נהיות פוקוסביליות ונפתחות ב-Enter או ברווח */
  function mark(root){
    (root || document).querySelectorAll(SEL).forEach(function(i){
      if (i.closest(".card") || i.hasAttribute("tabindex")) return;
      i.tabIndex = 0; i.setAttribute("role", "button");
      i.setAttribute("aria-label", "הגדלת התמונה: " + (i.alt || ""));
    });
  }
  document.addEventListener("keydown", function(e){
    if ((e.key === "Enter" || e.key === " ") && document.activeElement && document.activeElement.matches && document.activeElement.matches(SEL)) {
      e.preventDefault(); document.activeElement.click();
    }
  });
  /* הפרקים נבנים מחדש בכל מעבר, אז מסמנים תמונות חדשות כשהן מופיעות */
  function watch(){
    mark();
    var m = document.getElementById("main");
    if (m && window.MutationObserver) new MutationObserver(function(){ mark(m); }).observe(m, {childList:true, subtree:true});
  }
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", watch); else watch();
})();
