<?php
/* גיבוי: אם כלל ה-Rewrite לא הופעל, גם /science/ עובר דרך בדיקת ההרשאה. */
$_GET['f'] = '';
require __DIR__ . '/../api/science_gate.php';
