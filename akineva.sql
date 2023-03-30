-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-03-2023 a las 23:55:57
-- Versión del servidor: 10.10.2-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `akineva`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellidos`, `email`) VALUES
(11, 'armando', 'jauregui', 'armando@hotmail.com'),
(15, 'Nakano', 'Nino', 'nakano@gmail.com'),
(16, 'Nino', 'Nakano', 'nakano?@gmail.com'),
(24, 'Nino', 'Nakano', 'armando_@hotmail.com'),
(25, 'admin', 'admin', 'admin@hotmail.com'),
(26, 'armando', 'jauregui', 'nekroz@hotmail.com'),
(27, 'sebastian', 'lopez', 'slopez@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `id_transaccion` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id_cliente` varchar(20) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `id_transaccion`, `fecha`, `status`, `email`, `id_cliente`, `total`) VALUES
(18, '6J306929844745547', '2023-03-16 01:06:42', 'COMPLETED', 'sb-xxvgm25289301@personal.example.com', 'GBBQKK6CKTY6G', 34000),
(19, '7NH30689K1253413J', '2023-03-16 01:15:09', 'COMPLETED', 'sb-xxvgm25289301@personal.example.com', 'GBBQKK6CKTY6G', 28000),
(20, '8BT02396NC543503C', '2023-03-16 01:52:56', 'COMPLETED', 'sb-xxvgm25289301@personal.example.com', 'GBBQKK6CKTY6G', 2900),
(21, '6VV38476RU932643G', '2023-03-16 02:07:10', 'COMPLETED', 'sb-xxvgm25289301@personal.example.com', 'GBBQKK6CKTY6G', 20000),
(22, '3KE08847PY383220G', '2023-03-17 23:22:38', 'COMPLETED', 'sb-xxvgm25289301@personal.example.com', 'GBBQKK6CKTY6G', 3500),
(23, '8YS830116W947621R', '2023-03-17 23:24:53', 'COMPLETED', 'sb-xxvgm25289301@personal.example.com', 'GBBQKK6CKTY6G', 10000),
(24, '7S569886421737044', '2023-03-17 23:48:22', 'COMPLETED', 'sb-xxvgm25289301@personal.example.com', 'GBBQKK6CKTY6G', 18000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detai_compra`
--

CREATE TABLE `detai_compra` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detai_compra`
--

INSERT INTO `detai_compra` (`id`, `id_compra`, `id_product`, `nombre`, `precio`, `cantidad`) VALUES
(6, 18, 1, 'Akame', 12000, 2),
(7, 18, 2, 'Rem', 10000, 1),
(8, 19, 2, 'Rem', 10000, 2),
(9, 19, 3, 'erys greyrat', 8000, 1),
(10, 20, 5, 'Nino nakano', 2000, 1),
(11, 20, 4, 'marin kitagawa', 900, 1),
(12, 21, 3, 'erys greyrat', 8000, 1),
(13, 21, 1, 'Akame', 12000, 1),
(14, 22, 8, 'makima', 3500, 1),
(15, 23, 2, 'Rem', 10000, 1),
(16, 24, 2, 'Rem', 10000, 1),
(17, 24, 3, 'erys greyrat', 8000, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name_product` varchar(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `name_product`, `description`, `price`, `stock`, `image`) VALUES
(1, 'Akame', 'figura de akame', 12000, 21, 'Akame.jpg'),
(2, 'Rem', 'figura de rem ', 10000, 12, 'bampresto.jpg'),
(3, 'erys greyrat', 'figura de erys greyrat', 8000, 2, 'figura.jpg'),
(4, 'marin kitagawa', 'figura de marin kitagawa', 900, 5, 'marin.jpg'),
(5, 'Nino nakano', 'figura nendoroid nino nakano', 2000, 5, 'nendo.jpg'),
(6, 'jijo', 'figura', 2300, 23, 'Akame.jpg'),
(7, 'nino', 'figura de nino', 500, 10, 'ninogod.jpg'),
(8, 'makima', 'figura de makima', 3500, 12, 'makima.png'),
(9, 'prueba', 'hola', 500, 10, 'makima.png'),
(10, 'makima', 'prueba', 500, 2, 'makima.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(120) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `activacion` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `usuario`, `password`, `id_cliente`, `activacion`) VALUES
(8, 'Nekroz', '$2y$10$g0q./wBtiK/C.5fUUICi2uMYgaYptlXfWZvAnsyv9foyz7Y80h/B2', 11, 0),
(9, 'Nino', '$2y$10$k.V0on2I1xmOWU7ZXzQf8ec0B9KOnv3xDXDfbuUneKNUg9VJ2N5Ae', 15, 0),
(10, 'ninonakna', '$2y$10$s5Uu.AqfKLebkC8RWPP/2OEAnI9x5/d3P2N2FUTP46dTD7Nc9jQjO', 16, 0),
(11, 'NinoGod', '$2y$10$mvbal2NvDlT2Srq.2apGYuPJs2B1wIjWjRfll85QhMGw8pinbjoy.', 24, 0),
(12, 'admin', '$2y$10$YGGytObn4nJmiQy0cTOwf.oi.TfCrycMGkje45rzKJ0owoLAWJ.SW', 25, 1),
(13, 'Armando', '$2y$10$VeJUp2wx2q0qEltgphNmnuxb4XJnKKUJz6Hq/4jVm8HS16uXF7I/m', 26, 0),
(14, 'sebas2607', '$2y$10$CTjvkwK/LpLha82un6rFl.eDOM8n6.MV5HuobBhZUaWBWJQslI7y2', 27, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `detai_compra`
--
ALTER TABLE `detai_compra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_compra` (`id_compra`),
  ADD KEY `id_product` (`id_product`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `detai_compra`
--
ALTER TABLE `detai_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detai_compra`
--
ALTER TABLE `detai_compra`
  ADD CONSTRAINT `detai_compra_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detai_compra_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
