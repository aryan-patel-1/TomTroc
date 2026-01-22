-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 29 déc. 2025 à 15:33
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tomtroc`
--

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `book_description` text DEFAULT NULL,
  `owner_id` int(11) NOT NULL,
  `date_time` datetime DEFAULT current_timestamp(),
  `availability` tinyint(1) DEFAULT 1,
  `cover_url` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`book_id`, `book_title`, `author`, `book_description`, `owner_id`, `date_time`, `availability`, `cover_url`) VALUES
(5, 'Esther', 'Alabaster', 'Edition Alabaster avec photographies inspirantes.', 1, '2025-12-09 11:11:23', 1, 'images/esther.png'),
(6, 'The Kinfolk Table', 'Nathan Williams', 'Recettes et histoires pour des tables conviviales', 2, '2025-12-09 11:11:23', 0, 'images/kinfolk.png'),
(7, 'Wabi Sabi', 'Beth Kempton', 'Une exploration du concept japonais du wabi-sabi.', 3, '2025-12-09 11:11:23', 1, 'images/wabi.png'),
(8, 'Milk & honey', 'Rupi Kaur', 'Recueil de poèmes illustrés.', 4, '2025-12-09 11:11:23', 1, 'images/milk.png'),
(10, 'Livre 1', 'Auteur 1', 'Description simple du livre 1.', 10, '2025-01-02 09:00:00', 1, 'https://picsum.photos/id/1010/400/400'),
(11, 'Livre 2', 'Auteur 2', 'Description simple du livre 2.', 11, '2025-01-02 09:05:00', 1, 'https://picsum.photos/id/1011/400/400'),
(12, 'Livre 3', 'Auteur 3', 'Description simple du livre 3.', 12, '2025-01-02 09:10:00', 0, 'https://picsum.photos/id/1012/400/400'),
(13, 'Livre 4', 'Auteur 4', 'Description simple du livre 4.', 13, '2025-01-02 09:15:00', 1, 'https://picsum.photos/id/1013/400/400'),
(14, 'Livre 5', 'Auteur 5', 'Description simple du livre 5.', 14, '2025-01-02 09:20:00', 1, 'https://picsum.photos/id/1014/400/400'),
(15, 'Livre 6', 'Auteur 6', 'Description simple du livre 6.', 15, '2025-01-02 09:25:00', 0, 'https://picsum.photos/id/1015/400/400'),
(16, 'Livre 7', 'Auteur 7', 'Description simple du livre 7.', 16, '2025-01-02 09:30:00', 1, 'https://picsum.photos/id/1016/400/400'),
(18, 'Livre 9', 'Auteur 9', 'Description simple du livre 9.', 18, '2025-01-02 09:40:00', 1, 'https://picsum.photos/id/1018/400/400'),
(19, 'Livre 10', 'Auteur 10', 'Description simple du livre 10.', 19, '2025-01-02 09:45:00', 0, 'https://picsum.photos/id/1019/400/400'),
(20, 'Livre 11', 'Auteur 11', 'Description simple du livre 11.', 20, '2025-01-02 09:50:00', 1, 'https://picsum.photos/id/1020/400/400'),
(21, 'Livre 12', 'Auteur 12', 'Description simple du livre 12.', 21, '2025-01-02 09:55:00', 1, 'https://picsum.photos/id/1021/400/400');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message_content` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`message_id`, `sender_id`, `receiver_id`, `message_content`, `date_time`, `is_read`) VALUES
(1, 2, 4, 'ar', '2025-12-15 14:39:59', 1),
(2, 4, 2, 'ae', '2025-12-15 14:40:24', 1),
(3, 2, 3, 'ar', '2025-12-18 10:03:53', 0),
(4, 2, 3, 'ar', '2025-12-22 08:47:05', 0),
(5, 2, 3, 'a', '2025-12-22 14:28:05', 0),
(6, 2, 3, 'a', '2025-12-22 14:28:05', 0),
(7, 2, 3, 'a', '2025-12-22 14:28:08', 0),
(8, 4, 2, 'ar', '2025-12-26 08:35:11', 1),
(9, 2, 4, 'ae', '2025-12-26 08:46:41', 1),
(10, 4, 2, 'ar', '2025-12-26 08:47:09', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_picture` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password_hash`, `date_time`, `user_picture`) VALUES
(10, 'alice', 'alice@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-01-01 09:00:00', 'https://picsum.photos/id/200/400/400'),
(11, 'bob', 'bob@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-01-01 09:05:00', 'https://picsum.photos/id/201/400/400'),
(12, 'charlie', 'charlie@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-01-01 09:10:00', 'https://picsum.photos/id/202/400/400'),
(13, 'diane', 'diane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-01-01 09:15:00', 'https://picsum.photos/id/203/400/400'),
(14, 'eric', 'eric@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-01-01 09:20:00', 'https://picsum.photos/id/204/400/400'),
(15, 'fatima', 'fatima@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-01-01 09:25:00', 'https://picsum.photos/id/205/400/400'),
(16, 'georges', 'georges@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-01-01 09:30:00', 'https://picsum.photos/id/206/400/400'),
(17, 'hannah', 'hannah@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-01-01 09:35:00', 'https://picsum.photos/id/207/400/400'),
(18, 'igor', 'igor@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-01-01 09:40:00', 'https://picsum.photos/id/208/400/400'),
(19, 'julie', 'julie@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-01-01 09:45:00', 'https://picsum.photos/id/209/400/400'),
(20, 'khaled', 'khaled@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-01-01 09:50:00', 'https://picsum.photos/id/210/400/400'),
(21, 'lea', 'lea@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-01-01 09:55:00', 'https://picsum.photos/id/211/400/400');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `fk_message_sender` (`sender_id`),
  ADD KEY `fk_message_receiver` (`receiver_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_receiver` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_message_sender` FOREIGN KEY (`sender_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
