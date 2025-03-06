-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 06 mars 2025 à 09:56
-- Version du serveur : 5.7.24
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `module_resa`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(3) NOT NULL,
  `login` varchar(50) NOT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `login`, `mdp`) VALUES
(1, 'ViyaneAdmin', '$2y$10$manKoas6WiLsWsvzSoJbj.s2eh7wt7xmrjSINjsx5NUe5mxzB4Cl6'),
(2, 'Sergio', '$2y$10$NqEWFOV5pk0d/O28ZVE5IuESfF9SLWU.Bd5Oqptgygm0VjrGsV.Bm'),
(3, 'Vincenzo', '$2y$10$Wz7R/gLnzC2rGj2x/KZuJeCLAfLX6BLrca0lyH5Vxqz4ghYdbcxiK'),
(4, 'Julien', '$2y$10$2//EB/FFq1hNLbb8XF.Kg.6yifHWGJOxnvat0BBwWRBGghkB4sowy');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(90) NOT NULL,
  `prenom` varchar(90) NOT NULL,
  `email` varchar(90) NOT NULL,
  `telephone` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id_client`, `nom`, `prenom`, `email`, `telephone`) VALUES
(22, 'De Macedo', 'Theo', 'dong@gmail.com', '0600000000'),
(23, 'De Almeda', 'Lucas', 'ding@gmail.com', '0600000000'),
(24, 'Rossini', 'Severino', 'severino@ilpiubello.it', '0600000000'),
(25, 'K', 'Angy', 'admin@potato.com', '0600000000');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `date_heure` datetime DEFAULT NULL,
  `nombre_personnes` int(2) NOT NULL,
  `commentaires` text NOT NULL,
  `status` enum('Attente','Refusée','Acceptée') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `id_client`, `date_heure`, `nombre_personnes`, `commentaires`, `status`) VALUES
(31, 22, '2025-03-14 18:30:00', 2, '', 'Attente'),
(32, 23, '2025-03-05 12:00:00', 4, '', 'Attente'),
(33, 24, '2025-03-14 18:30:00', 6, '', 'Attente'),
(34, 22, '2025-03-03 18:30:00', 2, '', 'Attente'),
(35, 25, '2025-03-05 11:30:00', 2, 'test', 'Attente'),
(36, 25, '2025-03-06 11:30:00', 4, 'test', 'Attente');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_reservation`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
