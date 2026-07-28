'use client';

import { useState, useEffect } from 'react';
import { TRANSLATIONS } from './translations';

export default function Home() {
  const [lang, setLang] = useState('fr');
  const [currentStep, setCurrentStep] = useState(0);
  const [formData, setFormData] = useState({
    // Step 0: General info
    q0_1: '', q0_2: '', q0_3_ar: '', q0_3_fr: '', q0_4_ar: '', q0_4_fr: '',
    q0_5_main_date: '', q0_5_main_place: '', q0_5_period: '',
    q0_5_ouargla: '', q0_5_annaba: '', q0_5_oran: '', q0_6: '',
    q0_7_participants: '', q0_7_ateliers: '', q0_7_seminaires: '', q0_7_entreprises: '',
    q0_8_fb: '', q0_8_in: '', q0_8_tw: '', q0_8_yt: '',
    q0_9_address: '', q0_9_phone: '', q0_9_email: '', q0_9_reg_email: '',
    q0_10: [], // array of { name, link, logo }

    // Step 1: Hero & Nav
    q1_1_ar: '', q1_1_fr: '', q1_2_ar: '', q1_2_fr: '', q1_3: '',
    q1_4_ar: '', q1_4_fr: '',
    q1_5_nav_1_ar: '', q1_5_nav_1_fr: '',
    q1_5_nav_2_ar: '', q1_5_nav_2_fr: '',
    q1_5_nav_3_ar: '', q1_5_nav_3_fr: '',
    q1_5_nav_4_ar: '', q1_5_nav_4_fr: '',
    q1_5_nav_5_ar: '', q1_5_nav_5_fr: '',
    q1_6_ar: '', q1_6_fr: '', q1_7_ar: '', q1_7_fr: '', q1_8: '',

    // Step 2: About
    q2_1_ar: '', q2_1_fr: '', q2_2: [], // array of { obj }
    q2_3_ar: '', q2_3_fr: '', q2_4_ar: '', q2_4_fr: '', q2_5: [], // array of URLs
    q2_6_txt_ar: '', q2_6_txt_fr: '', q2_6_photo: '',

    // Step 3: Programme
    q3_1: [], // array of { time, title, speaker }
    q3_2_ouargla_theme: '', q3_2_annaba_theme: '', q3_2_oran_theme: '',
    q3_3_hack_desc: '', q3_4_closing: '', q3_5: '', q3_6_ar: '', q3_6_fr: '',

    // Step 4: Presse
    q4_1: [], // array of { title_ar, title_fr, content_ar, content_fr, image }
    q4_2: [], // array of URLs
    q4_3: [], // array of { url }
    q4_4_ar: '', q4_4_fr: '', q4_5: '',

    // Step 5: Inscription
    q5_1: [], // array of checked fields
    q5_2: [], // array of checked interests
    q5_3: [], // array of { sector }
    q5_4_ar: '', q5_4_fr: '', q5_5_msg_ar: '', q5_5_msg_fr: '', q5_6_ar: '', q5_6_fr: '',

    // Step 6: Legals
    q6_1_ar: '', q6_1_fr: '', q6_1_use_default: false,
    q6_2_ar: '', q6_2_fr: '', q6_2_use_default: false,
    q6_3_legal_name: '', q6_3_hq: '', q6_3_reg_num: '', q6_3_director: '',
    q6_4_domain: '', q6_4_purchased: 'no', q6_4_host: '',

    // Step 7: Back Office
    q7_1: [], // array of { name, email }
    q7_2: '', q7_3_subject_ar: '', q7_3_subject_fr: '', q7_3_body_ar: '', q7_3_body_fr: '',
    q7_4_ar: ''
  });

  const [uploadStatus, setUploadStatus] = useState({}); // { [fieldName]: 'idle' | 'uploading' | 'success' | 'error' }
  const [submitting, setSubmitting] = useState(false);
  const [submitted, setSubmitted] = useState(false);

  // Sync lang direction on html element
  useEffect(() => {
    const html = document.documentElement;
    html.setAttribute('lang', lang);
    html.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
  }, [lang]);

  const t = TRANSLATIONS[lang];

  // Helper to handle general text input change
  const handleInputChange = (field, value) => {
    setFormData(prev => ({
      ...prev,
      [field]: value
    }));
  };

  // Helper to handle file upload
  const handleFileUpload = async (fieldName, file) => {
    if (!file) return;

    setUploadStatus(prev => ({ ...prev, [fieldName]: 'uploading' }));

    try {
      const response = await fetch(`/api/upload?filename=${encodeURIComponent(file.name)}`, {
        method: 'POST',
        body: file,
      });

      if (!response.ok) throw new Error('Upload failed');
      const data = await response.json();

      setFormData(prev => ({
        ...prev,
        [fieldName]: data.url
      }));
      setUploadStatus(prev => ({ ...prev, [fieldName]: 'success' }));
    } catch (error) {
      console.error(error);
      setUploadStatus(prev => ({ ...prev, [fieldName]: 'error' }));
    }
  };

  // Helper for multiple file uploads (arrays of file URLs)
  const handleMultiFileUpload = async (fieldName, files) => {
    if (!files || files.length === 0) return;

    setUploadStatus(prev => ({ ...prev, [fieldName]: 'uploading' }));

    try {
      const uploadPromises = Array.from(files).map(async (file) => {
        const response = await fetch(`/api/upload?filename=${encodeURIComponent(file.name)}`, {
          method: 'POST',
          body: file,
        });
        if (!response.ok) throw new Error('Upload failed');
        const data = await response.json();
        return data.url;
      });

      const urls = await Promise.all(uploadPromises);

      setFormData(prev => ({
        ...prev,
        [fieldName]: [...(prev[fieldName] || []), ...urls]
      }));
      setUploadStatus(prev => ({ ...prev, [fieldName]: 'success' }));
    } catch (error) {
      console.error(error);
      setUploadStatus(prev => ({ ...prev, [fieldName]: 'error' }));
    }
  };

  // List of fields for general checkbox choices
  const registrationFields = [
    { key: 'companyName', labelFr: "Nom de l'entreprise", labelAr: "اسم المؤسسة" },
    { key: 'legalForm', labelFr: "Forme juridique", labelAr: "الشكل القانوني" },
    { key: 'regNum', labelFr: "N° Registre de commerce", labelAr: "رقم السجل التجاري" },
    { key: 'taxId', labelFr: "N° Identification fiscale", labelAr: "رقم التعريف الجبائي" },
    { key: 'sector', labelFr: "Secteur économique", labelAr: "القطاع الاقتصادي" },
    { key: 'mainActivity', labelFr: "Activité principale", labelAr: "النشاط الرئيسي" },
    { key: 'wilaya', labelFr: "Wilaya", labelAr: "الولاية" },
    { key: 'address', labelFr: "Adresse", labelAr: "العنوان" },
    { key: 'email', labelFr: "Email", labelAr: "البريد الإلكتروني" },
    { key: 'phone', labelFr: "Téléphone", labelAr: "رقم الهاتف" },
    { key: 'website', labelFr: "Site web", labelAr: "الموقع الإلكتروني" },
    { key: 'contactName', labelFr: "Nom du responsable / représentant", labelAr: "اسم المسؤول أو الممثل" },
    { key: 'contactPost', labelFr: "Poste", labelAr: "المنصب" },
    { key: 'employees', labelFr: "Nombre d'employés", labelAr: "عدد العمال" },
    { key: 'size', labelFr: "Taille de l'entreprise", labelAr: "حجم المؤسسة" },
    { key: 'domain', labelFr: "Domaine (producteur, sous-traitance, services)", labelAr: "المجال" },
    { key: 'logo', labelFr: "Logo de l'entreprise", labelAr: "شعار المؤسسة" },
    { key: 'pdfProfile', labelFr: "Fichier profil PDF de l'entreprise", labelAr: "ملف تعريفي PDF للمؤسسة" }
  ];

  const interestOptions = [
    { key: 'training', labelFr: "Bénéficier de formations dans les séminaires régionaux", labelAr: "الاستفادة من التكوين ضمن الندوات الجهوية" },
    { key: 'pitch', labelFr: "Pitcher son projet (Pitch Box 1 min)", labelAr: "تسويق المشروع الخاص (Pitch Box 1 min)" },
    { key: 'recruit', labelFr: "Recruter des compétences (sous-traitance & qualité)", labelAr: "توظيف خبرات ومهارات في مجال المناولة والجودة" },
    { key: 'b2b', labelFr: "Opportunité de partenariat B2B (clôture)", labelAr: "فرصة شراكة ومناولة B2B (حفل الاختتام)" },
    { key: 'hackathon', labelFr: "Participer au Hackathon", labelAr: "المشاركة في الهاكاثون" },
    { key: 'sponsoring', labelFr: "Sponsoring & financement de l'événement", labelAr: "رعاية وتمويل الحدث" },
    { key: 'media', labelFr: "Couverture médiatique de l'événement", labelAr: "تغطية الحدث إعلامياً" }
  ];

  // Helper to toggle checkbox array values
  const handleCheckboxChange = (field, key) => {
    setFormData(prev => {
      const current = prev[field] || [];
      const updated = current.includes(key)
        ? current.filter(item => item !== key)
        : [...current, key];
      return { ...prev, [field]: updated };
    });
  };

  // Submit entire form state
  const submitForm = async () => {
    if (!window.confirm(t.confirmSubmit)) return;

    setSubmitting(true);
    try {
      const response = await fetch('/api/submit', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData),
      });

      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(errorData.error || 'Submission failed');
      }

      setSubmitted(true);
    } catch (error) {
      console.error(error);
      alert(`Erreur lors de la soumission : ${error.message}`);
    } finally {
      setSubmitting(false);
    }
  };

  // Calculate overall progress percentage
  const getOverallProgress = () => {
    let filledFields = 0;
    let totalFields = 0;

    // We calculate progress based on some core properties
    const coreFields = [
      'q0_3_ar', 'q0_3_fr', 'q0_4_ar', 'q0_5_main_date', 'q0_5_main_place',
      'q1_1_fr', 'q1_2_fr', 'q1_4_fr',
      'q2_1_fr', 'q2_3_fr',
      'q3_2_ouargla_theme', 'q3_3_hack_desc', 'q3_6_fr',
      'q4_4_fr', 'q5_4_fr', 'q5_5_msg_fr', 'q5_6_fr',
      'q6_3_legal_name', 'q6_4_domain',
      'q7_2', 'q7_3_subject_fr'
    ];

    coreFields.forEach(f => {
      totalFields++;
      if (formData[f] && formData[f] !== '') filledFields++;
    });

    return Math.round((filledFields / totalFields) * 100);
  };

  if (submitted) {
    return (
      <div className="container" style={{ padding: '8rem 2rem', textAlign: 'center' }}>
        <div className="glass-container" style={{ maxWidth: '600px', margin: '0 auto' }}>
          <div style={{ color: 'var(--success)', fontSize: '4rem', marginBottom: '1.5rem' }}>✓</div>
          <h2 style={{ fontSize: '1.8rem', fontWeight: '800', marginBottom: '1rem' }}>
            {lang === 'fr' ? 'Merci pour vos réponses !' : 'شكراً لإجاباتكم !'}
          </h2>
          <p style={{ color: 'var(--text-muted)', marginBottom: '2rem' }}>
            {lang === 'fr' 
              ? 'Le questionnaire a été soumis avec succès. Les informations et fichiers ont été envoyés à l\'équipe technique.' 
              : 'تم إرسال الاستمارة بنجاح. تم إرسال كافة المعلومات والملفات المرفقة للفريق التقني.'}
          </p>
          <button 
            className="nav-btn nav-btn-next" 
            style={{ margin: '0 auto' }}
            onClick={() => setSubmitted(false)}
          >
            {lang === 'fr' ? 'Revenir au formulaire' : 'العودة للاستمارة'}
          </button>
        </div>
      </div>
    );
  }

  return (
    <div>
      {/* ── HEADER ── */}
      <header className="header-bar">
        <div className="container header-content">
          <div className="header-title">
            <h1>
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="16" y1="13" x2="8" y2="13" />
                <line x1="16" y1="17" x2="8" y2="17" />
                <polyline points="10 9 9 9 8 9" />
              </svg>
              {t.title}
            </h1>
            <p>{t.subtitle}</p>
          </div>
          <div className="lang-switcher">
            <button className={`lang-btn ${lang === 'fr' ? 'active' : ''}`} onClick={() => setLang('fr')}>FR</button>
            <button className={`lang-btn ${lang === 'ar' ? 'active' : ''}`} onClick={() => setLang('ar')}>AR</button>
          </div>
        </div>
      </header>

      <main className="container" style={{ marginTop: '2rem' }}>
        {/* ── INTRO BLOCK ── */}
        <div className="intro-block">
          <h2>{t.introTitle}</h2>
          <p>{t.introText}</p>
          <div style={{ marginTop: '1rem', display: 'flex', gap: '1.5rem', fontSize: '0.8rem', color: 'var(--text-muted)', flexWrap: 'wrap' }}>
            <span><strong>{t.project}</strong></span>
            <span><strong>{t.event}</strong></span>
            <span><strong>{t.version}</strong></span>
          </div>
        </div>

        {/* ── PROGRESS BAR ── */}
        <div className="progress-section">
          <div className="progress-header">
            <span>{t.progressTitle}</span>
            <strong>{getOverallProgress()}%</strong>
          </div>
          <div className="progress-bar-bg">
            <div className="progress-bar-fill" style={{ width: `${getOverallProgress()}%` }}></div>
          </div>
        </div>

        {/* ── STEP CONTENT WIZARD ── */}
        <div className="glass-container">
          {/* Step 0: GENERAL INFORMATION */}
          {currentStep === 0 && (
            <div>
              <div className="step-title-section">
                <div className="step-number">0</div>
                <h2>{t.sections.s0}</h2>
              </div>

              {/* Q0.1 Logo Evénement */}
              <div className="form-group">
                <span className="form-label">{t.fields.q0_1}</span>
                <div className="tag-container">
                  <span className="badge badge-required">{t.requiredTag}</span>
                  <span className="badge badge-file">{t.fileTag}</span>
                </div>
                <input 
                  type="text" 
                  className="input-text" 
                  placeholder={lang === 'fr' ? "Ex: https://drive.google.com/... (Lien du logo)" : "مثال: https://drive.google.com/... (رابط الشعار)"} 
                  value={formData.q0_1} 
                  onChange={(e) => handleInputChange('q0_1', e.target.value)} 
                />
              </div>

              {/* Q0.2 Logo Organisateur */}
              <div className="form-group">
                <span className="form-label">{t.fields.q0_2}</span>
                <div className="tag-container">
                  <span className="badge badge-required">{t.requiredTag}</span>
                  <span className="badge badge-file">{t.fileTag}</span>
                </div>
                <input 
                  type="text" 
                  className="input-text" 
                  placeholder={lang === 'fr' ? "Ex: https://drive.google.com/... (Lien du logo)" : "مثال: https://drive.google.com/... (رابط الشعار)"} 
                  value={formData.q0_2} 
                  onChange={(e) => handleInputChange('q0_2', e.target.value)} 
                />
              </div>

              {/* Q0.3 Nom complet Event (Bilingue) */}
              <div className="form-group">
                <span className="form-label">{t.fields.q0_3_ar}</span>
                <div className="tag-container">
                  <span className="badge badge-required">{t.requiredTag}</span>
                  <span className="badge badge-bilingual">{t.bilingualTag}</span>
                </div>
                <input type="text" className="input-text" style={{ direction: 'rtl' }} value={formData.q0_3_ar} onChange={(e) => handleInputChange('q0_3_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q0_3_fr}</span>
                <div className="tag-container">
                  <span className="badge badge-required">{t.requiredTag}</span>
                  <span className="badge badge-bilingual">{t.bilingualTag}</span>
                </div>
                <input type="text" className="input-text" value={formData.q0_3_fr} onChange={(e) => handleInputChange('q0_3_fr', e.target.value)} />
              </div>

              {/* Q0.4 Slogan Event (Bilingue) */}
              <div className="form-group">
                <span className="form-label">{t.fields.q0_4_ar}</span>
                <div className="tag-container">
                  <span className="badge badge-required">{t.requiredTag}</span>
                  <span className="badge badge-bilingual">{t.bilingualTag}</span>
                </div>
                <input type="text" className="input-text" style={{ direction: 'rtl' }} value={formData.q0_4_ar} onChange={(e) => handleInputChange('q0_4_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q0_4_fr}</span>
                <div className="tag-container">
                  <span className="badge badge-required">{t.requiredTag}</span>
                  <span className="badge badge-bilingual">{t.bilingualTag}</span>
                </div>
                <input type="text" className="input-text" value={formData.q0_4_fr} onChange={(e) => handleInputChange('q0_4_fr', e.target.value)} />
              </div>

              {/* Q0.5 Dates et Lieux */}
              <div className="form-group">
                <span className="form-label">{t.fields.q0_5_main_date}</span>
                <input type="text" className="input-text" value={formData.q0_5_main_date} onChange={(e) => handleInputChange('q0_5_main_date', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q0_5_main_place}</span>
                <input type="text" className="input-text" value={formData.q0_5_main_place} onChange={(e) => handleInputChange('q0_5_main_place', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q0_5_period}</span>
                <input type="text" className="input-text" value={formData.q0_5_period} onChange={(e) => handleInputChange('q0_5_period', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q0_5_ouargla}</span>
                <input type="text" className="input-text" value={formData.q0_5_ouargla} onChange={(e) => handleInputChange('q0_5_ouargla', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q0_5_annaba}</span>
                <input type="text" className="input-text" value={formData.q0_5_annaba} onChange={(e) => handleInputChange('q0_5_annaba', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q0_5_oran}</span>
                <input type="text" className="input-text" value={formData.q0_5_oran} onChange={(e) => handleInputChange('q0_5_oran', e.target.value)} />
              </div>

              {/* Q0.6 Charte graphique PDF */}
              <div className="form-group">
                <span className="form-label">{t.fields.q0_6}</span>
                <div className="tag-container">
                  <span className="badge badge-optional">{t.optionalTag}</span>
                  <span className="badge badge-file">{t.fileTag}</span>
                </div>
                <input 
                  type="text" 
                  className="input-text" 
                  placeholder={lang === 'fr' ? "Ex: https://drive.google.com/... (Lien de la charte graphique)" : "مثال: https://drive.google.com/... (رابط الميثاق البصري)"} 
                  value={formData.q0_6} 
                  onChange={(e) => handleInputChange('q0_6', e.target.value)} 
                />
              </div>

              {/* Q0.7 Chiffres clés */}
              <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
                <div className="form-group">
                  <span className="form-label">{t.fields.q0_7_participants}</span>
                  <input type="text" className="input-text" value={formData.q0_7_participants} onChange={(e) => handleInputChange('q0_7_participants', e.target.value)} />
                </div>
                <div className="form-group">
                  <span className="form-label">{t.fields.q0_7_ateliers}</span>
                  <input type="text" className="input-text" value={formData.q0_7_ateliers} onChange={(e) => handleInputChange('q0_7_ateliers', e.target.value)} />
                </div>
              </div>
              <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
                <div className="form-group">
                  <span className="form-label">{t.fields.q0_7_seminaires}</span>
                  <input type="text" className="input-text" value={formData.q0_7_seminaires} onChange={(e) => handleInputChange('q0_7_seminaires', e.target.value)} />
                </div>
                <div className="form-group">
                  <span className="form-label">{t.fields.q0_7_entreprises}</span>
                  <input type="text" className="input-text" value={formData.q0_7_entreprises} onChange={(e) => handleInputChange('q0_7_entreprises', e.target.value)} />
                </div>
              </div>

              {/* Q0.8 Reseaux sociaux */}
              <div className="form-group">
                <span className="form-label">{t.fields.q0_8_fb}</span>
                <input type="text" className="input-text" value={formData.q0_8_fb} onChange={(e) => handleInputChange('q0_8_fb', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q0_8_in}</span>
                <input type="text" className="input-text" value={formData.q0_8_in} onChange={(e) => handleInputChange('q0_8_in', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q0_8_tw}</span>
                <input type="text" className="input-text" value={formData.q0_8_tw} onChange={(e) => handleInputChange('q0_8_tw', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q0_8_yt}</span>
                <input type="text" className="input-text" value={formData.q0_8_yt} onChange={(e) => handleInputChange('q0_8_yt', e.target.value)} />
              </div>

              {/* Q0.9 Contact details */}
              <div className="form-group">
                <span className="form-label">{t.fields.q0_9_address}</span>
                <input type="text" className="input-text" value={formData.q0_9_address} onChange={(e) => handleInputChange('q0_9_address', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q0_9_phone}</span>
                <input type="text" className="input-text" value={formData.q0_9_phone} onChange={(e) => handleInputChange('q0_9_phone', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q0_9_email}</span>
                <input type="text" className="input-text" value={formData.q0_9_email} onChange={(e) => handleInputChange('q0_9_email', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q0_9_reg_email}</span>
                <input type="text" className="input-text" value={formData.q0_9_reg_email} onChange={(e) => handleInputChange('q0_9_reg_email', e.target.value)} />
              </div>

              {/* Q0.10 Sponsors bandeau défilant (Dynamic List) */}
              <div className="form-group" style={{ borderTop: '1px solid rgba(255,255,255,0.05)', paddingTop: '1.5rem' }}>
                <span className="form-label">{t.fields.q0_10}</span>
                <div className="tag-container" style={{ marginBottom: '1rem' }}>
                  <span className="badge badge-required">{t.requiredTag}</span>
                  <span className="badge badge-file">{t.fileTag}</span>
                </div>

                {(formData.q0_10 || []).map((sponsor, idx) => (
                  <div key={idx} className="list-item-card">
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem', marginBottom: '0.8rem' }}>
                      <div>
                        <span className="form-label" style={{ fontSize: '0.8rem' }}>{t.fields.q0_10_name}</span>
                        <input type="text" className="input-text" value={sponsor.name || ''} onChange={(e) => {
                          const updated = [...formData.q0_10];
                          updated[idx].name = e.target.value;
                          handleInputChange('q0_10', updated);
                        }} />
                      </div>
                      <div>
                        <span className="form-label" style={{ fontSize: '0.8rem' }}>{t.fields.q0_10_link}</span>
                        <input type="text" className="input-text" value={sponsor.link || ''} onChange={(e) => {
                          const updated = [...formData.q0_10];
                          updated[idx].link = e.target.value;
                          handleInputChange('q0_10', updated);
                        }} />
                      </div>
                    </div>
                    <div>
                      <span className="form-label" style={{ fontSize: '0.8rem' }}>{t.fields.q0_10_logo}</span>
                      <input 
                        type="text" 
                        className="input-text" 
                        placeholder={lang === 'fr' ? "Ex: https://drive.google.com/... (Lien du logo)" : "مثال: https://drive.google.com/... (رابط الشعار)"} 
                        value={sponsor.logo || ''} 
                        onChange={(e) => {
                          const updated = [...formData.q0_10];
                          updated[idx].logo = e.target.value;
                          handleInputChange('q0_10', updated);
                        }} 
                      />
                    </div>
                    <button className="remove-btn" onClick={() => {
                      const updated = formData.q0_10.filter((_, i) => i !== idx);
                      handleInputChange('q0_10', updated);
                    }}>{t.removeBtn}</button>
                  </div>
                ))}

                <button className="add-btn" onClick={() => {
                  handleInputChange('q0_10', [...(formData.q0_10 || []), { name: '', link: '', logo: '' }]);
                }}>+ {t.addBtn}</button>
              </div>
            </div>
          )}

          {/* Step 1: HOME & HERO */}
          {currentStep === 1 && (
            <div>
              <div className="step-title-section">
                <div className="step-number">1</div>
                <h2>{t.sections.s1}</h2>
              </div>

              {/* Q1.1 Hero titre */}
              <div className="form-group">
                <span className="form-label">{t.fields.q1_1_ar}</span>
                <input type="text" className="input-text" style={{ direction: 'rtl' }} value={formData.q1_1_ar} onChange={(e) => handleInputChange('q1_1_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q1_1_fr}</span>
                <input type="text" className="input-text" value={formData.q1_1_fr} onChange={(e) => handleInputChange('q1_1_fr', e.target.value)} />
              </div>

              {/* Q1.2 Hero sous-titre */}
              <div className="form-group">
                <span className="form-label">{t.fields.q1_2_ar}</span>
                <input type="text" className="input-text" style={{ direction: 'rtl' }} value={formData.q1_2_ar} onChange={(e) => handleInputChange('q1_2_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q1_2_fr}</span>
                <input type="text" className="input-text" value={formData.q1_2_fr} onChange={(e) => handleInputChange('q1_2_fr', e.target.value)} />
              </div>

              {/* Q1.3 Hero Image Fond */}
              <div className="form-group">
                <span className="form-label">{t.fields.q1_3}</span>
                <div className="tag-container">
                  <span className="badge badge-optional">{t.optionalTag}</span>
                  <span className="badge badge-file">{t.fileTag}</span>
                </div>
                <input 
                  type="text" 
                  className="input-text" 
                  placeholder={lang === 'fr' ? "Ex: https://drive.google.com/... (Lien de l'image de fond)" : "مثال: https://drive.google.com/... (رابط صورة الخلفية)"} 
                  value={formData.q1_3} 
                  onChange={(e) => handleInputChange('q1_3', e.target.value)} 
                />
              </div>

              {/* Q1.4 Button Action */}
              <div className="form-group">
                <span className="form-label">{t.fields.q1_4_ar}</span>
                <input type="text" className="input-text" style={{ direction: 'rtl' }} value={formData.q1_4_ar} onChange={(e) => handleInputChange('q1_4_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q1_4_fr}</span>
                <input type="text" className="input-text" value={formData.q1_4_fr} onChange={(e) => handleInputChange('q1_4_fr', e.target.value)} />
              </div>

              {/* Q1.5 Noms sections nav */}
              <div className="form-group" style={{ borderTop: '1px solid rgba(255,255,255,0.05)', paddingTop: '1.5rem' }}>
                <span className="form-label">{t.fields.q1_5_nav}</span>
                
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem', marginBottom: '0.8rem' }}>
                  <input type="text" className="input-text" style={{ direction: 'rtl' }} placeholder={t.fields.q1_5_nav_1_ar} value={formData.q1_5_nav_1_ar} onChange={(e) => handleInputChange('q1_5_nav_1_ar', e.target.value)} />
                  <input type="text" className="input-text" placeholder={t.fields.q1_5_nav_1_fr} value={formData.q1_5_nav_1_fr} onChange={(e) => handleInputChange('q1_5_nav_1_fr', e.target.value)} />
                </div>
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem', marginBottom: '0.8rem' }}>
                  <input type="text" className="input-text" style={{ direction: 'rtl' }} placeholder={t.fields.q1_5_nav_2_ar} value={formData.q1_5_nav_2_ar} onChange={(e) => handleInputChange('q1_5_nav_2_ar', e.target.value)} />
                  <input type="text" className="input-text" placeholder={t.fields.q1_5_nav_2_fr} value={formData.q1_5_nav_2_fr} onChange={(e) => handleInputChange('q1_5_nav_2_fr', e.target.value)} />
                </div>
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem', marginBottom: '0.8rem' }}>
                  <input type="text" className="input-text" style={{ direction: 'rtl' }} placeholder={t.fields.q1_5_nav_3_ar} value={formData.q1_5_nav_3_ar} onChange={(e) => handleInputChange('q1_5_nav_3_ar', e.target.value)} />
                  <input type="text" className="input-text" placeholder={t.fields.q1_5_nav_3_fr} value={formData.q1_5_nav_3_fr} onChange={(e) => handleInputChange('q1_5_nav_3_fr', e.target.value)} />
                </div>
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem', marginBottom: '0.8rem' }}>
                  <input type="text" className="input-text" style={{ direction: 'rtl' }} placeholder={t.fields.q1_5_nav_4_ar} value={formData.q1_5_nav_4_ar} onChange={(e) => handleInputChange('q1_5_nav_4_ar', e.target.value)} />
                  <input type="text" className="input-text" placeholder={t.fields.q1_5_nav_4_fr} value={formData.q1_5_nav_4_fr} onChange={(e) => handleInputChange('q1_5_nav_4_fr', e.target.value)} />
                </div>
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
                  <input type="text" className="input-text" style={{ direction: 'rtl' }} placeholder={t.fields.q1_5_nav_5_ar} value={formData.q1_5_nav_5_ar} onChange={(e) => handleInputChange('q1_5_nav_5_ar', e.target.value)} />
                  <input type="text" className="input-text" placeholder={t.fields.q1_5_nav_5_fr} value={formData.q1_5_nav_5_fr} onChange={(e) => handleInputChange('q1_5_nav_5_fr', e.target.value)} />
                </div>
              </div>

              {/* Q1.6 Footer Copyright */}
              <div className="form-group">
                <span className="form-label">{t.fields.q1_6_ar}</span>
                <input type="text" className="input-text" style={{ direction: 'rtl' }} value={formData.q1_6_ar} onChange={(e) => handleInputChange('q1_6_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q1_6_fr}</span>
                <input type="text" className="input-text" value={formData.q1_6_fr} onChange={(e) => handleInputChange('q1_6_fr', e.target.value)} />
              </div>

              {/* Q1.7 Message de bienvenue Hero */}
              <div className="form-group">
                <span className="form-label">{t.fields.q1_7_ar}</span>
                <input type="text" className="input-text" style={{ direction: 'rtl' }} value={formData.q1_7_ar} onChange={(e) => handleInputChange('q1_7_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q1_7_fr}</span>
                <input type="text" className="input-text" value={formData.q1_7_fr} onChange={(e) => handleInputChange('q1_7_fr', e.target.value)} />
              </div>

              {/* Q1.8 Vidéo promotionnelle URL */}
              <div className="form-group">
                <span className="form-label">{t.fields.q1_8}</span>
                <input type="text" className="input-text" value={formData.q1_8} onChange={(e) => handleInputChange('q1_8', e.target.value)} />
              </div>
            </div>
          )}

          {/* Step 2: ABOUT SECTION */}
          {currentStep === 2 && (
            <div>
              <div className="step-title-section">
                <div className="step-number">2</div>
                <h2>{t.sections.s2}</h2>
              </div>

              {/* Q2.1 Presentation initiative */}
              <div className="form-group">
                <span className="form-label">{t.fields.q2_1_ar}</span>
                <textarea className="input-textarea" style={{ direction: 'rtl' }} value={formData.q2_1_ar} onChange={(e) => handleInputChange('q2_1_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q2_1_fr}</span>
                <textarea className="input-textarea" value={formData.q2_1_fr} onChange={(e) => handleInputChange('q2_1_fr', e.target.value)} />
              </div>

              {/* Q2.2 Objectifs principaux (Dynamic List) */}
              <div className="form-group">
                <span className="form-label">{t.fields.q2_2}</span>
                {(formData.q2_2 || []).map((item, idx) => (
                  <div key={idx} className="list-item-card" style={{ display: 'flex', alignItems: 'center', gap: '1rem' }}>
                    <input type="text" className="input-text" placeholder={t.fields.q2_2_obj} value={item.obj || ''} onChange={(e) => {
                      const updated = [...formData.q2_2];
                      updated[idx].obj = e.target.value;
                      handleInputChange('q2_2', updated);
                    }} />
                    <button className="remove-btn" style={{ margin: 0 }} onClick={() => {
                      const updated = formData.q2_2.filter((_, i) => i !== idx);
                      handleInputChange('q2_2', updated);
                    }}>{t.removeBtn}</button>
                  </div>
                ))}
                <button className="add-btn" onClick={() => {
                  handleInputChange('q2_2', [...(formData.q2_2 || []), { obj: '' }]);
                }}>+ {t.addBtn}</button>
              </div>

              {/* Q2.3 Impact attendu */}
              <div className="form-group">
                <span className="form-label">{t.fields.q2_3_ar}</span>
                <textarea className="input-textarea" style={{ direction: 'rtl' }} value={formData.q2_3_ar} onChange={(e) => handleInputChange('q2_3_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q2_3_fr}</span>
                <textarea className="input-textarea" value={formData.q2_3_fr} onChange={(e) => handleInputChange('q2_3_fr', e.target.value)} />
              </div>

              {/* Q2.4 Présentation organisateur */}
              <div className="form-group">
                <span className="form-label">{t.fields.q2_4_ar}</span>
                <textarea className="input-textarea" style={{ direction: 'rtl' }} value={formData.q2_4_ar} onChange={(e) => handleInputChange('q2_4_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q2_4_fr}</span>
                <textarea className="input-textarea" value={formData.q2_4_fr} onChange={(e) => handleInputChange('q2_4_fr', e.target.value)} />
              </div>

              {/* Q2.5 Photos illustrations À propos */}
              <div className="form-group">
                <span className="form-label">{t.fields.q2_5}</span>
                <div className="tag-container">
                  <span className="badge badge-optional">{t.optionalTag}</span>
                  <span className="badge badge-file">{t.fileTag}</span>
                </div>
                {(formData.q2_5 || []).map((url, idx) => (
                  <div key={idx} className="list-item-card" style={{ display: 'flex', alignItems: 'center', gap: '1rem', marginBottom: '0.5rem' }}>
                    <input 
                      type="text" 
                      className="input-text" 
                      placeholder={lang === 'fr' ? "Ex: https://drive.google.com/... (Lien d'image)" : "مثال: https://drive.google.com/... (رابط الصورة)"} 
                      value={url || ''} 
                      onChange={(e) => {
                        const updated = [...formData.q2_5];
                        updated[idx] = e.target.value;
                        handleInputChange('q2_5', updated);
                      }} 
                    />
                    <button className="remove-btn" style={{ margin: 0 }} onClick={() => {
                      const updated = formData.q2_5.filter((_, i) => i !== idx);
                      handleInputChange('q2_5', updated);
                    }}>{t.removeBtn}</button>
                  </div>
                ))}
                <button className="add-btn" onClick={() => {
                  handleInputChange('q2_5', [...(formData.q2_5 || []), '']);
                }}>+ {t.addBtn}</button>
              </div>

              {/* Q2.6 Mot du président */}
              <div className="form-group" style={{ borderTop: '1px solid rgba(255,255,255,0.05)', paddingTop: '1.5rem' }}>
                <span className="form-label">{t.fields.q2_6_txt_ar}</span>
                <textarea className="input-textarea" style={{ direction: 'rtl' }} value={formData.q2_6_txt_ar} onChange={(e) => handleInputChange('q2_6_txt_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q2_6_txt_fr}</span>
                <textarea className="input-textarea" value={formData.q2_6_txt_fr} onChange={(e) => handleInputChange('q2_6_txt_fr', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q2_6_photo}</span>
                <input 
                  type="text" 
                  className="input-text" 
                  placeholder={lang === 'fr' ? "Ex: https://drive.google.com/... (Photo du président)" : "مثال: https://drive.google.com/... (صورة رئيس المؤسسة)"} 
                  value={formData.q2_6_photo} 
                  onChange={(e) => handleInputChange('q2_6_photo', e.target.value)} 
                />
              </div>
            </div>
          )}

          {/* Step 3: PROGRAMME TIMELINE */}
          {currentStep === 3 && (
            <div>
              <div className="step-title-section">
                <div className="step-number">3</div>
                <h2>{t.sections.s3}</h2>
              </div>

              {/* Q3.6 Intro programme (Bilingue) */}
              <div className="form-group">
                <span className="form-label">{t.fields.q3_6_ar}</span>
                <textarea className="input-textarea" style={{ direction: 'rtl' }} value={formData.q3_6_ar} onChange={(e) => handleInputChange('q3_6_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q3_6_fr}</span>
                <textarea className="input-textarea" value={formData.q3_6_fr} onChange={(e) => handleInputChange('q3_6_fr', e.target.value)} />
              </div>

              {/* Q3.1 Timeline jour ouverture (Dynamic List) */}
              <div className="form-group" style={{ borderTop: '1px solid rgba(255,255,255,0.05)', paddingTop: '1.5rem' }}>
                <span className="form-label">{t.fields.q3_1}</span>
                {(formData.q3_1 || []).map((event, idx) => (
                  <div key={idx} className="list-item-card">
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 2fr 1fr', gap: '1rem', marginBottom: '0.5rem' }}>
                      <div>
                        <span className="form-label" style={{ fontSize: '0.8rem' }}>{t.fields.q3_1_time}</span>
                        <input type="text" className="input-text" value={event.time || ''} onChange={(e) => {
                          const updated = [...formData.q3_1];
                          updated[idx].time = e.target.value;
                          handleInputChange('q3_1', updated);
                        }} />
                      </div>
                      <div>
                        <span className="form-label" style={{ fontSize: '0.8rem' }}>{t.fields.q3_1_title}</span>
                        <input type="text" className="input-text" value={event.title || ''} onChange={(e) => {
                          const updated = [...formData.q3_1];
                          updated[idx].title = e.target.value;
                          handleInputChange('q3_1', updated);
                        }} />
                      </div>
                      <div>
                        <span className="form-label" style={{ fontSize: '0.8rem' }}>{t.fields.q3_1_speaker}</span>
                        <input type="text" className="input-text" value={event.speaker || ''} onChange={(e) => {
                          const updated = [...formData.q3_1];
                          updated[idx].speaker = e.target.value;
                          handleInputChange('q3_1', updated);
                        }} />
                      </div>
                    </div>
                    <button className="remove-btn" onClick={() => {
                      const updated = formData.q3_1.filter((_, i) => i !== idx);
                      handleInputChange('q3_1', updated);
                    }}>{t.removeBtn}</button>
                  </div>
                ))}
                <button className="add-btn" onClick={() => {
                  handleInputChange('q3_1', [...(formData.q3_1 || []), { time: '', title: '', speaker: '' }]);
                }}>+ {t.addBtn}</button>
              </div>

              {/* Q3.2 Themes seminaires regionaux */}
              <div className="form-group">
                <span className="form-label">{t.fields.q3_2_ouargla_theme}</span>
                <textarea className="input-textarea" value={formData.q3_2_ouargla_theme} onChange={(e) => handleInputChange('q3_2_ouargla_theme', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q3_2_annaba_theme}</span>
                <textarea className="input-textarea" value={formData.q3_2_annaba_theme} onChange={(e) => handleInputChange('q3_2_annaba_theme', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q3_2_oran_theme}</span>
                <textarea className="input-textarea" value={formData.q3_2_oran_theme} onChange={(e) => handleInputChange('q3_2_oran_theme', e.target.value)} />
              </div>

              {/* Q3.3 Hackathon desc */}
              <div className="form-group">
                <span className="form-label">{t.fields.q3_3_hack_desc}</span>
                <textarea className="input-textarea" value={formData.q3_3_hack_desc} onChange={(e) => handleInputChange('q3_3_hack_desc', e.target.value)} />
              </div>

              {/* Q3.4 Programme clôture */}
              <div className="form-group">
                <span className="form-label">{t.fields.q3_4_closing}</span>
                <textarea className="input-textarea" value={formData.q3_4_closing} onChange={(e) => handleInputChange('q3_4_closing', e.target.value)} />
              </div>

              {/* Q3.5 Programme complet PDF */}
              <div className="form-group">
                <span className="form-label">{t.fields.q3_5}</span>
                <div className="tag-container">
                  <span className="badge badge-optional">{t.optionalTag}</span>
                  <span className="badge badge-file">{t.fileTag}</span>
                </div>
                <input 
                  type="text" 
                  className="input-text" 
                  placeholder={lang === 'fr' ? "Ex: https://drive.google.com/... (Lien PDF programme)" : "مثال: https://drive.google.com/... (رابط ملف البرنامج)"} 
                  value={formData.q3_5} 
                  onChange={(e) => handleInputChange('q3_5', e.target.value)} 
                />
              </div>
            </div>
          )}

          {/* Step 4: CENTRE DE PRESSE */}
          {currentStep === 4 && (
            <div>
              <div className="step-title-section">
                <div className="step-number">4</div>
                <h2>{t.sections.s4}</h2>
              </div>

              {/* Q4.4 Intro presse */}
              <div className="form-group">
                <span className="form-label">{t.fields.q4_4_ar}</span>
                <textarea className="input-textarea" style={{ direction: 'rtl' }} value={formData.q4_4_ar} onChange={(e) => handleInputChange('q4_4_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q4_4_fr}</span>
                <textarea className="input-textarea" value={formData.q4_4_fr} onChange={(e) => handleInputChange('q4_4_fr', e.target.value)} />
              </div>

              {/* Q4.1 Actualites initiales (Dynamic List) */}
              <div className="form-group" style={{ borderTop: '1px solid rgba(255,255,255,0.05)', paddingTop: '1.5rem' }}>
                <span className="form-label">{t.fields.q4_1}</span>
                
                {(formData.q4_1 || []).map((news, idx) => (
                  <div key={idx} className="list-item-card">
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem', marginBottom: '0.8rem' }}>
                      <div>
                        <span className="form-label" style={{ fontSize: '0.8rem' }}>{t.fields.q4_1_title_ar}</span>
                        <input type="text" className="input-text" style={{ direction: 'rtl' }} value={news.title_ar || ''} onChange={(e) => {
                          const updated = [...formData.q4_1];
                          updated[idx].title_ar = e.target.value;
                          handleInputChange('q4_1', updated);
                        }} />
                      </div>
                      <div>
                        <span className="form-label" style={{ fontSize: '0.8rem' }}>{t.fields.q4_1_title_fr}</span>
                        <input type="text" className="input-text" value={news.title_fr || ''} onChange={(e) => {
                          const updated = [...formData.q4_1];
                          updated[idx].title_fr = e.target.value;
                          handleInputChange('q4_1', updated);
                        }} />
                      </div>
                    </div>
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem', marginBottom: '0.8rem' }}>
                      <div>
                        <span className="form-label" style={{ fontSize: '0.8rem' }}>{t.fields.q4_1_content_ar}</span>
                        <textarea className="input-textarea" style={{ direction: 'rtl', minHeight: '60px' }} value={news.content_ar || ''} onChange={(e) => {
                          const updated = [...formData.q4_1];
                          updated[idx].content_ar = e.target.value;
                          handleInputChange('q4_1', updated);
                        }} />
                      </div>
                      <div>
                        <span className="form-label" style={{ fontSize: '0.8rem' }}>{t.fields.q4_1_content_fr}</span>
                        <textarea className="input-textarea" style={{ minHeight: '60px' }} value={news.content_fr || ''} onChange={(e) => {
                          const updated = [...formData.q4_1];
                          updated[idx].content_fr = e.target.value;
                          handleInputChange('q4_1', updated);
                        }} />
                      </div>
                    </div>
                    <div>
                      <span className="form-label" style={{ fontSize: '0.8rem' }}>{t.fields.q4_1_image}</span>
                      <input 
                        type="text" 
                        className="input-text" 
                        placeholder={lang === 'fr' ? "Ex: https://drive.google.com/... (Lien de l'image)" : "مثال: https://drive.google.com/... (رابط الصورة)"} 
                        value={news.image || ''} 
                        onChange={(e) => {
                          const updated = [...formData.q4_1];
                          updated[idx].image = e.target.value;
                          handleInputChange('q4_1', updated);
                        }} 
                      />
                    </div>
                    <button className="remove-btn" onClick={() => {
                      const updated = formData.q4_1.filter((_, i) => i !== idx);
                      handleInputChange('q4_1', updated);
                    }}>{t.removeBtn}</button>
                  </div>
                ))}
                <button className="add-btn" onClick={() => {
                  handleInputChange('q4_1', [...(formData.q4_1 || []), { title_ar: '', title_fr: '', content_ar: '', content_fr: '', image: '' }]);
                }}>+ {t.addBtn}</button>
              </div>

              {/* Q4.2 Photos galerie */}
              <div className="form-group">
                <span className="form-label">{t.fields.q4_2}</span>
                <div className="tag-container">
                  <span className="badge badge-optional">{t.optionalTag}</span>
                  <span className="badge badge-file">{t.fileTag}</span>
                </div>
                {(formData.q4_2 || []).map((url, idx) => (
                  <div key={idx} className="list-item-card" style={{ display: 'flex', alignItems: 'center', gap: '1rem', marginBottom: '0.5rem' }}>
                    <input 
                      type="text" 
                      className="input-text" 
                      placeholder={lang === 'fr' ? "Ex: https://drive.google.com/... (Lien photo)" : "مثال: https://drive.google.com/... (رابط الصورة)"} 
                      value={url || ''} 
                      onChange={(e) => {
                        const updated = [...formData.q4_2];
                        updated[idx] = e.target.value;
                        handleInputChange('q4_2', updated);
                      }} 
                    />
                    <button className="remove-btn" style={{ margin: 0 }} onClick={() => {
                      const updated = formData.q4_2.filter((_, i) => i !== idx);
                      handleInputChange('q4_2', updated);
                    }}>{t.removeBtn}</button>
                  </div>
                ))}
                <button className="add-btn" onClick={() => {
                  handleInputChange('q4_2', [...(formData.q4_2 || []), '']);
                }}>+ {t.addBtn}</button>
              </div>

              {/* Q4.3 YouTube URLs (Dynamic List) */}
              <div className="form-group">
                <span className="form-label">{t.fields.q4_3}</span>
                {(formData.q4_3 || []).map((item, idx) => (
                  <div key={idx} className="list-item-card" style={{ display: 'flex', alignItems: 'center', gap: '1rem' }}>
                    <input type="text" className="input-text" placeholder={t.fields.q4_3_url} value={item.url || ''} onChange={(e) => {
                      const updated = [...formData.q4_3];
                      updated[idx].url = e.target.value;
                      handleInputChange('q4_3', updated);
                    }} />
                    <button className="remove-btn" style={{ margin: 0 }} onClick={() => {
                      const updated = formData.q4_3.filter((_, i) => i !== idx);
                      handleInputChange('q4_3', updated);
                    }}>{t.removeBtn}</button>
                  </div>
                ))}
                <button className="add-btn" onClick={() => {
                  handleInputChange('q4_3', [...(formData.q4_3 || []), { url: '' }]);
                }}>+ {t.addBtn}</button>
              </div>

              {/* Q4.5 Press kit ZIP/PDF */}
              <div className="form-group">
                <span className="form-label">{t.fields.q4_5}</span>
                <div className="tag-container">
                  <span className="badge badge-optional">{t.optionalTag}</span>
                  <span className="badge badge-file">{t.fileTag}</span>
                </div>
                <input 
                  type="text" 
                  className="input-text" 
                  placeholder={lang === 'fr' ? "Ex: https://drive.google.com/... (Lien Dossier Presse)" : "مثال: https://drive.google.com/... (رابط الملف الصحفي)"} 
                  value={formData.q4_5} 
                  onChange={(e) => handleInputChange('q4_5', e.target.value)} 
                />
              </div>
            </div>
          )}

          {/* Step 5: FORMULAIRE INSCRIPTION */}
          {currentStep === 5 && (
            <div>
              <div className="step-title-section">
                <div className="step-number">5</div>
                <h2>{t.sections.s5}</h2>
              </div>

              {/* Q5.6 Inscription intro */}
              <div className="form-group">
                <span className="form-label">{t.fields.q5_6_ar}</span>
                <textarea className="input-textarea" style={{ direction: 'rtl' }} value={formData.q5_6_ar} onChange={(e) => handleInputChange('q5_6_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q5_6_fr}</span>
                <textarea className="input-textarea" value={formData.q5_6_fr} onChange={(e) => handleInputChange('q5_6_fr', e.target.value)} />
              </div>

              {/* Q5.1 Checkbox fields */}
              <div className="form-group">
                <span className="form-label">{t.fields.q5_1}</span>
                <p className="form-hint">{t.fields.q5_1_opts}</p>
                <div className="checkbox-grid">
                  {registrationFields.map((field) => (
                    <label key={field.key} className="checkbox-label">
                      <input 
                        type="checkbox" 
                        className="checkbox-input"
                        checked={(formData.q5_1 || []).includes(field.key)}
                        onChange={() => handleCheckboxChange('q5_1', field.key)}
                      />
                      <span>{lang === 'fr' ? field.labelFr : field.labelAr}</span>
                    </label>
                  ))}
                </div>
              </div>

              {/* Q5.2 Checkbox interests */}
              <div className="form-group" style={{ borderTop: '1px solid rgba(255,255,255,0.05)', paddingTop: '1.5rem' }}>
                <span className="form-label">{t.fields.q5_2}</span>
                <p className="form-hint">{t.fields.q5_2_opts}</p>
                <div className="checkbox-grid">
                  {interestOptions.map((opt) => (
                    <label key={opt.key} className="checkbox-label">
                      <input 
                        type="checkbox" 
                        className="checkbox-input"
                        checked={(formData.q5_2 || []).includes(opt.key)}
                        onChange={() => handleCheckboxChange('q5_2', opt.key)}
                      />
                      <span>{lang === 'fr' ? opt.labelFr : opt.labelAr}</span>
                    </label>
                  ))}
                </div>
              </div>

              {/* Q5.3 Secteurs economiques list (Dynamic list) */}
              <div className="form-group" style={{ borderTop: '1px solid rgba(255,255,255,0.05)', paddingTop: '1.5rem' }}>
                <span className="form-label">{t.fields.q5_3}</span>
                {(formData.q5_3 || []).map((item, idx) => (
                  <div key={idx} className="list-item-card" style={{ display: 'flex', alignItems: 'center', gap: '1rem' }}>
                    <input type="text" className="input-text" placeholder={t.fields.q5_3_sector} value={item.sector || ''} onChange={(e) => {
                      const updated = [...formData.q5_3];
                      updated[idx].sector = e.target.value;
                      handleInputChange('q5_3', updated);
                    }} />
                    <button className="remove-btn" style={{ margin: 0 }} onClick={() => {
                      const updated = formData.q5_3.filter((_, i) => i !== idx);
                      handleInputChange('q5_3', updated);
                    }}>{t.removeBtn}</button>
                  </div>
                ))}
                <button className="add-btn" onClick={() => {
                  handleInputChange('q5_3', [...(formData.q5_3 || []), { sector: '' }]);
                }}>+ {t.addBtn}</button>
              </div>

              {/* Q5.4 Conditions participation */}
              <div className="form-group">
                <span className="form-label">{t.fields.q5_4_ar}</span>
                <textarea className="input-textarea" style={{ direction: 'rtl' }} value={formData.q5_4_ar} onChange={(e) => handleInputChange('q5_4_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q5_4_fr}</span>
                <textarea className="input-textarea" value={formData.q5_4_fr} onChange={(e) => handleInputChange('q5_4_fr', e.target.value)} />
              </div>

              {/* Q5.5 Success message */}
              <div className="form-group">
                <span className="form-label">{t.fields.q5_5_msg_ar}</span>
                <input type="text" className="input-text" style={{ direction: 'rtl' }} value={formData.q5_5_msg_ar} onChange={(e) => handleInputChange('q5_5_msg_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q5_5_msg_fr}</span>
                <input type="text" className="input-text" value={formData.q5_5_msg_fr} onChange={(e) => handleInputChange('q5_5_msg_fr', e.target.value)} />
              </div>
            </div>
          )}

          {/* Step 6: TEXTES LEGAUX */}
          {currentStep === 6 && (
            <div>
              <div className="step-title-section">
                <div className="step-number">6</div>
                <h2>{t.sections.s6}</h2>
              </div>

              {/* Q6.1 Confidentialite */}
              <div className="form-group">
                <span className="form-label">{t.fields.q6_1_ar}</span>
                <textarea className="input-textarea" style={{ direction: 'rtl' }} disabled={formData.q6_1_use_default} value={formData.q6_1_ar} onChange={(e) => handleInputChange('q6_1_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q6_1_fr}</span>
                <textarea className="input-textarea" disabled={formData.q6_1_use_default} value={formData.q6_1_fr} onChange={(e) => handleInputChange('q6_1_fr', e.target.value)} />
              </div>
              <div className="form-group">
                <label className="checkbox-label" style={{ background: 'rgba(255,255,255,0.02)' }}>
                  <input type="checkbox" className="checkbox-input" checked={formData.q6_1_use_default} onChange={(e) => handleInputChange('q6_1_use_default', e.target.checked)} />
                  <span>{t.fields.q6_1_use_default}</span>
                </label>
              </div>

              {/* Q6.2 CGU */}
              <div className="form-group" style={{ borderTop: '1px solid rgba(255,255,255,0.05)', paddingTop: '1.5rem' }}>
                <span className="form-label">{t.fields.q6_2_ar}</span>
                <textarea className="input-textarea" style={{ direction: 'rtl' }} disabled={formData.q6_2_use_default} value={formData.q6_2_ar} onChange={(e) => handleInputChange('q6_2_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q6_2_fr}</span>
                <textarea className="input-textarea" disabled={formData.q6_2_use_default} value={formData.q6_2_fr} onChange={(e) => handleInputChange('q6_2_fr', e.target.value)} />
              </div>
              <div className="form-group">
                <label className="checkbox-label" style={{ background: 'rgba(255,255,255,0.02)' }}>
                  <input type="checkbox" className="checkbox-input" checked={formData.q6_2_use_default} onChange={(e) => handleInputChange('q6_2_use_default', e.target.checked)} />
                  <span>{t.fields.q6_2_use_default}</span>
                </label>
              </div>

              {/* Q6.3 Mentions legales details */}
              <div className="form-group" style={{ borderTop: '1px solid rgba(255,255,255,0.05)', paddingTop: '1.5rem' }}>
                <span className="form-label">{t.fields.q6_3_legal_name}</span>
                <input type="text" className="input-text" value={formData.q6_3_legal_name} onChange={(e) => handleInputChange('q6_3_legal_name', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q6_3_hq}</span>
                <input type="text" className="input-text" value={formData.q6_3_hq} onChange={(e) => handleInputChange('q6_3_hq', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q6_3_reg_num}</span>
                <input type="text" className="input-text" value={formData.q6_3_reg_num} onChange={(e) => handleInputChange('q6_3_reg_num', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q6_3_director}</span>
                <input type="text" className="input-text" value={formData.q6_3_director} onChange={(e) => handleInputChange('q6_3_director', e.target.value)} />
              </div>

              {/* Q6.4 Domain et Host */}
              <div className="form-group" style={{ borderTop: '1px solid rgba(255,255,255,0.05)', paddingTop: '1.5rem' }}>
                <span className="form-label">{t.fields.q6_4_domain}</span>
                <input type="text" className="input-text" placeholder="www.idmadj.dz" value={formData.q6_4_domain} onChange={(e) => handleInputChange('q6_4_domain', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q6_4_purchased}</span>
                <div style={{ display: 'flex', gap: '2rem', marginTop: '0.5rem' }}>
                  <label style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', cursor: 'pointer' }}>
                    <input type="radio" name="purchased" checked={formData.q6_4_purchased === 'yes'} onChange={() => handleInputChange('q6_4_purchased', 'yes')} />
                    <span>{t.fields.q6_4_purchased_yes}</span>
                  </label>
                  <label style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', cursor: 'pointer' }}>
                    <input type="radio" name="purchased" checked={formData.q6_4_purchased === 'no'} onChange={() => handleInputChange('q6_4_purchased', 'no')} />
                    <span>{t.fields.q6_4_purchased_no}</span>
                  </label>
                </div>
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q6_4_host}</span>
                <input type="text" className="input-text" value={formData.q6_4_host} onChange={(e) => handleInputChange('q6_4_host', e.target.value)} />
              </div>
            </div>
          )}

          {/* Step 7: BACK OFFICE & EMAILS */}
          {currentStep === 7 && (
            <div>
              <div className="step-title-section">
                <div className="step-number">7</div>
                <h2>{t.sections.s7}</h2>
              </div>

              {/* Q7.1 Access Back Office (Dynamic List) */}
              <div className="form-group">
                <span className="form-label">{t.fields.q7_1}</span>
                {(formData.q7_1 || []).map((admin, idx) => (
                  <div key={idx} className="list-item-card">
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem', marginBottom: '0.5rem' }}>
                      <div>
                        <span className="form-label" style={{ fontSize: '0.8rem' }}>{t.fields.q7_1_name}</span>
                        <input type="text" className="input-text" value={admin.name || ''} onChange={(e) => {
                          const updated = [...formData.q7_1];
                          updated[idx].name = e.target.value;
                          handleInputChange('q7_1', updated);
                        }} />
                      </div>
                      <div>
                        <span className="form-label" style={{ fontSize: '0.8rem' }}>{t.fields.q7_1_email}</span>
                        <input type="email" className="input-text" value={admin.email || ''} onChange={(e) => {
                          const updated = [...formData.q7_1];
                          updated[idx].email = e.target.value;
                          handleInputChange('q7_1', updated);
                        }} />
                      </div>
                    </div>
                    <button className="remove-btn" onClick={() => {
                      const updated = formData.q7_1.filter((_, i) => i !== idx);
                      handleInputChange('q7_1', updated);
                    }}>{t.removeBtn}</button>
                  </div>
                ))}
                <button className="add-btn" onClick={() => {
                  handleInputChange('q7_1', [...(formData.q7_1 || []), { name: '', email: '' }]);
                }}>+ {t.addBtn}</button>
              </div>

              {/* Q7.2 Email expéditeur */}
              <div className="form-group" style={{ borderTop: '1px solid rgba(255,255,255,0.05)', paddingTop: '1.5rem' }}>
                <span className="form-label">{t.fields.q7_2}</span>
                <input type="text" className="input-text" value={formData.q7_2} onChange={(e) => handleInputChange('q7_2', e.target.value)} />
              </div>

              {/* Q7.3 Confirmation Email bilingue */}
              <div className="form-group">
                <span className="form-label">{t.fields.q7_3_subject_ar}</span>
                <input type="text" className="input-text" style={{ direction: 'rtl' }} value={formData.q7_3_subject_ar} onChange={(e) => handleInputChange('q7_3_subject_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q7_3_subject_fr}</span>
                <input type="text" className="input-text" value={formData.q7_3_subject_fr} onChange={(e) => handleInputChange('q7_3_subject_fr', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q7_3_body_ar}</span>
                <textarea className="input-textarea" style={{ direction: 'rtl' }} value={formData.q7_3_body_ar} onChange={(e) => handleInputChange('q7_3_body_ar', e.target.value)} />
              </div>
              <div className="form-group">
                <span className="form-label">{t.fields.q7_3_body_fr}</span>
                <textarea className="input-textarea" value={formData.q7_3_body_fr} onChange={(e) => handleInputChange('q7_3_body_fr', e.target.value)} />
              </div>

              {/* Q7.4 Autres besoins */}
              <div className="form-group" style={{ borderTop: '1px solid rgba(255,255,255,0.05)', paddingTop: '1.5rem' }}>
                <span className="form-label">{t.fields.q7_4_ar}</span>
                <textarea className="input-textarea" placeholder={t.fields.q7_4_fr} value={formData.q7_4_ar} onChange={(e) => handleInputChange('q7_4_ar', e.target.value)} />
              </div>
            </div>
          )}

          {/* ── BUTTONS BAR ── */}
          <div className="navigation-bar">
            {currentStep > 0 ? (
              <button className="nav-btn nav-btn-prev" onClick={() => setCurrentStep(prev => prev - 1)}>
                {lang === 'ar' ? '←' : '←'} {t.prevBtn}
              </button>
            ) : (
              <div></div>
            )}

            {currentStep < 7 ? (
              <button className="nav-btn nav-btn-next" onClick={() => setCurrentStep(prev => prev + 1)}>
                {t.nextBtn} {lang === 'ar' ? '←' : '→'}
              </button>
            ) : (
              <button className="nav-btn nav-btn-submit" disabled={submitting} onClick={submitForm}>
                {submitting ? <span className="spinner"></span> : null}
                {t.submitBtn}
              </button>
            )}
          </div>
        </div>
      </main>

      {/* ── FOOTER ── */}
      <footer className="doc-footer">
        <p><strong>IDMADJ.DZ — {lang === 'fr' ? 'Collecte de Contenus (Nouveau CDC)' : 'جمع المحتويات (دفتر الشروط الجديد)'}</strong></p>
        <p>{lang === 'fr' ? 'Version interactive pour le développement de la plateforme' : 'النسخة التفاعلية لإنجاز المنصة الإلكترونية'}</p>
        <p style={{ marginTop: '0.5rem', color: 'var(--text-light)', fontSize: '0.75rem' }}>© 2026 IDMADJ.DZ — All rights reserved.</p>
      </footer>
    </div>
  );
}
