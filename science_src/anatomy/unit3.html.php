<?php http_response_code(404); exit; /* מוגש רק דרך api/science_gate.php */ ?>
<!doctype html>
<html lang="he" dir="rtl"><head><meta charset="utf-8"><link rel="icon" href="/favicon.svg?v=2" type="image/svg+xml"><meta name="robots" content="noindex, nofollow, noarchive, nosnippet, noimageindex"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>יחידות 2–3 · אנטומיה · קורס מדעי · קורס מדריכי ריצות ארוכות</title>
<meta name="claude:viewport-fit-sides" content="cover">
<style>
/* Same field-guide notebook as "האנטומיה של הריצה": sticky chapter rail, one chapter at a time, quiz closes each chapter */
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
.dplate{background:var(--paper);border:1px solid var(--line);border-radius:8px;padding:10px;overflow-x:auto}
.dg{display:block;width:100%;height:auto;max-width:560px;min-width:300px;margin:0 auto;direction:ltr}
.dg .b{fill:var(--boneFill);stroke:var(--ink);stroke-width:2;stroke-linejoin:round}
.dg .c1,.dg .f1{fill:color-mix(in srgb,var(--d1) 32%,var(--boneFill))}
.dg .c2,.dg .f2{fill:color-mix(in srgb,var(--d2) 32%,var(--boneFill))}
.dg .c3,.dg .f3{fill:color-mix(in srgb,var(--d3) 32%,var(--boneFill))}
.dg .t{fill:var(--ink);font:700 15px var(--body)}
.dg text{direction:rtl}
.dg .s{fill:var(--muted);font:italic 500 12.5px var(--latin);direction:ltr}
.dg .m{fill:var(--muted);font:500 13.5px var(--body)}
.dg .k1{fill:var(--d1)}.dg .k2{fill:var(--d2)}.dg .k3{fill:var(--d3)}.dg .k4{fill:var(--d4)}
.dg .ld{stroke:var(--muted);stroke-width:1.2;fill:none}
.dg .spbg{fill:var(--spongy)}.dg .spdot{fill:var(--spongyDot)}
.dg .marrow{fill:var(--marrow)}
.dg .cartS{stroke:var(--cart);stroke-width:8;fill:none;stroke-linecap:round}
.dg .cartF{fill:var(--cart);stroke:var(--ink);stroke-width:1.2}
.dg .hole{fill:var(--paper);stroke:var(--ink);stroke-width:1.5}
.dg .sock{fill:color-mix(in srgb,var(--ink) 16%,transparent);stroke:var(--ink);stroke-width:1.5;stroke-dasharray:4 3}
.dg .zone1{fill:color-mix(in srgb,var(--d1) 10%,transparent);stroke:var(--d1);stroke-dasharray:6 4}
.dg .zone2{fill:color-mix(in srgb,var(--d2) 10%,transparent);stroke:var(--d2);stroke-dasharray:6 4}
.dg .zz{stroke:var(--ink);stroke-width:2}
.dg .caps{fill:none;stroke:var(--accent);stroke-width:2;stroke-dasharray:6 4}
.dg .lig{stroke-width:6;stroke-linecap:round;fill:none}
.dg .l1{stroke:var(--d1)}.dg .l2{stroke:var(--d2)}.dg .l3{stroke:var(--d3)}.dg .l4{stroke:var(--d4)}
.dg .pl{stroke-width:4;stroke-dasharray:8 5;fill:none}
.dg .men{fill:none;stroke:var(--cart);stroke-width:18;stroke-linecap:round}
.dg .arr{fill:none;stroke:var(--accent);stroke-width:2.5}
.dg .arh{fill:var(--accent)}
.dg .lgF{fill:color-mix(in srgb,var(--d2) 40%,transparent);stroke:var(--d2);stroke-width:2}
.dg .pers{fill:var(--boneFill);stroke:var(--ink);stroke-width:2}
.dg .limb{stroke:var(--ink);stroke-width:5;stroke-linecap:round;fill:none}
.dg .bone2o{stroke:var(--ink);stroke-width:20;stroke-linecap:round}
.dg .bone2{stroke:var(--boneFill);stroke-width:16;stroke-linecap:round}
.dg .mu1{fill:color-mix(in srgb,var(--d1) 65%,transparent);stroke:var(--d1);stroke-width:1.5}
.dg .mu2{fill:color-mix(in srgb,var(--d2) 65%,transparent);stroke:var(--d2);stroke-width:1.5}
.dg .mu3{fill:color-mix(in srgb,var(--d3) 65%,transparent);stroke:var(--d3);stroke-width:1.5}
.dg .ghost{fill:none;stroke:var(--muted);stroke-width:1.5;stroke-dasharray:5 4}

.chain{flex-wrap:wrap}
.spine{display:flex;flex-direction:column;gap:3px;max-width:520px;margin:0 auto;height:420px}
.sp{display:grid;grid-template-columns:48px 1fr;border-radius:8px;overflow:hidden;border:1px solid var(--line);background:color-mix(in srgb,var(--c) 10%,var(--paper));min-height:40px}
.spn{background:var(--c);color:#fff;font:700 20px var(--display);display:grid;place-items:center}
.spt{padding:4px 10px;align-self:center;font-size:15px}.spc{color:var(--muted);font-size:13.5px}
.ribs{display:flex;gap:6px;margin-top:8px;flex-wrap:wrap}
.rib{min-width:150px;border:1px solid var(--line);border-top:6px solid var(--c);border-radius:8px;padding:8px 10px;background:var(--paper);display:flex;flex-direction:column;gap:3px;font-size:14.5px}
.rib .rn{font:700 20px var(--display);color:var(--c)}.rib span{color:var(--muted)}
.disc{display:flex;gap:18px;align-items:center;flex-wrap:wrap}
.disc .ring{width:150px;height:150px;border-radius:50%;flex:none;display:grid;place-items:center;background:repeating-radial-gradient(circle,var(--d2) 0 5px,color-mix(in srgb,var(--d2) 55%,var(--paper)) 5px 9px)}
.disc .core{width:72px;height:72px;border-radius:50%;background:var(--d4);color:#fff;display:grid;place-items:center;font-weight:700;box-shadow:0 0 0 4px var(--paper)}
.disc .dtxt{flex:1;min-width:220px}.disc .dtxt p{margin:0 0 8px}
.jgrid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:10px;margin-top:8px}
.jc{display:grid;grid-template-columns:44px 1fr;gap:10px;border:1px solid var(--line);border-radius:10px;padding:10px;background:var(--paper);font-size:14.5px}
.ji{font-size:28px;color:var(--accent);display:grid;place-items:center;background:var(--accent-soft);border-radius:8px;height:44px}
.jl{margin-top:3px}.jl span{color:var(--muted)}
.jfacts{display:grid;gap:6px;margin-top:8px}
.jfacts>div{display:grid;grid-template-columns:70px 1fr;gap:8px;font-size:15px}
.jfacts span{color:var(--muted);font-weight:600}
.unitTag{color:var(--accent)}
</style><script src="/theme.js?v=20261123f"></script><script src="/nav.js?v=20261123i" defer></script><script src="/sync.js?v=20261123f" defer></script><script src="/lightbox.js?v=20261123f" defer></script><link rel="preload" href="/fonts/Assistant-Variable.woff" as="font" type="font/woff" crossorigin><link rel="stylesheet" href="/design.css?v=5"></head><body>

<header class="top wrap"><nav class="sb" aria-label="ניווט באתר"><a class="home" href="/">קורס מדריכי ריצות ארוכות</a><span class="sep" aria-hidden="true">‹</span><a href="/science/">קורס מדעי</a><span class="sep" aria-hidden="true">‹</span><a href="/science/anatomy/">אנטומיה</a><span class="sep" aria-hidden="true">‹</span><span aria-current="page">יחידות 2–3</span></nav>
  <div class="eyebrow">אנטומיה · שיעור מיום <bdi>23/11/2026</bdi></div>
  <h1>יחידות 2–3: מערכת שלד-שריר ומפרקים</h1>
  <p class="lead">מבנה השלד, עמוד השדרה, סוגי מפרקים, מפרקי הגפיים, ומישורים ותנועות. כל החומר מהמצגות, בשפה פשוטה, עם בוחן בסוף כל פרק וכרטיסיות לשינון. ההתקדמות נשמרת בדפדפן, ואפשר לסנכרן אותה עם המייל.</p>
</header>
<nav class="rail" aria-label="פרקים"><div class="wrap" id="rail" role="tablist"></div></nav>
<main class="wrap" id="main"></main>
<footer class="wrap foot">מבוסס על המצגות של גל קני: "מבוא יחידה 3: מערכת שלד-שריר, מפרקים" (חלקים א ו-ב).<br>המצגות מבוססות על תוכן של המכללה האקדמית לוינסקי-וינגייט.</footer>
<div class="tip" id="tip" role="tooltip"></div>

<script>
const IMG={};
const fig=(k,c,h)=>`<figure class="fig"><div class="plate"><img src="${IMG[k]}" alt="${c}" style="max-height:${h||300}px"></div><figcaption>${c}</figcaption></figure>`;
const figs=(...a)=>`<div class="figrow">${a.join("")}</div>`;
const more=(label,...d)=>`<details class="more"><summary>${label}</summary><div>${d.join("")}</div></details>`;
const L=t=>`<span class="lat">${t}</span>`;
const chart=(svg,c,leg)=>`<figure class="fig"><div class="dplate">${leg||""}${svg}</div><figcaption>${c}</figcaption></figure>`;
const legend=items=>`<div class="legend">${items.map(([c,t])=>`<span><i style="background:var(${c})"></i>${t}</span>`).join("")}</div>`;

/* ---------- diagrams ---------- */
const PLANES_SVG=`<svg class="dg" viewBox="0 0 480 250" role="img" aria-label="שלושת מישורי התנועה">
<g transform="translate(80,110)"><circle cx="0" cy="-70" r="14" class="pers"/><rect x="-20" y="-52" width="40" height="66" rx="10" class="pers"/><path d="M -20 -44 L -34 8 M 20 -44 L 34 8 M -10 14 L -13 78 M 10 14 L 13 78" class="limb"/><path d="M 0 -96 L 0 92" class="pl l1"/></g>
<g transform="translate(240,110)"><circle cx="2" cy="-70" r="14" class="pers"/><path d="M 14 -72 L 20 -68 L 14 -64" class="limb" style="stroke-width:3"/><rect x="-12" y="-52" width="26" height="66" rx="10" class="pers"/><path d="M 0 -44 L 4 8 M -2 14 L -2 78 M 6 14 L 8 78" class="limb"/><path d="M 0 -96 L 0 92" class="pl l2"/></g>
<g transform="translate(400,110)"><circle cx="0" cy="-70" r="14" class="pers"/><rect x="-20" y="-52" width="40" height="66" rx="10" class="pers"/><path d="M -20 -44 L -34 8 M 20 -44 L 34 8 M -10 14 L -13 78 M 10 14 L 13 78" class="limb"/><path d="M -60 4 L 60 4" class="pl l3"/></g>
<text class="t k1" x="80" y="222" text-anchor="middle">חיצי</text><text class="m" x="80" y="242" text-anchor="middle">חותך לימין ושמאל</text>
<text class="t k2" x="240" y="222" text-anchor="middle">חזיתי</text><text class="m" x="240" y="242" text-anchor="middle">חותך לקדמי ואחורי</text>
<text class="t k3" x="400" y="222" text-anchor="middle">אופקי</text><text class="m" x="400" y="242" text-anchor="middle">חותך לעליון ותחתון</text>
<text class="m" x="80" y="12" text-anchor="middle">מבט מלפנים</text><text class="m" x="240" y="12" text-anchor="middle">מבט מהצד</text><text class="m" x="400" y="12" text-anchor="middle">מבט מלפנים</text>
</svg>`;
function spineBar(){
  const parts=[["צווארי","Cervical",7,"--d2","לורדוזה (קשת קדימה)"],["בית החזה","Thoracic",12,"--d1","קיפוזה (קשת אחורה)"],["מותני","Lumbar",5,"--d3","לורדוזה (קשת קדימה)"],["עצה","Sacrum",5,"--d4","מאוחות לעצם אחת"],["זנב","Coccyx",4,"--muted","מאוחות"]];
  return `<figure class="fig"><div class="dplate"><div class="spine">${parts.map(([h,l,n,c,cv])=>`<div class="sp" style="--c:var(${c});flex:${n}"><div class="spn">${n}</div><div class="spt"><b>${h}</b> ${L(l)}<div class="spc">${cv}</div></div></div>`).join("")}</div></div><figcaption>33 החוליות מלמעלה למטה. ככל שיורדים, החוליות גדולות יותר, כי הן נושאות יותר משקל.</figcaption></figure>`;
}
function ribsBar(){
  const g=[["1–7","צלעות אמיתיות","מחוברות ישירות לעצם החזה","--d3",7],["8–10","צלעות מדומות","מתחברות לעצם החזה דרך הסחוס של הצלע השביעית","--d2",3],["11–12","צלעות צפות","לא מתחברות לעצם החזה בכלל","--d1",2]];
  return `<div class="ribs">${g.map(([n,t,d,c,w])=>`<div class="rib" style="--c:var(${c});flex:${w}"><div class="rn">${n}</div><b>${t}</b><span>${d}</span></div>`).join("")}</div>`;
}
const JTYPES=[
 ["כדורי","Ball & socket","מכתש ועלי: ראש עגול בתוך שקע","לכל הכיוונים, וגם סיבוב על ציר העצם","ירך, כתף","◉"],
 ["ציר","Hinge","כמו ציר של דלת","כפיפה ופשיטה בלבד","מרפק, ברך","⊐"],
 ["אוכף","Saddle","שני אוכפים צמודים","כמעט כמו כדורי, אבל בלי סיבוב על הציר","בין האגודל לשורש כף היד","⌓"],
 ["אליפטי","Ellipsoid","דומה לכדורי, אבל מוגבל יותר","תנועה מוגבלת יותר מכדורי","בין חלקי האצבע (לפי המצגת)","⬭"],
 ["סיבובי","Pivot","שתי עצמות מקבילות, אחת סובבת סביב השנייה","סיבוב","באמה: החישור סובב סביב הגומד","↻"],
 ["החלקה","Plane","שני משטחים חלקים שמחליקים זה על זה","תנועה קטנה לכל כיוון","בין עצמות שורש כף היד","▭"]
];

/* ---------- content ---------- */
const chapters=[
{id:"skeleton",short:"3.1 מבנה השלד",unit:"יחידות 2–3: מערכת שלד-שריר ומפרקים",title:"מבנה השלד",sub:"שלד הציר ושלד הגפיים, וכל העצמות בפלג הגוף העליון והתחתון",
html:()=>`
<div class="block"><h3>🦴 סימולטור שלד</h3><p>רוצים לתרגל? ב<a href="/science/anatomy/skeleton.html" style="color:var(--accent);font-weight:700">סימולטור השלד</a> לוחצים על עצם ורואים את השם שלה, או בוחנים את עצמכם.</p></div>
<div class="block"><h3>שתי חלוקות</h3>
<div class="grid2">
<div class="mini"><div class="k">שלד הציר</div>גולגולת, עמוד שדרה, עצם החזה וצלעות.</div>
<div class="mini"><div class="k">שלד הגפיים</div>בריח, שכמה, אגן, ידיים ורגלים.</div>
</div></div>
<div class="trick"><b class="tag">טריק לזכירה</b>שלד הציר = <b>הגזע</b> של העץ, שלד הגפיים = <b>הענפים</b>. החגורות (כתפיים ואגן) הן המקום שבו הענפים מתחברים לגזע.</div>

<div class="grid2">
<div class="block" style="margin:0"><h3>פלג גוף עליון</h3>
<p><b>חגורת הכתפיים:</b></p>
<ul><li>שכמה ${L("Scapula")}</li><li>עצם הבריח ${L("Clavicle")}</li></ul>
<p style="margin-top:6px"><b>הגפה:</b></p>
<ul><li>זרוע ${L("Humerus")}</li><li>2 עצמות האמה: חישור ${L("Radius")} וגומד ${L("Ulna")}</li></ul>
<p style="margin-top:6px"><b>כף היד:</b></p>
<ul><li>8 עצמות שורש כף היד ${L("Carpals")}</li><li>5 עצמות המסרק ${L("Metacarpals")}</li><li>14 גלילי האצבעות ${L("Phalanges")}</li></ul></div>
<div class="block" style="margin:0"><h3>פלג גוף תחתון</h3>
<p><b>חגורת האגן</b> ${L("Pelvis")}</p>
<p style="margin-top:6px"><b>הגפה:</b></p>
<ul><li>ירך ${L("Femur")}</li><li>2 עצמות השוק: שוקה ${L("Tibia")} (גדולה) ושוקית ${L("Fibula")} (קטנה)</li><li>פיקה ${L("Patella")}</li></ul>
<p style="margin-top:6px"><b>כף הרגל:</b></p>
<ul><li>7 עצמות שורש כף הרגל ${L("Tarsals")}</li><li>5 עצמות המסרק ${L("Metatarsals")}</li><li>14 גלילי האצבעות ${L("Phalanges")}</li></ul></div>
</div>
<div class="trick"><b class="tag">טריק לזכירה</b>היד והרגל בנויות באותה תבנית: <b>שורש → מסרק (5) → אצבעות (14)</b>. ההבדל בשורש: <b>8 ביד, 7 ברגל</b>. ו"מטה" (Meta) = אחרי: המסרק בא <b>אחרי</b> השורש.</div>
<div class="block"><h3>חיבור לאנטומיה בקורס הענפי</h3><p>על העצמות של הרגל, האגן והקרסול, ואיך הן משתלבות בריצה, יש פירוט נוסף בפרקים "עצמות" ו"מפרקים" ב<a href="/branch/anatomy.html" style="color:var(--accent)">האנטומיה של הריצה</a>.</p></div>
`,
quiz:[
["מה שייך לשלד הציר?",["שכמה ובריח","גולגולת, עמוד שדרה, עצם החזה וצלעות","אגן ורגליים","זרוע ואמה"],1,"השאר שייכים לשלד הגפיים."],
["מהן שתי עצמות האמה?",["שוקה ושוקית","חישור (Radius) וגומד (Ulna)","זרוע ושכמה","ירך ופיקה"],1,"שוקה ושוקית הן עצמות השוק."],
["כמה עצמות שורש יש בכף היד?",["5","7","8","14"],2,"8 בכף היד, 7 בכף הרגל."],
["מה שמה הלטיני של עצם הבריח?",["Scapula","Clavicle","Humerus","Pelvis"],1,"Scapula = שכמה."],
["מה מרכיב את חגורת הכתפיים?",["שכמה ובריח","זרוע ואמה","צלעות ועצם החזה","אגן וירך"],0,"החגורה מחברת את הגפה לשלד הציר."],
["כמה גלילי אצבעות יש בכף רגל אחת?",["5","10","14","26"],2,"כמו ביד: 14."]
]},

{id:"spine",short:"3.2 עמוד השדרה",unit:"יחידות 2–3: מערכת שלד-שריר ומפרקים",title:"עמוד השדרה, הדיסק והצלעות",sub:"33 חוליות, הקשתות, החוליה והדיסק, פריצת דיסק, ושלושה סוגי צלעות",
html:()=>`
<div class="block"><h3>עמוד השדרה</h3>
<ul>
<li>מבנה <b>גמיש</b>, בזכות <b>33 חוליות</b> והדיסקים שביניהן.</li>
<li>יש לו קשתות בולטות ושקועות בצורת <b>S</b>.</li>
<li>החוליות <b>קטנות למעלה וגדולות למטה</b>.</li>
</ul>
${spineBar()}</div>
<div class="trick"><b class="tag">טריק לזכירה</b><b>7-12-5-5-4</b>: "ארוחת בוקר ב-7, צהריים ב-12, ערב ב-5". צוואר 7, חזה 12 (כמו 12 זוגות צלעות), מותן 5, עצה 5, זנב 4. ביחד 33.</div>

<div class="block"><h3>הקשתות</h3>
<div class="grid2">
<div class="mini"><div class="k">לורדוזה צווארית</div>הצוואר מתקמר <b>קדימה</b>.</div>
<div class="mini"><div class="k">קיפוזה של בית החזה</div>בית החזה מתקמר <b>אחורה</b>.</div>
<div class="mini"><div class="k">לורדוזה מותנית</div>הגב התחתון מתקמר שוב <b>קדימה</b>.</div>
</div>
<p style="margin-top:8px">צורת ה-S מאפשרת לעמוד השדרה לבלום זעזועים ולשמור על איזון, כמו קפיץ.</p></div>
<div class="trick"><b class="tag">טריק לזכירה</b><b>ק</b>יפוזה = <b>ק</b>מור כמו <b>ק</b>ונכייה (גב עגול אחורה). לורדוזה = ה"שקע" קדימה, בצוואר ובגב התחתון.</div>

<div class="block"><h3>החוליה ${L("Vertebra")}</h3>
<ul>
<li>בנויה מ<b>גוף החוליה</b> ומ<b>קשת החוליה</b>. בתוך הקשת עובר <b>חוט השדרה</b>.</li>
<li><b>גוף החוליה</b> הוא החלק הקדמי, והוא נושא את רוב המשקל.</li>
<li>ככל שיורדים, גופי החוליות <b>רחבים</b> יותר.</li>
<li>בין כל שני גופי חוליות יש <b>דיסק</b>.</li>
</ul></div>
<div class="block"><h3>הדיסק הבין-חולייתי ${L("Discus intervertebralis")}</h3>
<div class="disc" aria-label="מבנה הדיסק">
<div class="ring"><div class="core">גרעין</div></div>
<div class="dtxt">
<p><b>במרכז: הגרעין.</b> חומר ג׳לטיני וגמיש (<b>70% מים</b>), שבולם זעזועים. עם השנים הוא מאבד מהגמישות ומהעמידות ללחצים.</p>
<p><b>בהיקף: הטבעת.</b> סיבים טבעתיים רב-שכבתיים מ<b>קולגן</b>, שמחזקים את הדיסק ועמידים לכוחות מכיוונים שונים.</p>
</div></div></div>
<div class="block warn"><h3>בלט דיסק ופריצת דיסק</h3>
<p>כשהסיבים החיצוניים והקשיחים נחלשים או נקרעים, מחבלה או מבלאי:</p>
<ul>
<li>המעטפת נחלשת ← החומר הרך שבמרכז <b>בולט</b> החוצה: <b>בלט דיסק</b>.</li>
<li>המעטפת נקרעת ← החומר הרך <b>פורץ</b> החוצה: <b>פריצת דיסק</b> ${L("Spinal disc herniation")}.</li>
</ul></div>
<div class="trick"><b class="tag">טריק לזכירה</b>הדיסק הוא <b>סופגנייה</b>: הריבה (הגרעין) רכה, הבצק (הטבעת) מחזיק אותה. בצק חלש = הריבה בולטת. בצק קרוע = הריבה יוצאת.</div>

<div class="block"><h3>הצלעות ועצם החזה (סטרנום)</h3>
<p>12 זוגות צלעות, מסחוס רחב ועצם. מאחור כל צלע מתחברת לחוליה המתאימה בבית החזה (T1–T12). מקדימה:</p>
${ribsBar()}</div>
`,
quiz:[
["כמה חוליות יש בעמוד השדרה?",["24","26","33","12"],2,"7 + 12 + 5 + 5 + 4 = 33."],
["כמה חוליות יש באזור המותני?",["7","12","5","4"],2,"צוואר 7, חזה 12, מותן 5, עצה 5, זנב 4."],
["מה הקשת של בית החזה?",["לורדוזה","קיפוזה","סקוליוזה","אין קשת"],1,"קיפוזה אחורה; צוואר ומותן: לורדוזה קדימה."],
["איזה חלק בחוליה נושא את רוב המשקל?",["קשת החוליה","גוף החוליה","הדיסק","חוט השדרה"],1,"החלק הקדמי, והוא רחב יותר ככל שיורדים."],
["מה יש במרכז הדיסק?",["סיבי קולגן קשים","גרעין ג׳לטיני (70% מים) שבולם זעזועים","עצם ספוגית","שריר"],1,"והטבעת בהיקף בנויה מקולגן."],
["מה ההבדל בין בלט דיסק לפריצת דיסק?",["אין הבדל","בבלט המעטפת נחלשת והחומר בולט; בפריצה היא נקרעת והחומר יוצא","בבלט הדיסק נעלם","בפריצה הדיסק מתקשה"],1,"נחלשה = בלט, נקרעה = פריצה."],
["מהן הצלעות הצפות?",["1–7","8–10","11–12","כל הצלעות"],2,"הן לא מתחברות לעצם החזה."],
["איך מתחברות צלעות 8–10 לעצם החזה?",["ישירות","דרך הסחוס של הצלע השביעית","הן לא מתחברות","דרך עצם הבריח"],1,"ולכן הן נקראות צלעות מדומות."]
]},

{id:"jointtypes",short:"3.3 סוגי מפרקים",unit:"יחידות 2–3: מערכת שלד-שריר ומפרקים",title:"6 סוגי המפרקים",sub:"איך צורת המפרק קובעת לאן אפשר לזוז",
html:()=>`
<div class="block"><h3>הצורה קובעת את התנועה</h3>
<p>במפרקים הסינוביאליים, הצורה של קצות העצמות קובעת באילו כיוונים המפרק יכול לזוז:</p>
<div class="jgrid">${JTYPES.map(([n,l,sh,mv,ex,ic])=>`<div class="jc"><div class="ji" aria-hidden="true">${ic}</div><div><b>מפרק ${n}</b> ${L(l)}<div class="jl"><span>מבנה:</span> ${sh}</div><div class="jl"><span>תנועה:</span> ${mv}</div><div class="jl"><span>דוגמה:</span> ${ex}</div></div></div>`).join("")}</div></div>
<div class="trick"><b class="tag">טריק לזכירה</b>כל אחד הוא חפץ מוכר: <b>כדורי</b> = ג׳ויסטיק, <b>ציר</b> = דלת, <b>אוכף</b> = רוכב על סוס (קדימה-אחורה וצד-לצד, אבל לא מסתובב), <b>סיבובי</b> = ידית של דלת, <b>החלקה</b> = מגירה.</div>
<div class="block warn"><h3>שימו לב</h3>
<p>במצגת, המפרקים בין חלקי האצבע מופיעים כדוגמה ל<b>מפרק אליפטי</b>. בספרים רבים המפרקים בין גלילי האצבעות מסווגים כ<b>מפרקי ציר</b>, ומפרק שורש כף היד (בין החישור לשורש) הוא הדוגמה הקלאסית למפרק אליפטי. במבחן, כדאי ללכת לפי מה שהמרצה לימדה.</p></div>
`,
quiz:[
["איזה סוג מפרק הוא מפרק הירך?",["ציר","כדורי","החלקה","אוכף"],1,"שאלת חזרה מהמצגת. מכתש ועלי, תנועה לכל הכיוונים."],
["איזה סוג מפרק הוא מפרק המרפק?",["ציר","כדורי","החלקה","אוכף"],0,"שאלת חזרה מהמצגת. כפיפה ופשיטה, כמו דלת."],
["מה מאפשר מפרק אוכף, שמפרק כדורי מאפשר וגם הוא?",["רק כפיפה","תנועה כמעט חופשית, אבל בלי סיבוב על הציר","רק סיבוב","שום תנועה"],1,"הדוגמה: בין האגודל לשורש כף היד."],
["איזה מפרק מאפשר לחישור להסתובב סביב הגומד?",["ציר","סיבובי (Pivot)","אוכף","כדורי"],1,"מפרק סיבובי."],
["איפה יש מפרקי החלקה?",["בברך","בין עצמות שורש כף היד","בכתף","בירך"],1,"תנועה קטנה לכל כיוון."],
["מפרק ציר מאפשר:",["כפיפה ופשיטה בלבד","תנועה לכל הכיוונים","רק סיבוב","רק החלקה"],0,"כמו ציר של דלת."]
]},

{id:"limbjoints",short:"3.4 מפרקי הגפיים",unit:"יחידות 2–3: מערכת שלד-שריר ומפרקים",title:"מפרקי הגפיים העליונות והתחתונות",sub:"כתף, מרפק, יד, אגן, ירך, ברך וכף רגל: עצמות, מאפיינים ותנועות",
html:()=>`
<h3>גפיים עליונות</h3>
<div class="block"><h3>מפרק הכתף ${L("Shoulder joint")}</h3>
<p>3 עצמות עיקריות: <b>זרוע</b> ${L("Humerus")}, <b>שכמה</b> ${L("Scapula")}, <b>בריח</b> ${L("Clavicle")}. הכתף היא בעצם <b>4 מפרקים</b>:</p>
<ol>
<li><b>גלנו-הומרלי</b> ${L("Glenohumeral")}: מפרק הכתף העיקרי, בין שקע הגלנואיד בשכמה לראש הזרוע.</li>
<li><b>אקרומיו-קלביקולרי</b> ${L("Acromioclavicular")}: בין זיז האקרומיון בשכמה לקצה הבריח. מיוצב בקפסולה נוקשה וברצועות חזקות.</li>
<li><b>סטרנו-קלביקולרי</b> ${L("Sternoclavicular")}: בין הקצה הפנימי של הבריח לעצם החזה. שותף לנשיאת העומסים על הגפה.</li>
<li><b>סקפולו-תורקלי</b> ${L("Scapulothoracic")}: <b>לא מפרק אמיתי</b>, אלא המגע בין השכמה לצלעות. תורם כ<b>שליש</b> מטווח התנועה של הכתף.</li>
</ol>
<div class="jfacts"><div><span>סוג</span>סינוביאלי רב-צירי, מכתש ועלי (כדורי)</div><div><span>מאפיין</span>הרבה תנועתיות, <b>על חשבון היציבות</b></div><div><span>תנועות</span>כפיפה ופשיטה · הרחקה וקירוב · הרחקה וקירוב אופקיים · רוטציה פנימה והחוצה</div></div></div>
<div class="trick"><b class="tag">טריק לזכירה</b>הכתף היא <b>כדור גולף על טי</b>: ראש הזרוע גדול, השקע קטן ורדוד. לכן היא זזה לכל כיוון, וגם נוקעת בקלות.</div>
<div class="block"><h3>מפרק המרפק ${L("Elbow joint")}</h3>
<p>מחבר בין הזרוע לעצמות האמה, ובנוי משלושה מפרקים. המפרק בין הזרוע לגומד נושא את רוב העומס בכפיפה ופשיטה. המפרק בין החישור לגומד מאפשר <b>סיבוב של האמה</b>, בלי קשר לזווית המרפק.</p>
<div class="jfacts"><div><span>סוג</span>סינוביאלי חד-צירי (ציר)</div><div><span>עצמות</span>זרוע ${L("Humerus")} · חישור ${L("Radius")}, בצד <b>האגודל</b> · גומד ${L("Ulna")}, בצד <b>הזרת</b></div><div><span>תנועות</span>כפיפה ופשיטה · סופינציה ופרונציה (באמה)</div></div></div>
<div class="trick"><b class="tag">טריק לזכירה</b><b>R</b>adius = <b>R</b>oute של האגודל: החישור תמיד בצד האגודל. ה-Ulna בצד הזרת.</div>
<div class="block"><h3>מפרקי היד ${L("Hand joints")}</h3>
<ul><li><b>שורש כף היד</b> ${L("Wrist joint")}: בין החישור והגומד לבין 8 עצמות השורש. תנועות: <b>כפיפה גבית</b> ${L("dorsiflexion")} ו<b>כפיפה כפית</b> ${L("palmar flexion")}.</li>
<li><b>מפרקי האצבעות:</b> כפיפה ופשיטה.</li></ul></div>

<h3 style="margin-top:8px">גפיים תחתונות</h3>
<div class="block"><h3>האגן ומפרקיו</h3>
<p>עצם האגן יוצרת 3 מפרקים:</p>
<ol>
<li><b>סקרו-איליאק</b> ${L("Sacro-iliac")}: בין הכסל לעצה, מאחור.</li>
<li><b>סימפיזיס פוביס</b> ${L("Symphysis pubis")}: בין עצמות החיק, מקדימה.</li>
<li><b>מפרק הירך</b> ${L("Hip joint")}: בין האגן לעצם הירך.</li>
</ol></div>
<div class="block"><h3>מפרק הירך ${L("Hip joint")}</h3>
<div class="jfacts"><div><span>סוג</span>סינוביאלי רב-צירי (כדורי)</div><div><span>עצמות</span>ירך ${L("Femur")} · אגן ${L("Pelvis")}</div><div><span>תנועות</span>כפיפה ופשיטה · הרחקה וקירוב · הרחקה וקירוב אופקיים · רוטציה פנימה והחוצה</div></div></div>
<div class="block"><h3>מפרק הברך ${L("Knee joint")}</h3>
<p>בנוי משני מפרקים: <b>ירך-פיקה</b> ${L("Patellofemoral")} ו<b>ירך-שוקה</b> ${L("Tibiofemoral")}. בתוכו סחוס עבה, ה<b>מניסקוס</b> (פנימי וחיצוני), שמשפר את ההתאמה בין העצמות ובולם זעזועים.</p>
<div class="jfacts"><div><span>עצמות</span>ירך · פיקה · שוקה · שוקית (לפי המצגת)</div><div><span>תנועות</span>כפיפה ופשיטה · רוטציה פנימה והחוצה, <b>רק כשהברך כפופה</b></div></div>
<p class="warn" style="margin-top:8px">במצגת הזו השוקית מופיעה ברשימת עצמות הברך. במצגת של הקורס הענפי מודגש שהשוקית <b>לא</b> משתתפת במפרק הברך עצמו (המפרק הוא ירך + שוקה + פיקה). השוקית קרובה לברך ורצועות מתחברות אליה, אבל היא לא חלק מהמשטחים המפרקיים.</p></div>
<div class="block"><h3>מפרקי כף הרגל ${L("Foot joints")}</h3>
<ul>
<li><b>מפרק הקרסול</b> ${L("Ankle joint")}: 3 עצמות: <b>קפץ</b> ${L("Talus")}, <b>שוקית</b> ${L("Fibula")}, <b>שוקה</b> ${L("Tibia")}. תנועות: <b>כפיפה כפית</b> ${L("plantar flexion")}, <b>כפיפה גבית</b> ${L("dorsiflexion")}, <b>אינברסיה</b> (סיבוב פנימה) ו<b>אברסיה</b> (סיבוב החוצה).</li>
<li><b>שאר המפרקים</b> הם בין עצמות כף הרגל: 7 עצמות שורש ${L("Tarsals")}, 5 עצמות מסרק ${L("Metatarsals")}, 14 גלילים ${L("Phalanges")}. תנועות: כפיפה ופשיטה.</li>
</ul></div>
`,
quiz:[
["איזה \"מפרק\" בכתף הוא לא מפרק אמיתי?",["גלנו-הומרלי","אקרומיו-קלביקולרי","סטרנו-קלביקולרי","סקפולו-תורקלי"],3,"זה רק משטח המגע בין השכמה לצלעות, אבל הוא תורם כשליש מטווח התנועה."],
["מה המחיר של התנועתיות הגדולה של הכתף?",["אין מחיר","פחות יציבות","היא כבדה","אין בה רצועות"],1,"התנועתיות באה על חשבון היציבות."],
["באיזה צד של האמה נמצא החישור (Radius)?",["בצד הזרת","בצד האגודל","באמצע","בכתף"],1,"והגומד (Ulna) בצד הזרת."],
["אילו תנועות יש במרפק, מעבר לכפיפה ופשיטה?",["הרחקה וקירוב","סופינציה ופרונציה","אינברסיה ואברסיה","הרמה והורדה"],1,"דרך המפרק בין החישור לגומד."],
["אילו 3 מפרקים יוצרת עצם האגן?",["ברך, קרסול, ירך","סקרו-איליאק, סימפיזיס פוביס, מפרק הירך","כתף, מרפק, יד","רק מפרק הירך"],1,"מאחור, מקדימה, ולמטה לכיוון הירך."],
["מתי אפשר רוטציה בברך?",["תמיד","רק כשהברך כפופה","רק כשהיא ישרה","אף פעם"],1,"כשהברך ישרה היא נעולה."],
["מאילו עצמות בנוי מפרק הקרסול?",["ירך, שוקה, פיקה","קפץ, שוקית, שוקה","עקב ומסרק","שוקה ופיקה"],1,"Talus, Fibula, Tibia."]
]},

{id:"planes",short:"3.5 מישורים ותנועות",unit:"יחידות 2–3: מערכת שלד-שריר ומפרקים",title:"עמידה אנטומית, מישורים ותנועות",sub:"איך מתארים כל תנועה בגוף, כולל תנועות מיוחדות של האמה, הקרסול והשכמה",
html:()=>`
<div class="block"><h3>עמידה אנטומית</h3>
<p>נקודת המוצא לתיאור כל תנועה: עמידה שבה <b>כל המפרקים בזווית של 180°</b>, חוץ מ<b>הקרסול, שבזווית של 90°</b>.</p></div>
<div class="block"><h3>3 המישורים</h3>
<figure class="fig"><div class="dplate">${PLANES_SVG}</div><figcaption>הקו המקווקו מראה איפה כל מישור חותך את הגוף.</figcaption></figure></div>

<div class="block"><h3>מישור חיצי ${L("Sagittal")}</h3>
<ul>
<li><b>כפיפה</b> ${L("Flexion")}: קירוב בין שתי עצמות, <b>הקטנת הזווית</b> במפרק.</li>
<li><b>פשיטה</b> ${L("Extension")}: ההפך: <b>הגדלת הזווית</b>.</li>
<li><b>פשיטת יתר</b> ${L("Hyperextension")}: פשיטה <b>מעבר</b> לטווח האנטומי.</li>
<li>בקרסול: <b>כפיפה גבית</b> ${L("Dorsiflexion")} (קצה כף הרגל עולה לכיוון השוק) ו<b>כפיפה כפית</b> ${L("Plantar flexion")} (כף הרגל יורדת, כמו לחיצה על דוושה).</li>
</ul>
<p style="margin-top:6px"><b>איפה:</b> כתף, מרפק, כף היד, ברך, ירך, קרסול, עמוד שדרה.</p></div>
<div class="block"><h3>מישור חזיתי ${L("Frontal")}</h3>
<ul>
<li><b>קירוב</b> ${L("Adduction")}: הגפה זזה <b>אל</b> מרכז הגוף.</li>
<li><b>הרחקה</b> ${L("Abduction")}: הגפה זזה <b>הרחק</b> ממרכז הגוף.</li>
</ul>
<p style="margin-top:6px"><b>איפה:</b> כתף, ירך.</p></div>
<div class="block"><h3>מישור אופקי ${L("Transverse")}</h3>
<ul>
<li><b>קירוב אופקי</b> ${L("Horizontal adduction")} ו<b>הרחקה אופקית</b> ${L("Horizontal abduction")}: הגפה (מורמת) נעה אל הגוף או ממנו. בכתף ובירך.</li>
<li><b>סיבוב</b> ${L("Rotation")}: חיצוני ${L("Lateral")} ופנימי ${L("Medial")}. בכתף, בירך, בברך (רק כשהיא כפופה) ובגו.</li>
</ul></div>

<h3 style="margin-top:8px">תנועות מיוחדות</h3>
<div class="tbl"><table>
<tr><th>איפה</th><th>תנועה</th><th>מה קורה</th></tr>
<tr><td rowspan="2"><b>אמה</b></td><td>פרונציה ${L("Pronation")}</td><td>סיבוב פנימה: האגודל פונה <b>לכיוון הגוף</b> (כף היד למטה)</td></tr>
<tr><td>סופינציה ${L("Supination")}</td><td>סיבוב החוצה: האגודל פונה <b>הרחק מהגוף</b> (כף היד למעלה)</td></tr>
<tr><td rowspan="2"><b>קרסול</b></td><td>אינברסיה ${L("Inversion")}</td><td>הסוליה מסתובבת <b>פנימה</b>. זו תנועת <b>הנקע</b> השכיחה</td></tr>
<tr><td>אברסיה ${L("Eversion")}</td><td>הסוליה מסתובבת <b>החוצה</b></td></tr>
<tr><td rowspan="6"><b>שכמה</b></td><td>הרמה ${L("Elevation")}</td><td>משיכת הכתפיים לכיוון האוזניים</td></tr>
<tr><td>הורדה ${L("Depression")}</td><td>לחיצת הכתפיים למטה, הרחק מהאוזניים</td></tr>
<tr><td>קירוב ${L("Retraction")}</td><td>קירוב השכמות זו לזו</td></tr>
<tr><td>הרחקה ${L("Protraction")}</td><td>הרחקת השכמות זו מזו</td></tr>
<tr><td>סיבוב החוצה ולמעלה ${L("Upward rotation")}</td><td>השכמה מסתובבת למעלה, למשל כשמרימים יד מעל הראש</td></tr>
<tr><td>סיבוב פנימה ולמטה ${L("Downward rotation")}</td><td>החזרה למטה</td></tr>
</table></div>
<div class="trick"><b class="tag">טריק לזכירה</b><b>סופינציה = סוּפּ</b>: כף יד למעלה, כאילו מחזיקים צלחת <b>מרק</b> (soup). פרונציה = ההפך, כף היד <b>פונה</b> לרצפה.<br><b>אינ</b>ברסיה = <b>אינ</b> = פנימה (in). וזו התנועה שבה נוקעים את הקרסול.<br><b>Re</b>traction = <b>Re</b>turn: מחזירים את השכמות אחורה, זו לזו. <b>Pro</b>traction = <b>Pro</b> = קדימה.</div>

<h3 style="margin-top:14px">כרטיסיות לשינון: כל המושגים</h3>
<div class="fc-bar"><button class="btn" id="fcPrev">הקודם</button><button class="btn primary" id="fcNext">הבא</button><button class="btn" id="fcShuf">ערבב</button><span class="count" id="fcCount"></span></div>
<div class="card" id="fcCard" tabindex="0" role="button" aria-label="הפוך כרטיסייה"></div>
`,
quiz:[
["מהי עמידה אנטומית?",["כל המפרקים ב-90°","כל המפרקים ב-180°, חוץ מהקרסול ב-90°","ישיבה","עמידה על רגל אחת"],1,"נקודת המוצא לתיאור תנועות."],
["כפיפה היא...",["הגדלת הזווית במפרק","הקטנת הזווית במפרק","סיבוב","תנועה הצידה"],1,"ופשיטה היא הגדלת הזווית."],
["באיזה מישור מתבצעות הרחקה וקירוב?",["חיצי","חזיתי","אופקי","אין מישור כזה"],1,"וקירוב/הרחקה אופקיים במישור האופקי."],
["מהי פשיטת יתר?",["כפיפה מלאה","פשיטה מעבר לטווח האנטומי","סיבוב חיצוני","הרחקה אופקית"],1,"Hyperextension."],
["בפרונציה של האמה...",["האגודל פונה הרחק מהגוף","האגודל פונה לכיוון הגוף","המרפק נכפף","השכמה עולה"],1,"וסופינציה = האגודל הרחק מהגוף."],
["איזו תנועה בקרסול היא תנועת הנקע השכיחה?",["אברסיה","אינברסיה","כפיפה גבית","פשיטה"],1,"הסוליה מסתובבת פנימה."],
["מה זה Retraction של השכמה?",["הרחקת השכמות זו מזו","קירוב השכמות זו לזו","משיכת הכתפיים לאוזניים","לחיצת הכתפיים למטה"],1,"Protraction = הרחקה."],
["באילו מפרקים יש סיבוב לפי המצגת?",["רק במרפק","כתף, ירך, ברך כפופה וגו","רק בקרסול","באצבעות"],1,"במישור האופקי."]
]}
];

const cards=[
["אנטומיה","הענף בביולוגיה שעוסק בצורה, במבנה ובמיקום של איברי הגוף. המונחים בלטינית."],
["רמות הארגון","אטום ← מולקולה ← מקרו-מולקולה ← אברון ← תא ← רקמה ← איבר ← מערכת ← אורגניזם."],
["אברוני התא","גרעין (דנ״א, פיקוח), מיטוכונדריה (אנרגיה), ריבוזום (חלבון), ליזוזום (מחזור), רשת אנדופלסמטית (הובלה), גולג׳י (עיבוד חלבון)."],
["קולגן מול אלסטין","קולגן: עבה, לא נמתח (חבל). אלסטין: דק, נמתח עד פי 1.5, נוטה להיקרע (גומייה)."],
["אפיתל","תאים צמודים בשכבה רציפה. הגנה, ספיגה, הפרשה וחישה."],
["רקמת חיבור צפופה סדירה","קולגן במקביל, חזקה בכיוון אחד. גידים ורצועות."],
["רצועה","עצם לעצם. קולגן + אלסטין. יותר כלי דם מגיד. חיישנים שמגינים מפציעה."],
["גיד","שריר לעצם. כמעט רק קולגן (2% אלסטין). מעט מאוד דם, ריפוי איטי. איבר גולג׳י."],
["עצם דחוסה מול ספוגית","דחוסה: פחות מ-5% חללים, חוזק. ספוגית: 50–90% חללים, קוריות, מח עצם."],
["תאי עצם","אוסטאובלסט בונה, אוסטאוקלסט הורס, אוסטאוציט מנטר."],
["חוק וולף","העצם מתחזקת לפי העומסים: כוח כובד, עומס מכני וכיווץ שרירים."],
["3 סוגי סחוס","היאליני: קצות עצמות. סיבי: דיסק, מניסקוס, חיק. אלסטי: אוזן, אף."],
["מפרק סינוביאלי","סחוס היאליני, קפסולה, נוזל סינוביאלי (פחות חיכוך, הזנת סחוס), רצועות וגידים."],
["שלד הציר מול שלד הגפיים","ציר: גולגולת, עמוד שדרה, עצם החזה, צלעות. גפיים: בריח, שכמה, אגן, ידיים, רגליים."],
["עמוד השדרה","33 חוליות: 7 צוואר, 12 חזה, 5 מותן, 5 עצה, 4 זנב. לורדוזה-קיפוזה-לורדוזה."],
["הדיסק","גרעין ג׳לטיני (70% מים) במרכז, טבעת קולגן בהיקף. נחלשה = בלט, נקרעה = פריצה."],
["הצלעות","1–7 אמיתיות, 8–10 מדומות (דרך סחוס צלע 7), 11–12 צפות."],
["6 סוגי מפרקים","כדורי (ירך, כתף), ציר (מרפק, ברך), אוכף (אגודל), אליפטי, סיבובי (חישור-גומד), החלקה (שורש כף היד)."],
["4 מפרקי הכתף","גלנו-הומרלי, אקרומיו-קלביקולרי, סטרנו-קלביקולרי, סקפולו-תורקלי (לא אמיתי)."],
["פרונציה וסופינציה","פרונציה: אגודל לכיוון הגוף. סופינציה: אגודל הרחק מהגוף."],
["אינברסיה ואברסיה","אינברסיה: סוליה פנימה (נקע). אברסיה: סוליה החוצה."],
["תנועות השכמה","הרמה, הורדה, Retraction (קירוב), Protraction (הרחקה), סיבוב למעלה ולמטה."]
];

/* ---------- app ---------- */
const store={get(k,d){try{const v=localStorage.getItem(k);return v==null?d:JSON.parse(v)}catch(e){return d}},set(k,v){try{localStorage.setItem(k,JSON.stringify(v))}catch(e){}}};
let cur=store.get("sci.anat3.cur","skeleton");
let done=store.get("sci.anat3.done",{});
if(!chapters.find(c=>c.id===cur))cur="skeleton";

function renderRail(){
  const r=document.getElementById("rail");
  r.innerHTML=chapters.map(c=>`<button role="tab" id="tab-${c.id}" aria-selected="${c.id===cur}" data-id="${c.id}"><span class="done ${done[c.id]?'on':''}" aria-hidden="true"></span>${c.short}</button>`).join("");
  r.querySelectorAll("button").forEach(b=>b.onclick=()=>go(b.dataset.id));
  const a=r.querySelector('[aria-selected="true"]');if(a&&a.scrollIntoView)a.scrollIntoView({block:"nearest",inline:"nearest"});
}
function go(id){cur=id;store.set("sci.anat3.cur",cur);render();window.scrollTo({top:0})}
function quizHTML(c){
  return `<section class="quiz" aria-label="בוחן"><div class="eyebrow">סוף הפרק</div><h2>בדוק את עצמך</h2>
  ${c.quiz.map((q,qi)=>{const ord=q[1].map((_,i)=>i).sort(()=>Math.random()-.5);return `<div class="qitem" data-q="${qi}"><div class="qt">${qi+1}. ${q[0]}</div><div class="opts">${ord.map(oi=>`<button class="opt" data-o="${oi}">${q[1][oi]}</button>`).join("")}</div><div class="expl" hidden></div></div>`}).join("")}
  <div class="score"><span id="scoreTxt">ענית על 0 מתוך ${c.quiz.length}</span><button class="btn" id="redo">התחל מחדש</button></div></section>`;
}
function wireQuiz(c){
  let answered=0,right=0;
  const upd=()=>{const t=document.getElementById("scoreTxt");
    t.textContent=answered<c.quiz.length?`ענית על ${answered} מתוך ${c.quiz.length}`:`סיימת: ${right} מתוך ${c.quiz.length} נכונות. ${right===c.quiz.length?"מצוין, הפרק בכיס!":right>=c.quiz.length*0.7?"כמעט! חזור על ההסברים של מה שפספסת.":"כדאי לקרוא שוב את הפרק ולנסות שוב."}`;
    if(answered===c.quiz.length&&right>=Math.ceil(c.quiz.length*0.7)){done[c.id]=true;store.set("sci.anat3.done",done);renderRail()}};
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
/* calculator */
function wireCalc(){
  const $=id=>document.getElementById(id);
  const def={cAge:20,cSex:"220",cRest:50,cMax:"",cP1:60,cP2:70,cK1:40,cK2:60};
  const saved=store.get("phys.calc",def);
  Object.keys(def).forEach(k=>{$(k).value=saved[k]??def[k];$(k).oninput=calc;$(k).onchange=calc});
  function calc(){
    const v={};Object.keys(def).forEach(k=>v[k]=$(k).value);store.set("phys.calc",v);
    const age=+v.cAge,rest=+v.cRest,base=+v.cSex;
    const mx=v.cMax?+v.cMax:base-age, res=mx-rest;
    const p=(a)=>Math.round(mx*a/100), k=(a)=>Math.round(rest+res*a/100);
    const ok=age>0&&rest>0&&mx>rest;
    $("cOut").innerHTML=!ok?`<div class="res">בדוק את הנתונים: הדופק המרבי צריך להיות גבוה מדופק המנוחה.</div>`:
    `<div class="res"><div>דופק מרבי ${v.cMax?"(נמדד)":"(חזוי)"}</div><div class="big">${mx}</div><div class="how">${v.cMax?"הוזן ידנית":`${base} − ${age} = ${mx}`}</div></div>
     <div class="res"><div>רזרבת דופק</div><div class="big">${res}</div><div class="how">${mx} − ${rest} = ${res}</div></div>
     <div class="res"><div>${v.cP1}–${v.cP2}% מהדופק המרבי</div><div class="big">${p(+v.cP1)}–${p(+v.cP2)}</div><div class="how">${mx} × ${v.cP1}% = ${p(+v.cP1)} · ${mx} × ${v.cP2}% = ${p(+v.cP2)}</div></div>
     <div class="res" style="border-color:var(--accent)"><div>${v.cK1}–${v.cK2}% מרזרבת הדופק (קרבונן)</div><div class="big">${k(+v.cK1)}–${k(+v.cK2)}</div><div class="how">${rest} + ${res} × ${v.cK1}% = ${k(+v.cK1)} · ${rest} + ${res} × ${v.cK2}% = ${k(+v.cK2)}</div></div>`;
    fixBidi($("cOut"));
  }
  calc();
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
  if(document.getElementById("calc"))wireCalc();
  if(document.getElementById("fcCard"))wireCards();
  fixBidi(document.getElementById("main"));wireTips();wireQuiz(c);
  if(next)document.getElementById("nextChap").onclick=()=>go(next.id);
}
render();
</script>
</body></html>
