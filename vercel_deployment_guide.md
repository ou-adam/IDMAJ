# Guide de Déploiement Vercel — Questionnaire Interactif IDMADJ

Ce document explique comment déployer l'application interactive de questionnaire sur Vercel, et comment connecter les services de stockage (Vercel Blob) et d'emails (Resend).

---

## Étape 1 : Préparation du Projet

Le projet a été créé dans le sous-dossier `idmadj-questionnaire`.
Vous pouvez le pousser sur un dépôt GitHub (ex: `idmadj-questionnaire`), ou utiliser la CLI Vercel pour le déployer directement depuis votre machine.

Pour initialiser Git et le lier à GitHub :
```bash
cd idmadj-questionnaire
git init
git add .
git commit -m "Initial commit - questionnaire interactif"
# Créez ensuite un dépôt sur GitHub et associez-le :
git remote add origin <VOTRE_DEPOT_URL>
git branch -M main
git push -u origin main
```

---

## Étape 2 : Déploiement sur Vercel

1. Rendez-vous sur votre tableau de bord [Vercel](https://vercel.com).
2. Cliquez sur **Add New** > **Project**.
3. Importez votre dépôt GitHub `idmadj-questionnaire`.
4. Dans les options de configuration, laissez tout par défaut (Vercel détecte automatiquement Next.js).
5. Cliquez sur **Deploy**.

---

## Étape 3 : Activer Vercel Blob (Stockage des Fichiers)

Pour permettre au client d'uploader des fichiers (logos, PDF) directement depuis le questionnaire :

1. Sur Vercel, allez dans l'onglet **Storage** de votre projet.
2. Sélectionnez **Blob** et cliquez sur **Create Database** (ou **Connect**).
3. Vercel va créer le store Blob et injecter automatiquement la variable d'environnement `BLOB_READ_WRITE_TOKEN` dans votre projet.
4. **Redéployez** le projet pour appliquer les changements (Vercel le fait automatiquement lors d'un nouveau commit, ou vous pouvez déclencher un redeploy manuel depuis l'onglet Deployments).

---

## Étape 4 : Configurer Resend (Notifications par Email)

Pour recevoir les réponses du client par email dès qu'il clique sur "Soumettre" :

1. Créez un compte gratuit sur [Resend](https://resend.com).
2. Allez dans **API Keys** et créez une clé API.
3. Sur votre projet Vercel, allez dans **Settings** > **Environment Variables** et ajoutez les variables suivantes :

| Clé | Valeur | Description |
|-----|--------|-------------|
| `RESEND_API_KEY` | `re_...` | Votre clé API Resend |
| `NOTIFICATION_EMAIL` | `votre-email@domaine.com` | L'adresse email où vous souhaitez recevoir les réponses |

4. Cliquez sur **Save** et redéployez l'application.

> [!NOTE]
> Avec le compte gratuit Resend, vous pouvez envoyer des emails uniquement vers l'adresse email associée à votre compte Resend (ex: votre email de connexion). Pour envoyer vers d'autres adresses, vous devez ajouter et valider votre nom de domaine dans l'onglet **Domains** de Resend.

---

## Étape 5 : Test Local

Pour tester l'application sur votre machine locale avant ou après déploiement :

1. Créez un fichier `.env.local` à la racine de `idmadj-questionnaire/` contenant :
   ```env
   RESEND_API_KEY=votre_cle_resend
   NOTIFICATION_EMAIL=votre_email_de_reception
   ```
2. Lancez le serveur local :
   ```bash
   npm run dev
   ```
3. Ouvrez [http://localhost:3000](http://localhost:3000) dans votre navigateur.
4. Remplissez le formulaire et uploadez des fichiers. Les fichiers seront uploadés sur Vercel Blob si configuré (ou utiliseront un lien fictif/local si absent), et l'email vous sera envoyé via Resend.
