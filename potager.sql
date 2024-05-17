-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 17 mai 2024 à 07:17
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
('DoctrineMigrations\\Version20240515142452', '2024-05-15 16:25:01', 119),
('DoctrineMigrations\\Version20240515145713', '2024-05-15 16:57:22', 51);

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
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `email`, `roles`, `password`, `is_active`, `created_at`, `updated_at`) VALUES
(53, 'genevieve09@boulanger.fr', '[\"ROLE_USER\"]', '$2y$13$GdR1lfRbbsAedDtdUimiyeVTqs7AkVjPHBhLFHXU5VNQ7kbzZz8h2', 1, '2024-05-15 19:25:21', NULL),
(54, 'guyot.guy@sfr.fr', '[\"ROLE_USER\"]', '$2y$13$uht0N0DaklmVc7g47hi4w.YIOxHSAldbOqSwhHhri1IHHdL7fGP1m', 1, '2024-05-15 19:25:21', NULL),
(55, 'ebigot@laposte.net', '[\"ROLE_USER\"]', '$2y$13$1Tpp3mTsccaPYcoYQ6rBkuknB4qzUv.9fPI2JafngnxC2AsycWFw6', 1, '2024-05-15 19:25:22', NULL),
(56, 'tlabbe@riou.org', '[\"ROLE_USER\"]', '$2y$13$uCNal8O6gQZ4Pth67dme8u2ElLHa9AvYO5w5ZlOYcmYIGvllAMYxG', 1, '2024-05-15 19:25:22', NULL),
(57, 'benoit.boucher@orange.fr', '[\"ROLE_USER\"]', '$2y$13$RjW5z8hHEwFjspJ9TbLQUO66JZ782UWYy3mDZCd7TDvCF9tvoKuq2', 1, '2024-05-15 19:25:22', NULL),
(58, 'ischmitt@coulon.com', '[\"ROLE_USER\"]', '$2y$13$Ju8LR9t662KzdeFcZHqbTuZsgMO4X8fopiD0JcPVdjQb8K669Tkcy', 1, '2024-05-15 19:25:23', NULL),
(59, 'lcosta@jacques.com', '[\"ROLE_USER\"]', '$2y$13$HPeWl8GFjur2RhK1fRkKOeWUFt93o5RhB7fHtWX3YDMg0lA93e0vO', 1, '2024-05-15 19:25:23', NULL),
(60, 'diane56@tele2.fr', '[\"ROLE_USER\"]', '$2y$13$i85WfVuXBw7qCTTlBCuxA.LuwyfsiFKz.JCZNpKaqDelu4GBYwhjy', 1, '2024-05-15 19:25:23', NULL),
(61, 'blanc.margaret@regnier.fr', '[\"ROLE_USER\"]', '$2y$13$LlHPc5ci9fpyCUaCHq9wuuXy2Xmc7jdzD3DWCZDjvQIyZ09joPmHW', 1, '2024-05-15 19:25:24', NULL),
(62, 'celine.martineau@gros.com', '[\"ROLE_USER\"]', '$2y$13$U0d9KqGeou3nQbJflhEpGuPJkvmBJPNmcb/vpRD/hnqsPF41Ie.f2', 1, '2024-05-15 19:25:24', NULL);

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
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

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
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `utilisateur_details`
--
ALTER TABLE `utilisateur_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `utilisateur_details`
--
ALTER TABLE `utilisateur_details`
  ADD CONSTRAINT `FK_82DFC18FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
