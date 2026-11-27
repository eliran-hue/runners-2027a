<?php http_response_code(404); exit; /* מוגש רק דרך api/branch_gate.php */ ?>
<!doctype html>
<html lang="he" dir="rtl"><head><meta charset="utf-8"><link rel="icon" href="/favicon.svg?v=2" type="image/svg+xml"><meta name="robots" content="noindex, nofollow, noarchive, nosnippet, noimageindex"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>קורס ענפי · קורס מדריכי ריצות ארוכות</title>
<meta name="claude:viewport-fit-sides" content="cover">
<link rel="stylesheet" href="/site.css?v=20261123f">
<script src="/theme.js?v=20261127c"></script><script src="/nav.js?v=20261127d" defer></script><script src="/sync.js?v=20261127d" defer></script><style>
.sched{margin-top:28px;background:var(--paper);border:1px solid var(--line);border-radius:14px;padding:18px 20px}
.sched h2{margin:0 0 4px;font:400 24px var(--display)}
.sched-lead{margin:0 0 12px;color:var(--muted)}
.tl{list-style:none;margin:0;padding:0;display:grid;gap:8px}
.tl li{display:grid;grid-template-columns:auto auto 1fr auto;align-items:center;gap:12px;padding:10px 12px;border:1px solid var(--line);border-radius:10px;background:var(--bg)}
.tl-date{display:flex;flex-direction:column;font-weight:700;font-variant-numeric:tabular-nums;min-width:92px}
.tl-date small{font-weight:400;color:var(--muted);font-size:13px}
.tl-kind{font-size:12.5px;font-weight:700;border-radius:999px;padding:2px 10px;background:var(--accent-soft);color:var(--accent);border:1px solid currentColor}
.tl li[data-k=exam] .tl-kind{color:#B4232F;background:color-mix(in srgb,#B4232F 10%,transparent)}
:root[data-theme=dark] .tl li[data-k=exam] .tl-kind{color:#FF8A94}
@media (prefers-color-scheme:dark){:root:not([data-theme=light]) .tl li[data-k=exam] .tl-kind{color:#FF8A94}}
.tl li[data-k=lab] .tl-kind{color:#1F7A4D;background:color-mix(in srgb,#1F7A4D 10%,transparent)}
.tl-rel{font-size:13.5px;color:var(--muted);white-space:nowrap}
.tl li.next{border:2px solid var(--accent);background:var(--accent-soft)}
.tl li.next .tl-rel{color:var(--accent);font-weight:700}
.tl li.past{opacity:.55}
@media (max-width:520px){.tl li{grid-template-columns:auto 1fr;row-gap:4px}.tl li b{grid-column:2}.tl-kind{justify-self:start}.tl-rel{grid-column:2}.tl-date{grid-row:span 3}}
.topic.wide .prog{flex-basis:100%;margin-top:4px}
.topic.wide .subs{display:flex;flex-wrap:wrap;gap:6px;margin-top:8px;padding:0;list-style:none}
.topic.wide .subs li{font-size:13.5px;font-weight:600;border:1px solid var(--line);border-radius:999px;padding:2px 10px;background:var(--bg);margin:0}
.topic.wide .subs li::before{display:none}
</style><link rel="preload" href="/fonts/Assistant-Variable.woff" as="font" type="font/woff" crossorigin><link rel="stylesheet" href="/design.css?v=5"></head><body>
<header class="wrap">
  <nav class="sb" id="acct" aria-label="ניווט באתר"><a class="home" href="/">קורס מדריכי ריצות ארוכות</a><span class="sep" aria-hidden="true">‹</span><span aria-current="page">קורס ענפי</span></nav>
  <h1>קורס ענפי</h1>
</header>
<main class="wrap">
  <div class="grid">
    <a class="topic wide" href="/branch/tools/" style="--c:var(--d3)">
      <div><h2>מחשבונים וכלי עזר</h2><p>כלים לשימוש מהיר, בלי לחפש בתוך הפרקים: דופק מטרה, אזורי אימון ואחוז קצב.</p></div>
      <span class="go">לכלים ←</span>
    </a>

    <a class="topic wide" href="/branch/body/" style="--c:var(--d1)">
      <div><h2>אנטומיה ופיזיולוגיה</h2><p>איך הגוף בנוי ואיך הוא עובד בזמן ריצה.</p><ul class="subs"><li>האנטומיה של הריצה</li><li>הפיזיולוגיה של הריצה</li></ul></div>
      <div class="prog" data-keys="anat:5,phys:7"><div class="bar"><i></i></div><div class="t"><span class="st">12 פרקים</span><span class="go">לנושא ←</span></div></div>
    </a>

    <a class="topic wide" href="/branch/theory/" style="--c:var(--d4)">
      <div><h2>תורת האימון</h2><p>איך בונים כושר, מתכננים אימונים ומדריכים קבוצה.</p><ul class="subs"><li>עקרונות תורת האימון</li><li>תכנון אימונים</li><li>מתודיקה באימון</li></ul></div>
      <div class="prog" data-keys="train:13,plan:5,meth:5"><div class="bar"><i></i></div><div class="t"><span class="st">23 פרקים</span><span class="go">לנושא ←</span></div></div>
    </a>
  </div>

  <section class="sched" aria-labelledby="schedH">
    <h2 id="schedH">לוח זמנים</h2>
    <p class="sched-lead">הסדנאות, המעבדה והמבחנים של הקורס הענפי.</p>
    <ol class="tl" id="schedList">
      <li data-d="2027-01-01" data-k="work"><b>סדנת מתודיקה: סבב ראשון</b></li>
      <li data-d="2027-01-01" data-k="lab"><b>מעבדה בפיזיולוגיה</b></li>
      <li data-d="2027-01-08" data-k="work"><b>סדנת מתודיקה: סבב שני</b></li>
      <li data-d="2027-01-15" data-k="exam"><b>מבחן מעשי: סבב ראשון</b></li>
      <li data-d="2027-01-22" data-k="exam"><b>מבחן מעשי: סבב שני</b></li>
      <li data-d="2027-01-29" data-k="exam"><b>בחינה עיונית מסכמת</b></li>
    </ol>
  </section>
  <div class="tip"><b>איך מסמנים פרק כ"הושלם"?</b> עונים על הבוחן בסוף הפרק, ומקבלים לפחות 70%. הנקודה ליד שם הפרק נצבעת בירוק, והפס מתקדם.<br><b>רוצה להמשיך ממכשיר אחר?</b> נכנסים שם עם אותה כתובת מייל, וההתקדמות מחכה שם.</div>
</main>
<footer class="wrap"><span class="credit">המצגות מבוססות על תוכן של המכללה האקדמית לוינסקי-וינגייט.</span></footer>
<script>
/* פסי התקדמות: סופרים פרקים שהושלמו בכל המפתחות שבכרטיס (data-keys="anat:5,phys:7"). */
document.querySelectorAll(".prog").forEach(p=>{
  let n=0,t=0;
  p.dataset.keys.split(",").forEach(kv=>{const [k,c]=kv.split(":");t+=+c;
    try{const d=JSON.parse(localStorage.getItem(k+".done")||"{}")||{};n+=Math.min(+c,Object.values(d).filter(Boolean).length)}catch(e){}});
  p.querySelector(".bar i").style.width=(t?Math.min(100,n/t*100):0)+"%";
  if(n>0){p.querySelector(".st").textContent=n>=t?`הושלמו כל ${t} הפרקים`:`הושלמו ${n} מתוך ${t} פרקים`;const g=p.querySelector(".go");if(g)g.textContent=n>=t?"לחזרה ←":"להמשיך ←"}
});


/* לוח זמנים: תאריך ויום בשבוע, סימון של מה שעבר ושל האירוע הקרוב. */
(function(){
  const today=new Date();today.setHours(0,0,0,0);let next=null;
  document.querySelectorAll("#schedList li").forEach(li=>{
    const [y,m,d]=li.dataset.d.split("-").map(Number),dt=new Date(y,m-1,d);
    const days=Math.round((dt-today)/864e5);
    const date=`${String(d).padStart(2,"0")}/${String(m).padStart(2,"0")}/${y}`;
    const wd=dt.toLocaleDateString("he-IL",{weekday:"long"});
    const kind={exam:"מבחן",meet:"מפגש",work:"סדנה",lab:"מעבדה"}[li.dataset.k]||"";
    li.insertAdjacentHTML("afterbegin",`<span class="tl-date"><bdi>${date}</bdi><small>${wd}</small></span><span class="tl-kind">${kind}</span>`);
    if(days<0){li.classList.add("past");li.insertAdjacentHTML("beforeend",`<span class="tl-rel">עבר</span>`)}
    else{
      if(!next)next=li.dataset.d;if(li.dataset.d===next)li.classList.add("next");
      li.insertAdjacentHTML("beforeend",`<span class="tl-rel">${days===0?"היום":days===1?"מחר":`בעוד ${days} ימים`}</span>`);
    }
  });
})();
</script>
</body></html>
