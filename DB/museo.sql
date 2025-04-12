-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-04-2025 a las 00:40:18
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
(9, 'buena', 'root', 'root', 130);

--
-- Disparadores `arqueologia`
--
DELIMITER $$
CREATE TRIGGER `after_delete_arqueologia` AFTER DELETE ON `arqueologia` FOR EACH ROW BEGIN


    INSERT INTO datos_eliminados (
        Pieza_idPieza,
        IdClasificacion,
        Tabla,
        campo1,
        campo2,
        campo3
    ) VALUES (
        OLD.Pieza_idPieza,
        OLD.idArqueologia,       -- ID primario de Arqueologia
        'Arqueologia',           -- Nombre de la tabla de origen
        OLD.integridad_historica, -- Primer campo específico de Arqueologia
        OLD.estetica,            -- Segundo campo específico de Arqueologia
        OLD.material             -- Tercer campo específico de Arqueologia
    );
END
$$
DELIMITER ;

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
(14, 'root', 'root', 'root', 'root', 'root', 'root', 'root', 151),
(15, 'root', 'root', 'root', 'root', 'root', 'root', 'root', 155);

--
-- Disparadores `botanica`
--
DELIMITER $$
CREATE TRIGGER `after_delete_botanica` AFTER DELETE ON `botanica` FOR EACH ROW BEGIN
    INSERT INTO datos_eliminados (
        Pieza_idPieza,
        IdClasificacion,
        Tabla,
        campo1,
        campo2,
        campo3,
        campo4,
        campo5,
        campo6,
        campo7
    ) VALUES (
        OLD.Pieza_idPieza,
        OLD.idBotanica,        -- El ID primario de Botánica
        'Botánica',            -- El nombre de la tabla de origen
        OLD.reino,             -- Primer campo específico de Botánica
        OLD.familia,           -- Segundo campo específico de Botánica
        OLD.especie,           -- Tercer campo específico de Botánica
        OLD.orden,             -- Cuarto campo específico de Botánica
        OLD.division,          -- Quinto campo específico de Botánica
        OLD.clase,             -- Sexto campo específico de Botánica
        OLD.descripcion        -- Séptimo campo específico de Botánica
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_eliminados`
--

CREATE TABLE `datos_eliminados` (
  `id` int(11) NOT NULL,
  `Pieza_idPieza` int(11) NOT NULL,
  `IdClasificacion` int(11) NOT NULL,
  `Tabla` varchar(255) DEFAULT NULL,
  `campo1` varchar(255) DEFAULT NULL,
  `campo2` varchar(255) DEFAULT NULL,
  `campo3` varchar(255) DEFAULT NULL,
  `campo4` varchar(255) DEFAULT NULL,
  `campo5` varchar(255) DEFAULT NULL,
  `campo6` varchar(255) DEFAULT NULL,
  `campo7` varchar(255) DEFAULT NULL,
  `campo8` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donadores_eliminados`
--

CREATE TABLE `donadores_eliminados` (
  `id` int(11) NOT NULL,
  `idDonante` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `fecha` date DEFAULT NULL,
  `fecha_eliminacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `donadores_eliminados`
--

INSERT INTO `donadores_eliminados` (`id`, `idDonante`, `nombre`, `apellido`, `fecha`, `fecha_eliminacion`) VALUES
(2, 10, 'Yamil', 'Pelapis', '2024-11-01', '2025-04-12 21:46:34'),
(3, 11, 'javier', 'milei', '2024-11-01', '2025-04-12 21:46:37'),
(4, 13, 'rosalba', 'itati', '2024-12-19', '2025-04-12 21:48:22'),
(5, 14, 'rott', 'r', '2025-02-25', '2025-04-12 21:48:33'),
(6, 9, 'Leo', 'Juarez', '2024-11-01', '2025-04-12 21:49:30');

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
(1, 'Juan', 'Perez Riquelmes', '2023-01-15'),
(2, 'María', 'García', '2023-02-10'),
(3, 'Carlos', 'López', '2023-03-05'),
(4, 'Ana', 'Martínez', '2023-04-20'),
(5, 'Luisa', 'Fernández', '2023-05-30'),
(6, 'Tiago', 'Raminelli', '2024-10-25'),
(7, 'Nacho', 'Daro', '2024-10-26'),
(8, 'root', 'root', '2024-10-27'),
(15, 'Juan', 'Buatista Riquelme', '2025-04-12');

--
-- Disparadores `donante`
--
DELIMITER $$
CREATE TRIGGER `before_donadores_delete` BEFORE DELETE ON `donante` FOR EACH ROW BEGIN
    INSERT INTO donadores_eliminados (idDonante, nombre, apellido, fecha)
    VALUES (OLD.idDonante, OLD.nombre, OLD.apellido, OLD.fecha);
END
$$
DELIMITER ;

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
(45, 'sedimentarias', 'root', 147),
(46, 'sedimentarias', 'aaaaaaaaaaaaa', 149),
(47, 'ígneas', 'ROOT', 154);

--
-- Disparadores `geologia`
--
DELIMITER $$
CREATE TRIGGER `after_delete_geologia` BEFORE DELETE ON `geologia` FOR EACH ROW BEGIN
    INSERT INTO datos_eliminados (
        Pieza_idPieza,
        IdClasificacion,
        Tabla,
        campo1,
        campo2
    ) VALUES (
        OLD.Pieza_idPieza,
        OLD.idGeologia,         -- El ID primario de Geología
        'Geología',             -- El nombre de la tabla de origen
        OLD.tipo_rocas,         -- Primer campo específico de Geología
        OLD.descripcion         -- Segundo campo específico de Geología
    );
END
$$
DELIMITER ;

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
(10, 'root', 'root', 'root', 142);

--
-- Disparadores `ictiologia`
--
DELIMITER $$
CREATE TRIGGER `after_delete_ictiologia` AFTER DELETE ON `ictiologia` FOR EACH ROW BEGIN
    INSERT INTO datos_eliminados (
        Pieza_idPieza,
        IdClasificacion,
        Tabla,
        campo1,
        campo2,
        campo3
    ) VALUES (
        OLD.Pieza_idPieza,
        OLD.idIctiologia,       -- El ID primario de Ictiología
        'Ictiología',           -- El nombre de la tabla de origen
        OLD.clasificacion,      -- Primer campo específico de Ictiología
        OLD.especies,           -- Segundo campo específico de Ictiología
        OLD.descripcion         -- Tercer campo específico de Ictiología
    );
END
$$
DELIMITER ;

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
(9, 'root', 'root', 'root', 'NOse', 152);

--
-- Disparadores `octologia`
--
DELIMITER $$
CREATE TRIGGER `after_delete_octologia` AFTER DELETE ON `octologia` FOR EACH ROW BEGIN
    INSERT INTO datos_eliminados (
        Pieza_idPieza,
        IdClasificacion,
        Tabla,
        campo1,
        campo2,
        campo3,
        campo4
    ) VALUES (
        OLD.Pieza_idPieza,
        OLD.idOctologia,        -- ID primario de Octologia
        'Octologia',            -- Nombre de la tabla de origen
        OLD.clasificacion,      -- Primer campo específico de Octologia
        OLD.tipo,               -- Segundo campo específico de Octologia
        OLD.especie,            -- Tercer campo específico de Octologia
        OLD.descripcion         -- Cuarto campo específico de Octologia
    );
END
$$
DELIMITER ;

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
-- Disparadores `osteologia`
--
DELIMITER $$
CREATE TRIGGER `after_delete_osteologia` AFTER DELETE ON `osteologia` FOR EACH ROW BEGIN
    INSERT INTO datos_eliminados (
        Pieza_idPieza,
        IdClasificacion,
        Tabla,
        campo1,
        campo2
    ) VALUES (
        OLD.Pieza_idPieza,
        OLD.idOsteologia,     -- El ID primario de Osteología
        'Osteología',         -- El nombre de la tabla de origen
        OLD.especie,          -- Primer campo específico de Osteología
        OLD.clasificacion     -- Segundo campo específico de Osteología
    );
END
$$
DELIMITER ;

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
(28, 'Paleozoico', 'Ordovícico', 'aaaaaaaaaa', 153);

--
-- Disparadores `paleontologia`
--
DELIMITER $$
CREATE TRIGGER `after_delete_paleontologia` AFTER DELETE ON `paleontologia` FOR EACH ROW BEGIN
  INSERT INTO datos_eliminados (
        Pieza_idPieza,
        IdClasificacion,
        Tabla,
        campo1,
        campo2,
        campo3
    ) VALUES (
        OLD.Pieza_idPieza,
        OLD.idPaleontologia, -- El ID primario de Paleontología
        'Paleontología',     -- El nombre de la tabla de origen
        OLD.era,             -- Primer campo específico de Paleontología
        OLD.periodo,         -- Segundo campo específico de Paleontología
        OLD.descripcion      -- Tercer campo específico de Paleontología
    );

END
$$
DELIMITER ;

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
(130, 'NDH-130', 'Root', 'Regular', '2024-12-19', '1', 'Arqueología', 'root', 'eva 2.jpeg', 6),
(142, 'NDH-142', 'root', 'Malo', '2025-04-12', '6', 'Ictiología', 'root', '', 4),
(147, 'NDH-147', 'root', 'root', '2024-11-12', '1', 'Geología', 'root', '', 6),
(148, 'NDH-148', 'root', 'root', '2024-12-19', '2', 'Zoología', 'root', '', 6),
(149, 'NDH-149', 'root', 'Malo', '2025-04-12', '1', 'Geología', 'aaaaaaaaaa', '', 6),
(151, 'NDH-151', 'root', 'root', '2025-04-28', '1', 'Botánica', 'root', '', 6),
(152, 'NDH-152', 'root', 'Regular', '2025-04-06', '1', 'Octología', 'Ninguna', '', 6),
(153, 'NDH-153', 'root', 'En restauración', '2025-04-08', '3', 'Paleontología', 'cualquier cosa', '', 6),
(154, 'NDH-154', 'IMAGEN', 'Excelente', '2025-04-13', '1', 'Geología', 'IMAGEN', 'nerv.jpg', 6),
(155, 'NDH-155', 'root', 'En restauración', '2025-04-12', '1', 'Botánica', 'root', 'star rail.png', 6);

--
-- Disparadores `pieza`
--
DELIMITER $$
CREATE TRIGGER `after_pieza_update` AFTER UPDATE ON `pieza` FOR EACH ROW BEGIN
    UPDATE usuario_has_pieza
    SET  ultima_actualizacion = CURRENT_TIMESTAMP()
    WHERE Pieza_idPieza = NEW.idPieza;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `eliminar_piezas_heredadas` AFTER DELETE ON `pieza` FOR EACH ROW BEGIN
    -- Intentar eliminar registros de osteologia
    BEGIN
        DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
        BEGIN
            -- Manejo de errores, se puede registrar o hacer algo específico
            -- Pero el trigger continuará a la siguiente eliminación
        END;

        DELETE FROM osteologia WHERE Pieza_idPieza = OLD.idPieza;
    END;

    -- Intentar eliminar registros de ictiologia
    BEGIN
        DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
        BEGIN
            -- Manejo de errores
        END;

        DELETE FROM ictiologia WHERE Pieza_idPieza = OLD.idPieza;
    END;

    -- Intentar eliminar registros de geologia
    BEGIN
        DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
        BEGIN
            -- Manejo de errores
        END;

        DELETE FROM geologia WHERE Pieza_idPieza = OLD.idPieza;
    END;

    -- Intentar eliminar registros de botanica
    BEGIN
        DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
        BEGIN
            -- Manejo de errores
        END;

        DELETE FROM botanica WHERE Pieza_idPieza = OLD.idPieza;
    END;

    -- Intentar eliminar registros de zoologia
    BEGIN
        DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
        BEGIN
            -- Manejo de errores
        END;

        DELETE FROM zoologia WHERE Pieza_idPieza = OLD.idPieza;
    END;

    -- Intentar eliminar registros de arqueologia
    BEGIN
        DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
        BEGIN
            -- Manejo de errores
        END;

        DELETE FROM arqueologia WHERE Pieza_idPieza = OLD.idPieza;
    END;

    -- Intentar eliminar registros de octologia
    BEGIN
        DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
        BEGIN
            -- Manejo de errores
        END;

        DELETE FROM octologia WHERE Pieza_idPieza = OLD.idPieza;
    END;

    -- Intentar eliminar registros de paleontologia
    BEGIN
        DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
        BEGIN
            -- Manejo de errores
        END;

        DELETE FROM paleontologia WHERE Pieza_idPieza = OLD.idPieza;
    END;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `registrar_piezas_eliminadas` BEFORE DELETE ON `pieza` FOR EACH ROW BEGIN
  INSERT INTO registros_eliminados (
        idPieza, num_inventario, especie, estado_conservacion,
        fecha_ingreso, cantidad_de_piezas, clasificacion,
        observacion, imagen, Donante_idDonante
    ) VALUES (
        OLD.idPieza, OLD.num_inventario, OLD.especie, OLD.estado_conservacion,
        OLD.fecha_ingreso, OLD.cantidad_de_piezas, OLD.clasificacion,
        OLD.observacion, OLD.imagen, OLD.Donante_idDonante
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros_eliminados`
--

CREATE TABLE `registros_eliminados` (
  `id` int(11) NOT NULL,
  `idPieza` int(11) DEFAULT NULL,
  `num_inventario` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `especie` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `estado_conservacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `cantidad_de_piezas` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `clasificacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `observacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `imagen` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Donante_idDonante` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `registros_eliminados`
--
DELIMITER $$
CREATE TRIGGER `trigger_after_delete` AFTER DELETE ON `registros_eliminados` FOR EACH ROW BEGIN
   
END
$$
DELIMITER ;

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
(11, '43766375', 'tiago', 'Raminelli', 'tiagoraminelli@gmail.com', 'abcd1234', '2024-10-29', 'administrador'),
(15, '10103030', 'gerente', 'gerente', 'gerentes@gmail.com', '$2y$10$hJaDhcSH4Db5Cqx6wJMRH.R9jzw3PdGt.ky5vWIw.ymJYjZvbocKC', '2024-12-19', 'gerente'),
(16, '10101010', 'anabel', 'roldan', 'Anaroldan@gmail.com', '$2y$10$PQg8oJVTP.bo87Vqev6LUeuNtBIhzpL4R.rzaE49l0xeYJCfZhSwe', '2024-12-19', 'gerente'),
(26, '11111111', 'admin', 'admin', 'admin@gmail.com', 'admin', '2025-02-28', 'administrador'),
(34, '43766377', 'valea', 'root', 'passedit1@gmail.com', '$2y$10$m6TywpJSWC5kzf/LEx6w.efEOU4uJcFt98oM59uLuaX1ql0O4qqrO', '2025-04-12', 'administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_has_pieza`
--

CREATE TABLE `usuario_has_pieza` (
  `Usuario_idUsuario` int(11) NOT NULL,
  `Pieza_idPieza` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultima_actualizacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario_has_pieza`
--

INSERT INTO `usuario_has_pieza` (`Usuario_idUsuario`, `Pieza_idPieza`, `fecha_registro`, `ultima_actualizacion`) VALUES
(11, 149, '2025-04-02 17:00:46', '2025-04-12 16:45:09'),
(11, 151, '2025-04-02 17:03:11', '2025-04-02 14:03:34'),
(11, 152, '2025-04-12 19:34:58', '0000-00-00 00:00:00'),
(15, 130, '2024-12-19 19:45:10', '2025-04-12 19:29:25'),
(15, 154, '2025-04-12 22:20:54', '2025-04-12 19:21:43'),
(15, 155, '2025-04-12 22:39:36', '0000-00-00 00:00:00'),
(26, 147, '2025-03-30 21:38:56', '2025-04-02 14:01:27'),
(26, 148, '2025-03-30 21:39:19', '2025-03-30 18:39:52'),
(34, 153, '2025-04-12 21:09:51', '2025-04-12 18:10:08');

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
(16, 'root', 'root', 'root', 'root', 'root', 'root', 'root', 'root', 148);

--
-- Disparadores `zoologia`
--
DELIMITER $$
CREATE TRIGGER `after_delete_zoologia` AFTER DELETE ON `zoologia` FOR EACH ROW BEGIN
    INSERT INTO datos_eliminados (
        Pieza_idPieza,
        IdClasificacion,
        Tabla,
        campo1,
        campo2,
        campo3,
        campo4,
        campo5,
        campo6,
        campo7,
        campo8
    ) VALUES (
        OLD.Pieza_idPieza,
        OLD.idZoologia,      -- El ID primario de Zoologia
        'Zoologia',          -- El nombre de la tabla de origen
        OLD.reino,           -- Primer campo específico de Zoologia
        OLD.familia,         -- Segundo campo específico de Zoologia
        OLD.especie,         -- Tercer campo específico de Zoologia
        OLD.orden,           -- Cuarto campo específico de Zoologia
        OLD.phylum,          -- Quinto campo específico de Zoologia
        OLD.clase,           -- Sexto campo específico de Zoologia
        OLD.genero,          -- Séptimo campo específico de Zoologia
        OLD.descripcion      -- Octavo campo específico de Zoologia
    );
END
$$
DELIMITER ;

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
-- Indices de la tabla `datos_eliminados`
--
ALTER TABLE `datos_eliminados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `donadores_eliminados`
--
ALTER TABLE `donadores_eliminados`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `registros_eliminados`
--
ALTER TABLE `registros_eliminados`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `idArqueologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `botanica`
--
ALTER TABLE `botanica`
  MODIFY `idBotanica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `datos_eliminados`
--
ALTER TABLE `datos_eliminados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `donadores_eliminados`
--
ALTER TABLE `donadores_eliminados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `donante`
--
ALTER TABLE `donante`
  MODIFY `idDonante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `geologia`
--
ALTER TABLE `geologia`
  MODIFY `idGeologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `ictiologia`
--
ALTER TABLE `ictiologia`
  MODIFY `idIctiologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `octologia`
--
ALTER TABLE `octologia`
  MODIFY `idOctologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `osteologia`
--
ALTER TABLE `osteologia`
  MODIFY `idOsteologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `paleontologia`
--
ALTER TABLE `paleontologia`
  MODIFY `idPaleontologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `pieza`
--
ALTER TABLE `pieza`
  MODIFY `idPieza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT de la tabla `registros_eliminados`
--
ALTER TABLE `registros_eliminados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `zoologia`
--
ALTER TABLE `zoologia`
  MODIFY `idZoologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
