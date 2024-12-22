![image description](https://github.com/yassine-jarir/fut-dashboard/blob/main/client/public/images/fut%20.png)

# FUT Champions Ultimate Team

## Contexte du Projet
Ce projet vise à développer la plateforme FUT Champions Ultimate Team en utilisant **Next.js** pour le frontend, **PHP** pour le backend, et des API pour la communication entre les deux. Nous utilisons également **TailwindCSS** pour le design et le style, offrant une interface moderne et réactive. La plateforme permet une gestion avancée des joueurs, des équipes, des nationalités et d'autres entités liées, tout en intégrant des fonctionnalités multilingues et des statistiques dynamiques.

---

## Fonctionnalités Backend Attendues

### Analyse et Optimisation des Données
- Analyse approfondie du fichier JSON fourni pour concevoir une structure de base de données optimale.
- Normalisation des bases de données pour éviter la redondance des données.
- Création de schémas relationnels efficaces pour gérer les entités (joueurs, équipes, nationalités, etc.).

### Gestion des Entités
- API pour ajouter, modifier, supprimer et lister les entités.
- Gestion des relations entre les entités (par exemple, associer un joueur à une équipe et à une nationalité).

### Tableau de Bord et Statistiques
- Tableau de bord dynamique pour visualiser les statistiques clés (nombre de joueurs, répartition par nationalité, performances des équipes, etc.).
- Intégration de graphiques interactifs avec des bibliothèques comme Chart.js.

### Internationalisation (i18n)
- Système d'internationalisation pour un support multilingue.
- Gestion de fichiers de langue séparés pour chaque langue supportée.
- Option pour changer la langue de l'interface via le tableau de bord.

---

## Fonctionnalités Frontend

### Framework Utilisé
- **Next.js** pour un rendu côté serveur (SSR) et une expérience utilisateur fluide.

### Design
- **TailwindCSS** pour une interface utilisateur moderne et responsive.

### Navigation et Interactions
- Intégration d'AJAX pour des interactions sans rechargement de page.
- Utilisation de modals pour des actions fluides (par exemple, formulaires de gestion dans des fenêtres modales).

---

## API Backend

### Langage et Framework
- Développement backend en **PHP procédural**.

### Méthodes API
- CRUD (Create, Read, Update, Delete) pour chaque entité (joueurs, équipes, nationalités).
- Réponses structurées en JSON pour une communication fluide avec le frontend.

---

## Instructions pour Configurer le Projet

### Prérequis
1. **Backend**
   - Serveur PHP (par exemple, XAMPP, WAMP, ou un serveur en ligne).
   - MySQL pour la base de données.

2. **Frontend**
   - Node.js installé pour exécuter l'application Next.js.

3. **API Communication**
   - Assurez-vous que les endpoints API sont accessibles depuis le frontend.

### Installation

#### Backend
1. Configurez la base de données MySQL à l'aide du script SQL fourni.
2. Placez les fichiers PHP dans le dossier `htdocs` ou sur un serveur en ligne.
3. Testez les endpoints API via Postman ou un navigateur.

#### Frontend
1. Clonez ce dépôt :
   ```bash
   git clone <url-du-repo>
   ```
2. Installez les dépendances :
   ```bash
   npm install
   ```
3. Lancez le serveur de développement :
   ```bash
   npm run dev
   ```

 
