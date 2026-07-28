<?php
// website/program.php: Event Program and regional seminars page with Multilingual support
require_once 'includes/lang.php';
$page_title = t('brand_title') . " 2026 - " . t('nav_program');
include 'includes/header.php';
?>


<section class="page-banner text-center">
    <div class="container">
        <span class="badge badge-primary"><?php echo t('nav_program'); ?></span>
        <h1><?php echo t('program_title'); ?></h1>
        <p><?php echo t('program_subtitle'); ?></p>
    </div>
</section>

<!-- Timeline and tabs section -->
<section class="section-padding program-section">
    <div class="container">
        
        <!-- Tabs Menu -->
        <div class="program-tabs">
            <button class="tab-btn active" onclick="switchTab(event, 'opening')">
                <span class="tab-date">25 <?php echo ($lang === 'ar') ? 'جوان 2026' : 'Juin / June 2026'; ?></span>
                <span class="tab-title"><?php echo ($lang === 'ar') ? 'الجلسة الافتتاحية' : (($lang === 'fr') ? 'Session d’Ouverture' : 'Opening Session'); ?></span>
            </button>
            <button class="tab-btn" onclick="switchTab(event, 'regional')">
                <span class="tab-date"><?php echo ($lang === 'ar') ? 'جوان - سبتمبر' : 'Juin - Septembre'; ?></span>
                <span class="tab-title"><?php echo ($lang === 'ar') ? 'الندوات الجهوية' : (($lang === 'fr') ? 'Séminaires Régionaux' : 'Regional Seminars'); ?></span>
            </button>
            <button class="tab-btn" onclick="switchTab(event, 'hackathon')">
                <span class="tab-date"><?php echo ($lang === 'ar') ? 'أوت - سبتمبر' : 'Août - Septembre'; ?></span>
                <span class="tab-title"><?php echo ($lang === 'ar') ? 'الهاكاثون الصناعي' : (($lang === 'fr') ? 'Hackathon Industriel' : 'Industrial Hackathon'); ?></span>
            </button>
            <button class="tab-btn" onclick="switchTab(event, 'closing')">
                <span class="tab-date">24 <?php echo ($lang === 'ar') ? 'سبتمبر 2026' : 'Septembre 2026'; ?></span>
                <span class="tab-title"><?php echo ($lang === 'ar') ? 'حفل الاختتام' : (($lang === 'fr') ? 'Cérémonie de Clôture' : 'Closing Ceremony'); ?></span>
            </button>
        </div>

        <!-- Tabs Content -->
        
        <!-- Tab 1: Opening Ceremony -->
        <div class="tab-content active" id="tab-opening">
            <div class="timeline-header">
                <h3><?php echo t('program_day1'); ?></h3>
                <p><?php echo ($lang === 'ar') ? 'تنطلق الفعالية تحت الرعاية الرسمية ببرنامج ثري يجمع صناع القرار والمؤسسات الكبرى.' : (($lang === 'fr') ? 'L’évènement débute sous le haut patronage avec un programme riche réunissant les grands décideurs.' : 'The event launches under official patronage featuring key decision-makers and industrial leaders.'); ?></p>
            </div>
            
            <div class="timeline">
                <div class="timeline-item">
                    <div class="time-stamp">09:00 - 09:30</div>
                    <h4><?php echo ($lang === 'ar') ? 'الاستقبال والتسجيل وحفل الاستقبال' : (($lang === 'fr') ? 'Accueil, Emargement & Café de Bienvenue' : 'Reception, Registration & Welcome Coffee'); ?></h4>
                    <p><?php echo ($lang === 'ar') ? 'استقبال الوفود الوزارية، الشركات الصناعية الكبرى والشركاء الرسميين.' : (($lang === 'fr') ? 'Accueil des délégations ministérielles, grands groupes et partenaires officiels.' : 'Welcoming ministerial delegations, major industrial groups, and official partners.'); ?></p>
                </div>
                
                <div class="timeline-item">
                    <div class="time-stamp">09:30 - 10:00</div>
                    <h4><?php echo ($lang === 'ar') ? 'الافتتاح الرسمي والكلمات الترحيبية' : (($lang === 'fr') ? 'Ouverture Officielle & Discours Inauguraux' : 'Official Opening & Inaugural Speeches'); ?></h4>
                    <ul class="bullet-list">
                        <li><?php echo ($lang === 'ar') ? 'كلمة رئيس المؤسسة الجزائرية لدعم الشباب وتنمية المقاولاتية (AFYE).' : (($lang === 'fr') ? 'Allocution du Président de l’AFYE.' : 'Speech by the President of AFYE.'); ?></li>
                        <li><?php echo ($lang === 'ar') ? 'كلمة وزير الصناعة والإعلان الرسمي عن انطلاق الجلسات الوطنية.' : (($lang === 'fr') ? 'Allocution de M. le Ministre de l’Industrie.' : 'Address by the Minister of Industry.'); ?></li>
                    </ul>
                </div>
                
                <div class="timeline-item">
                    <div class="time-stamp">10:00 - 11:30</div>
                    <h4><?php echo ($lang === 'ar') ? 'الجلسة التفاعلية الأولى: خارطة طريق المناولة الرقمية' : (($lang === 'fr') ? 'Panel 1 : Feuille de Route de la Sous-Traitance Numérique' : 'Panel 1: Digital Subcontracting Roadmap'); ?></h4>
                    <p><?php echo ($lang === 'ar') ? 'نقاش مفتوح حول التشريعات، معايير الجودة الوطنية، تطبيقات الثورة الصناعية الرابعة والأمن السيبراني.' : (($lang === 'fr') ? 'Débat ouvert sur les réglementations, les normes de qualité, l’industrie 4.0 et la cybersécurité.' : 'Panel on regulations, national quality standards, Industry 4.0, and cybersecurity.'); ?></p>
                </div>

                <div class="timeline-item">
                    <div class="time-stamp">11:30 - 12:30</div>
                    <h4><?php echo ($lang === 'ar') ? 'الجلسة التفاعلية الثانية: عرض قصص نجاح صناعية' : (($lang === 'fr') ? 'Panel 2 : Success Stories & Retours d’Expérience' : 'Panel 2: Industrial Success Stories'); ?></h4>
                    <p><?php echo ($lang === 'ar') ? 'عرض تجارب ناجحة لمؤسسات وطنية استطاعت تحقيق معدلات إدماج قياسية وتصدير منتجاتها.' : (($lang === 'fr') ? 'Présentation de parcours d’entreprises ayant atteint des taux d’intégration élevés.' : 'Showcasing successful national companies achieving high local integration rates.'); ?></p>
                </div>

                <div class="timeline-item">
                    <div class="time-stamp">12:30 - 13:30</div>
                    <h4><?php echo ($lang === 'ar') ? 'الإطلاق الرسمي للمنصة والهاكاثون' : (($lang === 'fr') ? 'Lancement Officiel de la Plateforme & du Hackathon' : 'Official Launch of Platform & Hackathon'); ?></h4>
                    <ul class="bullet-list">
                        <li><?php echo ($lang === 'ar') ? 'عرض فرص مناولة كبرى ومباشرة لفائدة المؤسسات الصغيرة والمتوسطة.' : (($lang === 'fr') ? 'Présentation des opportunités de sous-traitance pour les PME.' : 'Presenting major subcontracting opportunities for SMEs.'); ?></li>
                        <li><?php echo ($lang === 'ar') ? 'الإطلاق الرسمي لمنصة WWW.IDMADJ.DZ.' : (($lang === 'fr') ? 'Lancement officiel de la plateforme WWW.IDMADJ.DZ.' : 'Official launch of WWW.IDMADJ.DZ platform.'); ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tab 2: Regional Seminars -->
        <div class="tab-content" id="tab-regional">
            <div class="timeline-header">
                <h3><?php echo ($lang === 'ar') ? 'ندوات الولايات (جوان - سبتمبر 2026)' : (($lang === 'fr') ? 'Séminaires Régionaux dans les Wilayas' : 'Regional Wilaya Seminars'); ?></h3>
                <p><?php echo ($lang === 'ar') ? 'مجموعة من الندوات والورشات الجهوية للتقرب من الفاعلين الاقتصاديين في مختلف جهات الوطن.' : (($lang === 'fr') ? 'Série de séminaires et ateliers régionaux au plus près des acteurs économiques.' : 'Regional workshops and seminars connecting with local economic players.'); ?></p>
            </div>
            
            <div class="grid grid-3" style="margin-top: 2rem;">
                <div class="premium-card seminar-card text-center">
                    <div class="wilaya-badge"><?php echo ($lang === 'ar') ? 'ندوة الجنوب' : 'Sud / South'; ?></div>
                    <h3><?php echo ($lang === 'ar') ? 'ورقلة' : 'Ouargla'; ?></h3>
                    <p class="seminar-meta"><?php echo ($lang === 'ar') ? 'جويلية 2026' : (($lang === 'fr') ? 'Juillet 2026' : 'July 2026'); ?></p>
                    <p class="seminar-desc"><?php echo ($lang === 'ar') ? 'المناولة في قطاع الطاقة، المحروقات والخدمات البترولية.' : (($lang === 'fr') ? 'Sous-traitance dans le secteur de l’énergie et des hydrocarbures.' : 'Subcontracting in energy and oilfield services.'); ?></p>
                </div>
                <div class="premium-card seminar-card text-center">
                    <div class="wilaya-badge"><?php echo ($lang === 'ar') ? 'ندوة الغرب' : 'Ouest / West'; ?></div>
                    <h3><?php echo ($lang === 'ar') ? 'وهران' : 'Oran'; ?></h3>
                    <p class="seminar-meta"><?php echo ($lang === 'ar') ? 'أوت 2026' : (($lang === 'fr') ? 'Août 2026' : 'August 2026'); ?></p>
                    <p class="seminar-desc"><?php echo ($lang === 'ar') ? 'الصناعات الميكانيكية، السيارات والتصنيع الذكي.' : (($lang === 'fr') ? 'Industries mécaniques, automobile et fabrication intelligente.' : 'Mechanical industries, automotive, and smart manufacturing.'); ?></p>
                </div>
                <div class="premium-card seminar-card text-center">
                    <div class="wilaya-badge"><?php echo ($lang === 'ar') ? 'ندوة الشرق' : 'Est / East'; ?></div>
                    <h3><?php echo ($lang === 'ar') ? 'قسنطينة' : 'Constantine'; ?></h3>
                    <p class="seminar-meta"><?php echo ($lang === 'ar') ? 'سبتمبر 2026' : (($lang === 'fr') ? 'Septembre 2026' : 'September 2026'); ?></p>
                    <p class="seminar-desc"><?php echo ($lang === 'ar') ? 'الصناعات الصيدلانية، الدقيقة والأجهزة الطبية.' : (($lang === 'fr') ? 'Industrie pharmaceutique et équipements médicaux.' : 'Pharmaceutical industry and medical equipment.'); ?></p>
                </div>
            </div>
        </div>

        <!-- Tab 3: Hackathon -->
        <div class="tab-content" id="tab-hackathon">
            <div class="timeline-header">
                <h3><?php echo t('hackathon_title'); ?></h3>
                <p><?php echo t('hackathon_subtitle'); ?></p>
            </div>
            
            <div class="grid grid-3" style="margin-top: 2rem;">
                <div class="premium-card text-center">
                    <h4><?php echo t('hackathon_track1'); ?></h4>
                    <p class="seminar-desc"><?php echo ($lang === 'ar') ? 'تطوير منصات ذكية لربط سلاسل التوريد المحلية بالذكاء الاصطناعي.' : (($lang === 'fr') ? 'Développement de plateformes IA pour optimiser la supply chain locale.' : 'AI platforms for optimizing local supply chain logistics.'); ?></p>
                </div>
                <div class="premium-card text-center">
                    <h4><?php echo t('hackathon_track2'); ?></h4>
                    <p class="seminar-desc"><?php echo ($lang === 'ar') ? 'حلول رقمية لتتبع معايير الجودة وشهادات المطابقة.' : (($lang === 'fr') ? 'Solutions digitales pour le suivi des normes de qualité et conformités.' : 'Digital solutions for quality standards and compliance tracking.'); ?></p>
                </div>
                <div class="premium-card text-center">
                    <h4><?php echo t('hackathon_track3'); ?></h4>
                    <p class="seminar-desc"><?php echo ($lang === 'ar') ? 'خوارزميات الصيانة التنبؤية وكفاءة الطاقة للمصانع.' : (($lang === 'fr') ? 'Algorithmes de maintenance prédictive et efficacité énergétique.' : 'Predictive maintenance algorithms and industrial energy efficiency.'); ?></p>
                </div>
            </div>
            <div class="text-center" style="margin-top: 2.5rem;">
                <a href="hackathon.php" class="btn btn-primary"><?php echo t('hackathon_cta'); ?></a>
            </div>
        </div>

        <!-- Tab 4: Closing Ceremony -->
        <div class="tab-content" id="tab-closing">
            <div class="timeline-header">
                <h3><?php echo t('program_day3'); ?></h3>
                <p><?php echo ($lang === 'ar') ? 'الإعلان عن نتائج الهاكاثون، تكريم المشاركين وتكريم الرعاة والشركاء.' : (($lang === 'fr') ? 'Annonce des résultats du Hackathon, remise des prix et bilan général.' : 'Announcing Hackathon winners, awarding prizes, and presenting official recommendations.'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Tab switcher JS -->
<script>
function switchTab(evt, tabName) {
    const tabContents = document.getElementsByClassName("tab-content");
    for (let i = 0; i < tabContents.length; i++) {
        tabContents[i].classList.remove("active");
    }
    const tabBtns = document.getElementsByClassName("tab-btn");
    for (let i = 0; i < tabBtns.length; i++) {
        tabBtns[i].classList.remove("active");
    }
    document.getElementById("tab-" + tabName).classList.add("active");
    evt.currentTarget.classList.add("active");
}
</script>

<!-- CSS Styles for Program Tabs & Timeline -->
<style>
.program-tabs {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 3.5rem;
    flex-wrap: wrap;
}
.tab-btn {
    background-color: var(--bg-card);
    border: 1px solid var(--border-color);
    padding: 1rem 1.8rem;
    border-radius: 0.8rem;
    color: var(--text-light);
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: var(--transition-smooth);
    min-width: 170px;
}
@media (max-width: 576px) {
    .program-tabs {
        gap: 0.5rem;
    }
    .tab-btn {
        flex: 1 1 calc(50% - 0.5rem);
        min-width: 120px;
        padding: 0.75rem 0.5rem;
    }
    .tab-title {
        font-size: 0.85rem;
    }
}
.tab-btn:hover {
    border-color: var(--primary);
    transform: translateY(-3px);
}
.tab-btn.active {
    background-color: var(--primary);
    border-color: var(--primary);
    box-shadow: 0 0 15px rgba(14, 165, 233, 0.4);
}
.tab-date {
    font-size: 0.75rem;
    opacity: 0.8;
    margin-bottom: 0.2rem;
}
.tab-title {
    font-weight: 700;
    font-size: 0.95rem;
}
.tab-content {
    display: none;
}
.tab-content.active {
    display: block;
}
.timeline-header {
    text-align: center;
    margin-bottom: 3rem;
}
.timeline-header h3 {
    font-size: 1.6rem;
    color: var(--text-light);
    margin-bottom: 0.5rem;
}
.timeline-header p {
    color: var(--text-muted);
}
.time-stamp {
    font-weight: 800;
    color: var(--primary);
    font-family: 'Outfit', sans-serif;
    margin-bottom: 0.4rem;
}
.speaker-text {
    font-size: 0.85rem;
    color: var(--accent-gold);
    margin-top: 0.5rem;
}
.wilaya-badge {
    display: inline-block;
    padding: 0.3rem 0.8rem;
    border-radius: 2rem;
    background-color: rgba(14, 165, 233, 0.15);
    color: var(--primary);
    font-size: 0.75rem;
    font-weight: 700;
    margin-bottom: 1rem;
}
.seminar-meta {
    font-size: 0.85rem;
    color: var(--accent-gold);
    margin-top: 0.4rem;
    margin-bottom: 0.8rem;
}
.seminar-desc {
    font-size: 0.88rem;
    color: var(--text-muted);
}
</style>

<?php include 'includes/footer.php'; ?>
