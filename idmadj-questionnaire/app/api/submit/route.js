import { Resend } from 'resend';

export async function POST(request) {
  try {
    const data = await request.json();

    console.log("Form Submission Received:", JSON.stringify(data, null, 2));

    // Determine target email for notifications
    const targetEmail = process.env.NOTIFICATION_EMAIL || 'aouamri.anis@gmail.com'; // Default or fallback
    const resendApiKey = process.env.RESEND_API_KEY;

    let emailSent = false;
    let emailMessage = '';

    if (resendApiKey && resendApiKey !== 're_123456789') {
      const resend = new Resend(resendApiKey);

      // Construct a clean HTML body summarizing all submissions
      let htmlContent = `
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; color: #333;">
          <h2 style="color: #0ea5e9; border-bottom: 2px solid #0ea5e9; padding-bottom: 10px;">
            Nouvelle Soumission Questionnaire IDMADJ.DZ
          </h2>
          <p>Une nouvelle soumission a été reçue le <strong>${new Date().toLocaleString()}</strong>.</p>
          
          <h3 style="background-color: #f1f5f9; padding: 8px; border-radius: 4px; color: #1e293b;">
            Résumé des Données Soumises
          </h3>
      `;

      // Helper to generate section summaries
      const generateSectionHtml = (sectionKey, sectionTitle, fields) => {
        let sectionHtml = `
          <h4 style="color: #6366f1; margin-top: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px;">
            ${sectionTitle}
          </h4>
          <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 14px;">
        `;

        for (const [key, label] of Object.entries(fields)) {
          const value = data[key];
          let displayValue = '<em>Non renseigné</em>';

          if (value !== undefined && value !== '') {
            if (Array.isArray(value)) {
              if (value.length === 0) {
                displayValue = '<em>Aucun élément</em>';
              } else if (typeof value[0] === 'object') {
                // List of items (e.g. Sponsors, Events)
                displayValue = `<ul style="margin: 0; padding-left: 20px;">`;
                value.forEach((item, idx) => {
                  const itemParts = [];
                  for (const [k, v] of Object.entries(item)) {
                    if (v && v.startsWith('http')) {
                      itemParts.push(`<strong>${k}</strong>: <a href="${v}" target="_blank">Lien Fichier</a>`);
                    } else if (v) {
                      itemParts.push(`<strong>${k}</strong>: ${v}`);
                    }
                  }
                  displayValue += `<li style="margin-bottom: 5px;">${itemParts.join(' | ')}</li>`;
                });
                displayValue += `</ul>`;
              } else {
                // Array of strings (e.g. selected checkboxes)
                displayValue = value.join(', ');
              }
            } else if (typeof value === 'boolean') {
              displayValue = value ? 'Oui' : 'Non';
            } else if (typeof value === 'string' && value.startsWith('http')) {
              displayValue = `<a href="${value}" target="_blank" style="color: #0ea5e9; font-weight: bold;">Lien Fichier</a>`;
            } else {
              displayValue = String(value).replace(/\n/g, '<br/>');
            }
          }

          sectionHtml += `
            <tr style="border-bottom: 1px solid #f1f5f9;">
              <td style="padding: 6px; width: 40%; font-weight: bold; color: #475569; vertical-align: top;">${label}</td>
              <td style="padding: 6px; width: 60%; color: #0f172a; vertical-align: top;">${displayValue}</td>
            </tr>
          `;
        }

        sectionHtml += `</table>`;
        return sectionHtml;
      };

      // Map sections based on translations key mapping
      const s0_fields = {
        q0_1: "Logo de l'événement",
        q0_2: "Logo de l'organisateur",
        q0_3_ar: "Nom officiel AR",
        q0_3_fr: "Nom officiel FR",
        q0_4_ar: "Slogan AR",
        q0_4_fr: "Slogan FR",
        q0_5_main_date: "Date événement principal",
        q0_5_main_place: "Lieu principal",
        q0_5_period: "Période globale",
        q0_5_ouargla: "Ouargla Date & Lieu",
        q0_5_annaba: "Annaba Date & Lieu",
        q0_5_oran: "Oran Date & Lieu",
        q0_6: "Charte graphique PDF",
        q0_7_participants: "Nb participants",
        q0_7_ateliers: "Nb ateliers",
        q0_7_seminaires: "Nb séminaires régionaux",
        q0_7_entreprises: "Nb entreprises ciblées",
        q0_8_fb: "Facebook",
        q0_8_in: "LinkedIn",
        q0_8_tw: "Twitter",
        q0_8_yt: "YouTube",
        q0_9_address: "Adresse postale",
        q0_9_phone: "Téléphone",
        q0_9_email: "Email principal",
        q0_9_reg_email: "Email inscriptions",
        q0_10: "Liste des sponsors"
      };

      const s1_fields = {
        q1_1_ar: "Hero titre AR",
        q1_1_fr: "Hero titre FR",
        q1_2_ar: "Hero sous-titre AR",
        q1_2_fr: "Hero sous-titre FR",
        q1_3: "Hero image fond",
        q1_4_ar: "CTA texte AR",
        q1_4_fr: "CTA texte FR",
        q1_5_nav_1_ar: "Nav 1 AR", q1_5_nav_1_fr: "Nav 1 FR",
        q1_5_nav_2_ar: "Nav 2 AR", q1_5_nav_2_fr: "Nav 2 FR",
        q1_5_nav_3_ar: "Nav 3 AR", q1_5_nav_3_fr: "Nav 3 FR",
        q1_5_nav_4_ar: "Nav 4 AR", q1_5_nav_4_fr: "Nav 4 FR",
        q1_5_nav_5_ar: "Nav 5 AR", q1_5_nav_5_fr: "Nav 5 FR",
        q1_6_ar: "Footer copyright AR",
        q1_6_fr: "Footer copyright FR",
        q1_7_ar: "Hero bienvenue AR",
        q1_7_fr: "Hero bienvenue FR",
        q1_8: "Vidéo promo URL"
      };

      const s2_fields = {
        q2_1_ar: "Présentation IDMADJ AR",
        q2_1_fr: "Présentation IDMADJ FR",
        q2_2: "Liste des objectifs",
        q2_3_ar: "Impact attendu AR",
        q2_3_fr: "Impact attendu FR",
        q2_4_ar: "Présentation organisateur AR",
        q2_4_fr: "Présentation organisateur FR",
        q2_5: "Photos d'illustrations À propos",
        q2_6_txt_ar: "Mot du président AR",
        q2_6_txt_fr: "Mot du président FR",
        q2_6_photo: "Photo du président"
      };

      const s3_fields = {
        q3_1: "Timeline journée ouverture",
        q3_2_ouargla_theme: "Séminaire Ouargla thématique",
        q3_2_annaba_theme: "Séminaire Annaba thématique",
        q3_2_oran_theme: "Séminaire Oran thématique",
        q3_3_hack_desc: "Hackathon thématiques",
        q3_4_closing: "Programme clôture",
        q3_5: "Programme PDF complet",
        q3_6_ar: "Intro programme AR",
        q3_6_fr: "Intro programme FR"
      };

      const s4_fields = {
        q4_1: "Actualités / communiqués initiaux",
        q4_2: "Photos galerie média",
        q4_3: "Vidéos YouTube galerie",
        q4_4_ar: "Intro presse AR",
        q4_4_fr: "Intro presse FR",
        q4_5: "Dossier de presse (Press Kit) ZIP/PDF"
      };

      const s5_fields = {
        q5_1: "Champs requis inscription unifiée",
        q5_2: "Centres d'intérêt inclus",
        q5_3: "Liste des secteurs économiques",
        q5_4_ar: "Conditions de participation AR",
        q5_4_fr: "Conditions de participation FR",
        q5_5_msg_ar: "Message succès écran AR",
        q5_5_msg_fr: "Message succès écran FR",
        q5_6_ar: "Intro inscription AR",
        q5_6_fr: "Intro inscription FR"
      };

      const s6_fields = {
        q6_1_ar: "Politique confidentialité AR",
        q6_1_fr: "Politique confidentialité FR",
        q6_1_use_default: "Utiliser confidentialité standard",
        q6_2_ar: "CGU AR",
        q6_2_fr: "CGU FR",
        q6_2_use_default: "Utiliser CGU standard",
        q6_3_legal_name: "Nom légal organisme",
        q6_3_hq: "Siège social",
        q6_3_reg_num: "N° agrément",
        q6_3_director: "Directeur publication",
        q6_4_domain: "Nom domaine souhaité",
        q6_4_purchased: "Domaine déjà acheté",
        q6_4_host: "Hébergement"
      };

      const s7_fields = {
        q7_1: "Liste admins",
        q7_2: "Email expéditeur souhaité",
        q7_3_subject_ar: "Objet email confirmation AR",
        q7_3_subject_fr: "Objet email confirmation FR",
        q7_3_body_ar: "Corps email confirmation AR",
        q7_3_body_fr: "Corps email confirmation FR",
        q7_4_ar: "Autres besoins / emails"
      };

      htmlContent += generateSectionHtml("s0", "0. Informations Générales & Identité Visuelle", s0_fields);
      htmlContent += generateSectionHtml("s1", "1. Section Accueil (Hero & Navigation)", s1_fields);
      htmlContent += generateSectionHtml("s2", "2. Section À propos", s2_fields);
      htmlContent += generateSectionHtml("s3", "3. Section Programme", s3_fields);
      htmlContent += generateSectionHtml("s4", "4. Section Centre de presse", s4_fields);
      htmlContent += generateSectionHtml("s5", "5. Formulaire d'inscription unifié", s5_fields);
      htmlContent += generateSectionHtml("s6", "6. Rédactions & Textes légaux", s6_fields);
      htmlContent += generateSectionHtml("s7", "7. Back Office & Emails", s7_fields);

      htmlContent += `
          <div style="margin-top: 30px; padding: 15px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; font-size: 11px; color: #64748b; text-align: center;">
            Cet email a été généré automatiquement depuis la plateforme interactive de questionnaire IDMADJ.DZ.
          </div>
        </div>
      `;

      const response = await resend.emails.send({
        from: 'Questionnaire IDMADJ <onboarding@resend.dev>', // Resend sandbox default sender
        to: targetEmail,
        subject: `Soumission IDMADJ — ${data.q0_3_fr || 'Nouveau Client'}`,
        html: htmlContent,
      });

      if (response.error) {
        console.error("Resend API error:", response.error);
        emailSent = false;
        emailMessage = `Erreur Resend : ${response.error.message}`;
      } else {
        console.log("Email sent successfully via Resend:", response.data);
        emailSent = true;
        emailMessage = 'Email envoyé avec succès !';
      }
    } else {
      console.warn("RESEND_API_KEY is not configured or is default. Skipping email delivery.");
      emailMessage = 'Sauvegardé localement (Configuration Resend manquante)';
    }

    return Response.json({
      success: true,
      message: 'Soumission enregistrée avec succès !',
      emailSent: emailSent,
      emailDetails: emailMessage
    });
  } catch (error) {
    console.error('Submission processing error:', error);
    return Response.json({ error: error.message }, { status: 500 });
  }
}
