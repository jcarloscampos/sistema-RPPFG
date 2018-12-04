-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2018 a las 15:34:00
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `username` varchar(16) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `state` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `state`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$t3wvVOaVBZZc/9iEyOGq9eaJS7uJ5ehq13Ysh7CODiLsXLgnaCi0i', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'secretary', '$2y$10$aqgdTVLse3uV5EmfKfdPdOrINNEis.vX8OuG0L02P6BuOscuZWkN2', 0, '2018-11-02 12:12:12', '2018-11-08 11:11:11'),
(30, 'promero', '$2y$10$Wmx1IQmW.LEVV5he04MAG.ek2HVQ.Gi5jRUjUjB3pAADuVCABPYRS', 0, '2018-11-09 15:37:35', '2018-11-09 15:45:24'),
(31, 'cflores', '$2y$10$zxq58jHfm1ZJ46tVyx7wLeUAPgcdSGUpqpdgoWt9W14vt8cBZb3Oq', 0, '2018-11-09 15:41:27', '2018-11-09 15:43:34'),
(42, 'jorellana', '$2y$10$DUZcSYtEpf51uU6czr3IROP2O5fTbWksvwkEyqjB7BBSsRH/o.J22', 0, '2018-11-17 11:18:11', '2018-11-17 11:30:14'),
(43, 'ximena', '$2y$10$xxR2TCLV9s4o0YkuXlbpT.RFnqnYhiUXc5XCeR5d1Uqm9Hok/15gK', 0, '2018-11-17 11:21:30', '2018-11-17 11:21:30'),
(44, 'bcalancha', '$2y$10$4Uk7M7Kxwj68aJILXjy88uzvwFvHtGPC3eX7bzVBX8EdvXHywWPcy', 0, '2018-11-18 00:11:56', '2018-11-18 00:32:45'),
(45, 'vcostas', '$2y$10$n1OKryu.eZxHCCjtyjdid.YjmFHf9RKFDSDIB3FTMxjfuQgAnbs1a', 0, '2018-11-18 00:13:35', '2018-11-18 00:30:47'),
(46, 'kjaldin', '$2y$10$zg9qNYLghdqVuEIlyQgKrufB7e6kAVZ9Rvgis8yPZr2pN6nlCjGDC', 0, '2018-11-18 00:16:06', '2018-11-18 00:29:13'),
(47, 'naparicio', '$2y$10$2HypidHvf1ntXW3AKCwasu7bfNpHqgce6THVudWvK62xkaggvw3Su', 0, '2018-11-18 00:17:51', '2018-11-18 00:27:34'),
(48, 'kkellog', '$2y$10$xMXww.2nnhe6m/DcLvfZ7e/eut8AxHiP3F9eV/bewx7/1M1aAX1A.', 0, '2018-11-18 00:22:01', '2018-11-18 00:26:33'),
(49, 'tbeckham', '$2y$10$/3gGBk7ljbT9Dxn9XUGZtObJ3Q6XHthc5vVDQS9o/NC6LLNILoTty', 0, '2018-11-18 00:24:02', '2018-11-18 00:25:10'),
(50, 'jvillanueva', '$2y$10$2AjGspndEIZc8sUVlxy74eQ6XCsRNIAML4of5RD9fv/5lJkXhZRfu', 0, '2018-11-18 00:37:21', '2018-11-18 00:37:21'),
(51, 'mayk', '$2y$10$I6GglkSuVQRGZAJfaPmxLenwqo.K91yMHXvZRRqwXNqmyoQm/TXwS', 0, '2018-11-18 00:52:13', '2018-11-18 00:52:13'),
(52, 'pazero', '$2y$10$k90MnxwbiWzuXCBFdDfBIO/5ACh6H9ahWjQYQKEE2Yo8yiYhF5EnG', 0, '2018-11-18 05:00:32', '2018-11-18 05:00:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrator`
--

CREATE TABLE `administrator` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `l_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ml_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ci` int(10) NOT NULL,
  `phone` int(8) NOT NULL,
  `email` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_account` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `administrator`
--

INSERT INTO `administrator` (`id`, `name`, `l_name`, `ml_name`, `ci`, `phone`, `email`, `address`, `id_account`, `created_at`, `updated_at`) VALUES
(3, 'Santiago Diego', 'Valencia', 'Mendez', 5, 4666666, 'santiago-56@gmail.com', '', 1, '0000-00-00 00:00:00', '2018-11-13 20:07:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `description` text COLLATE utf8_spanish_ci NOT NULL,
  `id_parent_area` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id`, `name`, `description`, `id_parent_area`, `created_at`, `updated_at`) VALUES
(19, 'Ingeniería de software', 'primera descripción\r\nsegunda descripción\r\n\r\ntercera descripción ', 19, '2018-11-12 21:06:33', '2018-11-12 21:06:33'),
(20, 'Sistemas de Información', 'Descripción de Sistemas de Información', 20, '2018-11-16 19:39:12', '2018-11-16 19:39:12'),
(21, 'Sistemas transaccionales', 'Estos sistemas basan su funcionamiento en el tipo de transacciones que realizan', 20, '2018-11-16 19:40:14', '2018-11-16 19:40:14'),
(22, 'Inteligencia Artificial', '', 22, '2018-11-16 22:51:46', '2018-11-16 22:51:46'),
(23, 'Sistemas Inteligentes', 'No tieneee', 22, '2018-11-16 22:52:27', '2018-11-16 22:52:27'),
(27, 'Matemática Computacional', '', 27, '2018-11-16 23:59:39', '2018-11-16 23:59:39'),
(28, 'base de datos', '', 28, '2018-11-17 00:00:33', '2018-11-17 00:00:33'),
(29, 'Sistemas Multiagente', '', 22, '2018-11-17 01:48:39', '2018-11-17 01:48:39'),
(30, 'Redes de computadoras', 'Redes como área global', 30, '2018-11-17 23:58:24', '2018-11-17 23:58:24'),
(31, 'Programación web', 'Programación para WWW', 31, '2018-11-17 23:59:32', '2018-11-17 23:59:32'),
(32, 'Reingeniería', '', 32, '2018-11-18 01:01:05', '2018-11-18 01:01:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_profile`
--

CREATE TABLE `area_profile` (
  `id` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `area_profile`
--

INSERT INTO `area_profile` (`id`, `id_profile`, `id_area`, `created_at`, `updated_at`) VALUES
(3, 3, 32, '2018-11-18 05:35:42', '2018-11-18 05:35:42'),
(4, 4, 22, '2018-11-18 13:34:26', '2018-11-18 13:34:26'),
(5, 4, 29, '2018-11-18 13:34:26', '2018-11-18 13:34:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `a_degree`
--

CREATE TABLE `a_degree` (
  `id` int(11) NOT NULL,
  `name_ad` varchar(16) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `a_degree`
--

INSERT INTO `a_degree` (`id`, `name_ad`) VALUES
(1, 'Lic.'),
(2, 'Msc.'),
(3, 'Dr.'),
(4, 'Master'),
(5, 'Ing.'),
(6, 'Msc. Lic.'),
(7, 'Msc. Ing.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `career`
--

CREATE TABLE `career` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `career`
--

INSERT INTO `career` (`id`, `name`) VALUES
(1, 'Licenciatura en Ingenieria Informática'),
(2, 'Ingeniería De Sistemas'),
(3, 'Licenciatura en Informática');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `acronym` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `responsable` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `company`
--

INSERT INTO `company` (`id`, `name`, `acronym`, `responsable`) VALUES
(1, 'Tecnosim', 'Tecnosim', 'Daniel Alegre Campero'),
(2, 'Tunari', 'Tunari', 'Adrin Camacho Prado'),
(3, 'Prime Factor Solutions', 'PFS', 'Henrry Panozo Ustaris'),
(4, 'Transoft Ltda', 'Transoft', 'Victor Garcia Molina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etnprof_area`
--

CREATE TABLE `etnprof_area` (
  `id` int(11) NOT NULL,
  `id_prof` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `etnprof_area`
--

INSERT INTO `etnprof_area` (`id`, `id_prof`, `id_area`, `created_at`, `updated_at`) VALUES
(96, 4, 28, '2018-11-18 00:34:04', '2018-11-18 00:34:04'),
(97, 5, 23, '2018-11-18 00:35:07', '2018-11-18 00:35:07'),
(98, 5, 22, '2018-11-18 00:35:07', '2018-11-18 00:35:07'),
(99, 4, 32, '2018-11-18 01:01:30', '2018-11-18 01:01:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etntutor`
--

CREATE TABLE `etntutor` (
  `id` int(11) NOT NULL,
  `id_entprof` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `etntutor`
--

INSERT INTO `etntutor` (`id`, `id_entprof`, `id_profile`, `created_at`, `updated_at`) VALUES
(14, 4, 3, '2018-11-18 05:37:12', '2018-11-18 05:37:12'),
(15, 4, 3, '2018-11-18 12:37:32', '2018-11-18 12:37:32'),
(16, 4, 4, '2018-11-18 13:36:02', '2018-11-18 13:36:02'),
(17, 5, 4, '2018-11-18 13:36:02', '2018-11-18 13:36:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `is_registered`
--

CREATE TABLE `is_registered` (
  `id` int(11) NOT NULL,
  `ci` int(10) NOT NULL,
  `sigla_mat` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `is_registered`
--

INSERT INTO `is_registered` (`id`, `ci`, `sigla_mat`, `created_at`, `updated_at`) VALUES
(1, 369963, 'tg-2010214', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 258852, 'tg-2010214', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 147741, 'tg-2010214', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 963369, 'tg-2010214', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 852258, 'tg-2010214', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 741147, 'tg-2010214', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itnprof_area`
--

CREATE TABLE `itnprof_area` (
  `id` int(11) NOT NULL,
  `id_prof` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `itnprof_area`
--

INSERT INTO `itnprof_area` (`id`, `id_prof`, `id_area`, `created_at`, `updated_at`) VALUES
(109, 24, 30, '2018-11-18 00:00:17', '2018-11-18 00:00:17'),
(110, 28, 28, '2018-11-18 00:28:14', '2018-11-18 00:28:14'),
(111, 27, 21, '2018-11-18 00:29:52', '2018-11-18 00:29:52'),
(112, 27, 20, '2018-11-18 00:29:52', '2018-11-18 00:29:52'),
(113, 26, 31, '2018-11-18 00:31:50', '2018-11-18 00:31:50'),
(114, 29, 32, '2018-11-18 05:05:54', '2018-11-18 05:05:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modality`
--

CREATE TABLE `modality` (
  `id` int(11) NOT NULL,
  `name_mod` varchar(40) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `modality`
--

INSERT INTO `modality` (`id`, `name_mod`) VALUES
(1, 'Adscripción'),
(2, 'Proyecto de Grado'),
(4, 'Proyecto de Investigación (Tesis)'),
(3, 'Trabajo Dirigido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `period`
--

CREATE TABLE `period` (
  `id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `period` int(1) NOT NULL,
  `extended` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `period`
--

INSERT INTO `period` (`id`, `start_date`, `end_date`, `period`, `extended`, `created_at`, `updated_at`) VALUES
(2, '2018-11-18', '2020-11-18', 2, 0, '2018-11-18 00:21:36', '2018-11-18 00:21:36'),
(3, '2018-11-18', '2020-11-18', 2, 0, '2018-11-18 00:35:42', '2018-11-18 00:35:42'),
(4, '2018-11-18', '2020-11-18', 2, 0, '2018-11-18 08:34:26', '2018-11-18 08:34:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulant`
--

CREATE TABLE `postulant` (
  `id` int(11) NOT NULL,
  `ci` int(10) NOT NULL,
  `name` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `l_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ml_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `phone` int(8) NOT NULL,
  `address` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cod_sis` int(9) NOT NULL,
  `id_account` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `postulant`
--

INSERT INTO `postulant` (`id`, `ci`, `name`, `l_name`, `ml_name`, `email`, `phone`, `address`, `cod_sis`, `id_account`, `created_at`, `updated_at`) VALUES
(5, 147741, 'Ximena', 'Montano', 'Camcho', 'ximena15@gmail.com', 0, '', 0, 43, '2018-11-17 11:21:30', '2018-11-17 11:21:30'),
(6, 741147, 'Jorge Andres', 'Villanueva', 'Castillo', 'jandres@gmail.com', 0, '', 0, 50, '2018-11-18 00:37:21', '2018-11-18 00:37:21'),
(7, 852258, 'Mayk', 'Arispe', 'Aguilar', 'mayk@gmail.com', 0, '', 900909000, 51, '2018-11-18 00:52:13', '2018-11-18 00:52:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulant_profile`
--

CREATE TABLE `postulant_profile` (
  `id` int(11) NOT NULL,
  `id_postulant` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `id_career` int(11) NOT NULL,
  `id_period` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `postulant_profile`
--

INSERT INTO `postulant_profile` (`id`, `id_postulant`, `id_profile`, `id_career`, `id_period`, `created_at`, `updated_at`) VALUES
(3, 7, 3, 1, 3, '2018-11-18 00:35:42', '2018-11-18 00:35:42'),
(4, 6, 4, 1, 4, '2018-11-18 08:34:26', '2018-11-18 08:34:26'),
(5, 5, 4, 1, 4, '2018-11-18 08:34:26', '2018-11-18 08:34:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `professional_ext`
--

CREATE TABLE `professional_ext` (
  `id` int(11) NOT NULL,
  `ci` int(10) NOT NULL,
  `name` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `l_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ml_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `phone` int(9) NOT NULL,
  `address` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `active` int(1) NOT NULL,
  `id_ad` int(11) NOT NULL,
  `profile` text COLLATE utf8_spanish_ci NOT NULL,
  `id_account` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `professional_ext`
--

INSERT INTO `professional_ext` (`id`, `ci`, `name`, `l_name`, `ml_name`, `email`, `phone`, `address`, `active`, `id_ad`, `profile`, `id_account`, `created_at`, `updated_at`) VALUES
(4, 560054, 'Kiefer', 'Kellog', 'Hawk', 'kkiefer@gmail.com', 0, '', 1, 1, '', 48, '2018-11-18 00:22:01', '2018-11-18 00:22:02'),
(5, 300056, 'Thomas', 'Beckham', 'Gates', 'thomas@gmail.com', 0, '', 1, 1, '', 49, '2018-11-18 00:24:03', '2018-11-18 00:24:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `professional_umss`
--

CREATE TABLE `professional_umss` (
  `id` int(11) NOT NULL,
  `ci` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `l_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ml_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `phone` int(8) NOT NULL,
  `address` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `cod_sis` int(8) NOT NULL,
  `active` int(1) NOT NULL,
  `id_ad` int(11) NOT NULL,
  `id_wl` int(11) NOT NULL,
  `profile` text COLLATE utf8_spanish_ci NOT NULL,
  `id_account` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `professional_umss`
--

INSERT INTO `professional_umss` (`id`, `ci`, `name`, `l_name`, `ml_name`, `email`, `phone`, `address`, `cod_sis`, `active`, `id_ad`, `id_wl`, `profile`, `id_account`, `created_at`, `updated_at`) VALUES
(17, 589257, 'Patricia Elizabeth', 'Romero', 'Rodriguez', 'paromeror@gmail.com', 0, '', 200422022, 1, 1, 1, '', 30, '2018-11-09 15:37:35', '2018-11-09 15:45:24'),
(18, 7851244, 'Corina Justina', 'Flores', 'Villarroel', 'corina@memi.umss.edu.bo', 0, '', 200402444, 1, 1, 1, '', 31, '2018-11-09 15:41:27', '2018-11-09 15:43:34'),
(24, 9005009, 'Jorge Walter', 'Orellana', 'Araoz', 'jw.orellana@umss.edu.bo', 0, '', 30033333, 1, 1, 1, '', 42, '2018-11-17 11:18:11', '2018-11-17 11:30:14'),
(25, 9090807, 'Boris Marcelo', 'Calancha', 'Navia', 'boris@fcyt.umss.edu.bo', 0, '', 30033333, 1, 1, 1, '', 44, '2018-11-18 00:11:56', '2018-11-18 00:32:45'),
(26, 5632544, 'Vladimir', 'Costas', 'Jáuregui', 'v.costas@umss.edu.bo', 0, '', 30033333, 1, 1, 1, '', 45, '2018-11-18 00:13:35', '2018-11-18 00:30:47'),
(27, 604050, 'K. Rolando', 'Jaldin', 'Rosales', 'rjaldin@hotmail.com', 0, '', 30033333, 1, 1, 1, '', 46, '2018-11-18 00:16:06', '2018-11-18 00:29:13'),
(28, 402060, 'Nancy Tatiana', 'Aparicio', 'Yuja', 'aparicio@ucbcba.edu.bo', 0, '', 30033333, 1, 1, 1, '', 47, '2018-11-18 00:17:51', '2018-11-18 00:27:35'),
(29, 600045, 'Pablo Ramon', 'Azero', 'Alcocer', 'pabloazero@memi.umss.edu.bo', 0, '', 0, 0, 1, 1, '', 52, '2018-11-18 05:00:32', '2018-11-18 05:06:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `num_profile` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `title` text COLLATE utf8_spanish_ci NOT NULL,
  `g_objective` text COLLATE utf8_spanish_ci NOT NULL,
  `s_objects` text COLLATE utf8_spanish_ci NOT NULL,
  `description` text COLLATE utf8_spanish_ci NOT NULL,
  `id_cmpy_area` int(11) NOT NULL,
  `id_mod` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `profile`
--

INSERT INTO `profile` (`id`, `num_profile`, `title`, `g_objective`, `s_objects`, `description`, `id_cmpy_area`, `id_mod`, `id_status`, `created_at`, `updated_at`) VALUES
(3, '', 'titulo nuevo de reingenieria editado', 'objetivo general de perfil en reingeniería', 'objetivo 80\r\nobjetivo 20', 'algo de descripcion para perfiles con reingeniería', 1, 2, 3, '2018-11-18 05:35:42', '2018-11-18 15:28:50'),
(4, '2', 'nuevo perfil editado', 'objetivo general nuevo perfil', 'objetivos especificos nuevo perfil', 'descripcion nuevo perfil', 2, 3, 3, '2018-11-18 13:34:26', '2018-11-18 15:00:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prof_smatter`
--

CREATE TABLE `prof_smatter` (
  `id` int(11) NOT NULL,
  `id_prof` int(11) NOT NULL,
  `id_smatter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `prof_smatter`
--

INSERT INTO `prof_smatter` (`id`, `id_prof`, `id_smatter`) VALUES
(1, 18, 1),
(2, 17, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsable`
--

CREATE TABLE `responsable` (
  `id` int(11) NOT NULL,
  `id_intprof` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL,
  `id_type_resp` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `responsable`
--

INSERT INTO `responsable` (`id`, `id_intprof`, `id_profile`, `id_type_resp`, `created_at`, `updated_at`) VALUES
(14, 18, 3, 1, '2018-11-18 05:37:12', '2018-11-18 05:37:12'),
(15, 18, 3, 1, '2018-11-18 12:37:32', '2018-11-18 12:37:32'),
(16, 18, 4, 1, '2018-11-18 13:36:02', '2018-11-18 13:36:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `name_rol` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `name_rol`, `created_at`, `update_at`) VALUES
(1, 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'director', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'etnprof', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'itnprof', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'secretary', '2018-11-02 04:10:10', '2018-11-03 06:11:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secretary`
--

CREATE TABLE `secretary` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `l_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ml_name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `ci` int(10) NOT NULL,
  `phone` int(8) NOT NULL,
  `email` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_account` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `secretary`
--

INSERT INTO `secretary` (`id`, `name`, `l_name`, `ml_name`, `ci`, `phone`, `email`, `address`, `id_account`, `created_at`, `updated_at`) VALUES
(1, 'Susana', 'Torrico', 'Fuentes', 1, 4568090, 'susanaf@gmail.com', 'Simon Lopez #210', 3, '2018-11-06 03:04:09', '2018-11-13 20:04:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'inhabilitado'),
(2, 'aceptado'),
(3, 'revision'),
(4, 'tribunales'),
(5, 'defendido'),
(6, 'rechazado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subject_matter`
--

CREATE TABLE `subject_matter` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `sigla` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `subject_matter`
--

INSERT INTO `subject_matter` (`id`, `name`, `sigla`) VALUES
(1, 'Taller de grado I', '2010214'),
(2, 'Taller de grado II', '2010215');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_resp`
--

CREATE TABLE `type_resp` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `type_resp`
--

INSERT INTO `type_resp` (`id`, `name`) VALUES
(1, 'teacher'),
(2, 'tutor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_rol`
--

CREATE TABLE `user_rol` (
  `id` int(11) NOT NULL,
  `id_account` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `user_rol`
--

INSERT INTO `user_rol` (`id`, `id_account`, `id_rol`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 3, 5, '2018-11-03 05:05:05', '2018-11-06 10:10:10'),
(21, 30, 4, '2018-11-09 15:37:36', '2018-11-09 15:37:36'),
(22, 31, 4, '2018-11-09 15:41:28', '2018-11-09 15:41:28'),
(30, 42, 4, '2018-11-17 11:18:11', '2018-11-17 11:18:11'),
(31, 44, 2, '2018-11-18 00:11:56', '2018-11-18 04:32:19'),
(32, 45, 4, '2018-11-18 00:13:35', '2018-11-18 00:13:35'),
(33, 46, 4, '2018-11-18 00:16:08', '2018-11-18 00:16:08'),
(34, 47, 4, '2018-11-18 00:17:52', '2018-11-18 00:17:52'),
(35, 48, 3, '2018-11-18 00:22:02', '2018-11-18 00:22:02'),
(36, 49, 3, '2018-11-18 00:24:04', '2018-11-18 00:24:04'),
(37, 52, 4, '2018-11-18 05:00:33', '2018-11-18 05:00:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `workload`
--

CREATE TABLE `workload` (
  `id` int(11) NOT NULL,
  `name_wl` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `workload`
--

INSERT INTO `workload` (`id`, `name_wl`) VALUES
(1, 'Tiempo Parcial'),
(2, 'Tiempo Completo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_ACCOUNT` (`id_account`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_AREA` (`id_parent_area`);

--
-- Indices de la tabla `area_profile`
--
ALTER TABLE `area_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_PROFILE` (`id_profile`),
  ADD KEY `FK_ID_AREA` (`id_area`);

--
-- Indices de la tabla `a_degree`
--
ALTER TABLE `a_degree`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `career`
--
ALTER TABLE `career`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `etnprof_area`
--
ALTER TABLE `etnprof_area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_ETNPROFESSIONAL` (`id_prof`),
  ADD KEY `FK_ID_AREA` (`id_area`);

--
-- Indices de la tabla `etntutor`
--
ALTER TABLE `etntutor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_ETNPROF` (`id_entprof`),
  ADD KEY `FK_ID_PROFILE` (`id_profile`);

--
-- Indices de la tabla `is_registered`
--
ALTER TABLE `is_registered`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `itnprof_area`
--
ALTER TABLE `itnprof_area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_PROFESSIONAL` (`id_prof`),
  ADD KEY `FK_ID_AREA` (`id_area`);

--
-- Indices de la tabla `modality`
--
ALTER TABLE `modality`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_mod` (`name_mod`);

--
-- Indices de la tabla `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `postulant`
--
ALTER TABLE `postulant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_ACCOUNT` (`id_account`);

--
-- Indices de la tabla `postulant_profile`
--
ALTER TABLE `postulant_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_POSTULANT` (`id_postulant`),
  ADD KEY `FK_ID_PROFILE` (`id_profile`),
  ADD KEY `FK_ID_CAREER` (`id_career`),
  ADD KEY `FK_ID_PERIOD` (`id_period`);

--
-- Indices de la tabla `professional_ext`
--
ALTER TABLE `professional_ext`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_ACCOUNT` (`id_account`),
  ADD KEY `FK_ID_AD` (`id_ad`);

--
-- Indices de la tabla `professional_umss`
--
ALTER TABLE `professional_umss`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_ACCOUNT` (`id_account`),
  ADD KEY `FK_ID_AD` (`id_ad`),
  ADD KEY `FK_ID_WL` (`id_wl`);

--
-- Indices de la tabla `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_MOD` (`id_mod`),
  ADD KEY `FK_ID_STATUS` (`id_status`),
  ADD KEY `FK_ID_CMPY_AREA` (`id_cmpy_area`);

--
-- Indices de la tabla `prof_smatter`
--
ALTER TABLE `prof_smatter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_PROFESSIONAL` (`id_prof`),
  ADD KEY `FK_ID_SMATTER` (`id_smatter`);

--
-- Indices de la tabla `responsable`
--
ALTER TABLE `responsable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_ITNPROF` (`id_intprof`),
  ADD KEY `FK_ID_PROFILE` (`id_profile`),
  ADD KEY `ID_TYPE_RESP` (`id_type_resp`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `secretary`
--
ALTER TABLE `secretary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_ACCOUNT` (`id_account`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subject_matter`
--
ALTER TABLE `subject_matter`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `type_resp`
--
ALTER TABLE `type_resp`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_rol`
--
ALTER TABLE `user_rol`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_ACCOUNT` (`id_account`),
  ADD KEY `FK_ID_ROL` (`id_rol`);

--
-- Indices de la tabla `workload`
--
ALTER TABLE `workload`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `area_profile`
--
ALTER TABLE `area_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `a_degree`
--
ALTER TABLE `a_degree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `career`
--
ALTER TABLE `career`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `etnprof_area`
--
ALTER TABLE `etnprof_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `etntutor`
--
ALTER TABLE `etntutor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `is_registered`
--
ALTER TABLE `is_registered`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `itnprof_area`
--
ALTER TABLE `itnprof_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de la tabla `modality`
--
ALTER TABLE `modality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `period`
--
ALTER TABLE `period`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `postulant`
--
ALTER TABLE `postulant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `postulant_profile`
--
ALTER TABLE `postulant_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `professional_ext`
--
ALTER TABLE `professional_ext`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `professional_umss`
--
ALTER TABLE `professional_umss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `prof_smatter`
--
ALTER TABLE `prof_smatter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `responsable`
--
ALTER TABLE `responsable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `secretary`
--
ALTER TABLE `secretary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `subject_matter`
--
ALTER TABLE `subject_matter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `type_resp`
--
ALTER TABLE `type_resp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user_rol`
--
ALTER TABLE `user_rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `workload`
--
ALTER TABLE `workload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `area_ibfk_1` FOREIGN KEY (`id_parent_area`) REFERENCES `area` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `area_profile`
--
ALTER TABLE `area_profile`
  ADD CONSTRAINT `area_profile_ibfk_1` FOREIGN KEY (`id_profile`) REFERENCES `profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `area_profile_ibfk_2` FOREIGN KEY (`id_area`) REFERENCES `area` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `etnprof_area`
--
ALTER TABLE `etnprof_area`
  ADD CONSTRAINT `etnprof_area_ibfk_1` FOREIGN KEY (`id_prof`) REFERENCES `professional_ext` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `etnprof_area_ibfk_2` FOREIGN KEY (`id_area`) REFERENCES `area` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `etntutor`
--
ALTER TABLE `etntutor`
  ADD CONSTRAINT `etntutor_ibfk_1` FOREIGN KEY (`id_entprof`) REFERENCES `professional_ext` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `etntutor_ibfk_2` FOREIGN KEY (`id_profile`) REFERENCES `profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `itnprof_area`
--
ALTER TABLE `itnprof_area`
  ADD CONSTRAINT `itnprof_area_ibfk_1` FOREIGN KEY (`id_area`) REFERENCES `area` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `itnprof_area_ibfk_2` FOREIGN KEY (`id_prof`) REFERENCES `professional_umss` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `postulant`
--
ALTER TABLE `postulant`
  ADD CONSTRAINT `postulant_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `postulant_profile`
--
ALTER TABLE `postulant_profile`
  ADD CONSTRAINT `postulant_profile_ibfk_1` FOREIGN KEY (`id_postulant`) REFERENCES `postulant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `postulant_profile_ibfk_2` FOREIGN KEY (`id_profile`) REFERENCES `profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `postulant_profile_ibfk_3` FOREIGN KEY (`id_career`) REFERENCES `career` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `postulant_profile_ibfk_4` FOREIGN KEY (`id_period`) REFERENCES `period` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `professional_ext`
--
ALTER TABLE `professional_ext`
  ADD CONSTRAINT `professional_ext_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `professional_ext_ibfk_2` FOREIGN KEY (`id_ad`) REFERENCES `a_degree` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `professional_umss`
--
ALTER TABLE `professional_umss`
  ADD CONSTRAINT `professional_umss_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `professional_umss_ibfk_2` FOREIGN KEY (`id_ad`) REFERENCES `a_degree` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `professional_umss_ibfk_3` FOREIGN KEY (`id_wl`) REFERENCES `workload` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`id_mod`) REFERENCES `modality` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profile_ibfk_2` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prof_smatter`
--
ALTER TABLE `prof_smatter`
  ADD CONSTRAINT `prof_smatter_ibfk_1` FOREIGN KEY (`id_prof`) REFERENCES `professional_umss` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prof_smatter_ibfk_2` FOREIGN KEY (`id_smatter`) REFERENCES `subject_matter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `responsable`
--
ALTER TABLE `responsable`
  ADD CONSTRAINT `responsable_ibfk_1` FOREIGN KEY (`id_intprof`) REFERENCES `professional_umss` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `responsable_ibfk_2` FOREIGN KEY (`id_profile`) REFERENCES `profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `responsable_ibfk_3` FOREIGN KEY (`id_type_resp`) REFERENCES `type_resp` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `secretary`
--
ALTER TABLE `secretary`
  ADD CONSTRAINT `secretary_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_rol`
--
ALTER TABLE `user_rol`
  ADD CONSTRAINT `user_rol_ibfk_2` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_rol_ibfk_3` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
