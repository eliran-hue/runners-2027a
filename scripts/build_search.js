/* Builds api/_search_index.php: the text of every chapter in the site, split into sections, for the site search.
   Run again whenever chapter content changes:   node scripts/build_search.js
   Needs Playwright + Chrome (in Claude's workspace: /opt/npm-tools/node_modules/playwright and /usr/bin/google-chrome).

   How it works: each page in branch_src/ and science_src/ is served locally (without its PHP guard line) and opened in
   headless Chrome. The page's own `chapters` array is rendered (html() of every chapter), so the index holds exactly the
   text learners see, including collapsed "more" boxes, chart captions, quizzes and flashcards.
   One record per section: {u: page url, p: page title, c: chapter id, n: chapter number, t: chapter title,
   s: section title, k: "text" | "quiz" | "cards" | "tool", x: plain text}. */
"use strict";
const fs = require("fs"), path = require("path"), http = require("http");
let pw;
try { pw = require("playwright"); } catch (e) { pw = require("/opt/npm-tools/node_modules/playwright"); }

const ROOT = path.resolve(__dirname, "..");
/* [course, source file (without .html.php), page url] */
const PAGES = [
  ["branch", "tools", "/branch/tools/"],
  ["branch", "anatomy", "/branch/anatomy/"],
  ["branch", "physiology", "/branch/physiology/"],
  ["branch", "training", "/branch/training/"],
  ["branch", "planning", "/branch/planning/"],
  ["branch", "methodology", "/branch/methodology/"],
  ["science", "anatomy/unit1", "/science/anatomy/unit1/"],
  ["science", "anatomy/unit3", "/science/anatomy/unit3/"],
  ["science", "anatomy/unit4", "/science/anatomy/unit4/"]
];

const TYPES = {".html": "text/html; charset=utf-8", ".css": "text/css", ".js": "application/javascript", ".svg": "image/svg+xml", ".woff": "font/woff", ".png": "image/png", ".jpg": "image/jpeg"};
function serve() {
  return new Promise(res => {
    const srv = http.createServer((req, rsp) => {
      const u = decodeURIComponent(new URL(req.url, "http://x").pathname);
      const m = u.match(/^\/__src\/(branch|science)\/(.+)\.html$/);
      let file = m ? path.join(ROOT, m[1] + "_src", m[2] + ".html.php") : path.join(ROOT, u);
      if (!file.startsWith(ROOT) || !fs.existsSync(file) || fs.statSync(file).isDirectory()) { rsp.writeHead(404); rsp.end(); return; }
      let body = fs.readFileSync(file);
      if (m) { const s = body.toString("utf8"); body = Buffer.from(s.slice(s.indexOf("\n") + 1)); }
      rsp.writeHead(200, {"Content-Type": (m ? TYPES[".html"] : TYPES[path.extname(file)]) || "application/octet-stream"});
      rsp.end(body);
    });
    srv.listen(0, "127.0.0.1", () => res(srv));
  });
}

/* Runs inside the page. */
function extract(kind) {
  const clean = s => String(s || "").replace(/\s+/g, " ").trim();
  /* a space after every block-level element, so "<div>זון 1</div><div>זון 2</div>" doesn't become "זון 1זון 2"
     (inline tags like <b> stay glued: "<b>י</b>ציבה" must stay "יציבה") */
  const BLOCK = ".tag,select,div,p,li,dt,dd,td,th,tr,h1,h2,h3,h4,h5,h6,label,option,figcaption,summary,section,br,button,text,tspan,span.n,span.ar,.k,.mini,.zt,.zn,.zd,.lv b,.lv span";
  const spaced = el => { el.querySelectorAll(BLOCK).forEach(x => x.after(" ")); return el; };
  const strip = h => { const d = document.createElement("div"); d.innerHTML = h; d.querySelectorAll("script,style").forEach(x => x.remove()); return spaced(d); };
  const h1 = clean((document.querySelector("h1") || {}).textContent);
  const out = [];
  if (kind === "tool") {
    document.querySelectorAll("main details, details").forEach(d => {
      const sm = d.querySelector("summary"); if (!sm) return;
      const s = clean((sm.querySelector("h2,h3") || sm).textContent);
      const body = spaced(d.cloneNode(true)); const bs = body.querySelector("summary"), hd = bs.querySelector("h2,h3"); if (hd) hd.remove();
      out.push({c: "", n: 0, t: "", s, k: "tool", x: clean(body.textContent)});
    });
    return {h1, out};
  }
  /* `chapters` / `cards` are top-level consts of the page script */
  const CH = (typeof chapters !== "undefined") ? chapters : [];
  const CARDS = (typeof cards !== "undefined") ? cards : [];
  CH.forEach((ch, i) => {
    const title = clean(ch.title), n = i + 1;
    let html = ""; try { html = typeof ch.html === "function" ? ch.html() : String(ch.html || ""); } catch (e) { html = ""; }
    const d = strip(html);
    /* sections: a top-level h3 starts a new section; a block with its own h3 is a section of its own */
    let cur = clean(ch.sub) ? title : title, buf = [], secs = [];
    const flush = (s) => { const x = clean(buf.join(" ")); if (x) secs.push({s, x}); buf = []; };
    let curTitle = title;
    Array.from(d.children).forEach(el => {
      if (/^H[23]$/.test(el.tagName)) { flush(curTitle); curTitle = clean(el.textContent) || title; buf.push(el.textContent); return; }
      const own = el.querySelector && el.querySelector("h3");
      if (own && el.firstElementChild === own) { flush(curTitle); const st = clean(own.textContent); buf.push(el.textContent); flush(st); return; }
      buf.push(el.textContent);
    });
    flush(curTitle);
    if (clean(ch.sub)) secs.unshift({s: title, x: clean(ch.sub)});
    secs.filter(sc => sc.x !== sc.s).forEach(sc => out.push({c: ch.id, n, t: title, s: sc.s, k: "text", x: sc.x}));
    if (Array.isArray(ch.quiz) && ch.quiz.length) {
      const q = ch.quiz.map(z => clean(strip(String(z[0])).textContent) + " " + (z[1] || []).map(o => clean(strip(String(o)).textContent)).join(" · ") + " " + clean(strip(String(z[3] || "")).textContent)).join(" | ");
      out.push({c: ch.id, n, t: title, s: "בוחן", k: "quiz", x: q});
    }
    if (CARDS.length && /id="fcCard"/.test(html)) {
      out.push({c: ch.id, n, t: title, s: "כרטיסיות לשינון", k: "cards", x: CARDS.map(c => clean(strip(String(c[0])).textContent) + ": " + clean(strip(String(c[1])).textContent)).join(" | ")});
    }
  });
  return {h1, out};
}

(async () => {
  const srv = await serve();
  const port = srv.address().port;
  const browser = await pw.chromium.launch({executablePath: fs.existsSync("/usr/bin/google-chrome") ? "/usr/bin/google-chrome" : undefined, args: ["--no-sandbox"]});
  const ctx = await browser.newContext();
  await ctx.route(/\/api\//, r => r.fulfill({status: 200, contentType: "application/json", body: '{"ok":false}'}));
  await ctx.route(/youtube|google|cloudflare/, r => r.abort());
  const idx = {branch: [], science: []};
  for (const [course, src, url] of PAGES) {
    const pg = await ctx.newPage();
    const errs = []; pg.on("pageerror", e => errs.push(e.message));
    await pg.goto(`http://127.0.0.1:${port}/__src/${course}/${src}.html`, {waitUntil: "load"});
    await pg.waitForTimeout(300);
    const {h1, out} = await pg.evaluate(extract, src === "tools" ? "tool" : "chapters");
    out.forEach(r => idx[course].push(Object.assign({u: url, p: h1}, r)));
    console.log(url.padEnd(30), String(out.length).padStart(4), "sections", errs.length ? "  page errors: " + errs.join(" / ") : "");
    await pg.close();
  }
  await browser.close(); srv.close();
  const php = "<?php\n/* נוצר אוטומטית (scripts/build_search.js): הטקסט של כל הפרקים, לחיפוש באתר. לא לערוך ידנית. */\nreturn [\n"
    + Object.keys(idx).map(k => `  '${k}' => <<<'JSON'\n${JSON.stringify(idx[k])}\nJSON,`).join("\n") + "\n];\n";
  fs.writeFileSync(path.join(ROOT, "api/_search_index.php"), php);
  for (const k in idx) console.log(k, idx[k].length, "records,", Math.round(JSON.stringify(idx[k]).length / 1024), "KB");
})().catch(e => { console.error(e); process.exit(1); });
