<?php
// includes/header.php: Unified page header template with Trilingual support
require_once __DIR__ . '/lang.php';

if (!isset($page_title)) {
    $page_title = t('site_title_default');
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>" dir="<?php echo htmlspecialchars($dir); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Main Style Sheets -->
    <link rel="stylesheet" href="css/style.css?v=1.3">
    <?php if ($lang === 'ar'): ?>
    <link rel="stylesheet" href="css/rtl.css?v=1.3">
    <?php endif; ?>
    <!-- Theme Detection -->
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            if (theme === 'light') {
                document.documentElement.classList.add('light-theme');
            }
        })();
    </script>
</head>
<body>
    <header class="site-header">
        <div class="header-container">
            <!-- Brand Logotype -->
            <a href="index.php" class="brand-logo">
                <img src="../Photos/site%20web%20IDMADJ/LOGGO.svg" alt="IDMADJ Logo" class="main-logo-img">
                <div class="brand-text">
                    <span class="brand-title"><?php echo t('brand_title'); ?> <span class="cyan-text">IDMADJ</span></span>
                    <span class="brand-subtitle"><?php echo t('brand_subtitle'); ?></span>
                </div>
            </a>

            <!-- Mobile Navigation Toggle -->
            <button class="nav-toggle" id="js-nav-toggle" aria-label="Toggle Menu">
                <span class="toggle-bar"></span>
                <span class="toggle-bar"></span>
                <span class="toggle-bar"></span>
            </button>

            <!-- Navigation Links + Controls -->
            <nav class="nav-menu" id="js-nav-menu">
                <ul class="nav-list">
                    <li><a href="index.php" class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>"><?php echo t('nav_home'); ?></a></li>
                    <li><a href="about.php" class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>"><?php echo t('nav_about'); ?></a></li>
                    <li><a href="program.php" class="nav-link <?php echo ($current_page == 'program.php') ? 'active' : ''; ?>"><?php echo t('nav_program'); ?></a></li>
                    <li><a href="b2b.php" class="nav-link <?php echo ($current_page == 'b2b.php') ? 'active' : ''; ?>"><?php echo t('nav_b2b'); ?></a></li>
                    <li><a href="hackathon.php" class="nav-link <?php echo ($current_page == 'hackathon.php') ? 'active' : ''; ?>"><?php echo t('nav_hackathon'); ?></a></li>
                    <li><a href="pitch.php" class="nav-link <?php echo ($current_page == 'pitch.php') ? 'active' : ''; ?>"><?php echo t('nav_pitch'); ?></a></li>
                    <li><a href="podcast.php" class="nav-link <?php echo ($current_page == 'podcast.php') ? 'active' : ''; ?>"><?php echo t('nav_podcast'); ?></a></li>
                    <li><a href="sponsors.php" class="nav-link <?php echo ($current_page == 'sponsors.php' || $current_page == 'partners.php') ? 'active' : ''; ?>"><?php echo t('nav_sponsors'); ?></a></li>
                    <li><a href="contact.php" class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>"><?php echo t('nav_contact'); ?></a></li>
                </ul>

                <!-- Header Controls (Language Switcher + Theme Toggle) -->
                <div class="header-controls" style="display: flex; align-items: center; gap: 0.5rem; margin: 0 0.5rem;">
                    <!-- Language Switcher -->
                    <div class="lang-switcher">
                        <a href="<?php echo htmlspecialchars(get_lang_url('ar')); ?>" class="lang-btn <?php echo ($lang === 'ar') ? 'active' : ''; ?>">عربي</a>
                        <a href="<?php echo htmlspecialchars(get_lang_url('fr')); ?>" class="lang-btn <?php echo ($lang === 'fr') ? 'active' : ''; ?>">FR</a>
                        <a href="<?php echo htmlspecialchars(get_lang_url('en')); ?>" class="lang-btn <?php echo ($lang === 'en') ? 'active' : ''; ?>">EN</a>
                    </div>

                    <!-- Theme Toggle Button -->
                    <button id="theme-toggle" class="theme-toggle-btn" aria-label="Toggle Theme">
                        <svg class="theme-icon-sun" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px; display: none;"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                        <svg class="theme-icon-moon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px; display: block;"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                    </button>
                </div>

                <div class="nav-cta-wrapper">
                    <a href="register.php" class="btn btn-primary cta-btn"><?php echo t('nav_register'); ?></a>
                </div>
            </nav>
        </div>
    </header>
    <main class="main-content">
