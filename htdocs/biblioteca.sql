-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2018 a las 17:40:05
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `ID_Equipo` int(11) NOT NULL,
  `Nombre` char(30) COLLATE latin1_spanish_ci NOT NULL,
  `Fabricante` char(30) COLLATE latin1_spanish_ci NOT NULL,
  `NumSerie` char(20) COLLATE latin1_spanish_ci NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Disponibles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`ID_Equipo`, `Nombre`, `Fabricante`, `NumSerie`, `Cantidad`, `Disponibles`) VALUES
(1, 'Computador Portatil', 'lenovo', 'frf444f4g', 45, 45),
(2, 'Cable HDMI', 'ibm', 'c444v56', 12, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `ID_Evento` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `HoraI` time NOT NULL,
  `HoraF` time NOT NULL,
  `Nombre` char(15) COLLATE latin1_spanish_ci NOT NULL,
  `Lugar` char(15) COLLATE latin1_spanish_ci DEFAULT NULL,
  `ID_Sala` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`ID_Evento`, `Fecha`, `HoraI`, `HoraF`, `Nombre`, `Lugar`, `ID_Sala`) VALUES
(1, '2018-06-01', '07:00:00', '09:00:00', 'Evento1', NULL, 1),
(2, '2018-06-05', '07:00:00', '08:59:00', 'Evento2', NULL, 3),
(3, '2018-06-20', '09:00:00', '11:00:00', 'Evento3', 'lugar1', NULL),
(4, '2018-06-15', '14:00:00', '18:00:00', 'Graduacion', NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `ID_Libro` int(11) NOT NULL,
  `Titulo` char(30) COLLATE latin1_spanish_ci NOT NULL,
  `Autor` char(30) COLLATE latin1_spanish_ci NOT NULL,
  `ISBN` char(20) COLLATE latin1_spanish_ci NOT NULL,
  `Edicion` char(20) COLLATE latin1_spanish_ci NOT NULL,
  `Editorial` char(30) COLLATE latin1_spanish_ci NOT NULL,
  `Paginas` int(11) NOT NULL,
  `Copias` int(11) NOT NULL,
  `Disponibles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`ID_Libro`, `Titulo`, `Autor`, `ISBN`, `Edicion`, `Editorial`, `Paginas`, `Copias`, `Disponibles`) VALUES
(1, 'Cien aÃ±os de soledad', 'Garcia Marquez', 'd44d44d4', '1ra Edicion', 'pepitos', 506, 9, 9),
(2, 'SAO 17', 'Reki kawahara', '4f44ff4f', '2da Edicion', 'ABvEC', 325, 10, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamoequipo`
--

CREATE TABLE `prestamoequipo` (
  `ID_Usuario` int(11) NOT NULL,
  `ID_Equipo` int(11) NOT NULL,
  `FechaInicio` datetime NOT NULL,
  `FechaFinal` datetime NOT NULL,
  `Tiempo` int(11) NOT NULL,
  `Reporte` int(11) NOT NULL,
  `Estado` char(15) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `prestamoequipo`
--

INSERT INTO `prestamoequipo` (`ID_Usuario`, `ID_Equipo`, `FechaInicio`, `FechaFinal`, `Tiempo`, `Reporte`, `Estado`) VALUES
(3, 1, '2018-06-01 17:33:58', '2018-06-02 17:33:58', 24, 6, 'devuelto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamolibro`
--

CREATE TABLE `prestamolibro` (
  `ID_Usuario` int(11) NOT NULL,
  `ID_Libro` int(11) NOT NULL,
  `FechaInicio` datetime NOT NULL,
  `FechaFinal` datetime NOT NULL,
  `Tiempo` int(11) NOT NULL,
  `Reporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamosala`
--

CREATE TABLE `prestamosala` (
  `ID_PrestamoSala` int(11) NOT NULL,
  `ID_Usuario` int(11) NOT NULL,
  `ID_Sala` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `HoraI` time NOT NULL,
  `HoraF` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `prestamosala`
--

INSERT INTO `prestamosala` (`ID_PrestamoSala`, `ID_Usuario`, `ID_Sala`, `Fecha`, `HoraI`, `HoraF`) VALUES
(1, 1, 2, '2018-06-07', '07:30:00', '11:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salas`
--

CREATE TABLE `salas` (
  `ID_Sala` int(11) NOT NULL,
  `Nombre` char(15) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `salas`
--

INSERT INTO `salas` (`ID_Sala`, `Nombre`) VALUES
(1, 'Sala1'),
(2, 'Sala2'),
(3, 'Sala3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudequipo`
--

CREATE TABLE `solicitudequipo` (
  `ID_Usuario` int(11) NOT NULL,
  `ID_Equipo` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Estado` enum('espera','aceptada','rechazada') COLLATE latin1_spanish_ci NOT NULL,
  `Motivo` char(50) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `solicitudequipo`
--

INSERT INTO `solicitudequipo` (`ID_Usuario`, `ID_Equipo`, `Fecha`, `Estado`, `Motivo`) VALUES
(3, 1, '2018-06-01 17:33:58', 'aceptada', ''),
(3, 2, '2018-06-01 17:34:24', 'espera', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudlibro`
--

CREATE TABLE `solicitudlibro` (
  `ID_Usuario` int(11) NOT NULL,
  `ID_Libro` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Estado` enum('espera','aceptada','rechazada') COLLATE latin1_spanish_ci NOT NULL,
  `Motivo` char(50) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `solicitudlibro`
--

INSERT INTO `solicitudlibro` (`ID_Usuario`, `ID_Libro`, `Fecha`, `Estado`, `Motivo`) VALUES
(3, 2, '2018-06-01 17:34:14', 'espera', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudsala`
--

CREATE TABLE `solicitudsala` (
  `ID_SolicitudSala` int(11) NOT NULL,
  `ID_Usuario` int(11) NOT NULL,
  `ID_Sala` int(11) NOT NULL,
  `Estado` enum('espera','aceptada','rechazada') COLLATE latin1_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `HoraI` time NOT NULL,
  `HoraF` time NOT NULL,
  `Motivo` char(30) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `solicitudsala`
--

INSERT INTO `solicitudsala` (`ID_SolicitudSala`, `ID_Usuario`, `ID_Sala`, `Estado`, `Fecha`, `HoraI`, `HoraF`, `Motivo`) VALUES
(1, 1, 1, 'espera', '2018-06-02', '18:00:00', '20:00:00', NULL),
(2, 1, 2, 'aceptada', '2018-06-07', '07:30:00', '11:00:00', ''),
(3, 1, 3, 'espera', '2018-06-05', '12:00:00', '14:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_Usuario` int(11) NOT NULL,
  `Nombre` char(15) COLLATE latin1_spanish_ci NOT NULL,
  `Correo` char(20) COLLATE latin1_spanish_ci NOT NULL,
  `Contrasena` char(20) COLLATE latin1_spanish_ci NOT NULL,
  `Rol` char(20) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_Usuario`, `Nombre`, `Correo`, `Contrasena`, `Rol`) VALUES
(1, 'User1', 'user1@gmail.com', 'user1', 'User'),
(2, 'Admin1', 'admin1@gmail.com', 'admin1', 'Admin'),
(3, 'millos', 'niseandres@gmail.com', 'millos123', 'User');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariosxevento`
--

CREATE TABLE `usuariosxevento` (
  `ID_Evento` int(11) NOT NULL,
  `ID_Usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuariosxevento`
--

INSERT INTO `usuariosxevento` (`ID_Evento`, `ID_Usuario`) VALUES
(1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`ID_Equipo`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`ID_Evento`),
  ADD KEY `ID_Sala` (`ID_Sala`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`ID_Libro`);

--
-- Indices de la tabla `prestamoequipo`
--
ALTER TABLE `prestamoequipo`
  ADD PRIMARY KEY (`ID_Usuario`,`ID_Equipo`),
  ADD KEY `ID_Equipo` (`ID_Equipo`);

--
-- Indices de la tabla `prestamolibro`
--
ALTER TABLE `prestamolibro`
  ADD PRIMARY KEY (`ID_Usuario`,`ID_Libro`),
  ADD KEY `ID_Libro` (`ID_Libro`);

--
-- Indices de la tabla `prestamosala`
--
ALTER TABLE `prestamosala`
  ADD PRIMARY KEY (`ID_PrestamoSala`,`ID_Usuario`,`ID_Sala`),
  ADD KEY `ID_Usuario` (`ID_Usuario`),
  ADD KEY `ID_Sala` (`ID_Sala`);

--
-- Indices de la tabla `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`ID_Sala`);

--
-- Indices de la tabla `solicitudequipo`
--
ALTER TABLE `solicitudequipo`
  ADD PRIMARY KEY (`ID_Usuario`,`ID_Equipo`),
  ADD KEY `ID_Equipo` (`ID_Equipo`);

--
-- Indices de la tabla `solicitudlibro`
--
ALTER TABLE `solicitudlibro`
  ADD PRIMARY KEY (`ID_Usuario`,`ID_Libro`),
  ADD KEY `ID_Libro` (`ID_Libro`);

--
-- Indices de la tabla `solicitudsala`
--
ALTER TABLE `solicitudsala`
  ADD PRIMARY KEY (`ID_SolicitudSala`,`ID_Usuario`,`ID_Sala`),
  ADD KEY `ID_Usuario` (`ID_Usuario`),
  ADD KEY `ID_Sala` (`ID_Sala`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_Usuario`),
  ADD UNIQUE KEY `Nombre` (`Nombre`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- Indices de la tabla `usuariosxevento`
--
ALTER TABLE `usuariosxevento`
  ADD PRIMARY KEY (`ID_Evento`,`ID_Usuario`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `ID_Equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `ID_Evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `ID_Libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `prestamosala`
--
ALTER TABLE `prestamosala`
  MODIFY `ID_PrestamoSala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `salas`
--
ALTER TABLE `salas`
  MODIFY `ID_Sala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `solicitudsala`
--
ALTER TABLE `solicitudsala`
  MODIFY `ID_SolicitudSala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`ID_Sala`) REFERENCES `salas` (`ID_Sala`) ON DELETE CASCADE;

--
-- Filtros para la tabla `prestamoequipo`
--
ALTER TABLE `prestamoequipo`
  ADD CONSTRAINT `prestamoequipo_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `prestamoequipo_ibfk_2` FOREIGN KEY (`ID_Equipo`) REFERENCES `equipos` (`ID_Equipo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `prestamolibro`
--
ALTER TABLE `prestamolibro`
  ADD CONSTRAINT `prestamolibro_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `prestamolibro_ibfk_2` FOREIGN KEY (`ID_Libro`) REFERENCES `libros` (`ID_Libro`) ON DELETE CASCADE;

--
-- Filtros para la tabla `prestamosala`
--
ALTER TABLE `prestamosala`
  ADD CONSTRAINT `prestamosala_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `prestamosala_ibfk_2` FOREIGN KEY (`ID_Sala`) REFERENCES `salas` (`ID_Sala`) ON DELETE CASCADE;

--
-- Filtros para la tabla `solicitudequipo`
--
ALTER TABLE `solicitudequipo`
  ADD CONSTRAINT `solicitudequipo_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `solicitudequipo_ibfk_2` FOREIGN KEY (`ID_Equipo`) REFERENCES `equipos` (`ID_Equipo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `solicitudlibro`
--
ALTER TABLE `solicitudlibro`
  ADD CONSTRAINT `solicitudlibro_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `solicitudlibro_ibfk_2` FOREIGN KEY (`ID_Libro`) REFERENCES `libros` (`ID_Libro`) ON DELETE CASCADE;

--
-- Filtros para la tabla `solicitudsala`
--
ALTER TABLE `solicitudsala`
  ADD CONSTRAINT `solicitudsala_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `solicitudsala_ibfk_2` FOREIGN KEY (`ID_Sala`) REFERENCES `salas` (`ID_Sala`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuariosxevento`
--
ALTER TABLE `usuariosxevento`
  ADD CONSTRAINT `usuariosxevento_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID_Usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuariosxevento_ibfk_2` FOREIGN KEY (`ID_Evento`) REFERENCES `eventos` (`ID_Evento`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
