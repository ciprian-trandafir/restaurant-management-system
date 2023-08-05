-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 05, 2023 at 03:39 PM
-- Server version: 5.7.33
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `ID` int(11) NOT NULL,
  `product` varchar(250) NOT NULL,
  `stock` float NOT NULL,
  `measure` varchar(20) NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `date_upd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`ID`, `product`, `stock`, `measure`, `price`, `date_upd`) VALUES
(1, 'potatoes', 98.8, 'kg', 3, '2023-08-03 18:01:32'),
(2, 'onion', 57, 'kg', 2.55, '2023-08-03 18:02:41'),
(3, 'salt', 1.14, 'kg', 1.3, '2023-08-05 15:46:52'),
(4, 'tomatoes', 23.1, 'kg', 6, '2023-08-03 18:04:00'),
(5, 'oil', 1.37, 'l', 8.5, '2023-08-03 18:04:20'),
(6, 'cheese', 0, 'kg', 31, '2023-08-03 18:04:55'),
(7, 'olive', 122.7, 'kg', 1.45, '2023-08-05 15:46:45'),
(8, 'flour', 9.3, 'kg', 2.99, '2023-08-03 18:06:17'),
(9, 'green olives', 24, 'buc', 0.5, '2023-08-03 18:06:39'),
(10, 'spicy salami', 11.8, 'kg', 20, '2023-08-05 15:46:30'),
(11, 'beer', 7, 'buc', 5, '2023-08-05 15:49:13'),
(12, 'water', 616, 'buc', 3.4, '2023-08-05 15:49:28'),
(13, 'lemon', 13, 'buc', 0.9, '2023-08-05 15:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `ID` int(11) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `total` float NOT NULL DEFAULT '0',
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `mentions` varchar(250) NOT NULL,
  `date_add` datetime NOT NULL,
  `date_paid` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`ID`, `ID_user`, `total`, `paid`, `mentions`, `date_add`, `date_paid`) VALUES
(1, 2, 91, 1, 'urgent', '2023-08-03 18:16:36', '2023-08-03 18:21:11'),
(2, 2, 146, 1, 'table 12', '2023-08-05 15:48:49', '2023-08-05 15:53:32'),
(3, 2, 27.4, 0, 'table 23', '2023-08-05 15:51:14', NULL),
(4, 2, 42.4, 1, 'table 1', '2023-08-05 15:53:05', '2023-08-05 15:53:35'),
(5, 2, 28.4, 0, 'table 2', '2023-08-05 15:53:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices_products`
--

CREATE TABLE `invoices_products` (
  `ID` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `id_product` int(11) DEFAULT NULL,
  `id_recipe` int(11) DEFAULT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices_products`
--

INSERT INTO `invoices_products` (`ID`, `id_invoice`, `id_product`, `id_recipe`, `amount`) VALUES
(1, 1, NULL, 2, 2),
(2, 1, NULL, 1, 1),
(3, 2, NULL, 2, 1),
(4, 2, NULL, 1, 2),
(5, 2, NULL, 3, 1),
(6, 3, NULL, 4, 2),
(7, 3, 12, NULL, 1),
(8, 4, 12, NULL, 1),
(9, 4, 11, NULL, 3),
(10, 4, NULL, 4, 2),
(11, 5, NULL, 2, 1),
(12, 5, 12, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kitchen_requests`
--

CREATE TABLE `kitchen_requests` (
  `ID` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `id_recipe` int(11) NOT NULL,
  `request_user` int(11) NOT NULL,
  `respondent_user` int(11) DEFAULT NULL,
  `date_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_finished` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kitchen_requests`
--

INSERT INTO `kitchen_requests` (`ID`, `id_invoice`, `id_recipe`, `request_user`, `respondent_user`, `date_add`, `date_finished`) VALUES
(1, 1, 2, 2, 3, '2023-08-03 18:16:36', '2023-08-03 18:18:39'),
(2, 1, 1, 2, NULL, '2023-08-03 18:16:36', NULL),
(3, 2, 2, 2, 3, '2023-08-05 15:48:49', '2023-08-05 17:19:07'),
(4, 2, 1, 2, NULL, '2023-08-05 15:48:49', NULL),
(5, 2, 3, 2, NULL, '2023-08-05 15:48:49', NULL),
(6, 3, 4, 2, 3, '2023-08-05 15:51:14', '2023-08-05 17:19:09'),
(7, 4, 4, 2, NULL, '2023-08-05 15:53:05', NULL),
(8, 5, 2, 2, NULL, '2023-08-05 15:53:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `ID` int(11) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `action` varchar(250) NOT NULL,
  `details` longtext NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`ID`, `ID_user`, `action`, `details`, `date`) VALUES
(1, 1, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 17:56:29'),
(2, 1, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 17:59:44'),
(3, 1, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:00:13'),
(4, 1, 'insert inventory', 'inserted id 1', '2023-08-03 18:01:32'),
(5, 1, 'insert inventory', 'inserted id 2', '2023-08-03 18:02:41'),
(6, 1, 'insert inventory', 'inserted id 3', '2023-08-03 18:03:25'),
(7, 1, 'insert inventory', 'inserted id 4', '2023-08-03 18:04:00'),
(8, 1, 'insert inventory', 'inserted id 5', '2023-08-03 18:04:20'),
(9, 1, 'insert inventory', 'inserted id 6', '2023-08-03 18:04:55'),
(10, 1, 'insert inventory', 'inserted id 7', '2023-08-03 18:05:41'),
(11, 1, 'insert inventory', 'inserted id 8', '2023-08-03 18:06:17'),
(12, 1, 'insert inventory', 'inserted id 9', '2023-08-03 18:06:39'),
(13, 2, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:07:34'),
(14, 1, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:08:31'),
(15, 1, 'insert recipe', 'inserted id 1', '2023-08-03 18:09:41'),
(16, 1, 'insert ingredient', 'inserted id 1', '2023-08-03 18:10:05'),
(17, 1, 'insert ingredient', 'inserted id 2', '2023-08-03 18:10:10'),
(18, 1, 'update ingredient', 'updated id 2', '2023-08-03 18:10:15'),
(19, 1, 'insert ingredient', 'inserted id 3', '2023-08-03 18:10:21'),
(20, 1, 'insert ingredient', 'inserted id 4', '2023-08-03 18:10:25'),
(21, 1, 'update ingredient', 'updated id 4', '2023-08-03 18:10:33'),
(22, 1, 'insert ingredient', 'inserted id 5', '2023-08-03 18:10:46'),
(23, 1, 'insert ingredient', 'inserted id 6', '2023-08-03 18:10:54'),
(24, 2, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:11:20'),
(25, 1, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:12:48'),
(26, 1, 'insert recipe', 'inserted id 2', '2023-08-03 18:15:11'),
(27, 1, 'insert ingredient', 'inserted id 7', '2023-08-03 18:15:20'),
(28, 1, 'insert ingredient', 'inserted id 8', '2023-08-03 18:15:24'),
(29, 1, 'insert ingredient', 'inserted id 9', '2023-08-03 18:15:30'),
(30, 2, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:15:53'),
(31, 2, 'create invoice', 'created invoice id 1', '2023-08-03 18:16:36'),
(32, 3, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:17:49'),
(33, 3, 'finish kitchen request', 'finish id 1', '2023-08-03 18:18:39'),
(34, 2, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:19:28'),
(35, 3, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:20:07'),
(36, 4, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:20:47'),
(37, 2, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:21:04'),
(38, 2, 'pay invoice', 'paid invoice id 1', '2023-08-03 18:21:11'),
(39, 3, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:22:06'),
(40, 1, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:22:19'),
(41, 1, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:22:37'),
(42, 1, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:23:05'),
(43, 1, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 18:36:39'),
(44, 1, 'login', 'logged in from IP 127.0.0.1', '2023-08-03 19:12:30'),
(45, 1, 'login', 'logged in from IP 127.0.0.1', '2023-08-05 15:39:34'),
(46, 1, 'insert inventory', 'inserted id 10', '2023-08-05 15:42:50'),
(47, 1, 'insert recipe', 'inserted id 3', '2023-08-05 15:43:13'),
(48, 1, 'insert ingredient', 'inserted id 10', '2023-08-05 15:43:34'),
(49, 1, 'update ingredient', 'updated id 10', '2023-08-05 15:43:43'),
(50, 1, 'insert ingredient', 'inserted id 11', '2023-08-05 15:44:12'),
(51, 1, 'insert ingredient', 'inserted id 12', '2023-08-05 15:44:16'),
(52, 1, 'insert ingredient', 'inserted id 13', '2023-08-05 15:44:41'),
(53, 1, 'update ingredient', 'updated id 13', '2023-08-05 15:44:47'),
(54, 1, 'update ingredient', 'updated id 13', '2023-08-05 15:44:51'),
(55, 2, 'login', 'logged in from IP 127.0.0.1', '2023-08-05 15:45:38'),
(56, 1, 'login', 'logged in from IP 127.0.0.1', '2023-08-05 15:46:17'),
(57, 1, 'update inventory', 'updated price - id 10', '2023-08-05 15:46:30'),
(58, 1, 'update inventory', 'updated stock - id 10', '2023-08-05 15:46:30'),
(59, 1, 'update inventory', 'updated price - id 7', '2023-08-05 15:46:45'),
(60, 1, 'update inventory', 'updated stock - id 7', '2023-08-05 15:46:45'),
(61, 1, 'update inventory', 'updated price - id 3', '2023-08-05 15:46:52'),
(62, 1, 'update inventory', 'updated stock - id 3', '2023-08-05 15:46:52'),
(63, 2, 'login', 'logged in from IP 127.0.0.1', '2023-08-05 15:46:58'),
(64, 1, 'update ingredient', 'updated id 11', '2023-08-05 15:47:59'),
(65, 1, 'update ingredient', 'updated id 10', '2023-08-05 15:48:05'),
(66, 2, 'create invoice', 'created invoice id 2', '2023-08-05 15:48:49'),
(67, 1, 'insert inventory', 'inserted id 11', '2023-08-05 15:49:13'),
(68, 1, 'insert inventory', 'inserted id 12', '2023-08-05 15:49:28'),
(69, 1, 'insert inventory', 'inserted id 13', '2023-08-05 15:50:00'),
(70, 1, 'insert recipe', 'inserted id 4', '2023-08-05 15:50:17'),
(71, 1, 'insert ingredient', 'inserted id 14', '2023-08-05 15:50:24'),
(72, 1, 'insert ingredient', 'inserted id 15', '2023-08-05 15:50:34'),
(73, 2, 'create invoice', 'created invoice id 3', '2023-08-05 15:51:14'),
(74, 2, 'create invoice', 'created invoice id 4', '2023-08-05 15:53:05'),
(75, 2, 'create invoice', 'created invoice id 5', '2023-08-05 15:53:29'),
(76, 2, 'pay invoice', 'paid invoice id 2', '2023-08-05 15:53:32'),
(77, 2, 'pay invoice', 'paid invoice id 4', '2023-08-05 15:53:35'),
(78, 2, 'login', 'logged in from IP 127.0.0.1', '2023-08-05 15:53:43'),
(79, 2, 'login', 'logged in from IP 127.0.0.1', '2023-08-05 16:08:41'),
(80, 3, 'login', 'logged in from IP 127.0.0.1', '2023-08-05 16:12:32'),
(81, 4, 'login', 'logged in from IP 127.0.0.1', '2023-08-05 16:13:01'),
(82, 1, 'login', 'logged in from IP 127.0.0.1', '2023-08-05 16:27:46'),
(83, 2, 'login', 'logged in from IP 127.0.0.1', '2023-08-05 17:14:28'),
(84, 3, 'login', 'logged in from IP 127.0.0.1', '2023-08-05 17:19:02'),
(85, 3, 'finish kitchen request', 'finish id 3', '2023-08-05 17:19:07'),
(86, 3, 'finish kitchen request', 'finish id 6', '2023-08-05 17:19:09'),
(87, 2, 'login', 'logged in from IP 127.0.0.1', '2023-08-05 17:19:15');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `ID` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `price` float NOT NULL,
  `date_upd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`ID`, `name`, `price`, `date_upd`) VALUES
(1, 'Pizza Napoli', 41, '2023-08-03 18:09:41'),
(2, 'Fries', 25, '2023-08-03 18:15:11'),
(3, 'Pizza Diavola', 39, '2023-08-05 15:43:13'),
(4, 'lemon fresh', 12, '2023-08-05 15:50:17');

-- --------------------------------------------------------

--
-- Table structure for table `recipes_ingredients`
--

CREATE TABLE `recipes_ingredients` (
  `ID` int(11) NOT NULL,
  `id_recipe` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipes_ingredients`
--

INSERT INTO `recipes_ingredients` (`ID`, `id_recipe`, `id_product`, `quantity`) VALUES
(1, 1, 8, 0.8),
(2, 1, 4, 0.3),
(3, 1, 5, 0.1),
(4, 1, 3, 0.05),
(5, 1, 7, 0.15),
(6, 1, 9, 5),
(7, 2, 1, 0.3),
(8, 2, 5, 0.06),
(9, 2, 3, 0.06),
(10, 3, 10, 0.2),
(11, 3, 8, 0.3),
(12, 3, 5, 0.09),
(13, 3, 3, 0.1),
(14, 4, 13, 3),
(15, 4, 12, 0.5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `first_name` varchar(256) NOT NULL,
  `last_name` varchar(256) NOT NULL,
  `password` longtext NOT NULL,
  `email` varchar(256) NOT NULL,
  `access_level` int(11) NOT NULL DEFAULT '-1',
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `first_name`, `last_name`, `password`, `email`, `access_level`, `active`) VALUES
(1, 'Admin', 'Admin', '$2y$10$s8lG9zrXvwrnj3WC3BelKegYDw3yBn0Apibkis9YbFHvVacdzhPgC', 'admin@admin.com', 2, 1),
(2, 'Waiter', 'Waiter', '$2y$10$P69Z7lhhd9LujIZGfbxCHO8TZW7MxeXpSIS752zNzo2h/cLrVbBDi', 'waiter@waiter.com', 1, 1),
(3, 'Chef', 'Chef', '$2y$10$t.2UxQd5bCWoF9OK9BKooOtwDR0BlgnuL1xVAaXBC4vHPkL7.IeiS', 'chef@chef.com', 0, 1),
(4, 'User', 'User', '$2y$10$ZHdmh/D7haanSMWPELPwCenO/uRrbw45Sh23IqFv2ZAVP2Jqh7lOG', 'user@user.com', -1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `invoices_products`
--
ALTER TABLE `invoices_products`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_invoice` (`id_invoice`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_recipe` (`id_recipe`);

--
-- Indexes for table `kitchen_requests`
--
ALTER TABLE `kitchen_requests`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_recipe` (`id_recipe`),
  ADD KEY `request_user` (`request_user`),
  ADD KEY `respondent_user` (`respondent_user`),
  ADD KEY `id_invoice` (`id_invoice`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `recipes_ingredients`
--
ALTER TABLE `recipes_ingredients`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_recipe` (`id_recipe`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoices_products`
--
ALTER TABLE `invoices_products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kitchen_requests`
--
ALTER TABLE `kitchen_requests`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `recipes_ingredients`
--
ALTER TABLE `recipes_ingredients`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
