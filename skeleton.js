/* Interactive skeleton ("סימולטור שלד"): click a bone to see its name, or test yourself in quiz mode.
   Self-initialising: renders into any <div id="skelSim"> that appears on the page (chapter pages re-render their content). */
(function(){
  "use strict";

  /* ---------- bone data ---------- */
  var AX = "שלד הציר", AP = "שלד הגפיים";
  var B = {
    skull:      {he:"גולגולת", la:"Cranium", en:"Skull", g:AX, fact:"מגינה על המוח. יחד עם עמוד השדרה, עצם החזה והצלעות היא שלד הציר."},
    spineC:     {he:"חוליות הצוואר", la:"Vertebrae cervicales", en:"Cervical vertebrae", g:AX, n:"7 חוליות", fact:"הקשת של הצוואר היא לורדוזה: קשת קדימה. החוליות כאן הקטנות ביותר."},
    spineT:     {he:"חוליות בית החזה", la:"Vertebrae thoracicae", en:"Thoracic vertebrae", g:AX, n:"12 חוליות", fact:"כל חוליה מחוברת לזוג צלעות (T1–T12). הקשת כאן היא קיפוזה: קשת אחורה. במבט מלפנים הן מוסתרות מאחורי עצם החזה, ולכן רואים אותן במבט מהצד."},
    spineL:     {he:"חוליות מותניות", la:"Vertebrae lumbales", en:"Lumbar vertebrae", g:AX, n:"5 חוליות", fact:"החוליות הגדולות ביותר, כי הן נושאות הכי הרבה משקל. הקשת כאן היא שוב לורדוזה: קשת קדימה."},
    sacrum:     {he:"עצה", la:"Os sacrum", en:"Sacrum", g:AX, n:"5 חוליות מאוחות", fact:"חמש חוליות שהתאחו לעצם אחת. מתחברת לעצם הכסל שבאגן במפרק הסקרו-איליאק."},
    coccyx:     {he:"עצם הזנב", la:"Os coccygis", en:"Coccyx", g:AX, n:"4 חוליות מאוחות", fact:"הקצה התחתון של עמוד השדרה."},
    sternum:    {he:"עצם החזה", la:"Sternum", en:"Sternum", g:AX, fact:"העצם השטוחה במרכז בית החזה. הצלעות האמיתיות מתחברות אליה ישירות."},
    ribsTrue:   {he:"צלעות אמיתיות", la:"Costae verae", en:"True ribs", g:AX, n:"צלעות 1–7", fact:"מחוברות ישירות לעצם החזה, כל אחת דרך סחוס משלה."},
    ribsFalse:  {he:"צלעות מדומות", la:"Costae spuriae", en:"False ribs", g:AX, n:"צלעות 8–10", fact:"מתחברות לעצם החזה בעקיפין, דרך הסחוס של הצלע השביעית."},
    ribsFloat:  {he:"צלעות צפות", la:"Costae fluctuantes", en:"Floating ribs", g:AX, n:"צלעות 11–12", fact:"לא מתחברות לעצם החזה בכלל, רק לעמוד השדרה מאחור."},
    clavicle:   {he:"עצם הבריח", la:"Clavicula", en:"Clavicle", g:AP, fact:"חלק מחגורת הכתפיים. מחברת את הגפה העליונה לשלד הציר, דרך מפרק הסטרנו-קלביקולרי בעצם החזה."},
    scapula:    {he:"שכמה", la:"Scapula", en:"Scapula", g:AP, fact:"חלק מחגורת הכתפיים. יושבת מאחורי בית החזה, ולכן מלפנים רואים רק את הקצה שלה. השקע שלה (גלנואיד) הוא חלק ממפרק הכתף."},
    humerus:    {he:"עצם הזרוע", la:"Humerus", en:"Humerus", g:AP, fact:"העצם הארוכה של הזרוע, בין הכתף למרפק. הראש העגול שלה יושב בשקע של השכמה."},
    radius:     {he:"חישור", la:"Radius", en:"Radius", g:AP, fact:"עצם האמה בצד האגודל. מסתובבת סביב הגומד בסופינציה ופרונציה."},
    ulna:       {he:"גומד", la:"Ulna", en:"Ulna", g:AP, fact:"עצם האמה בצד הזרת. יוצרת עם הזרוע את מפרק הציר של המרפק."},
    carpals:    {he:"עצמות שורש כף היד", la:"Ossa carpi", en:"Carpals", g:AP, n:"8 עצמות", fact:"שמונה עצמות קטנות בשתי שורות. ביניהן מפרקי החלקה."},
    metacarpals:{he:"עצמות המסרק (יד)", la:"Ossa metacarpi", en:"Metacarpals", g:AP, n:"5 עצמות", fact:"העצמות של כף היד עצמה, בין השורש לאצבעות."},
    handPhal:   {he:"גלילי אצבעות היד", la:"Phalanges manus", en:"Phalanges", g:AP, n:"14 עצמות", fact:"3 בכל אצבע ו-2 באגודל."},
    ilium:      {he:"עצם הכסל", la:"Os ilium", en:"Ilium", g:AP, n:"חלק מעצם האגן", fact:"החלק העליון והרחב של עצם האגן (\"הכנף\"). מאחור הוא מתחבר לעצה במפרק הסקרו-איליאק. את השפה העליונה שלו (ציצת הכסל) אפשר למשש בצד המותן."},
    ischium:    {he:"עצם השת", la:"Os ischii", en:"Ischium", g:AP, n:"חלק מעצם האגן", fact:"החלק התחתון והאחורי של עצם האגן. עליו יושבים, ומהבליטה שלו יוצאים שרירי החבליים (המסטרינג)."},
    pubis:      {he:"עצם החיק", la:"Os pubis", en:"Pubis", g:AP, n:"חלק מעצם האגן", fact:"החלק הקדמי של עצם האגן. שתי עצמות החיק נפגשות באמצע, במפרק הסימפיזיס פוביס, שבנוי מסחוס סיבי."},
    femur:      {he:"עצם הירך", la:"Femur", en:"Femur", g:AP, fact:"העצם הארוכה והחזקה ביותר בגוף. הראש שלה יושב בשקע של האגן (מפרק כדורי)."},
    patella:    {he:"פיקה", la:"Patella", en:"Patella", g:AP, fact:"עצם קטנה בתוך הגיד של הארבע-ראשי, מלפני הברך. יוצרת את מפרק ירך-פיקה."},
    tibia:      {he:"שוקה", la:"Tibia", en:"Tibia", g:AP, fact:"עצם השוק הגדולה, בצד הפנימי. נושאת את רוב משקל הגוף, ויוצרת עם הירך את מפרק הברך."},
    fibula:     {he:"שוקית", la:"Fibula", en:"Fibula", g:AP, fact:"עצם השוק הקטנה והדקה, בצד החיצוני. משתתפת במפרק הקרסול."},
    tarsals:    {he:"עצמות שורש כף הרגל", la:"Ossa tarsi", en:"Tarsals", g:AP, n:"7 עצמות", fact:"ביניהן הקפץ (Talus), שיוצר את מפרק הקרסול עם השוקה והשוקית, והעקב."},
    metatarsals:{he:"עצמות המסרק (רגל)", la:"Ossa metatarsi", en:"Metatarsals", g:AP, n:"5 עצמות", fact:"העצמות הארוכות של כף הרגל, בין השורש לאצבעות."},
    footPhal:   {he:"גלילי אצבעות הרגל", la:"Phalanges pedis", en:"Phalanges", g:AP, n:"14 עצמות", fact:"3 בכל אצבע ו-2 בבוהן."}
  };
  var ORDER = ["skull","spineC","clavicle","scapula","sternum","ribsTrue","ribsFalse","ribsFloat","spineT","humerus","radius","ulna","carpals","metacarpals","handPhal","spineL","ilium","ischium","pubis","sacrum","coccyx","femur","patella","tibia","fibula","tarsals","metatarsals","footPhal"];

  /* ---------- drawing (front view; viewer's left = person's right; paired bones are mirrored) ---------- */
  var M = ' transform="matrix(-1 0 0 1 300 0)"';
  function pair(d, extra){ return '<path d="' + d + '"' + (extra || "") + '/><path d="' + d + '"' + (extra || "") + M + '/>'; }
  function pairC(cx, cy, rx, ry){ return '<ellipse cx="' + cx + '" cy="' + cy + '" rx="' + rx + '" ry="' + ry + '"/><ellipse cx="' + (300 - cx) + '" cy="' + cy + '" rx="' + rx + '" ry="' + ry + '"/>'; }
  function stroke(d, w){ return '<path class="sk-line" d="' + d + '" stroke-width="' + w + '"/><path class="sk-lhit" d="' + d + '"/>'; }
  function pairStroke(d, w){ return '<path class="sk-line" d="' + d + '" stroke-width="' + w + '"/><path class="sk-line" d="' + d + '" stroke-width="' + w + '"' + M + '/>'
    + '<path class="sk-lhit" d="' + d + '"/><path class="sk-lhit" d="' + d + '"' + M + '/>'; }
  function g(id, inner, hit){ var b = B[id];
    return '<g class="sk-bone" data-b="' + id + '" tabindex="0" role="button" aria-label="' + b.la + ', ' + b.he + '">' + inner + (hit ? '<path class="sk-hit" d="' + hit + '"/>' + '<path class="sk-hit" d="' + hit + '"' + M + '/>' : '') + '</g>'; }

  function front(){
    var s = "";
    // vertebral segments
    function verts(y0, y1, n, x0, x1){ var h = (y1 - y0) / n, o = ""; for (var i = 0; i < n; i++) o += '<rect x="' + x0 + '" y="' + (y0 + i * h + .6).toFixed(1) + '" width="' + (x1 - x0) + '" height="' + (h - 1.2).toFixed(1) + '" rx="2"/>'; return o; }
    s += g("scapula", pair("M104,142 L126,146 L119,210 Z"), null);
    s += g("spineT", verts(136, 248, 12, 141, 159), null);
    // ribs
    var rt = "", rf = "", rfl = "";
    for (var i = 1; i <= 7; i++) { var ys = 146 + (i - 1) * 12.5, w = 122 - Math.min(i, 7) * 2.9;
      rt += pairStroke("M144," + ys.toFixed(1) + " C" + (w + 10).toFixed(1) + "," + (ys - 7).toFixed(1) + " " + w.toFixed(1) + "," + (ys - 1).toFixed(1) + " " + (w - 1).toFixed(1) + "," + (ys + 15).toFixed(1), 4.2); }
    rf += pairStroke("M144,227 C141,236 133,245 121,252", 3);
    for (var j = 0; j < 3; j++) { var x = 138 - j * 7, y = 233 + j * 7;
      rf += pairStroke("M" + x + "," + y + " C" + (x - 14) + "," + (y - 4) + " " + (101 + j) + "," + (y + 2) + " " + (101 + j) + "," + (y + 16), 4.2); }
    rfl += pairStroke("M114,252 C108,254 104,258 103,266", 4) + pairStroke("M117,262 C112,265 109,269 108,276", 4);
    s += g("ribsTrue", rt, null) + g("ribsFalse", rf, null) + g("ribsFloat", rfl, null);
    s += g("sternum", '<path d="M144,139 L156,139 L157,158 L155,161 L156,226 L150,237 L144,226 L145,161 L143,158 Z"/>', null);
    s += g("spineC", verts(94, 134, 7, 144, 156), null);
    s += g("clavicle", pairStroke("M146,137 C131,133 119,130 104,136", 6), "M146,137 C131,133 119,130 104,136");
    s += g("skull", '<path d="M150,10 C126,10 115,28 116,52 C117,66 122,74 125,80 C127,95 137,104 150,104 C163,104 173,95 175,80 C178,74 183,66 184,52 C185,28 174,10 150,10 Z"/>'
      + '<ellipse class="sk-hole" cx="138" cy="58" rx="8" ry="7"/><ellipse class="sk-hole" cx="162" cy="58" rx="8" ry="7"/><path class="sk-hole" d="M150,66 L145,78 L155,78 Z"/>'
      + '<path class="sk-hole" d="M134,88 C142,93 158,93 166,88" fill="none" stroke-width="1.6"/>', null);
    s += g("humerus", pair("M95,146 C99,140 109,141 110,149 C110,155 106,158 104,160 L96,252 C100,254 101,260 97,265 L82,265 C78,260 80,254 86,252 L94,160 C92,156 92,150 95,146 Z"), null);
    s += g("ulna", pairStroke("M94,268 L87,364", 5), "M94,268 L87,364");
    s += g("radius", pairStroke("M83,272 L74,364", 6), "M83,272 L74,364");
    var cp = ""; [[76,370],[83,369],[90,370],[73,377],[80,377],[87,377],[93,376],[96,371]].forEach(function(c){ cp += pairC(c[0], c[1], 3.4, 3.2); });
    s += g("carpals", cp, null);
    var mc = ""; [[74,381,66,401],[79,383,74,410],[84,383,82,412],[89,383,89,410],[93,382,95,405]].forEach(function(l){ mc += pairStroke("M" + l[0] + "," + l[1] + " L" + l[2] + "," + l[3], 3.4); });
    s += g("metacarpals", mc, null);
    var hp = ""; [[66,404,60,428,2],[74,413,72,446,3],[82,415,82,452,3],[89,413,91,448,3],[95,408,99,438,3]].forEach(function(f){
      var n = f[4]; for (var k = 0; k < n; k++) { var a = k / n, b2 = (k + 1) / n - .04, x1 = f[0] + (f[2] - f[0]) * a, y1 = f[1] + (f[3] - f[1]) * a, x2 = f[0] + (f[2] - f[0]) * b2, y2 = f[1] + (f[3] - f[1]) * b2;
        hp += pairStroke("M" + x1.toFixed(1) + "," + y1.toFixed(1) + " L" + x2.toFixed(1) + "," + y2.toFixed(1), 3); } });
    s += g("handPhal", hp, null);
    s += g("spineL", verts(250, 298, 5, 140, 160), null);
    // hip bone (os coxae) = ilium + ischium + pubis, fused around the hip socket
    s += g("ilium", pair("M139,300 C120,293 104,300 103,318 C102,334 113,347 125,352 L133,349 L141,337 L141,318 Z"), null);
    s += g("pubis", pair("M133,349 L141,337 L143,346 C144,352 146,355 149,356 L149,365 C144,365 140,362 138,358 C137,354 135,351 133,349 Z"), null);
    s += g("ischium", pair("M125,352 L133,349 C135,351 137,354 138,358 C140,362 144,365 149,365 L149,372 C146,375 140,374 136,369 C132,363 129,357 125,352 Z")
      + '<ellipse class="sk-hole" cx="138.5" cy="360" rx="3.6" ry="3"/><ellipse class="sk-hole" cx="161.5" cy="360" rx="3.6" ry="3"/>', null);
    s += g("sacrum", '<path d="M139,300 L161,300 L157,338 L150,346 L143,338 Z"/>', null);
    s += g("coccyx", '<path d="M145,346 L155,346 L150,357 Z"/>', null);
    s += g("femur", pair("M125,346 C130,342 138,345 137,352 C137,357 133,360 130,361 L131,364 C133,366 133,368 131,370 L137,498 C143,500 145,508 141,514 L124,514 C120,508 122,500 128,498 L122,374 C117,373 114,368 116,363 C118,358 122,359 124,360 C121,356 121,349 125,346 Z"), null);
    s += g("tibia", pair("M123,520 L145,520 C146,526 143,530 140,532 L139,632 C142,634 143,640 139,644 L129,644 C126,640 127,634 131,632 L130,532 C125,530 122,526 123,520 Z"), null);
    s += g("fibula", pairStroke("M120,528 L124,640", 4.4), "M120,528 L124,640");
    s += g("patella", pairC(133, 507, 6.5, 8.5), null);
    var ts = ""; [[124,649],[131,648],[138,649],[127,656],[134,656],[141,655],[120,654]].forEach(function(c){ ts += pairC(c[0], c[1], 3.6, 3.3); });
    s += g("tarsals", ts, null);
    var mt = ""; [[121,661,114,681],[126,662,122,686],[131,662,130,688],[136,662,138,687],[141,661,146,684]].forEach(function(l){ mt += pairStroke("M" + l[0] + "," + l[1] + " L" + l[2] + "," + l[3], 3.4); });
    s += g("metatarsals", mt, null);
    var fp = ""; [[113,684,111,694,2],[121,689,120,699,3],[130,691,130,701,3],[138,690,140,700,3],[147,687,151,697,3]].forEach(function(f){
      var n = f[4]; for (var k = 0; k < n; k++) { var a = k / n, b2 = (k + 1) / n - .06, x1 = f[0] + (f[2] - f[0]) * a, y1 = f[1] + (f[3] - f[1]) * a, x2 = f[0] + (f[2] - f[0]) * b2, y2 = f[1] + (f[3] - f[1]) * b2;
        fp += pairStroke("M" + x1.toFixed(1) + "," + y1.toFixed(1) + " L" + x2.toFixed(1) + "," + y2.toFixed(1), 2.6); } });
    s += g("footPhal", fp, null);
    return '<svg class="sk-front" viewBox="60 0 180 708" role="group" aria-label="השלד במבט מלפנים">'
      + '<text class="sk-side" x="66" y="22">ימין</text><text class="sk-side" x="234" y="22" text-anchor="end">שמאל</text>' + s + '</svg>';
  }
  function side(){
    function seg(id, d, w){ return g(id, '<path class="sk-line sk-spine" d="' + d + '" stroke-width="' + w + '"/>', d); }
    return '<svg class="sk-sideview" viewBox="0 0 120 420" role="group" aria-label="עמוד השדרה במבט מהצד">'
      + '<text class="sk-cap" x="60" y="14" text-anchor="middle">עמוד השדרה מהצד</text>'
      + '<text class="sk-dir" x="112" y="34" text-anchor="end">קדימה →</text>'
      + seg("spineC", "M56,28 C66,52 66,78 56,100", 10)
      + seg("spineT", "M56,100 C38,140 38,190 56,232", 13)
      + seg("spineL", "M56,232 C72,262 72,296 58,322", 16)
      + seg("sacrum", "M58,322 C48,342 46,362 54,382", 15)
      + seg("coccyx", "M54,382 C58,392 62,398 68,402", 7)
      + '<text class="sk-lab" x="68" y="66">לורדוזה</text><text class="sk-lab" x="4" y="170">קיפוזה</text><text class="sk-lab" x="72" y="282">לורדוזה</text>'
      + '</svg>';
  }

  /* ---------- styles ---------- */
  var CSS = ""
    + ".sk{--skf:#F4ECDA;--sks:#A89676;--skh:#D9CBAA;--skl:#C2AD80;margin:6px 0 4px;color:var(--ink)}"
    + ":root[data-theme=dark] .sk{--skf:#D8CDB5;--sks:#7C705A;--skh:#BDB194;--skl:#CDBF9F}"
    + "@media (prefers-color-scheme:dark){:root:not([data-theme=light]) .sk{--skf:#D8CDB5;--sks:#7C705A;--skh:#BDB194;--skl:#CDBF9F}}"
    + ".sk-bar{display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-bottom:10px}"
    + ".sk-bar button{font:700 14.5px var(--body);min-height:40px;padding:6px 14px;border-radius:999px;border:1px solid var(--line);background:var(--paper);color:var(--ink);cursor:pointer}"
    + ".sk-bar button[aria-pressed=true]{background:var(--navy,var(--accent));border-color:var(--navy,var(--accent));color:#fff}"
    + ".sk-bar button:focus-visible,.sk-bone:focus-visible{outline:3px solid var(--accent);outline-offset:2px}"
    + ".sk-grid{display:grid;grid-template-columns:minmax(0,1fr) 120px;gap:8px;align-items:start}"
    + ".sk-stage{position:relative;background:radial-gradient(70% 60% at 50% 35%,color-mix(in srgb,var(--accent) 8%,transparent),transparent 70%),var(--paper);border:1px solid var(--line);border-radius:16px;padding:6px}"
    + ".sk-front{width:100%;max-width:330px;height:auto;display:block;margin:0 auto;touch-action:manipulation}"
    + ".sk-sideview{width:100%;height:auto;display:block;background:var(--paper);border:1px solid var(--line);border-radius:14px}"
    + ".sk svg path,.sk svg rect,.sk svg ellipse{fill:var(--skf);stroke:var(--sks);transition:fill .15s,stroke .15s}.sk svg path:not(.sk-line):not(.sk-lhit):not(.sk-hit),.sk svg rect,.sk svg ellipse{stroke-width:1.1}"
    + ".sk svg .sk-line{fill:none!important;stroke:var(--skl);stroke-linecap:round}.sk svg text{direction:ltr;unicode-bidi:plaintext}.sk svg .sk-lhit{fill:none!important;stroke:transparent!important;stroke-width:11!important;stroke-linecap:round;pointer-events:stroke}"
    + ".sk svg .sk-spine{stroke-dasharray:6 2;stroke-linecap:butt}"
    + ".sk svg .sk-hole{fill:var(--sks)!important;stroke:none;opacity:.55}"
    + ".sk svg .sk-hit{fill:none!important;stroke:transparent!important;stroke-width:14!important;stroke-linecap:round}"
    + ".sk-bone{cursor:pointer;outline:none}"
    + ".sk-bone:hover path:not(.sk-hit):not(.sk-hole):not(.sk-lhit),.sk-bone:hover rect,.sk-bone:hover ellipse:not(.sk-hole){fill:var(--skh)}"
    + ".sk-bone:hover .sk-line:not(.sk-lhit){stroke:var(--skh)!important}"
    + ".sk-bone.on path:not(.sk-hit):not(.sk-hole):not(.sk-lhit),.sk-bone.on rect,.sk-bone.on ellipse:not(.sk-hole){fill:var(--accent);stroke:color-mix(in srgb,var(--accent) 70%,#000)}"
    + ".sk-bone.on .sk-line:not(.sk-lhit){stroke:var(--accent)!important}"
    + ".sk-bone.ok path:not(.sk-hit):not(.sk-hole):not(.sk-lhit),.sk-bone.ok rect,.sk-bone.ok ellipse:not(.sk-hole){fill:#059669;stroke:#065F46}.sk-bone.ok .sk-line:not(.sk-lhit){stroke:#059669!important}"
    + ".sk-bone.bad path:not(.sk-hit):not(.sk-hole):not(.sk-lhit),.sk-bone.bad rect,.sk-bone.bad ellipse:not(.sk-hole){fill:#DC2626;stroke:#7F1D1D}.sk-bone.bad .sk-line:not(.sk-lhit){stroke:#DC2626!important}"
    + ".sk.groups .sk-bone[data-g=ax] path:not(.sk-hit):not(.sk-hole):not(.sk-lhit),.sk.groups .sk-bone[data-g=ax] rect,.sk.groups .sk-bone[data-g=ax] ellipse:not(.sk-hole){fill:#93B4F5}.sk.groups .sk-bone[data-g=ax] .sk-line{stroke:#93B4F5}"
    + ".sk.groups .sk-bone[data-g=ap] path:not(.sk-hit):not(.sk-hole):not(.sk-lhit),.sk.groups .sk-bone[data-g=ap] rect,.sk.groups .sk-bone[data-g=ap] ellipse:not(.sk-hole){fill:#F5C27A}.sk.groups .sk-bone[data-g=ap] .sk-line{stroke:#F5C27A}"
    + ".sk-legend{display:none;gap:12px;font-size:13.5px;color:var(--muted);margin-top:6px;justify-content:center}.sk.groups .sk-legend{display:flex}"
    + ".sk-legend i{display:inline-block;width:12px;height:12px;border-radius:3px;vertical-align:middle;margin-inline-end:5px}"
    + ".sk-side{font:700 9px var(--body);fill:var(--muted)}.sk-cap{font:700 11px var(--body);fill:var(--ink)}.sk-dir,.sk-lab{font:600 10px var(--body);fill:var(--muted)}"
    + ".sk-tip{position:absolute;pointer-events:none;transform:translate(-50%,-125%);display:flex;align-items:center;gap:6px;background:var(--ink);color:var(--paper);font:700 14px var(--body);padding:5px 10px;border-radius:8px;white-space:nowrap;opacity:0;transition:opacity .15s;z-index:3}"
    + ".sk-tip.show{opacity:1}.sk-tip .sk-say{pointer-events:auto}.sk-tip .th{font-weight:600;opacity:.85}"
    + ".sk-say{border:0;background:rgba(255,255,255,.18);color:inherit;border-radius:999px;width:30px;height:30px;display:grid;place-items:center;cursor:pointer;font-size:15px;margin-inline-start:2px}"
    + ".sk-say:hover{background:rgba(255,255,255,.32)}.sk-say:focus-visible{outline:2px solid currentColor;outline-offset:1px}.sk-say.on{animation:skPulse 1s ease-in-out infinite}"
    + "@keyframes skPulse{50%{transform:scale(1.12)}}"
    + ".sk-panel .sk-say{background:var(--accent-soft);color:var(--accent);margin-inline-start:8px;vertical-align:middle}"
    + ".sk-panel{margin-top:10px;border:1px solid var(--line);border-inline-start:4px solid var(--accent);border-radius:14px;background:var(--paper);padding:12px 14px;min-height:96px}"
    + ".sk-panel h4{margin:0;font:800 24px var(--display);color:var(--navy,var(--ink));text-align:right}.sk-panel .he-sub{font-weight:700;font-size:16px;margin-top:2px}.sk-panel .en{color:var(--muted);font-weight:600;font-size:14px}"
    + ".sk-panel .la{direction:ltr;unicode-bidi:isolate;color:var(--muted);font-weight:600;margin-inline-start:6px;font-size:15px}"
    + ".sk-chips{display:flex;flex-wrap:wrap;gap:6px;margin:6px 0}"
    + ".sk-chip{font-size:12.5px;font-weight:700;border-radius:999px;padding:2px 10px;background:var(--accent-soft);color:var(--accent)}"
    + ".sk-chip.ap{background:color-mix(in srgb,#D97706 14%,transparent);color:#B45309}"
    + ":root[data-theme=dark] .sk-chip.ap{color:#FBBF24}@media (prefers-color-scheme:dark){:root:not([data-theme=light]) .sk-chip.ap{color:#FBBF24}}"
    + ".sk-panel p{margin:4px 0 0}.sk-hint{color:var(--muted)}"
    + ".sk-q{font:800 19px var(--display);margin:0 0 4px}.sk-q b{color:var(--accent)}"
    + ".sk-score{font-variant-numeric:tabular-nums;color:var(--muted);font-weight:700}"
    + ".sk-list{display:flex;flex-wrap:wrap;gap:6px;margin-top:10px}"
    + ".sk-list button small{font-weight:400;color:var(--muted);margin-inline-start:6px;font-size:12px}.sk-list button.on small{color:#fff}.sk-list button{font:600 13.5px var(--body);padding:5px 10px;border-radius:999px;border:1px solid var(--line);background:var(--paper);color:var(--ink);cursor:pointer;min-height:34px}"
    + ".sk-list button.on{background:var(--accent);border-color:var(--accent);color:#fff}"
    + ".sk-quizonly{display:none}.sk.quiz .sk-quizonly{display:inline-flex}.sk.quiz .sk-list{display:none}"
    + "@media (max-width:520px){.sk-grid{grid-template-columns:minmax(0,1fr) 92px}.sk-panel h4{font-size:20px}}";

  /* ---------- reading names aloud (Web Speech API) ---------- */
  var canSpeak = "speechSynthesis" in window && "SpeechSynthesisUtterance" in window;
  function voice(prefixes){
    var vs = speechSynthesis.getVoices() || [];
    for (var i = 0; i < prefixes.length; i++) for (var j = 0; j < vs.length; j++) if (vs[j].lang && vs[j].lang.toLowerCase().indexOf(prefixes[i]) === 0) return vs[j];
    return null;
  }
  if (canSpeak) { try { speechSynthesis.getVoices(); speechSynthesis.onvoiceschanged = function(){}; } catch (e) {} }
  function say(id, btn){
    if (!canSpeak) return;
    var b = B[id]; speechSynthesis.cancel();
    var u1 = new SpeechSynthesisUtterance(b.la), v1 = voice(["la", "it", "es", "en"]);
    if (v1) { u1.voice = v1; u1.lang = v1.lang; } else u1.lang = "it-IT";
    u1.rate = .85;
    var q = [u1], vh = voice(["he", "iw"]);
    if (vh) { var u2 = new SpeechSynthesisUtterance(b.he); u2.voice = vh; u2.lang = vh.lang; u2.rate = .95; q.push(u2); }
    if (btn) { btn.classList.add("on"); q[q.length - 1].onend = q[q.length - 1].onerror = function(){ btn.classList.remove("on"); }; }
    q.forEach(function(u){ speechSynthesis.speak(u); });
  }

  /* ---------- behaviour ---------- */
  function init(root){
    if (root.dataset.init) return; root.dataset.init = "1";
    if (!document.getElementById("skCss")) { var st = document.createElement("style"); st.id = "skCss"; st.textContent = CSS; document.head.appendChild(st); }
    root.className = "sk";
    root.innerHTML = '<div class="sk-bar" role="toolbar" aria-label="מצב הסימולטור">'
      + '<button type="button" data-mode="explore" aria-pressed="true">🔍 חקירה</button>'
      + '<button type="button" data-mode="quiz" aria-pressed="false">🎯 בחן את עצמך</button>'
      + '<button type="button" data-groups aria-pressed="false">צבע לפי שלד הציר / הגפיים</button>'
      + '<button type="button" class="sk-quizonly" data-skip>דלג</button></div>'
      + '<div class="sk-grid"><div class="sk-stage">' + front() + '<div class="sk-tip"></div></div>' + side() + '</div>'
      + '<div class="sk-legend"><span><i style="background:#93B4F5"></i>שלד הציר</span><span><i style="background:#F5C27A"></i>שלד הגפיים</span></div>'
      + '<div class="sk-panel" aria-live="polite"></div>'
      + '<div class="sk-list" aria-label="רשימת העצמות">' + ORDER.map(function(id){ return '<button type="button" data-pick="' + id + '"><bdi lang="la">' + B[id].la + '</bdi><small>' + B[id].he + '</small></button>'; }).join("") + '</div>';
    var panel = root.querySelector(".sk-panel"), tip = root.querySelector(".sk-tip"), stage = root.querySelector(".sk-stage");
    root.querySelectorAll(".sk-bone").forEach(function(el){ el.setAttribute("data-g", B[el.dataset.b].g === AX ? "ax" : "ap"); });
    var mode = "explore", sel = null, quiz = null;

    function mark(id, cls){
      root.querySelectorAll(".sk-bone." + cls).forEach(function(e){ e.classList.remove(cls); });
      if (id) root.querySelectorAll('.sk-bone[data-b="' + id + '"]').forEach(function(e){ e.classList.add(cls); });
    }
    function info(id){
      var b = B[id];
      return '<h4 class="la-main"><span lang="la" dir="ltr">' + b.la + '</span>' + (canSpeak ? '<button type="button" class="sk-say" data-say="' + id + '" aria-label="הקראת השם ' + b.la + '" title="הקראה">🔊</button>' : '') + '</h4><div class="he-sub">' + b.he + (b.en && b.en !== b.la ? ' <span class="en">· במצגת: <bdi>' + b.en + '</bdi></span>' : '') + '</div><div class="sk-chips"><span class="sk-chip ' + (b.g === AP ? "ap" : "") + '">' + b.g + '</span>'
        + (b.n ? '<span class="sk-chip">' + b.n + '</span>' : '') + '</div><p>' + b.fact + '</p>';
    }
    function showTip(id, ev){
      var r = stage.getBoundingClientRect(), x, y;
      if (ev && ev.clientX) { x = ev.clientX - r.left; y = ev.clientY - r.top; }
      else { var bb = root.querySelector('.sk-front .sk-bone[data-b="' + id + '"]'); if (!bb) { tip.classList.remove("show"); return; } var q = bb.getBoundingClientRect(); x = q.left + q.width / 2 - r.left; y = q.top - r.top + 6; }
      tip.innerHTML = '<span class="tl" lang="la" dir="ltr">' + B[id].la + '</span> <span class="th">(' + B[id].he + ')</span>'
        + (canSpeak ? '<button type="button" class="sk-say" data-say="' + id + '" aria-label="הקראת השם ' + B[id].la + '" title="הקראה">🔊</button>' : '');
      tip.style.left = Math.max(90, Math.min(r.width - 90, x)) + "px"; tip.style.top = Math.max(34, y) + "px"; tip.classList.add("show");
    }
    function explore(id, ev){
      sel = id; mark(id, "on"); panel.innerHTML = info(id); showTip(id, ev);
      root.querySelectorAll(".sk-list button").forEach(function(b){ b.classList.toggle("on", b.dataset.pick === id); });
    }
    function newQ(){
      var pool = ORDER.filter(function(id){ return id !== (quiz && quiz.target); });
      quiz.target = pool[(Math.random() * pool.length) | 0]; quiz.tries = 0; tip.classList.remove("show");
      mark(null, "ok"); mark(null, "bad"); mark(null, "on");
      panel.innerHTML = '<p class="sk-q">איפה נמצא/ת: <b lang="la" dir="ltr">' + B[quiz.target].la + '</b>?</p><p class="sk-hint">לוחצים על העצם בשלד' + (/spine|sacrum|coccyx/.test(quiz.target) ? ' (אפשר גם במבט מהצד)' : '') + '.</p><p class="sk-score">ניקוד: ' + quiz.right + ' מתוך ' + quiz.asked + '</p>';
    }
    function answer(id, ev){
      if (!quiz.target) return;
      if (id === quiz.target) {
        if (quiz.tries === 0) quiz.right++; quiz.asked++;
        mark(id, "ok"); showTip(id, ev);
        panel.innerHTML = '<p class="sk-q">✅ נכון!</p>' + info(id) + '<p class="sk-score">ניקוד: ' + quiz.right + ' מתוך ' + quiz.asked + '</p>';
        quiz.target = null; setTimeout(newQ, 2300);
      } else {
        quiz.tries++; mark(id, "bad"); showTip(id, ev);
        if (quiz.tries >= 2) {
          quiz.asked++; mark(quiz.target, "ok");
          panel.innerHTML = '<p class="sk-q">לא בדיוק. לחצת על <bdi>' + B[id].la + '</bdi> (' + B[id].he + ').</p><p><bdi>' + B[quiz.target].la + '</bdi> (' + B[quiz.target].he + ') מסומן/ת עכשיו בירוק.</p><p class="sk-score">ניקוד: ' + quiz.right + ' מתוך ' + quiz.asked + '</p>';
          quiz.target = null; setTimeout(newQ, 2600);
        } else {
          panel.innerHTML = '<p class="sk-q">זה <bdi>' + B[id].la + '</bdi> (' + B[id].he + '). נסו שוב: איפה <b lang="la" dir="ltr">' + B[quiz.target].la + '</b>?</p><p class="sk-score">ניקוד: ' + quiz.right + ' מתוך ' + quiz.asked + '</p>';
        }
      }
    }
    function pick(id, ev){ if (mode === "quiz") answer(id, ev); else explore(id, ev); }
    root.addEventListener("click", function(e){
      var sb = e.target.closest && e.target.closest("[data-say]"); if (sb) { e.stopPropagation(); say(sb.dataset.say, sb); return; }
      var bone = e.target.closest && e.target.closest(".sk-bone"); if (bone) { pick(bone.dataset.b, e); return; }
      var p = e.target.closest && e.target.closest("[data-pick]"); if (p) { explore(p.dataset.pick); return; }
      if (e.target.closest && e.target.closest(".sk-stage") && !e.target.closest(".sk-tip")) tip.classList.remove("show");
      var m = e.target.closest && e.target.closest("[data-mode]");
      if (m) { mode = m.dataset.mode; root.classList.toggle("quiz", mode === "quiz");
        root.querySelectorAll("[data-mode]").forEach(function(b){ b.setAttribute("aria-pressed", String(b === m)); });
        if (mode === "quiz") { quiz = {right:0, asked:0, target:null}; newQ(); } else { mark(null, "ok"); mark(null, "bad"); start(); } return; }
      if (e.target.closest && e.target.closest("[data-groups]")) { var on = root.classList.toggle("groups"); e.target.closest("[data-groups]").setAttribute("aria-pressed", String(on)); return; }
      if (e.target.closest && e.target.closest("[data-skip]") && quiz) { quiz.asked++; mark(quiz.target, "ok"); var t = quiz.target; quiz.target = null; panel.innerHTML = '<p class="sk-q"><bdi>' + B[t].la + '</bdi> (' + B[t].he + ') מסומן/ת בירוק.</p><p class="sk-score">ניקוד: ' + quiz.right + ' מתוך ' + quiz.asked + '</p>'; setTimeout(newQ, 1800); }
    });
    root.addEventListener("keydown", function(e){ if ((e.key === "Enter" || e.key === " ") && e.target.classList && e.target.classList.contains("sk-bone")) { e.preventDefault(); pick(e.target.dataset.b); } });
    function start(){ sel = null; mark(null, "on"); root.querySelectorAll(".sk-list button").forEach(function(b){ b.classList.remove("on"); });
      panel.innerHTML = '<p class="sk-q">לוחצים על עצם כדי לראות את השם שלה</p><p class="sk-hint">אפשר גם לבחור מהרשימה למטה. במצב "בחן את עצמך" מקבלים שם של עצם, וצריך למצוא אותה בשלד.</p>'; }
    start();
  }
  function scan(){ var el = document.getElementById("skelSim"); if (el && !el.dataset.init) init(el); }
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", scan); else scan();
  new MutationObserver(scan).observe(document.documentElement, {childList:true, subtree:true});
})();
