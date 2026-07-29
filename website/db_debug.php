<?php
// website/db_debug.php: Test Hostinger MySQL DB connection & user permissions
header('Content-Type: text/html; charset=utf-8');

$host = 'localhost';
$user = 'u970568928_idmaj';
$pass = 'Babou2026@@';

$databases_to_test = [
    'u970568928_idmaj',
    'u970568928_idmadj',
    'u970568928_idmadj_db',
    'u970568928_db',
    'u970568928_idmaj_db'
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Diagnostic BDD Hostinger</title>
</head>
<body style="background: #0b0f19; color: #f8fafc; font-family: sans-serif; padding: 2rem;">

<div style="max-width: 650px; margin: 0 auto; background: #1e293b; border: 1px solid #334155; padding: 2rem; border-radius: 12px;">
    <h2 style="color: #38bdf8; margin-top: 0;">🔍 Diagnostic Connexion BDD Hostinger</h2>
    <p style="color: #94a3b8; font-size: 0.9rem;">Test de l'utilisateur MySQL : <code>u970568928_idmaj</code></p>

    <div style="background: #0f172a; padding: 1.5rem; border-radius: 8px; margin-top: 1.5rem;">
<?php
$connected = false;
foreach ($databases_to_test as $db_name) {
    try {
        $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        echo "<p style='color: #10b981; margin: 8px 0;'><strong>✅ SUCCÈS :</strong> Connecté avec succès à la base <code>{$db_name}</code> !</p>";
        $connected = true;
    } catch (\PDOException $e) {
        echo "<p style='color: #f43f5e; margin: 8px 0;'><strong>❌ Test [{$db_name}] :</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>
    </div>

    <?php if (!$connected): ?>
    <div style="background: #450a0a; border: 1px solid #ef4444; padding: 1rem; border-radius: 8px; margin-top: 1.5rem; color: #fca5a5; font-size: 0.9rem; line-height: 1.6;">
        <strong>📌 Solution dans Hostinger hPanel :</strong><br>
        1. Allez dans <strong>Hostinger hPanel &rarr; Bases de données (Databases) &rarr; Bases de données MySQL</strong>.<br>
        2. Vérifiez le nom exact de la base de données créée.<br>
        3. Assurez-vous d'ajouter l'utilisateur <code>u970568928_idmaj</code> à cette base avec <strong>Tous les privilèges</strong>.
    </div>
    <?php endif; ?>
</div>

</body>
</html>
