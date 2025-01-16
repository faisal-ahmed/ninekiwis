-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 16, 2025 at 01:44 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ninekiwis`
--
CREATE DATABASE IF NOT EXISTS `ninekiwis` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ninekiwis`;

-- --------------------------------------------------------

--
-- Table structure for table `nk_category`
--

CREATE TABLE `nk_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nk_category`
--

INSERT INTO `nk_category` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Women\'s clothing & shoes', 'Female Cloth', '2025-01-12 12:52:30', '2025-01-16 13:42:03'),
(2, 'Men\'s clothing & shoes', 'Male Cloth', '2025-01-12 12:52:30', '2025-01-16 13:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `nk_personal_info`
--

CREATE TABLE `nk_personal_info` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT '',
  `lastname` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nk_personal_info`
--

INSERT INTO `nk_personal_info` (`id`, `user_id`, `firstname`, `lastname`) VALUES
(1, 1, 'Mohammad Faisal', 'Ahmed');

-- --------------------------------------------------------

--
-- Table structure for table `nk_product`
--

CREATE TABLE `nk_product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) DEFAULT '0',
  `category_id` int(11) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nk_product`
--

INSERT INTO `nk_product` (`id`, `name`, `description`, `price`, `stock_quantity`, `category_id`, `sku`, `image_url`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Red Coat', 'Colorful Rain Coat', '500.00', 1000, 2, 'TP002', 'http://localhost/ninekiwis/product_images/1736693859.jpg', 'Active', '2025-01-12 14:57:39', '2025-01-16 13:39:01'),
(4, 'T-Shirt Horse', 'My T-Shirt', '200.00', 200, 1, 'TS005', 'http://localhost/ninekiwis/product_images/1736694321.jpg', 'Active', '2025-01-12 15:05:21', '2025-01-13 14:08:06'),
(6, 'T-Shirt Jacket', 'My Personal T-Shirt', '500.00', 200, 2, 'TS006', 'http://localhost/ninekiwis/product_images/1736945455.webp', 'Active', '2025-01-12 15:05:21', '2025-01-16 13:40:54'),
(7, 'Jacket with Color', 'Different Color Jacket', '1000.00', 100, 1, 'TP007', 'http://localhost/ninekiwis/product_images/1736945455.webp', 'Active', '2025-01-15 12:50:55', '2025-01-15 12:50:55');

-- --------------------------------------------------------

--
-- Table structure for table `nk_users`
--

CREATE TABLE `nk_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `last_logged_in` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_time` bigint(20) DEFAULT NULL,
  `modified_time` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nk_users`
--

INSERT INTO `nk_users` (`id`, `email`, `password`, `last_logged_in`, `created_time`, `modified_time`) VALUES
(1, 'ninekiwis@gmail.com', '5d41402abc4b2a76b9719d911017c592', '2025-01-11 13:46:04', 1736603138, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nk_category`
--
ALTER TABLE `nk_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nk_personal_info`
--
ALTER TABLE `nk_personal_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nk_product`
--
ALTER TABLE `nk_product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `nk_users`
--
ALTER TABLE `nk_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nk_category`
--
ALTER TABLE `nk_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nk_personal_info`
--
ALTER TABLE `nk_personal_info`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nk_product`
--
ALTER TABLE `nk_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `nk_users`
--
ALTER TABLE `nk_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nk_product`
--
ALTER TABLE `nk_product`
  ADD CONSTRAINT `nk_product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `nk_category` (`id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
