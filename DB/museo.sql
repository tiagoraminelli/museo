-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-10-2024 a las 00:43:58
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
-- Base de datos: `museo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arqueologia`
--

CREATE TABLE `arqueologia` (
  `idArqueologia` int(11) NOT NULL,
  `integridad_historica` varchar(255) DEFAULT NULL,
  `estetica` varchar(255) DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `arqueologia`
--

INSERT INTO `arqueologia` (`idArqueologia`, `integridad_historica`, `estetica`, `material`, `Pieza_idPieza`) VALUES
(3, 'tiago', 'estuvo', 'AQUI', 2),
(4, 'buena', 'asdasda', 'taigo', 56);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `botanica`
--

CREATE TABLE `botanica` (
  `idBotanica` int(11) NOT NULL,
  `reino` varchar(255) DEFAULT NULL,
  `familia` varchar(255) DEFAULT NULL,
  `especie` varchar(255) DEFAULT NULL,
  `orden` varchar(255) DEFAULT NULL,
  `division` varchar(255) DEFAULT NULL,
  `clase` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `botanica`
--

INSERT INTO `botanica` (`idBotanica`, `reino`, `familia`, `especie`, `orden`, `division`, `clase`, `descripcion`, `Pieza_idPieza`) VALUES
(2, 'tiago', 'estuvo', 'aqui', 'jugandoi', 'con', 'plantas', 'carnivoras Soja, leguminosa cultivada para la producción de aceite.', 2),
(4, 'tiago', 'estuvo', 'asdjkakjsd', 'jugando', 'un', 'poco', '', 48),
(5, 'tiago', 'estuvo', 'asdjkakjsd', 'jugando', 'un', 'poco', 'de todo', 49);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donante`
--

CREATE TABLE `donante` (
  `idDonante` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `donante`
--

INSERT INTO `donante` (`idDonante`, `nombre`, `apellido`, `fecha`) VALUES
(1, 'Juan', 'Pérez', '2023-01-15'),
(2, 'María', 'García', '2023-02-10'),
(3, 'Carlos', 'López', '2023-03-05'),
(4, 'Ana', 'Martínez', '2023-04-20'),
(5, 'Luisa', 'Fernández', '2023-05-30'),
(6, 'Tiago', 'Raminelli', '2024-10-25'),
(7, 'Nacho', 'Daro', '2024-10-26'),
(8, 'root', 'root', '2024-10-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `geologia`
--

CREATE TABLE `geologia` (
  `idGeologia` int(11) NOT NULL,
  `tipo_rocas` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `geologia`
--

INSERT INTO `geologia` (`idGeologia`, `tipo_rocas`, `descripcion`, `Pieza_idPieza`) VALUES
(3, 'tiago', 'esutvo tirando rcoas', 2),
(4, 'ígneas', 'adasdasdasd', 24),
(5, 'ígneas', 'adasdasdasd', 25),
(6, 'ígneas', '', 26),
(8, 'ígneas', 'asdasdasad', 28);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ictiologia`
--

CREATE TABLE `ictiologia` (
  `idIctiologia` int(11) NOT NULL,
  `clasificacion` varchar(255) DEFAULT NULL,
  `especies` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ictiologia`
--

INSERT INTO `ictiologia` (`idIctiologia`, `clasificacion`, `especies`, `descripcion`, `Pieza_idPieza`) VALUES
(3, 'tiago', 'estuvo', 'jugando con tiburones', 2),
(5, 'tiago no ', 'estuvo jugando', 'aqui asdasd', 46);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `octologia`
--

CREATE TABLE `octologia` (
  `idOctologia` int(11) NOT NULL,
  `clasificacion` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `especie` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `octologia`
--

INSERT INTO `octologia` (`idOctologia`, `clasificacion`, `tipo`, `especie`, `descripcion`, `Pieza_idPieza`) VALUES
(2, 'tiago', 'estuvo', 'aqui', 'dujandop asdjkashjdasd Langosta europea, reconocida por su tamaño y sabor.', 2),
(3, 'yo', 'estuve', 'aqui', 'JUGANDO', 57);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `osteologia`
--

CREATE TABLE `osteologia` (
  `idOsteologia` int(11) NOT NULL,
  `especie` varchar(255) DEFAULT NULL,
  `clasificacion` varchar(255) DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `osteologia`
--

INSERT INTO `osteologia` (`idOsteologia`, `especie`, `clasificacion`, `Pieza_idPieza`) VALUES
(2, 'tiago', 'estuvo aqui', 2),
(3, 'adasdasda', 'Osteología', 23),
(4, NULL, NULL, 41),
(5, NULL, NULL, 42),
(6, NULL, NULL, 43),
(7, NULL, NULL, 44),
(8, 'estuvo', 'aqui', 45),
(9, 'root', 'root', 58),
(10, 'root', 'root', 59),
(11, 'root', 'root', 60);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paleontologia`
--

CREATE TABLE `paleontologia` (
  `idPaleontologia` int(11) NOT NULL,
  `era` varchar(255) DEFAULT NULL,
  `periodo` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `paleontologia`
--

INSERT INTO `paleontologia` (`idPaleontologia`, `era`, `periodo`, `descripcion`, `Pieza_idPieza`) VALUES
(2, 'tiagoñi', 'el de tu señora', 'muy ensangrentada', 2),
(5, 'Paleozoico', 'Cretácico', '', 30),
(6, 'Paleozoico', 'Cuaternario', 'A VER SI ACA ME DEHJA', 31),
(7, 'Paleozoico', 'Paleógeno', '', 32),
(8, 'Paleozoico', 'Paleógeno', '', 33),
(9, 'Paleozoico', 'Paleógeno', '', 34),
(10, 'Paleozoico', 'Ordovícico', '', 35),
(11, 'Paleozoico', 'Neógeno', '', 36),
(12, 'Paleozoico', 'Silúrico', '', 37),
(13, 'Paleozoico', 'Silúrico', 'a ver si me lo guarda al cambio', 38),
(14, 'Paleozoico', 'Silúrico', NULL, 39),
(15, 'Paleozoico', 'Devónico', 'asdasdasd', 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pieza`
--

CREATE TABLE `pieza` (
  `idPieza` int(11) NOT NULL,
  `num_inventario` varchar(255) DEFAULT NULL,
  `especie` varchar(255) DEFAULT NULL,
  `estado_conservacion` varchar(255) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `cantidad_de_piezas` varchar(255) DEFAULT NULL,
  `clasificacion` varchar(255) DEFAULT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `Donante_idDonante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `pieza`
--

INSERT INTO `pieza` (`idPieza`, `num_inventario`, `especie`, `estado_conservacion`, `fecha_ingreso`, `cantidad_de_piezas`, `clasificacion`, `observacion`, `imagen`, `Donante_idDonante`) VALUES
(2, 'tiago', 'aqui 2', 'aqui', '2023-06-18', '1000', 'Zoología', 'Pequeñas fisuras', '', 2),
(13, 'INV-001', 'Tyrannosaurus Rex', 'Excelente', '2023-05-01', '1', 'Paleontología', 'Fósil completo en excelente estado', 'trex.jpg', 1),
(14, 'INV-002', 'Quercus Robur', 'Bueno', '2023-06-15', '3', 'Botánica', 'Hojas en estado de conservación moderado', 'roble.jpg', 2),
(16, 'INV-004', 'Arenisca', 'Excelente', '2023-08-10', '5', 'Geología', 'Muestra de roca sedimentaria bien preservada', 'arenisca.jpg', 4),
(17, 'INV-005', 'Triceratops Horridus', 'Bueno', '2023-09-01', '1', 'Paleontología', 'Fósil de cráneo casi completo', 'triceratops.jpg', 1),
(18, 'INV-006', 'Sphenodon Punctatus', 'Regular', '2023-03-18', '2', 'Zoología', 'Esqueleto incompleto pero identificable', 'tuatara.jpg', 3),
(19, 'INV-007', 'Pinus Sylvestris', 'Bueno', '2023-04-22', '10', 'Botánica', 'Muestras de corteza y hojas en buen estado', 'pino.jpg', 2),
(20, 'INV-008', 'Roca Ígnea', 'Excelente', '2023-05-30', '4', 'Geología', 'Muestra intacta de roca volcánica', 'roca_ignea.jpg', 4),
(21, 'INV-009', 'Dactylis Glomerata', 'Regular', '2023-06-05', '7', 'Botánica', 'Semillas y flores parcialmente deterioradas', 'dactylis.jpg', 2),
(22, 'INV-010', 'Velociraptor Mongoliensis', 'Bueno', '2023-07-01', '1', 'Paleontología', 'Fósil con algunas partes faltantes', 'velociraptor.jpg', 1),
(23, 'estuvo', 'adasdasda', 'dadasdasd', '2024-10-15', '12', 'Osteología', 'esjadhhjdasjdhsaas', '', 6),
(24, 'prueba', 'de', 'campo', '2024-10-21', '1', 'Geología', 'a ver si se guardo el historiral', 'gestion de inventario.webp', 6),
(25, 'prueba', 'de', 'campo', '2024-10-21', '1', 'Geología', 'a ver si se guardo el historiral', 'gestion de inventario.webp', 6),
(26, 'NVH122', 'asdasd', 'asdasdadads', '2024-10-30', '1', 'Geología', 'adasd', '', 7),
(28, 'root Geologia carga', '1', '1', '2024-10-09', '1', 'Geología', 'sdsad', '', 6),
(30, 'root paleontologia ', '1', '1', '2024-10-26', '1', 'Paleontología', '1', '', 7),
(31, 'root paleontologia ', 'asdasdasd', '1', '2024-10-26', '1', 'Paleontología', 'adasdsd', '', 6),
(32, 'PALEONTOLOGO', 'adasdasda', 'asdasd', '2024-10-26', '1', 'Paleontología', 'asdasdasd', '', 6),
(33, 'PALEONTOLOGO', 'adasdasda', 'asdasd', '2024-10-26', '1', 'Paleontología', 'asdasdasd', '', 6),
(34, 'PALEONTOLOGO', 'adasdasda', 'asdasd', '2024-10-26', '1', 'Paleontología', 'asdasdasd', '', 6),
(35, 'root paleontologia ', '1', '1', '2024-11-04', '1', 'Paleontología', 'a1', '', 6),
(36, '1', '1', '1', '2024-11-05', '1', 'Paleontología', 'asdasd', '', 6),
(37, 'root', '1', '1', '2024-10-26', '1', 'Paleontología', 'asdasdasd', '', 6),
(38, 'root', '1', '1', '2024-10-26', '1', 'Paleontología', 'asdasdasd', '', 6),
(39, 'root', '1', '1', '2024-10-26', '1', 'Paleontología', 'asdasdasd', '', 6),
(40, 'asdasd', 'dasdasda', 'aadsadsdas', '2024-11-04', '1', 'Paleontología', 'asdasd', '', 6),
(41, 'root osteo', '1', '1', '2024-10-26', '1', 'Osteología', 'asdasdasd', '', 6),
(42, 'root osteo', '1', '1', '2024-10-26', '1', 'Osteología', 'asdasdasd', '', 6),
(43, 'root osteo', '1', '1', '2024-10-26', '1', 'Osteología', 'asdasdasd', '', 6),
(44, 'root osteo', '1', '1', '2024-10-26', '1', 'Osteología', 'asdasdasd', '', 6),
(45, 'root osteo carga', 'ewstuvo', '1', '2024-10-22', '1', 'Osteología', 'asdasdasd', '', 6),
(46, 'root ictiologia', 'asdhjajhsd', '1', '2024-10-26', '1', 'Ictiología', 'adasdasdaads', '', 6),
(48, 'root botanica', 'asdjkakjsd', 'buena', '2024-10-28', '1', 'Botánica', 'asdasd', '', 6),
(49, 'root botanica', 'asdjkakjsd', 'buena', '2024-10-28', '1', 'Botánica', 'asdasd', '', 6),
(50, 'root zoologia carga', 'adasdasda', 'dadasdasd', '2024-11-04', '1', 'Zoología', 'asdasd', '', 6),
(51, 'root zoologia carga', 'adasdasda', 'dadasdasd', '2024-11-04', '1', 'Zoología', 'asdasd', '', 6),
(52, 'root zoologia carga', 'adasdasda', 'dadasdasd', '2024-11-04', '1', 'Zoología', 'asdasd', '', 6),
(53, 'root zoologia carga', 'adasdasda', 'dadasdasd', '2024-11-04', '1', 'Zoología', 'asdasd', '', 6),
(54, 'root zoologia carga', 'adasdasda', 'dadasdasd', '2024-11-04', '1', 'Zoología', 'asdasd', '', 6),
(55, 'root zoologia ', 'aqui', '1', '2024-10-26', '1', 'Zoología', 'sadasdasd', '', 6),
(56, 'root arqueologia', '', 'asdaskdj', '2024-10-26', '1', 'Arqueología', 'asdasdasd', '', 6),
(57, 'root octologia', '', 'asdasdkj', '2024-10-26', '1', 'Octología', '1', '', 6),
(58, 'NVH999', '', 'root', '2024-10-26', '1', 'Osteología', 'root', 'Captura de pantalla 2024-10-02 161322.png', 8),
(59, 'NVH999', '', 'root', '2024-10-26', '1', 'Osteología', 'root', 'Captura de pantalla 2024-10-02 161322.png', 8),
(60, 'NVH999', '', 'root', '2024-10-26', '1', 'Osteología', 'root', 'Captura de pantalla 2024-10-02 161322.png', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `tipo_de_usuario` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `dni`, `nombre`, `apellido`, `email`, `clave`, `fecha_alta`, `tipo_de_usuario`) VALUES
(1, '12345678', 'Juan', 'Pérez', 'juan.perez@example.com', 'clave123', '2024-09-18', 'administrador'),
(2, '12345678', 'Juan', 'Martino', 'juan.perez@example.com', 'clave123', '2024-09-18', 'administrador'),
(3, '87654321', 'María', 'Gómez', 'maria.gomez@example.com', 'clave456', '2024-09-18', 'usuario'),
(4, '11223344', 'Luis', 'Martínez', 'luis.martinez@example.com', 'clave789', '2024-09-18', 'moderador'),
(5, '22334455', 'Ana', 'Sánchez', 'ana.sanchez@example.com', 'clave321', '2024-09-18', 'usuario'),
(6, '43766375', 'Jon', 'Doe', 'test@example.us', 'asdasdasdasd', '2024-09-19', 'user'),
(7, '43766375', 'Jonathan', 'Doe', 'jon.doe@example.us', 'nuevacontraseña', '2024-09-19', 'user'),
(8, '43766375', 'Taigo', 'Doestar', 'thiago.doe@example.us', 'nuevacontraseña', '2024-09-19', 'usuario'),
(9, '43766375', 'Avastore', 'Doestar', 'thiago.doe@example.us', '$2y$10$L0Dg9w2SdP8UL2RcUUu0m.l3fIbnNhCMbKwe.xG9/RUvj4yZCEewG', NULL, NULL),
(10, '43766375', 'Jon', 'Doe', 'test@example.us', '$2y$10$mBvHnAsQUqBlD4tTHRcTB.LZn/8HrSJy9.ow5SLOeE1ra2/3Sa.lW', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_has_pieza`
--

CREATE TABLE `usuario_has_pieza` (
  `Usuario_idUsuario` int(11) NOT NULL,
  `Pieza_idPieza` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario_has_pieza`
--

INSERT INTO `usuario_has_pieza` (`Usuario_idUsuario`, `Pieza_idPieza`, `fecha_registro`) VALUES
(1, 2, '2024-10-25 03:15:15'),
(1, 23, '2024-10-25 03:15:15'),
(1, 24, '2024-10-25 03:16:06'),
(1, 25, '2024-10-25 03:16:46'),
(1, 26, '2024-10-26 21:34:26'),
(1, 28, '2024-10-26 21:40:19'),
(1, 30, '2024-10-26 21:42:41'),
(1, 31, '2024-10-26 21:44:56'),
(1, 32, '2024-10-26 21:46:57'),
(1, 33, '2024-10-26 21:47:09'),
(1, 34, '2024-10-26 21:49:35'),
(1, 35, '2024-10-26 21:52:30'),
(1, 36, '2024-10-26 21:53:23'),
(1, 37, '2024-10-26 21:56:52'),
(1, 38, '2024-10-26 21:58:22'),
(1, 39, '2024-10-26 21:58:26'),
(1, 40, '2024-10-26 21:58:46'),
(1, 41, '2024-10-26 22:00:52'),
(1, 42, '2024-10-26 22:01:25'),
(1, 43, '2024-10-26 22:01:28'),
(1, 44, '2024-10-26 22:01:30'),
(1, 45, '2024-10-26 22:02:25'),
(1, 46, '2024-10-26 22:04:53'),
(1, 48, '2024-10-26 22:10:03'),
(1, 49, '2024-10-26 22:11:10'),
(1, 50, '2024-10-26 22:13:35'),
(1, 51, '2024-10-26 22:15:37'),
(1, 52, '2024-10-26 22:15:40'),
(1, 53, '2024-10-26 22:16:27'),
(1, 54, '2024-10-26 22:16:56'),
(1, 55, '2024-10-26 22:17:42'),
(1, 56, '2024-10-26 22:19:39'),
(1, 57, '2024-10-26 22:22:18'),
(1, 58, '2024-10-26 22:25:34'),
(1, 59, '2024-10-26 22:26:04'),
(1, 60, '2024-10-26 22:26:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zoologia`
--

CREATE TABLE `zoologia` (
  `idZoologia` int(11) NOT NULL,
  `reino` varchar(255) DEFAULT NULL,
  `familia` varchar(255) DEFAULT NULL,
  `especie` varchar(255) DEFAULT NULL,
  `orden` varchar(255) DEFAULT NULL,
  `phylum` varchar(255) DEFAULT NULL,
  `clase` varchar(255) DEFAULT NULL,
  `genero` varchar(255) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `Pieza_idPieza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `zoologia`
--

INSERT INTO `zoologia` (`idZoologia`, `reino`, `familia`, `especie`, `orden`, `phylum`, `clase`, `genero`, `descripcion`, `Pieza_idPieza`) VALUES
(2, 'tiago 2', 'estuvo 2', 'aqui 2', 'de  2', 'forma 2', 'remota 2', 'uwu 2', 'El perro es un mamífero doméstico que pertenece a la familia de los cánidos. 2', 2),
(3, 'cualqueir', 'aqudaklsd', 'adasdasda', 'asdkkjads', 'con', 'asdasdasd', 'animales', 'asdasdasdas', 50),
(4, '', '', 'adasdasda', '', 'con', '', 'animales', '', 51),
(5, '', '', 'adasdasda', '', 'con', '', 'animales', '', 52),
(6, '', '', 'adasdasda', '', 'con', '', 'animales', '', 53),
(7, '', '', 'adasdasda', '', 'con', '', 'animales', '', 54),
(8, 'tiago', 'estuvo', 'aqui', 'jugandoi', 'forma', 'dasdasdas', 'Canisad', 'asdasdasdasda', 55);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `arqueologia`
--
ALTER TABLE `arqueologia`
  ADD PRIMARY KEY (`idArqueologia`),
  ADD KEY `fk_Arqueologia_Pieza1_idx` (`Pieza_idPieza`);

--
-- Indices de la tabla `botanica`
--
ALTER TABLE `botanica`
  ADD PRIMARY KEY (`idBotanica`),
  ADD KEY `fk_Botanica_Pieza1_idx` (`Pieza_idPieza`);

--
-- Indices de la tabla `donante`
--
ALTER TABLE `donante`
  ADD PRIMARY KEY (`idDonante`);

--
-- Indices de la tabla `geologia`
--
ALTER TABLE `geologia`
  ADD PRIMARY KEY (`idGeologia`),
  ADD KEY `fk_Geologia_Pieza1_idx` (`Pieza_idPieza`);

--
-- Indices de la tabla `ictiologia`
--
ALTER TABLE `ictiologia`
  ADD PRIMARY KEY (`idIctiologia`),
  ADD KEY `fk_Ictiologia_Pieza1_idx` (`Pieza_idPieza`);

--
-- Indices de la tabla `octologia`
--
ALTER TABLE `octologia`
  ADD PRIMARY KEY (`idOctologia`),
  ADD KEY `fk_Octologia_Pieza1_idx` (`Pieza_idPieza`);

--
-- Indices de la tabla `osteologia`
--
ALTER TABLE `osteologia`
  ADD PRIMARY KEY (`idOsteologia`),
  ADD KEY `fk_Osteologia_Pieza1_idx` (`Pieza_idPieza`);

--
-- Indices de la tabla `paleontologia`
--
ALTER TABLE `paleontologia`
  ADD PRIMARY KEY (`idPaleontologia`),
  ADD KEY `fk_Paleontologia_Pieza1_idx` (`Pieza_idPieza`);

--
-- Indices de la tabla `pieza`
--
ALTER TABLE `pieza`
  ADD PRIMARY KEY (`idPieza`),
  ADD KEY `fk_Pieza_Donante1_idx` (`Donante_idDonante`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `usuario_has_pieza`
--
ALTER TABLE `usuario_has_pieza`
  ADD PRIMARY KEY (`Usuario_idUsuario`,`Pieza_idPieza`),
  ADD KEY `fk_Usuario_has_Pieza_Pieza1_idx` (`Pieza_idPieza`),
  ADD KEY `fk_Usuario_has_Pieza_Usuario_idx` (`Usuario_idUsuario`);

--
-- Indices de la tabla `zoologia`
--
ALTER TABLE `zoologia`
  ADD PRIMARY KEY (`idZoologia`),
  ADD KEY `fk_Zoologia_Pieza1_idx` (`Pieza_idPieza`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `arqueologia`
--
ALTER TABLE `arqueologia`
  MODIFY `idArqueologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `botanica`
--
ALTER TABLE `botanica`
  MODIFY `idBotanica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `donante`
--
ALTER TABLE `donante`
  MODIFY `idDonante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `geologia`
--
ALTER TABLE `geologia`
  MODIFY `idGeologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ictiologia`
--
ALTER TABLE `ictiologia`
  MODIFY `idIctiologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `octologia`
--
ALTER TABLE `octologia`
  MODIFY `idOctologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `osteologia`
--
ALTER TABLE `osteologia`
  MODIFY `idOsteologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `paleontologia`
--
ALTER TABLE `paleontologia`
  MODIFY `idPaleontologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `pieza`
--
ALTER TABLE `pieza`
  MODIFY `idPieza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `zoologia`
--
ALTER TABLE `zoologia`
  MODIFY `idZoologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `arqueologia`
--
ALTER TABLE `arqueologia`
  ADD CONSTRAINT `fk_Arqueologia_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `botanica`
--
ALTER TABLE `botanica`
  ADD CONSTRAINT `fk_Botanica_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `geologia`
--
ALTER TABLE `geologia`
  ADD CONSTRAINT `fk_Geologia_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ictiologia`
--
ALTER TABLE `ictiologia`
  ADD CONSTRAINT `fk_Ictiologia_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `octologia`
--
ALTER TABLE `octologia`
  ADD CONSTRAINT `fk_Octologia_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `osteologia`
--
ALTER TABLE `osteologia`
  ADD CONSTRAINT `fk_Osteologia_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `paleontologia`
--
ALTER TABLE `paleontologia`
  ADD CONSTRAINT `fk_Paleontologia_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pieza`
--
ALTER TABLE `pieza`
  ADD CONSTRAINT `fk_Pieza_Donante1` FOREIGN KEY (`Donante_idDonante`) REFERENCES `donante` (`idDonante`);

--
-- Filtros para la tabla `usuario_has_pieza`
--
ALTER TABLE `usuario_has_pieza`
  ADD CONSTRAINT `fk_Usuario_has_Pieza_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Usuario_has_Pieza_Usuario` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `zoologia`
--
ALTER TABLE `zoologia`
  ADD CONSTRAINT `fk_Zoologia_Pieza1` FOREIGN KEY (`Pieza_idPieza`) REFERENCES `pieza` (`idPieza`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
