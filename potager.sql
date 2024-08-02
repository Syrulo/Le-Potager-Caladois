-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 02 août 2024 à 09:16
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `potager`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_size` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`, `image_name`, `image_size`, `created_at`, `updated_at`, `slug`) VALUES
(1, 'Fruits', 'fruits-668ba89137c27985147790.jpg', 32993, '2024-05-25 10:39:26', '2024-07-08 10:51:29', 'Fruits'),
(2, 'Légumes', 'legumes-668ba89997e25939618274.webp', 38230, '2024-05-25 10:39:56', '2024-07-08 10:51:37', 'Legumes'),
(3, 'Boissons', 'boissons-668ba89ea19ee196249473.webp', 38706, '2024-05-25 10:41:47', '2024-07-08 10:51:42', 'Boissons');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240729132033', '2024-07-29 15:20:38', 27),
('DoctrineMigrations\\Version20240729140356', '2024-07-29 16:04:00', 27);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `producteur`
--

CREATE TABLE `producteur` (
  `id` int(11) NOT NULL,
  `nom` varchar(180) DEFAULT NULL,
  `email` varchar(180) NOT NULL,
  `tel` varchar(10) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `ville` varchar(80) DEFAULT NULL,
  `code_postal` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_size` int(11) NOT NULL,
  `description` longtext DEFAULT NULL,
  `utilisateur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `producteur`
--

INSERT INTO `producteur` (`id`, `nom`, `email`, `tel`, `adresse`, `ville`, `code_postal`, `created_at`, `updated_at`, `slug`, `image_name`, `image_size`, `description`, `utilisateur_id`) VALUES
(16, 'La Ferme Caladoise', 'lafermecaladoise@gmail.com', '0689562456', '8 rue du patio', 'Villefranche-sur-Saône', 69400, '2024-07-29 16:35:21', '2024-07-30 13:46:21', 'La-Ferme-Caladoise', 'lafermecaladoise-66a8d28d63edf465381239.jpg', 54309, 'En activité depuis 1970, La Ferme Caladoise est une entreprise familiale depuis trois générations. Ayant à cœur de fournir des produit de qualité, les légumes et fruits sont produits sur place.', 20),
(17, 'Légumes du jardin', 'legumesdujardin@gmail.com', '0625323636', '8 rue Copernic', 'Limas', 69400, '2024-07-30 13:52:02', '2024-07-30 13:52:03', 'Legumes-du-jardin', 'legumesdujardin-66a8d3e36e367262888792.jpg', 138866, 'Légumes du jardin, c\'est des années de passion et d\'amour de la nature. Tous les produits de cette coopérative agricole à taille humaine, sont récoltés à la main dans la plus pur tradition française d\'antan.', 21),
(18, 'Fruits du verger', 'fruitsduverger@gmail.com', '0632353431', '16 chemin de la tarte aux fruits', 'Anse', 69009, '2024-07-30 14:08:45', '2024-07-30 14:08:45', 'Fruits-du-verger', 'fruitsduverger-66a8d7cdb3a4d259559686.jpg', 150729, 'Vous aimez les fruits ? Vous allez adorer les fruits de nos vergers. Cueillis à la main, conditionnés par nos soins et pressez pour vous fournir les boissons les plus fruitées qui soit ainsi que les des fruits à consommer tel quel, Les fruits du verger, c\'est la référence lyonnaise.', 22);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `producteur_id` int(11) DEFAULT NULL,
  `nom` varchar(50) NOT NULL,
  `prix` double NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_size` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL,
  `slug` varchar(50) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `categorie_id`, `producteur_id`, `nom`, `prix`, `image_name`, `image_size`, `created_at`, `updated_at`, `slug`, `description`) VALUES
(19, 2, 16, 'Salade', 1.3, 'salade-laitue-66a8bc2c21760109966123.webp', 102024, '2024-07-30 12:10:50', '2024-07-30 12:24:50', 'Salade', 'C\'est une salade'),
(20, 1, 18, 'Pommes', 1.1, 'pommes-667c1b7ca7d93158738233-66a8d907d3b24905142283.jpg', 152636, '2024-07-30 14:13:59', '2024-07-30 14:13:59', 'Pommes', 'La pomme est riche en pectine. C\'est aussi une source de vitamine C et d\'antioxydants. Elle stimule le système immunitaire.\r\nEnviron 5-6 pour faire un kilo.\r\nOrigine France.'),
(21, 3, 18, 'Jus de pommes', 2.6, 'jusdepommes-66a8db3ce41ad539735521.webp', 22722, '2024-07-30 14:23:24', '2024-07-30 14:23:24', 'Jus-de-pommes', 'Jus de pommes 100% naturel.'),
(22, 1, 18, 'Pêches', 1.5, 'peches-66a8dca1725c9001510746.webp', 75334, '2024-07-30 14:29:21', '2024-07-30 14:30:44', 'Peches', 'Les pêches sont des fruits climatériques charnus, juteux et sucrés, avec une chair jaune, blanche, ou rouge (sanguine), une peau veloutée de couleur jaune ou orange plus ou moins lavée de rose-carmin à rose-saumon ou brune chez les sanguines, et un noyau dur, adhérent ou non.'),
(23, 1, 18, 'Pêches plates', 1.45, 'peche-plate-66a8dcdc26db4884344842.jpg', 221307, '2024-07-30 14:30:20', '2024-07-30 14:30:20', 'Peches-plates', 'Les pêches sont des fruits climatériques charnus, juteux et sucrés, avec une chair jaune, blanche, ou rouge (sanguine), une peau veloutée de couleur jaune ou orange plus ou moins lavée de rose-carmin à rose-saumon ou brune chez les sanguines, et un noyau dur, adhérent ou non.'),
(24, 2, 17, 'Tomates', 2, 'tomates-66a8dda26402d270371819.jpg', 25457, '2024-07-30 14:33:38', '2024-07-30 14:33:38', 'Tomates', 'La tomate se consomme comme un légume-fruit, crue ou cuite. Riche en eau, en antioxydant et de fibres. C\'est aussi une source de vitamine C. Autres avantages, elle est peu calorique.\r\nEnviron 6-7 pièces au kg.\r\nOrigine France'),
(25, 2, 17, 'Radis', 2, 'radis-66a8e605283cb070219192.webp', 65708, '2024-07-30 15:09:25', '2024-07-30 15:09:25', 'Radis', 'Toutes les parties de la plante sont comestibles, bien que sa racine pivot soit plus populaire. La peau et la chair du radis peuvent être de différentes couleurs, dont la plus courante est le rouge. Certaines variétés peuvent être bicolores, roses, violettes, vertes, blanches ou noires.'),
(26, 1, 16, 'Poires', 3.8, 'poires-66a8e7b95a4bd528303356.webp', 22600, '2024-07-30 15:16:41', '2024-07-30 15:16:41', 'Poires', 'La poire est une excellente source de fibres alimentaires et aussi riche en antioxydant. La poire conférence a la chair fine, juteuse et fondante avec une saveur légèrement acidulée.\r\nEnviron 7 poires pour faire un kilo.'),
(27, 1, 16, 'Oranges', 2, 'orange-66a8eaec336ca963172789.jpg', 161931, '2024-07-30 15:30:20', '2024-07-30 15:30:20', 'Oranges', 'L\'orange est une source de fibres, de calcium et de magnésium. Mais elle est aussi riche en vitamine C et pauvre en calories. Elle stimule le système immunitaire.');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `email`, `roles`, `password`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 'admin@admin.admin', '[\"ROLE_USER\",\"ROLE_ADMIN\"]', '$2y$13$A.lwV.2CmjhpqKbFMadPXODo7lpvVo5WsgooQPHObNG7GIHh7vNmq', 1, '2024-05-25 10:35:28', '2024-05-25 10:35:28'),
(5, 'lol@lol.lol', '[\"ROLE_USER\"]', '$2y$13$icXYM/8frXK44yQVCRjIkuA6zCZNuq.gwlsd/KpcymNMY07jYUbP6', 1, '2024-06-02 10:08:14', '2024-06-02 10:08:14'),
(20, 'lal@lal.lal', '[\"ROLE_PRODUCTEUR\"]', '$2y$13$.zHRc5mlk55wsX.e7S2s5OMaKKqGpRH5tn6dYwrEVsb7aUYdYZ5iC', 0, '2024-07-29 16:35:21', '2024-07-29 16:35:21'),
(21, 'legumes@gmail.com', '[\"ROLE_PRODUCTEUR\"]', '$2y$13$4gWzgJI2zLPHM7KEznv2MeI2Au06QNYT6Fkj89Ji3zLFnmqy03pUS', 0, '2024-07-30 13:52:02', '2024-07-30 13:52:02'),
(22, 'fruits@gmail.com', '[\"ROLE_PRODUCTEUR\"]', '$2y$13$QN4lIjrBh8IijUv2vO3tNe4wKIlCCXsEeTxooG7Dw32u.nBVz8ywu', 0, '2024-07-30 14:08:45', '2024-07-30 14:08:45'),
(23, 'test@test.test', '[\"ROLE_USER\"]', '$2y$13$1Nn9faZpOZ2GTHMOSr2xjuqkEqmrR3EjmNMU9/lqSN03IeOlDjJDW', 1, '2024-07-30 14:48:11', '2024-07-30 14:48:11');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_details`
--

CREATE TABLE `utilisateur_details` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `tel` varchar(10) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `ville` varchar(80) DEFAULT NULL,
  `code_postal` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur_details`
--

INSERT INTO `utilisateur_details` (`id`, `utilisateur_id`, `prenom`, `nom`, `tel`, `adresse`, `ville`, `code_postal`, `created_at`, `updated_at`) VALUES
(1, 3, 'admin', 'admin', '0625586566', '6 zelkcjzejn', 'admin', 32625, '2024-05-25 10:35:28', '2024-05-25 10:35:28'),
(2, 5, 'Jean-Michel', 'DeTel', '0526353625', '6 rue des platanes', 'Limas', 69400, '2024-06-02 10:08:14', '2024-06-02 10:08:14'),
(7, 23, 'test', 'test', '0635323632', 'test', 'test', 69632, '2024-07-30 14:48:11', '2024-07-30 14:48:11');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `producteur`
--
ALTER TABLE `producteur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_7EDBEE10E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_7EDBEE10F037AB0F` (`tel`),
  ADD UNIQUE KEY `UNIQ_7EDBEE10FB88E14F` (`utilisateur_id`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_29A5EC27BCF5E72D` (`categorie_id`),
  ADD KEY `IDX_29A5EC27AB9BB300` (`producteur_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- Index pour la table `utilisateur_details`
--
ALTER TABLE `utilisateur_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_82DFC18FB88E14F` (`utilisateur_id`),
  ADD UNIQUE KEY `UNIQ_82DFC18F037AB0F` (`tel`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `producteur`
--
ALTER TABLE `producteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `utilisateur_details`
--
ALTER TABLE `utilisateur_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `producteur`
--
ALTER TABLE `producteur`
  ADD CONSTRAINT `FK_7EDBEE10FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_29A5EC27AB9BB300` FOREIGN KEY (`producteur_id`) REFERENCES `producteur` (`id`),
  ADD CONSTRAINT `FK_29A5EC27BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `utilisateur_details`
--
ALTER TABLE `utilisateur_details`
  ADD CONSTRAINT `FK_82DFC18FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
