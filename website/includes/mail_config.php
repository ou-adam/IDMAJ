<?php
// includes/mail_config.php - SMTP & Email Configuration for IDMAJ

// --- Hostinger / External SMTP Settings ---
// If you create an email address on Hostinger (e.g. contact@idmadj.dz), enter details here:
$smtp_user = ''; // e.g. 'contact@idmadj.dz'
$smtp_pass = ''; // e.g. your Hostinger email password

if (!empty($smtp_user) && !empty($smtp_pass)) {
    // 1. Hostinger / Custom SMTP Mode
    define('SMTP_ENABLED', true);
    define('SMTP_HOST', 'smtp.hostinger.com');
    define('SMTP_PORT', 465); // 465 for SSL, 587 for TLS
    define('SMTP_AUTH', true);
    define('SMTP_USER', $smtp_user);
    define('SMTP_PASS', $smtp_pass);
    define('SMTP_SECURE', 'ssl');
} else {
    // 2. Localhost vs Production auto-detection
    $is_localhost = isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);
    
    if ($is_localhost) {
        // Local Papercut SMTP Testing (127.0.0.1:25)
        define('SMTP_ENABLED', true);
        define('SMTP_HOST', '127.0.0.1');
        define('SMTP_PORT', 25);
        define('SMTP_AUTH', false);
        define('SMTP_USER', '');
        define('SMTP_PASS', '');
        define('SMTP_SECURE', '');
    } else {
        // Production Hostinger Native PHP mail() Mode (Fast & uses sendmail with -f parameter)
        define('SMTP_ENABLED', false);
        define('SMTP_HOST', 'localhost');
        define('SMTP_PORT', 25);
        define('SMTP_AUTH', false);
        define('SMTP_USER', '');
        define('SMTP_PASS', '');
        define('SMTP_SECURE', '');
    }
}

// Sender Details
define('MAIL_FROM_ADDRESS', !empty($smtp_user) ? $smtp_user : 'contact@idmadj.dz');
define('MAIL_FROM_NAME', 'منصة إدماج IDMAJ 2026');

// Recipient Email for Admin Notifications (All form submissions & registrations)
define('ADMIN_NOTIFY_EMAIL', 'contact@idmadj.dz');
