-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-07-2025 a las 14:28:56
-- Versión del servidor: 10.11.10-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `foro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` bigint(20) NOT NULL,
  `id_pregunta` bigint(20) NOT NULL,
  `contenido` text DEFAULT NULL,
  `likes` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `id_pregunta`, `contenido`, `likes`) VALUES
(1, 1, 'Buenas Tardes', NULL),
(2, 1, 'Buenos Días', NULL),
(3, 1, 'Buenas Noches', NULL),
(4, 2, 'Qué Dices', NULL),
(5, 2, 'Callate', NULL),
(6, 2, 'Me tienes contento', NULL),
(7, 2, 'Mucho hablas tu', NULL),
(8, 2, 'Mejor ni hables hazme el favor', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` bigint(20) NOT NULL,
  `contenido` text DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `contenido`, `fecha_publicacion`) VALUES
(1, '¿Cuál es el límite real y empírico del enfriamiento del universo?', NULL),
(2, 'sdfvsd', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id` bigint(20) NOT NULL,
  `id_pregunta` bigint(20) NOT NULL,
  `id_mensaje` bigint(20) NOT NULL,
  `id_respuesta` bigint(20) NOT NULL,
  `id_usuario` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` bigint(20) NOT NULL,
  `id_mensaje` bigint(20) NOT NULL,
  `contenido` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `top_discusiones`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `top_discusiones` (
`contenido` text
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(4) NOT NULL,
  `nombre` char(50) DEFAULT NULL,
  `apellido1` char(50) DEFAULT NULL,
  `apellido2` char(50) DEFAULT NULL,
  `correo` varchar(256) DEFAULT NULL,
  `clave` varchar(255) NOT NULL,
  `rol` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido1`, `apellido2`, `correo`, `clave`, `rol`) VALUES
(1, 'neftalí', 'Espino', 'Rodríguez', 'neftali@gmail.com', '1234', 'admin'),
(2, 'Joel', 'Ramos', 'Zurita', 'joel@gmail.com', '1234', 'admin');

-- --------------------------------------------------------

--
-- Estructura para la vista `top_discusiones`
--
DROP TABLE IF EXISTS `top_discusiones`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `top_discusiones`  AS SELECT `preguntas`.`contenido` AS `contenido` FROM (`preguntas` join (select `mensajes`.`id_pregunta` AS `id_pregunta`,count(`mensajes`.`id`) AS `total` from `mensajes` group by `mensajes`.`id_pregunta`) `temp` on(`temp`.`id_pregunta` = `preguntas`.`id`)) ORDER BY `temp`.`total` DESC ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `origen` (`id_pregunta`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `publica` (`id_mensaje`),
  ADD KEY `crea` (`id_pregunta`),
  ADD KEY `contesta` (`id_respuesta`),
  ADD KEY `propietario` (`id_usuario`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `responde` (`id_mensaje`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `origen` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id`);

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `contesta` FOREIGN KEY (`id_respuesta`) REFERENCES `respuestas` (`id`),
  ADD CONSTRAINT `crea` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id`),
  ADD CONSTRAINT `propietario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `publica` FOREIGN KEY (`id_mensaje`) REFERENCES `mensajes` (`id`);

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `responde` FOREIGN KEY (`id_mensaje`) REFERENCES `mensajes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
