-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 04, 2022 at 12:43 AM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoryies`
--

DROP TABLE IF EXISTS `categoryies`;
CREATE TABLE IF NOT EXISTS `categoryies` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ordering` int NOT NULL,
  `visibility` tinyint NOT NULL DEFAULT '0',
  `allow_comment` tinyint NOT NULL DEFAULT '0',
  `allow_ads` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `groub_id` int NOT NULL DEFAULT '0',
  `trust_status` int NOT NULL DEFAULT '0',
  `reg_status` int NOT NULL DEFAULT '0',
  `Date` date NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `email`, `full_name`, `groub_id`, `trust_status`, `reg_status`, `Date`) VALUES
(1, 'Ahmed Al Sharkawy', '35fd9e76b083eee7e8c99059475a28d6fa6de8a2', 'ahmedmaher0110@gmail.com', 'Ahmed Al Sharkawy', 1, 0, 1, '2022-01-02'),
(3, 'Ahmed Al Sharkawy', '35fd9e76b083eee7e8c99059475a28d6fa6de8a2', 'ahmedmaher0110@gmail.com', 'Ahmed Al Sharkawy', 0, 0, 0, '2022-01-02'),
(4, 'Ahmed Maher', 'e53520516845e66a8a353f2fc8c5ffdedc13953d', 'ahmedmaher@gmail.com', 'Ahmed Maher', 0, 0, 0, '2022-01-02'),
(5, 'Rana', '197e05636aeec6bb48702990db9d330fdcf91c29', 'Rana@gmail.com', 'Rana', 0, 0, 0, '2022-01-02');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
