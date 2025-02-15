-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2025 at 03:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_administracion`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_periods`
--

CREATE TABLE `academic_periods` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_periods`
--

INSERT INTO `academic_periods` (`id`, `name`, `start_date`, `end_date`, `created_at`) VALUES
(1, 'Primer Periodo Académico: Abril - Agosto', 'Abril', 'Agosto', '2024-11-07 06:07:46'),
(2, 'Segundo Periodo Académico: Octubre - Febrero', 'Octubre', 'Febrero', '2024-11-07 06:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `base_datos_indexada`
--

CREATE TABLE `base_datos_indexada` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `base_datos_indexada`
--

INSERT INTO `base_datos_indexada` (`id`, `nombre`) VALUES
(1, 'LATIN INDEX (CATÁLOGO)'),
(2, 'LILACS'),
(3, 'SciELO'),
(4, 'LIBRO'),
(5, 'REDALYC'),
(6, 'EBSCO'),
(7, 'OAJI'),
(8, 'DOAJ'),
(9, 'CINAHL'),
(10, 'SCOPUS'),
(11, 'ISI JOURNAL'),
(12, 'HEIN ON LINE LIBRARY'),
(13, 'CHEMICAL ABSTRACTS INDIAN CITATION INDEX'),
(14, 'ERIHPLUS'),
(15, 'WEB OF SCIENCE'),
(16, 'CLASE'),
(17, 'PERIODICA'),
(18, 'AGRICOLA'),
(19, 'CAB ABSTRACTS'),
(20, 'ANTHROPOLOGICAL INDEX'),
(21, 'ARTS AND HUMANITIES CITATION INDEX (AHCI)'),
(22, 'HISPANIC AMERICAN PERIODICAL INDEX (HAPI)'),
(23, 'HEINONLINE'),
(24, 'BIOLOGICAL ABSTRACTS'),
(25, 'GLOBAL HEALTH'),
(26, 'INTERNATIONAL POLITICAL SCIENCE ABSTRACTS'),
(27, 'WORLDWIDE POLITICAL SCIENCE ABSTRACTS'),
(28, 'APPLIED SOCIAL SCIENCE ABSTRACTS & INDEXES (ASSIA)'),
(29, 'INTERNATIONAL BIBLIOGRAPHY OF THE SOCIAL SCIENCES (IBSS)'),
(30, 'CLASIFICACIÓN INTEGRADA DE REVISTAS CIENTÍFICAS (CIRC)'),
(31, 'ÍNDICE DE REVISTAS DE EDUCACIÓN SUPERIOR E INVESTIGACIÓN EDUCATIVA (IRESIE)'),
(32, 'EDUCATIONAL RESEARCH ABSTRACTS (ERA)'),
(33, 'ECONOMIC LITERATURE INDEX'),
(34, 'PHILOSOPHER\'S INDEX'),
(35, 'INTERNATIONAL PHARMACEUTICAL ABSTRACTS'),
(36, 'GEOBASE'),
(37, 'GEOREF'),
(38, 'HISTORICAL ABSTRACTS'),
(39, 'INSPEC'),
(40, 'METADEX'),
(41, 'MATHEMATICS EDUCATION DATABASE'),
(42, 'HISTORIA MATHEMATICA'),
(43, 'PSYCINFO'),
(44, 'PSICODOC'),
(45, 'CHEMICAL ABSTRACTS PLUS'),
(46, 'CUIDEN'),
(47, 'EMBASE'),
(48, 'INDEX MEDICUS'),
(49, 'SOCINDEX'),
(50, 'SOCIOLOGICAL ABSTRACTS'),
(51, 'ADVANCED SCIENCE INDEX (ASI)'),
(52, 'CROSSREF'),
(53, 'PROQUEST NURSING ALLIED HEALTH SOURCE'),
(54, 'INDEX COPERNICUS (ICI JOURNALS MASTER LIST)'),
(55, 'ACTUALIDAD IBEROAMERICANA'),
(56, 'REVENCYT'),
(57, 'NO APLICA');

-- --------------------------------------------------------

--
-- Table structure for table `campo_amplio`
--

CREATE TABLE `campo_amplio` (
  `id` int(11) NOT NULL,
  `nombre_amplio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campo_amplio`
--

INSERT INTO `campo_amplio` (`id`, `nombre_amplio`) VALUES
(1, 'Administración'),
(2, 'Administración de empresas y derecho'),
(3, 'Agricultura, silvicultura, pesca y veterinaria'),
(4, 'Artes y humanidades'),
(5, 'Ciencias naturales, matemáticas y estadísticas'),
(6, 'Ciencias sociales, periodismo e información'),
(7, 'Ciencias sociales, periodismo, información y derecho'),
(8, 'Educación'),
(9, 'Ingeniería, industria y construcción'),
(10, 'Programas Genéricos y Calificaciones'),
(11, 'Salud y Bienestar'),
(12, 'Servicios'),
(13, 'Tecnologías de la información y comunicación (TIC)');

-- --------------------------------------------------------

--
-- Table structure for table `campo_detallado`
--

CREATE TABLE `campo_detallado` (
  `id` int(11) NOT NULL,
  `nombre_detallado` varchar(255) NOT NULL,
  `especifico_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campo_detallado`
--

INSERT INTO `campo_detallado` (`id`, `nombre_detallado`, `especifico_id`) VALUES
(1, 'Contabilidad y auditoría', 1),
(2, 'Gestión financiera', 1),
(3, 'Administración', 1),
(4, 'Mercadotecnia y publicidad', 1),
(5, 'Información gerencial', 1),
(6, 'Comercio', 1),
(7, 'Competencias laborales', 1),
(8, 'Derecho', 2),
(9, 'Derechos humanos', 2),
(10, 'Producción agrícola y ganadera', 3),
(11, 'Silvicultura', 4),
(12, 'Veterinaria', 5),
(13, 'Pesca', 6),
(14, 'Técnicas audiovisuales y producción para medios de comunicación', 7),
(15, 'Diseño', 7),
(16, 'Artes', 7),
(17, 'Música y artes escénicas', 7),
(18, 'Idiomas', 8),
(19, 'Literatura y lingüística', 8),
(20, 'Religión y Teología', 9),
(21, 'Historia y Arqueología', 9),
(22, 'Filosofía', 9),
(23, 'Biología', 10),
(24, 'Biofísica', 10),
(25, 'Biofarmacéutica', 10),
(26, 'Biomedicina', 10),
(27, 'Bioquímica', 10),
(28, 'Genética', 10),
(29, 'Biodiversidad', 10),
(30, 'Neurociencias', 10),
(31, 'Química', 11),
(32, 'Ciencias de la Tierra', 11),
(33, 'Física', 11),
(34, 'Medio ambiente', 12),
(35, 'Recursos Naturales Renovables', 12),
(36, 'Matemáticas', 13),
(37, 'Estadísticas', 13),
(38, 'Logística y transporte', 13),
(39, 'Economía', 14),
(40, 'Economía Matemática', 14),
(41, 'Ciencia políticas', 14),
(42, 'Psicología', 14),
(43, 'Estudios Sociales y Culturales', 14),
(44, 'Estudios de Género', 14),
(45, 'Geografía y territorio', 14),
(46, 'Derecho', 15),
(47, 'Periodismo y comunicación', 16),
(48, 'Bibliotecología, documentación y archivología', 16),
(49, 'Formación para docentes con asignaturas de especialización', 17),
(50, 'Educación', 17),
(51, 'Psicopedagogía', 17),
(52, 'Formación para docentes de educación preprimaria', 17),
(53, 'Formación para docentes sin asignaturas de especialización', 17),
(54, 'Procesamiento de alimentos', 18),
(55, 'Materiales', 18),
(56, 'Productos textiles', 18),
(57, 'Minería y extracción', 18),
(58, 'Producción industrial', 18),
(59, 'Seguridad industrial', 18),
(60, 'Diseño industrial y de procesos', 18),
(61, 'Mantenimiento industrial', 18),
(62, 'Arquitectura, urbanismo y restauración', 19),
(63, 'Construcción e ingeniería civil', 19),
(64, 'Química aplicada', 20),
(65, 'Tecnología de protección del medio ambiente', 20),
(66, 'Electricidad y energía', 20),
(67, 'Electrónica, automatización y sonido', 20),
(68, 'Mecánica y profesiones afines a la metalistería', 20),
(69, 'Diseño y construcción de vehículos, barcos y aeronaves motorizadas', 20),
(70, 'Tecnologías Nucleares y Energéticas', 20),
(71, 'Mecatrónica', 20),
(72, 'Hidráulica', 20),
(73, 'Telecomunicaciones', 20),
(74, 'Nanotecnología', 20),
(75, 'Programas y cualificaciones básicas', 21),
(76, 'Alfabetización y aritmética', 22),
(77, 'Desarrollo y habilidades Personales', 23),
(78, 'Asistencia a adultos mayores y discapacitados', 24),
(79, 'Asistencia a la infancia y servicios para jóvenes', 24),
(80, 'Medicina', 25),
(81, 'Enfermería y obstetricia', 25),
(82, 'Tecnología de diagnóstico y tratamiento médico', 25),
(83, 'Farmacia', 25),
(84, 'Terapias alternativas y complementarias', 25),
(85, 'Salud Pública', 25),
(86, 'Terapia, rehabilitación y tratamiento de la salud', 25),
(87, 'Estudios dentales', 25),
(88, 'Peluquería y tratamiento de belleza', 26),
(89, 'Hotelería y gastronomía', 26),
(90, 'Actividad física', 26),
(91, 'Turismo', 26),
(92, 'Educación policial, militar y defensa', 27),
(93, 'Seguridad ciudadana', 27),
(94, 'Prevención y gestión de riesgos', 28),
(95, 'Salud y seguridad ocupacional', 28),
(96, 'Gestión del transporte', 29),
(97, 'Computación', 30),
(98, 'Diseño y administración de redes y bases de datos', 30),
(99, 'Desarrollo y análisis de software y aplicaciones', 30),
(100, 'Sistemas de información', 30);

-- --------------------------------------------------------

--
-- Table structure for table `campo_especifico`
--

CREATE TABLE `campo_especifico` (
  `id` int(11) NOT NULL,
  `nombre_especifico` varchar(255) NOT NULL,
  `amplio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campo_especifico`
--

INSERT INTO `campo_especifico` (`id`, `nombre_especifico`, `amplio_id`) VALUES
(1, 'Educación comercial y administración', 1),
(2, 'Derecho', 2),
(3, 'Agricultura', 3),
(4, 'Silvicultura', 3),
(5, 'Veterinaria', 3),
(6, 'Pesca', 3),
(7, 'Artes', 4),
(8, 'Idiomas', 4),
(9, 'Humanidades', 4),
(10, 'Ciencias biológicas y afines', 5),
(11, 'Ciencias físicas', 5),
(12, 'Medio ambiente', 5),
(13, 'Matemáticas y estadística', 5),
(14, 'Ciencias sociales y del comportamiento', 7),
(15, 'Derecho', 7),
(16, 'Periodismo e información', 7),
(17, 'Educación', 8),
(18, 'Industría y producción', 9),
(19, 'Arquitectura y construcción', 9),
(20, 'Ingeniería y profesiones afines', 9),
(21, 'Programas y cualificaciones básicas', 10),
(22, 'Alfabetización y aritmética', 10),
(23, 'Desarrollo y habilidades Personales', 10),
(24, 'Bienestar', 11),
(25, 'Salud', 11),
(26, 'Servicios personales', 12),
(27, 'Servicios de seguridad', 12),
(28, 'Servicios de protección', 12),
(29, 'Servicio de transporte', 12),
(30, 'Tecnologías de la información y comunicación (TIC)', 13);

-- --------------------------------------------------------

--
-- Table structure for table `careers`
--

CREATE TABLE `careers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `careers`
--

INSERT INTO `careers` (`id`, `name`, `created_at`) VALUES
(1, 'Institucionales', '2024-11-06 09:17:45'),
(2, 'Desarrollo de Software', '2024-11-06 09:17:45'),
(3, 'Desarrollo y Análisis de Software - Modalidad Virtual', '2024-11-21 00:06:34'),
(4, 'Diseño Gráfico', '2024-11-21 00:06:34'),
(5, 'Administración', '2024-11-21 00:06:34'),
(6, 'Marketing Digital y Comercio Electrónico', '2024-11-21 00:06:34'),
(7, 'Redes y Telecomunicaciones', '2024-11-21 00:06:34'),
(8, 'Atención Integral a Adultos Mayores', '2025-02-02 15:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Proyectos Integradores de Saberes', 'PIS de estudiantes del ITSI.', '2024-11-06 09:17:45', '2024-11-07 09:41:52'),
(2, 'Trabajos de Titulación', 'Trabajos de grado', '2024-11-06 09:17:45', '2024-11-06 09:17:45'),
(3, 'Proyectos I+D+i', 'Proyectos de investigación, desarrollo e innovación', '2024-11-06 09:17:45', '2024-11-06 09:17:45');

-- --------------------------------------------------------

--
-- Table structure for table `docentes`
--

CREATE TABLE `docentes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `docentes`
--

INSERT INTO `docentes` (`id`, `nombre`, `cedula`, `created_at`, `updated_at`) VALUES
(30, 'docente 1', '1111', '2025-02-12 20:56:51', '2025-02-12 20:56:51'),
(31, 'docente 2', '2222', '2025-02-12 21:01:02', '2025-02-12 21:01:02'),
(32, 'docente 3', '3333', '2025-02-12 21:14:37', '2025-02-12 21:14:37'),
(33, 'docente 4', '4444', '2025-02-12 21:18:25', '2025-02-12 21:18:25'),
(34, 'Jose Morales', '9999999999', '2025-02-13 14:45:34', '2025-02-13 14:45:34');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `career_id` int(11) NOT NULL,
  `academic_period_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `authors` text NOT NULL,
  `publication_year` int(11) NOT NULL,
  `summary` text DEFAULT NULL,
  `pdf_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `category_id`, `career_id`, `academic_period_id`, `title`, `authors`, `publication_year`, `summary`, `pdf_path`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 1, 'Desarrollo de una aplicación móvil con implementación de un método de pago electrónico para automatizar el servicio de pago de transporte terrestre urbano en la Cooperativa San Miguel de Ibarra', 'Durán Rosero Lucía Monserat, Collaguazo Toala Steven Anibal', 2024, 'El objetivo general fue desarrollar una aplicación móvil innovadora para la cooperativa de transporte urbano San Miguel, centrada en la implementación de un método de pago electrónico con la finalidad de ofrecer eficiencia y comodidad en los servicios ofrecidos mediante códigos QR.', 'uploads/documents/2024/11/1730963165_1010a44ba0d14da81939.pdf', '2024-11-07 12:06:05', '2024-11-07 12:06:05'),
(3, 2, 2, 1, 'Análisis de la imagen corporativa y desarrollo de estrategias para el posicionamiento de la marca “Inter Farma” en la industria farmacéutica.', 'Cevallos Torres Karla Valeria, Sarzosa Recalde Diego Sebastián', 2024, 'Este proyecto se enfoca en implementar estrategias de branding y marketing en la farmacia Inter Farma para su posiciónamiento en el mercado farmacéutico. Se busca diseñar un plan integral que refleje la identidad y valores únicos de Inter Farma,', 'uploads/documents/2024/11/1731045912_2dcac8d834ea4ae77ac4.pdf', '2024-11-08 11:05:12', '2024-11-08 11:05:12');

-- --------------------------------------------------------

--
-- Table structure for table `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `nombre`, `cedula`, `created_at`, `updated_at`) VALUES
(41, 'estudiante 1', '111', '2025-02-12 20:58:24', '2025-02-12 20:58:24'),
(42, 'estudiante 2', '222', '2025-02-12 21:01:02', '2025-02-12 21:01:02'),
(43, 'estudiante 4', '444', '2025-02-12 21:18:25', '2025-02-12 21:18:25'),
(44, 'Leonel Stalin Chavez Chasi', '1003816533', '2025-02-13 14:45:34', '2025-02-13 14:45:34'),
(45, 'Fernando Kenyy Benalcazar Iles', '8888888888', '2025-02-13 14:45:34', '2025-02-13 14:45:34');

-- --------------------------------------------------------

--
-- Table structure for table `lineas_investigacion_carreras`
--

CREATE TABLE `lineas_investigacion_carreras` (
  `id` int(11) NOT NULL,
  `nombre_linea` varchar(255) NOT NULL,
  `carrera_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lineas_investigacion_carreras`
--

INSERT INTO `lineas_investigacion_carreras` (`id`, `nombre_linea`, `carrera_id`) VALUES
(48, 'ITSI-L1-INNOVACIÓN EDUCATIVA, PEDAGOGÍA E INTERCULTURALIDAD', 1),
(49, 'ITSI-L2-CIENCIAS DE LA VIDA, SOSTENIBILIDAD, MATEMÁTICA Y ESTADÍSTICA', 1),
(50, 'ITSI-L3-DISEÑO Y PRODUCCIÓN AUDIOVISUAL', 1),
(51, 'ITSI-L4-SALUD PÚBLICA Y PROMOCIÓN DE LA SALUD', 1),
(52, 'ITSI-L5-TECNOLOGÍAS DE LA INFORMACIÓN Y LA COMUNICACIÓN (TIC)', 1),
(53, 'ITSI-L6-INGENIERÍA, PRODUCCIÓN Y CONSTRUCCIÓN', 1),
(54, 'ITSI-L7-CIENCIAS SOCIALES Y DESARROLLO COMUNITARIO', 1),
(55, 'ITSI-L8-SERVICIOS Y ADMINISTRACIÓN', 1),
(56, 'ITSI-L9-DESARROLLO TECNOLÓGICO', 1),
(57, 'ITSI-DS-L1-TECNOLOGÍAS DE INFORMACIÓN Y COMUNICACIÓN', 2),
(58, 'ITSI-DS-L2-SOFTWARE APLICADO', 2),
(59, 'ITSI-DS-L3-DESARROLLO DE SOFTWARE', 2),
(60, 'ITSI-DS-L4-INNOVACIÓN TECNOLÓGICA Y NEGOCIOS', 2),
(61, 'ITSI-DS-L5-APLICACIONES TECNOLÓGICAS PARA EL DESARROLLO', 2),
(62, 'ITSI-DS-L6-ADMINISTRACIÓN Y SEGURIDAD DE LAS BASES DE DATOS', 2),
(63, 'ITSI-DS-L7-ADMINISTRACIÓN Y AUDITORIA DE HARDWARE.', 2),
(64, 'ITSI-DS-L8-REDES Y TELECOMUNICACIONES EN LA PRODUCCIÓN DE BIENES Y SERVICIOS', 2),
(65, 'ITSI-DS-L9-METODOLOGÍAS PARA EL DESARROLLO DE SOFTWARE', 2),
(66, 'ITSI-DS-L10-DESARROLLO TECNOLÓGICO Y SOCIEDAD.', 2),
(67, 'ITSI-RT-L1-PROCESAMIENTO DIGITAL DE SEÑALES E IMÁGENES EN COMUNICACIÓN', 7),
(68, 'ITSI-RT-L2-COMUNICACIONES ÓPTICAS DE ALTA VELOCIDAD', 7),
(69, 'ITSI-RT-L3-INTERNET Y REDES DE NUEVA GENERACIÓN', 7),
(70, 'ITSI-RT-L4-REDES INTELIGENTES Y SERVICIOS AVANZADOS DE TELECOMUNICACIONES', 7),
(71, 'ITSI-RT-L5- SISTEMAS DE TRASMISIÓN', 7),
(72, 'ITSI-RT-L6-PROCESAMIENTO DIGITAL DE SEÑALES E IMÁGENES EN COMUNICACIÓN', 7),
(73, 'ITSI-DG-L1-ESTRATEGIAS Y MARCAS', 4),
(74, 'ITSI-DG-L2-PUBLICACIONES IMPRESAS Y DIGITALES', 4),
(75, 'ITSI-DG-L3-FUNDAMENTOS DEL DISEÑO', 4),
(76, 'ITSI-DG-L4-SOFTWARE Y AUTOEDICIÓN', 4),
(77, 'ITSI-DG-L5-COMUNICACIÓN VISUAL', 4),
(78, 'ITSI-DG-L6-MARKETING INTEGRAL', 4),
(79, 'ITSI-DG-L7-DISEÑO WEB PARA EL DESARROLLO.', 4),
(80, 'ITSI-DG-L8-INNOVACIÓN TECNOLÓGICA EN MARKETING DIGITAL.', 4),
(81, 'ITSI-MD-L1-HERRAMIENTAS DE MARKETING DIGITAL', 6),
(82, 'ITSI-MD-L2-UTILIZACIÓN DE DATOS DIGITALES', 6),
(83, 'ITSI-MD-L3-COMPORTAMIENTO DE CONSUMIDOR', 6),
(84, 'ITSI-MD-L4- TENDENCIAS DEL COMERCIO ELECTRÓNICO', 6),
(85, 'ITSI-MD-L5-ESTRATEGIAS DE MARKETING PARA AUMENTAR LAS VENTAS', 6),
(86, 'ITSI-A-L1-EMPRENDIMIENTO', 5),
(87, 'ITSI-A-L2-LIDERAZGO EMPRESARIAL', 5),
(88, 'ITSI-A-L3-ESTRATEGIAS DE MARKETING', 5),
(89, 'ITSI-A-L4-HERRAMIENTAS DE ANÁLISIS DE DATOS PARA LA TOMA DE DECISIONES EMPRESARIALES', 5),
(90, 'ITSI-A-L5-GESTIÓN FINANCIERA PARA LA SOSTENIBILIDAD DE EMPRESAS', 5),
(91, 'ITSI-A-L6-GESTIÓN DE OPERACIONES', 5),
(92, 'ITSI-A-L7-PLANIFICACIÓN ESTRATÉGICA', 5),
(93, 'ITSI-A-L8-PLANIFICACIÓN FINANCIERA', 5),
(94, 'ITSI-AM-L1-LA GERONTOLOGÍA ANILIZADA Y EXPLICADA INTERDISCIPLINARIAMENTE DESDE LA COMPLEJIDAD DE LOS PROCESOS DE ENVEJECIMIENTO DEL SER HUMANO', 8),
(95, 'ITSI-AM-L2-INCLUSIÓN DE LAS PERSONAS DE LA TERCERA EDAD EN FUNCIÓN DE LA PARTICIPACIÓN Y APORTE A LA SOCIEDAD EN DIFERENTES ESPACIOS PRODUCTIVOS', 8),
(96, 'ITSI-AM-L3-RECONOCIMIENTO DE LOS DERECHOS DEL ADULTO MAYOR DESDE LAS POLÍTICAS Y PROYECTOS GUBERNAMENTALES.', 8),
(97, 'ITSI-AM-L4-VULNERABILIDAD DE DERECHOS', 8),
(98, 'ITSI-AM-L5-SALUD INTEGRAL DEL ADULTO-MAYOR', 8),
(99, 'ITSI-AM-L6-INCLUSIÓN DEL ADULTO MAYOR', 8),
(100, 'ITSI-AM-L17-CONDICIONES DE DESARROLLO DE LAS PERSONAS A-M', 8),
(101, 'ITSI-AM-L8-ADULTOS MAYORES Y PRODUCTIVIDAD', 8),
(102, 'ITSI-AM-L9-ADULTOS MAYORES Y POLÍTICAS PÚBLICAS', 8),
(103, 'ITSI-AM-L10-ATENCIÓN A PERSONAS A-M', 8);

-- --------------------------------------------------------

--
-- Table structure for table `meses`
--

CREATE TABLE `meses` (
  `id` int(11) NOT NULL,
  `mes` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meses`
--

INSERT INTO `meses` (`id`, `mes`) VALUES
(1, 'Enero'),
(2, 'Febrero'),
(3, 'Marzo'),
(4, 'Abril'),
(5, 'Mayo'),
(6, 'Junio'),
(7, 'Julio'),
(8, 'Agosto'),
(9, 'Septiembre'),
(10, 'Octubre'),
(11, 'Noviembre'),
(12, 'Diciembre');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2024-11-06-205343', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1730927384, 1),
(2, '2024-11-06-205450', 'App\\Database\\Migrations\\CreateCategoriesTable', 'default', 'App', 1730927384, 1),
(3, '2024-11-06-205530', 'App\\Database\\Migrations\\CreateCareersTable', 'default', 'App', 1730927384, 1),
(4, '2024-11-06-205654', 'App\\Database\\Migrations\\CreateAcademicPeriodsTable', 'default', 'App', 1730927384, 1),
(5, '2024-11-06-205723', 'App\\Database\\Migrations\\CreateDocumentsTable', 'default', 'App', 1730927384, 1);

-- --------------------------------------------------------

--
-- Table structure for table `participantes`
--

CREATE TABLE `participantes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cedula` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pis_docentes`
--

CREATE TABLE `pis_docentes` (
  `id` int(11) NOT NULL,
  `proyecto_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pis_docentes`
--

INSERT INTO `pis_docentes` (`id`, `proyecto_id`, `docente_id`, `created_at`) VALUES
(56, 54, 30, '2025-02-12 21:14:37'),
(57, 54, 32, '2025-02-12 21:14:37'),
(60, 56, 31, '2025-02-12 21:24:11'),
(61, 56, 33, '2025-02-12 21:24:11'),
(62, 57, 34, '2025-02-13 14:45:34');

-- --------------------------------------------------------

--
-- Table structure for table `pis_estudiantes`
--

CREATE TABLE `pis_estudiantes` (
  `id` int(11) NOT NULL,
  `proyecto_id` int(11) NOT NULL,
  `estudiante_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pis_estudiantes`
--

INSERT INTO `pis_estudiantes` (`id`, `proyecto_id`, `estudiante_id`, `created_at`) VALUES
(53, 56, 42, '2025-02-12 21:24:11'),
(54, 56, 43, '2025-02-12 21:24:11'),
(55, 57, 44, '2025-02-13 14:45:34'),
(56, 57, 45, '2025-02-13 14:45:34');

-- --------------------------------------------------------

--
-- Table structure for table `produccion_cientifica_tecnica`
--

CREATE TABLE `produccion_cientifica_tecnica` (
  `id` int(11) NOT NULL,
  `tipo` enum('Artículo','Capítulo de Libro','Libro','Otro') NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `titulo` text NOT NULL,
  `fecha_publicacion` date NOT NULL,
  `campo_amplio_id` int(11) NOT NULL,
  `campo_especifico_id` int(11) NOT NULL,
  `campo_detallado_id` int(11) NOT NULL,
  `filiacion` enum('Sí','No') NOT NULL,
  `tipo_articulo` enum('Revista','Memoria de evento científico') DEFAULT NULL,
  `base_datos_id` int(11) DEFAULT NULL,
  `codigo_issn` varchar(50) DEFAULT NULL,
  `nombre_revista` text DEFAULT NULL,
  `estado` enum('Publicado','Aceptado para publicación') DEFAULT NULL,
  `link_publicacion` text DEFAULT NULL,
  `link_revista` text DEFAULT NULL,
  `intercultural` enum('Sí','No','No Registra') DEFAULT NULL,
  `titulo_libro` text DEFAULT NULL,
  `total_capitulos_libro` int(11) DEFAULT NULL,
  `codigo_capitulo_isbn` varchar(50) DEFAULT NULL,
  `editor_copilador` varchar(255) DEFAULT NULL,
  `paginas` varchar(50) DEFAULT NULL,
  `codigo_libro_isbn` varchar(50) DEFAULT NULL,
  `revisado_pares` enum('Sí','No') DEFAULT NULL,
  `tipo_apoyo_ies` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produccion_participantes`
--

CREATE TABLE `produccion_participantes` (
  `id` int(11) NOT NULL,
  `produccion_id` int(11) NOT NULL,
  `participante_id` int(11) NOT NULL,
  `tipo` enum('Autor','Coautor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programas`
--

CREATE TABLE `programas` (
  `id` int(11) NOT NULL,
  `nombre_programa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programas`
--

INSERT INTO `programas` (`id`, `nombre_programa`) VALUES
(1, 'Programa de Vinculación con la Sociedad'),
(2, 'Programa de fomento a la investigación'),
(3, 'Programa de desarrollo de redes internas y externas'),
(4, 'Programa de investigación continua en el ámbito de la investigación técnica y tecnológica para el desarrollo'),
(5, 'Programa de iniciación en la investigación');

-- --------------------------------------------------------

--
-- Table structure for table `proyectos_integradores_saberes`
--

CREATE TABLE `proyectos_integradores_saberes` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `tipo` enum('Investigación','Vinculación','Investigación y Vinculación') NOT NULL,
  `objetivo` text NOT NULL,
  `programa_id` int(11) DEFAULT NULL,
  `estado` enum('Finalizado','En Cierre','En Ejecución','Detenido','Cancelado') NOT NULL,
  `linea_investigacion_carrera_id` int(11) DEFAULT NULL,
  `facultad_entidad_area` varchar(255) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `coordinador_director` varchar(255) NOT NULL,
  `fecha_fin_planificado` date NOT NULL,
  `correo_coordinador` varchar(100) NOT NULL,
  `fecha_fin_real` date DEFAULT NULL,
  `telefono_coordinador` int(11) NOT NULL,
  `campo_amplio_id` int(11) DEFAULT NULL,
  `campo_especifico_id` int(11) DEFAULT NULL,
  `campo_detallado_id` int(11) DEFAULT NULL,
  `alcance_territorial` enum('Cantonal','Institucional','Internacional','Nacional','Parroquial','Provincial') NOT NULL,
  `investigadores_acreditados` enum('Si','No') NOT NULL,
  `impacto_social` text DEFAULT NULL,
  `impacto_cientifico` text DEFAULT NULL,
  `impacto_economico` text DEFAULT NULL,
  `impacto_politico` text DEFAULT NULL,
  `impacto_ambiental` text DEFAULT NULL,
  `otro_impacto` text DEFAULT NULL,
  `fuente_financiamiento` enum('Asignación Regular IES','Fondos Concursables Interno IES','Fondos Concursables Nacionales','Fondos Concursables Internacionales','Fondos No Concursables Internacionales','Fondos No Concursables Nacionales Externos a la IES','Otros') NOT NULL,
  `descripcion_actividad` text NOT NULL,
  `parametro_cumplimiento` enum('Gasto Interno','Gasto Externo','Gasto de Capital','Gasto Interno Bruto en I + D + I','Gasto Nacional Bruto en I + D + I','Créditos Presupuestarios Públicos en I + D + I','Costos Salariales Personal  I +D + I') NOT NULL,
  `cooperacion` enum('Internacional','Nacional','Internacional y Nacional','No Aplica') NOT NULL,
  `red` enum('Internacional','Nacional','Internacional y Nacional','No Aplica') NOT NULL,
  `resultados_verificables` enum('Totales','Parciales','Sin Resultados') NOT NULL,
  `anio` int(4) NOT NULL,
  `presupuesto_planificado` decimal(10,2) NOT NULL,
  `presupuesto_ejecutado` decimal(10,2) NOT NULL,
  `tipo_participante` enum('Docente','Estudiante','Docente/Estudiante') NOT NULL,
  `horas` int(11) NOT NULL,
  `publicaciones_id` int(11) DEFAULT NULL,
  `proyecto_path` varchar(255) DEFAULT NULL,
  `poster_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proyectos_integradores_saberes`
--

INSERT INTO `proyectos_integradores_saberes` (`id`, `nombre`, `codigo`, `tipo`, `objetivo`, `programa_id`, `estado`, `linea_investigacion_carrera_id`, `facultad_entidad_area`, `fecha_inicio`, `coordinador_director`, `fecha_fin_planificado`, `correo_coordinador`, `fecha_fin_real`, `telefono_coordinador`, `campo_amplio_id`, `campo_especifico_id`, `campo_detallado_id`, `alcance_territorial`, `investigadores_acreditados`, `impacto_social`, `impacto_cientifico`, `impacto_economico`, `impacto_politico`, `impacto_ambiental`, `otro_impacto`, `fuente_financiamiento`, `descripcion_actividad`, `parametro_cumplimiento`, `cooperacion`, `red`, `resultados_verificables`, `anio`, `presupuesto_planificado`, `presupuesto_ejecutado`, `tipo_participante`, `horas`, `publicaciones_id`, `proyecto_path`, `poster_path`, `created_at`, `updated_at`) VALUES
(54, 'Prueba 1', '100117', 'Vinculación', 'afsadf', 2, 'En Cierre', 60, 'Software', '2025-02-14', 'Aprender y desarrollar nuevas habilidades puede ser un desafío emocionante. La clave está en establecer metas claras, organizar el tiempo, ser constante y buscar recursos adecuados. La práctica diaria asegura el éxito en cualquier actividad que deseas', '2025-02-21', 'bismuto7@gmail.com', '2025-01-31', 1234566789, NULL, NULL, NULL, 'Nacional', 'Si', NULL, NULL, NULL, NULL, NULL, NULL, 'Asignación Regular IES', 'kkjkj', 'Gasto Nacional Bruto en I + D + I', 'Nacional', 'Nacional', 'Totales', 2025, 55.00, 55.00, 'Docente', 55, NULL, NULL, NULL, '2025-02-12 20:56:51', '2025-02-12 21:14:37'),
(55, 'Prueba 2', '100117', 'Vinculación', 'adsfa', 1, 'En Cierre', 62, 'adsf', '2025-02-12', 'adsf', '2025-02-12', 'bismuto7@gmail.com', '2025-02-12', 1234567896, NULL, NULL, NULL, 'Internacional', 'Si', NULL, NULL, NULL, NULL, NULL, NULL, 'Fondos Concursables Nacionales', 'asdf', 'Gasto Interno', 'Nacional', 'Internacional y Nacional', 'Parciales', 2025, 55.00, 55.00, 'Estudiante', 55, NULL, NULL, NULL, '2025-02-12 20:58:24', '2025-02-12 21:17:07'),
(56, 'Prueba 3', '100117', 'Investigación y Vinculación', 'asdfff', 1, 'En Cierre', 61, 'Software', '2025-02-12', 'Morales', '2025-02-12', 'bismuto7@gmail.com', '2025-02-12', 1234567896, NULL, NULL, NULL, 'Nacional', 'Si', NULL, NULL, NULL, NULL, NULL, NULL, 'Fondos Concursables Interno IES', 'asdff', 'Gasto de Capital', 'Internacional', 'Nacional', 'Parciales', 2025, 55.00, 55.00, 'Docente/Estudiante', 55, NULL, NULL, NULL, '2025-02-12 21:01:02', '2025-02-12 21:24:11'),
(57, 'DISEÑO Y DESARROLLO DE UN SISTEMA WEB PARA ADMINISTRAR UNA TIENDA DE ZAPATOS DE FORMA MÁS RÁPIDA Y EFICIENTE', '100117', 'Investigación', 'Desarrollar un sistema web de gestión integral, mediante la utilización de herramientas tecnológicas modernas, para optimizar los procesos clave y mejorar su eficiencia operativa y toma de decisiones, para la zapatería “Calzado Americano” de la ciudad de Pimampiro.', 2, 'Finalizado', 58, 'Software', '2024-04-18', 'Diego Salgado', '2024-09-12', 'diegosalgado@hotmail.com', '2024-09-15', 1234567896, 8, 17, 50, 'Cantonal', 'No', 'Impulsar las ventas de un negocio.', 'Reforzar los conocimientos en investigacion de los estudiantes.', 'Incrementa las ventas del negocio y reduce compras erroneas.', 'Mejorar la reputacion del instituto.', 'Reduccion del uso de papel.', 'Cumplir con la malla.', 'Asignación Regular IES', 'Reforzar los conocimientos de los estudiantes en investigacion mediante un pis.', 'Gasto Interno', 'No Aplica', 'No Aplica', 'Sin Resultados', 2025, 555.00, 600.00, 'Docente/Estudiante', 90, NULL, 'uploads/proyectos_integradores_saberes/proyectos/1739457933_d24e4a93dc7742d2914c.docx', 'uploads/proyectos_integradores_saberes/posters/1739457933_345a47eb222d4c1533fc.pptx', '2025-02-13 14:45:33', '2025-02-13 14:45:33');

-- --------------------------------------------------------

--
-- Table structure for table `trabajos_de_titulacion`
--

CREATE TABLE `trabajos_de_titulacion` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `linea_investigacion` varchar(255) DEFAULT NULL,
  `autores` varchar(255) NOT NULL,
  `resumen` text NOT NULL,
  `documento_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `career_id` int(11) NOT NULL,
  `academic_period_id` int(11) NOT NULL,
  `mes_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trabajos_de_titulacion`
--

INSERT INTO `trabajos_de_titulacion` (`id`, `titulo`, `linea_investigacion`, `autores`, `resumen`, `documento_path`, `created_at`, `updated_at`, `career_id`, `academic_period_id`, `mes_id`, `year_id`) VALUES
(5, 'Desarrollo e implementación de un sistema de Control de Asistencia Laboral en la empresa W==F=BER', 'Desarrollo de Software', 'Cacuango Pabón Diego Alexander', 'W==F=BER, una empresa de internet en Ecuador, enfrentaba problemas en la gestión de asistencias debido a la falta de un sistema automatizado. Se desarrolló un sistema de control de asistencias con C# y SQL Server para mejorar la gestión del tiempo laboral. El sistema mejoró la precisión del registro de asistencias y la eficiencia laboral, optimizando la asignación de tareas y el seguimiento del personal.', 'uploads/trabajos_titulacion/2025/01/1736814136_2115bcc3fa6010aaa35f.pdf', '2025-01-14 00:22:16', '2025-01-14 00:22:16', 1, 1, 7, 1),
(6, 'Desarrollo de un Sistema para Gestionar el Programa de Participación Estudiantil Extracurricular PPE en la Unidad Educativa Fiscomisional Inocencio Jácome', 'Desarrollo de software', 'Brandon Steeven Almachi Villagómez, Marco Said Bonilla Yépez', 'La Unidad Educativa Fiscomisional Inocencio Jácome en Ecuador enfrenta desafíos al gestionar el Programa de Participación Estudiantil (PPE) debido a la falta de una plataforma centralizada. Se propone implementar un Sistema de Gestión de Relaciones con Clientes (CRM) adaptado para mejorar la coordinación, comunicación y eficiencia. El objetivo es implementar un sistema que cumpla con la normativa educativa y mejore la gestión del PPE.', 'uploads/trabajos_titulacion/2025/01/1736814168_dcd740afc7c6b3728e47.pdf', '2025-01-14 00:22:48', '2025-01-14 00:22:48', 1, 1, 7, 1),
(7, 'Desarrollo del sistema de control de nivel de agua y PH para reservorios y fumigación de cultivos (Finca Floricola Fragrances of Roses)', 'Innovación tecnológica y negocios', 'Lucero Pujota Kevin Joel', 'El sistema de control del nivel de agua y monitoreo del pH aborda la falta de mediciones precisas en la fumigación agrícola, lo que puede llevar a un uso ineficiente de productos químicos y contaminación ambiental. La medición precisa es esencial para adaptar las prácticas de fumigación y garantizar la eficacia de los tratamientos fitosanitarios, especialmente en regiones con acceso limitado a agua de calidad.', 'uploads/trabajos_titulacion/2025/01/1736814193_6d1d6b8bf9f6f47a7434.pdf', '2025-01-14 00:23:13', '2025-01-14 00:23:13', 1, 1, 7, 1),
(9, 'Desarrollo de una aplicación móvil con implementación de un método de pago electrónico para automatizar el servicio de pago de transporte terrestre urbano en la Cooperativa San Miguel de Ibarra', 'Aplicaciones tecnológicas para el desarrollo', 'Durán Rosero Lucía Monserat, Collaguazo Toala Steven Anibal', 'La implementación de un método de pago electrónico en el transporte urbano busca mejorar la comodidad y eficiencia de los pasajeros de autobuses. La aplicación móvil innovadora desarrollada para la cooperativa de transporte urbano San Miguel utiliza códigos QR para ofrecer un pago electrónico eficiente y reducir el uso de efectivo, optimizando el tiempo del usuario.', 'uploads/trabajos_titulacion/2025/01/1737119125_e4cc1a6d58873db4aa4c.pdf', '2025-01-17 13:05:25', '2025-01-17 13:05:25', 1, 1, 7, 1),
(10, 'ANÁLISIS GEOGRÁFICO DE SENDEROS MONTAÑOSOS EN EL DEPORTE ENDURO VALLE DEL CHOTA-IMBABURA', 'Comunicación Visual', 'Almeida Morán Alexis Gustavo, Ortega Barrera Anderson Eduardo', 'El Valle del Chota, ubicado en la región de Aloburo-Ambuquí, alberga una diversidad de senderos montañosos ideales para la práctica del motociclismo enduro. Sin embargo, la falta de un sistema de señalización adecuado en estos senderos representa un desafío para la seguridad de los deportistas y la conservación del medio ambiente.', 'uploads/trabajos_titulacion/2025/01/1737303759_5afa1fbea5a85f84ad84.pdf', '2025-01-19 16:22:39', '2025-01-19 16:24:28', 2, 1, 7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@itsi.edu.ec', '$2y$10$EwqID0p6UVxwgW9OxE2jyO0t6qePe9HpKyTJuJ2U5QT03mMVD1KaW', 'Administrador', '2024-11-06 09:17:45', '2024-11-06 22:33:07');

-- --------------------------------------------------------

--
-- Table structure for table `year`
--

CREATE TABLE `year` (
  `id` int(11) NOT NULL,
  `anio` int(4) NOT NULL CHECK (`anio` >= 1000 and `anio` <= 9999),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `year`
--

INSERT INTO `year` (`id`, `anio`, `created_at`, `updated_at`) VALUES
(1, 2024, '2024-11-18 21:20:01', '2024-11-18 21:20:01'),
(2, 2025, '2024-11-19 03:32:33', '2024-11-19 03:32:33'),
(3, 2023, '2025-01-14 00:25:14', '2025-01-14 00:25:14'),
(4, 2026, '2025-01-19 16:24:28', '2025-01-19 16:24:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_periods`
--
ALTER TABLE `academic_periods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_academic_periods_dates` (`start_date`,`end_date`);

--
-- Indexes for table `base_datos_indexada`
--
ALTER TABLE `base_datos_indexada`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campo_amplio`
--
ALTER TABLE `campo_amplio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campo_detallado`
--
ALTER TABLE `campo_detallado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_especifico` (`especifico_id`);

--
-- Indexes for table `campo_especifico`
--
ALTER TABLE `campo_especifico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_amplio` (`amplio_id`);

--
-- Indexes for table `careers`
--
ALTER TABLE `careers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_cedula` (`cedula`),
  ADD KEY `idx_nombre` (`nombre`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_documents_title` (`title`);

--
-- Indexes for table `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_cedula` (`cedula`),
  ADD KEY `idx_nombre` (`nombre`);

--
-- Indexes for table `lineas_investigacion_carreras`
--
ALTER TABLE `lineas_investigacion_carreras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_carrera` (`carrera_id`);

--
-- Indexes for table `meses`
--
ALTER TABLE `meses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pis_docentes`
--
ALTER TABLE `pis_docentes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_proyecto_docente` (`proyecto_id`,`docente_id`),
  ADD KEY `fk_pis_docentes_docente` (`docente_id`);

--
-- Indexes for table `pis_estudiantes`
--
ALTER TABLE `pis_estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_proyecto_estudiante` (`proyecto_id`,`estudiante_id`),
  ADD KEY `fk_pis_estudiantes_estudiante` (`estudiante_id`);

--
-- Indexes for table `produccion_cientifica_tecnica`
--
ALTER TABLE `produccion_cientifica_tecnica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campo_amplio_id` (`campo_amplio_id`),
  ADD KEY `campo_especifico_id` (`campo_especifico_id`),
  ADD KEY `campo_detallado_id` (`campo_detallado_id`),
  ADD KEY `base_datos_id` (`base_datos_id`);

--
-- Indexes for table `produccion_participantes`
--
ALTER TABLE `produccion_participantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_produccion_participante` (`produccion_id`,`participante_id`),
  ADD KEY `participante_id` (`participante_id`);

--
-- Indexes for table `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proyectos_integradores_saberes`
--
ALTER TABLE `proyectos_integradores_saberes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_programa` (`programa_id`),
  ADD KEY `idx_linea_investigacion` (`linea_investigacion_carrera_id`),
  ADD KEY `idx_campo_amplio` (`campo_amplio_id`),
  ADD KEY `idx_campo_especifico` (`campo_especifico_id`),
  ADD KEY `idx_campo_detallado` (`campo_detallado_id`),
  ADD KEY `idx_publicaciones` (`publicaciones_id`);

--
-- Indexes for table `trabajos_de_titulacion`
--
ALTER TABLE `trabajos_de_titulacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_career` (`career_id`),
  ADD KEY `idx_academic_period` (`academic_period_id`),
  ADD KEY `idx_mes` (`mes_id`),
  ADD KEY `idx_year` (`year_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `year`
--
ALTER TABLE `year`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_periods`
--
ALTER TABLE `academic_periods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `base_datos_indexada`
--
ALTER TABLE `base_datos_indexada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `campo_amplio`
--
ALTER TABLE `campo_amplio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `campo_detallado`
--
ALTER TABLE `campo_detallado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `campo_especifico`
--
ALTER TABLE `campo_especifico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `careers`
--
ALTER TABLE `careers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `lineas_investigacion_carreras`
--
ALTER TABLE `lineas_investigacion_carreras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `meses`
--
ALTER TABLE `meses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pis_docentes`
--
ALTER TABLE `pis_docentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `pis_estudiantes`
--
ALTER TABLE `pis_estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `produccion_cientifica_tecnica`
--
ALTER TABLE `produccion_cientifica_tecnica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produccion_participantes`
--
ALTER TABLE `produccion_participantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programas`
--
ALTER TABLE `programas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `proyectos_integradores_saberes`
--
ALTER TABLE `proyectos_integradores_saberes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `trabajos_de_titulacion`
--
ALTER TABLE `trabajos_de_titulacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `year`
--
ALTER TABLE `year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `campo_detallado`
--
ALTER TABLE `campo_detallado`
  ADD CONSTRAINT `fk_campo_detallado_especifico` FOREIGN KEY (`especifico_id`) REFERENCES `campo_especifico` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `campo_especifico`
--
ALTER TABLE `campo_especifico`
  ADD CONSTRAINT `fk_campo_especifico_amplio` FOREIGN KEY (`amplio_id`) REFERENCES `campo_amplio` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `lineas_investigacion_carreras`
--
ALTER TABLE `lineas_investigacion_carreras`
  ADD CONSTRAINT `fk_linea_carrera` FOREIGN KEY (`carrera_id`) REFERENCES `careers` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `pis_docentes`
--
ALTER TABLE `pis_docentes`
  ADD CONSTRAINT `fk_pis_docentes_docente` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pis_docentes_proyecto` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos_integradores_saberes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pis_estudiantes`
--
ALTER TABLE `pis_estudiantes`
  ADD CONSTRAINT `fk_pis_estudiantes_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pis_estudiantes_proyecto` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos_integradores_saberes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produccion_cientifica_tecnica`
--
ALTER TABLE `produccion_cientifica_tecnica`
  ADD CONSTRAINT `produccion_cientifica_tecnica_ibfk_1` FOREIGN KEY (`campo_amplio_id`) REFERENCES `campo_amplio` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `produccion_cientifica_tecnica_ibfk_2` FOREIGN KEY (`campo_especifico_id`) REFERENCES `campo_especifico` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `produccion_cientifica_tecnica_ibfk_3` FOREIGN KEY (`campo_detallado_id`) REFERENCES `campo_detallado` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `produccion_cientifica_tecnica_ibfk_4` FOREIGN KEY (`base_datos_id`) REFERENCES `base_datos_indexada` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `produccion_participantes`
--
ALTER TABLE `produccion_participantes`
  ADD CONSTRAINT `produccion_participantes_ibfk_1` FOREIGN KEY (`produccion_id`) REFERENCES `produccion_cientifica_tecnica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produccion_participantes_ibfk_2` FOREIGN KEY (`participante_id`) REFERENCES `participantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `proyectos_integradores_saberes`
--
ALTER TABLE `proyectos_integradores_saberes`
  ADD CONSTRAINT `fk_pis_campo_amplio` FOREIGN KEY (`campo_amplio_id`) REFERENCES `campo_amplio` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pis_campo_detallado` FOREIGN KEY (`campo_detallado_id`) REFERENCES `campo_detallado` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pis_campo_especifico` FOREIGN KEY (`campo_especifico_id`) REFERENCES `campo_especifico` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pis_linea_investigacion` FOREIGN KEY (`linea_investigacion_carrera_id`) REFERENCES `lineas_investigacion_carreras` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pis_produccion_cientifica` FOREIGN KEY (`publicaciones_id`) REFERENCES `produccion_cientifica_tecnica` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pis_programa` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `trabajos_de_titulacion`
--
ALTER TABLE `trabajos_de_titulacion`
  ADD CONSTRAINT `fk_tdt_academic_period` FOREIGN KEY (`academic_period_id`) REFERENCES `academic_periods` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tdt_career` FOREIGN KEY (`career_id`) REFERENCES `careers` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tdt_mes` FOREIGN KEY (`mes_id`) REFERENCES `meses` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tdt_year` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
