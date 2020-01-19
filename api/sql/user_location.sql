-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Tempo de geração: 18-Jan-2020 às 21:30
-- Versão do servidor: 8.0.18
-- versão do PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Banco de dados: `omnistack`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_location`
--

DROP TABLE IF EXISTS `user_location`;
CREATE TABLE IF NOT EXISTS `user_location` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(10) NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address_line` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address_number` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address_complement` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address_city` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address_state` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address_country` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `latitude` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `longitude` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;
