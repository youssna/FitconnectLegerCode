BasicFit – Projet CFA INSTA – Client Léger Plateforme Web de Formation et de Coaching Sportif Contexte du projet Le projet Basic-Fit Training est une plateforme web développée dans le cadre d’un projet étudiant du CFA INSTA. Son objectif principal est de mettre en relation les adhérents Basic-Fit et des coachs sportifs professionnels, selon leurs objectifs personnels, au travers d'une interface web fluide et sécurisée.

La plateforme permet de répondre à divers besoins d'entraînement :

Prise de masse

Sèche

Remise en forme

L’accent est mis sur la simplicité d’utilisation, le "matching" par spécialité et une navigation claire développée avec une architecture Client Léger (PHP natif).

Fonctionnement général (Espace Adhérent) Lorsqu’un visiteur arrive sur le site, il découvre la présentation du concept Basic-Fit Training. Pour accéder au service et trouver un coach, il doit créer un compte utilisateur via un formulaire d’inscription sécurisé comprenant :

Identité et contact (Nom, prénom, adresse e-mail, mot de passe)

Données morphologiques (Poids, taille)

Objectif sportif (Prise de masse, sèche, remise en forme)

Une courte description personnelle (Motivation, attentes)

Une fois le profil créé, l'algorithme du site propose automatiquement ce client aux coachs qui partagent la spécialité correspondant à son objectif.

Une fois sa demande acceptée par un professionnel, le client accède à son tableau de bord personnel, où il peut voir :

Le statut de sa demande (“Acceptée”).

Les coordonnées complètes de son coach attitré (Nom, E-mail, Téléphone) pour démarrer l'entraînement.

Le récapitulatif de son profil physique.

Côté Coach (Espace Pro) Les professionnels peuvent postuler directement via la page “Postuler comme coach”. Ils renseignent leurs informations :

Nom, prénom, adresse e-mail, téléphone, adresse postale

Spécialité sportive

Lien vers leur CV / Portfolio

Sécurité : À la création, le compte du coach est inactif par mesure de sécurité. Son profil doit d'abord être audité et validé par l'administration Basic-Fit.

Une fois validé, le coach se connecte à son Espace Pro Web. Dans cet espace, il peut :

Consulter les demandes en attente des adhérents correspondant exactement à sa spécialité.

Accepter une demande (le client lui est alors officiellement rattaché) ou la refuser.

Gérer la liste de ses clients actifs et consulter leurs motivations pour préparer leurs séances.

Design et ergonomie Le design du site repose sur le framework Bootstrap 5, afin d’assurer :

Une interface moderne, épurée et pensée en "Mobile-First".

Une cohérence visuelle sur tous les supports (ordinateur, tablette, smartphone).

Le respect de la charte graphique de Basic-Fit (Couleurs dynamiques, lisibilité optimale).

L’utilisation de Bootstrap permet de garantir une expérience utilisateur fluide et conforme aux standards du web actuel.

Structure du projet (Architecture MVC) Le projet Web est organisé selon une architecture MVC (Modèle-Vue-Contrôleur) couplée à un routeur centralisé (index.php), ce qui permet une séparation claire du code et une maintenance facilitée :

/bdd/ → Fichiers de configuration et connexion à la base de données.

/controller/ → Logique métier (Traitement des formulaires, sessions, assignations).

/model/ → Gestion des données et requêtes SQL sécurisées (CRUD).

/view/ → Pages HTML/PHP visibles par l’utilisateur (Templates).

/style/ → Feuilles de style CSS personnalisées.

À propos du modèle de données : La base de données relationnelle (MySQL InnoDB) est structurée autour d'entités fortes (Client, Coach, Utilisateur) reliées par des clés étrangères avec des contraintes de suppression en cascade pour garantir l'intégrité des informations.

Sécurité et Bonnes pratiques de collaboration Mots de passe : Hachage cryptographique systématique (algorithme Bcrypt).

Injections SQL : Utilisation exclusive de requêtes préparées via l'objet PDO en PHP.

Git : Ne jamais pousser les identifiants de base de données en clair sur le dépôt (utilisation du .gitignore pour les fichiers de configuration locaux).

Code clair : Respect strict de la structure MVC pour garder le projet maintenable par n'importe quel autre développeur.

Objectif et valeur ajoutée Le projet Web Basic-Fit Training modernise la relation entre coachs et adhérents grâce à un système automatisé, fluide et ciblé. Ce projet se distingue par :

Sa simplicité d’utilisation et son ergonomie.

Sa logique fonctionnelle bien pensée (Matching par objectif).

La robustesse de son code PHP (MVC natif, sécurisation des données).

Basic-Fit Training relie efficacement clients et coachs autour d’un objectif commun : rendre l’entraînement plus accessible et encadré.
