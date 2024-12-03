-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-12-2024 a las 22:06:45
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_smartkey`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones`
--

CREATE TABLE `acciones` (
  `id` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `on1` tinyint(1) NOT NULL,
  `start1` tinyint(1) NOT NULL,
  `off1` tinyint(1) NOT NULL,
  `opendoor` tinyint(1) NOT NULL,
  `closedoor` tinyint(1) NOT NULL,
  `latitud` decimal(10,8) NOT NULL,
  `longitud` decimal(11,8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acciones`
--

INSERT INTO `acciones` (`id`, `fecha_hora`, `id_usuario`, `on1`, `start1`, `off1`, `opendoor`, `closedoor`, `latitud`, `longitud`) VALUES
(1, '2024-11-20 12:34:56', 1, 1, 0, 0, 1, 0, -12.04637400, -77.04279300),
(2, '2024-11-20 12:34:56', 1, 1, 0, 0, 1, 0, -12.04637400, -77.04279300),
(3, '2024-11-20 12:34:56', 8, 1, 0, 0, 1, 0, -12.04637400, -77.04279300),
(4, '2024-11-19 12:34:56', 10, 1, 0, 0, 1, 0, -12.04637400, -77.04279300),
(5, '2024-11-19 12:34:56', 12, 1, 0, 0, 1, 0, -12.04637400, -77.04279300),
(6, '2024-11-20 12:34:56', 1, 1, 0, 0, 1, 0, -12.04637400, -77.04279300),
(7, '2024-11-20 12:00:00', 4, 1, 0, 1, 1, 0, -12.04637400, -77.04279300),
(8, '2024-11-20 10:00:00', 4, 1, 0, 1, 1, 0, -12.04637400, -77.04279300),
(9, '2024-11-20 11:00:00', 5, 0, 1, 0, 0, 1, -12.04537400, -77.04269300),
(10, '2024-11-20 12:00:00', 6, 1, 1, 1, 1, 1, -12.04737400, -77.04379300),
(11, '2024-11-19 14:30:00', 7, 0, 0, 1, 1, 0, -12.04617400, -77.04389300),
(12, '2024-11-19 15:00:00', 8, 1, 1, 0, 0, 1, -12.04597400, -77.04409300),
(13, '2024-11-20 16:00:00', 9, 1, 0, 1, 1, 0, -12.04557400, -77.04549300),
(14, '2024-11-20 17:30:00', 10, 1, 1, 1, 0, 1, -12.04517400, -77.04659300),
(15, '2024-11-19 18:00:00', 11, 0, 0, 1, 1, 0, -12.04507400, -77.04779300),
(16, '2024-11-19 19:00:00', 12, 1, 1, 0, 0, 1, -12.04497400, -77.04889300),
(17, '2024-11-20 20:30:00', 13, 0, 1, 1, 1, 0, -12.04457400, -77.04909300),
(18, '2024-11-20 21:00:00', 14, 1, 0, 1, 0, 1, -12.04397400, -77.05029300),
(19, '2024-11-19 22:00:00', 15, 1, 1, 0, 1, 0, -12.04347400, -77.05149300),
(20, '2024-11-20 23:00:00', 16, 0, 0, 1, 1, 0, -12.04307400, -77.05269300),
(21, '2024-11-19 11:30:00', 17, 1, 1, 0, 0, 1, -12.04267400, -77.05379300),
(22, '2024-11-20 10:30:00', 18, 1, 0, 1, 1, 0, -12.04217400, -77.05489300),
(23, '2024-11-19 13:00:00', 19, 1, 1, 1, 0, 1, -12.04167400, -77.05599300),
(24, '2024-11-20 14:00:00', 20, 0, 1, 0, 1, 0, -12.04117400, -77.05609300),
(25, '2024-11-19 15:30:00', 21, 1, 0, 1, 1, 0, -12.04067400, -77.05719300),
(26, '2024-11-20 10:00:00', 4, 1, 0, 1, 1, 0, -9.97020500, -76.24289900),
(27, '2024-11-20 11:00:00', 5, 0, 1, 0, 0, 1, -9.96903500, -76.24031500),
(28, '2024-11-20 12:00:00', 6, 1, 1, 1, 1, 1, -9.96810200, -76.24301300),
(29, '2024-11-19 14:30:00', 7, 0, 0, 1, 1, 0, -9.96774400, -76.24452200),
(30, '2024-11-19 15:00:00', 8, 1, 1, 0, 0, 1, -9.96551200, -76.24145300),
(31, '2024-11-20 16:00:00', 9, 1, 0, 1, 1, 0, -9.96337500, -76.23967800),
(32, '2024-11-20 17:30:00', 10, 1, 1, 1, 0, 1, -9.96018900, -76.23705100),
(33, '2024-11-19 18:00:00', 11, 0, 0, 1, 1, 0, -9.95854300, -76.23456700),
(34, '2024-11-19 19:00:00', 12, 1, 1, 0, 0, 1, -9.95703400, -76.23089400),
(35, '2024-11-20 20:30:00', 13, 0, 1, 1, 1, 0, -9.95567600, -76.23211400),
(36, '2024-11-20 21:00:00', 14, 1, 0, 1, 0, 1, -9.95385500, -76.23001600),
(37, '2024-11-19 22:00:00', 15, 1, 1, 0, 1, 0, -9.95224200, -76.22889700),
(38, '2024-11-19 22:00:00', 15, 1, 1, 0, 1, 0, -9.95224200, -76.22889700),
(39, '2024-11-20 23:00:00', 16, 0, 0, 1, 1, 0, -9.95050600, -76.22733500),
(40, '2024-11-19 11:30:00', 17, 1, 1, 0, 0, 1, -9.94891800, -76.22576600),
(41, '2024-11-20 10:30:00', 18, 1, 0, 1, 1, 0, -9.94668500, -76.22321900),
(42, '2024-11-19 13:00:00', 19, 1, 1, 1, 0, 1, -9.94452800, -76.22173500),
(43, '2024-11-20 14:00:00', 20, 0, 1, 0, 1, 0, -9.94276300, -76.22044400),
(44, '2024-11-19 15:30:00', 21, 1, 0, 1, 1, 0, -9.94053800, -76.21933400),
(45, '2024-11-20 16:30:00', 22, 1, 1, 1, 1, 1, -9.93924500, -76.21812400),
(46, '2024-11-19 17:00:00', 23, 0, 0, 1, 0, 1, -9.93843400, -76.21750800),
(47, '2024-11-19 18:30:00', 24, 1, 0, 0, 1, 0, -9.93689500, -76.21577100),
(48, '2024-11-20 19:00:00', 25, 1, 1, 1, 0, 1, -9.93476400, -76.21413200),
(49, '2024-11-20 20:00:00', 26, 0, 0, 1, 1, 0, -9.93313400, -76.21348000),
(50, '2024-11-19 21:00:00', 27, 1, 1, 0, 0, 1, -9.93153600, -76.21207200),
(51, '2024-11-19 22:30:00', 28, 0, 1, 0, 1, 0, -9.93001400, -76.21119500),
(52, '2024-11-20 23:30:00', 29, 1, 1, 1, 0, 1, -9.92845100, -76.21048600),
(53, '2024-11-19 09:00:00', 30, 0, 0, 1, 1, 0, -9.92691000, -76.20884900),
(54, '2015-11-30 08:30:05', 25, 0, 1, 1, 0, 1, -9.92869940, -76.23956500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `id_smart` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `nombres`, `clave`, `placa`, `modelo`, `id_smart`) VALUES
(4, 'IanGabriel', 'Ian Gabriel Zuñiga Solano', '$2y$10$GkVjDxrNV8AL1qCdH8DDzeEy1TQm6Mftc0M8HR.au5HNM/LYp6MAu', 'TUMA78', 'Lamborghini Criolla', 155),
(5, 'Jordy78', 'Jordy Steve Morales Chavez', '$2y$10$GZ6/l0Nm/070vZmfkylW9u3pXscIMgiwa6bHDQC7Dlmw4prIu13si', 'KHU-789', 'Totoya Bajito', 502),
(6, 'Jordy78', 'Jordy Steve Morales Chavez', '$2y$10$SxY5AlI0ypy7j4KCf38N5.uBaqDBQJidnNc5uwdpnS8WYsWqjMIT6', 'ATM-108', 'Totoya', 501),
(7, 'Yoyiss78', 'Yoyiss Britney Moreno Jara', '$2y$10$aUXbQSV6Jioud7E6SPosSu6gQd9BGuYk75XD4dSGsSgCVMHZLSzd6', 'YTA-502', 'Mustang', 508),
(8, 'Yoyiss78', 'Yoyiss Britney Moreno Jara', '$2y$10$KM/Fizr6HJIskdz06Ub2lO4iANG47IL6ZrtCZnox7Sq13v5Ku0572', 'YTA-502', 'Mustang', 508),
(9, 'Diego78', 'Diego Fernando', '$2y$10$FWIb8XnQpvsiQoMRwkSkOOK8TrY/DLeD2.Gk.a9lqEDKHcokxig7.', 'KTM-50B', 'Lamborginhi', 780),
(10, 'Camila78', 'Camila Paulino Jara', '$2y$10$KTbhcRw0qQQOhq7k.HxVQezhuqCNQMDnSv29LVq.wWBfk4HqF1skK', 'KAM-502', 'Mustang', 901),
(11, 'Kira78', 'Kira masna', '$2y$10$2gw.2Z4sbP1cq5v8cXSBVuesdHMlk5HjqfbSS3JOZ.KrEbvWjtjpa', 'KIR-456', 'Mustang', 500),
(12, 'Danna78', 'Danna Flores', '$2y$10$g2g3Ynk6j7QSMwYwNrx3g.7kwYtfQ5V08pKoBDLmhCO8BwZiQdDiK', 'DAN-54A', 'Mustang', 400),
(13, 'Gimena78', 'Gimena Vargas', '$2y$10$rce9DgOrCXUlXBu6FJJ4WOcb/FtmPIgnRUnKFcX4JhUJpL6/giqbW', 'GIM-5G5', 'Mustang', 100),
(14, 'Alexito78', 'Alex Silva Haro', '$2y$10$zI0qDjUBowkXEAXjlD0zE.NqLiu7/V2iaCu7iWy1qODfjbFVjFfs.', 'AXP-56G', 'Mustang', 600),
(15, 'asdasd', 'sadd', '$2y$10$09VMx78KjLcIJHlP2Mf0xesL1pac9EbgF19GZy/j2tbNfgLrNxfau', 'sadasd', 'adssdadas', 0),
(16, 'asdasd', 'sadd', '$2y$10$UDxcwLS2efweMtMn80YUGOShdV6Vt9q9v4gZAla/tXTAPsRydEifS', 'sadasd', 'adssdadas', 0),
(17, 'Jhan78', 'Jhan Antonio', '$2y$10$yTLL/VMV6sJBvwTmLs4lnOBA1ZxGjgYuGmKC2Z9./36s0tQSDSdhq', 'KIS-50G', 'Mustang', 400),
(18, 'Gabo78', 'Ian Gabriel Zuñiga Solano', '$2y$10$LCxRvfX5Q8kzWJo70UqGOeo4bJLNvgU8lfuumboxXsKga3Wq//7l6', 'JUS-7S4', 'Mustang', 50),
(19, 'Jose78', 'Jose Silva Haro', '$2y$10$.qrDSRuBQzRBoYbKxwUf2O8sGg7YDh73RK9xdmbt9WyL2Fi8g38va', 'JSP-54S', 'Mustang', 800),
(20, 'Lorena78', 'Lorena SIlva Haro', '$2y$10$6NIyhxMxzuq5JHhINJONSeX9njt9PfbpxuBj.whm3uUg/O/OLytG6', 'KIS-87M', 'Mustang', 60),
(21, 'Jusmer78', 'Jusmer', '$2y$10$HXgWR9c3jAvDtfQAVC85CuPtwz1V72F/vvpUdlppunrzP1jBD2772', 'ATM-45S', 'Mustang', 151),
(22, 'Stefany78', 'Camila Stefany Paulino Jara', '$2y$10$wk1HLZ7hwI/OMypuuROAfej0CzOelyLAV.z4Ho/2P04Oicb/kDuHq', 'STG-54S', 'Lambornginhi', 500),
(23, 'Vamos78', 'Jhons Retoblo Masna', '$2y$10$mMnidpHA2kVRcALW/Gxw9e3heAuLdf6K5Lav7SwGLfAWLn1c5xS3q', 'AKI-85S', 'Mustang', 502),
(24, 'Jordy789', 'Jordy MOrales Chavez', '$2y$10$/gnCJw0lJrSCoudowtrEEuKjCnbqHHJfBVIhOjFkZ8LE.us/xMdly', 'KISM-87S', 'Mustang', 10),
(25, 'Grillo', 'Pepe', '$2y$10$7BEkQOYsQKBFDcgHb5jfwuhWxyrIrwh11S/TMDkRe9CWwOJqWB/Ty', 'CR-1997', 'FJ Cruiser', 2024);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acciones`
--
ALTER TABLE `acciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
