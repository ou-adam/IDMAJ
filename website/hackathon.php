<?php
// website/hackathon.php: Hackathon info page with Multilingual support
require_once 'includes/lang.php';
$page_title = t('brand_title') . " 2026 - " . t('nav_hackathon');
include 'includes/header.php';
?>


<section class="page-banner text-center">
    <div class="container">
        <span class="badge badge-primary"><?php echo t('nav_hackathon'); ?></span>
        <h1><?php echo t('hackathon_title'); ?></h1>
        <p><?php echo t('hackathon_subtitle'); ?></p>
        <div style="margin-top: 1.5rem;">
            <a href="register.php?type=hackathon" class="btn btn-primary"><?php echo t('hackathon_cta'); ?></a>
        </div>
    </div>
</section>

<section class="section-padding hack-intro-section">
    <div class="container">
        <div class="grid grid-2">
            <!-- Text Info -->
            <div class="hack-intro-text">
                <h2><?php echo t('hackathon_title'); ?></h2>
                <hr class="accent-line">
                <p><?php echo t('pillar3_desc'); ?></p>
                <p><?php echo t('hackathon_subtitle'); ?></p>

                <h3 style="margin-top: 2rem;"><?php echo t('hackathon_prizes_title'); ?></h3>
                <ul class="bullet-list">
                    <li><?php echo t('hackathon_prize_desc'); ?></li>
                    <li><?php echo ($lang === 'ar') ? 'توجيه ومرافقة فنية من خبراء وموجهين صناعيين طيلة فترة التحدي.' : (($lang === 'fr') ? 'Mentorat et accompagnement par des experts industriels.' : 'Mentorship and technical guidance from industrial leaders.'); ?></li>
                    <li><?php echo ($lang === 'ar') ? 'عرض المشاريع الفائزة أمام الوزراء والمستثمرين في حفل الاختتام.' : (($lang === 'fr') ? 'Présentation des projets devant des investisseurs et officiels.' : 'Showcasing winning projects to ministers, investors, and official partners.'); ?></li>
                </ul>
            </div>

            <!-- Tracks Showcase -->
            <div class="hack-tracks premium-card">
                <h3><?php echo t('hackathon_tracks_title'); ?></h3>
                <p class="section-sub"><?php echo ($lang === 'ar') ? 'يركز الهاكاثون على إيجاد حلول في المجالات الحيوية التالية:' : (($lang === 'fr') ? 'Le hackathon s’articule autour des axes suivants :' : 'The hackathon focuses on developing solutions in the following tracks:'); ?></p>

                <div class="track-list" style="margin-top: 1.5rem;">
                    <div class="track-item-row">
                        <span class="track-icon">1</span>
                        <div class="track-desc">
                            <h4><?php echo t('hackathon_track1'); ?></h4>
                            <p><?php echo ($lang === 'ar') ? 'تطوير برمجيات ومنصات لتسهيل التبادل التجاري وربط سلاسل التوريد وتصنيف المناولين.' : (($lang === 'fr') ? 'Plateformes et logiciels pour fluidifier la supply chain et la sous-traitance.' : 'Software platforms for supply chain integration and subcontractor ranking.'); ?></p>
                        </div>
                    </div>

                    <div class="track-item-row">
                        <span class="track-icon">2</span>
                        <div class="track-desc">
                            <h4><?php echo t('hackathon_track2'); ?></h4>
                            <p><?php echo ($lang === 'ar') ? 'أدوات تكنولوجية ذكية لمراقبة معايير الجودة بشكل فوري وضمان الامتثال للمواصفات القياسية.' : (($lang === 'fr') ? 'Outils digitaux pour le suivi temps réel de la qualité et des normes.' : 'Smart tech tools for real-time quality monitoring and standards compliance.'); ?></p>
                        </div>
                    </div>

                    <div class="track-item-row">
                        <span class="track-icon">3</span>
                        <div class="track-desc">
                            <h4><?php echo t('hackathon_track3'); ?></h4>
                            <p><?php echo ($lang === 'ar') ? 'استخدام إنترنت الأشياء والذكاء الاصطناعي لتوقع الأعطال وجدولة الصيانة الوقائية للمصانع.' : (($lang === 'fr') ? 'IoT et IA pour la maintenance prédictive et la réduction de consommation d’énergie.' : 'IoT and AI for predictive equipment maintenance and energy optimization.'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline and Roadmap of the Challenge -->
<section class="section-padding bg-dark-slate">
    <div class="container">
        <div class="section-header text-center">
            <span class="badge badge-gold"><?php echo ($lang === 'ar') ? 'خارطة التحدي' : (($lang === 'fr') ? 'Calendrier' : 'Roadmap'); ?></span>
            <h2><?php echo ($lang === 'ar') ? 'المراحل الزمنية للهاكاثون' : (($lang === 'fr') ? 'Grandes Étapes du Hackathon' : 'Hackathon Key Phases'); ?></h2>
            <p><?php echo ($lang === 'ar') ? 'كيف سيسير التحدي من التسجيل وحتى التتويج النهائي' : (($lang === 'fr') ? 'Les étapes clefs depuis l’inscription jusqu’à la finale' : 'Key milestones from registration to final pitch'); ?></p>
        </div>

        <div class="grid grid-3 text-center">
            <div class="premium-card step-card">
                <span class="step-num">Phase 1</span>
                <h4><?php echo ($lang === 'ar') ? 'التسجيل الأولي وتصفية الأفكار' : (($lang === 'fr') ? 'Inscriptions & Pré-sélection' : 'Registration & Pre-selection'); ?></h4>
                <p><?php echo ($lang === 'ar') ? 'تقديم وصف أولي للفكرة وأعضاء الفريق اختيار الأفكار الواعدة.' : (($lang === 'fr') ? 'Soumission des dossiers d’équipe et sélection des meilleures idées.' : 'Idea submission, team registration, and evaluation of initial prototypes.'); ?></p>
            </div>
            <div class="premium-card step-card">
                <span class="step-num">Phase 2</span>
                <h4><?php echo ($lang === 'ar') ? 'مرحلة التطوير والمنتورينغ' : (($lang === 'fr') ? 'Développement & Mentoring' : 'Development & Mentorship'); ?></h4>
                <p><?php echo ($lang === 'ar') ? 'تأطير ومرافقة مكثفة من طرف الخبراء لتطوير النموذج الأولي.' : (($lang === 'fr') ? 'Session de coaching intensif avec les mentors industriels.' : 'Intensive development sprint guided by industrial mentors.'); ?></p>
            </div>
            <div class="premium-card step-card">
                <span class="step-num">Phase 3</span>
                <h4><?php echo ($lang === 'ar') ? 'التصفيات النهائية والتتويج' : (($lang === 'fr') ? 'Finale & Remise des Prix' : 'Final Pitch & Awards'); ?></h4>
                <p><?php echo ($lang === 'ar') ? 'عرض الحلول أمام لجنة التحكيم في حفل اختتام الجلسات.' : (($lang === 'fr') ? 'Présentation des prototypes devant le jury lors du grand final.' : 'Final presentation to jury and awarding prizes at closing ceremony.'); ?></p>
            </div>
        </div>

        <div class="text-center" style="margin-top: 3rem;">
            <a href="register.php?type=hackathon" class="btn btn-primary"><?php echo t('hackathon_cta'); ?></a>
        </div>
    </div>
</section>

<style>
.hack-intro-text p {
    font-size: 1rem;
    color: var(--text-light);
    margin-bottom: 1.2rem;
}
.hack-tracks {
    padding: 2rem;
}
.track-item-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    align-items: flex-start;
}
.track-icon {
    width: 36px;
    height: 36px;
    background: var(--primary);
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    flex-shrink: 0;
}
.track-desc h4 {
    font-size: 1rem;
    color: var(--text-light);
}
.track-desc p {
    font-size: 0.85rem;
    color: var(--text-muted);
}
</style>

<?php include 'includes/footer.php'; ?>
