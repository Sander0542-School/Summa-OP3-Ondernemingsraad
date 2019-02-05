-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2019 at 12:22 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ondernemingsraad`
--
CREATE DATABASE IF NOT EXISTS `ondernemingsraad` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ondernemingsraad`;

-- --------------------------------------------------------

--
-- Table structure for table `gebruikers`
--

DROP TABLE IF EXISTS `gebruikers`;
CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL,
  `gebruikersnaam` varchar(25) NOT NULL,
  `voornaam` varchar(150) NOT NULL,
  `achternaam` varchar(250) NOT NULL,
  `groepen` varchar(15000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `gebruikersnaam`, `voornaam`, `achternaam`, `groepen`) VALUES
(1, 'ADMIN', 'Admin', 'Admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stemmen`
--

DROP TABLE IF EXISTS `stemmen`;
CREATE TABLE `stemmen` (
  `id` int(11) NOT NULL,
  `gebruiker_id` int(11) NOT NULL,
  `verkiesbare_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `verkiesbare`
--

DROP TABLE IF EXISTS `verkiesbare`;
CREATE TABLE `verkiesbare` (
  `id` int(11) NOT NULL,
  `gebruiker_id` int(11) NOT NULL,
  `periode_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `periode_einde` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gebruikersnaam` (`gebruikersnaam`);

--
-- Indexes for table `stemmen`
--
ALTER TABLE `stemmen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UniekeStem` (`gebruiker_id`,`verkiesbare_id`) USING BTREE;

--
-- Indexes for table `verkiesbare`
--
ALTER TABLE `verkiesbare`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stemmen`
--
ALTER TABLE `stemmen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `verkiesbare`
--
ALTER TABLE `verkiesbare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
