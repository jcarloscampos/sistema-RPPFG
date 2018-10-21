-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 21, 2018 at 04:08 PM
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
CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `username` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
CREATE TABLE `administrator` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `l_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ml_name` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ci` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `phone` int(8) DEFAULT NULL,
  `email` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `avatar` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_account` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `name_area` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `desc_area` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_degree`
--

DROP TABLE IF EXISTS `a_degree`;
CREATE TABLE `a_degree` (
  `id` int(11) NOT NULL,
  `name_ad` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
CREATE TABLE `is_registered` (
  `id` int(11) NOT NULL,
  `ci` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `sigla_mat` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
CREATE TABLE `modality` (
  `id` int(11) NOT NULL,
  `name_mod` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modality`
--

INSERT INTO `modality` (`id`, `name_mod`) VALUES
(1, 'Adscripción'),
(2, 'Proyecto de Grado'),
(3, 'Trabajo Dirigido'),
(4, 'Proyecto de Investigación (Tesis)');

-- --------------------------------------------------------

--
-- Table structure for table `postulant`
--

DROP TABLE IF EXISTS `postulant`;
CREATE TABLE `postulant` (
  `id` int(11) NOT NULL,
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
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `professionalumssview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `professionalumssview`;
CREATE TABLE `professionalumssview` (
`id` int(11)
,`full_name` varchar(83)
,`email` varchar(30)
,`phone` int(8)
,`address` varchar(50)
,`name_wl` varchar(15)
);

-- --------------------------------------------------------

--
-- Table structure for table `professional_ext`
--

DROP TABLE IF EXISTS `professional_ext`;
CREATE TABLE `professional_ext` (
  `id_prof` int(11) NOT NULL,
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
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `professional_umss`
--

DROP TABLE IF EXISTS `professional_umss`;
CREATE TABLE `professional_umss` (
  `id` int(11) NOT NULL,
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
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `name_rol` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id_rol`, `name_rol`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2018-10-01 09:25:00', '0000-00-00 00:00:00'),
(2, 'director', '2018-10-01 14:20:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `subarea`
--

DROP TABLE IF EXISTS `subarea`;
CREATE TABLE `subarea` (
  `id` int(11) NOT NULL,
  `name_subarea` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `desc_subarea` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_area` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_rol`
--

DROP TABLE IF EXISTS `user_rol`;
CREATE TABLE `user_rol` (
  `id_urol` int(11) NOT NULL,
  `id_account` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
CREATE TABLE `workload` (
  `id` int(11) NOT NULL,
  `name_wl` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_ACCOUNT` (`id_account`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_area` (`name_area`);

--
-- Indexes for table `a_degree`
--
ALTER TABLE `a_degree`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_ad` (`name_ad`);

--
-- Indexes for table `is_registered`
--
ALTER TABLE `is_registered`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modality`
--
ALTER TABLE `modality`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_mod` (`name_mod`);

--
-- Indexes for table `postulant`
--
ALTER TABLE `postulant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_ACCOUNT` (`id_account`);

--
-- Indexes for table `professional_ext`
--
ALTER TABLE `professional_ext`
  ADD PRIMARY KEY (`id_prof`),
  ADD KEY `FK_ID_ACCOUNT` (`id_account`);

--
-- Indexes for table `professional_umss`
--
ALTER TABLE `professional_umss`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_A_DEGREE` (`id_a_degree`) USING BTREE,
  ADD KEY `FK_ID_WORKLOAD` (`id_workload`) USING BTREE,
  ADD KEY `FK_ID_ACCOUNT` (`id_account`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indexes for table `subarea`
--
ALTER TABLE `subarea`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_area` (`id_area`);

--
-- Indexes for table `user_rol`
--
ALTER TABLE `user_rol`
  ADD PRIMARY KEY (`id_urol`),
  ADD KEY `FK_ID_ACCOUNT` (`id_account`),
  ADD KEY `FK_ID_ROL` (`id_rol`);

--
-- Indexes for table `workload`
--
ALTER TABLE `workload`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_wl` (`name_wl`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `a_degree`
--
ALTER TABLE `a_degree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `is_registered`
--
ALTER TABLE `is_registered`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `modality`
--
ALTER TABLE `modality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `postulant`
--
ALTER TABLE `postulant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `professional_ext`
--
ALTER TABLE `professional_ext`
  MODIFY `id_prof` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `professional_umss`
--
ALTER TABLE `professional_umss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subarea`
--
ALTER TABLE `subarea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_rol`
--
ALTER TABLE `user_rol`
  MODIFY `id_urol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `workload`
--
ALTER TABLE `workload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  ADD CONSTRAINT `user_rol_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
