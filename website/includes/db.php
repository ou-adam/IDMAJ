<?php
// includes/db.php: Database Connection using PDO with Environment & Database Candidate Auto-detection

$is_cli = (php_sapi_name() === 'cli');
$is_local_web = isset($_SERVER['HTTP_HOST']) && (
    strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || 
    strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false
);

$is_localhost = $is_cli || $is_local_web;

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
];

if ($is_localhost) {
    // 1. Local WAMP / XAMPP Environment
    $host = '127.0.0.1';
    $db   = 'idmadj_db';
    $user = 'root';
    $pass = '';

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        die("خطأ في الاتصال بقاعدة البيانات المحلية: " . $e->getMessage());
    }
} else {
    // 2. Hostinger Production Environment (idmaj.afye.dz)
    $host = 'localhost';
    $user = 'u970568928_idmaj';
    $pass = 'Babou2026@@';

    // Candidate database names on Hostinger
    $db_candidates = [
        'u970568928_idmaj',
        'u970568928_idmadj',
        'u970568928_idmadj_db'
    ];

    $pdo = null;
    $last_error = null;

    foreach ($db_candidates as $db_name) {
        try {
            $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";
            $conn = new PDO($dsn, $user, $pass, $options);
            $pdo = $conn;
            $db = $db_name;
            break;
        } catch (\PDOException $ex) {
            $last_error = $ex;
        }
    }

    if (!$pdo) {
        die("خطأ في الاتصال بقاعدة البيانات: " . $last_error->getMessage());
    }
}
?>
