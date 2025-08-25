-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2025 at 04:48 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date_taken` date NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `student_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `student_id`, `date_taken`, `teacher_id`, `status`, `student_name`) VALUES
(61, 17, '2025-08-04', 0, 'P', 'vanessa'),
(62, 17, '2025-08-05', 0, 'P', 'vanessa'),
(63, 17, '2025-08-07', 0, 'P', 'vanessa'),
(64, 17, '2025-08-08', 0, 'P', 'vanessa'),
(65, 18, '2025-08-04', 0, 'A', 'Daniel'),
(66, 18, '2025-08-05', 0, 'A', 'Daniel'),
(67, 18, '2025-08-06', 0, 'L', 'Daniel'),
(68, 19, '2025-08-04', 0, 'P', 'Joseph'),
(69, 20, '2025-08-04', 0, 'P', 'emma'),
(70, 21, '2025-08-04', 0, 'P', 'Bernard'),
(71, 22, '2025-08-04', 0, 'P', 'Kelvin'),
(72, 23, '2025-08-04', 0, 'P', 'Christ'),
(73, 25, '2025-08-04', 0, 'A', 'Victor'),
(74, 26, '2025-08-04', 0, 'A', 'Michael'),
(75, 36, '2025-08-04', 0, 'P', 'Rita'),
(76, 37, '2025-08-04', 0, 'P', 'Choky'),
(77, 40, '2025-08-04', 0, 'A', 'Naomi'),
(78, 42, '2025-08-04', 0, 'A', 'Esther'),
(79, 43, '2025-08-04', 0, 'L', 'Diana'),
(80, 44, '2025-08-04', 0, 'L', 'Patrice'),
(81, 37, '2025-08-04', 0, 'P', 'Choky'),
(82, 38, '2025-08-04', 0, 'A', 'Mr stark'),
(83, 39, '2025-08-04', 0, 'P', 'sylvie'),
(84, 40, '2025-08-04', 0, 'P', 'Naomi');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`) VALUES
(1, 'Form 1'),
(2, 'Form 2'),
(3, 'Form 3'),
(4, 'Form 4'),
(5, 'Form 5'),
(6, 'lower sixth'),
(7, 'upper sixth');

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
(1, 'wilbrown', '650525830', '$2y$10$F7W11KYTdOGYRwDOk1Ix.e.y7f7UGpIebPNaV.y9XqSpGs6xikGtq', 'wilbrown@gmail.com', '2025-08-16 23:46:12', 0);

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
(33, 'REGISTRATION', 'Good evening to all my falor students and parents just to announce you that registration have already started in our school', 'admin', '2025-08-24 23:06:56');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `matricule` varchar(50) NOT NULL,
  `class` varchar(50) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `fullname`, `matricule`, `class`, `parent_id`) VALUES
(17, 'vanessa', 'sams-0001', 'upper sixth', 0),
(18, 'Daniel', 'sams-0002', 'upper sixth', 0),
(19, 'Joseph', 'sams-0003', 'upper sixth', 0),
(20, 'emma', 'sams-0004', 'upper sixth', 0),
(21, 'Bernard', 'sams-0005', 'lower sixth', 0),
(22, 'Kelvin', 'sams-0006', 'lower sixth', 0),
(23, 'Christ', 'sams-0007', 'lower sixth', 0),
(24, 'Richard', 'sams-0008', 'lower sixth', 0),
(25, 'Victor', 'sams-0009', 'form 5', 0),
(26, 'Michael', 'sams-0010', 'from 5', 0),
(27, 'Linda', 'sams-0011', 'form 5', 0),
(28, 'Farelle', 'sams-0012', 'form 5', 0),
(29, 'Sarah luise', 'sams-0013', 'form 4', 0),
(30, 'Marc', 'sams-0014', 'form 4', 0),
(31, 'Grace', 'sams-0015', 'form 4', 0),
(32, 'Aziz', 'sams-0016', 'form 4', 0),
(33, 'Audrey', 'sams-0017', 'form 3', 0),
(34, 'Shaza', 'sams-0018', 'form 3', 0),
(35, 'Biloa', 'sams-0019', 'form 3', 0),
(36, 'Rita', 'sams-0020', 'form 3', 0),
(37, 'Choky', 'sams-0021', 'form 2', 0),
(38, 'Mr stark', 'sams-0022', 'form 2', 0),
(39, 'sylvie', 'sams-0023', 'form 2', 0),
(40, 'Naomi', 'sams-00024', 'form 2', 0),
(41, 'Brenda', 'sams-0025', 'form 1', 0),
(42, 'Esther', 'sams-0026', 'form 1', 0),
(43, 'Diana', 'sams-0027', 'form 1', 0),
(44, 'Patrice', 'sams-0028', 'form 1', 0);

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
(5415231, 'emmanuel', 14, '650525830', '', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

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
