<?php
// includes/mailer.php - SMTP Engine & Notification Helper
require_once __DIR__ . '/mail_config.php';

class SimpleSMTPMailer {
    private $host;
    private $port;
    private $auth;
    private $username;
    private $password;
    private $secure;
    private $logs = [];

    public function __construct() {
        $this->host = defined('SMTP_HOST') ? SMTP_HOST : '127.0.0.1';
        $this->port = defined('SMTP_PORT') ? SMTP_PORT : 25;
        $this->auth = defined('SMTP_AUTH') ? SMTP_AUTH : false;
        $this->username = defined('SMTP_USER') ? SMTP_USER : '';
        $this->password = defined('SMTP_PASS') ? SMTP_PASS : '';
        $this->secure = defined('SMTP_SECURE') ? strtolower(SMTP_SECURE) : '';
    }

    private function log($msg) {
        $this->logs[] = "[" . date('H:i:s') . "] " . $msg;
    }

    public function getLogs() {
        return $this->logs;
    }

    public function send($to, $subject, $htmlMessage, $fromEmail = null, $fromName = null) {
        $fromEmail = $fromEmail ?: (defined('MAIL_FROM_ADDRESS') ? MAIL_FROM_ADDRESS : 'noreply@idmadj.dz');
        $fromName  = $fromName  ?: (defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'IDMAJ 2026');

        if (defined('SMTP_ENABLED') && !SMTP_ENABLED) {
            // Fallback to php native mail()
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <{$fromEmail}>\r\n";
            $headers .= "Reply-To: <{$fromEmail}>\r\n";
            $encodedSubject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
            $res = @mail($to, $encodedSubject, $htmlMessage, $headers, "-f " . $fromEmail);
            return ['success' => $res, 'message' => $res ? 'Mail sent via PHP mail()' : 'Failed PHP mail()', 'log' => ['Native mail() used']];
        }

        $remote = $this->host . ':' . $this->port;
        if ($this->secure === 'ssl') {
            $remote = 'ssl://' . $this->host . ':' . $this->port;
        }

        $context = stream_context_create([
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ]
        ]);

        $socket = @stream_socket_client($remote, $errno, $errstr, 5, STREAM_CLIENT_CONNECT, $context);
        if (!$socket) {
            $err = "SMTP Connection failed to {$remote}: [$errno] $errstr";
            $this->log($err);
            // Fallback to PHP native mail()
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <{$fromEmail}>\r\n";
            $headers .= "Reply-To: <{$fromEmail}>\r\n";
            $encodedSubject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
            $res = @mail($to, $encodedSubject, $htmlMessage, $headers, "-f " . $fromEmail);
            return ['success' => $res, 'message' => $res ? 'SMTP failed; sent via PHP mail() fallback' : $err, 'log' => $this->logs];
        }

        stream_set_timeout($socket, 3);

        $response = fgets($socket, 515);
        $this->log("SERVER: " . trim($response));

        // EHLO
        fputs($socket, "EHLO " . gethostname() . "\r\n");
        $this->log("CLIENT: EHLO " . gethostname());
        $response = $this->readResponse($socket);

        // TLS
        if ($this->secure === 'tls') {
            fputs($socket, "STARTTLS\r\n");
            $this->log("CLIENT: STARTTLS");
            $response = $this->readResponse($socket);
            if (substr($response, 0, 3) == '220') {
                stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
                fputs($socket, "EHLO " . gethostname() . "\r\n");
                $this->log("CLIENT: EHLO (after TLS) " . gethostname());
                $response = $this->readResponse($socket);
            }
        }

        // AUTH
        if ($this->auth) {
            fputs($socket, "AUTH LOGIN\r\n");
            $this->log("CLIENT: AUTH LOGIN");
            $response = $this->readResponse($socket);

            fputs($socket, base64_encode($this->username) . "\r\n");
            $this->log("CLIENT: [User Base64]");
            $response = $this->readResponse($socket);

            fputs($socket, base64_encode($this->password) . "\r\n");
            $this->log("CLIENT: [Pass Base64]");
            $response = $this->readResponse($socket);

            if (substr($response, 0, 3) !== '235') {
                $err = "SMTP Auth failed: " . trim($response);
                $this->log($err);
                @fclose($socket);

                // Fallback to PHP native mail()
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                $headers .= "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <{$fromEmail}>\r\n";
                $headers .= "Reply-To: <{$fromEmail}>\r\n";
                $encodedSubject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
                $res = @mail($to, $encodedSubject, $htmlMessage, $headers, "-f " . $fromEmail);
                return ['success' => $res, 'message' => 'SMTP Auth failed (' . trim($response) . '), fallback to mail(): ' . ($res ? 'Sent' : 'Failed'), 'log' => $this->logs];
            }
        }

        // MAIL FROM
        fputs($socket, "MAIL FROM: <{$fromEmail}>\r\n");
        $this->log("CLIENT: MAIL FROM: <{$fromEmail}>");
        $response = $this->readResponse($socket);

        // RCPT TO
        fputs($socket, "RCPT TO: <{$to}>\r\n");
        $this->log("CLIENT: RCPT TO: <{$to}>");
        $response = $this->readResponse($socket);

        // DATA
        fputs($socket, "DATA\r\n");
        $this->log("CLIENT: DATA");
        $response = $this->readResponse($socket);

        // Prepare email headers and body
        $encodedSubject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
        $encodedFromName = "=?UTF-8?B?" . base64_encode($fromName) . "?=";

        $headers = [];
        $headers[] = "From: {$encodedFromName} <{$fromEmail}>";
        $headers[] = "To: <{$to}>";
        $headers[] = "Subject: {$encodedSubject}";
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-Type: text/html; charset=UTF-8";
        $headers[] = "Content-Transfer-Encoding: base64";
        $headers[] = "Date: " . date('r');
        $headers[] = "X-Mailer: IDMAJ-SMTP-Mailer/1.0";

        $content = implode("\r\n", $headers) . "\r\n\r\n" . chunk_split(base64_encode($htmlMessage));

        fputs($socket, $content . "\r\n.\r\n");
        $this->log("CLIENT: [Sent Message Data]");
        $response = $this->readResponse($socket);

        // QUIT
        fputs($socket, "QUIT\r\n");
        $this->log("CLIENT: QUIT");
        @fclose($socket);

        $isOk = (substr($response, 0, 3) == '250');
        if (!$isOk) {
            // If SMTP data send failed, fallback to native mail()
            $headersStr = "MIME-Version: 1.0\r\n";
            $headersStr .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headersStr .= "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <{$fromEmail}>\r\n";
            $headersStr .= "Reply-To: <{$fromEmail}>\r\n";
            $encodedSubj = "=?UTF-8?B?" . base64_encode($subject) . "?=";
            $res = @mail($to, $encodedSubj, $htmlMessage, $headersStr, "-f " . $fromEmail);
            return ['success' => $res, 'message' => 'SMTP send failed (' . trim($response) . '), fallback to mail(): ' . ($res ? 'Sent' : 'Failed'), 'log' => $this->logs];
        }
        return [
            'success' => $isOk,
            'message' => $isOk ? 'Email sent successfully via SMTP' : 'SMTP Error: ' . trim($response),
            'log' => $this->logs
        ];
    }

    private function readResponse($socket) {
        $response = '';
        while ($str = fgets($socket, 515)) {
            $response .= $str;
            $this->log("SERVER: " . trim($str));
            if (substr($str, 3, 1) == ' ') {
                break;
            }
        }
        return $response;
    }
}

/**
 * Universal Wrapper function to send app email
 */
function send_app_email($to, $subject, $htmlBody, $fromEmail = null, $fromName = null) {
    $mailer = new SimpleSMTPMailer();
    return $mailer->send($to, $subject, $htmlBody, $fromEmail, $fromName);
}

/**
 * Email Templates and Helpers
 */

function get_email_header_template($title) {
    return '
    <!DOCTYPE html>
    <html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; color: #333; }
            .email-container { max-width: 650px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #e1e8ed; }
            .email-header { background: linear-gradient(135deg, #1b365d 0%, #0d1b2a 100%); color: #ffffff; padding: 25px; text-align: center; border-bottom: 4px solid #c5a059; }
            .email-header h1 { margin: 0; font-size: 22px; font-weight: 700; color: #ffffff; }
            .email-header p { margin: 5px 0 0; font-size: 13px; color: #c5a059; }
            .email-body { padding: 30px; line-height: 1.6; }
            .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 14px; }
            .info-table th { background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px 14px; text-align: right; color: #475569; width: 35%; }
            .info-table td { border: 1px solid #e2e8f0; padding: 10px 14px; text-align: right; color: #1e293b; }
            .badge-code { background: #1b365d; color: #ffffff; padding: 6px 14px; border-radius: 6px; font-weight: bold; font-family: monospace; font-size: 16px; display: inline-block; }
            .email-footer { background: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid #e2e8f0; }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="email-header">
                <h1>منصة إدماج IDMAJ 2026</h1>
                <p>' . htmlspecialchars($title) . '</p>
            </div>
            <div class="email-body">
    ';
}

function get_email_footer_template() {
    return '
            </div>
            <div class="email-footer">
                <p>© 2026 منصة إdماج IDMAJ - جميع الحقوق محفوظة.</p>
                <p>هذه الرسالة تم إرسالها تلقائياً من المنصة الرسمية.</p>
            </div>
        </div>
    </body>
    </html>
    ';
}

/**
 * Handle Notification & Confirmation Emails for Registrations
 */
function send_registration_emails($data) {
    $adminEmail = defined('ADMIN_NOTIFY_EMAIL') ? ADMIN_NOTIFY_EMAIL : 'contact@idmadj.dz';
    $regId = $data['reg_id'];
    $name = $data['representative_name'];
    $email = $data['email'];
    $type = $data['participant_type'];
    $phone = $data['phone'];
    $wilaya = $data['wilaya'];
    $orgName = $data['organization_name'] ?? 'غ/م';

    $typeLabels = [
        'general' => 'مشارك عام / زائر',
        'seminar' => 'حضور الندوات التكوينية',
        'b2b' => 'لقاءات ثنائية B2B',
        'hackathon' => 'مسابقة الهكاثون (Hackathon)',
        'pitch' => 'عرض المشاريع (Pitching)'
    ];

    $typeLabel = $typeLabels[$type] ?? $type;

    // 1. ADMIN NOTIFICATION EMAIL
    $adminSubject = "إشعار تسجيل جديد: [{$regId}] - {$name} ({$typeLabel})";
    $adminHtml = get_email_header_template("إشعار تسجيل جديد في المنصة");
    $adminHtml .= "<h3>تم استلام تسجيل جديد عبر المنصة:</h3>";
    $adminHtml .= "<table class='info-table'>";
    $adminHtml .= "<tr><th>رمز التسجيل</th><td><span class='badge-code'>{$regId}</span></td></tr>";
    $adminHtml .= "<tr><th>نوع المشاركة</th><td><strong>{$typeLabel}</strong></td></tr>";
    $adminHtml .= "<tr><th>الاسم واللقب</th><td>{$name}</td></tr>";
    $adminHtml .= "<tr><th>البريد الإلكتروني</th><td><a href='mailto:{$email}'>{$email}</a></td></tr>";
    $adminHtml .= "<tr><th>رقم الهاتف</th><td>{$phone}</td></tr>";
    $adminHtml .= "<tr><th>الولاية</th><td>{$wilaya}</td></tr>";
    if (!empty($orgName)) {
        $adminHtml .= "<tr><th>اسم المؤسسة / الهيئة</th><td>{$orgName}</td></tr>";
    }
    if (!empty($data['selected_seminar'])) {
        $adminHtml .= "<tr><th>الندوة المختارة</th><td>{$data['selected_seminar']}</td></tr>";
    }
    $adminHtml .= "</table>";
    $adminHtml .= "<p><a href='http://localhost/IDMAJ/website/admin/registrations.php' style='background:#1b365d; color:#fff; padding:10px 18px; text-decoration:none; border-radius:6px; font-weight:bold; display:inline-block;'>عرض التثبيت في لوحة التحكم</a></p>";
    $adminHtml .= get_email_footer_template();

    send_app_email($adminEmail, $adminSubject, $adminHtml);

    // 2. USER CONFIRMATION EMAIL
    if (!empty($email)) {
        $userSubject = "تأكيد التسجيل في منصة إدماج IDMAJ 2026 - {$regId}";
        $userHtml = get_email_header_template("تأكيد استلام طلب التسجيل");
        $userHtml .= "<p>مرحباً <strong>{$name}</strong>،</p>";
        $userHtml .= "<p>شكراً لتسجيلكم في منصة إدماج IDMAJ 2026. تم استلام طلبكم بنجاح ويسعدنا مشاركتكم معنا.</p>";
        $userHtml .= "<p style='text-align:center; margin:25px 0;'><span class='badge-code'>رمز التسجيل الخاص بكم: {$regId}</span></p>";
        $userHtml .= "<table class='info-table'>";
        $userHtml .= "<tr><th>نوع المشاركة</th><td>{$typeLabel}</td></tr>";
        $userHtml .= "<tr><th>الاسم</th><td>{$name}</td></tr>";
        $userHtml .= "<tr><th>الولاية</th><td>{$wilaya}</td></tr>";
        $userHtml .= "</table>";
        $userHtml .= "<p>يرجى الاحتفاظ برمز التسجيل هذا لإبرازه عند الاستقبال وفي الفعاليات.</p>";
        $userHtml .= get_email_footer_template();

        send_app_email($email, $userSubject, $userHtml);
    }
}

/**
 * Handle Notification & Confirmation Emails for Contact Form
 */
function send_contact_emails($data) {
    $adminEmail = defined('ADMIN_NOTIFY_EMAIL') ? ADMIN_NOTIFY_EMAIL : 'contact@idmadj.dz';
    $name = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'] ?? '';
    $subject = $data['subject'];
    $reason = $data['reason'] ?? 'عام';
    $message = nl2br(htmlspecialchars($data['message']));

    // 1. ADMIN NOTIFICATION EMAIL
    $adminSubject = "رسالة تواصل جديدة: {$subject}";
    $adminHtml = get_email_header_template("رسالة تواصل جديدة عبر الموقع");
    $adminHtml .= "<h3>تفاصيل الرسالة المستقبلة:</h3>";
    $adminHtml .= "<table class='info-table'>";
    $adminHtml .= "<tr><th>الاسم واللقب</th><td>{$name}</td></tr>";
    $adminHtml .= "<tr><th>البريد الإلكتروني</th><td><a href='mailto:{$email}'>{$email}</a></td></tr>";
    $adminHtml .= "<tr><th>رقم الهاتف</th><td>{$phone}</td></tr>";
    $adminHtml .= "<tr><th>سبب التواصل</th><td>{$reason}</td></tr>";
    $adminHtml .= "<tr><th>الموضوع</th><td><strong>{$subject}</strong></td></tr>";
    $adminHtml .= "</table>";
    $adminHtml .= "<div style='background:#f8fafc; border-right:4px solid #1b365d; padding:15px; margin:15px 0; font-size:14px;'>{$message}</div>";
    $adminHtml .= get_email_footer_template();

    send_app_email($adminEmail, $adminSubject, $adminHtml);

    // 2. USER RECEIPT EMAIL
    if (!empty($email)) {
        $userSubject = "تأكيد استلام رسالتكم - منصة إدماج IDMAJ 2026";
        $userHtml = get_email_header_template("تم استلام رسالتكم بنجاح");
        $userHtml .= "<p>مرحباً <strong>{$name}</strong>،</p>";
        $userHtml .= "<p>نشكركم على تواصلكم مع فريق منصة إdماج IDMAJ 2026. لقد تم استلام رسالتكم وسيتم الرد عليكم في أقرب وقت ممكن.</p>";
        $userHtml .= "<table class='info-table'>";
        $userHtml .= "<tr><th>الموضوع</th><td>{$subject}</td></tr>";
        $userHtml .= "</table>";
        $userHtml .= get_email_footer_template();

        send_app_email($email, $userSubject, $userHtml);
    }
}

/**
 * Handle Notification & Confirmation Emails for Sponsor Form
 */
function send_sponsor_emails($data) {
    $adminEmail = defined('ADMIN_NOTIFY_EMAIL') ? ADMIN_NOTIFY_EMAIL : 'contact@idmadj.dz';
    $companyName = $data['company_name'];
    $contactName = $data['contact_name'];
    $contactTitle = $data['contact_title'] ?? '';
    $email = $data['email'];
    $phone = $data['phone'];
    $sponsorLevel = $data['sponsor_level'];
    $contribution = $data['contribution'] ?? '';
    $notes = nl2br(htmlspecialchars($data['notes'] ?? ''));

    // 1. ADMIN NOTIFICATION EMAIL
    $adminSubject = "طلب رعاية (Sponsorship) جديد: {$companyName} - {$sponsorLevel}";
    $adminHtml = get_email_header_template("طلب رعاية جديد بالمنصة");
    $adminHtml .= "<h3>طلب مشاركة كرعاية جديد:</h3>";
    $adminHtml .= "<table class='info-table'>";
    $adminHtml .= "<tr><th>اسم الشركة / المؤسسة</th><td><strong>{$companyName}</strong></td></tr>";
    $adminHtml .= "<tr><th>مستوى الرعاية المطلوب</th><td><span class='badge-code'>{$sponsorLevel}</span></td></tr>";
    $adminHtml .= "<tr><th>اسم ممثل الشركة</th><td>{$contactName} ({$contactTitle})</td></tr>";
    $adminHtml .= "<tr><th>البريد الإلكتروني</th><td><a href='mailto:{$email}'>{$email}</a></td></tr>";
    $adminHtml .= "<tr><th>رقم الهاتف</th><td>{$phone}</td></tr>";
    if (!empty($contribution)) {
        $adminHtml .= "<tr><th>المساهمة المقترحة</th><td>{$contribution}</td></tr>";
    }
    $adminHtml .= "</table>";
    if (!empty($notes)) {
        $adminHtml .= "<h4>ملاحظات إضافية:</h4><div style='background:#f8fafc; padding:15px;'>{$notes}</div>";
    }
    $adminHtml .= get_email_footer_template();

    send_app_email($adminEmail, $adminSubject, $adminHtml);

    // 2. USER RECEIPT EMAIL
    if (!empty($email)) {
        $userSubject = "تأكيد استلام طلب الرعاية - منصة إدماج IDMAJ 2026";
        $userHtml = get_email_header_template("تأكيد استلام طلب الرعاية");
        $userHtml .= "<p>السادة في <strong>{$companyName}</strong>،</p>";
        $userHtml .= "<p>نشكركم جزيل الشكر على اهتمامكم برعاية منصة إدماج IDMAJ 2026. تم استلام طلبكم الخاص بمستوى الرعاية (<strong>{$sponsorLevel}</strong>).</p>";
        $userHtml .= "<p>سيتواصل معكم فريق العلاقات والشراكات لمناقشة التفاصيل وإتمام الإجراءات.</p>";
        $userHtml .= get_email_footer_template();

        send_app_email($email, $userSubject, $userHtml);
    }
}
?>
