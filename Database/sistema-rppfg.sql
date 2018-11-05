-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 04, 2018 at 02:38 PM
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
DROP DATABASE IF EXISTS `sistema-rppfg`;
CREATE DATABASE `sistema-rppfg`;

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
(44, 'jnavarro345356', '$2y$10$J9vFESlAj1uEnY0rOZAeEeRX/klC44mHoEPzMHxRUvx2uPIn9LvQu', '2018-10-21 05:29:37', '2018-10-21 05:29:37'),
(45, 'pab.aze', 'pab.aze.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(46, 'vla.cos', 'vla.cos.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(47, 'cor.flo', 'cor.flo.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(48, 'vic.mon', 'vic.mon.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(49, 'car.sal', 'car.sal.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(50, 'hen.vil', 'hen.vil.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(51, 'sam.ach', 'sam.ach.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(52, 'lui.agr', 'lui.agr.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(53, 'tat.apa', 'tat.apa.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(54, 'let.bla', 'let.bla.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(55, 'bor.cal', 'bor.cal.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(56, 'ind.cam', 'ind.cam.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(57, 'dav.esc', 'dav.esc.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(58, 'mar.flo', 'mar.flo.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(59, 'rol.jal', 'rol.jal.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(60, 'root', 'root.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(61, 'car.man', 'car.man.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(62, 'yon.mon', 'yon.mon.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(63, 'pat.rom', 'pat.rom.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(64, 'ro.sa', 'ro.sa.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(65, 'rox.sil', 'rox.sil.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(66, 'her.ust', 'her.ust.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(67, 'aid.var', 'aid.var.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(68, 'alv.car', 'alv.car.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(69, 'rau.cat', 'rau.cat.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(70, 'fra.cho', 'fra.cho.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(71, 'alf.cos', 'alf.cos.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(72, 'wal.cos', 'wal.cos.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(73, 'jor.dav', 'jor.dav.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(74, 'jua.fer', 'jua.fer.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(75, 'est.gri', 'est.gri.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(76, 'vic.gut', 'vic.gut.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(77, 'mau.hoe', 'mau.hoe.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(78, 'tit.lim', 'tit.lim.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(79, 'rob.man', 'rob.man.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(80, 'jul.med', 'jul.med.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(81, 'vic.mej', 'vic.mej.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(82, 'rob.omo', 'rob.omo.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(83, 'jos.omo', 'jos.omo.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(84, 'oma.per', 'oma.per.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(85, 'ram.roj', 'ram.roj.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(86, 'jos.sor', 'jos.sor.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(87, 'fid.tab', 'fid.tab.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(88, 'rob.val', 'rob.val.123', '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(89, 'car.gar', 'car.gar.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(90, 'pat.rod', 'pat.rod.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(91, 'mab.mag', 'mab.mag.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(92, 'gro.cus', 'gro.cus.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(93, 'jor.ore', 'jor.ore.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(94, 'ros.tor', 'ros.tor.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(95, 'jim.vill', 'jim.vill.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(96, 'lig.ara', 'lig.ara.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(97, 'ame.fio', 'ame.fio.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(98, 'ric.ayo', 'ric.ayo.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(99, 'mar.mon', 'mar.mon.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(100, 'villazon', 'villazon.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(101, 'wal.ari', 'wal.ari.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(102, 'ale.bus', 'ale.bus.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(103, 'cec.cas', 'cec.cas.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(104, 'ben.ces', 'ben.ces.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(105, 'ale.cho', 'ale.cho.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(106, 'alf.del', 'alf.del.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(107, 'dav.fer', 'dav.fer.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(108, 'rub.gar', 'rub.gar.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(109, 'osv.gut', 'osv.gut.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(110, 'gon.guz', 'gon.guz.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(111, 'joh.her', 'joh.her.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(112, 'dem.juc', 'dem.juc.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(113, 'gua.leo', 'gua.leo.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(114, 'mar.luc', 'mar.luc.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(115, 'ami.mar', 'ami.mar.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(116, 'edg.pat', 'edg.pat.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(117, 'mag.pee', 'mag.pee.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(118, 'alf.per', 'alf.per.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(119, 'abd.qui', 'abd.qui.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(120, 'ant.rod', 'ant.rod.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(121, 'ari.sar', 'ari.sar.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(122, 'dar.tay', 'dar.tay.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(123, 'jua.ter', 'jua.ter.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(124, 'mar.val', 'mar.val.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(125, 'mar.var', 'mar.var.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(126, 'osc.zab', 'osc.zab.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(127, 'val.lai', 'val.lai.123', '2018-10-21 19:46:56', '2018-10-21 19:46:56');

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
  `id_parent_area` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_area` (`name_area`)
) ENGINE=InnoDB AUTO_INCREMENT=625 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `name_area`, `desc_area`, `id_parent_area`, `status`, `created_at`, `updated_at`) VALUES
(328, 'Base de Datos', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(329, 'Comercio Electrónico', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(330, 'Computación Gráfica', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(331, 'Evaluación y Auditoria de Sistemas', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(332, 'Ingeniería de Producción', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(333, 'Ingeniería de Software', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(334, 'Inteligencia Artificial', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(335, 'Interacción Humano Computador', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(336, 'Investigación Operativa', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(337, 'Matemática Computacional', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(338, 'Programación en Internet', ' ', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(339, 'Redes y Sistemas Distribuidos', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(340, 'Simulación', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(341, 'Sistemas de Información', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(342, 'Tecnologías de Control', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(343, 'Teoría de la Computación', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(344, 'Bioinformatica', ' ', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(345, 'Telecomunicaciones ', ' ', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(346, 'Programación Funcional ', ' ', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(347, 'Sistemas Operativos ', ' ', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(348, 'Recuperación de la información', 'Sistemas cuya problematica central en la manera en que recuperan la información', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(349, 'Automatización de procesos', 'En esta área se tratan los temas de automatización de procesos en todos los campos', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(350, 'Ingeniería de Sistemas', 'Sin información', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(351, 'Ingenieria de la usabilidad', 'Sin información', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(352, 'Interfaz de Usuario', 'Sin información', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(353, 'Tecnología de Información y Comunicación (TIC)', 'Sin descripcion', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(354, 'Educación Superior en Inf.', 'Sin descripción', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(355, 'Tecnologías de Desarrollo', 'Sin descripción', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(356, 'Seguridad Informática', 'Seguridad Informática en Sistemas Computacionales', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(357, 'Gestión de Sistemas', 'La información que se maneja en una base de datos de una entidad financiera es de vital importancia, para ello se lleva un proceso el cual se desarrollará para verificar como se encuentran los datos, como actuarán ellos tras algún percance que pueda ocurrir y sobre todo la continuidad que puede tener la entidad con estos problemas y como se resolverán para que no ocurran en un futuro y mantenerlos controlados.', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(358, 'Accesibilidad Web', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(359, 'Motores de Búsqueda', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(360, 'Ingeniería de Software Educativo', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(361, 'Sistemas de Telecomunicaion', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(362, 'Sistemas de Telecomunicacion', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(363, 'Migracion de contenidos de CMS', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(364, 'Sistemas de Informacion Web', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(365, 'Planificacion, Control y Gestion', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(366, 'Música Artificial', 'Creacion de musica a travez de algoritmos que proveen mecanismos de composición', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(367, 'Gestión de Transacciones', 'Se trata el problema de asegurar la bd en un estado consistente aún en casos de acceso concurrente', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(368, 'Ingenieria de tecnologia e informacion (IT)', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(369, 'Modelación y simulación', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(370, 'Dinámica de sistemas', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(371, 'Contend Management Systems (CMS)', 'Sistemas de administración de contenido, archivos, páginas web, blogs,entre otros', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(372, 'Sistemas de Telecomunicaciones', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(373, 'Sistemas de Información Geográfico', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(374, 'Ciencias Juridicas', 'Ciencias Juridicas', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(375, 'Programación y Aplicaciones Web', 'El estudio y programacion de aplicaciones web', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(376, 'Estandares Web', 'Especifica los estandares formales y otras especificaciones que definen  aspectos de la worl wide we', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(377, 'Tecnologia Web', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(378, 'PLANEACIÓN Y CONTROL DE PRODUCCIÓN DE LA MANO DE OBRA DIRECTA.', 'Controlar la parte productiva del personal de planta', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(379, 'Redes Multimedia', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(380, 'E-learning', 'aprendizaje por internet', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(381, 'Didáctica y Multimedia Interactiva', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(382, 'business intelligence', 'Se denomina inteligencia empresarial o inteligencia de negocios o BI', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(383, 'Ingenieria de Calidad', 'Referido a control de calidad en productos de software.', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(384, 'Domótica', 'Se entiende por domótica al conjunto de sistemas capaces de automatizar una vivienda, aportando servicios de gestión energética, seguridad, bienestar y comunicación', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(385, 'Telemetría', 'La telemetría es una tecnología que permite la medición remota de magnitudes físicas y el posterior envío de la información hacia el operador', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(386, 'Base de Datos Relacionales Difusas', 'La Base de Datos Relacionales Difusas, nos ayuda a poder realizar consultas con tipos de datos imprecisa.', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(387, 'Seguridad en base de datos', 'Seguridad en base de datos', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(388, 'Electronica', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(389, 'Multimedia Interactivo', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(390, 'Seguridad en Aplicaciones Web', 'Seguridad en Aplicaciones Web', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(391, 'Administracion de Servidores', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(392, 'Diseño Avanzado de Software', 'Diseño Avanzado de Software', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(393, 'Interaccion Humano-Computadora', 'Interaccion Humano-Computadora', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(394, 'Linguistica Computacional', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(395, 'sistemas orientados a objetos', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(396, 'Interfaces Gráficas de Usuario WEB', 'Interfaces Gráficas de Usuario WEB', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(397, 'Gestión y Administración de Información', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(398, 'Contabilidad de Costos', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(399, 'Estados Financieros', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(400, 'Arquitectura de la Informacion', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(401, 'Seguridad con sistemas informaticos', 'Seguridad domiciliaria y empresarial con sistemas informaticos', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(402, 'Programacion Funcional Aplicada', 'Desarrollo de aplicaciones utilizando lenguajes funcioanles.', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(403, 'Aeronáutica', 'La aeronáutica es la ciencia relacionada con el estudio, diseño, manufactura y técnicas de control de aeronaves.', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(404, 'Infografía', 'Imágenes generadas por ordenador', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(405, 'Redes de Computadoras', 'Estudio de los niveles del modelo tpc/ip', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(406, 'bd new', 'asd asd', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(407, 'Contenedor CMS', 'Un sistema de gestión de contenidos (content management system, abreviado CMS) es un programa que permite crear una estructura de soporte (framework) para la creación y administración de contenidos, principalmente en páginas web, por parte de los participantes.', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(408, 'Redes Inalambricas', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(409, 'Toma de Desiciones Administrativas', '\'\'', NULL, 0, '2018-10-21 18:50:00', '2018-10-21 18:50:00'),
(410, 'Reconocimiento de voz', 'Reconocimiento de voz', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(411, 'Reconocimiento de la voz', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(412, 'Desarrollo de Software Inteligente ', 'Aplicación de la Inteligencia Artificial al desarrollo de software', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(413, 'Ambientes automatizados de apoyo para productos de construcción de software', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(414, 'Programacion Movil', 'Desarrollo de aplicaciones para los dispocitivos moviles (Celulares)', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(415, 'Seguridad biometrica', 'Desarrollo de aplicaciones de seguridad utilizando biometria de tecleo', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(416, 'Software Educativo', 'En esta área se engloban todo software orientados a la educación en sus diferentes grados.', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(417, 'Seguridad  y Gestion de Redes', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(418, 'Programación abajo Nivel', 'Uso del lenguaje de segunda generación assembler ', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(419, 'taller de programación  a bajo nivel', 'Se trata de aplicar los conocimientos adquiridos en la programación con assembler, aprovechando al maximo la arquitectura de un computador y el sistema operativo.', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(420, 'Aplicaciones WEB', 'Aplicaciones creadas para el servicio web, orientadas a proveer un servicio a los usuarios.', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(421, 'Servicio WEB', 'Servicios orientados a los usuarios, con fines educativos, informativos, etc.', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(422, 'Sistema de procesamiento de transacciones', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(423, 'Educación Superior en Ingeniería de Sistemas', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(424, 'patrones de diseño', 'El Patrón de Diseño DAO busca el acoplamiento con el patrón Modelo Vista Controlador (MVC). Creando las clases necesarias para el Modelo (CRUD), Controlador (Action), Vista, JSP.', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(425, 'Informatica', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(426, 'Sistema  de Apoyo a la Toma de decisiones', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(427, 'Redes de computadoras intranet', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(428, 'Aplicacion Web', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(429, 'sistema web', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(430, 'M-Commerce, M-Payment', 'Areas en las que se realizan distintas transacciones concretamente de pago y compra de bienes o servicios utilizando como herramineta un dispositivo movil. ', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(431, 'Sistema de Informacion Administrativo', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(432, 'Android', 'Android es un sistema operativo orientado a dispositivos móviles basado en una versión modificada del núcleo Linux.Inicialmente fue desarrollado por Android Inc., compañía que fue comprada después por Google, y en la actualidad lo desarrollan los miembros de la Open Handset Alliance (liderada por Google).\r\nLa presentación de la plataforma Android se realizó el 5 de noviembre de 2007 junto con la fundación Open Handset Alliance, un consorcio de 48 compañías de hardware, software y telecomunicaciones comprometidas con la promoción de estándares abiertos para dispositivos móviles.Esta plataforma permite el desarrollo de aplicaciones por terceros a través del SDK, proporcionada por el mismo Google, y mediante el lenguaje de programación Java.Una alternativa es el uso del NDK (Native Development Kit) de Google para emplear el lenguaje de programación C.\r\n\r\nEl código fuente de Android está disponible bajo diversas licencias de software libre y código abierto destacando la versión 2 de la licencia Apache.\r\nCaracteristicas:\r\n    * Framework  de aplicaciones: permite reutilización y reemplazo de componentes.\r\n    * Máquina virtual Dalvik: optimizada para dispositivos móviles.\r\n    * Navegador integrado: basado en el motor de código abierto WebKit.\r\n    * Gráficos optimizados, con una biblioteca de gráficos 2D; gráficos 3D basado en la especificación OpenGL ES 1.0 (aceleración por hardware opcional).\r\n    * SQLite para almacenamiento de datos estructurados.\r\n    * Soporte para medios con formatos comunes de audio, vídeo e imágenes planas (MPEG4, H.264, MP3, OGG, AAC, AMR, JPG, PNG, GIF)\r\n    * Telefonía GSM (dependiente del hardware)\r\n    * Bluetooth, EDGE, 3G, y WiFi (dependiente del hardware)\r\n    * Cámara, GPS, brújula, y acelerómetro (dependiente del hardware)\r\n    * Ambiente rico de desarrollo incluyendo un emulador de dispositivo, herramientas para depurar, perfiles de memoria y rendimiento, y un complemento para el IDE Eclipse.\r\n    * Pantalla táctil\r\n    * Android Market permite que los desarrolladores pongan sus aplicaciones, gratuitas o de pago, en el mercado a través de esta aplicación accesible desde la mayoría de los teléfonos con Android.\r\n', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(433, 'Sistemas de Gestion Web', 'Toda informacion sera manejada mediante el internet en linea con el apoyo de la herramienta Zend para Php', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(434, 'Programación Web', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(435, 'Redes de computadoras e internet', 'Redes de computadoras que se relacionan con internet', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(436, 'Tecnologia Informatica en Educacion', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(437, 'Sistema de Produccion', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(438, 'Entornos Virtuales de Aprendizaje', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(439, 'Workflow', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(440, 'Redes de Comunicacion', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(441, 'VOZ IP', 'En esta area esta relacionanda con las telecomunicaciones el cual utiliza la transmicion de voz sobre ips como tambien tipos de compresion para la voz el cual seran transmitidos', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(442, 'Telefonia IP', 'La telefonía IP reúne la transmisión de voz y de datos, lo que posibilita la utilización de las redes informáticas para efectuar llamadas telefónicas. Además, ésta tecnología al desarrollar una única red encargada de cursar todo tipo de comunicación, ya sea de voz, datos o video, se denomina red convergente o red multiservicios.La telefonía IP surge como una alternativa a la telefonía tradicional, brindando nuevos servicios al cliente y una serie de beneficios económicos y tecnológicos', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(443, 'Centrales Telefonicas IP', 'En la nueva era de las comunicaciones digitales, las centrales de telefonía han evolucionado, hasta convertirse en potentes maquinas de enrutamiento y gestión de llamadas, capaces de usar telefonía IP', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(444, 'Aseguramiento de la calidad del software', 'Area encargada de validar , verificar y controlar la calidad del producto de software', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(445, 'Aseguramiento de Calidad de Software.', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(446, 'Aseguramiento de Calidad de Software', 'Control de Calidad', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(447, 'Tecnología de Información y Comunicación (TIC) en la educación', 'Tecnologias de Informacion y Comunicacion (TIC) aplicadas a la educacion.', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(448, 'Diseño de interfaces', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(449, 'Seguridad de la Informacion', 'Es el area que se encarga de buscar, formas de proteger la informacion de terceras personas, como con la criptografia, esteganografia, marcas de agua, etc.', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(450, 'Esteganografia', 'Esta tecnica es el arte y ciencia de enviar informacion secreta de tal forma que nadie fuera de quien lo envia y quien lo recibe sabe de su existencia, en contraste con la criptografia, en donde la existencia del mensaje es clara pero esta obscurecido. Por lo general la informacion  enviada de este tipo parece ser simplemente una imagen o foto. La esteganografia logra ocultar informacion en una imagen utilizando el bit menos significativo de cada color en los pixeles.', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(451, 'Computación Científica', 'Es el campo de estudio relacionado con la construcción de modelos matemáticos y técnicas numéricas para resolver problemas científicos', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(452, 'MODELO DIGITAL DEL TERRENO', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(453, 'Calidad de Software', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(454, 'Sistemas Tutoriales', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(455, 'Autoevaluación', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(456, 'Optimizacion Combinatoria', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(457, 'Aseguramiento de la calidad de software', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(458, 'Diseño de compiladores', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(459, 'Estrategias Heurísticas para la toma de  decisiones ', 'Se comportan como recursos organizativos del proceso de resolución, que contribuyen especialmente a determinar la vía de solución del problema abordado', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(460, 'Sistemas Expertos', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(461, 'Diseño e Implementación de un Compilador', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(462, 'Control de calidad de software', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(463, 'Material Educativo Computarizado (M.E.C.)', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(464, 'Monitoreo de Servidores', 'Herramientas útiles para los administradores de servidores o personal de TI', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(465, 'Ambientes automatizados de apoyo', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(466, 'Control de Calidad del Software', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(467, 'Sistemas de Aprendizaje', 'Sistemas de aprendizaje', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(468, 'Inteligencia Artificial, Base de Datos', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(469, 'Redes', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(470, 'Redes de Telecomunicaciones', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(471, 'Transferencia de Datos Protocolo IP', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(472, 'Sistema de Escaneado Optimo', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(473, 'CMS', 'Content Management System', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(474, 'Procesamiento de datos Meteorológicos', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(475, 'Software de Gestión', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(476, 'Diseño e implementacion de software', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(477, 'Web semántica', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(478, 'Redes de Datos', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(479, 'Tecnicas de Animacion 3D', 'se hace uso de las tecnicas de animacion 3D como ser Keyframe,procedural las cuales permiten generar una animacion en 3D haciendo uso de herramientas de diseño 3D,tambien se puede hacer uso de la tecnica de rotoscopia el cual captura informacion de movimiento mediante sensores de objetos reales pero este requiere de equipos especiales.', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(480, 'Base de Datos, Web', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(481, 'Herramienta SIG', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(482, 'Sistemas Integrados de Gestion', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(483, 'Sistemas web', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(484, 'Sistemas de Información geográfica', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(485, 'Sistemas de Gestión', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(486, 'Sistemas Colaborativos en la Educación', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(487, 'Computación en la nube', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(488, 'Telefonía y Comunicaciones', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(489, 'Sistema de Reportes', 'En la ingenieria de software se necesita gráficas para analizar el trabajo de cada desarrollador, que representados en reportes gráficos son mas entendibles para los administradores de equipos de desarrollo', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(490, 'Redes Moviles', 'Esta subárea se refiere a la interconexion de celulares por medio wifi.', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(491, 'Realidad Aumentada', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(492, 'Redes de computadoras en internet', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(493, 'Sistemas de Soporte a la Administración', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(494, 'Sistema de Archivos', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(495, 'Programación en la Nube', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(496, 'Software para dispositivos móviles', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(497, 'Mashups', 'En desarrollo web, un mashup es una página web o aplicación que usa y combina datos, presentaciones y funcionalidad procedentes de una o más fuentes para crear nuevos servicios. El término implica integración fácil y rápida, usando a menudo APIs abiertos y fuentes de datos para producir resultados enriquecidos que no fueron la razón original para la que fueron producidos los datos en crudo originales.', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(498, 'Web Scraping', 'Web Scraping es una técnica utilizada por softwares de computadora para extraer información de sitios webs', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(499, 'Redes de distribucion', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(500, 'Aplicacion android', 'desarrollo de aplicaciones para Android', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(501, 'Sistema CRM', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(502, 'Metodos de Busqueda heuristica o solucion de problemas', 'En computación, dos objetivos fundamentales son encontrar algoritmos con buenos tiempos de ejecución y buenas soluciones, usualmente las óptimas. Una heurística es un algoritmo que abandona uno o ambos objetivos; por ejemplo, normalmente encuentran buenas soluciones, aunque no hay pruebas de que la solución no pueda ser arbitrariamente errónea en algunos casos; o se ejecuta razonablemente rápido, aunque no existe tampoco prueba de que siempre será así. Las heurísticas generalmente son usadas cuando no existe una solución óptima bajo las restricciones dadas (tiempo, espacio, etc.), o cuando no existe del todo.\r\nA menudo, pueden encontrarse instancias concretas del problema donde la heurística producirá resultados muy malos o se ejecutará muy lentamente. Aun así, estas instancias concretas pueden ser ignoradas porque no deberían ocurrir nunca en la práctica por ser de origen teórico. Por tanto, el uso de heurísticas es muy común en el mundo real.', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(503, 'Sistemas de apoyo a la docencia', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(504, 'Accesibilidad audiovisual web', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(505, 'Compiladores e interpretadores', 'Sub area de compiladores e interpretadores\r\n\r\n', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(506, 'Analisis y filtrado', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(507, 'Interpretes y compiladores', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(508, 'Ambientes automatizados de apoyo para construccion de productos de software', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(509, 'Medios de Comunicacion Digitales', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(510, 'Sistemas de gestión de calidad de producción.', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(511, 'Investigación', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(512, 'Hidrología', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(513, 'Automatización', 'Sistema tecnológico basado en la ingeniería y la informática, que proporciona una optimización de los procesos productivos mediante la regulación automática.', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(514, 'Redes de telecomunicaiones', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(515, 'Punto de Venta', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(516, 'Simulacion de Sistemas', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(517, 'Diseño de Aerogeneradores', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(518, 'Ingeniería de yacimientos', 'La ingeniería de yacimientos es la parte fundamental de la ingeniería de petróleo, aplicando conocimientos científicos, permite  una explotación racional de las acumulaciones de hidrocarburos, para obtener su máxima recuperación al menor costo ', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(519, 'Data Science', '', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(520, 'Sistemas Virtuales', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(521, 'Comunicacion de datos, Sistemas de tiempo real, Intranet/Internet', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(522, 'Modelo relacional de base de datos', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(523, 'Protocolos de acceso a directorio', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(524, 'H.C.I', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(525, 'Telefonia Movil, M-Payment, Modem Gateway', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(526, 'Juegos Didacticos', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(527, 'Programacion y Aplicacion web', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(528, 'Computacion Paralela', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(529, 'Semántica de datos', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(530, 'Interacción persona-computador para educación', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(531, 'Composicion Algoritmica', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(532, 'Servidor OwnCloud', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(533, 'Administracion de inventarios', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(534, 'Aplicacion movil', 'Aplicacion movil para el manejo de inventarios\r\n', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(535, 'Tecnologías Web', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(536, 'Comunicación en Tiempo Real', 'Tecnologías web que permiten comunicación en tiempo real.', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(537, 'TICs en la educacion', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(538, 'Computacion y Sociedad', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(539, 'Ejercitación y Práctica', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(540, 'Planificación y Organización Empresarial', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(541, 'Gestión Estratégica de Empresas', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(542, 'Técnologias de Información Educativa', 'Sistemas de información dedicada al estudio y apoyo a la educación mediante un sistema de información. ', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(543, 'Taller de Programacion a Bajo Nivel', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(544, 'Aplicacion de Sistemas Operativos', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(545, 'procesamiento de imagenes digitales', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(546, 'Administrador de archivos', 'Sistema especializado en la administración de documentación, a partir de la cual se crea un repositorio, el que podrá ser accedido, compartido, eliminado según la necesidad o requerimientos del administrador o usuarios', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(547, 'Sistemas basados en conocimiento', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(548, 'Lingüística  Computacional', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(549, 'Programación y Algoritmos', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(550, 'Minería de datos ', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(551, 'Informática de la salud', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(552, 'TICs aplicadas a la Educación', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(553, 'Programacion Web reactiva', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(554, 'Gestion y planificación de empresas', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(555, 'Television Digital', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(556, 'Modelos de proceso', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(557, 'Gestión de empresas', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(558, 'Internet', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(559, 'Sistemas Distribuidos', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(560, 'Desarrollo de Software', 'Herramientas y recursos que son utilizados en el proceso de fabricación de software', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(561, 'Tecnología de Información y Comunicación (TIC) de la educación', '\'\'', NULL, 0, '2018-10-21 18:50:01', '2018-10-21 18:50:01'),
(562, 'TICs de la educación', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(563, 'Tecnologia de Apoyo a Estadistica', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(564, 'Administración y gestión de proyectos', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(565, 'modelacion de sistemas', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(566, 'Desarrollo de videojuegos', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(567, 'Enrutamiento', 'La función de enrutamiento es una función de la Capa 3 del modelo OSI. El enrutamiento es un esquema de organización jerárquico que permite que se agrupen direcciones individuales. Estas direcciones individuales son tratadas como unidades únicas hasta que se necesita la dirección destino para la entrega final de los datos. El enrutamiento es el proceso de hallar la ruta más eficiente desde un dispositivo a otro. El dispositivo primario que realiza el proceso de enrutamiento es el Router.', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(568, 'Diseño', 'Patrones de diseño', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(569, 'Sistemas Control de Procesos', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(570, 'Aplicacion de GPS', 'Aplicación de GPS (Sistema de posicionamiento global) en dispositivos móviles', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(571, 'aprendizaje por computadora', 'el aprendizaje automático (Machine Learning) es una rama de la inteligencia artificial el cual busca desarrollar técnicas que permitan crear programas capaces de procesar y analizar grandes cantidades de datos para posteriormente agruparlas y consolidarlas en porciones pequeñas de información útil, que permita reconocer y decodificar patrones complejos y predecir tendencias o comportamientos futuros, estos programas deben aprender y mejorar con la experiencia a través el tiempo, refinando sus modelos que son usados para predecir los posibles resultados con el fin de facilitar la toma de decisiones inteligentes basadas en esa información.', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(572, 'Visión Artificial', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(573, 'Aprendizaje automático', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(574, 'Laboratorios virtuales basados en WWW.', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(575, 'Base de Datos - Ingenieria de Software', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(576, 'control de procesos', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(577, 'Sistema en tiempo real y control de procesos', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(578, 'Ingenieria de control', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(579, 'Programación en Ginga-NCL', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(580, 'Computación Educativa', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(581, 'sistema de informacion administrativa web', 'es un conjunto de elementos orientados al tratamiento y administracion de datos e informacion ,organizados y listos para su uso posterior o un objetivo.\r\nQue formarian parte de algunas de las siguientes partes (personas , actividades, datos. etc), para obtener informacion mas exacta y mas clara al momento de utilizar dicha informacion.\r\nla parte de administrar esta informacion en el area web es que ayude y evite pasos extras al momento de manejo de informacion hace que sea dinamico las busqueadas y otros procedimientos de la misma aplicacion web.\r\n', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(582, 'Aplicación Intranet ', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(583, 'Prueba de intrusión', 'Es una práctica para poner a prueba un sistema informático, red o aplicación web para encontrar vulnerabilidades que un atacante podría explotar.', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(584, 'Encriptacion de datos', 'Es el proceso mediante el cual cierta informacion o texto sin formato es cifrado de forma que el resultado sea ilegible a menos que se conozca los datos necesarios para su interpretacion.', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(585, 'Programacion Ginga NCL/Lua', 'Ginga NCL/Lua herramienta desarrollada por la puc de Rio para el desarrollo de aplicaciones interactivas para Television Digital', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(586, 'CSCW', 'Computer Supported Coopertive Work CSCW, Trabajo cooperativo asistido por computadora.\r\nCSCW es un Término utilizado para describir cualquier tecnología que combina recursos de hardware y software para permitir a grupos de personas colaborar y compartir tecnología.', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(587, 'Visualizacion de datos', 'La visualizacio&#769;n de datos trata de la creacio&#769;n de meta&#769;foras visuales y el estudio de comunicar la informacio&#769;n de manera ma&#769;s clara y efectiva a trave&#769;s de estas.', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(588, 'Herramienta y métodos de ingeniería de software', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(589, 'Integracion de tecnologias moviles', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(590, 'Planificación Automática', 'La planificación automática es una disciplina de la inteligencia artificial que tiene por objeto la producción de planes (es decir, una planificación), típicamente para la ejecución de un robot u otro agente.', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(591, 'Aplicaciones móviles', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(592, 'aplicación móvil (app)', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(593, 'Programación Móvil, GPS', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(594, 'Television Digital Interactiva', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(595, 'Procesamiento del lenguaje natural', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(596, 'Aprendizaje de máquina', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(597, 'Ingenieria Economica', 'Area de la matematica financiera muy usado en la toma de decisiones, el manejo de amortizaciones de deudas y manejo de las tasas de interes muy usado en la vida cotidiana. ', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(598, 'Aplicaciones Hibridas', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(599, 'Teoría de Grafos', 'Teoría de Grafos', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(600, 'Redes aleatorias', 'Redes aleatorias', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(601, 'Diseño de Interfaces - Desarrollo de Sistemas Orientados a Objetos', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(602, 'Gestion Administrativa', 'Gestion de los procesos administrativos', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(603, 'Servicios Telematicos', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(604, 'Realidad Mixta', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(605, 'Graficacion por Computadora', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(606, 'Servicios Web REST', 'La Transferencia de Estado Representacional (REST - Representational State Transfer) fue ganando amplia adopción en toda la web como una alternativa más simple a SOAP y a los servicios web basados en el Lenguage de Descripción de Servicios Web (Web Services Descripcion Language - WSDL).REST define un set de principios arquitectónicos por los cuales se diseñan servicios web haciendo foco en los recursos del sistema, incluyendo cómo se accede al estado de dichos recursos y cómo se transfieren por HTTP hacia clientes escritos en diversos lenguajes.', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(607, 'Almacén de Eventos', 'Del inglés -Event sourcing- involucra el modelado de cambio de estados hechos a una aplicación como una secuencia inmutable o registro de eventos. \r\n\r\nEn lugar modificar el estado de la aplicación directamente, un almacén de eventos almacena el evento que lanzo el cambio de estado en un registro inmutable y modela los cambios de estados como respuestas a los eventos en el registro.', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(608, 'Modelación y Optimización', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(609, 'Sistema de Información', 'Los sistemas de Información dan soporte a las operaciones empresariales, la gestión y la toma de decisiones, proporcionando a las personas la información que necesitan mediante el uso de las tecnologías de la información. ', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(610, 'INTELIGENCIA DE NEGOCIOS', 'SE ENTIENDE POR INTELIGENCIA DE NEGOCIOS (BUSINESS INTELLIGENCE) AL CONJUNTO DE METODOLOGIAS , APLICACIONES, PRACTICAS Y CAPACIDADES ENFOCADAS A LA CREACION Y ADMINISTRACION DE LA INFORMACION QUE PERMITE TOMAR MEJORES DECISIONES A LOS USUARIOS DE UN ORGANIZACION.\r\nEN RESUMEN SE PUEDE UTILIZAR DATOS DE AYER Y HOY PARA TOMAR MEJORES DECISIONES MAÑANA.', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(611, 'Bots', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(612, 'Cloud Computing', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(613, 'Base de Datos,Aplicación Web y Sistemas de información', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(614, 'Análisis de contenido de páginas web.', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(615, 'Servicio Movil Nativa', 'servicio del dispositivo movil nativa \r\n', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(616, 'Data Warehouse y Mineria de Datos', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(617, 'Data Mining, Data Science', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(618, 'Realidad virtual', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(619, ' sistema de información', 'Un Sistema de Información es un conjunto de componentes que interactúan entre sí, orientado a la recolección, almacenamiento, procesamiento y recuperación de información.\r\nSe estudian las características resultantes de esas interacciones y qué mecanismos se pueden utilizar para el desarrollo y adaptación de estos sistemas de forma que puedan se explotados en las organizaciones con el mayor retorno posible.', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(620, 'Análisis de video', 'Describe un amplio número de nuevas tecnologías y evoluciones en el campo de la vigilancia con vídeo y la seguridad.\r\nAlgunas aplicaciones del análisis de vídeo son la detección de objetos abandonados en lugares llenos de gente, controlar obras de arte en los museos y detectar vehículos no autorizados que ingresen a determinadas áreas. La detección de matrículas de vehículos, congestión de tránsito,tecnologias mas de reconocimiento facial.', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(621, 'sistema gestion del conocimiento', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(622, 'Aprendizaje en profundidad', '\'\'', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(623, 'Algoritmos', 'Algoritmos pueden realizar calculos, procesamiento de datos y tareas de razonamiento automatizado.', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02'),
(624, 'Optimizacion', 'Es la seleccion del mejor elemento con respecto a algun criterio de un conjunto de elementos disponibles.\r\n', NULL, 0, '2018-10-21 18:50:02', '2018-10-21 18:50:02');

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

--
-- Dumping data for table `career`
--

INSERT INTO `career` (`id`, `name`) VALUES
(1, 'Licenciatura en Ingenieria Informática'),
(2, 'Licenciatura en Informática');

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
-- Stand-in structure for view `pojectsview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `pojectsview`;
CREATE TABLE IF NOT EXISTS `pojectsview` (
`title` mediumtext
,`fullname_tutor` varchar(83)
,`fullname_tutor_2` varchar(83)
,`fullname_student` varchar(72)
,`fullname_student_2` varchar(72)
,`general_obj` longtext
,`AREA` varchar(100)
,`subarea` varchar(100)
,`area_2` varchar(100)
,`subarea_2` varchar(100)
,`modality` varchar(40)
,`career` varchar(50)
,`registry_date` date
,`period` varchar(1)
);

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
  `active` tinyint(1) NOT NULL DEFAULT 0,
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
(1, '7900012', 'Christian', 'Villazon', 'Alcocer', 'christian91@outlook.com', NULL, NULL, NULL, NULL, 1, 2, NULL, 44, '2018-10-14 23:33:08', '2018-10-14 23:33:08'),
(22, '', 'Pablo Ramon', 'Azero', 'Azero', 'pabloazero@memi.umss.edu.bo', 4252439, 'Programa MEMI (UMSS).', NULL, '', 2, 1, '', 45, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(23, '', 'Vladimir', 'Costas', 'Costas', 'vcostas@cs.umss.edu.bo', 4666037, 'Centro MEMI - Area Informatica', NULL, '', 3, 2, '', 46, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(24, '', 'Corina Justina', 'Flores', 'Flores', 'corina@memi.umss.edu.bo', 4252439, 'Programa MEMI (UMSS).', NULL, '', 2, 1, '', 47, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(25, '', 'Victor Hugo', 'Montaño', 'Montaño', 'victor@memi.umss.edu.bo', 4233719, 'Departamento de Informática y Sistemas (UMSS).', NULL, '', 2, 1, '', 48, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(26, '', 'Carla', 'Salazar', 'Salazar', 'csalazar@memi.umss.edu.bo', 4233719, 'Departamento de Informática y Sistemas (UMSS).', NULL, '', 5, 2, '', 49, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(27, '', 'Henrry Frank', 'Villarroel', 'Villarroel', 'hvillarroel@memi.umss.edu.bo', 77931275, '', NULL, '', 2, 2, '', 50, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(28, '', 'Samuel Roberto', 'Achá', 'Achá', 'cibo@supernet.com.bo', 70719123, 'Antezana 537', NULL, '', 1, 1, '', 51, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(29, '', 'Luis Roberto', 'Agreda', 'Agreda', 'luisagreda@hotmail.com', 4529557, '', NULL, '', 1, 1, '', 52, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(30, '', 'Nancy Tatiana', 'Aparicio', 'Aparicio', 'aparicio@ucbcba.edu.bo', 0, '', NULL, '', 3, 1, '', 53, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(31, '', 'Maria Leticia', 'Blanco', 'Blanco', 'leticia@memi.umss.edu.bo', 4252439, 'Programa MEMI (UMSS).', NULL, '', 2, 1, '', 54, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(32, '', 'Boris Marcelo', 'Calancha', 'Calancha', 'boris@fcyt.umss.edu.bo', 4233719, 'Dirección de Carrera', NULL, '', 2, 2, '', 55, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(33, '', 'Indira Elva', 'Camacho', 'Camacho', 'agrofru@gmail.com', 4529433, '', NULL, '', 3, 1, '', 56, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(34, '', 'David', 'Escalera', 'Escalera', 'descalera@cs.umss.edu.bo', 0, '', NULL, '', 2, 1, '', 57, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(35, '', 'Juan Marcelo', 'Flores', 'Flores', 'marcelo@memi.umss.edu.bo', 4233719, 'Programa MEMI (UMSS).', NULL, '', 2, 1, '', 58, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(36, '', 'K. Rolando', 'Jaldin', 'Jaldin', 'rjaldin@hotmail.com', 100, '', NULL, '', 5, 2, '', 59, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(37, '', 'Ruperto', 'León', 'León', 'ruperto@cs.umss.edu.bo', 4233719, 'Departamento de Informática y Sistemas (UMSS).', NULL, '', 4, 1, '', 60, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(38, '', 'Carlos Benito', 'Manzur', 'Manzur', 'ca.manzu@umss.edu.bo', 4233719, '', NULL, '', 2, 1, '', 61, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(39, '', 'Yony Richard', 'Montoya', 'Montoya', 'yony@setbol.net', 71725138, '', NULL, '', 5, 1, '', 62, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(40, '', 'Patricia Elizabeth', 'Romero', 'Romero', 'paromeror@gmail.com', 0, '', NULL, '', 5, 1, '', 63, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(41, '', 'Rose Mary', 'Salazar', 'Salazar', 'rsalazar@umss.edu.bo', 4233719, '', NULL, '', 2, 1, '', 64, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(42, '', 'Roxana', 'Silva', 'Silva', 'tersil@supernet.com.bo', 4233719, '', NULL, '', 2, 1, '', 65, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(43, '', 'Hernan', 'Ustariz', 'Ustariz', 'hustariz@memi.umss.edu.bo', 4233719, 'Laboratorio de Informática y Sistemas (UMSS).', NULL, '', 2, 1, '', 66, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(44, '', 'Aidée', 'Vargas', 'Vargas', 'aideevc@fcyt.umss.edu.bo', 4233719, '', NULL, '', 2, 1, '', 67, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(45, '', 'Alvaro Hernando', 'Carrasco', 'Carrasco', ' ', 4233719, '', NULL, '', 2, 1, '', 68, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(46, '', 'Raul', 'Catari', 'Catari', 'micorreo@yahoo.com', 4233719, 'avenida oquendo nro 234', NULL, '', 2, 1, '', 69, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(47, '', 'Francisco', 'Choque', 'Choque', ' uno@hotmail.com', 4233719, '', NULL, '', 2, 1, '', 70, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(48, '', 'Carlos J. Alfredo', 'Cosio', 'Cosio', ' ', 4233719, '', NULL, '', 1, 1, '', 71, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(49, '', 'Walter', 'Cossio', 'Cossio', ' cossio@hotmail.com', 4233719, '', NULL, '', 4, 1, '', 72, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(50, '', 'Jorge', 'Davalos', 'Davalos', ' ', 4233719, '', NULL, '', 2, 1, '', 73, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(51, '', 'Juan A.', 'Fernandez', 'Fernandez', ' ', 4233719, '', NULL, '', 2, 1, '', 74, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(52, '', 'Maria Estela', 'Grilo', 'Grilo', ' ', 4233719, '', NULL, '', 2, 1, '', 75, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(53, '', 'Victor', 'Gutierrez', 'Gutierrez', ' ', 4233719, '', NULL, '', 2, 1, '', 76, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(54, '', 'Mauricio', 'Hoepfner', 'Hoepfner', ' ', 4233719, '', NULL, '', 2, 1, '', 77, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(55, '', 'Tito Anibal', 'Lima', 'Lima', 'tlima@quadraplastsrl.com', 70744138, '', NULL, '', 4, 1, '', 78, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(56, '', 'Roberto Juan', 'Manchego', 'Manchego', 'rmanchego@hotmail.com', 4232189, 'Av. Heroinas E-1897', NULL, '', 1, 1, '', 79, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(57, '', 'Julio', 'Medina', 'Medina', ' ', 4233719, '', NULL, '', 1, 1, '', 80, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(58, '', 'Victor R.', 'Mejia', 'Mejia', ' ', 4233719, '', NULL, '', 2, 1, '', 81, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(59, '', 'Jose Roberto', 'Omonte', 'Omonte', ' ', 4233719, '', NULL, '', 1, 1, '', 82, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(60, '', 'Jose Gil', 'Omonte', 'Omonte', ' ', 4233719, '', NULL, '', 1, 1, '', 83, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(61, '', 'Omar David', 'Perez', 'Perez', 'omar_perez_f@hotmail.com', 4233719, '', NULL, '', 4, 1, '', 84, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(62, '', 'Ramiro', 'Rojas', 'Rojas', ' ', 4233719, '', NULL, '', 1, 1, '', 85, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(63, '', 'Jose Antonio', 'Soruco', 'Soruco', ' ', 4233719, '', NULL, '', 2, 1, '', 86, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(64, '', 'Fidel', 'Taborga', 'Taborga', ' ', 4233719, '', NULL, '', 2, 1, '', 87, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(65, '', 'Roberto', 'Valenzuela', 'Valenzuela', ' ', 4233719, '', NULL, '', 1, 1, '', 88, '2018-10-21 19:46:55', '2018-10-21 19:46:55'),
(66, '', 'Carmen Rosa', 'Garcia', 'Garcia', 'carmenrosagarcia@hotmail.com', 0, '', NULL, '', 2, 1, '', 89, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(67, '', 'Erika Patricia', 'Rodriguez', 'Rodriguez', 'akirebilbao@gmail.com ', 0, '', NULL, '', 5, 2, '', 90, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(68, '', 'Mabel Gloria', 'Magariños', 'Magariños', 'mabelm@fcyt.umss.edu.bo', 4234244, '', NULL, '', 1, 1, '', 91, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(69, '', 'Grover', 'Cussi', 'Cussi', 'gcussi@yahoo.com', 0, '', NULL, '', 2, 1, '', 92, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(70, '', 'Jorge Walter', 'Orellana', 'Orellana', 'jw.orellana@umss.edu.bo', 0, '', NULL, '', 4, 2, '', 93, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(71, '', 'Rosemary', 'Torrico', 'Torrico', 'rosemary@cs.umss.edu.bo', 71778384, '', NULL, '', 5, 1, '', 94, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(72, '', 'Jimmy', 'Villarroel', 'Villarroel', 'jimmyvn_@hotmail.com', 0, '', NULL, '', 1, 2, '', 95, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(73, '', 'Ligia Jacqueline', 'Aranibar', 'Aranibar', 'ligiajacqueline@hotmail.com', 0, '', NULL, '', 2, 1, '', 96, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(74, '', 'Americo', 'Fiorilo', 'Fiorilo', 'amefio@gmail.com', 0, '', NULL, '', 4, 1, '', 97, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(75, '', 'Jose Richard', 'Ayoroa', 'Ayoroa', 'richard@correo.com', 0, '', NULL, '', 1, 2, '', 98, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(76, '', 'Marco Antonio', 'Montecinos', 'Montecinos', 'markmcbo@gmail.com', 0, '', NULL, '', 5, 1, '', 99, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(77, '', 'Christian', 'Villazon', 'Villazon', 'villazon@gmial.com', 0, '', NULL, '', 2, 1, '', 100, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(78, '', 'Walter', 'Arispe', 'Arispe', 'santander@hotmail.com', 0, '', NULL, '', 1, 1, '', 101, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(79, '', 'Alex Israel', 'Bustillos', 'Bustillos', 'bustillos@hotmail.com', 0, '', NULL, '', 2, 1, '', 102, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(80, '', 'Cecilia Beatriz', 'Castro', 'Castro', 'castro@hotmail.com', 0, '', NULL, '', 2, 1, '', 103, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(81, '', 'Maria Benita', 'Cespedes', 'Cespedes', 'cespedes@hotmail.com', 0, '', NULL, '', 2, 1, '', 104, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(82, '', 'Alex D\'anchgelo', 'Choque', 'Choque', 'choque@hotmail.com', 0, '', NULL, '', 2, 1, '', 105, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(83, '', 'David Alfredo', 'Delgadillo', 'Delgadillo', 'delgadillo@hotmail.com', 0, '', NULL, '', 2, 1, '', 106, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(84, '', 'David', 'Fernandez', 'Fernandez', 'fernandez@hotmail.com', 0, '', NULL, '', 1, 1, '', 107, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(85, '', 'Juan Ruben', 'Garcia', 'Garcia', 'garcia@hotmail.com', 0, '', NULL, '', 1, 1, '', 108, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(86, '', 'Osvaldo Walter', 'Gutierrez', 'Gutierrez', 'gutierrez@hotmail.com', 0, '', NULL, '', 1, 1, '', 109, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(87, '', 'Gonzalo E. Antonio', 'Guzman', 'Guzman', 'guzman@hotmail.com', 0, '', NULL, '', 1, 1, '', 110, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(88, '', 'Johnny', 'Herrera', 'Herrera', 'herrera@hotmail.com', 0, '', NULL, '', 1, 1, '', 111, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(89, '', 'Demetrio', 'Juchani', 'Juchani', 'juchani@hotmail.com', 0, '', NULL, '', 1, 1, '', 112, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(90, '', 'Gualberto', 'Leon', 'Leon', 'leon@hotmail.com', 0, '', NULL, '', 1, 1, '', 113, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(91, '', 'Marcelo Javier', 'Lucano', 'Lucano', 'lucano@hotmail.com', 0, '', NULL, '', 2, 1, '', 114, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(92, '', 'Amilcar Saul', 'Martinez', 'Martinez', 'martinez@hotmail.com', 0, '', NULL, '', 2, 1, '', 115, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(93, '', 'Ronald Edgar', 'Patiño', 'Patiño', 'patino@hotmail.com', 0, '', NULL, '', 1, 1, '', 116, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(94, '', 'Magda Lena', 'Peeters', 'Peeters', 'peeters@hotmail.com', 0, '', NULL, '', 2, 1, '', 117, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(95, '', 'Alfredo', 'Pericon', 'Pericon', 'pericon@hotmail.com', 0, '', NULL, '', 1, 1, '', 118, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(96, '', 'Abdon', 'Quiroz', 'Quiroz', 'quiroz@hotmail.com', 0, '', NULL, '', 1, 1, '', 119, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(97, '', 'Juan Antonio', 'Rodriguez', 'Rodriguez', 'rodriguez@hotmail.com', 0, '', NULL, '', 1, 1, '', 120, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(98, '', 'Ariel Antonio', 'Sarmiento', 'Sarmiento', 'sarmiento@hotmail.com', 0, '', NULL, '', 1, 1, '', 121, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(99, '', 'Darlong Howard', 'Taylor', 'Taylor', 'taylor@hotmail.com', 0, '', NULL, '', 2, 1, '', 122, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(100, '', 'Juan', 'Terrazas', 'Terrazas', 'terrazas@hotmail.com', 0, '', NULL, '', 1, 1, '', 123, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(101, '', 'Marco Antonio', 'Vallejos', 'Vallejos', 'vallejos@hotmail.com', 0, '', NULL, '', 1, 1, '', 124, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(102, '', 'Ademar Marcelo', 'Vargas', 'Vargas', 'vargas@hotmail.com', 0, '', NULL, '', 1, 1, '', 125, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(103, '', 'Oscar A', 'Zabalaga', 'Zabalaga', 'zabalaga@hotmail.com', 0, '', NULL, '', 1, 1, '', 126, '2018-10-21 19:46:56', '2018-10-21 19:46:56'),
(104, '', 'Valentin', 'Laime', 'Laime', 'laime@gmail.com', 0, '', NULL, '', 2, 1, '', 127, '2018-10-21 19:46:56', '2018-10-21 19:46:56');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Pendiente');

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
-- Structure for view `pojectsview`
--
DROP TABLE IF EXISTS `pojectsview`;

CREATE ALGORITHM=TEMPTABLE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pojectsview`  AS  select `p`.`id` AS `id`,`p`.`title` AS `title`,concat(`pw`.`name_ad`,' ',`pw`.`name`,' ',`pw`.`l_name`,' ',`pw`.`ml_name`) AS `fullname_tutor`,concat(`pw2`.`name_ad`,' ',`pw2`.`name`,' ',`pw2`.`l_name`,' ',`pw2`.`ml_name`) AS `fullname_tutor_2`,concat(`est`.`name`,' ',`est`.`l_name`,' ',`est`.`ml_name`) AS `fullname_student`,concat(`est2`.`name`,' ',`est2`.`l_name`,' ',`est2`.`ml_name`) AS `fullname_student_2`,`p`.`general_obj` AS `general_obj`,`a`.`name_area` AS `AREA`,`sa`.`name_area` AS `subarea`,`a2`.`name_area` AS `area_2`,`sa2`.`name_area` AS `subarea_2`,`mode`.`name_mod` AS `modality`,`car`.`name` AS `career`,`p`.`registry_date` AS `registry_date`,`per`.`period` AS `period` from (((((((((((`profile` `p` join `professionalview` `pw`) join `professionalview` `pw2`) join `postulant` `est`) join `postulant` `est2`) join `area` `a`) join `area` `sa`) join `area` `a2`) join `area` `sa2`) join `modality` `mode`) join `career` `car`) join `period` `per`) where `p`.`id_tutor` = `pw`.`id_professional` and `p`.`id_tutor_2` = `pw2`.`id_professional` and `p`.`id_area` = `a`.`id` and `p`.`id_subarea` = `sa`.`id` and `p`.`id_area_2` = `a2`.`id` and `p`.`id_subarea_2` = `sa2`.`id` and `p`.`id_modality` = `mode`.`id` and `p`.`id_career` = `car`.`id` and `p`.`id_period` = `per`.`id` ;

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
