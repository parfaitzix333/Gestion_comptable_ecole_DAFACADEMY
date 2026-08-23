-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : sam. 22 août 2026 à 10:43
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
-- Base de données : `laravel`
--

-- --------------------------------------------------------

--
-- Structure de la table `annee_scolaires`
--

CREATE TABLE `annee_scolaires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `annee` varchar(255) NOT NULL,
  `statut` enum('actif','inactif') NOT NULL DEFAULT 'inactif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `annee_scolaires`
--

INSERT INTO `annee_scolaires` (`id`, `annee`, `statut`, `created_at`, `updated_at`) VALUES
(1, '2024-2025', 'actif', '2026-08-16 18:02:35', '2026-08-17 22:31:58'),
(2, '2023-2024', 'inactif', '2026-08-16 18:02:58', '2026-08-21 01:39:27'),
(4, '2022-2023', 'inactif', '2026-08-21 14:13:08', '2026-08-21 14:13:08');

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(255) NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `annee_scolaire_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`id`, `designation`, `section_id`, `annee_scolaire_id`, `created_at`, `updated_at`) VALUES
(1, '1ère Maternelle', 2, 1, '2026-08-16 10:06:13', '2026-08-19 10:50:19'),
(2, '2è Maternelle', 2, 1, '2026-08-17 17:28:49', '2026-08-17 17:28:49'),
(3, '3è Maternelle', 2, 1, '2026-08-17 17:29:55', '2026-08-17 17:29:55');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couriel` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `adresse` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id`, `couriel`, `tel`, `created_at`, `updated_at`, `adresse`) VALUES
(1, 'parfaitzix333@gmail.com', '+243999385123', '2026-08-16 10:02:16', '2026-08-19 10:42:53', 'Av.Lumumba.Q.CraaUsine/Comm.Annexe.');

-- --------------------------------------------------------

--
-- Structure de la table `eleves`
--

CREATE TABLE `eleves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `matricule` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `date_n` date NOT NULL,
  `lieu_n` varchar(255) NOT NULL,
  `responsable` varchar(255) NOT NULL,
  `tel_responsable` varchar(255) NOT NULL,
  `adresse` text DEFAULT NULL,
  `classe_id` bigint(20) UNSIGNED NOT NULL,
  `annee_scolaire_id` bigint(20) UNSIGNED NOT NULL,
  `ecole_provenance` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `sexe` enum('M','F') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `eleves`
--

INSERT INTO `eleves` (`id`, `matricule`, `nom`, `date_n`, `lieu_n`, `responsable`, `tel_responsable`, `adresse`, `classe_id`, `annee_scolaire_id`, `ecole_provenance`, `photo`, `sexe`, `created_at`, `updated_at`) VALUES
(1, '2026-1-1', 'Mumba Kisimba Boaz', '2026-07-29', 'Likasi', 'Mumbas Roger', '+24390018240', 'Av Kamanyola N° 30', 1, 1, '---', 'uploads/photos/1786932880_Capture d’écran du 2026-08-15 01-26-50.png', 'M', '2026-08-17 02:14:40', '2026-08-17 08:58:12'),
(2, '2026-1-2', 'Hemedi Kalonda Ben', '2002-08-17', 'Kolwezi', 'Hemedi Mwamba', '+24390018240', 'Av du 30 juin.', 1, 1, 'CS TUJENGE', 'uploads/photos/1786957977_upl_prog.jpeg', 'M', '2026-08-17 09:12:57', '2026-08-17 09:12:57'),
(3, '2026-2-3', 'Ngoy Bliss', '2026-07-28', 'lubumbashi', 'Ngoy Bina', '+24390018240', 'Av Kamanyola N° 30', 2, 1, 'EP UPENDO', 'uploads/photos/1787033875_Capture d’écran du 2026-08-18 01-25-01.png', 'F', '2026-08-18 06:17:55', '2026-08-18 06:17:55');

-- --------------------------------------------------------

--
-- Structure de la table `enseignants`
--

CREATE TABLE `enseignants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `matricule` varchar(255) NOT NULL,
  `classe_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sexe` enum('M','F') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `enseignants`
--

INSERT INTO `enseignants` (`id`, `nom`, `matricule`, `classe_id`, `user_id`, `sexe`, `created_at`, `updated_at`) VALUES
(1, 'numbi guelord', '201', 1, 2, 'M', '2026-08-16 23:10:57', '2026-08-20 23:45:36'),
(2, 'Henoc Dyanda', '202', 2, 4, 'M', '2026-08-21 22:41:46', '2026-08-22 01:00:53'),
(3, 'Marcella2', '203', 3, 7, 'M', '2026-08-22 00:28:43', '2026-08-22 00:46:10');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `frais`
--

CREATE TABLE `frais` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(255) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `classe_id` bigint(20) UNSIGNED NOT NULL,
  `annee_scolaire_id` bigint(20) UNSIGNED NOT NULL,
  `statut` enum('actif','inactif') NOT NULL DEFAULT 'inactif',
  `devise` varchar(10) NOT NULL DEFAULT '$',
  `date_limite` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `frais`
--

INSERT INTO `frais` (`id`, `designation`, `montant`, `classe_id`, `annee_scolaire_id`, `statut`, `devise`, `date_limite`, `created_at`, `updated_at`) VALUES
(1, 'Frais de l\'État (Tranche 1)', 20.00, 1, 1, 'actif', '$', '2026-08-01', '2026-08-16 10:32:20', '2026-08-18 00:23:02'),
(2, 'Minerval janvier', 50.00, 1, 1, 'actif', '$', '2026-09-02', '2026-08-16 21:48:57', '2026-08-21 00:19:56'),
(3, 'frais de l\'etat (Tranche 2)', 10.00, 1, 1, 'inactif', '$', '2026-08-31', '2026-08-17 21:28:57', '2026-08-17 21:28:57'),
(4, 'Minerval Février', 50.00, 1, 1, 'inactif', '$', '2026-09-01', '2026-08-17 21:32:05', '2026-08-17 21:32:05'),
(5, 'Minerval marse', 50.00, 1, 1, 'inactif', '$', '2026-09-01', '2026-08-17 21:32:41', '2026-08-17 21:32:41'),
(6, 'Frais d\'inscription', 10.00, 2, 1, 'inactif', '$', '2026-09-01', '2026-08-17 21:33:56', '2026-08-17 21:33:56');

-- --------------------------------------------------------

--
-- Structure de la table `historiques`
--

CREATE TABLE `historiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historiques`
--

INSERT INTO `historiques` (`id`, `user_id`, `action`, `created_at`, `updated_at`) VALUES
(1, 1, 'Création d\'une année scolaire : 2024-2025', '2026-08-16 09:27:08', '2026-08-16 09:27:08'),
(2, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 09:31:07', '2026-08-16 09:31:07'),
(3, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 09:31:59', '2026-08-16 09:31:59'),
(4, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 09:36:52', '2026-08-16 09:36:52'),
(5, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 09:36:57', '2026-08-16 09:36:57'),
(6, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 09:38:41', '2026-08-16 09:38:41'),
(7, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 09:38:48', '2026-08-16 09:38:48'),
(8, 1, 'Ajout d\'un contact : parfaitzix333@gmail.com', '2026-08-16 10:02:16', '2026-08-16 10:02:16'),
(9, 1, 'Création d\'une nouvelle section : Primaire', '2026-08-16 10:03:27', '2026-08-16 10:03:27'),
(10, 1, 'Création d\'une nouvelle section : Maternelle', '2026-08-16 10:03:39', '2026-08-16 10:03:39'),
(11, 1, 'Création d\'une classe : 1ère Maternelle', '2026-08-16 10:06:13', '2026-08-16 10:06:13'),
(12, 1, 'Ajout d\'une propriété : A propos de Nous', '2026-08-16 10:08:23', '2026-08-16 10:08:23'),
(13, 1, 'Création d\'un frais : Frais de l\'État (Tranche 1)', '2026-08-16 10:32:20', '2026-08-16 10:32:20'),
(14, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 11:02:26', '2026-08-16 11:02:26'),
(15, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 11:02:49', '2026-08-16 11:02:49'),
(16, 1, 'Création d\'une année scolaire : 2025-2026', '2026-08-16 14:11:52', '2026-08-16 14:11:52'),
(17, 1, 'Création d\'une année scolaire : 2024-2025', '2026-08-16 18:02:35', '2026-08-16 18:02:35'),
(18, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 18:02:39', '2026-08-16 18:02:39'),
(19, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 18:02:42', '2026-08-16 18:02:42'),
(20, 1, 'Création d\'une année scolaire : 2024-2026', '2026-08-16 18:02:58', '2026-08-16 18:02:58'),
(21, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 18:03:02', '2026-08-16 18:03:02'),
(22, 1, 'Mise à jour de l\'année scolaire : 2024-2026', '2026-08-16 18:10:48', '2026-08-16 18:10:48'),
(23, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 19:20:36', '2026-08-16 19:20:36'),
(24, 1, 'Mise à jour de l\'année scolaire : 2024-2026', '2026-08-16 19:20:39', '2026-08-16 19:20:39'),
(25, 1, 'Mise à jour de l\'année scolaire : 2024-2026', '2026-08-16 21:21:29', '2026-08-16 21:21:29'),
(26, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 21:21:32', '2026-08-16 21:21:32'),
(27, 1, 'Mise à jour de la section : Primairedd', '2026-08-16 21:27:11', '2026-08-16 21:27:11'),
(28, 1, 'Mise à jour de la section : Primaire', '2026-08-16 21:27:25', '2026-08-16 21:27:25'),
(29, 1, 'Création d\'une nouvelle section : secondaire', '2026-08-16 21:27:35', '2026-08-16 21:27:35'),
(30, 1, 'Suppression de la section : secondaire', '2026-08-16 21:27:39', '2026-08-16 21:27:39'),
(31, 1, 'Création d\'une année scolaire : 2023-2024', '2026-08-16 21:28:00', '2026-08-16 21:28:00'),
(32, 1, 'Suppression de l\'année scolaire : 2023-2024', '2026-08-16 21:28:09', '2026-08-16 21:28:09'),
(33, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 21:37:01', '2026-08-16 21:37:01'),
(34, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-16 21:37:05', '2026-08-16 21:37:05'),
(35, 1, 'Mise à jour du contact : parfaitzix333@gmail.com', '2026-08-16 21:38:54', '2026-08-16 21:38:54'),
(36, 1, 'Mise à jour du contact : parfaitzix333@gmail.com', '2026-08-16 21:39:01', '2026-08-16 21:39:01'),
(37, 1, 'Création d\'un frais : Minerval janvier', '2026-08-16 21:48:57', '2026-08-16 21:48:57'),
(38, 1, 'Mise à jour du frais : Frais de l\'État (Tranche 1)', '2026-08-16 21:49:35', '2026-08-16 21:49:35'),
(39, 1, 'Mise à jour du frais : Minerval janvier', '2026-08-16 21:51:06', '2026-08-16 21:51:06'),
(40, 1, 'Mise à jour du frais : Minerval janvier', '2026-08-16 21:51:18', '2026-08-16 21:51:18'),
(41, 1, 'Mise à jour du frais : Minerval janvier', '2026-08-16 21:51:27', '2026-08-16 21:51:27'),
(42, 1, 'Mise à jour du frais : Minerval janvier', '2026-08-16 21:52:13', '2026-08-16 21:52:13'),
(43, 1, 'Mise à jour du frais : Minerval janvier', '2026-08-16 21:55:05', '2026-08-16 21:55:05'),
(44, 1, 'Mise à jour du frais : Minerval janvier', '2026-08-16 21:55:30', '2026-08-16 21:55:30'),
(45, 1, 'Mise à jour du frais : Minerval janvier xx', '2026-08-16 21:55:40', '2026-08-16 21:55:40'),
(46, 1, 'Mise à jour du frais : Frais de l\'État (Tranche 1)', '2026-08-16 21:55:50', '2026-08-16 21:55:50'),
(47, 1, 'Mise à jour du frais : Minerval janvier', '2026-08-16 21:55:59', '2026-08-16 21:55:59'),
(48, 1, 'Mise à jour de la classe : 1ère Maternelle', '2026-08-16 22:37:33', '2026-08-16 22:37:33'),
(49, 1, 'Création d\'un enseignant : Lufungula Patrick', '2026-08-16 23:10:57', '2026-08-16 23:10:57'),
(50, 1, 'Mise à jour de l\'enseignant : Lufungula Patrick', '2026-08-16 23:39:57', '2026-08-16 23:39:57'),
(51, 1, 'Mise à jour de l\'enseignant : Lufungula Patrick', '2026-08-16 23:40:03', '2026-08-16 23:40:03'),
(52, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-17 00:40:12', '2026-08-17 00:40:12'),
(53, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-17 00:40:16', '2026-08-17 00:40:16'),
(54, 1, 'Création d\'un élève : Mumba Kisimba Boaz', '2026-08-17 02:14:40', '2026-08-17 02:14:40'),
(55, 1, 'Mise à jour de l\'élève : Mumba Kisimba Boaz', '2026-08-17 02:15:44', '2026-08-17 02:15:44'),
(56, 1, 'Mise à jour de l\'élève : Mumba Kisimba Boaz', '2026-08-17 08:57:56', '2026-08-17 08:57:56'),
(57, 1, 'Mise à jour de l\'élève : Mumba Kisimba Boaz', '2026-08-17 08:58:12', '2026-08-17 08:58:12'),
(58, 1, 'Création d\'un élève : Hemedi Kalonda Ben', '2026-08-17 09:12:57', '2026-08-17 09:12:57'),
(59, 1, 'Mise à jour de l\'élève : Hemedi Kalonda Ben', '2026-08-17 09:19:49', '2026-08-17 09:19:49'),
(60, 1, 'Création d\'une classe : 2è Maternelle', '2026-08-17 17:28:49', '2026-08-17 17:28:49'),
(61, 1, 'Création d\'une classe : 3è Maternelle', '2026-08-17 17:29:55', '2026-08-17 17:29:55'),
(62, 1, 'Création d\'un frais : frais de l\'etat (Tranche 2)', '2026-08-17 21:28:57', '2026-08-17 21:28:57'),
(63, 1, 'Création d\'un frais : Minerval Février', '2026-08-17 21:32:05', '2026-08-17 21:32:05'),
(64, 1, 'Création d\'un frais : Minerval marse', '2026-08-17 21:32:41', '2026-08-17 21:32:41'),
(65, 1, 'Création d\'un frais : Frais d\'inscription', '2026-08-17 21:33:56', '2026-08-17 21:33:56'),
(66, 1, 'Création d\'un paiement pour l\'élève : Hemedi Kalonda Ben - Montant : 20', '2026-08-17 21:39:38', '2026-08-17 21:39:38'),
(67, 1, 'Création d\'un paiement pour l\'élève : Hemedi Kalonda Ben - Montant : 5', '2026-08-17 21:40:38', '2026-08-17 21:40:38'),
(68, 1, 'Mise à jour de l\'année scolaire : 2024-2025', '2026-08-17 22:31:48', '2026-08-17 22:31:48'),
(69, 1, 'Mise à jour de l\'année scolaire : 2024-2026', '2026-08-17 22:31:51', '2026-08-17 22:31:51'),
(78, 1, 'Mise à jour du paiement ID: 2', '2026-08-18 12:42:30', '2026-08-18 12:42:30'),
(79, 1, 'Mise à jour du paiement ID: 1', '2026-08-18 12:42:43', '2026-08-18 12:42:43'),
(80, 1, 'Mise à jour du paiement ID: 3', '2026-08-18 13:23:38', '2026-08-18 13:23:38'),
(81, 1, 'Mise à jour du paiement ID: 3', '2026-08-19 01:20:42', '2026-08-19 01:20:42'),
(82, 1, 'Création d\'un paiement pour l\'élève : Hemedi Kalonda Ben - Montant : 50.00', '2026-08-19 01:23:07', '2026-08-19 01:23:07'),
(83, 1, 'Mise à jour du paiement ID: 6', '2026-08-19 01:24:06', '2026-08-19 01:24:06'),
(84, 1, 'Suppression du paiement ID: 3', '2026-08-19 02:08:09', '2026-08-19 02:08:09'),
(85, 1, 'Création d\'un paiement pour l\'élève : Hemedi Kalonda Ben - Montant : 40', '2026-08-19 09:14:58', '2026-08-19 09:14:58'),
(86, 1, 'Mise à jour du paiement ID: 8', '2026-08-19 09:25:38', '2026-08-19 09:25:38'),
(87, 1, 'Mise à jour du paiement ID: 6', '2026-08-19 09:55:00', '2026-08-19 09:55:00'),
(88, 1, 'Mise à jour du contact : parfaitzix333@gmail.com', '2026-08-19 10:42:53', '2026-08-19 10:42:53'),
(89, 1, 'Mise à jour de la classe : 1ère Maternelle', '2026-08-19 10:50:19', '2026-08-19 10:50:19'),
(90, 3, 'Mise à jour de l\'élève : Mumba Kisimba Boaz', '2026-08-19 16:41:25', '2026-08-19 16:41:25'),
(91, 1, 'Mise à jour de l\'élève : Hemedi Kalonda Ben', '2026-08-19 19:49:26', '2026-08-19 19:49:26'),
(92, 1, 'Mise à jour du frais : Frais de l\'État (Tranche 1)', '2026-08-19 22:23:04', '2026-08-19 22:23:04'),
(93, 1, 'Mise à jour du frais : Minerval janvier', '2026-08-19 22:23:08', '2026-08-19 22:23:08'),
(94, 3, 'Mise à jour du paiement ID: 6', '2026-08-19 23:21:57', '2026-08-19 23:21:57'),
(95, 3, 'Mise à jour du paiement ID: 2', '2026-08-19 23:22:07', '2026-08-19 23:22:07'),
(96, 1, 'Mise à jour de l\'utilisateur : admin', '2026-08-19 23:42:40', '2026-08-19 23:42:40'),
(97, 1, 'Mise à jour de l\'utilisateur : Ruth Mputu', '2026-08-19 23:43:06', '2026-08-19 23:43:06'),
(98, 1, 'Mise à jour de l\'utilisateur : Ruth Mputu', '2026-08-19 23:45:20', '2026-08-19 23:45:20'),
(99, 1, 'Mise à jour de l\'enseignant : Lufungula Patrick', '2026-08-20 01:04:34', '2026-08-20 01:04:34'),
(100, 1, 'Mise à jour de l\'enseignant : numbi guelord', '2026-08-20 01:04:53', '2026-08-20 01:04:53'),
(101, 1, 'Mise à jour de l\'enseignant : numbi guelord', '2026-08-20 01:22:01', '2026-08-20 01:22:01'),
(102, 1, 'Mise à jour de l\'enseignant : numbi guelord', '2026-08-20 01:24:35', '2026-08-20 01:24:35'),
(103, 1, 'Mise à jour de l\'enseignant : numbi guelord', '2026-08-20 01:25:06', '2026-08-20 01:25:06'),
(104, 1, 'Mise à jour de l\'enseignant : numbi guelord', '2026-08-20 23:45:36', '2026-08-20 23:45:36'),
(105, 1, 'Mise à jour du frais : Minerval janvier', '2026-08-21 00:19:56', '2026-08-21 00:19:56'),
(106, 1, 'Mise à jour de l\'année scolaire : 2023-2024', '2026-08-21 01:39:27', '2026-08-21 01:39:27'),
(107, 3, 'Création d\'un paiement pour l\'élève : Ngoy Bliss - Montant : 10.00', '2026-08-21 01:44:50', '2026-08-21 01:44:50'),
(108, 1, 'Mise à jour de la section : Maternelle', '2026-08-21 13:04:44', '2026-08-21 13:04:44'),
(109, 1, 'Mise à jour de l\'utilisateur : Ruth Mputu', '2026-08-21 14:03:42', '2026-08-21 14:03:42'),
(110, 1, 'Mise à jour de l\'utilisateur : Ruth Mputu', '2026-08-21 14:04:31', '2026-08-21 14:04:31'),
(111, 1, 'Création d\'une année scolaire : 2022-2023', '2026-08-21 14:13:08', '2026-08-21 14:13:08'),
(112, 1, 'Création d\'un enseignant : Henoc Dyanda', '2026-08-21 22:41:46', '2026-08-21 22:41:46'),
(113, 1, 'Création d\'un enseignant : Marcella', '2026-08-22 00:28:43', '2026-08-22 00:28:43'),
(114, 1, 'Mise à jour de l\'enseignant : Henoc Dyanda', '2026-08-22 01:00:13', '2026-08-22 01:00:13'),
(115, 1, 'Mise à jour de l\'enseignant : Henoc Dyanda', '2026-08-22 01:00:53', '2026-08-22 01:00:53');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(15, '0001_01_01_000000_create_users_table', 1),
(16, '0001_01_01_000001_create_cache_table', 1),
(17, '0001_01_01_000002_create_jobs_table', 1),
(19, '2026_08_14_222516_create_sections_table', 1),
(20, '2026_08_14_222535_create_classes_table', 1),
(21, '2026_08_14_222620_create_frais_table', 1),
(22, '2026_08_14_222644_create_eleves_table', 1),
(24, '2026_08_14_222727_create_historiques_table', 1),
(25, '2026_08_14_230512_create_enseignants_table', 1),
(26, '2026_08_14_235417_create_contacts_table', 1),
(27, '2026_08_14_235438_create_proprietes_table', 1),
(28, '2026_08_15_000606_create_retours_table', 1),
(29, '2026_08_14_222701_create_paiements_table', 2),
(30, '2026_08_14_222503_create_annee_scolaires_table', 3);

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE `paiements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `eleve_id` bigint(20) UNSIGNED NOT NULL,
  `frais_id` bigint(20) UNSIGNED NOT NULL,
  `classe_id` bigint(20) UNSIGNED NOT NULL,
  `annee_scolaire_id` bigint(20) UNSIGNED NOT NULL,
  `date_limite` date NOT NULL,
  `mode_paiement` varchar(255) NOT NULL,
  `devise` varchar(10) NOT NULL DEFAULT '$',
  `statut` enum('acompte','payé') NOT NULL DEFAULT 'acompte',
  `montant_en_lettre` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `paiements`
--

INSERT INTO `paiements` (`id`, `montant`, `eleve_id`, `frais_id`, `classe_id`, `annee_scolaire_id`, `date_limite`, `mode_paiement`, `devise`, `statut`, `montant_en_lettre`, `created_at`, `updated_at`) VALUES
(1, 20.00, 2, 1, 1, 1, '2026-09-01', 'Espece', '$', 'payé', 'vingt', '2026-08-17 21:39:38', '2026-08-18 12:42:43'),
(2, 5.00, 2, 3, 1, 1, '2026-08-31', 'Espece', '$', 'acompte', 'Cinq $', '2026-08-17 21:40:38', '2026-08-19 23:22:07'),
(6, 50.00, 2, 5, 1, 1, '2026-09-01', 'Mobile Money', '$', 'payé', 'Cinquante $', '2026-08-19 01:23:07', '2026-08-19 09:55:00'),
(8, 40.00, 2, 2, 1, 1, '2026-09-02', 'Espèce', '$', 'acompte', 'Quarante $', '2026-08-19 09:14:58', '2026-08-19 09:25:38'),
(9, 10.00, 3, 6, 2, 1, '2026-09-01', 'Espèce', '$', 'payé', 'Dix $', '2026-08-21 01:44:50', '2026-08-21 01:44:50');

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `proprietes`
--

CREATE TABLE `proprietes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(300) DEFAULT NULL,
  `information` varchar(2000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `proprietes`
--

INSERT INTO `proprietes` (`id`, `titre`, `information`, `created_at`, `updated_at`) VALUES
(1, 'A propos de Nous', 'Nous somme une institution scolaire biling (Francais-Anglais).', '2026-08-16 10:08:23', '2026-08-16 10:08:23');

-- --------------------------------------------------------

--
-- Structure de la table `retours`
--

CREATE TABLE `retours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `couriel` varchar(255) DEFAULT NULL,
  `avis` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sections`
--

INSERT INTO `sections` (`id`, `designation`, `created_at`, `updated_at`) VALUES
(1, 'Primaire', '2026-08-16 10:03:27', '2026-08-16 21:27:25'),
(2, 'Maternelle', '2026-08-16 10:03:39', '2026-08-16 10:03:39');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('mCGXljD7cTEslUlwWFPaFrpiiLhXPxxJO6W1Dd5x', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:147.0) Gecko/20100101 Firefox/147.0', 'eyJfdG9rZW4iOiJUaXRXalJVT285UTlIaEYzdUZ6d25MNzFBVEtDU09POVhLSFdxTFZ2IiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2Vuc2VpZ25hbnRzIn0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvcHJvZmlsZV9wcm9tb3RldXIiLCJyb3V0ZSI6InByb2ZpbGVfcHJvbW90ZXVyIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9', 1787388007);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `matricule` varchar(255) DEFAULT NULL,
  `role` enum('user','promoteur','comptable','enseignant','suspendu') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `anne_scolaire_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `matricule`, `role`, `remember_token`, `created_at`, `updated_at`, `anne_scolaire_id`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$RwiEFgTEJUHKesGk7krMeuv5Vtgsw.tsM0tLk0GpuQDYFmnVtmXAW', NULL, 'promoteur', 'vLMELB898cCl8GF6KPuklLkdwI0hQPVhzPcj4YYd6xKekI9Y2u4aRdG2Oyqa', '2026-08-15 07:26:13', '2026-08-21 12:20:42', 1),
(2, 'numbi', 'numbi@gmail.com', NULL, '$2y$12$hsS/nZGJ4d1BUHeo0lNLyu8Wtq.Dy4lvApHBa/7ORNryFjMJrncIa', NULL, 'enseignant', NULL, '2026-08-15 20:31:57', '2026-08-21 00:22:24', 1),
(3, 'Ruth Mputu', 'ruth@gmail.com', NULL, '$2y$12$V.RZnh7mgpGOizTSbF5la..87LiPYZP2o3o7xNe9TZEDECRDN14oy', NULL, 'comptable', NULL, '2026-08-17 09:59:41', '2026-08-21 14:04:31', 1),
(4, 'Henoc Dyanda', 'henoc@gmail.com', NULL, '$2y$12$nXdv30FA4DhK6trVlSblWerBmNvUtlUGL/kGEy4RfAEc59auCorsq', '202', 'enseignant', NULL, '2026-08-21 22:43:41', '2026-08-21 22:43:41', NULL),
(7, 'Marcella2', 'marcella@gmail.com', NULL, '$2y$12$RTbr398vDROS2LYnCaAkquSFZ52XbGvOK36l8NXc4mmtbCgyYkrjK', '203', 'enseignant', NULL, '2026-08-22 00:46:10', '2026-08-22 00:46:10', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annee_scolaires`
--
ALTER TABLE `annee_scolaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `classes_designation_annee_scolaire_id_unique` (`designation`,`annee_scolaire_id`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `eleves`
--
ALTER TABLE `eleves`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eleves_matricule_annee_scolaire_id_unique` (`matricule`,`annee_scolaire_id`),
  ADD UNIQUE KEY `eleves_matricule_unique` (`matricule`);

--
-- Index pour la table `enseignants`
--
ALTER TABLE `enseignants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enseignants_matricule_unique` (`matricule`),
  ADD UNIQUE KEY `enseignants_user_id_classe_id_unique` (`user_id`,`classe_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Index pour la table `frais`
--
ALTER TABLE `frais`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `frais_designation_classe_id_annee_scolaire_id_unique` (`designation`,`classe_id`,`annee_scolaire_id`);

--
-- Index pour la table `historiques`
--
ALTER TABLE `historiques`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `paiements_eleve_id_frais_id_unique` (`eleve_id`,`frais_id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `proprietes`
--
ALTER TABLE `proprietes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `retours`
--
ALTER TABLE `retours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annee_scolaires`
--
ALTER TABLE `annee_scolaires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `eleves`
--
ALTER TABLE `eleves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `enseignants`
--
ALTER TABLE `enseignants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `frais`
--
ALTER TABLE `frais`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `historiques`
--
ALTER TABLE `historiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `proprietes`
--
ALTER TABLE `proprietes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `retours`
--
ALTER TABLE `retours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
