-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2018 a las 03:39:33
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `posmarket_db`
--
CREATE DATABASE IF NOT EXISTS `posmarket_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `posmarket_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `medio_pago_id` int(10) UNSIGNED NOT NULL,
  `producto_id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `valor_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `cantidad`, `fecha`, `medio_pago_id`, `producto_id`, `usuario_id`, `valor_total`) VALUES
(3, 20, '2018-11-25', 1, 7, 21, 22000),
(4, 25, '2018-11-25', 1, 8, 21, 37500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medios_pago`
--

CREATE TABLE `medios_pago` (
  `id` int(10) UNSIGNED NOT NULL,
  `medio` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `medios_pago`
--

INSERT INTO `medios_pago` (`id`, `medio`) VALUES
(1, 'Efectivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `oferta` int(11) NOT NULL,
  `tamano` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_producto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `precio`, `cantidad`, `oferta`, `tamano`, `tipo_producto`, `imagen`, `activo`) VALUES
(7, 'Arroz1', 'Arroz', 1200, 10, 0, 'PequeÃ±o', 'Comida', '/img/334568145953_p3_master1200.jpg', 1),
(8, 'Lentejas1', 'Lentejas', 1800, 20, 0, 'PequeÃ±o', 'Comida', '/img/83259171403_p0.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id` int(10) UNSIGNED NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `producto_id` int(10) UNSIGNED DEFAULT NULL,
  `tipo_reporte_id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `rol` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol`) VALUES
(1, 'Admin'),
(2, 'Usuario'),
(3, 'Proveedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_reportes`
--

CREATE TABLE `tipo_reportes` (
  `id` int(10) UNSIGNED NOT NULL,
  `reporte` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_reportes`
--

INSERT INTO `tipo_reportes` (`id`, `reporte`) VALUES
(1, 'Contacto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cedula` int(11) NOT NULL,
  `celular` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contrasena` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `apellido`, `cedula`, `celular`, `ciudad`, `contrasena`, `correo`, `direccion`, `nombre`, `rol_id`) VALUES
(1, 'Posmarket', 123, '123', 'Cali', 'e10adc3949ba59abbe56e057f20f883e', 'admin@hotmail.com', 'Carrera a', 'Admin', 1),
(21, 'Prueba', 456, '123456', 'Medellin', 'e10adc3949ba59abbe56e057f20f883e', 'proveedor@hotmail.com', 'Carrera d', 'Proveedor', 3),
(22, 'Prueba', 4567, '123456', 'Bogota', 'e10adc3949ba59abbe56e057f20f883e', 'usuario@hotmail.com', 'Carrera b', 'Usuario', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `medio_pago_id` int(10) UNSIGNED NOT NULL,
  `datos` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `valor_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `fecha`, `medio_pago_id`, `datos`, `usuario_id`, `valor_total`) VALUES
(18, '2018-11-25 05:00:00', 1, 'a:2:{i:0;a:3:{s:2:\"id\";s:1:\"8\";s:5:\"valor\";s:4:\"1800\";s:8:\"cantidad\";s:1:\"3\";}i:1;a:3:{s:2:\"id\";s:1:\"7\";s:5:\"valor\";s:4:\"1200\";s:8:\"cantidad\";s:1:\"8\";}}', 22, 15000);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compras_producto_id_foreign` (`producto_id`),
  ADD KEY `compras_medio_pago_id_foreign` (`medio_pago_id`),
  ADD KEY `compras_usuario_id_foreign` (`usuario_id`);

--
-- Indices de la tabla `medios_pago`
--
ALTER TABLE `medios_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productos_codigo_unique` (`codigo`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reportes_usuario_id_foreign` (`usuario_id`),
  ADD KEY `reportes_tipo_reporte_id_foreign` (`tipo_reporte_id`),
  ADD KEY `reportes_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_reportes`
--
ALTER TABLE `tipo_reportes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuarios_cedula_unique` (`cedula`),
  ADD UNIQUE KEY `usuarios_correo_unique` (`correo`),
  ADD KEY `usuarios_rol_id_foreign` (`rol_id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_producto_id_foreign` (`datos`(191)),
  ADD KEY `ventas_medio_pago_id_foreign` (`medio_pago_id`),
  ADD KEY `ventas_usuario_id_foreign` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `medios_pago`
--
ALTER TABLE `medios_pago`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_reportes`
--
ALTER TABLE `tipo_reportes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_medio_pago_id_foreign` FOREIGN KEY (`medio_pago_id`) REFERENCES `medios_pago` (`id`),
  ADD CONSTRAINT `compras_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `compras_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `reportes_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `reportes_tipo_reporte_id_foreign` FOREIGN KEY (`tipo_reporte_id`) REFERENCES `tipo_reportes` (`id`),
  ADD CONSTRAINT `reportes_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_medio_pago_id_foreign` FOREIGN KEY (`medio_pago_id`) REFERENCES `medios_pago` (`id`),
  ADD CONSTRAINT `ventas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
