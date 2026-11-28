<?php http_response_code(404); exit; /* מוגש רק דרך api/branch_gate.php */ ?>
<!doctype html>
<html lang="he" dir="rtl"><head><meta charset="utf-8"><link rel="icon" href="/favicon.svg?v=2" type="image/svg+xml"><meta name="robots" content="noindex, nofollow, noarchive, nosnippet, noimageindex"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>מחשבונים וכלי עזר · קורס ענפי</title>
<meta name="claude:viewport-fit-sides" content="cover">
<link rel="stylesheet" href="/site.css?v=20261123f">
<script src="/theme.js?v=20261127c"></script><script src="/nav.js?v=20261128s" defer></script><script src="/sync.js?v=20261127d" defer></script><style>
.tools{display:flex;flex-direction:column;gap:14px}
details.tool{padding:0}
details.tool>summary{list-style:none;cursor:pointer;display:flex;gap:14px;align-items:center;padding:18px 22px;border-radius:14px}
details.tool>summary::-webkit-details-marker{display:none}
details.tool>summary:focus-visible{outline:3px solid var(--accent);outline-offset:2px}
details.tool>summary:hover h3{color:var(--accent)}
details.tool .sumt{flex:1;min-width:0}
details.tool .chev{flex:none;width:30px;height:30px;border-radius:50%;background:var(--accent-soft);display:grid;place-items:center;transition:transform .2s}
details.tool .chev::before{content:"";width:8px;height:8px;border-right:2.5px solid var(--accent);border-bottom:2.5px solid var(--accent);transform:translateY(-2px) rotate(45deg)}
details.tool[open] .chev{transform:rotate(180deg)}
details.tool[open]>summary{padding-bottom:4px}
details.tool>:not(summary){margin-inline:22px}
details.tool>:last-child{margin-bottom:20px}
.usage{display:inline-block;color:var(--ink);background:var(--accent-soft);border-radius:6px;padding:1px 8px;margin-inline-end:4px}
.zt-tests{display:grid;grid-template-columns:1fr;gap:12px;margin-top:12px}
.zt{border:1px solid var(--line);border-radius:12px;padding:10px 14px 14px;margin:0;background:var(--bg)}
.zt legend{font-weight:800;padding:0 6px;display:flex;gap:8px;align-items:center}
.zt legend .tag{font-size:12px;font-weight:700;border-radius:999px;padding:1px 8px;background:var(--accent-soft);color:var(--accent)}
.zt .row{margin-top:4px;align-items:end}
.zt{position:relative}
.zt-acts{position:absolute;top:-16px;left:12px;display:flex;gap:6px}
.zt-act{display:inline-flex;align-items:center;gap:5px;font:700 13px var(--body);color:var(--ink);background:var(--paper);border:1px solid var(--line);border-radius:999px;padding:4px 11px;cursor:pointer;line-height:1.3}
.zt-act svg{width:15px;height:15px;flex:none}
.zt-act:hover{border-color:var(--accent);color:var(--accent)}
.zt-act.del:hover{border-color:#E5484D;color:#E5484D}
.zt-act:focus-visible{outline:3px solid var(--accent);outline-offset:2px}
.zt[data-t="2"]{margin-top:10px}
.zt-pct{display:block;font-size:13px;color:var(--muted);margin-top:2px}
.zt-lt{margin:12px 0 0;padding:10px 14px;border-radius:12px;background:var(--accent-soft);font-size:15px;line-height:1.6}
.zt-lt a{color:var(--accent);font-weight:700}
@media (max-width:400px){.zt-act{padding:4px 8px;font-size:12.5px}}
.zt-bar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:10px;margin-top:12px}
.zt-add{font:700 15px var(--body);color:var(--accent);background:var(--paper);border:1.5px dashed var(--accent);border-radius:999px;padding:8px 16px;cursor:pointer}
.zt-view{display:flex;flex-wrap:wrap;align-items:center;gap:6px;font-size:14.5px;color:var(--muted)}
.zt-view[hidden]{display:none}
.zt-view button{font:700 14.5px var(--body);color:var(--ink);background:var(--paper);border:1px solid var(--line);border-radius:999px;padding:6px 14px;cursor:pointer}
.zt-view button[aria-pressed=true]{background:var(--accent);border-color:var(--accent);color:#fff}
.zt-imp{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:10px;margin-top:14px}
.zt-imp .res b.up{color:var(--ok)}.zt-imp .res b.down{color:#d9534f}
.zt-was{display:block;font-size:13px;color:var(--muted);margin-top:2px}
</style><link rel="preload" href="/fonts/Assistant-Variable.woff" as="font" type="font/woff" crossorigin><link rel="stylesheet" href="/design.css?v=5"></head><body>
<header class="wrap">
  <nav class="sb" id="acct" aria-label="ניווט באתר"><a class="home" href="/">קורס מדריכי ריצות ארוכות</a><span class="sep" aria-hidden="true">‹</span><a href="/branch/">קורס ענפי</a><span class="sep" aria-hidden="true">‹</span><span aria-current="page">מחשבונים וכלי עזר</span></nav>
  <div class="eyebrow">קורס ענפי</div>
  <h1>מחשבונים וכלי עזר</h1>
  <p class="lead">כלים לשימוש מהיר, בלי לחפש בתוך הפרקים: דופק מטרה, אזורי אימון ואחוז קצב.</p>
</header>
<main class="wrap">
<section class="tools" style="margin-top:22px" aria-label="מחשבונים">
        <details class="tool" id="hrCalc">
      <summary><span class="sumt"><h3>מחשבון דופק מטרה</h3><p class="desc">שתי שיטות זו לצד זו: אחוז מהדופק המרבי, ונוסחת קרבונן (אחוז מרזרבת הדופק), שמתחשבת גם בדופק המנוחה.</p></span><span class="chev" aria-hidden="true"></span></summary>
      <div class="row">
        <label>גיל<input type="number" id="cAge" min="10" max="90" inputmode="numeric"></label>
        <label>מין<select id="cSex"><option value="220">גבר (220 − גיל)</option><option value="226">אישה (226 − גיל)</option></select></label>
        <label>דופק מנוחה<input type="number" id="cRest" min="30" max="110" inputmode="numeric"></label>
        <label>דופק מרבי (אם נמדד)<input type="number" id="cMax" placeholder="השאר ריק לחיזוי" inputmode="numeric"></label>
      </div>
      <div class="row">
        <label>% מדופק מרבי: מ-<input type="number" id="cP1" min="30" max="100" inputmode="numeric"></label>
        <label>עד<input type="number" id="cP2" min="30" max="100" inputmode="numeric"></label>
        <label>% מרזרבת דופק: מ-<input type="number" id="cK1" min="20" max="100" inputmode="numeric"></label>
        <label>עד<input type="number" id="cK2" min="20" max="100" inputmode="numeric"></label>
      </div>
      <div class="out" id="cOut" aria-live="polite"></div>
      <p class="note">החיזוי לפי גיל הוא הערכה גסה. אם יש דופק מרבי ממבדק, עדיף להזין אותו. ההסבר המלא נמצא בפרק <a href="/branch/physiology/">"לב ודופק" בפיזיולוגיה</a>, והערכים שמוזנים כאן משותפים למחשבון שבפרק.</p>
    </details>
      <details class="tool" id="zCalc" style="border-top-color:var(--d4)">
      <summary><span class="sumt"><h3>מחשבון אזורי אימון (זונים) לפי טסט 30 דקות</h3><p class="desc">רצים 30 דקות בקצב הממוצע הגבוה ביותר. מזינים את המרחק ואת הדופק הממוצע של 20 הדקות האחרונות, ומקבלים קצב ודופק לכל אחד מ-6 הזונים. אפשר להוסיף טסט חוזר ולראות את השיפור.</p></span><span class="chev" aria-hidden="true"></span></summary>
      <p class="zt-lt"><b>מה הטסט מודד?</b> הטסט נותן הערכה של <b>סף 2</b> (סף הלקטאט, או הסף האנאירובי): הדופק הממוצע ב-20 הדקות האחרונות הוא דופק הסף, וכל הזונים מחושבים כאחוזים ממנו. כדי להגדיר את הזונים בשעון, מגדירים אותם לפי דופק סף, ולא לפי אחוז מהדופק המרבי. הרחבה בפרק <a href="/branch/training/#c=zones">"אזורי אימון"</a> בעקרונות תורת האימון, ועל הספים בפרק <a href="/branch/physiology/#c=lactate">"סף ויעילות"</a> בפיזיולוגיה. בשעון עם 5 זונים, זון 5 מתחיל מ-5A (מעל 100% מדופק הסף).</p>
      <div class="zt-tests" id="zTests"></div>
      <div class="zt-bar">
        <button type="button" class="zt-add" id="zAdd">+ הוספת טסט נוסף (להשוואה)</button>
        <div class="zt-view" id="zView" role="group" aria-label="מה להציג" hidden>
          <span>מה להציג:</span>
          <button type="button" data-v="cmp">השוואה</button><button type="button" data-v="1">רק טסט 1</button><button type="button" data-v="2">רק טסט 2</button>
        </div>
      </div>
      <div id="zOut" aria-live="polite"></div>
      <p class="note">הקצבים לפי אחוז מקצב הטסט (פרייל), והדופק לפי אחוז מדופק הסף שבמצגת. ההסבר המלא בפרק <a href="/branch/training/">"אזורי אימון" בתורת האימון</a>.</p>
    </details>
    <details class="tool" id="pCalc" style="border-top-color:var(--d2)">
      <summary><span class="sumt"><h3>מחשבון אחוז קצב מטסט</h3><p class="desc"><b class="usage">מיועד לתרגול אימוני עליות.</b> מזינים קצב ייחוס (למשל הקצב מטסט 30 דקות) ואחוז, ומקבלים את הקצב לאימון.</p></span><span class="chev" aria-hidden="true"></span></summary>
      <div class="row">
        <label>קצב ייחוס: דקות<input type="number" id="pMin" min="2" max="15" inputmode="numeric"></label>
        <label>שניות<input type="number" id="pSec" min="0" max="59" inputmode="numeric"></label>
        <label>אחוזים מהקצב<input type="number" id="pPct" min="50" max="130" step="0.5" inputmode="decimal"></label>
      </div>
      <div id="pOut" aria-live="polite"></div>
      <p class="note">החישוב זהה לגיליון "מחשבון אחוז קצב מטסט": הקצב המחושב = קצב הייחוס ÷ האחוז, ומעגלים כלפי מטה לשנייה שלמה. האחוז הוא אחוז מה<b>מהירות</b>, ולכן 90% נותן קצב <b>איטי</b> יותר ו-105% קצב <b>מהיר</b> יותר. זה שונה מטבלת הזונים של פרייל, שבה מכפילים את <b>זמן</b> הקצב באחוז.</p>
    </details>
</section>
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
/* מחשבון דופק מטרה. אותו מפתח שמירה כמו בפרק "לב ודופק" (phys.calc), כך שהערכים משותפים ונשמרים גם בחשבון. */
(function(){
  const $=id=>document.getElementById(id);
  const def={cAge:20,cSex:"220",cRest:50,cMax:"",cP1:60,cP2:70,cK1:40,cK2:60};
  let saved=def;try{saved=Object.assign({},def,JSON.parse(localStorage.getItem("phys.calc")||"{}"))}catch(e){}
  const m=t=>`<span class="m">${t}</span>`;
  Object.keys(def).forEach(k=>{$(k).value=saved[k]??def[k];$(k).addEventListener("input",calc);$(k).addEventListener("change",calc)});
  function calc(){
    const v={};Object.keys(def).forEach(k=>v[k]=$(k).value);
    try{localStorage.setItem("phys.calc",JSON.stringify(v))}catch(e){}
    const age=+v.cAge,rest=+v.cRest,base=+v.cSex,mx=v.cMax?+v.cMax:base-age,res=mx-rest;
    const p=a=>Math.round(mx*a/100),k=a=>Math.round(rest+res*a/100);
    if(!(age>0&&rest>0&&mx>rest)){$("cOut").innerHTML=`<div class="res">בדוק את הנתונים: הדופק המרבי צריך להיות גבוה מדופק המנוחה.</div>`;return}
    $("cOut").innerHTML=
     `<div class="res"><div>דופק מרבי ${v.cMax?"(נמדד)":"(חזוי)"}</div><div class="big">${mx}</div><div class="how">${v.cMax?"הוזן ידנית":m(`${base} − ${age} = ${mx}`)}</div></div>`+
     `<div class="res"><div>רזרבת דופק</div><div class="big">${res}</div><div class="how">${m(`${mx} − ${rest} = ${res}`)}</div></div>`+
     `<div class="res"><div>${m(`${v.cP1}–${v.cP2}%`)} מהדופק המרבי</div><div class="big">${m(`${p(+v.cP1)}–${p(+v.cP2)}`)}</div><div class="how">${m(`${mx} × ${v.cP1}% = ${p(+v.cP1)}`)} · ${m(`${mx} × ${v.cP2}% = ${p(+v.cP2)}`)}</div></div>`+
     `<div class="res key"><div>${m(`${v.cK1}–${v.cK2}%`)} מרזרבת הדופק (קרבונן)</div><div class="big">${m(`${k(+v.cK1)}–${k(+v.cK2)}`)}</div><div class="how">${m(`${rest} + ${res} × ${v.cK1}% = ${k(+v.cK1)}`)} · ${m(`${rest} + ${res} × ${v.cK2}% = ${k(+v.cK2)}`)}</div></div>`;
  }
  calc();
})();

/* מחשבון זונים לפי טסט 30 דקות, עם אפשרות לטסט חוזר והשוואה.
   נשמר ב-train.ztests (נשמר גם בחשבון, דרך sync.js): {t1:{d,hr,date}, t2:{...}|null, view:"cmp"|"1"|"2"}.
   הטסט העדכני (2 אם יש, אחרת 1) נכתב גם ל-train.zcalc, שממנו קורא המחשבון שבפרק "אזורי אימון". */
(function(){
  const $=id=>document.getElementById(id);
  const Z=[["1","התאוששות",1.29,null,.65,.84],["2","סבולת נרחבת",1.14,1.29,.85,.91],["3","סבולת עצימה",1.06,1.13,.92,.95],["4","סף אנאירובי",.99,1.05,.96,1],["5A","מעל הסף",.97,1,1,1.02],["5B","סבולת אנאירובית",.9,.96,1.03,1.05]];
  const mmss=x=>{x=Math.round(x);return Math.floor(x/60)+":"+String(x%60).padStart(2,"0")};
  const m=t=>`<span class="m">${t}</span>`;
  const fmtDate=s=>{const a=(s||"").split("-");return a.length===3?`${a[2]}/${a[1]}/${a[0]}`:""};
  let st=null;try{st=JSON.parse(localStorage.getItem("train.ztests")||"null")}catch(e){}
  if(!st||!st.t1){let v={zDist:6,zHr:170};try{v=Object.assign(v,JSON.parse(localStorage.getItem("train.zcalc")||"{}"))}catch(e){}st={t1:{d:v.zDist,hr:v.zHr,date:""},t2:null,view:"1"}}
  function save(){
    try{localStorage.setItem("train.ztests",JSON.stringify(st));const L=st.t2&&ok(st.t2)?st.t2:st.t1;localStorage.setItem("train.zcalc",JSON.stringify({zDist:String(L.d),zHr:String(L.hr)}))}catch(e){}
  }
  const ok=t=>t&&+t.d>0&&+t.hr>0;
  function testBox(n){
    const t=st["t"+n];
    return `<fieldset class="zt" data-t="${n}"><legend>טסט ${n}${n===2?'<span class="tag">טסט חוזר</span>':""}</legend>${n===2?ACTS:""}<div class="row">
      <label>תאריך (לא חובה)<input type="date" data-k="date" value="${t.date||""}"></label>
      <label>מרחק ב-30 דק׳ (ק״מ)<input type="number" data-k="d" min="2" max="12" step="0.01" inputmode="decimal" value="${t.d??""}"${n===1?' id="zDist"':""}></label>
      <label>דופק ממוצע ב-20 הדק׳ האחרונות (דופק סח״ח)<input type="number" data-k="hr" min="100" max="210" inputmode="numeric" value="${t.hr??""}"${n===1?' id="zHr"':""}></label></div>
      </fieldset>`;
  }
  function drawInputs(){
    $("zTests").innerHTML=testBox(1)+(st.t2?testBox(2):"");
    $("zAdd").hidden=!!st.t2; $("zView").hidden=!st.t2;
    $("zTests").querySelectorAll("input").forEach(i=>{const f=()=>{const n=i.closest(".zt").dataset.t;st["t"+n][i.dataset.k]=i.value;save();calc()};i.addEventListener("input",f);i.addEventListener("change",f)});
    const rm=$("zTests").querySelector("[data-rm]");if(rm)rm.onclick=async()=>{if(!await confirmish({title:"למחוק את טסט 2?",text:"הנתונים של טסט 2 יימחקו, ויוצג רק טסט 1.",ok:"למחוק",danger:true}))return;st.t2=null;st.view="1";save();drawInputs();calc()};
    const sh=$("zTests").querySelector("[data-shift]");if(sh)sh.onclick=async()=>{if(!await confirmish({title:"להתחיל טסט חדש?",text:"טסט 2 יהפוך לטסט 1, ויתפנה מקום לטסט חדש. הנתונים של טסט 1 הנוכחי יימחקו.",ok:"להמשיך",icon:"🔄"}))return;st.t1=st.t2;st.t2={d:"",hr:st.t1.hr,date:""};st.view="cmp";save();drawInputs();calc()};
  }
  /* window.confirm blocks some embedded browsers; fall back to "yes" when it isn't available. */
  const ACTS='<div class="zt-acts">'
    +'<button type="button" class="zt-act" data-shift title="טסט 2 הופך לטסט 1, ומתפנה מקום לטסט חדש" aria-label="טסט חדש: טסט 2 הופך לטסט 1"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 0 1 15.5-6.2L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-15.5 6.2L3 16"/><path d="M3 21v-5h5"/></svg><span class="lbl">טסט חדש</span></button>'
    +'<button type="button" class="zt-act del" data-rm title="מחיקת טסט 2" aria-label="מחיקת טסט 2"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg><span class="lbl">מחיקה</span></button></div>';
  function confirmish(o){if(window.runnersDialog)return window.runnersDialog(o);try{return Promise.resolve(window.confirm(o.text))}catch(e){return Promise.resolve(true)}}
  function zonesHTML(t,prev){
    const p=1800/t.d,hr=+t.hr,pp=prev?1800/prev.d:0,ph=prev?+prev.hr:0;
    const pace=(x,z)=>z[3]?`${mmss(x*z[2])}–${mmss(x*z[3])}`:"איטי מ-"+mmss(x*z[2]);
    const hrs=(h,z)=>z[0]==="1"?"עד "+Math.round(h*z[5]):`${Math.round(h*z[4])}–${Math.round(h*z[5])}`;
    const pct=z=>z[0]==="1"?`עד ${Math.round(z[5]*100)}%`:`${Math.round(z[4]*100)}–${Math.round(z[5]*100)}%`;
    return `<div class="out">`+Z.map(z=>`<div class="res"><div><b>זון ${z[0]}</b> · ${z[1]}</div><div class="big" style="font-size:22px">${m(pace(p,z))}</div>${prev?`<span class="zt-was">בטסט 1: ${m(pace(pp,z))}</span>`:""}<div class="how">דופק ${m(hrs(hr,z))}${prev?` <span class="zt-was" style="display:inline">(בטסט 1: ${m(hrs(ph,z))})</span>`:""}<span class="zt-pct">${m(pct(z))} מדופק הסף</span></div></div>`).join("")+`</div>`;
  }
  function single(n){
    const t=st["t"+n];
    if(!ok(t))return `<div class="out"><div class="res">הזן מרחק ודופק${st.t2?" לטסט "+n:""}.</div></div>`;
    const p=1800/t.d;
    return `<div class="out"><div class="res key"><div>קצב הטסט${st.t2?" · טסט "+n:""}${t.date?" · "+fmtDate(t.date):""}</div><div class="big">${m(mmss(p))}</div><div class="how">דקות לק״מ · ${m(`30 ÷ ${t.d} = ${mmss(p)}`)}</div></div></div>`+zonesHTML(t,null);
  }
  function compare(){
    const a=st.t1,b=st.t2;
    if(!ok(a)||!ok(b))return `<div class="out"><div class="res">כדי להשוות, צריך מרחק ודופק בשני הטסטים.</div></div>`+(ok(a)?single(1):"");
    const pa=1800/a.d,pb=1800/b.d,ds=Math.round(pa)-Math.round(pb),pct=(pa-pb)/pa*100,dm=Math.round((b.d-a.d)*1000),dh=b.hr-a.hr;
    let days="";if(a.date&&b.date){const n=Math.round((new Date(b.date)-new Date(a.date))/864e5);if(n>0)days=`בתוך ${n} ימים`}
    const cls=ds>0?"up":ds<0?"down":"";
    const verdict=ds>0?`✓ מהר יותר בכל ק״מ`:ds<0?`איטי יותר בכל ק״מ`:"הקצב לא השתנה";
    return `<div class="zt-imp">
      <div class="res key"><div>השיפור${days?" · "+days:""}</div><div class="big"><b class="${cls}">${m(Math.abs(ds))} שנ׳</b></div><div class="how">${verdict} (${m((pct>=0?"":"−")+Math.abs(pct).toFixed(1)+"%")})</div></div>
      <div class="res"><div>קצב הטסט</div><div class="big" style="font-size:22px">${m(mmss(pa))} ← ${m(mmss(pb))}</div><div class="how">טסט 1 ← טסט 2 (דקות לק״מ)</div></div>
      <div class="res"><div>מרחק ב-30 דק׳</div><div class="big" style="font-size:22px">${m(a.d)} ← ${m(b.d)}</div><div class="how">${dm===0?"אותו מרחק":`${dm>0?"עוד":"פחות"} ${m(Math.abs(dm))} מ׳`}</div></div>
      <div class="res"><div>דופק סח״ח</div><div class="big" style="font-size:22px">${m(a.hr)} ← ${m(b.hr)}</div><div class="how">${dh===0?"אותו דופק":`${dh>0?"+":"−"}${m(Math.abs(dh))} פעימות. הזונים של הדופק מתעדכנים בהתאם`}</div></div>
    </div><p class="note" style="margin:10px 0 0">הזונים לפי הטסט העדכני (טסט 2). מתחת לכל זון מופיע הערך מטסט 1.</p>`+zonesHTML(b,a);
  }
  function calc(){
    const v=st.t2?st.view||"cmp":"1";
    $("zView").querySelectorAll("button").forEach(x=>x.setAttribute("aria-pressed",String(x.dataset.v===v)));
    $("zOut").innerHTML=v==="cmp"?compare():single(+v);
  }
  $("zAdd").onclick=()=>{st.t2={d:"",hr:st.t1.hr||"",date:""};st.view="cmp";save();drawInputs();calc();const i=$("zTests").querySelector('[data-t="2"] input[data-k="d"]');if(i)i.focus()};
  $("zView").addEventListener("click",e=>{const x=e.target.closest("[data-v]");if(!x)return;st.view=x.dataset.v;save();calc()});
  drawInputs();calc();
})();

/* מחשבון אחוז קצב מטסט: כמו בגיליון, INT(שניות הייחוס / (אחוז/100)). */
(function(){
  const $=id=>document.getElementById(id);
  const mmss=x=>Math.floor(x/60)+":"+String(x%60).padStart(2,"0");
  const m=t=>`<span class="m">${t}</span>`;
  const pace=(ref,p)=>Math.floor(ref/(p/100));
  let v={pMin:4,pSec:0,pPct:90};try{v=Object.assign(v,JSON.parse(localStorage.getItem("train.pcalc")||"{}"))}catch(e){}
  ["pMin","pSec","pPct"].forEach(k=>$(k).value=v[k]);
  function calc(){
    const mi=+$("pMin").value||0,se=+$("pSec").value||0,p=+$("pPct").value;
    try{localStorage.setItem("train.pcalc",JSON.stringify({pMin:$("pMin").value,pSec:$("pSec").value,pPct:$("pPct").value}))}catch(e){}
    const ref=mi*60+se;
    if(!(ref>0&&p>0)){$("pOut").innerHTML='<div class="out"><div class="res">הזן קצב ייחוס ואחוז.</div></div>';return}
    const r=pace(ref,p);
    const list=[80,85,90,95,100,105,110].map(q=>`<div class="res"${q===p?' style="border-color:var(--accent)"':''}><div>${m(q+"%")}</div><div class="big" style="font-size:22px">${m(mmss(pace(ref,q)))}</div></div>`).join("");
    $("pOut").innerHTML=`<div class="out"><div class="res key"><div>הקצב המחושב (${m(p+"%")} מ-${m(mmss(ref))})</div><div class="big">${m(mmss(r))}</div><div class="how">דקות לק״מ · ${m(`${ref} ÷ ${p/100} = ${(ref/(p/100)).toFixed(1)}`)} ← ${r} שניות</div></div></div>`+
      `<div class="note" style="margin-top:12px">אחוזים נפוצים מאותו קצב ייחוס:</div><div class="out" style="grid-template-columns:repeat(auto-fit,minmax(90px,1fr));margin-top:6px">${list}</div>`;
  }
  ["pMin","pSec","pPct"].forEach(k=>{$(k).addEventListener("input",calc);$(k).addEventListener("change",calc)});calc();
})();
</script>
</body></html>
