# 🚀 Guide de Déploiement du Projet IDMAJ (Sur Hébergement Web / cPanel)

Ce guide récapitule les étapes simples pour déployer l'intégralité du site **IDMAJ 2026** sur votre serveur d'hébergement web (cPanel, Plesk, VPS, etc.).

---

## 📁 1. Transférer les Fichiers sur le Serveur
Uploadez l'ensemble des fichiers du dossier `website/` vers le dossier racine de votre hébergement (généralement `public_html/` ou `www/`).

---

## 🗄️ 2. Configurer la Base de Données
1. Créez une nouvelle base de données MySQL sur votre hébergeur (ex: `idmadj_db`).
2. Créez un utilisateur MySQL avec son mot de passe et attribuez-lui tous les privilèges sur la base de données.
3. Ouvrez le fichier **`includes/db.php`** sur le serveur et renseignez les identifiants :
   ```php
   $host = 'localhost';          // Serveur MySQL de l'hébergeur
   $db   = 'nom_de_votre_bdd';    // Nom de la BDD
   $user = 'utilisateur_bdd';    // Nom d'utilisateur MySQL
   $pass = 'mot_de_passe_bdd';   // Mot de passe MySQL
   ```
4. Exécutez l'installateur automatique dans votre navigateur :
   👉 `https://votre-domaine.com/db_setup.php`
   *(Ce script crée automatiquement toutes les tables MySQL nécessaires et le compte admin de départ).*

---

## ✉️ 3. Configurer l'Envoi des Emails SMTP
Ouvrez le fichier **`includes/mail_config.php`** et configurez vos accès de messagerie :

```php
define('SMTP_ENABLED', true);
define('SMTP_HOST', 'mail.votre-domaine.com'); // Hôte SMTP de votre hébergeur
define('SMTP_PORT', 465);                       // Port 465 (SSL) ou 587 (TLS)
define('SMTP_AUTH', true);                      // Authentification activée
define('SMTP_USER', 'contact@idmadj.dz');       // Adresse email
define('SMTP_PASS', 'mot_de_passe_email');      // Mot de passe email
define('SMTP_SECURE', 'ssl');                   // 'ssl' ou 'tls'

define('ADMIN_NOTIFY_EMAIL', 'contact@idmadj.dz');
```

---

## 🔑 4. Accès à la Le panneau d'administration (Admin Panel)
- **URL Admin** : `https://votre-domaine.com/admin/`
- **Nom d'utilisateur** : `admin`
- **Mot de passe** : `password123`
*(Il est recommandé de modifier ce mot de passe une fois connecté).*

---

## 🔒 5. Sécurité après installation
Une fois l'installation terminée avec succès :
- Supprimez le fichier `db_setup.php` du serveur pour des raisons de sécurité.

---

## ⚡ 6. Déploiement Automatique à chaque `git push` sur Hostinger

Il existe **2 méthodes** pour synchroniser automatiquement le site dès que vous faites un `git push`.

### 📌 Option A : GitHub Actions via FTP (Recommandé - Déjà configuré dans le projet)
Un fichier de workflow [deploy.yml](file:///c:/wamp64/www/IDMAJ/.github/workflows/deploy.yml) a été créé dans le projet.

1. **Trouver vos accès FTP sur Hostinger** :
   - Dans Hostinger hPanel, allez dans **Fichiers > Comptes FTP**.
   - Notez le **Hôte FTP**, l'**Utilisateur FTP** et le **Mot de passe**.
2. **Ajouter les Secrets dans GitHub** :
   - Allez sur votre dépôt GitHub.
   - Allez dans **Settings > Secrets and variables > Actions**.
   - Cliquez sur **New repository secret** et ajoutez ces 3 variables :
     - `FTP_SERVER` : (ex: `ftp.votre-domaine.com` ou l'adresse IP Hostinger)
     - `FTP_USERNAME` : (votre identifiant FTP Hostinger)
     - `FTP_PASSWORD` : (votre mot de passe FTP Hostinger)
3. **Tester** :
   - À chaque `git push` sur la branche `main`, GitHub envoie automatiquement les fichiers mis à jour dans le dossier `public_html/`.

---

### 📌 Option B : Webhook Git Natif d'Hostinger (Sans GitHub Actions)
1. Dans Hostinger **hPanel**, allez dans la section **Git** (dans le menu latéral).
2. Entrez l'URL de votre dépôt GitHub (ex: `https://github.com/votre-compte/IDMAJ.git`), la branche (`main`) et le répertoire cible (`public_html`).
3. Cliquez sur **Créer**.
4. Copiez l'**URL du Webhook de Déploiement Automatique** générée par Hostinger.
5. Allez sur **GitHub** > **Settings** > **Webhooks** > **Add webhook** :
   - **Payload URL** : Collez l'URL de Hostinger.
   - **Content type** : `application/json`.
   - Cliquez sur **Add webhook**.

