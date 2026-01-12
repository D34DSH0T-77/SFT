-- --------------------------------------------------------
-- Host:                         mysql-deadshot-77-cjoyner1402-941e.g.aivencloud.com
-- Versión del servidor:         8.0.35 - Source distribution
-- SO del servidor:              Linux
-- HeidiSQL Versión:             12.14.0.7165
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para defaultdb
DROP DATABASE IF EXISTS `defaultdb`;
CREATE DATABASE IF NOT EXISTS `defaultdb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `defaultdb`;

-- Volcando estructura para tabla defaultdb.clientes
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8mb4_spanish2_ci,
  `apellido` text COLLATE utf8mb4_spanish2_ci,
  `estado` enum('Activo','Inactivo') COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- Volcando datos para la tabla defaultdb.clientes: ~13 rows (aproximadamente)
REPLACE INTO `clientes` (`id`, `nombre`, `apellido`, `estado`) VALUES
	(2, 'Lebrons', 'James', 'Activo'),
	(4, 'jon', 'wick', 'Activo'),
	(5, 'aa', 'aa', 'Activo'),
	(6, 'bs', 'bs', 'Activo'),
	(8, 'whis', 'sa', 'Activo'),
	(10, 'pablo', 'perez', 'Activo'),
	(11, 'pablo', 'perez', 'Activo'),
	(12, 'pablo', 'perez', 'Activo'),
	(13, 'si', 'sa', 'Activo'),
	(14, 'francisco', 'milan', 'Activo'),
	(15, 'yes', 'not', 'Activo'),
	(16, 'aaa', 'aaaa', 'Activo'),
	(17, 'ss', 'ss', 'Activo');

-- Volcando estructura para tabla defaultdb.detalles_entrada
DROP TABLE IF EXISTS `detalles_entrada`;
CREATE TABLE IF NOT EXISTS `detalles_entrada` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_entrada` int DEFAULT NULL,
  `id_torta` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_detalles_entrada_tortas` (`id_torta`),
  KEY `FK_detalles_entrada_entradas` (`id_entrada`),
  CONSTRAINT `FK_detalles_entrada_entradas` FOREIGN KEY (`id_entrada`) REFERENCES `entradas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_detalles_entrada_tortas` FOREIGN KEY (`id_torta`) REFERENCES `tortas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- Volcando datos para la tabla defaultdb.detalles_entrada: ~16 rows (aproximadamente)
REPLACE INTO `detalles_entrada` (`id`, `id_entrada`, `id_torta`, `cantidad`) VALUES
	(42, 23, 19, 10),
	(43, 23, 20, 15),
	(44, 24, 19, 13),
	(45, 25, 20, 12),
	(46, 26, 19, 212),
	(47, 27, 20, 11),
	(48, 27, 21, 11),
	(49, 27, 23, 11),
	(50, 28, 20, 12),
	(51, 29, 19, 1),
	(52, 30, 21, 1),
	(53, 31, 20, 15),
	(54, 32, 23, 16),
	(55, 32, 19, 17),
	(56, 33, 20, 1),
	(57, 34, 23, 10),
	(58, 35, 19, 11);

-- Volcando estructura para tabla defaultdb.detalles_factura
DROP TABLE IF EXISTS `detalles_factura`;
CREATE TABLE IF NOT EXISTS `detalles_factura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_torta` int DEFAULT NULL,
  `precio_bs` decimal(10,2) DEFAULT NULL,
  `precio_usd` decimal(10,2) DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `id_factura` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_detalles_factura_tortas` (`id_torta`),
  KEY `FK_detalles_factura_factura` (`id_factura`),
  CONSTRAINT `FK_detalles_factura_factura` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_detalles_factura_tortas` FOREIGN KEY (`id_torta`) REFERENCES `tortas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- Volcando datos para la tabla defaultdb.detalles_factura: ~14 rows (aproximadamente)
REPLACE INTO `detalles_factura` (`id`, `id_torta`, `precio_bs`, `precio_usd`, `cantidad`, `id_factura`) VALUES
	(43, 19, 1057.22, 3.20, 1, 31),
	(44, 19, 1057.22, 3.20, 1, 32),
	(45, 19, 1057.22, 3.20, 1, 33),
	(46, 19, 1057.22, 3.20, 1, 34),
	(47, 19, 1057.22, 3.20, 1, 35),
	(48, 19, 1057.22, 3.20, 1, 36),
	(49, 19, 1057.22, 3.20, 1, 37),
	(50, 19, 1057.22, 3.20, 1, 38),
	(51, 19, 1057.22, 3.20, 1, 39),
	(52, 19, 165.19, 0.50, 1, 40),
	(53, 21, 165.19, 0.50, 1, 41),
	(54, 20, 1651.90, 5.00, 1, 42);

-- Volcando estructura para tabla defaultdb.entradas
DROP TABLE IF EXISTS `entradas`;
CREATE TABLE IF NOT EXISTS `entradas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `local` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `precio_bs` decimal(10,2) DEFAULT NULL,
  `precio_usd` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- Volcando datos para la tabla defaultdb.entradas: ~12 rows (aproximadamente)
REPLACE INTO `entradas` (`id`, `codigo`, `fecha`, `local`, `precio_bs`, `precio_usd`) VALUES
	(23, 'ENT-050126-IDAMR', '2025-06-05 00:00:00', 'El Papa de las Tortas C.A', 3046.80, 10.00),
	(24, 'ENT-050126-JJESH', '2025-11-25 00:00:00', 'El Papa de las Tortas C.A', 1523.40, 5.00),
	(25, 'ENT-050126-N6EZB', '2026-01-05 00:00:00', 'El Papa de las Tortas C.A', 1371.06, 4.50),
	(26, 'ENT-070126-EECV3', '2026-01-07 00:00:00', 'El Papa de las Tortas C.A', 200000.00, 641.27),
	(27, 'ENT-070126-LZYJH', '2026-01-07 00:00:00', 'El Papa de las Tortas C.A', 2500.00, 8.02),
	(28, 'ENT-070126-NAJ5Y', '2026-01-07 00:00:00', 'El Papa de las Tortas C.A', 1559.40, 5.00),
	(29, 'ENT-070126-J38W8', '2026-01-07 00:00:00', 'El Papa de las Tortas C.A', 2222.00, 7.12),
	(30, 'ENT-070126-6D12H', '2026-01-07 00:00:00', 'El Papa de las Tortas C.A', 1559.40, 5.00),
	(31, 'ENT-070126-UERMP', '2026-01-07 00:00:00', 'El Papa de las Tortas C.A', 1247.52, 4.00),
	(32, 'ENT-070126-75DCS', '2026-01-07 00:00:00', 'El Papa de las Tortas C.A', 6237.60, 20.00),
	(33, 'ENT-070126-S2X3D', '2026-01-07 00:00:00', 'El Papa de las Tortas C.A', 123.00, 0.39),
	(34, 'ENT-070126-R3G02', '2026-01-07 00:00:00', 'El Papa de las Tortas C.A', 1559.40, 5.00),
	(35, 'ENT-120126-M7KQH', '2026-01-12 00:00:00', 'El Papa de las Tortas C.A', 3964.56, 12.00);

-- Volcando estructura para tabla defaultdb.factura
DROP TABLE IF EXISTS `factura`;
CREATE TABLE IF NOT EXISTS `factura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int DEFAULT NULL,
  `total_bs` decimal(10,2) NOT NULL,
  `total_usd` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `codigo` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_factura_clientes` (`id_cliente`),
  CONSTRAINT `FK_factura_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- Volcando datos para la tabla defaultdb.factura: ~12 rows (aproximadamente)
REPLACE INTO `factura` (`id`, `id_cliente`, `total_bs`, `total_usd`, `fecha`, `estado`, `codigo`) VALUES
	(31, 4, 1057.22, 3.20, '2026-01-12 21:48:25', 'Completado', 'VEN-120126-B0ADZ'),
	(32, 4, 1057.22, 3.20, '2026-01-12 21:49:11', 'Completado', 'VEN-120126-JTZ44'),
	(33, 4, 1057.22, 3.20, '2026-01-12 21:50:00', 'En proceso', 'VEN-120126-B7EMA'),
	(34, 4, 1057.22, 3.20, '2026-01-12 21:55:37', 'Completado', 'VEN-120126-QR84W'),
	(35, 2, 1057.22, 3.20, '2026-01-12 21:58:39', 'En proceso', 'VEN-120126-8N2R8'),
	(36, 2, 1057.22, 3.20, '2026-01-12 21:59:19', 'En proceso', 'VEN-120126-4GN0A'),
	(37, 4, 1057.22, 3.20, '2026-01-12 22:00:40', 'Completado', 'VEN-120126-T66HD'),
	(38, 2, 1057.22, 3.20, '2026-01-12 22:03:20', 'En proceso', 'VEN-120126-67S6Q'),
	(39, 5, 1057.22, 3.20, '2026-01-12 22:04:35', 'En proceso', 'VEN-120126-70MBP'),
	(40, 2, 165.19, 0.50, '2026-01-12 22:08:18', 'Completado', 'VEN-120126-DX3LN'),
	(41, 4, 165.19, 0.50, '2026-01-12 22:13:23', 'En proceso', 'VEN-120126-WQI62'),
	(42, 6, 1651.90, 5.00, '2026-01-12 22:17:12', 'En proceso', 'VEN-120126-M64K9');

-- Volcando estructura para tabla defaultdb.lotes
DROP TABLE IF EXISTS `lotes`;
CREATE TABLE IF NOT EXISTS `lotes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_torta` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_lotes_tortas` (`id_torta`),
  CONSTRAINT `FK_lotes_tortas` FOREIGN KEY (`id_torta`) REFERENCES `tortas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- Volcando datos para la tabla defaultdb.lotes: ~16 rows (aproximadamente)
REPLACE INTO `lotes` (`id`, `id_torta`, `cantidad`) VALUES
	(28, 19, 0),
	(29, 20, 0),
	(30, 19, 0),
	(31, 20, 0),
	(32, 19, 0),
	(33, 20, 7),
	(34, 21, 9),
	(35, 23, 10),
	(36, 20, 12),
	(37, 19, 1),
	(38, 21, 12),
	(39, 20, 15),
	(40, 23, 16),
	(41, 19, 17),
	(42, 20, 1),
	(43, 23, 10),
	(44, 19, 11);

-- Volcando estructura para tabla defaultdb.pago
DROP TABLE IF EXISTS `pago`;
CREATE TABLE IF NOT EXISTS `pago` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_factura` int DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `metodo` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `tasa` decimal(10,2) DEFAULT '1.00',
  PRIMARY KEY (`id`),
  KEY `FK_pago_factura` (`id_factura`),
  CONSTRAINT `FK_pago_factura` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- Volcando datos para la tabla defaultdb.pago: ~16 rows (aproximadamente)
REPLACE INTO `pago` (`id`, `id_factura`, `monto`, `fecha`, `metodo`, `tasa`) VALUES
	(47, 31, 1057.22, '2026-01-12 21:48:27', 'Efectivo', 1.00),
	(48, 32, 500.00, '2026-01-12 21:49:12', 'Efectivo', 1.00),
	(49, 33, 0.00, '2026-01-12 21:50:01', 'Efectivo', 1.00),
	(50, 34, 500.00, '2026-01-12 21:55:38', 'Efectivo', 1.00),
	(51, 35, 3.00, '2026-01-12 21:58:40', 'Divisa', 1.00),
	(52, 36, 3.00, '2026-01-12 21:59:20', 'Efectivo', 1.00),
	(53, 37, 500.00, '2026-01-12 22:00:41', 'Efectivo', 1.00),
	(54, 38, 3.00, '2026-01-12 22:03:21', 'Efectivo', 1.00),
	(55, 39, 0.00, '2026-01-12 22:04:36', 'Efectivo', 1.00),
	(56, 39, 0.01, '2026-01-12 22:05:04', 'Efectivo', 1.00),
	(57, 39, 0.01, '2026-01-12 22:05:08', 'Efectivo', 1.00),
	(58, 40, 0.50, '2026-01-12 22:08:19', 'Efectivo', 1.00),
	(59, 40, 0.00, '2026-01-12 22:09:52', 'Efectivo', 1.00),
	(60, 41, 0.50, '2026-01-12 22:13:24', 'Efectivo', 1.00),
	(61, 42, 0.15, '2026-01-12 22:17:13', 'Efectivo', 1.00),
	(62, 42, 3.03, '2026-01-12 22:20:45', 'Efectivo', 1.00);

-- Volcando estructura para tabla defaultdb.tortas
DROP TABLE IF EXISTS `tortas`;
CREATE TABLE IF NOT EXISTS `tortas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `img` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- Volcando datos para la tabla defaultdb.tortas: ~4 rows (aproximadamente)
REPLACE INTO `tortas` (`id`, `nombre`, `precio`, `img`, `estado`) VALUES
	(19, 'Torta tres leches', 3.00, '', 'Activo'),
	(20, 'Torta Chocolate', 3.00, '', 'Activo'),
	(21, 'Torta Brauni', 3.00, '', 'Activo'),
	(23, 'Torta Caje <[:v', 3.00, 'src/Assets/img/tortas/torta_1766184407.jpg', 'Activo');

-- Volcando estructura para tabla defaultdb.usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `usuario` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `cedula` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `rol` enum('Admin','Usuario') COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `cedula` (`cedula`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- Volcando datos para la tabla defaultdb.usuarios: ~3 rows (aproximadamente)
REPLACE INTO `usuarios` (`id`, `nombre`, `apellido`, `usuario`, `cedula`, `rol`, `estado`) VALUES
	(2, 'Joyner', 'C', 'DeadShot', '1234', 'Admin', 'Activo'),
	(9, 'Rafael', 'Alvarado', 'kestico23', '31042140', 'Admin', 'Activo'),
	(12, 'root', 'root', 'root', '123456', 'Usuario', 'Activo');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
