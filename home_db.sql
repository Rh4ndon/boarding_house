-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 02, 2023 at 05:12 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `home_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
('BcjKNX58e4x7bIqIvxG7', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997');

-- --------------------------------------------------------

--
-- Table structure for table `approve`
--

DROP TABLE IF EXISTS `approve`;
CREATE TABLE IF NOT EXISTS `approve` (
  `id` varchar(50) NOT NULL,
  `property_id` varchar(50) NOT NULL,
  `renter` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `ratings` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `approve`
--

INSERT INTO `approve` (`id`, `property_id`, `renter`, `owner`, `ratings`) VALUES
('0Dl6QhssqcEWf79tvWXP', 'JXpm4n6hpMlOZbl9SfAH', '0Qk9wgxOEenKMQ4peDQP', 'fKGM7HUgKqacGCfqRTmZ', 'none yet!');

-- --------------------------------------------------------

--
-- Table structure for table `bir`
--

DROP TABLE IF EXISTS `bir`;
CREATE TABLE IF NOT EXISTS `bir` (
  `id` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `img_src` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bir`
--

INSERT INTO `bir` (`id`, `owner`, `img_src`) VALUES
('YdhSRh32PnUl1wMeoaBw', 'fKGM7HUgKqacGCfqRTmZ', 'uploaded_files/Screenshot 2023-11-02 124448.png');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `number`, `message`) VALUES
('2hOIKBUIamvLttCvij7Z', 'Renter', 'renter@gmail.com', '0998765432', 'Hey'),
('LMrPj4gO9mSKv2w5WlfS', 'Someone ', 'some@gmail.com', '0912398765', 'Yow');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` varchar(50) NOT NULL,
  `property_id` varchar(50) NOT NULL,
  `renter` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `img_src` varchar(50) NOT NULL,
  `date_request` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

DROP TABLE IF EXISTS `property`;
CREATE TABLE IF NOT EXISTS `property` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `property_name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `price` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `offer` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `rooms` varchar(50) NOT NULL,
  `deposite` varchar(50) NOT NULL,
  `bedroom` varchar(50) NOT NULL,
  `bathroom` varchar(50) NOT NULL,
  `availability` varchar(50) NOT NULL,
  `wifi_connection` varchar(50) NOT NULL,
  `water_supply` varchar(50) NOT NULL,
  `electricity` varchar(50) NOT NULL,
  `parking_area` varchar(50) NOT NULL,
  `school_area` varchar(50) NOT NULL,
  `image_01` varchar(50) NOT NULL,
  `image_02` varchar(50) NOT NULL,
  `image_03` varchar(50) NOT NULL,
  `image_04` varchar(50) NOT NULL,
  `image_05` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `user_id`, `property_name`, `address`, `price`, `type`, `offer`, `status`, `rooms`, `deposite`, `bedroom`, `bathroom`, `availability`, `wifi_connection`, `water_supply`, `electricity`, `parking_area`, `school_area`, `image_01`, `image_02`, `image_03`, `image_04`, `image_05`, `description`, `date`) VALUES
('JXpm4n6hpMlOZbl9SfAH', 'fKGM7HUgKqacGCfqRTmZ', 'Example Boarding House', 'Some Home Town', '500', 'house', 'rent', 'ready to move', '1', '1000', '1', '1', '1', 'yes', 'yes', 'yes', 'yes', 'yes', 'boQzZFJjQUfargnLHFfI.jpg', '', '', '', '', 'Something', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `renters`
--

DROP TABLE IF EXISTS `renters`;
CREATE TABLE IF NOT EXISTS `renters` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `renters`
--

INSERT INTO `renters` (`id`, `name`, `number`, `email`, `password`) VALUES
('0Qk9wgxOEenKMQ4peDQP', 'Renter', '0998765432', 'renter@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b');

-- --------------------------------------------------------

--
-- Table structure for table `renters_payment`
--

DROP TABLE IF EXISTS `renters_payment`;
CREATE TABLE IF NOT EXISTS `renters_payment` (
  `id` varchar(50) NOT NULL,
  `property_id` varchar(50) NOT NULL,
  `renter` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `proof` varchar(1000) NOT NULL,
  `date_of` varchar(1000) NOT NULL,
  `remarks` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `renters_payment`
--

INSERT INTO `renters_payment` (`id`, `property_id`, `renter`, `owner`, `amount`, `proof`, `date_of`, `remarks`) VALUES
('Dit53Wih8UP6G6N6hiqc', 'JXpm4n6hpMlOZbl9SfAH', '0Qk9wgxOEenKMQ4peDQP', 'fKGM7HUgKqacGCfqRTmZ', '', 'uploaded_files/Screenshot 2023-10-29 104700.png', '10-29-23', 'payment received'),
('xjrdrx20QweHoOXOnFiz', 'JXpm4n6hpMlOZbl9SfAH', '0Qk9wgxOEenKMQ4peDQP', 'fKGM7HUgKqacGCfqRTmZ', '', 'uploaded_files/Screenshot 2023-10-29 104700.png', '10-29-23', 'payment received'),
('voAD1XsMtIUiFFBK5RSG', 'JXpm4n6hpMlOZbl9SfAH', '0Qk9wgxOEenKMQ4peDQP', 'fKGM7HUgKqacGCfqRTmZ', '1000', 'uploaded_files/Screenshot 2023-10-29 104700.png', '10-29-23', 'payment received'),
('NqRGJ5H6rMwyFVdhQeXS', 'JXpm4n6hpMlOZbl9SfAH', '0Qk9wgxOEenKMQ4peDQP', 'fKGM7HUgKqacGCfqRTmZ', '1000', 'uploaded_files/Screenshot 2023-10-29 104700.png', '10-29-23', 'payment received'),
('0Dl6QhssqcEWf79tvWXP', 'JXpm4n6hpMlOZbl9SfAH', '0Qk9wgxOEenKMQ4peDQP', 'fKGM7HUgKqacGCfqRTmZ', '1000', 'uploaded_files/Screenshot 2023-10-29 051400.png', '10-29-23', 'payment received');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
CREATE TABLE IF NOT EXISTS `requests` (
  `id` varchar(20) NOT NULL,
  `property_id` varchar(20) NOT NULL,
  `sender` varchar(20) NOT NULL,
  `receiver` varchar(20) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved`
--

DROP TABLE IF EXISTS `saved`;
CREATE TABLE IF NOT EXISTS `saved` (
  `id` varchar(20) NOT NULL,
  `property_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `remarks` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `number`, `email`, `password`, `remarks`) VALUES
('fKGM7HUgKqacGCfqRTmZ', 'Sample', '0912345678', 'example@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
