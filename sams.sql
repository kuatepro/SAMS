-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2025 at 10:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sams`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `admin_id` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `fullname`, `admin_id`, `password`, `email`, `created_at`) VALUES
(3, 'wills237', '1234', '$2y$10$eIfrmM3o7lBaMyK2BlfxLus2KDwpJ6y7OUq39XNnS/DD4tVRLMAmS', 'q@gmail.com', '2025-08-17 21:17:21'),
(6, 'willswilbown', '123457', '$2y$10$eaLI/gKa7tr.QI79Gns...Qw864.gUyg2O/gy7DXNobqWjxghUKsG', 'wills@gmail.com', '2025-08-18 13:09:07'),
(7, 'melissa', '14789', '$2y$10$JzBojqtQy5Uaeii32GvpHOC/APtG33HaZeju388YzJHK7CsGhOO/O', 'meli@gmail.com', '2025-08-18 14:41:30'),
(29, 'amins200', '101010', '$2y$10$cS/sDhiwg7c7aFNAewJElOQc4K1SNIdx94X6BbOt0JVH9pIuwXpRm', 'admin@gmail.com', '2025-08-22 07:34:44'),
(30, 'diminho', '0987', '$2y$10$zPhZ8n73L7MUR1iziCu49ui3M4Y3SWd6Ukf5Bs9HSlU7lU00KhKkG', 'dimi@gmail.com', '2025-08-22 12:15:28');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` enum('Present','Absent') NOT NULL,
  `date_taken` date NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `contact` varchar(9) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`id`, `fullname`, `contact`, `password`, `email`, `created_at`, `user_id`) VALUES
(1, 'wilbrown', '650525830', '$2y$10$F7W11KYTdOGYRwDOk1Ix.e.y7f7UGpIebPNaV.y9XqSpGs6xikGtq', 'wilbrown@gmail.com', '2025-08-16 23:46:12', 0),
(5, 'brown', '650525830', '$2y$10$J/Y0rf9xRPDUkcp0AYt8uOR0agC3nnR5.JWkqbGr6ObWY.zao6tJG', 'brown@gmail.com', '2025-08-17 00:35:43', 0),
(22, 'emmanuel', '653535353', '$2y$10$pYtxehlP7frFOIpzCisaUOLy7GWebIpH6QpV/7.kX3xMaGCqiIBIm', 'johna@gmail.com', '2025-08-18 13:17:26', 0),
(42, 'monsieur', '633333333', '$2y$10$ik15XkGUh2rDkYR5zi84KuZ7aJyhuUmZonIAx5ASBeLfZbBVrPekO', 'parentss@gmail.com', '2025-08-21 08:58:27', 0),
(43, 'newparent', '622525252', '$2y$10$tMLzqvBoUCSJRcivX6h4ceN.jXV4ec4yk1f/cpfpHtUgqJWaPx8na', 'parent@gmail.com', '2025-08-22 07:41:24', 0),
(44, 'manass', '692487867', '$2y$10$4UqSt5cDxCdPPSJPoGEyZO2uFAmCommVCDWFMEnZz7MSQNAYnDNd6', 'manass@gmail.com', '2025-08-22 12:19:47', 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `posted_by` varchar(50) NOT NULL,
  `post_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `content`, `posted_by`, `post_date`) VALUES
(20, 'shcool info', 'please you guys should pay your fees\r\n\r\n', 'admin', '2025-08-19 13:56:33');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `matricule` varchar(50) NOT NULL,
  `class` varchar(50) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `fullname`, `matricule`, `class`, `parent_id`, `class_id`) VALUES
(1, 'Emmanuel', 'sams-01', 'lower sixth', 0, 0),
(2, 'Wilbrown', 'sams-07', 'upper sixth', 0, 0),
(3, 'Aziz', 'sams-09', 'upper sixth', 0, 0),
(4, 'John', 'sams-05', ' form 5', 0, 0),
(5, 'emmanuel', 'sams01', 'form1', 0, 123),
(6, 'aziz', 'sams01', 'form1', 0, 123),
(7, 'john', 'sams02', 'form1', 0, 124),
(8, 'wilbrown', 'sams03', 'form1', 0, 125);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `contact` varchar(9) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`user_id`, `fullname`, `teacher_id`, `contact`, `password`, `email`) VALUES
(5415220, 'wilbrown', 3, '693353586', '', ''),
(5415231, 'emmanuel', 14, '650525830', '', ''),
(5415232, 'nhodimi', 15, '656396098', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','parent','teacher','admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(5415196, 'emmanuel', 'emma@gmail.com', '$2y$10$58dxzek0MvsVnJBmSdPaTu1PbD7nG63c4TQo5xwoBOz.Qk6LLVy1O', 'parent', '2025-08-17 08:16:59'),
(5415203, 'mummama', 'mum@gmail.com', '$2y$10$SkCIgIEBdhI.Zqprc8NIUeU.DJN9jrtQHTPGaqUv2w2FKNcMGVQvy', 'parent', '2025-08-17 08:57:21'),
(5415220, 'wilbrown', 'wilbrown@gmail.com', '$2y$10$RagRBbZ4xViM0tmXdnqRnuR49gMTrN1Yx7kIXp3Jp/12Hs5HU7o/q', 'teacher', '2025-08-17 16:42:28'),
(5415231, 'emmanuel', 'teacher@gmail.com', '$2y$10$n/N8rbMi67UBk/Ue1Hx7MexTZlKV62bheZnRRwWjOnmsEXV8S1i3W', 'teacher', '2025-08-21 20:26:33'),
(5415232, 'nhodimi', 'nhodimi@gmail.com', '$2y$10$3B5gzDhOq1SxFqJHb83rletVPJvKFHVzC2D0VBxNrqpneHnuwqWvq', 'teacher', '2025-08-22 12:17:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_id` (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `teacher_id` (`teacher_id`),
  ADD KEY `teacher_ibfk_1` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5415233;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
