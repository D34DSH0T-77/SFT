-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql-deadshot.alwaysdata.net
-- Generation Time: Dec 11, 2025 at 09:34 PM
-- Server version: 10.11.14-MariaDB
-- PHP Version: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deadshot_tortas`
--

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `apellido` text DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `estado`) VALUES
(1, 's', 's', 'Activo'),
(2, 'Lebrons', 'James', 'Activo'),
(4, 'jon', 'wick', 'Activo'),
(5, 'aa', 'aa', 'Activo'),
(6, 'bs', 'bs', 'Activo'),
(8, 'whis', 'sa', 'Inactivo');

-- --------------------------------------------------------

--
-- Table structure for table `detalles_entrada`
--

CREATE TABLE `detalles_entrada` (
  `id` int(11) NOT NULL,
  `id_entrada` int(11) DEFAULT NULL,
  `id_torta` int(11) DEFAULT NULL,
  `precio_bs` decimal(10,2) DEFAULT NULL,
  `precio_usd` decimal(10,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detalles_factura`
--

CREATE TABLE `detalles_factura` (
  `id` int(11) NOT NULL,
  `id_torta` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `id_factura` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entradas`
--

CREATE TABLE `entradas` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `local` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Dumping data for table `entradas`
--

INSERT INTO `entradas` (`id`, `codigo`, `fecha`, `local`) VALUES
(1, 'wewdd', '2025-04-20 00:00:00', 'sisa');

-- --------------------------------------------------------

--
-- Table structure for table `factura`
--

CREATE TABLE `factura` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hola`
--

CREATE TABLE `hola` (
  `id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lotes`
--

CREATE TABLE `lotes` (
  `id` int(11) NOT NULL,
  `id_torta` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pago`
--

CREATE TABLE `pago` (
  `id` int(11) NOT NULL,
  `id_factura` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `metodo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `si`
--

CREATE TABLE `si` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tortas`
--

CREATE TABLE `tortas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `img` varchar(50) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Dumping data for table `tortas`
--

INSERT INTO `tortas` (`id`, `nombre`, `precio`, `img`, `estado`) VALUES
(1, 'pablo', 1.00, 'src/Assets/img/tortas/torta_1764360259.jpg', 'Activo'),
(5, 'Torta de Arequipesss', 1.80, 'src/Assets/img/tortas/torta_1764360347.png', 'Inactivo'),
(7, 'sssss', 2.00, '', 'Activo'),
(11, 'torta', 12.00, NULL, 'Activo'),
(14, 'si', 2.00, 'src/Assets/img/tortas/torta_1764358290.jpg', 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `apellido` text DEFAULT NULL,
  `usuario` text DEFAULT NULL,
  `cedula` varchar(50) DEFAULT NULL,
  `rol` enum('Admin','Usuario') DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `usuario`, `cedula`, `rol`, `estado`) VALUES
(2, 'Joyner', 'C', 'DeadShot', '1234', 'Admin', 'Activo'),
(5, 'User', 'de prueba', 'root', '12345678', 'Usuario', 'Activo'),
(9, 'Rafael', 'Alvarado', 'kestico23', '31042140', 'Admin', 'Activo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `detalles_entrada`
--
ALTER TABLE `detalles_entrada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_detalles_entrada_tortas` (`id_torta`),
  ADD KEY `FK_detalles_entrada_entradas` (`id_entrada`);

--
-- Indexes for table `detalles_factura`
--
ALTER TABLE `detalles_factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_detalles_factura_tortas` (`id_torta`),
  ADD KEY `FK_detalles_factura_factura` (`id_factura`);

--
-- Indexes for table `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_factura_clientes` (`id_cliente`);

--
-- Indexes for table `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_lotes_tortas` (`id_torta`);

--
-- Indexes for table `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_pago_factura` (`id_factura`);

--
-- Indexes for table `tortas`
--
ALTER TABLE `tortas`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `usuario` (`usuario`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `detalles_entrada`
--
ALTER TABLE `detalles_entrada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detalles_factura`
--
ALTER TABLE `detalles_factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lotes`
--
ALTER TABLE `lotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pago`
--
ALTER TABLE `pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tortas`
--
ALTER TABLE `tortas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detalles_entrada`
--
ALTER TABLE `detalles_entrada`
  ADD CONSTRAINT `FK_detalles_entrada_entradas` FOREIGN KEY (`id_entrada`) REFERENCES `entradas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_detalles_entrada_tortas` FOREIGN KEY (`id_torta`) REFERENCES `tortas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `detalles_factura`
--
ALTER TABLE `detalles_factura`
  ADD CONSTRAINT `FK_detalles_factura_factura` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_detalles_factura_tortas` FOREIGN KEY (`id_torta`) REFERENCES `tortas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `FK_factura_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lotes`
--
ALTER TABLE `lotes`
  ADD CONSTRAINT `FK_lotes_tortas` FOREIGN KEY (`id_torta`) REFERENCES `tortas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `FK_pago_factura` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
