<?php
// includes/db.php: Database Connection using PDO

$host = '127.0.0.1';
$db   = 'idmadj_db';
$user = 'root';
$pass = ''; // Leave blank for default XAMPP/WAMP setups
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     $pdo->exec("SET NAMES utf8mb4");
} catch (\PDOException $e) {
     // In development, show error. In production, log it.
     die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>
