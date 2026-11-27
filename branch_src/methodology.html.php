<?php http_response_code(404); exit; /* מוגש רק דרך api/branch_gate.php */ ?>
<!doctype html>
<html lang="he" dir="rtl"><head><meta charset="utf-8"><link rel="icon" href="/favicon.svg?v=2" type="image/svg+xml"><meta name="robots" content="noindex, nofollow, noarchive, nosnippet, noimageindex"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>מתודיקה באימון · קורס ענפי · קורס מדריכי ריצות ארוכות</title>
<meta name="claude:viewport-fit-sides" content="cover">
<style>
/* Same field-guide notebook as "תורת האימון": sticky chapter rail, one chapter at a time, quiz closes each chapter */
:root{
  --bg:#EEF2F4; --paper:#FFFFFF; --ink:#13232E; --muted:#56687A; --line:#D3DCE3;
  --accent:#1F5FD6; --accent-soft:#E2EBFB; --bone:#F7F2E4; --boneInk:#6B5521;
  --ok:#1F8A55; --okSoft:#E1F3E9; --bad:#C23B45; --badSoft:#FBE6E8; --plate:#FFFFFF; --boneFill:#F3EAD3;
  --d1:#D23F4D; --d2:#2C6AD6; --d3:#1C9461; --d4:#8549CC; --grid:#E3E9EE;
  --display:"Assistant",system-ui,sans-serif;
  --body:"Assistant",system-ui,-apple-system,"Segoe UI",sans-serif;
  --latin:"Assistant",system-ui,sans-serif;
  color-scheme:light;
}
@media (prefers-color-scheme:dark){:root:not([data-theme="light"]){
  --bg:#0F171D; --paper:#17222B; --ink:#E6EDF2; --muted:#93A4B3; --line:#2A3946;
  --accent:#7FA8FF; --accent-soft:#1B2C47; --bone:#2A2618; --boneInk:#E3CD92;
  --ok:#5CCB92; --okSoft:#14301F; --bad:#FF8089; --badSoft:#3A1A1E; --plate:#F1F3F5; --boneFill:#3B3527;
  --d1:#FF7783; --d2:#82AAFF; --d3:#5ECC93; --d4:#C29CFF; --grid:#22303B; color-scheme:dark}}
:root[data-theme="dark"]{
  --bg:#0F171D; --paper:#17222B; --ink:#E6EDF2; --muted:#93A4B3; --line:#2A3946;
  --accent:#7FA8FF; --accent-soft:#1B2C47; --bone:#2A2618; --boneInk:#E3CD92;
  --ok:#5CCB92; --okSoft:#14301F; --bad:#FF8089; --badSoft:#3A1A1E; --plate:#F1F3F5; --boneFill:#3B3527;
  --d1:#FF7783; --d2:#82AAFF; --d3:#5ECC93; --d4:#C29CFF; --grid:#22303B; color-scheme:dark}
*{box-sizing:border-box}
html{scroll-padding-top:env(safe-area-inset-top,0px)}
body{margin:0;background:var(--bg);color:var(--ink);font-family:var(--body);font-size:17px;line-height:1.65;direction:rtl;padding-bottom:env(safe-area-inset-bottom,0px)}
body::before{content:"";position:fixed;inset:0 0 auto;height:env(safe-area-inset-top,0px);z-index:10;background:var(--paper)}
img{max-width:100%}
.wrap{max-width:860px;margin:0 auto;padding-left:max(16px,env(safe-area-inset-left,0px));padding-right:max(16px,env(safe-area-inset-right,0px))}
header.top{padding-block:calc(28px + env(safe-area-inset-top,0px)) 8px}
h1{font-family:var(--display);font-weight:400;font-size:clamp(30px,6vw,44px);line-height:1.1;margin:0;text-wrap:balance}
.lead{color:var(--muted);margin:8px 0 0;max-width:62ch}
.lead a{color:var(--accent)}
nav.rail{position:sticky;top:env(safe-area-inset-top,0px);z-index:5;background:var(--paper);border-bottom:1px solid var(--line);margin-top:18px}
nav.rail .wrap{display:flex;gap:6px;overflow-x:auto;padding-block:10px;scrollbar-width:thin}
nav.rail button{flex:0 0 auto;font:600 15px var(--body);color:var(--muted);background:transparent;border:1px solid var(--line);border-radius:999px;padding:6px 14px;cursor:pointer;display:flex;gap:6px;align-items:center}
nav.rail button[aria-selected="true"]{background:var(--ink);color:var(--paper);border-color:var(--ink)}
nav.rail button .done{width:8px;height:8px;border-radius:50%;background:var(--line)}
nav.rail button .done.on{background:var(--ok)}
button:focus-visible,.opt:focus-visible,.card:focus-visible,input:focus-visible,select:focus-visible{outline:3px solid var(--accent);outline-offset:2px}
main{padding-block:26px 60px}
.chap-head{display:flex;flex-direction:column;gap:4px;margin-bottom:18px}
.eyebrow{font:600 13px var(--body);letter-spacing:.06em;color:var(--accent)}
h2{font-family:var(--display);font-weight:400;font-size:clamp(24px,4.5vw,32px);margin:0;line-height:1.2;text-wrap:balance}
h3{font-size:19px;margin:0 0 6px;line-height:1.3}
.stack{display:flex;flex-direction:column;gap:14px}
.block{background:var(--paper);border:1px solid var(--line);border-radius:10px;padding:18px 20px;min-width:0}
.block p{margin:0 0 8px}.block p:last-child{margin:0}
.block ul,.block ol{margin:4px 0 0;padding-inline-start:20px}.block li{margin:3px 0}
.m{unicode-bidi:isolate;white-space:nowrap}
.lat{font-family:var(--latin);font-size:.82em;font-style:italic;color:var(--muted);direction:ltr;unicode-bidi:isolate;white-space:nowrap}
.trick{background:var(--bone);color:var(--ink);border:1px dashed var(--boneInk);border-radius:10px;padding:14px 18px}
.trick b.tag{display:block;font-size:13px;letter-spacing:.06em;color:var(--boneInk);margin-bottom:2px}
.warn{border-inline-start:4px solid var(--bad);padding-inline-start:12px}
.tbl{overflow-x:auto;border:1px solid var(--line);border-radius:10px;background:var(--paper)}
table{border-collapse:collapse;width:100%;min-width:520px;font-size:15.5px}
th,td{text-align:right;padding:9px 12px;border-bottom:1px solid var(--line);vertical-align:top}
th{background:var(--accent-soft);font-weight:700;font-size:14px}
tr:last-child td{border-bottom:0}
td.num,th.num{font-variant-numeric:tabular-nums;white-space:nowrap}
.grid2{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px}
.mini{background:var(--paper);border:1px solid var(--line);border-radius:10px;padding:14px 16px;min-width:0}
.mini .k{font-weight:700}
.block .mini{background:var(--bg)}
figure{margin:0}
.fig{margin-top:12px;min-width:0}
.fig .plate{background:var(--plate);border:1px solid var(--line);border-radius:8px;padding:8px;display:flex;justify-content:center}
.fig .plate img{width:auto;max-width:100%;object-fit:contain;border-radius:4px;display:block}
.figrow{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;align-items:start}
.figrow .fig{margin-top:0}
figcaption{font-size:13.5px;color:var(--muted);margin-top:6px}
details.more{margin-top:12px}
details.more summary{display:inline-flex;align-items:center;gap:8px;cursor:pointer;font:600 15px var(--body);color:var(--accent);background:var(--accent-soft);border:1px solid var(--accent);border-radius:999px;padding:6px 14px;list-style:none}
details.more summary::-webkit-details-marker{display:none}
details.more summary::before{content:"+";font-weight:700;width:1em;text-align:center}
details.more[open] summary::before{content:"−"}

/* formulas & flow chains */
.formula{font-family:var(--display);font-size:clamp(19px,4vw,24px);text-align:center;background:var(--accent-soft);border:1px solid var(--accent);border-radius:10px;padding:12px 14px;margin:10px 0;line-height:1.4}
.formula .en{display:block;font-family:var(--latin);font-size:15px;color:var(--muted);direction:ltr;margin-top:4px}
.chain{display:flex;flex-wrap:wrap;align-items:center;gap:6px 8px;margin:10px 0}
.chain .n{background:var(--bg);border:1px solid var(--line);border-radius:8px;padding:6px 12px;font-weight:600}
.chain .n.hot{border-color:var(--d1);background:color-mix(in srgb,var(--d1) 12%,var(--paper))}
.chain .n.cool{border-color:var(--d2);background:color-mix(in srgb,var(--d2) 12%,var(--paper))}
.chain .n.good{border-color:var(--d3);background:color-mix(in srgb,var(--d3) 12%,var(--paper))}
.chain .ar{color:var(--muted);font-weight:700}
.zone-lab{font:600 13px var(--body);color:var(--muted);letter-spacing:.04em;margin-top:10px}
.atp{display:flex;align-items:center;gap:4px;flex-wrap:wrap;margin:8px 0}
.atp .ad{background:var(--boneFill);border:2px solid var(--ink);border-radius:999px;padding:4px 14px;font-weight:700}
.atp .p{width:30px;height:30px;border-radius:50%;border:2px solid var(--ink);display:grid;place-items:center;font:700 14px var(--latin);background:color-mix(in srgb,var(--d4) 25%,var(--paper))}
.atp .bond{width:14px;height:3px;background:var(--ink)}
.atp .zap{color:var(--d1);font-weight:700;margin-inline:6px}

/* intensity domains */
.domains{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-top:10px}
.dom{border-radius:10px;padding:12px;border:1px solid var(--line);border-top:6px solid var(--c);background:color-mix(in srgb,var(--c) 9%,var(--paper));min-width:0}
.dom .nm{font-family:var(--display);font-size:20px;line-height:1.2}
.dom .en{font:500 12px var(--latin);color:var(--muted);direction:ltr;text-align:right}
.dom .t{font-weight:700;margin-top:6px}
.dom .s{font-size:14.5px;color:var(--muted)}
.dom-arrow{display:flex;justify-content:space-between;font-size:14px;color:var(--muted);margin-top:8px}
.thr{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;font:600 13px var(--body);color:var(--muted);margin-top:4px}
.thr span{text-align:left;border-inline-end:0}
@media (max-width:640px){.domains,.thr{grid-template-columns:1fr 1fr}.thr{display:none}}

/* charts */
.dplate{background:var(--paper);border:1px solid var(--line);border-radius:8px;padding:10px;overflow-x:auto}
.ch{display:block;width:100%;height:auto;max-width:620px;min-width:0;margin:0 auto;direction:ltr}
.ch text{font-family:var(--body);fill:var(--ink);direction:rtl}
.ch .ax{stroke:var(--muted);stroke-width:1}
.ch .gr{stroke:var(--grid);stroke-width:1}
.ch .tk{fill:var(--muted);font-size:13.5px}
.ch .lb{font-size:15px;font-weight:700}
.ch .sm{fill:var(--muted);font-size:14px}
.ch .ln{fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round}
.ch .c1{stroke:var(--d1)}.ch .c2{stroke:var(--d2)}.ch .c3{stroke:var(--d3)}.ch .c4{stroke:var(--d4)}
.ch .f1{fill:var(--d1)}.ch .f2{fill:var(--d2)}.ch .f3{fill:var(--d3)}.ch .f4{fill:var(--d4)}
.ch .t1{fill:var(--d1)}.ch .t2{fill:var(--d2)}
.ch .dash{stroke-dasharray:6 5}
.ch .dot{stroke:var(--paper);stroke-width:2}
.ch .hit{fill:transparent;cursor:pointer}
.ch .hit:hover+.bar,.ch g.bar:hover rect{opacity:.85}
@media (max-width:560px){.block{padding:14px 12px}.dplate{padding:4px}}
.legend{display:flex;gap:16px;flex-wrap:wrap;justify-content:center;font-size:14px;color:var(--muted);margin:2px 0 6px}
.legend i{display:inline-block;width:12px;height:12px;border-radius:3px;margin-inline-end:6px;vertical-align:-1px}
.tip{position:fixed;z-index:20;pointer-events:none;background:var(--ink);color:var(--paper);font-size:14px;padding:6px 10px;border-radius:6px;max-width:240px;line-height:1.35;opacity:0;transition:opacity .1s}

/* calculator */
.calc{background:var(--paper);border:2px solid var(--accent);border-radius:12px;padding:18px 20px}
.calc .row{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:10px 14px;margin-top:10px}
.calc label{display:flex;flex-direction:column;gap:4px;font-weight:600;font-size:15px}
.calc input,.calc select{font:inherit;font-size:17px;padding:7px 10px;border:1px solid var(--line);border-radius:8px;background:var(--bg);color:var(--ink);width:100%}
.calc .out{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:10px;margin-top:14px}
.calc .res{background:var(--bg);border:1px solid var(--line);border-radius:10px;padding:12px 14px}
.calc .res .big{font-family:var(--display);font-size:28px;line-height:1.1;font-variant-numeric:tabular-nums}
.calc .res .how{font-size:14px;color:var(--muted);margin-top:4px;direction:rtl}
.calc .note{font-size:14px;color:var(--muted);margin-top:10px}
.factors{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:8px;margin-top:8px}
.factors .mini{padding:10px 12px;font-size:15px}
.factors .mini .k{color:var(--accent)}

/* flashcards */
.fc-bar{display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin-bottom:10px}
.card{background:var(--paper);border:1px solid var(--line);border-radius:14px;min-height:200px;padding:22px;display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;cursor:pointer;user-select:none}
.card .q{font-family:var(--display);font-size:26px;line-height:1.25}
.card .hint{color:var(--muted);font-size:14px;margin-top:10px}
.card .a{font-size:17px;text-align:right;width:100%;max-width:52ch}
.btn{font:600 15px var(--body);border-radius:8px;padding:8px 16px;cursor:pointer;border:1px solid var(--line);background:var(--paper);color:var(--ink)}
.btn.primary{background:var(--accent);border-color:var(--accent);color:var(--paper)}
.count{color:var(--muted);font-variant-numeric:tabular-nums;font-size:15px}
/* quiz */
.quiz{margin-top:26px;background:var(--paper);border:2px solid var(--ink);border-radius:12px;padding:20px}
.quiz h2{font-size:24px}
.qitem{border-top:1px solid var(--line);padding-top:14px;margin-top:14px}
.qitem .qt{font-weight:700;margin-bottom:8px}
.opts{display:flex;flex-direction:column;gap:7px}
.opt{text-align:right;font:inherit;font-size:16px;border:1px solid var(--line);border-radius:8px;padding:9px 12px;background:var(--bg);color:var(--ink);cursor:pointer}
.opt:hover:not([disabled]){border-color:var(--accent)}
.opt.right{background:var(--okSoft);border-color:var(--ok)}
.opt.wrong{background:var(--badSoft);border-color:var(--bad)}
.opt[disabled]{cursor:default}
.expl{margin-top:8px;font-size:15.5px;padding:8px 12px;border-radius:8px;background:var(--accent-soft)}
.score{margin-top:16px;font-weight:700;display:flex;gap:12px;align-items:center;flex-wrap:wrap}
.foot{color:var(--muted);font-size:14px;padding-block:0 30px}
@media (prefers-reduced-motion:no-preference){.card{transition:transform .15s}.card:active{transform:scale(.99)}}

.sb{display:flex;align-items:center;gap:6px 10px;flex-wrap:wrap;font:600 14px "Assistant",system-ui,sans-serif;margin-bottom:14px;min-height:30px}
.sb a{color:var(--muted);text-decoration:none;border-radius:6px;padding:2px 0}
.sb a:hover{color:var(--accent)}
.sb a.home{color:var(--accent)}
.sb [aria-current]{color:var(--ink)}
.sb .sep{color:var(--muted);opacity:.6}
.sb a:focus-visible{outline:3px solid var(--accent);outline-offset:2px}

/* training theory additions */
.sbar{display:grid;grid-template-columns:110px 1fr;gap:10px;align-items:center;margin:6px 0}
.sbl{font-weight:600;font-size:14.5px}
.sbt{display:flex;gap:2px;height:30px;border-radius:6px;overflow:hidden}
.sbt span{display:grid;place-items:center;color:#fff;font:700 13px var(--body);min-width:0;cursor:default}
.rbgrid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:18px}
.rbt{font-weight:700;margin-bottom:6px}
.rb{display:grid;grid-template-columns:62px 1fr;gap:8px;align-items:center;margin:5px 0;font-size:14.5px}
.rbb{height:16px;background:var(--bg);border-radius:4px;overflow:hidden;display:block}
.rbb i{display:block;height:100%;border-radius:4px}
.pyr{display:flex;flex-direction:column;align-items:center;gap:4px;margin:10px auto 14px;max-width:420px;position:relative;padding:14px 0 34px;border:2px dashed var(--accent);border-radius:999px/60px}
.pyr div{text-align:center;font-weight:700;padding:8px 0;color:#fff;border-radius:6px}
.pyr .p3{width:40%;background:var(--d1)}.pyr .p2{width:60%;background:var(--d3)}.pyr .p1{width:80%;background:var(--d2)}
.pyr .ring{position:absolute;bottom:6px;color:var(--accent)!important;font-size:14px;padding:0;background:none}
.ladder{display:flex;flex-direction:column;align-items:center;gap:4px;margin:8px 0}
.ladder .lv{width:var(--w);background:var(--accent-soft);border:1px solid var(--accent);border-radius:8px;padding:7px 12px;display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;font-size:15px}
.ladder .lv span{color:var(--muted);font-size:14px}
@media (max-width:560px){.ladder .lv{width:100%!important}}
.models{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:10px}
.models>div{display:flex;flex-direction:column;gap:3px;font-size:14px}
.models b{font-size:14px;margin-bottom:2px}
.models span{border-radius:6px;padding:6px;text-align:center;color:#fff;font-weight:600}
.models .g{background:var(--d3)}.models .r{background:var(--d1)}.models .b{background:var(--d2)}
.zl{display:flex;flex-direction:column;gap:4px;margin-top:10px}
.zr{display:grid;grid-template-columns:70px 1fr;border:1px solid var(--line);border-inline-start:6px solid var(--c);border-radius:8px;background:color-mix(in srgb,var(--c) 8%,var(--paper));overflow:hidden}
.zn{font-family:var(--display);font-size:19px;display:grid;place-items:center;color:var(--c)}
.zt{padding:8px 12px;font-size:15.5px}
.zd{color:var(--muted);font-size:14.5px;margin-top:2px}
.zsep{font:700 13px var(--body);color:var(--d1);border-top:2px dashed var(--d1);padding-top:2px;margin:2px 0}
table.wide{min-width:760px}

/* YouTube embeds */
.vid{position:relative;aspect-ratio:16/9;background:#000;border-radius:8px;overflow:hidden;border:1px solid var(--line)}
.vid iframe{position:absolute;inset:0;width:100%;height:100%;border:0}
.vids{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:14px}
.vids .fig{margin-top:0}
figcaption a{color:var(--accent)}

/* methodology additions */
.chk{display:flex;flex-direction:column;gap:6px;margin-top:8px}
.chk label{display:flex;gap:10px;align-items:flex-start;background:var(--bg);border:1px solid var(--line);border-radius:8px;padding:9px 12px;cursor:pointer}
.chk input{width:18px;height:18px;margin-top:4px;flex:0 0 auto;accent-color:var(--ok)}
.chk input:checked+span{color:var(--muted);text-decoration:line-through}
</style><script src="/theme.js?v=20261127c"></script><script src="/nav.js?v=20261127h" defer></script><script src="/sync.js?v=20261127d" defer></script><link rel="preload" href="/fonts/Assistant-Variable.woff" as="font" type="font/woff" crossorigin><link rel="stylesheet" href="/design.css?v=5"></head>
<body>

<header class="top wrap"><nav class="sb" aria-label="ניווט באתר"><a class="home" href="/">קורס מדריכי ריצות ארוכות</a><span class="sep" aria-hidden="true">‹</span><a href="/branch/">קורס ענפי</a><span class="sep" aria-hidden="true">‹</span><a href="/branch/theory/">תורת האימון</a><span class="sep" aria-hidden="true">‹</span><span aria-current="page">מתודיקה באימון</span></nav>
  <h1>מתודיקה באימון</h1>
  <p class="lead">איך מדריכים ומאמנים קבוצה: עקרונות, שיטות הדרכה, עמדת המדריך ותכנון האימון. לומדים פרק, ובסוף כל פרק עונים על בוחן קצר. ההתקדמות נשמרת בחשבון שלך.</p>
</header>
<nav class="rail" aria-label="פרקים"><div class="wrap" id="rail" role="tablist"></div></nav>
<main class="wrap" id="main"></main>
<footer class="wrap foot">מבוסס על המצגת "מתודיקה באימון: עקרונות במתודיקה של אימון קבוצה".<br>המצגות מבוססות על תוכן של המכללה האקדמית לוינסקי-וינגייט.</footer>
<div class="tip" id="tip" role="tooltip"></div>

<script>
const L=t=>`<span class="lat">${t}</span>`;
const chart=(svg,c,leg)=>`<figure class="fig"><div class="dplate">${leg||""}${svg}</div><figcaption>${c}</figcaption></figure>`;

/* ---------- diagram: instructor position (שר״ש) ---------- */
function chSun(){
  let s=`<svg class="ch" viewBox="0 0 620 250" role="img" aria-label="עמדת המדריך: השמש מאחורי המתאמנים">`;
  s+=`<defs><marker id="arS" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="7" markerHeight="7" orient="auto"><path d="M0 0 L10 5 L0 10 Z" fill="var(--muted)"/></marker></defs>`;
  /* sun */
  s+=`<g style="stroke:#E0A21B;stroke-width:3;stroke-linecap:round">${[0,45,90,135,180,225,270,315].map(a=>{const r=a*Math.PI/180;return `<line x1="${60+Math.cos(r)*30}" y1="${110+Math.sin(r)*30}" x2="${60+Math.cos(r)*42}" y2="${110+Math.sin(r)*42}"/>`}).join("")}</g>`;
  s+=`<circle cx="60" cy="110" r="22" fill="#F5C242"/><text class="lb" x="60" y="180" text-anchor="middle">שמש</text>`;
  /* group in an arc, facing the instructor */
  [[200,40],[225,75],[238,110],[225,145],[200,180]].forEach(([x,y])=>{s+=`<circle cx="${x}" cy="${y}" r="13" class="f2"/>`});
  s+=`<text class="lb t2" x="215" y="228" text-anchor="middle">מתאמנים</text>`;
  /* instructor */
  s+=`<circle cx="480" cy="110" r="17" class="f1"/><text class="lb t1" x="480" y="160" text-anchor="middle">מדריך</text>`;
  s+=`<line x1="262" y1="96" x2="452" y2="96" class="ln" style="stroke:var(--muted);stroke-width:2" marker-end="url(#arS)"/><text class="sm" x="357" y="86" text-anchor="middle">המתאמנים מסתכלים על המדריך</text>`;
  s+=`<line x1="458" y1="126" x2="268" y2="126" class="ln dash" style="stroke:var(--muted);stroke-width:2" marker-end="url(#arS)"/><text class="sm" x="363" y="148" text-anchor="middle">המדריך מסתכל לכיוון השמש</text>`;
  return s+`</svg>`;
}

const chapters=[
{id:"intro",short:"1. מהי מתודיקה",title:"מהי מתודיקה?",sub:"ההגדרה, והמטלות שהמדריך מתמודד איתן כשהוא מתכנן אימון",
html:()=>`
<div class="block"><h3>ההגדרה</h3>
<p>המילה באה מיוונית עתיקה, ופירושה <b>"הדרך להגיע למטרה"</b>.</p>
<p>מתודיקה היא שיטה להעביר מסרים ומידע, כך שהמתאמן גם <b>יודע יותר</b>, וגם <b>מעורב יותר ומשתף פעולה</b>. המעורבות הזו היא מה שעוזר לו להפנים את מה שלמד.</p>
<div class="formula">מתודיקה עונה על השאלה: <b>איך</b> להדריך ולאמן?</div></div>
<div class="trick"><b class="tag">טריק לזכירה</b><b>תורת האימון = "מה", מתודיקה = "איך".</b> תורת האימון אומרת שצריך אינטרוולים בזון 4. המתודיקה אומרת איך מסבירים, מדגימים, מארגנים את הקבוצה ומתקנים טעויות, כדי שהאימון באמת יקרה.</div>

<div class="block"><h3>9 המטלות של המדריך</h3>
<p>בתכנון האימון, המתודיקה מתבטאת בדרך שבה המדריך מתמודד עם המטלות האלה:</p>
<div class="grid2">
<div class="mini"><div class="k">1. דרך ההוראה</div>איך מלמדים את המטלה.</div>
<div class="mini"><div class="k">2. שלבי ההוראה</div>באיזה סדר מלמדים ומדריכים.</div>
<div class="mini"><div class="k">3. לוח זמנים</div>כמה זמן ללמד, לתרגל ולאמן כל תרגיל, וכמה זמן לאימון כולו.</div>
<div class="mini"><div class="k">4. טעויות טכניקה</div>קובעים סדר עדיפויות, ומתקנים.</div>
<div class="mini"><div class="k">5. ארגון יחידת האימון</div>איך בנוי האימון עצמו.</div>
<div class="mini"><div class="k">6. תפעול הקבוצה</div>איך מנהלים את המתאמנים בשטח.</div>
<div class="mini"><div class="k">7. אמצעי עזר</div>אילו לבחור, ואיך להשתמש בהם.</div>
<div class="mini"><div class="k">8. עמדת המדריך</div>איפה המדריך עומד בכל שלב.</div>
<div class="mini"><div class="k">9. משוב ובקרה</div>תשומת לב לכל מתאמן, ובקרה על האימון.</div>
</div></div>
<div class="block"><h3>דוגמה מהמצגת: 3 × 30 מ׳ עקבים לישבן</h3>
<p>נשמע פשוט, אבל המתודיקה שואלת: כמה זמן ייקח להסביר ולהדגים? איפה הקבוצה עומדת? מי מתחיל, ואיך חוזרים לנקודת ההתחלה? מה הטעות הכי חשובה לתקן קודם? <b>כל תרגיל קטן דורש תכנון של הזמן והארגון</b>, לא רק של התוכן.</p></div>
`,
quiz:[
["מה פירוש המילה \"מתודיקה\"?",["תורת השרירים","הדרך להגיע למטרה","אימון קבוצתי","מדידת מאמץ"],1,"מיוונית עתיקה."],
["על איזו שאלה עונה המתודיקה?",["מה לאמן","איך להדריך ולאמן","כמה לאמן","למה להתאמן"],1,"תורת האימון עונה על \"מה\", המתודיקה על \"איך\"."],
["מה עוזר למתאמן להפנים את מה שלמד, לפי ההגדרה?",["עונשים","מעורבות ושיתוף פעולה שלו","הרצאה ארוכה","אימון בלי הסבר"],1,"המתודיקה מעשירה את הידע ומגדילה את המעורבות."],
["מה מהבאים הוא אחת המטלות של המדריך בתכנון?",["קביעת סדר עדיפויות לתיקון טעויות טכניקה","בחירת צבע החולצה של המתאמנים","חישוב הצח״מ של כל מתאמן","קביעת מחיר המנוי"],0,"עוד מטלות: דרך ההוראה, לוח זמנים, אמצעי עזר, עמדת המדריך ועוד."],
["מה מלמדת הדוגמה \"3 × 30 מ׳ עקבים לישבן\"?",["שזה תרגיל מסוכן","שגם תרגיל קצר דורש תכנון של זמן וארגון","שצריך 30 חזרות","שאין צורך בהדגמה"],1,"כמה זמן להסביר, להדגים ולבצע, ואיך הקבוצה זזה."]
]},

{id:"principles",short:"2. עקרונות ושלבים",title:"עקרונות דידקטיים ושלבי הלמידה",sub:"5 העקרונות, שלבי ההסבר-תרגול-אימון, והשלבים המתודיים",
html:()=>`
<div class="block"><h3>5 העקרונות הדידקטיים</h3>
<p>חמישה עקרונות שעוזרים למדריך להוציא לפועל שיעור או אימון בודד:</p>
<div class="zl">
<div class="zr" style="--c:var(--d1)"><div class="zn">1</div><div class="zt"><b>פעלתנות</b><div class="zd">"מדריך ← מתאמן ← מדריך": הוראה, ביצוע, משוב. המתאמן עושה, לא רק מקשיב.</div></div></div>
<div class="zr" style="--c:var(--d2)"><div class="zn">2</div><div class="zt"><b>העדפת הדגמה</b><div class="zd">מציגים את מה שלומדים בהדגמה או בסרטון. "תמונה אחת שווה אלף מילים".</div></div></div>
<div class="zr" style="--c:var(--d3)"><div class="zn">3</div><div class="zt"><b>פשטות ופרטנות</b><div class="zd">מתאימים את הדרישות לרמה של המתאמנים.</div></div></div>
<div class="zr" style="--c:var(--d4)"><div class="zn">4</div><div class="zt"><b>רצף</b><div class="zd">בתהליך הלמידה, ההדרכה והאימון: שיטתיות ועקביות.</div></div></div>
<div class="zr" style="--c:var(--boneInk)"><div class="zn">5</div><div class="zt"><b>עלייה מתמדת והדרגתית</b><div class="zd">בדרישות הלימודיות וברמת האימון.</div></div></div>
</div></div>
<div class="trick"><b class="tag">טריק לזכירה</b><b>"עושים, רואים, פשוט, ברצף, ועולים":</b> פעלתנות, הדגמה, פשטות, רצף, עלייה הדרגתית. זה בדיוק הסדר שבו מדריכים טוב: המתאמן פעיל, רואה, מקבל משימה ברמה שלו, באימונים שממשיכים זה את זה, ובקושי שעולה לאט.</div>

<div class="block"><h3>מהסבר לאימון: 3 שלבים</h3>
<div class="chain"><span class="n">הסבר פשוט</span><span class="ar">←</span><span class="n cool">שלב התרגול</span><span class="ar">←</span><span class="n hot">שלב האימון</span></div>
<ul>
<li><b>הסבר פשוט:</b> בודקים שהמתאמן הבין בעזרת <b>שאלות מנחות</b>.</li>
<li><b>תרגול:</b> חוזרים על מה שנלמד בתנאים <b>"מקלים"</b>, עם אמצעי עזר.</li>
<li><b>אימון:</b> חוזרים על התנועות בתנאים ש<b>הולכים ונעשים קשים</b>.</li>
</ul></div>
<div class="trick"><b class="tag">טריק לזכירה</b>כמו ללמוד לנהוג: קודם מסבירים איפה הבלם (הסבר), אחר כך נוסעים במגרש חניה ריק (תרגול), ורק אז יוצאים לכביש (אימון).</div>
<div class="block"><h3>4 עקרונות הלמידה</h3>
<ul>
<li>הלמידה מתקיימת <b>תוך כדי עשייה</b>, ותוך <b>ידיעת התוצאה</b> (משוב).</li>
<li>יוצרים <b>מבנה הגיוני</b> בשלבי הלמידה.</li>
<li>דואגים ל<b>ערנות, מוטיבציה והנאה</b>.</li>
<li><b>תקשורת דו-סטרית</b>, כולל דיבור פנימי של המתאמן.</li>
</ul></div>

<div class="block"><h3>השלבים המתודיים</h3>
<div class="grid2">
<div class="mini"><div class="k">מהקל לכבד</div>קודם בלי עומס, אחר כך עם.</div>
<div class="mini"><div class="k">מהפשוט למורכב</div>קודם חלק אחד, אחר כך שילוב.</div>
<div class="mini"><div class="k">מהידוע לבלתי ידוע</div>בונים על מה שהמתאמן כבר מכיר.</div>
</div>
<p style="margin-top:8px">דוגמה מתרגילי הריצה: מסקיפינג נמוך לסקיפינג גבוה, ומתרגיל בודד לתרגיל שממשיך לריצה (ראו <a href="/branch/training/" style="color:var(--accent)">תורת האימון</a>, פרק 10).</p></div>
<div class="block"><h3>התפתחות הסגנון: 3 שלבים בטכניקה</h3>
<div class="ladder">
<div class="lv" style="--w:60%"><b>1. השלב ה"גס"</b><span>התנועה נכונה בגדול, עם הרבה טעויות</span></div>
<div class="lv" style="--w:80%"><b>2. השלב ה"נקי"</b><span>פחות טעויות, התנועה יציבה יותר</span></div>
<div class="lv" style="--w:100%"><b>3. השלב ה"מושלם"</b><span>ביצוע מדויק ואוטומטי</span></div>
</div></div>
`,
quiz:[
["מה אומר עיקרון הפעלתנות?",["המדריך מדבר והמתאמנים מקשיבים","מדריך ← מתאמן ← מדריך: הוראה, ביצוע, משוב","המתאמן מתאמן לבד","רק המדריך מדגים"],1,"המתאמן פעיל בתהליך."],
["איזה עיקרון מתאים ל\"תמונה אחת שווה אלף מילים\"?",["פשטות","רצף","העדפת הדגמה","עלייה הדרגתית"],2,"מציגים את הנלמד בהדגמה או בסרטון."],
["מה עיקרון הפשטות והפרטנות?",["כל המתאמנים מקבלים אותו אימון","התאמת דרישות האימון לרמת המתאמנים","להסביר כמה שפחות","לאמן רק אחד-על-אחד"],1,"פרטנות = התאמה לכל מתאמן."],
["מה מאפיין את שלב התרגול?",["תנאים קשים ותחרותיים","חזרה על הנלמד בתנאים מקלים, עם אמצעי עזר","הסבר ארוך","מבחן"],1,"בשלב האימון התנאים הולכים ונעשים קשים."],
["איך בודקים שההסבר הובן?",["שואלים \"הבנתם?\"","שאלות מנחות למתאמן","מבחן כתוב","לא בודקים"],1,"זה חלק מהשלב של ההסבר הפשוט."],
["מה <b>לא</b> אחד מהשלבים המתודיים?",["מהקל לכבד","מהפשוט למורכב","מהידוע לבלתי ידוע","מהמהיר לאיטי"],3,"השלבים: קל ← כבד, פשוט ← מורכב, ידוע ← לא ידוע."],
["מה הסדר של התפתחות הסגנון בטכניקה?",["נקי ← גס ← מושלם","גס ← נקי ← מושלם","מושלם ← נקי ← גס","גס ← מושלם ← נקי"],1,"מתנועה נכונה בגדול ועד ביצוע מדויק ואוטומטי."]
]},

{id:"methods",short:"3. שיטות הדרכה",title:"שיטות הדרכה",sub:"הדגמה, הדרכה מילולית והדרכה ידנית: מתי וגם איך",
html:()=>`
<div class="block"><h3>3 שיטות ההדרכה</h3>
<div class="grid2">
<div class="mini"><div class="k">הדגמה</div>המתאמנים <b>רואים</b>.</div>
<div class="mini"><div class="k">הדרכה מילולית</div>המתאמנים <b>שומעים</b>.</div>
<div class="mini"><div class="k">הדרכה ידנית</div>המתאמנים <b>מרגישים</b> את התנועה.</div>
</div></div>
<div class="trick"><b class="tag">טריק לזכירה</b><b>עיניים, אוזניים, ידיים.</b> שלוש דרכים להכניס תנועה לראש של מתאמן.</div>

<div class="block" style="border-top:5px solid var(--d2)"><h3>1. הדגמה</h3>
<ul>
<li>מדגים <b>המדריך</b>, או <b>מתאמן</b> שהוכן לכך מראש, ומדגישים נקודות מנחות.</li>
<li>מדגימים במקום ובאופן שכל המתאמנים <b>רואים טוב</b> (למשל לאורך שורת המתאמנים).</li>
<li>מומלץ <b>2 הדגמות</b>. לפני השנייה מכוונים את תשומת הלב לנקודות הקריטיות בביצוע.</li>
</ul></div>
<div class="block" style="border-top:5px solid var(--d3)"><h3>2. הדרכה מילולית</h3>
<ul>
<li>הסבר דינמי, עם <b>חיקויים ודימויים</b> שעוזרים להבין.</li>
<li>רמת הפירוט לפי מה שצריך להבין ולפי רמת החניכים.</li>
<li>משתמשים ב<b>גווני קול</b> (אינטונציה) כדי להמחיש, להדגיש את העיקר ולשמור על ריכוז.</li>
<li><b>לא מדברים ומדגימים בו זמנית</b>: קודם אחד, אחר כך השני.</li>
<li>הסבר <b>קצר וממצה</b>.</li>
</ul></div>
<div class="block warn"><h3>חשוב: לא לדבר תוך כדי הדגמה</h3>
<p>כשהמדריך מדבר ומדגים באותו זמן, המתאמנים צריכים לבחור: להקשיב או להסתכל. לכן מסבירים, ואז מדגימים (או להפך).</p></div>
<div class="block" style="border-top:5px solid var(--d1)"><h3>3. הדרכה ידנית</h3>
<ul>
<li>המדריך <b>מוביל ביד</b> את התנועה של הלומד, או עוזר לו במגע (אחיזה בידיים, ברגליים וכו׳), כדי שיבין את התנועה.</li>
<li><b>שמירה</b> בביצוע מסוכן, או כשיש סכנה לאבד שיווי משקל.</li>
<li><b>תמיד</b> מתאמים ציפיות מראש ו<b>מבקשים רשות</b>.</li>
<li>לוקחים בחשבון <b>היבטים חברתיים ותרבותיים</b> של מגע.</li>
</ul></div>
`,
quiz:[
["מהן 3 שיטות ההדרכה?",["הרצאה, מבחן, משוב","הדגמה, הדרכה מילולית, הדרכה ידנית","וידאו, ספר, אתר","ריצה, הליכה, מתיחות"],1,"עיניים, אוזניים, ידיים."],
["כמה הדגמות מומלץ לבצע?",["אחת","שתיים, ולפני השנייה ממקדים בנקודות הקריטיות","חמש","אין צורך בהדגמה"],1,"ההדגמה השנייה ממוקדת."],
["מי יכול להדגים?",["רק המדריך","המדריך, או מתאמן שהוכן לכך","רק מתאמן מתחיל","רק סרטון"],1,"עם הדגשת נקודות מנחות."],
["מה נכון לגבי הדרכה מילולית והדגמה?",["עדיף לעשות את שתיהן בו זמנית","לא לשלב במקביל, אלא אחת אחרי השנייה","הדגמה מיותרת אם ההסבר טוב","הסבר ארוך עדיף"],1,"כך המתאמנים לא צריכים לבחור בין להקשיב להסתכל."],
["מה חובה לפני הדרכה ידנית?",["כלום","תיאום ציפיות ובקשת רשות","לבקש מהמתאמן לעצום עיניים","לחכות לסוף האימון"],1,"ולהתחשב בהיבטים חברתיים ותרבותיים של מגע."],
["מתי משתמשים בהדרכה ידנית לשמירה?",["בכל תרגיל","בביצוע מסוכן או כשיש סכנה לאבד שיווי משקל","רק בתחרות","רק בחימום"],1,"השמירה היא חלק מההדרכה הידנית."]
]},

{id:"coach",short:"4. המדריך מול הקבוצה",title:"המדריך מול הקבוצה",sub:"עמדת המדריך (עקרון שר״ש), מסירת מידע ותפקוד המאמן",
html:()=>`
<div class="block"><h3>עמדת המדריך: עקרון שר״ש</h3>
<div class="grid2">
<div class="mini"><div class="k">ש · שמיעה</div>עומדים במרחק שבו כל המתאמנים שומעים.</div>
<div class="mini"><div class="k">ר · ראייה</div>עומדים במקום שכל המתאמנים רואים.</div>
<div class="mini"><div class="k">ש · שמש</div>מעמידים את הקבוצה כך שהמתאמנים <b>לא מסתנוורים</b> מהשמש.</div>
</div>
${chart(chSun(),"השמש מאחורי המתאמנים: הם רואים את המדריך בלי להסתנוור. המדריך הוא זה שמסתכל לכיוון השמש")}
<p style="margin-top:8px">ועוד שני דברים שקשורים לעמדה:</p>
<ul>
<li><b>הופעת המדריך:</b> ביגוד והתנהגות.</li>
<li><b>הנהגה:</b> ביטחון עצמי, דוגמה אישית, משמעת, וטיפול בהפרעות דיבור.</li>
</ul></div>
<div class="trick"><b class="tag">טריק לזכירה</b><b>שר״ש</b>: <b>ש</b>ומעים, <b>ר</b>ואים, <b>ש</b>מש בגב. אם אחד מהשלושה חסר, ההסבר הכי טוב לא יעבור.</div>

<div class="block"><h3>טכניקת מסירת המידע</h3>
<p>לא רק <b>מה</b> אומרים ומציגים, אלא גם <b>איך</b>: טון דיבור, קשר עין וכו׳.</p>
<div class="tbl"><table>
<tr><th></th><th>מה זה אומר בפועל</th></tr>
<tr><td><b>א. כניסה והופעה</b></td><td>מגיעים <b>5–10 דק׳ לפני</b> האימון, בהופעה ספורטיבית והולמת. בודקים שהציוד ואמצעי העזר תקינים, ושאין בעיית בטיחות.</td></tr>
<tr><td><b>ב. קול ודיבור</b></td><td>עוצמת הקול לפי גודל הקבוצה והסביבה. בלי מונוטוניות. הרמת קול פתאומית להדגשה, ודיבור שקט כדי למשוך תשומת לב.</td></tr>
<tr><td><b>ג. ניסוח ובקיאות</b></td><td>משפטים ברורים, ושליטה בחומר.</td></tr>
<tr><td><b>ד. תנועה ומיקום</b></td><td>איך ואיפה המדריך עומד וזז.</td></tr>
<tr><td><b>ה. קשר עין</b></td><td>ומסרים לא מילוליים.</td></tr>
</table></div></div>

<div class="block"><h3>5 נקודות לתפקוד המאמן</h3>
<div class="grid2">
<div class="mini"><div class="k">הופעה</div>ספורטיבית וייצוגית: לבוש, נעליים, מראה.</div>
<div class="mini"><div class="k">קול</div>מספיק חזק כדי שישמעו, בלי לצעוק. משנים אינטונציה כדי שלא ישתעממו.</div>
<div class="mini"><div class="k">שליטה בקבוצה</div>התנהגות, משמעת, הפרעות דיבור.</div>
<div class="mini"><div class="k">ניידות</div>לא עומדים במקום אחד. באימון זזים כדי לראות את המתאמנים מכמה זוויות.</div>
<div class="mini"><div class="k">התנהגות</div>יחס הולם למתאמנים, וקשב מלא לאימון: לא לטלפון, ולא לשיחות צד.</div>
</div></div>
`,
quiz:[
["מה ראשי התיבות של עקרון שר״ש?",["שיטה, רצף, שליטה","שמיעה, ראייה, שמש","שרירים, ריצה, שיווי משקל","שאלה, רעיון, שיחה"],1,"איפה המדריך עומד מול הקבוצה."],
["לאיזה כיוון צריכים להסתכל המתאמנים ביחס לשמש?",["ישר אל השמש","כך שהשמש מאחוריהם והם לא מסתנוורים","זה לא משנה","רק בצל"],1,"המדריך הוא זה שמסתכל לכיוון השמש."],
["כמה זמן לפני האימון כדאי שהמדריך יגיע?",["בדיוק בזמן","לפחות 5–10 דק׳ לפני","שעה לפני","אחרי שכולם הגיעו"],1,"כדי לבדוק ציוד ובטיחות."],
["איך משתמשים בקול כדי למשוך תשומת לב?",["צועקים כל הזמן","מדברים בשקט","מדברים מהר","לא מדברים בכלל"],1,"והרמת קול פתאומית משמשת להדגשה."],
["למה המדריך צריך לזוז במהלך האימון?",["כדי להתחמם","כדי למנוע שעמום ולראות את המתאמנים מכמה זוויות","כדי לרוץ עם המתאמנים","אין סיבה"],1,"זו נקודת הניידות."],
["מה מהבאים פוגע בתפקוד המאמן?",["קשר עין","שיחה בטלפון במהלך האימון","הופעה ספורטיבית","שינוי אינטונציה"],1,"קשב מלא לאימון הוא חלק מהתנהגות המאמן."]
]},

{id:"planning",short:"5. תכנון ובחינה",title:"תכנון האימון ובחינת מערך האימון",sub:"מה מכינים לפני, מה עושים תוך כדי, ואילו שאלות שואלים על כל מערך אימון",
html:()=>`
<div class="block"><h3>נקודות למתודיקת האימון</h3>
<ul>
<li><b>תכנון מוקדם:</b> מה אני רוצה להשיג באימון הזה?</li>
<li><b>ארגון הציוד והלומדים:</b>
<ul><li>מכינים את הציוד מראש.</li><li>מחלקים ואוספים ציוד תוך כדי האימון.</li><li>מתכננים מעברים בין חלקי האימון (למשל מהחלק הטכני לחלק הכושר).</li></ul></li>
<li><b>הדגמות וציוד המחשה:</b> המאמן מדגים, מתאמן מדגים, סרטונים, תמונות.</li>
<li><b>חלוקה לרמות:</b> מינון ותרגילים שמתאימים לכל רמה.</li>
<li><b>יחס אישי לכל מתאמן:</b> משוב על הביצוע, על ההשקעה ועל ההשתתפות.</li>
<li><b>יעילות האימון:</b> כמה אחוז מהתכנון בוצע, וכמה המתאמנים הבינו וביצעו.</li>
</ul></div>
<div class="trick"><b class="tag">טריק לזכירה</b><b>לפני, תוך כדי, אחרי:</b> לפני מתכננים ומכינים ציוד. תוך כדי מארגנים, מדגימים, מחלקים לרמות ונותנים משוב. אחרי בודקים כמה מהתכנון באמת קרה.</div>

<div class="block"><h3>8 שאלות לבחינת מערך האימון</h3>
<p>שאלות שבודקים לפני שמעבירים אימון (וגם אחריו). סמנו לעצמכם, למשל על אימון שתכננתם:</p>
<div class="chk">
${["האם הוא מתאים לתקופת האימונים בעונה?","האם הוא מתאים לרמת המתאמנים?","האם הוא ממשיך את האימון הקודם? יש פרוגרסיה בין האימונים?","האם מודגשים בו תכנים לימודיים, טכניים או טקטיים?","האם יחס ההעמסה וההתאוששות בתוך האימון נכון?","האם יחס ההעמסה וההתאוששות בינו לבין האימון הקודם נכון?","האם התוכן מתאים ללוח הזמנים של האימון?","האם התוכן מתאים לרמת המתאמנים?"].map((q,i)=>`<label><input type="checkbox"><span>${i+1}. ${q}</span></label>`).join("")}
</div>
<p style="margin-top:8px;font-size:14.5px;color:var(--muted)">הסימונים לא נשמרים: זה כלי עזר לבדיקה מהירה.</p></div>
<div class="trick"><b class="tag">טריק לזכירה</b>4 שאלות על <b>ההקשר</b> (עונה, רמה, אימון קודם, מה מדגישים), ו-4 על <b>המינון</b> (עומס בתוך האימון, עומס מול האימון הקודם, זמן, רמה). את העקרונות עצמם, כמו פרוגרסיה ועומס והתאוששות, למדנו ב<a href="/branch/training/" style="color:var(--accent)">תורת האימון</a>.</div>
<div class="block"><h3>לקריאת העשרה</h3>
<p><a href="http://yedion.wincol.ac.il/books/izqc/#p=14" target="_blank" rel="noopener" style="color:var(--accent)">ידיעון המכללה</a>, עמודים 10–13.</p></div>

<h3 style="margin-top:14px">כרטיסיות לשינון: כל המושגים</h3>
<div class="fc-bar"><button class="btn" id="fcPrev">הקודם</button><button class="btn primary" id="fcNext">הבא</button><button class="btn" id="fcShuf">ערבב</button><span class="count" id="fcCount"></span></div>
<div class="card" id="fcCard" tabindex="0" role="button" aria-label="הפוך כרטיסייה"></div>
`,
quiz:[
["מה השאלה הראשונה בתכנון מוקדם של אימון?",["כמה מתאמנים יגיעו?","מה אני רוצה להשיג באימון?","מה מזג האוויר?","כמה זמן נשאר עד התחרות?"],1,"המטרה קודמת לכל השאר."],
["מה כולל ארגון הציוד והלומדים?",["רק להביא ציוד","הכנה מראש, חלוקה ואיסוף תוך כדי, ותכנון המעברים בין חלקי האימון","להשאיר את הציוד למתאמנים","לא להשתמש בציוד"],1,"למשל מעבר מהחלק הטכני לחלק הכושר."],
["איך מתאימים אימון לקבוצה מעורבת?",["כולם עושים אותו דבר","חלוקה לרמות, עם מינון ותרגילים לכל רמה","רק החזקים מתאמנים","מוותרים על החלשים"],1,"זה גם עיקרון הפשטות והפרטנות."],
["איך מודדים את יעילות האימון?",["לפי הזיעה","אחוז הביצוע מתוך התכנון, וכמה המתאמנים הבינו וביצעו","לפי אורך האימון","לפי מספר התרגילים"],1,"בודקים אחרי האימון."],
["מה מהבאים הוא שאלה לבחינת מערך האימון?",["האם יש פרוגרסיה בין האימון הזה לקודם?","האם המאמן נהנה?","כמה עלו הנעליים?","מי הגיע ראשון?"],0,"וגם: התאמה לתקופה, לרמה, ללוח הזמנים, ויחס עומס-התאוששות."],
["על מה מקבל המתאמן משוב, לפי המצגת?",["רק על התוצאה","על הביצוע, על ההשקעה ועל ההשתתפות","רק על האיחורים","לא נותנים משוב"],1,"יחס אישי לכל אחד מהמתאמנים."]
]}
];

const cards=[
["מתודיקה","\"הדרך להגיע למטרה\". עונה על השאלה איך להדריך ולאמן (תורת האימון עונה על \"מה\")."],
["9 המטלות של המדריך","דרך הוראה, שלבי הוראה, לוח זמנים, טיפול בטעויות, ארגון יחידת האימון, תפעול הקבוצה, אמצעי עזר, עמדת המדריך, משוב ובקרה."],
["5 העקרונות הדידקטיים","פעלתנות, העדפת הדגמה, פשטות ופרטנות, רצף, עלייה מתמדת והדרגתית."],
["עיקרון הפעלתנות","מדריך ← מתאמן ← מדריך: הוראה, ביצוע, משוב."],
["הסבר ← תרגול ← אימון","הסבר פשוט עם שאלות מנחות, תרגול בתנאים מקלים, אימון בתנאים שהולכים ונעשים קשים."],
["4 עקרונות הלמידה","עשייה וידיעת התוצאה, מבנה הגיוני, ערנות-מוטיבציה-הנאה, תקשורת דו-סטרית."],
["השלבים המתודיים","מהקל לכבד, מהפשוט למורכב, מהידוע לבלתי ידוע."],
["התפתחות הסגנון","גס ← נקי ← מושלם."],
["3 שיטות הדרכה","הדגמה (רואים), מילולית (שומעים), ידנית (מרגישים)."],
["הדגמה","מדריך או מתאמן שהוכן. כולם רואים. 2 הדגמות, השנייה ממוקדת."],
["הדרכה מילולית","קצרה וממצה, עם דימויים וגווני קול. לא במקביל להדגמה."],
["הדרכה ידנית","הובלת התנועה או שמירה. תמיד לבקש רשות ולהתחשב בתרבות."],
["שר״ש","שמיעה, ראייה, שמש (המתאמנים לא מסתנוורים)."],
["מסירת מידע: א–ה","כניסה והופעה (5–10 דק׳ לפני), קול ודיבור, ניסוח ובקיאות, תנועה ומיקום, קשר עין."],
["תפקוד המאמן","הופעה, קול, שליטה בקבוצה, ניידות, התנהגות."],
["יעילות האימון","אחוז הביצוע מתוך התכנון, וכמה המתאמנים הבינו וביצעו."],
["בחינת מערך אימון","תקופה בעונה, רמה, פרוגרסיה, תכנים, עומס-התאוששות בתוך האימון ומול הקודם, לוח זמנים."]
];

/* ---------- app ---------- */
const store={get(k,d){try{const v=localStorage.getItem(k);return v==null?d:JSON.parse(v)}catch(e){return d}},set(k,v){try{localStorage.setItem(k,JSON.stringify(v))}catch(e){}}};
let cur=store.get("meth.cur","intro");
let done=store.get("meth.done",{});
if(!chapters.find(c=>c.id===cur))cur="intro";

function renderRail(){
  const r=document.getElementById("rail");
  r.innerHTML=chapters.map(c=>`<button role="tab" id="tab-${c.id}" aria-selected="${c.id===cur}" data-id="${c.id}"><span class="done ${done[c.id]?'on':''}" aria-hidden="true"></span>${c.short}</button>`).join("");
  r.querySelectorAll("button").forEach(b=>b.onclick=()=>go(b.dataset.id));
  const a=r.querySelector('[aria-selected="true"]');if(a&&a.scrollIntoView)a.scrollIntoView({block:"nearest",inline:"nearest"});
}
function go(id){cur=id;store.set("meth.cur",cur);render();window.scrollTo({top:0})}
function quizHTML(c){
  return `<section class="quiz" aria-label="בוחן"><div class="eyebrow">סוף הפרק</div><h2>בדוק את עצמך</h2>
  ${c.quiz.map((q,qi)=>{const ord=q[1].map((_,i)=>i).sort(()=>Math.random()-.5);return `<div class="qitem" data-q="${qi}"><div class="qt">${qi+1}. ${q[0]}</div><div class="opts">${ord.map(oi=>`<button class="opt" data-o="${oi}">${q[1][oi]}</button>`).join("")}</div><div class="expl" hidden></div></div>`}).join("")}
  <div class="score"><span id="scoreTxt">ענית על 0 מתוך ${c.quiz.length}</span><button class="btn" id="redo">התחל מחדש</button></div></section>`;
}
function wireQuiz(c){
  let answered=0,right=0;
  const upd=()=>{const t=document.getElementById("scoreTxt");
    t.textContent=answered<c.quiz.length?`ענית על ${answered} מתוך ${c.quiz.length}`:`סיימת: ${right} מתוך ${c.quiz.length} נכונות. ${right===c.quiz.length?"מצוין, הפרק בכיס!":right>=c.quiz.length*0.7?"כמעט! חזור על ההסברים של מה שפספסת.":"כדאי לקרוא שוב את הפרק ולנסות שוב."}`;
    if(answered===c.quiz.length&&right>=Math.ceil(c.quiz.length*0.7)){done[c.id]=true;store.set("meth.done",done);renderRail()}};
  document.querySelectorAll(".qitem").forEach(el=>{
    const q=c.quiz[+el.dataset.q];
    el.querySelectorAll(".opt").forEach(b=>b.onclick=()=>{
      const oi=+b.dataset.o;el.querySelectorAll(".opt").forEach(x=>x.disabled=true);
      el.querySelector(`[data-o="${q[2]}"]`).classList.add("right");
      if(oi!==q[2])b.classList.add("wrong");else right++;
      answered++;const ex=el.querySelector(".expl");ex.hidden=false;ex.innerHTML=(oi===q[2]?"<b>נכון.</b> ":"<b>לא בדיוק.</b> ")+q[3];fixBidi(ex);upd();
    });
  });
  document.getElementById("redo").onclick=()=>render();
}
/* flashcards */
let fcOrder=cards.map((_,i)=>i),fcI=0,fcFlip=false;
function fcRender(){
  const card=document.getElementById("fcCard");if(!card)return;
  const c=cards[fcOrder[fcI]];
  card.innerHTML=fcFlip?`<div class="a"><div><b>${c[0]}</b></div><div style="margin-top:6px">${c[1]}</div></div>`:`<div class="q">${c[0]}</div><div class="hint">מה זה? נסה להסביר לעצמך, ואז לחץ להפוך</div>`;
  document.getElementById("fcCount").textContent=`${fcI+1} / ${cards.length}`;
}
function wireCards(){
  fcI=0;fcFlip=false;fcRender();
  const card=document.getElementById("fcCard");
  card.onclick=()=>{fcFlip=!fcFlip;fcRender()};
  card.onkeydown=e=>{if(e.key==="Enter"||e.key===" "){e.preventDefault();fcFlip=!fcFlip;fcRender()}};
  document.getElementById("fcNext").onclick=()=>{fcI=(fcI+1)%cards.length;fcFlip=false;fcRender()};
  document.getElementById("fcPrev").onclick=()=>{fcI=(fcI-1+cards.length)%cards.length;fcFlip=false;fcRender()};
  document.getElementById("fcShuf").onclick=()=>{fcOrder.sort(()=>Math.random()-.5);fcI=0;fcFlip=false;fcRender()};
}
/* chart hover */
function wireTips(){
  const tip=document.getElementById("tip");
  document.querySelectorAll("[data-tip]").forEach(g=>{
    const show=e=>{tip.textContent=g.dataset.tip;tip.style.opacity=1;const p=e.touches?e.touches[0]:e;tip.style.left=Math.min(p.clientX+12,innerWidth-250)+"px";tip.style.top=(p.clientY-40)+"px"};
    g.addEventListener("mousemove",show);g.addEventListener("mouseleave",()=>tip.style.opacity=0);
    g.addEventListener("touchstart",show,{passive:true});g.addEventListener("touchend",()=>setTimeout(()=>tip.style.opacity=0,1500));
  });
}
function fixBidi(root){
  const re=/\d[\d.,]*%?(?:\s*[–−+×÷=]\s*\d[\d.,]*%?)+/g;
  const w=document.createTreeWalker(root,NodeFilter.SHOW_TEXT,{acceptNode:n=>n.parentElement.closest("svg,.lat,.en,.m,script")?NodeFilter.FILTER_REJECT:(re.test(n.nodeValue)?(re.lastIndex=0,NodeFilter.FILTER_ACCEPT):NodeFilter.FILTER_SKIP)});
  const ns=[];while(w.nextNode())ns.push(w.currentNode);
  ns.forEach(n=>{const f=document.createDocumentFragment();let last=0,t=n.nodeValue;t.replace(re,(m,i)=>{f.append(t.slice(last,i));const sp=document.createElement("span");sp.className="m";sp.dir="ltr";sp.textContent=m;f.append(sp);last=i+m.length});f.append(t.slice(last));n.replaceWith(f)});
}
function render(){
  renderRail();
  const c=chapters.find(x=>x.id===cur),idx=chapters.indexOf(c),next=chapters[idx+1];
  document.getElementById("main").innerHTML=`<div class="chap-head"><div class="eyebrow">פרק ${idx+1} מתוך ${chapters.length}</div><h2>${c.title}</h2><p class="lead" style="margin:0">${c.sub}</p></div>
  <div class="stack">${c.html()}</div>${quizHTML(c)}
  ${next?`<div style="margin-top:18px"><button class="btn primary" id="nextChap">לפרק הבא: ${next.title}</button></div>`:""}`;
  if(document.getElementById("fcCard"))wireCards();
  fixBidi(document.getElementById("main"));wireTips();wireQuiz(c);
  if(next)document.getElementById("nextChap").onclick=()=>go(next.id);
}
render();
</script>
</body></html>
