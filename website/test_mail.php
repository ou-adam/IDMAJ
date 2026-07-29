<?php
// website/test_mail.php: Test Email Sender with full debug log output
require_once 'includes/mailer.php';

$testTo = isset($_GET['to']) ? trim($_GET['to']) : 'contact@afye.dz';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test d'envoi Email - IDMAJ</title>
</head>
<body style="background-color: #0b0f19; color: #f8fafc; font-family: sans-serif; padding: 2rem;">

<div style="max-width: 700px; margin: 0 auto; background: #1e293b; border: 1px solid #334155; padding: 2rem; border-radius: 12px;">
    <h2 style="color: #38bdf8; margin-top: 0;">📩 Test de diagnostic Email IDMAJ</h2>
    
    <form method="GET" style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-size: 0.9rem; color: #94a3b8;">Adresse email de destination pour le test :</label>
        <input type="email" name="to" value="<?php echo htmlspecialchars($testTo); ?>" style="width: 70%; padding: 8px 12px; background: #0f172a; border: 1px solid #334155; color: #fff; border-radius: 6px;">
        <button type="submit" style="padding: 8px 16px; background: #0284c7; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Tester l'envoi</button>
    </form>

<?php
$subject = "Test Email IDMAJ - " . date('d/m/Y H:i:s');
$body = get_email_header_template("اختبار إرسال البريد الإلكتروني");
$body .= "<p>هذه رسالة تجريبية للتأكد من وصول التنبيهات بنجاح من منصة إدماج 2026.</p>";
$body .= get_email_footer_template();

$result = send_app_email($testTo, $subject, $body);
?>

    <div style="background: #0f172a; border: 1px solid <?php echo $result['success'] ? '#10b981' : '#f43f5e'; ?>; padding: 15px; border-radius: 8px; margin-top: 15px;">
        <h3 style="margin-top: 0; color: <?php echo $result['success'] ? '#10b981' : '#f43f5e'; ?>;">
            <?php echo $result['success'] ? '✅ E-mail envoyé avec succès !' : '❌ Échec d’envoi'; ?>
        </h3>
        <p style="margin: 5px 0;"><strong>Statut :</strong> <?php echo htmlspecialchars($result['message']); ?></p>
    </div>

    <h4 style="color: #94a3b8; margin-top: 20px;">📋 Journal de connexion (Logs) :</h4>
    <pre style="background: #090d16; color: #38bdf8; padding: 15px; border-radius: 6px; font-size: 13px; overflow-x: auto; max-height: 300px;"><?php
    if (!empty($result['log'])) {
        foreach ($result['log'] as $line) {
            echo htmlspecialchars($line) . "\n";
        }
    } else {
        echo "Aucun log journalisé.";
    }
    ?></pre>
</div>

</body>
</html>
