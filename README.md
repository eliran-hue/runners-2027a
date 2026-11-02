# האתר למדריכי ריצות ארוכות · סמסטר 2027א

אתר לימוד לקורס מדריכי ריצות ארוכות: כל חומר המצגות בשפה פשוטה, עם בוחן בסוף כל פרק. האתר מתארח ב-Cloudways ומתעדכן אוטומטית בכל push ל-`main` (ראו "פריסה" למטה).

## קבצים

- `index.html`: העמוד הראשי, עם קישור לכל נושא ופס התקדמות.
- `anatomy.html`: האנטומיה של הריצה (5 פרקים).
- `physiology.html`: הפיזיולוגיה של הריצה (7 פרקים, כולל מחשבון קרבונן).
- `.github/workflows/cloudways-deploy.yml`: העלאה אוטומטית ל-Cloudways בכל push.

כל עמוד עומד בפני עצמו: ה-CSS, ה-JavaScript והתמונות נמצאים בתוך הקובץ, ואין צורך בשרת או בבסיס נתונים. ההתקדמות נשמרת ב-`localStorage` של הדפדפן.

## הוספת נושא חדש

1. מוסיפים קובץ `<נושא>.html`.
2. מוסיפים כרטיס ב-`index.html` (עם `data-key` ו-`data-total` לפס ההתקדמות).
3. מוסיפים קישור בסרגל הניווט (`nav.sb`) בכל העמודים.

## פריסה (Cloudways + GitHub Actions)

כל `push` ל-`main` מפעיל את `.github/workflows/cloudways-deploy.yml`, שקורא ל-API של Cloudways כדי למשוך (`git pull`) את הקוד העדכני לאפליקציה. הענף (`main`) ותיקיית היעד (`public_html`) קבועים בקובץ. שלושת הסודות הנדרשים (`CLOUDWAYS_API_KEY`, ובו Access Token של Cloudways, `CLOUDWAYS_SERVER_ID` ו-`CLOUDWAYS_APP_ID`) מוגדרים ב-Settings → Secrets and variables → Actions של הריפו.
