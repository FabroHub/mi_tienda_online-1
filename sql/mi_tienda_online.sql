-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-09-2024 a las 14:30:12
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

create database mi_tienda_online;
use mi_tienda_online;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL auto_increment primary key,
  `nombre` varchar(256) NOT NULL,
  `apellidos` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL unique key,
  `rol` varchar(256) NOT NULL default 'Usuario',
  `dni` varchar(9) NOT NULL unique key,
  `direccion` varchar(256) NOT NULL,
  `telefono` int(9) NOT NULL,
  `contrasena` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO usuarios (nombre, apellidos, email, rol, dni, direccion, telefono, contrasena) VALUES
('Jorge', 'Fabro García', 'jorge@fabro.com', 'Admin', '12345678A', 'Calle Falsa 123', 123456789, 'admin1'),
('Admin', '', 'admin@admin.com',  'Admin', '98765432B', '', 987654321, 'admin'),
('Juan', 'Pérez López', 'juan@perez.com', 'Usuario', '87654321B', 'Calle Falsa 324', 987654321, '1234');

CREATE TABLE categorias (
  `id` int(11) NOT NULL auto_increment primary key,
  `categorias` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO categorias (categorias) VALUES
('Madera'),
('Herramientas'),
('Ferretería');

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL auto_increment primary key,
  `nombre` varchar(256) NOT NULL,
  `apellidos` varchar(256) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `direccion` varchar(256) NOT NULL,
  `precioTotal` float NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `lineapedidos` (
  `id` int(11) NOT NULL auto_increment primary key,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `productos` (
  `id` int(11) NOT NULL auto_increment primary key unique key,
  `nombre` varchar(256) NOT NULL unique key,
  `precioUnitario` float NOT NULL,
  `imagen` varchar(8000) NOT NULL,  -- Change varbinary to varchar
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO productos(nombre, precioUnitario, imagen, stock) VALUES
('Martillo 005 C', 2.98, 'https://media.adeo.com/marketplace/MKP/86611690/0634dcdca4012f218080243543179ac0.jpeg?width=650&height=650&format=jpg&quality=80&fit=bounds', 27),
('Taladro', 54.99, 'https://media.adeo.com/media/1912628/media.jpg?width=650&height=650&format=jpg&quality=80&fit=bounds', 57),
('Caja DIY de 100 tornillos bicromatados (3,5x16 mm)', 7.52, 'https://media.adeo.com/mkp/5894ecc7e638a92c93376e9533f4d3f2/media.jpg?width=650&height=650&format=jpg&quality=80&fit=bounds', 42),
('Tabla de Roble', 4.93,'https://live.staticflickr.com/2246/1495245032_33ac3e5ee7_c.jpg',  100),
('Pala punta 5501-4 MA.CL', '11.15','https://bellota.b-cdn.net/CMP4506/1/FM3443BI17104_SA_155804_SZ6.png', 10);

create table `procat` (
`id_producto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  PRIMARY KEY (`id_producto`, `id_categoria`),
  FOREIGN KEY (`id_producto`) REFERENCES `productos`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_categoria`) REFERENCES `categorias`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO procat (id_producto, id_categoria) VALUES
(1, 2),
(2, 2),
(3, 3),
(4, 1),
(5, 2);

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL auto_increment primary key,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  FOREIGN KEY (`id_producto`) REFERENCES `productos`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
