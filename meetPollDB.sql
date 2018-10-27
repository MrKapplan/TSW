-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-10-2018 a las 00:34:58
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.0.32

DROP DATABASE IF EXISTS MEETPOLL;
CREATE DATABASE IF NOT EXISTS MEETPOLL;
USE MEETPOLL;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `MEETPOLL`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gap`
--

CREATE TABLE IF NOT EXISTS `gap` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `timeStart` time NOT NULL,
  `timeEnd` time NOT NULL,
  `poll_id` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `gap`
--

INSERT INTO `gap` (`id`, `date`, `timeStart`, `timeEnd`, `poll_id`) VALUES
(1, '2018-09-27', '10:00:00', '11:00:00', 1),
(2, '2018-09-28', '15:00:00', '16:00:00', 1),
(3, '2018-09-29', '16:00:00', '17:00:00', 1),
(4, '2018-10-01', '09:00:00', '10:00:00', 1),
(5, '2018-10-11', '13:00:00', '16:00:00', 2),
(6, '2018-10-18', '13:00:00', '16:00:00', 2),
(7, '2018-10-25', '20:00:00', '22:00:00', 2),
(8, '2018-12-01', '10:30:00', '14:30:00', 3),
(9, '2018-12-01', '16:00:00', '20:00:00', 3),
(10, '2018-12-11', '09:00:00', '10:00:00', 4),
(11, '2018-12-21', '09:00:00', '10:00:00', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poll`
--

CREATE TABLE IF NOT EXISTS `poll` (
  `id` int(11) NOT NULL,
  `title` varchar(225) NOT NULL,
  `ubication` varchar(225) DEFAULT NULL,
  `author` varchar(25) NOT NULL,
  `link` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `poll`
--

INSERT INTO `poll` (`id`, `title`, `ubication`, `author`, `link`) VALUES
(1, 'Reunión de desarrolladores', 'Despacho 23', 'mpegea', 'ec819428960921f0cc1ce29022d26862'),
(2, 'Churrasco AMPA', 'Casa de Julián', 'albovy', '208872e6934784b6844c0394eed87e99'),
(3, 'Trail Ribeira Sacra', 'Parada do Sil, Ourense', 'mpegea', 'b7a34489ac1bbb0bfad1a1a46c01ad0f'),
(4, 'Entrenamientos semana 12', 'Campo de O Couto', 'ivandd', '32237d5e7fb42892fd766692010996b4'),
(5, 'Quedada graduados 2014/15', 'Bar Graduado', 'ivandd', '39b656378545d9ff04282e0b7dbe3f12'),
(6, 'Magostos 2018', 'Finca de Javier', 'mpegea', 'f1188203ff33e591ffc4e877ec978682');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(25) NOT NULL,
  `passwd` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`username`, `passwd`) VALUES
('admin', 'admin'),
('albovy', 'redteamwins'),
('ivandd', 'ivan'),
('mpegea', 'pimpam');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_selects_gap`
--

CREATE TABLE IF NOT EXISTS `user_selects_gap` (
  `username` varchar(25) NOT NULL,
  `gap_id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user_selects_gap`
--

INSERT INTO `user_selects_gap` (`username`, `gap_id`, `poll_id`) VALUES
('albovy', 1, 1),
('albovy', 2, 1),
('albovy', 3, 1),
('albovy', 4, 1),
('albovy', 5, 2),
('albovy', 6, 2),
('albovy', 8, 3),
('albovy', 9, 3),
('ivandd', 1, 1),
('ivandd', 3, 1),
('ivandd', 5, 2),
('ivandd', 6, 2),
('ivandd', 8, 3),
('ivandd', 9, 3),
('mpegea', 1, 1),
('mpegea', 2, 1),
('mpegea', 5, 2),
('mpegea', 8, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `gap`
--
ALTER TABLE `gap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poll_id` (`poll_id`);

--
-- Indices de la tabla `poll`
--
ALTER TABLE `poll`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `link` (`link`),
  ADD KEY `author` (`author`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `user_selects_gap`
--
ALTER TABLE `user_selects_gap`
  ADD PRIMARY KEY (`username`,`gap_id`,`poll_id`),
  ADD KEY `gap_id` (`gap_id`),
  ADD KEY `poll_id` (`poll_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `gap`
--
ALTER TABLE `gap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `poll`
--
ALTER TABLE `poll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `gap`
--
ALTER TABLE `gap`
  ADD CONSTRAINT `gap_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `poll` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `poll`
--
ALTER TABLE `poll`
  ADD CONSTRAINT `poll_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_selects_gap`
--
ALTER TABLE `user_selects_gap`
  ADD CONSTRAINT `user_selects_gap_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_selects_gap_ibfk_2` FOREIGN KEY (`gap_id`) REFERENCES `gap` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_selects_gap_ibfk_3` FOREIGN KEY (`poll_id`) REFERENCES `poll` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
