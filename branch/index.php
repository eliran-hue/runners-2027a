<?php
/* גיבוי: אם כלל ה-Rewrite לא הופעל, גם /branch/ עובר דרך בדיקת ההרשאה. */
$_GET['f'] = (string)($_GET['p'] ?? '');
require __DIR__ . '/../api/branch_gate.php';
