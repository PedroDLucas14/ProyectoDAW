-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-06-2023 a las 17:55:39
-- Versión del servidor: 10.9.3-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `starwarshunters`
--
CREATE DATABASE starwarshunters;
USE starwarshunters;

CREATE USER 'adminSH'@'localhost' IDENTIFIED BY 'admin';
GRANT ALL PRIVILEGES ON starwarshunters.* TO 'adminSH'@'localhost';
FLUSH PRIVILEGES;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesorios`
--

CREATE TABLE `accesorios` (
  `cod_accesorio` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ataque` int(11) DEFAULT NULL,
  `aumento_ataque` int(11) DEFAULT NULL,
  `defensa` int(11) DEFAULT NULL,
  `aumento_defensa` int(11) DEFAULT NULL,
  `resistencia` int(11) DEFAULT NULL,
  `aumento_resistencia` int(11) DEFAULT NULL,
  `valor` int(11) NOT NULL,
  `coste_nivel` int(11) DEFAULT NULL,
  `imagen` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `accesorios`
--

INSERT INTO `accesorios` (`cod_accesorio`, `nombre`, `descripcion`, `ataque`, `aumento_ataque`, `defensa`, `aumento_defensa`, `resistencia`, `aumento_resistencia`, `valor`, `coste_nivel`, `imagen`, `created_at`, `updated_at`) VALUES
(3, 'Cañón láser L-s1', 'Cañón láser fabricado por los Sistemas de Flotas Sienar', 50, 5, NULL, NULL, NULL, NULL, 2000, 1000, 'imgBD/accesorios/barrage_rockets.png', NULL, NULL),
(4, 'Cañones láser IX4', 'Cañón láser desarrollado por Taim & Bak', 50, 5, NULL, NULL, NULL, NULL, 2000, 1000, 'imgBD/accesorios/barrage.png', NULL, NULL),
(5, 'Droide astromecánico', 'Robots sofisticados de reparación de computadores y recuperación de información, especializados en el mantenimiento de las naves espaciales.', NULL, NULL, 100, 10, 200, 10, 2000, 1000, 'imgBD/accesorios/bbAtrach.png', NULL, NULL),
(6, 'Sensores avanzados', 'aaaaa', NULL, NULL, 75, 15, 50, NULL, 1200, 1000, 'imgBD/accesorios/Advanced_Sensors.png', NULL, NULL),
(7, 'Cañón de iones', 'Deshabilita a tus enemigos con descargas de energía disruptiva. Paraliza naves enemigas y desactiva sus sistemas electrónicos.', 60, 10, 30, 5, NULL, NULL, 3000, 1000, 'imgBD/accesorios/Cañon_de_iones.png', NULL, NULL),
(8, 'Autoblasters', 'Dispara rápidamente con estos cañones automáticos de precisión. Lanza una lluvia de proyectiles letales contra tus adversarios.', 80, 10, NULL, NULL, NULL, NULL, 3000, 1100, 'imgBD/accesorios/Autoblasters.png', NULL, NULL),
(9, 'Propulsores cebados', 'Aumenta la velocidad de tu nave al máximo. Disfruta de aceleraciones explosivas y maniobras ágiles para superar a tus oponentes.', NULL, NULL, 100, 10, NULL, NULL, 3000, 1200, 'imgBD/accesorios/Propulsores_cebados.png', NULL, NULL),
(10, 'Torreta de cañón de iones', 'Coloca esta torreta en tu nave y desata descargas de energía iónica sobre tus enemigos. Paraliza y desactiva sus sistemas, dejándolos vulnerables ante tus ataques.', NULL, NULL, 50, 10, 40, 15, 3500, 2000, 'imgBD/accesorios/torreta_iones.png', NULL, NULL),
(11, 'Mejora de escudo', 'Refuerza la protección de tu nave con este sistema avanzado. Aumenta la resistencia y la durabilidad de tu escudo, brindándote una defensa sólida en combate.', NULL, NULL, 150, 30, 1000, 100, 10000, 5000, 'imgBD/accesorios/mejora_escudo.png', NULL, NULL),
(12, 'Artillero de primera', 'Añade a tu tripulación a este experto en combate. Potencia tus ataques con precisión y destreza, infligiendo un daño devastador a tus enemigos', 250, 30, NULL, NULL, NULL, NULL, 10000, 5000, 'imgBD/accesorios/artillero_de_primera.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesorio_registro_batalla`
--

CREATE TABLE `accesorio_registro_batalla` (
  `cod_accesorio_registro_batalla` bigint(20) UNSIGNED NOT NULL,
  `cod_registro_batalla` bigint(20) UNSIGNED NOT NULL,
  `cod_usuario_accesorio` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `accesorio_registro_batalla`
--

INSERT INTO `accesorio_registro_batalla` (`cod_accesorio_registro_batalla`, `cod_registro_batalla`, `cod_usuario_accesorio`) VALUES
(1, 1, 27),
(2, 1, 26),
(3, 1, 6),
(4, 1, 5),
(5, 1, 7),
(6, 2, 24),
(7, 2, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_roles`
--

CREATE TABLE `acl_roles` (
  `cod_acl_role` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perm1` tinyint(1) NOT NULL DEFAULT 0,
  `perm2` tinyint(1) NOT NULL DEFAULT 0,
  `perm3` tinyint(1) NOT NULL DEFAULT 0,
  `perm4` tinyint(1) NOT NULL DEFAULT 0,
  `perm5` tinyint(1) NOT NULL DEFAULT 0,
  `perm6` tinyint(1) NOT NULL DEFAULT 0,
  `perm7` tinyint(1) NOT NULL DEFAULT 0,
  `perm8` tinyint(1) NOT NULL DEFAULT 0,
  `perm9` tinyint(1) NOT NULL DEFAULT 0,
  `perm10` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `acl_roles`
--

INSERT INTO `acl_roles` (`cod_acl_role`, `nombre`, `perm1`, `perm2`, `perm3`, `perm4`, `perm5`, `perm6`, `perm7`, `perm8`, `perm9`, `perm10`, `created_at`, `updated_at`) VALUES
(1, 'administrador', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2023-04-15 13:55:18', '2023-04-15 13:55:18'),
(2, 'jugador', 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '2023-04-15 13:55:18', '2023-04-15 13:55:18'),
(3, 'mantenimiento', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, '2023-04-15 13:55:18', '2023-04-15 13:55:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_usuarios`
--

CREATE TABLE `acl_usuarios` (
  `cod_acl_usuario` bigint(20) UNSIGNED NOT NULL,
  `nick` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cod_acl_role` bigint(20) UNSIGNED NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `acl_usuarios`
--

INSERT INTO `acl_usuarios` (`cod_acl_usuario`, `nick`, `nombre`, `email`, `password`, `cod_acl_role`, `borrado`, `remember_token`, `created_at`, `updated_at`) VALUES
(11, 'Lubba', 'Pedro David', 'espectroBro2122@gmail.com', '$2y$10$NH.3u3gQp3BmyCn0Q2B46evZt1tmamaXZN6QTWG.WpOocSGszBdiW', 1, 0, 'aRRz6hnraZMh0qMOBR1FEe8iPEyQU5ZGdawy1TYcgc03EpZFSE0WTa3bRfHP', '2023-04-23 13:45:19', '2023-06-14 17:18:26'),
(70, 'Prueba25', 'Prueba25', 'prueba25@gmail.com', '$2y$10$2gKHTkSMRV09L1E19Jqd7uri9ORXLgLmJ4v0InhwqPqrSbiegFgDW', 2, 0, NULL, '2023-06-14 08:15:47', '2023-06-17 19:12:16'),
(73, 'Jarvis', 'prueba de manetnimiento', 'jarvis@gmail.com', '$2y$10$qaj/Keb4HY0BIXIVua70leq6X/jiE/4Rjzbc/XNaabDeTkghrYBPi', 3, 0, NULL, '2023-06-15 13:23:49', '2023-06-15 13:23:49'),
(74, 'Xopyes', 'Xopyes', 'Xopyes@gmail.com', '$2y$10$CJpvrgG71JTWTYv.BoQr2eMU3u3Rf3njWQcSbHHn5bapy4ViSUpCW', 2, 0, NULL, '2023-06-19 12:55:48', '2023-06-19 13:27:18'),
(75, 'Tahuna', 'Tahuna', 'Tahuna@gmail.com', '$2y$10$.GzbfkYFktYLCe8eC.4AeeahKkjNbiGKip8IekmlJmuuZy2Rx5gGe', 2, 0, NULL, '2023-06-19 12:56:32', '2023-06-19 12:56:32'),
(76, 'Riufil', 'Riufil', 'Riufil@gmail.com', '$2y$10$wdyOVwEtm0/tjWXgcHJny.Oyqp//GxNRjcY0jhLphRzWX1Nqja0C.', 2, 0, NULL, '2023-06-19 12:58:14', '2023-06-19 12:58:14'),
(77, 'Lunixe', 'Lunixe', 'Lunixe@gmail.com', '$2y$10$NWFb4v4RwtPmVMGkZMJxr.Mlh1dL39UGLH5TjMGkLYkBSP/ttq9mC', 2, 0, NULL, '2023-06-19 12:59:47', '2023-06-19 12:59:47'),
(78, 'Zenake', 'Zenake', 'Zenake@gmail.com', '$2y$10$cN/zpgflOhIUkPoo1j84uu6L/AWS1OaENnw.x1rHcM1sa5P96yQcK', 2, 0, NULL, '2023-06-19 13:06:37', '2023-06-19 13:06:37'),
(79, 'Xudemi', 'Xudemi', 'Xudemi@gmail.com', '$2y$10$UrBdKY9R3cFSIDvR8bMjgeQomKCmHKJWmQQ7/UR5wn10pBD13N49u', 2, 0, NULL, '2023-06-19 13:08:09', '2023-06-19 13:08:09'),
(80, 'Arkeur', 'Arkeur', 'Arkeur@gmail.com', '$2y$10$qDd8UZS73xSluQkH6RIMNu3oaZ5tUcqh0sFbJZbppCoMRI1GOBlnu', 2, 0, NULL, '2023-06-19 13:12:55', '2023-06-19 13:12:55'),
(81, 'Giruse', 'Giruse', 'Giruse@gmail.com', '$2y$10$iHH3j3bs8/xK8ZUOJ7ocPOTIuRlKk4ZYLTDbQ9PaAyMmzOXaeg3ly', 2, 0, NULL, '2023-06-19 13:15:16', '2023-06-19 13:15:16'),
(82, 'Bopide', 'Bopide', 'Bopide@gmail.com', '$2y$10$Haan9Wtn7Bdij4iET2oAnOhSuz.S0jfHUP7RD0N76N2L2r1riaFLm', 2, 0, NULL, '2023-06-19 13:18:04', '2023-06-19 13:18:04'),
(83, 'casamorada', 'casamorada', 'casamorada@gmail.com', '$2y$10$y1xLvnGxYb1yxBZ6oX6HkuKv7EC9jJAwFoP6KUD57iGfCN2Hg0foi', 2, 0, NULL, '2023-06-19 13:19:43', '2023-06-19 13:19:43'),
(84, 'Nuamua', 'Nuamua', 'Nuamua@gmail.com', '$2y$10$i1trqvrxaW8iy.cq/qRbOemjZT5ZYAM3ikYzL3JPalPF9wm8KqI12', 2, 0, NULL, '2023-06-19 13:21:14', '2023-06-19 13:21:14'),
(85, 'Gacilu', 'Gacilu', 'Gacilu@gmail.com', '$2y$10$o2o/VbsntAupjIS3Zx4XLur86MuXj.BkmjnrXz9DV9Rgka0f55Hdm', 2, 0, NULL, '2023-06-19 13:29:44', '2023-06-19 13:29:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `batalla`
--

CREATE TABLE `batalla` (
  `cod_batalla` bigint(20) UNSIGNED NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_final` time DEFAULT NULL,
  `fecha` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `usuario_ganador` bigint(20) UNSIGNED DEFAULT NULL,
  `tiempo_batalla` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `batalla`
--

INSERT INTO `batalla` (`cod_batalla`, `hora_inicio`, `hora_final`, `fecha`, `estado`, `usuario_ganador`, `tiempo_batalla`, `created_at`, `updated_at`) VALUES
(1, '14:36:41', '14:38:13', '2023-06-19', 0, 11, 90, '2023-06-19 12:36:41', '2023-06-19 12:36:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divisiones`
--

CREATE TABLE `divisiones` (
  `cod_division` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `puntos_minimos` int(11) NOT NULL,
  `puntos_maximos` int(11) NOT NULL,
  `imagen` varchar(250) COLLATE utf8mb4_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `divisiones`
--

INSERT INTO `divisiones` (`cod_division`, `nombre`, `puntos_minimos`, `puntos_maximos`, `imagen`) VALUES
(1, 'Bronce', 0, 999, '\\imgBD\\divisiones\\bronce.png'),
(2, 'Plata', 1000, 1999, '\\imgBD\\divisiones\\plata.png'),
(3, 'Oro', 2000, 2999, 'imgBD\\divisiones\\oro.png'),
(4, 'Platino', 3000, 3999, 'imgBD\\divisiones\\platino.png'),
(5, 'Diamante', 4000, 4999, 'imgBD\\divisiones\\diamante.png'),
(6, 'Campeón', 5000, 10000000, 'imgBD\\divisiones\\campeon.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilidades`
--

CREATE TABLE `habilidades` (
  `cod_habilidad` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cod_piloto` bigint(20) UNSIGNED NOT NULL,
  `atributo` enum('ataque','defensa','resistencia','puntos','creditos') COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `tiempo_duracion` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `habilidades`
--

INSERT INTO `habilidades` (`cod_habilidad`, `nombre`, `descripcion`, `cod_piloto`, `atributo`, `cantidad`, `tiempo_duracion`, `created_at`, `updated_at`) VALUES
(1, 'Orden de ataque', 'Durante 2 turnos el ataque aumenta en 80 puntos.', 1, 'ataque', 80, 2, NULL, NULL),
(2, 'Concentración', 'adada', 2, 'ataque', 80, 2, NULL, NULL),
(3, 'Concentración1', 'adada', 3, 'ataque', 80, 2, NULL, NULL),
(4, 'Concentración2', 'adada', 4, 'ataque', 80, 2, NULL, NULL),
(5, 'Concentración3', 'adada', 5, 'ataque', 80, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_batalla`
--

CREATE TABLE `log_batalla` (
  `cod_log_batalla` bigint(20) UNSIGNED NOT NULL,
  `cod_registro_batalla` bigint(20) UNSIGNED NOT NULL,
  `turno` int(11) NOT NULL,
  `dado` int(11) NOT NULL,
  `efecto` varchar(250) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `resistencia_actual` int(11) NOT NULL,
  `ataque_actual` int(11) NOT NULL,
  `defensa_actual` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `log_batalla`
--

INSERT INTO `log_batalla` (`cod_log_batalla`, `cod_registro_batalla`, `turno`, `dado`, `efecto`, `resistencia_actual`, `ataque_actual`, `defensa_actual`, `estado`) VALUES
(1, 1, 0, 3, 'Comienzo', 5310, 240, 295, 1),
(2, 2, 0, 1, 'Comienzo', 1520, 360, 120, 1),
(3, 1, 1, 5, 'Rival esquiva', 5245, 240, 295, 1),
(4, 2, 1, 4, 'Ataque acertado 65 de daño', 1520, 360, 120, 1),
(5, 1, 2, 2, 'Ataque acertado 120 de daño', 5180, 240, 295, 1),
(6, 2, 2, 4, 'Ataque acertado 65 de daño', 1400, 360, 120, 1),
(7, 1, 3, 4, 'Ataque acertado 120 de daño', 5180, 240, 295, 1),
(8, 2, 3, 5, 'Rival esquiva', 1280, 360, 120, 1),
(9, 1, 4, 4, 'Ataque acertado 120 de daño', 5180, 240, 295, 1),
(10, 2, 4, 1, 'Ataque fallado', 1160, 360, 120, 1),
(11, 1, 5, 5, 'Rival esquiva', 5180, 240, 295, 1),
(12, 2, 5, 3, 'Rival esquiva', 1160, 360, 120, 1),
(13, 1, 6, 4, 'Ataque acertado 120 de daño', 5180, 240, 295, 1),
(14, 2, 6, 1, 'Ataque fallado', 1040, 360, 120, 1),
(15, 1, 7, 1, 'Ataque fallado', 5180, 240, 295, 1),
(16, 2, 7, 3, 'Rival esquiva', 1040, 360, 120, 1),
(17, 1, 8, 4, 'Ataque acertado 120 de daño', 5180, 240, 295, 1),
(18, 2, 8, 5, 'Rival esquiva', 920, 360, 120, 1),
(19, 1, 9, 5, 'Rival esquiva', 5180, 240, 295, 1),
(20, 2, 9, 5, 'Rival esquiva', 920, 360, 120, 1),
(21, 1, 10, 1, 'Ataque fallado', 5180, 240, 295, 1),
(22, 2, 10, 3, 'Rival esquiva', 920, 360, 120, 1),
(23, 1, 11, 4, 'Ataque acertado 120 de daño', 5180, 240, 295, 1),
(24, 2, 11, 6, 'Habilidad activada: Aumento de ataque en 80 pts durante 2 turnos', 800, 360, 120, 1),
(25, 1, 12, 5, 'Rival esquiva', 5180, 240, 295, 1),
(26, 2, 12, 5, 'Rival esquiva', 800, 440, 120, 1),
(27, 1, 13, 1, 'Ataque fallado', 5115, 240, 295, 1),
(28, 2, 13, 4, 'Ataque acertado 65 de daño', 800, 360, 120, 1),
(29, 1, 14, 2, 'Ataque acertado 120 de daño', 5115, 240, 295, 1),
(30, 2, 14, 1, 'Ataque fallado', 680, 360, 120, 1),
(31, 1, 15, 5, 'Rival esquiva', 5115, 240, 295, 1),
(32, 2, 15, 1, 'Ataque fallado', 680, 360, 120, 1),
(33, 1, 16, 5, 'Rival esquiva', 5050, 240, 295, 1),
(34, 2, 16, 4, 'Ataque acertado 65 de daño', 680, 360, 120, 1),
(35, 1, 17, 6, 'Rival esquiva', 5050, 240, 295, 1),
(36, 2, 17, 1, 'Ataque fallado', 680, 360, 120, 1),
(37, 1, 18, 1, 'Ataque fallado', 5050, 240, 295, 1),
(38, 2, 18, 1, 'Ataque fallado', 680, 360, 120, 1),
(39, 1, 19, 6, 'Ataque fallado', 5050, 240, 295, 1),
(40, 2, 19, 1, 'Ataque fallado', 680, 360, 120, 1),
(41, 1, 20, 3, 'Rival esquiva', 4985, 240, 295, 1),
(42, 2, 20, 2, 'Ataque acertado 65 de daño', 680, 360, 120, 1),
(43, 1, 21, 1, 'Ataque fallado', 4985, 240, 295, 1),
(44, 2, 21, 6, 'Habilidad activada: Aumento de ataque en 80 pts durante 2 turnos', 680, 360, 120, 1),
(45, 1, 22, 3, 'Rival esquiva', 4985, 240, 295, 1),
(46, 2, 22, 6, 'Habilidad activada: Aumento de ataque en 80 pts durante 2 turnos', 680, 440, 120, 1),
(47, 1, 23, 6, 'Rival esquiva', 4920, 240, 295, 1),
(48, 2, 23, 2, 'Ataque acertado 65 de daño', 680, 360, 120, 1),
(49, 1, 24, 2, 'Ataque acertado 120 de daño', 4920, 240, 295, 1),
(50, 2, 24, 3, 'Rival esquiva', 560, 360, 120, 1),
(51, 1, 25, 6, 'Ataque acertado 120 de daño', 4920, 240, 295, 1),
(52, 2, 25, 5, 'Rival esquiva', 560, 360, 120, 1),
(53, 1, 26, 5, 'Rival esquiva', 4920, 240, 295, 1),
(54, 2, 26, 1, 'Ataque fallado', 560, 360, 120, 1),
(55, 1, 27, 6, 'Rival esquiva', 4920, 240, 295, 1),
(56, 2, 27, 5, 'Rival esquiva', 560, 360, 120, 1),
(57, 1, 28, 4, 'Ataque acertado 120 de daño', 4855, 240, 295, 1),
(58, 2, 28, 2, 'Ataque acertado 65 de daño', 440, 360, 120, 1),
(59, 1, 29, 1, 'Ataque fallado', 4790, 240, 295, 1),
(60, 2, 29, 4, 'Ataque acertado 65 de daño', 440, 360, 120, 1),
(61, 1, 30, 2, 'Ataque acertado 120 de daño', 4790, 240, 295, 1),
(62, 2, 30, 1, 'Ataque fallado', 320, 360, 120, 1),
(63, 1, 31, 3, 'Rival esquiva', 4790, 240, 295, 1),
(64, 2, 31, 5, 'Rival esquiva', 320, 360, 120, 1),
(65, 1, 32, 3, 'Rival esquiva', 4790, 240, 295, 1),
(66, 2, 32, 3, 'Rival esquiva', 320, 360, 120, 1),
(67, 1, 33, 2, 'Ataque acertado 120 de daño', 4790, 240, 295, 1),
(68, 2, 33, 1, 'Ataque fallado', 200, 360, 120, 1),
(69, 1, 34, 3, 'Rival esquiva', 4725, 240, 295, 1),
(70, 2, 34, 2, 'Ataque acertado 65 de daño', 200, 360, 120, 1),
(71, 1, 35, 4, 'Ataque acertado 120 de daño', 4660, 240, 295, 1),
(72, 2, 35, 2, 'Ataque acertado 65 de daño', 80, 360, 120, 1),
(73, 1, 36, 1, 'Ataque fallado', 4595, 240, 295, 1),
(74, 2, 36, 4, 'Ataque acertado 65 de daño', 80, 360, 120, 1),
(75, 1, 37, 5, 'Rival esquiva', 4595, 240, 295, 1),
(76, 2, 37, 6, 'Habilidad activada: Aumento de ataque en 80 pts durante 2 turnos', 80, 360, 120, 1),
(77, 1, 38, 4, 'Ataque acertado 120 de daño', 4595, 240, 295, 0),
(78, 2, 38, 3, 'Rival esquiva', 0, 440, 120, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(196, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(197, '2019_08_19_000000_create_failed_jobs_table', 1),
(198, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(199, '2023_04_05_234053_create_acl_roles_create', 1),
(200, '2023_04_05_234110_create_acl_usuarios_table', 1),
(201, '2023_04_06_102551_create_naves_table', 1),
(202, '2023_04_06_103115_create_usuarios_table', 1),
(203, '2023_04_06_104447_create_habilidades_table', 1),
(204, '2023_04_06_105232_create_pilotos_table', 1),
(205, '2023_04_06_105907_create_accesorios_table', 1),
(206, '2023_04_08_104031_create_usuarios_accesorios_table', 1),
(207, '2023_04_08_104413_create_usuarios_pilotos_table', 1),
(208, '2023_04_08_105321_create_usuarios_naves_table', 1),
(209, '2023_04_15_154842_create_batalla_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `naves`
--

CREATE TABLE `naves` (
  `cod_nave` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ataque` int(11) NOT NULL,
  `aumento_ataque` int(11) DEFAULT NULL,
  `defensa` int(11) NOT NULL,
  `aumento_defensa` int(11) DEFAULT NULL,
  `resistencia` int(11) NOT NULL,
  `aumento_resistencia` int(11) NOT NULL,
  `num_accesorios` int(11) NOT NULL DEFAULT 2,
  `valor` int(11) NOT NULL,
  `coste_nivel` int(11) NOT NULL,
  `imagen` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `naves`
--

INSERT INTO `naves` (`cod_nave`, `nombre`, `ataque`, `aumento_ataque`, `defensa`, `aumento_defensa`, `resistencia`, `aumento_resistencia`, `num_accesorios`, `valor`, `coste_nivel`, `imagen`, `created_at`, `updated_at`) VALUES
(1, 'Caza estelar T-65 Ala-X', 100, 20, 60, 10, 1000, 200, 2, 10000, 2500, 'imgBD\\naves\\X-Wing-Starfighter.png', NULL, NULL),
(2, 'Caza estelar TIE', 100, 15, 50, 10, 1000, 200, 2, 10000, 2000, 'imgBD\\naves\\cazaTie.png', NULL, NULL),
(3, 'T-70 X-Wing', 120, 20, 80, 10, 1200, 200, 2, 15000, 5000, 'imgBD\\naves\\T-70 X-Wing.png', NULL, NULL),
(4, 'Z-95-AF4 Headhunter', 150, 15, 50, 15, 1300, 200, 2, 20000, 5000, 'imgBD\\naves\\Z-95-AF4 Headhunter.png', NULL, NULL),
(5, 'TIE Reaper', 200, 20, 60, 10, 1500, 200, 2, 25000, 10000, 'imgBD\\naves\\TIE-Reaper.png', NULL, NULL),
(6, 'TIE Bomber', 300, 15, 50, 10, 900, 200, 2, 11000, 3000, 'imgBD\\naves\\TIEBomber.png', NULL, NULL),
(7, 'Attack Shuttle', 150, 30, 100, 30, 1700, 200, 2, 18000, 5000, 'imgBD\\naves\\Attack Shuttle.png', NULL, NULL),
(8, 'Millennium Falcon', 200, 20, 100, 15, 1500, 250, 4, 30000, 5000, 'imgBD\\naves\\Millennium_Falcon.png', NULL, NULL),
(9, 'TIE Advanced', 200, 20, 70, 15, 1200, 200, 3, 13000, 5000, 'imgBD\\naves\\TIE Advanced.png', NULL, NULL),
(10, 'Destructor Imperial', 0, 0, 100, 20, 5000, 200, 8, 100000, 50000, 'imgBD\\naves\\destructor.png\r\n', NULL, NULL),
(11, 'Btl-a4 Starfighter', 90, 20, 40, 5, 1500, 100, 2, 12000, 6000, 'imgBD\\naves\\btl-a4_starfighter.png', NULL, NULL),
(12, 'Firespray Gunship', 250, 50, 100, 20, 2500, 100, 4, 50000, 25000, 'imgBD\\naves\\Firespray_Gunship.png', NULL, NULL),
(13, 'Interceptor Clase Actis', 150, 10, 75, 30, 1500, 250, 3, 35000, 17500, 'imgBD\\naves\\Interceptor_eta_2_clase_Actis.png', NULL, NULL),
(14, 'Nantex clase Starfighter', 120, 30, 0, 0, 1200, 100, 1, 10000, 5000, 'imgBD\\naves\\Nantex-class_Starfighter.png', NULL, NULL),
(15, 'RZ-2 A-Wing', 100, 20, 100, 20, 1500, 200, 2, 20000, 5000, 'imgBD\\naves\\RZ-2_A-Wing.png', NULL, NULL),
(16, 'TIE Phantom', 300, 20, 0, 0, 2000, 100, 4, 30000, 5000, 'imgBD\\naves\\TIE_Phantom.png', NULL, NULL),
(17, 'Gauntlet Fighter', 50, 0, 200, 50, 2500, 250, 4, 60000, 10000, 'imgBD\\naves\\Gauntlet_Fighter.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pilotos`
--

CREATE TABLE `pilotos` (
  `cod_piloto` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ataque` int(11) NOT NULL,
  `aumento_ataque` int(11) NOT NULL,
  `defensa` int(11) NOT NULL,
  `aumento_defensa` int(11) NOT NULL,
  `resistencia` int(11) NOT NULL,
  `aumento_resistencia` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `coste_nivel` int(11) NOT NULL,
  `imagen` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pilotos`
--

INSERT INTO `pilotos` (`cod_piloto`, `nombre`, `ataque`, `aumento_ataque`, `defensa`, `aumento_defensa`, `resistencia`, `aumento_resistencia`, `valor`, `coste_nivel`, `imagen`, `created_at`, `updated_at`) VALUES
(1, 'Piloto TIE', 50, 5, 20, 5, 100, 10, 2000, 1000, 'imgBD\\pilotos\\TIE_Pilot.png', NULL, NULL),
(2, 'Han Solo', 70, 5, 20, 5, 20, 10, 2000, 1000, 'imgBD\\pilotos\\han_solo.png', NULL, NULL),
(3, 'Piloto Rebelde', 90, 5, 10, 5, 60, 10, 2000, 1000, 'imgBD\\pilotos\\Character-Biggs_Darklighter.png', NULL, NULL),
(4, 'Sabine Wren', 70, 5, 10, 5, 90, 10, 2000, 1000, 'imgBD\\pilotos\\Sabine_Wren.png', NULL, NULL),
(5, '\"Zeb\" Orrelios', 40, 5, 20, 5, 60, 10, 2000, 1000, 'imgBD\\pilotos\\zeb.png', NULL, NULL),
(6, 'Darth Vader', 80, 10, 25, 10, 70, 10, 4000, 1000, 'imgBD\\pilotos\\darth_vader.png', NULL, NULL),
(7, 'Obi-Wan Kenobi', 60, 5, 20, 10, 60, 10, 2500, 1000, 'imgBD\\pilotos\\obi_wan.png', NULL, '2023-06-16 11:13:22'),
(21, 'Anakin Skywalker', 120, 10, 30, 10, 90, 5, 3000, 1000, 'imgBD/pilotos/anakin.png', NULL, NULL),
(22, 'Boba Fett', 150, 10, 10, 5, 90, 10, 5000, 2000, 'imgBD/pilotos/boba_fett.png', NULL, NULL),
(23, 'Chewbacca', 50, 10, 60, 10, 200, 20, 5000, 200, 'imgBD/pilotos/Chewbacca.png', NULL, NULL),
(24, 'Inquisidor', 50, 10, 50, 10, 100, 10, 3000, 1000, 'imgBD/pilotos/inquisidor.png', NULL, NULL),
(25, 'Luke Skywalker', 70, 10, 50, 10, 100, 20, 4000, 2000, 'imgBD/pilotos/luke.png', NULL, NULL),
(26, 'Palpatine', 250, 20, 10, 0, 10, 0, 10000, 5000, 'imgBD/pilotos/palpatine.png', NULL, NULL),
(27, 'Kylo Ren', 100, 10, 50, 10, 150, 20, 8000, 4000, 'imgBD/pilotos/kylo.png', NULL, NULL),
(28, 'Rey', 100, 10, 50, 10, 150, 20, 8000, 4000, 'imgBD/pilotos/rey.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_batalla`
--

CREATE TABLE `registro_batalla` (
  `cod_registro_batalla` bigint(20) UNSIGNED NOT NULL,
  `cod_usuario` bigint(20) UNSIGNED NOT NULL,
  `cod_batalla` bigint(20) UNSIGNED NOT NULL,
  `cod_usuario_nave` bigint(20) UNSIGNED NOT NULL,
  `cod_usuario_piloto` bigint(20) UNSIGNED NOT NULL,
  `turno_actual` int(11) NOT NULL,
  `vista_completa` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `registro_batalla`
--

INSERT INTO `registro_batalla` (`cod_registro_batalla`, `cod_usuario`, `cod_batalla`, `cod_usuario_nave`, `cod_usuario_piloto`, `turno_actual`, `vista_completa`) VALUES
(1, 11, 1, 29, 32, 0, 1),
(2, 37, 1, 28, 35, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cod_usuario` bigint(20) UNSIGNED NOT NULL,
  `nick` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creditos` bigint(20) NOT NULL DEFAULT 50000,
  `victorias` int(11) NOT NULL DEFAULT 0,
  `derrotas` int(11) NOT NULL DEFAULT 0,
  `puntos` int(11) NOT NULL DEFAULT 0,
  `cod_division` bigint(20) UNSIGNED NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cod_usuario`, `nick`, `fecha_nacimiento`, `email`, `creditos`, `victorias`, `derrotas`, `puntos`, `cod_division`, `avatar`, `borrado`, `created_at`, `updated_at`) VALUES
(11, 'Lubba', '1995-07-21', 'espectroBro2122@gmail.com', 119869800, 74, 46, 800, 1, 'imgBD/usuarios/11.png', 0, NULL, '2023-06-19 12:36:44'),
(37, 'Prueba25', '1995-02-02', 'prueba25@gmail.com', 9000, 4, 2, 350, 1, 'imgBD/usuarios/default.png', 0, '2023-06-14 08:15:47', '2023-06-19 12:36:44'),
(40, 'Jarvis', '1995-06-15', 'jarvis@gmail.com', 0, 0, 0, 0, 1, '/imgBD/usuarios/default.png', 0, '2023-06-15 13:23:53', '2023-06-15 13:23:53'),
(41, 'Xopyes', '2000-07-05', 'Xopyes@gmail.com', 40000, 36, 10, 3100, 3, '/imgBD/usuarios/default.png', 0, '2023-06-19 12:55:48', '2023-06-19 13:27:18'),
(42, 'Tahuna', '2001-12-09', 'Tahuna@gmail.com', 0, 5, 0, 500, 1, '/imgBD/usuarios/default.png', 0, '2023-06-19 12:56:32', '2023-06-19 12:56:32'),
(43, 'Riufil', '1998-04-07', 'Riufil@gmail.com', 0, 0, 0, 0, 1, '/imgBD/usuarios/default.png', 0, '2023-06-19 12:58:14', '2023-06-19 12:58:14'),
(44, 'Lunixe', '1993-04-01', 'Lunixe@gmail.com', 0, 20, 5, 2500, 2, '/imgBD/usuarios/Lunixe.jpg', 0, '2023-06-19 12:59:47', '2023-06-19 12:59:47'),
(45, 'Zenake', '1995-02-04', 'Zenake@gmail.com', 0, 0, 0, 0, 1, 'imgBD/usuarios/45.jpg', 0, '2023-06-19 13:06:37', '2023-06-19 13:07:15'),
(46, 'Xudemi', '2001-07-31', 'Xudemi@gmail.com', 15000, 15, 0, 1500, 2, 'imgBD/usuarios/default.png', 0, '2023-06-19 13:08:09', '2023-06-19 13:27:51'),
(47, 'Arkeur', '1999-02-05', 'Arkeur@gmail.com', 0, 0, 0, 0, 1, 'imgBD/usuarios/Arkeur.jpg', 0, '2023-06-19 13:12:55', '2023-06-19 13:12:55'),
(48, 'Giruse', '1985-02-21', 'Giruse@gmail.com', 15000, 12, 0, 1200, 2, 'imgBD/usuarios/default.png', 0, '2023-06-19 13:15:16', '2023-06-19 13:31:03'),
(49, 'Bopide', '2000-05-21', 'Bopide@gmail.com', 0, 0, 0, 0, 1, 'imgBD/usuarios/default.png', 0, '2023-06-19 13:18:04', '2023-06-19 13:18:04'),
(50, 'casamorada', '1995-07-21', 'casamorada@gmail.com', 100000, 80, 0, 8000, 6, 'imgBD/usuarios/default.png', 0, '2023-06-19 13:19:43', '2023-06-19 13:20:25'),
(51, 'Nuamua', '2001-01-04', 'Nuamua@gmail.com', 0, 0, 0, 0, 1, 'imgBD/usuarios/default.png', 0, '2023-06-19 13:21:14', '2023-06-19 13:21:14'),
(52, 'Gacilu', '1998-02-06', 'Gacilu@gmail.com', 3000, 3, 1, 250, 1, 'imgBD/usuarios/default.png', 0, '2023-06-19 13:29:44', '2023-06-19 13:29:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_accesorios`
--

CREATE TABLE `usuarios_accesorios` (
  `cod_usuario_accesorio` bigint(20) UNSIGNED NOT NULL,
  `cod_usuario` bigint(20) UNSIGNED NOT NULL,
  `cod_accesorio` bigint(20) UNSIGNED NOT NULL,
  `ataque_actual` int(11) DEFAULT NULL,
  `defensa_actual` int(11) DEFAULT NULL,
  `resistencia_actual` int(11) DEFAULT NULL,
  `nivel` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios_accesorios`
--

INSERT INTO `usuarios_accesorios` (`cod_usuario_accesorio`, `cod_usuario`, `cod_accesorio`, `ataque_actual`, `defensa_actual`, `resistencia_actual`, `nivel`, `created_at`, `updated_at`) VALUES
(5, 11, 4, 50, NULL, NULL, 1, NULL, NULL),
(6, 11, 5, NULL, 100, 200, 1, NULL, NULL),
(7, 11, 3, 50, NULL, NULL, 1, NULL, NULL),
(22, 40, 3, 50, NULL, NULL, 1, '2023-05-29 16:01:02', '2023-05-29 16:01:02'),
(23, 40, 4, 50, NULL, NULL, 1, '2023-05-29 16:01:02', '2023-05-29 16:01:02'),
(24, 37, 3, 50, NULL, NULL, 1, '2023-06-14 08:15:47', '2023-06-14 08:15:47'),
(25, 37, 4, 50, NULL, NULL, 1, '2023-06-14 08:15:47', '2023-06-14 08:15:47'),
(26, 11, 6, NULL, 75, 50, 1, '2023-06-16 17:28:59', '2023-06-16 17:28:59'),
(27, 11, 8, 80, NULL, NULL, 1, '2023-06-19 09:36:43', '2023-06-19 09:36:43'),
(28, 41, 3, 50, NULL, NULL, 1, '2023-06-19 12:55:48', '2023-06-19 12:55:48'),
(29, 41, 4, 50, NULL, NULL, 1, '2023-06-19 12:55:48', '2023-06-19 12:55:48'),
(30, 42, 3, 50, NULL, NULL, 1, '2023-06-19 12:56:32', '2023-06-19 12:56:32'),
(31, 42, 4, 50, NULL, NULL, 1, '2023-06-19 12:56:32', '2023-06-19 12:56:32'),
(32, 43, 3, 50, NULL, NULL, 1, '2023-06-19 12:58:14', '2023-06-19 12:58:14'),
(33, 43, 4, 50, NULL, NULL, 1, '2023-06-19 12:58:14', '2023-06-19 12:58:14'),
(34, 44, 3, 50, NULL, NULL, 1, '2023-06-19 12:59:47', '2023-06-19 12:59:47'),
(35, 44, 4, 50, NULL, NULL, 1, '2023-06-19 12:59:47', '2023-06-19 12:59:47'),
(36, 45, 3, 50, NULL, NULL, 1, '2023-06-19 13:06:37', '2023-06-19 13:06:37'),
(37, 45, 4, 50, NULL, NULL, 1, '2023-06-19 13:06:37', '2023-06-19 13:06:37'),
(38, 46, 3, 50, NULL, NULL, 1, '2023-06-19 13:08:09', '2023-06-19 13:08:09'),
(39, 46, 4, 50, NULL, NULL, 1, '2023-06-19 13:08:09', '2023-06-19 13:08:09'),
(40, 47, 3, 50, NULL, NULL, 1, '2023-06-19 13:12:55', '2023-06-19 13:12:55'),
(41, 47, 4, 50, NULL, NULL, 1, '2023-06-19 13:12:55', '2023-06-19 13:12:55'),
(42, 48, 3, 50, NULL, NULL, 1, '2023-06-19 13:15:16', '2023-06-19 13:15:16'),
(43, 48, 4, 50, NULL, NULL, 1, '2023-06-19 13:15:16', '2023-06-19 13:15:16'),
(44, 49, 3, 50, NULL, NULL, 1, '2023-06-19 13:18:04', '2023-06-19 13:18:04'),
(45, 49, 4, 50, NULL, NULL, 1, '2023-06-19 13:18:04', '2023-06-19 13:18:04'),
(46, 50, 3, 50, NULL, NULL, 1, '2023-06-19 13:19:43', '2023-06-19 13:19:43'),
(47, 50, 4, 50, NULL, NULL, 1, '2023-06-19 13:19:43', '2023-06-19 13:19:43'),
(48, 51, 3, 50, NULL, NULL, 1, '2023-06-19 13:21:14', '2023-06-19 13:21:14'),
(49, 51, 4, 50, NULL, NULL, 1, '2023-06-19 13:21:14', '2023-06-19 13:21:14'),
(50, 52, 3, 50, NULL, NULL, 1, '2023-06-19 13:29:44', '2023-06-19 13:29:44'),
(51, 52, 4, 50, NULL, NULL, 1, '2023-06-19 13:29:44', '2023-06-19 13:29:44'),
(58, 44, 12, 250, NULL, NULL, 1, NULL, NULL),
(59, 42, 8, 80, NULL, NULL, 1, NULL, NULL),
(60, 50, 11, NULL, 150, NULL, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_naves`
--

CREATE TABLE `usuarios_naves` (
  `cod_usuario_nave` bigint(20) UNSIGNED NOT NULL,
  `cod_usuario` bigint(20) UNSIGNED NOT NULL,
  `cod_nave` bigint(20) UNSIGNED NOT NULL,
  `ataque_actual` int(11) DEFAULT NULL,
  `defensa_actual` int(11) DEFAULT NULL,
  `resistencia_actual` int(11) DEFAULT NULL,
  `nivel` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios_naves`
--

INSERT INTO `usuarios_naves` (`cod_usuario_nave`, `cod_usuario`, `cod_nave`, `ataque_actual`, `defensa_actual`, `resistencia_actual`, `nivel`, `created_at`, `updated_at`) VALUES
(21, 40, 1, 150, 60, 1000, 1, '2023-05-29 16:01:02', '2023-05-29 16:01:02'),
(22, 11, 4, 165, 60, 1200, 2, '2023-06-01 12:45:16', '2023-06-08 05:54:48'),
(23, 11, 7, 190, 80, 1400, 3, '2023-06-01 12:47:25', '2023-06-15 22:14:01'),
(24, 11, 6, 150, 50, 1000, 1, '2023-06-01 12:52:20', '2023-06-01 12:52:20'),
(25, 37, 1, 170, 70, 1200, 2, '2023-06-14 08:15:47', '2023-06-17 16:28:08'),
(27, 37, 2, 150, 50, 1000, 1, '2023-06-17 13:52:19', '2023-06-17 13:52:19'),
(28, 37, 8, 200, 100, 1500, 1, '2023-06-17 13:55:10', '2023-06-17 13:55:10'),
(29, 11, 10, 0, 100, 5000, 1, '2023-06-19 12:14:00', '2023-06-19 12:14:00'),
(30, 41, 1, 100, 60, 1000, 1, '2023-06-19 12:55:48', '2023-06-19 12:55:48'),
(31, 42, 1, 100, 60, 1000, 1, '2023-06-19 12:56:32', '2023-06-19 12:56:32'),
(32, 43, 1, 100, 60, 1000, 1, '2023-06-19 12:58:14', '2023-06-19 12:58:14'),
(33, 44, 1, 100, 60, 1000, 1, '2023-06-19 12:59:47', '2023-06-19 12:59:47'),
(34, 45, 1, 100, 60, 1000, 1, '2023-06-19 13:06:37', '2023-06-19 13:06:37'),
(35, 46, 1, 100, 60, 1000, 1, '2023-06-19 13:08:09', '2023-06-19 13:08:09'),
(36, 47, 1, 100, 60, 1000, 1, '2023-06-19 13:12:55', '2023-06-19 13:12:55'),
(37, 48, 1, 100, 60, 1000, 1, '2023-06-19 13:15:16', '2023-06-19 13:15:16'),
(38, 49, 1, 100, 60, 1000, 1, '2023-06-19 13:18:04', '2023-06-19 13:18:04'),
(39, 50, 1, 100, 60, 1000, 1, '2023-06-19 13:19:43', '2023-06-19 13:19:43'),
(40, 51, 1, 100, 60, 1000, 1, '2023-06-19 13:21:14', '2023-06-19 13:21:14'),
(41, 52, 1, 100, 60, 1000, 1, '2023-06-19 13:29:44', '2023-06-19 13:29:44'),
(42, 50, 10, NULL, 100, 5000, 1, NULL, NULL),
(43, 51, 16, 300, NULL, 2000, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_pilotos`
--

CREATE TABLE `usuarios_pilotos` (
  `cod_usuario_piloto` bigint(20) UNSIGNED NOT NULL,
  `cod_usuario` bigint(20) UNSIGNED NOT NULL,
  `cod_piloto` bigint(20) UNSIGNED NOT NULL,
  `ataque_actual` int(11) NOT NULL,
  `defensa_actual` int(11) NOT NULL,
  `resistencia_actual` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios_pilotos`
--

INSERT INTO `usuarios_pilotos` (`cod_usuario_piloto`, `cod_usuario`, `cod_piloto`, `ataque_actual`, `defensa_actual`, `resistencia_actual`, `nivel`, `created_at`, `updated_at`) VALUES
(19, 11, 2, 65, 25, 30, 6, '2023-05-28 09:15:48', '2023-06-08 07:12:48'),
(25, 11, 3, 90, 10, 60, 1, '2023-05-28 09:41:10', '2023-05-28 09:41:10'),
(26, 11, 4, 70, 10, 90, 1, '2023-05-28 09:41:35', '2023-05-28 09:41:35'),
(30, 40, 2, 60, 20, 20, 1, '2023-05-29 16:01:02', '2023-05-29 16:01:02'),
(31, 11, 5, 30, 20, 60, 1, '2023-06-01 12:48:20', '2023-06-01 12:48:20'),
(32, 11, 6, 60, 20, 60, 1, '2023-06-01 12:51:33', '2023-06-01 12:51:33'),
(33, 11, 7, 60, 20, 60, 1, '2023-06-01 13:03:32', '2023-06-01 13:03:32'),
(34, 11, 1, 55, 25, 110, 2, '2023-06-08 12:07:19', '2023-06-10 09:59:07'),
(35, 37, 2, 60, 20, 20, 1, '2023-06-14 08:15:47', '2023-06-14 08:15:47'),
(37, 41, 2, 70, 20, 20, 1, '2023-06-19 12:55:48', '2023-06-19 12:55:48'),
(38, 42, 2, 70, 20, 20, 1, '2023-06-19 12:56:32', '2023-06-19 12:56:32'),
(39, 43, 2, 70, 20, 20, 1, '2023-06-19 12:58:14', '2023-06-19 12:58:14'),
(40, 44, 2, 70, 20, 20, 1, '2023-06-19 12:59:47', '2023-06-19 12:59:47'),
(41, 45, 2, 70, 20, 20, 1, '2023-06-19 13:06:37', '2023-06-19 13:06:37'),
(42, 46, 2, 70, 20, 20, 1, '2023-06-19 13:08:09', '2023-06-19 13:08:09'),
(43, 47, 2, 70, 20, 20, 1, '2023-06-19 13:12:55', '2023-06-19 13:12:55'),
(44, 48, 2, 70, 20, 20, 1, '2023-06-19 13:15:16', '2023-06-19 13:15:16'),
(45, 49, 2, 70, 20, 20, 1, '2023-06-19 13:18:04', '2023-06-19 13:18:04'),
(46, 50, 2, 70, 20, 20, 1, '2023-06-19 13:19:43', '2023-06-19 13:19:43'),
(47, 51, 2, 70, 20, 20, 1, '2023-06-19 13:21:14', '2023-06-19 13:21:14'),
(48, 52, 2, 70, 20, 20, 1, '2023-06-19 13:29:44', '2023-06-19 13:29:44');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesorios`
--
ALTER TABLE `accesorios`
  ADD PRIMARY KEY (`cod_accesorio`),
  ADD UNIQUE KEY `accesorios_nombre_unique` (`nombre`);

--
-- Indices de la tabla `accesorio_registro_batalla`
--
ALTER TABLE `accesorio_registro_batalla`
  ADD PRIMARY KEY (`cod_accesorio_registro_batalla`),
  ADD KEY `fk_cod_registro_batalla` (`cod_registro_batalla`),
  ADD KEY `fk_cod_accesorio_usuario` (`cod_usuario_accesorio`);

--
-- Indices de la tabla `acl_roles`
--
ALTER TABLE `acl_roles`
  ADD PRIMARY KEY (`cod_acl_role`),
  ADD UNIQUE KEY `acl_roles_nombre_unique` (`nombre`);

--
-- Indices de la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  ADD PRIMARY KEY (`cod_acl_usuario`),
  ADD UNIQUE KEY `acl_usuarios_nick_unique` (`nick`),
  ADD UNIQUE KEY `acl_usuarios_email_unique` (`email`),
  ADD KEY `acl_usuarios_cod_acl_role_foreign` (`cod_acl_role`);

--
-- Indices de la tabla `batalla`
--
ALTER TABLE `batalla`
  ADD PRIMARY KEY (`cod_batalla`),
  ADD KEY `fk_cod_usuario_ganador` (`usuario_ganador`);

--
-- Indices de la tabla `divisiones`
--
ALTER TABLE `divisiones`
  ADD PRIMARY KEY (`cod_division`),
  ADD UNIQUE KEY `uq_Diviones` (`nombre`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `habilidades`
--
ALTER TABLE `habilidades`
  ADD PRIMARY KEY (`cod_habilidad`),
  ADD UNIQUE KEY `habilidades_nombre_unique` (`nombre`),
  ADD UNIQUE KEY `cod_habilidad_cod_piloto` (`cod_habilidad`,`cod_piloto`),
  ADD KEY `fk_cod_piloto` (`cod_piloto`);

--
-- Indices de la tabla `log_batalla`
--
ALTER TABLE `log_batalla`
  ADD PRIMARY KEY (`cod_log_batalla`),
  ADD KEY `Fk_cod_reg_batalla` (`cod_registro_batalla`) USING BTREE;

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `naves`
--
ALTER TABLE `naves`
  ADD PRIMARY KEY (`cod_nave`),
  ADD UNIQUE KEY `naves_nombre_unique` (`nombre`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `pilotos`
--
ALTER TABLE `pilotos`
  ADD PRIMARY KEY (`cod_piloto`),
  ADD UNIQUE KEY `pilotos_nombre_unique` (`nombre`);

--
-- Indices de la tabla `registro_batalla`
--
ALTER TABLE `registro_batalla`
  ADD PRIMARY KEY (`cod_registro_batalla`),
  ADD KEY `fk_cod_usuarios_naves` (`cod_usuario_nave`),
  ADD KEY `fk_cod_usuario_piloto` (`cod_usuario_piloto`),
  ADD KEY `fk_batalla` (`cod_batalla`),
  ADD KEY `fk_usuarios` (`cod_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cod_usuario`),
  ADD UNIQUE KEY `usuarios_nick_unique` (`nick`),
  ADD UNIQUE KEY `usuarios_email_unique` (`email`),
  ADD KEY `fk_cod_division` (`cod_division`);

--
-- Indices de la tabla `usuarios_accesorios`
--
ALTER TABLE `usuarios_accesorios`
  ADD PRIMARY KEY (`cod_usuario_accesorio`),
  ADD UNIQUE KEY `cod_accesorios_cod_usuario` (`cod_usuario`,`cod_accesorio`),
  ADD KEY `usuarios_accesorios_cod_accesorio_foreign` (`cod_accesorio`);

--
-- Indices de la tabla `usuarios_naves`
--
ALTER TABLE `usuarios_naves`
  ADD PRIMARY KEY (`cod_usuario_nave`),
  ADD UNIQUE KEY `cod_nave_cod_usuario` (`cod_usuario`,`cod_nave`),
  ADD KEY `usuarios_naves_cod_nave_foreign` (`cod_nave`);

--
-- Indices de la tabla `usuarios_pilotos`
--
ALTER TABLE `usuarios_pilotos`
  ADD PRIMARY KEY (`cod_usuario_piloto`),
  ADD UNIQUE KEY `cod_piloto_cod_usuario` (`cod_usuario`,`cod_piloto`),
  ADD KEY `usuarios_pilotos_cod_piloto_foreign` (`cod_piloto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesorios`
--
ALTER TABLE `accesorios`
  MODIFY `cod_accesorio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `accesorio_registro_batalla`
--
ALTER TABLE `accesorio_registro_batalla`
  MODIFY `cod_accesorio_registro_batalla` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `acl_roles`
--
ALTER TABLE `acl_roles`
  MODIFY `cod_acl_role` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  MODIFY `cod_acl_usuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `batalla`
--
ALTER TABLE `batalla`
  MODIFY `cod_batalla` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `divisiones`
--
ALTER TABLE `divisiones`
  MODIFY `cod_division` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habilidades`
--
ALTER TABLE `habilidades`
  MODIFY `cod_habilidad` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `log_batalla`
--
ALTER TABLE `log_batalla`
  MODIFY `cod_log_batalla` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT de la tabla `naves`
--
ALTER TABLE `naves`
  MODIFY `cod_nave` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pilotos`
--
ALTER TABLE `pilotos`
  MODIFY `cod_piloto` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `registro_batalla`
--
ALTER TABLE `registro_batalla`
  MODIFY `cod_registro_batalla` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `cod_usuario` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `usuarios_accesorios`
--
ALTER TABLE `usuarios_accesorios`
  MODIFY `cod_usuario_accesorio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `usuarios_naves`
--
ALTER TABLE `usuarios_naves`
  MODIFY `cod_usuario_nave` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `usuarios_pilotos`
--
ALTER TABLE `usuarios_pilotos`
  MODIFY `cod_usuario_piloto` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesorio_registro_batalla`
--
ALTER TABLE `accesorio_registro_batalla`
  ADD CONSTRAINT `fk_cod_accesorio_usuario` FOREIGN KEY (`cod_usuario_accesorio`) REFERENCES `usuarios_accesorios` (`cod_usuario_accesorio`),
  ADD CONSTRAINT `fk_cod_registro_batalla` FOREIGN KEY (`cod_registro_batalla`) REFERENCES `registro_batalla` (`cod_registro_batalla`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  ADD CONSTRAINT `acl_usuarios_cod_acl_role_foreign` FOREIGN KEY (`cod_acl_role`) REFERENCES `acl_roles` (`cod_acl_role`);

--
-- Filtros para la tabla `habilidades`
--
ALTER TABLE `habilidades`
  ADD CONSTRAINT `habilidades_ibfk_1` FOREIGN KEY (`cod_piloto`) REFERENCES `pilotos` (`cod_piloto`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`cod_division`) REFERENCES `divisiones` (`cod_division`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_accesorios`
--
ALTER TABLE `usuarios_accesorios`
  ADD CONSTRAINT `usuarios_accesorios_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_accesorios_ibfk_2` FOREIGN KEY (`cod_accesorio`) REFERENCES `accesorios` (`cod_accesorio`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_naves`
--
ALTER TABLE `usuarios_naves`
  ADD CONSTRAINT `usuarios_naves_ibfk_1` FOREIGN KEY (`cod_nave`) REFERENCES `naves` (`cod_nave`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_naves_ibfk_2` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_pilotos`
--
ALTER TABLE `usuarios_pilotos`
  ADD CONSTRAINT `usuarios_pilotos_ibfk_1` FOREIGN KEY (`cod_piloto`) REFERENCES `pilotos` (`cod_piloto`),
  ADD CONSTRAINT `usuarios_pilotos_ibfk_2` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
