-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 11, 2023 at 02:52 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `programming_hero_task_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `fonts`
--

CREATE TABLE `fonts` (
  `id` int UNSIGNED NOT NULL,
  `font_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `fonts`
--

INSERT INTO `fonts` (`id`, `font_name`, `created_at`) VALUES
(1, 'Freedom-10eM.ttf', '2023-09-10 11:02:03'),
(7, 'ArianaVioleta-dz2K.ttf', '2023-09-10 11:59:26'),
(8, 'Mefikademo-owEAq.ttf', '2023-09-10 15:59:37'),
(9, 'Branda-yolq.ttf', '2023-09-10 15:59:44'),
(10, 'OpenSans-Regular.ttf', '2023-09-10 16:00:11'),
(11, 'Raleway-Medium.ttf', '2023-09-10 16:00:35'),
(12, 'Raleway-BlackItalic.ttf', '2023-09-10 16:01:15'),
(13, 'Raleway-SemiBold.ttf', '2023-09-10 16:03:44');

-- --------------------------------------------------------

--
-- Table structure for table `grouping`
--

CREATE TABLE `grouping` (
  `group_id` int UNSIGNED NOT NULL,
  `font_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `grouping`
--

INSERT INTO `grouping` (`group_id`, `font_id`, `created_at`) VALUES
(1, 7, '2023-09-11 13:32:02'),
(1, 9, '2023-09-11 13:32:02'),
(1, 8, '2023-09-11 13:32:02'),
(2, 7, '2023-09-11 13:35:22'),
(2, 9, '2023-09-11 13:35:22'),
(2, 1, '2023-09-11 13:35:22'),
(3, 1, '2023-09-11 13:52:45'),
(3, 8, '2023-09-11 13:52:45'),
(3, 10, '2023-09-11 13:52:45');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int UNSIGNED NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `created_at`) VALUES
(1, 'Facebook', '2023-09-11 13:32:02'),
(2, 'face', '2023-09-11 13:35:22'),
(3, 'Google', '2023-09-11 13:52:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fonts`
--
ALTER TABLE `fonts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grouping`
--
ALTER TABLE `grouping`
  ADD KEY `group_id` (`group_id`),
  ADD KEY `font_id` (`font_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grouping`
--
ALTER TABLE `grouping`
  ADD CONSTRAINT `grouping_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grouping_ibfk_2` FOREIGN KEY (`font_id`) REFERENCES `fonts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
