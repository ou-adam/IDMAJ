<?php
// website/terms.php: Terms & Conditions Page for IDMAJ 2026 with Multilingual support
require_once 'includes/lang.php';
$page_title = t('brand_title') . " 2026 - " . t('footer_terms');
include 'includes/header.php';
?>

<!-- Page Banner -->
<section class="page-banner text-center">
    <div class="container">
        <span class="badge badge-gold"><?php echo t('footer_terms'); ?></span>
        <h1><?php echo t('footer_terms'); ?></h1>
        <p><?php echo ($lang === 'ar') ? 'القواعد والشروط المنظمة لاستخدام منصة إدماج الرقمية وللمشاركة في الفعاليات' : (($lang === 'fr') ? 'Conditions générales d’utilisation de la plateforme et de participation aux évènements' : 'Terms and conditions governing the use of IDMAJ platform and event registration'); ?></p>
    </div>
</section>

<!-- Content Section -->
<section class="section-padding legal-content-section">
    <div class="container" style="max-width: 900px;">
        <div class="premium-card legal-card">
            
            <div class="legal-header">
                <div class="legal-icon-wrap" style="background: rgba(243, 156, 18, 0.1); border-color: rgba(243, 156, 18, 0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--accent-gold);"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <div>
                    <h2><?php echo ($lang === 'ar') ? 'شروط وأحكام استخدام منصة إدماج (IDMAJ 2026)' : (($lang === 'fr') ? 'Conditions Générales d’Utilisation de la Plateforme IDMAJ 2026' : 'Terms and Conditions of Use - IDMAJ 2026 Platform'); ?></h2>
                    <span class="legal-date"><?php echo ($lang === 'ar') ? 'سارية المفعول لجميع الزوار والمشاركين والعارضين | تحديث 2026' : (($lang === 'fr') ? 'Applicables à tous les visiteurs, participants et exposants | Mise à jour 2026' : 'Applicable to all visitors, participants, and exhibitors | 2026 Update'); ?></span>
                </div>
            </div>

            <hr class="legal-divider">

            <div class="legal-body">
                
                <!-- Section 1 -->
                <div class="legal-block">
                    <h3><span class="block-num gold">01</span> <?php echo ($lang === 'ar') ? 'القبول بالشروط' : (($lang === 'fr') ? 'Acceptation des Conditions' : 'Acceptance of Terms'); ?></h3>
                    <p>
                        <?php echo ($lang === 'ar') ? 
                        'يرجى قراءة هذه الشروط والأحكام بعناية قبل استخدام المنصة الإلكترونية للجلسات الوطنية **إدماج 2026 (WWW.IDMADJ.DZ)**. يشكل تصفح الموقع، التسجيل في الفعاليات، أو التفاعل مع الخدمات المتاحة قبولاً تاماً وغير مشروط بجميع البنود الواردة في هذا الإطار التنظيمي وبسياسة الخصوصية المرتبطة به.' : 
                        (($lang === 'fr') ? 
                        'En naviguant sur la plateforme **IDMAJ 2026 (WWW.IDMADJ.DZ)** et en vous inscrivant aux évènements, vous acceptez pleinement et sans réserve les présentes conditions générales d’utilisation et la politique de confidentialité associée.' : 
                        'By browsing the **IDMAJ 2026** platform (WWW.IDMADJ.DZ) and registering for events, you fully and unconditionally accept these terms and conditions and the associated privacy policy.'); ?>
                    </p>
                </div>

                <!-- Section 2 -->
                <div class="legal-block">
                    <h3><span class="block-num gold">02</span> <?php echo ($lang === 'ar') ? 'شروط وضوابط التسجيل والمشاركة' : (($lang === 'fr') ? 'Conditions d’Inscription et de Participation' : 'Registration & Participation Rules'); ?></h3>
                    <p><?php echo ($lang === 'ar') ? 'يتطلب التسجيل في الفعاليات أو حجز اللقاءات الثنائية والندوات الالتزام بالضوابط التالية:' : (($lang === 'fr') ? 'L’inscription aux évènements, assises et rendez-vous B2B implique le respect des règles suivantes :' : 'Event registration and B2B matchmaking require adherence to the following conditions:'); ?></p>
                    <ul class="legal-list">
                        <li><strong><?php echo ($lang === 'ar') ? 'صحة ودقة البيانات:' : (($lang === 'fr') ? 'Exactitude des données :' : 'Data Accuracy:'); ?></strong> <?php echo ($lang === 'ar') ? 'يلتزم المسجل بتقديم بيانات صحيحة ومطابقة للواقع (سواء للبيانات الشخصية أو السجل التجاري والمؤسسي).' : (($lang === 'fr') ? 'Le participant s’engage à fournir des informations exactes et vérifiables (identité, registre du commerce, NIF).' : 'Participants commit to providing truthful and verifiable personal and corporate information.'); ?></li>
                        <li><strong><?php echo ($lang === 'ar') ? 'الأهلية القانونية:' : (($lang === 'fr') ? 'Capacité juridique :' : 'Legal Authority:'); ?></strong> <?php echo ($lang === 'ar') ? 'يقر ممثل المؤسسة أو الشركة بأنه يمتلك الصلاحية القانونية الكاملة لتمثيل مؤسسته وتوقيع طلبات المشاركة ورعاية الفعاليات.' : (($lang === 'fr') ? 'Le représentant certifie détenir l’autorité légale pour engager son entreprise aux B2B et partenariats.' : 'Company representatives confirm full legal authority to bind their entity for B2B and sponsorship commitments.'); ?></li>
                        <li><strong><?php echo ($lang === 'ar') ? 'حق التأكيد أو الرفض:' : (($lang === 'fr') ? 'Validation de l’organisation :' : 'Organizational Approval:'); ?></strong> <?php echo ($lang === 'ar') ? 'تحتفظ اللجنة التنظيمية للمبادرة الوطنية بالحق في مراجعة وتأكيد أو رفض الطلبات التي لا تستوفي معايير المشاركة أو شروط الفعالية.' : (($lang === 'fr') ? 'Le comité d’organisation se réserve le droit de valider ou refuser les candidatures non conformes.' : 'The organizing committee reserves the right to validate or decline applications that do not meet event criteria.'); ?></li>
                    </ul>
                </div>

                <!-- Section 3 -->
                <div class="legal-block">
                    <h3><span class="block-num gold">03</span> <?php echo ($lang === 'ar') ? 'قواعد لقاءات B2B وهاكاثون الصناعة' : (($lang === 'fr') ? 'Règles des Rencontres B2B & Hackathon' : 'B2B & Hackathon Rules'); ?></h3>
                    <p><?php echo ($lang === 'ar') ? 'تخضع المشاركة في المسابقات التنافسية ولقاءات الأعمال الثنائية للقواعد التنفيذية الآتية:' : (($lang === 'fr') ? 'La participation aux espaces B2B et compétitions est régie par les règles suivantes :' : 'Participation in B2B meetings and competitions is governed by:'); ?></p>
                    <ul class="legal-list">
                        <li><?php echo ($lang === 'ar') ? 'الالتزام التام بالمواعيد والجدول الزمني المحدد للمقابلات الثنائية B2B بين المؤسسات الآمرة بالتأجير والمناولين.' : (($lang === 'fr') ? 'Respect strict du planning des rendez-vous B2B entre donneurs d’ordre et sous-traitants.' : 'Strict punctuality and compliance with scheduled B2B buyer-subcontractor meetings.'); ?></li>
                        <li><?php echo ($lang === 'ar') ? 'الملكية الفكرية والابتكارية للمشاريع والنماذج المعروضة في مسابقة **Pitch Box** و**هاكاثون الصناعة الذكية 4.0** تبقى محفوظة كلياً لأصحابها ومبتكريها.' : (($lang === 'fr') ? 'La propriété intellectuelle des projets présentés au Pitch Box et au Hackathon reste la propriété exclusive de leurs auteurs.' : 'Intellectual property rights for projects presented at Pitch Box and Hackathon remain 100% with their creators.'); ?></li>
                        <li><?php echo ($lang === 'ar') ? 'يمنع تقديم أية عروض أو معلومات مضللة أو غير حقيقية حول القدرات الإنتاجية أو الاعتمادات والجودة أثناء لقاءات الأعمال.' : (($lang === 'fr') ? 'Toute information trompeuse sur les capacités de production ou certifications est strictement interdite.' : 'Misleading information regarding manufacturing capabilities or quality certifications is strictly prohibited.'); ?></li>
                    </ul>
                </div>

                <!-- Section 4 -->
                <div class="legal-block">
                    <h3><span class="block-num gold">04</span> <?php echo ($lang === 'ar') ? 'حقوق الملكية الفكرية للمنصة' : (($lang === 'fr') ? 'Propriété Intellectuelle de la Plateforme' : 'Platform Intellectual Property'); ?></h3>
                    <p>
                        <?php echo ($lang === 'ar') ? 
                        'جميع المحتويات المعروضة على المنصة (بما في ذلك النصوص، التصاميم، الشعارات، الصور، الهوية البصرية، والرموز البرمجية) هي ملك حصري لمنصة **إدماج 2026** وللهيئات التنظيمية المعتمدة، ومحمية بموجب قوانين الملكية الفكرية والحقوق المجاورة في الجزائر. يُحظر نسخ، إعادة إنتاج، أو توزيع أي جزء دون إذن كتابي مسبق.' : 
                        (($lang === 'fr') ? 
                        'Tous les contenus figurant sur la plateforme (textes, visuels, logos, identité graphique, code source) sont la propriété exclusive d’**IDMAJ 2026** et des organismes organisateurs, protégés par la législation algérienne sur la propriété intellectuelle. Toute reproduction est interdite sans autorisation écrite préalable.' : 
                        'All content displayed on the platform (texts, graphics, logos, visual identity, source code) is the exclusive property of **IDMAJ 2026** and protected under Algerian IP laws. Reproduction without written consent is strictly prohibited.'); ?>
                    </p>
                </div>

                <!-- Section 5 -->
                <div class="legal-block">
                    <h3><span class="block-num gold">05</span> <?php echo ($lang === 'ar') ? 'السلوك المحظور وإساءة الاستخدام' : (($lang === 'fr') ? 'Comportements Interdits' : 'Prohibited Conduct'); ?></h3>
                    <p><?php echo ($lang === 'ar') ? 'يُحظر على أي مستخدم للمنصة القيام بأي من الأفعال التالية:' : (($lang === 'fr') ? 'Il est strictement interdit à tout utilisateur de :' : 'Users are strictly prohibited from:'); ?></p>
                    <ul class="legal-list">
                        <li><?php echo ($lang === 'ar') ? 'استخدام المنصة لأية أغراض غير قانونية، أو إرسال بريد عشوائي (Spam)، أو اختراق الأمن الرقمي للموقع.' : (($lang === 'fr') ? 'Utiliser la plateforme à des fins illégales, envoyer des spams ou tenter de porter atteinte à la sécurité informatique.' : 'Using the platform for illegal purposes, sending spam, or attempting cyber security breaches.'); ?></li>
                        <li><?php echo ($lang === 'ar') ? 'رفع ملفات تحتوي على فيروسات أو برمجيات خبيثة قد تضر بالبنية التحتية للمنصة.' : (($lang === 'fr') ? 'Téléverser des fichiers contenant des virus ou des logiciels malveillants.' : 'Uploading files containing viruses or malicious software.'); ?></li>
                        <li><?php echo ($lang === 'ar') ? 'الانتحال أو التظاهر بتمثيل مؤسسة أو هيئة دون تفويض رسمي منه.' : (($lang === 'fr') ? 'Usurper l’identité d’une entreprise ou d’un organisme sans mandat officiel.' : 'Impersonating any company or entity without official delegation.'); ?></li>
                    </ul>
                </div>

                <!-- Section 6 -->
                <div class="legal-block">
                    <h3><span class="block-num gold">06</span> <?php echo ($lang === 'ar') ? 'إخلاء المسؤولية والتعديلات' : (($lang === 'fr') ? 'Limitation de Responsabilité' : 'Limitation of Liability & Updates'); ?></h3>
                    <p>
                        <?php echo ($lang === 'ar') ? 
                        'تسعى إدارة المنصة لضمان دقة واستمرارية جميع الخدمات والمعلومات المعروضة. ومع ذلك، لا تتحمل المنصة المسؤولية عن أية انقطاعات فنية خارجة عن السيطرة أو أخطاء ناتجة عن إدخال بيانات غير صحيحة من قبل المستخدمين. وتحتفظ اللجنة التنظيمية بالحق في تعديل أو تحديث برنامج الفعاليات أو شروط الاستخدام عند الضرورة.' : 
                        (($lang === 'fr') ? 
                        'L’administration de la plateforme s’efforce d’assurer la continuité des services, mais ne peut être tenue responsable des interruptions techniques indépendantes de sa volonté. Le comité d’organisation se réserve le droit de modifier le programme ou les conditions d’utilisation si nécessaire.' : 
                        'Management strives to maintain service continuity but assumes no liability for technical outages beyond reasonable control. The committee reserves the right to modify the event program or terms when necessary.'); ?>
                    </p>
                </div>

                <!-- Section 7 -->
                <div class="legal-block">
                    <h3><span class="block-num gold">07</span> <?php echo ($lang === 'ar') ? 'القانون الواجب التطبيق والحلول القضائية' : (($lang === 'fr') ? 'Droit Applicable et Juridiction' : 'Governing Law & Jurisdiction'); ?></h3>
                    <p>
                        <?php echo ($lang === 'ar') ? 
                        'تخضع هذه الشروط والأحكام وتفسر وفقاً للقوانين والتشريعات المعمول بها في **الجمهورية الجزائرية الديمقراطية الشعبية**. وفي حال نشوب أي نزاع يتصل باستعمال المنصة أو الفعاليات، يسعى الطرفان لحله ودياً، وفي حال تعذر ذلك يخضع الاختصاص للمحاكم الجزائرية المختصة.' : 
                        (($lang === 'fr') ? 
                        'Les présentes conditions générales sont régies par les lois en vigueur en **République Algérienne Démocratique et Populaire**. Tout litige relatif à l’utilisation de la plateforme sera soumis au règlement amiable, et à défaut, à la compétence des juridictions algériennes.' : 
                        'These terms and conditions are governed by the laws of the **People’s Democratic Republic of Algeria**. Any dispute arising from platform usage shall be settled amicably or brought before competent Algerian courts.'); ?>
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
