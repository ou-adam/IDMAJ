<?php
// website/index.php: Homepage of the IDMADJ platform with Multilingual support
require_once 'includes/lang.php';
$page_title = t('brand_title') . " 2026 - " . t('nav_home');
include 'includes/header.php';
?>


<!-- 1. Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <!-- 3D Animated Logo Hologram -->
        <div class="hero-logo-3d-container" id="js-logo-3d-hologram">
            <div class="hologram-projector"></div>
            <div class="hologram-ring-outer"></div>
            <div class="hologram-ring-inner"></div>
            <div class="hologram-glow"></div>
            <div class="hologram-logo-wrapper">
                <img src="../Photos/site%20web%20IDMADJ/LOGGO.svg" alt="IDMADJ Logo" class="hologram-logo-img">
            </div>
            <canvas id="logo-3d-particles"></canvas>
        </div>

        <div class="hero-badge-wrapper">
            <span class="badge badge-primary"><?php echo t('hero_badge'); ?></span>
        </div>
        <h1 class="hero-title"><?php echo t('hero_title'); ?></h1>
        <p class="hero-subtitle"><?php echo t('hero_subtitle'); ?></p>
        
        <div class="hero-meta">
            <div class="meta-item">
                <span class="meta-icon" style="color: var(--primary); display: inline-flex; align-items: center;">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </span>
                <span><?php echo t('hero_event_date'); ?></span>
            </div>
        </div>

        <div class="hero-actions">
            <a href="register.php" class="btn btn-primary"><?php echo t('hero_cta_register'); ?></a>
            <a href="b2b.php" class="btn btn-secondary"><?php echo t('hero_cta_b2b'); ?></a>
        </div>

        <!-- Countdown Timer Card -->
        <div class="hero-countdown premium-card">
            <h3 class="countdown-title"><?php echo ($lang === 'ar') ? 'الوقت المتبقي لافتتاح الحدث' : (($lang === 'fr') ? 'Temps restant avant l’ouverture' : 'Time Remaining Until Opening'); ?></h3>
            <div class="countdown-grid">
                <div class="countdown-item">
                    <span class="countdown-number" id="countdown-days">00</span>
                    <span class="countdown-label"><?php echo t('count_days'); ?></span>
                </div>
                <div class="countdown-divider">:</div>
                <div class="countdown-item">
                    <span class="countdown-number" id="countdown-hours">00</span>
                    <span class="countdown-label"><?php echo t('count_hours'); ?></span>
                </div>
                <div class="countdown-divider">:</div>
                <div class="countdown-item">
                    <span class="countdown-number" id="countdown-minutes">00</span>
                    <span class="countdown-label"><?php echo t('count_minutes'); ?></span>
                </div>
                <div class="countdown-divider">:</div>
                <div class="countdown-item">
                    <span class="countdown-number" id="countdown-seconds">00</span>
                    <span class="countdown-label"><?php echo t('count_seconds'); ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. Statistics Grid (KPIs) -->
<section class="section-padding stats-section">
    <div class="container">
        <div class="section-header text-center">
            <span class="badge badge-gold"><?php echo t('home_stats_title'); ?></span>
            <h2><?php echo ($lang === 'ar') ? 'قوة الحدث بالأرقام' : (($lang === 'fr') ? 'La Force de l’Événement en Chiffres' : 'The Impact of the Event in Numbers'); ?></h2>
            <p><?php echo ($lang === 'ar') ? 'أبعاد وتأثير الجلسات الوطنية إدماج 2026 في الساحة الاقتصادية' : (($lang === 'fr') ? 'Impact et portée des Assises Nationales IDMAJ 2026 sur l’écosystème économique' : 'Scope and impact of the National IDMAJ 2026 Sessions on the economy'); ?></p>
        </div>

        <div class="grid grid-4 text-center">
            <div class="premium-card stat-card">
                <span class="stat-number cyan-text">+1000</span>
                <span class="stat-label"><?php echo t('stat_participants'); ?></span>
            </div>
            <div class="premium-card stat-card">
                <span class="stat-number gold-text">+500</span>
                <span class="stat-label"><?php echo t('stat_b2b'); ?></span>
            </div>
            <div class="premium-card stat-card">
                <span class="stat-number cyan-text">+50</span>
                <span class="stat-label"><?php echo t('stat_hackathon'); ?></span>
            </div>
            <div class="premium-card stat-card">
                <span class="stat-number gold-text">58</span>
                <span class="stat-label"><?php echo t('stat_wilayas'); ?></span>
            </div>
        </div>
    </div>
</section>

<!-- 3. Pillars / Objectives -->
<section class="section-padding pillars-section">
    <div class="container">
        <div class="section-header text-center">
            <h2><?php echo t('home_pillars_title'); ?></h2>
            <p><?php echo ($lang === 'ar') ? 'تركز الجلسات على أركان جوهرية لدعم النسيج الاقتصادي الجزائري' : (($lang === 'fr') ? 'Les Assises se concentrent sur des axes stratégiques pour renforcer l’industrie algérienne' : 'The sessions focus on key strategic pillars to empower the Algerian industrial fabric'); ?></p>
        </div>

        <div class="grid grid-4">
            <div class="premium-card pillar-card text-center">
                <div class="pillar-icon" style="color: var(--primary);">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                </div>
                <h3><?php echo t('pillar1_title'); ?></h3>
                <p><?php echo t('pillar1_desc'); ?></p>
            </div>
            <div class="premium-card pillar-card text-center">
                <div class="pillar-icon" style="color: var(--accent-gold);">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                </div>
                <h3><?php echo t('pillar2_title'); ?></h3>
                <p><?php echo t('pillar2_desc'); ?></p>
            </div>
            <div class="premium-card pillar-card text-center">
                <div class="pillar-icon" style="color: var(--secondary);">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                </div>
                <h3><?php echo t('pillar3_title'); ?></h3>
                <p><?php echo t('pillar3_desc'); ?></p>
            </div>
            <div class="premium-card pillar-card text-center">
                <div class="pillar-icon" style="color: var(--success);">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
                </div>
                <h3><?php echo t('pillar4_title'); ?></h3>
                <p><?php echo t('pillar4_desc'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- 4. Logos Strip (Sponsors & Partners) -->
<section class="section-padding logos-section">
    <div class="container">
        <div class="section-header text-center">
            <h2><?php echo t('sponsors_title'); ?></h2>
            <p><?php echo t('sponsors_subtitle'); ?></p>
        </div>

        <!-- Official Partners -->
        <h3 class="logos-group-title text-center"><?php echo t('sponsors_partners'); ?></h3>
        <div class="logos-strip">
            <div class="logo-item" title="ADPMEPI">
                <img src="../Photos/site%20web%20IDMADJ/les%20partenaires/ADPMEPI.png" alt="ADPMEPI Logo">
            </div>
            <div class="logo-item" title="ALGERAC">
                <img src="../Photos/site%20web%20IDMADJ/les%20partenaires/ALGERAC.png" alt="ALGERAC Logo">
            </div>
            <div class="logo-item" title="ANVREDET">
                <img src="../Photos/site%20web%20IDMADJ/les%20partenaires/ANVREDET.png" alt="ANVREDET Logo">
            </div>
            <div class="logo-item" title="BASTP">
                <img src="../Photos/site%20web%20IDMADJ/les%20partenaires/BASTP.png" alt="BASTP Logo">
            </div>
            <div class="logo-item" title="FGAR">
                <img src="../Photos/site%20web%20IDMADJ/les%20partenaires/FGAR.png" alt="FGAR Logo">
            </div>
            <div class="logo-item" title="INAPI">
                <img src="../Photos/site%20web%20IDMADJ/les%20partenaires/INAPI.png" alt="INAPI Logo">
            </div>
        </div>

        <!-- Sponsors -->
        <h3 class="logos-group-title text-center" style="margin-top: 3rem;"><?php echo t('sponsors_official'); ?></h3>
        <div class="logos-strip sponsors-strip">
            <div class="logo-item" title="MAATEC Assurance">
                <img src="../Photos/site%20web%20IDMADJ/les%20sponsor/golds/MAATEC%20Assurance.png" alt="MAATEC Assurance">
            </div>
            <div class="logo-item" title="Bank Salam">
                <img src="../Photos/site%20web%20IDMADJ/les%20sponsor/silvers/bank%20salam.png" alt="Bank Salam">
            </div>
            <div class="logo-item" title="BitBit">
                <img src="../Photos/site%20web%20IDMADJ/les%20sponsor/silvers/BitBit.png" alt="Bit Bait">
            </div>
            <div class="logo-item" title="CS&PA Company">
                <img src="../Photos/site%20web%20IDMADJ/les%20sponsor/silvers/cspa.png" alt="CS&PA Company">
            </div>
            <div class="logo-item" title="El Djazair Istithmar">
                <img src="../Photos/site%20web%20IDMADJ/les%20sponsor/silvers/el%20djazair%20istithmar.png" alt="El Djazair Istithmar">
            </div>
            <div class="logo-item" title="Ferdi Lilly">
                <img src="../Photos/site%20web%20IDMADJ/les%20sponsor/silvers/Ferdi_Lilly-removebg-preview.png" alt="Ferdi Lilly">
            </div>
            <div class="logo-item" title="SAA">
                <img src="../Photos/site%20web%20IDMADJ/les%20sponsor/silvers/saa.png" alt="SAA">
            </div>
        </div>
    </div>
</section>

<!-- Additional Custom Styles for Home -->
<style>
.hero-section {
    padding: 8rem 0 5rem;
    background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.1), transparent 500px),
                radial-gradient(circle at bottom left, rgba(14, 165, 233, 0.1), transparent 500px);
}
.hero-badge-wrapper {
    margin-bottom: 1.5rem;
}
.hero-title {
    font-size: 3.2rem;
    line-height: 1.3;
    margin-bottom: 1.5rem;
}
.hero-subtitle {
    font-size: 1.15rem;
    color: var(--text-muted);
    max-width: 800px;
    margin: 0 auto 2.5rem;
}
.hero-meta {
    display: flex;
    justify-content: center;
    gap: 3rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
    font-size: 0.95rem;
}
.meta-item {
    display: flex;
    align-items: center;
    gap: 0.6rem;
}
.meta-icon {
    font-size: 1.3rem;
}
.hero-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 5rem;
    flex-wrap: wrap;
}
.hero-countdown {
    max-width: 600px;
    margin: 0 auto;
}
.countdown-title {
    font-size: 1rem;
    color: var(--text-muted);
    text-transform: uppercase;
    margin-bottom: 1.5rem;
}
.countdown-grid {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
}
.countdown-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 70px;
}
.countdown-number {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--primary);
    font-family: 'Outfit', sans-serif;
}
.countdown-label {
    font-size: 0.75rem;
    color: var(--text-muted);
}
.countdown-divider {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--border-color);
    padding-bottom: 25px;
}
.stat-number {
    display: block;
    font-size: 2.6rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    font-family: 'Outfit', sans-serif;
}
.stat-label {
    color: var(--text-muted);
    font-size: 0.9rem;
    font-weight: 600;
}
.pillar-icon {
    font-size: 3rem;
    margin-bottom: 1.5rem;
    display: inline-block;
}
.pillar-card h3 {
    font-size: 1.25rem;
    margin-bottom: 1rem;
}
.logos-group-title {
    font-size: 1rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 2rem;
}
.logos-strip {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 2.5rem;
}
.logo-item {
    background-color: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.12);
    padding: 1rem;
    border-radius: 0.8rem;
    width: 110px;
    height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition-smooth);
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.03);
}
.logo-item:hover {
    border-color: var(--primary);
    transform: translateY(-4px);
    background-color: rgba(255, 255, 255, 0.08);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.1);
}
.logo-item img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.45));
    transition: filter 0.3s ease, transform 0.3s ease;
}
.logo-item:hover img {
    filter: drop-shadow(0 0 14px rgba(255, 255, 255, 0.8));
}

@media (max-width: 768px) {
    .hero-section { padding: 5rem 0 3rem; }
    .hero-title { font-size: 2.2rem; }
    .hero-meta { flex-direction: column; gap: 0.8rem; }
    .countdown-grid { gap: 0.4rem; }
    .countdown-item { min-width: 45px; }
    .countdown-number { font-size: 1.5rem; }
    .countdown-divider { font-size: 1.5rem; padding-bottom: 15px; }
    .logo-item { width: 85px; height: 85px; padding: 0.6rem; }
}

@media (max-width: 480px) {
    .hero-title { font-size: 1.7rem; }
    .hero-subtitle { font-size: 0.95rem; }
    .hero-logo-3d-container { width: 180px; height: 180px; }
    .hologram-ring-outer { width: 170px; height: 170px; }
    .hologram-ring-inner { width: 140px; height: 140px; }
    .hologram-logo-wrapper { width: 90px; height: 90px; }
    .hero-actions { flex-direction: column; width: 100%; }
    .hero-actions .btn { width: 100%; }
    .countdown-number { font-size: 1.3rem; }
    .countdown-label { font-size: 0.68rem; }
    .countdown-divider { font-size: 1.2rem; padding-bottom: 10px; }
    .countdown-item { min-width: 38px; }
}

/* 3D Hologram Logo Styles */
.hero-logo-3d-container {
    position: relative;
    width: 240px;
    height: 240px;
    margin: 0 auto 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
    perspective: 1000px;
    cursor: pointer;
}
.hologram-projector {
    position: absolute;
    bottom: 5px;
    width: 140px;
    height: 10px;
    background: radial-gradient(ellipse, rgba(14, 165, 233, 0.4) 0%, transparent 70%);
    border-radius: 50%;
    filter: blur(2px);
}
.hologram-ring-outer {
    position: absolute;
    width: 220px;
    height: 220px;
    border: 2px dashed rgba(14, 165, 233, 0.25);
    border-radius: 50%;
    animation: rotateRingClockwise 20s linear infinite;
    box-shadow: 0 0 15px rgba(14, 165, 233, 0.05), inset 0 0 15px rgba(14, 165, 233, 0.05);
}
.hologram-ring-inner {
    position: absolute;
    width: 180px;
    height: 180px;
    border: 1px dashed rgba(99, 102, 241, 0.2);
    border-radius: 50%;
    animation: rotateRingCounter 12s linear infinite;
}
.hologram-glow {
    position: absolute;
    width: 120px;
    height: 120px;
    background: radial-gradient(circle, rgba(14, 165, 233, 0.18) 0%, transparent 70%);
    border-radius: 50%;
    filter: blur(8px);
    animation: hologramPulse 4s infinite ease-in-out;
}
.hologram-logo-wrapper {
    position: relative;
    z-index: 10;
    width: 115px;
    height: 115px;
    animation: floatLogoHologram 5s infinite ease-in-out;
    filter: drop-shadow(0 0 20px rgba(14, 165, 233, 0.35));
    transition: transform 0.2s ease-out;
    transform-style: preserve-3d;
}
.hologram-logo-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
#logo-3d-particles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 6;
}
@keyframes rotateRingClockwise { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
@keyframes rotateRingCounter { from { transform: rotate(360deg); } to { transform: rotate(0deg); } }
@keyframes hologramPulse { 0%, 100% { opacity: 0.4; transform: scale(0.9); } 50% { opacity: 0.8; transform: scale(1.1); } }
@keyframes floatLogoHologram { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-8px) rotate(2deg); } }
</style>

<!-- Load Three.js for Hero 3D Particle Constellations -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('js-logo-3d-hologram');
    const canvas = document.getElementById('logo-3d-particles');
    if (!container || !canvas) return;

    const width = container.clientWidth;
    const height = container.clientHeight;
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 100);
    camera.position.z = 18;

    const renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true, antialias: true });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    const particleCount = 120;
    const geo = new THREE.BufferGeometry();
    const positions = new Float32Array(particleCount * 3);
    const colors = new Float32Array(particleCount * 3);
    const colorCyan = new THREE.Color(0x0ea5e9);
    const colorIndigo = new THREE.Color(0x6366f1);
    const pData = [];

    for (let i = 0; i < particleCount; i++) {
        const angle = Math.random() * Math.PI * 2;
        const radius = 4.5 + Math.random() * 2.5;
        const speed = (0.2 + Math.random() * 0.4) * (Math.random() > 0.5 ? 1 : -1);
        const yOffset = (Math.random() - 0.5) * 3;
        pData.push({ angle, radius, speed, yOffset });

        positions[i * 3] = Math.cos(angle) * radius;
        positions[i * 3 + 1] = yOffset;
        positions[i * 3 + 2] = Math.sin(angle) * radius;

        const isIndigo = Math.random() > 0.6;
        const pointColor = isIndigo ? colorIndigo : colorCyan;
        colors[i * 3] = pointColor.r;
        colors[i * 3 + 1] = pointColor.g;
        colors[i * 3 + 2] = pointColor.b;
    }

    geo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    geo.setAttribute('color', new THREE.BufferAttribute(colors, 3));

    const createRoundTexture = () => {
        const pCanvas = document.createElement('canvas');
        pCanvas.width = 16;
        pCanvas.height = 16;
        const ctx = pCanvas.getContext('2d');
        const grad = ctx.createRadialGradient(8, 8, 0, 8, 8, 8);
        grad.addColorStop(0, 'rgba(255, 255, 255, 1)');
        grad.addColorStop(0.3, 'rgba(14, 165, 233, 0.8)');
        grad.addColorStop(1, 'rgba(14, 165, 233, 0)');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, 16, 16);
        return new THREE.CanvasTexture(pCanvas);
    };

    const mat = new THREE.PointsMaterial({
        size: 0.35,
        map: createRoundTexture(),
        transparent: true,
        vertexColors: true,
        blending: THREE.AdditiveBlending,
        depthWrite: false
    });

    const particles = new THREE.Points(geo, mat);
    scene.add(particles);

    let targetRotationX = 0, targetRotationY = 0;
    let currentRotationX = 0, currentRotationY = 0;
    const logoWrapper = container.querySelector('.hologram-logo-wrapper');

    container.addEventListener('mousemove', (e) => {
        const rect = container.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        targetRotationY = (x / (rect.width / 2)) * 25;
        targetRotationX = -(y / (rect.height / 2)) * 25;
        particles.rotation.y = (x / rect.width) * 2;
        particles.rotation.x = (y / rect.height) * 2;
    });

    container.addEventListener('mouseleave', () => {
        targetRotationX = 0;
        targetRotationY = 0;
    });

    const clock = new THREE.Clock();
    const draw = () => {
        requestAnimationFrame(draw);
        const delta = clock.getDelta();
        const posAttr = geo.attributes.position;
        for (let i = 0; i < particleCount; i++) {
            const data = pData[i];
            data.angle += data.speed * delta;
            posAttr.setX(i, Math.cos(data.angle) * data.radius);
            posAttr.setZ(i, Math.sin(data.angle) * data.radius);
        }
        posAttr.needsUpdate = true;

        if (targetRotationX === 0 && targetRotationY === 0) {
            particles.rotation.y += 0.15 * delta;
        }

        currentRotationX += (targetRotationX - currentRotationX) * 0.1;
        currentRotationY += (targetRotationY - currentRotationY) * 0.1;
        
        if (logoWrapper) {
            logoWrapper.style.transform = `rotateX(${currentRotationX}deg) rotateY(${currentRotationY}deg)`;
        }
        renderer.render(scene, camera);
    };
    draw();

    window.addEventListener('resize', () => {
        if (container.clientWidth > 0) {
            const w = container.clientWidth;
            const h = container.clientHeight;
            camera.aspect = w / h;
            camera.updateProjectionMatrix();
            renderer.setSize(w, h);
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>
