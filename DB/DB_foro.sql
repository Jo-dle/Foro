-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-08-2025 a las 14:03:14
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
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_mensaje` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`id`, `id_usuario`, `id_mensaje`) VALUES
(84, 1, 10),
(83, 1, 11),
(97, 2, 17),
(109, 2, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` bigint(20) NOT NULL,
  `id_pregunta` bigint(20) NOT NULL,
  `contenido` text DEFAULT NULL,
  `id_usuario` int(4) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `id_pregunta`, `contenido`, `id_usuario`, `likes`) VALUES
(1, 1, 'Buenas Tardes', NULL, NULL),
(2, 1, 'Buenos Días', NULL, NULL),
(3, 1, 'Buenas Noches', NULL, NULL),
(4, 2, 'Qué Dices', NULL, NULL),
(5, 2, 'Callate', NULL, NULL),
(6, 2, 'Me tienes contento', NULL, NULL),
(7, 2, 'Mucho hablas tu', NULL, NULL),
(8, 2, 'Mejor ni hables hazme el favor', NULL, NULL),
(9, 1, 'antonio', NULL, NULL),
(10, 2, 'gilipichis', NULL, NULL),
(11, 3, 'maravilloso comentario', NULL, NULL),
(12, 3, 'xxx&lt;x&lt;zx', NULL, NULL),
(14, 1, 'holaaaaa', NULL, NULL),
(15, 2, 'nada', NULL, NULL),
(16, 1, 'Si', NULL, NULL),
(17, 4, 'Yo creo que el perro, al final pesará lo mismo que constantino', NULL, NULL),
(18, 1, 'hola', NULL, NULL),
(19, 5, 'Cállate', NULL, NULL),
(20, 1, 'xxxzx', NULL, NULL),
(22, 5, 'NO gilipichis', 1, NULL),
(23, 5, 'siuuuuuuuuuuuuuuuuu', 1, NULL),
(24, 7, 'Una puta mierda', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` bigint(20) NOT NULL,
  `contenido` text DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `id_usuario` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `contenido`, `fecha_publicacion`, `id_usuario`) VALUES
(1, '¿Cuál es el límite real y empírico del enfriamiento del universo?', NULL, NULL),
(2, 'sdfvsd', NULL, NULL),
(3, 'Fuerte batatada de foro!!', NULL, NULL),
(4, 'Quien ganaría en un combate, Constantino O un perro de 15 años con artrosis', NULL, NULL),
(5, 'No quiero', NULL, NULL),
(7, 'Realmente que es la vida una gran aventura o un gran mojón?', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` bigint(20) NOT NULL,
  `id_mensaje` bigint(20) NOT NULL,
  `contenido` text DEFAULT NULL,
  `id_usuario` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `id_mensaje`, `contenido`, `id_usuario`) VALUES
(2, 11, 'holi', NULL),
(3, 1, 'no', NULL),
(4, 1, 'si', NULL),
(5, 1, 'tal vez', NULL),
(6, 17, 'uff no se que decirte que tipo de perro ya que algunos tienen menos alcance que constatino', NULL),
(7, 9, 'no', NULL),
(8, 2, 'no', NULL),
(9, 17, 'Creo realmente que está usted equivocado ya que constantino cuenta como un perro de 20 años con reuma', NULL);

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
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`,`id_mensaje`),
  ADD KEY `id_mensaje` (`id_mensaje`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `origen` (`id_pregunta`),
  ADD KEY `usuario` (`id_usuario`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cosas` (`id_usuario`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `responde` (`id_mensaje`),
  ADD KEY `coson` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_mensaje`) REFERENCES `mensajes` (`id`);

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `origen` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id`),
  ADD CONSTRAINT `usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `cosas` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `coson` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `responde` FOREIGN KEY (`id_mensaje`) REFERENCES `mensajes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
