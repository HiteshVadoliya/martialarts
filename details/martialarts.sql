-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2024 at 05:53 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `martialarts`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes_all`
--

CREATE TABLE `classes_all` (
  `class_id` int(10) UNSIGNED NOT NULL,
  `class_title` varchar(155) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `isDelete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `classes_all`
--

INSERT INTO `classes_all` (`class_id`, `class_title`, `status`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'Tigers', 1, 0, '2024-01-22 11:44:59', NULL),
(2, 'Youth', 1, 0, '2024-01-22 11:44:59', NULL),
(3, 'Adult', 1, 0, '2024-01-22 11:45:09', NULL),
(4, 'XMA', 1, 0, '2024-01-22 11:45:09', NULL),
(5, 'Sparring 33', 1, 1, '2024-01-22 11:45:22', '2024-01-27 02:11:30'),
(6, 'Legacy Instructor', 1, 0, '2024-01-22 11:45:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `instructor_level`
--

CREATE TABLE `instructor_level` (
  `level_id` int(10) UNSIGNED NOT NULL,
  `level_title` varchar(155) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `isDelete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `instructor_level`
--

INSERT INTO `instructor_level` (`level_id`, `level_title`, `status`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'Level 0', 1, 0, '2024-01-22 11:05:34', NULL),
(2, 'Level 1', 1, 0, '2024-01-22 11:05:34', NULL),
(3, 'Level 2', 1, 0, '2024-01-22 11:05:41', NULL),
(4, 'Level 3', 1, 0, '2024-01-22 11:05:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(10) UNSIGNED NOT NULL,
  `location_title` varchar(155) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `isDelete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `location_title`, `status`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'Glen Rose', 1, 0, '2024-01-22 11:49:14', NULL),
(2, 'Granbury', 1, 0, '2024-01-22 11:49:14', NULL),
(3, 'Cleburne', 1, 0, '2024-01-22 11:49:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Phrases`
--

CREATE TABLE `Phrases` (
  `Phrase_id` int(11) NOT NULL,
  `Phrase` varchar(30) NOT NULL,
  `Good` tinyint(1) NOT NULL,
  `Weight` int(11) NOT NULL,
  `Camp_pid` varchar(10) NOT NULL COMMENT 'ALL indicates all campaigns',
  `Client` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Phrases`
--

INSERT INTO `Phrases` (`Phrase_id`, `Phrase`, `Good`, `Weight`, `Camp_pid`, `Client`) VALUES
(1, 'person charged 12/17/2023', 1, 50, 'ATAExcelle', 0),
(2, 'Thank You', 1, 32, 'ALL', 0),
(3, 'gotta', 0, 10, 'ALL', 0),
(4, 'Thank You', 1, 8, 'BE', 0),
(8, 'Airport', 0, 4, 'BE', 0),
(19, 'repeat', 0, 42, '[ALL]', 0),
(21, 'Airport', 0, 3, 'EMPIRE', 0),
(22, 'okay', 1, 8, '[ALL]', 0),
(23, 'why', 1, 10, '[ALL]', 0),
(24, 'hello', 1, 5, '[ALL]', 0),
(25, 'how', 1, 5, '[ALL]', 0),
(26, 'you', 0, 6, '[ALL]', 0),
(27, 'like', 0, 2, '[ALL]', 0),
(28, '1', 1, 0, 'EmpireDefF', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

CREATE TABLE `rank` (
  `rank_id` int(10) UNSIGNED NOT NULL,
  `rank_title` varchar(155) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `isDelete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rank`
--

INSERT INTO `rank` (`rank_id`, `rank_title`, `status`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'Color Belt', 1, 0, '2024-01-22 11:37:12', NULL),
(2, '1st Degree', 1, 0, '2024-01-22 11:37:24', NULL),
(3, '2nd Degree', 1, 0, '2024-01-22 11:37:24', NULL),
(4, '3rd Degree', 1, 0, '2024-01-22 11:37:35', NULL),
(5, '4th Degree', 1, 0, '2024-01-22 11:37:35', NULL),
(6, '5th Degree', 1, 0, '2024-01-22 11:37:45', NULL),
(7, '6th Degree', 1, 0, '2024-01-22 11:37:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(10) UNSIGNED NOT NULL,
  `schedule_title` varchar(255) NOT NULL,
  `school_pid` int(11) NOT NULL,
  `schedule_time` datetime DEFAULT NULL,
  `week` int(11) NOT NULL,
  `day` varchar(50) NOT NULL,
  `day_number` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `isDelete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `schedule_title`, `school_pid`, `schedule_time`, `week`, `day`, `day_number`, `status`, `isDelete`, `created_at`, `updated_at`) VALUES
(2, 'Legal Instructor', 1, '2024-01-29 10:56:00', 5, 'Monday', 1, 1, 0, '2024-01-27 09:57:03', '2024-01-27 05:36:33'),
(3, 'Home School', 1, '2024-01-29 11:59:00', 5, 'Monday', 1, 1, 0, '2024-01-27 09:57:34', '2024-01-27 05:36:33'),
(4, 'Tiger Cub', 1, '2024-01-29 11:43:00', 5, 'Monday', 1, 1, 0, '2024-01-27 10:02:01', '2024-01-27 05:37:25'),
(5, 'Cubs', 3, '2024-01-29 18:14:00', 5, 'Monday', 1, 1, 0, '2024-01-27 10:02:36', '2024-01-27 05:37:27'),
(6, 'Beginner Sparring', 1, '2024-01-30 10:02:00', 5, 'Tuesday', 2, 1, 0, '2024-01-27 10:03:19', '2024-01-27 05:36:33'),
(7, 'XMA', 1, '2024-01-30 05:03:00', 5, 'Tuesday', 2, 1, 0, '2024-01-27 10:03:43', '2024-01-27 05:36:33'),
(8, 'Homeschool', 1, '2024-01-31 06:11:00', 5, 'Wednesday', 3, 1, 0, '2024-01-27 10:04:36', '2024-01-27 05:36:33'),
(9, 'Tiger Cub', 2, '2024-01-31 10:04:00', 5, 'Wednesday', 3, 1, 0, '2024-01-27 10:06:05', '2024-01-27 05:36:40'),
(10, 'instructor class', 3, '2024-02-01 04:11:00', 5, 'Thursday', 4, 1, 0, '2024-01-27 10:08:19', '2024-01-27 05:36:49'),
(11, 'test44', 2, '2024-02-09 11:08:00', 6, 'Friday', 5, 1, 0, '2024-01-27 11:09:10', NULL),
(12, 'test 4', 3, '2024-02-10 11:09:00', 6, 'Saturday', 6, 1, 0, '2024-01-27 11:09:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `school_all`
--

CREATE TABLE `school_all` (
  `school_id` int(10) UNSIGNED NOT NULL,
  `school_title` varchar(155) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `isDelete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `school_all`
--

INSERT INTO `school_all` (`school_id`, `school_title`, `status`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'Granbury', 1, 0, '2024-01-27 08:05:43', NULL),
(2, 'Cleburne', 1, 0, '2024-01-27 08:05:43', NULL),
(3, 'Glen Rose', 1, 0, '2024-01-27 08:05:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_global_settings`
--

CREATE TABLE `tbl_global_settings` (
  `setting_id` int(10) UNSIGNED NOT NULL,
  `transcript_url` varchar(250) NOT NULL,
  `pdf_url` varchar(250) NOT NULL,
  `recording_url` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_global_settings`
--

INSERT INTO `tbl_global_settings` (`setting_id`, `transcript_url`, `pdf_url`, `recording_url`) VALUES
(1, '/public/files/transcript', '/public/files/pdf_export', '/public/files/recording');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_module_access`
--

CREATE TABLE `tbl_module_access` (
  `module_access_id` int(10) UNSIGNED NOT NULL,
  `role_pid` int(11) NOT NULL,
  `module` varchar(80) NOT NULL,
  `operation` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_module_access`
--

INSERT INTO `tbl_module_access` (`module_access_id`, `role_pid`, `module`, `operation`) VALUES
(1, 1, 'admin', 'access'),
(2, 1, 'admin', 'save'),
(3, 1, 'admin', 'update'),
(4, 1, 'admin', 'delete'),
(5, 1, 'admin', 'change_status'),
(6, 1, 'admin', 'access'),
(7, 1, 'admin', 'save'),
(8, 1, 'admin', 'update'),
(9, 1, 'admin', 'delete'),
(10, 1, 'admin', 'change_status'),
(11, 1, 'users', 'access'),
(12, 1, 'users', 'view'),
(13, 1, 'users', 'save'),
(14, 1, 'users', 'update'),
(15, 1, 'users', 'delete'),
(16, 1, 'users', 'status_change'),
(17, 1, 'users', 'password_change'),
(18, 1, 'user_roles', 'access'),
(19, 1, 'user_roles', 'save'),
(20, 1, 'user_roles', 'update'),
(21, 1, 'user_roles', 'delete'),
(22, 1, 'user_roles', 'status_change'),
(23, 1, 'dashboard', 'access'),
(24, 1, 'dashboard', 'dashboard'),
(25, 1, 'dashboard', 'dashboard2'),
(26, 1, 'dashboard', 'dashboard3'),
(27, 2, 'dashboard', 'access'),
(28, 2, 'dashboard', 'dashboard'),
(29, 2, 'dashboard', 'dashboard2'),
(30, 2, 'dashboard', 'dashboard3'),
(31, 3, 'dashboard', 'access'),
(32, 3, 'dashboard', 'dashboard'),
(33, 3, 'dashboard', 'dashboard2'),
(34, 3, 'dashboard', 'dashboard3'),
(35, 4, 'dashboard', 'access'),
(36, 4, 'dashboard', 'dashboard'),
(37, 4, 'dashboard', 'dashboard2'),
(38, 4, 'dashboard', 'dashboard3');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

CREATE TABLE `tbl_role` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `cdate` datetime NOT NULL,
  `role` varchar(30) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_role`
--

INSERT INTO `tbl_role` (`role_id`, `cdate`, `role`, `is_active`) VALUES
(1, '2023-10-16 00:00:00', 'Administrator', 1),
(2, '2023-10-16 00:00:00', 'Instructors', 1),
(3, '2023-10-16 00:00:00', 'Assistants', 1),
(4, '2023-11-07 11:29:50', 'Students', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `b_date` date DEFAULT NULL,
  `level_pid` int(11) DEFAULT NULL,
  `rank_pid` int(11) DEFAULT NULL,
  `hr_rate` float(8,2) DEFAULT NULL,
  `class_pid` varchar(150) DEFAULT NULL,
  `location_pid` varchar(150) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `image` varchar(80) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `isDelete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `fname`, `lname`, `username`, `password`, `email`, `b_date`, `level_pid`, `rank_pid`, `hr_rate`, `class_pid`, `location_pid`, `phone`, `image`, `is_active`, `status`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'admin', '', 'admin', '$2y$10$E4BY2GTa2hBB/ZW0ytTRXOwL6XrqVZnprg9HfgLvOxmlohVMl6Etu', 'admin@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1231230001', NULL, 1, 1, 0, '2024-01-21 09:20:40', NULL),
(2, 'Instructor', '', 'instructor', '$2y$10$KQOKdnsOe0ZAMorNxMntk.QmBX5248RgEc0zGEW.aa0cIbZAOGdG2', 'instructor@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1231230002', '', 1, 1, 0, '2024-01-21 09:20:40', NULL),
(3, 'Assistants', '', 'assistants', '$2y$10$bFD6b78OVQxF6qy0Rx66v.xOqLAd7EqRt.LjOoGpJrrf2kpJ3WFZC', 'assistants@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1231230003', NULL, 1, 0, 0, '2024-01-21 09:20:40', NULL),
(4, 'Students', '', 'students', '$2y$10$mX1G5dLstYqNl8GA1X8hXefVGpQar6PC68BYOcbb7FWhsUTBMJBGe', 'student@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1231320004', NULL, 1, 0, 0, '2024-01-21 09:20:40', NULL),
(5, 'ins2', '', 'ins', '$2y$10$E4BY2GTa2hBB/ZW0ytTRXOwL6XrqVZnprg9HfgLvOxmlohVMl6Etu', 'ins@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1231230005', NULL, 1, 0, 0, '2024-01-21 09:20:40', NULL),
(8078, 'Assistants', '', 'assistants', '$2y$10$bFD6b78OVQxF6qy0Rx66v.xOqLAd7EqRt.LjOoGpJrrf2kpJ3WFZC', 'assistants@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1231230003', NULL, 1, 0, 0, '2024-01-21 09:20:40', NULL),
(8079, 'Students', '', 'students', '$2y$10$mX1G5dLstYqNl8GA1X8hXefVGpQar6PC68BYOcbb7FWhsUTBMJBGe', 'student@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1231320004', NULL, 1, 0, 0, '2024-01-21 09:20:40', NULL),
(8080, 'ins2', '', 'ins', '$2y$10$E4BY2GTa2hBB/ZW0ytTRXOwL6XrqVZnprg9HfgLvOxmlohVMl6Etu', 'ins@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1231230005', NULL, 1, 0, 0, '2024-01-21 09:20:40', NULL),
(8081, 'Hitesh', 'Vadoliya', '', '$2y$10$62z7CJJtbqeCUhnWV4ScyubB4D.jp2HUcrgjIqLM3tZ0LxtOJ7Rq6', '1@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2024-01-21 12:27:20', NULL),
(8082, 'jack', 'k', '', '$2y$10$7GHp3ZZNBAWFGGUkAHmexukNVNOJanDJXFOKj0D6/19KEAIfrfEsq', 'k@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2024-01-21 12:29:13', '2024-01-21 07:21:00'),
(8083, 'a44', 'b', '', '$2y$10$TsCen63H8wmmdEWuV6GBWucAB2EsPmgoMmuSfFxt4t1H9fiwGwI8u', 'c@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2024-01-21 12:36:25', NULL),
(8084, 'Assistants', '', 'assistants', '$2y$10$bFD6b78OVQxF6qy0Rx66v.xOqLAd7EqRt.LjOoGpJrrf2kpJ3WFZC', 'assistants@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1231230003', NULL, 1, 0, 0, '2024-01-21 09:20:40', NULL),
(8085, 'Students', '', 'students', '$2y$10$mX1G5dLstYqNl8GA1X8hXefVGpQar6PC68BYOcbb7FWhsUTBMJBGe', 'student@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1231320004', NULL, 1, 0, 0, '2024-01-21 09:20:40', NULL),
(8086, 'ins2', '', 'ins', '$2y$10$E4BY2GTa2hBB/ZW0ytTRXOwL6XrqVZnprg9HfgLvOxmlohVMl6Etu', 'ins@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1231230005', NULL, 1, 0, 0, '2024-01-21 09:20:40', NULL),
(8087, 'Hitesh', 'Vadoliya', '', '$2y$10$62z7CJJtbqeCUhnWV4ScyubB4D.jp2HUcrgjIqLM3tZ0LxtOJ7Rq6', '1@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2024-01-21 12:27:20', NULL),
(8088, 'jack', 'k', '', '$2y$10$7GHp3ZZNBAWFGGUkAHmexukNVNOJanDJXFOKj0D6/19KEAIfrfEsq', 'k@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2024-01-21 12:29:13', '2024-01-21 07:21:00'),
(8089, 'a44', 'b', '', '$2y$10$TsCen63H8wmmdEWuV6GBWucAB2EsPmgoMmuSfFxt4t1H9fiwGwI8u', 'c@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2024-01-21 12:36:25', NULL),
(8090, 'Hitesh Vadoliya', '', '', '$2y$10$XnVIEOyHTU6PbKeL3uI6pe4O4xgJUVT3eueu8fptJx3bstA3iVKXm', '11@gmail.com', NULL, 3, 4, 25.00, '2,3,6', '2,3', '8866005130', NULL, 0, 1, 0, '2024-01-22 18:36:27', '2024-01-27 01:49:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_role`
--

CREATE TABLE `tbl_user_role` (
  `user_role_id` int(10) UNSIGNED NOT NULL,
  `user_pid` int(11) NOT NULL,
  `role_pid` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `cdate` datetime NOT NULL,
  `role` varchar(30) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_user_role`
--

INSERT INTO `tbl_user_role` (`user_role_id`, `user_pid`, `role_pid`, `created_at`, `updated_at`, `cdate`, `role`, `is_active`) VALUES
(1, 1, 1, '2024-01-21 12:32:08', NULL, '2023-10-16 00:00:00', '', 1),
(2, 2, 2, '2024-01-21 12:32:08', NULL, '2023-10-16 00:00:00', '', 1),
(3, 3, 3, '2024-01-21 12:32:08', NULL, '2023-10-16 00:00:00', '', 1),
(4, 4, 4, '2024-01-21 12:32:08', NULL, '2023-11-07 11:29:50', '', 1),
(8, 5, 2, '2024-01-21 12:32:08', NULL, '2023-11-07 11:29:50', '', 1),
(9, 5, 4, '2024-01-21 12:32:08', NULL, '2023-11-07 11:29:50', '', 1),
(10, 8083, 2, '2024-01-21 12:36:25', NULL, '0000-00-00 00:00:00', '', 0),
(14, 8090, 2, '2024-01-21 12:36:25', NULL, '0000-00-00 00:00:00', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes_all`
--
ALTER TABLE `classes_all`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `instructor_level`
--
ALTER TABLE `instructor_level`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `Phrases`
--
ALTER TABLE `Phrases`
  ADD PRIMARY KEY (`Phrase_id`);

--
-- Indexes for table `rank`
--
ALTER TABLE `rank`
  ADD PRIMARY KEY (`rank_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `school_all`
--
ALTER TABLE `school_all`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `tbl_global_settings`
--
ALTER TABLE `tbl_global_settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `tbl_module_access`
--
ALTER TABLE `tbl_module_access`
  ADD PRIMARY KEY (`module_access_id`),
  ADD KEY `admin_role_pid` (`role_pid`);

--
-- Indexes for table `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  ADD PRIMARY KEY (`user_role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes_all`
--
ALTER TABLE `classes_all`
  MODIFY `class_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `instructor_level`
--
ALTER TABLE `instructor_level`
  MODIFY `level_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Phrases`
--
ALTER TABLE `Phrases`
  MODIFY `Phrase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `rank`
--
ALTER TABLE `rank`
  MODIFY `rank_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `school_all`
--
ALTER TABLE `school_all`
  MODIFY `school_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_global_settings`
--
ALTER TABLE `tbl_global_settings`
  MODIFY `setting_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_module_access`
--
ALTER TABLE `tbl_module_access`
  MODIFY `module_access_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8091;

--
-- AUTO_INCREMENT for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  MODIFY `user_role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
