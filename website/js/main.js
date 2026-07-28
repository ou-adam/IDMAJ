/* website/js/main.js: Site Interactions and Countdown */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile Navigation Menu Toggle
    const navToggle = document.getElementById('js-nav-toggle');
    const navMenu = document.getElementById('js-nav-menu');

    if (navToggle && navMenu) {
        const closeMenu = () => {
            navMenu.classList.remove('open');
            navToggle.classList.remove('active');
            document.body.classList.remove('menu-open');
        };

        navToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = navMenu.classList.toggle('open');
            navToggle.classList.toggle('active');
            document.body.classList.toggle('menu-open', isOpen);
        });

        // Close menu when clicking any link inside nav-menu
        navMenu.querySelectorAll('.nav-link, .btn').forEach(link => {
            link.addEventListener('click', () => {
                closeMenu();
            });
        });

        // Close menu when clicking outside header
        document.addEventListener('click', (e) => {
            if (navMenu.classList.contains('open')) {
                const header = document.querySelector('.site-header');
                if (header && !header.contains(e.target)) {
                    closeMenu();
                }
            }
        });
    }

    // 2. Countdown Timer for Opening Ceremony (June 25, 2026)
    const countdownDays = document.getElementById('countdown-days');
    const countdownHours = document.getElementById('countdown-hours');
    const countdownMinutes = document.getElementById('countdown-minutes');
    const countdownSeconds = document.getElementById('countdown-seconds');

    if (countdownDays && countdownHours && countdownMinutes && countdownSeconds) {
        // Set the opening ceremony date (June 25, 2026 09:00:00)
        const targetDate = new Date('June 25, 2026 09:00:00').getTime();

        const updateCountdown = () => {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {
                // If the event has started
                document.querySelector('.hero-countdown').style.display = 'none';
                return;
            }

            // Calculations
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output to elements
            countdownDays.innerText = String(days).padStart(2, '0');
            countdownHours.innerText = String(hours).padStart(2, '0');
            countdownMinutes.innerText = String(minutes).padStart(2, '0');
            countdownSeconds.innerText = String(seconds).padStart(2, '0');
        };

        // Run once immediately, then update every second
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    // 3. Dynamic Form Field Switcher (for register.php)
    const participantTypeSelect = document.getElementById('participant_type');
    const orgFields = document.getElementById('fields-org-only');
    const b2bFields = document.getElementById('fields-b2b-only');
    const hackathonFields = document.getElementById('fields-hack-only');
    const pitchFields = document.getElementById('fields-pitch-only');
    const seminarFields = document.getElementById('fields-seminar-only');
    const selectedSeminarSelect = document.getElementById('selected_seminar_wilaya');

    if (participantTypeSelect) {
        const toggleFormSections = () => {
            const selectedType = participantTypeSelect.value;

            // Default hidden & not required
            if (orgFields) orgFields.style.display = 'none';
            if (b2bFields) b2bFields.style.display = 'none';
            if (hackathonFields) hackathonFields.style.display = 'none';
            if (pitchFields) pitchFields.style.display = 'none';
            if (seminarFields) seminarFields.style.display = 'none';
            if (selectedSeminarSelect) selectedSeminarSelect.required = false;

            // Show sections based on participant type
            if (['corporate', 'sponsor', 'b2b'].includes(selectedType)) {
                if (orgFields) orgFields.style.display = 'block';
            }
            if (selectedType === 'b2b') {
                if (b2bFields) b2bFields.style.display = 'block';
            }
            if (selectedType === 'hackathon') {
                if (hackathonFields) hackathonFields.style.display = 'block';
            }
            if (selectedType === 'pitch') {
                if (pitchFields) pitchFields.style.display = 'block';
            }
            if (selectedType === 'seminar') {
                if (seminarFields) seminarFields.style.display = 'block';
                if (selectedSeminarSelect) selectedSeminarSelect.required = true;
            }
        };

        participantTypeSelect.addEventListener('change', toggleFormSections);
        // Execute on load to preserve state on reload or prepopulation
        toggleFormSections();
    }

    // 4. Light/Dark Theme Switcher Logic
    const themeToggleBtn = document.getElementById('theme-toggle');
    if (themeToggleBtn) {
        const sunIcon = themeToggleBtn.querySelector('.theme-icon-sun');
        const moonIcon = themeToggleBtn.querySelector('.theme-icon-moon');

        const updateThemeIcons = (isLight) => {
            if (isLight) {
                sunIcon.style.display = 'block';
                moonIcon.style.display = 'none';
            } else {
                sunIcon.style.display = 'none';
                moonIcon.style.display = 'block';
            }
        };

        // Check storage for active state
        const currentTheme = localStorage.getItem('theme') || 'dark';
        const isCurrentlyLight = currentTheme === 'light';
        updateThemeIcons(isCurrentlyLight);
        
        if (isCurrentlyLight) {
            document.documentElement.classList.add('light-theme');
            document.body.classList.add('light-theme');
        }

        themeToggleBtn.addEventListener('click', () => {
            const isLight = document.documentElement.classList.toggle('light-theme');
            document.body.classList.toggle('light-theme', isLight);
            
            // Persist preference in storage
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
            updateThemeIcons(isLight);
        });
    }

    // 5. Scroll Reveal Animation Observer (Global)
    const scrollObserverOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -30px 0px'
    };

    const scrollObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            }
        });
    }, scrollObserverOptions);

    // Observe all reveal-on-scroll elements across sub-pages
    document.querySelectorAll('.reveal-on-scroll, .section-header, .stat-card, .pillar-card, .podcast-card, .seminar-card').forEach(el => {
        if (!el.classList.contains('reveal-on-scroll')) {
            el.classList.add('reveal-on-scroll');
        }
        scrollObserver.observe(el);
    });

    // 6. Form Submission Loading Feedback
    const allForms = document.querySelectorAll('form');
    allForms.forEach(form => {
        form.addEventListener('submit', (e) => {
            if (form.checkValidity && !form.checkValidity()) {
                return; // Let browser HTML5 validation handle invalid fields
            }
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                const lang = document.documentElement.lang || 'ar';
                const loadingText = lang === 'ar' ? 'جاري الإرسال والمعالجة...' : (lang === 'fr' ? 'Traitement en cours...' : 'Processing...');
                
                // Add keyframe animation if missing
                if (!document.getElementById('js-spinner-style')) {
                    const style = document.createElement('style');
                    style.id = 'js-spinner-style';
                    style.textContent = `@keyframes spin { to { transform: rotate(360deg); } }`;
                    document.head.appendChild(style);
                }

                setTimeout(() => {
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.85';
                    submitBtn.style.cursor = 'wait';
                    submitBtn.innerHTML = `<span style="display:inline-block; width:14px; height:14px; border:2px solid currentColor; border-right-color:transparent; border-radius:50%; animation:spin 0.75s linear infinite; margin-inline-end:8px; vertical-align:-2px;"></span> ` + loadingText;
                }, 10);
            }
        });
    });
});
