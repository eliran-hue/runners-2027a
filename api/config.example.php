<?php
/**
 * מעתיקים את הקובץ הזה ל-config.php (באותה תיקייה, api/) וממלאים את פרטי
 * בסיס הנתונים מעמוד Access Details של האפליקציה ב-Cloudways.
 *
 * config.php נמצא ב-.gitignore בכוונה: אסור שיגיע ל-GitHub.
 */
return [
    'db_host' => 'localhost',
    'db_name' => 'your_db_name',
    'db_user' => 'your_db_user',
    'db_pass' => 'your_db_password',
    // כתובת השולח. חייבת להיות בדומיין שמאומת ב-Elastic Email.
    'mail_from' => 'noreply@runners2027.fyi',
    'mail_from_name' => 'מדריכי ריצות ארוכות 2027א',
];
