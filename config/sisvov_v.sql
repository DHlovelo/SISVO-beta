-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2026 a las 13:38:20
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sisvo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `becas`
--

CREATE TABLE `becas` (
  `id` int(11) NOT NULL,
  `CI_usu` varchar(10) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `requisitos` text NOT NULL,
  `fecha_cierre` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `becas`
--

INSERT INTO `becas` (`id`, `CI_usu`, `titulo`, `descripcion`, `requisitos`, `fecha_cierre`, `created_at`) VALUES
(1, 'INS17169', 'beca suerte', 'para pros', 'suerte', '0027-02-20', '2026-11-15 22:21:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id_carrera` int(11) NOT NULL,
  `CI_usu` varchar(50) NOT NULL,
  `id_sede` int(11) DEFAULT NULL,
  `nombre_carrera` varchar(150) NOT NULL,
  `nivel` varchar(50) DEFAULT 'Licenciatura',
  `duracion` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id_carrera`, `CI_usu`, `id_sede`, `nombre_carrera`, `nivel`, `duracion`, `descripcion`, `fecha_registro`) VALUES
(1, 'INS17169', 2, 'gastronomia', '', '4 años', 'seras un chefsito', '2026-11-18 08:54:52'),
(2, 'INS17169', 2, 'gastronomia', 'licenciatura', '4 años', 'chefsito', '2026-11-18 08:55:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convocatorias`
--

CREATE TABLE `convocatorias` (
  `id` int(11) NOT NULL,
  `CI_usu` varchar(10) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_cierre` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `convocatorias`
--

INSERT INTO `convocatorias` (`id`, `CI_usu`, `titulo`, `categoria`, `descripcion`, `fecha_cierre`, `created_at`) VALUES
(2, 'INS77404', 'beca suerte', 'Beca', 'A', '2026-12-04', '2026-11-15 18:38:41'),
(3, 'INS77404', 'beca suerte', 'Beca', 'a', '2026-11-02', '2026-11-15 18:40:08'),
(4, 'INS17169', 'ing de sistemas', 'Admision', 'cuesta 20bs', '2026-11-26', '2026-11-15 19:49:12'),
(5, 'INS17169', 'beca suerte', 'Beca', 'd', '2026-11-12', '2026-11-15 21:14:00'),
(6, 'INS17169', 'gatronomia 1-27', 'Admision', 'dinero', '2027-01-01', '2026-11-15 22:20:20'),
(7, 'INS17169', 'hola', 'Admision', 'dfsvfdbdsbdbd', '2026-11-20', '2026-11-15 23:46:06'),
(8, 'INS17169', 'dsadsadsa', 'Admision', 'sdfsdfsdf', '2026-11-06', '2026-11-16 12:31:30'),
(9, 'INS17169', 'beca suerte', 'Admision', 'jjjjj', '2000-03-12', '2026-11-16 16:32:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instituciones`
--

CREATE TABLE `instituciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `CI_usu` varchar(10) DEFAULT NULL,
  `nombre_institucion` varchar(150) NOT NULL,
  `nit` varchar(50) DEFAULT NULL,
  `info_verificacion` text DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `verificado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `instituciones`
--

INSERT INTO `instituciones` (`id`, `CI_usu`, `nombre_institucion`, `nit`, `info_verificacion`, `telefono`, `verificado`) VALUES
(1, 'INS17169', 'UNIFRANZ', '01020233028', '01020233028', NULL, 0),
(2, 'INS77404', 'CBA', '1020531027', '1020531027', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nuevo_usu`
--

CREATE TABLE `nuevo_usu` (
  `CI_usu` varchar(10) NOT NULL,
  `nombre_c_usu` varchar(200) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `rol` enum('admin','institucion','usuario') NOT NULL DEFAULT 'usuario',
  `token_verificacion` char(64) DEFAULT NULL,
  `token_expira` datetime DEFAULT NULL,
  `estado_verificacion` tinyint(1) NOT NULL DEFAULT 0,
  `email_verificado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nuevo_usu`
--

INSERT INTO `nuevo_usu` (`CI_usu`, `nombre_c_usu`, `telefono`, `correo`, `fecha_nacimiento`, `contrasena`, `rol`, `token_verificacion`, `token_expira`, `estado_verificacion`, `email_verificado`) VALUES
('00', 'adriana', '00', 'asalgueirocallisaya@gmail.com', '2026-12-02', '$2y$10$gKNdL6.WQXgFr732QafeZOUsIam9EwjK6qAp7.q7G.fDZwPMnlTc2', 'usuario', NULL, NULL, 0, 1),
('02', 'carlos', '12312', 'car@gmail.com', '2026-11-17', '$2y$10$E8MNa2CQFmEN7NPVZJHVeOcUHW/GiWDjA5RYmCm1p2jNw/bJvsxUq', 'usuario', NULL, NULL, 1, 1),
('1', 'sivox', '0', 'sisvox@gmail.com', '2026-10-26', '$2y$10$3dD5LYPXQWpm4rl0ls40mOMX.aFBFnbrnw.8vA1Vy8BTJ01ckeOaS', 'admin', NULL, NULL, 1, 1),
('1234567', 'pepsi peralez', '12', 'pepsi@gmail.com', '2026-10-28', '$2y$10$oc0a8jNk9LXcUDOlZAzo2uIMCRWwNLDhM22.aevIwlXBmuI/kk4oC', 'usuario', NULL, NULL, 1, 1),
('12863829', 'dante', '62383374', 'est.dantemauricio.carrillo.ba@unifranz.edu.bo', '2026-12-02', '$2y$10$CLFE.2bYZCa5QYFnp7bCe..5b2HdSTZTsqqG.mKjf6NttPnJIqrUa', 'usuario', NULL, NULL, 0, 1),
('44221', 'lola', '76511', 'noeheidi.1@gmail.com', '2000-02-12', '$2y$10$ODea9u6j9WL/eMNr1XdqaOO5EZCmaEH8AWiiMutzuSh1gK4zp5mKK', 'usuario', '18265b4c8a2e0b472ffcff2e35fe48f7e1d26430afa77f08b4700cc2e8bddea2', '2026-11-18 10:25:28', 0, 0),
('INS17169', 'UNIFRANZ', '', 'UNIFRANZ@unifranz.edu.bo', '2026-11-15', '$2y$10$ieNLc6j0qOG9yCHBNBea2.6ziX4Ml1LmUACV1h8R5HHKJ/uEffd.u', 'institucion', NULL, NULL, 1, 1),
('INS77404', 'CBA', '', 'CBA@cba.edu.bo', '2026-11-15', '$2y$10$QdVz8q1j7HObiNwSWCgBNO0oL2pV6VrurAY/yVWHXe9gBxSd.CvxW', 'institucion', NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sedes`
--

CREATE TABLE `sedes` (
  `id_sede` int(11) NOT NULL,
  `CI_usu` varchar(20) NOT NULL,
  `nombre_sede` varchar(120) NOT NULL,
  `ciudad` varchar(80) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono_sede` varchar(30) DEFAULT NULL,
  `url_maps` varchar(500) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sedes`
--

INSERT INTO `sedes` (`id_sede`, `CI_usu`, `nombre_sede`, `ciudad`, `direccion`, `telefono_sede`, `url_maps`, `fecha_registro`) VALUES
(1, 'INS17169', 'UNIFRANZ EA', 'El Alto', 'Av. del Aeropuerto Internacional El Alto, N° 1015, El Alto', '', 'https://maps.app.goo.gl/LuMWZS8vCw7wQjf8A', '2026-11-18 06:50:08'),
(2, 'INS17169', 'UNIFRANZ LP', 'La Paz', ' C. Héroes del Acre, esq N° 1855, La Paz', '', 'https://maps.app.goo.gl/j2eF9TTCo2Y87ynz6', '2026-11-18 07:27:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `becas`
--
ALTER TABLE `becas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_becas_usuario` (`CI_usu`);

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id_carrera`),
  ADD KEY `CI_usu` (`CI_usu`),
  ADD KEY `id_sede` (`id_sede`);

--
-- Indices de la tabla `convocatorias`
--
ALTER TABLE `convocatorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_convocatorias_usuario` (`CI_usu`);

--
-- Indices de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `CI_usu` (`CI_usu`);

--
-- Indices de la tabla `nuevo_usu`
--
ALTER TABLE `nuevo_usu`
  ADD PRIMARY KEY (`CI_usu`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `idx_token_verificacion` (`token_verificacion`);

--
-- Indices de la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD PRIMARY KEY (`id_sede`),
  ADD KEY `CI_usu` (`CI_usu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `becas`
--
ALTER TABLE `becas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id_carrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `convocatorias`
--
ALTER TABLE `convocatorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sedes`
--
ALTER TABLE `sedes`
  MODIFY `id_sede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `becas`
--
ALTER TABLE `becas`
  ADD CONSTRAINT `fk_becas_usuario` FOREIGN KEY (`CI_usu`) REFERENCES `nuevo_usu` (`CI_usu`) ON DELETE CASCADE;

--
-- Filtros para la tabla `convocatorias`
--
ALTER TABLE `convocatorias`
  ADD CONSTRAINT `fk_convocatorias_usuario` FOREIGN KEY (`CI_usu`) REFERENCES `nuevo_usu` (`CI_usu`) ON DELETE CASCADE;

--
-- Filtros para la tabla `instituciones`
--
ALTER TABLE `instituciones`
  ADD CONSTRAINT `fk_instituciones_nuevo_usu` FOREIGN KEY (`CI_usu`) REFERENCES `nuevo_usu` (`CI_usu`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD CONSTRAINT `sedes_ibfk_1` FOREIGN KEY (`CI_usu`) REFERENCES `instituciones` (`CI_usu`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
