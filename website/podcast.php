<?php
// website/podcast.php: Podcast page with Multilingual support
require_once 'includes/lang.php';
$page_title = t('brand_title') . " 2026 - " . t('nav_podcast');
include 'includes/header.php';
require_once 'includes/db.php';

// Fetch podcasts from database
$podcasts = [];
if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT * FROM podcasts ORDER BY id ASC");
        $podcasts = $stmt->fetchAll();
    } catch (\PDOException $e) {
        $podcasts = [];
    }
}

// Fallback sample episodes if database table is empty
if (empty($podcasts)) {
    if ($lang === 'fr') {
        $podcasts = [
            [
                'id' => 1,
                'title' => 'Transformation Numérique & Industrie 4.0 en Algérie',
                'description' => 'Débat sur l’intégration des technologies d’intelligence artificielle et d’IoT dans les usines et entreprises algériennes.',
                'guest' => 'Dr. Ahmed Benali - Expert en IA',
                'sponsor_name' => 'Sponsorisé par : Smart Accel',
                'youtube_url' => '',
                'audio_path' => '#'
            ],
            [
                'id' => 2,
                'title' => 'Sous-Traitance Industrielle & Partenariats B2B',
                'description' => 'Discussion sur l’importance des synergies entre grands donneurs d’ordres et PME/startups locales.',
                'guest' => 'Mme Meriem Brahimi - Consultante Industrielle',
                'sponsor_name' => 'Sponsorisé par : IDMAJ 2026',
                'youtube_url' => '',
                'audio_path' => '#'
            ],
            [
                'id' => 3,
                'title' => 'Financement & Déploiement des Startups et PME',
                'description' => 'Aperçu des mécanismes d’accompagnement et de financement pour les projets innovants.',
                'guest' => 'Sofiane Kadri - Directeur d’Incubateur',
                'sponsor_name' => 'Sponsorisé par : Pitch Box 4.0',
                'youtube_url' => '',
                'audio_path' => '#'
            ]
        ];
    } elseif ($lang === 'en') {
        $podcasts = [
            [
                'id' => 1,
                'title' => 'Digital Transformation & Industry 4.0 in Algeria',
                'description' => 'Discussion on integrating AI and IoT technologies into Algerian factories and industrial enterprises.',
                'guest' => 'Dr. Ahmed Benali - AI Expert',
                'sponsor_name' => 'Sponsored by: Smart Accel',
                'youtube_url' => '',
                'audio_path' => '#'
            ],
            [
                'id' => 2,
                'title' => 'Industrial Subcontracting & Strategic B2B Partnerships',
                'description' => 'Examining synergies between major industrial buyers and local SMEs/startups.',
                'guest' => 'Mrs. Meriem Brahimi - Industrial Consultant',
                'sponsor_name' => 'Sponsored by: IDMAJ 2026',
                'youtube_url' => '',
                'audio_path' => '#'
            ],
            [
                'id' => 3,
                'title' => 'Funding & Growth of Startups and SMEs',
                'description' => 'Overview of support and financing mechanisms available for innovative tech ventures.',
                'guest' => 'Sofiane Kadri - Incubator Director',
                'sponsor_name' => 'Sponsored by: Pitch Box 4.0',
                'youtube_url' => '',
                'audio_path' => '#'
            ]
        ];
    } else {
        $podcasts = [
            [
                'id' => 1,
                'title' => 'التحول الرقمي والصناعة 4.0 في الجزائر',
                'description' => 'حوار حول كيفية إدماج تقنيات الذكاء الاصطناعي وإنترنت الأشياء في المصانع والشركات الجزائرية.',
                'guest' => 'د. أحمد بن علي - خبير في الذكاء الاصطناعي',
                'sponsor_name' => 'برعاية: Smart Accel',
                'youtube_url' => '',
                'audio_path' => '#'
            ],
            [
                'id' => 2,
                'title' => 'المناولة الصناعية والشراكات الاستراتيجية (B2B)',
                'description' => 'مناقشة أهمية الربط بين المؤسسات الكبرى والمؤسسات الناشئة لتعزيز الإنتاج المحلي.',
                'guest' => 'أ. مريم براهيمي - مستشارة تنمية صناعية',
                'sponsor_name' => 'برعاية: IDMAJ 2026',
                'youtube_url' => '',
                'audio_path' => '#'
            ],
            [
                'id' => 3,
                'title' => 'تمويل وتنمية المؤسسات الناشئة والمصغرة',
                'description' => 'استعراض آليات الدعم والتمويل المتاحة للمشاريع المبتكرة في قطاع المناولة والتكنولوجيا.',
                'guest' => 'سفيان قادري - مدير حاضنة أعمال',
                'sponsor_name' => 'برعاية: Pitch Box 4.0',
                'youtube_url' => '',
                'audio_path' => '#'
            ]
        ];
    }
}
?>


<section class="page-banner text-center">
    <div class="container">
        <span class="badge badge-primary"><?php echo t('nav_podcast'); ?></span>
        <h1><?php echo t('podcast_title'); ?></h1>
        <p><?php echo t('podcast_subtitle'); ?></p>
    </div>
</section>


<!-- Podcast Grid Section -->
<section class="section-padding podcast-grid-section">
    <div class="container">
        <div class="grid grid-3">
            <?php foreach ($podcasts as $podcast): 
                $yt_url = $podcast['youtube_url'] ?? '';
                // Check if video is placeholder/empty/Rick Astley or marked unavailable
                $is_coming_soon = empty($yt_url) || $yt_url === '#' || strpos($yt_url, 'dQw4w9WgXcQ') !== false;
            ?>
                <div class="premium-card podcast-card">
                    <!-- Video Embed or Coming Soon Frame -->
                    <div class="podcast-media-wrapper">
                        <?php if ($is_coming_soon): ?>
                            <div class="video-coming-soon-box" onclick="showComingSoonNotice('video')">
                                <div class="cs-glow-bg"></div>
                                <div class="cs-grid-overlay"></div>
                                
                                <div class="cs-top-tag">
                                    <span class="cs-live-pulse"></span>
                                    <span><?php echo ($lang === 'ar') ? 'قريباً' : (($lang === 'fr') ? 'Bientôt disponible' : 'Coming Soon'); ?></span>
                                </div>

                                <div class="cs-center-content">
                                    <div class="cs-play-circle">
                                        <svg class="cs-play-svg" viewBox="0 0 24 24">
                                            <polygon points="6,3 20,12 6,21"></polygon>
                                        </svg>
                                        <div class="cs-lock-icon" title="<?php echo ($lang === 'ar') ? 'قيد الإنتاج' : (($lang === 'fr') ? 'En production' : 'In Production'); ?>">
                                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="cs-status-text"><?php echo ($lang === 'ar') ? 'الحلقة قيد الإنتاج' : (($lang === 'fr') ? 'Épisode en cours de production' : 'Episode in Production'); ?></div>
                                    <div class="cs-sub-text"><?php echo ($lang === 'ar') ? 'سيتم توفير الفيديو فور اكتمال المونتاج' : (($lang === 'fr') ? 'La vidéo sera disponible dès la fin du montage' : 'Video will be available after editing'); ?></div>
                                </div>

                            </div>
                        <?php else: ?>
                            <iframe width="100%" height="200" src="<?php echo htmlspecialchars($podcast['youtube_url']); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        <?php endif; ?>
                    </div>

                    <div class="podcast-body">
                        <span class="podcast-sponsor"><?php echo htmlspecialchars($podcast['sponsor_name']); ?></span>
                        <h3 class="podcast-title"><?php echo htmlspecialchars($podcast['title']); ?></h3>
                        <p class="podcast-guest"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -2px; margin-inline-end: 5px; color: var(--primary);"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> <strong><?php echo ($lang === 'ar') ? 'الضيف:' : (($lang === 'fr') ? 'Invité :' : 'Guest:'); ?></strong> <?php echo htmlspecialchars($podcast['guest']); ?></p>
                        <p class="podcast-desc"><?php echo htmlspecialchars($podcast['description']); ?></p>
                        
                        <div class="podcast-actions">
                            <?php if ($is_coming_soon): ?>
                                <button type="button" class="btn btn-primary btn-sm btn-cs-action" onclick="showComingSoonNotice('video')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 4px; vertical-align: -2px;"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                                    <?php echo ($lang === 'ar') ? 'مشاهدة على YouTube (قريباً)' : (($lang === 'fr') ? 'Regarder sur YouTube (Bientôt)' : 'Watch on YouTube (Soon)'); ?>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm btn-cs-action" onclick="showComingSoonNotice('audio')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 4px; vertical-align: -2px;"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg>
                                    <?php echo ($lang === 'ar') ? 'استماع للنسخة الصوتية' : (($lang === 'fr') ? 'Écouter la version audio' : 'Listen to Audio Version'); ?>
                                </button>
                            <?php else: ?>
                                <a href="<?php echo htmlspecialchars($podcast['youtube_url']); ?>" target="_blank" class="btn btn-primary btn-sm"><?php echo ($lang === 'ar') ? 'مشاهدة على YouTube' : (($lang === 'fr') ? 'Regarder sur YouTube' : 'Watch on YouTube'); ?></a>
                                <a href="<?php echo htmlspecialchars($podcast['audio_path']); ?>" class="btn btn-secondary btn-sm"><?php echo ($lang === 'ar') ? 'استماع للنسخة الصوتية' : (($lang === 'fr') ? 'Écouter la version audio' : 'Listen to Audio Version'); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.podcast-card {
    padding: 0;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.podcast-media-wrapper {
    background-color: #050b14;
    position: relative;
    overflow: hidden;
}
.podcast-body {
    padding: 1.8rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
.podcast-sponsor {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--accent-gold);
    display: block;
    margin-bottom: 0.5rem;
}
.podcast-title {
    font-size: 1.1rem;
    color: var(--text-light);
    margin-bottom: 0.8rem;
    line-height: 1.5;
}
.podcast-guest {
    font-size: 0.85rem;
    color: var(--text-light);
    margin-bottom: 0.8rem;
}
.podcast-desc {
    font-size: 0.8rem;
    color: var(--text-muted);
    line-height: 1.6;
    margin-bottom: 1.5rem;
    flex-grow: 1;
}
.podcast-actions {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
    margin-top: auto;
    width: 100%;
}
.podcast-actions .btn {
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    white-space: normal;
    word-break: break-word;
}
.btn-sm {
    padding: 0.65rem 1rem;
    font-size: 0.85rem;
}
.btn-cs-action {
    opacity: 0.9;
    transition: all 0.25s ease;
}
.btn-cs-action:hover {
    opacity: 1;
    transform: translateY(-1px);
}

/* Coming Soon Box Design */
.video-coming-soon-box {
    height: 200px;
    width: 100%;
    position: relative;
    background: linear-gradient(135deg, #091322 0%, #0f1c30 50%, #060b14 100%);
    border-bottom: 1px solid rgba(0, 242, 254, 0.15);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    cursor: pointer;
    user-select: none;
    transition: all 0.3s ease;
}

.video-coming-soon-box:hover {
    background: linear-gradient(135deg, #0d1b30 0%, #13243d 50%, #080f1d 100%);
}

.video-coming-soon-box:hover .cs-play-circle {
    transform: scale(1.1);
    box-shadow: 0 0 25px rgba(0, 242, 254, 0.6);
    border-color: var(--primary, #00f2fe);
}

.cs-glow-bg {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 150px;
    height: 150px;
    background: radial-gradient(circle, rgba(0, 242, 254, 0.2) 0%, rgba(243, 156, 18, 0.08) 50%, transparent 70%);
    filter: blur(20px);
    pointer-events: none;
    animation: csGlowPulse 4s infinite alternate ease-in-out;
}

.cs-grid-overlay {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px);
    background-size: 16px 16px;
    opacity: 0.6;
    pointer-events: none;
}

.cs-top-tag {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(11, 22, 40, 0.85);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(0, 242, 254, 0.35);
    color: var(--primary, #00f2fe);
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 11px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    z-index: 2;
}

.cs-live-pulse {
    width: 7px;
    height: 7px;
    background-color: var(--accent-gold, #f39c12);
    border-radius: 50%;
    box-shadow: 0 0 8px var(--accent-gold, #f39c12);
    animation: csPulse 1.5s infinite ease-in-out;
}

.cs-center-content {
    position: relative;
    z-index: 2;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 1rem;
}

.cs-play-circle {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: rgba(0, 242, 254, 0.08);
    border: 2px solid rgba(0, 242, 254, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    margin-bottom: 10px;
    position: relative;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 0 15px rgba(0, 242, 254, 0.25);
}

.cs-play-svg {
    width: 20px;
    height: 20px;
    fill: #00f2fe;
    color: #00f2fe;
    filter: drop-shadow(0 0 5px rgba(0, 242, 254, 0.8));
}

.cs-lock-icon {
    position: absolute;
    bottom: -2px;
    right: -2px;
    background: #0f1c30;
    border: 1px solid var(--accent-gold, #f39c12);
    color: var(--accent-gold, #f39c12);
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.5);
}

.cs-status-text {
    font-size: 0.95rem;
    font-weight: 700;
    color: #ffffff;
    letter-spacing: 0.3px;
    margin-bottom: 3px;
    text-shadow: 0 2px 8px rgba(0,0,0,0.6);
}

.cs-sub-text {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.65);
    font-weight: 400;
}

/* Toast Notice Popup */
.cs-toast-popup {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%) translateY(0);
    z-index: 9999;
    background: rgba(11, 22, 40, 0.95);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(0, 242, 254, 0.4);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 15px rgba(0, 242, 254, 0.2);
    border-radius: 12px;
    padding: 14px 20px;
    animation: csToastSlideIn 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    max-width: 90%;
    width: 440px;
}

.cs-toast-popup.hide {
    animation: csToastSlideOut 0.35s ease forwards;
}

.cs-toast-content {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #ffffff;
    font-size: 0.85rem;
    line-height: 1.5;
}

.cs-toast-icon {
    font-size: 1.4rem;
    flex-shrink: 0;
}

.cs-toast-text {
    flex-grow: 1;
}

.cs-toast-close {
    background: none;
    border: none;
    color: rgba(255,255,255,0.6);
    font-size: 1.1rem;
    cursor: pointer;
    padding: 0 4px;
    transition: color 0.2s;
}

.cs-toast-close:hover {
    color: #ffffff;
}

@keyframes csPulse {
    0% { transform: scale(0.95); opacity: 0.7; box-shadow: 0 0 0 0 rgba(243, 156, 18, 0.7); }
    70% { transform: scale(1.15); opacity: 1; box-shadow: 0 0 0 6px rgba(243, 156, 18, 0); }
    100% { transform: scale(0.95); opacity: 0.7; box-shadow: 0 0 0 0 rgba(243, 156, 18, 0); }
}

@keyframes csGlowPulse {
    0% { transform: translate(-50%, -50%) scale(0.8); opacity: 0.4; }
    100% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.8; }
}

@keyframes csToastSlideIn {
    from { opacity: 0; transform: translateX(-50%) translateY(40px); }
    to { opacity: 1; transform: translateX(-50%) translateY(0); }
}

@keyframes csToastSlideOut {
    from { opacity: 1; transform: translateX(-50%) translateY(0); }
    to { opacity: 0; transform: translateX(-50%) translateY(40px); }
}

/* =========================================================
   LIGHT THEME ADAPTATIONS (White Version)
   ========================================================= */
.light-theme .video-coming-soon-box {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 60%, #f8fafc 100%);
    border-bottom: 1px solid rgba(2, 132, 199, 0.2);
}

.light-theme .video-coming-soon-box:hover {
    background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 60%, #f1f5f9 100%);
}

.light-theme .video-coming-soon-box:hover .cs-play-circle {
    box-shadow: 0 0 25px rgba(2, 132, 199, 0.5);
    border-color: #0284c7;
}

.light-theme .cs-glow-bg {
    background: radial-gradient(circle, rgba(2, 132, 199, 0.25) 0%, rgba(217, 119, 6, 0.12) 50%, transparent 70%);
}

.light-theme .cs-grid-overlay {
    background-image: radial-gradient(rgba(15, 23, 42, 0.08) 1px, transparent 1px);
    opacity: 0.7;
}

.light-theme .cs-top-tag {
    background: rgba(255, 255, 255, 0.92);
    border: 1px solid rgba(2, 132, 199, 0.35);
    color: #0284c7;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
}

.light-theme .cs-live-pulse {
    background-color: #d97706;
    box-shadow: 0 0 8px #d97706;
}

.light-theme .cs-play-circle {
    background: rgba(2, 132, 199, 0.12);
    border: 2px solid rgba(2, 132, 199, 0.45);
    box-shadow: 0 0 15px rgba(2, 132, 199, 0.2);
}

.light-theme .cs-play-svg {
    fill: #0284c7;
    color: #0284c7;
    filter: drop-shadow(0 0 4px rgba(2, 132, 199, 0.4));
}

.light-theme .cs-lock-icon {
    background: #ffffff;
    border: 1px solid #d97706;
    color: #d97706;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.15);
}

.light-theme .cs-status-text {
    color: #0f172a;
    text-shadow: none;
}

.light-theme .cs-sub-text {
    color: #475569;
}

.light-theme .cs-toast-popup {
    background: rgba(255, 255, 255, 0.96);
    border: 1px solid rgba(2, 132, 199, 0.35);
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15), 0 0 15px rgba(2, 132, 199, 0.1);
}

.light-theme .cs-toast-content {
    color: #0f172a;
}

.light-theme .cs-toast-close {
    color: #64748b;
}

.light-theme .cs-toast-close:hover {
    color: #0f172a;
}
</style>

<script>
function showComingSoonNotice(type) {
    const existingToast = document.getElementById('cs-toast-notice');
    if (existingToast) existingToast.remove();

    const toast = document.createElement('div');
    toast.id = 'cs-toast-notice';
    toast.className = 'cs-toast-popup';
    
    const message = type === 'audio' 
        ? 'النسخة الصوتية لهذه الحلقة قيد التحضير! ستتوفر فور اكتمال التسجيل.'
        : 'فيديو هذه الحلقة قيد الإنتاج والمونتاج! سيتم رفعه فور الجاهزية.';

    toast.innerHTML = `
        <div class="cs-toast-content">
            <span class="cs-toast-icon">⏳</span>
            <div class="cs-toast-text">${message}</div>
            <button class="cs-toast-close" onclick="this.closest('.cs-toast-popup').remove()">✕</button>
        </div>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        if (toast.parentElement) {
            toast.classList.add('hide');
            setTimeout(() => { if (toast.parentElement) toast.remove(); }, 350);
        }
    }, 4500);
}
</script>

<?php include 'includes/footer.php'; ?>
