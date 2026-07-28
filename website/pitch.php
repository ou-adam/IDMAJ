<?php
// website/pitch.php: 1-Minute Pitch Box info page with Multilingual support
require_once 'includes/lang.php';
$page_title = t('brand_title') . " 2026 - " . t('nav_pitch');
include 'includes/header.php';
?>


<section class="page-banner text-center">
    <div class="container">
        <span class="badge badge-primary"><?php echo t('nav_pitch'); ?></span>
        <h1><?php echo t('pitch_title'); ?></h1>
        <p><?php echo t('pitch_subtitle'); ?></p>
        <div style="margin-top: 1.5rem;">
            <a href="register.php?type=pitch" class="btn btn-primary"><?php echo t('pitch_cta'); ?></a>
        </div>
    </div>
</section>

<section class="section-padding pitch-intro-section">
    <div class="container">
        <div class="grid grid-2">
            <!-- Text Content -->
            <div class="pitch-intro-text">
                <h2><?php echo t('pitch_title'); ?></h2>
                <hr class="accent-line">
                <p><?php echo t('pillar4_desc'); ?></p>
                <p><?php echo t('pitch_subtitle'); ?></p>
                
                <h3 style="margin-top: 2rem;"><?php echo t('pitch_rules_title'); ?></h3>
                <ul class="bullet-list">
                    <li><?php echo t('pitch_rule1'); ?></li>
                    <li><?php echo t('pitch_rule2'); ?></li>
                    <li><?php echo t('pitch_rule3'); ?></li>
                </ul>
            </div>

            <!-- Pitching Tips -->
            <div class="pitch-tips-box premium-card">
                <h3><?php echo ($lang === 'ar') ? 'نصائح ذهبية لإعداد عرض (Pitch) ناجح' : (($lang === 'fr') ? 'Conseils pour un Pitch Réussi (60s)' : 'Tips for a Successful 60-Second Pitch'); ?></h3>
                <p class="section-sub"><?php echo ($lang === 'ar') ? 'كيف تبني عرضاً مقنعاً في 60 ثانية فقط:' : (($lang === 'fr') ? 'Comment structurer votre présentation en 1 minute :' : 'How to structure your pitch in just 60 seconds:'); ?></p>

                <div class="tips-list" style="margin-top: 1.5rem;">
                    <div class="tip-item">
                        <span class="tip-number">1</span>
                        <div>
                            <h4><?php echo ($lang === 'ar') ? 'المشكلة (The Problem - 15s)' : (($lang === 'fr') ? 'Le Problème (15s)' : 'The Problem (15s)'); ?></h4>
                            <p><?php echo ($lang === 'ar') ? 'حدد المشكلة الصناعية أو الفجوة الميدانية التي يحلها مشروعكم.' : (($lang === 'fr') ? 'Définissez le problème industriel auquel votre projet répond.' : 'Define the industrial problem your project solves.'); ?></p>
                        </div>
                    </div>

                    <div class="tip-item">
                        <span class="tip-number">2</span>
                        <div>
                            <h4><?php echo ($lang === 'ar') ? 'الحل التقني (The Solution - 20s)' : (($lang === 'fr') ? 'La Solution (20s)' : 'The Solution (20s)'); ?></h4>
                            <p><?php echo ($lang === 'ar') ? 'اشرح كيف يعمل منتجكم أو خدمتكم وما هي التكنولوجيا المستخدمة.' : (($lang === 'fr') ? 'Présentez la technologie et l’innovation derrière votre solution.' : 'Explain how your tech innovation works and its core advantage.'); ?></p>
                        </div>
                    </div>

                    <div class="tip-item">
                        <span class="tip-number">3</span>
                        <div>
                            <h4><?php echo ($lang === 'ar') ? 'الاحتياج المحدد (Call to Action - 15s)' : (($lang === 'fr') ? 'Besoin & Appel à l’Action (15s)' : 'Call to Action (15s)'); ?></h4>
                            <p><?php echo ($lang === 'ar') ? 'أنهِ العرض بطلب محدد: تمويل؟ شريك صناعي؟ أو عقود مناولة؟' : (($lang === 'fr') ? 'Précisez votre besoin : Financement, Partenariat ou Marché ?' : 'Conclude with a clear request: Funding, Industrial Partner, or Contracts.'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Phases Grid -->
<section class="section-padding bg-dark-slate">
    <div class="container">
        <div class="section-header text-center">
            <span class="badge badge-gold"><?php echo ($lang === 'ar') ? 'الخطوات التفصيلية' : (($lang === 'fr') ? 'Procédure' : 'Selection Process'); ?></span>
            <h2><?php echo ($lang === 'ar') ? 'خطوات تقديم وتقييم المشاريع' : (($lang === 'fr') ? 'Étapes de Sélection & Évaluation' : 'Submission & Evaluation Steps'); ?></h2>
            <p><?php echo ($lang === 'ar') ? 'كيف تتم فلترة واختيار المشاريع المشاركة وتأهيلها لحفل الاختتام' : (($lang === 'fr') ? 'De la soumission du projet jusqu’à la présentation finale devant le jury' : 'From pitch submission to presentation in front of investors'); ?></p>
        </div>

        <div class="grid grid-3 text-center">
            <div class="premium-card step-card">
                <span class="step-num">Step 1</span>
                <h4><?php echo ($lang === 'ar') ? 'تقديم الملف والفيديو' : (($lang === 'fr') ? 'Soumission du Dossier' : 'File & Video Submission'); ?></h4>
                <p><?php echo ($lang === 'ar') ? 'تعبئة البيانات، كتابة ملخص الفكرة ورفع رابط فيديو العرض (60 ثانية).' : (($lang === 'fr') ? 'Remplir le formulaire, joindre la présentation PDF et la vidéo 60s.' : 'Fill the form, attach pitch presentation slides, and submit a 60-sec video.'); ?></p>
            </div>

            <div class="premium-card step-card">
                <span class="step-num">Step 2</span>
                <h4><?php echo ($lang === 'ar') ? 'تصفية لجنة التقييم' : (($lang === 'fr') ? 'Évaluation du Jury' : 'Jury Evaluation'); ?></h4>
                <p><?php echo ($lang === 'ar') ? 'اختيار أفضل 10 عروض وتوجيه أصحابها للمرحلة النهائية.' : (($lang === 'fr') ? 'Sélection des 10 meilleurs projets pour la finale.' : 'Shortlisting the top projects for the final round.'); ?></p>
            </div>

            <div class="premium-card step-card">
                <span class="step-num">Step 3</span>
                <h4><?php echo ($lang === 'ar') ? 'العرض الختامي والتتويج' : (($lang === 'fr') ? 'Grand Pitch Final' : 'Final Pitch Event'); ?></h4>
                <p><?php echo ($lang === 'ar') ? 'تقديم العرض المباشر أمام المستثمرين وكبار المصنعين يوم الاختتام.' : (($lang === 'fr') ? 'Pitch en direct devant les investisseurs et officiels lors de la clôture.' : 'Live pitch in front of investors and industrial executives at closing event.'); ?></p>
            </div>
        </div>

        <div class="text-center" style="margin-top: 3rem;">
            <a href="register.php?type=pitch" class="btn btn-primary"><?php echo t('pitch_cta'); ?></a>
        </div>
    </div>
</section>

<style>
.pitch-intro-text p {
    font-size: 1rem;
    color: var(--text-light);
    margin-bottom: 1.2rem;
}
.pitch-tips-box {
    padding: 2rem;
}
.tip-item {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    align-items: flex-start;
}
.tip-number {
    width: 36px;
    height: 36px;
    background: var(--accent-gold);
    color: #000;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    flex-shrink: 0;
}
.tip-item h4 {
    font-size: 1rem;
    color: var(--text-light);
}
.tip-item p {
    font-size: 0.85rem;
    color: var(--text-muted);
}
</style>

<?php include 'includes/footer.php'; ?>
