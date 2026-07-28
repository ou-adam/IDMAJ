<?php
// website/register.php: Dynamic Multi-type Registration Portal with Multilingual support
require_once 'includes/lang.php';
$page_title = t('brand_title') . " 2026 - " . t('reg_title');
include 'includes/header.php';
require_once 'includes/db.php';
require_once 'includes/mailer.php';




$success = false;
$error_msg = "";
$generated_id = "";

// Initial dropdown parameter for pre-select
$preselect_type = isset($_GET['type']) ? $_GET['type'] : '';
$preselect_seminar = isset($_GET['seminar']) ? $_GET['seminar'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect Core Fields
    $participant_type = trim($_POST['participant_type']);
    $representative_name = trim($_POST['representative_name']);
    $representative_title = trim($_POST['representative_title'] ?? '');
    $wilaya = trim($_POST['wilaya']);
    $address = trim($_POST['address']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $website = trim($_POST['website'] ?? '');
    $selected_seminar = ($participant_type === 'seminar') ? trim($_POST['selected_seminar_wilaya'] ?? '') : null;

    // Validate Core fields
    if (empty($participant_type) || empty($representative_name) || empty($wilaya) || empty($address) || empty($email) || empty($phone)) {
        $error_msg = ($lang === 'ar') ? "يرجى ملء جميع الحقول الأساسية الإلزامية." : (($lang === 'fr') ? "Veuillez remplir tous les champs obligatoires." : "Please fill in all mandatory fields.");
    } else {
        try {
            // Check for duplicates
            $stmt = $pdo->prepare("SELECT id FROM registrations WHERE email = ? OR phone = ?");
            $stmt->execute([$email, $phone]);
            if ($stmt->fetch()) {
                $error_msg = ($lang === 'ar') ? "هذا البريد الإلكتروني أو رقم الهاتف مسجل بالفعل في قاعدة البيانات." : (($lang === 'fr') ? "Cet email ou ce numéro de téléphone est déjà enregistré." : "This email or phone number is already registered.");
            } else {
                // Ensure uploads directory exists
                if (!file_exists('uploads')) {
                    mkdir('uploads', 0777, true);
                }

                // Handle File Uploads
                $personal_photo = "";
                $company_logo = "";
                $company_profile_pdf = "";

                if (isset($_FILES['personal_photo']) && $_FILES['personal_photo']['error'] === UPLOAD_ERR_OK) {
                    $ext = pathinfo($_FILES['personal_photo']['name'], PATHINFO_EXTENSION);
                    $personal_photo = 'uploads/photo_' . time() . '_' . rand(100, 999) . '.' . $ext;
                    move_uploaded_file($_FILES['personal_photo']['tmp_name'], $personal_photo);
                }

                if (isset($_FILES['company_logo']) && $_FILES['company_logo']['error'] === UPLOAD_ERR_OK) {
                    $ext = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);
                    $company_logo = 'uploads/logo_' . time() . '_' . rand(100, 999) . '.' . $ext;
                    move_uploaded_file($_FILES['company_logo']['tmp_name'], $company_logo);
                }

                if (isset($_FILES['company_profile_pdf']) && $_FILES['company_profile_pdf']['error'] === UPLOAD_ERR_OK) {
                    $ext = pathinfo($_FILES['company_profile_pdf']['name'], PATHINFO_EXTENSION);
                    $company_profile_pdf = 'uploads/pdf_' . time() . '_' . rand(100, 999) . '.' . $ext;
                    move_uploaded_file($_FILES['company_profile_pdf']['tmp_name'], $company_profile_pdf);
                }

                // Generate Unique IDMAJ Code
                $generated_id = 'IDMAJ-2026-' . rand(1000, 9999);

                // Collect Organization Fields (if applicable)
                $organization_name = trim($_POST['organization_name'] ?? '');
                $legal_status = trim($_POST['legal_status'] ?? '');
                $commercial_register_no = trim($_POST['commercial_register_no'] ?? '');
                $nif = trim($_POST['nif'] ?? '');
                $economic_sector = trim($_POST['economic_sector'] ?? '');
                $main_activity = trim($_POST['main_activity'] ?? '');
                $company_size = trim($_POST['company_size'] ?? '');
                $company_type = trim($_POST['company_type'] ?? '');

                // Insert into Registrations Table
                $stmt = $pdo->prepare("INSERT INTO registrations 
                    (reg_id, participant_type, organization_name, legal_status, commercial_register_no, nif, economic_sector, main_activity, company_size, company_type, representative_name, representative_title, wilaya, address, email, phone, website, selected_seminar, personal_photo, company_logo, company_profile_pdf, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
                
                $stmt->execute([
                    $generated_id, $participant_type, $organization_name, $legal_status, $commercial_register_no, $nif, $economic_sector, $main_activity, $company_size, $company_type, $representative_name, $representative_title, $wilaya, $address, $email, $phone, $website, $selected_seminar, $personal_photo, $company_logo, $company_profile_pdf
                ]);
                $registration_db_id = $pdo->lastInsertId();

                // Handle Sub-tables based on type
                if ($participant_type === 'b2b') {
                    $b2b_role = trim($_POST['b2b_role'] ?? '');
                    $sectors_needed = implode(',', (array)($_POST['sectors_needed'] ?? []));
                    $opportunities_needed = implode(',', (array)($_POST['opportunities_needed'] ?? []));
                    
                    $sub_stmt = $pdo->prepare("INSERT INTO b2b_requests (registration_id, b2b_role, sectors_needed, opportunities_needed) VALUES (?, ?, ?, ?)");
                    $sub_stmt->execute([$registration_db_id, $b2b_role, $sectors_needed, $opportunities_needed]);
                } 
                elseif ($participant_type === 'hackathon') {
                    $team_name = trim($_POST['team_name'] ?? '');
                    $members_count = intval($_POST['members_count'] ?? 3);
                    $leader_name = $representative_name;
                    $leader_email = $email;
                    $leader_phone = $phone;
                    $track = trim($_POST['hack_track'] ?? '');
                    $idea_desc = trim($_POST['hack_idea'] ?? '');
                    $has_prototype = isset($_POST['has_prototype']) ? 1 : 0;
                    $github_link = trim($_POST['github_link'] ?? '');
                    
                    $sub_stmt = $pdo->prepare("INSERT INTO hackathon_teams (registration_id, team_name, members_count, leader_name, leader_email, leader_phone, wilaya, specialty, track, idea_desc, has_prototype, github_link, slide_pdf) VALUES (?, ?, ?, ?, ?, ?, ?, '', ?, ?, ?, ?, ?)");
                    $sub_stmt->execute([$registration_db_id, $team_name, $members_count, $leader_name, $leader_email, $leader_phone, $wilaya, $track, $idea_desc, $has_prototype, $github_link, $company_profile_pdf]);
                } 
                elseif ($participant_type === 'pitch') {
                    $project_name = trim($_POST['pitch_project_name'] ?? '');
                    $pitch_sector = trim($_POST['pitch_sector'] ?? '');
                    $pitch_stage = trim($_POST['pitch_stage'] ?? '');
                    $pitch_desc = trim($_POST['pitch_desc'] ?? '');
                    $pitch_value = trim($_POST['pitch_value'] ?? '');
                    $pitch_need = trim($_POST['pitch_need'] ?? '');
                    $video_link = trim($_POST['pitch_video_link'] ?? '');
                    
                    $sub_stmt = $pdo->prepare("INSERT INTO pitch_submissions (registration_id, owner_name, project_name, wilaya, sector, stage, description, value_add, need_type, video_link, pdf_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $sub_stmt->execute([$registration_db_id, $representative_name, $project_name, $wilaya, $pitch_sector, $pitch_stage, $pitch_desc, $pitch_value, $pitch_need, $video_link, $company_profile_pdf]);
                }

                $success = true;

                // Send email notifications (Admin notification + User confirmation)
                try {
                    send_registration_emails([
                        'reg_id' => $generated_id,
                        'participant_type' => $participant_type,
                        'representative_name' => $representative_name,
                        'email' => $email,
                        'phone' => $phone,
                        'wilaya' => $wilaya,
                        'organization_name' => $organization_name ?? '',
                        'selected_seminar' => $selected_seminar ?? ''
                    ]);
                } catch (\Throwable $mEx) {
                    // Log mail error silently so registration is not interrupted
                    error_log("Mail Error: " . $mEx->getMessage());
                }

            }
        } catch (\PDOException $e) {
            $error_msg = "خطأ في معالجة التسجيل في قاعدة البيانات: " . $e->getMessage();
        }
    }
}
?>

<section class="page-banner text-center">
    <div class="container">
        <span class="badge badge-primary"><?php echo t('nav_register'); ?></span>
        <h1><?php echo t('reg_title'); ?></h1>
        <p><?php echo t('reg_subtitle'); ?></p>
    </div>
</section>

<section class="section-padding registration-form-section">
    <div class="container" style="max-width: 800px;">
        
        <?php if ($success): ?>
            <div class="registration-success premium-card text-center">
                <span class="success-icon" style="color: var(--success); display: inline-flex; align-items: center; justify-content: center; width: 100%;">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </span>
                <h2><?php echo t('reg_success_title'); ?></h2>
                <hr class="accent-line" style="margin: 1.5rem auto;">
                <p><?php echo ($lang === 'ar') ? 'مرحباً بك' : (($lang === 'fr') ? 'Bienvenue' : 'Welcome'); ?> <strong><?php echo htmlspecialchars($representative_name); ?></strong></p>
                <div class="id-card-display">
                    <span class="id-label"><?php echo t('reg_success_id'); ?></span>
                    <span class="id-code"><?php echo $generated_id; ?></span>
                </div>
                <p class="success-note">
                    <?php echo t('reg_success_note'); ?>
                </p>
                <div style="margin-top: 2rem;">
                    <a href="index.php" class="btn btn-secondary"><?php echo t('btn_back'); ?></a>
                </div>
            </div>
        <?php else: ?>
            
            <?php if (!empty($error_msg)): ?>
                <div class="error-alert" style="margin-bottom: 2rem; background-color: rgba(239, 68, 68, 0.15); border: 1px solid var(--danger); padding: 1rem; border-radius: 0.8rem; text-align: center; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <svg class="icon" style="color: var(--danger); font-size: 1.25rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    <span><?php echo $error_msg; ?></span>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST" enctype="multipart/form-data" class="premium-card register-form">
                
                <!-- 1. Participant Type Choice -->
                <div class="form-group">
                    <label for="participant_type"><?php echo t('reg_type_select'); ?> *</label>
                    <select id="participant_type" name="participant_type" required>
                        <option value=""><?php echo ($lang === 'ar') ? '-- اختر نوع المشاركة --' : (($lang === 'fr') ? '-- Choisir le type de participation --' : '-- Select participation type --'); ?></option>
                        <option value="corporate" <?php echo ($preselect_type == 'corporate') ? 'selected' : ''; ?>><?php echo t('reg_type_corporate'); ?></option>
                        <option value="seminar" <?php echo ($preselect_type == 'seminar' || !empty($preselect_seminar)) ? 'selected' : ''; ?>><?php echo t('reg_type_seminar'); ?></option>
                        <option value="expert" <?php echo ($preselect_type == 'expert') ? 'selected' : ''; ?>><?php echo t('reg_type_expert'); ?></option>
                        <option value="media" <?php echo ($preselect_type == 'media') ? 'selected' : ''; ?>><?php echo t('reg_type_media'); ?></option>
                        <option value="sponsor" <?php echo ($preselect_type == 'sponsor') ? 'selected' : ''; ?>><?php echo t('reg_type_sponsor'); ?></option>
                        <option value="b2b" <?php echo ($preselect_type == 'b2b') ? 'selected' : ''; ?>><?php echo t('reg_type_b2b'); ?></option>
                        <option value="hackathon" <?php echo ($preselect_type == 'hackathon') ? 'selected' : ''; ?>><?php echo t('reg_type_hackathon'); ?></option>
                        <option value="pitch" <?php echo ($preselect_type == 'pitch') ? 'selected' : ''; ?>><?php echo t('reg_type_pitch'); ?></option>
                    </select>
                </div>


                <!-- 1.1 Dynamic Section: Seminar Wilaya Choice -->
                <div id="fields-seminar-only" style="display:none; margin-top: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px dashed var(--border-color);">
                    <div class="form-group">
                        <label for="selected_seminar_wilaya"><?php echo ($lang === 'ar') ? 'الندوة الولائية / الجهوية التي ترغب في حضورها *' : (($lang === 'fr') ? 'Séminaire régional auquel vous souhaitez assister *' : 'Regional Seminar you wish to attend *'); ?></label>
                        <select id="selected_seminar_wilaya" name="selected_seminar_wilaya">
                            <option value=""><?php echo ($lang === 'ar') ? '-- اختر الندوة الولائية --' : (($lang === 'fr') ? '-- Choisir le séminaire --' : '-- Select Regional Seminar --'); ?></option>
                            <option value="ورقلة (ندوة الجنوب)" <?php echo ($preselect_seminar == 'ouargla') ? 'selected' : ''; ?>><?php echo ($lang === 'ar') ? 'ورقلة (ندوة الجنوب - جويلية 2026)' : (($lang === 'fr') ? 'Ouargla (Séminaire du Sud - Juillet 2026)' : 'Ouargla (South Seminar - July 2026)'); ?></option>
                            <option value="عنابة (ندوة الشرق)" <?php echo ($preselect_seminar == 'annaba') ? 'selected' : ''; ?>><?php echo ($lang === 'ar') ? 'عنابة (ندوة الشرق - أوت 2026)' : (($lang === 'fr') ? 'Annaba (Séminaire de l’Est - Août 2026)' : 'Annaba (East Seminar - August 2026)'); ?></option>
                            <option value="وهران (ندوة الغرب)" <?php echo ($preselect_seminar == 'oran') ? 'selected' : ''; ?>><?php echo ($lang === 'ar') ? 'وهران (ندوة الغرب - سبتمبر 2026)' : (($lang === 'fr') ? 'Oran (Séminaire de l’Ouest - Septembre 2026)' : 'Oran (West Seminar - September 2026)'); ?></option>
                        </select>
                    </div>
                </div>

                <!-- 2. Core Representative Info -->
                <h3 class="form-section-title"><?php echo t('reg_personal_info'); ?></h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="representative_name"><?php echo t('reg_rep_name'); ?> *</label>
                        <input type="text" id="representative_name" name="representative_name" required placeholder="<?php echo ($lang === 'ar') ? 'مثال: أحمد علوي' : (($lang === 'fr') ? 'Ex: Ahmed Alawi' : 'e.g. Ahmed Alawi'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="representative_title"><?php echo t('reg_rep_title'); ?></label>
                        <input type="text" id="representative_title" name="representative_title" placeholder="<?php echo ($lang === 'ar') ? 'مثال: مدير التطوير، طالب، مهندس...' : (($lang === 'fr') ? 'Ex: Directeur, Ingénieur, Étudiant...' : 'e.g. Director, Engineer, Student...'); ?>">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="email"><?php echo t('reg_email'); ?> *</label>
                        <input type="email" id="email" name="email" required placeholder="name@domain.com">
                    </div>
                    <div class="form-group">
                        <label for="phone"><?php echo t('reg_phone'); ?> *</label>
                        <input type="text" id="phone" name="phone" required placeholder="06XXXXXXXX / 05XXXXXXXX">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="wilaya"><?php echo t('reg_wilaya'); ?> *</label>
                        <select id="wilaya" name="wilaya" required>
                            <option value=""><?php echo ($lang === 'ar') ? 'اختر الولاية...' : (($lang === 'fr') ? 'Choisir la wilaya...' : 'Select Wilaya...'); ?></option>
                            <option value="01 - أدرار">01 - Adrar</option>
                            <option value="02 - الشلف">02 - Chlef</option>
                            <option value="03 - الأغواط">03 - Laghouat</option>
                            <option value="04 - أم البواقي">04 - Oum El Bouaghi</option>
                            <option value="05 - باتنة">05 - Batna</option>
                            <option value="06 - بجاية">06 - Béjaïa</option>
                            <option value="07 - بسكرة">07 - Biskra</option>
                            <option value="08 - بشار">08 - Béchar</option>
                            <option value="09 - البليدة">09 - Blida</option>
                            <option value="10 - البويرة">10 - Bouira</option>
                            <option value="11 - تمنراست">11 - Tamanrasset</option>
                            <option value="12 - تبسة">12 - Tébessa</option>
                            <option value="13 - تلمسان">13 - Tlemcen</option>
                            <option value="14 - تيارت">14 - Tiaret</option>
                            <option value="15 - تيزي وزو">15 - Tizi Ouzou</option>
                            <option value="16 - الجزائر العاصمة" <?php echo ($preselect_seminar == 'algiers') ? 'selected' : ''; ?>>16 - Alger</option>
                            <option value="17 - الجلفة">17 - Djelfa</option>
                            <option value="18 - جيجل">18 - Jijel</option>
                            <option value="19 - سطيف">19 - Sétif</option>
                            <option value="20 - سعيدة">20 - Saïda</option>
                            <option value="21 - سكيكدة">21 - Skikda</option>
                            <option value="22 - سيدي بلعباس">22 - Sidi Bel Abbès</option>
                            <option value="23 - عنابة" <?php echo ($preselect_seminar == 'annaba') ? 'selected' : ''; ?>>23 - Annaba</option>
                            <option value="24 - قالمة">24 - Guelma</option>
                            <option value="25 - قسنطينة">25 - Constantine</option>
                            <option value="26 - المدية">26 - Médéa</option>
                            <option value="27 - مستغانم">27 - Mostaganem</option>
                            <option value="28 - المسيلة">28 - M'Sila</option>
                            <option value="29 - معسكر">29 - Mascara</option>
                            <option value="30 - ورقلة" <?php echo ($preselect_seminar == 'ouargla') ? 'selected' : ''; ?>>30 - Ouargla</option>
                            <option value="31 - وهران" <?php echo ($preselect_seminar == 'oran') ? 'selected' : ''; ?>>31 - Oran</option>
                            <option value="32 - البيض">32 - El Bayadh</option>
                            <option value="33 - إليزي">33 - Illizi</option>
                            <option value="34 - برج بوعريريج">34 - Bordj Bou Arréridj</option>
                            <option value="35 - بومرداس">35 - Boumerdès</option>
                            <option value="36 - الطارف">36 - El Tarf</option>
                            <option value="37 - تندوف">37 - Tindouf</option>
                            <option value="38 - تيسمسيلت">38 - Tissemsilt</option>
                            <option value="39 - الوادي">39 - El Oued</option>
                            <option value="40 - خنشلة">40 - Khenchela</option>
                            <option value="41 - سوق أهراس">41 - Souk Ahras</option>
                            <option value="42 - تيبازة">42 - Tipaza</option>
                            <option value="43 - ميلة">43 - Mila</option>
                            <option value="44 - عين الدفلى">44 - Aïn Defla</option>
                            <option value="45 - النعامة">45 - Naâma</option>
                            <option value="46 - عين تموشنت">46 - Aïn Témouchent</option>
                            <option value="47 - غرداية">47 - Ghardaïa</option>
                            <option value="48 - غليزان">48 - Relizane</option>
                            <option value="49 - تيميمون">49 - Timimoun</option>
                            <option value="50 - برج باجي مختار">50 - Bordj Badji Mokhtar</option>
                            <option value="51 - أولاد جلال">51 - Ouled Djellal</option>
                            <option value="52 - بني عباس">52 - Béni Abbès</option>
                            <option value="53 - عين صالح">53 - In Salah</option>
                            <option value="54 - عين قزام">54 - In Guezzam</option>
                            <option value="55 - تقرت">55 - Touggourt</option>
                            <option value="56 - جانت">56 - Djanet</option>
                            <option value="57 - المغير">57 - El M'Ghair</option>
                            <option value="58 - المنيعة">58 - El Meniaa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="website"><?php echo t('reg_website'); ?></label>
                        <input type="url" id="website" name="website" placeholder="https://domain.com">
                    </div>
                </div>

                <div class="form-group">
                    <label for="address"><?php echo t('reg_address'); ?> *</label>
                    <textarea id="address" name="address" rows="2" required placeholder="<?php echo ($lang === 'ar') ? 'العنوان البريدي للمراسلة الرسمي' : (($lang === 'fr') ? 'Adresse postale officielle' : 'Official mailing address'); ?>"></textarea>
                </div>



                <!-- 3. Dynamic Section: Organization Info -->
                <div id="fields-org-only" style="display:none; margin-top: 2rem; border-top: 1px dashed var(--border-color); padding-top: 2rem;">
                    <h3 class="form-section-title"><?php echo t('reg_org_info'); ?></h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="organization_name"><?php echo t('reg_org_name'); ?> *</label>
                            <input type="text" id="organization_name" name="organization_name" placeholder="<?php echo ($lang === 'ar') ? 'مثال: المؤسسة الوطنية للحديد والصلب' : (($lang === 'fr') ? 'Ex: Société Nationale de Sidérurgie' : 'e.g. National Steel Company'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="legal_status"><?php echo t('reg_legal_status'); ?></label>
                            <select id="legal_status" name="legal_status">
                                <option value=""><?php echo ($lang === 'ar') ? 'اختر الشكل...' : (($lang === 'fr') ? 'Choisir la forme...' : 'Select Form...'); ?></option>
                                <option value="EURL">EURL</option>
                                <option value="SARL">SARL</option>
                                <option value="SPA">SPA</option>
                                <option value="SNC">SNC</option>
                                <option value="أخرى"><?php echo ($lang === 'ar') ? 'شكل قانوني آخر' : (($lang === 'fr') ? 'Autre forme juridique' : 'Other legal form'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="commercial_register_no"><?php echo t('reg_cr_no'); ?></label>
                            <input type="text" id="commercial_register_no" name="commercial_register_no" placeholder="N° RC">
                        </div>
                        <div class="form-group">
                            <label for="nif"><?php echo t('reg_nif'); ?></label>
                            <input type="text" id="nif" name="nif" placeholder="NIF">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="economic_sector"><?php echo t('reg_sector'); ?> *</label>
                            <select id="economic_sector" name="economic_sector">
                                <option value=""><?php echo ($lang === 'ar') ? 'اختر القطاع...' : (($lang === 'fr') ? 'Choisir le secteur...' : 'Select Sector...'); ?></option>
                                <option value="الميكانيك والحديد"><?php echo ($lang === 'ar') ? 'الميكانيك والحديد والصلب' : (($lang === 'fr') ? 'Mécanique, Fer & Acier' : 'Mechanics, Iron & Steel'); ?></option>
                                <option value="البلاستيك والكيمياء"><?php echo ($lang === 'ar') ? 'الصناعات الكيميائية والبتروكيميائية' : (($lang === 'fr') ? 'Industries Chimiques & Pétrochimiques' : 'Chemical & Petrochemical Industries'); ?></option>
                                <option value="الطاقة والكهرباء"><?php echo ($lang === 'ar') ? 'الطاقة والمناولة اللوجستية الكهربائية' : (($lang === 'fr') ? 'Énergie & Logistique Électrique' : 'Energy & Electrical Logistics'); ?></option>
                                <option value="صناعة السيارات"><?php echo ($lang === 'ar') ? 'صناعة وتركيب السيارات وقطع الغيار' : (($lang === 'fr') ? 'Automobile & Pièces Détachées' : 'Automotive & Spare Parts'); ?></option>
                                <option value="صناعات غذائية"><?php echo ($lang === 'ar') ? 'الصناعات الغذائية والتحويلية' : (($lang === 'fr') ? 'Agroalimentaire & Transformation' : 'Agrifood & Transformation'); ?></option>
                                <option value="تكنولوجيا ورقمنة"><?php echo ($lang === 'ar') ? 'التكنولوجيا والبرمجيات الذكية 4.0' : (($lang === 'fr') ? 'Technologies & Logiciels 4.0' : 'Technologies & Smart Software 4.0'); ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company_size"><?php echo t('reg_size'); ?> *</label>
                            <select id="company_size" name="company_size">
                                <option value=""><?php echo ($lang === 'ar') ? 'اختر الحجم...' : (($lang === 'fr') ? 'Choisir la taille...' : 'Select Size...'); ?></option>
                                <option value="مصغرة"><?php echo ($lang === 'ar') ? 'مؤسسة مصغرة (Micro)' : (($lang === 'fr') ? 'Micro-entreprise (Micro)' : 'Micro Enterprise (Micro)'); ?></option>
                                <option value="صغيرة"><?php echo ($lang === 'ar') ? 'مؤسسة صغيرة (Small)' : (($lang === 'fr') ? 'Petite entreprise (Small)' : 'Small Enterprise (Small)'); ?></option>
                                <option value="متوسطة"><?php echo ($lang === 'ar') ? 'مؤسسة متوسطة (Medium)' : (($lang === 'fr') ? 'Moyenne entreprise (Medium)' : 'Medium Enterprise (Medium)'); ?></option>
                                <option value="كبيرة"><?php echo ($lang === 'ar') ? 'مؤسسة كبرى (Large)' : (($lang === 'fr') ? 'Grande entreprise (Large)' : 'Large Enterprise (Large)'); ?></option>
                                <option value="ناشئة"><?php echo ($lang === 'ar') ? 'شركة ناشئة (Startup)' : (($lang === 'fr') ? 'Start-up' : 'Startup'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="main_activity"><?php echo t('reg_activity'); ?></label>
                        <input type="text" id="main_activity" name="main_activity" placeholder="<?php echo ($lang === 'ar') ? 'مثال: تصنيع الهياكل المعدنية، توريد الكوابل...' : (($lang === 'fr') ? 'Ex: Fabrication de charpentes, câbles...' : 'e.g. Metal structures manufacturing, cables...'); ?>">
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="company_type"><?php echo ($lang === 'ar') ? 'طبيعة نشاط المؤسسة *' : (($lang === 'fr') ? 'Nature d’activité de l’entreprise *' : 'Company Activity Nature *'); ?></label>
                            <select id="company_type" name="company_type">
                                <option value=""><?php echo ($lang === 'ar') ? 'اختر طبيعة النشاط...' : (($lang === 'fr') ? 'Choisir la nature...' : 'Select Nature...'); ?></option>
                                <option value="منتجة"><?php echo ($lang === 'ar') ? 'مؤسسة منتجة للمخرجات النهائية' : (($lang === 'fr') ? 'Entreprise productrice finale' : 'End-product Manufacturer'); ?></option>
                                <option value="مناولة"><?php echo ($lang === 'ar') ? 'مؤسسة مناولة (موردة للقطع والمكونات)' : (($lang === 'fr') ? 'Sous-traitant (Fournisseur composants)' : 'Subcontractor (Parts/Component Supplier)'); ?></option>
                                <option value="خدماتية"><?php echo ($lang === 'ar') ? 'مقدم خدمات صناعية / لوجستية / استشارية' : (($lang === 'fr') ? 'Prestataire de services industriels' : 'Industrial Service Provider'); ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company_logo"><?php echo ($lang === 'ar') ? 'شعار المؤسسة' : (($lang === 'fr') ? 'Logo de l’entreprise' : 'Company Logo'); ?></label>
                            <input type="file" id="company_logo" name="company_logo" accept="image/*">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="company_profile_pdf"><?php echo ($lang === 'ar') ? 'الملف التعريفي الفني للمؤسسة (Company Profile)' : (($lang === 'fr') ? 'Profil Technique de l’entreprise (PDF)' : 'Company Technical Profile (PDF)'); ?></label>
                        <input type="file" id="company_profile_pdf" name="company_profile_pdf" accept="application/pdf">
                        <span class="file-hint"><?php echo ($lang === 'ar') ? 'صيغة مدعومة: PDF فقط. الحد الأقصى للحجم: 5 ميغابايت.' : (($lang === 'fr') ? 'Format supporté : PDF uniquement. Taille max : 5 Mo.' : 'Supported format: PDF only. Max size: 5MB.'); ?></span>
                    </div>
                </div>

                <!-- 4. Dynamic Section: B2B Matchmaking info -->
                <div id="fields-b2b-only" style="display:none; margin-top: 2rem; border-top: 1px dashed var(--border-color); padding-top: 2rem;">
                    <h3 class="form-section-title"><?php echo t('reg_b2b_details'); ?></h3>
                    <div class="form-group">
                        <label for="b2b_role"><?php echo t('reg_b2b_role'); ?> *</label>
                        <select id="b2b_role" name="b2b_role">
                            <option value=""><?php echo ($lang === 'ar') ? 'اختر الدور...' : (($lang === 'fr') ? 'Choisir le rôle...' : 'Select Role...'); ?></option>
                            <option value="طالب خدمة / مصنع يبحث عن مناولين"><?php echo ($lang === 'ar') ? 'طالب خدمة / مصنع كبرى يبحث عن مناولين (Buyer/Purchaser)' : (($lang === 'fr') ? 'Donneur d’ordre / Acheteur (Buyer/Purchaser)' : 'Buyer / Purchaser searching for suppliers'); ?></option>
                            <option value="مناول يعرض خدماته ومنتجاته"><?php echo ($lang === 'ar') ? 'مناول يعرض خدماته ومنتجاته وقطع الغيار (Subcontractor/Supplier)' : (($lang === 'fr') ? 'Sous-traitant / Fournisseur (Subcontractor/Supplier)' : 'Subcontractor / Supplier presenting products'); ?></option>
                            <option value="هيئة تمويل / بنك يدعم الاستثمار"><?php echo ($lang === 'ar') ? 'هيئة تمويل أو بنك يدعم استثمارات المناولة الصناعية' : (($lang === 'fr') ? 'Organisme de financement ou Banque' : 'Financing Institution or Bank'); ?></option>
                            <option value="مخبر مطابقة وتقييس للخدمات"><?php echo ($lang === 'ar') ? 'مخبر مطابقة ومعايرة وهيئة اعتماد' : (($lang === 'fr') ? 'Laboratoire de conformité & certification' : 'Compliance Laboratory & Certification Body'); ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo t('reg_b2b_sectors'); ?>:</label>
                        <div class="checkbox-grid">
                            <label class="checkbox-item"><input type="checkbox" name="sectors_needed[]" value="الميكانيك والحديد"> <?php echo ($lang === 'ar') ? 'الصناعات الميكانيكية والحديدية' : (($lang === 'fr') ? 'Industries Mécaniques & Métallurgiques' : 'Mechanical & Metallurgy'); ?></label>
                            <label class="checkbox-item"><input type="checkbox" name="sectors_needed[]" value="صناعة البلاستيك"> <?php echo ($lang === 'ar') ? 'صناعة البلاستيك والمطاط' : (($lang === 'fr') ? 'Plastique & Caoutchouc' : 'Plastics & Rubber'); ?></label>
                            <label class="checkbox-item"><input type="checkbox" name="sectors_needed[]" value="التجهيزات الكهربائية"> <?php echo ($lang === 'ar') ? 'المكونات واللوحات الكهربائية' : (($lang === 'fr') ? 'Électrique & Électronique' : 'Electrical & Electronics'); ?></label>
                            <label class="checkbox-item"><input type="checkbox" name="sectors_needed[]" value="المطابقة والتقييس"> <?php echo ($lang === 'ar') ? 'مخابر المطابقة والمعايرة' : (($lang === 'fr') ? 'Laboratoires & Certification' : 'Labs & Certification'); ?></label>
                            <label class="checkbox-item"><input type="checkbox" name="sectors_needed[]" value="خدمات تكنولوجية"> <?php echo ($lang === 'ar') ? 'الرقمنة ونظم المعلومات 4.0' : (($lang === 'fr') ? 'Digitalisation & SI 4.0' : 'Digitalization & IT 4.0'); ?></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo t('reg_b2b_opportunities'); ?>:</label>
                        <div class="checkbox-grid">
                            <label class="checkbox-item"><input type="checkbox" name="opportunities_needed[]" value="توريد"> <?php echo ($lang === 'ar') ? 'عقد توريد قطع ومكونات' : (($lang === 'fr') ? 'Contrat de fourniture de pièces' : 'Parts Supply Contract'); ?></label>
                            <label class="checkbox-item"><input type="checkbox" name="opportunities_needed[]" value="تصنيع"> <?php echo ($lang === 'ar') ? 'تصنيع مشترك محلي' : (($lang === 'fr') ? 'Co-fabrication locale' : 'Local Joint Manufacturing'); ?></label>
                            <label class="checkbox-item"><input type="checkbox" name="opportunities_needed[]" value="صيانة"> <?php echo ($lang === 'ar') ? 'صيانة الآلات وخطوط الإنتاج' : (($lang === 'fr') ? 'Maintenance industrielle' : 'Industrial Maintenance'); ?></label>
                            <label class="checkbox-item"><input type="checkbox" name="opportunities_needed[]" value="تمويل"> <?php echo ($lang === 'ar') ? 'تمويل وضمان القروض' : (($lang === 'fr') ? 'Financement & Garanties' : 'Financing & Guarantee'); ?></label>
                        </div>
                    </div>
                </div>

                <!-- 5. Dynamic Section: Hackathon Team info -->
                <div id="fields-hack-only" style="display:none; margin-top: 2rem; border-top: 1px dashed var(--border-color); padding-top: 2rem;">
                    <h3 class="form-section-title"><?php echo t('reg_hack_details'); ?></h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="team_name"><?php echo t('reg_hack_team_name'); ?> *</label>
                            <input type="text" id="team_name" name="team_name" placeholder="<?php echo ($lang === 'ar') ? 'مثال: فريق المهندسين الأحرار' : (($lang === 'fr') ? 'Ex: Équipe InnovTech' : 'e.g. InnovTech Team'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="members_count"><?php echo t('reg_hack_members'); ?> *</label>
                            <select id="members_count" name="members_count">
                                <option value="3">3 <?php echo ($lang === 'ar') ? 'أعضاء' : (($lang === 'fr') ? 'membres' : 'members'); ?></option>
                                <option value="4">4 <?php echo ($lang === 'ar') ? 'أعضاء' : (($lang === 'fr') ? 'membres' : 'members'); ?></option>
                                <option value="5">5 <?php echo ($lang === 'ar') ? 'أعضاء' : (($lang === 'fr') ? 'membres' : 'members'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hack_track"><?php echo t('reg_hack_track'); ?> *</label>
                        <select id="hack_track" name="hack_track">
                            <option value=""><?php echo ($lang === 'ar') ? 'اختر المحور...' : (($lang === 'fr') ? 'Choisir l’axe...' : 'Select Track...'); ?></option>
                            <option value="المناولة الذكية"><?php echo ($lang === 'ar') ? 'المناولة الذكية وسلاسل الإمداد الرقمية' : (($lang === 'fr') ? 'Sous-traitance intelligente & Supply Chain' : 'Smart Subcontracting & Supply Chain'); ?></option>
                            <option value="تتبع الجودة والمطابقة"><?php echo ($lang === 'ar') ? 'أنظمة تتبع الجودة والمطابقة الرقمية' : (($lang === 'fr') ? 'Traçabilité Qualité & Conformité' : 'Quality Traceability & Compliance'); ?></option>
                            <option value="الصيانة 4.0"><?php echo ($lang === 'ar') ? 'الصيانة التنبؤية والتطبيقات الذكية 4.0' : (($lang === 'fr') ? 'Maintenance prédictive & 4.0' : 'Predictive Maintenance & 4.0'); ?></option>
                            <option value="اللوجستيك الأخضر"><?php echo ($lang === 'ar') ? 'اللوجستيك الأخضر وتقليل تكلفة الإنتاج' : (($lang === 'fr') ? 'Logistique verte & réduction des coûts' : 'Green Logistics & Cost Reduction'); ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hack_idea"><?php echo t('reg_hack_idea'); ?> *</label>
                        <textarea id="hack_idea" name="hack_idea" rows="4" placeholder="<?php echo ($lang === 'ar') ? 'اشرح الفكرة، القيمة المضافة، والتقنيات المقترح استخدامها لحل التحدي...' : (($lang === 'fr') ? 'Décrivez l’idée, la valeur ajoutée et les technologies...' : 'Explain the idea, value add, and technology stack...'); ?>"></textarea>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="checkbox-item" style="flex-direction: row; align-items: center; gap: 0.5rem; margin-top: 1.5rem;">
                                <input type="checkbox" name="has_prototype" value="1"> <?php echo t('reg_hack_prototype'); ?>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="github_link"><?php echo ($lang === 'ar') ? 'رابط مستودع GitHub أو Portfolio للمطورين' : (($lang === 'fr') ? 'Lien GitHub ou Portfolio' : 'GitHub Repository or Portfolio Link'); ?></label>
                            <input type="url" id="github_link" name="github_link" placeholder="https://github.com/username">
                        </div>
                    </div>
                </div>

                <!-- 6. Dynamic Section: Pitch Box submissions -->
                <div id="fields-pitch-only" style="display:none; margin-top: 2rem; border-top: 1px dashed var(--border-color); padding-top: 2rem;">
                    <h3 class="form-section-title"><?php echo t('reg_pitch_details'); ?></h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="pitch_project_name"><?php echo t('reg_pitch_project'); ?> *</label>
                            <input type="text" id="pitch_project_name" name="pitch_project_name" placeholder="<?php echo ($lang === 'ar') ? 'مثال: جهاز المعايرة الرقمي الذكي' : (($lang === 'fr') ? 'Ex: Capteur de mesure intelligent 4.0' : 'e.g. Smart 4.0 Sensor'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="pitch_sector"><?php echo ($lang === 'ar') ? 'قطاع المشروع *' : (($lang === 'fr') ? 'Secteur du projet *' : 'Project Sector *'); ?></label>
                            <input type="text" id="pitch_sector" name="pitch_sector" placeholder="<?php echo ($lang === 'ar') ? 'مثال: تكنولوجيا الصناعة، الذكاء الاصطناعي' : (($lang === 'fr') ? 'Ex: Industrie 4.0, IA' : 'e.g. Industry 4.0, AI'); ?>">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="pitch_stage"><?php echo t('reg_pitch_stage'); ?> *</label>
                            <select id="pitch_stage" name="pitch_stage">
                                <option value=""><?php echo ($lang === 'ar') ? 'اختر المرحلة...' : (($lang === 'fr') ? 'Choisir l’étape...' : 'Select Stage...'); ?></option>
                                <option value="فكرة"><?php echo ($lang === 'ar') ? 'فكرة فقط (Idea)' : (($lang === 'fr') ? 'Idée (Idea)' : 'Idea'); ?></option>
                                <option value="نموذج أولي"><?php echo ($lang === 'ar') ? 'نموذج أولي مبدئي (Prototype)' : (($lang === 'fr') ? 'Prototype' : 'Prototype'); ?></option>
                                <option value="نشاط قائم"><?php echo ($lang === 'ar') ? 'نشاط تجاري قائم وقيد التشغيل' : (($lang === 'fr') ? 'Entreprise opérationnelle' : 'Operational Business'); ?></option>
                                <option value="توسعة"><?php echo ($lang === 'ar') ? 'توسعة لمشروع ناجح وبحث عن استثمار' : (($lang === 'fr') ? 'Projet en expansion / Recherche d’investissement' : 'Expanding Project / Seeking Investment'); ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pitch_need"><?php echo t('reg_pitch_need'); ?> *</label>
                            <select id="pitch_need" name="pitch_need">
                                <option value=""><?php echo ($lang === 'ar') ? 'اختر الاحتياج...' : (($lang === 'fr') ? 'Choisir le besoin...' : 'Select Need...'); ?></option>
                                <option value="تمويل واستثمار"><?php echo ($lang === 'ar') ? 'تمويل واستثمار مالي' : (($lang === 'fr') ? 'Financement et investissement' : 'Funding & Financial Investment'); ?></option>
                                <option value="شريك تكنولوجي أو صناعي"><?php echo ($lang === 'ar') ? 'شريك تكنولوجي أو صناعي' : (($lang === 'fr') ? 'Partenaire technologique ou industriel' : 'Technological or Industrial Partner'); ?></option>
                                <option value="سوق وعقود مناولة مباشرة"><?php echo ($lang === 'ar') ? 'سوق وعقود مناولة وتصريف المنتجات' : (($lang === 'fr') ? 'Accès marché et contrats de sous-traitance' : 'Market Access & Subcontracting Contracts'); ?></option>
                                <option value="مرافقة واحتضان وتطوير فني"><?php echo ($lang === 'ar') ? 'مرافقة وحاضنة لتطوير النموذج الفني' : (($lang === 'fr') ? 'Accompagnement et incubation' : 'Mentorship & Incubation'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pitch_desc"><?php echo t('reg_pitch_desc'); ?> *</label>
                        <textarea id="pitch_desc" name="pitch_desc" rows="3" maxlength="500" placeholder="<?php echo ($lang === 'ar') ? 'اكتب خلاصة مشروعك والقيمة المقترحة لخدماتكم...' : (($lang === 'fr') ? 'Décrivez brièvement votre projet et sa valeur ajoutée...' : 'Briefly describe your project and value proposition...'); ?>"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="pitch_value"><?php echo t('reg_pitch_value'); ?> *</label>
                        <textarea id="pitch_value" name="pitch_value" rows="3" placeholder="<?php echo ($lang === 'ar') ? 'لماذا مشروعكم فريد؟ ما هي المشكلة التي يحلها؟' : (($lang === 'fr') ? 'Pourquoi votre projet est-il unique ? Quel problème résout-il ?' : 'Why is your project unique? What problem does it solve?'); ?>"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="pitch_video_link"><?php echo t('reg_pitch_video'); ?></label>
                        <input type="url" id="pitch_video_link" name="pitch_video_link" placeholder="https://youtube.com/watch?v=...">
                        <span class="file-hint"><?php echo ($lang === 'ar') ? 'فيديو قصير مدته دقيقة يوضح فكرة مشروعك بشكل عملي.' : (($lang === 'fr') ? 'Courte vidéo d’une minute expliquant votre projet.' : 'Short 1-minute video demonstrating your project idea.'); ?></span>
                    </div>
                </div>

                <!-- Terms Acceptance -->
                <div class="form-group" style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                    <label class="checkbox-item">
                        <input type="checkbox" required name="accept_terms" value="1"> <span><?php echo ($lang === 'ar') ? 'أقر بصحة البيانات المسجلة وأوافق على' : (($lang === 'fr') ? 'Je certifie l’exactitude des données et j’accepte les' : 'I certify that the information is accurate and agree to the'); ?> <a href="terms.php" target="_blank" style="color: var(--primary); text-decoration: underline; font-weight: 700;"><?php echo t('footer_terms'); ?></a> <?php echo ($lang === 'ar') ? 'و' : (($lang === 'fr') ? 'et la' : 'and'); ?> <a href="privacy.php" target="_blank" style="color: var(--primary); text-decoration: underline; font-weight: 700;"><?php echo t('footer_privacy'); ?></a> <?php echo ($lang === 'ar') ? 'لمنصة إدماج.' : (($lang === 'fr') ? 'de la plateforme IDMAJ.' : 'of IDMAJ platform.'); ?> *</span>
                    </label>
                </div>

                <div class="form-actions text-center" style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;"><?php echo t('reg_submit'); ?></button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</section>

<style>
.register-form {
    padding: 3rem;
}
@media (max-width: 768px) {
    .register-form {
        padding: 1.5rem;
    }
}
@media (max-width: 576px) {
    .register-form {
        padding: 1.2rem 0.85rem;
    }
    .id-code {
        font-size: 1.6rem;
        letter-spacing: 1px;
    }
    .id-card-display {
        padding: 1rem;
        width: 100%;
    }
}
.form-section-title {
    font-size: 1.15rem;
    color: var(--primary);
    margin-top: 2.5rem;
    margin-bottom: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 0.6rem;
    font-weight: 700;
    position: relative;
}
.form-section-title::after {
    content: '';
    position: absolute;
    bottom: -1px;
    right: 0;
    width: 40px;
    height: 2px;
    background-color: var(--primary);
}
.file-hint {
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-top: 0.3rem;
    display: block;
}
.registration-success {
    padding: 4rem 2rem;
}
.success-icon {
    font-size: 4rem;
    display: block;
    margin-bottom: 1.5rem;
}
.id-card-display {
    background-color: rgba(14, 165, 233, 0.08);
    border: 1px dashed var(--primary);
    padding: 1.5rem;
    border-radius: 0.8rem;
    margin: 2rem 0;
    display: inline-block;
}
.id-label {
    display: block;
    font-size: 0.9rem;
    color: var(--text-muted);
    margin-bottom: 0.5rem;
}
.id-code {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--primary);
    letter-spacing: 2px;
    font-family: 'Outfit', sans-serif;
}
.success-note {
    font-size: 0.9rem;
    color: var(--text-muted);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.7;
}
</style>

<?php include 'includes/footer.php'; ?>
