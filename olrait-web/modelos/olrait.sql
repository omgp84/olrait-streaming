-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 02, 2017 at 03:14 
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `olrait`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Videojuegos'),
(2, 'Motor'),
(3, 'Música'),
(4, 'Moda'),
(5, 'Deportes'),
(6, 'Cine'),
(7, 'Literatura'),
(8, 'Documentales'),
(9, 'Educación'),
(10, 'Política');

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `valor` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `nombre`, `valor`) VALUES
(1, 'facebook', 'https://www.facebook.com/olrait'),
(2, 'twitter', 'https://www.twitter.com/olrait'),
(3, 'linkedin', 'https://www.linkedin.com/olrait');

-- --------------------------------------------------------

--
-- Table structure for table `grupos`
--

CREATE TABLE `grupos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `grupos`
--

INSERT INTO `grupos` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Editor'),
(3, 'Streamer'),
(4, 'Espectador');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre_usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `correo` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` longtext COLLATE utf8_spanish_ci,
  `grupo` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `titulo_canal` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion_canal` longtext COLLATE utf8_spanish_ci,
  `imagen_canal` text COLLATE utf8_spanish_ci,
  `visitas` int(11) NOT NULL,
  `votos` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `emitiendo` tinyint(1) NOT NULL,
  `imagen_perfil` text COLLATE utf8_spanish_ci,
  `token` text COLLATE utf8_spanish_ci NOT NULL,
  `token_creado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tipo_emision` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `contrasena`, `nombre`, `correo`, `descripcion`, `grupo`, `fecha_creacion`, `titulo_canal`, `descripcion_canal`, `imagen_canal`, `visitas`, `votos`, `id_categoria`, `emitiendo`, `imagen_perfil`, `token`, `token_creado`, `tipo_emision`) VALUES
(1, 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Administrador', 'admin@olrait.com', '¡Soy administrador! ¡Olrait!', 1, '2017-02-16 17:41:37', 'AdminTV', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'joe.png', 0, 0, 1, 1, '', '2ef0e80d8c0bc6e6696662acaf84fd418008ed39b2d71805db6dcb0d2e0a957981b87f7a1c24d2aaf863724dbee9c4673c6796018a9570f9b1346658be6208ed', '2017-04-02 13:11:24', '1'),
(2, 'editor', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Editor', 'editor@olrait.com', 'Lorem ipsum dolor sit amet.', 2, '2017-02-16 17:41:37', 'Canal de editor', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'joe.png', 0, 0, 1, 1, '', '0bd3936d0d741b0c189b1b8954ca532b29afda1af5434945d7c999669ddddc7a7dc6f6c5d62eb0fc703d3c79256d12e878af0c89f3e2c8bc0ec6bf59382e4836', '2017-04-02 11:04:29', '2'),
(3, 'streamer', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Streamer', 'streamer@olrait.com', 'Lorem ipsum dolor sit amet.', 3, '2017-02-16 17:42:26', 'Canal de streamer', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '', 0, 0, 1, 1, '', '261c82aca5d4657df5fc97b7f3915264469bc606fc7eb31fd9042c66c9f83d5f182b305279c8bab2a2fa008a84ec25258499649131c183099d7d57e887197d42', '2017-04-02 13:06:25', '1'),
(4, 'usuario', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Usuario', 'usuario@olrait.com', 'Lorem ipsum dolor sit amet.', 4, '2017-03-01 18:38:14', 'Canal de Usuario', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '', 0, 0, 4, 1, '', 'bfe080a2e1a5ce0e7841db6a8352c66f780dc50234336d9e3e6cc27c4d572dae6ac8c94c898b2b9a825c9ccc5b86be1d0a309296e8977cfc504dc72babc51864', '2017-04-02 13:05:27', ''),
(5, 'antonio', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Antonio', 'antonio@olrait.com', 'Lorem ipsum dolor sit amet.', 4, '2017-03-01 18:38:14', 'Canal de Antonio', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '', 0, 0, 5, 1, '', '', '0000-00-00 00:00:00', ''),
(6, 'andres', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Andres', 'andres@olrait.com', 'Lorem ipsum dolor sit amet.', 4, '2017-03-01 18:42:07', 'Canal de Andrés', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '', 0, 0, 6, 1, '', '', '0000-00-00 00:00:00', ''),
(7, 'carlos', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Carlos', 'carlos@olrait.com', 'Lorem ipsum dolor sit amet.', 4, '2017-03-01 18:42:07', 'Canal de Carlos', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '', 0, 0, 7, 1, '', '', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_pendientes`
--

CREATE TABLE `usuarios_pendientes` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre_usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `correo` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` longtext COLLATE utf8_spanish_ci,
  `grupo` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `titulo_canal` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion_canal` longtext COLLATE utf8_spanish_ci,
  `imagen_canal` text COLLATE utf8_spanish_ci,
  `visitas` int(11) NOT NULL,
  `votos` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `emitiendo` tinyint(1) NOT NULL,
  `imagen_perfil` text COLLATE utf8_spanish_ci,
  `token` text COLLATE utf8_spanish_ci NOT NULL,
  `token_creado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tipo_emision` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios_pendientes`
--
ALTER TABLE `usuarios_pendientes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `usuarios_pendientes`
--
ALTER TABLE `usuarios_pendientes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
