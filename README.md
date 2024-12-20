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

---

## User Stories

### US01 : Gestion des Joueurs
- En tant qu’administrateur, je veux pouvoir ajouter, modifier, supprimer et lister des joueurs afin de maintenir une base de données à jour.

### US02 : Gestion des Équipes
- En tant qu’administrateur, je veux pouvoir créer et gérer des équipes pour organiser les compétitions efficacement.

### US03 : Internationalisation (Bonus)
- En tant qu’utilisateur, je veux avoir la possibilité de changer la langue de l’interface afin d’utiliser la plateforme dans ma langue préférée.

### US04 : Statistiques Dynamiques
- En tant qu’administrateur, je veux visualiser des statistiques clés sur un tableau de bord afin de mieux comprendre l’utilisation de la plateforme.

### US05 : Fluidité de Navigation (Bonus)
- En tant qu’utilisateur, je veux pouvoir effectuer des actions sans rechargement de page grâce à AJAX afin d’améliorer mon expérience utilisateur.

---

## Technologies Utilisées
- **Frontend** : Next.js, TailwindCSS
- **Backend** : PHP, MySQL
- **Graphiques** : Chart.js
- **Internationalisation** : Gestion des fichiers de langue en PHP

---

## Modalités Pédagogiques
- **Travail** : Individuel
- **Durée de travail** : 7 jours
- **Date de lancement du brief** : 12/12/2024 à 9:00
- **Date limite de soumission** : 20/12/2024 avant midi

---

## Modalités d'Évaluation
- **Présentation du travail** : 10 minutes
  - 5 minutes : Démonstration de la conception
  - 10 minutes : Explication du code
- **Challenge en classe** : 1h + 15 minutes de QCM
