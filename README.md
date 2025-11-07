# Plugin Google Workspace pour Blesta

Ce plugin permet aux administrateurs de se connecter à leur compte Blesta en utilisant leur compte Google Workspace via OAuth 2.0.

## Fonctionnalités

- Authentification SSO via Google Workspace
- Remplacement optionnel de la page de connexion admin
- Support multilingue (Anglais/Français)

## Prérequis

- Blesta 5.x ou supérieur
- Un compte Google Workspace
- Accès à Google Cloud Console

## Installation

1. Téléchargez ou clonez ce repository
2. Copiez le dossier `google_workspace` dans le répertoire `plugins/` de votre installation Blesta
3. Allez dans l'admin Blesta : **Settings > Company > Plugins**
4. Installez et activez le plugin "Google Workspace"

## Configuration

### 1. Créer un projet Google Cloud

1. Allez sur [Google Cloud Console](https://console.cloud.google.com/)
2. Créez un nouveau projet ou sélectionnez un projet existant
3. Activez l'API Google+ si ce n'est pas déjà fait

### 2. Configurer OAuth 2.0

1. Dans Google Cloud Console, allez dans **APIs & Services > Credentials**
2. Cliquez sur **Create Credentials > OAuth 2.0 Client IDs**
3. Configurez l'écran de consentement OAuth si nécessaire
4. Sélectionnez **Web application** comme type d'application
5. Ajoutez les URI suivants :
   - **Authorized redirect URIs** : `https://votredomaine.com/plugin/google_workspace/callback`
   - Remplacez `votredomaine.com` par votre domaine Blesta

### 3. Configurer le plugin dans Blesta

1. Dans l'admin Blesta, allez dans **Settings > Company > Plugins**
2. Cliquez sur "Manage" pour le plugin Google Workspace
3. Remplissez les champs :
   - **Client ID** : Copiez depuis Google Cloud Console
   - **Client Secret** : Copiez depuis Google Cloud Console
   - **Replace Admin Login Page** : Cochez si vous voulez que la page de connexion admin redirige automatiquement vers Google
4. Sauvegardez les paramètres

## Utilisation

### Connexion admin

Si "Replace Admin Login Page" est activé :
- Allez sur la page admin de Blesta
- Vous serez automatiquement redirigé vers Google pour vous authentifier
- Après authentification, vous serez connecté à Blesta

Si désactivé :
- Allez sur `https://votredomaine.com/plugin/google_workspace/login`
- Authentifiez-vous avec Google
- Vous serez redirigé vers l'admin Blesta

### Conditions

- L'utilisateur doit avoir un compte staff dans Blesta avec la même adresse email que son compte Google Workspace
- Le domaine Google Workspace doit correspondre au domaine configuré

## Dépannage

### Erreur "redirect_uri_mismatch"

- Vérifiez que l'URI de redirection dans Google Cloud Console correspond exactement à `https://votredomaine.com/plugin/google_workspace/callback`

### Erreur "invalid_client"

- Vérifiez que le Client ID et Client Secret sont corrects
- Assurez-vous que l'API Google+ est activée

### Utilisateur non trouvé

- Vérifiez que l'adresse email de l'utilisateur dans Blesta correspond exactement à celle de Google Workspace
- L'utilisateur doit avoir le statut "staff" actif

### Problèmes de domaine

- Assurez-vous que le domaine Google Workspace est autorisé dans les paramètres OAuth

## Sécurité

- Le Client Secret doit rester confidentiel
- Utilisez HTTPS en production
- Limitez les domaines autorisés dans Google Cloud Console

## Support

Pour des problèmes ou questions, contactez SPEED CLOUD à https://speed-cloud.fr

## Licence

GPL v3