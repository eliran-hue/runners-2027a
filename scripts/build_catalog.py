# Builds api/_catalog.php: every topic page with chapters (address, course, title, chapters [id, title]).
# Run again whenever chapters are added, removed or renamed.
import re,os,json
root=os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
pages=[('branch','anatomy','/branch/anatomy/'),('branch','physiology','/branch/physiology/'),('branch','training','/branch/training/'),('branch','planning','/branch/planning/'),('branch','methodology','/branch/methodology/'),
       ('science','anatomy/unit1','/science/anatomy/unit1/'),('science','anatomy/unit3','/science/anatomy/unit3/'),('science','anatomy/unit4','/science/anatomy/unit4/')]
out=[]
for area,src,url in pages:
    s=open(f'{root}/{area}_src/{src}.html.php').read()
    h1=re.search(r'<h1>([^<]*)',s).group(1).strip()
    # each chapter object opens with {id:"..." and has a title:"..." field (with other fields like unit: possibly before it)
    ch=re.findall(r'\{id:"([a-z0-9_-]+)",(?:[a-z]+:"[^"]*",)*?title:"([^"]*)"',s)
    out.append({'url':url,'course':'branch' if area=='branch' else 'science','title':h1,'chapters':[{'id':i,'title':t} for i,t in ch]})
php="<?php\n/* נוצר אוטומטית (catalog.py): כל עמודי הנושא עם הפרקים שלהם. משמש את עמוד הניהול לסימון 'עוד לא נלמד בכיתה'. */\nreturn json_decode(<<<'JSON'\n" + json.dumps(out,ensure_ascii=False,indent=1) + "\nJSON, true);\n"
open(f'{root}/api/_catalog.php','w').write(php)
for p in out: print(p['url'],len(p['chapters']))
print(sum(len(p['chapters']) for p in out),'chapters')
