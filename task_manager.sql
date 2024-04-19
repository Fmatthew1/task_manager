-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 19, 2024 at 01:40 PM
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
  `name` varchar(100) NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` (`id`, `name`, `is_completed`, `created_at`, `updated_at`, `completed_at`) VALUES
(1, 'Read GoPro every morning by 4am', 1, '2024-04-16 21:27:00', '2024-04-18 14:29:42', '2024-04-17 07:16:32'),
(2, 'morning Worship by 6am', 1, '2024-04-16 21:28:42', '2024-04-16 21:28:42', '2024-04-17 07:16:34'),
(3, 'Start Laravel Project by 9am ', 1, '2024-04-16 21:30:29', '2024-04-16 21:30:29', '2024-04-18 14:31:46'),
(4, 'Learn PHP OOP from 11am everyday', 0, '2024-04-16 21:31:33', '2024-04-16 21:31:33', '2024-04-16 21:31:33'),
(5, 'Study JavaScript by 1pm daily', 0, '2024-04-16 21:33:00', '2024-04-16 21:33:00', '2024-04-16 21:33:00'),
(6, 'Create video Content by 2pm daily', 0, '2024-04-16 21:33:53', '2024-04-16 21:33:53', '2024-04-16 21:33:53'),
(7, 'Upload content on YouTube by 4pm daily', 0, '2024-04-16 21:34:56', '2024-04-16 21:34:56', '2024-04-16 21:34:56'),
(8, 'book 10 people for presentation by 5pm daily', 0, '2024-04-16 21:36:35', '2024-04-16 21:36:35', '2024-04-16 21:36:35'),
(9, 'Follow up 5 prospects by 6pm daily', 0, '2024-04-16 21:37:17', '2024-04-16 21:37:17', '2024-04-16 21:37:17'),
(10, 'call 3 serious team by 7:30pm daily', 1, '2024-04-16 21:37:57', '2024-04-16 21:38:32', '2024-04-16 21:39:30'),
(11, 'Personal Development by 4:30pm Daily', 0, '2024-04-18 13:28:44', '2024-04-18 14:29:28', '2024-04-18 13:28:44'),
(12, 'Practice SAVERS from 5am Daily', 0, '2024-04-19 09:48:24', '2024-04-19 09:48:24', '2024-04-19 09:48:24'),
(13, 'Do 30 press ups every morning', 0, '2024-04-19 10:55:00', '2024-04-19 10:55:00', '2024-04-19 10:55:00'),
(14, 'Do 30 push ups every morning', 0, '2024-04-19 10:58:50', '2024-04-19 10:58:50', '2024-04-19 10:58:50'),
(15, 'Jog every morning', 0, '2024-04-19 11:08:06', '2024-04-19 11:08:06', '2024-04-19 11:08:06'),
(16, 'Brush your teeth by 7am every morning', 0, '2024-04-19 11:11:14', '2024-04-19 11:11:14', '2024-04-19 11:11:14'),
(17, 'Eat Breakfast by 7:30am', 1, '2024-04-19 11:27:10', '2024-04-19 11:27:10', '2024-04-19 11:29:05'),
(18, 'Go the office by 8am', 1, '2024-04-19 11:28:39', '2024-04-19 11:28:39', '2024-04-19 11:29:42'),
(19, 'Buy shoe for Chrysolite tomorrow', 0, '2024-04-19 11:35:45', '2024-04-19 11:35:45', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todos`
--
ALTER TABLE `todos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
