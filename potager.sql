-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 25 juil. 2024 à 18:29
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
('DoctrineMigrations\\Version20240628122919', '2024-06-28 14:29:27', 32);

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
  `nom` varchar(180) NOT NULL,
  `email` varchar(180) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(80) NOT NULL,
  `code_postal` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_size` int(11) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `producteur`
--

INSERT INTO `producteur` (`id`, `nom`, `email`, `tel`, `adresse`, `ville`, `code_postal`, `created_at`, `updated_at`, `slug`, `image_name`, `image_size`, `description`) VALUES
(1, 'La Ferme Caladoise', 'lafermecaladoise@gmail.com', '0689562456', '8 rue du patio', 'Villefranche-sur-Saône', 69400, '2024-05-25 10:42:57', '2024-05-25 10:42:57', 'La-Ferme-Caladoise', 'ferme.webp', 0, 'En activité depuis 1970, La Ferme Caladoise est une entreprise familiale depuis trois générations. \r\nAyant à cœur de fournir des produit de qualité, les légumes et fruits sont produits sur place.'),
(11, 'Légumes du jardin', 'legumesdujardin@gmail.com', '0625323636', '8 rue Copernic', 'Limas', 69400, '2024-06-24 15:54:20', '2024-06-28 10:06:35', 'Legumes-du-jardin', 'legumesdujardin-667e6f0b465c7942689864.jpg', 138866, 'Légumes du jardin, c\'est des années de passion et d\'amour de la nature.\r\nTous les produits de cette coopérative agricole à taille humaine, sont récoltés à la main dans la plus pur tradition française d\'antan.');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `producteur_id` int(11) DEFAULT NULL,
  `nom` varchar(50) NOT NULL,
  `prix` int(11) NOT NULL,
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
(1, 2, 1, 'Tomate', 0, 'tomates-66702ca061bee264215891.png', 610533, '2024-05-25 10:43:56', '2024-06-17 14:31:28', 'Tomate', 'La tomate se consomme comme un légume-fruit, crue ou cuite. Riche en eau, en antioxydant et de fibres. C\'est aussi une source de vitamine C. Autres avantages, elle est peu calorique. Environ 6-7 pièces au kg.\r\n\r\nOrigine France'),
(2, 1, 1, 'Pommes', 110, 'pommes-667c1b7ca7d93158738233.jpg', 152636, '2024-05-25 10:49:27', '2024-06-26 15:45:32', 'Pommes', 'La pomme est riche en pectine. C\'est aussi une source de vitamine C et d\'antioxydants. Elle stimule le système immunitaire. Environ 5-6 pour faire un kilo.\r\n\r\nOrigine France.'),
(8, 2, 11, 'radis', 200, 'radis-667e918318ee0095511000.jpg', 46227, '2024-06-26 14:53:10', '2024-06-28 12:33:39', 'radis', 'c\'est un radis'),
(9, 1, 1, 'Poires', 380, 'poires-667c1bee6c0e7703230029.webp', 80536, '2024-06-26 15:47:26', '2024-06-26 15:47:26', 'Poires', 'La poire est une excellente source de fibres alimentaires et aussi riche en antioxydant. La poire conférence a la chair fine, juteuse et fondante avec une saveur légèrement acidulée. Environ 7 poires pour faire un kilo.'),
(10, 1, 11, 'Oranges', 200, 'orange-667c1d23a0b6a295804480.webp', 38354, '2024-06-26 15:52:35', '2024-06-26 15:52:35', 'Oranges', 'Orange aussi bonne en jus ou à la main. \r\nL\'orange est une source de fibres, de calcium et de magnésium. Mais elle est aussi riche en vitamine C et pauvre en calories. Elle stimule le système immunitaire.'),
(11, 1, 11, 'Pêches plates', 145, 'peche-plate-667c2339067a3803164341.jpg', 221307, '2024-06-26 16:18:32', '2024-06-26 16:18:33', 'Peches-plates', 'Les pêches sont des fruits climatériques charnus, juteux et sucrés, avec une chair jaune, blanche, ou rouge (sanguine), une peau veloutée de couleur jaune ou orange plus ou moins lavée de rose-carmin à rose-saumon ou brune chez les sanguines, et un noyau dur, adhérent ou non.'),
(12, 1, 1, 'Pêches', 150, 'peches-667c235d32aaa293313028.webp', 75334, '2024-06-26 16:19:09', '2024-06-26 16:19:09', 'Peches', 'Les pêches sont des fruits climatériques charnus, juteux et sucrés, avec une chair jaune, blanche, ou rouge (sanguine), une peau veloutée de couleur jaune ou orange plus ou moins lavée de rose-carmin à rose-saumon ou brune chez les sanguines, et un noyau dur, adhérent ou non.'),
(13, 3, 11, 'Jus de pommes', 200, 'jusdepommes-667e71f776632875643308.webp', 22722, '2024-06-28 10:14:26', '2024-06-28 10:19:03', 'Jus-de-pommes', 'Jus de pommes 100% naturel.');

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
(5, 'lol@lol.lol', '[\"ROLE_USER\"]', '$2y$13$icXYM/8frXK44yQVCRjIkuA6zCZNuq.gwlsd/KpcymNMY07jYUbP6', 1, '2024-06-02 10:08:14', '2024-06-02 10:08:14');

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
(2, 5, 'Jean-Michel', 'DeTel', '0526353625', '6 rue des platanes', 'Limas', 69400, '2024-06-02 10:08:14', '2024-06-02 10:08:14');

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
  ADD UNIQUE KEY `UNIQ_7EDBEE10F037AB0F` (`tel`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `utilisateur_details`
--
ALTER TABLE `utilisateur_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

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
