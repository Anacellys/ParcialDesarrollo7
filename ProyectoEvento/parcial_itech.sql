-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 30-06-2026 a las 15:05:06
-- Versión del servidor: 8.4.7
-- Versión de PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `parcial_itech`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas_interes`
--

DROP TABLE IF EXISTS `areas_interes`;
CREATE TABLE IF NOT EXISTS `areas_interes` (
  `id_area` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_area`),
  UNIQUE KEY `uq_area_nombre` (`nombre`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `areas_interes`
--

INSERT INTO `areas_interes` (`id_area`, `nombre`) VALUES
(1, 'Cloud Computing'),
(2, 'Big Data'),
(3, 'Desarrollo Móvil'),
(4, 'Ciberseguridad'),
(5, 'IoT'),
(6, 'Machine Learning'),
(7, 'DevOps'),
(8, 'Python');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscriptores`
--

DROP TABLE IF EXISTS `inscriptores`;
CREATE TABLE IF NOT EXISTS `inscriptores` (
  `id_inscriptor` int NOT NULL AUTO_INCREMENT,
  `identidad` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edad` int NOT NULL,
  `sexo` enum('Masculino','Femenino','Otro') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pais_residencia` int NOT NULL,
  `id_nacionalidad` int NOT NULL,
  `correo` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `celular` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `firma_openssl` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_inscriptor`),
  UNIQUE KEY `uq_identidad` (`identidad`),
  UNIQUE KEY `uq_correo` (`correo`),
  KEY `fk_pais_residencia` (`id_pais_residencia`),
  KEY `fk_nacionalidad` (`id_nacionalidad`)
) ;

--
-- Volcado de datos para la tabla `inscriptores`
--

INSERT INTO `inscriptores` (`id_inscriptor`, `identidad`, `nombre`, `apellido`, `edad`, `sexo`, `id_pais_residencia`, `id_nacionalidad`, `correo`, `celular`, `observaciones`, `firma_openssl`, `fecha_registro`) VALUES
(1, '0008-1032-00665', 'Anacelis', 'Boniche', 20, 'Femenino', 5, 7, 'anacelisbooniche04@gmail.com', '64667788', 'okkkkkkkkkkkk', 'qflEnmiHdi03M948LxXS6+fNGRl+Nr9FqkEXhen9+OcsrNBHzagxjguuI2wQqGnjo0s0pEny7Rcok+MbhFsrxXiBAuRxdJbb6+FMLcuj4cJ5iV/ipcI3ayh20pVjWJEyTX2GrhIxKDSUAN0mzanbc+qRKlMWiW7gWF68BexNZ8qX/V015f6U/VnsBpIBO2s4zKqtVu2hZkTVE7y3Jy8RLw3t2IzEC1l1RBz2hXjKSy4PqSSNwm4RZl7BoZaCT+CFZ404AroDaThhPkayQIoySi8BbMjqTAPCIJ+fZdT/Vty77P3TbNMygoyqVSxHOUlXUsWP67+mo4SStytNc/+71A==', '2026-06-30 14:38:13'),
(2, '0008-1032-00669', 'Arely', 'Mendoza', 14, 'Femenino', 2, 13, 'estrella@gmail.com', '64669788', 'kkllllll', 'VbpcWqxVHHsraqSsttXY02Ig0xUX15MJarhz4n70713d5jDSaCeUXP561h3yXhfwVRQIMKrQED/aBjh1cC+/IoLF9V7ILB0HGWV8aL+F5BIySP0UZ/m4pwI8rNd52bs9IbZzYf1nlwwDegvKjSyCzpTBSnzNlR7ThwZ78uXUumWcWBaOvYJb+SifT3zEvU0TZMsJ8A1fBesVVOUvWUVtCOjX/fWEm/scLVNEqAYbBLDAt09e03QIhfrwy069/F9VGmK2AdQQf/S7ZziEzKk+gD2o3loNK0TUyetUKeVrzeM8DrcrtF+9mqzXpPig1Jv5D8bHCu+mLnYZWcMLYHphLg==', '2026-06-30 14:41:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscriptor_area`
--

DROP TABLE IF EXISTS `inscriptor_area`;
CREATE TABLE IF NOT EXISTS `inscriptor_area` (
  `id_inscriptor` int NOT NULL,
  `id_area` int NOT NULL,
  PRIMARY KEY (`id_inscriptor`,`id_area`),
  KEY `fk_ia_area` (`id_area`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inscriptor_area`
--

INSERT INTO `inscriptor_area` (`id_inscriptor`, `id_area`) VALUES
(1, 2),
(2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

DROP TABLE IF EXISTS `paises`;
CREATE TABLE IF NOT EXISTS `paises` (
  `id_pais` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_pais`),
  UNIQUE KEY `uq_pais_nombre` (`nombre`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id_pais`, `nombre`) VALUES
(1, 'Panamá'),
(2, 'Costa Rica'),
(3, 'Colombia'),
(4, 'México'),
(5, 'Estados Unidos'),
(6, 'Canadá'),
(7, 'España'),
(8, 'Argentina'),
(9, 'Chile'),
(10, 'Perú'),
(11, 'Venezuela'),
(12, 'Brasil'),
(13, 'Ecuador'),
(14, 'Uruguay'),
(15, 'Paraguay'),
(16, 'Bolivia'),
(17, 'Guatemala'),
(18, 'Honduras'),
(19, 'Nicaragua'),
(20, 'El Salvador');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
