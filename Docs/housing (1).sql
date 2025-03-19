-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 19, 2025 at 03:51 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `housing`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `admin_user_id` int NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `priv` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`admin_user_id`, `email`, `password`, `priv`) VALUES
(1, 'adam.watkin@rolsa.com', '$2y$10$/jAZ0ShSHck0XSFJgX14Ru328zcNoPneDcQWdzsmxkuTplUDcfKqe', 'SUPER');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int NOT NULL,
  `made_on` int NOT NULL,
  `consult_date` int NOT NULL,
  `user_id` int NOT NULL,
  `staff_id` int NOT NULL,
  `product` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int NOT NULL,
  `f_name` text NOT NULL,
  `s_name` text NOT NULL,
  `role` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `created_on` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `f_name`, `s_name`, `role`, `email`, `password`, `created_on`) VALUES
(1, 'James', 'Barowik', 'INSTALLER', 'j.b@rolsa.com', '$2y$10$7aeebYWzSiIIpt0H.F.VDOWbOXcnP8SuQOuImMdMcfy58b8XlqPji', 1742219097),
(2, 'Adamski', 'Watkinski', 'CONSULTANT', 'adam.watkin@rzl.com', '$2y$10$JJtQrmTULIJpL/RsZruZLuqtRnVerBOZb9urHdNCi8CI.eHQyUvM2', 1742395856);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `f_name` text NOT NULL,
  `s_name` text NOT NULL,
  `addressln1` text NOT NULL,
  `addressln2` text NOT NULL,
  `city` text NOT NULL,
  `postcode` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `f_name`, `s_name`, `addressln1`, `addressln2`, `city`, `postcode`, `email`, `phone`, `password`) VALUES
(1, 'Adam', 'Watkin', '1 Housey', 'house', 'Barnsl', 'S70 3RS', 'adam.watkin@r.com', '07989898', '$2y$10$g2cRbzWpkkgF9Vkt003rO.CykvqH4v9YGQUgzwMCH1PW7OPN7GkqO'),
(2, 'Albert', 'Albertson', 'ss', 'ss', 'ssd', 'dffgg', 'albet@r.com', '567987', '$2y$10$KBrCP5/aAlThxQ.uoCbtE.G7qw0kKgtmg15iZ9vY1Ry/nsr3emOKu'),
(3, 'James', 'vb', 'wefd', 'qwedf', 'wef', 'werf', 'j.b@r.com', '3e4t', '$2y$10$6H4W4uzhzKNk1MRHE5lszeeq5fFGZzgsJG6.LChTUpVTUyaYJTQfG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`admin_user_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `admin_user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
