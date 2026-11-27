<?php http_response_code(404); exit; /* מוגש רק דרך api/science_gate.php */ ?>
<!doctype html>
<html lang="he" dir="rtl"><head><meta charset="utf-8"><link rel="icon" href="/favicon.svg?v=2" type="image/svg+xml"><meta name="robots" content="noindex, nofollow, noarchive, nosnippet, noimageindex"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>סימולטור שלד · אנטומיה · קורס מדעי · קורס מדריכי ריצות ארוכות</title>
<meta name="claude:viewport-fit-sides" content="cover">
<link rel="stylesheet" href="/site.css?v=20261123f">
<script src="/theme.js?v=20261127c"></script><script src="/nav.js?v=20261127h" defer></script><script src="/skeleton.js?v=17" defer></script><script src="/sync.js?v=20261127d" defer></script><style>.topic .ldate{color:var(--muted);font-weight:600;letter-spacing:0}</style><style>.exam-note{display:inline-block;margin:10px 0 0;padding:8px 14px;border-radius:10px;background:var(--accent-soft);border:1px solid var(--line)}.exam-note a{color:var(--accent);font-weight:600}</style><link rel="preload" href="/fonts/Assistant-Variable.woff" as="font" type="font/woff" crossorigin><link rel="stylesheet" href="/design.css?v=5"><style>.sim-card{background:var(--paper);border:1px solid var(--line);border-radius:18px;padding:14px;box-shadow:var(--shadow-1)}.sim-card .sk-front{max-width:380px}.sim-more{color:var(--muted)}.sim-more a{color:var(--accent);font-weight:700}</style></head><body>
<header class="wrap">
  <nav class="sb" id="acct" aria-label="ניווט באתר"><a class="home" href="/">קורס מדריכי ריצות ארוכות</a><span class="sep" aria-hidden="true">‹</span><a href="/science/">קורס מדעי</a><span class="sep" aria-hidden="true">‹</span><a href="/science/anatomy/">אנטומיה</a><span class="sep" aria-hidden="true">‹</span><span aria-current="page">סימולטור שלד</span></nav>
  <div class="eyebrow">אנטומיה · כלי עזר</div>
  <h1>סימולטור שלד</h1>
  <p class="lead">לוחצים על עצם כדי לראות את השם שלה כמו במצגת, את השם הלטיני ופרט חשוב עליה. במצב "בחן את עצמך" מקבלים שם של עצם וצריך למצוא אותה בשלד.</p>
</header>
<main class="wrap">
  <div class="sim-card"><div id="skelSim"></div></div>
  <p class="sim-more">החומר המלא על השלד נמצא ב<a href="/science/anatomy/unit3/">יחידות 2–3: מערכת שלד-שריר ומפרקים</a>.</p>
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

</script>
</body></html>
