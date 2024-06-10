-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 10, 2024 at 10:13 AM
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
(2, 2, 'dispose the refuse', 0, '2024-06-08 15:16:36', '2024-06-08 15:16:36', NULL),
(3, 10, 'Buy 2kg of Gas', 0, '2024-06-08 15:38:14', '2024-06-08 15:38:14', NULL),
(4, 11, 'Learn video Editing', 0, '2024-06-08 15:43:28', '2024-06-08 15:43:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Mattez', 'matfeks@gmail.com', 'inactive', '2024-06-08 08:56:27', '2024-06-08 15:57:24'),
(2, 'Tobi', 'tobi@gmail.com', 'inactive', '2024-06-08 15:32:30', '2024-06-08 17:14:02'),
(6, 'Ayo', 'ayo@gmail.com', 'active', '2024-06-08 15:48:04', '2024-06-08 17:13:27'),
(7, 'David', 'david@gmail.com', 'inactive', '2024-06-08 15:52:21', '2024-06-08 17:12:49'),
(8, 'John Mikes', 'johnmikes@gmail.com', 'inactive', '2024-06-08 15:54:50', '2024-06-08 15:57:18'),
(9, 'jane doe', 'jane@gmail.com', 'active', '2024-06-08 16:17:57', '2024-06-08 16:19:20'),
(10, 'Christal', 'christal@gmail.com', 'active', '2024-06-08 16:36:09', '2024-06-08 16:36:09'),
(11, 'Derek', 'derek@gmail.com', 'active', '2024-06-08 16:42:06', '2024-06-08 16:42:06');

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
