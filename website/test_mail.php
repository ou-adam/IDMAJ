<?php
// website/test_mail.php - Standalone SMTP Tester
require_once 'includes/mailer.php';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>اختبار البريد الإلكتروني SMTP - Papercut Test</title>
    <style>
        body { font-family: Tahoma, sans-serif; background: #0f172a; color: #f8fafc; padding: 30px; line-height: 1.6; }
        .box { max-width: 800px; margin: 0 auto; background: #1e293b; padding: 25px; border-radius: 12px; border: 1px solid #334155; }
        h1 { color: #38bdf8; border-bottom: 2px solid #334155; padding-bottom: 10px; }
        .success { background: #064e3b; color: #6ee7b7; padding: 15px; border-radius: 8px; margin: 15px 0; border: 1px solid #047857; }
        .error { background: #7f1d1d; color: #fca5a5; padding: 15px; border-radius: 8px; margin: 15px 0; border: 1px solid #b91c1c; }
        pre { background: #090d16; padding: 15px; border-radius: 8px; color: #a7f3d0; overflow-x: auto; font-family: monospace; }
        .btn { display: inline-block; background: #0284c7; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 15px; }
        .btn:hover { background: #0369a1; }
    </style>
</head>
<body>
<div class="box">
    <h1>اختبار ربط خادم البريد SMTP (Papercut)</h1>
    <p>إعدادات الخادم الحالية: <strong><?php echo SMTP_HOST . ':' . SMTP_PORT; ?></strong></p>

    <?php
    if (isset($_GET['run'])) {
        echo "<p>جاري إرسال رسالة تجريبية...</p>";
        $mailer = new SimpleSMTPMailer();
        $testEmail = isset($_GET['email']) ? $_GET['email'] : ADMIN_NOTIFY_EMAIL;
        $res = $mailer->send(
            $testEmail,
            "رسالة اختبار SMTP من منصة إدماج IDMAJ - " . date('H:i:s'),
            "<h2>اختبار نجاح إرسال البريد الإلكتروني</h2><p>هذه الرسالة تؤكد أن خادم SMTP (Papercut) يعمل بشكل ممتاز ويستقبل كافة المراسلات والتحويلات الخاصة بتسجيلات وفورمات الموقع بنجاح.</p><p>الوقت: " . date('Y-m-d H:i:s') . "</p>"
        );

        if ($res['success']) {
            echo "<div class='success'>✔ تم إرسال الرسالة بنجاح عبر SMTP! يرجى مراجعة برنامج Papercut على جهازك.</div>";
        } else {
            echo "<div class='error'>❌ حدث خطأ أثناء الإرسال: " . htmlspecialchars($res['message']) . "</div>";
        }

        echo "<h3>سجل معاملات SMTP (SMTP Handshake Protocol Logs):</h3>";
        echo "<pre>";
        foreach ($res['log'] as $line) {
            echo htmlspecialchars($line) . "\n";
        }
        echo "</pre>";
    }
    ?>

    <a href="test_mail.php?run=1" class="btn">إرسال رسالة اختبار الآن (Send Test Email)</a>
</div>
</body>
</html>
