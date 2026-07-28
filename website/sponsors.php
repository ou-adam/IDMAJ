<?php
// website/sponsors.php: Sponsors information and contact page with Multilingual support
require_once 'includes/lang.php';
$page_title = t('brand_title') . " 2026 - " . t('nav_sponsors');
include 'includes/header.php';
require_once 'includes/db.php';
require_once 'includes/mailer.php';


$message_sent = false;
$error_msg = "";

// Handle Sponsorship Application Form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'apply_sponsor') {
    $company_name = trim($_POST['company_name']);
    $contact_name = trim($_POST['contact_name']);
    $contact_title = trim($_POST['contact_title']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $sponsor_level = trim($_POST['sponsor_level']);
    $contribution = trim($_POST['contribution']);
    $notes = trim($_POST['notes']);

    if (empty($company_name) || empty($contact_name) || empty($email) || empty($phone) || empty($sponsor_level)) {
        $error_msg = ($lang === 'ar') ? "يرجى ملء جميع الحقول الإلزامية." : (($lang === 'fr') ? "Veuillez remplir tous les champs obligatoires." : "Please fill in all mandatory fields.");
    } else {
        try {
            // Insert request into messages table with reason = 'sponsor'
            $subject = "طلب رعاية جديد: $sponsor_level - $company_name";
            $full_message = "الشركة: $company_name\n المسؤول: $contact_name ($contact_title)\nالمساهمة المقترحة: $contribution\nملاحظات: $notes";
            
            $stmt = $pdo->prepare("INSERT INTO messages (name, email, phone, subject, message, reason, status) 
                                   VALUES (?, ?, ?, ?, ?, 'sponsor', 'unread')");
            $stmt->execute([$contact_name, $email, $phone, $subject, $full_message]);
            
            $message_sent = true;

            // Send sponsor notification & sponsor applicant receipt emails
            try {
                send_sponsor_emails([
                    'company_name' => $company_name,
                    'contact_name' => $contact_name,
                    'contact_title' => $contact_title,
                    'email' => $email,
                    'phone' => $phone,
                    'sponsor_level' => $sponsor_level,
                    'contribution' => $contribution,
                    'notes' => $notes
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
        <span class="badge badge-gold"><?php echo t('nav_sponsors'); ?></span>
        <h1><?php echo t('sponsors_title'); ?></h1>
        <p><?php echo t('sponsors_subtitle'); ?></p>
        <div style="margin-top: 1.5rem;">
            <a href="#sponsor-form" class="btn btn-primary"><?php echo ($lang === 'ar') ? 'قدم طلب رعاية الآن' : (($lang === 'fr') ? 'Devenir Sponsor' : 'Become a Sponsor'); ?></a>
        </div>
    </div>
</section>

<!-- Sponsors Grid Section -->
<section class="section-padding sponsors-grid-section">
    <div class="container">
        
        <!-- Gold Sponsors -->
        <div class="sponsors-level-group">
            <h2 class="text-center group-title"><span class="gold-text"><?php echo t('sponsors_official'); ?></span></h2>
            <div class="sponsors-logos-grid gold-grid">

                <div class="premium-card sponsor-display-card">
                    <img src="../Photos/site%20web%20IDMADJ/les%20sponsor/golds/MAATEC%20Assurance.png" alt="MAATEC Assurance" class="sponsor-logo-large">
                    <h4>ماتيك للتأمين (MAATEC Assurance)</h4>
                </div>
            </div>
        </div>

        <!-- Silver Sponsors -->
        <div class="sponsors-level-group" style="margin-top: 5rem;">
            <h2 class="text-center group-title"><span class="cyan-text"><?php echo ($lang === 'ar') ? 'الرعاة الفضيون' : (($lang === 'fr') ? 'Sponsors Argent' : 'Silver Sponsors'); ?></span></h2>
            <div class="sponsors-logos-grid silver-grid">
                <div class="premium-card sponsor-display-card">
                    <img src="../Photos/site%20web%20IDMADJ/les%20sponsor/silvers/bank%20salam.png" alt="مصرف السلام" class="sponsor-logo-medium">
                    <h4><?php echo ($lang === 'ar') ? 'مصرف السلام' : 'Al Salam Bank'; ?></h4>
                </div>
                
                <div class="premium-card sponsor-display-card">
                    <img src="../Photos/site%20web%20IDMADJ/les%20sponsor/silvers/BitBit.png" alt="Bit Bait" class="sponsor-logo-medium">
                    <h4>Bit Bait</h4>
                </div>

                <div class="premium-card sponsor-display-card">
                    <img src="../Photos/site%20web%20IDMADJ/les%20sponsor/silvers/cspa.png" alt="CS&PA Company" class="sponsor-logo-medium">
                    <h4>CS&PA Company</h4>
                </div>

                <div class="premium-card sponsor-display-card">
                    <img src="../Photos/site%20web%20IDMADJ/les%20sponsor/silvers/el%20djazair%20istithmar.png" alt="El Djazair Istithmar" class="sponsor-logo-medium">
                    <h4><?php echo ($lang === 'ar') ? 'الجزائر للاستثمار' : 'El Djazair Istithmar'; ?></h4>
                </div>

                <div class="premium-card sponsor-display-card">
                    <img src="../Photos/site%20web%20IDMADJ/les%20sponsor/silvers/Ferdi_Lilly-removebg-preview.png" alt="Ferdi Lilly" class="sponsor-logo-medium">
                    <h4>Ferdi Lilly</h4>
                </div>

                <div class="premium-card sponsor-display-card">
                    <img src="../Photos/site%20web%20IDMADJ/les%20sponsor/silvers/saa.png" alt="SAA Assurance" class="sponsor-logo-medium">
                    <h4>SAA Assurance</h4>
                </div>
            </div>
        </div>

        <!-- Partners Section -->
        <div class="sponsors-level-group" style="margin-top: 5rem;">
            <h2 class="text-center group-title"><?php echo ($lang === 'ar') ? 'الشركاء المؤسساتيون والهيئات الداعمة' : (($lang === 'fr') ? 'Partenaires Institutionnels & Organismes' : 'Institutional Partners & Agencies'); ?></h2>
            <div class="sponsors-logos-grid partners-grid">
                <div class="premium-card partner-display-card">
                    <img src="../Photos/site%20web%20IDMADJ/les%20partenaires/ADPMEPI.png" alt="ADPMEPI">
                    <h4>ADPMEPI <?php echo ($lang === 'ar') ? '(وكالة تطوير المؤسسات الصغرى والمتوسطة)' : (($lang === 'fr') ? '(Agence de Développement des PME)' : '(SME Development Agency)'); ?></h4>
                </div>
                <div class="premium-card partner-display-card">
                    <img src="../Photos/site%20web%20IDMADJ/les%20partenaires/ALGERAC.png" alt="ALGERAC">
                    <h4>ALGERAC <?php echo ($lang === 'ar') ? '(الهيئة الجزائرية للاعتماد)' : (($lang === 'fr') ? '(Organisme Algérien d’Accréditation)' : '(Algerian Accreditation Body)'); ?></h4>
                </div>
                <div class="premium-card partner-display-card">
                    <img src="../Photos/site%20web%20IDMADJ/les%20partenaires/ANVREDET.png" alt="ANVREDET">
                    <h4>ANVREDET <?php echo ($lang === 'ar') ? '(وكالة تثمين نتائج البحث)' : (($lang === 'fr') ? '(Agence de Valorisation des Résultats de la Recherche)' : '(Agency for Research Results Valorization)'); ?></h4>
                </div>
                <div class="premium-card partner-display-card">
                    <img src="../Photos/site%20web%20IDMADJ/les%20partenaires/BASTP.png" alt="BASTP">
                    <h4>BASTP <?php echo ($lang === 'ar') ? '(بورصة المناولة والشراكة للغرب)' : (($lang === 'fr') ? '(Bourse de Sous-Traitance du Partenariat)' : '(Subcontracting & Partnership Exchange)'); ?></h4>
                </div>
                <div class="premium-card partner-display-card">
                    <img src="../Photos/site%20web%20IDMADJ/les%20partenaires/FGAR.png" alt="FGAR">
                    <h4>FGAR <?php echo ($lang === 'ar') ? '(صندوق ضمان القروض للمؤسسات)' : (($lang === 'fr') ? '(Fonds de Garantie des Crédits aux PME)' : '(SME Credit Guarantee Fund)'); ?></h4>
                </div>
                <div class="premium-card partner-display-card">
                    <img src="../Photos/site%20web%20IDMADJ/les%20partenaires/INAPI.png" alt="INAPI">
                    <h4>INAPI <?php echo ($lang === 'ar') ? '(المعهد الجزائري للملكية الصناعية)' : (($lang === 'fr') ? '(Institut Algérien de la Propriété Industrielle)' : '(Algerian Industrial Property Institute)'); ?></h4>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Form Section -->
<section class="section-padding bg-dark-slate" id="sponsor-form">
    <div class="container" style="max-width: 750px;">
        <div class="section-header text-center">
            <span class="badge badge-gold"><?php echo ($lang === 'ar') ? 'فرص الاستثمار' : (($lang === 'fr') ? 'Opportunités de Sponsoring' : 'Sponsorship Opportunities'); ?></span>
            <h2><?php echo ($lang === 'ar') ? 'طلب رعاية أو شراكة' : (($lang === 'fr') ? 'Demande de Sponsoring ou Partenariat' : 'Sponsorship & Partnership Request'); ?></h2>
            <p><?php echo ($lang === 'ar') ? 'املأ الاستمارة التالية وسيقوم مسؤول الرعاة بالاتصال بكم لعرض ملف الرعاية والمزايا الإعلامية والمؤسساتية المتاحة.' : (($lang === 'fr') ? 'Remplissez le formulaire ci-dessous et notre équipe vous contactera pour vous présenter le dossier de sponsoring.' : 'Fill out the form below and our sponsorship team will contact you with the sponsorship package.'); ?></p>
        </div>

        <?php if ($message_sent): ?>
            <div class="success-alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -3px; margin-left: 6px; color: var(--success);"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> <?php echo ($lang === 'ar') ? 'تم إرسال طلبكم بنجاح! سيقوم فريق الرعاة والتنسيق بالاتصال بكم في أقرب وقت لمناقشة التفاصيل.' : (($lang === 'fr') ? 'Votre demande a été envoyée avec succès ! Notre équipe vous contactera dans les plus brefs délais.' : 'Your request has been submitted successfully! Our team will contact you shortly.'); ?>
            </div>
        <?php else: ?>
            <?php if (!empty($error_msg)): ?>
                <div class="error-alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -3px; margin-left: 6px; color: var(--danger);"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg> <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <form action="sponsors.php#sponsor-form" method="POST" class="premium-card sponsor-application-form">
                <input type="hidden" name="action" value="apply_sponsor">
                
                <div class="form-group">
                    <label for="company_name"><?php echo ($lang === 'ar') ? 'اسم الشركة / المؤسسة *' : (($lang === 'fr') ? 'Nom de l’entreprise / organisme *' : 'Company / Organization Name *'); ?></label>
                    <input type="text" id="company_name" name="company_name" required placeholder="<?php echo ($lang === 'ar') ? 'مثال: شركة ماتيك للتأمين' : (($lang === 'fr') ? 'Ex: MAATEC Assurance' : 'e.g. MAATEC Assurance'); ?>">
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="contact_name"><?php echo ($lang === 'ar') ? 'اسم المسؤول للتنسيق *' : (($lang === 'fr') ? 'Nom du responsable *' : 'Contact Person Name *'); ?></label>
                        <input type="text" id="contact_name" name="contact_name" required placeholder="<?php echo ($lang === 'ar') ? 'الاسم واللقب' : (($lang === 'fr') ? 'Nom et prénom' : 'Full Name'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="contact_title"><?php echo ($lang === 'ar') ? 'المنصب *' : (($lang === 'fr') ? 'Fonction / Poste *' : 'Job Title *'); ?></label>
                        <input type="text" id="contact_title" name="contact_title" required placeholder="<?php echo ($lang === 'ar') ? 'مثال: مدير الإعلام والاتصال' : (($lang === 'fr') ? 'Ex: Directeur de la communication' : 'e.g. Communication Director'); ?>">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="email"><?php echo ($lang === 'ar') ? 'البريد الإلكتروني *' : (($lang === 'fr') ? 'Adresse email *' : 'Email Address *'); ?></label>
                        <input type="email" id="email" name="email" required placeholder="name@company.dz">
                    </div>
                    <div class="form-group">
                        <label for="phone"><?php echo ($lang === 'ar') ? 'رقم الهاتف للاتصال *' : (($lang === 'fr') ? 'Numéro de téléphone *' : 'Phone Number *'); ?></label>
                        <input type="text" id="phone" name="phone" required placeholder="023 XX XX XX / 06XX XX XX XX">
                    </div>
                </div>

                <div class="form-group">
                    <label for="sponsor_level"><?php echo ($lang === 'ar') ? 'فئة الرعاية المطلوبة *' : (($lang === 'fr') ? 'Catégorie de sponsoring souhaitée *' : 'Sponsorship Package *'); ?></label>
                    <select id="sponsor_level" name="sponsor_level" required>
                        <option value=""><?php echo ($lang === 'ar') ? 'اختر باقة الرعاية...' : (($lang === 'fr') ? 'Choisir l’offre de sponsoring...' : 'Select Sponsorship Package...'); ?></option>
                        <option value="رعاية رسمية (Official Sponsor)"><?php echo ($lang === 'ar') ? 'رعاية رسمية (Official Sponsor)' : (($lang === 'fr') ? 'Sponsor Officiel (Official Sponsor)' : 'Official Sponsor'); ?></option>
                        <option value="رعاة ذهبيون (Gold Sponsor)"><?php echo ($lang === 'ar') ? 'رعاة ذهبيون (Gold Sponsor)' : (($lang === 'fr') ? 'Sponsor Or (Gold Sponsor)' : 'Gold Sponsor'); ?></option>
                        <option value="رعاة فضيون (Silver Sponsor)"><?php echo ($lang === 'ar') ? 'رعاة فضيون (Silver Sponsor)' : (($lang === 'fr') ? 'Sponsor Argent (Silver Sponsor)' : 'Silver Sponsor'); ?></option>
                        <option value="شريك داعم (Supporting Partner)"><?php echo ($lang === 'ar') ? 'شريك داعم (Supporting Partner)' : (($lang === 'fr') ? 'Partenaire Supporteur (Supporting Partner)' : 'Supporting Partner'); ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="contribution"><?php echo ($lang === 'ar') ? 'مبلغ أو طبيعة المساهمة المقترحة (اختياري)' : (($lang === 'fr') ? 'Montant ou nature de la contribution (Optionnel)' : 'Proposed Contribution / Sponsorship Type (Optional)'); ?></label>
                    <input type="text" id="contribution" name="contribution" placeholder="<?php echo ($lang === 'ar') ? 'مثال: رعاية مالية، تقديم خدمات لوجستية، تمويل ورشات...' : (($lang === 'fr') ? 'Ex: Sponsoring financier, soutien logistique, ateliers...' : 'e.g. Financial sponsorship, logistics, workshop support...'); ?>">
                </div>

                <div class="form-group">
                    <label for="notes"><?php echo ($lang === 'ar') ? 'ملاحظات أو استفسارات إضافية' : (($lang === 'fr') ? 'Remarques ou questions supplémentaires' : 'Additional Notes / Inquiries'); ?></label>
                    <textarea id="notes" name="notes" rows="4" placeholder="<?php echo ($lang === 'ar') ? 'اكتب استفساراتكم أو تفاصيل إضافية هنا...' : (($lang === 'fr') ? 'Écrivez vos remarques ou détails ici...' : 'Write your notes or additional details here...'); ?>"></textarea>
                </div>

                <div class="form-actions text-center">
                    <button type="submit" class="btn btn-primary"><?php echo ($lang === 'ar') ? 'إرسال الطلب الرسمي' : (($lang === 'fr') ? 'Soumettre la demande' : 'Submit Application'); ?></button>
                </div>
            </form>
        <?php endif; ?>

    </div>
</section>

<style>
.group-title {
    font-size: 1.5rem;
    margin-bottom: 2.5rem;
}
.sponsors-logos-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    justify-content: center;
    align-items: stretch;
}
.gold-grid .sponsor-display-card {
    flex: 1 1 320px;
    max-width: 400px;
}
.silver-grid .sponsor-display-card {
    flex: 1 1 260px;
    max-width: 320px;
}
.partners-grid .partner-display-card {
    flex: 1 1 220px;
    max-width: 280px;
}
@media (max-width: 576px) {
    .gold-grid .sponsor-display-card,
    .silver-grid .sponsor-display-card,
    .partners-grid .partner-display-card {
        flex: 1 1 100%;
        max-width: 100%;
        padding: 1.2rem 1rem;
    }
}
.sponsor-display-card, .partner-display-card {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    box-sizing: border-box;
}
.sponsor-logo-large {
    max-height: 120px;
    max-width: 100%;
    object-fit: contain;
    margin: 0 auto 1.5rem auto;
    display: block;
}
.sponsor-logo-medium {
    max-height: 80px;
    max-width: 100%;
    object-fit: contain;
    margin: 0 auto 1.5rem auto;
    display: block;
}
.partner-display-card img {
    max-height: 70px;
    max-width: 100%;
    object-fit: contain;
    margin: 0 auto 1.2rem auto;
    display: block;
}
.sponsor-display-card h4, .partner-display-card h4 {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    text-align: center;
    width: 100%;
}
.sponsor-link {
    font-size: 0.8rem;
    color: var(--primary);
    font-weight: 600;
}
.bg-dark-slate {
    background-color: #0b0f19;
}
.success-alert {
    background-color: rgba(16, 185, 129, 0.15);
    border: 1px solid var(--success);
    color: var(--text-light);
    padding: 1.5rem;
    border-radius: 0.8rem;
    margin-bottom: 2rem;
    text-align: center;
    font-weight: 600;
}
.error-alert {
    background-color: rgba(239, 68, 68, 0.15);
    border: 1px solid var(--danger);
    color: var(--text-light);
    padding: 1rem;
    border-radius: 0.8rem;
    margin-bottom: 2rem;
    text-align: center;
}
.sponsor-application-form {
    padding: 3rem;
}
/* Form styling is now loaded globally from style.css */
    .sponsor-application-form {
        padding: 1.5rem;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
