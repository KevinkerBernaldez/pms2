-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2025 at 07:38 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department`, `description`, `status`, `date_entry`) VALUES
(1, 'Administrative', 'a', 'Active', '2025-03-04 14:00:38'),
(5, 'CCIS', NULL, 'Active', '2025-03-06 05:05:38'),
(6, 'CCJE', NULL, 'Active', '2025-03-06 05:05:46'),
(7, 'Junior High School', NULL, 'Active', '2025-03-26 10:57:24'),
(8, 'Senior High School', NULL, 'Active', '2025-03-27 03:28:30'),
(9, 'CTHM', NULL, 'Active', '2025-03-27 03:28:43'),
(10, 'CAS', NULL, 'Active', '2025-03-27 03:31:31'),
(11, 'PMO', NULL, 'Active', '2025-03-27 03:35:29');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `request_no`, `office`, `date`, `position`, `service`, `service_others`, `jf_one`, `jf_two`, `jf_three`, `jf_four`, `jf_five`, `average_rate`, `remarks`, `personnel_id`, `personnel`, `date_entry`) VALUES
(1, '01', 'CCIS', '2025-04-03', 'Personnel', 'Ceiling Fan', '', 3, 3, 2, 2, 3, '2.6', 'Very good', 17, 'Employee Employee', '2025-04-03 09:55:13');

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
  `accepted_by_date` date DEFAULT NULL,
  `status` enum('FOR ACCEPTANCE','APPROVED') NOT NULL DEFAULT 'FOR ACCEPTANCE',
  `date_entry` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history_record`
--

INSERT INTO `history_record` (`id`, `inventory_id`, `type`, `date`, `job_order_no`, `problem`, `action_taken`, `date_completed`, `conducted_by`, `accepted_by_id`, `accepted_by`, `accepted_by_date`, `status`, `date_entry`) VALUES
(1, 1, 'R', '2025-03-30', '124', 'Repair printer', 'Repair parts \\\\', '2025-03-31', 'Technician', 25, 'Jonathan Liguid', '2025-03-30', 'APPROVED', '2025-03-30 06:35:32'),
(2, 2, 'R', '2025-03-30', '1412', 'Repair Laptop', 'Repair Parts', '2025-03-30', 'PMO', 25, 'Jonathan Liguid', '2025-03-30', 'APPROVED', '2025-03-30 06:35:10'),
(3, 5, 'R', '2025-03-30', '00011', 'Repair Laptop', 'Replace parts', '2025-03-30', 'Technician', 27, 'Ian joyd Franco', '2025-03-30', 'APPROVED', '2025-03-30 06:54:29');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `inspection`
--

INSERT INTO `inspection` (`id`, `request_no`, `date_inspected`, `details`, `inspected_by_id`, `inspected_by`, `inspected_by_date`, `conformed_by_id`, `conformed_by`, `conformed_by_date`, `verified_by_id`, `verified_by`, `verified_by_date`, `approved_by_id`, `approved_by`, `approved_by_date`, `status`, `with_job_order`, `date_entry`) VALUES
(1, '01', '2025-04-02', 'Functional', 14, 'General Services', '2025-03-31', 17, 'Employee Employee', '2025-03-31', 16, 'Pmo Ako', '2025-03-31', 13, 'Vp Admin', '2025-03-31', 'APPROVED', 'Yes', '2025-03-31 08:16:19'),
(2, '21', '2025-04-09', 'Need Replacement of motherboard', 14, 'General Services', '2025-04-07', 32, 'Joshua Estay', '2025-04-07', 16, 'Pmo Ako', '2025-04-07', 13, 'Vp Admin', '2025-04-07', 'APPROVED', 'Yes', '2025-04-07 02:07:40');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_category` varchar(255) DEFAULT NULL,
  `pr_no` varchar(30) DEFAULT NULL,
  `date_purchase` date DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `other_details` varchar(255) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `user_id`, `item_category`, `pr_no`, `date_purchase`, `quantity`, `unit`, `description`, `other_details`, `date_released`, `ws_no`, `is_signed`, `brand`, `part_code`, `model_number`, `serial_number`, `status`, `remarks`, `date_entry`) VALUES
(1, 25, 'Office Supplies', '2025-27272', '2025-03-27', 2, 'Unit', 'Printer', 'Epson Printing', '2025-03-30', '12345', 'No', 'Epson', '2351', '1235', '1247', 'F', NULL, '2025-03-30 06:25:56'),
(2, 25, 'Office Supplies', '2025-27272', '2025-03-27', 2, 'Unit', 'Laptop', 'Acer Brand', '2025-03-30', '12345', 'No', 'Acer', '314', '125', '217', 'G', NULL, '2025-03-30 06:25:56'),
(3, 19, 'Construction Materials', '2025-235', '2025-03-30', 2, 'Unit', 'Welding Machine', NULL, '2025-03-30', '213', 'No', 'N/A', '213', '24', '27', 'F', NULL, '2025-03-30 06:41:36'),
(4, 19, 'Construction Materials', '2025-235', '2025-03-30', 2, 'Pcs', 'Table', NULL, '2025-03-30', '213', 'No', 'N/A', '15', '128', '2', 'G', NULL, '2025-03-30 06:41:36'),
(5, 27, 'Office Supplies', '2025-123', '2025-03-30', 2, 'unit', 'laptop', 'HP laptop, 1235', '2025-03-30', '21', 'No', 'HP', '1238', '21', '35', 'F', NULL, '2025-03-30 06:51:21'),
(6, 27, 'Office Supplies', '2025-123', '2025-03-30', 2, 'unit', 'lecturn', NULL, '2025-03-30', '21', 'No', 'N/A', '127', '23', '12', 'G', NULL, '2025-03-30 06:51:21'),
(7, 17, 'Construction Materials', '2025-03-31', '2025-03-31', 0, 'pieces', 'Kabilya', NULL, '2025-03-31', '5', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-31 07:51:00'),
(8, 17, 'Construction Materials', '2025-034-01', '2025-03-31', 10, 'pieces', 'Chair', NULL, '2025-03-31', '2', 'No', 'kahoy', 'na', 'na', 'na', 'F', NULL, '2025-03-31 08:06:32'),
(9, 28, 'Office Supplies', '2025-3114', '2025-03-31', 0, 'Ream', 'Bondpaper', NULL, '2025-03-31', '234', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-31 09:16:16'),
(11, 19, 'Office Supplies', '2025-3114', NULL, 2, 'Unit', 'Printer', NULL, NULL, NULL, 'No', 'Epson', '141', '123', '156', 'Functional', NULL, '2025-03-31 09:19:28'),
(12, 29, 'Office Supplies', '2025-1291', '2025-04-01', 1, 'Unit', 'Laptop', NULL, '2025-04-01', '231', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-01 04:16:07'),
(13, 29, 'Office Supplies', '2025-1291', '2025-04-01', 2, 'Unit', 'Printer', NULL, '2025-04-01', '231', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-01 04:16:07'),
(15, 30, 'Office Supplies', '2025-12812', '2025-04-03', 2, 'Unit', 'Laptop', NULL, '2025-04-03', '321', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 01:22:13'),
(16, 30, 'Office Supplies', '2025-12812', '2025-04-03', 2, 'Unit', 'Printer', NULL, '2025-04-03', '321', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 01:22:13'),
(17, 31, 'Construction Materials', '2025-301', '2025-04-03', 2, 'Unit', 'Welding Machine', NULL, '2025-04-03', '023', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 01:42:18'),
(18, 31, 'Construction Materials', '2025-301', '2025-04-03', 2, 'Pcs', 'Martilyo', NULL, '2025-04-03', '023', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 01:42:18'),
(19, 26, 'Office Supplies', '2025-0012', '2025-04-03', 2, 'Unit', 'Laptop', NULL, '2025-04-03', '33', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 02:26:23'),
(20, 26, 'Office Supplies', '2025-0012', '2025-04-03', 2, 'Pcs', 'Table', NULL, '2025-04-03', '33', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-03 02:26:23'),
(21, 32, 'Spareparts', '2025-103', '2025-04-07', 1, 'Pcs', 'Motherboard', NULL, '2025-04-07', '241', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-07 01:57:19'),
(22, 32, 'Spareparts', '2025-103', '2025-04-07', 1, 'Kilo', 'Lansang', NULL, '2025-04-07', '241', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-07 01:57:19'),
(23, 19, 'Office Supplies', '2025-1291', NULL, 1, 'Unit', 'Laptop', NULL, NULL, NULL, 'No', 'Acer', '1246', '21', '312', 'Functional', NULL, '2025-04-07 02:15:52');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `job_order`
--

INSERT INTO `job_order` (`id`, `request_no`, `repair_type`, `date_repair`, `department`, `transaction`, `remarks`, `technician_by_id`, `technician_by`, `technician_by_date`, `verified_by_id`, `verified_by`, `verified_by_date`, `approved_by_id`, `approved_by`, `approved_by_date`, `status`, `date_entry`) VALUES
(1, '01', 'Repair', '2025-04-03', 5, 'Repairing', 'Functional', 1, 'Randy Manto', '2025-03-31', 14, 'General Services', '2025-03-31', 16, 'Pmo Ako', '2025-03-31', 'APPROVED', '2025-03-31 08:20:14'),
(2, '21', 'Replacement', '2025-04-09', 5, 'Replacement of motherboard', 'Done', 1, 'Randy Manto', '2025-04-07', 14, 'General Services', '2025-04-07', 16, 'Pmo Ako', '2025-04-07', 'APPROVED', '2025-04-07 02:12:52');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `logs_desc` text NOT NULL,
  `date_entry` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

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
(276, 1, 'Logged In', '2025-03-23 14:19:49'),
(277, 1, 'Logged In', '2025-03-24 03:52:04'),
(278, 1, 'Updated user No. 17', '2025-03-24 03:52:21'),
(279, 1, 'Updated user No. 17', '2025-03-24 03:52:27'),
(280, 1, 'Logged Out', '2025-03-24 03:54:56'),
(281, 17, 'Logged In', '2025-03-24 03:55:04'),
(282, 15, 'Logged In', '2025-03-24 09:44:23'),
(283, 15, 'Logged In', '2025-03-24 09:52:08'),
(284, 17, 'Logged In', '2025-03-24 09:52:57'),
(285, 17, 'Logged Out', '2025-03-24 09:55:34'),
(286, 1, 'Logged In', '2025-03-24 09:55:38'),
(287, 15, 'Logged In', '2025-03-24 10:01:57'),
(288, 1, 'Logged Out', '2025-03-24 10:07:00'),
(289, 17, 'Logged In', '2025-03-24 10:07:04'),
(290, 15, 'Logged Out', '2025-03-24 10:08:34'),
(291, 14, 'Logged In', '2025-03-24 10:08:38'),
(292, 17, 'Logged Out', '2025-03-24 10:09:12'),
(293, 18, 'Logged In', '2025-03-24 10:09:19'),
(294, 18, 'Logged Out', '2025-03-24 10:13:56'),
(295, 19, 'Logged In', '2025-03-24 10:14:12'),
(296, 14, 'Logged Out', '2025-03-24 10:14:31'),
(297, 17, 'Logged In', '2025-03-24 10:14:35'),
(298, 17, 'Logged Out', '2025-03-24 10:18:03'),
(299, 15, 'Logged In', '2025-03-24 10:18:06'),
(300, 15, 'Logged In', '2025-03-24 10:21:59'),
(301, 15, 'Updated logsheet entry No. 1', '2025-03-24 10:22:24'),
(302, 15, 'Inserted a new withdrawal entry', '2025-03-24 10:22:24'),
(303, 19, 'Logged Out', '2025-03-24 10:23:01'),
(304, 17, 'Logged In', '2025-03-24 10:23:14'),
(305, 15, 'Logged Out', '2025-03-24 10:24:32'),
(306, 17, 'Logged In', '2025-03-24 10:24:36'),
(307, 17, 'Logged Out', '2025-03-24 10:25:30'),
(308, 14, 'Logged In', '2025-03-24 10:25:36'),
(309, 17, 'Logged Out', '2025-03-24 10:25:48'),
(310, 19, 'Logged In', '2025-03-24 10:25:52'),
(311, 14, 'Logged Out', '2025-03-24 10:26:40'),
(312, 15, 'Logged In', '2025-03-24 10:26:43'),
(313, 15, 'Logged In', '2025-03-24 10:28:00'),
(314, 19, 'Logged Out', '2025-03-24 10:28:42'),
(315, 17, 'Logged In', '2025-03-24 10:28:47'),
(316, 15, 'Logged Out', '2025-03-24 10:31:20'),
(317, 1, 'Logged In', '2025-03-24 10:31:24'),
(318, 17, 'Logged In', '2025-03-24 10:33:29'),
(319, 15, 'Logged In', '2025-03-24 12:09:30'),
(320, 19, 'Logged In', '2025-03-24 12:10:05'),
(321, 15, 'Logged Out', '2025-03-24 12:10:34'),
(322, 17, 'Logged In', '2025-03-24 12:10:38'),
(323, 1, 'Logged In', '2025-03-24 12:11:00'),
(324, 1, 'Logged Out', '2025-03-24 12:11:55'),
(325, 17, 'Logged In', '2025-03-24 12:11:59'),
(326, 19, 'Logged Out', '2025-03-24 12:12:06'),
(327, 15, 'Logged In', '2025-03-24 12:12:09'),
(328, 15, 'Logged Out', '2025-03-24 12:12:39'),
(329, 16, 'Logged In', '2025-03-24 12:12:46'),
(330, 16, 'Logged Out', '2025-03-24 12:13:03'),
(331, 13, 'Logged In', '2025-03-24 12:13:07'),
(332, 13, 'Logged Out', '2025-03-24 12:13:30'),
(333, 15, 'Logged In', '2025-03-24 12:13:33'),
(334, 15, 'Logged Out', '2025-03-24 12:16:21'),
(335, 14, 'Logged In', '2025-03-24 12:16:27'),
(336, 14, 'Logged Out', '2025-03-24 12:16:41'),
(337, 19, 'Logged In', '2025-03-24 12:16:49'),
(338, 17, 'Logged Out', '2025-03-24 12:18:15'),
(339, 15, 'Logged In', '2025-03-24 12:18:23'),
(340, 15, 'Logged Out', '2025-03-24 12:18:45'),
(341, 16, 'Logged In', '2025-03-24 12:18:49'),
(342, 16, 'Logged Out', '2025-03-24 12:19:11'),
(343, 13, 'Logged In', '2025-03-24 12:19:14'),
(344, 13, 'Logged Out', '2025-03-24 12:21:15'),
(345, 15, 'Logged In', '2025-03-24 12:21:19'),
(346, 15, 'Logged Out', '2025-03-24 12:21:55'),
(347, 16, 'Logged In', '2025-03-24 12:22:17'),
(348, 16, 'Logged Out', '2025-03-24 12:22:51'),
(349, 13, 'Logged In', '2025-03-24 12:22:57'),
(350, 1, 'Logged In', '2025-03-25 06:53:04'),
(351, 1, 'Logged Out', '2025-03-25 06:58:19'),
(352, 1, 'Logged In', '2025-03-25 06:58:25'),
(353, 1, 'Changed Password', '2025-03-25 07:16:29'),
(354, 1, 'Logged Out', '2025-03-25 07:16:33'),
(355, 1, 'Logged In', '2025-03-25 07:16:40'),
(356, 1, 'Updated user No. 19', '2025-03-25 07:49:39'),
(357, 1, 'Updated user No. 19', '2025-03-25 07:49:44'),
(358, 1, 'Updated user No. 19', '2025-03-25 07:58:13'),
(359, 1, 'Updated user No. 19', '2025-03-25 07:58:27'),
(360, 1, 'Updated user No. 19', '2025-03-25 07:58:38'),
(361, 1, 'Updated user No. 19', '2025-03-25 07:58:48'),
(362, 1, 'Updated user No. 19', '2025-03-25 07:58:54'),
(363, 1, 'Updated user No. 19', '2025-03-25 08:00:04'),
(364, 1, 'Updated user No. 19', '2025-03-25 08:00:08'),
(365, 1, 'Logged Out', '2025-03-25 08:37:20'),
(366, 16, 'Logged In', '2025-03-25 08:37:25'),
(367, 16, 'Logged Out', '2025-03-25 08:37:30'),
(368, 16, 'Logged In', '2025-03-25 08:37:38'),
(369, 16, 'Logged Out', '2025-03-25 08:37:49'),
(370, 16, 'Logged In', '2025-03-25 08:38:01'),
(371, 16, 'Logged Out', '2025-03-25 08:38:21'),
(372, 16, 'Logged In', '2025-03-25 08:38:25'),
(373, 16, 'Logged Out', '2025-03-25 08:38:33'),
(374, 16, 'Logged In', '2025-03-25 08:38:38'),
(375, 16, 'Logged Out', '2025-03-25 08:38:46'),
(376, 16, 'Logged In', '2025-03-25 08:38:50'),
(377, 16, 'Logged Out', '2025-03-25 08:38:54'),
(378, 1, 'Logged In', '2025-03-25 08:39:02'),
(379, 1, 'Logged Out', '2025-03-25 09:02:19'),
(380, 15, 'Logged In', '2025-03-25 09:02:22'),
(381, 1, 'Logged In', '2025-03-26 02:14:00'),
(382, 1, 'Logged Out', '2025-03-26 02:14:48'),
(383, 1, 'Logged In', '2025-03-26 02:14:53'),
(384, 1, 'Logged Out', '2025-03-26 02:15:03'),
(385, 17, 'Logged In', '2025-03-26 02:15:07'),
(386, 17, 'Logged Out', '2025-03-26 02:15:54'),
(387, 17, 'Logged In', '2025-03-26 02:15:59'),
(388, 17, 'Logged Out', '2025-03-26 02:23:41'),
(389, 1, 'Logged In', '2025-03-26 02:27:22'),
(390, 1, 'Logged Out', '2025-03-26 02:28:00'),
(391, 1, 'Logged In', '2025-03-26 02:29:18'),
(392, 1, 'Logged Out', '2025-03-26 02:32:41'),
(393, 1, 'Logged In', '2025-03-26 02:39:07'),
(394, 1, 'Logged Out', '2025-03-26 02:39:29'),
(395, 1, 'Logged In', '2025-03-26 02:39:54'),
(396, 1, 'Logged Out', '2025-03-26 03:02:58'),
(397, 15, 'Logged In', '2025-03-26 03:03:03'),
(398, 15, 'Logged Out', '2025-03-26 03:22:48'),
(399, 17, 'Logged In', '2025-03-26 03:22:54'),
(400, 17, 'Logged Out', '2025-03-26 03:23:07'),
(401, 19, 'Logged In', '2025-03-26 03:23:11'),
(402, 19, 'Logged Out', '2025-03-26 03:32:06'),
(403, 15, 'Logged In', '2025-03-26 03:32:10'),
(404, 15, 'Logged Out', '2025-03-26 03:50:57'),
(405, 1, 'Logged In', '2025-03-26 03:51:00'),
(406, 1, 'Logged Out', '2025-03-26 04:35:44'),
(407, 14, 'Logged In', '2025-03-26 04:35:50'),
(408, 14, 'Logged Out', '2025-03-26 04:41:47'),
(409, 1, 'Logged In', '2025-03-26 04:41:51'),
(410, 1, 'Logged Out', '2025-03-26 04:43:09'),
(411, 17, 'Logged In', '2025-03-26 04:43:12'),
(412, 17, 'Logged Out', '2025-03-26 04:43:34'),
(413, 17, 'Logged In', '2025-03-26 04:43:38'),
(414, 17, 'Logged Out', '2025-03-26 04:45:06'),
(415, 17, 'Logged In', '2025-03-26 04:46:52'),
(416, 17, 'Logged Out', '2025-03-26 04:47:11'),
(417, 17, 'Logged In', '2025-03-26 04:47:14'),
(418, 1, 'Logged In', '2025-03-26 04:55:18'),
(419, 1, 'Logged Out', '2025-03-26 04:55:24'),
(420, 1, 'Logged In', '2025-03-26 04:55:31'),
(421, 1, 'Logged Out', '2025-03-26 04:55:37'),
(422, 1, 'Logged In', '2025-03-26 04:57:18'),
(423, 13, 'Logged In', '2025-03-26 06:04:01'),
(424, 13, 'Logged Out', '2025-03-26 06:07:03'),
(425, 1, 'Logged In', '2025-03-26 06:08:45'),
(426, 1, 'Updated user No. 17', '2025-03-26 06:09:10'),
(427, 1, 'Updated user No. 17', '2025-03-26 06:09:36'),
(428, 1, 'Updated user No. 17', '2025-03-26 06:09:45'),
(429, 1, 'Added user No. 20', '2025-03-26 06:12:35'),
(430, 1, 'Updated user No. 20', '2025-03-26 06:13:05'),
(431, 1, 'Added user No. 21', '2025-03-26 06:14:27'),
(432, 1, 'Updated user No. 21', '2025-03-26 06:15:21'),
(433, 1, 'Added user No. 22', '2025-03-26 06:16:11'),
(434, 1, 'Added user No. 23', '2025-03-26 06:16:51'),
(435, 1, 'Updated user No. 23', '2025-03-26 06:17:04'),
(436, 1, 'Logged In', '2025-03-26 06:22:37'),
(437, 1, 'Logged In', '2025-03-26 06:33:18'),
(438, 1, 'Updated user No. 23', '2025-03-26 06:33:51'),
(439, 1, 'Updated user No. 21', '2025-03-26 06:34:02'),
(440, 1, 'Updated user No. 20', '2025-03-26 06:35:31'),
(441, 1, 'Logged Out', '2025-03-26 06:35:36'),
(442, 15, 'Logged In', '2025-03-26 06:35:40'),
(443, 15, 'Logged Out', '2025-03-26 08:28:48'),
(444, 1, 'Logged In', '2025-03-26 08:28:51'),
(445, 1, 'Logged In', '2025-03-26 08:29:33'),
(446, 15, 'Logged In', '2025-03-26 08:33:41'),
(447, 15, 'Logged Out', '2025-03-26 08:33:47'),
(448, 1, 'Logged In', '2025-03-26 08:33:50'),
(449, 1, 'Logged In', '2025-03-26 08:34:02'),
(450, 1, 'Logged Out', '2025-03-26 08:35:35'),
(451, 1, 'Logged In', '2025-03-26 08:36:39'),
(452, 1, 'Logged In', '2025-03-26 08:40:58'),
(453, 1, 'Logged Out', '2025-03-26 08:43:03'),
(454, 1, 'Logged In', '2025-03-26 08:44:17'),
(455, 1, 'Logged Out', '2025-03-26 08:45:29'),
(456, 1, 'Logged In', '2025-03-26 08:45:32'),
(457, 1, 'Logged Out', '2025-03-26 08:46:03'),
(458, 1, 'Logged In', '2025-03-26 08:46:06'),
(459, 1, 'Logged Out', '2025-03-26 08:47:01'),
(460, 1, 'Logged In', '2025-03-26 08:48:28'),
(461, 1, 'Logged Out', '2025-03-26 08:48:33'),
(462, 1, 'Logged In', '2025-03-26 08:50:17'),
(463, 1, 'Logged Out', '2025-03-26 08:51:22'),
(464, 1, 'Logged In', '2025-03-26 08:51:42'),
(465, 1, 'Logged Out', '2025-03-26 09:14:56'),
(466, 17, 'Logged In', '2025-03-26 09:15:00'),
(467, 17, 'Logged Out', '2025-03-26 09:19:32'),
(468, 17, 'Logged In', '2025-03-26 09:20:07'),
(469, 17, 'Logged Out', '2025-03-26 09:32:56'),
(470, 15, 'Logged In', '2025-03-26 09:33:00'),
(471, 15, 'Logged Out', '2025-03-26 10:22:40'),
(472, 1, 'Logged In', '2025-03-26 10:22:44'),
(473, 1, 'Logged Out', '2025-03-26 10:23:44'),
(474, 1, 'Logged In', '2025-03-26 10:24:11'),
(475, 1, 'Logged In', '2025-03-26 10:28:45'),
(476, 1, 'Logged In', '2025-03-26 10:56:47'),
(477, 1, 'Added department No. 7', '2025-03-26 10:57:24'),
(478, 1, 'Added user No. 24', '2025-03-26 11:00:18'),
(479, 1, 'Logged Out', '2025-03-26 11:00:24'),
(480, 24, 'Logged In', '2025-03-26 11:00:32'),
(481, 24, 'Update Profile', '2025-03-26 11:01:55'),
(482, 15, 'Logged In', '2025-03-26 11:02:31'),
(483, 15, 'Updated logsheet entry No. 0012', '2025-03-26 11:07:49'),
(484, 15, 'Inserted a new withdrawal entry', '2025-03-26 11:07:49'),
(485, 15, 'Logged In', '2025-03-26 11:35:42'),
(486, 15, 'Logged Out', '2025-03-26 11:44:10'),
(487, 19, 'Logged In', '2025-03-26 11:44:15'),
(488, 15, 'Logged In', '2025-03-26 13:00:14'),
(489, 24, 'Logged In', '2025-03-26 13:44:54'),
(490, 15, 'Logged In', '2025-03-26 13:50:16'),
(491, 15, 'Updated logsheet entry No. 43', '2025-03-26 13:51:35'),
(492, 15, 'Inserted a new withdrawal entry', '2025-03-26 13:51:35'),
(493, 17, 'Logged In', '2025-03-26 13:54:29'),
(494, 17, 'Logged In', '2025-03-26 13:55:11'),
(495, 17, 'Logged In', '2025-03-26 13:57:25'),
(496, 15, 'Logged In', '2025-03-26 14:09:13'),
(497, 15, 'Logged Out', '2025-03-26 14:11:15'),
(498, 16, 'Logged In', '2025-03-26 14:11:19'),
(499, 16, 'Logged Out', '2025-03-26 14:11:52'),
(500, 13, 'Logged In', '2025-03-26 14:12:05'),
(501, 13, 'Logged Out', '2025-03-26 14:13:24'),
(502, 15, 'Logged In', '2025-03-26 14:13:27'),
(503, 1, 'Logged In', '2025-03-27 03:26:15'),
(504, 15, 'Logged In', '2025-03-27 03:27:31'),
(505, 1, 'Added department No. 8', '2025-03-27 03:28:30'),
(506, 1, 'Added department No. 9', '2025-03-27 03:28:43'),
(507, 1, 'Updated department No. 6', '2025-03-27 03:28:50'),
(508, 1, 'Updated department No. 6', '2025-03-27 03:28:57'),
(509, 15, 'Logged Out', '2025-03-27 03:31:10'),
(510, 1, 'Logged In', '2025-03-27 03:31:14'),
(511, 1, 'Added department No. 10', '2025-03-27 03:31:31'),
(512, 1, 'Updated user No. 17', '2025-03-27 03:32:40'),
(513, 1, 'Updated user No. 17', '2025-03-27 03:32:52'),
(514, 1, 'Logged Out', '2025-03-27 03:33:54'),
(515, 15, 'Logged In', '2025-03-27 03:33:58'),
(516, 1, 'Added department No. 11', '2025-03-27 03:35:29'),
(517, 1, 'Added user No. 25', '2025-03-27 03:36:15'),
(518, 15, 'Updated logsheet entry No. 2025-27272', '2025-03-27 03:40:34'),
(519, 15, 'Inserted a new withdrawal entry', '2025-03-27 03:40:34'),
(520, 15, 'Logged In', '2025-03-27 03:42:12'),
(521, 15, 'Logged In', '2025-03-27 03:48:04'),
(522, 1, 'Logged Out', '2025-03-27 03:52:03'),
(523, 25, 'Logged In', '2025-03-27 03:52:11'),
(524, 15, 'Updated logsheet entry No. 202527272', '2025-03-27 03:52:49'),
(525, 15, 'Inserted a new withdrawal entry', '2025-03-27 03:52:49'),
(526, 15, 'Logged In', '2025-03-27 04:37:08'),
(527, 15, 'Logged In', '2025-03-27 04:42:36'),
(528, 15, 'Updated logsheet entry No. 202527272', '2025-03-27 04:42:53'),
(529, 15, 'Inserted a new withdrawal entry', '2025-03-27 04:42:53'),
(530, 25, 'Added request entry No. 1', '2025-03-27 04:45:39'),
(531, 15, 'Logged Out', '2025-03-27 04:46:38'),
(532, 16, 'Logged In', '2025-03-27 04:46:41'),
(533, 16, 'Logged Out', '2025-03-27 04:47:08'),
(534, 13, 'Logged In', '2025-03-27 04:47:16'),
(535, 13, 'Logged Out', '2025-03-27 04:47:38'),
(536, 14, 'Logged In', '2025-03-27 04:47:45'),
(537, 14, 'Added inspection entry No. 1', '2025-03-27 04:48:15'),
(538, 14, 'Logged Out', '2025-03-27 04:48:51'),
(539, 16, 'Logged In', '2025-03-27 04:48:55'),
(540, 16, 'Logged Out', '2025-03-27 04:49:14'),
(541, 13, 'Logged In', '2025-03-27 04:49:23'),
(542, 13, 'Logged Out', '2025-03-27 04:49:44'),
(543, 14, 'Logged In', '2025-03-27 04:49:56'),
(544, 14, 'Added job order entry No. 1', '2025-03-27 04:52:41'),
(545, 14, 'Logged Out', '2025-03-27 05:11:05'),
(546, 15, 'Logged In', '2025-03-27 05:11:08'),
(547, 15, 'Updated logsheet entry No. 2025-27272', '2025-03-27 05:13:37'),
(548, 15, 'Inserted a new withdrawal entry', '2025-03-27 05:13:37'),
(549, 15, 'Logged In', '2025-03-27 05:17:56'),
(550, 15, 'Logged In', '2025-03-27 05:18:38'),
(551, 15, 'Updated logsheet entry No. 2025-312', '2025-03-27 05:27:08'),
(552, 15, 'Inserted a new withdrawal entry', '2025-03-27 05:27:08'),
(553, 15, 'Updated logsheet entry No. 2025-123123', '2025-03-27 05:31:46'),
(554, 15, 'Inserted a new withdrawal entry', '2025-03-27 05:31:46'),
(555, 15, 'Updated logsheet entry No. 2025-123123', '2025-03-27 05:34:06'),
(556, 15, 'Inserted a new withdrawal entry', '2025-03-27 05:34:06'),
(557, 15, 'Logged Out', '2025-03-27 05:34:52'),
(558, 14, 'Logged In', '2025-03-27 05:34:56'),
(559, 14, 'Logged Out', '2025-03-27 05:42:51'),
(560, 15, 'Logged In', '2025-03-27 05:42:55'),
(561, 15, 'Updated logsheet entry No. 2025-1234', '2025-03-27 05:48:58'),
(562, 15, 'Inserted a new withdrawal entry', '2025-03-27 05:48:58'),
(563, 15, 'Logged In', '2025-03-27 05:49:17'),
(564, 15, 'Updated logsheet entry No. 2025-27272', '2025-03-27 06:00:47'),
(565, 15, 'Inserted a new withdrawal entry', '2025-03-27 06:00:47'),
(566, 15, 'Updated logsheet entry No. 2025-27272', '2025-03-27 06:11:31'),
(567, 15, 'Inserted a new withdrawal entry', '2025-03-27 06:11:31'),
(568, 15, 'Updated logsheet entry No. 2025-13', '2025-03-27 06:12:26'),
(569, 15, 'Inserted a new withdrawal entry', '2025-03-27 06:12:26'),
(570, 25, 'Added request entry No. 1', '2025-03-27 06:18:15'),
(571, 15, 'Logged Out', '2025-03-27 06:19:20'),
(572, 16, 'Logged In', '2025-03-27 06:19:24'),
(573, 16, 'Logged In', '2025-03-27 06:21:13'),
(574, 16, 'Logged Out', '2025-03-27 06:21:26'),
(575, 13, 'Logged In', '2025-03-27 06:21:30'),
(576, 13, 'Logged Out', '2025-03-27 06:21:53'),
(577, 14, 'Logged In', '2025-03-27 06:22:03'),
(578, 14, 'Added inspection entry No. 1', '2025-03-27 06:22:49'),
(579, 14, 'Logged Out', '2025-03-27 06:22:56'),
(580, 25, 'Logged In', '2025-03-27 06:23:02'),
(581, 25, 'Logged Out', '2025-03-27 06:23:33'),
(582, 16, 'Logged In', '2025-03-27 06:23:40'),
(583, 16, 'Logged Out', '2025-03-27 06:24:03'),
(584, 13, 'Logged In', '2025-03-27 06:24:09'),
(585, 13, 'Logged Out', '2025-03-27 06:24:28'),
(586, 14, 'Logged In', '2025-03-27 06:24:39'),
(587, 1, 'Logged In', '2025-03-27 06:26:14'),
(588, 1, 'Added technician No. 1', '2025-03-27 06:26:52'),
(589, 14, 'Logged In', '2025-03-27 06:27:11'),
(590, 14, 'Added job order entry No. 1', '2025-03-27 06:29:20'),
(591, 14, 'Logged Out', '2025-03-27 06:29:45'),
(592, 16, 'Logged In', '2025-03-27 06:29:55'),
(593, 14, 'Logged In', '2025-03-27 06:32:17'),
(594, 14, 'Logged Out', '2025-03-27 06:34:46'),
(595, 15, 'Logged In', '2025-03-27 06:36:35'),
(596, 15, 'Logged Out', '2025-03-27 06:37:01'),
(597, 25, 'Logged In', '2025-03-27 06:37:10'),
(598, 15, 'Logged In', '2025-03-27 14:05:14'),
(599, 15, 'Logged In', '2025-03-28 03:13:38'),
(600, 15, 'Logged In', '2025-03-28 06:56:21'),
(601, 15, 'Logged In', '2025-03-28 07:11:58'),
(602, 15, 'Updated logsheet entry No. 2025-27272', '2025-03-28 07:18:12'),
(603, 15, 'Inserted a new withdrawal entry', '2025-03-28 07:18:12'),
(604, 15, 'Updated logsheet entry No. 2025-2671', '2025-03-28 07:19:37'),
(605, 15, 'Inserted a new withdrawal entry', '2025-03-28 07:19:37'),
(606, 15, 'Updated logsheet entry No. 2025-267145', '2025-03-28 07:35:51'),
(607, 15, 'Inserted a new withdrawal entry', '2025-03-28 07:35:51'),
(608, 25, 'Logged In', '2025-03-28 07:36:55'),
(609, 25, 'Logged Out', '2025-03-28 07:39:42'),
(610, 17, 'Logged In', '2025-03-28 07:39:45'),
(611, 17, 'Logged Out', '2025-03-28 07:39:53'),
(612, 19, 'Logged In', '2025-03-28 07:39:59'),
(613, 15, 'Logged Out', '2025-03-28 07:42:10'),
(614, 14, 'Logged In', '2025-03-28 07:42:14'),
(615, 14, 'Logged Out', '2025-03-28 07:43:05'),
(616, 17, 'Logged In', '2025-03-28 07:43:08'),
(617, 17, 'Logged Out', '2025-03-28 07:43:53'),
(618, 15, 'Logged In', '2025-03-28 07:43:58'),
(619, 15, 'Logged Out', '2025-03-28 07:44:18'),
(620, 16, 'Logged In', '2025-03-28 07:44:31'),
(621, 16, 'Logged Out', '2025-03-28 07:44:52'),
(622, 13, 'Logged In', '2025-03-28 07:44:55'),
(623, 13, 'Logged Out', '2025-03-28 07:45:16'),
(624, 15, 'Logged In', '2025-03-28 07:45:23'),
(625, 15, 'Logged In', '2025-03-28 09:01:26'),
(626, 15, 'Logged Out', '2025-03-28 09:03:53'),
(627, 1, 'Logged In', '2025-03-28 09:04:05'),
(628, 1, 'Added user No. 26', '2025-03-28 09:05:11'),
(629, 1, 'Logged Out', '2025-03-28 09:05:19'),
(630, 26, 'Logged In', '2025-03-28 09:05:35'),
(631, 15, 'Logged In', '2025-03-28 09:05:48'),
(632, 15, 'Updated logsheet entry No. 2025-1311', '2025-03-28 09:08:17'),
(633, 15, 'Inserted a new withdrawal entry', '2025-03-28 09:08:17'),
(634, 15, 'Logged Out', '2025-03-28 09:11:45'),
(635, 14, 'Logged In', '2025-03-28 09:11:55'),
(636, 19, 'Logged In', '2025-03-28 09:12:51'),
(637, 26, 'Logged In', '2025-03-28 09:13:52'),
(638, 26, 'Logged Out', '2025-03-28 09:14:10'),
(639, 15, 'Logged In', '2025-03-28 09:14:14'),
(640, 15, 'Logged Out', '2025-03-28 09:14:30'),
(641, 16, 'Logged In', '2025-03-28 09:14:33'),
(642, 16, 'Logged In', '2025-03-28 09:15:05'),
(643, 16, 'Logged Out', '2025-03-28 09:15:18'),
(644, 13, 'Logged In', '2025-03-28 09:15:21'),
(645, 13, 'Logged In', '2025-03-28 09:15:41'),
(646, 13, 'Logged Out', '2025-03-28 09:16:07'),
(647, 15, 'Logged In', '2025-03-28 09:16:12'),
(648, 14, 'Logged In', '2025-03-28 16:06:47'),
(649, 15, 'Logged In', '2025-03-29 02:21:25'),
(650, 25, 'Logged In', '2025-03-29 02:24:15'),
(651, 25, 'Logged Out', '2025-03-29 02:26:32'),
(652, 16, 'Logged In', '2025-03-29 02:26:36'),
(653, 16, 'Logged Out', '2025-03-29 02:27:02'),
(654, 13, 'Logged In', '2025-03-29 02:27:08'),
(655, 15, 'Logged Out', '2025-03-29 02:27:30'),
(656, 25, 'Logged In', '2025-03-29 02:27:38'),
(657, 13, 'Logged Out', '2025-03-29 02:28:59'),
(658, 14, 'Logged In', '2025-03-29 02:29:06'),
(659, 25, 'Logged Out', '2025-03-29 02:29:45'),
(660, 26, 'Logged In', '2025-03-29 02:29:52'),
(661, 14, 'Logged Out', '2025-03-29 02:32:30'),
(662, 15, 'Logged In', '2025-03-29 02:32:34'),
(663, 15, 'Logged Out', '2025-03-29 02:32:53'),
(664, 16, 'Logged In', '2025-03-29 02:33:01'),
(665, 16, 'Logged Out', '2025-03-29 02:33:22'),
(666, 13, 'Logged In', '2025-03-29 02:33:29'),
(667, 13, 'Logged Out', '2025-03-29 02:33:57'),
(668, 25, 'Logged In', '2025-03-29 02:34:04'),
(669, 26, 'Logged Out', '2025-03-29 02:34:36'),
(670, 15, 'Logged In', '2025-03-29 02:34:39'),
(671, 15, 'Added history record No. 1', '2025-03-29 02:35:47'),
(672, 15, 'Logged In', '2025-03-29 02:49:27'),
(673, 15, 'Logged In', '2025-03-29 02:54:55'),
(674, 25, 'Logged Out', '2025-03-29 02:57:26'),
(675, 17, 'Logged In', '2025-03-29 02:57:33'),
(676, 15, 'Logged In', '2025-03-29 03:03:06'),
(677, 17, 'Logged Out', '2025-03-29 03:04:42'),
(678, 25, 'Logged In', '2025-03-29 03:04:47'),
(679, 25, 'Logged Out', '2025-03-29 03:05:01'),
(680, 19, 'Logged In', '2025-03-29 03:05:06'),
(681, 15, 'Logged In', '2025-03-29 03:27:45'),
(682, 15, 'Logged In', '2025-03-29 03:49:47'),
(683, 15, 'Logged In', '2025-03-29 03:53:56'),
(684, 15, 'Added history record No. 2', '2025-03-29 03:54:41'),
(685, 15, 'Logged In', '2025-03-29 03:56:05'),
(686, 25, 'Logged In', '2025-03-29 03:57:00'),
(687, 19, 'Logged Out', '2025-03-29 03:59:26'),
(688, 25, 'Logged In', '2025-03-29 03:59:30'),
(689, 25, 'Logged Out', '2025-03-29 04:00:30'),
(690, 15, 'Logged In', '2025-03-29 04:00:33'),
(691, 15, 'Logged In', '2025-03-29 04:04:04'),
(692, 17, 'Logged In', '2025-03-29 04:05:33'),
(693, 15, 'Logged In', '2025-03-29 04:06:59'),
(694, 15, 'Logged In', '2025-03-29 09:03:20'),
(695, 15, 'Logged In', '2025-03-29 09:24:59'),
(696, 15, 'Logged In', '2025-03-29 09:30:02'),
(697, 15, 'Logged Out', '2025-03-29 09:32:11'),
(698, 1, 'Logged In', '2025-03-29 09:32:14'),
(699, 1, 'Logged Out', '2025-03-29 09:34:54'),
(700, 15, 'Logged In', '2025-03-29 09:35:04'),
(701, 15, 'Logged In', '2025-03-29 09:36:53'),
(702, 15, 'Logged In', '2025-03-30 06:24:05'),
(703, 15, 'Updated logsheet entry No. 2025-27272', '2025-03-30 06:26:35'),
(704, 15, 'Inserted a new withdrawal entry', '2025-03-30 06:26:35'),
(705, 25, 'Logged In', '2025-03-30 06:27:00'),
(706, 15, 'Added history record No. 1', '2025-03-30 06:28:57'),
(707, 15, 'Added history record No. 2', '2025-03-30 06:34:45'),
(708, 15, 'Logged In', '2025-03-30 06:40:56'),
(709, 15, 'Updated logsheet entry No. 2025-235', '2025-03-30 06:42:25'),
(710, 15, 'Inserted a new withdrawal entry', '2025-03-30 06:42:25'),
(711, 25, 'Logged Out', '2025-03-30 06:44:52'),
(712, 19, 'Logged In', '2025-03-30 06:44:57'),
(713, 15, 'Logged Out', '2025-03-30 06:47:45'),
(714, 1, 'Logged In', '2025-03-30 06:47:50'),
(715, 19, 'Changed Password', '2025-03-30 06:48:56'),
(716, 19, 'Logged Out', '2025-03-30 06:49:00'),
(717, 19, 'Logged In', '2025-03-30 06:49:07'),
(718, 19, 'Logged Out', '2025-03-30 06:49:22'),
(719, 19, 'Logged In', '2025-03-30 06:49:34'),
(720, 1, 'Added user No. 27', '2025-03-30 06:50:27'),
(721, 1, 'Logged Out', '2025-03-30 06:50:32'),
(722, 15, 'Logged In', '2025-03-30 06:50:35'),
(723, 19, 'Logged Out', '2025-03-30 06:51:36'),
(724, 27, 'Logged In', '2025-03-30 06:51:41'),
(725, 15, 'Updated logsheet entry No. 2025-123', '2025-03-30 06:52:02'),
(726, 15, 'Inserted a new withdrawal entry', '2025-03-30 06:52:02'),
(727, 15, 'Added history record No. 3', '2025-03-30 06:53:43'),
(728, 15, 'Logged In', '2025-03-30 06:55:07'),
(729, 15, 'Logged In', '2025-03-30 06:58:05'),
(730, 15, 'Logged In', '2025-03-30 13:44:30'),
(731, 15, 'Logged In', '2025-03-31 07:46:49'),
(732, 15, 'Logged Out', '2025-03-31 07:48:01'),
(733, 1, 'Logged In', '2025-03-31 07:48:07'),
(734, 1, 'Updated user No. 17', '2025-03-31 07:48:18'),
(735, 17, 'Logged In', '2025-03-31 07:48:36'),
(736, 17, 'Logged Out', '2025-03-31 07:49:11'),
(737, 15, 'Logged In', '2025-03-31 07:49:17'),
(738, 15, 'Updated logsheet entry No. 2025-03-31', '2025-03-31 07:52:42'),
(739, 15, 'Inserted a new withdrawal entry', '2025-03-31 07:52:42'),
(740, 15, 'Logged Out', '2025-03-31 07:52:51'),
(741, 17, 'Logged In', '2025-03-31 07:52:59'),
(742, 17, 'Logged Out', '2025-03-31 07:55:50'),
(743, 17, 'Logged In', '2025-03-31 07:56:04'),
(744, 17, 'Added request entry No. 1', '2025-03-31 07:58:24'),
(745, 15, 'Logged In', '2025-03-31 07:59:24'),
(746, 15, 'Logged Out', '2025-03-31 08:00:31'),
(747, 16, 'Logged In', '2025-03-31 08:00:36'),
(748, 16, 'Logged Out', '2025-03-31 08:02:39'),
(749, 15, 'Logged In', '2025-03-31 08:02:50'),
(750, 15, 'Logged Out', '2025-03-31 08:03:21'),
(751, 15, 'Logged In', '2025-03-31 08:03:27'),
(752, 15, 'Updated logsheet entry No. 2025-034-01', '2025-03-31 08:07:40'),
(753, 15, 'Inserted a new withdrawal entry', '2025-03-31 08:07:40'),
(754, 17, 'Added request entry No. 2', '2025-03-31 08:10:18'),
(755, 15, 'Logged Out', '2025-03-31 08:10:59'),
(756, 16, 'Logged In', '2025-03-31 08:11:04'),
(757, 16, 'Logged Out', '2025-03-31 08:11:18'),
(758, 13, 'Logged In', '2025-03-31 08:11:23'),
(759, 13, 'Logged Out', '2025-03-31 08:13:11'),
(760, 14, 'Logged In', '2025-03-31 08:13:17'),
(761, 14, 'Logged Out', '2025-03-31 08:15:11'),
(762, 15, 'Logged In', '2025-03-31 08:15:16'),
(763, 15, 'Logged Out', '2025-03-31 08:15:51'),
(764, 14, 'Logged In', '2025-03-31 08:15:57'),
(765, 14, 'Added inspection entry No. 1', '2025-03-31 08:16:19'),
(766, 14, 'Logged Out', '2025-03-31 08:17:06'),
(767, 16, 'Logged In', '2025-03-31 08:17:11'),
(768, 16, 'Logged Out', '2025-03-31 08:17:53'),
(769, 13, 'Logged In', '2025-03-31 08:17:59'),
(770, 13, 'Logged Out', '2025-03-31 08:18:27'),
(771, 14, 'Logged In', '2025-03-31 08:18:33'),
(772, 14, 'Added job order entry No. 1', '2025-03-31 08:20:14'),
(773, 14, 'Logged Out', '2025-03-31 08:22:44'),
(774, 15, 'Logged In', '2025-03-31 08:22:53'),
(775, 15, 'Logged Out', '2025-03-31 08:58:04'),
(776, 16, 'Logged In', '2025-03-31 08:58:13'),
(777, 16, 'Logged Out', '2025-03-31 09:01:39'),
(778, 15, 'Logged In', '2025-03-31 09:01:45'),
(779, 15, 'Logged Out', '2025-03-31 09:02:06'),
(780, 16, 'Logged In', '2025-03-31 09:02:11'),
(781, 17, 'Logged Out', '2025-03-31 09:03:03'),
(782, 14, 'Logged In', '2025-03-31 09:03:10'),
(783, 15, 'Logged In', '2025-03-31 09:03:30'),
(784, 15, 'Logged Out', '2025-03-31 09:04:02'),
(785, 14, 'Logged In', '2025-03-31 09:04:10'),
(786, 15, 'Logged In', '2025-03-31 09:04:57'),
(787, 15, 'Logged Out', '2025-03-31 09:05:37'),
(788, 14, 'Logged In', '2025-03-31 09:05:41'),
(789, 14, 'Logged Out', '2025-03-31 09:05:50'),
(790, 16, 'Logged In', '2025-03-31 09:05:54'),
(791, 15, 'Logged In', '2025-03-31 09:07:01'),
(792, 13, 'Logged In', '2025-03-31 09:08:32'),
(793, 1, 'Logged In', '2025-03-31 09:13:25'),
(794, 1, 'Added user No. 28', '2025-03-31 09:14:34'),
(795, 1, 'Logged Out', '2025-03-31 09:14:45'),
(796, 15, 'Logged In', '2025-03-31 09:14:48'),
(797, 13, 'Logged Out', '2025-03-31 09:14:55'),
(798, 28, 'Logged In', '2025-03-31 09:15:03'),
(799, 15, 'Updated logsheet entry No. 2025-3114', '2025-03-31 09:17:01'),
(800, 15, 'Inserted a new withdrawal entry', '2025-03-31 09:17:01'),
(801, 28, 'Logged Out', '2025-03-31 09:19:40'),
(802, 14, 'Logged In', '2025-03-31 09:19:45'),
(803, 14, 'Logged Out', '2025-03-31 09:20:18'),
(804, 19, 'Logged In', '2025-03-31 09:20:23'),
(805, 15, 'Logged Out', '2025-03-31 09:21:44'),
(806, 16, 'Logged In', '2025-03-31 09:21:52'),
(807, 16, 'Logged Out', '2025-03-31 09:22:02'),
(808, 13, 'Logged In', '2025-03-31 09:22:05'),
(809, 13, 'Logged Out', '2025-03-31 09:22:25'),
(810, 28, 'Logged In', '2025-03-31 09:22:34'),
(811, 15, 'Logged In', '2025-03-31 09:45:33'),
(812, 15, 'Logged Out', '2025-03-31 09:45:40'),
(813, 15, 'Logged In', '2025-03-31 11:11:14'),
(814, 17, 'Logged In', '2025-03-31 11:12:37'),
(815, 17, 'Logged Out', '2025-03-31 11:12:52'),
(816, 14, 'Logged In', '2025-03-31 11:12:57'),
(817, 15, 'Logged Out', '2025-03-31 11:16:24'),
(818, 17, 'Logged In', '2025-03-31 11:16:28'),
(819, 17, 'Logged In', '2025-03-31 13:17:07'),
(820, 15, 'Logged In', '2025-03-31 13:18:25'),
(821, 17, 'Logged Out', '2025-03-31 13:18:44'),
(822, 16, 'Logged In', '2025-03-31 13:18:48'),
(823, 16, 'Logged Out', '2025-03-31 13:19:28'),
(824, 19, 'Logged In', '2025-03-31 13:19:32'),
(825, 19, 'Logged Out', '2025-03-31 13:20:14'),
(826, 28, 'Logged In', '2025-03-31 13:20:17'),
(827, 15, 'Logged Out', '2025-03-31 13:21:25'),
(828, 16, 'Logged In', '2025-03-31 13:21:31'),
(829, 16, 'Logged Out', '2025-03-31 13:21:49'),
(830, 13, 'Logged In', '2025-03-31 13:21:54'),
(831, 13, 'Logged Out', '2025-03-31 13:22:23'),
(832, 17, 'Logged In', '2025-03-31 13:22:31'),
(833, 28, 'Logged Out', '2025-03-31 13:23:01'),
(834, 15, 'Logged In', '2025-03-31 13:23:07'),
(835, 15, 'Logged In', '2025-04-01 04:03:37'),
(836, 15, 'Logged In', '2025-04-01 04:05:12'),
(837, 15, 'Logged In', '2025-04-01 04:13:32'),
(838, 1, 'Logged In', '2025-04-01 04:13:51'),
(839, 1, 'Added user No. 29', '2025-04-01 04:14:30'),
(840, 1, 'Logged Out', '2025-04-01 04:14:38'),
(841, 29, 'Logged In', '2025-04-01 04:14:42'),
(842, 15, 'Updated logsheet entry No. 2025-1291', '2025-04-01 04:17:38'),
(843, 15, 'Inserted a new withdrawal entry', '2025-04-01 04:17:38'),
(844, 15, 'Logged Out', '2025-04-01 04:21:57'),
(845, 14, 'Logged In', '2025-04-01 04:22:05'),
(846, 14, 'Logged Out', '2025-04-01 04:22:54'),
(847, 17, 'Logged In', '2025-04-01 04:23:01'),
(848, 17, 'Logged Out', '2025-04-01 04:23:33'),
(849, 15, 'Logged In', '2025-04-01 04:23:36'),
(850, 15, 'Logged Out', '2025-04-01 04:24:02'),
(851, 16, 'Logged In', '2025-04-01 04:24:06'),
(852, 16, 'Logged Out', '2025-04-01 04:24:17'),
(853, 13, 'Logged In', '2025-04-01 04:24:20'),
(854, 13, 'Logged Out', '2025-04-01 04:25:32'),
(855, 15, 'Logged In', '2025-04-01 04:25:36'),
(856, 15, 'Logged Out', '2025-04-01 04:37:35'),
(857, 15, 'Logged In', '2025-04-01 04:40:22'),
(858, 14, 'Logged In', '2025-04-01 08:58:55'),
(859, 15, 'Logged In', '2025-04-03 01:18:35'),
(860, 14, 'Logged In', '2025-04-03 01:19:41'),
(861, 14, 'Logged Out', '2025-04-03 01:19:56'),
(862, 1, 'Logged In', '2025-04-03 01:20:03'),
(863, 1, 'Added user No. 30', '2025-04-03 01:21:19'),
(864, 1, 'Logged Out', '2025-04-03 01:21:23'),
(865, 30, 'Logged In', '2025-04-03 01:21:27'),
(866, 15, 'Updated logsheet entry No. 2025-12812', '2025-04-03 01:22:53'),
(867, 15, 'Inserted a new withdrawal entry', '2025-04-03 01:22:53'),
(868, 30, 'Logged Out', '2025-04-03 01:24:19'),
(869, 1, 'Logged In', '2025-04-03 01:25:31'),
(870, 1, 'Added user No. 31', '2025-04-03 01:40:23'),
(871, 1, 'Logged Out', '2025-04-03 01:41:12'),
(872, 15, 'Updated logsheet entry No. 2025-301', '2025-04-03 01:43:18'),
(873, 15, 'Inserted a new withdrawal entry', '2025-04-03 01:43:18'),
(874, 31, 'Logged In', '2025-04-03 01:43:33'),
(875, 15, 'Logged In', '2025-04-03 01:58:11'),
(876, 15, 'Updated logsheet entry No. 2025-0012', '2025-04-03 02:27:03'),
(877, 15, 'Inserted a new withdrawal entry', '2025-04-03 02:27:03'),
(878, 26, 'Logged In', '2025-04-03 02:27:21'),
(879, 15, 'Logged Out', '2025-04-03 03:19:17'),
(880, 1, 'Logged In', '2025-04-03 03:19:20'),
(881, 1, 'Logged Out', '2025-04-03 03:39:07'),
(882, 15, 'Logged In', '2025-04-03 03:39:10'),
(883, 15, 'Logged Out', '2025-04-03 03:39:27'),
(884, 15, 'Logged In', '2025-04-03 03:39:58'),
(885, 15, 'Logged Out', '2025-04-03 03:40:06'),
(886, 26, 'Logged In', '2025-04-03 03:40:12'),
(887, 26, 'Logged Out', '2025-04-03 03:40:52'),
(888, 15, 'Logged In', '2025-04-03 03:40:56'),
(889, 15, 'Logged Out', '2025-04-03 04:08:56'),
(890, 17, 'Logged In', '2025-04-03 04:09:00'),
(891, 15, 'Logged In', '2025-04-03 07:05:49'),
(892, 15, 'Logged In', '2025-04-03 09:45:17'),
(893, 15, 'Logged Out', '2025-04-03 09:54:09'),
(894, 17, 'Logged In', '2025-04-03 09:54:23'),
(895, 17, 'Added feedback entry No. 1', '2025-04-03 09:55:13'),
(896, 17, 'Logged Out', '2025-04-03 09:55:17'),
(897, 14, 'Logged In', '2025-04-03 09:55:22'),
(898, 17, 'Logged In', '2025-04-04 02:11:17'),
(899, 15, 'Logged In', '2025-04-07 00:58:09'),
(900, 15, 'Logged Out', '2025-04-07 01:52:16'),
(901, 1, 'Logged In', '2025-04-07 01:52:23'),
(902, 1, 'Added user No. 32', '2025-04-07 01:55:35'),
(903, 1, 'Logged Out', '2025-04-07 01:55:40'),
(904, 32, 'Logged In', '2025-04-07 01:55:44'),
(905, 15, 'Logged In', '2025-04-07 01:56:12'),
(906, 15, 'Updated logsheet entry No. 2025-103', '2025-04-07 02:01:24'),
(907, 15, 'Inserted a new withdrawal entry', '2025-04-07 02:01:24'),
(908, 32, 'Added request entry No. 3', '2025-04-07 02:05:16'),
(909, 15, 'Logged Out', '2025-04-07 02:06:21'),
(910, 16, 'Logged In', '2025-04-07 02:06:26'),
(911, 16, 'Logged Out', '2025-04-07 02:06:41'),
(912, 13, 'Logged In', '2025-04-07 02:06:47'),
(913, 13, 'Logged Out', '2025-04-07 02:07:03'),
(914, 14, 'Logged In', '2025-04-07 02:07:09'),
(915, 14, 'Added inspection entry No. 2', '2025-04-07 02:07:40'),
(916, 14, 'Logged Out', '2025-04-07 02:08:00'),
(917, 16, 'Logged In', '2025-04-07 02:08:05'),
(918, 16, 'Logged Out', '2025-04-07 02:11:08'),
(919, 13, 'Logged In', '2025-04-07 02:11:11'),
(920, 13, 'Logged Out', '2025-04-07 02:11:48'),
(921, 14, 'Logged In', '2025-04-07 02:12:02'),
(922, 14, 'Added job order entry No. 2', '2025-04-07 02:12:52'),
(923, 14, 'Logged Out', '2025-04-07 02:13:14'),
(924, 13, 'Logged In', '2025-04-07 02:13:20'),
(925, 13, 'Logged Out', '2025-04-07 02:13:37'),
(926, 16, 'Logged In', '2025-04-07 02:13:42'),
(927, 16, 'Logged Out', '2025-04-07 02:14:00'),
(928, 32, 'Logged In', '2025-04-07 02:14:08'),
(929, 32, 'Logged Out', '2025-04-07 02:15:15'),
(930, 17, 'Logged In', '2025-04-07 02:15:19'),
(931, 32, 'Logged Out', '2025-04-07 02:16:26'),
(932, 14, 'Logged In', '2025-04-07 02:16:30'),
(933, 17, 'Logged Out', '2025-04-07 02:23:31'),
(934, 1, 'Logged In', '2025-04-07 02:23:40'),
(935, 1, 'Logged Out', '2025-04-07 02:23:59'),
(936, 29, 'Logged In', '2025-04-07 02:24:03'),
(937, 29, 'Logged Out', '2025-04-07 02:24:38'),
(938, 19, 'Logged In', '2025-04-07 02:24:49'),
(939, 1, 'Logged In', '2025-04-07 12:02:21'),
(940, 1, 'Logged Out', '2025-04-07 12:02:38'),
(941, 1, 'Logged In', '2025-04-07 12:08:56'),
(942, 1, 'Logged Out', '2025-04-07 12:19:57'),
(943, 1, 'Logged Out', '2025-04-07 12:20:15'),
(944, 1, 'Logged In', '2025-04-07 13:03:00'),
(945, 1, 'Logged Out', '2025-04-07 13:05:41'),
(946, 15, 'Logged In', '2025-04-07 13:05:46'),
(947, 14, 'Logged In', '2025-04-07 13:09:58'),
(948, 32, 'Logged In', '2025-04-07 16:58:17'),
(949, 15, 'Logged Out', '2025-04-07 17:00:49'),
(950, 16, 'Logged In', '2025-04-07 17:00:52'),
(951, 16, 'Logged Out', '2025-04-07 17:02:54'),
(952, 13, 'Logged In', '2025-04-07 17:02:57'),
(953, 13, 'Logged Out', '2025-04-07 17:16:11'),
(954, 15, 'Logged In', '2025-04-07 17:16:15'),
(955, 32, 'Logged In', '2025-04-07 17:16:33'),
(956, 32, 'Logged Out', '2025-04-07 17:18:58'),
(957, 16, 'Logged In', '2025-04-07 17:19:02'),
(958, 16, 'Logged Out', '2025-04-07 17:19:15'),
(959, 13, 'Logged In', '2025-04-07 17:19:18'),
(960, 13, 'Logged Out', '2025-04-07 17:19:42'),
(961, 32, 'Logged In', '2025-04-07 17:19:46');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `logsheet`
--

INSERT INTO `logsheet` (`id`, `user_id`, `item_category`, `pr_no`, `date_purchase`, `quantity_received`, `unit`, `description`, `date_released`, `ws_no`, `quantity_released`, `is_signed`, `date_entry`) VALUES
(1, 25, 'Office Supplies', '2025-27272', '2025-03-27', 2, 'Unit', 'Printer', '2025-03-30', '12345', 2, 'Yes', '2025-03-30 06:25:56'),
(2, 25, 'Office Supplies', '2025-27272', '2025-03-27', 2, 'Unit', 'Laptop', '2025-03-30', '12345', 2, 'Yes', '2025-03-30 06:25:56'),
(3, 19, 'Construction Materials', '2025-235', '2025-03-30', 2, 'Unit', 'Welding Machine', '2025-03-30', '213', 2, 'Yes', '2025-03-30 06:41:36'),
(4, 19, 'Construction Materials', '2025-235', '2025-03-30', 2, 'Pcs', 'Table', '2025-03-30', '213', 2, 'Yes', '2025-03-30 06:41:36'),
(5, 27, 'Office Supplies', '2025-123', '2025-03-30', 2, 'unit', 'laptop', '2025-03-30', '21', 2, 'Yes', '2025-03-30 06:51:21'),
(6, 27, 'Office Supplies', '2025-123', '2025-03-30', 2, 'unit', 'lecturn', '2025-03-30', '21', 2, 'Yes', '2025-03-30 06:51:21'),
(7, 17, 'Construction Materials', '2025-03-31', '2025-03-31', 50, 'pieces', 'Kabilya', '2025-03-31', '5', 50, 'Yes', '2025-03-31 07:51:00'),
(8, 17, 'Construction Materials', '2025-034-01', '2025-03-31', 20, 'pieces', 'Chair', '2025-03-31', '2', 20, 'Yes', '2025-03-31 08:06:32'),
(9, 28, 'Office Supplies', '2025-3114', '2025-03-31', 2, 'Ream', 'Bondpaper', '2025-03-31', '234', 2, 'Yes', '2025-03-31 09:16:16'),
(10, 28, 'Office Supplies', '2025-3114', '2025-03-31', 2, 'Unit', 'Printer', '2025-03-31', '234', 2, 'Yes', '2025-03-31 09:16:16'),
(11, 29, 'Office Supplies', '2025-1291', '2025-04-01', 2, 'Unit', 'Laptop', '2025-04-01', '231', 2, 'Yes', '2025-04-01 04:16:07'),
(12, 29, 'Office Supplies', '2025-1291', '2025-04-01', 2, 'Unit', 'Printer', '2025-04-01', '231', 2, 'Yes', '2025-04-01 04:16:07'),
(13, 30, 'Office Supplies', '2025-12812', '2025-04-03', 2, 'Unit', 'Laptop', '2025-04-03', '321', 2, 'Yes', '2025-04-03 01:22:13'),
(14, 30, 'Office Supplies', '2025-12812', '2025-04-03', 2, 'Unit', 'Printer', '2025-04-03', '321', 2, 'Yes', '2025-04-03 01:22:13'),
(15, 31, 'Construction Materials', '2025-301', '2025-04-03', 2, 'Unit', 'Welding Machine', '2025-04-03', '023', 2, 'Yes', '2025-04-03 01:42:18'),
(16, 31, 'Construction Materials', '2025-301', '2025-04-03', 2, 'Pcs', 'Martilyo', '2025-04-03', '023', 2, 'Yes', '2025-04-03 01:42:18'),
(17, 26, 'Office Supplies', '2025-0012', '2025-04-03', 2, 'Unit', 'Laptop', '2025-04-03', '33', 2, 'Yes', '2025-04-03 02:26:23'),
(18, 26, 'Office Supplies', '2025-0012', '2025-04-03', 2, 'Pcs', 'Table', '2025-04-03', '33', 2, 'Yes', '2025-04-03 02:26:23'),
(19, 32, 'Spareparts', '2025-103', '2025-04-07', 2, 'Pcs', 'Motherboard', '2025-04-07', '241', 2, 'Yes', '2025-04-07 01:57:19'),
(20, 32, 'Spareparts', '2025-103', '2025-04-07', 2, 'Kilo', 'Lansang', '2025-04-07', '241', 2, 'Yes', '2025-04-07 01:57:19');

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
  `disapproved_by_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `status` enum('FOR PROPERTY CUSTODIAN','FOR PMO','FOR VP','APPROVED','DISAPPROVED','CANCELLED') DEFAULT 'FOR PROPERTY CUSTODIAN',
  `file` text NOT NULL,
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `property_disposal`
--

INSERT INTO `property_disposal` (`id`, `date`, `department`, `item_category`, `prepared_by_id`, `prepared_by`, `checked_by_id`, `checked_by`, `checked_by_date`, `noted_by_id`, `noted_by`, `noted_by_date`, `approved_by_id`, `approved_by`, `approved_by_date`, `disapproved_by_id`, `comment`, `status`, `file`, `date_entry`) VALUES
(1, '2025-04-08', 'CCIS', 'Spareparts', 32, 'Joshua Estay', 15, 'pc ako', '2025-04-08', 16, 'Pmo Ako', '2025-04-08', 13, 'Vp Admin', '2025-04-08', NULL, '', 'APPROVED', '1744046220_incident_report.pdf', '2025-04-07 17:17:13');

-- --------------------------------------------------------

--
-- Table structure for table `property_disposal_items`
--

CREATE TABLE `property_disposal_items` (
  `id` int(11) NOT NULL,
  `disposal_id` int(11) DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `property_code` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `part_code` varchar(255) DEFAULT NULL,
  `conditioned` varchar(255) DEFAULT 'No',
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `property_disposal_items`
--

INSERT INTO `property_disposal_items` (`id`, `disposal_id`, `inventory_id`, `quantity`, `unit`, `description`, `property_code`, `brand`, `part_code`, `conditioned`, `remarks`) VALUES
(1, 1, 22, 1, 'Kilo', 'Lansang', '1412', 'N/A', '14512', 'Dispose', 'Dispose');

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
  `area` varchar(255) DEFAULT NULL,
  `in_charge_id` int(11) DEFAULT NULL,
  `in_charge` varchar(255) DEFAULT NULL,
  `in_charge_date` date DEFAULT NULL,
  `conformed_by_id` int(11) DEFAULT NULL,
  `conformed_by` varchar(255) DEFAULT NULL,
  `conformed_by_date` date DEFAULT NULL,
  `status` enum('FOR USER','FOR PROPERTY CUSTODIAN','APPROVED') DEFAULT 'FOR USER',
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `property_inventory`
--

INSERT INTO `property_inventory` (`id`, `date_inventory`, `date_last`, `property_code`, `department_id`, `item_category`, `sy`, `area`, `in_charge_id`, `in_charge`, `in_charge_date`, `conformed_by_id`, `conformed_by`, `conformed_by_date`, `status`, `date_entry`) VALUES
(1, '2025-03-30', '2025-03-01', '2025-2135', 11, 'Office Supplies', '2025', 'Main Building', 25, 'Jonathan Liguid', '2025-03-30', 15, 'pc ako', '2025-03-30', 'APPROVED', '2025-03-30 06:38:54'),
(2, '2025-03-30', '2025-03-01', '2025-2135', 6, 'Construction Materials', '2025', '3rd Floor', 19, 'Lorevic SAylon', '2025-03-30', 15, 'pc ako', '2025-03-30', 'APPROVED', '2025-03-30 06:46:17'),
(3, '2025-03-02', '2025-03-01', '2025-123', 6, 'Office Supplies', '2025', '2nd Floor', 27, 'Ian joyd Franco', '2025-03-30', 15, 'pc ako', '2025-03-30', 'APPROVED', '2025-03-30 06:56:03'),
(4, '2025-01-06', '2025-04-30', '098', 5, 'Construction Materials', '2025', 'Offices', 17, 'Employee Employee', '2025-03-31', 15, 'pc ako', '2025-03-31', 'APPROVED', '2025-03-31 08:31:12');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `property_inventory_items`
--

INSERT INTO `property_inventory_items` (`id`, `property_inventory_id`, `user_id`, `item_category`, `quantity`, `unit`, `description`, `brand`, `part_code`, `model_number`, `serial_number`, `status`, `remarks`, `date_entry`) VALUES
(1, 1, 25, 'Office Supplies', 2, 'Unit', 'Printer', 'Epson', '2351', '1235', '1247', 'F', 'Functional', '2025-03-30 06:38:54'),
(2, 1, 25, 'Office Supplies', 2, 'Unit', 'Laptop', 'Acer', '314', '125', '217', 'G', 'Good', '2025-03-30 06:38:54'),
(3, 2, 19, 'Construction Materials', 2, 'Unit', 'Welding Machine', 'N/A', '213', '24', '27', 'F', 'Functional', '2025-03-30 06:46:17'),
(4, 2, 19, 'Construction Materials', 2, 'Pcs', 'Table', 'N/A', '15', '128', '2', 'G', 'Good', '2025-03-30 06:46:17'),
(5, 3, 27, 'Office Supplies', 2, 'unit', 'laptop', 'HP', '1238', '21', '35', 'F', 'Functional', '2025-03-30 06:56:03'),
(6, 3, 27, 'Office Supplies', 2, 'unit', 'lecturn', 'N/A', '127', '23', '12', 'G', 'Good', '2025-03-30 06:56:03'),
(7, 4, 17, 'Construction Materials', 20, 'pieces', 'Chair', 'kahoy', 'na', 'na', 'na', 'F', 'Functional', '2025-03-31 08:31:12');

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
  `status` enum('FOR PROPERTY CUSTODIAN','FOR PMO','FOR VP','APPROVED','CANCELLED') DEFAULT 'FOR PROPERTY CUSTODIAN',
  `is_inspected` enum('Yes','No') DEFAULT 'No',
  `is_feedback` enum('Yes','No') NOT NULL DEFAULT 'No',
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `request_form`
--

INSERT INTO `request_form` (`id`, `request_no`, `request_type`, `request_type_others`, `department`, `date_requested`, `location`, `date_action`, `details`, `requested_by_id`, `requested_by`, `endorsed_by_id`, `endorsed_by`, `endorsed_by_date`, `recommend_by_id`, `recommend_by`, `recommend_by_date`, `approved_by_id`, `approved_by`, `approved_by_date`, `status`, `is_inspected`, `is_feedback`, `date_entry`) VALUES
(2, '01', 'Others', 'chairs', 5, '2025-03-31', '3rd Floor', '2025-03-31', 'Need Repairing', 17, 'Employee Employee', 15, 'pc ako', '2025-03-31', 16, 'Pmo Ako', '2025-03-31', 13, 'Vp Admin', '2025-03-31', 'APPROVED', 'Yes', 'Yes', '2025-03-31 08:10:18'),
(3, '21', 'Others', 'Repair motherboard', 5, '2025-04-07', '3rd Floor', '2025-04-08', 'Repair Motherboard', 32, 'Joshua Estay', 15, 'pc ako', '2025-04-07', 16, 'Pmo Ako', '2025-04-07', 13, 'Vp Admin', '2025-04-07', 'APPROVED', 'Yes', 'No', '2025-04-07 02:05:16');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`id`, `fname`, `lname`, `mname`, `signature`, `status`, `date_entry`) VALUES
(1, 'Randy', 'Manto', '', '1743056760_signature.png', 'Active', '2025-03-27 06:26:52');

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
  `disapproved_by_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `status` enum('FOR GENERAL SERVICES','FOR USER','FOR PROPERTY CUSTODIAN','FOR PMO','FOR VP','APPROVED','DISAPPROVED','CANCELLED') DEFAULT 'FOR GENERAL SERVICES',
  `date_entry` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `transfer_property`
--

INSERT INTO `transfer_property` (`id`, `date`, `move_from`, `move_to_id`, `item_category`, `is_transfer`, `is_turnover`, `others`, `prepared_by_id`, `prepared_by`, `checked_by_id`, `checked_by`, `checked_by_date`, `accepted_by_id`, `accepted_by`, `accepted_by_date`, `endorsed_by_id`, `endorsed_by`, `endorsed_by_date`, `recommending_by_id`, `recommending_by`, `recommending_by_date`, `approved_by_id`, `approved_by`, `approved_by_date`, `disapproved_by_id`, `comment`, `status`, `date_entry`) VALUES
(1, '2025-04-08', 'CCIS', 6, 'Spareparts', 'Yes', 'No', 'Transfer', 32, 'Joshua Estay', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CANCELLED', '2025-04-07 17:21:06');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_property_items`
--

CREATE TABLE `transfer_property_items` (
  `id` int(11) NOT NULL,
  `transfer_id` int(11) DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `part_code` varchar(255) DEFAULT NULL,
  `model_number` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'No',
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `transfer_property_items`
--

INSERT INTO `transfer_property_items` (`id`, `transfer_id`, `inventory_id`, `quantity`, `unit`, `description`, `brand`, `part_code`, `model_number`, `serial_number`, `status`, `remarks`) VALUES
(1, 1, 21, 1, 'Pcs', 'Motherboard', 'N/A', '1414', '12', '412', 'Functional', NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `mname`, `department_id`, `username`, `password`, `role`, `avatar`, `signature`, `status`, `date_entry`) VALUES
(1, 'Kevinker', 'Bernaldez', '', 1, 'admin', '$2y$10$aS/bFgNh7xFIZKyk5qMM8.ZUy8yorVt/EVmTQn4GlGFGOdBwXrRd6', 'Administrator', '1742125920_profile.jpg', '1741234560_signature.png', 'Active', '2025-02-03 13:30:41'),
(13, 'Vp', 'Admin', '', 1, 'vp', '$2y$10$fb15JVl4jVGmFdysLCxbnuZb2UpG68wXaloxk13rw1nqhj7nxQZ0S', 'VP', 'uploads/profile/user.png', '1741570080_signature.png', 'Active', '2025-03-06 04:07:29'),
(14, 'General', 'Services', '', 1, 'genserv', '$2y$10$Dk7bslURYVz3ei3H5SOx8uW5mS.6sfituqbwd5BjscCKjvWRmP5DO', 'General Services', 'uploads/profile/user.png', '1741579200_signature.png', 'Active', '2025-03-06 04:08:48'),
(15, 'pc', 'ako', '', 1, 'pc', '$2y$10$6TQdx6ijYEH1nzBRruy/vucE.5P82EoQL/CmKdCK2L1Cs4s5aIhLy', 'Property Custodian', 'uploads/profile/user.png', '1741234560_signature.png', 'Active', '2025-03-06 04:10:43'),
(16, 'Pmo', 'Ako', '', 1, 'pmo', '$2y$10$YmMAdYRSQKdWKWULA4FhS.etIDpP3X0B.8uHWLGzqfjW79sYNiKhC', 'PMO Head', 'uploads/profile/user.png', '1741601040_signature.png', 'Active', '2025-03-10 04:06:08'),
(17, 'Employee', 'Employee', '', 5, 'emp', '$2y$10$In2rq03jt2k0GQlx3DXCBO4oRsmKOZXYoc/rqbM5KhH0xvkvLKKoe', 'Employee', 'uploads/profile/user.png', '1742125920_signature.png', 'Active', '2025-03-16 11:52:24'),
(19, 'Lorevic', 'SAylon', '', 6, 'lorevic', '$2y$10$O3LLnihoweoBaoEn6WfZhuvvnKa3bBCj3a27O1L160bHZo4YKGgOW', 'Employee', 'uploads/profile/user.png', '1742390520_signature.png', 'Active', '2025-03-19 13:22:47'),
(24, 'Angelica', 'Aldaya', 'Nalam', 7, 'Angelica', '$2y$10$qfAm.Zc4RVL052FvwlPvceyHJN.RKbvkhHR92qx6zQdDBAhcVAfzS', 'Employee', '1742986860_profile.jpg', '1742986800_signature.png', 'Active', '2025-03-26 11:00:18'),
(25, 'Jonathan', 'Liguid', 'A', 11, 'Jonathan', '$2y$10$2e3ZBeEo.LlGeqQpFCUZ2ujA15YBeW695yCfCyiXIyw9yDdyJC7.i', 'Employee', 'uploads/profile/user.png', '1743046560_signature.png', 'Active', '2025-03-27 03:36:15'),
(26, 'Princess', 'Varona', 'Lusica', 10, 'princess', '$2y$10$fWYC7tMnWtxUfodVgj1tU..U26/XNuov7moaucnYJOSbXaVlzzA.2', 'Employee', 'uploads/profile/user.png', '1743152700_signature.png', 'Active', '2025-03-28 09:05:11'),
(27, 'Ian joyd', 'Franco', '', 6, 'ianjoyd', '$2y$10$4IFBNWRaUKclY428re3SAOyiPZ6GH2u8VUNfUSnMwPevawESftOyi', 'Employee', 'uploads/profile/user.png', '1743317400_signature.png', 'Active', '2025-03-30 06:50:27'),
(28, 'Jessa Claire Bernadette', 'Cabusao', '', 10, 'jessa', '$2y$10$lXVSKTVQyPwUmS4Ui5d09OlXfRGey5lm8.M9NPGuKbZ74GmiZX4Kq', 'Employee', 'uploads/profile/user.png', '1743412440_signature.png', 'Active', '2025-03-31 09:14:34'),
(29, 'Ronnel', 'Falo', '', 6, 'ronnel', '$2y$10$keeeKzZBNHrEkrSHXyHjHeMUqBj2U8pvsts3cjkfwE8BZX93tB96.', 'Employee', 'uploads/profile/user.png', '1743480840_signature.png', 'Active', '2025-04-01 04:14:30'),
(30, 'Desiree', 'Abian', '', 10, 'desiree', '$2y$10$Hbo/mug2QoRf4cTyTE4ULe8NnZdvcE7FvGylaFktmReVxZYgWhrCa', 'Employee', 'uploads/profile/user.png', '1743643260_signature.png', 'Active', '2025-04-03 01:21:19'),
(31, 'Noel', 'Aguasito', '', 8, 'noel', '$2y$10$IDVtzmyIYC10R04s3FqgnuVToYzVzE2hAA2ENJVVibrI6lQTd1Fgu', 'Employee', 'uploads/profile/user.png', '1743644400_signature.png', 'Active', '2025-04-03 01:40:23'),
(32, 'Joshua', 'Estay', '', 5, 'joshua', '$2y$10$Z5.fyMkdq3HSf6HFKBkupumgPhBxKf137q.ACUDZf7/Pod8edY7RS', 'Employee', 'uploads/profile/user.png', '1743990900_signature.png', 'Active', '2025-04-07 01:55:35');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `withdrawal`
--

INSERT INTO `withdrawal` (`id`, `pr_no`, `item`, `delivered_to`, `date`, `cv`, `remarks`, `prepared_by_id`, `prepared_by`, `received_by_id`, `received_by`, `received_date`, `date_entry`) VALUES
(1, '2025-27272', 'Office Supplies', 'PMO', '2025-03-30', 1235, 'Released', 15, 'pc ako', 25, 'Jonathan Liguid', '2025-03-30', '2025-03-30 06:26:35'),
(2, '2025-235', 'Construction Materials', 'CCJE', '2025-03-30', 1236, 'Released', 15, 'pc ako', 19, 'Lorevic SAylon', '2025-03-30', '2025-03-30 06:42:25'),
(3, '2025-123', 'Office Supplies', 'CCJE', '2025-03-30', 124, 'Released', 15, 'pc ako', 27, 'Ian joyd Franco', '2025-03-30', '2025-03-30 06:52:02'),
(4, '2025-03-31', 'Construction  Materials', 'CCIS', '2025-03-31', 2, 'Released', 15, 'pc ako', 17, 'Employee Employee', '2025-03-31', '2025-03-31 07:52:42'),
(5, '2025-034-01', 'Construction Materials', 'CCIS', '2025-03-31', 31, 'Released', 15, 'pc ako', 17, 'Employee Employee', '2025-03-31', '2025-03-31 08:07:40'),
(6, '2025-3114', 'Office Supplies', 'CAS', '2025-03-31', 2451, 'Released', 15, 'pc ako', 28, 'Jessa Claire Bernadette Cabusao', '2025-03-31', '2025-03-31 09:17:01'),
(7, '2025-1291', 'Office Supplies', 'CCJE', '2025-04-01', 124, 'Released', 15, 'pc ako', 29, 'Ronnel Falo', '2025-04-01', '2025-04-01 04:17:38'),
(8, '2025-12812', 'Office Supplies', 'CAS', '2025-04-03', 123644, 'Released', 15, 'pc ako', 30, 'Desiree Abian', '2025-04-03', '2025-04-03 01:22:53'),
(9, '2025-301', 'Office Supplies', 'Senior High School', '2025-04-03', 512, 'Released', 15, 'pc ako', 31, 'Noel Aguasito', '2025-04-03', '2025-04-03 01:43:18'),
(10, '2025-0012', 'Office Supplies', 'CAS', '2025-04-03', 341, 'Released', 15, 'pc ako', 26, 'Princess Varona', '2025-04-03', '2025-04-03 02:27:03'),
(11, '2025-103', 'Spareparts', 'CCIS', '2025-04-07', 411, 'Released', 15, 'pc ako', 32, 'Joshua Estay', '2025-04-07', '2025-04-07 02:01:24');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `history_record`
--
ALTER TABLE `history_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inspection`
--
ALTER TABLE `inspection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `job_order`
--
ALTER TABLE `job_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=962;

--
-- AUTO_INCREMENT for table `logsheet`
--
ALTER TABLE `logsheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `property_disposal`
--
ALTER TABLE `property_disposal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_disposal_items`
--
ALTER TABLE `property_disposal_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_inventory`
--
ALTER TABLE `property_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `property_inventory_items`
--
ALTER TABLE `property_inventory_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `request_form`
--
ALTER TABLE `request_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transfer_property`
--
ALTER TABLE `transfer_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transfer_property_items`
--
ALTER TABLE `transfer_property_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `withdrawal`
--
ALTER TABLE `withdrawal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
