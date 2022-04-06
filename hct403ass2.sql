-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2022 at 03:48 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hct403ass2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cables`
--

CREATE TABLE `cables` (
  `id` int(5) NOT NULL,
  `name` varchar(60) NOT NULL,
  `stationId` int(11) NOT NULL,
  `lineString` linestring DEFAULT NULL,
  `cableId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cables`
--

INSERT INTO `cables` (`id`, `name`, `stationId`, `lineString`, `cableId`) VALUES
(1, 'Arundel cable 1', 1, 0x0000000001020000000400000060a0b5ec5ac431c0a35c7578630a3f409b374e0af3d431c0c05f27501f0c3f40effa71a02cc131c04867052bf3ff3e402d25cb4928c731c039190bf956023f40, 1),
(2, 'Cable 57', 1, 0x0000000001020000000500000060a0b5ec5ac431c0a35c7578630a3f409b374e0af3d431c0c05f27501f0c3f40effa71a02cc131c04867052bf3ff3e402d25cb4928c731c039190bf956023f404f1e166a4d2534c001ace9d55b963c40, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stations`
--

CREATE TABLE `stations` (
  `id` int(5) NOT NULL,
  `name` varchar(60) NOT NULL,
  `pointLocation` point NOT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stations`
--

INSERT INTO `stations` (`id`, `name`, `pointLocation`, `address`) VALUES
(1, 'Arundel Station', 0x000000000101000000a35c7578630a3f4060a0b5ec5ac431c0, 'Arundel Station'),
(2, 'Marondera Station', 0x0000000001010000002761f07a7a8c3f40ba55c675423032c0, '12 Marondera road '),
(3, 'Bulawayo Station', 0x00000000010100000001ace9d55b963c404f1e166a4d2534c0, '12 khumalo road , Bulawayo'),
(6, 'Mutoko Station', 0x000000000101000000eb483f2b7a1c4040f6c99b0d436731c0, 'Mutoko road '),
(7, 'Murehwa Station', 0x00000000010100000044d5f90159c73f401f4718ab72a631c0, 'Murehwa Center');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `active`, `created_on`) VALUES
(1, 'Blessing', 'blessing@gmail.com', '1234567', 0, '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cables`
--
ALTER TABLE `cables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cables`
--
ALTER TABLE `cables`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stations`
--
ALTER TABLE `stations`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
