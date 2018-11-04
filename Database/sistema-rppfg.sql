-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 03, 2018 at 03:04 PM
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
  `username` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$t3wvVOaVBZZc/9iEyOGq9eaJS7uJ5ehq13Ysh7CODiLsXLgnaCi0i', '2018-10-13 21:12:06', '2018-10-19 02:36:00'),
(44, 'jnavarro345356', '$2y$10$J9vFESlAj1uEnY0rOZAeEeRX/klC44mHoEPzMHxRUvx2uPIn9LvQu', '2018-10-21 05:29:37', '2018-10-21 05:29:37');

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `l_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ml_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ci` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` int(8) DEFAULT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_account` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ID_ACCOUNT` (`id_account`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`, `name`, `l_name`, `ml_name`, `ci`, `phone`, `email`, `address`, `avatar`, `id_account`, `created_at`, `updated_at`) VALUES
(1, 'Santiago diego', 'Valencia', 'Mendez', '5678545', 4454555, 'valencia.re@gmail.com', '6 de agosto # 43', '', 1, '2018-10-13 16:10:00', '2018-10-21 05:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE IF NOT EXISTS `area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_area` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_area` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `id_parent_area` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_area` (`name_area`),
  KEY `FK_PARENT_AREA` (`id_parent_area`)
) ENGINE=InnoDB AUTO_INCREMENT=625 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_degree`
--

DROP TABLE IF EXISTS `a_degree`;
CREATE TABLE IF NOT EXISTS `a_degree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_ad` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_ad` (`name_ad`)
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
-- Table structure for table `career`
--

DROP TABLE IF EXISTS `career`;
CREATE TABLE IF NOT EXISTS `career` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `is_registered`
--

DROP TABLE IF EXISTS `is_registered`;
CREATE TABLE IF NOT EXISTS `is_registered` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ci` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sigla_mat` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `modality`
--

DROP TABLE IF EXISTS `modality`;
CREATE TABLE IF NOT EXISTS `modality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_mod` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_mod` (`name_mod`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modality`
--

INSERT INTO `modality` (`id`, `name_mod`) VALUES
(1, 'Adscripción'),
(2, 'Proyecto de Grado'),
(4, 'Proyecto de Investigación (Tesis)'),
(3, 'Trabajo Dirigido');

-- --------------------------------------------------------

--
-- Table structure for table `period`
--

DROP TABLE IF EXISTS `period`;
CREATE TABLE IF NOT EXISTS `period` (
  `id` int(11) NOT NULL,
  `period` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `period`
--

INSERT INTO `period` (`id`, `period`) VALUES
(1, '1'),
(2, '2');

-- --------------------------------------------------------

--
-- Table structure for table `postulant`
--

DROP TABLE IF EXISTS `postulant`;
CREATE TABLE IF NOT EXISTS `postulant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ci` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `l_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ml_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` int(8) DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_sis` int(9) NOT NULL,
  `id_career` int(11) NOT NULL,
  `id_account` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ID_ACCOUNT` (`id_account`),
  KEY `FK__CAREER` (`id_career`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `professionalumssview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `professionalumssview`;
CREATE TABLE IF NOT EXISTS `professionalumssview` (
`id` int(11)
,`full_name` varchar(83)
,`email` varchar(30)
,`phone` int(8)
,`address` varchar(50)
,`name_wl` varchar(15)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `professionalview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `professionalview`;
CREATE TABLE IF NOT EXISTS `professionalview` (
`id_professional` int(11)
,`name` varchar(30)
,`l_name` varchar(20)
,`ml_name` varchar(20)
,`address` varchar(50)
,`avatar` varchar(200)
,`ci` varchar(11)
,`created_at` datetime
,`email` varchar(30)
,`profile` mediumtext
,`updated_at` datetime
,`name_ad` varchar(10)
);

-- --------------------------------------------------------

--
-- Table structure for table `professional_area_subarea`
--

DROP TABLE IF EXISTS `professional_area_subarea`;
CREATE TABLE IF NOT EXISTS `professional_area_subarea` (
  `id_professional_account` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `id_sub_area` int(11) NOT NULL,
  KEY `FK_AREA` (`id_area`),
  KEY `FK_SUB_AREA` (`id_sub_area`),
  KEY `FK_PROF_ACCOUNT` (`id_professional_account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `professional_ext`
--

DROP TABLE IF EXISTS `professional_ext`;
CREATE TABLE IF NOT EXISTS `professional_ext` (
  `id_prof` int(11) NOT NULL AUTO_INCREMENT,
  `ci` int(10) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `l_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ml_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_a_degree` int(11) NOT NULL DEFAULT 2,
  `profile` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_account` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_prof`),
  KEY `FK_ID_ACCOUNT` (`id_account`),
  KEY `FK_ID_A_DEGREE` (`id_a_degree`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `professional_umss`
--

DROP TABLE IF EXISTS `professional_umss`;
CREATE TABLE IF NOT EXISTS `professional_umss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ci` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `l_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ml_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` int(8) DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_sis` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_a_degree` int(11) NOT NULL,
  `id_workload` int(11) NOT NULL,
  `profile` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_account` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ID_A_DEGREE` (`id_a_degree`) USING BTREE,
  KEY `FK_ID_WORKLOAD` (`id_workload`) USING BTREE,
  KEY `FK_ID_ACCOUNT` (`id_account`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `professional_umss`
--

INSERT INTO `professional_umss` (`id`, `ci`, `name`, `l_name`, `ml_name`, `email`, `phone`, `address`, `avatar`, `cod_sis`, `id_a_degree`, `id_workload`, `profile`, `id_account`, `created_at`, `updated_at`) VALUES
(1, '7900012', 'Christian', 'Villazon', 'Alcocer', 'christian91@outlook.com', NULL, NULL, NULL, NULL, 1, 2, NULL, 44, '2018-10-14 23:33:08', '2018-10-14 23:33:08');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(11) NOT NULL,
  `title` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `general_obj` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_period` int(11) NOT NULL,
  `registry_date` date DEFAULT current_timestamp(),
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp(),
  `id_modality` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `id_subarea` int(11) DEFAULT NULL,
  `id_area_2` int(11) DEFAULT NULL,
  `id_subarea_2` int(11) DEFAULT NULL,
  `id_postulant` int(11) NOT NULL,
  `id_postulant_2` int(11) DEFAULT NULL,
  `id_professional_umss` int(11) NOT NULL,
  `id_tutor` int(11) NOT NULL,
  `id_tutor_2` int(11) DEFAULT NULL,
  `id_status` int(11) NOT NULL,
  `id_career` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_AREA_1` (`id_area`),
  KEY `FK_AREA_2` (`id_area_2`),
  KEY `FK_MODALITY` (`id_modality`),
  KEY `FK_PERIOD` (`id_period`),
  KEY `FK_POSTULANT` (`id_postulant`),
  KEY `FK_POSTULANT_2` (`id_postulant_2`),
  KEY `FK_PROFESSIONAL_UMSS` (`id_professional_umss`),
  KEY `FK_STATUS` (`id_status`),
  KEY `FK_SUBAREA_1` (`id_subarea`),
  KEY `FK_SUBAREA_2` (`id_subarea_2`),
  KEY `FK_TUTOR_1` (`id_tutor`),
  KEY `FK_TUTOR_2` (`id_tutor_2`),
  KEY `FK_CAREER` (`id_career`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `name_rol` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id_rol`, `name_rol`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2018-10-01 09:25:00', '0000-00-00 00:00:00'),
(2, 'director', '2018-10-01 14:20:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

DROP TABLE IF EXISTS `tutor`;
CREATE TABLE IF NOT EXISTS `tutor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_professional` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__PROF_ACCOUNT` (`id_professional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_rol`
--

DROP TABLE IF EXISTS `user_rol`;
CREATE TABLE IF NOT EXISTS `user_rol` (
  `id_urol` int(11) NOT NULL AUTO_INCREMENT,
  `id_account` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_urol`),
  KEY `FK_ID_ACCOUNT` (`id_account`),
  KEY `FK_ID_ROL` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_rol`
--

INSERT INTO `user_rol` (`id_urol`, `id_account`, `id_rol`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2018-10-13 10:20:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `workload`
--

DROP TABLE IF EXISTS `workload`;
CREATE TABLE IF NOT EXISTS `workload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_wl` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_wl` (`name_wl`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workload`
--

INSERT INTO `workload` (`id`, `name_wl`) VALUES
(2, 'Tiempo Completo'),
(1, 'Tiempo Parcial');

-- --------------------------------------------------------

--
-- Structure for view `professionalumssview`
--
DROP TABLE IF EXISTS `professionalumssview`;

CREATE ALGORITHM=TEMPTABLE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `professionalumssview`  AS  select `p`.`id` AS `id`,concat(`d`.`name_ad`,' ',`p`.`l_name`,' ',`p`.`ml_name`,' ',`p`.`name`) AS `full_name`,`p`.`email` AS `email`,`p`.`phone` AS `phone`,`p`.`address` AS `address`,`w`.`name_wl` AS `name_wl` from ((`professional_umss` `p` join `a_degree` `d`) join `workload` `w`) where `p`.`id_a_degree` = `d`.`id` and `p`.`id_workload` = `w`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `professionalview`
--
DROP TABLE IF EXISTS `professionalview`;

CREATE ALGORITHM=TEMPTABLE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `professionalview`  AS  select `a`.`id` AS `id_professional`,`u`.`name` AS `name`,`u`.`l_name` AS `l_name`,`u`.`ml_name` AS `ml_name`,`u`.`address` AS `address`,`u`.`avatar` AS `avatar`,`u`.`ci` AS `ci`,`u`.`created_at` AS `created_at`,`u`.`email` AS `email`,`u`.`profile` AS `profile`,`u`.`updated_at` AS `updated_at`,`d`.`name_ad` AS `name_ad` from ((`account` `a` join `professional_umss` `u`) join `a_degree` `d`) where `u`.`id_account` = `a`.`id` and `u`.`id_a_degree` = `d`.`id` union all select `a`.`id` AS `id_professional`,`e`.`name` AS `name`,`e`.`l_name` AS `l_name`,`e`.`ml_name` AS `ml_name`,`e`.`address` AS `address`,`e`.`avatar` AS `avatar`,`e`.`ci` AS `ci`,`e`.`created_at` AS `created_at`,`e`.`email` AS `email`,`e`.`profile` AS `profile`,`e`.`updated_at` AS `updated_at`,`d`.`name_ad` AS `name_ad` from ((`account` `a` join `professional_ext` `e`) join `a_degree` `d`) where `e`.`id_account` = `a`.`id` and `e`.`id_a_degree` = `d`.`id` ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `FK_PARENT_AREA` FOREIGN KEY (`id_parent_area`) REFERENCES `area` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `postulant`
--
ALTER TABLE `postulant`
  ADD CONSTRAINT `FK_ACCOUNT` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK__CAREER` FOREIGN KEY (`id_career`) REFERENCES `career` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `professional_area_subarea`
--
ALTER TABLE `professional_area_subarea`
  ADD CONSTRAINT `FK_AREA` FOREIGN KEY (`id_area`) REFERENCES `area` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PROF_ACCOUNT` FOREIGN KEY (`id_professional_account`) REFERENCES `account` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SUB_AREA` FOREIGN KEY (`id_sub_area`) REFERENCES `area` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `professional_ext`
--
ALTER TABLE `professional_ext`
  ADD CONSTRAINT `professional_ext_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `professional_ext_ibfk_2` FOREIGN KEY (`id_a_degree`) REFERENCES `a_degree` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `professional_umss`
--
ALTER TABLE `professional_umss`
  ADD CONSTRAINT `professional_umss_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `professional_umss_ibfk_2` FOREIGN KEY (`id_a_degree`) REFERENCES `a_degree` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `professional_umss_ibfk_3` FOREIGN KEY (`id_workload`) REFERENCES `workload` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `FK_AREA_1` FOREIGN KEY (`id_area`) REFERENCES `area` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_AREA_2` FOREIGN KEY (`id_area_2`) REFERENCES `area` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAREER` FOREIGN KEY (`id_career`) REFERENCES `career` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_MODALITY` FOREIGN KEY (`id_modality`) REFERENCES `modality` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PERIOD` FOREIGN KEY (`id_period`) REFERENCES `period` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_POSTULANT` FOREIGN KEY (`id_postulant`) REFERENCES `postulant` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_POSTULANT_2` FOREIGN KEY (`id_postulant_2`) REFERENCES `postulant` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PROFESSIONAL_UMSS` FOREIGN KEY (`id_professional_umss`) REFERENCES `professional_umss` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_STATUS` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SUBAREA_1` FOREIGN KEY (`id_subarea`) REFERENCES `area` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SUBAREA_2` FOREIGN KEY (`id_subarea_2`) REFERENCES `area` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TUTOR_1` FOREIGN KEY (`id_tutor`) REFERENCES `tutor` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TUTOR_2` FOREIGN KEY (`id_tutor_2`) REFERENCES `tutor` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tutor`
--
ALTER TABLE `tutor`
  ADD CONSTRAINT `FK__PROF_ACCOUNT` FOREIGN KEY (`id_professional`) REFERENCES `account` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_rol`
--
ALTER TABLE `user_rol`
  ADD CONSTRAINT `user_rol_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_rol_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
