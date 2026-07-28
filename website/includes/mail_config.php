<?php
// includes/mail_config.php - SMTP Mail Configuration

// SMTP Server Configuration (Papercut default: 127.0.0.1:25)
define('SMTP_ENABLED', true);
define('SMTP_HOST', '127.0.0.1');
define('SMTP_PORT', 25);
define('SMTP_AUTH', false); // Papercut does not require auth
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('SMTP_SECURE', ''); // '', 'tls', or 'ssl'

// Sender Details
define('MAIL_FROM_ADDRESS', 'noreply@idmadj.dz');
define('MAIL_FROM_NAME', 'منصة إدماج IDMAJ 2026');

// Recipient Email for Admin Notifications (All form submissions & registrations)
define('ADMIN_NOTIFY_EMAIL', 'contact@idmadj.dz');

?>
