-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2025 at 07:17 AM
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
(1, 'Desarrollo de Software', '2024-11-06 09:17:45'),
(2, 'Diseño Gráfico', '2024-11-06 09:17:45'),
(3, 'Desarrollo y Análisis de Software - Modalidad Virtual', '2024-11-21 00:06:34'),
(4, 'Atención Integral a Adultos Mayores', '2024-11-21 00:06:34'),
(5, 'Administración', '2024-11-21 00:06:34'),
(6, 'Marketing Digital y Comercio Electrónico', '2024-11-21 00:06:34'),
(7, 'Redes y Telecomunicaciones', '2024-11-21 00:06:34');

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
(1, 'Desarrollo de software', 1),
(2, 'Innovación tecnológica y negocios', 1),
(3, 'Aplicaciones tecnológicas para el desarrollo', 1),
(4, 'Administración y seguridad de las bases de datos', 1),
(5, 'Administración y auditoria de hardware', 1),
(6, 'Redes y telecomunicaciones en la producción de bienes y servicios', 1),
(7, 'Metodologías para el desarrollo de software', 1),
(8, 'Desarrollo tecnológico y sociedad', 1),
(9, 'Fundamentos del diseño', 2),
(10, 'Software y autoedición', 2),
(11, 'Comunicación visual', 2),
(12, 'Marketing integral', 2),
(13, 'Diseño web para el desarrollo', 2),
(14, 'Innovación tecnológica en Marketing Digital', 2),
(15, 'Internet y redes de nueva generación', 7),
(16, 'Sistemas de trasmisión', 7),
(17, 'Comunicaciones ópticas', 7),
(18, 'Redes inteligentes y servicios avanzados de telecomunicación', 7),
(19, 'Procesamiento digital de señales e imágenes en comunicación', 7),
(20, 'Comunicaciones ópticas de alta velocidad', 7),
(21, 'Herramientas de marketing digital', 6),
(22, 'Utilización de datos digitales', 6),
(23, 'Comportamiento del consumidor', 6),
(24, 'Tendencias del comercio electrónico', 6),
(25, 'Estrategias de marketing para aumentar las ventas', 6),
(26, 'Vulnerabilidad de derechos', 4),
(27, 'Salud integral del adulto-mayor', 4),
(28, 'Inclusión del adulto mayor', 4),
(29, 'Condiciones de desarrollo de las personas A-M', 4),
(30, 'Adultos mayores y productividad', 4),
(31, 'Adultos mayores y políticas públicas', 4),
(32, 'Atención a personas A-M', 4);

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
-- Table structure for table `produccion_cientifica_tecnica`
--

CREATE TABLE `produccion_cientifica_tecnica` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produccion_cientifica_tecnica`
--

INSERT INTO `produccion_cientifica_tecnica` (`id`, `nombre`) VALUES
(1, 'Impacto de las Metodologías Ágiles en el Desarrollo de Software en Institutos Tecnológicos Superiores del Ecuador'),
(2, 'Análisis del uso de herramientas de marketing digital en las PYMES de la región norte del Ecuador'),
(3, 'Estudio sobre la implementación de redes de sensores IoT para el monitoreo ambiental en zonas urbanas');

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
(2, 'Programa de relaciones interinstitucionales');

-- --------------------------------------------------------

--
-- Table structure for table `proyectos_integradores_saberes`
--

CREATE TABLE `proyectos_integradores_saberes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `tipo` enum('Investigación','Vinculación','Investigación y Vinculación') NOT NULL,
  `objetivo` varchar(255) NOT NULL,
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
  `impacto_social` varchar(255) DEFAULT NULL,
  `impacto_cientifico` varchar(255) DEFAULT NULL,
  `impacto_economico` varchar(255) DEFAULT NULL,
  `impacto_politico` varchar(255) DEFAULT NULL,
  `impacto_ambiental` varchar(255) DEFAULT NULL,
  `otro_impacto` varchar(255) DEFAULT NULL,
  `fuente_financiamiento` enum('Asignación Regular IES','Fondos Concursables Interno IES','Fondos Concursables Nacionales','Fondos Concursables Internacionales','Fondos No Concursables Internacionales','Fondos No Concursables Nacionales Externos a la IES','Otros') NOT NULL,
  `descripcion_actividad` varchar(255) NOT NULL,
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
(6, 'Creacion de una aplicacion web para manejar la caja y el inventario de una tienda de zapatos', '100117', 'Investigación', 'Aprender y desarrollar nuevas habilidades puede ser un desafío emocionante. La clave está en establecer metas claras, organizar el tiempo, ser constante y buscar recursos adecuados. La práctica diaria asegura el éxito en cualquier actividad que deseas', 1, 'En Ejecución', 10, 'Aprender y desarrollar nuevas habilidades puede ser un desafío emocionante. La clave está en establecer metas claras, organizar el tiempo, ser constante y buscar recursos adecuados. La práctica diaria asegura el éxito en cualquier actividad que deseas', '2024-04-10', 'Aprender y desarrollar nuevas habilidades puede ser un desafío emocionante. La clave está en establecer metas claras, organizar el tiempo, ser constante y buscar recursos adecuados. La práctica diaria asegura el éxito en cualquier actividad que deseas', '2024-08-20', 'bismuto7@gmail.com', '2024-08-20', 983104196, 13, 30, 99, 'Cantonal', 'No', 'Aprender y desarrollar nuevas habilidades puede ser un desafío emocionante. La clave está en establecer metas claras, organizar el tiempe y buscar recursos adecuados. La práctica diaria asegura el éxito en cualquier actividad que deseas', 'Aprendetasd que deseas', 'Aprender y desarrosafío emocionante. La clave está en establecer metas claras, organizar el tiempo, ser constante y buscar recursos adecuados. La práctica diaria asegura el éxito en cualquier actividad que deseas', 'Aprender y desarrollar nuevas habilidades puede ser un desafío emocionante. La clave está en establecer metas claras, organizar el tiempo, ser constante y buscar recursos adecuados. La práctica diaria asegura el éxito en cualquier actividad que deseas', 'Aprender y desarrollar nuevas hn desafío emocionante. La clave está en establecer metas claras, organizar el tiempo, ser constante y buscar recursos adecuados. La práctica diaria asegura el éxito en cualquier actividad que deseas', 'uno y dos', 'Asignación Regular IES', 'Aprender y desarrollar nuevas habilidades puede ser un desafío emocionante. La clave está en establecer metas claras, organizar el tiempo, ser constante y buscar recursos adecuados. La práctica diaria asegura el éxito en cualquier actividad que deseas', 'Gasto Interno', 'Nacional', 'No Aplica', 'Parciales', 2024, 100.00, 100.00, 'Estudiante', 60, 1, 'uploads/proyectos_integradores_saberes/proyectos/1738018390_1dacce217e2b84096198.docx', 'uploads/proyectos_integradores_saberes/posters/1738018390_ae15c17be825cade8997.pptx', '2025-01-27 22:50:36', '2025-01-28 05:48:11');

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
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_documents_title` (`title`);

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
-- Indexes for table `produccion_cientifica_tecnica`
--
ALTER TABLE `produccion_cientifica_tecnica`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lineas_investigacion_carreras`
--
ALTER TABLE `lineas_investigacion_carreras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
-- AUTO_INCREMENT for table `produccion_cientifica_tecnica`
--
ALTER TABLE `produccion_cientifica_tecnica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `programas`
--
ALTER TABLE `programas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `proyectos_integradores_saberes`
--
ALTER TABLE `proyectos_integradores_saberes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
