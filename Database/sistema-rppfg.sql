-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 18, 2018 at 04:28 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
(25, 'christian', '$2y$10$jO3Qa6a0NY5vLKvz025j3.LwOUUMa6NZlYncnA1/27pX2ZpKZ1P36', '2018-10-14 23:33:08', '2018-10-14 23:33:08'),
(29, 'pab.aze', 'pab.aze.123', '2018-10-17 18:03:18', '2018-10-17 18:03:18'),
(30, 'vla.cos', 'vla.cos.123', '2018-10-17 18:03:18', '2018-10-17 18:03:18'),
(31, 'cor.flo', 'cor.flo.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(32, 'vic.mon', 'vic.mon.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(33, 'car.sal', 'car.sal.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(34, 'hen.vil', 'hen.vil.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(35, 'sam.ach', 'sam.ach.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(36, 'lui.agr', 'lui.agr.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(37, 'tat.apa', 'tat.apa.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(38, 'let.bla', 'let.bla.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(39, 'bor.cal', 'bor.cal.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(40, 'ind.cam', 'ind.cam.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(41, 'dav.esc', 'dav.esc.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(42, 'mar.flo', 'mar.flo.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(43, 'rol.jal', 'rol.jal.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(44, 'root', 'root.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(45, 'car.man', 'car.man.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(46, 'yon.mon', 'yon.mon.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(47, 'pat.rom', 'pat.rom.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(48, 'ro.sa', 'ro.sa.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(49, 'rox.sil', 'rox.sil.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(50, 'her.ust', 'her.ust.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(51, 'aid.var', 'aid.var.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(52, 'alv.car', 'alv.car.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(53, 'rau.cat', 'rau.cat.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(54, 'fra.cho', 'fra.cho.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(55, 'alf.cos', 'alf.cos.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(56, 'wal.cos', 'wal.cos.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(57, 'jor.dav', 'jor.dav.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(58, 'jua.fer', 'jua.fer.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(59, 'est.gri', 'est.gri.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(60, 'vic.gut', 'vic.gut.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(61, 'mau.hoe', 'mau.hoe.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(62, 'tit.lim', 'tit.lim.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(63, 'rob.man', 'rob.man.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(64, 'jul.med', 'jul.med.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(65, 'vic.mej', 'vic.mej.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(66, 'rob.omo', 'rob.omo.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(67, 'jos.omo', 'jos.omo.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(68, 'oma.per', 'oma.per.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(69, 'ram.roj', 'ram.roj.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(70, 'jos.sor', 'jos.sor.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(71, 'fid.tab', 'fid.tab.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(72, 'rob.val', 'rob.val.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(73, 'car.gar', 'car.gar.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(74, 'pat.rod', 'pat.rod.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(75, 'mab.mag', 'mab.mag.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(76, 'gro.cus', 'gro.cus.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(77, 'jor.ore', 'jor.ore.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(78, 'ros.tor', 'ros.tor.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(79, 'jim.vill', 'jim.vill.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(80, 'lig.ara', 'lig.ara.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(81, 'ame.fio', 'ame.fio.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(82, 'ric.ayo', 'ric.ayo.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(83, 'mar.mon', 'mar.mon.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(84, 'villazon', 'villazon.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(85, 'wal.ari', 'wal.ari.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(86, 'ale.bus', 'ale.bus.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(87, 'cec.cas', 'cec.cas.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(88, 'ben.ces', 'ben.ces.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(89, 'ale.cho', 'ale.cho.123', '2018-10-17 18:03:19', '2018-10-17 18:03:19'),
(90, 'alf.del', 'alf.del.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(91, 'dav.fer', 'dav.fer.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(92, 'rub.gar', 'rub.gar.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(93, 'osv.gut', 'osv.gut.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(94, 'gon.guz', 'gon.guz.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(95, 'joh.her', 'joh.her.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(96, 'dem.juc', 'dem.juc.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(97, 'gua.leo', 'gua.leo.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(98, 'mar.luc', 'mar.luc.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(99, 'ami.mar', 'ami.mar.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(100, 'edg.pat', 'edg.pat.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(101, 'mag.pee', 'mag.pee.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(102, 'alf.per', 'alf.per.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(103, 'abd.qui', 'abd.qui.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(104, 'ant.rod', 'ant.rod.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(105, 'ari.sar', 'ari.sar.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(106, 'dar.tay', 'dar.tay.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(107, 'jua.ter', 'jua.ter.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(108, 'mar.val', 'mar.val.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(109, 'mar.var', 'mar.var.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(110, 'osc.zab', 'osc.zab.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20'),
(111, 'val.lai', 'val.lai.123', '2018-10-17 18:03:20', '2018-10-17 18:03:20');

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_area` (`name_area`)
) ENGINE=InnoDB AUTO_INCREMENT=304 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
-- Table structure for table `modality`
--

DROP TABLE IF EXISTS `modality`;
CREATE TABLE IF NOT EXISTS `modality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_mod` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_mod` (`name_mod`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `professional_umss`
--

INSERT INTO `professional_umss` (`id`, `ci`, `name`, `l_name`, `ml_name`, `email`, `phone`, `address`, `avatar`, `cod_sis`, `id_a_degree`, `id_workload`, `profile`, `id_account`, `created_at`, `updated_at`) VALUES
(1, '5642123', 'Marco Julian', 'Navarro', 'Flores', 'marcolian@gmail.com', NULL, NULL, NULL, NULL, 1, 2, NULL, 2, '2018-10-13 21:29:33', '2018-10-13 21:29:33');

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
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
