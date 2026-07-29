<?php
// website/admin/reset_admin.php: Standalone Admin Account Reset Script
require_once '../includes/db.php';

$password = 'password123';
$hash = password_hash($password, PASSWORD_BCRYPT);

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation Admin IDMAJ</title>
</head>
<body style="background-color: #0b0f19; color: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0;">

<div style="background-color: #1e293b; border: 1px solid #334155; padding: 2.5rem; border-radius: 1rem; text-align: center; max-width: 480px; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
<?php
try {
    // 1. Ensure users table exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('super_admin', 'content_manager', 'registration_manager', 'sponsors_manager', 'b2b_manager', 'hackathon_manager', 'media_manager') NOT NULL DEFAULT 'registration_manager',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;");

    // 2. Insert or update admin user
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES ('admin', ?, 'super_admin') ON DUPLICATE KEY UPDATE password = VALUES(password)");
    $stmt->execute([$hash]);

    echo '<h2 style="color: #38bdf8; margin-top: 0;">✅ Compte Admin Prêt !</h2>';
    echo '<p style="color: #94a3b8; font-size: 0.95rem;">Le compte administrateur a été configuré avec succès dans la base de données.</p>';
    echo '<div style="background-color: #0f172a; border: 1px solid #3b82f6; padding: 1rem; border-radius: 0.5rem; margin: 1.5rem 0;">';
    echo '<p style="margin: 0.3rem 0; font-size: 1.05rem;"><strong>Utilisateur :</strong> <code style="color: #38bdf8;">admin</code></p>';
    echo '<p style="margin: 0.3rem 0; font-size: 1.05rem;"><strong>Mot de passe :</strong> <code style="color: #38bdf8;">password123</code></p>';
    echo '</div>';
    echo '<a href="index.php" style="display: inline-block; background-color: #0284c7; color: white; padding: 0.8rem 2rem; border-radius: 0.5rem; text-decoration: none; font-weight: bold; margin-top: 0.5rem;">Se connecter à la لوحة التحكم &rarr;</a>';
} catch (\PDOException $e) {
    echo '<h2 style="color: #f87171; margin-top: 0;">❌ Erreur Base de Données</h2>';
    echo '<p style="color: #cbd5e1; font-size: 0.9rem; word-break: break-all;">' . htmlspecialchars($e->getMessage()) . '</p>';
}
?>
</div>

</body>
</html>
