# DEVIS DÉTAILLÉ — PLATEFORME IDMADJ.DZ
### Smart Accel Industrie 4.0 · Édition 2026

---

> [!IMPORTANT]
> **Document confidentiel** — Préparé le 07 Mai 2026 · Valable 30 jours
> Client : Agence Algérienne de Soutien à l'Entrepreneuriat Jeunesse
> Projet : WWW.IDMADJ.DZ · Période : 25 Juin – 24 Septembre 2026

---

## 📋 RÉCAPITULATIF EXÉCUTIF

| Poste | Montant |
|---|---|
| **Phase 1 — MVP (Développement 6 semaines)** | **180 000 DA** |
| **Phase 2 — Module QR Code & Présences** | **120 000 DA** |
| **Douchette de scan QR (matériel)** | **20 000 DA** |
| **ICOSNET VMware VPS — 6 mois** | **84 000 DA** |
| **Emails transactionnels** | **8 000 DA** |
| **Domaine .dz — Frais traitement dossier (NIC-DZ)** | **5 000 DA** |

---

## 🏗️ STRUCTURE PAR PHASE

### ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
### PHASE 1 — MVP · Durée : 6 Semaines
### ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

#### 📅 Semaine 1 — Préparation & Architecture
- Revue complète du cahier des charges IDMADJ
- Collecte des fichiers visuels (logo, charte graphique, contenus)
- Définition de l'identité visuelle (couleurs : bleu foncé, cyan, gris, or)
- Choix et configuration de l'hébergement ICOSNET (VMware VPS)
- Modélisation de la base de données (17 tables)
- Mise en place de l'environnement de développement

**Livrables :** Schéma BDD validé, maquette fil de fer, environnement serveur opérationnel

---

#### 🎨 Semaine 2 — Design & Maquettes
- Design de la page d'accueil (Hero, countdown, stats, sponsors)
- Design de la page Inscription (formulaire adaptatif 8 types)
- Design de la page Programme (Timeline filtrable)
- Design de la page Sponsors/Partenaires
- Validation client (2 cycles de retours inclus)
- Adaptation RTL (Arabe) + LTR (Français)

**Livrables :** Maquettes Figma/HTML des 4 pages principales, approbation client

---

#### ⚙️ Semaines 3-4 — Développement Core
**Front Office (14 pages publiques) :**
- [ ] Page Accueil — Hero + Countdown + KPIs + Sponsors Strip
- [ ] Page À propos d'IDMAJ — contexte, objectifs, cibles
- [ ] Page Programme général — Timeline filtrable, export PDF
- [ ] Page Sponsors — Classement Or/Argent/Bronze + portail
- [ ] Page Partenaires — logos + descriptions + liens
- [ ] Page Séminaires régionaux — carte interactive (4 wilayas)
- [ ] Page B2B & Sous-traitance — formulaire + liste d'opportunités
- [ ] Page Hackathon Dz-Industry Hack — inscription équipes
- [ ] Page 1-Minute Pitch Box — soumission projets
- [ ] Page Podcast IDMAJ Tech DZ 4.0 — player + archives
- [ ] Page Actualités & Centre de presse — articles + SEO
- [ ] Page Ateliers de formation — 5 catégories
- [ ] Page Contact — formulaire 7 motifs + carte
- [ ] Pages légales (x5) — confidentialité, CGU, données

**Back Office — 19 modules :**
- [ ] Tableau de bord (stats globales + graphiques)
- [ ] Gestion des inscriptions (8 types + statuts)
- [ ] Gestion des sponsors + logos
- [ ] Gestion des partenaires
- [ ] Gestion des demandes B2B
- [ ] Gestion du Hackathon (équipes + axes)
- [ ] Gestion Pitch Box (10 projets → 5 finalistes)
- [ ] Gestion Podcast + Médias
- [ ] Gestion des séminaires régionaux
- [ ] Gestion des ateliers
- [ ] Gestion des pages (CMS intégré)
- [ ] Gestion des actualités
- [ ] Gestion de la médiathèque
- [ ] Messages entrants (contact)
- [ ] Export Excel/CSV/PDF
- [ ] Statistiques avancées
- [ ] 7 rôles d'accès (Super Admin → Resp. Médias)
- [ ] Authentification sécurisée (2FA optionnel)
- [ ] Journaux d'activité (Logs)
- [ ] Système de sauvegarde automatique

**Système d'emails automatiques (8 types) :**
- Email 1 : Confirmation d'inscription (déclenché immédiatement)
- Email 2 : Acceptation de participation
- Email 3 : Refus / Demande d'informations complémentaires
- Email 4 : Rappel avant l'événement (J-7, J-1)
- Email 5 : Confirmation B2B
- Email 6 : Instructions Hackathon
- Email 7 : Prospection sponsors
- Email 8 : Remerciement post-événement

**Sécurité (10 mesures obligatoires) :**
- Certificat SSL (HTTPS)
- Connexion admin sécurisée (hash bcrypt)
- Protection Brute Force (rate limiting)
- CAPTCHA sur les formulaires
- Protection SQL Injection, XSS, CSRF
- Contrôle des rôles et permissions
- Journaux d'activité complets
- Sauvegardes automatiques quotidiennes
- Mises à jour de sécurité incluses (pendant 3 mois)
- Validation et sanitisation des uploads

**Livrables semaines 3-4 :** Site fonctionnel en staging, back-office opérationnel, formulaires testés

---

#### 🧪 Semaine 5 — Tests & Corrections
- Tests fonctionnels sur tous les formulaires
- Tests des emails automatiques (envoi + contenu)
- Tests responsive (mobile, tablette, desktop)
- Tests de performance (PageSpeed > 85)
- Tests sécurité (XSS, injection, brute force)
- Corrections des bugs identifiés
- Tests du back-office avec données réelles
- Optimisation SEO de base (meta, sitemap, robots.txt)

**Livrables :** Rapport de tests, liste de bugs corrigés, site prêt pour la production

---

#### 🚀 Semaine 6 — Déploiement & Livraison
- Connexion du domaine IDMADJ.DZ
- Configuration SSL sur le domaine production
- Migration base de données staging → production
- Lancement officiel de la plateforme
- Formation du responsable administrateur (3h)
- Remise des accès (hébergement, admin, base de données)
- Documentation technique (guide d'utilisation)
- 1ère sauvegarde officielle

**Livrables (14 éléments) :**
1. Site en ligne sur WWW.IDMADJ.DZ
2. Back-office complet opérationnel
3. Base de données structurée (17 tables)
4. Formulaires d'inscription fonctionnels (8 types)
5. Système export Excel/CSV
6. Système emailing automatique (8 types)
7. Pages de contenu complètes
8. Design responsive (mobile-first)
9. Certificat SSL actif
10. SEO de base configuré
11. Guide d'utilisation pour l'équipe
12. Comptes administrateurs avec rôles
13. 1ère sauvegarde complète
14. Fichier technique (hébergement, accès)

---

### ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
### PHASE 2 — Module QR Code & Présences
### (Fonctionnalités avancées — à planifier après lancement MVP)
### ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Cette phase active les 10 fonctionnalités avancées identifiées dans le cahier des charges :

| # | Fonctionnalité | Description technique |
|---|---|---|
| 1 | **QR Code par participant** | Génération d'un QR unique par inscription (ID IDMAJ-2026-XXXX) |
| 2 | **Système de présence (Scan QR)** | Scan en temps réel via douchette + interface web admin |
| 3 | **Espace privé participants** | Portail connecté avec badge QR + statut + programme personnalisé |
| 4 | **Matchmaking B2B automatique** | Algorithme de correspondance intelligent entre offres et demandes |
| 5 | **PWA (Progressive Web App)** | Application installable sur mobile sans App Store |
| 6 | **Statistiques avancées** | Tableaux de bord en temps réel + présences par session |
| 7 | **Support bilingue FR/EN** | Interface en 3 langues (AR/FR/EN) |
| 8 | **Archive vidéo & conférences** | Bibliothèque vidéo indexée |
| 9 | **Certificats électroniques** | PDF signé pour chaque participant présent |
| 10 | **Système d'évaluation ateliers** | Formulaires de notation en temps réel |

> [!NOTE]
> Le module QR Code (items 1 & 2) est le cœur de la Phase 2. Il nécessite la douchette de scan décrite ci-dessous et le plan VPS recommandé pour garantir le temps réel.

---

## 📡 DOUCHETTE DE SCAN QR CODE

### Matériel inclus : 1× Lecteur QR Code USB/Bluetooth

| Spec | Détail |
|---|---|
| **Prix unitaire** | **20 000 DA** |
| **Type** | Pistolet scanner 1D/2D (QR Code, DataMatrix, Code 128…) |
| **Connexion** | USB-HID + Bluetooth (dual mode) |
| **Compatibilité** | Windows, Linux, Mac — Plug & Play, aucun driver requis |
| **Distance de lecture** | 5 cm à 50 cm (mode standard) |
| **Utilisation** | Contrôle d'accès aux sessions, enregistrement de présence |
| **Fonctionnement** | La douchette lit le QR → envoie l'ID → la plateforme marque la présence en temps réel |
| **Garantie** | 1 an fabricant |

**Flux de scan :**
```
Douchette scan QR participant
        ↓
Transmission ID (USB-HID ou Bluetooth)
        ↓
Interface web admin (page dédiée scan)
        ↓
API REST → base de données (présence enregistrée < 1 sec)
        ↓
Confirmation visuelle (✅ vert = valide / ❌ rouge = invalide ou déjà scanné)
        ↓
Statistiques temps réel (dashboard admin mis à jour instantanément)
```

> [!TIP]
> Pour les grands événements (+500 participants), il est recommandé d'utiliser 2 douchettes en parallèle sur 2 postes distincts. Le coût serait alors 40 000 DA pour 2 unités.

---

## 🌐 HÉBERGEMENT — ICOSNET (Algérie)

### Pourquoi ICOSNET ?
- **Leader du Cloud et de l'hébergement en Algérie** — 2 datacenters locaux sécurisés
- Datacenter localisé en Algérie — conformité réglementaire obligatoire pour projet institutionnel
- Support technique disponible en Arabe et Français
- Registrar agréé NIC-DZ — peut gérer l'enregistrement du domaine .dz
- Infrastructure hyperconvergée VMware — haute disponibilité professionnelle
- Bande passante illimitée incluse

---

### ✅ PLAN RECOMMANDÉ : VMware VPS ICOSNET

> [!IMPORTANT]
> **C'est le plan obligatoire pour ce projet institutionnel algérien.** Les données doivent être hébergées localement en Algérie conformément à la réglementation.

| Ressource | VMware VPS ICOSNET |
|---|---|
| **Prix** | **84 000 DA / 6 mois** |
| **CPU** | 2 vCores minimum |
| **RAM** | 8 Go minimum |
| **Stockage** | 100 Go SSD |
| **Bande passante** | Illimitée |
| **IP dédiée** | ✅ Oui (localisée en Algérie) |
| **OS** | Ubuntu 22.04 LTS |
| **Datacenter** | Alger, Algérie |
| **Technologie** | VMware (hyperviseur de niveau entreprise) |
| **Registrar NIC-DZ** | ✅ Agréé — peut enregistrer le domaine .dz |

### Pourquoi PAS le Shared Hosting (hébergement mutualisé) ?

| Critère | Shared Hosting | VMware VPS ICOSNET ✅ |
|---|---|---|
| Scan QR temps réel | ❌ Latence imprévisible | ✅ Réponse < 200ms garantie |
| +1000 inscriptions simultanées | ❌ Throttling automatique | ✅ Ressources dédiées |
| Connexions WebSocket (temps réel) | ❌ Bloquées sur shared | ✅ Totalement supportées |
| PHP/Laravel personnalisé | ❌ Limité | ✅ Full control |
| Sauvegardes automatiques | ❌ Payant en option | ✅ Incluses |
| Conformité réglementaire Algérie | ❌ Datacenter étranger | ✅ Datacenter Alger |
| Cron jobs illimités | ❌ Limité | ✅ Illimité |

---

### 🔧 CONFIGURATION VPS RECOMMANDÉE

**Stack technique déployée sur le VPS :**

```
Ubuntu 22.04 LTS
├── Nginx (serveur web haute performance)
├── PHP 8.2 + php-fpm
├── MySQL 8.0 (base de données principale)
├── Redis (cache + sessions temps réel pour scan QR)
├── Supervisor (gestion des queues d'emails)
├── Let's Encrypt (SSL automatique + renouvellement)
├── UFW Firewall (ports 80, 443, 22 uniquement)
└── Cron jobs (sauvegardes quotidiennes, emails programmés)
```

**Pourquoi Redis est critique pour le scan QR ?**

Redis permet de gérer les sessions actives en mémoire (RAM) — ainsi, quand une douchette scanne un QR, la réponse est instantanée sans requête SQL lourde. C'est indispensable pour éviter les doublons de scan et garantir la fiabilité en temps réel.

---

### 📦 OPTIONS ICOSNET COMPLÉMENTAIRES

| Option | Utilité | Prix estimé |
|---|---|---|
| **Backup périodique** | Inclus dans VMware VPS | Inclus |
| **Snapshot manuel** | Avant chaque mise à jour majeure | Inclus |
| **IP dédiée** | Incluse dans le VPS | Inclus |
| **Domaine .dz via ICOSNET** | ICOSNET est Registrar agréé NIC-DZ | Frais traitement : 5 000 DA |

> [!IMPORTANT]
> Le domaine **IDMADJ.DZ** est géré exclusivement par **NIC-DZ** (www.nic.dz). ICOSNET étant un Registrar agréé NIC-DZ, ils peuvent soumettre la demande d'enregistrement à votre place. Les frais de traitement du dossier s'élèvent à **5 000 DA** (unique).

---

### 📧 EMAILS TRANSACTIONNELS — BREVO (ex-Sendinblue)

Pour les 8 types d'emails automatiques, utiliser **Brevo** (service SMTP dédié aux emails transactionnels) :

| Plan Brevo | Détail |
|---|---|
| **Plan Starter** | 20 000 emails/mois |
| **Prix** | ~25 €/mois (~8 000 DA/mois) → ~12 000 DA/an si faible volume |
| **Alternative gratuite** | Brevo Free (300 emails/jour) — suffisant en phase de lancement |
| **Alternative** | Mailgun (~10 000 emails offerts/mois, ~5 $/mois au-delà) |
| **Intégration** | SMTP standard, compatible avec PHP/Laravel/Node |

> [!TIP]
> Pour +1000 participants avec rappels et confirmations, prévoyez environ **5 000 à 10 000 emails** sur la durée du projet. Le plan gratuit Brevo (300 emails/jour) peut suffire en phase de lancement — à upgrader 2 semaines avant l'événement.

---

## 🔒 ASSURANCE & GARANTIES DE DISPONIBILITÉ

### Garanties du VMware VPS ICOSNET :

| Garantie | Niveau |
|---|---|
| **Uptime (disponibilité)** | **99.9%** (SLA ICOSNET) |
| **Downtime max/mois** | ~44 minutes/mois maximum |
| **Sauvegarde automatique** | Périodique (infrastructure VMware) |
| **Support** | Support technique local (AR/FR) |
| **Datacenter** | Algérie — conformité réglementaire |
| **Protection DDoS** | Incluse |
| **Restauration d'urgence** | < 30 minutes depuis dernier snapshot |

### Mesures de sécurité incluses dans le développement :

| Mesure | Impact |
|---|---|
| SSL HTTPS | Données chiffrées en transit |
| Hachage bcrypt des mots de passe | Irrecupérables même si BDD compromise |
| CAPTCHA sur les formulaires | Protection anti-bots et spam |
| Firewall UFW sur le VPS | Ports non-essentiels fermés |
| Sauvegardes quotidiennes automatiques | Restauration possible en cas de panne |
| Journaux d'activité admin | Traçabilité totale des actions |
| Rate limiting | Prévention des attaques par force brute |
| Validation des uploads | Pas de fichiers malveillants |
| Protection SQL Injection / XSS / CSRF | Requêtes sécurisées côté serveur |

> [!IMPORTANT]
> **Garantie de disponibilité pendant l'événement (25 Juin – 24 Sept 2026) :**
> La configuration VPS avec Redis, Nginx et sauvegardes quotidiennes assure une disponibilité optimale pendant toute la durée de l'événement. En cas d'incident critique, la restauration depuis le dernier snapshot est possible en **moins de 30 minutes**.

---

## 💰 RÉCAPITULATIF BUDGÉTAIRE GLOBAL

### Postes Fixes (matériel & hébergement)

| Poste | Durée | Coût (DA) |
|---|---|---|
| Douchette scan QR USB/Bluetooth | Achat unique | **20 000 DA** |
| ICOSNET VMware VPS | 6 mois | **84 000 DA** |
| Domaine IDMADJ.DZ — Frais traitement dossier (NIC-DZ) | Unique | **5 000 DA** |
| Service emailing Brevo Starter | 6 mois | **~8 000 DA** |
| **SOUS-TOTAL Infrastructure** | | **~117 000 DA** |

### Développement (à définir selon accord commercial)

| Phase | Contenu | Durée estimée |
|---|---|---|
| Phase 1 — MVP | 14 pages + back-office 19 modules + 8 emails + sécurité | 6 semaines |
| Phase 2 — QR & Avancé | Module QR + PWA + Matchmaking B2B + Certificats | 3-4 semaines |

---

## 📌 CONDITIONS & MODALITÉS

- **Validité du devis :** 30 jours à compter du 07 Mai 2026
- **Révisions incluses en Phase 1 :** 2 cycles de retours (design + fonctionnel)
- **Support post-livraison :** 1 mois offert après lancement (bugs critiques uniquement)
- **Propriété :** Le client reçoit l'intégralité du code source à la livraison finale
- **Paiement suggéré :** 40% avant démarrage · 30% fin de Phase 1 · 30% fin de Phase 2

---

*Préparé par : Développeur / Équipe technique IDMADJ*
*Date : 07 Mai 2026*
