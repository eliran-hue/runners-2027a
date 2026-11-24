<?php
/* גיבוי: אם כלל ה-Rewrite לא הופעל, גם /branch/ עובר דרך בדיקת ההרשאה. */
$_GET['f'] = '';
require __DIR__ . '/../api/branch_gate.php';
