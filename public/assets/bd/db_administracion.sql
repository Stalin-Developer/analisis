-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 05:48 AM
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
(2, 'Diseño Gráfico', '2024-11-06 09:17:45');

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
-- Table structure for table `trabajos_de_titulacion`
--

CREATE TABLE `trabajos_de_titulacion` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `linea_investigacion` varchar(255) DEFAULT NULL,
  `autores` varchar(255) NOT NULL,
  `resumen` text NOT NULL,
  `documento_path` varchar(255) NOT NULL,
  `poster_path` varchar(255) DEFAULT NULL,
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

INSERT INTO `trabajos_de_titulacion` (`id`, `titulo`, `linea_investigacion`, `autores`, `resumen`, `documento_path`, `poster_path`, `created_at`, `updated_at`, `career_id`, `academic_period_id`, `mes_id`, `year_id`) VALUES
(2, 'Desarrollo de una Aplicación Web para la Presentación de Proyectos Arquitectónicos de la Empresa Arq. Ramiro Pantoja: Implementación de Laravel en la Creación de un Portafolio Web Dinámico y Actualizable', 'Desarrollo de Software', 'Calderón Pasquel Isaac Mateo', 'El propósito fundamental de este trabajo de titulación es la creación de un Portafolio Web destinado a la Empresa Arq. Ramiro Pantoja.', 'uploads/trabajos_titulacion/2024/11/1731985902_a910921452e9ef88c65e.pdf', NULL, '2024-11-19 03:11:43', '2024-11-19 03:33:06', 1, 1, 7, 1);

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
(2, 2025, '2024-11-19 03:32:33', '2024-11-19 03:32:33');

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
-- AUTO_INCREMENT for table `careers`
--
ALTER TABLE `careers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `trabajos_de_titulacion`
--
ALTER TABLE `trabajos_de_titulacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `year`
--
ALTER TABLE `year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

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
