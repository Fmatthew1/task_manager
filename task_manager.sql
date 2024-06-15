-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 15, 2024 at 09:19 AM
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
(5, 9, 'Buy a Go Bag this weekend', 0, '2024-06-10 13:37:47', '2024-06-14 22:47:35', NULL),
(6, 1, 'Buy Bread for family', 0, '2024-06-15 07:05:50', '2024-06-15 08:11:17', NULL),
(7, 1, 'Buy clothes for Chrysolite', 0, '2024-06-15 08:17:24', '2024-06-15 09:17:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Mattez', 'matfeks@gmail.com', 'active', '2024-06-08 08:56:27', '2024-06-13 21:49:44'),
(2, 'Tobi', 'tobi@gmail.com', 'inactive', '2024-06-08 15:32:30', '2024-06-15 08:39:46'),
(6, 'Ayo', 'ayo@gmail.com', 'inactive', '2024-06-08 15:48:04', '2024-06-15 08:39:39'),
(7, 'David', 'david@gmail.com', 'active', '2024-06-08 15:52:21', '2024-06-13 13:08:24'),
(8, 'John Mikes', 'johnmikes@gmail.com', 'active', '2024-06-08 15:54:50', '2024-06-13 12:52:12'),
(9, 'jane doe', 'jane@gmail.com', 'inactive', '2024-06-08 16:17:57', '2024-06-15 09:18:00'),
(10, 'Christal', 'christal@gmail.com', 'active', '2024-06-08 16:36:09', '2024-06-15 09:18:06'),
(11, 'Derek', 'derek@gmail.com', 'inactive', '2024-06-08 16:42:06', '2024-06-15 08:14:42'),
(12, 'Matthew', 'matthewfeks@gmail.com', 'inactive', '2024-06-10 14:37:18', '2024-06-15 08:14:43'),
(14, 'Gloria', 'glofeks@gmail.com', 'active', '2024-06-15 09:18:47', '2024-06-15 09:18:47');

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
