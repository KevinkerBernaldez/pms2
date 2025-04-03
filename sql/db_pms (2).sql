-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2025 at 03:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department`, `description`, `status`, `date_entry`) VALUES
(1, 'Administrative', 'a', 'Active', '2025-03-04 14:00:38'),
(5, 'CCIS', NULL, 'Active', '2025-03-06 05:05:38'),
(6, 'CCJE', NULL, 'Active', '2025-03-06 05:05:46');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `request_no` varchar(255) NOT NULL,
  `office` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `service` enum('Air Condition Unit','Light Bulb','Ceiling Fan','Others') DEFAULT NULL,
  `service_others` varchar(255) DEFAULT NULL,
  `jf_one` int(11) DEFAULT NULL,
  `jf_two` int(11) DEFAULT NULL,
  `jf_three` int(11) DEFAULT NULL,
  `jf_four` int(11) DEFAULT NULL,
  `jf_five` int(11) DEFAULT NULL,
  `average_rate` varchar(10) NOT NULL,
  `remarks` text DEFAULT NULL,
  `personnel_id` int(11) DEFAULT NULL,
  `personnel` varchar(255) DEFAULT NULL,
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `request_no`, `office`, `date`, `position`, `service`, `service_others`, `jf_one`, `jf_two`, `jf_three`, `jf_four`, `jf_five`, `average_rate`, `remarks`, `personnel_id`, `personnel`, `date_entry`) VALUES
(1, '2', 'CCIS College Office', '2025-03-23', 'Personnel', 'Others', 'Bulb Repair', 3, 3, 3, 3, 3, '3', 'Good service', 17, 'Employee Employee', '2025-03-23 08:30:19');

-- --------------------------------------------------------

--
-- Table structure for table `history_record`
--

CREATE TABLE `history_record` (
  `id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `job_order_no` varchar(255) NOT NULL,
  `problem` varchar(255) NOT NULL,
  `action_taken` varchar(255) NOT NULL,
  `date_completed` date NOT NULL,
  `conducted_by` varchar(255) NOT NULL,
  `accepted_by_id` int(11) NOT NULL,
  `accepted_by` varchar(255) NOT NULL,
  `accepted_by_date` date NOT NULL,
  `status` enum('FOR ACCEPTANCE','APPROVED') NOT NULL DEFAULT 'FOR ACCEPTANCE',
  `date_entry` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inspection`
--

CREATE TABLE `inspection` (
  `id` int(11) NOT NULL,
  `request_no` varchar(255) DEFAULT NULL,
  `date_inspected` date DEFAULT NULL,
  `details` text DEFAULT NULL,
  `inspected_by_id` int(11) DEFAULT NULL,
  `inspected_by` varchar(255) DEFAULT NULL,
  `inspected_by_date` date DEFAULT NULL,
  `conformed_by_id` int(11) DEFAULT NULL,
  `conformed_by` varchar(255) DEFAULT NULL,
  `conformed_by_date` date DEFAULT NULL,
  `verified_by_id` int(11) DEFAULT NULL,
  `verified_by` varchar(255) DEFAULT NULL,
  `verified_by_date` date DEFAULT NULL,
  `approved_by_id` int(11) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_by_date` date DEFAULT NULL,
  `status` enum('FOR USER','FOR PMO','FOR VP','APPROVED') DEFAULT 'FOR USER',
  `with_job_order` enum('Yes','No') DEFAULT 'No',
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `inspection`
--

INSERT INTO `inspection` (`id`, `request_no`, `date_inspected`, `details`, `inspected_by_id`, `inspected_by`, `inspected_by_date`, `conformed_by_id`, `conformed_by`, `conformed_by_date`, `verified_by_id`, `verified_by`, `verified_by_date`, `approved_by_id`, `approved_by`, `approved_by_date`, `status`, `with_job_order`, `date_entry`) VALUES
(1, '2', '2025-03-23', 'Needed Repair', 14, 'General Services', '2025-03-23', 17, 'Employee Employee', '2025-03-23', 16, 'Pmo Ako', '2025-03-23', 13, 'Vp Admin', '2025-03-23', 'APPROVED', 'Yes', '2025-03-23 08:25:59');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `property_inventory_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_category` varchar(255) DEFAULT NULL,
  `pr_no` varchar(30) DEFAULT NULL,
  `date_purchase` date DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_released` date DEFAULT NULL,
  `ws_no` varchar(30) DEFAULT NULL,
  `is_signed` enum('Yes','No') DEFAULT 'No',
  `brand` varchar(255) DEFAULT NULL,
  `part_code` varchar(255) DEFAULT NULL,
  `model_number` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `property_inventory_id`, `user_id`, `item_category`, `pr_no`, `date_purchase`, `quantity`, `unit`, `description`, `date_released`, `ws_no`, `is_signed`, `brand`, `part_code`, `model_number`, `serial_number`, `status`, `remarks`, `date_entry`) VALUES
(3, NULL, 17, 'Others', '23', '2025-03-23', 2, 'Unit', 'Printer', '2025-03-23', '234', 'No', 'N/A', '4', '43', '21', 'B', NULL, '2025-03-23 07:58:59'),
(4, NULL, 17, 'Others', '23', '2025-03-23', 2, 'Unit', 'Bangko', '2025-03-23', '234', 'No', 'N/A', '5', '32', '2', 'F', NULL, '2025-03-23 07:58:59'),
(5, NULL, 17, 'Office Supplies', '2343', '2025-03-22', 0, 'Unit', 'Laptop', '2025-03-23', '2', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 08:09:17'),
(6, NULL, 17, 'Office Supplies', '2343', '2025-03-22', 0, 'Unit', 'Desk', '2025-03-23', '2', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 08:09:17'),
(7, NULL, 17, 'Others', '23467', '2025-03-23', 3, 'Unit', 'WhiteBoard', '2025-03-23', '6', 'No', 'N/A', '54', '23', '43', 'G', NULL, '2025-03-23 08:16:46'),
(8, NULL, 17, 'Others', '23467', '2025-03-23', 2, 'Unit', 'Lecturn', '2025-03-23', '6', 'No', 'N/A', '42', '234', '421', 'L', NULL, '2025-03-23 08:16:46'),
(9, NULL, 19, 'Construction Materials', '23', NULL, 2, 'Pcs', 'Welding', NULL, NULL, 'No', 'N/A', 'N/A', 'N/A', '2412', 'Good', NULL, '2025-03-23 08:32:22'),
(10, NULL, 19, 'Construction Materials', '23', NULL, 2, 'Pcs', 'Martilyo', NULL, NULL, 'No', 'N/A', 'N/A', 'N/A', '2', 'Good', NULL, '2025-03-23 08:32:22');

-- --------------------------------------------------------

--
-- Table structure for table `job_order`
--

CREATE TABLE `job_order` (
  `id` int(11) NOT NULL,
  `request_no` varchar(255) DEFAULT NULL,
  `repair_type` varchar(255) DEFAULT NULL,
  `date_repair` date DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `transaction` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `technician_by_id` int(11) DEFAULT NULL,
  `technician_by` varchar(255) DEFAULT NULL,
  `technician_by_date` date DEFAULT NULL,
  `verified_by_id` int(11) DEFAULT NULL,
  `verified_by` varchar(255) DEFAULT NULL,
  `verified_by_date` date DEFAULT NULL,
  `approved_by_id` int(11) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_by_date` date DEFAULT NULL,
  `status` enum('FOR PMO','APPROVED') DEFAULT 'FOR PMO',
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `job_order`
--

INSERT INTO `job_order` (`id`, `request_no`, `repair_type`, `date_repair`, `department`, `transaction`, `remarks`, `technician_by_id`, `technician_by`, `technician_by_date`, `verified_by_id`, `verified_by`, `verified_by_date`, `approved_by_id`, `approved_by`, `approved_by_date`, `status`, `date_entry`) VALUES
(1, '2', 'Repair', '2025-03-23', 5, 'Bulb Repair', 'Done Repair', 10, 'Technician Random', '2025-03-23', 14, 'General Services', '2025-03-23', 16, 'Pmo Ako', '2025-03-23', 'APPROVED', '2025-03-23 08:28:17');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `logs_desc` text NOT NULL,
  `date_entry` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `logs_desc`, `date_entry`) VALUES
(1, 1, 'Logged In', '2025-03-16 11:51:12'),
(2, 1, 'Added user No. 17', '2025-03-16 11:52:24'),
(3, 1, 'Update Profile', '2025-03-16 11:52:46'),
(4, 1, 'Logged Out', '2025-03-16 11:52:57'),
(5, 17, 'Logged In', '2025-03-16 11:53:04'),
(6, 17, 'Added request entry No. 1', '2025-03-16 11:54:51'),
(7, 15, 'Logged In', '2025-03-16 11:55:37'),
(8, 15, 'Logged Out', '2025-03-16 12:00:03'),
(9, 16, 'Logged In', '2025-03-16 12:00:08'),
(10, 16, 'Logged Out', '2025-03-16 12:01:10'),
(11, 13, 'Logged In', '2025-03-16 12:01:52'),
(12, 13, 'Logged Out', '2025-03-16 12:02:08'),
(13, 14, 'Logged In', '2025-03-16 12:02:30'),
(14, 14, 'Added inspection entry No. 1', '2025-03-16 12:02:54'),
(15, 14, 'Logged Out', '2025-03-16 12:03:06'),
(16, 17, 'Logged In', '2025-03-16 12:03:23'),
(17, 17, 'Logged Out', '2025-03-16 12:04:27'),
(18, 16, 'Logged In', '2025-03-16 12:04:34'),
(19, 16, 'Logged Out', '2025-03-16 12:04:47'),
(20, 13, 'Logged In', '2025-03-16 12:04:50'),
(21, 13, 'Logged Out', '2025-03-16 12:05:11'),
(22, 14, 'Logged In', '2025-03-16 12:05:22'),
(23, 14, 'Added job order entry No. 1', '2025-03-16 12:06:06'),
(24, 14, 'Logged Out', '2025-03-16 12:06:22'),
(25, 17, 'Logged In', '2025-03-16 12:06:33'),
(26, 17, 'Added feedback entry No. 1', '2025-03-16 12:07:11'),
(27, 17, 'Logged Out', '2025-03-16 12:07:17'),
(28, 14, 'Logged In', '2025-03-16 12:07:21'),
(29, 14, 'Logged Out', '2025-03-16 12:08:03'),
(30, 17, 'Logged In', '2025-03-16 12:08:06'),
(31, 17, 'Logged Out', '2025-03-16 12:08:23'),
(32, 15, 'Logged In', '2025-03-16 12:08:29'),
(33, 15, 'Added inventory entry No. 1', '2025-03-16 12:09:24'),
(34, 15, 'Updated logsheet entry No. 1', '2025-03-16 12:09:45'),
(35, 15, 'Added history record No. 1', '2025-03-16 12:12:30'),
(36, 15, 'Logged Out', '2025-03-16 12:16:36'),
(37, 17, 'Logged In', '2025-03-16 12:17:14'),
(38, 17, 'Logged Out', '2025-03-16 12:17:50'),
(39, 15, 'Logged In', '2025-03-16 12:17:54'),
(40, 15, 'Logged Out', '2025-03-16 12:19:58'),
(41, 1, 'Logged In', '2025-03-16 12:20:01'),
(42, 1, 'Logged Out', '2025-03-16 12:23:01'),
(43, 17, 'Logged In', '2025-03-16 12:23:19'),
(44, 17, 'Logged Out', '2025-03-16 12:29:25'),
(45, 15, 'Logged In', '2025-03-16 12:29:32'),
(46, 1, 'Logged In', '2025-03-18 02:33:49'),
(47, 1, 'Logged Out', '2025-03-18 02:34:10'),
(48, 17, 'Logged In', '2025-03-18 02:34:18'),
(49, 17, 'Logged Out', '2025-03-18 03:06:00'),
(50, 15, 'Logged In', '2025-03-18 03:06:03'),
(51, 17, 'Logged In', '2025-03-18 06:56:09'),
(52, 15, 'Logged In', '2025-03-18 06:59:03'),
(53, 15, 'Logged Out', '2025-03-18 07:01:05'),
(54, 16, 'Logged In', '2025-03-18 07:01:10'),
(55, 16, 'Logged Out', '2025-03-18 07:01:33'),
(56, 13, 'Logged In', '2025-03-18 07:01:37'),
(57, 17, 'Logged Out', '2025-03-18 07:03:27'),
(58, 13, 'Logged In', '2025-03-18 07:03:33'),
(59, 13, 'Logged In', '2025-03-18 07:05:10'),
(60, 13, 'Logged Out', '2025-03-18 07:05:34'),
(61, 15, 'Logged In', '2025-03-18 07:05:40'),
(62, 15, 'Logged Out', '2025-03-18 07:14:03'),
(63, 1, 'Logged In', '2025-03-18 07:14:07'),
(64, 17, 'Logged In', '2025-03-18 07:14:47'),
(65, 15, 'Logged In', '2025-03-18 07:15:02'),
(66, 15, 'Added inventory entry No. 2', '2025-03-18 07:15:56'),
(67, 15, 'Updated logsheet entry No. 2', '2025-03-18 07:16:34'),
(68, 15, 'Inserted a new withdrawal entry', '2025-03-18 07:16:34'),
(69, 15, 'Logged Out', '2025-03-18 07:16:55'),
(70, 1, 'Logged In', '2025-03-18 07:17:10'),
(71, 1, 'Added user No. 18', '2025-03-18 07:17:45'),
(72, 1, 'Logged Out', '2025-03-18 07:17:50'),
(73, 15, 'Logged In', '2025-03-18 07:17:53'),
(74, 15, 'Added inventory entry No. 3', '2025-03-18 07:18:38'),
(75, 15, 'Updated logsheet entry No. 3', '2025-03-18 07:18:54'),
(76, 15, 'Updated logsheet entry No. 3', '2025-03-18 07:19:10'),
(77, 15, 'Inserted a new withdrawal entry', '2025-03-18 07:19:10'),
(78, 15, 'Logged Out', '2025-03-18 07:19:19'),
(79, 17, 'Logged In', '2025-03-18 07:19:23'),
(80, 17, 'Logged Out', '2025-03-18 07:20:23'),
(81, 14, 'Logged In', '2025-03-18 07:20:29'),
(82, 14, 'Logged Out', '2025-03-18 07:20:45'),
(83, 17, 'Logged In', '2025-03-18 07:20:51'),
(84, 1, 'Logged In', '2025-03-18 10:43:31'),
(85, 1, 'Logged Out', '2025-03-18 11:11:15'),
(86, 17, 'Logged In', '2025-03-18 11:11:21'),
(87, 17, 'Logged In', '2025-03-18 11:24:04'),
(88, 17, 'Logged Out', '2025-03-18 11:33:41'),
(89, 15, 'Logged In', '2025-03-18 11:33:50'),
(90, 15, 'Logged In', '2025-03-19 11:28:02'),
(91, 15, 'Updated logsheet entry No. 1', '2025-03-19 11:28:31'),
(92, 15, 'Inserted a new withdrawal entry', '2025-03-19 11:28:31'),
(93, 15, 'Added inventory entry No. 4', '2025-03-19 11:40:31'),
(94, 15, 'Updated logsheet entry No. 4', '2025-03-19 11:40:56'),
(95, 15, 'Inserted a new withdrawal entry', '2025-03-19 11:40:56'),
(96, 15, 'Logged Out', '2025-03-19 12:08:23'),
(97, 17, 'Logged In', '2025-03-19 12:08:33'),
(98, 15, 'Logged In', '2025-03-19 12:33:57'),
(99, 15, 'Logged In', '2025-03-19 13:03:07'),
(100, 17, 'Logged In', '2025-03-19 13:14:19'),
(101, 1, 'Logged In', '2025-03-19 13:21:58'),
(102, 1, 'Added user No. 19', '2025-03-19 13:22:47'),
(103, 1, 'Logged Out', '2025-03-19 13:23:50'),
(104, 19, 'Logged In', '2025-03-19 13:24:07'),
(105, 19, 'Logged Out', '2025-03-19 13:25:44'),
(106, 14, 'Logged In', '2025-03-19 13:25:48'),
(107, 14, 'Logged Out', '2025-03-19 13:26:08'),
(108, 19, 'Logged In', '2025-03-19 13:26:13'),
(109, 17, 'Logged Out', '2025-03-19 13:28:15'),
(110, 15, 'Logged In', '2025-03-19 13:28:19'),
(111, 15, 'Added inventory entry No. 5', '2025-03-19 13:31:31'),
(112, 15, 'Updated logsheet entry No. 5', '2025-03-19 13:31:52'),
(113, 15, 'Inserted a new withdrawal entry', '2025-03-19 13:31:52'),
(114, 19, 'Logged Out', '2025-03-19 13:34:28'),
(115, 17, 'Logged In', '2025-03-19 13:34:33'),
(116, 15, 'Logged In', '2025-03-19 13:35:20'),
(117, 15, 'Logged Out', '2025-03-19 13:36:18'),
(118, 17, 'Logged In', '2025-03-19 13:36:26'),
(119, 17, 'Logged Out', '2025-03-19 13:37:35'),
(120, 14, 'Logged In', '2025-03-19 13:37:40'),
(121, 17, 'Logged Out', '2025-03-19 13:39:24'),
(122, 15, 'Logged In', '2025-03-19 13:39:28'),
(123, 14, 'Logged In', '2025-03-19 13:49:09'),
(124, 16, 'Logged In', '2025-03-19 13:53:21'),
(125, 15, 'Logged In', '2025-03-21 08:38:31'),
(126, 15, 'Logged In', '2025-03-21 08:48:04'),
(127, 17, 'Logged In', '2025-03-21 08:50:52'),
(128, 17, 'Updated logsheet entry No. 123', '2025-03-21 08:51:16'),
(129, 17, 'Inserted a new withdrawal entry', '2025-03-21 08:51:16'),
(130, 15, 'Logged In', '2025-03-21 08:53:11'),
(131, 17, 'Logged In', '2025-03-21 08:54:53'),
(132, 15, 'Updated logsheet entry No. 321', '2025-03-21 08:56:39'),
(133, 15, 'Inserted a new withdrawal entry', '2025-03-21 08:56:39'),
(134, 15, 'Updated logsheet entry No. 345', '2025-03-21 08:59:02'),
(135, 15, 'Inserted a new withdrawal entry', '2025-03-21 08:59:02'),
(136, 15, 'Logged In', '2025-03-21 14:56:46'),
(137, 17, 'Logged In', '2025-03-21 15:01:10'),
(138, 17, 'Logged Out', '2025-03-21 15:08:14'),
(139, 15, 'Logged In', '2025-03-21 15:08:18'),
(140, 14, 'Logged In', '2025-03-22 01:17:36'),
(141, 17, 'Logged In', '2025-03-22 01:17:53'),
(142, 17, 'Added request entry No. 1', '2025-03-22 01:18:30'),
(143, 14, 'Logged Out', '2025-03-22 01:18:37'),
(144, 15, 'Logged In', '2025-03-22 01:18:41'),
(145, 15, 'Logged Out', '2025-03-22 01:19:17'),
(146, 16, 'Logged In', '2025-03-22 01:19:21'),
(147, 17, 'Logged Out', '2025-03-22 01:19:41'),
(148, 13, 'Logged In', '2025-03-22 01:19:44'),
(149, 13, 'Logged Out', '2025-03-22 01:20:10'),
(150, 14, 'Logged In', '2025-03-22 01:20:18'),
(151, 14, 'Added inspection entry No. 1', '2025-03-22 01:20:40'),
(152, 16, 'Logged Out', '2025-03-22 01:20:56'),
(153, 17, 'Logged In', '2025-03-22 01:21:02'),
(154, 14, 'Logged Out', '2025-03-22 01:21:57'),
(155, 16, 'Logged In', '2025-03-22 01:22:03'),
(156, 16, 'Logged Out', '2025-03-22 01:22:20'),
(157, 13, 'Logged In', '2025-03-22 01:22:23'),
(158, 13, 'Logged Out', '2025-03-22 02:50:01'),
(159, 14, 'Logged In', '2025-03-22 02:50:05'),
(160, 14, 'Added job order entry No. 1', '2025-03-22 02:50:54'),
(161, 14, 'Logged Out', '2025-03-22 02:51:19'),
(162, 16, 'Logged In', '2025-03-22 02:51:22'),
(163, 17, 'Added feedback entry No. 1', '2025-03-22 02:52:49'),
(164, 16, 'Logged Out', '2025-03-22 03:28:06'),
(165, 15, 'Logged In', '2025-03-22 03:28:10'),
(166, 15, 'Updated logsheet entry No. 34', '2025-03-22 03:30:57'),
(167, 15, 'Inserted a new withdrawal entry', '2025-03-22 03:30:57'),
(168, 15, 'Added history record No. 1', '2025-03-22 03:35:42'),
(169, 17, 'Logged In', '2025-03-22 03:37:56'),
(170, 15, 'Added history record No. 2', '2025-03-22 03:41:05'),
(171, 17, 'Logged Out', '2025-03-22 06:18:15'),
(172, 15, 'Logged In', '2025-03-22 06:18:30'),
(173, 15, 'Logged Out', '2025-03-22 06:20:05'),
(174, 17, 'Logged In', '2025-03-22 06:20:09'),
(175, 15, 'Updated logsheet entry No. 123', '2025-03-22 06:20:36'),
(176, 15, 'Inserted a new withdrawal entry', '2025-03-22 06:20:36'),
(177, 15, 'Updated logsheet entry No. 4', '2025-03-22 06:22:25'),
(178, 15, 'Inserted a new withdrawal entry', '2025-03-22 06:22:25'),
(179, 15, 'Logged Out', '2025-03-22 06:24:42'),
(180, 1, 'Logged In', '2025-03-22 06:24:46'),
(181, 1, 'Logged Out', '2025-03-22 06:26:00'),
(182, 14, 'Logged In', '2025-03-22 06:26:06'),
(183, 14, 'Logged In', '2025-03-22 06:27:21'),
(184, 17, 'Logged Out', '2025-03-22 06:30:03'),
(185, 19, 'Logged In', '2025-03-22 06:30:10'),
(186, 14, 'Logged Out', '2025-03-22 06:30:56'),
(187, 15, 'Logged In', '2025-03-22 06:31:00'),
(188, 15, 'Logged Out', '2025-03-22 06:31:28'),
(189, 16, 'Logged In', '2025-03-22 06:31:34'),
(190, 16, 'Logged Out', '2025-03-22 06:32:04'),
(191, 13, 'Logged In', '2025-03-22 06:32:38'),
(192, 15, 'Logged In', '2025-03-22 06:33:57'),
(193, 15, 'Logged In', '2025-03-22 07:06:24'),
(194, 17, 'Logged In', '2025-03-22 07:06:45'),
(195, 15, 'Updated logsheet entry No. 45', '2025-03-22 07:09:14'),
(196, 15, 'Inserted a new withdrawal entry', '2025-03-22 07:09:14'),
(197, 15, 'Logged In', '2025-03-22 07:12:43'),
(198, 15, 'Logged In', '2025-03-22 07:27:56'),
(199, 15, 'Logged In', '2025-03-22 07:52:11'),
(200, 15, 'Logged In', '2025-03-22 07:56:44'),
(201, 15, 'Updated logsheet entry No. n/a', '2025-03-22 07:59:27'),
(202, 15, 'Inserted a new withdrawal entry', '2025-03-22 07:59:27'),
(203, 15, 'Updated logsheet entry No. 12', '2025-03-22 08:12:43'),
(204, 15, 'Inserted a new withdrawal entry', '2025-03-22 08:12:43'),
(205, 15, 'Logged In', '2025-03-22 08:16:40'),
(206, 15, 'Added history record No. 1', '2025-03-22 08:17:52'),
(207, 15, 'Logged In', '2025-03-22 08:19:37'),
(208, 15, 'Added history record No. 2', '2025-03-22 08:20:20'),
(209, 17, 'Logged In', '2025-03-22 08:20:49'),
(210, 15, 'Logged In', '2025-03-22 08:22:09'),
(211, 15, 'Added history record No. 3', '2025-03-22 08:25:18'),
(212, 15, 'Logged In', '2025-03-22 16:20:51'),
(213, 15, 'Logged In', '2025-03-22 16:21:32'),
(214, 15, 'Logged In', '2025-03-22 19:54:30'),
(215, 1, 'Logged In', '2025-03-23 07:36:56'),
(216, 1, 'Logged Out', '2025-03-23 07:37:05'),
(217, 17, 'Logged In', '2025-03-23 07:37:37'),
(218, 15, 'Logged In', '2025-03-23 07:37:48'),
(219, 15, 'Updated logsheet entry No. 23', '2025-03-23 07:39:52'),
(220, 15, 'Inserted a new withdrawal entry', '2025-03-23 07:39:52'),
(221, 15, 'Logged In', '2025-03-23 08:08:21'),
(222, 15, 'Updated logsheet entry No. 2343', '2025-03-23 08:09:40'),
(223, 15, 'Inserted a new withdrawal entry', '2025-03-23 08:09:40'),
(224, 17, 'Logged In', '2025-03-23 08:15:00'),
(225, 15, 'Updated logsheet entry No. 23467', '2025-03-23 08:17:17'),
(226, 15, 'Inserted a new withdrawal entry', '2025-03-23 08:17:17'),
(227, 17, 'Added request entry No. 1', '2025-03-23 08:23:08'),
(228, 15, 'Logged Out', '2025-03-23 08:24:31'),
(229, 16, 'Logged In', '2025-03-23 08:24:34'),
(230, 16, 'Logged Out', '2025-03-23 08:25:01'),
(231, 13, 'Logged In', '2025-03-23 08:25:15'),
(232, 13, 'Logged Out', '2025-03-23 08:25:37'),
(233, 14, 'Logged In', '2025-03-23 08:25:42'),
(234, 14, 'Added inspection entry No. 1', '2025-03-23 08:25:59'),
(235, 14, 'Logged Out', '2025-03-23 08:26:06'),
(236, 17, 'Logged In', '2025-03-23 08:26:09'),
(237, 17, 'Logged Out', '2025-03-23 08:26:34'),
(238, 16, 'Logged In', '2025-03-23 08:26:43'),
(239, 16, 'Logged Out', '2025-03-23 08:27:02'),
(240, 13, 'Logged In', '2025-03-23 08:27:09'),
(241, 13, 'Logged Out', '2025-03-23 08:27:31'),
(242, 14, 'Logged In', '2025-03-23 08:27:38'),
(243, 14, 'Added job order entry No. 1', '2025-03-23 08:28:17'),
(244, 14, 'Logged Out', '2025-03-23 08:28:31'),
(245, 16, 'Logged In', '2025-03-23 08:28:35'),
(246, 16, 'Logged Out', '2025-03-23 08:29:00'),
(247, 17, 'Logged In', '2025-03-23 08:29:08'),
(248, 17, 'Added feedback entry No. 1', '2025-03-23 08:30:19'),
(249, 17, 'Logged Out', '2025-03-23 08:30:24'),
(250, 14, 'Logged In', '2025-03-23 08:30:30'),
(251, 17, 'Logged Out', '2025-03-23 08:32:27'),
(252, 14, 'Logged In', '2025-03-23 08:32:35'),
(253, 14, 'Logged Out', '2025-03-23 08:33:20'),
(254, 19, 'Logged In', '2025-03-23 08:33:30'),
(255, 14, 'Logged Out', '2025-03-23 08:34:24'),
(256, 15, 'Logged In', '2025-03-23 08:34:27'),
(257, 15, 'Logged Out', '2025-03-23 08:34:50'),
(258, 16, 'Logged In', '2025-03-23 08:34:58'),
(259, 16, 'Logged Out', '2025-03-23 08:35:40'),
(260, 13, 'Logged In', '2025-03-23 08:35:46'),
(261, 13, 'Logged Out', '2025-03-23 08:36:03'),
(262, 15, 'Logged In', '2025-03-23 08:36:11'),
(263, 19, 'Logged Out', '2025-03-23 08:36:53'),
(264, 17, 'Logged In', '2025-03-23 08:36:59'),
(265, 17, 'Logged Out', '2025-03-23 08:37:52'),
(266, 15, 'Logged In', '2025-03-23 08:37:56'),
(267, 15, 'Logged Out', '2025-03-23 08:38:06'),
(268, 17, 'Logged In', '2025-03-23 08:38:10'),
(269, 15, 'Logged Out', '2025-03-23 08:43:12'),
(270, 16, 'Logged In', '2025-03-23 08:43:23'),
(271, 16, 'Logged Out', '2025-03-23 08:44:18'),
(272, 13, 'Logged In', '2025-03-23 08:44:24'),
(273, 13, 'Logged Out', '2025-03-23 08:45:04'),
(274, 15, 'Logged In', '2025-03-23 08:45:07'),
(275, 15, 'Logged In', '2025-03-23 09:01:14'),
(276, 1, 'Logged In', '2025-03-23 14:19:49');

-- --------------------------------------------------------

--
-- Table structure for table `logsheet`
--

CREATE TABLE `logsheet` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_category` varchar(255) DEFAULT NULL,
  `pr_no` varchar(30) DEFAULT NULL,
  `date_purchase` date DEFAULT NULL,
  `quantity_received` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_released` date DEFAULT NULL,
  `ws_no` varchar(30) DEFAULT NULL,
  `quantity_released` int(11) DEFAULT NULL,
  `is_signed` enum('Yes','No') DEFAULT 'No',
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `logsheet`
--

INSERT INTO `logsheet` (`id`, `user_id`, `item_category`, `pr_no`, `date_purchase`, `quantity_received`, `unit`, `description`, `date_released`, `ws_no`, `quantity_released`, `is_signed`, `date_entry`) VALUES
(1, 17, 'Construction Materials', '23', '2025-03-23', 2, 'Pcs', 'Martilyo', '2025-03-23', '23', 2, 'Yes', '2025-03-23 07:39:01'),
(2, 17, 'Construction Materials', '23', '2025-03-23', 2, 'Pcs', 'Welding', '2025-03-23', '23', 2, 'Yes', '2025-03-23 07:39:01'),
(3, 17, 'Others', '23', '2025-03-23', 2, 'Unit', 'Printer', '2025-03-23', '234', 2, 'No', '2025-03-23 07:58:59'),
(4, 17, 'Others', '23', '2025-03-23', 2, 'Unit', 'Bangko', '2025-03-23', '234', 2, 'No', '2025-03-23 07:58:59'),
(5, 17, 'Office Supplies', '2343', '2025-03-22', 2, 'Unit', 'Laptop', '2025-03-23', '2', 2, 'Yes', '2025-03-23 08:09:17'),
(6, 17, 'Office Supplies', '2343', '2025-03-22', 2, 'Unit', 'Desk', '2025-03-23', '2', 2, 'Yes', '2025-03-23 08:09:17'),
(7, 17, 'Others', '23467', '2025-03-23', 3, 'Unit', 'WhiteBoard', '2025-03-23', '6', 3, 'Yes', '2025-03-23 08:16:46'),
(8, 17, 'Others', '23467', '2025-03-23', 2, 'Unit', 'Lecturn', '2025-03-23', '6', 2, 'Yes', '2025-03-23 08:16:46');

-- --------------------------------------------------------

--
-- Table structure for table `property_disposal`
--

CREATE TABLE `property_disposal` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `item_category` varchar(255) DEFAULT NULL,
  `prepared_by_id` int(11) DEFAULT NULL,
  `prepared_by` varchar(255) DEFAULT NULL,
  `checked_by_id` int(11) DEFAULT NULL,
  `checked_by` varchar(255) DEFAULT NULL,
  `checked_by_date` date DEFAULT NULL,
  `noted_by_id` int(11) DEFAULT NULL,
  `noted_by` varchar(255) DEFAULT NULL,
  `noted_by_date` date DEFAULT NULL,
  `approved_by_id` int(11) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_by_date` date DEFAULT NULL,
  `status` enum('FOR PROPERTY CUSTODIAN','FOR PMO','FOR VP','APPROVED') DEFAULT 'FOR PROPERTY CUSTODIAN',
  `file` text NOT NULL,
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `property_disposal`
--

INSERT INTO `property_disposal` (`id`, `date`, `department`, `item_category`, `prepared_by_id`, `prepared_by`, `checked_by_id`, `checked_by`, `checked_by_date`, `noted_by_id`, `noted_by`, `noted_by_date`, `approved_by_id`, `approved_by`, `approved_by_date`, `status`, `file`, `date_entry`) VALUES
(1, '2025-03-23', 'Administrative', 'Office Supplies', 17, 'Employee Employee', 15, 'pc ako', '2025-03-23', 16, 'Pmo Ako', '2025-03-23', 13, 'Vp Admin', '2025-03-23', 'APPROVED', '1742719260_incident_report.pdf', '2025-03-23 08:41:57');

-- --------------------------------------------------------

--
-- Table structure for table `property_disposal_items`
--

CREATE TABLE `property_disposal_items` (
  `id` int(11) NOT NULL,
  `disposal_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `property_code` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `part_code` varchar(255) DEFAULT NULL,
  `conditioned` varchar(255) DEFAULT 'No',
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `property_disposal_items`
--

INSERT INTO `property_disposal_items` (`id`, `disposal_id`, `quantity`, `unit`, `description`, `property_code`, `brand`, `part_code`, `conditioned`, `remarks`) VALUES
(1, 1, 2, 'Unit', 'Laptop', '123', 'Acer', '23', 'Damage', 'Dispose'),
(2, 1, 2, 'Unit', 'Desk', '32', 'N/A', '412', 'Damage', 'Dispose');

-- --------------------------------------------------------

--
-- Table structure for table `property_inventory`
--

CREATE TABLE `property_inventory` (
  `id` int(11) NOT NULL,
  `date_inventory` date DEFAULT NULL,
  `date_last` date DEFAULT NULL,
  `property_code` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `item_category` varchar(255) DEFAULT 'No',
  `sy` varchar(255) DEFAULT 'No',
  `in_charge_id` int(11) DEFAULT NULL,
  `in_charge` varchar(255) DEFAULT NULL,
  `in_charge_date` date DEFAULT NULL,
  `conformed_by_id` int(11) DEFAULT NULL,
  `conformed_by` varchar(255) DEFAULT NULL,
  `conformed_by_date` date DEFAULT NULL,
  `status` enum('FOR USER','FOR PROPERTY CUSTODIAN','APPROVED') DEFAULT 'FOR USER',
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `property_inventory`
--

INSERT INTO `property_inventory` (`id`, `date_inventory`, `date_last`, `property_code`, `department_id`, `item_category`, `sy`, `in_charge_id`, `in_charge`, `in_charge_date`, `conformed_by_id`, `conformed_by`, `conformed_by_date`, `status`, `date_entry`) VALUES
(1, '2025-03-23', '2025-03-01', '123', 1, 'Others', '2025', 17, 'Employee Employee', '2025-03-23', 15, 'pc ako', '2025-03-23', 'APPROVED', '2025-03-23 08:48:49');

-- --------------------------------------------------------

--
-- Table structure for table `property_inventory_items`
--

CREATE TABLE `property_inventory_items` (
  `id` int(11) NOT NULL,
  `property_inventory_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_category` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `part_code` varchar(255) DEFAULT NULL,
  `model_number` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT 'Ok',
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `property_inventory_items`
--

INSERT INTO `property_inventory_items` (`id`, `property_inventory_id`, `user_id`, `item_category`, `quantity`, `unit`, `description`, `brand`, `part_code`, `model_number`, `serial_number`, `status`, `remarks`, `date_entry`) VALUES
(1, 1, 17, 'Others', 2, 'Unit', 'Printer', 'N/A', '4', '43', '21', 'B', 'Ok', '2025-03-23 08:48:49'),
(2, 1, 17, 'Others', 2, 'Unit', 'Bangko', 'N/A', '5', '32', '2', 'F', 'Ok', '2025-03-23 08:48:49'),
(3, 1, 17, 'Others', 3, 'Unit', 'WhiteBoard', 'N/A', '54', '23', '43', 'G', 'Ok', '2025-03-23 08:48:49'),
(4, 1, 17, 'Others', 2, 'Unit', 'Lecturn', 'N/A', '42', '234', '421', 'L', 'Ok', '2025-03-23 08:48:49');

-- --------------------------------------------------------

--
-- Table structure for table `request_form`
--

CREATE TABLE `request_form` (
  `id` int(11) NOT NULL,
  `request_no` varchar(255) DEFAULT NULL,
  `request_type` enum('Structure/Building','Vehicle','Equipment','Others') DEFAULT NULL,
  `request_type_others` varchar(255) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `date_requested` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `date_action` date DEFAULT NULL,
  `details` text DEFAULT NULL,
  `requested_by_id` int(11) DEFAULT NULL,
  `requested_by` varchar(255) DEFAULT NULL,
  `endorsed_by_id` int(11) DEFAULT NULL,
  `endorsed_by` varchar(255) DEFAULT NULL,
  `endorsed_by_date` date DEFAULT NULL,
  `recommend_by_id` int(11) DEFAULT NULL,
  `recommend_by` varchar(255) DEFAULT NULL,
  `recommend_by_date` date DEFAULT NULL,
  `approved_by_id` int(11) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_by_date` date DEFAULT NULL,
  `status` enum('FOR PROPERTY CUSTODIAN','FOR PMO','FOR VP','APPROVED') DEFAULT 'FOR PROPERTY CUSTODIAN',
  `is_inspected` enum('Yes','No') DEFAULT 'No',
  `is_feedback` enum('Yes','No') NOT NULL DEFAULT 'No',
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `request_form`
--

INSERT INTO `request_form` (`id`, `request_no`, `request_type`, `request_type_others`, `department`, `date_requested`, `location`, `date_action`, `details`, `requested_by_id`, `requested_by`, `endorsed_by_id`, `endorsed_by`, `endorsed_by_date`, `recommend_by_id`, `recommend_by`, `recommend_by_date`, `approved_by_id`, `approved_by`, `approved_by_date`, `status`, `is_inspected`, `is_feedback`, `date_entry`) VALUES
(1, '2', 'Equipment', '', 5, '2025-03-23', '3rd Floor', '2025-03-26', 'Repair Bulb', 17, 'Employee Employee', 15, 'pc ako', '2025-03-23', 16, 'Pmo Ako', '2025-03-23', 13, 'Vp Admin', '2025-03-23', 'APPROVED', 'Yes', 'Yes', '2025-03-23 08:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`id`, `fname`, `lname`, `mname`, `signature`, `status`, `date_entry`) VALUES
(10, 'Technician', 'Random', '', '1741233960_signature.png', 'Active', '2025-03-06 04:06:31');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_property`
--

CREATE TABLE `transfer_property` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `move_from` varchar(255) DEFAULT NULL,
  `move_to_id` int(11) DEFAULT NULL,
  `item_category` varchar(255) DEFAULT NULL,
  `is_transfer` enum('Yes','No') DEFAULT 'No',
  `is_turnover` enum('Yes','No') DEFAULT 'No',
  `others` varchar(255) DEFAULT NULL,
  `prepared_by_id` int(11) DEFAULT NULL,
  `prepared_by` varchar(255) DEFAULT NULL,
  `checked_by_id` int(11) DEFAULT NULL,
  `checked_by` varchar(255) DEFAULT NULL,
  `checked_by_date` date DEFAULT NULL,
  `accepted_by_id` int(11) DEFAULT NULL,
  `accepted_by` varchar(255) DEFAULT NULL,
  `accepted_by_date` date DEFAULT NULL,
  `endorsed_by_id` int(11) DEFAULT NULL,
  `endorsed_by` varchar(255) DEFAULT NULL,
  `endorsed_by_date` date DEFAULT NULL,
  `recommending_by_id` int(11) DEFAULT NULL,
  `recommending_by` varchar(255) DEFAULT NULL,
  `recommending_by_date` date DEFAULT NULL,
  `approved_by_id` int(11) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_by_date` date DEFAULT NULL,
  `status` enum('FOR GENERAL SERVICES','FOR USER','FOR PROPERTY CUSTODIAN','FOR PMO','FOR VP','APPROVED') DEFAULT 'FOR GENERAL SERVICES',
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `transfer_property`
--

INSERT INTO `transfer_property` (`id`, `date`, `move_from`, `move_to_id`, `item_category`, `is_transfer`, `is_turnover`, `others`, `prepared_by_id`, `prepared_by`, `checked_by_id`, `checked_by`, `checked_by_date`, `accepted_by_id`, `accepted_by`, `accepted_by_date`, `endorsed_by_id`, `endorsed_by`, `endorsed_by_date`, `recommending_by_id`, `recommending_by`, `recommending_by_date`, `approved_by_id`, `approved_by`, `approved_by_date`, `status`, `date_entry`) VALUES
(1, '2025-03-23', 'Administrative', 6, 'Construction Materials', 'Yes', 'No', 'Transfer', 17, 'Employee Employee', 14, 'General Services', '2025-03-23', 19, 'Lorevic SAylon', '2025-03-23', 15, 'pc ako', '2025-03-23', 16, 'Pmo Ako', '2025-03-23', 13, 'Vp Admin', '2025-03-23', 'APPROVED', '2025-03-23 08:32:22');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_property_items`
--

CREATE TABLE `transfer_property_items` (
  `id` int(11) NOT NULL,
  `transfer_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `part_code` varchar(255) DEFAULT NULL,
  `model_number` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'No',
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `transfer_property_items`
--

INSERT INTO `transfer_property_items` (`id`, `transfer_id`, `quantity`, `unit`, `description`, `brand`, `part_code`, `model_number`, `serial_number`, `status`, `remarks`) VALUES
(1, 1, 2, 'Pcs', 'Welding', 'N/A', 'N/A', 'N/A', '2412', 'Good', NULL),
(2, 1, 2, 'Pcs', 'Martilyo', 'N/A', 'N/A', 'N/A', '2', 'Good', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('Administrator','General Services','PMO Head','Property Custodian','Staff','Technician','VP','Employee') DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `mname`, `department_id`, `username`, `password`, `role`, `avatar`, `signature`, `status`, `date_entry`) VALUES
(1, 'Kevinker', 'Bernaldez', '', 1, 'admin', '$2y$10$HCK3lPU5KOgZ21/n0HeFW.mEmWj345NdQDXEPOcQdqdSst4PuMHFK', 'Administrator', '1742125920_profile.jpg', '1741234560_signature.png', 'Active', '2025-02-03 13:30:41'),
(13, 'Vp', 'Admin', '', 1, 'vp', '$2y$10$fb15JVl4jVGmFdysLCxbnuZb2UpG68wXaloxk13rw1nqhj7nxQZ0S', 'VP', 'uploads/profile/user.png', '1741570080_signature.png', 'Active', '2025-03-06 04:07:29'),
(14, 'General', 'Services', '', 1, 'genserv', '$2y$10$Dk7bslURYVz3ei3H5SOx8uW5mS.6sfituqbwd5BjscCKjvWRmP5DO', 'General Services', 'uploads/profile/user.png', '1741579200_signature.png', 'Active', '2025-03-06 04:08:48'),
(15, 'pc', 'ako', '', 1, 'pc', '$2y$10$6TQdx6ijYEH1nzBRruy/vucE.5P82EoQL/CmKdCK2L1Cs4s5aIhLy', 'Property Custodian', 'uploads/profile/user.png', '1741234560_signature.png', 'Active', '2025-03-06 04:10:43'),
(16, 'Pmo', 'Ako', '', 1, 'pmo', '$2y$10$YmMAdYRSQKdWKWULA4FhS.etIDpP3X0B.8uHWLGzqfjW79sYNiKhC', 'PMO Head', 'uploads/profile/user.png', '1741601040_signature.png', 'Active', '2025-03-10 04:06:08'),
(17, 'Employee', 'Employee', '', 1, 'emp', '$2y$10$In2rq03jt2k0GQlx3DXCBO4oRsmKOZXYoc/rqbM5KhH0xvkvLKKoe', 'Employee', 'uploads/profile/user.png', '1742125920_signature.png', 'Active', '2025-03-16 11:52:24'),
(18, 'Johnbill', 'Danggis', '', 6, 'johnbill', '$2y$10$ZSOTws065/50z5ZYW281Fu6Btexv94q8WsOS5QPsMcIJc2jDLg2uK', 'Employee', 'uploads/profile/user.png', '1742282220_signature.png', 'Active', '2025-03-18 07:17:45'),
(19, 'Lorevic', 'SAylon', '', 6, 'lorevic', '$2y$10$0Nta9ueBs7IQFlQByIj2LeqUAOvvkFWCgHJQ2rwazK2nvi4dEde1C', 'Employee', 'uploads/profile/user.png', '1742390520_signature.png', 'Active', '2025-03-19 13:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal`
--

CREATE TABLE `withdrawal` (
  `id` int(11) NOT NULL,
  `pr_no` varchar(255) DEFAULT NULL,
  `item` varchar(100) DEFAULT NULL,
  `delivered_to` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `cv` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `prepared_by_id` int(11) NOT NULL,
  `prepared_by` varchar(255) DEFAULT NULL,
  `received_by_id` int(11) NOT NULL,
  `received_by` varchar(255) DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `withdrawal`
--

INSERT INTO `withdrawal` (`id`, `pr_no`, `item`, `delivered_to`, `date`, `cv`, `remarks`, `prepared_by_id`, `prepared_by`, `received_by_id`, `received_by`, `received_date`, `date_entry`) VALUES
(1, '23', 'Construction Materials', 'CCIS', '2025-03-23', 2, 'Released', 15, 'pc ako', 17, 'Employee Employee', '2025-03-23', '2025-03-23 07:39:52'),
(2, '2343', 'Office Supplies', 'CCIS', '2025-03-23', 34, 'Released', 15, 'pc ako', 17, 'Employee Employee', '2025-03-23', '2025-03-23 08:09:40'),
(3, '23467', 'Lecturn', 'CCIS', '2025-03-23', 45, 'Released', 15, 'pc ako', 17, 'Employee Employee', '2025-03-23', '2025-03-23 08:17:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `history_record`
--
ALTER TABLE `history_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inspection`
--
ALTER TABLE `inspection`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `job_order`
--
ALTER TABLE `job_order`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `logsheet`
--
ALTER TABLE `logsheet`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `property_disposal`
--
ALTER TABLE `property_disposal`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `property_disposal_items`
--
ALTER TABLE `property_disposal_items`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `property_inventory`
--
ALTER TABLE `property_inventory`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `property_inventory_items`
--
ALTER TABLE `property_inventory_items`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `request_form`
--
ALTER TABLE `request_form`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `transfer_property`
--
ALTER TABLE `transfer_property`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `transfer_property_items`
--
ALTER TABLE `transfer_property_items`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `withdrawal`
--
ALTER TABLE `withdrawal`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `history_record`
--
ALTER TABLE `history_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inspection`
--
ALTER TABLE `inspection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `job_order`
--
ALTER TABLE `job_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT for table `logsheet`
--
ALTER TABLE `logsheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `property_disposal`
--
ALTER TABLE `property_disposal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_disposal_items`
--
ALTER TABLE `property_disposal_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `property_inventory`
--
ALTER TABLE `property_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_inventory_items`
--
ALTER TABLE `property_inventory_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `request_form`
--
ALTER TABLE `request_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transfer_property`
--
ALTER TABLE `transfer_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transfer_property_items`
--
ALTER TABLE `transfer_property_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `withdrawal`
--
ALTER TABLE `withdrawal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
