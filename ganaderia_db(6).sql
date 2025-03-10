-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-03-2025 a las 10:54:52
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
-- Base de datos: `ganaderia_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animales`
--

CREATE TABLE `animales` (
  `id` int(11) NOT NULL,
  `arete_id` varchar(50) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `sexo` enum('Macho','Hembra') DEFAULT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `corral_actual` int(11) DEFAULT NULL,
  `estado_salud` enum('Sano','Enfermo','En tratamiento') DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_entrada` date NOT NULL,
  `padre` varchar(100) DEFAULT NULL,
  `madre` varchar(100) DEFAULT NULL,
  `raza` varchar(100) DEFAULT NULL,
  `fierro` varchar(50) DEFAULT NULL,
  `estado` enum('Viva','Muerta') DEFAULT 'Viva',
  `expectativa` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `lugar_nacimiento` varchar(100) DEFAULT NULL,
  `fecha_destete` date DEFAULT NULL,
  `tipo_alimentacion` varchar(50) DEFAULT NULL,
  `numero_partos` int(11) DEFAULT 0,
  `observaciones` text DEFAULT NULL,
  `vendido` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `animales`
--

INSERT INTO `animales` (`id`, `arete_id`, `fecha_nacimiento`, `color`, `sexo`, `peso`, `corral_actual`, `estado_salud`, `fecha_registro`, `fecha_entrada`, `padre`, `madre`, `raza`, `fierro`, `estado`, `expectativa`, `foto`, `lugar_nacimiento`, `fecha_destete`, `tipo_alimentacion`, `numero_partos`, `observaciones`, `vendido`) VALUES
(1, '46', '2007-04-17', 'Negro', 'Macho', 67.00, 1, 'Enfermo', '2025-02-26 13:58:20', '7666-06-17', NULL, NULL, NULL, NULL, 'Viva', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1),
(6, '4663', '2025-02-06', 'rosa', 'Hembra', 45.00, 1, 'En tratamiento', '2025-02-26 15:13:20', '2025-02-06', NULL, NULL, NULL, NULL, 'Viva', NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(8, '38', '2025-02-04', 'cafe', 'Macho', 45.00, 7, 'Sano', '2025-02-26 16:47:28', '2025-02-05', NULL, NULL, NULL, NULL, 'Viva', NULL, NULL, NULL, NULL, NULL, 0, NULL, 0),
(12, '56', '2025-02-12', 'Dorado', 'Macho', 34.00, 3, 'Sano', '2025-02-26 18:48:38', '2025-02-13', 'Gringo', 'Lechera', 'Thorffin', 'AZ', 'Viva', 'Reproducción', NULL, NULL, NULL, NULL, 0, NULL, 0),
(15, '67', '2025-02-08', 'Gris', 'Macho', 45.00, 6, 'En tratamiento', '2025-02-26 19:25:07', '2025-02-12', 'Ramiro', 'Corriente', 'Gringo', 'AZ', 'Viva', 'Lechera', NULL, 'Aqui', '2025-02-24', 'Pastoreo', 0, 'SI', 1),
(18, '6789', '2025-02-20', 'Negro', 'Hembra', 56.00, 5, 'Enfermo', '2025-02-26 19:48:28', '2025-02-21', 'Ramiro', 'Corriente', 'Griego', 'AZ', 'Viva', 'Reproducción', NULL, 'Aqui', '2025-02-27', 'Mixto', 0, 'Esta fina', 0),
(19, '999', '2025-02-20', 'Azul', 'Hembra', 56.00, 6, 'En tratamiento', '2025-02-26 20:05:46', '2025-02-21', 'Ramiro', 'Corriente', 'Griego', 'AZ', 'Viva', 'Reproducción', NULL, 'Aqui', '2025-02-22', 'Concentrado', 0, 'Esta bien', 0),
(20, '555', '2024-01-09', 'Verde', 'Macho', 90.00, 7, 'Sano', '2025-02-26 20:11:38', '2024-03-05', 'Ramiro', 'Lechera', 'Griego', 'ZAD', 'Viva', 'Reproducción', NULL, 'Aqui', '2024-03-06', 'Mixto', 0, 'Esta fino.', 0),
(21, '879', '2025-02-04', 'Azul', 'Macho', 45.00, 3, 'Sano', '2025-02-28 17:45:40', '2025-02-06', 'Felipe', 'Corriente', 'Gringo', 'WS', 'Viva', 'Engorda', NULL, 'Aqui', '2025-02-14', 'Mixto', 0, 'Esta fino', 0),
(22, '987', '2025-02-05', 'Verde', 'Hembra', 45.00, 5, 'Sano', '2025-02-28 18:00:15', '2025-02-05', 'Ramiro', 'Corriente', 'Gringo', 'FGC', 'Viva', 'Reproducción', NULL, 'Aqui', '2025-02-19', 'Pastoreo', 0, 'ESta bien', 0),
(23, '54', '2025-03-01', 'Rojo', 'Macho', 19.00, 1, 'Sano', '2025-03-02 03:44:08', '2025-03-01', 'Greogorio', 'Mana', 'Gringo', 'AZ', 'Viva', 'Engorda', NULL, 'Rodeo', '2025-03-20', 'Mixto', 0, 'Es un res tierno', 0),
(24, '567', '2025-02-12', 'Verde', 'Hembra', 58.00, NULL, 'En tratamiento', '2025-03-02 03:51:34', '2025-02-19', 'Rodrigo', 'Corriente', 'Cemental', 'df', 'Viva', 'Lechera', NULL, 'Aqui', '2025-03-01', '0', 0, 'Esta vivita', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animal_hato`
--

CREATE TABLE `animal_hato` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `hato_id` int(11) NOT NULL,
  `fecha_entrada` date NOT NULL,
  `fecha_salida` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones`
--

CREATE TABLE `asignaciones` (
  `id` int(11) NOT NULL,
  `trabajador_id` int(11) NOT NULL,
  `corral_id` int(11) DEFAULT NULL,
  `tarea` enum('Alimentación','Salud','Reproducción','Limpieza','Ventas','Transporte') DEFAULT NULL,
  `fecha_asignacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignaciones`
--

INSERT INTO `asignaciones` (`id`, `trabajador_id`, `corral_id`, `tarea`, `fecha_asignacion`) VALUES
(9, 1, 1, 'Reproducción', '2025-03-02'),
(33, 29, 6, 'Alimentación', '2025-03-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calidad_leche`
--

CREATE TABLE `calidad_leche` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `mun` decimal(4,2) DEFAULT NULL,
  `recuento_celulas_somaticas` int(11) DEFAULT NULL,
  `antibiotico_detectado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corrales`
--

CREATE TABLE `corrales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `capacidad_maxima` int(11) DEFAULT NULL,
  `arete_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `corrales`
--

INSERT INTO `corrales` (`id`, `nombre`, `capacidad_maxima`, `arete_id`) VALUES
(1, 'Corral 1', 20, NULL),
(2, 'Corral 2', 20, NULL),
(3, 'Corral 3', 20, NULL),
(4, 'Corral 4', 20, NULL),
(5, 'Corral 5', 20, NULL),
(6, 'Corral 6', 20, NULL),
(7, 'Corral 7', 20, NULL),
(8, 'Corral 8', 20, NULL),
(9, 'Corral 9', 20, NULL),
(10, 'Corral 10', 20, NULL),
(11, 'Corral 11', 20, NULL),
(12, 'Corral 12', 20, NULL),
(13, 'Corral 13', 20, NULL),
(14, 'Corral 14', 20, NULL),
(15, 'Corral 15', 20, NULL),
(16, 'Corral 16', 20, NULL),
(17, 'Corral 17', 20, NULL),
(18, 'Corral 18', 20, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costos`
--

CREATE TABLE `costos` (
  `id` int(11) NOT NULL,
  `concepto` varchar(100) NOT NULL,
  `tipo` enum('Alimentación','Salud','Reproducción','Mano de obra','Otros') DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `animal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `costos`
--

INSERT INTO `costos` (`id`, `concepto`, `tipo`, `monto`, `fecha`, `animal_id`) VALUES
(1, 'Venta', 'Mano de obra', 900.00, '2025-02-06', 1),
(4, 'Comida', 'Alimentación', 500.00, '2025-02-28', 1),
(5, 'Comida', 'Alimentación', 200.00, '2025-02-27', 1),
(6, 'Gripa', 'Salud', 400.00, '2025-02-28', 20),
(7, 'Limpiar el corral', 'Mano de obra', 300.00, '2025-02-20', 22),
(8, 'Baño', 'Mano de obra', 676.00, '2025-03-15', 22),
(9, 'Baño', 'Mano de obra', 500.00, '2025-03-01', 24),
(10, 'Venta', 'Mano de obra', 700.00, '2025-03-05', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `embriones`
--

CREATE TABLE `embriones` (
  `id` int(11) NOT NULL,
  `donadora_id` int(11) NOT NULL,
  `receptora_id` int(11) NOT NULL,
  `fecha_transferencia` date NOT NULL,
  `estado` enum('Congelado','Implantado','Descarte') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfermedades`
--

CREATE TABLE `enfermedades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` enum('Infecciosa','Metabólica','Parasitaria') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos_reproductivos`
--

CREATE TABLE `eventos_reproductivos` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `fecha_evento` date NOT NULL,
  `tipo` enum('Servicio','Inseminación','Diagnóstico de preñez','Parto','Aborto') NOT NULL,
  `toro_id` int(11) DEFAULT NULL,
  `metodo` enum('Monta natural','IATF','Transferencia de embriones') DEFAULT NULL,
  `resultado` enum('Exitosa','Fallida') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ganancia_peso`
--

CREATE TABLE `ganancia_peso` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `peso` decimal(5,2) NOT NULL,
  `ganancia_diaria` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ganancia_peso`
--

INSERT INTO `ganancia_peso` (`id`, `animal_id`, `fecha`, `peso`, `ganancia_diaria`) VALUES
(2, 1, '2025-02-28', 56.00, NULL),
(3, 1, '2025-02-15', 56.00, NULL),
(4, 22, '2025-03-12', 45.00, NULL),
(5, 1, '2025-03-01', 60.00, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hatos`
--

CREATE TABLE `hatos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `hatos`
--

INSERT INTO `hatos` (`id`, `nombre`, `descripcion`, `fecha_creacion`) VALUES
(1, 'Si', 'No se', '2025-02-28 14:50:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_medico`
--

CREATE TABLE `historial_medico` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `tipo` enum('Vacuna','Enfermedad','Tratamiento') DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_medico`
--

INSERT INTO `historial_medico` (`id`, `animal_id`, `fecha`, `tipo`, `descripcion`) VALUES
(1, 1, '2025-02-26', 'Vacuna', 'Esta enfermo de gripa'),
(2, 19, '2025-02-26', 'Vacuna', 'Vacuna para la gripa'),
(3, 20, '2025-02-10', 'Tratamiento', 'Recuperacion de gripa'),
(7, 22, '2025-03-07', 'Vacuna', 'Pa que se aliviane'),
(8, 22, '2025-03-07', 'Vacuna', 'Pa que se aliviane'),
(9, 22, '2025-03-11', 'Vacuna', 'Evitar enfermedades'),
(10, 1, '2025-03-07', 'Vacuna', 'Para la tos'),
(11, 24, '2025-03-01', 'Enfermedad', 'Tiene tos'),
(12, 1, '2025-03-05', 'Vacuna', 'Vacunas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_movimientos`
--

CREATE TABLE `historial_movimientos` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `tipo` enum('Cambio de corral','Venta','Traslado') DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_movimientos`
--

INSERT INTO `historial_movimientos` (`id`, `animal_id`, `fecha`, `tipo`, `descripcion`) VALUES
(1, 1, '2025-02-28', 'Venta', 'Va pal matadero'),
(2, 19, '2027-03-11', 'Traslado', 'Se cambia de hogar'),
(3, 20, '2025-08-22', 'Venta', 'Se va a vender'),
(6, 1, '2025-03-06', 'Venta', 'Se nos va :('),
(7, 22, '2025-02-20', 'Cambio de corral', 'Se nos va'),
(8, 22, '2025-03-15', 'Cambio de corral', 'Se va'),
(9, 24, '2025-03-05', 'Traslado', 'Cambio de corral por apareamiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_peso`
--

CREATE TABLE `historial_peso` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `peso` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_peso`
--

INSERT INTO `historial_peso` (`id`, `animal_id`, `fecha`, `peso`) VALUES
(1, 1, '2025-02-11', 30.00),
(2, 24, '2025-03-01', 56.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_reproductivo`
--

CREATE TABLE `historial_reproductivo` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `evento` enum('Parto','Preñez','Celo') DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `toro_nombre` varchar(100) DEFAULT NULL,
  `toro_raza` varchar(50) DEFAULT NULL,
  `estado` enum('completado','pendiente','cancelado') DEFAULT 'pendiente',
  `observaciones` text DEFAULT NULL,
  `fecha_confirmacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_reproductivo`
--

INSERT INTO `historial_reproductivo` (`id`, `animal_id`, `fecha`, `evento`, `descripcion`, `toro_nombre`, `toro_raza`, `estado`, `observaciones`, `fecha_confirmacion`) VALUES
(1, 1, '2025-02-26', '', 'Anda en su ciclo', NULL, NULL, 'pendiente', NULL, NULL),
(2, 1, '2025-02-25', '', 'Esta hot', NULL, NULL, 'pendiente', NULL, NULL),
(3, 19, '2025-02-10', 'Parto', 'Ya pario', NULL, NULL, 'pendiente', NULL, NULL),
(4, 20, '2025-02-25', '', 'Esta hot', NULL, NULL, 'pendiente', NULL, NULL),
(7, 1, '2025-02-06', '', 'Todo bien', 'Joaquin', 'Griego', 'completado', 'Esta chido', '2025-03-01'),
(8, 24, '2025-03-06', '', 'Si', 'Joaquin', 'Griego', 'pendiente', 'Esta pendiente', '2025-03-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `potreros`
--

CREATE TABLE `potreros` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `area` decimal(10,2) NOT NULL,
  `capacidad_maxima` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion_leche`
--

CREATE TABLE `produccion_leche` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `litros` decimal(5,2) NOT NULL,
  `grasa` decimal(4,2) DEFAULT NULL,
  `proteina` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `produccion_leche`
--

INSERT INTO `produccion_leche` (`id`, `animal_id`, `fecha`, `litros`, `grasa`, `proteina`) VALUES
(1, 1, '2025-02-20', 4.00, 0.02, 0.01),
(2, 22, '2025-03-01', 56.00, 56.00, 34.00),
(3, 24, '2025-03-04', 59.00, 56.00, 32.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyeccion_carne`
--

CREATE TABLE `proyeccion_carne` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `fecha_proyeccion` date NOT NULL,
  `peso_esperado` decimal(5,2) DEFAULT NULL,
  `precio_mercado` decimal(10,2) DEFAULT NULL,
  `costo_alimentacion` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_enfermedades`
--

CREATE TABLE `registro_enfermedades` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `enfermedad_id` int(11) NOT NULL,
  `fecha_diagnostico` date NOT NULL,
  `fecha_recuperacion` date DEFAULT NULL,
  `severidad` enum('Leve','Moderada','Grave') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rentabilidad`
--

CREATE TABLE `rentabilidad` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `costo_produccion` decimal(10,2) DEFAULT NULL,
  `ingreso_venta` decimal(10,2) DEFAULT NULL,
  `margen_bruto` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

CREATE TABLE `trabajadores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contrasena_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trabajadores`
--

INSERT INTO `trabajadores` (`id`, `nombre`, `contrasena_hash`) VALUES
(1, 'Ruperto Martinez', ''),
(29, 'Ruben', ''),
(30, 'Carlos', ''),
(31, 'Jaun', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `rol` enum('admin','empleado') DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `contrasena_hash` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `rol`, `usuario`, `contrasena_hash`) VALUES
(1, 'Admin', 'admin', 'admin', '$2y$10$KRomKNm.932Oe6JfwNUB8eaob/8cTN1wSImjHk.I9ESVnjPLl/Q9i');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `trabajador_id` int(11) NOT NULL,
  `fecha_venta` date NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `comprador` varchar(100) DEFAULT NULL,
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta','Cheque') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `animal_id`, `trabajador_id`, `fecha_venta`, `precio`, `comprador`, `metodo_pago`) VALUES
(3, 1, 1, '2025-03-05', 7000.00, 'Jesus', 'Efectivo'),
(4, 15, 29, '2025-03-07', 9000.00, 'Cesat', 'Tarjeta');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `animales`
--
ALTER TABLE `animales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `arete_id` (`arete_id`);

--
-- Indices de la tabla `animal_hato`
--
ALTER TABLE `animal_hato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`),
  ADD KEY `hato_id` (`hato_id`);

--
-- Indices de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trabajador_id` (`trabajador_id`),
  ADD KEY `asignaciones_ibfk_2` (`corral_id`);

--
-- Indices de la tabla `calidad_leche`
--
ALTER TABLE `calidad_leche`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Indices de la tabla `corrales`
--
ALTER TABLE `corrales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_animal` (`arete_id`);

--
-- Indices de la tabla `costos`
--
ALTER TABLE `costos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `embriones`
--
ALTER TABLE `embriones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donadora_id` (`donadora_id`),
  ADD KEY `receptora_id` (`receptora_id`);

--
-- Indices de la tabla `enfermedades`
--
ALTER TABLE `enfermedades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `eventos_reproductivos`
--
ALTER TABLE `eventos_reproductivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Indices de la tabla `ganancia_peso`
--
ALTER TABLE `ganancia_peso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Indices de la tabla `hatos`
--
ALTER TABLE `hatos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial_medico`
--
ALTER TABLE `historial_medico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Indices de la tabla `historial_movimientos`
--
ALTER TABLE `historial_movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Indices de la tabla `historial_peso`
--
ALTER TABLE `historial_peso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Indices de la tabla `historial_reproductivo`
--
ALTER TABLE `historial_reproductivo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_animal_id` (`animal_id`);

--
-- Indices de la tabla `potreros`
--
ALTER TABLE `potreros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `produccion_leche`
--
ALTER TABLE `produccion_leche`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Indices de la tabla `proyeccion_carne`
--
ALTER TABLE `proyeccion_carne`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Indices de la tabla `registro_enfermedades`
--
ALTER TABLE `registro_enfermedades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`),
  ADD KEY `enfermedad_id` (`enfermedad_id`);

--
-- Indices de la tabla `rentabilidad`
--
ALTER TABLE `rentabilidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Indices de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ventas_animal` (`animal_id`),
  ADD KEY `fk_ventas_trabajador` (`trabajador_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `animales`
--
ALTER TABLE `animales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `animal_hato`
--
ALTER TABLE `animal_hato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `calidad_leche`
--
ALTER TABLE `calidad_leche`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `corrales`
--
ALTER TABLE `corrales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `costos`
--
ALTER TABLE `costos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `embriones`
--
ALTER TABLE `embriones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enfermedades`
--
ALTER TABLE `enfermedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `eventos_reproductivos`
--
ALTER TABLE `eventos_reproductivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ganancia_peso`
--
ALTER TABLE `ganancia_peso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `hatos`
--
ALTER TABLE `hatos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `historial_medico`
--
ALTER TABLE `historial_medico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `historial_movimientos`
--
ALTER TABLE `historial_movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `historial_peso`
--
ALTER TABLE `historial_peso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `historial_reproductivo`
--
ALTER TABLE `historial_reproductivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `potreros`
--
ALTER TABLE `potreros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `produccion_leche`
--
ALTER TABLE `produccion_leche`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proyeccion_carne`
--
ALTER TABLE `proyeccion_carne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_enfermedades`
--
ALTER TABLE `registro_enfermedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rentabilidad`
--
ALTER TABLE `rentabilidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `animal_hato`
--
ALTER TABLE `animal_hato`
  ADD CONSTRAINT `animal_hato_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `animal_hato_ibfk_2` FOREIGN KEY (`hato_id`) REFERENCES `hatos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD CONSTRAINT `asignaciones_ibfk_1` FOREIGN KEY (`trabajador_id`) REFERENCES `trabajadores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asignaciones_ibfk_2` FOREIGN KEY (`corral_id`) REFERENCES `corrales` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `calidad_leche`
--
ALTER TABLE `calidad_leche`
  ADD CONSTRAINT `calidad_leche_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animales` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `corrales`
--
ALTER TABLE `corrales`
  ADD CONSTRAINT `fk_animal` FOREIGN KEY (`arete_id`) REFERENCES `animales` (`arete_id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `embriones`
--
ALTER TABLE `embriones`
  ADD CONSTRAINT `embriones_ibfk_1` FOREIGN KEY (`donadora_id`) REFERENCES `animales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `embriones_ibfk_2` FOREIGN KEY (`receptora_id`) REFERENCES `animales` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `eventos_reproductivos`
--
ALTER TABLE `eventos_reproductivos`
  ADD CONSTRAINT `eventos_reproductivos_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animales` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ganancia_peso`
--
ALTER TABLE `ganancia_peso`
  ADD CONSTRAINT `ganancia_peso_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animales` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_medico`
--
ALTER TABLE `historial_medico`
  ADD CONSTRAINT `historial_medico_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animales` (`id`);

--
-- Filtros para la tabla `historial_movimientos`
--
ALTER TABLE `historial_movimientos`
  ADD CONSTRAINT `historial_movimientos_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animales` (`id`);

--
-- Filtros para la tabla `historial_peso`
--
ALTER TABLE `historial_peso`
  ADD CONSTRAINT `historial_peso_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animales` (`id`);

--
-- Filtros para la tabla `historial_reproductivo`
--
ALTER TABLE `historial_reproductivo`
  ADD CONSTRAINT `fk_animal_id` FOREIGN KEY (`animal_id`) REFERENCES `animales` (`id`),
  ADD CONSTRAINT `historial_reproductivo_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animales` (`id`);

--
-- Filtros para la tabla `produccion_leche`
--
ALTER TABLE `produccion_leche`
  ADD CONSTRAINT `produccion_leche_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animales` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `proyeccion_carne`
--
ALTER TABLE `proyeccion_carne`
  ADD CONSTRAINT `proyeccion_carne_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animales` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `registro_enfermedades`
--
ALTER TABLE `registro_enfermedades`
  ADD CONSTRAINT `registro_enfermedades_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registro_enfermedades_ibfk_2` FOREIGN KEY (`enfermedad_id`) REFERENCES `enfermedades` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rentabilidad`
--
ALTER TABLE `rentabilidad`
  ADD CONSTRAINT `rentabilidad_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animales` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_animal` FOREIGN KEY (`animal_id`) REFERENCES `animales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ventas_trabajador` FOREIGN KEY (`trabajador_id`) REFERENCES `trabajadores` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
