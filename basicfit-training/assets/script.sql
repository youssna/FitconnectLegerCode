-- Base de données : `fitconnect`

-- --------------------------------------------------------
-- STRUCTURE DES TABLES
-- --------------------------------------------------------

CREATE TABLE `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL UNIQUE,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('CLIENT','COACH','ADMIN') NOT NULL DEFAULT 'CLIENT',
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `coach` (
  `id_coach` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `specialite` varchar(50) NOT NULL,
  `cv` text NOT NULL,
  `valide` tinyint(1) NOT NULL DEFAULT '0',
  `date_validation` timestamp NULL DEFAULT NULL,
  `mail` varchar(100) UNIQUE,
  `mot_de_passe` varchar(255),
  `telephone` varchar(20),
  PRIMARY KEY (`id_coach`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `client` (
  `id_client` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `poids` decimal(5,2) NOT NULL,
  `taille` int NOT NULL,
  `objectif` varchar(50) NOT NULL,
  `motivation` text NOT NULL,
  `id_coach` int DEFAULT NULL,
  `mail` varchar(100) UNIQUE,
  `telephone` varchar(20),
  `mot_de_passe` varchar(255),
  `date_inscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_client`),
  CONSTRAINT `fk_client_coach` FOREIGN KEY (`id_coach`) REFERENCES `coach` (`id_coach`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `programme` (
  `id_programme` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `niveau` enum('debutant','intermediaire','confirme') DEFAULT 'debutant',
  `duree_semaines` int DEFAULT '8',
  `frequence_par_semaine` int DEFAULT '3',
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_programme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `exercice` (
  `id_exercice` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `description` text,
  `groupe_musculaire` varchar(50),
  PRIMARY KEY (`id_exercice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `seance` (
  `id_seance` int NOT NULL AUTO_INCREMENT,
  `id_programme` int NOT NULL,
  `jour_numero` int DEFAULT NULL,
  `titre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_seance`),
  CONSTRAINT `fk_seance_programme` FOREIGN KEY (`id_programme`) REFERENCES `programme` (`id_programme`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `seance_exercice` (
  `id_seance` int NOT NULL,
  `id_exercice` int NOT NULL,
  `series` int NOT NULL,
  `repetitions` varchar(50) NOT NULL,
  `repos_secondes` int DEFAULT NULL,
  PRIMARY KEY (`id_seance`,`id_exercice`),
  CONSTRAINT `fk_se_seance` FOREIGN KEY (`id_seance`) REFERENCES `seance` (`id_seance`) ON DELETE CASCADE,
  CONSTRAINT `fk_se_exercice` FOREIGN KEY (`id_exercice`) REFERENCES `exercice` (`id_exercice`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `client_programme` (
  `id_client_programme` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_programme` int NOT NULL,
  `date_debut` date NOT NULL,
  PRIMARY KEY (`id_client_programme`),
  CONSTRAINT `fk_cp_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE,
  CONSTRAINT `fk_cp_programme` FOREIGN KEY (`id_programme`) REFERENCES `programme` (`id_programme`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `refus_coach` (
  `id_refus` int NOT NULL AUTO_INCREMENT,
  `id_coach` int NOT NULL,
  `id_client` int NOT NULL,
  `date_refus` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_refus`),
  CONSTRAINT `fk_refus_coach` FOREIGN KEY (`id_coach`) REFERENCES `coach` (`id_coach`) ON DELETE CASCADE,
  CONSTRAINT `fk_refus_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- INSERTIONS DES DONNÉES
-- --------------------------------------------------------

-- Admin
INSERT INTO `utilisateur` (`email`, `mot_de_passe`, `role`) VALUES
('admin@fitconnect.fr', '$2a$10$B5PyXlmBGkBKq4TQ4xixOujJqhlaxQJy1B4.T7rAV6B59sKfhTYw.', 'ADMIN');

-- Coachs
INSERT INTO `coach` (`nom`, `prenom`, `adresse`, `specialite`, `cv`, `valide`, `mail`, `mot_de_passe`, `telephone`) VALUES
('Durant', 'Marc', '10 rue du Muscle, Paris', 'prise_masse', 'https://linkedin.com/pro', 1, 'marc.coach@fit.fr', '$2y$10$GsDs0.zXh.iK6dWGcXL3HuKo9xjRgvhS7/dEeaRkT.c9/dEl6vs7.', '0601020304'),
('Leclerc', 'Julie', '5 avenue Cardio, Lyon', 'seche', 'https://linkedin.com/pro', 1, 'julie.coach@fit.fr', '$2y$10$GsDs0.zXh.iK6dWGcXL3HuKo9xjRgvhS7/dEeaRkT.c9/dEl6vs7.', '0605060708'),
('Bernard', 'Thomas', '22 boulevard Santé, Lille', 'remise_forme', 'https://linkedin.com/pro', 1, 'thomas.coach@fit.fr', '$2y$10$GsDs0.zXh.iK6dWGcXL3HuKo9xjRgvhS7/dEeaRkT.c9/dEl6vs7.', '0609101112');

-- Clients
INSERT INTO `client` (`nom`, `prenom`, `poids`, `taille`, `objectif`, `motivation`, `id_coach`, `mail`, `telephone`, `mot_de_passe`) VALUES
('Gomez', 'Lucas', 70.00, 180, 'prise_masse', 'Prendre du muscle lourd.', 1, 'lucas@mail.com', '0701020304', '$2y$10$GsDs0.zXh.iK6dWGcXL3HuKo9xjRgvhS7/dEeaRkT.c9/dEl6vs7.'),
('Martin', 'Sophie', 65.00, 165, 'seche', 'Perdre du gras.', 2, 'sophie@mail.com', '0705060708', '$2y$10$GsDs0.zXh.iK6dWGcXL3HuKo9xjRgvhS7/dEeaRkT.c9/dEl6vs7.'),
('Petit', 'Jean', 95.00, 175, 'remise_forme', 'Reprendre le sport.', 3, 'jean@mail.com', '0709101112', '$2y$10$GsDs0.zXh.iK6dWGcXL3HuKo9xjRgvhS7/dEeaRkT.c9/dEl6vs7.');

-- Exercices
INSERT INTO `exercice` (`id_exercice`, `nom`, `description`, `groupe_musculaire`) VALUES
(1, 'Développé couché', 'Masse pectorale', 'Pectoraux'),
(2, 'Squat à la barre', 'Exercice roi jambes', 'Jambes'),
(3, 'Soulevé de terre', 'Chaîne postérieure', 'Dos/Jambes'),
(4, 'Tirage vertical poulie', 'Largeur du dos', 'Dos'),
(5, 'Presse à cuisses', 'Quadriceps', 'Jambes'),
(6, 'Burpees', 'Cardio intense', 'Full Body'),
(7, 'Fentes marchées', 'Fessiers et brûlage calories', 'Jambes'),
(8, 'Kettlebell Swing', 'Explosivité', 'Full Body'),
(9, 'Corde à sauter', 'Dépense énergétique', 'Cardio'),
(10, 'Thruster', 'Puissance', 'Full Body'),
(11, 'Pompes', 'Poids du corps', 'Pectoraux'),
(12, 'Gainage planche', 'Ceinture abdominale', 'Abdominaux'),
(13, 'Squat poids du corps', 'Réapprentissage mouvement', 'Jambes'),
(14, 'Tirage horizontal machine', 'Posture', 'Dos'),
(15, 'Vélo elliptique', 'Cardio sans impact', 'Cardio');

-- Programmes
INSERT INTO `programme` (`id_programme`, `nom`, `description`, `type`, `niveau`, `duree_semaines`, `frequence_par_semaine`) VALUES
(1, 'Programme Hypertrophie', 'Prise de masse avec charges lourdes.', 'prise_masse', 'intermediaire', 12, 4),
(2, 'Sèche Express', 'HIIT et musculation légère.', 'seche', 'confirme', 8, 5),
(3, 'Remise en Forme', 'Circuit training full-body.', 'remise_forme', 'debutant', 6, 3);

-- Séances
INSERT INTO `seance` (`id_seance`, `id_programme`, `jour_numero`, `titre`) VALUES
(1, 1, 1, 'Jour 1 : Push'),
(2, 1, 2, 'Jour 2 : Pull'),
(3, 1, 3, 'Jour 3 : Legs'),
(5, 2, 1, 'Jour 1 : Circuit Métabolique'),
(10, 3, 1, 'Jour 1 : Initiation');

-- Exercices par Séance
INSERT INTO `seance_exercice` (`id_seance`, `id_exercice`, `series`, `repetitions`, `repos_secondes`) VALUES
(1, 1, 4, '8 à 10', 120),
(1, 11, 4, 'Echec', 90),
(3, 2, 5, '6 à 8', 180),
(5, 6, 4, '15', 45),
(10, 13, 3, '12', 90);