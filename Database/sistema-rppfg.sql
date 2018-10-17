-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 17, 2018 at 06:00 PM
-- Server version: 10.3.9-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistema-rppfg`
--
CREATE DATABASE IF NOT EXISTS `sistema-rppfg` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sistema-rppfg`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$iI/OOi2A6CMKCGmuA5kK6.NTMIDPSDRcV3OhyogBmjl5WlJF8TRCe', '2018-10-13 21:12:06', '2018-10-13 21:12:06'),
(2, 'marcolian', '$2y$10$zMtJatIPxc2y833u4UEE7uZftvbyIxNMmgWh1nIhrpJFSvwlej3hS', '2018-10-13 21:29:33', '2018-10-13 21:29:33'),
(18, 'jaimebaz', '$2y$10$7OyVZLTQUZNJlvKy6eSQtuIf3HbHvIcxddK8wRQBE9R4JBYU61z9K', '2018-10-12 03:40:21', '2018-10-12 03:40:21'),
(21, 'mayk', '$2y$10$S8Je.AJar2s0kU4n7KVoLe3j0SxsyMY4BbNecmuSOEo/4t6p5DdAy', '2018-10-12 14:43:23', '2018-10-12 14:43:23'),
(22, 'miguel', '$2y$10$vli4JX9b/ZGS/ScDGiKv3O6F6KPUcAcPORlzzBrJT3cDQInNBwmTu', '2018-10-13 03:02:01', '2018-10-13 03:02:01'),
(23, 'admin22', '$2y$10$iI/OOi2A6CMKCGmuA5kK6.NTMIDPSDRcV3OhyogBmjl5WlJF8TRCe', '2018-10-13 21:12:06', '2018-10-13 21:12:06'),
(25, 'christian', '$2y$10$jO3Qa6a0NY5vLKvz025j3.LwOUUMa6NZlYncnA1/27pX2ZpKZ1P36', '2018-10-14 23:33:08', '2018-10-14 23:33:08');

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `l_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ml_name` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `phone` int(8) DEFAULT NULL,
  `email` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `avatar` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_account` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ID_ACCOUNT` (`id_account`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`, `name`, `l_name`, `ml_name`, `phone`, `email`, `address`, `avatar`, `id_account`, `created_at`, `updated_at`) VALUES
(1, '_', '_', NULL, NULL, '_', NULL, NULL, 1, '2018-10-13 16:10:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE IF NOT EXISTS `area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_area` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `desc_area` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `name_area`, `desc_area`, `created_at`, `updated_at`) VALUES
(7, 'Redes de computadoras', 'El campo más amplio de la ciencia de la computación teórica a la computación y una amplia gama de otros temas que se centran en los aspectos más abstractos, lógicos y matemáticos de la computación.', '2018-10-12 21:13:40', '2018-10-16 01:13:43');

-- --------------------------------------------------------

--
-- Table structure for table `a_degree`
--

DROP TABLE IF EXISTS `a_degree`;
CREATE TABLE IF NOT EXISTS `a_degree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_ad` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `a_degree`
--

INSERT INTO `a_degree` (`id`, `name_ad`) VALUES
(1, 'Ing.'),
(2, 'Lic.'),
(3, 'Msc.'),
(4, 'Msc. Ing.'),
(5, 'Msc. Lic.');

-- --------------------------------------------------------

--
-- Table structure for table `is_registered`
--

DROP TABLE IF EXISTS `is_registered`;
CREATE TABLE IF NOT EXISTS `is_registered` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ci` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `sigla_mat` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `is_registered`
--

INSERT INTO `is_registered` (`id`, `ci`, `sigla_mat`, `created_at`, `updated_at`) VALUES
(1, '369963', 'tg-2010214', '2018-10-11 02:11:00', '0000-00-00 00:00:00'),
(2, '258852', 'tg-2010214', '2018-10-11 06:05:00', '0000-00-00 00:00:00'),
(3, '147741', 'tg-2010214', '2018-10-11 10:04:00', '0000-00-00 00:00:00'),
(4, '963369', 'tg-2010214', '2018-10-11 03:10:10', '0000-00-00 00:00:00'),
(5, '852258', 'tg-2010214', '2018-10-11 04:36:00', '0000-00-00 00:00:00'),
(6, '741147', 'tg-2010214', '2018-10-11 15:11:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `postulant`
--

DROP TABLE IF EXISTS `postulant`;
CREATE TABLE IF NOT EXISTS `postulant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ci` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `l_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ml_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `phone` int(8) DEFAULT NULL,
  `address` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `avatar` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cod_sis` int(9) NOT NULL,
  `id_account` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ID_ACCOUNT` (`id_account`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `postulant`
--

INSERT INTO `postulant` (`id`, `ci`, `name`, `l_name`, `ml_name`, `email`, `phone`, `address`, `avatar`, `cod_sis`, `id_account`, `created_at`, `updated_at`) VALUES
(4, '369963', 'jaime', 'Bazualdo', 'acosta', 'jara@gmail.com', NULL, NULL, NULL, 0, 18, '2018-10-12 03:40:21', '2018-10-12 03:40:21'),
(5, '852258', 'maykel', 'canedo', 'prado', 'mayk_21@gamil.com', NULL, NULL, NULL, 0, 21, '2018-10-12 14:43:23', '2018-10-12 14:43:23'),
(6, '741147', 'miguel', 'villanuea', 'kjkjkjk', 'juchanidb@gmail.com', NULL, NULL, NULL, 0, 22, '2018-10-13 03:02:01', '2018-10-13 03:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `professional_ext`
--

DROP TABLE IF EXISTS `professional_ext`;
CREATE TABLE IF NOT EXISTS `professional_ext` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ci` int(10) NOT NULL,
  `name` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `l_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ml_name` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `avatar` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `a_degree` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `profile` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_account` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ID_ACCOUNT` (`id_account`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `professional_ext`
--

INSERT INTO `professional_ext` (`id`, `ci`, `name`, `l_name`, `ml_name`, `email`, `address`, `avatar`, `a_degree`, `profile`, `id_account`, `created_at`, `updated_at`) VALUES
(1, 232323, 'otro', 'otro', 'otro', 'juchanidb@gmail.com', NULL, NULL, NULL, NULL, 23, '2018-10-13 21:12:06', '2018-10-13 21:12:06');

-- --------------------------------------------------------

--
-- Table structure for table `professional_umss`
--

DROP TABLE IF EXISTS `professional_umss`;
CREATE TABLE IF NOT EXISTS `professional_umss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ci` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `l_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ml_name` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `phone` int(8) DEFAULT NULL,
  `address` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `avatar` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cod_sis` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_a_degree` int(11) NOT NULL,
  `id_workload` int(11) NOT NULL,
  `profile` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_account` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ID_ACCOUNT` (`id_account`),
  KEY `FK_ID_A_DEGREE` (`id_a_degree`) USING BTREE,
  KEY `FK_ID_WORKLOAD` (`id_workload`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `professional_umss`
--

INSERT INTO `professional_umss` (`id`, `ci`, `name`, `l_name`, `ml_name`, `email`, `phone`, `address`, `avatar`, `cod_sis`, `id_a_degree`, `id_workload`, `profile`, `id_account`, `created_at`, `updated_at`) VALUES
(1, '5642123', 'Marco Julian', 'Navarro', 'Flores', 'marcolian@gmail.com', NULL, NULL, NULL, NULL, 1, 2, NULL, 2, '2018-10-13 21:29:33', '2018-10-13 21:29:33'),
(9, '7900012', 'Christian', 'Villazon', 'Alcocer', 'christian91@outlook.com', NULL, NULL, NULL, NULL, 2, 1, NULL, 25, '2018-10-14 23:33:08', '2018-10-14 23:33:08');

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_rol` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id`, `name_rol`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2018-10-01 09:25:00', '0000-00-00 00:00:00'),
(2, 'director', '2018-10-01 14:20:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `subarea`
--

DROP TABLE IF EXISTS `subarea`;
CREATE TABLE IF NOT EXISTS `subarea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_subarea` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `desc_subarea` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_area` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_area` (`id_area`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `subarea`
--

INSERT INTO `subarea` (`id`, `name_subarea`, `desc_subarea`, `id_area`, `created_at`, `updated_at`) VALUES
(10, 'Redes WIFI', '', 7, '2018-10-12 21:20:27', '2018-10-12 21:20:27'),
(11, 'Redes LAN', 'Red LAN conecta diferentes ordenadores en un área pequeña, como un edificio o una habitación, lo que permite a los usuarios enviar, compartir y recibir archivos. Un sistema de redes LAN conectadas mediante líneas telefónicas se denomina WAN \"Wide-Area Network\", es decir, es una red de área ancha.', 7, '2018-10-12 21:21:23', '2018-10-12 21:21:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_rol`
--

DROP TABLE IF EXISTS `user_rol`;
CREATE TABLE IF NOT EXISTS `user_rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_account` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ID_ACCOUNT` (`id_account`),
  KEY `FK_ID_ROL` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `user_rol`
--

INSERT INTO `user_rol` (`id`, `id_account`, `id_rol`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2018-10-13 10:20:00', '0000-00-00 00:00:00'),
(2, 2, 2, '2018-10-13 11:12:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `workload`
--

DROP TABLE IF EXISTS `workload`;
CREATE TABLE IF NOT EXISTS `workload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_wl` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workload`
--

INSERT INTO `workload` (`id`, `name_wl`) VALUES
(1, 'Tiempo Parcial'),
(2, 'Tiempo Completo');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `postulant`
--
ALTER TABLE `postulant`
  ADD CONSTRAINT `postulant_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professional_ext`
--
ALTER TABLE `professional_ext`
  ADD CONSTRAINT `professional_ext_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professional_umss`
--
ALTER TABLE `professional_umss`
  ADD CONSTRAINT `professional_umss_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `professional_umss_ibfk_2` FOREIGN KEY (`id_a_degree`) REFERENCES `a_degree` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `professional_umss_ibfk_3` FOREIGN KEY (`id_workload`) REFERENCES `workload` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `subarea`
--
ALTER TABLE `subarea`
  ADD CONSTRAINT `subarea_ibfk_1` FOREIGN KEY (`id_area`) REFERENCES `area` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_rol`
--
ALTER TABLE `user_rol`
  ADD CONSTRAINT `user_rol_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_rol_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
