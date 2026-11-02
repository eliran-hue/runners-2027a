/* שמירת התקדמות בשרת: כניסה עם קוד במייל, וסנכרון של מפתחות anat.* ו-phys.* מ-localStorage.
   אם ה-API לא זמין (למשל כשפותחים את הקובץ מהמחשב), הכפתור פשוט לא מופיע והאתר עובד כרגיל. */
(function(){
  "use strict";
  var API = "api/";
  var PREFIXES = ["anat.", "phys."];
  var state = {email:null, ready:false, saving:null};
  var ls; try { ls = window.localStorage; ls.getItem("x"); } catch(e) { return; }

  function isOurs(k){ return PREFIXES.some(function(p){ return k.indexOf(p) === 0; }); }
  function readLocal(){
    var o = {};
    for (var i = 0; i < ls.length; i++) { var k = ls.key(i); if (k && isOurs(k)) o[k] = ls.getItem(k); }
    return o;
  }
  function parse(s){ try { return JSON.parse(s); } catch(e) { return null; } }
  /* Completed chapters are kept from both sides; everything else prefers this device. */
  function merge(local, server){
    var out = {}, k;
    for (k in server) out[k] = server[k];
    for (k in local) out[k] = local[k];
    for (k in out) {
      if (/\.done$/.test(k) && local[k] != null && server[k] != null) {
        var a = parse(local[k]) || {}, b = parse(server[k]) || {}, m = {}, x;
        for (x in b) if (b[x]) m[x] = true;
        for (x in a) if (a[x]) m[x] = true;
        out[k] = JSON.stringify(m);
      }
    }
    return out;
  }
  function same(a, b){ return JSON.stringify(sortKeys(a)) === JSON.stringify(sortKeys(b)); }
  function sortKeys(o){ var r = {}; Object.keys(o).sort().forEach(function(k){ r[k] = o[k]; }); return r; }

  function api(path, body){
    var opt = {credentials:"same-origin", headers:{"Content-Type":"application/json"}};
    if (body !== undefined) { opt.method = "POST"; opt.body = JSON.stringify(body); }
    return fetch(API + path, opt).then(function(r){
      return r.json().catch(function(){ throw new Error("no_api"); });
    });
  }
  function save(){
    if (!state.email) return;
    clearTimeout(state.saving);
    state.saving = setTimeout(function(){
      api("progress_save.php", {v:1, keys:readLocal()}).then(function(r){
        if (!r.ok && r.error === "not_authenticated") { state.email = null; paint(); }
      }).catch(function(){});
    }, 800);
  }
  /* Apply server progress; reload once if this device's view changed. */
  function adopt(progress, thenReload){
    var server = (progress && progress.keys) || {};
    var local = readLocal(), merged = merge(local, server);
    var changed = !same(local, merged);
    Object.keys(merged).forEach(function(k){ if (local[k] !== merged[k]) origSet.call(ls, k, merged[k]); });
    if (!same(server, merged)) save();
    if (changed && thenReload) {
      var last = +(sessionStorage.getItem("sync.reload") || 0);
      if (Date.now() - last > 10000) { sessionStorage.setItem("sync.reload", String(Date.now())); location.reload(); }
    }
  }

  /* Save whenever the page writes progress. */
  var origSet = Storage.prototype.setItem;
  Storage.prototype.setItem = function(k, v){
    origSet.apply(this, arguments);
    if (this === ls && isOurs(String(k))) save();
  };

  /* ---------- UI ---------- */
  var css = ""
   + ".acct-btn{margin-inline-start:auto;font:600 14px 'Assistant',system-ui,sans-serif;color:var(--accent);background:var(--accent-soft);border:1px solid var(--accent);border-radius:999px;padding:4px 14px;cursor:pointer;display:inline-flex;align-items:center;gap:6px}"
   + ".acct-btn.in{color:var(--ok,#1F8A55);border-color:currentColor;background:transparent}"
   + ".acct-btn .dot{width:8px;height:8px;border-radius:50%;background:currentColor}"
   + ".acct-btn:focus-visible{outline:3px solid var(--accent);outline-offset:2px}"
   + "dialog.acct{border:1px solid var(--line);border-radius:14px;padding:0;max-width:min(420px,calc(100vw - 32px));width:100%;background:var(--paper);color:var(--ink);font-family:'Assistant',system-ui,sans-serif;direction:rtl}"
   + "dialog.acct::backdrop{background:rgba(10,20,30,.45)}"
   + "dialog.acct form{padding:22px}"
   + "dialog.acct h2{font-family:'Secular One','Assistant',sans-serif;font-weight:400;font-size:24px;margin:0 0 6px}"
   + "dialog.acct p{margin:0 0 12px;color:var(--muted);font-size:15.5px;line-height:1.55}"
   + "dialog.acct label{display:block;font-weight:600;font-size:15px;margin-bottom:4px}"
   + "dialog.acct input{width:100%;font:inherit;font-size:18px;padding:9px 12px;border:1px solid var(--line);border-radius:8px;background:var(--bg);color:var(--ink);box-sizing:border-box}"
   + "dialog.acct input.code{letter-spacing:.35em;text-align:center;font-variant-numeric:tabular-nums;direction:ltr}"
   + "dialog.acct input[type=email]{direction:ltr;text-align:right}"
   + "dialog.acct .row{display:flex;gap:8px;flex-wrap:wrap;margin-top:14px}"
   + "dialog.acct button{font:600 15px 'Assistant',system-ui,sans-serif;border-radius:8px;padding:9px 16px;cursor:pointer;border:1px solid var(--line);background:var(--paper);color:var(--ink)}"
   + "dialog.acct button.pri{background:var(--accent);border-color:var(--accent);color:var(--paper)}"
   + "dialog.acct button.link{border:0;background:none;color:var(--accent);padding:9px 4px}"
   + "dialog.acct button[disabled]{opacity:.6;cursor:default}"
   + "dialog.acct .err{color:var(--bad,#C23B45);font-size:15px;margin-top:10px;min-height:1.2em}"
   + "dialog.acct .who{direction:ltr;unicode-bidi:isolate;font-weight:700;color:var(--ink)}";
  var st = document.createElement("style"); st.textContent = css; document.head.appendChild(st);

  var MSG = {
    bad_email:"כתובת המייל לא נראית תקינה.",
    wait:"כבר נשלח קוד לפני רגע. אפשר לבקש קוד חדש בעוד דקה.",
    too_many:"היו יותר מדי ניסיונות. נסה שוב בעוד שעה.",
    mail_failed:"לא הצלחנו לשלוח את המייל. נסה שוב בעוד כמה דקות.",
    bad_code:"הקוד לא נכון. בדוק ונסה שוב.",
    expired:"הקוד פג תוקף. בקש קוד חדש.",
    net:"אין חיבור לשרת. בדוק את האינטרנט ונסה שוב."
  };
  function msg(e){ return MSG[e] || "משהו השתבש. נסה שוב."; }

  var btn = document.createElement("button");
  btn.type = "button"; btn.className = "acct-btn"; btn.hidden = true;
  btn.onclick = open;
  var dlg = document.createElement("dialog"); dlg.className = "acct";
  var pendingEmail = "";

  function paint(){
    btn.hidden = !state.ready;
    btn.className = "acct-btn" + (state.email ? " in" : "");
    btn.innerHTML = state.email ? '<span class="dot" aria-hidden="true"></span>ההתקדמות נשמרת' : "שמירת התקדמות";
    btn.setAttribute("aria-label", state.email ? "מחובר בתור " + state.email + ". פתח הגדרות חשבון" : "שמירת התקדמות עם כתובת מייל");
  }
  function view(html, focusSel){
    dlg.innerHTML = '<form method="dialog" novalidate>' + html + "</form>";
    var f = dlg.querySelector(focusSel || "input,button.pri"); if (f) setTimeout(function(){ f.focus(); }, 30);
    var c = dlg.querySelector("[data-close]"); if (c) c.onclick = function(){ dlg.close(); };
  }
  function busy(form, on){ Array.prototype.forEach.call(form.querySelectorAll("button,input"), function(x){ x.disabled = on; }); }

  function stepEmail(){
    view('<h2>שמירת התקדמות</h2><p>מזינים כתובת מייל ומקבלים קוד בן 6 ספרות. ככה ההתקדמות נשמרת, ואפשר להמשיך מכל מכשיר.</p>'
      + '<label for="acE">כתובת מייל</label><input id="acE" type="email" autocomplete="email" inputmode="email" required value="' + (pendingEmail || "") + '">'
      + '<div class="err" role="alert"></div><div class="row"><button class="pri" type="submit">שליחת קוד</button><button type="button" data-close>ביטול</button></div>');
    var form = dlg.querySelector("form");
    form.onsubmit = function(ev){
      ev.preventDefault();
      var em = form.querySelector("#acE").value.trim(), err = form.querySelector(".err");
      if (!/^\S+@\S+\.\S+$/.test(em)) { err.textContent = msg("bad_email"); return; }
      busy(form, true); err.textContent = "";
      api("request_code.php", {email:em}).then(function(r){
        busy(form, false);
        if (r.ok || r.error === "wait") { pendingEmail = em; stepCode(r.ok ? "" : msg("wait")); }
        else err.textContent = msg(r.error);
      }).catch(function(){ busy(form, false); err.textContent = msg("net"); });
    };
  }
  function stepCode(note){
    view('<h2>הקלד את הקוד</h2><p>שלחנו קוד בן 6 ספרות אל <span class="who">' + esc(pendingEmail) + '</span>. הוא בתוקף ל-10 דקות. אם לא הגיע, כדאי לבדוק גם בתיקיית הספאם.</p>'
      + '<label for="acC">קוד</label><input id="acC" class="code" inputmode="numeric" autocomplete="one-time-code" maxlength="6" pattern="[0-9]*">'
      + '<div class="err" role="alert">' + (note || "") + '</div><div class="row"><button class="pri" type="submit">כניסה</button><button type="button" class="link" data-back>החלפת מייל</button><button type="button" class="link" data-resend>שליחה חוזרת</button></div>');
    var form = dlg.querySelector("form"), err = form.querySelector(".err"), inp = form.querySelector("#acC");
    inp.oninput = function(){ inp.value = inp.value.replace(/\D/g, "").slice(0, 6); if (inp.value.length === 6) form.requestSubmit ? form.requestSubmit() : form.onsubmit(new Event("submit")); };
    form.querySelector("[data-back]").onclick = stepEmail;
    form.querySelector("[data-resend]").onclick = function(){
      api("request_code.php", {email:pendingEmail}).then(function(r){ err.textContent = r.ok ? "נשלח קוד חדש." : msg(r.error); }).catch(function(){ err.textContent = msg("net"); });
    };
    form.onsubmit = function(ev){
      if (ev && ev.preventDefault) ev.preventDefault();
      if (inp.value.length !== 6) { err.textContent = msg("bad_code"); return; }
      busy(form, true); err.textContent = "";
      api("verify_code.php", {email:pendingEmail, code:inp.value}).then(function(r){
        if (!r.ok) { busy(form, false); err.textContent = msg(r.error); inp.select(); return; }
        state.email = r.email; paint();
        sessionStorage.removeItem("sync.reload");
        var before = readLocal();
        adopt(r.progress, false);
        api("progress_save.php", {v:1, keys:readLocal()}).catch(function(){});
        var changed = !same(before, readLocal());
        view('<h2>מחובר</h2><p>מעכשיו כל פרק שתסיים יישמר אצלנו. בכל מכשיר אחר, נכנסים עם אותה כתובת מייל וממשיכים מאותה נקודה.</p>'
          + (changed ? '<p>טענו את ההתקדמות שכבר הייתה שמורה. העמוד ייטען מחדש.</p>' : "")
          + '<div class="row"><button class="pri" type="button" data-ok>מעולה</button></div>');
        dlg.querySelector("[data-ok]").onclick = function(){ dlg.close(); if (changed) location.reload(); };
      }).catch(function(){ busy(form, false); err.textContent = msg("net"); });
    };
  }
  function stepAccount(){
    view('<h2>ההתקדמות נשמרת</h2><p>מחובר בתור <span class="who">' + esc(state.email) + '</span>. כל פרק שתסיים נשמר אוטומטית, ואפשר להמשיך מכל מכשיר.</p>'
      + '<p>בהתנתקות, ההתקדמות נשארת גם בשרת וגם בדפדפן הזה.</p>'
      + '<div class="row"><button class="pri" type="button" data-close>סגירה</button><button type="button" data-out>התנתקות</button></div>');
    dlg.querySelector("[data-out]").onclick = function(){
      api("logout.php", {}).catch(function(){}).then(function(){ state.email = null; paint(); dlg.close(); });
    };
  }
  function open(){
    if (!dlg.isConnected) document.body.appendChild(dlg);
    state.email ? stepAccount() : stepEmail();
    if (dlg.showModal) dlg.showModal(); else dlg.setAttribute("open", "");
  }
  function esc(s){ return String(s).replace(/[&<>"']/g, function(c){ return {"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c]; }); }

  function mount(){
    var host = document.getElementById("acct") || document.querySelector("nav.sb");
    if (host) host.appendChild(btn);
    paint();
    api("me.php").then(function(r){
      if (!r || r.ok !== true) return;
      state.ready = true; state.email = r.email || null; paint();
      if (state.email) adopt(r.progress, true);
    }).catch(function(){ /* no API here: keep the button hidden */ });
  }
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", mount); else mount();
})();
