<?php
/* גיבוי: אם כלל ה-Rewrite לא הופעל, גם /science/ עובר דרך בדיקת ההרשאה. */
$_GET['f'] = (string)($_GET['p'] ?? '');
require __DIR__ . '/../api/science_gate.php';
