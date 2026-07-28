<?php
// db_setup.php: Automated MySQL Database Installer & Diagnostics Tool

header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/includes/db.php';
$sql_file = __DIR__ . '/schema.sql';


echo "<!DOCTYPE html>
<html lang='ar' dir='rtl'>
<head>
    <meta charset='UTF-8'>
    <title>تثبيت وفحص قاعدة البيانات</title>
    <style>
        body { font-family: sans-serif; background-color: #0f172a; color: #f8fafc; padding: 3rem 2rem; direction: rtl; text-align: right; }
        .card { background-color: #1e293b; border: 1px solid rgba(255,255,255,0.1); padding: 2rem; border-radius: 0.8rem; max-width: 700px; margin: 0 auto; }
        h1 { color: #0ea5e9; font-size: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.8rem; margin-bottom: 1.5rem; }
        .log-item { padding: 0.6rem 1rem; margin-bottom: 0.8rem; border-radius: 0.4rem; font-size: 0.9rem; font-family: monospace; }
        .success { background-color: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #10b981; }
        .error { background-color: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #ef4444; }
        .info { background-color: rgba(14, 165, 233, 0.15); border: 1px solid #0ea5e9; color: #0ea5e9; }
        .btn { display: inline-block; background-color: #0ea5e9; color: #fff; padding: 0.8rem 2rem; border-radius: 0.5rem; text-decoration: none; font-weight: bold; margin-top: 1.5rem; }
    </style>
</head>
<body>
    <div class='card'>
        <h1>🛠️ معالج تثبيت وفحص قاعدة بيانات إدماج</h1>";

try {
    echo "<div class='log-item success'>✅ تم الاتصال بخادم MySQL بنجاح عبر (includes/db.php)!</div>";


    // 2. Check if schema.sql exists
    if (!file_exists($sql_file)) {
        throw new Exception("لم يتم العثور على ملف الاستعلامات '$sql_file' في نفس المجلد. يرجى التأكد من نسخه.");
    }
    echo "<div class='log-item success'>✅ تم العثور على ملف الاستعلامات ($sql_file) بنجاح.</div>";

    // 3. Read and execute SQL statements
    echo "<div class='log-item info'>⏳ جاري قراءة وتنفيذ أوامر SQL لإنشاء الجداول وحساب المسؤول...</div>";
    $sql_queries = file_get_contents($sql_file);
    
    $pdo->exec($sql_queries);
    echo "<div class='log-item success'>✅ تم إنشاء كافة الجداول وحساب المسؤول في قاعدة البيانات ($db) بنجاح!</div>";

    // 4. Verify registrations and users table exist
    echo "<div class='log-item info'>⏳ جاري التحقق النهائي من الجداول المنشأة...</div>";
    
    $tables = ['users', 'registrations', 'b2b_requests', 'hackathon_teams', 'pitch_submissions', 'messages'];
    $all_exist = true;
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt && $stmt->fetch()) {
            echo "<div class='log-item success'>✔️ جدول [$table] جاهز للعمل.</div>";
        } else {
            echo "<div class='log-item error'>❌ جدول [$table] غير موجود!</div>";
            $all_exist = false;
        }
    }

    if ($all_exist) {
        echo "<h3 style='color:#10b981; margin-top:1.5rem;'>🎉 قاعدة البيانات جاهزة ومثبتة بنجاح بنسبة 100%!</h3>";
        echo "<p style='font-size:0.9rem;'>يمكنك الآن تسجيل الدخول للوحة التحكم باستخدام:<br>اسم المستخدم: <strong>admin</strong><br>كلمة المرور: <strong>password123</strong></p>";
        echo "<a href='index.php' class='btn'>اذهب للموقع الرئيسي</a>";
    } else {
        echo "<h3 style='color:#ef4444; margin-top:1.5rem;'>⚠️ تم التثبيت مع وجود نقص في بعض الجداول.</h3>";
    }

} catch (\Exception $e) {
    echo "<div class='log-item error'>❌ فشل في التثبيت: " . $e->getMessage() . "</div>";
    echo "<p style='margin-top:1.5rem; font-size:0.9rem;'>نصيحة: تأكد من أن خادم MySQL في WAMP يعمل وأن كلمة المرور لمستخدم root فارغة (أو قم بتعديلها في أول الملف إذا كانت غير ذلك).</p>";
}

echo "</div>
</body>
</html>";
?>
