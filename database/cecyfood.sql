-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2026 a las 20:24:37
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
-- Base de datos: `cecyfood`
--
CREATE DATABASE IF NOT EXISTS `cecyfood` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cecyfood`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Hamburguesas'),
(2, 'Tortas'),
(3, 'Tacos'),
(4, 'Burritos'),
(5, 'Molletes'),
(6, 'Bebidas'),
(7, 'Comidas Completas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id`, `pedido_id`, `producto_id`, `cantidad`, `subtotal`) VALUES
(1, 1, 4, 1, 25.00),
(2, 1, 2, 1, 30.00),
(3, 1, 8, 1, 20.00),
(4, 2, 1, 1, 25.00),
(5, 2, 7, 1, 25.00),
(6, 3, 7, 4, 100.00),
(7, 3, 6, 2, 60.00),
(8, 3, 3, 2, 60.00),
(9, 4, 4, 1, 25.00),
(10, 4, 5, 1, 30.00),
(11, 5, 2, 2, 60.00),
(12, 6, 4, 1, 25.00),
(13, 7, 4, 1, 25.00),
(14, 8, 4, 1, 25.00),
(15, 9, 6, 2, 60.00),
(16, 9, 3, 3, 90.00),
(17, 10, 3, 1, 30.00),
(18, 10, 2, 1, 30.00),
(19, 11, 3, 1, 30.00),
(20, 12, 1, 1, 25.00),
(21, 13, 4, 1, 25.00),
(22, 14, 4, 1, 25.00),
(23, 14, 5, 1, 30.00),
(24, 15, 3, 3, 90.00),
(25, 16, 5, 1, 30.00),
(26, 17, 2, 1, 30.00),
(27, 18, 10, 1, 65.00),
(28, 18, 5, 1, 30.00),
(29, 19, 4, 1, 25.00),
(30, 20, 8, 1, 20.00),
(31, 21, 2, 1, 30.00),
(32, 22, 3, 1, 30.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`id`, `usuario_id`, `producto_id`) VALUES
(36, 2, 1),
(30, 2, 3),
(31, 2, 5),
(32, 2, 7),
(35, 2, 10),
(34, 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado` enum('pendiente','Preparando','Listo','Entregado') DEFAULT 'pendiente',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `metodo_pago` enum('Efectivo','Tarjeta') DEFAULT 'Efectivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `total`, `estado`, `fecha`, `metodo_pago`) VALUES
(1, 2, 75.00, 'Entregado', '2026-06-11 02:57:18', 'Efectivo'),
(2, 2, 50.00, 'Entregado', '2026-06-11 04:39:44', 'Efectivo'),
(3, 2, 220.00, 'Entregado', '2026-06-11 04:42:04', 'Efectivo'),
(4, 2, 55.00, 'Entregado', '2026-06-12 01:53:41', 'Efectivo'),
(5, 2, 60.00, 'Entregado', '2026-06-14 19:44:09', 'Efectivo'),
(6, 3, 25.00, 'Entregado', '2026-06-19 04:01:59', 'Efectivo'),
(7, 2, 25.00, 'Entregado', '2026-06-25 02:41:38', 'Efectivo'),
(8, 2, 25.00, 'Entregado', '2026-06-25 02:41:49', 'Tarjeta'),
(9, 2, 150.00, 'Entregado', '2026-06-25 02:53:52', 'Tarjeta'),
(10, 2, 60.00, 'pendiente', '2026-06-25 03:21:05', 'Efectivo'),
(11, 2, 30.00, 'pendiente', '2026-06-25 03:29:34', 'Efectivo'),
(12, 2, 25.00, 'pendiente', '2026-06-25 03:40:56', 'Efectivo'),
(13, 2, 25.00, 'pendiente', '2026-06-25 03:49:46', 'Efectivo'),
(14, 2, 55.00, 'pendiente', '2026-06-25 03:50:13', 'Efectivo'),
(15, 2, 90.00, 'pendiente', '2026-06-25 04:11:02', 'Efectivo'),
(16, 2, 30.00, 'Entregado', '2026-06-25 04:12:02', 'Tarjeta'),
(17, 2, 30.00, 'pendiente', '2026-06-26 03:46:55', 'Efectivo'),
(18, 2, 95.00, 'pendiente', '2026-06-26 05:28:34', 'Efectivo'),
(19, 2, 25.00, 'pendiente', '2026-06-26 05:31:13', 'Efectivo'),
(20, 2, 20.00, 'pendiente', '2026-06-26 05:34:41', 'Efectivo'),
(21, 2, 30.00, 'Preparando', '2026-06-26 05:40:23', 'Efectivo'),
(22, 2, 30.00, 'Entregado', '2026-06-26 05:42:12', 'Efectivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(500) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT 50
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `categoria_id`, `stock`) VALUES
(1, 'Hamburguesa de Res', 'Hambueguesa con queso y carne', 25.00, 'hamburguesa.jpg', 1, 0),
(2, 'Torta de Milanesa', 'Torta de Milanesa', 30.00, 'milanesa.jpg', 2, 47),
(3, 'Torta Española', 'Torta Española', 30.00, 'española.jpg', 2, 44),
(4, 'Tacos Campechanos', 'Tacos Campechanos con papas', 25.00, 'campechanos.jpg', 3, 47),
(5, 'Burrito', 'Burrito de carne asada', 30.00, 'burrito.jpg', 4, 47),
(6, 'Molletes', 'Molletes con carne y queso', 30.00, 'molletes.jpg', 5, 50),
(7, 'Agua de Jamaica', 'Agua de jamaica de 1L', 25.00, 'jamaica.jpg', 6, 50),
(8, 'Refresco', '600ml', 20.00, 'refresco.jpg', 6, 49),
(10, 'Comida Completa - Milanesa', 'Milanesa de pollo con arroz, ensalada fresca y agua natural.', 65.00, 'comida_completa_milanesa.jpg', 7, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `satisfaccion`
--

CREATE TABLE `satisfaccion` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `calificacion` int(11) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `satisfaccion`
--

INSERT INTO `satisfaccion` (`id`, `pedido_id`, `usuario_id`, `calificacion`, `comentario`, `fecha`) VALUES
(1, 16, 2, 5, 'hiola', '2026-06-26 02:50:30'),
(2, 4, 2, 5, 'Gkv', '2026-06-26 02:51:06'),
(3, 1, 2, 5, 'F', '2026-06-26 02:56:54'),
(4, 2, 2, 0, 'fggbh', '2026-06-26 02:57:18'),
(5, 3, 2, 5, 'sdf', '2026-06-26 03:00:55'),
(6, 8, 2, 4, 'asf', '2026-06-26 03:02:29'),
(7, 9, 2, 3, 'asg', '2026-06-26 03:04:18'),
(8, 5, 2, 3, 'sf', '2026-06-26 03:05:03'),
(9, 7, 2, 2, 'ASf', '2026-06-26 03:07:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `numero_control` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('cliente','admin') DEFAULT 'cliente',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `numero_control`, `password`, `rol`, `fecha_registro`) VALUES
(1, 'Fabian Garcia Solis', '23415082110489', '$2y$10$8Htbqsd9M8biQutCXohFru/S4fkdbwJAdZkMj.ozVLqz4INJByiu6', 'admin', '2026-05-30 23:27:59'),
(2, 'Angel Lona', '123456789', '$2y$10$6ESdxAZqMztH3a/QPztPneSaraUP3YGnD5CODKdx456Orr1oFmA22', 'cliente', '2026-06-10 16:57:18'),
(3, 'Ismael', '222222212', '$2y$10$Hdc8NkKLH9mK.bkHq/geO.rZL7CQYx.jNJKz5Gc.Nd7IULssqCcsa', 'cliente', '2026-06-19 04:00:50');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `detalle_pedido_ibfk_2` (`producto_id`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`,`producto_id`),
  ADD KEY `favoritos_ibfk_2` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `satisfaccion`
--
ALTER TABLE `satisfaccion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_control` (`numero_control`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `satisfaccion`
--
ALTER TABLE `satisfaccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
