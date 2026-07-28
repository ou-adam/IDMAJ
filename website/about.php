<?php
// website/about.php: About page with Multilingual support
require_once 'includes/lang.php';
$page_title = t('brand_title') . " 2026 - " . t('nav_about');
include 'includes/header.php';
?>


<section class="page-banner text-center">
    <div class="container">
        <span class="badge badge-primary"><?php echo t('nav_about'); ?></span>
        <h1><?php echo t('about_title'); ?></h1>
        <p><?php echo t('about_subtitle'); ?></p>
    </div>
</section>

<section class="section-padding about-content-section">
    <div class="container">
        <div class="grid grid-2">
            <!-- Text Content -->
            <div class="about-text-wrapper">
                <h2><?php echo t('about_vision_title'); ?></h2>
                <hr class="accent-line">
                <p><?php echo t('about_vision_text'); ?></p>
                
                <h3 style="margin-top: 2rem;"><?php echo t('about_obj_title'); ?></h3>
                <ul class="bullet-list">
                    <li><?php echo t('about_obj_1'); ?></li>
                    <li><?php echo t('about_obj_2'); ?></li>
                    <li><?php echo t('about_obj_3'); ?></li>
                    <li><?php echo t('about_obj_4'); ?></li>
                </ul>
            </div>

            <!-- Side Cards -->
            <div class="about-cards-wrapper">
                <div class="premium-card about-box">
                    <span class="box-number">01</span>
                    <h3><?php echo t('pillar1_title'); ?></h3>
                    <p><?php echo t('pillar1_desc'); ?></p>
                </div>
                <div class="premium-card about-box" style="margin-top: 1.5rem;">
                    <span class="box-number">02</span>
                    <h3><?php echo t('pillar2_title'); ?></h3>
                    <p><?php echo t('pillar2_desc'); ?></p>
                </div>
                <div class="premium-card about-box" style="margin-top: 1.5rem;">
                    <span class="box-number">03</span>
                    <h3><?php echo t('pillar3_title'); ?></h3>
                    <p><?php echo t('pillar3_desc'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Target Categories Section -->
<section class="section-padding bg-slate-gray">
    <div class="container">
        <div class="section-header text-center">
            <h2><?php echo ($lang === 'ar') ? 'الفئات المستهدفة من المنصة' : (($lang === 'fr') ? 'Public Cible & Participants' : 'Target Audience & Participants'); ?></h2>
            <p><?php echo ($lang === 'ar') ? 'تستهدف منصة إدماج جمع وتنسيق جهود الفاعلين الرئيسيين في البيئة الصناعية والاقتصادية' : (($lang === 'fr') ? 'La plateforme IDMAJ rassemble l’ensemble des acteurs clés de l’écosystème industriel' : 'IDMAJ platform brings together key stakeholders across the industrial ecosystem'); ?></p>
        </div>

        <div class="grid grid-4">
            <div class="premium-card target-card text-center">
                <h3><?php echo ($lang === 'ar') ? 'المؤسسات الاقتصادية' : (($lang === 'fr') ? 'Entreprises & Industriels' : 'Industrial Companies'); ?></h3>
                <p class="target-card-desc"><?php echo ($lang === 'ar') ? 'المؤسسات الصناعية الكبرى، المناولون، الشركات الصغيرة والمتوسطة، ومخابر المطابقة والجودة.' : (($lang === 'fr') ? 'Grands groupes industriels, sous-traitants, PME/PMI et laboratoires de conformité.' : 'Major industrial groups, subcontractors, SMEs, and compliance laboratories.'); ?></p>
            </div>
            <div class="premium-card target-card text-center">
                <h3><?php echo ($lang === 'ar') ? 'الشركاء والهيئات' : (($lang === 'fr') ? 'Partenaires Institutional' : 'Institutional Partners'); ?></h3>
                <p class="target-card-desc"><?php echo ($lang === 'ar') ? 'الهيئات الحكومية والرسمية، مؤسسات دعم الاستثمار، البنوك، وصناديق التمويل والضمان.' : (($lang === 'fr') ? 'Organismes publics, agences d’investissement, banques et fonds de garantie.' : 'Government agencies, investment promotion bodies, banks, and guarantee funds.'); ?></p>
            </div>
            <div class="premium-card target-card text-center">
                <h3><?php echo ($lang === 'ar') ? 'الرعاة والممولون' : (($lang === 'fr') ? 'Sponsors & Parrains' : 'Sponsors & Investors'); ?></h3>
                <p class="target-card-desc"><?php echo ($lang === 'ar') ? 'الشركات الراغبة في الظهور الإعلامي والترويجي ودعم مسار الابتكار والجودة الصناعية.' : (($lang === 'fr') ? 'Entreprises souhaitant soutenir l’innovation industrielle et accroître leur visibilité.' : 'Companies seeking visibility and supporting industrial innovation and quality.'); ?></p>
            </div>
            <div class="premium-card target-card text-center">
                <h3><?php echo ($lang === 'ar') ? 'المشاركون الأفراد' : (($lang === 'fr') ? 'Experts & Innovateurs' : 'Experts & Innovators'); ?></h3>
                <p class="target-card-desc"><?php echo ($lang === 'ar') ? 'الخبراء الصناعيون، الأساتذة الباحثون، المبرمجون والمهندسون، والطلبة الجامعيون.' : (($lang === 'fr') ? 'Experts industriels, chercheurs, ingénieurs, développeurs et étudiants.' : 'Industrial experts, researchers, engineers, developers, and university students.'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Past Activities Showcase -->
<section class="section-padding gallery-section">
    <div class="container">
        <div class="section-header text-center">
            <span class="badge badge-gold">AFYE</span>
            <h2><?php echo ($lang === 'ar') ? 'أنشطة وفعاليات سابقة للمؤسسة المنظمة (AFYE)' : (($lang === 'fr') ? 'Activités Précédentes de l’AFYE' : 'Past Activities of AFYE'); ?></h2>
            <p><?php echo ($lang === 'ar') ? 'تغطية مصورة لبعض المحطات الناجحة التي نظمتها المؤسسة لدعم المقاولاتية والتمويل والريادة' : (($lang === 'fr') ? 'Retour en images sur les évènements passés organisés pour promouvoir l’entrepreneuriat' : 'Highlights from previous events organized to promote entrepreneurship and innovation'); ?></p>
        </div>

        <div class="grid grid-3">
            <div class="gallery-card">
                <div class="gallery-img-wrapper">
                    <img src="../Photos/site%20web%20IDMADJ/%D8%B5%D9%88%D8%B1%20%D8%B9%D9%86%20%D8%A3%D9%86%D8%B4%D8%B7%D8%A9%20%D8%B3%D8%A7%D8%A8%D9%82%D8%A9%20%D9%84%D9%84%D9%85%D8%A4%D8%B3%D8%B3%D8%A9/%D8%A7%D9%84%D8%B5%D8%A7%D9%84%D9%88%D9%86%20%D8%A7%D9%84%D9%88%D8%B7%D9%86%D9%8A%20%D8%AA%D9%85%D9%88%D9%8A%D9%84/DSC_3425.jpg" alt="Salon National">
                </div>
                <div class="gallery-info">
                    <h4><?php echo ($lang === 'ar') ? 'الصالون الوطني للتمويل' : (($lang === 'fr') ? 'Salon National du Financement' : 'National Financing Exhibition'); ?></h4>
                    <p><?php echo ($lang === 'ar') ? 'حضور مميز للمؤسسات المالية، البنوك، وهيئات مرافقة ومشاريع الشباب المبتكر.' : (($lang === 'fr') ? 'Presénce d’institutions financières, banques et accompagnateurs de projets.' : 'Participation of financial institutions, banks, and youth venture accelerators.'); ?></p>
                </div>
            </div>

            <div class="gallery-card">
                <div class="gallery-img-wrapper">
                    <img src="../Photos/site%20web%20IDMADJ/%D8%B5%D9%88%D8%B1%20%D8%B9%D9%86%20%D8%A3%D9%86%D8%B4%D8%B7%D8%A9%20%D8%B3%D8%A7%D8%A8%D9%82%D8%A9%20%D9%84%D9%84%D9%85%D8%A4%D8%B3%D8%B3%D8%A9/%D8%A7%D9%84%D8%B5%D8%A7%D9%84%D9%88%D9%86%20%D8%A7%D9%84%D9%88%D8%B7%D9%86%D9%8A%20%D8%AA%D9%85%D9%88%D9%8A%D9%84/DSC_5353.jpg" alt="Debates">
                </div>
                <div class="gallery-info">
                    <h4><?php echo ($lang === 'ar') ? 'جلسات نقاش التمويل والاستثمار' : (($lang === 'fr') ? 'Panels sur le Financement et l’Investissement' : 'Investment & Funding Panels'); ?></h4>
                    <p><?php echo ($lang === 'ar') ? 'خبراء وباحثون يعرضون آليات وسبل تفعيل أدوات الضمان ودعم المشاريع المصغرة.' : (($lang === 'fr') ? 'Experts et chercheurs discutant des mécanismes de garantie et soutien aux micro-projets.' : 'Experts presenting guarantee instruments and support mechanisms for micro-projects.'); ?></p>
                </div>
            </div>

            <div class="gallery-card">
                <div class="gallery-img-wrapper">
                    <img src="../Photos/site%20web%20IDMADJ/%D8%B5%D9%88%D8%B1%20%D8%B9%D9%86%20%D8%A3%D9%86%D8%B4%D8%B7%D8%A9%20%D8%B3%D8%A7%D8%A8%D9%82%D8%A9%20%D9%84%D9%84%D9%85%D8%A4%D8%B3%D8%B3%D8%A9/%D8%A7%D9%84%D9%82%D8%A7%D9%81%D9%84%D8%A9%20%D8%A7%D9%84%D9%86%D8%B3%D9%88%D9%8A%D8%A9%20%D9%84%D8%B1%D9%8A%D8%A7%D8%AF%D8%A9%20%D8%A7%D9%84%D8%A3%D8%B9%D9%85%D8%A7%D9%84%20%D8%A7%D9%84%D9%85%D8%B3%D8%AA%D8%AF%D8%A7%D9%85%D8%A9/DSC_4715.jpg" alt="Caravan">
                </div>
                <div class="gallery-info">
                    <h4><?php echo ($lang === 'ar') ? 'القافلة النسوية للريادة المستدامة' : (($lang === 'fr') ? 'Caravane de l’Entrepreneuriat Féminin' : 'Women’s Sustainable Leadership Caravan'); ?></h4>
                    <p><?php echo ($lang === 'ar') ? 'دعم مهارات وأفكار النساء المقاولات في الولايات ونشر ثقافة الاستثمار الأخضر والمستدام.' : (($lang === 'fr') ? 'Accompagnement des femmes entrepreneures à travers plusieurs wilayas.' : 'Supporting women entrepreneurs across wilayas and fostering green investment.'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Additional Custom Styles for About -->
<style>
.accent-line {
    width: 60px;
    height: 3px;
    background-color: var(--primary);
    border: none;
    margin: 1rem 0 1.5rem;
}
.about-text-wrapper p {
    font-size: 1rem;
    margin-bottom: 1.2rem;
    color: var(--text-light);
}
.about-box {
    padding: 1.5rem;
}
.box-number {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--primary);
    font-family: 'Outfit', sans-serif;
    display: block;
    margin-bottom: 0.5rem;
}
.bg-slate-gray {
    background-color: rgba(30, 41, 59, 0.4);
}
.target-card-desc {
    font-size: 0.88rem;
    color: var(--text-muted);
    margin-top: 0.8rem;
}
.gallery-card {
    background-color: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 0.8rem;
    overflow: hidden;
    transition: var(--transition-smooth);
}
.gallery-card:hover {
    transform: translateY(-5px);
    border-color: var(--primary);
}
.gallery-img-wrapper {
    height: 200px;
    overflow: hidden;
}
.gallery-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition-smooth);
}
.gallery-card:hover .gallery-img-wrapper img {
    transform: scale(1.05);
}
.gallery-info {
    padding: 1.2rem;
}
.gallery-info h4 {
    font-size: 1.05rem;
    margin-bottom: 0.5rem;
    color: var(--text-light);
}
.gallery-info p {
    font-size: 0.85rem;
    color: var(--text-muted);
    line-height: 1.6;
}
</style>

<?php include 'includes/footer.php'; ?>
