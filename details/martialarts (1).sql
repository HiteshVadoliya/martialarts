-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2024 at 03:34 PM
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
  `class_pid` int(11) DEFAULT NULL,
  `school_pid` int(11) NOT NULL,
  `instructor_pid` int(11) NOT NULL,
  `weekday_pid` int(11) DEFAULT NULL,
  `day_time` time DEFAULT NULL,
  `effective_date_from` date DEFAULT NULL,
  `effective_date_to` date DEFAULT NULL,
  `effective_date` varchar(150) NOT NULL,
  `week` int(11) NOT NULL,
  `day` varchar(50) NOT NULL,
  `day_number` int(11) NOT NULL,
  `class_status` tinyint(4) DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `isDelete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `class_pid`, `school_pid`, `instructor_pid`, `weekday_pid`, `day_time`, `effective_date_from`, `effective_date_to`, `effective_date`, `week`, `day`, `day_number`, `class_status`, `status`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 1, '10:00:00', '2024-02-12', '2024-02-17', '2024-02-12 - 2024-02-17', 0, '', 0, 1, 1, 0, '2024-02-08 19:54:00', NULL),
(2, 3, 1, 8091, 1, '11:00:00', '2024-02-12', '2024-02-17', '2024-02-12 - 2024-02-17', 0, '', 0, 0, 1, 0, '2024-02-08 19:54:51', NULL),
(3, 2, 1, 8092, 1, '12:10:00', '2024-02-12', '2024-02-17', '2024-02-12 - 2024-02-17', 0, '', 0, 0, 1, 0, '2024-02-08 19:55:23', NULL),
(4, 1, 2, 2, 1, '14:30:00', '2024-02-12', '2024-02-17', '2024-02-12 - 2024-02-17', 0, '', 0, 0, 1, 0, '2024-02-08 19:56:01', NULL),
(5, 3, 2, 8092, 1, '15:30:00', '2024-02-12', '2024-02-17', '2024-02-12 - 2024-02-17', 0, '', 0, 0, 1, 0, '2024-02-08 19:56:32', NULL),
(6, 2, 3, 8091, 1, '14:10:00', '2024-02-12', '2024-02-17', '2024-02-12 - 2024-02-17', 0, '', 0, 0, 1, 0, '2024-02-08 19:57:02', NULL),
(7, 1, 1, 8093, 2, '21:35:00', '2024-02-12', '2024-02-17', '2024-02-12 - 2024-02-17', 0, '', 0, 0, 1, 0, '2024-02-08 19:57:58', NULL),
(8, 6, 1, 8093, 2, '15:10:00', '2024-02-12', '2024-02-17', '2024-02-12 - 2024-02-17', 0, '', 0, 1, 1, 0, '2024-02-08 19:58:33', NULL),
(9, 2, 2, 8091, 3, '08:35:00', '2024-02-16', '2024-02-17', '2024-02-16 - 2024-02-17', 0, '', 0, 0, 1, 0, '2024-02-16 08:46:27', NULL),
(10, 1, 1, 2, 1, '13:47:00', '2024-02-16', '2024-02-17', '2024-02-16 - 2024-02-17', 0, '', 0, 0, 1, 0, '2024-02-16 08:47:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_bk`
--

CREATE TABLE `schedule_bk` (
  `schedule_id` int(10) UNSIGNED NOT NULL,
  `schedule_title` varchar(255) NOT NULL,
  `school_pid` int(11) NOT NULL,
  `schedule_time` datetime DEFAULT NULL,
  `week` int(11) NOT NULL,
  `day` varchar(50) NOT NULL,
  `day_number` int(11) NOT NULL,
  `assign_pid` int(11) DEFAULT NULL,
  `assign_as` enum('Lead','Assistance') DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `isDelete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedule_bk`
--

INSERT INTO `schedule_bk` (`schedule_id`, `schedule_title`, `school_pid`, `schedule_time`, `week`, `day`, `day_number`, `assign_pid`, `assign_as`, `status`, `isDelete`, `created_at`, `updated_at`) VALUES
(2, 'Legal Instructor', 1, '2024-01-29 10:56:00', 5, 'Monday', 1, NULL, NULL, 1, 0, '2024-01-27 09:57:03', '2024-01-27 05:36:33'),
(3, 'Home School', 1, '2024-01-29 11:59:00', 5, 'Monday', 1, NULL, NULL, 1, 0, '2024-01-27 09:57:34', '2024-01-27 05:36:33'),
(4, 'Tiger Cub', 1, '2024-01-29 11:43:00', 5, 'Monday', 1, NULL, NULL, 1, 0, '2024-01-27 10:02:01', '2024-01-27 05:37:25'),
(5, 'Cubs', 3, '2024-01-29 18:14:00', 5, 'Monday', 1, NULL, NULL, 0, 0, '2024-01-27 10:02:36', '2024-01-27 05:37:27'),
(6, 'Beginner Sparring', 1, '2024-01-30 10:02:00', 5, 'Tuesday', 2, NULL, NULL, 1, 0, '2024-01-27 10:03:19', '2024-01-27 05:36:33'),
(7, 'XMA', 1, '2024-01-30 05:03:00', 5, 'Tuesday', 2, NULL, NULL, 1, 0, '2024-01-27 10:03:43', '2024-01-27 05:36:33'),
(8, 'Homeschool', 1, '2024-01-31 06:11:00', 5, 'Wednesday', 3, NULL, NULL, 1, 0, '2024-01-27 10:04:36', '2024-01-27 05:36:33'),
(9, 'Tiger Cub', 2, '2024-01-31 10:04:00', 5, 'Wednesday', 3, NULL, NULL, 1, 0, '2024-01-27 10:06:05', '2024-01-27 05:36:40'),
(10, 'instructor class', 3, '2024-02-01 04:11:00', 5, 'Thursday', 4, NULL, NULL, 1, 0, '2024-01-27 10:08:19', '2024-01-27 05:36:49'),
(11, 'test44', 2, '2024-02-09 11:08:00', 6, 'Friday', 5, NULL, NULL, 1, 0, '2024-01-27 11:09:10', NULL),
(12, 'test 4', 3, '2024-02-10 11:09:00', 6, 'Saturday', 6, NULL, NULL, 1, 0, '2024-01-27 11:09:29', NULL);

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
(1, 'admin', '', 'mart', '$2y$10$E4BY2GTa2hBB/ZW0ytTRXOwL6XrqVZnprg9HfgLvOxmlohVMl6Etu', 'admin@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1231230001', NULL, 1, 1, 0, '2024-01-21 09:20:40', NULL),
(2, 'ekon ins', '', 'instructor', '$2y$10$6ur358Fczm1sYaRV3Fy2J.w/seWmUy2napWmcGcfLndELTK5jgnhi', 'instructor@gmail.com', NULL, 1, 1, 10.00, '2', '2', '1231230002', '', 1, 1, 0, '2024-01-21 09:20:40', '2024-02-15 01:25:28'),
(3, 'Assistants', '', 'assistants', '$2y$10$bFD6b78OVQxF6qy0Rx66v.xOqLAd7EqRt.LjOoGpJrrf2kpJ3WFZC', 'assistants@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1231230003', NULL, 1, 1, 0, '2024-01-21 09:20:40', NULL),
(4, 'Students', '', 'students', '$2y$10$mX1G5dLstYqNl8GA1X8hXefVGpQar6PC68BYOcbb7FWhsUTBMJBGe', 'student@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '1231320004', NULL, 1, 0, 0, '2024-01-21 09:20:40', NULL),
(5, 'Smith Ins', '', 'ins', '$2y$10$E4BY2GTa2hBB/ZW0ytTRXOwL6XrqVZnprg9HfgLvOxmlohVMl6Etu', 'smith@gmail.com', NULL, 1, 1, 10.00, '1,2,3,6', '1,2', '1231230005', NULL, 1, 0, 0, '2024-01-21 09:20:40', '2024-02-08 14:17:56'),
(8091, 'Jack ins', '', '', '$2y$10$gkjvOhVLjuV4g7lR7.GaV.6dx9XpsoBXRwSoLsM7ReHCTwt72iney', 'jack@gmail.com', NULL, 2, 2, 1.00, '1,2,4,6', '1', '123', NULL, 0, 1, 0, '2024-02-06 21:27:00', '2024-02-08 14:18:07'),
(8092, 'will ins', '', '', '$2y$10$jQJznHHrBVOWWWAaDsVi.edFQI1tLrph7iPQZnCoQ0ahNaseRsKX6', 'will@gmail.com', NULL, 2, 3, 2.00, '2,3', '3', '9898989898', NULL, 0, 1, 0, '2024-02-08 19:48:46', NULL),
(8093, 'ruth ins', '', '', '$2y$10$xmxsugdhXxWC1YbR3LwTGeau0w4XhDOtney/0n7isCmqsNbGSglNG', 'ruth@gmail.com', NULL, 4, 4, 10.00, '1,2,6', '1', '7897897899', NULL, 0, 0, 0, '2024-02-08 19:49:25', NULL);

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
(9, 5, 2, '2024-01-21 12:32:08', NULL, '2023-11-07 11:29:50', '', 1),
(10, 8083, 2, '2024-01-21 12:36:25', NULL, '0000-00-00 00:00:00', '', 0),
(14, 8090, 2, '2024-01-21 12:36:25', NULL, '0000-00-00 00:00:00', '', 0),
(15, 8091, 2, '2024-02-06 21:27:00', NULL, '0000-00-00 00:00:00', '', 0),
(16, 8092, 2, '2024-02-08 19:48:46', NULL, '0000-00-00 00:00:00', '', 0),
(17, 8093, 2, '2024-02-08 19:49:25', NULL, '0000-00-00 00:00:00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `weekdays`
--

CREATE TABLE `weekdays` (
  `weekdays_id` int(10) UNSIGNED NOT NULL,
  `week_title` varchar(155) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `isDelete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `weekdays`
--

INSERT INTO `weekdays` (`weekdays_id`, `week_title`, `status`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'Monday', 1, 0, '2024-02-06 21:29:32', NULL),
(2, 'Tuesday', 1, 0, '2024-02-06 21:29:32', NULL),
(3, 'Wednesday', 1, 0, '2024-02-06 21:29:50', NULL),
(4, 'Thursday', 1, 0, '2024-02-06 21:29:50', NULL),
(5, 'Friday', 1, 0, '2024-02-06 21:29:58', NULL),
(6, 'Saturday', 1, 0, '2024-02-06 21:29:58', NULL),
(7, 'Sunday', 1, 0, '2024-02-06 21:30:04', NULL);

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
-- Indexes for table `schedule_bk`
--
ALTER TABLE `schedule_bk`
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
-- Indexes for table `weekdays`
--
ALTER TABLE `weekdays`
  ADD PRIMARY KEY (`weekdays_id`);

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
-- AUTO_INCREMENT for table `rank`
--
ALTER TABLE `rank`
  MODIFY `rank_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `schedule_bk`
--
ALTER TABLE `schedule_bk`
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
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8094;

--
-- AUTO_INCREMENT for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  MODIFY `user_role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `weekdays`
--
ALTER TABLE `weekdays`
  MODIFY `weekdays_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
