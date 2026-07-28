<?php
// website/privacy.php: Privacy Policy Page for IDMAJ 2026 with Multilingual support
require_once 'includes/lang.php';
$page_title = t('brand_title') . " 2026 - " . t('footer_privacy');
include 'includes/header.php';
?>

<!-- Page Banner -->
<section class="page-banner text-center">
    <div class="container">
        <span class="badge badge-primary"><?php echo t('footer_privacy'); ?></span>
        <h1><?php echo t('footer_privacy'); ?></h1>
        <p><?php echo ($lang === 'ar') ? 'التزامنا الكامل بحماية خصوصيتك وسرية بياناتك وفقاً للتشريعات والأطر القانونية' : (($lang === 'fr') ? 'Notre engagement complet pour la protection de vos données personnelles' : 'Our commitment to protecting your personal data and privacy'); ?></p>
    </div>
</section>

<!-- Content Section -->
<section class="section-padding legal-content-section">
    <div class="container" style="max-width: 900px;">
        <div class="premium-card legal-card">
            
            <div class="legal-header">
                <div class="legal-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <div>
                    <h2><?php echo ($lang === 'ar') ? 'سياسة الخصوصية لمنصة إدماج (IDMAJ 2026)' : (($lang === 'fr') ? 'Politique de Confidentialité de la Plateforme IDMAJ 2026' : 'Privacy Policy for IDMAJ 2026 Platform'); ?></h2>
                    <span class="legal-date"><?php echo ($lang === 'ar') ? 'تاريخ آخر تحديث: 24 جوان 2026 | متوافق مع القانون 18-07 المتعلق بحماية المعطيات ذات الطابع الشخصي' : (($lang === 'fr') ? 'Dernière mise à jour : 24 Juin 2026 | Conforme à la Loi 18-07 relative à la protection des données personnelles' : 'Last Updated: June 24, 2026 | Compliant with Law 18-07 on Personal Data Protection'); ?></span>
                </div>
            </div>

            <hr class="legal-divider">

            <div class="legal-body">
                
                <!-- Section 1 -->
                <div class="legal-block">
                    <h3><span class="block-num">01</span> <?php echo ($lang === 'ar') ? 'مقدمة ونطاق التطبيق' : (($lang === 'fr') ? 'Introduction et Champ d’Application' : 'Introduction & Scope'); ?></h3>
                    <p>
                        <?php echo ($lang === 'ar') ? 
                        'تولي **المنصة الوطنية الرقمية للجلسات الوطنية إدماج 2026 (WWW.IDMADJ.DZ)** أهمية قصوى لحماية الخصوصية والمعطيات ذات الطابع الشخصي للمشاركين، المؤسسات الاقتصادية، والزوار. تهدف هذه السياسة إلى توضيح كيفية جمع، استخدام، وحماية بياناتكم عند استخدام المنصة أو التسجيل في فعاليات الجلسات الوطنية ورعايتها.' : 
                        (($lang === 'fr') ? 
                        'La plateforme numérique nationale **IDMAJ 2026 (WWW.IDMADJ.DZ)** accorde une importance primordiale à la protection de la vie privée et des données à caractère personnel de ses participants, entreprises et visiteurs. Cette politique décrit la manière dont vos informations sont collectées, utilisées et sécurisées.' : 
                        'The national digital platform **IDMAJ 2026 (WWW.IDMADJ.DZ)** places the highest priority on protecting the privacy and personal data of its participants, businesses, and visitors. This policy outlines how your information is collected, used, and secured.'); ?>
                    </p>
                </div>

                <!-- Section 2 -->
                <div class="legal-block">
                    <h3><span class="block-num">02</span> <?php echo ($lang === 'ar') ? 'المعطيات التي نجمعها' : (($lang === 'fr') ? 'Données Collectées' : 'Data We Collect'); ?></h3>
                    <p><?php echo ($lang === 'ar') ? 'عند استخدامكم للمنصة أو تعبئة استمارات التسجيل (للمشاركين، المؤسسات، مسابقة الهاكاثون، أو لقاءات B2B)، قد نقوم بجمع المعطيات التالية:' : (($lang === 'fr') ? 'Lors de l’utilisation de la plateforme ou du remplissage des formulaires (B2B, Hackathon, Pitch Box), nous collectons :' : 'When using the platform or filling out registration forms (B2B, Hackathon, Pitch Box), we may collect:'); ?></p>
                    <ul class="legal-list">
                        <li><strong><?php echo ($lang === 'ar') ? 'بيانات الهوية والتواصل الشخصي:' : (($lang === 'fr') ? 'Identité et Contact :' : 'Identity & Personal Contact:'); ?></strong> <?php echo ($lang === 'ar') ? 'الاسم، اللقب، البريد الإلكتروني، رقم الهاتف، الولاية، والصفة المهنية.' : (($lang === 'fr') ? 'Nom, prénom, email, téléphone, wilaya et fonction professionnelle.' : 'Full name, email, phone number, wilaya, and job position.'); ?></li>
                        <li><strong><?php echo ($lang === 'ar') ? 'بيانات المؤسسة الاقتصادية:' : (($lang === 'fr') ? 'Données Entreprise :' : 'Company Information:'); ?></strong> <?php echo ($lang === 'ar') ? 'اسم الشركة، الشكل القانوني (EURL, SARL, SPA...)، رقم السجل التجاري (RC)، رقم التعريف الجبائي (NIF)، القطاع الصناعي، وحجم المؤسسة.' : (($lang === 'fr') ? 'Raison sociale, forme juridique (SARL, SPA...), N° Registre du Commerce, NIF, secteur et taille.' : 'Organization name, legal status, Commercial Register No., NIF, industrial sector, company size.'); ?></li>
                        <li><strong><?php echo ($lang === 'ar') ? 'بيانات النشاط والمناولة:' : (($lang === 'fr') ? 'Activité et Sous-traitance :' : 'Activity & Subcontracting Data:'); ?></strong> <?php echo ($lang === 'ar') ? 'طبيعة المنتجات المصنعة، الاحتياجات اللوجستية، وعروض وتطلعات الشراكة في لقاءات B2B.' : (($lang === 'fr') ? 'Capacités de production, besoins logistiques et offres de partenariat B2B.' : 'Manufacturing capacities, logistics needs, and B2B partnership goals.'); ?></li>
                        <li><strong><?php echo ($lang === 'ar') ? 'البيانات التقنية:' : (($lang === 'fr') ? 'Données Techniques :' : 'Technical Data:'); ?></strong> <?php echo ($lang === 'ar') ? 'عنوان الـ IP، نوع المتصفح، ونظام التشغيل لغرض تحسين تجربة التصفح والأمان الرقمي.' : (($lang === 'fr') ? 'Adresse IP, type de navigateur et système d’exploitation pour l’optimisation et la sécurité.' : 'IP address, browser type, and operating system for security and user experience.'); ?></li>
                    </ul>
                </div>

                <!-- Section 3 -->
                <div class="legal-block">
                    <h3><span class="block-num">03</span> <?php echo ($lang === 'ar') ? 'أغراض معالجة البيانات' : (($lang === 'fr') ? 'Finalités du Traitement des Données' : 'Purposes of Data Processing'); ?></h3>
                    <p><?php echo ($lang === 'ar') ? 'نستخدم المعطيات المجمعة حصرياً للأغراض التنظيمية التالية:' : (($lang === 'fr') ? 'Nous utilisons les données collectées exclusivement aux fins organisationnelles suivantes :' : 'We use collected data exclusively for the following organizational purposes:'); ?></p>
                    <ul class="legal-list">
                        <li><?php echo ($lang === 'ar') ? 'تأكيد ومعالجة طلبات التسجيل وحجز المقاعد في الندوات الجهوية والجلسات الوطنية.' : (($lang === 'fr') ? 'Confirmation et gestion des inscriptions aux assises et séminaires régionaux.' : 'Confirming and processing registration requests for national sessions and regional seminars.'); ?></li>
                        <li><?php echo ($lang === 'ar') ? 'تنظيم وجدولة لقاءات الأعمال الثنائية (B2B) والربط الفعال بين الآمرين بالتأجير والمؤسسات المناولة.' : (($lang === 'fr') ? 'Planification des rendez-vous d’affaires B2B entre donneurs d’ordre et sous-traitants.' : 'Scheduling B2B matchmaking meetings between buyers and subcontractors.'); ?></li>
                        <li><?php echo ($lang === 'ar') ? 'إرسال الشارات الإلكترونية، الدعوات الرسمية، والتحديثات الهامة المتعلقة بالبرنامج.' : (($lang === 'fr') ? 'Émission des badges d’accès, invitations officielles et mises à jour du programme.' : 'Issuing digital badges, official invitations, and program updates.'); ?></li>
                        <li><?php echo ($lang === 'ar') ? 'إعداد الإحصائيات الوطنية والتقارير التجميعية لترقية المناولة والصناعة الذكية دون الكشف عن الخصوصية الفردية.' : (($lang === 'fr') ? 'Établissement de statistiques nationales anonymisées pour la promotion de l’industrie 4.0.' : 'Compiling anonymized national statistics to promote smart industry 4.0.'); ?></li>
                    </ul>
                </div>

                <!-- Section 4 -->
                <div class="legal-block">
                    <h3><span class="block-num">04</span> <?php echo ($lang === 'ar') ? 'سرية وأمان المعطيات' : (($lang === 'fr') ? 'Sécurité et Confidentialité' : 'Security & Confidentiality'); ?></h3>
                    <p>
                        <?php echo ($lang === 'ar') ? 
                        'نلتزم بتطبيق أحدث المعايير والبروتوكولات الأجدر بالأمان الرقمي (التشفير عبر SSL/TLS، جدران الحماية، والوصول المقيد) لضمان حماية المعطيات من أي تدمير أو فقدان أو تغيير أو إفصاح غير مصرح به.' : 
                        (($lang === 'fr') ? 
                        'Nous appliquons les normes de sécurité informatique les plus strictes (chiffrement SSL/TLS, pare-feu, accès restreint) pour garantir la protection de vos données contre tout accès, altération ou divulgation non autorisés.' : 
                        'We apply strict cybersecurity protocols (SSL/TLS encryption, firewalls, restricted access) to guarantee protection against unauthorized access, loss, or disclosure.'); ?>
                    </p>
                </div>

                <!-- Section 5 -->
                <div class="legal-block">
                    <h3><span class="block-num">05</span> <?php echo ($lang === 'ar') ? 'مشاركة البيانات مع الأطراف الثالثة' : (($lang === 'fr') ? 'Partage des Données avec des Tiers' : 'Third-Party Data Sharing'); ?></h3>
                    <p>
                        <?php echo ($lang === 'ar') ? 
                        'تتعهد منصة **إدماج** بعدم بيع أو تأجير أو متاجرة البيانات الشخصية أو بيانات المؤسسات لأي أطراف تجارية تسويقية. يتم مشاركة البيانات حصرياً وفي حدود الضرورة التنظيمية مع:' : 
                        (($lang === 'fr') ? 
                        'La plateforme **IDMAJ** s’engage à ne jamais vendre ni louer vos données à des fins commerciales. Les données sont partagées exclusivement avec :' : 
                        '**IDMAJ** platform commits never to sell or rent personal or corporate data to third parties. Data is shared strictly with:'); ?>
                    </p>
                    <ul class="legal-list">
                        <li><?php echo ($lang === 'ar') ? 'الهيئات والمؤسسات الرسمية الشريكة والمنظمة (مثل وزارة الصناعة والمؤسسة AFYE) لغرض التنسيق التنظيمي.' : (($lang === 'fr') ? 'Les institutions officielles organisatrices (Ministère de l’Industrie, AFYE) pour la coordination.' : 'Official organizing institutions (Ministry of Industry, AFYE) for logistics coordination.'); ?></li>
                        <li><?php echo ($lang === 'ar') ? 'الشركاء والآمرين بالتأجير المشاركين في لقاءات B2B لغرض تسهيل اتفاقيات الشراكة والمناولة.' : (($lang === 'fr') ? 'Les donneurs d’ordre et partenaires B2B concernés pour faciliter la mise en relation.' : 'Matched B2B buyers and partners to facilitate subcontracting agreements.'); ?></li>
                    </ul>
                </div>

                <!-- Section 6 -->
                <div class="legal-block">
                    <h3><span class="block-num">06</span> <?php echo ($lang === 'ar') ? 'حقوق المستخدمين' : (($lang === 'fr') ? 'Droits des Utilisateurs' : 'User Rights'); ?></h3>
                    <p><?php echo ($lang === 'ar') ? 'بموجب التشريعات النافذة، يمتلك المستخدم والمؤسسة كافة الحقوق المتعلقة بمعطياتهم:' : (($lang === 'fr') ? 'Conformément à la réglementation en vigueur (Loi 18-07), vous disposez des droits suivants :' : 'Under applicable legislation, users and organizations retain full rights:'); ?></p>
                    <ul class="legal-list">
                        <li><?php echo ($lang === 'ar') ? 'حق الوصول إلى البيانات المسجلة والاطلاع عليها.' : (($lang === 'fr') ? 'Droit d’accès et de consultation des données.' : 'Right to access and review registered data.'); ?></li>
                        <li><?php echo ($lang === 'ar') ? 'حق تصحيح أو تعديل أو تحديث المعطيات غير الدقيقة.' : (($lang === 'fr') ? 'Droit de rectification et de mise à jour.' : 'Right to rectify and update inaccurate information.'); ?></li>
                        <li><?php echo ($lang === 'ar') ? 'حق طلب حذف البيانات أو إلغاء التسجيل عبر مراسلة فريق الدعم الإلكتروني.' : (($lang === 'fr') ? 'Droit de suppression des données ou d’annulation d’inscription.' : 'Right to request data deletion or cancel registration.'); ?></li>
                    </ul>
                    <div class="contact-box" style="margin-top: 1.5rem; padding: 1.2rem; background: rgba(14, 165, 233, 0.08); border-radius: 0.8rem; border: 1px dashed var(--primary);">
                        <span><?php echo ($lang === 'ar') ? 'لأية استفسارات أو لممارسة حقوقكم، يرجى التواصل معنا عبر البريد الرسمي:' : (($lang === 'fr') ? 'Pour toute question ou pour exercer vos droits, contactez notre équipe par email :' : 'For inquiries or to exercise your rights, please contact our team via email:'); ?> <strong>contact@idmadj.dz</strong></span>
                    </div>
                </div>

                <!-- Section 7 -->
                <div class="legal-block">
                    <h3><span class="block-num">07</span> <?php echo ($lang === 'ar') ? 'تعديل سياسة الخصوصية' : (($lang === 'fr') ? 'Modification de la Politique de Confidentialité' : 'Policy Updates'); ?></h3>
                    <p>
                        <?php echo ($lang === 'ar') ? 
                        'تحتفظ إدارة المنصة بالحق في تحديث أو تعديل سياسة الخصوصية هذه لمواكبة التطورات التشريعية والتنظيمية. يتم نشر أي تعديل فور اعتماده على هذه الصفحة مع تحديث تاريخ المراجعة.' : 
                        (($lang === 'fr') ? 
                        'L’administration de la plateforme se réserve le droit de modifier cette politique afin de se conformer aux évolutions réglementaires. Toute mise à jour sera publiée directement sur cette page.' : 
                        'Platform management reserves the right to update or modify this policy to comply with legislative evolutions. Any updates will be published directly on this page.'); ?>
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
