/* שמירת התקדמות בשרת: כניסה עם קוד במייל, וסנכרון של מפתחות anat.*, phys.*, train.*, meth.* ו-sci.* מ-localStorage.
   אם ה-API לא זמין (למשל כשפותחים את הקובץ מהמחשב), הכפתור פשוט לא מופיע והאתר עובד כרגיל. */
(function(){
  "use strict";
  var API = "/api/";
  var PREFIXES = ["anat.", "phys.", "train.", "meth.", "sci."];
  var state = {email:null, name:null, branch:false, science:false, admin:false, pending:false, course:null, ready:false, saving:null};
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
    var opt = {credentials:"same-origin", cache:"no-store", headers:{"Content-Type":"application/json"}};
    if (body !== undefined) { opt.method = "POST"; opt.body = JSON.stringify(body); }
    return fetch(API + path, opt).then(function(r){
      return r.json().catch(function(){ throw new Error("no_api"); });
    });
  }
  /* Lets each page react to who is logged in (e.g. show the science course card). */
  function announce(r){
    state.branch = !!(r && r.branch); state.science = !!(r && r.science); state.admin = !!(r && r.admin);
    state.pending = !!(r && r.pending); state.course = (r && r.course) || null;
    state.name = (r && r.name) || null;
    window.runnersAuth = {known:true, offline:!!(r && r.offline), email:state.email, name:state.name, branch:state.branch, science:state.science,
      admin:state.admin, pending:state.pending, course:state.course};
    document.dispatchEvent(new CustomEvent("runners:auth", {detail:window.runnersAuth}));
    adminLink.hidden = !state.admin;
    paint();
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
  /* Who the progress in this browser belongs to. Kept outside PREFIXES, so it is never synced. */
  var OWNER = "sync.owner";
  function clearLocal(){ Object.keys(readLocal()).forEach(function(k){ ls.removeItem(k); }); }
  /* Before adopting an account's progress: if this browser holds another account's progress, drop it.
     Progress made here before any login (no owner yet) is merged into the first account that logs in. */
  function claim(email){
    var owner = ls.getItem(OWNER);
    if (owner && owner !== email) clearLocal();
    origSet.call(ls, OWNER, email);
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
   + ".admin-link{font:600 14px 'Assistant',system-ui,sans-serif;color:var(--accent);margin-inline-start:auto;margin-inline-end:4px;text-decoration:none}.admin-link[hidden]{display:none}.admin-link:hover{text-decoration:underline}"
   + ".admin-link:not([hidden]) ~ .theme-btn, .admin-link:not([hidden]) ~ .acct-btn{margin-inline-start:8px}"
   + ".acct-btn{margin-inline-start:auto;font:600 14px 'Assistant',system-ui,sans-serif;color:var(--accent);background:var(--accent-soft);border:1px solid var(--accent);border-radius:999px;padding:4px 14px;cursor:pointer;display:inline-flex;align-items:center;gap:6px}"
   + ".acct-btn.in{color:var(--ok,#1F8A55);border-color:currentColor;background:transparent}"
   + ".acct-btn .dot{width:8px;height:8px;border-radius:50%;background:currentColor}"
   + ".acct-btn:focus-visible{outline:3px solid var(--accent);outline-offset:2px}"
   + "dialog.acct{border:1px solid var(--line);border-radius:14px;padding:0;max-width:min(420px,calc(100vw - 32px));width:100%;background:var(--paper);color:var(--ink);font-family:'Assistant',system-ui,sans-serif;direction:rtl}"
   + "dialog.acct::backdrop{background:rgba(10,20,30,.45)}"
   + "dialog.acct form{padding:22px}"
   + "dialog.acct h2{font-family:'Assistant',sans-serif;font-weight:800;font-weight:400;font-size:24px;margin:0 0 6px}"
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
   + "dialog.acct .who{direction:ltr;unicode-bidi:isolate;font-weight:700;color:var(--ink)}"
   + "dialog.acct label + input, dialog.acct input + label, dialog.acct fieldset{margin-top:0}"
   + "dialog.acct .fld{margin-bottom:12px}"
   + "dialog.acct fieldset{border:0;padding:0;margin:0 0 4px}"
   + "dialog.acct legend{font-weight:600;font-size:15px;margin-bottom:6px;padding:0}"
   + "dialog.acct .opts{display:grid;gap:6px}"
   + "dialog.acct .opt{display:flex;align-items:center;gap:10px;font-weight:600;font-size:16px;border:1px solid var(--line);border-radius:10px;padding:9px 12px;cursor:pointer;margin:0}"
   + "dialog.acct .opt input{width:18px;height:18px;margin:0;accent-color:var(--accent);flex:none}"
   + "dialog.acct .opt:has(input:checked){border-color:var(--accent);background:var(--accent-soft)}"
   + "dialog.acct .opt small{font-weight:400;color:var(--muted);font-size:14px}"
   + "dialog.acct .alt{margin:14px 0 0;font-size:15px;color:var(--muted)}"
   + "dialog.acct .alt button{padding:0 2px;font-size:15px}"
   + "dialog.acct .ok-ic{font-size:34px;line-height:1;margin-bottom:6px}"
   + "dialog.acct .acc{display:flex;flex-wrap:wrap;gap:6px;margin:0 0 12px}"
   + "dialog.acct .acc span{font-size:13.5px;font-weight:700;border-radius:999px;padding:2px 10px;border:1px solid var(--line);color:var(--muted)}"
   + "dialog.acct .acc span.on{border-color:var(--ok,#1F8A55);color:var(--ok,#1F8A55)}";
  var st = document.createElement("style"); st.textContent = css; document.head.appendChild(st);

  var MSG = {
    bad_email:"כתובת המייל לא נראית תקינה.",
    wait:"כבר נשלח קוד לפני רגע. אפשר לבקש קוד חדש בעוד דקה.",
    too_many:"היו יותר מדי ניסיונות. נסה שוב בעוד שעה.",
    mail_failed:"לא הצלחנו לשלוח את המייל. נסה שוב בעוד כמה דקות.",
    bad_code:"הקוד לא נכון. בדוק ונסה שוב.",
    expired:"הקוד פג תוקף. בקש קוד חדש.",
    not_registered:"המייל הזה עוד לא רשום באתר. אפשר להירשם עכשיו.",
    bad_name:"צריך למלא שם מלא.",
    bad_course:"צריך לבחור איזה קורס לומדים.",
    net:"אין חיבור לשרת. בדוק את האינטרנט ונסה שוב."
  };
  function msg(e){ return MSG[e] || "משהו השתבש. נסה שוב."; }

  var btn = document.createElement("button");
  btn.type = "button"; btn.className = "acct-btn"; btn.hidden = true;
  btn.onclick = function(){ open(); };
  var dlg = document.createElement("dialog"); dlg.className = "acct";
  var adminLink = document.createElement("a");
  adminLink.href = "/admin/"; adminLink.className = "admin-link"; adminLink.textContent = "ניהול"; adminLink.hidden = true;
  var pendingEmail = "";

  function paint(){
    btn.hidden = !state.ready;
    btn.className = "acct-btn" + (state.email ? " in" : "");
    btn.innerHTML = state.email ? '<span class="dot" aria-hidden="true"></span>' + (state.pending ? "ממתין לאישור" : "החשבון שלי") : "כניסה / הרשמה";
    btn.setAttribute("aria-label", state.email ? "מחובר בתור " + state.email + ". פתח הגדרות חשבון" : "כניסה או הרשמה לאתר עם כתובת מייל");
  }
  function view(html, focusSel){
    dlg.innerHTML = '<form method="dialog" novalidate>' + html + "</form>";
    var f = dlg.querySelector(focusSel || "input,button.pri"); if (f) setTimeout(function(){ f.focus(); }, 30);
    var c = dlg.querySelector("[data-close]"); if (c) c.onclick = function(){ dlg.close(); };
  }
  function busy(form, on){ Array.prototype.forEach.call(form.querySelectorAll("button,input"), function(x){ x.disabled = on; }); }

  /* The last code request, so "send again" repeats it exactly (login or registration). */
  var lastReq = null;
  function sendCode(req, form, err){
    busy(form, true); err.textContent = "";
    api("request_code.php", req).then(function(r){
      busy(form, false);
      if (r.ok || r.error === "wait") { lastReq = req; pendingEmail = req.email; stepCode(r.ok ? "" : msg("wait")); }
      else if (r.error === "not_registered") { err.innerHTML = esc(msg(r.error)) + ' <button type="button" class="link" data-goreg>להרשמה ←</button>'; err.querySelector("[data-goreg]").onclick = function(){ stepRegister(req.email); }; }
      else err.textContent = msg(r.error);
    }).catch(function(){ busy(form, false); err.textContent = msg("net"); });
  }
  function stepEmail(){
    view('<h2>כניסה לאתר</h2><p>האתר פתוח רק למשתתפי הקורס. מזינים את כתובת המייל שנרשמת איתה, ומקבלים קוד כניסה בן 6 ספרות.</p>'
      + '<label for="acE">כתובת מייל</label><input id="acE" type="email" autocomplete="email" inputmode="email" required value="' + esc(pendingEmail || "") + '">'
      + '<div class="err" role="alert"></div><div class="row"><button class="pri" type="submit">שליחת קוד</button><button type="button" data-close>ביטול</button></div>'
      + '<p class="alt">עוד לא נרשמת? <button type="button" class="link" data-reg>להרשמה ←</button></p>');
    var form = dlg.querySelector("form");
    form.querySelector("[data-reg]").onclick = function(){ stepRegister(form.querySelector("#acE").value.trim()); };
    form.onsubmit = function(ev){
      ev.preventDefault();
      var em = form.querySelector("#acE").value.trim(), err = form.querySelector(".err");
      if (!/^\S+@\S+\.\S+$/.test(em)) { err.textContent = msg("bad_email"); return; }
      sendCode({mode:"login", email:em}, form, err);
    };
  }
  /* Registration: full name, email (verified with a code) and the course. The admin then approves the access. */
  var COURSE_OPTS = [["branch", "קורס ענפי"], ["science", "קורס מדעי"], ["both", "גם וגם", "ענפי ומדעי"]];
  function stepRegister(email){
    var reg = state.reg || {};
    view('<h2>הרשמה לאתר</h2><p>ממלאים את הפרטים ומאמתים את המייל בקוד. אחרי זה מנהל האתר מאשר את הגישה, ומקבלים על כך מייל.</p>'
      + '<div class="fld"><label for="acN">שם מלא</label><input id="acN" type="text" autocomplete="name" maxlength="40" required value="' + esc(reg.name || "") + '"></div>'
      + '<div class="fld"><label for="acE">כתובת מייל</label><input id="acE" type="email" autocomplete="email" inputmode="email" required value="' + esc(email || pendingEmail || "") + '"></div>'
      + '<fieldset><legend>איזה קורס לומדים?</legend><div class="opts">' + COURSE_OPTS.map(function(o){
          return '<label class="opt"><input type="radio" name="course" value="' + o[0] + '"' + (reg.course === o[0] ? " checked" : "") + '>' + o[1] + (o[2] ? ' <small>(' + o[2] + ')</small>' : "") + '</label>';
        }).join("") + '</div></fieldset>'
      + '<div class="err" role="alert"></div><div class="row"><button class="pri" type="submit">שליחת קוד אימות</button><button type="button" data-close>ביטול</button></div>'
      + '<p class="alt">כבר נרשמת? <button type="button" class="link" data-login>לכניסה ←</button></p>');
    var form = dlg.querySelector("form");
    form.querySelector("[data-login]").onclick = function(){ pendingEmail = form.querySelector("#acE").value.trim(); stepEmail(); };
    form.onsubmit = function(ev){
      ev.preventDefault();
      var err = form.querySelector(".err"), c = form.querySelector("input[name=course]:checked");
      var req = {mode:"register", name:form.querySelector("#acN").value.trim(), email:form.querySelector("#acE").value.trim(), course:c ? c.value : ""};
      state.reg = {name:req.name, course:req.course};
      if (req.name.length < 2) { err.textContent = msg("bad_name"); form.querySelector("#acN").focus(); return; }
      if (!/^\S+@\S+\.\S+$/.test(req.email)) { err.textContent = msg("bad_email"); form.querySelector("#acE").focus(); return; }
      if (!req.course) { err.textContent = msg("bad_course"); return; }
      sendCode(req, form, err);
    };
  }
  function stepCode(note){
    view('<h2>הקלד את הקוד</h2><p>שלחנו קוד בן 6 ספרות אל <span class="who">' + esc(pendingEmail) + '</span>. הוא בתוקף ל-10 דקות. אם לא הגיע, כדאי לבדוק גם בתיקיית הספאם.</p>'
      + '<label for="acC">קוד</label><input id="acC" class="code" inputmode="numeric" autocomplete="one-time-code" maxlength="6" pattern="[0-9]*">'
      + '<div class="err" role="alert">' + (note || "") + '</div><div class="row"><button class="pri" type="submit">כניסה</button><button type="button" class="link" data-back>החלפת מייל</button><button type="button" class="link" data-resend>שליחה חוזרת</button></div>');
    var form = dlg.querySelector("form"), err = form.querySelector(".err"), inp = form.querySelector("#acC");
    inp.oninput = function(){ inp.value = inp.value.replace(/\D/g, "").slice(0, 6); if (inp.value.length === 6) form.requestSubmit ? form.requestSubmit() : form.onsubmit(new Event("submit")); };
    form.querySelector("[data-back]").onclick = function(){ lastReq && lastReq.mode === "register" ? stepRegister(pendingEmail) : stepEmail(); };
    form.querySelector("[data-resend]").onclick = function(){
      api("request_code.php", lastReq || {mode:"login", email:pendingEmail}).then(function(r){ err.textContent = r.ok ? "נשלח קוד חדש." : msg(r.error); }).catch(function(){ err.textContent = msg("net"); });
    };
    form.onsubmit = function(ev){
      if (ev && ev.preventDefault) ev.preventDefault();
      if (inp.value.length !== 6) { err.textContent = msg("bad_code"); return; }
      busy(form, true); err.textContent = "";
      api("verify_code.php", {email:pendingEmail, code:inp.value}).then(function(r){
        if (!r.ok) { busy(form, false); err.textContent = msg(r.error); inp.select(); return; }
        state.email = r.email; paint(); announce(r);
        sessionStorage.removeItem("sync.reload");
        var before = readLocal();
        claim(r.email);
        adopt(r.progress, false);
        api("progress_save.php", {v:1, keys:readLocal()}).catch(function(){});
        var changed = !same(before, readLocal());
        state.reg = null;
        if (r.pending) { stepPending(); return; }
        var nx = nextUrl();
        if (nx && ((/^\/branch\//.test(nx) && r.branch) || (/^\/science\//.test(nx) && r.science) || r.admin)) { location.href = nx; return; }
        if (r.first) stepName(true, function(){ loggedIn(changed); }); else loggedIn(changed);
      }).catch(function(){ busy(form, false); err.textContent = msg("net"); });
    };
  }
  /* The page's address for the view counter, in the old file form (/branch/training.html), so the admin stats keep their names. */
  function pagePath(){
    var p = new URLSearchParams(location.search).get("p");
    if (p === null) return location.pathname;
    p = p.replace(/^\/+/, "");
    if (p && !/\/$/.test(p) && !/\.[a-z0-9]+$/i.test(p)) p += ".html";
    return location.pathname + p;
  }
  /* Where to go after logging in: a course page the visitor asked for before logging in (set by the content gate). */
  function nextUrl(){
    var n = new URLSearchParams(location.search).get("next") || "";
    return /^\/(branch|science)\/(\?p=[\w\-\/.]*)?$/.test(n) && n.indexOf("..") < 0 ? n : "";
  }
  function loggedIn(changed){
        view('<h2>' + (state.name ? "שלום, " + esc(state.name) + "!" : "מחובר") + '</h2><p>מעכשיו כל פרק שתסיים יישמר אצלנו. בכל מכשיר אחר, נכנסים עם אותה כתובת מייל וממשיכים מאותה נקודה.</p>'
          + (changed ? '<p>טענו את ההתקדמות שכבר הייתה שמורה. העמוד ייטען מחדש.</p>' : "")
          + '<div class="row"><button class="pri" type="button" data-ok>מעולה</button></div>');
        dlg.querySelector("[data-ok]").onclick = function(){ dlg.close(); if (changed) location.reload(); };
  }
  /* Registered and verified, but the admin hasn't opened anything yet. */
  function stepPending(){
    view('<div class="ok-ic" aria-hidden="true">✅</div><h2>הבקשה נשלחה</h2><p>המייל אומת, והבקשה שלך הועברה למנהל האתר. ברגע שהגישה תאושר, יישלח אליך מייל, ואפשר יהיה להיכנס עם אותה כתובת.</p>'
      + '<div class="row"><button class="pri" type="button" data-ok>הבנתי</button></div>');
    dlg.querySelector("[data-ok]").onclick = function(){ dlg.close(); if (location.pathname !== "/") location.href = "/"; };
  }
  /* Optional display name: offered once after the first login, and editable from the account dialog. */
  function stepName(first, next){
    view('<h2>' + (first ? "נעים להכיר!" : "השם שלך") + '</h2><p>' + (first ? "איך קוראים לך? השם יופיע בדף הבית כשתתחבר." : "השם מופיע בדף הבית.") + '</p>'
      + '<label for="acN">שם מלא</label><input id="acN" type="text" autocomplete="name" maxlength="40" value="' + esc(state.name || "") + '">'
      + '<div class="err" role="alert"></div><div class="row"><button class="pri" type="submit">שמירה</button><button type="button" data-skip>' + (first ? "דילוג" : "ביטול") + '</button></div>');
    var form = dlg.querySelector("form"), err = form.querySelector(".err");
    form.querySelector("[data-skip]").onclick = next;
    form.onsubmit = function(ev){
      ev.preventDefault();
      busy(form, true); err.textContent = "";
      api("set_name.php", {name: form.querySelector("#acN").value}).then(function(r){
        busy(form, false);
        if (!r.ok) { err.textContent = msg(r.error); return; }
        announce({name:r.name, branch:state.branch, science:state.science, admin:state.admin, pending:state.pending, course:state.course});
        next();
      }).catch(function(){ busy(form, false); err.textContent = msg("net"); });
    };
  }
  function stepAccount(){
    var who = state.name ? '<b>' + esc(state.name) + '</b> (<span class="who">' + esc(state.email) + '</span>)' : '<span class="who">' + esc(state.email) + '</span>';
    var acc = state.admin ? '<span class="on">מנהל האתר</span>'
      : '<span class="' + (state.branch ? "on" : "") + '">קורס ענפי: ' + (state.branch ? "פתוח" : "סגור") + '</span><span class="' + (state.science ? "on" : "") + '">קורס מדעי: ' + (state.science ? "פתוח" : "סגור") + '</span>';
    view('<h2>החשבון שלי</h2><p>מחובר בתור ' + who + '.</p><div class="acc">' + acc + '</div>'
      + (state.pending ? '<p>הבקשה שלך ממתינה לאישור של מנהל האתר. כשהגישה תאושר, יישלח אליך מייל.</p>'
                       : '<p>כל פרק שתסיים נשמר אוטומטית, ואפשר להמשיך מכל מכשיר. בהתנתקות ההתקדמות נמחקת מהדפדפן הזה (היא נשארת שמורה בשרת).</p>')
      + '<div class="row"><button class="pri" type="button" data-close>סגירה</button><button type="button" data-name>' + (state.name ? "שינוי שם" : "הוספת שם") + '</button><button type="button" data-out>התנתקות</button></div>');
    dlg.querySelector("[data-name]").onclick = function(){ stepName(false, stepAccount); };
    dlg.querySelector("[data-out]").onclick = logout;
  }
  function logout(){
    api("logout.php", {}).catch(function(){}).then(function(){ clearLocal(); ls.removeItem(OWNER); location.href = "/"; });
  }
  /* mode: "login" / "register" (from the landing screen), or nothing for the header button. */
  function open(mode){
    if (!dlg.isConnected) document.body.appendChild(dlg);
    if (state.email) stepAccount(); else if (mode === "register") stepRegister(); else stepEmail();
    if (dlg.showModal) { if (!dlg.open) dlg.showModal(); } else dlg.setAttribute("open", "");
  }
  window.runnersAccount = {open:open, logout:logout};
  function esc(s){ return String(s).replace(/[&<>"']/g, function(c){ return {"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c]; }); }

  /* Page-view counter: a random id for this browser (not tied to the email), plus the page path. */
  function hit(){
    try {
      var vid = ls.getItem("rv.vid");
      if (!/^[a-f0-9]{32}$/.test(vid || "")) {
        var a = new Uint8Array(16); crypto.getRandomValues(a);
        vid = Array.prototype.map.call(a, function(b){ return ("0" + b.toString(16)).slice(-2); }).join("");
        origSet.call(ls, "rv.vid", vid);
      }
      api("hit.php", {path: pagePath(), v: vid}).catch(function(){});
    } catch (e) {}
  }
  function mount(){
    hit();
    var host = document.getElementById("topActions") || document.getElementById("acct") || document.querySelector("nav.sb");
    if (host) { host.appendChild(adminLink); host.appendChild(btn); }
    paint();
    api("me.php").then(function(r){
      if (!r || r.ok !== true) return;
      state.ready = true; state.email = r.email || null; paint(); announce(r);
      if (state.email) { var before = readLocal(); claim(state.email); adopt(r.progress, true); if (!same(before, readLocal()) && !sessionStorage.getItem("sync.reload")) location.reload(); }
      else if (ls.getItem(OWNER)) { clearLocal(); ls.removeItem(OWNER); location.reload(); }
    }).catch(function(){ /* no API here (e.g. a file opened from the computer): keep the button hidden */ announce({offline:true}); });
  }
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", mount); else mount();
})();
