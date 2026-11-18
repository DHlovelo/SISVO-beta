-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2026 a las 07:28:33
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id`, `nombre`) VALUES
(1, 'Administración de Empresas'),
(2, 'Administración de Hotelería y Turismo'),
(3, 'Aeronáutica'),
(4, 'Antropología y Arqueología'),
(5, 'Arquitectura'),
(6, 'Artes Musicales'),
(7, 'Artes Plásticas'),
(8, 'Auditoría'),
(9, 'Auditoría Financiera'),
(10, 'Biología'),
(11, 'Bioquímica'),
(12, 'Bioquímica y Farmacia'),
(13, 'Ciencias de la Comunicación Social'),
(14, 'Ciencias de la Educación'),
(15, 'Ciencias de la Información'),
(16, 'Ciencias del Desarrollo'),
(17, 'Ciencias Políticas'),
(18, 'Ciencias Políticas y Gestión Pública'),
(19, 'Ciencias Políticas y Sociales'),
(20, 'Ciencias Químicas'),
(21, 'Comunicación'),
(22, 'Comunicación Publicitaria'),
(23, 'Construcciones Civiles'),
(24, 'Contaduría Pública'),
(25, 'Derecho'),
(26, 'Diseño Gráfico y Comunicación Visual'),
(27, 'Diseño Gráfico y Producción Crossmedia'),
(28, 'Economía'),
(29, 'Educación Especial Inclusiva'),
(30, 'Electricidad Industrial'),
(31, 'Electromecánica'),
(32, 'Electrónica y Telecomunicaciones'),
(33, 'Enfermería'),
(34, 'Estadística'),
(35, 'Filosofía'),
(38, 'Física'),
(36, 'Fisioterapia y Kinesiología'),
(37, 'Fonoaudiología'),
(39, 'Gastronomía y Artes Culinarias'),
(40, 'Gastronomía y Gestión de Restaurantes'),
(41, 'Geodesia, Topografía y Geomática'),
(42, 'Historia'),
(43, 'Informática'),
(44, 'Ingeniería Agroindustrial'),
(45, 'Ingeniería Agronómica'),
(46, 'Ingeniería Ambiental'),
(47, 'Ingeniería Civil'),
(48, 'Ingeniería Comercial'),
(49, 'Ingeniería Comercial y Desarrollo de Negocios'),
(50, 'Ingeniería de Alimentos'),
(51, 'Ingeniería de Sistemas'),
(52, 'Ingeniería de Sistemas Electrónicos'),
(53, 'Ingeniería de Telecomunicaciones'),
(55, 'Ingeniería Eléctrica'),
(54, 'Ingeniería Electrónica'),
(56, 'Ingeniería en Gas y Petróleo'),
(57, 'Ingeniería en Producción y Comercialización Agropecuaria'),
(58, 'Ingeniería Geográfica'),
(59, 'Ingeniería Geológica'),
(60, 'Ingeniería Industrial'),
(62, 'Ingeniería Mecánica y Electromecánica'),
(61, 'Ingeniería Mecatrónica'),
(63, 'Ingeniería Medio Ambiental'),
(64, 'Ingeniería Metalúrgica y de Materiales'),
(65, 'Ingeniería Petrolera'),
(66, 'Ingeniería Química'),
(67, 'Instrumentación Quirúrgica'),
(68, 'Liderazgo Pastoral'),
(69, 'Lingüística e Idiomas'),
(70, 'Literatura'),
(71, 'Marketing y Publicidad'),
(72, 'Matemática'),
(73, 'Mecánica Automotriz'),
(74, 'Mecánica Industrial'),
(75, 'Medicina'),
(76, 'Medicina Veterinaria y Zootecnia'),
(77, 'Nutrición y Dietética'),
(78, 'Odontología'),
(79, 'Pedagogía de Atención al Adulto Mayor'),
(80, 'Periodismo'),
(81, 'Programa de Derecho de Naciones Originarias'),
(82, 'Psicología'),
(83, 'Psicomotricidad en Salud, Educación y Deportes'),
(84, 'Publicidad'),
(85, 'Publicidad y Marketing'),
(86, 'Química Farmacéutica'),
(87, 'Química Industrial'),
(88, 'Sociología'),
(89, 'Tecnología Médica'),
(90, 'Trabajo Social'),
(91, 'Turismo');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directorio_instituciones`
--

CREATE TABLE `directorio_instituciones` (
  `id` int(10) UNSIGNED NOT NULL,
  `categoria` varchar(20) NOT NULL DEFAULT 'universidad',
  `sigla` varchar(30) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `tipo` varchar(30) DEFAULT NULL,
  `regimen` text DEFAULT NULL,
  `anio_creacion` varchar(80) DEFAULT NULL,
  `sedes` text DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` varchar(80) DEFAULT NULL,
  `sitio_web` varchar(150) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `directorio_instituciones`
--

INSERT INTO `directorio_instituciones` (`id`, `categoria`, `sigla`, `nombre`, `tipo`, `regimen`, `anio_creacion`, `sedes`, `direccion`, `telefono`, `sitio_web`, `observaciones`) VALUES
(1, 'universidad', 'UMSA', 'Universidad Mayor de San Andrés', 'Pública', 'Pública y autónoma. Fundada en 1830.', NULL, 'La Paz (Monoblock Central y facultades). Viacha: Ing. en Producción y Comercialización Agropecuaria. Sapecho (Alto Beni): Ing. Agronómica.', 'Av. Villazón N° 1995, Monoblock Central, La Paz.', NULL, 'umsa.bo', '13 facultades. Las fuentes dan entre 56 y 62 carreras de grado, según la fecha del conteo.'),
(2, 'universidad', 'UPEA', 'Universidad Pública de El Alto', 'Pública', 'Pública y autónoma. Creada por Ley 2115 (5/9/2000); autonomía por Ley 2556 (12/11/2003).', NULL, 'El Alto (Villa Esperanza).', 'Av. Sucre s/n, Zona Villa Esperanza, El Alto.', '(591-2) 2844177', 'upea.bo', '37 carreras organizadas en 9 áreas; 15 acreditadas hasta 2025 según una fuente secundaria.'),
(3, 'universidad', 'UCB', 'Universidad Católica Boliviana “San Pablo”', 'Privada', 'Privada, miembro del Sistema de la Universidad Boliviana. Fundada en 1966.', NULL, 'Sede La Paz (Obrajes). Bloque El Alto. A nivel nacional también: Cochabamba, Santa Cruz, Tarija y Sucre.', 'Av. 14 de Septiembre N° 4807, esq. Calle 2, Obrajes. Rectorado de Sede: Calle 5, Obrajes.', '(591-2) 2782222', 'lpz.ucb.edu.bo', 'Facultades en Sede La Paz: Ciencias Económicas y Financieras; Ingeniería; Ciencias Sociales y Humanas; Derecho y Ciencias Políticas. 109 carreras de grado a nivel nacional (2024).'),
(4, 'universidad', 'EMI', 'Escuela Militar de Ingeniería', 'Especial', 'Universidad especial. Naturaleza jurídica regulada por la Ley 1202 (2019).', NULL, 'Unidad Académica La Paz (central). Fuera del Dpto.: Cochabamba, Santa Cruz, Riberalta y El Trópico.', 'Av. Arce N° 2642, Zona San Jorge, La Paz.', NULL, 'emi.edu.bo', 'Especializada en ingeniería desde 1977; abrió a estudiantes civiles en 1980; carreras técnicas (Tecnológico) desde 1993.'),
(5, 'universidad', 'UNIPOL', 'Universidad Policial “Mcal. Antonio José de Sucre”', 'Especial', 'Universidad de la Policía Boliviana. Creada en 2004.', NULL, 'La Paz.', NULL, NULL, NULL, 'Figura entre las cinco del sistema universitario en el plan de la UCB.'),
(6, 'universidad', 'UASB', 'Universidad Andina Simón Bolívar', 'Privada', NULL, NULL, 'Sede principal en Sucre; sede académica en La Paz.', NULL, NULL, NULL, 'Universidad de posgrado, parte de la Comunidad Andina.'),
(7, 'universidad', 'UB', 'Universidad Bolivariana / Unión Bolivariana', 'Privada', NULL, '2004', 'La Paz.', NULL, NULL, NULL, NULL),
(8, 'universidad', 'UBI', 'Universidad Boliviana de Informática', 'Privada', NULL, NULL, 'La Paz y El Alto (según el directorio Unicarrera).', NULL, NULL, NULL, NULL),
(9, 'universidad', 'UNICEN', 'Universidad Central', 'Privada', NULL, NULL, 'La Paz.', NULL, NULL, NULL, NULL),
(10, 'universidad', 'UNITEPC', 'Universidad Técnica Privada Cosmos', 'Privada', NULL, NULL, 'La Paz.', NULL, NULL, NULL, 'Aparece como “Universidad Cosmos” en el plan de la UCB.'),
(11, 'universidad', 'UDABOL', 'Universidad de Aquino Bolivia', 'Privada', NULL, '1995', 'Sede La Paz; también Santa Cruz, Cochabamba y otras ciudades.', NULL, NULL, NULL, NULL),
(12, 'universidad', 'UCORDILLERA', 'Universidad de la Cordillera', 'Privada', NULL, '1997', 'La Paz.', NULL, NULL, NULL, NULL),
(13, 'universidad', 'UNIFRANZ', 'Universidad Privada Franz Tamayo', 'Privada', NULL, '1993', 'La Paz. El Alto. Fuera del Dpto.: Cochabamba y Santa Cruz.', 'La Paz: Calle Héroes del Acre N° 1855, esq. Landaeta. El Alto: Av. Aeropuerto Internacional de El Alto.', '(591-2) 2487700', 'unifranz.edu.bo', NULL),
(14, 'universidad', 'ULS', 'Universidad La Salle', 'Privada', NULL, '2003', 'La Paz.', NULL, NULL, NULL, NULL),
(15, 'universidad', 'UNANDES', 'Universidad de los Andes', 'Privada', NULL, '1995', 'La Paz.', NULL, NULL, NULL, NULL),
(16, 'universidad', NULL, 'Universidad Loyola', 'Privada', NULL, '1995', 'La Paz.', NULL, NULL, NULL, NULL),
(17, 'universidad', 'UNSLP', 'Universidad Nuestra Señora de La Paz', 'Privada', NULL, '1992', 'La Paz.', 'Calle Andrés Muñoz N° 2469, La Paz.', '(591-2) 242 2323', NULL, 'El teléfono viene de un directorio secundario (Altillo) y puede estar desactualizado.'),
(18, 'universidad', NULL, 'Universidad NUR', 'Privada', NULL, NULL, 'Sede principal en Santa Cruz; sede académica en La Paz.', NULL, NULL, NULL, NULL),
(19, 'universidad', 'UPB', 'Universidad Privada Boliviana', 'Privada', NULL, NULL, 'La Paz y Cochabamba.', NULL, NULL, NULL, NULL),
(20, 'universidad', 'UNIVALLE', 'Universidad Privada del Valle', 'Privada', NULL, NULL, 'La Paz, Cochabamba, Sucre, Trinidad y Santa Cruz.', NULL, NULL, NULL, NULL),
(21, 'universidad', 'UPDS', 'Universidad Privada Domingo Savio', 'Privada', NULL, NULL, 'Sede principal en Santa Cruz; sede académica en La Paz.', NULL, NULL, NULL, NULL),
(22, 'universidad', 'UREAL', 'Universidad Real', 'Privada', NULL, '1999', 'La Paz.', NULL, NULL, NULL, NULL),
(23, 'universidad', 'USP', 'Universidad Saint Paul', 'Privada', NULL, NULL, 'La Paz.', NULL, NULL, NULL, 'El plan de la UCB la escribe “Saint Pol”.'),
(24, 'universidad', 'USALESIANA', 'Universidad Salesiana de Bolivia', 'Privada', NULL, '1998 (habilitada por R.M. del 2/2/1998)', 'La Paz. Fuera del Dpto.: Cochabamba, San Carlos-Yapacani, Camiri, Monteagudo, Yacuiba y Santa Cruz.', 'Campus La Paz: Av. Chacaltaya N° 1258, Achachicala, Plaza Don Bosco. Posgrado: Av. Arce N° 2609.', '2305210 / 2305252', 'usalesiana.edu.bo', NULL),
(25, 'universidad', 'USFA', 'Universidad Privada San Francisco de Asís', 'Privada', NULL, '1999', 'La Paz y El Alto.', NULL, NULL, NULL, NULL),
(26, 'universidad', 'UTB', 'Universidad Tecnológica Boliviana', 'Privada', NULL, '1993', 'La Paz y El Alto.', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instituciones`
--

CREATE TABLE `instituciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `CI_usu` varchar(10) DEFAULT NULL,
  `nombre_institucion` varchar(150) NOT NULL,
  `nit` varchar(50) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `verificado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `institucion_carrera`
--

CREATE TABLE `institucion_carrera` (
  `id` int(10) UNSIGNED NOT NULL,
  `institucion_id` int(10) UNSIGNED NOT NULL,
  `carrera_id` int(10) UNSIGNED NOT NULL,
  `facultad` varchar(200) DEFAULT NULL,
  `grado` varchar(40) NOT NULL,
  `duracion` varchar(80) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `institucion_carrera`
--

INSERT INTO `institucion_carrera` (`id`, `institucion_id`, `carrera_id`, `facultad`, `grado`, `duracion`, `observaciones`) VALUES
(1, 1, 45, 'Agronomía', 'Licenciatura', '5 años*', 'Sedes La Paz y Sapecho (Alto Beni).'),
(2, 1, 57, 'Agronomía', 'Licenciatura', NULL, 'Sede Viacha.'),
(3, 1, 44, 'Agronomía', 'Licenciatura', NULL, 'Aparece en el menú de facultades de la UMSA.'),
(4, 1, 76, 'Agronomía', 'Licenciatura', NULL, NULL),
(5, 1, 5, 'Arquitectura, Artes, Diseño y Urbanismo', 'Licenciatura', NULL, NULL),
(6, 1, 7, 'Arquitectura, Artes, Diseño y Urbanismo', 'Licenciatura', NULL, NULL),
(7, 1, 6, 'Arquitectura, Artes, Diseño y Urbanismo', 'Licenciatura', NULL, 'Aparece en un listado secundario.'),
(8, 1, 1, 'Ciencias Económicas y Financieras', 'Licenciatura', NULL, NULL),
(9, 1, 24, 'Ciencias Económicas y Financieras', 'Licenciatura', NULL, NULL),
(10, 1, 28, 'Ciencias Económicas y Financieras', 'Licenciatura', NULL, NULL),
(11, 1, 11, 'Ciencias Farmacéuticas y Bioquímicas', 'Licenciatura', NULL, NULL),
(12, 1, 86, 'Ciencias Farmacéuticas y Bioquímicas', 'Licenciatura', NULL, NULL),
(13, 1, 59, 'Ciencias Geológicas', 'Licenciatura', '5 años*', NULL),
(14, 1, 58, 'Ciencias Geológicas', 'Licenciatura', '5 años*', NULL),
(15, 1, 10, 'Ciencias Puras y Naturales', 'Licenciatura', NULL, NULL),
(16, 1, 20, 'Ciencias Puras y Naturales', 'Licenciatura', NULL, NULL),
(17, 1, 34, 'Ciencias Puras y Naturales', 'Licenciatura', NULL, NULL),
(18, 1, 38, 'Ciencias Puras y Naturales', 'Licenciatura', NULL, NULL),
(19, 1, 43, 'Ciencias Puras y Naturales', 'Licenciatura', NULL, NULL),
(20, 1, 72, 'Ciencias Puras y Naturales', 'Licenciatura', NULL, NULL),
(21, 1, 4, 'Ciencias Sociales', 'Licenciatura', NULL, NULL),
(22, 1, 13, 'Ciencias Sociales', 'Licenciatura', NULL, NULL),
(23, 1, 88, 'Ciencias Sociales', 'Licenciatura', NULL, NULL),
(24, 1, 90, 'Ciencias Sociales', 'Licenciatura', NULL, NULL),
(25, 1, 25, 'Derecho y Ciencias Políticas', 'Licenciatura', '5 años*', NULL),
(26, 1, 18, 'Derecho y Ciencias Políticas', 'Licenciatura', NULL, NULL),
(27, 1, 81, 'Derecho y Ciencias Políticas', 'Licenciatura', NULL, 'Programa especial.'),
(28, 1, 14, 'Humanidades y Ciencias de la Educación', 'Licenciatura', NULL, NULL),
(29, 1, 15, 'Humanidades y Ciencias de la Educación', 'Licenciatura', NULL, NULL),
(30, 1, 35, 'Humanidades y Ciencias de la Educación', 'Licenciatura', NULL, NULL),
(31, 1, 42, 'Humanidades y Ciencias de la Educación', 'Licenciatura', NULL, NULL),
(32, 1, 69, 'Humanidades y Ciencias de la Educación', 'Licenciatura', NULL, NULL),
(33, 1, 70, 'Humanidades y Ciencias de la Educación', 'Licenciatura', NULL, NULL),
(34, 1, 82, 'Humanidades y Ciencias de la Educación', 'Licenciatura', NULL, NULL),
(35, 1, 91, 'Humanidades y Ciencias de la Educación', 'Licenciatura', NULL, NULL),
(36, 1, 47, 'Ingeniería', 'Licenciatura', '5 años*', NULL),
(37, 1, 55, 'Ingeniería', 'Licenciatura', '5 años*', NULL),
(38, 1, 54, 'Ingeniería', 'Licenciatura', '5 años*', NULL),
(39, 1, 60, 'Ingeniería', 'Licenciatura', '4 años*', NULL),
(40, 1, 62, 'Ingeniería', 'Licenciatura', '5 años* (Electromecánica)', NULL),
(41, 1, 64, 'Ingeniería', 'Licenciatura', NULL, NULL),
(42, 1, 65, 'Ingeniería', 'Licenciatura', '5 años*', NULL),
(43, 1, 66, 'Ingeniería', 'Licenciatura', '5 años*', NULL),
(44, 1, 46, 'Ingeniería', 'Licenciatura', '5 años*', NULL),
(45, 1, 75, 'Medicina, Enfermería, Nutrición y Tecnología Médica', 'Licenciatura', '6 años*', NULL),
(46, 1, 33, 'Medicina, Enfermería, Nutrición y Tecnología Médica', 'Licenciatura', NULL, NULL),
(47, 1, 77, 'Medicina, Enfermería, Nutrición y Tecnología Médica', 'Licenciatura', NULL, NULL),
(48, 1, 89, 'Medicina, Enfermería, Nutrición y Tecnología Médica', 'Licenciatura', '5 años*', NULL),
(49, 1, 78, 'Odontología', 'Licenciatura', NULL, NULL),
(50, 1, 3, 'Tecnología', 'Técnico superior', '3 años*', 'Las carreras de esta facultad se dan como técnico superior.'),
(51, 1, 23, 'Tecnología', 'Técnico superior', '3 años*', NULL),
(52, 1, 30, 'Tecnología', 'Técnico superior', '3 años*', NULL),
(53, 1, 32, 'Tecnología', 'Técnico superior', '3 años*', NULL),
(54, 1, 31, 'Tecnología', 'Técnico superior', '3 años*', NULL),
(55, 1, 73, 'Tecnología', 'Técnico superior', '3 años*', NULL),
(56, 1, 74, 'Tecnología', 'Técnico superior', '3 años*', NULL),
(57, 1, 87, 'Tecnología', 'Técnico superior', '3 años*', NULL),
(58, 1, 41, 'Tecnología', 'Técnico superior', '3 años*', NULL),
(59, 2, 45, 'Ciencias Agrícolas, Pecuarias y Recursos Naturales', 'Licenciatura', NULL, NULL),
(60, 2, 24, 'Ciencias Económicas', 'Licenciatura', NULL, 'Carrera acreditada ante el CEUB según una fuente secundaria.'),
(61, 2, 13, 'Ciencias Sociales', 'Licenciatura', NULL, NULL),
(62, 2, 16, 'Ciencias Sociales', 'Licenciatura', NULL, NULL),
(63, 3, 1, 'Ciencias Económicas y Financieras', 'Licenciatura', NULL, 'El plan de estudios exige 42 asignaturas obligatorias y 2 libres.'),
(64, 3, 28, 'Ciencias Económicas y Financieras', 'Licenciatura', NULL, NULL),
(65, 3, 24, 'Ciencias Económicas y Financieras', 'Licenciatura', NULL, 'Aparece en una oferta antigua de la sede.'),
(66, 3, 66, 'Ingeniería', 'Licenciatura', NULL, 'Reconocida por ARCU-SUR (Mercosur) en 2023.'),
(67, 3, 51, 'Ingeniería', 'Licenciatura', NULL, 'También se ofrece en el bloque El Alto.'),
(68, 3, 61, 'Ingeniería', 'Licenciatura', NULL, 'El plan de la sede cita laboratorios de Mecatrónica.'),
(69, 3, 5, 'Ingeniería / Arquitectura', 'Licenciatura', NULL, 'Reconocida por ARCU-SUR (Mercosur) en 2023.'),
(70, 3, 13, 'Ciencias Sociales y Humanas', 'Licenciatura', NULL, 'Aparece en una oferta antigua de la sede.'),
(71, 3, 82, 'Ciencias Sociales y Humanas', 'Licenciatura', NULL, 'El plan de la sede cita laboratorios de Psicología.'),
(72, 3, 26, 'Ciencias Sociales y Humanas', 'Licenciatura', NULL, 'La carrera figura en el plan de la sede.'),
(73, 3, 25, 'Derecho y Ciencias Políticas', 'Licenciatura', '9 semestres (referencia de otras sedes UCB)', '(título de Abogado)'),
(74, 3, 17, 'Derecho y Ciencias Políticas', 'Licenciatura', NULL, 'Aparece en una oferta antigua de la sede.'),
(75, 4, 47, 'Ingenierías', 'Licenciatura', NULL, NULL),
(76, 4, 51, 'Ingenierías', 'Licenciatura', NULL, NULL),
(77, 4, 52, 'Ingenierías', 'Licenciatura', NULL, 'La EMI fue la primera universidad del país en ofrecerla, según su manual institucional.'),
(78, 4, 48, 'Ingenierías', 'Licenciatura', NULL, NULL),
(79, 4, 61, 'Ingenierías', 'Licenciatura', NULL, 'Tiene laboratorio de robótica en La Paz.'),
(80, 4, 45, 'Ingenierías', 'Licenciatura', NULL, 'Aparece en una oferta antigua. Confirmar.'),
(81, 4, 46, 'Ingenierías', 'Licenciatura', NULL, 'Aparece en una oferta antigua. Confirmar.'),
(82, 4, 75, 'Salud', 'Licenciatura', NULL, 'Figura una carrera de Medicina en convenios de la EMI (2025). Confirmar sede.'),
(83, 13, 25, 'Ciencias Jurídicas y Sociales', 'Licenciatura', NULL, 'Sedes: LP y EA.'),
(84, 13, 82, 'Ciencias Jurídicas y Sociales', 'Licenciatura', NULL, 'Sedes: LP y EA.'),
(85, 13, 80, 'Ciencias Jurídicas y Sociales', 'Licenciatura', NULL, 'Sede: LP. Mención: Periodismo Digital (la guía cita otra mención de comunicación).'),
(86, 13, 1, 'Ciencias Económicas y Empresariales', 'Licenciatura', NULL, 'Sedes: LP y EA. Menciones: Gestión del Talento Humano; Emprendedurismo e Innovación.'),
(87, 13, 2, 'Ciencias Económicas y Empresariales', 'Licenciatura', NULL, 'Sedes: LP y EA. Menciones: Gestión Hotelera; Tech Tourismo.'),
(88, 13, 9, 'Ciencias Económicas y Empresariales', 'Licenciatura', NULL, 'Sede: EA. Menciones: Gestión Tributaria; Gestión Financiera.'),
(89, 13, 24, 'Ciencias Económicas y Empresariales', 'Licenciatura', NULL, 'Sede: LP. Menciones: Gestión Tributaria; Gestión Financiera.'),
(90, 13, 28, 'Ciencias Económicas y Empresariales', 'Licenciatura', NULL, 'Sede: LP. Menciones: Análisis Económico Aplicado; Economía Financiera.'),
(91, 13, 48, 'Ciencias Económicas y Empresariales', 'Licenciatura', NULL, 'Sedes: LP y EA. Menciones: Comercio Exterior; eBusiness.'),
(92, 13, 75, 'Ciencias de la Salud', 'Licenciatura', NULL, 'Sedes: LP y EA.'),
(93, 13, 78, 'Ciencias de la Salud', 'Licenciatura', NULL, 'Sedes: LP y EA.'),
(94, 13, 12, 'Ciencias de la Salud', 'Licenciatura', NULL, 'Sedes: LP y EA.'),
(95, 13, 33, 'Ciencias de la Salud', 'Licenciatura', NULL, 'Sede: EA.'),
(96, 13, 51, 'Ingeniería', 'Licenciatura', NULL, 'Sedes: LP y EA. Menciones: Domótica; Internet de las Cosas. Un directorio la nombra “Ingeniería de Sistemas e Innovación Digital”.'),
(97, 13, 85, 'Diseño y Tecnologías Crossmedia', 'Licenciatura', NULL, 'Sede: por verificar (aparece en La Paz en notas de la universidad).'),
(98, 13, 27, 'Diseño y Tecnologías Crossmedia', 'Licenciatura', NULL, 'Sede: por verificar.'),
(99, 13, 39, 'Otras', 'Licenciatura', NULL, 'Sede: por verificar.'),
(100, 24, 14, NULL, 'Licenciatura', NULL, 'Una de las dos carreras con las que se habilitó la universidad en 1998.'),
(101, 24, 51, NULL, 'Licenciatura', NULL, 'La otra carrera inicial en 1998.'),
(102, 24, 25, NULL, 'Licenciatura', NULL, NULL),
(103, 24, 24, NULL, 'Licenciatura', NULL, NULL),
(104, 24, 49, NULL, 'Licenciatura', NULL, NULL),
(105, 24, 83, NULL, 'Licenciatura', NULL, NULL),
(106, 24, 40, NULL, 'Licenciatura', NULL, NULL),
(107, 24, 79, NULL, 'Técnico superior', NULL, NULL),
(108, 24, 29, NULL, 'Técnico superior', NULL, NULL),
(109, 17, 75, 'Medicina', 'Licenciatura', NULL, NULL),
(110, 17, 33, 'Medicina', 'Licenciatura', NULL, NULL),
(111, 17, 67, 'Medicina', 'Licenciatura', NULL, NULL),
(112, 17, 37, 'Medicina', 'Licenciatura', NULL, NULL),
(113, 17, 63, 'Ingeniería', 'Licenciatura', NULL, NULL),
(114, 17, 51, 'Ingeniería', 'Licenciatura', NULL, NULL),
(115, 17, 50, 'Ingeniería', 'Licenciatura', NULL, NULL),
(116, 17, 60, 'Ingeniería', 'Licenciatura', NULL, NULL),
(117, 17, 19, 'Ciencias Políticas y Sociales', 'Licenciatura', NULL, NULL),
(118, 17, 25, 'Ciencias Políticas y Sociales', 'Licenciatura', NULL, NULL),
(119, 17, 22, 'Ciencias Políticas y Sociales', 'Licenciatura', NULL, NULL),
(120, 17, 84, 'Ciencias Políticas y Sociales', 'Técnico superior', NULL, NULL),
(121, 17, 28, 'Economía', 'Licenciatura', NULL, NULL),
(122, 17, 48, 'Economía', 'Licenciatura', NULL, NULL),
(123, 11, 1, NULL, 'Licenciatura', NULL, NULL),
(124, 11, 5, NULL, 'Licenciatura', NULL, NULL),
(125, 11, 8, NULL, 'Licenciatura', NULL, NULL),
(126, 11, 12, NULL, 'Licenciatura', NULL, NULL),
(127, 11, 21, NULL, 'Licenciatura', NULL, NULL),
(128, 11, 25, NULL, 'Licenciatura', NULL, NULL),
(129, 11, 33, NULL, 'Licenciatura', NULL, NULL),
(130, 11, 36, NULL, 'Licenciatura', NULL, NULL),
(131, 11, 46, NULL, 'Licenciatura', NULL, NULL),
(132, 11, 48, NULL, 'Licenciatura', NULL, NULL),
(133, 11, 51, NULL, 'Licenciatura', NULL, NULL),
(134, 11, 53, NULL, 'Licenciatura', NULL, NULL),
(135, 11, 56, NULL, 'Licenciatura', NULL, NULL),
(136, 11, 68, NULL, 'Licenciatura', NULL, NULL),
(137, 11, 71, NULL, 'Licenciatura', NULL, NULL),
(138, 11, 75, NULL, 'Licenciatura', NULL, NULL),
(139, 11, 78, NULL, 'Licenciatura', NULL, NULL),
(140, 11, 82, NULL, 'Licenciatura', NULL, NULL),
(141, 11, 91, NULL, 'Licenciatura', NULL, NULL);

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
  `token_verificacion` varchar(255) NOT NULL,
  `token_expira` datetime DEFAULT NULL,
  `email_verificado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nuevo_usu`
--

INSERT INTO `nuevo_usu` (`CI_usu`, `nombre_c_usu`, `telefono`, `correo`, `fecha_nacimiento`, `contrasena`, `rol`, `token_verificacion`, `token_expira`, `email_verificado`) VALUES
('12345678', 'pepe peralez', '123', 'pepe@gmail.com', '2026-11-13', '$2y$10$iO.rtqu2Ak3/EMF3j4ZARO8KqC0OceOoUINQgwMgq.dJNHtQZ/oAS', 'institucion', '', NULL, 0),
('13845803', 'Helen Ramos', '77713485', 'sistema.sisvo@gmail.com', '2007-10-22', '$2y$10$WSdIQpPM3fWjJMKd8b3NheqmI6DFDSC9xi89SMblFVcTxQO2dqlYO', 'usuario', '', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_test`
--

CREATE TABLE `resultados_test` (
  `id_resultado` int(11) NOT NULL,
  `CI_usu` varchar(30) NOT NULL,
  `codigo_mbti` char(4) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_carrera_nombre` (`nombre`);

--
-- Indices de la tabla `convocatorias`
--
ALTER TABLE `convocatorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_convocatorias_usuario` (`CI_usu`);

--
-- Indices de la tabla `directorio_instituciones`
--
ALTER TABLE `directorio_instituciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `CI_usu` (`CI_usu`);

--
-- Indices de la tabla `institucion_carrera`
--
ALTER TABLE `institucion_carrera`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_institucion` (`institucion_id`),
  ADD KEY `idx_carrera` (`carrera_id`);

--
-- Indices de la tabla `nuevo_usu`
--
ALTER TABLE `nuevo_usu`
  ADD PRIMARY KEY (`CI_usu`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `resultados_test`
--
ALTER TABLE `resultados_test`
  ADD PRIMARY KEY (`id_resultado`),
  ADD KEY `idx_ci` (`CI_usu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `becas`
--
ALTER TABLE `becas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `convocatorias`
--
ALTER TABLE `convocatorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `directorio_instituciones`
--
ALTER TABLE `directorio_instituciones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `instituciones`
--
ALTER TABLE `instituciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `institucion_carrera`
--
ALTER TABLE `institucion_carrera`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT de la tabla `resultados_test`
--
ALTER TABLE `resultados_test`
  MODIFY `id_resultado` int(11) NOT NULL AUTO_INCREMENT;

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
-- Filtros para la tabla `institucion_carrera`
--
ALTER TABLE `institucion_carrera`
  ADD CONSTRAINT `fk_ic_carrera` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ic_institucion` FOREIGN KEY (`institucion_id`) REFERENCES `directorio_instituciones` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
