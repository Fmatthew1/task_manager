-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2024 at 08:16 AM
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
-- Database: `task_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE `todos` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` (`id`, `user_id`, `name`, `is_completed`, `created_at`, `updated_at`, `completed_at`) VALUES
(1, 2, 'implement a multitenant system', 1, '2024-06-08 15:16:16', '2024-06-08 15:16:16', '2024-06-08 15:16:41'),
(2, 2, 'dispose the refuse', 1, '2024-06-08 15:16:36', '2024-06-08 15:16:36', '2024-06-10 12:09:19'),
(3, 10, 'Buy 2kg of Gas tonight', 1, '2024-06-08 15:38:14', '2024-06-14 19:21:02', '2024-06-15 08:06:08'),
(4, 7, 'Learn video Editing ', 1, '2024-06-08 15:43:28', '2024-06-15 08:15:26', '2024-06-15 08:06:25'),
(5, 9, 'Buy a Go Bag this weekend', 1, '2024-06-10 13:37:47', '2024-06-14 22:47:35', '2024-06-26 20:15:47'),
(6, 1, 'Buy Bread for family', 1, '2024-06-15 07:05:50', '2024-06-27 13:10:19', '2024-06-27 12:30:33'),
(7, 7, 'Pay for Electric bill', 0, '2024-06-15 08:17:24', '2024-07-05 16:36:04', NULL),
(8, 15, 'Buy Diesel for the truck ', 0, '2024-06-26 20:12:52', '2024-06-28 13:00:09', NULL),
(9, 16, 'Buy 1 bag of Garri tomorrow', 0, '2024-06-27 12:25:12', '2024-06-27 12:25:12', NULL),
(10, 17, 'Buy a Samsung phone next week', 0, '2024-06-27 18:59:07', '2024-06-27 18:59:07', NULL),
(11, 21, 'Buy Food stuffs for the month', 0, '2024-07-05 15:36:47', '2024-07-05 16:37:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Mattez', 'matfeks@gmail.com', 'password', 'active', '2024-06-08 08:56:27', '2024-07-03 18:17:40'),
(2, 'Tobi', 'tobi@gmail.com', 'password', 'inactive', '2024-06-08 15:32:30', '2024-07-03 18:17:52'),
(6, 'Ayo', 'ayo@gmail.com', 'password', 'inactive', '2024-06-08 15:48:04', '2024-07-03 18:18:00'),
(7, 'David', 'david@gmail.com', 'password', 'inactive', '2024-06-08 15:52:21', '2024-07-05 16:38:00'),
(8, 'John Mike', 'johnmike@gmail.com', 'password', 'active', '2024-06-08 15:54:50', '2024-07-03 18:18:15'),
(9, 'Jane Doe', 'janedoe@gmail.com', 'password', 'active', '2024-06-08 16:17:57', '2024-07-03 18:18:23'),
(10, 'Christal', 'christal@gmail.com', 'password', 'active', '2024-06-08 16:36:09', '2024-07-03 18:18:31'),
(11, 'Derek', 'derek1@gmail.com', 'password', 'inactive', '2024-06-08 16:42:06', '2024-07-05 16:37:49'),
(12, 'Matthew', 'matthewfeks@gmail.com', 'password', 'inactive', '2024-06-10 14:37:18', '2024-07-03 18:18:47'),
(14, 'Gloria', 'glofeks1@gmail.com', 'password', 'inactive', '2024-06-15 09:18:47', '2024-07-03 18:18:54'),
(15, 'Kola', 'kola1@gmail.com', 'password', 'active', '2024-06-26 21:11:36', '2024-07-03 18:19:01'),
(16, 'Jennifer', 'jennifer1@gmail.com', 'password', 'active', '2024-06-27 12:41:22', '2024-07-03 18:19:09'),
(17, 'Emma', 'emma@gmail.com', 'password', 'active', '2024-06-27 19:58:13', '2024-07-03 18:19:16'),
(18, 'John', 'john@gmail.com', 'password', 'active', '2024-07-01 20:46:55', '2024-07-03 18:19:59'),
(19, 'Sola', 'sola@gmail.com', '$2y$10$cugXsqa64ANAAp.4WApybOlwvYshHfGxsQrZ2QTx5NQlwQic/e9fO', 'inactive', '2024-07-04 21:55:10', '2024-07-04 22:24:13'),
(20, 'Faith', 'faith@gmail.com', '$2y$10$wG1GO/ANLkJYm1WA2O0w7eFzNptQ9QGN/dKwnMz0AKitLzIDzWxpu', 'active', '2024-07-04 22:15:38', '2024-07-04 22:15:38'),
(21, 'Salome', 'salome@gmail.com', '$2y$10$mbcasG8kU6.o5DUacSFkT.xLbaHX8MesC.iFHoMNCb4/Boo.gfQaK', 'active', '2024-07-04 22:35:19', '2024-07-04 22:35:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `todos`
--
ALTER TABLE `todos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `todos`
--
ALTER TABLE `todos`
  ADD CONSTRAINT `todos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
