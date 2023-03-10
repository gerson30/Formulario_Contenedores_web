-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2022 a las 18:19:29
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `brinsa_formulario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_formularios`
--

CREATE TABLE `tb_formularios` (
  `id` int(11) NOT NULL,
  `pregunta_1` varchar(100) NOT NULL,
  `pregunta_2` varchar(100) NOT NULL,
  `pregunta_3` varchar(100) NOT NULL,
  `pregunta_4` varchar(100) NOT NULL,
  `pregunta_5` varchar(100) NOT NULL,
  `pregunta_6` varchar(100) NOT NULL,
  `pregunta_7` varchar(100) NOT NULL,
  `pregunta_8` varchar(100) NOT NULL,
  `persona_inspeccion` varchar(100) NOT NULL,
  `punto_recoleccion` varchar(100) NOT NULL,
  `foto1` varchar(250) NOT NULL,
  `foto2` varchar(250) NOT NULL,
  `foto3` varchar(250) NOT NULL,
  `observaciones` varchar(220) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_formularios`
--

INSERT INTO `tb_formularios` (`id`, `pregunta_1`, `pregunta_2`, `pregunta_3`, `pregunta_4`, `pregunta_5`, `pregunta_6`, `pregunta_7`, `pregunta_8`, `persona_inspeccion`, `punto_recoleccion`, `foto1`, `foto2`, `foto3`, `observaciones`) VALUES
(1, 'NO', 'NO', 'SI', 'SI', 'NO', 'SI', 'SI', 'SI', 'PEPITO', 'fisica', '1666212975_yo.jpg', '', '', 'ghhfgh'),
(7, 'SI', 'SI', 'SI', 'SI', 'SI', 'SI', 'SI', 'SI', 'PEPITO', 'analisis', '1666214844_bingo.png', '1666214844_imagen_oncor.png', '1666214844_logosimbolo_oncor_circle.png', 'prueba ti '),
(8, 'SI', 'SI', 'SI', 'SI', 'SI', '', '', 'SI', 'Wilson ', '', '1666361291_16663612578825027298978177807581.jpg', '1666361291_16663612688771019441344748936254.jpg', '1666361291_16663612776433638853635312221448.jpg', 'Wjsjsis'),
(11, 'SI', 'NO', 'NO', 'NO', 'NO', 'SI', 'SI', 'SI', 'Prueba', 'programacion', '1666383156_LyT.png', '1666383156_Oncor.png', '1666383156_LyT.png', 'Hola');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_formularios`
--
ALTER TABLE `tb_formularios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_formularios`
--
ALTER TABLE `tb_formularios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
