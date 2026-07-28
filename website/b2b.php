<?php
// website/b2b.php: B2B Matchmaking info page with Multilingual support
require_once 'includes/lang.php';
$page_title = t('brand_title') . " 2026 - " . t('nav_b2b');
include 'includes/header.php';
?>


<section class="page-banner text-center">
    <div class="container">
        <span class="badge badge-primary"><?php echo t('nav_b2b'); ?></span>
        <h1><?php echo t('b2b_title'); ?></h1>
        <p><?php echo t('b2b_subtitle'); ?></p>
        <div style="margin-top: 1.5rem;">
            <a href="register.php?type=b2b" class="btn btn-primary"><?php echo t('b2b_cta'); ?></a>
        </div>
    </div>
</section>

<section class="section-padding b2b-intro-section">
    <div class="container">
        <div class="grid grid-2">
            <!-- Text content -->
            <div class="b2b-intro-text">
                <h2><?php echo t('b2b_why_title'); ?></h2>
                <hr class="accent-line">
                <p><?php echo t('pillar1_desc'); ?></p>
                
                <h3 style="margin-top: 2rem;"><?php echo ($lang === 'ar') ? 'مزايا المشاركة في لقاءات B2B:' : (($lang === 'fr') ? 'Avantages de la participation aux B2B :' : 'Benefits of B2B Participation:'); ?></h3>
                <ul class="bullet-list">
                    <li><strong><?php echo ($lang === 'ar') ? 'عقود مباشرة:' : (($lang === 'fr') ? 'Accès Direct :' : 'Direct Access:'); ?></strong> <?php echo t('b2b_step1'); ?></li>
                    <li><strong><?php echo ($lang === 'ar') ? 'فرص تعاقد:' : (($lang === 'fr') ? 'Opportunités :' : 'Supply Opportunities:'); ?></strong> <?php echo t('b2b_step2'); ?></li>
                    <li><strong><?php echo ($lang === 'ar') ? 'شراكات تمويل:' : (($lang === 'fr') ? 'Partenariats :' : 'Long-term Partnerships:'); ?></strong> <?php echo t('b2b_step3'); ?></li>
                </ul>
            </div>

            <!-- Visual Info -->
            <div class="b2b-sectors premium-card">
                <h3><?php echo ($lang === 'ar') ? 'القطاعات الصناعية ذات الأولوية' : (($lang === 'fr') ? 'Secteurs Industriels Prioritaires' : 'Priority Industrial Sectors'); ?></h3>
                <p class="section-sub"><?php echo ($lang === 'ar') ? 'تركز اللقاءات الثنائية بشكل خاص على القطاعات التالية:' : (($lang === 'fr') ? 'Les rencontres B2B ciblent particulièrement les domaines suivants :' : 'B2B sessions focus specifically on the following sectors:'); ?></p>
                
                <div class="sector-list" style="margin-top: 1.5rem;">
                    <div class="sector-item-row">
                        <span class="sector-icon" style="color: var(--primary);">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        </span>
                        <div class="sector-desc">
                            <h4><?php echo ($lang === 'ar') ? 'الميكانيك والحديد والصلب' : (($lang === 'fr') ? 'Mécanique & Métallurgie' : 'Mechanics & Metallurgy'); ?></h4>
                            <p><?php echo ($lang === 'ar') ? 'تصنيع وتوريد هياكل معدنية، قطع غيار الآلات، والمدخلات التعدينية.' : (($lang === 'fr') ? 'Fabrication et fourniture de structures métalliques et pièces de rechange.' : 'Manufacturing and supply of metallic structures and machinery spare parts.'); ?></p>
                        </div>
                    </div>

                    <div class="sector-item-row">
                        <span class="sector-icon" style="color: var(--primary);">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 3h6M10 9h4M10 3v6l-4 8a2 2 0 0 0 2 3h8a2 2 0 0 0 2-3l-4-8V3"></path></svg>
                        </span>
                        <div class="sector-desc">
                            <h4><?php echo ($lang === 'ar') ? 'الصناعات البلاستيكية والكيميائية' : (($lang === 'fr') ? 'Plasturgie & Chimie' : 'Plastics & Chemicals'); ?></h4>
                            <p><?php echo ($lang === 'ar') ? 'المكونات البلاستيكية والمطاطية والمواد الأولية المستعملة في سلاسل الإنتاج.' : (($lang === 'fr') ? 'Composants plastiques, caoutchouc et matières premières industrielles.' : 'Plastic components, rubber, and industrial raw materials.'); ?></p>
                        </div>
                    </div>

                    <div class="sector-item-row">
                        <span class="sector-icon" style="color: var(--primary);">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        </span>
                        <div class="sector-desc">
                            <h4><?php echo ($lang === 'ar') ? 'المكونات الكهربائية والإلكترونية' : (($lang === 'fr') ? 'Électricité & Électronique' : 'Electrical & Electronics'); ?></h4>
                            <p><?php echo ($lang === 'ar') ? 'تجميع الدارات، توريد الكوابل الكهربائية المتخصصة، والأنظمة الإلكترونية.' : (($lang === 'fr') ? 'Assemblage de cartes, câblages spécialisés et systèmes électroniques.' : 'PCB assembly, specialized cabling, and electronic systems.'); ?></p>
                        </div>
                    </div>

                    <div class="sector-item-row">
                        <span class="sector-icon" style="color: var(--primary);">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                        </span>
                        <div class="sector-desc">
                            <h4><?php echo ($lang === 'ar') ? 'تكنولوجيا الرقمنة والتحكم الآلي 4.0' : (($lang === 'fr') ? 'Numérique & Automatisation 4.0' : 'Digital & Automation 4.0'); ?></h4>
                            <p><?php echo ($lang === 'ar') ? 'حلول البرمجيات الصناعية، الربط بإنترنت الأشياء، وحماية البيانات السيبرانية.' : (($lang === 'fr') ? 'Logiciels industriels, IoT et cybersécurité des systèmes de production.' : 'Industrial software, IoT connectivity, and industrial cybersecurity.'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Matchmaking Workflow -->
<section class="section-padding bg-dark-slate">
    <div class="container">
        <div class="section-header text-center">
            <span class="badge badge-gold"><?php echo ($lang === 'ar') ? 'خطوات العملية' : (($lang === 'fr') ? 'Processus' : 'Workflow'); ?></span>
            <h2><?php echo ($lang === 'ar') ? 'سير عمل لقاءات B2B والمطابقة' : (($lang === 'fr') ? 'Déroulement des Rencontres B2B' : 'B2B Matchmaking Process'); ?></h2>
            <p><?php echo ($lang === 'ar') ? 'كيف ننظم ونجدول مواعيد اللقاءات لضمان تحقيق نتائج ملموسة للمؤسسات المشاركة' : (($lang === 'fr') ? 'Comment nous organisons les rendez-vous pour des résultats concrets' : 'How we schedule and facilitate B2B meetings for effective outcomes'); ?></p>
        </div>

        <div class="grid grid-3">
            <div class="premium-card step-card text-center">
                <div class="step-num">1</div>
                <h3><?php echo ($lang === 'ar') ? 'التسجيل وتحديد الحاجيات' : (($lang === 'fr') ? 'Inscription & Expression des Besoins' : 'Registration & Requirements'); ?></h3>
                <p><?php echo ($lang === 'ar') ? 'ملء استمارة B2B وتوضيح نوع القطاع والفرص أو الخدمات المطلوبة.' : (($lang === 'fr') ? 'Remplir le formulaire B2B en précisant les secteurs et besoins.' : 'Fill the B2B form specifying sectors, capabilities, or procurement needs.'); ?></p>
            </div>
            <div class="premium-card step-card text-center">
                <div class="step-num">2</div>
                <h3><?php echo ($lang === 'ar') ? 'جدولة المواعيد مسبقاً' : (($lang === 'fr') ? 'Planification des Rendez-vous' : 'Advance Scheduling'); ?></h3>
                <p><?php echo ($lang === 'ar') ? 'تقوم منصة إدماج بمطابقة الطلبات وتحديد مواعيد اللقاءات الفردية.' : (($lang === 'fr') ? 'La plateforme IDMAJ associe les profils et génère les plannings.' : 'IDMAJ system matches requests and issues personalized meeting agendas.'); ?></p>
            </div>
            <div class="premium-card step-card text-center">
                <div class="step-num">3</div>
                <h3><?php echo ($lang === 'ar') ? 'عقد اللقاءات والمتابعة' : (($lang === 'fr') ? 'Rencontres & Suivi' : 'Meetings & Follow-up'); ?></h3>
                <p><?php echo ($lang === 'ar') ? 'إجراء اللقاءات يوم الفعالية ومتابعة نتائج توقيع اتفاقيات الشراكة.' : (($lang === 'fr') ? 'Tenue des réunions le jour J et accompagnement pour la concrétisation.' : 'Conducting meetings at the event and supporting partnership sign-offs.'); ?></p>
            </div>
        </div>

        <div class="text-center" style="margin-top: 3rem;">
            <a href="register.php?type=b2b" class="btn btn-primary"><?php echo t('b2b_cta'); ?></a>
        </div>
    </div>
</section>

<style>
.b2b-intro-text p {
    font-size: 1rem;
    color: var(--text-light);
    margin-bottom: 1.2rem;
}
.b2b-sectors {
    padding: 2rem;
}
.sector-item-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    align-items: flex-start;
}
.sector-icon {
    font-size: 1.5rem;
    background: rgba(14, 165, 233, 0.1);
    padding: 0.6rem;
    border-radius: 0.6rem;
}
.sector-desc h4 {
    font-size: 1rem;
    color: var(--text-light);
}
.sector-desc p {
    font-size: 0.85rem;
    color: var(--text-muted);
}
.bg-dark-slate {
    background-color: rgba(15, 23, 42, 0.6);
}
.step-num {
    width: 45px;
    height: 45px;
    background: var(--primary);
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1.2rem;
    margin: 0 auto 1.2rem;
}
</style>

<?php include 'includes/footer.php'; ?>
