-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 24-06-2012 a las 21:06:24
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sisco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frecuencia_organismo`
--

CREATE TABLE IF NOT EXISTS `frecuencia_organismo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organismo_id` int(11) NOT NULL,
  `frecuencia_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organismo_id` (`organismo_id`,`frecuencia_id`),
  KEY `frecuencia_id` (`frecuencia_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `frecuencia_organismo`
--
ALTER TABLE `frecuencia_organismo`
  ADD CONSTRAINT `frecuencia_organismo_ibfk_3` FOREIGN KEY (`organismo_id`) REFERENCES `organismo` (`id`),
  ADD CONSTRAINT `frecuencia_organismo_ibfk_2` FOREIGN KEY (`frecuencia_id`) REFERENCES `frecuencia` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
