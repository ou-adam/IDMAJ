<?php
// website/contact.php: Contact Us Page with Multilingual support
require_once 'includes/lang.php';
$page_title = t('brand_title') . " 2026 - " . t('nav_contact');
include 'includes/header.php';
require_once 'includes/db.php';
require_once 'includes/mailer.php';


$success = false;
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    $reason = trim($_POST['reason']);

    if (empty($name) || empty($email) || empty($subject) || empty($message) || empty($reason)) {
        $error_msg = ($lang === 'ar') ? "يرجى ملء جميع الحقول الإلزامية المطلوبة." : (($lang === 'fr') ? "Veuillez remplir tous les champs obligatoires." : "Please fill in all mandatory fields.");
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO messages (name, email, phone, subject, message, reason, status) 
                                   VALUES (?, ?, ?, ?, ?, ?, 'unread')");
            $stmt->execute([$name, $email, $phone, $subject, $message, $reason]);
            $success = true;

            // Send contact notification & user receipt emails
            try {
                send_contact_emails([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'subject' => $subject,
                    'reason' => $reason,
                    'message' => $message
                ]);
            } catch (\Throwable $mEx) {
                error_log("Mail Error: " . $mEx->getMessage());
            }
        } catch (\PDOException $e) {
            $error_msg = "Error: " . $e->getMessage();
        }
    }
}

?>

<section class="page-banner text-center">
    <div class="container">
        <span class="badge badge-primary"><?php echo t('nav_contact'); ?></span>
        <h1><?php echo t('contact_title'); ?></h1>
        <p><?php echo t('contact_subtitle'); ?></p>
    </div>
</section>

<section class="section-padding contact-main-section">
    <div class="container">
        <div class="grid grid-2">
            
            <!-- Contact Details Card -->
            <div class="premium-card contact-details-card">
                <h2><?php echo t('footer_contact_info'); ?></h2>
                <hr class="accent-line">
                <p><?php echo ($lang === 'ar') ? 'إذا كان لديك أي سؤال أو تفضل الاتصال بفريقنا مباشرة، يمكنك استخدام القنوات التالية:' : (($lang === 'fr') ? 'Si vous avez des questions ou souhaitez contacter notre équipe :' : 'If you have any questions or wish to get in touch directly:'); ?></p>
                
                <div class="contact-methods" style="margin-top: 2rem;">
                    <div class="contact-method-item">
                        <span class="contact-icon" style="color: var(--primary);">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </span>
                        <div class="contact-desc">
                            <h4><?php echo t('contact_email'); ?></h4>
                            <p>contact@idmadj.dz</p>
                        </div>
                    </div>

                    <div class="contact-method-item" style="margin-top: 1.5rem;">
                        <span class="contact-icon" style="color: var(--primary);">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </span>
                        <div class="contact-desc">
                            <h4><?php echo t('contact_phone'); ?></h4>
                            <p><?php echo t('contact_phone_num'); ?></p>
                        </div>
                    </div>

                    <div class="contact-method-item" style="margin-top: 1.5rem;">
                        <span class="contact-icon" style="color: var(--primary);">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </span>
                        <div class="contact-desc">
                            <h4><?php echo ($lang === 'ar') ? 'المقر الرئيسي' : (($lang === 'fr') ? 'Siège Social' : 'Headquarters'); ?></h4>
                            <p><?php echo t('contact_address'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <?php if ($success): ?>
                    <div class="success-alert" style="background-color: rgba(16, 185, 129, 0.15); border: 1px solid var(--success); color: var(--text-light); padding: 1.5rem; border-radius: 0.8rem; text-align: center; gap: 10px;">
                        <span><?php echo t('contact_success'); ?></span>
                    </div>
                <?php else: ?>
                    <form method="POST" action="contact.php" class="premium-card form-box">
                        <?php if ($error_msg): ?>
                            <div class="error-alert" style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid var(--danger); color: var(--text-light); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                                <?php echo htmlspecialchars($error_msg); ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="form-label"><?php echo t('contact_name'); ?> *</label>
                            <input type="text" name="name" class="form-input" required placeholder="<?php echo t('contact_name'); ?>">
                        </div>

                        <div class="grid grid-2">
                            <div class="form-group">
                                <label class="form-label"><?php echo t('contact_email'); ?> *</label>
                                <input type="email" name="email" class="form-input" required placeholder="name@example.com">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><?php echo t('contact_phone'); ?></label>
                                <input type="text" name="phone" class="form-input" placeholder="05XXXXXXXX">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><?php echo t('contact_reason'); ?> *</label>
                            <select name="reason" class="form-select" required>
                                <option value="general"><?php echo t('contact_reason_general'); ?></option>
                                <option value="sponsor"><?php echo t('contact_reason_sponsor'); ?></option>
                                <option value="register"><?php echo t('contact_reason_register'); ?></option>
                                <option value="b2b"><?php echo t('contact_reason_b2b'); ?></option>
                                <option value="hackathon"><?php echo t('contact_reason_hackathon'); ?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><?php echo t('contact_subject'); ?> *</label>
                            <input type="text" name="subject" class="form-input" required placeholder="<?php echo t('contact_subject'); ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label"><?php echo t('contact_message'); ?> *</label>
                            <textarea name="message" rows="5" class="form-input" required placeholder="<?php echo t('contact_message'); ?>"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%;"><?php echo t('contact_send'); ?></button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
.contact-method-item {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}
.contact-icon {
    font-size: 1.5rem;
    background: rgba(14, 165, 233, 0.1);
    padding: 0.6rem;
    border-radius: 0.6rem;
}
.contact-desc h4 {
    font-size: 1rem;
    color: var(--text-light);
}
.contact-desc p {
    font-size: 0.88rem;
    color: var(--text-muted);
}
.form-box {
    padding: 2rem;
}
.form-group {
    margin-bottom: 1.2rem;
}
.form-label {
    display: block;
    margin-bottom: 0.4rem;
    font-size: 0.88rem;
    font-weight: 600;
}
.form-input, .form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    background: rgba(15, 23, 42, 0.8);
    border: 1px solid var(--border-color);
    border-radius: 0.6rem;
    color: var(--text-light);
    font-family: inherit;
}
.form-input:focus, .form-select:focus {
    border-color: var(--primary);
    outline: none;
    box-shadow: 0 0 10px rgba(14, 165, 233, 0.3);
}
@media (max-width: 576px) {
    .contact-details-card, .form-box {
        padding: 1.2rem 1rem !important;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
