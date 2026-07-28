<?php
// includes/footer.php: Unified page footer template with Trilingual support
?>
    </main> <!-- End of .main-content -->
    
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-row">
                <!-- Info Section -->
                <div class="footer-col info-col">
                    <a href="index.php" class="footer-brand">
                        <img src="../Photos/site%20web%20IDMADJ/LOGGO.svg" alt="IDMADJ Logo" class="footer-logo-img">
                        <span><?php echo t('brand_title'); ?> <span class="cyan-text">IDMADJ</span></span>
                    </a>
                    <p class="footer-description">
                        <?php echo t('footer_desc'); ?>
                    </p>
                    <div class="social-links">
                        <a href="https://facebook.com" target="_blank" aria-label="Facebook" class="social-icon facebook">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn" class="social-icon linkedin">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
                        </a>
                        <a href="https://youtube.com" target="_blank" aria-label="YouTube" class="social-icon youtube">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        <a href="https://instagram.com" target="_blank" aria-label="Instagram" class="social-icon instagram">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-col links-col">
                    <h3 class="footer-title"><?php echo t('footer_quick_links'); ?></h3>
                    <ul class="footer-links">
                        <li><a href="about.php"><?php echo t('nav_about'); ?></a></li>
                        <li><a href="program.php"><?php echo t('nav_program'); ?></a></li>
                        <li><a href="b2b.php"><?php echo t('nav_b2b'); ?></a></li>
                        <li><a href="hackathon.php"><?php echo t('nav_hackathon'); ?></a></li>
                        <li><a href="register.php"><?php echo t('nav_register'); ?></a></li>
                    </ul>
                </div>

                <!-- Contact Details -->
                <div class="footer-col contact-col">
                    <h3 class="footer-title"><?php echo t('footer_contact_info'); ?></h3>
                    <ul class="footer-contact-info">
                        <li><svg class="icon" style="margin-left: 8px; color: var(--primary);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg> contact@idmadj.dz</li>
                        <li><svg class="icon" style="margin-left: 8px; color: var(--primary);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> <?php echo t('contact_phone_num'); ?></li>
                        <li><svg class="icon" style="margin-left: 8px; color: var(--primary);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> <?php echo t('contact_address'); ?></li>
                    </ul>
                </div>

                <!-- Sponsoring Logos -->
                <div class="footer-col organizers-col">
                    <h3 class="footer-title"><?php echo t('footer_organizers'); ?></h3>
                    <div class="footer-organizer-logos">
                        <div class="logo-box" title="AFYE">
                            <img src="../Photos/site%20web%20IDMADJ/LOGO%20afye/AFYE.png" alt="AFYE Logo">
                        </div>
                        <div class="logo-box" title="Ministere">
                            <img src="../Photos/site%20web%20IDMADJ/logo%20ministere/t%C3%A9l%C3%A9chargement.png" alt="Ministry Logo">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer bar -->
            <div class="footer-bottom">
                <p>&copy; 2026 <?php echo t('footer_rights'); ?></p>
                <div class="footer-legal-links">
                    <a href="privacy.php"><?php echo t('footer_privacy'); ?></a> | 
                    <a href="terms.php"><?php echo t('footer_terms'); ?></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Main JavaScript File -->
    <script src="js/main.js?v=1.1"></script>
</body>
</html>
