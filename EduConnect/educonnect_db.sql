-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 28, 2025 at 06:32 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `educonnect_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `address`, `message`, `status`, `created_at`) VALUES
(8, 'Maleesha Sanjana', 'maleeshasanjanadilshan@gmail.com', 'Malabe', 'I want to Contact you quickly.', 'confirmed', '2025-06-23 20:44:36'),
(9, 'Hiruni Wijewardhana', 'hiruwijewardhana4@gmail.coom', 'Malabe', 'I want to Contact', 'pending', '2025-06-23 20:45:20'),
(10, 'Deshan Siriwardhana', 'deshan123@gmail.com', 'Avissawella', 'I want to contact', 'confirmed', '2025-06-24 10:48:02');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `faculty` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `price`, `faculty`, `created_at`) VALUES
(1, 'BSc.(Hon\'s) in Software Engineering', 1300.00, 'Faculty of Computing', '2025-04-19 09:07:22'),
(2, 'BSc. ( Hon\'s ) in Information technology', 1200.00, 'Faculty of Computing', '2025-06-23 17:19:10'),
(3, 'BSc. ( Hon\'s ) in Data Science Technology', 2300.00, 'Faculty of Computing', '2025-06-23 17:20:54'),
(4, 'BSc. (Hon\'s) in Maritime Operations', 18000.00, 'Faculty of Marine Engineering', '2025-06-23 17:25:56'),
(5, 'Marine Engineering Officer Cadet Program', 16000.00, 'Faculty of Marine Engineering', '2025-06-23 17:32:16'),
(7, 'BBA (Honours) in Banking & Finance', 13400.00, 'Faculty of Management', '2025-06-23 17:35:17'),
(8, 'BMgt. (Honours) in Human Resources Management ', 12450.00, 'Faculty of Management', '2025-06-23 17:34:25'),
(9, 'BSc (Hons) in Engineering in Electronic & Telecommunication Engineering', 13000.00, 'Faculty of Marine Engineering', '2025-06-23 17:32:35'),
(10, 'BSc. Honours in Logistics & Transportation', 23500.00, 'Faculty of Management', '2025-06-23 17:34:54'),
(11, 'BSc.(Hon\'s) in Civil Engineering', 20000.00, 'Faculty of Engineering', '2025-06-23 17:37:35'),
(12, 'BSc.(Hon\'s) in Mechanical Engineering', 50000.00, 'Faculty of Engineering', '2025-06-23 17:37:57'),
(13, 'BSc.(Hon\'s) in Electric Engineering', 18000.00, 'Faculty of Engineering', '2025-06-23 17:38:19'),
(14, 'BSc (Hon\'s) in Physical Science', 20000.00, 'Faculty of Health Sciences', '2025-06-23 17:45:01'),
(15, 'BSc (Hons) in Chemical Science', 19450.00, 'Faculty of Health Sciences', '2025-06-23 17:45:26'),
(16, 'Foundation Program For Sciences', 2150.00, 'Faculty of Health Sciences', '2025-06-23 17:45:53'),
(17, 'LL.B. (Hon\'s) in Law', 25450.00, 'Faculty of Law', '2025-06-23 17:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `course` varchar(100) NOT NULL,
  `enroll_date` date NOT NULL,
  `qualifications` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `name`, `email`, `phone`, `course`, `enroll_date`, `qualifications`, `created_at`) VALUES
(3, 'Maleesha Sanjana (Confirmed)', 'maleeshasanjanadilshan@gmail.com', '0786360508', 'electric_engineering', '2025-06-11', 'A/L', '2025-06-23 19:16:45'),
(5, 'Hiruni Nisansala', 'hirunisansala@gmail.com', '0786360508', 'human_resources_management', '2025-06-25', 'A/L', '2025-06-23 19:18:36'),
(6, 'Deshan (Confirmed)', 'deshan123@gmail.com', '097472', 'data_science_technology', '2025-06-25', 'A/L', '2025-06-24 10:46:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` enum('admin','staff','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_level`) VALUES
(1, 'Maleesha1', 'admin@gmail.com', 'admin123', 'admin'),
(2, 'Maleesha2', 'staff@gmail.com', 'staff123', 'staff'),
(3, 'Maleesha4', 'user1@gmail.com', '$2y$10$I4SNj9l/hOe39hJcToeatuLpChY8z.tTWHN/9cOaYSg1b6b47iZNa', 'user'),
(4, 'Hiruni', 'hiruni@gmail.com', 'hiruni123', 'admin'),
(5, 'Hiruni2', 'staff2@gmail.com', 'staff123', 'staff'),
(22, 'Maleesha', 'maleesha123@gmail.com', '$2y$10$ewestz4ZB7SYU5CbOl1j4eDdW8kPwUeDrw5DMx3f37hvPS./OBkj.', 'user'),
(23, 'Sachi', 'sachi@gmail.com', '$2y$10$YXcAh2ExFsNCDTQNGE9WV.cviKeRM./xLwrcCqBvht9RCu8EJC7Li', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
