-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2024 at 02:42 AM
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
-- Database: `reviewer_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` varchar(50) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(150) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `firstname`, `lastname`, `email`, `password`, `image`) VALUES
('0101-5552-4177', 'Minji', 'Kim', 'admin_mail@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1.gif');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audit`
--

CREATE TABLE `tbl_audit` (
  `id` int(11) NOT NULL,
  `action` text NOT NULL,
  `table_name` varchar(200) NOT NULL,
  `log_message` text NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `teacher_id` varchar(50) DEFAULT NULL,
  `admin_id` varchar(50) DEFAULT NULL,
  `dean_id` varchar(50) DEFAULT NULL,
  `ph_id` varchar(50) DEFAULT NULL,
  `ip_addr` varchar(50) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_audit`
--

INSERT INTO `tbl_audit` (`id`, `action`, `table_name`, `log_message`, `student_id`, `teacher_id`, `admin_id`, `dean_id`, `ph_id`, `ip_addr`, `timestamp`) VALUES
(70, 'Update', 'tbl_teachers', 'Changed status from \'active\' to \'inactive\'', NULL, '02-2324-03958', '0101-5552-4177', NULL, NULL, '', '2024-01-12 08:07:01'),
(71, 'Update', 'tbl_teachers', 'Changed status from \'active\' to \'inactive\'', NULL, '02-2324-03957', '0101-5552-4177', NULL, NULL, '', '2024-01-12 08:07:03'),
(72, 'Update', 'tbl_teachers', 'Changed status from \'active\' to \'inactive\'', NULL, '02-2324-03956', '0101-5552-4177', NULL, NULL, '', '2024-01-12 08:07:05'),
(73, 'Update', 'tbl_teachers', 'Changed status from \'active\' to \'inactive\'', NULL, '02-2324-03955', '0101-5552-4177', NULL, NULL, '', '2024-01-12 08:07:06'),
(74, 'Update', 'tbl_teachers', 'Changed status from \'inactive\' to \'active\'', NULL, '02-2324-03955', '0101-5552-4177', NULL, NULL, '', '2024-01-12 08:07:13'),
(75, 'Update', 'tbl_teachers', 'Changed status from \'inactive\' to \'active\'', NULL, '02-2324-03956', '0101-5552-4177', NULL, NULL, '', '2024-01-12 08:07:14'),
(76, 'Update', 'tbl_teachers', 'Changed status from \'inactive\' to \'active\'', NULL, '02-2324-03957', '0101-5552-4177', NULL, NULL, '', '2024-01-12 08:07:16'),
(77, 'Update', 'tbl_teachers', 'Changed status from \'inactive\' to \'active\'', NULL, '02-2324-03958', '0101-5552-4177', NULL, NULL, '', '2024-01-12 08:07:18'),
(78, 'INSERT', 'tbl_program_head', 'Inserted new program head with faculty ID: 9918821', NULL, NULL, '0101-5552-4177', NULL, NULL, '', '2024-03-13 18:42:53'),
(79, 'INSERT', 'tbl_program_head', 'Admin with admin id: 0101-5552-4177 created new program head with faculty ID: 02-1819-09881', NULL, NULL, '0101-5552-4177', NULL, NULL, '', '2024-03-13 18:48:43'),
(87, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 7990-AK47', NULL, NULL, '0101-5552-4177', NULL, NULL, '', '2024-03-14 02:32:11'),
(88, 'Insert', 'tbl_deans', 'Admin with admin id: 0101-5552-4177 Created new dean with dean ID: 987-996-9999', NULL, NULL, '0101-5552-4177', NULL, NULL, '', '2024-03-14 07:37:32'),
(89, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2020-70139', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:02:06'),
(90, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2020-69648', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:10:06'),
(91, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2020-20976', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:12:13'),
(92, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2020-49807', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:22:44'),
(93, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2020-42057', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:24:17'),
(94, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2020-87051', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:25:33'),
(95, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2020-22191', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:27:41'),
(96, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2020-99157', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:30:42'),
(97, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2020-41159', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:35:19'),
(98, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2021-96573', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:42:21'),
(99, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2021-75365', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:43:50'),
(100, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2021-82325', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:45:11'),
(101, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2021-37571', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:46:56'),
(102, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2021-69506', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:48:11'),
(103, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2021-09414', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:50:18'),
(104, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2021-21863', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:51:42'),
(105, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2021-58332', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:56:17'),
(106, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2021-51308', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 08:59:16'),
(107, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2021-93846', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 09:00:36'),
(108, 'update', 'tbl_students', 'Admin with ID: 0101-5552-4177 updated student data for student with ID: 02-1920-03919. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 09:00:53'),
(109, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2022-69309', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 09:04:05'),
(110, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2022-49289', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 09:05:44'),
(111, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2022-13807', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 09:06:49'),
(112, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2022-42028', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 09:09:45'),
(113, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2022-71785', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 09:10:57'),
(114, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2022-56424', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 09:12:11'),
(115, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2022-35896', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 09:13:25'),
(116, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2022-42190', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 09:14:35'),
(117, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2022-15820', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 09:16:49'),
(118, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-2022-79317', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-14 09:18:10'),
(119, 'update', 'tbl_teachers', 'Admin with ID: 0101-5552-4177 updated teacher data for teacher with ID: undefined. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 10:07:30'),
(120, 'update', 'tbl_teachers', 'Admin with ID: 0101-5552-4177 updated teacher data for teacher with ID: undefined. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 10:08:28'),
(121, 'update', 'tbl_teachers', 'Admin with ID: 0101-5552-4177 updated teacher data for teacher with ID: undefined. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 10:10:11'),
(122, 'update', 'tbl_teachers', 'Admin with ID: 0101-5552-4177 updated teacher data for teacher with ID: undefined. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 10:10:45'),
(123, 'update', 'tbl_teachers', 'Admin with ID: 0101-5552-4177 updated teacher data for teacher with ID: undefined. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 10:11:11'),
(124, 'update', 'tbl_teachers', 'Admin with ID: 0101-5552-4177 updated teacher data for teacher with ID: undefined. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 10:11:53'),
(125, 'update', 'tbl_teachers', 'Admin with ID: 0101-5552-4177 updated teacher data for teacher with ID: undefined. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 10:12:06'),
(126, 'update', 'tbl_teachers', 'Admin with ID: 0101-5552-4177 updated teacher data for teacher with ID: undefined. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 10:12:58'),
(127, 'update', 'tbl_teachers', 'Admin with ID: 0101-5552-4177 updated teacher data for teacher with ID: 02-1920-03952. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 10:17:57'),
(128, 'update', 'tbl_teachers', 'Admin with ID: 0101-5552-4177 updated teacher data for teacher with ID: 02-1920-03952. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 10:18:27'),
(129, 'update', 'tbl_teachers', 'Admin with ID: 0101-5552-4177 updated teacher data for teacher with ID: 02-1920-03952. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 10:18:38'),
(130, 'update', 'tbl_teachers', 'Admin with ID: 0101-5552-4177 updated teacher data for teacher with ID: 02-1920-03952. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 11:23:08'),
(131, 'update', 'tbl_dean', 'Admin with ID: 0101-5552-4177 updated dean data for dean with ID: 1920-2324-12345. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 11:34:00'),
(132, 'update', 'tbl_dean', 'Admin with ID: 0101-5552-4177 updated dean data for dean with ID: 1920-2324-12345. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 11:34:14'),
(133, 'update', 'tbl_dean', 'Admin with ID: 0101-5552-4177 updated dean data for dean with ID: 1920-2324-12345. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 11:34:24'),
(134, 'update', 'tbl_dean', 'Admin with ID: 0101-5552-4177 updated dean data for dean with ID: 1920-2324-12345. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 11:36:39'),
(135, 'update', 'tbl_program_head', 'Admin with ID: 0101-5552-4177 updated program head data for program head with ID: 02-1819-09881. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-15 05:29:25'),
(136, 'update', 'tbl_program_head', 'Admin with ID: 0101-5552-4177 updated program head data for program head with ID: 02-1819-09881. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-15 05:29:35'),
(137, 'INSERT', 'tbl_program_head', 'Admin with admin id: 0101-5552-4177 created new program head with faculty ID: 9021-02991-09999', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 22:30:09'),
(138, 'INSERT', 'tbl_program_head', 'Admin with admin id: 0101-5552-4177 created new program head with faculty ID: 01-0999-01888', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 22:35:03'),
(139, 'INSERT', 'tbl_program_head', 'Admin with admin id: 0101-5552-4177 created new program head with faculty ID: 82528', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 22:36:03'),
(140, 'INSERT', 'tbl_program_head', 'Admin with admin id: 0101-5552-4177 created new program head with faculty ID: 1512', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 22:36:46'),
(141, 'INSERT', 'tbl_program_head', 'Admin with admin id: 0101-5552-4177 created new program head with faculty ID: 09000', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 22:39:46'),
(142, 'INSERT', 'tbl_program_head', 'Admin with admin id: 0101-5552-4177 created new program head with faculty ID: 02-0919-29999', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 22:43:41'),
(143, 'INSERT', 'tbl_program_head', 'Admin with admin id: 0101-5552-4177 created new program head with faculty ID: 03-1988-01999', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 22:45:28'),
(144, 'INSERT', 'tbl_program_head', 'Admin with admin id: 0101-5552-4177 created new program head with faculty ID: 1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 22:47:28'),
(145, 'INSERT', 'tbl_program_head', 'Admin with admin id: 0101-5552-4177 created new program head with faculty ID: 12', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 22:47:42'),
(146, 'INSERT', 'tbl_program_head', 'Admin with admin id: 0101-5552-4177 created new program head with faculty ID: 2', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-14 22:48:24'),
(147, 'update', 'tbl_program_head', 'Admin with ID: 0101-5552-4177 updated program head data for program head with ID: 01-0999-01888. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-15 07:03:04'),
(148, 'update', 'tbl_section', 'Admin with ID: 0101-5552-4177 updated section data for section with ID: . IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-15 07:31:02'),
(149, 'update', 'tbl_section', 'Admin with ID: 0101-5552-4177 updated section data for section with ID: . IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-15 07:32:05'),
(150, 'update', 'tbl_section', 'Admin with ID: 0101-5552-4177 updated section data for section with ID: . IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-15 07:33:09'),
(151, 'update', 'tbl_section', 'Admin with ID: 0101-5552-4177 updated section data for section with ID: . IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-15 07:33:48'),
(152, 'update', 'tbl_section', 'Admin with ID: 0101-5552-4177 updated section data for section with ID: CRIM-02A. IP Address: ::1', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-15 07:34:58'),
(153, 'insert', 'tbl_teachers', 'Admin with admin id: 0101-5552-4177 created new teacher with ID: 02-1718-01059', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:05:51'),
(154, 'update', 'tbl_teachers', 'Admin with ID: 0101-5552-4177 updated teacher data for teacher with ID: 02-1718-01059. IP Address: 127.0.0.1', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:08:47'),
(155, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-14723', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:12:23'),
(156, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-40017', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:13:35'),
(157, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-13506', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:15:29'),
(158, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-40229', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:16:55'),
(159, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-74875', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:18:03'),
(160, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-34838', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:18:58'),
(161, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-97733', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:19:51'),
(162, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-72010', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:21:50'),
(163, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-72836', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:22:57'),
(164, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-85861', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:24:32'),
(165, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-83892', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:43:55'),
(166, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-66550', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:45:31'),
(167, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-40599', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:46:31'),
(169, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-64644', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:48:00'),
(170, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-49513', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:49:06'),
(171, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-52003', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:50:26'),
(172, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-03866', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:52:00'),
(173, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-08175', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:55:37'),
(174, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-59341', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:56:39'),
(175, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-38449', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 13:58:40'),
(176, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-35142', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 14:01:32'),
(177, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-72874', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 14:10:52'),
(178, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-15794', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 14:21:02'),
(179, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-84513', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 14:22:19'),
(180, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1999-74126', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 14:25:21'),
(181, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 added students from an Excel file', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-15 15:35:05'),
(182, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 added students from an Excel file', NULL, NULL, '0101-5552-4177', NULL, NULL, '::1', '2024-03-15 15:37:48'),
(183, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 added students from an Excel file', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 15:43:25'),
(184, 'insert', 'tbl_students', 'Admin with admin id: 0101-5552-4177 created new student with ID: 02-1819-05847', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 20:20:41'),
(185, 'insert', 'tbl_teachers', 'Admin with admin id: 0101-5552-4177 created new teacher with ID: 02-9999-01059', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 20:21:59'),
(187, 'update', 'tbl_teachers', 'Admin with ID: 0101-5552-4177 updated teacher data for teacher with ID: 02-9999-01059. IP Address: 127.0.0.1', NULL, NULL, '0101-5552-4177', NULL, NULL, '127.0.0.1', '2024-03-15 20:30:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bookmark`
--

CREATE TABLE `tbl_bookmark` (
  `user_id` varchar(30) NOT NULL,
  `lesson_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_bookmark`
--

INSERT INTO `tbl_bookmark` (`user_id`, `lesson_id`) VALUES
('02-1920-03919', 50);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`category_id`, `category_name`) VALUES
(1, 'Criminal Law and Jurisprudence'),
(2, 'Law Enforcement Administration'),
(3, 'Forensics/Criminalistics'),
(4, 'Crime Detection and Investigation'),
(5, 'Sociology of Crimes and Ethics'),
(6, 'Correctional Administration');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_classlessons`
--

CREATE TABLE `tbl_classlessons` (
  `classlesson_id` int(11) NOT NULL,
  `section_name` varchar(50) NOT NULL,
  `lesson_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_classlessons`
--

INSERT INTO `tbl_classlessons` (`classlesson_id`, `section_name`, `lesson_id`) VALUES
(12, 'CRIM-02A', 32),
(13, 'CRIM-02B', 32),
(14, 'CRIM-02A', 33),
(15, 'CRIM-02B', 33),
(16, 'CRIM-02A', 34),
(17, 'CRIM-02B', 34),
(18, 'CRIM-02A', 35),
(19, 'CRIM-02B', 35),
(20, 'CRIM-02A', 36),
(21, 'CRIM-02B', 36),
(22, 'CRIM-02A', 37),
(23, 'CRIM-02B', 37),
(24, 'CRIM-02A', 38),
(25, 'CRIM-02B', 38),
(26, 'CRIM-LEA2', 38),
(27, 'CRIM-02A', 39),
(28, 'CRIM-02B', 39),
(29, 'CRIM-LEA2', 39),
(30, 'CRIM-02A', 40),
(31, 'CRIM-02B', 40),
(32, 'CRIM-LEA2', 40),
(33, 'CRIM-02A', 41),
(34, 'CRIM-02B', 41),
(35, 'CRIM-LEA2', 41),
(39, 'CRIM-02D', 43),
(40, 'CRIM-02A', 44),
(41, 'CRIM-02B', 44),
(42, 'CRIM-LEA2', 44),
(43, 'CRIM-02A', 45),
(44, 'CRIM-02B', 45),
(45, 'CRIM-LEA2', 45),
(46, 'CRIM-02A', 46),
(47, 'CRIM-02B', 46),
(48, 'CRIM-LEA2', 46),
(49, 'CRIM-02A', 47),
(50, 'CRIM-02B', 47),
(51, 'CRIM-LEA2', 47),
(52, 'CRIM-02A', 48),
(53, 'CRIM-02B', 48),
(54, 'CRIM-LEA2', 48),
(55, 'CRIM-02A', 49),
(56, 'CRIM-02B', 49),
(57, 'CRIM-LEA2', 49),
(58, 'CRIM-02A', 50),
(59, 'CRIM-02B', 50),
(60, 'CRIM-LEA2', 50),
(61, 'CRIM-02A', 51),
(62, 'CRIM-02B', 51),
(63, 'CRIM-LEA2', 51),
(64, 'CRIM-02B', 52),
(65, 'CRIM-LEA2', 52),
(66, 'CRIM-03', 53),
(67, 'CRIM-02B', 54),
(68, 'CRIM-LEA2', 54);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `comment_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `teacher_id` varchar(50) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dean`
--

CREATE TABLE `tbl_dean` (
  `dean_id` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isActive` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_dean`
--

INSERT INTO `tbl_dean` (`dean_id`, `firstname`, `middlename`, `lastname`, `gender`, `email`, `password`, `isActive`) VALUES
('1920-2324-12345', 'Paul', 'Smith', 'Sho', 'Male', 'pssm.sho.coc@phinmaed.com', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'inactive'),
('987-996-9999', 'Chelsy', '', 'Demi', 'Female', 'demichelsy@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_learningmaterials`
--

CREATE TABLE `tbl_learningmaterials` (
  `material_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `material_title` varchar(80) NOT NULL,
  `material_description` varchar(1000) NOT NULL,
  `file` varchar(250) NOT NULL,
  `thumbnail` varchar(250) NOT NULL,
  `date_created` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_learningmaterials`
--

INSERT INTO `tbl_learningmaterials` (`material_id`, `lesson_id`, `material_title`, `material_description`, `file`, `thumbnail`, `date_created`, `status`) VALUES
(22, 32, 'Introduction to Criminology', 'Criminology is the study of crime, society&#39;s response to it, and its prevention, including examination of the environmental, hereditary, or psychological causes of crime, modes of criminal investigation and conviction, and the efficacy of punishment or correction (see prison) as compared with forms of treatment or rehabilitation. Although it is generally considered a subdivision of sociology, criminology also draws on the findings of psychology, economics, and other disciplines that investigate humans and their environment.', 'ff3b0b3ff0a874830039565e3415ca11.pdf', '13032024161508.jpg', '2024-03-13', 'active'),
(23, 33, 'JUVENILE DELINQUENCY AND JUVENILE JUSTICE SYSTEM', 'Juvenile delinquency refers to the criminal acts performed by juveniles. Mostlegal systems prescribe specific procedures for dealing with juveniles, such as juveniledetention centers. Youth crime is an aspect of crime which receives great attention formnews media and politicians.', '13032024164045.pdf', '13032024164045.jpg', '2024-03-13', 'active'),
(24, 34, 'CRI 190 DISPUTE RESOLUTION AND CRISES/INCIDENT MANAGEMENT', 'This lesson deals with the study of the different mechanisms in dealing and resolving conflicts/disputes. It includes the art of intervention through mediation, and reconciliation between stakeholders and agencies tasked to carry out the endeavor.', '13032024165443.pdf', '13032024165443.jpg', '2024-03-13', 'active'),
(25, 35, 'THEORIES OF CRIME CAUSATION', 'These theories specify the types of situations most conducive to crime. Such theories usually argue that crime is most likely in those types of situations where the benefits of crime are seen as high and the costs as low, an argument very compatible with social learning theory.', '13032024170528.pdf', '13032024170528.jpg', '2024-03-14', 'active'),
(26, 36, 'HUMAN BEHAVIOR AND VICTIMOLOGY', 'The course covers the study on human behavior with emphasis on the concept of human development and abnormal behavior. It includes strategies and approaches in handling different kinds of abnormal behavior in relation to law enforcement and criminal proceedings.', '13032024171801.pdf', '13032024171801.png', '2024-03-14', 'active'),
(27, 37, 'CRIMINOLOGICAL RESEARCH 1 & 2', 'This lesson focuses on how writing research paper/thesis is done, and the applicablestatistical tools, understanding the different parts of the thesis, their interplay, and thegoverning rules in writing a technical paper, the development of a research problem, theinstrument, the data gathering methods, and the treatment of the data collected. ', '13032024172830.pdf', '13032024172830.jpg', '2024-03-14', 'active'),
(28, 38, 'Theories of Crime and Deviance', 'This module provides an in-depth examination of major theories of crime and deviance. Students will explore the historical development, key concepts, and empirical support for each theory. Emphasis will be placed on understanding how these theories explain criminal behavior and their implications for crime prevention and intervention.', '14032024033350.pdf', '14032024033350.png', '2024-03-14', 'active'),
(29, 39, 'Criminal Justice Systems', 'This module provides an overview of the criminal justice system, including its components and processes. Students will examine the role of law enforcement, the courts, and corrections in the administration of justice. The module will also explore contemporary issues and challenges facing the criminal justice system.', '14032024034552.pdf', '14032024034552.jpg', '2024-03-14', 'active'),
(30, 40, 'Victimology', 'This module provides a comprehensive examination of victimology, focusing on the study of victims and their experiences within the criminal justice system. Students will explore the impact of crime on victims, the role of victims in the criminal justice process, and the various forms of victimization.', '14032024040239.pdf', '14032024040239.png', '2024-03-14', 'active'),
(31, 41, 'Crime Prevention and Control Strategies', 'This module examines various strategies and approaches used to prevent and control crime. Students will explore the theoretical foundations of crime prevention, as well as practical applications and effectiveness of different crime prevention strategies.', '14032024041342.pdf', '14032024041342.jpg', '2024-03-14', 'active'),
(32, 43, 'Lessons in Criminology and Criminal Justice', '“Lessons in Criminology and Criminal Justice” tells the story of 25 facts\r\nabout crime and criminal justice that I know to be absolutely true based on\r\na quarter century of working in the field. The book will lay out each fact,\r\none at a time, and then present the research in support of that fact. Though\r\nthe book is scholarly in nature, it is written for the layperson and\r\nintroductory student. Using humor where appropriate, but also utilizing a\r\n“tell it like it is” approach, the book will captivate the reader and keep their\r\nattention throughout. The format of the book is unique, as no one has ever\r\nwritten such a book within the fields of Criminology and Criminal Justice.\r\nThe book will be always interesting, occasionally funny, timely, and\r\nengaging.', '14032024051749.pdf', '14032024051749.png', '2024-03-14', 'active'),
(33, 44, 'Criminal Law and Legal Theory', 'This module provides an overview of criminal law and legal theory, focusing on the definition, principles, and application of criminal law in the legal system. It explores the historical development of criminal law, its fundamental concepts, and the role of legal theory in shaping criminal justice.', '14032024172050.pdf', '14032024172050.webp', '2024-03-15', 'active'),
(34, 45, 'Criminal Procedure and Due Process', 'This module provides an overview of criminal procedure and due process, focusing on the legal framework that governs the investigation, prosecution, and adjudication of criminal cases. It explores the constitutional principles that protect the rights of individuals accused of crimes and ensure a fair and impartial criminal justice system.', '14032024172918.pdf', '14032024172918.webp', '2024-03-15', 'active'),
(35, 46, 'Comparative Criminal Justice Systems', 'This module provides a comparative analysis of criminal justice systems around the world, focusing on the differences and similarities in legal principles, procedures, and practices. It explores the cultural, historical, and political factors that influence the development of criminal justice systems and their effectiveness in addressing crime and ensuring justice.', '14032024173642.pdf', '14032024173642.png', '2024-03-15', 'active'),
(36, 47, 'Comparative Criminal Law', 'This module provides an overview of comparative criminal law, focusing on the study of different legal systems and their approaches to defining and punishing criminal behavior. It explores the similarities and differences between various legal traditions, highlighting the impact of cultural, historical, and political factors on criminal law.', '14032024174342.pdf', '14032024174342.png', '2024-03-15', 'active'),
(37, 48, 'Principles of Law Enforcement Administration', 'This module provides an overview of law enforcement administration, focusing on the principles and practices of managing law enforcement agencies. It covers topics such as leadership, organizational structure, personnel management, budgeting, and community relations in the context of law enforcement.', '14032024175650.pdf', '14032024175650.png', '2024-03-15', 'active'),
(38, 49, 'Ethics in Law Enforcement', 'This module provides an overview of ethics in law enforcement, focusing on the ethical challenges and dilemmas faced by law enforcement officers and agencies. It explores the importance of ethical behavior in maintaining public trust and confidence in law enforcement.', '14032024181127.pdf', '14032024181127.webp', '2024-03-15', 'active'),
(39, 50, 'Strategic Planning in Law Enforcement', 'This module provides an overview of strategic planning in law enforcement, focusing on the development and implementation of strategic plans to achieve organizational goals and objectives. It explores the key components of strategic planning and their application in law enforcement agencies.', '14032024181745.pdf', '14032024181745.jpg', '2024-03-15', 'active'),
(40, 51, 'Technology and Innovation in Law Enforcement', 'This module provides an overview of technology and innovation in law enforcement, focusing on the use of technological advancements to enhance policing practices and improve public safety. It explores the impact of technology on various aspects of law enforcement, including crime prevention, investigation, and community engagement.', '14032024183051.pdf', '14032024183051.jpg', '2024-03-15', 'active'),
(41, 52, 'Criminal Investigation and Forensic Science', 'This module provides an overview of crime detection and investigation, focusing on the principles and techniques used by law enforcement agencies to identify and solve crimes. It covers topics such as crime scene analysis, evidence collection and analysis, and investigative procedures.', '15032024024053.pdf', '15032024024053.png', '2024-03-15', 'active'),
(42, 53, 'material 1', 'material ni', '15032024140647.pdf', '15032024140647.png', '2024-03-15', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lessons`
--

CREATE TABLE `tbl_lessons` (
  `lesson_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `teacher_id` varchar(30) NOT NULL,
  `lesson_title` varchar(500) NOT NULL,
  `lesson_desc` varchar(1000) NOT NULL,
  `thumb` varchar(128) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_lessons`
--

INSERT INTO `tbl_lessons` (`lesson_id`, `category_id`, `teacher_id`, `lesson_title`, `lesson_desc`, `thumb`, `date`, `status`) VALUES
(32, 1, '02-1920-03954', 'INTRODUCTION TO CRIMINOLOGY', 'Criminology is the study of crime, society&#39;s response to it, and its prevention, including examination of the environmental, hereditary, or psychological causes of crime, modes of criminal investigation and conviction, and the efficacy of punishment or correction (see prison) as compared with forms of treatment or rehabilitation. Although it is generally considered a subdivision of sociology, criminology also draws on the findings of psychology, economics, and other disciplines that investigate humans and their environment.', '13032024161135.jpg', '2024-03-13', 'active'),
(33, 2, '02-1920-03954', 'JUVENILE DELINQUENCY AND JUVENILE JUSTICE SYSTEM', 'Juvenile delinquency refers to the criminal acts performed by juveniles. Mostlegal systems prescribe specific procedures for dealing with juveniles, such as juveniledetention centers. Youth crime is an aspect of crime which receives great attention formnews media and politicians.', '13032024163829.jpg', '2024-03-13', 'active'),
(34, 3, '02-1920-03954', 'CRI 190 DISPUTE RESOLUTION AND CRISES/INCIDENT MANAGEMENT', 'This lesson deals with the study of the different mechanisms in dealing and resolving conflicts/disputes. It includes the art of intervention through mediation, and reconciliation between stakeholders and agencies tasked to carry out the endeavor.', '13032024165141.jpg', '2024-03-13', 'active'),
(35, 4, '02-1920-03954', 'THEORIES OF CRIME CAUSATION', 'These theories specify the types of situations most conducive to crime. Such theories usually argue that crime is most likely in those types of situations where the benefits of crime are seen as high and the costs as low, an argument very compatible with social learning theory.', '13032024170125.jpg', '2024-03-14', 'active'),
(36, 5, '02-1920-03954', 'HUMAN BEHAVIOR AND VICTIMOLOGY', 'The course covers the study on human behavior with emphasis on the concept of human development and abnormal behavior. It includes strategies and approaches in handling different kinds of abnormal behavior in relation to law enforcement and criminal proceedings.', '13032024171350.png', '2024-03-14', 'active'),
(37, 6, '02-1920-03954', 'CRIMINOLOGICAL RESEARCH 1 & 2', 'This lesson focuses on how writing research paper/thesis is done, and the applicablestatistical tools, understanding the different parts of the thesis, their interplay, and thegoverning rules in writing a technical paper, the development of a research problem, theinstrument, the data gathering methods, and the treatment of the data collected. ', '13032024172532.jpg', '2024-03-14', 'active'),
(38, 1, '02-1920-03954', 'Theories of Crime and Deviance', 'This module provides an in-depth examination of major theories of crime and deviance. Students will explore the historical development, key concepts, and empirical support for each theory. Emphasis will be placed on understanding how these theories explain criminal behavior and their implications for crime prevention and intervention.', '14032024033049.png', '2024-03-14', 'active'),
(39, 2, '02-1920-03954', 'Criminal Justice Systems', 'This module provides an overview of the criminal justice system, including its components and processes. Students will examine the role of law enforcement, the courts, and corrections in the administration of justice. The module will also explore contemporary issues and challenges facing the criminal justice system.', '14032024034153.jpg', '2024-03-14', 'active'),
(40, 2, '02-1920-03954', 'Victimology', 'This module provides a comprehensive examination of victimology, focusing on the study of victims and their experiences within the criminal justice system. Students will explore the impact of crime on victims, the role of victims in the criminal justice process, and the various forms of victimization.', 'fc84cf69927a7250eef5977175b32ac031b70aedf49f2328.png', '2024-03-14', 'active'),
(41, 3, '02-1920-03954', 'Crime Prevention and Control Strategies', 'This module examines various strategies and approaches used to prevent and control crime. Students will explore the theoretical foundations of crime prevention, as well as practical applications and effectiveness of different crime prevention strategies.', '14032024040921.jpg', '2024-03-14', 'active'),
(43, 1, '02-2324-03955', 'Lessons in Criminology and Criminal Justice', '“Lessons in Criminology and Criminal Justice” tells the story of 25 facts\r\nabout crime and criminal justice that I know to be absolutely true based on\r\na quarter century of working in the field. The book will lay out each fact,\r\none at a time, and then present the research in support of that fact. Though\r\nthe book is scholarly in nature, it is written for the layperson and\r\nintroductory student. Using humor where appropriate, but also utilizing a\r\n“tell it like it is” approach, the book will captivate the reader and keep their\r\nattention throughout. The format of the book is unique, as no one has ever\r\nwritten such a book within the fields of Criminology and Criminal Justice.\r\nThe book will be always interesting, occasionally funny, timely, and\r\nengaging.', '14032024051431.webp', '2024-03-14', 'active'),
(44, 1, '02-1920-03954', 'Criminal Law and Legal Theory', 'This module provides an overview of criminal law and legal theory, focusing on the definition, principles, and application of criminal law in the legal system. It explores the historical development of criminal law, its fundamental concepts, and the role of legal theory in shaping criminal justice.', '49ea36c9aa40e937dca54cc398c28fb9b1b8644882670418.webp', '2024-03-15', 'deactive'),
(45, 1, '02-1920-03954', 'Criminal Procedure and Due Process', 'This module provides an overview of criminal procedure and due process, focusing on the legal framework that governs the investigation, prosecution, and adjudication of criminal cases. It explores the constitutional principles that protect the rights of individuals accused of crimes and ensure a fair and impartial criminal justice system.', '9ddedbc88d0e6afecb6fc51f416a221ea3719f87a64afcd7.webp', '2024-03-15', 'active'),
(46, 1, '02-1920-03954', 'Comparative Criminal Justice Systems', 'This module provides a comparative analysis of criminal justice systems around the world, focusing on the differences and similarities in legal principles, procedures, and practices. It explores the cultural, historical, and political factors that influence the development of criminal justice systems and their effectiveness in addressing crime and ensuring justice.', '9810092d9f9137c3d5667092dba7c09b401ba86752cbf2e2.jpg', '2024-03-15', 'deactive'),
(47, 1, '02-1920-03954', 'Comparative Criminal Law', 'This module provides an overview of comparative criminal law, focusing on the study of different legal systems and their approaches to defining and punishing criminal behavior. It explores the similarities and differences between various legal traditions, highlighting the impact of cultural, historical, and political factors on criminal law.', '609d8e0b655ed74c90982862c0593d4ab0c13f7d3a65afb5.png', '2024-03-15', 'active'),
(48, 2, '02-1920-03954', 'Principles of Law Enforcement Administration', 'This module provides an overview of law enforcement administration, focusing on the principles and practices of managing law enforcement agencies. It covers topics such as leadership, organizational structure, personnel management, budgeting, and community relations in the context of law enforcement.', '29bf9bd1a2d86d2501cb7d1036d0005d28c43c93664b0135.png', '2024-03-15', 'active'),
(49, 2, '02-1920-03954', 'Ethics in Law Enforcement', 'This module provides an overview of ethics in law enforcement, focusing on the ethical challenges and dilemmas faced by law enforcement officers and agencies. It explores the importance of ethical behavior in maintaining public trust and confidence in law enforcement.', '43875d132bca0eec11ab43d942cea6bbc51c87a24f4cdafc.webp', '2024-03-15', 'active'),
(50, 2, '02-1920-03954', 'Strategic Planning in Law Enforcement', 'This module provides an overview of strategic planning in law enforcement, focusing on the development and implementation of strategic plans to achieve organizational goals and objectives. It explores the key components of strategic planning and their application in law enforcement agencies', 'b2bdc47d7a954108fe9464fc121d762aad0ca9c4552c4cf4.jpg', '2024-03-15', 'active'),
(51, 2, '02-1920-03954', 'Technology and Innovation in Law Enforcement', 'This module provides an overview of technology and innovation in law enforcement, focusing on the use of technological advancements to enhance policing practices and improve public safety. It explores the impact of technology on various aspects of law enforcement, including crime prevention, investigation, and community engagement.', 'aa1b3b36a23ef01326db27061828c25c81cf54bca795c092.jpg', '2024-03-15', 'active'),
(52, 4, '02-1920-03954', 'Criminal Investigation and Forensic Science', 'This module provides an overview of crime detection and investigation, focusing on the principles and techniques used by law enforcement agencies to identify and solve crimes. It covers topics such as crime scene analysis, evidence collection and analysis, and investigative procedures.', '15032024023842.png', '2024-03-15', 'active'),
(53, 1, '02-9999-01059', 'topic1', 'mao nani', '15032024135812.png', '2024-03-15', 'active'),
(54, 1, '02-1920-03954', 'alert()', 'asdasdasdas', '21032024004453.png', '2024-03-21', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_program_head`
--

CREATE TABLE `tbl_program_head` (
  `faculty_id` varchar(50) NOT NULL,
  `faculty_firstname` varchar(50) NOT NULL,
  `faculty_lastname` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(200) NOT NULL,
  `isActive` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_program_head`
--

INSERT INTO `tbl_program_head` (`faculty_id`, `faculty_firstname`, `faculty_lastname`, `gender`, `email`, `password`, `isActive`) VALUES
('01-0999-01888', 'Jhana', 'Osanastre', 'female', 'jhanaosanastre@gmail.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 'active'),
('1', 'Chelsy', 'Demi', 'Female', 'slimedemi@vevomusic.net', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active'),
('12', 'Chelsy', 'Demi', 'Female', 'slimedemi@vevomusic.nets', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active'),
('2', 'Danielle', 'Marsh', 'Female', 'danni_@gmail.com', '2f61cb7837b83df50a7fffb58e802b87679cdaff', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quiz`
--

CREATE TABLE `tbl_quiz` (
  `quiz_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `quiz_title` text NOT NULL,
  `quiz_description` text NOT NULL,
  `quiz_type` varchar(100) NOT NULL,
  `numberOfItems` int(11) NOT NULL,
  `passingScore` int(11) NOT NULL,
  `retryAfter` int(11) NOT NULL,
  `quiz_created` datetime NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_quiz`
--

INSERT INTO `tbl_quiz` (`quiz_id`, `lesson_id`, `status`, `quiz_title`, `quiz_description`, `quiz_type`, `numberOfItems`, `passingScore`, `retryAfter`, `quiz_created`, `last_updated`) VALUES
(7, 32, 'active', 'Criminology Theories', 'Explore the depths of criminology theories with our Pretest. Dive into classical, biological, sociological, and psychological perspectives on criminal behavior. Uncover the origins of crime, societal influences, and real-world applications.', 'pre-test', 5, 3, 3600, '2024-03-14 10:50:49', '2024-03-14 11:00:47'),
(8, 32, 'active', 'forensic', '\r\nDelve into the captivating realm of forensic science, merging scientific principles with criminal inquiry. Discover key lesson topics including crime scene analysis, DNA profiling, fingerprint examination, ballistics, and toxicology. Prepare to explore the intricate world where science meets investigation in the pursuit of justice.', 'pre-test', 5, 4, 3600, '2024-03-14 11:12:08', '0000-00-00 00:00:00'),
(9, 32, 'active', 'INTRODUCTION TO CRIMINOLOGY', 'Choose the letter of the correct answer', 'pre-test', 10, 1, 0, '2024-03-14 11:30:08', '0000-00-00 00:00:00'),
(10, 35, 'active', 'Criminal Law and Jurisprudence', 'Upon completion of the quiz, you will receive feedback on your performance, allowing you to gauge your comprehension of Criminal Law and Jurisprudence concepts and areas for further study.', 'pre-test', 5, 4, 3600, '2024-03-14 11:31:22', '0000-00-00 00:00:00'),
(11, 35, 'active', 'Forensic', 'Upon completion of the quiz, you will receive feedback on your performance, allowing you to gauge your comprehension of Criminal Law and Jurisprudence concepts and areas for further study.', 'pre-test', 5, 4, 3600, '2024-03-14 11:31:22', '2024-03-14 11:33:21'),
(12, 32, 'active', 'INTRODUCTION TO CRIMINOLOGY', 'Choose the letter of the correct answer', 'post-test', 10, 5, 3600, '2024-03-14 11:57:01', '0000-00-00 00:00:00'),
(13, 43, 'active', 'Pre-Test Criminal law and Jurisprudence', 'Choose the best answer!', 'pre-test', 5, 3, 3600, '2024-03-14 12:24:01', '2024-03-14 12:51:38'),
(14, 33, 'active', 'JUVENILE DELINQUENCY AND JUVENILE JUSTICE SYSTEM', 'Choose the letter of the correct answer', 'pre-test', 10, 1, 0, '2024-03-14 12:39:43', '0000-00-00 00:00:00'),
(15, 43, 'active', 'Post-Test Criminal law and Jurisprudence', 'Choose the best answer!', 'post-test', 5, 3, 3600, '2024-03-14 12:50:24', '2024-03-14 12:51:25'),
(16, 33, 'active', 'JUVENILE DELINQUENCY AND JUVENILE JUSTICE SYSTEM', 'Choose the letter of the correct answer', 'post-test', 10, 5, 3600, '2024-03-14 12:56:40', '0000-00-00 00:00:00'),
(17, 34, 'active', 'CRI 190 DISPUTE RESOLUTION AND CRISES/INCIDENT MANAGEMENT', 'Choose the letter of the correct answer', 'pre-test', 10, 1, 0, '2024-03-14 13:28:26', '0000-00-00 00:00:00'),
(18, 34, 'active', 'CRI 190 DISPUTE RESOLUTION AND CRISES/INCIDENT MANAGEMENT', 'Choose the letter of the correct answer', 'post-test', 10, 5, 3600, '2024-03-14 13:42:31', '0000-00-00 00:00:00'),
(19, 35, 'active', 'THEORIES OF CRIME CAUSATION', 'Choose the letter of the correct answer', 'pre-test', 10, 1, 0, '2024-03-14 14:10:52', '0000-00-00 00:00:00'),
(20, 35, 'active', 'THEORIES OF CRIME CAUSATION', 'Choose the letter of the correct answer', 'post-test', 10, 5, 3600, '2024-03-14 14:23:27', '0000-00-00 00:00:00'),
(21, 53, 'active', 'Quiz1', 'Quiz1', 'pre-test', 3, 2, 0, '2024-03-15 21:08:31', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quizattempt`
--

CREATE TABLE `tbl_quizattempt` (
  `attempt_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `attempt_status` varchar(50) NOT NULL,
  `attempt_score` int(11) NOT NULL,
  `attempt_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_quizattempt`
--

INSERT INTO `tbl_quizattempt` (`attempt_id`, `quiz_id`, `student_id`, `attempt_status`, `attempt_score`, `attempt_count`) VALUES
(49, 17, '02-1920-03919', 'completed', 3, 1),
(50, 7, '02-1920-03919', 'completed', 0, 1),
(51, 21, '02-1819-05847', 'completed', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quizquestions`
--

CREATE TABLE `tbl_quizquestions` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `quiz_question` varchar(2000) NOT NULL,
  `option_1` varchar(500) NOT NULL,
  `option_2` varchar(500) NOT NULL,
  `option_3` varchar(500) NOT NULL,
  `option_4` varchar(500) NOT NULL,
  `correct_answer` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_quizquestions`
--

INSERT INTO `tbl_quizquestions` (`question_id`, `quiz_id`, `quiz_question`, `option_1`, `option_2`, `option_3`, `option_4`, `correct_answer`) VALUES
(50, 7, 'Criminology is the scientific study of:', 'A. The making of laws', 'B. The breaking of laws', 'C. Society’s reaction to the breaking of laws', 'D. Society is a stable entity in which laws are created for the general good.', 'D. Society is a stable entity in which laws are created for the general good.'),
(51, 7, 'The conflict model of law assumes that:', 'A. The conflict model of law assumes that:', 'B. The criminal law expresses the values of the ruling class within a society.', 'C. Members of a society, by and large, agree on what is right.', 'D. Society is a stable entity in which laws are created for the general good.', 'A. The conflict model of law assumes that:'),
(52, 7, 'Conflict theorists view society as a stable entity in which laws are created for the general good.', ' A. True', ' B. False', 'C. Maybe', 'D. No answer', ' B. False'),
(53, 7, 'Crime has become globalized.', 'True', 'False', 'Maybe', 'No Answer', 'True'),
(54, 7, 'What are some of the limitations of self-report surveys?', 'A. They represent a wide range of criminal acts.', 'B. Respondents may not tell the truth.', 'C. The samples are never biased.', 'D.  The information they yield applies to individuals of many age ranges', 'B. Respondents may not tell the truth.'),
(55, 8, '1. What is the primary goal of forensic science?', 'a) Identifying suspects', 'b) Solving crimes', 'c) Analyzing evidence', 'd) Compiling case reports', 'b) Solving crimes'),
(56, 8, '2. What is the &#34;chain of custody&#34; in forensic science?', 'a) A collection of evidence', 'b) A chronological record of evidence handling', 'c) A method of preserving DNA samples', 'd) A catalog of forensic tools', 'a) A collection of evidence'),
(57, 8, '3. What is the role of forensic entomology in criminal investigations?', 'a) Studying insects found on ', 'b) Analyzing soil samples from crime scenes', 'c) Identifying plant materials at crime scenes', 'd) Examining gunshot residue', 'a) Studying insects found on '),
(58, 8, '4. How can DNA evidence be used in forensic investigations?', 'a) Establishing suspects&#39; alibis', 'b) Analyzing blood spatter patterns', 'c) Identifying unknown individuals', 'd) Matching tire tracks at crime scenes', 'c) Identifying unknown individuals'),
(59, 8, '5. What is the purpose of forensic ballistics?', 'a) Analyzing the trajectory of bullets', 'b) Identifying chemical substances in evidence', 'c) Examining tool marks on surfaces', 'd) Documenting bloodstain patterns', 'a) Analyzing the trajectory of bullets'),
(60, 9, 'What does the term &#34;criminology&#34; refer to?', 'A) The study of crime as a social phenomenon', 'B) The study of criminal behavior and its causes', 'C) The study of victims and their experiences within the criminal justice system', 'D) The study of punishment of crime and criminal offenders', 'A) The study of crime as a social phenomenon'),
(61, 11, '1. What is the primary goal of forensic science?', 'a) Identifying suspects', 'b) Solving crimes', 'c) Analyzing evidence', 'd) Compiling case reports', 'b) Solving crimes'),
(62, 11, '2. What is the &#34;chain of custody&#34; in forensic science?', 'a) A collection of evidence', 'b) A chronological record of evidence handling', 'c) A method of preserving DNA samples', 'd) A catalog of forensic tools', 'a) A collection of evidence'),
(63, 9, 'Who introduced the term &#34;criminology&#34; in Italian?', 'A) Raffaele Garofalo', 'B) Cesare Beccaria', 'C) Paul Topinard', 'D) Enrico Ferri', 'A) Raffaele Garofalo'),
(64, 11, '3. What is the role of forensic entomology in criminal investigations?', 'a) Studying insects found on decomposing bodies', 'b) Analyzing soil samples from crime scenes', 'c) Identifying plant materials at crime scenes d) Examining gunshot residue', 'd) Examining gunshot residue', 'a) Studying insects found on decomposing bodies'),
(65, 11, '4. How can DNA evidence be used in forensic investigations?', 'a) Establishing suspects&#39; alibis', 'b) Analyzing blood spatter patterns', 'c) Identifying unknown individuals', 'd) Matching tire tracks at crime scenes', 'c) Identifying unknown individuals'),
(66, 9, 'Which of the following is one of the principal divisions of criminology?', 'A) Sociology of Law', 'B) Criminal Psychology', 'C) Economic Criminology', 'D) Political Criminology', 'A) Sociology of Law'),
(67, 11, '5. What is the purpose of forensic ballistics?', 'a) Analyzing the trajectory of bullets', 'b) Identifying chemical substances in evidence', 'c) Examining tool marks on surfaces', 'd) Documenting bloodstain patterns', 'a) Analyzing the trajectory of bullets'),
(68, 9, 'What is the primary aim in the study of criminology?', 'A) To understand laws and legal systems', 'B) To understand crimes and criminals', 'C) To prevent the occurrence of crime', 'D) To understand the role of police in society', 'B) To understand crimes and criminals'),
(69, 9, 'Which of the following is NOT a component of the criminal justice system?', 'A) Law Enforcement', 'B) Prosecution', 'C) Correctional Facilities', 'D) Medical Institutions', 'D) Medical Institutions'),
(70, 9, 'Who is often referred to as the &#34;Father of Criminology&#34;?', 'A) Cesare Beccaria', 'B) Raffaele Garofalo', 'C) Enrico Ferri', 'D) Jeremy Bentham', 'B) Raffaele Garofalo'),
(71, 9, 'What is the primary focus of victimology?', 'A) The study of crime as a social phenomenon', 'B) The study of victims and their experiences within the criminal justice system', 'C) The study of criminal behavior and its causes', 'D) The study of punishment of crime and criminal offenders', 'B) The study of victims and their experiences within the criminal justice system'),
(72, 9, 'Which approach in the explanation of crime focuses on factors extraneous to the offender, such as social, sociological, cultural, and economic factors?', 'A) Biological Approach', 'B) Psychological Approach', 'C) Sociological Approach', 'D) Geographical Approach', 'C) Sociological Approach'),
(73, 9, 'What is the term used to describe the study of punishment of crime or of criminal offenders?', 'A) Victimology', 'B) Penology', 'C) Criminology', 'D) Criminalistics', 'B) Penology'),
(74, 9, 'Which theory of victimology suggests that people may initiate the confrontation that leads to their injury or death?', 'A) Lifestyle Theory', 'B) Routine Activities Theory', 'C) Victim Precipitation Theory', 'D) Deviant Place Theory', 'C) Victim Precipitation Theory'),
(75, 10, '1. In criminal cases, except those involving quasi-offenses or criminal negligence or those allowed by the law, what is the offer by the accused which may be received in evidence as an implied admission of guilt?', 'a) compromise', 'b) Agreement ', 'c) Covenant', 'd) Admission', 'b) Agreement '),
(76, 10, '2. What is the territorial reach of a warrant of arrest?', 'a) Anywhere in the world', 'b) Anywhere in the philippines  ', 'c)Within the city wher such warrantof arrest was issued', 'd) none of these', 'b) Anywhere in the philippines  '),
(77, 10, '3. What exists when the evidence submitted to the inquest officer engenders a well- founded belief that a crime has been committed that the arrested or detained person is probably quilty therefor?', 'a) Criminal guilt', 'b) Probable cause', 'c) Inquest', 'd) none of these', 'b) Probable cause'),
(78, 10, '4. The factors to be considered by the court in determining proper penalty for impossible crime are:', 'a. The social danger', 'b. The intent or means of commission', 'b. The degree of criminality shown by the offender', 'd.  A and C', 'd.  A and C'),
(79, 10, '5. What principle of law requires that the judiciary can do nothing but to apply a law, even in cases where doing such would seem to result in grave injustice?', 'A.   Aberratio ictus', 'B. Ignorantialegis non excusat', 'C. Vox populivox De', 'D. Dura lex sed lex', 'D. Dura lex sed lex'),
(80, 10, '5. What principle of law requires that the judiciary can do nothing but to apply a law, even in cases where doing such would seem to result in grave injustice?', 'A.   Aberratio ictus', 'B. Ignorantialegis non excusat', 'C. Vox populivox De', 'D. Dura lex sed lex', 'D. Dura lex sed lex'),
(81, 12, 'Who introduced the term &#34;criminology&#34;?', 'A) Raffaele Garofalo', 'B) Cesare Beccaria', 'C) Enrico Ferri', 'D) Jeremy Bentham', 'A) Raffaele Garofalo'),
(82, 12, 'What is the primary source of criminal law in the Philippines?', 'A) Republic Act No. 6506', 'B) Republic Act No. 11131', 'C) Act No. 3815', 'D) Revised Penal Code', 'C) Act No. 3815'),
(83, 12, 'According to Lombroso, what are &#34;born criminals&#34;?', 'A) Individuals who commit crime due to less physical stamina', 'B) Individuals who commit crime due to insignificant reasons', 'C) Individuals who are easily influenced by great emotions', 'D) Individuals who inherit criminal behavior traits', 'D) Individuals who inherit criminal behavior traits'),
(84, 12, 'What is the consensus view of crime?', 'A) Crime is a political concept designed to protect the power of the upper classes', 'B) Crime is behavior in violation of the criminal law agreed upon by a majority of citizens', 'C) Crime is a result of the interaction between criminals and victims', 'D) Crime is behavior that is outlawed because society defines it as such', 'B) Crime is behavior in violation of the criminal law agreed upon by a majority of citizens'),
(85, 12, 'What is penology?', 'A) The study of victims of crimes', 'B) The study of punishment of crime or of criminal offenders', 'C) The study of criminal behavior and crime causation', 'D) The study of the criminal justice system', 'B) The study of punishment of crime or of criminal offenders'),
(86, 12, 'Which theory of victimology suggests that crime is a function of the victim&#39;s lifestyle?', 'A) Victim precipitation theory', 'B) Lifestyle theory', 'C) Deviant place theory', 'D) Rational choice theory', 'B) Lifestyle theory'),
(87, 12, 'What are the components of the criminal justice system in the Philippines?', 'A) Law enforcement, prosecution, court, corrections, mobilized community', 'B) Police, courts, lawyers, prisons, rehabilitation centers', 'C) Legislation, judiciary, executive, corrections, community', 'D) Crime prevention, investigation, prosecution, trial, sentencing', 'A) Law enforcement, prosecution, court, corrections, mobilized community'),
(88, 12, 'What is the primary source of criminal law in the Philippines?', 'A) Revised Penal Code', 'B) Civil Code', 'C) Family Code', 'D) Labor Code', 'A) Revised Penal Code'),
(89, 12, 'According to the Consensus View of crime, how is crime defined?', 'A) By the ruling class', 'B) By moral consensus', 'C) By political concept', 'D) By individual perception', 'B) By moral consensus'),
(90, 12, 'Which theory of victimology suggests that crime is a function of the victim&#39;s lifestyle?', 'A) Victim precipitation theory', 'B) Lifestyle theory', 'C) Deviant place theory', 'D) Routine activities theory', 'B) Lifestyle theory'),
(91, 13, 'John Rey was lawfully arrested in one of the rooms of hotel Nebraska. Incidental to that lawful arrest, the police operatives conducted a warrantless search in another room of the hotel adjacent to the suspect’s room. The pieces of evidence that could be obtained from that another room are considered.', 'a.   Legal since they are taken incidental to a lawful arrest', 'b.   Inadmissible', 'c.   Admissible', 'd.   B and/or C', 'a.   Legal since they are taken incidental to a lawful arrest'),
(92, 13, 'What is the territorial reach of a warrant of arrest?', 'a. Anywhere in the world', 'b. Anywhere in the Philippines', 'c. Within the region where such warrant of arrest was issued', 'd. Within the city where such warrant of arrest was issued', 'b. Anywhere in the Philippines'),
(93, 13, '3. This may happen that one may offer evidence which is inadmissible but which is admitted because there is no objection from the opposite party. The latter is not justified in introducing a reply to the same kind of evidence, if properly objected, it erases the unfavorable inference which might otherwise have been caused from the original evidence.', 'a. Affirmative Admissibility', 'b. Corrective Admissibility', 'c. Multiple Admissibility', 'd.   Curative Admissibility', 'd.   Curative Admissibility'),
(94, 13, '4. It is the informal and summary investigation conducted by a public prosecutor in criminal cases involving persons arrested detained without the benefit of warrant of arrest issued by the court for the purpose of determining whether or not said persons should remain under custody and correspondingly be charged in court. ', 'a. Preliminary Investigation', 'b. Preliminary Conference ', 'c.   Inquest', 'd. Judicial inquiry', 'c.   Inquest'),
(95, 13, '5. What exists when the evidence submitted to the Inquest Officer engenders a well-founded beliefthat a crime has been committed that the arrested or detained person is probably guilty thereof?', 'a. Prima facie evidence', 'b.   Probable cause', 'c. Proof beyond reasonable doubt', 'd. Criminal guilt', 'b.   Probable cause'),
(96, 14, 'Which of the following is NOT a historical milestone in the development of juvenile justice?', 'A) Code of Hammurabi', 'B) 1641 Stubborn Child Law', 'C) 1916 Keating-Owen Act', 'D) 1818 Committee Report', 'D) 1818 Committee Report'),
(97, 14, 'What was the significance of the 1899 Illinois legislature passing a law creating a juvenile court?', 'A) It established the first juvenile detention center in the United States.', 'B) It provided the procedural requirements for waiving juveniles to criminal court.', 'C) It laid the groundwork for the Fair Labor Standards Act.', 'D) It was the cornerstone for juvenile justice throughout the United States.', 'D) It was the cornerstone for juvenile justice throughout the United States.'),
(98, 14, 'Which theory of delinquency suggests that crime is a learned behavior?', 'A) Supernatural Theory', 'B) Classical School Theory', 'C) Differential Association Theory', 'D) Rational Choice Theory', 'C) Differential Association Theory'),
(99, 14, 'According to William Sheldon&#39;s somatotype theory, which body type is associated with a tendency towards masculinity and corresponds to the Somatotonia temperament?', 'A) Endomorph', 'B) Mesomorph', 'C) Ectomorph', 'D) None of the above', 'B) Mesomorph'),
(100, 14, 'What is the main idea behind the Social Control Theory?', 'A) Delinquents are normal except in belonging to a subculture that teaches them it is all right to be delinquent.', 'B) Members in society form bonds with other members in society or institutions that control their behavior.', 'C) Crime is caused by factors that are in place before the crime occurs, and free will has nothing to do with what people do.', 'D) Society is organized around a consensus of values and norms, and conflict within society is normal.', 'B) Members in society form bonds with other members in society or institutions that control their behavior.'),
(101, 14, 'What is the primary goal of the Conflict Theory?', 'A) To explain criminal behavior as a result of biological and psychological factors.', 'B) To analyze crime as a product of social and economic inequalities.', 'C) To describe how crime is learned through associations with others.', 'D) To understand crime as a result of strain between societal goals and the means to achieve them.', 'B) To analyze crime as a product of social and economic inequalities.'),
(102, 14, 'What is the main premise of the Differential Opportunity Theory?', 'A) Delinquency rates decline the farther one moves from the center of the city.', 'B) People learn criminal behavior through the groups with which they associate.', 'C) The means for illegitimate success are more equally distributed than the means for legitimate success.', 'D) Crime is caused by frustration resulting from blocked opportunities to achieve positively valued goals.D) Crime is caused by frustration resulting from blocked opportunities to achieve positively valued goals.', 'D) Crime is caused by frustration resulting from blocked opportunities to achieve positively valued goals.D) Crime is caused by frustration resulting from blocked opportunities to achieve positively valued goals.'),
(103, 14, 'Which theory of female delinquency views delinquents as well-adjusted people and sees delinquent behavior as behavior so labeled by adults in a community?', 'A) Lombroso and Ferrero’s Atavistic Girl', 'B) Freud’s “Inferior Girl”', 'C) Thomas’ “Unadjusted Girl”', 'D) Frank Tannenbaum Labeling Theory', 'D) Frank Tannenbaum Labeling Theory'),
(104, 14, 'What is the etymology of the modern English word &#34;marriage&#34;?', 'A) It derives from Middle English mariage, which first appeared in 1250-1300 C.E.', 'B) It derives from Old French marier and ultimately Latin maritare and maritus.', 'C) It derives from the Latin word &#34;matrimonium,&#34; meaning the state or condition of a mother.', 'D) It derives from the Greek word &#34;maria,&#34; meaning union or partnership.', 'B) It derives from Old French marier and ultimately Latin maritare and maritus.'),
(105, 14, 'What is a common-law marriage?', 'A) It is a marriage that is recognized only by a church authority.', 'B) It is a form of marriage recognized in some jurisdictions where no legally recognized marriage ceremony is performed.', 'C) It is a marriage between two people of the same biological sex.', 'D) It is a marriage that is recognized only by a state authority.', 'B) It is a form of marriage recognized in some jurisdictions where no legally recognized marriage ceremony is performed.'),
(106, 15, '15. The factors to be considered by the court in determining proper penalty for impossible crime are:', 'a. The social danger', 'b. The degree of criminality shown by the offender', 'c. The intent or means of commission', 'd. A and B', 'd. A and B'),
(107, 15, '16. What principle of law requires that the judiciary can do nothing but to apply a law, even in cases where doing such would seem to result in grave injustice?', 'a. None of these ', 'b. Dura lex sed lex', 'c. Dura lex sed lex ', 'd.   Ignorantialegis non excusat', 'c. Dura lex sed lex '),
(108, 15, '17. Matthew with intent to kill stabbed Luke but the latter was only hit on his wrist. The small cut required medication for 5 days. What crime was committed by Matthew?', 'a.   Slight physical injury', 'b.   Attempted homicide', 'c.   Frustrated homicide', 'd.   Attempted homicide', 'd.   Attempted homicide'),
(109, 15, '4. Mark with intent to kill assaulted John from behind but the point of the knife hit the back of the chair where John was seated. Fortunately, John was not wounded. What was the crime committed by Mark?', 'a. Frustrated murder ', 'b.   Attempted homicide', 'c. Attempted murder', 'd.   Impossible crime', 'c. Attempted murder'),
(110, 15, '5. Mere contact by the male’s sex organ of the labia is –', 'a. Attempted rape ', 'b. Frustrated rape', 'c. Consummated rape', 'd.   Act of lasciviousness', 'c. Consummated rape'),
(111, 16, 'What was the significance of the 1916 Keating-Owen Act?', 'A) It established the first juvenile detention center in the United States.', 'B) It provided the procedural requirements for waiving juveniles to criminal court.', 'C) It was the first piece of child labor legislation in America.', 'D) It laid the groundwork for the Fair Labor Standards Act.', 'C) It was the first piece of child labor legislation in America.'),
(112, 16, 'According to Differential Association Theory, how do people learn criminal behavior?', 'A) Through genetic predisposition.', 'B) Through environmental influences and associations.', 'C) Through psychological trauma.', 'D) Through biological factors.', 'B) Through environmental influences and associations.'),
(113, 16, 'What is the main idea behind the Social Control Theory?', 'A) Delinquents are normal except in belonging to a subculture that teaches them it is all right to be delinquent.', 'B) Members in society form bonds with other members in society or institutions that control their behavior.', 'C) Crime is caused by factors that are in place before the crime occurs, and free will has nothing to do with what people do.', 'D) Society is organized around a consensus of values and norms, and conflict within society is normal.', 'B) Members in society form bonds with other members in society or institutions that control their behavior.'),
(114, 16, 'Which theory of delinquency suggests that crime is a learned behavior?', 'A) Supernatural Theory', 'B) Classical School Theory', 'C) Differential Association Theory', 'D) Rational Choice Theory', 'C) Differential Association Theory'),
(115, 16, 'What is the primary goal of the Conflict Theory?', 'A) To explain criminal behavior as a result of biological and psychological factors.', 'B) To analyze crime as a product of social and economic inequalities.', 'C) To describe how crime is learned through associations with others.', 'D) To understand crime as a result of strain between societal goals and the means to achieve them.', 'B) To analyze crime as a product of social and economic inequalities.'),
(116, 16, 'What is the etymology of the modern English word &#34;marriage&#34;?', 'A) It derives from Middle English mariage, which first appeared in 1250-1300 C.E.', 'B) It derives from Old French marier and ultimately Latin maritare and maritus.', 'C) It derives from the Latin word &#34;matrimonium,&#34; meaning the state or condition of a mother.', 'D) It derives from the Greek word &#34;maria,&#34; meaning union or partnership.', 'B) It derives from Old French marier and ultimately Latin maritare and maritus.'),
(117, 16, 'What is a common-law marriage?', 'A) It is a marriage that is recognized only by a church authority.', 'B) It is a form of marriage recognized in some jurisdictions where no legally recognized marriage ceremony is performed.', 'C) It is a marriage between two people of the same biological sex.', 'D) It is a marriage that is recognized only by a state authority.', 'B) It is a form of marriage recognized in some jurisdictions where no legally recognized marriage ceremony is performed.'),
(118, 16, 'Which theory of female delinquency views delinquents as well-adjusted people and sees delinquent behavior as behavior so labeled by adults in a community?', 'A) Lombroso and Ferrero’s Atavistic Girl', 'B) Freud’s “Inferior Girl”', 'C) Thomas’ “Unadjusted Girl”', 'D) Frank Tannenbaum Labeling Theory', 'D) Frank Tannenbaum Labeling Theory'),
(119, 16, 'What is the main premise of the Differential Opportunity Theory?', 'A) Delinquency rates decline the farther one moves from the center of the city.', 'B) People learn criminal behavior through the groups with which they associate.', 'C) The means for illegitimate success are more equally distributed than the means for legitimate success.', 'D) Crime is caused by frustration resulting from blocked opportunities to achieve positively valued goals.', 'D) Crime is caused by frustration resulting from blocked opportunities to achieve positively valued goals.'),
(120, 16, 'According to William Sheldon&#39;s somatotype theory, which body type is associated with a tendency towards masculinity and corresponds to the Somatotonia temperament?', 'A) Endomorph', 'B) Mesomorph', 'C) Ectomorph', 'D) None of the above', 'B) Mesomorph'),
(121, 17, 'What is negotiation?', 'a) A process where a neutral person assists parties in reaching a resolution', 'b) A process where two parties in a conflict try to reach a resolution together', 'b) A process where two parties in a conflict try to reach a resolution together', 'd) A process where parties in a conflict use force to reach an agreement', 'b) A process where two parties in a conflict try to reach a resolution together'),
(122, 17, 'What is the goal of negotiation?', 'a) To impose a decision on the parties', 'b) To reach an agreement acceptable to all parties', 'c) To prolong the conflict', 'd) To avoid resolution', 'b) To reach an agreement acceptable to all parties'),
(123, 17, 'What is mediation?', 'a) A process where a neutral person assists parties in reaching a resolution', 'b) A process where two parties in a conflict try to reach a resolution together', 'c) A process where parties present evidence to a judge for a decision', 'd) A process where parties in a conflict use force to reach an agreement', 'a) A process where a neutral person assists parties in reaching a resolution'),
(124, 17, 'What is the role of a mediator?', 'a) To impose a decision on the parties', 'b) To reach an agreement acceptable to all parties', 'c) To prolong the conflict', 'd) To assist parties in communicating and reaching a resolution', 'd) To assist parties in communicating and reaching a resolution'),
(125, 17, 'What is litigation?', 'a) A process where a neutral person assists parties in reaching a resolution', 'b) A process where two parties in a conflict try to reach a resolution together', 'c) A process where parties present evidence to a judge for a decision', 'd) A process where parties in a conflict use force to reach an agreement', 'c) A process where parties present evidence to a judge for a decision'),
(126, 17, 'What is the main difference between retributive justice and restorative justice?', 'a) Retributive justice focuses on punishment, while restorative justice focuses on repairing harm and restoring relationships.', 'b) Retributive justice focuses on repairing harm, while restorative justice focuses on punishment.', 'c) Retributive justice involves the community, while restorative justice involves only the victim and offender.', 'd) Retributive justice involves only the victim and offender, while restorative justice involves the community.', 'a) Retributive justice focuses on punishment, while restorative justice focuses on repairing harm and restoring relationships.'),
(127, 17, 'What are some advantages of mediation?', 'a) Parties have complete control over the settlement', 'b) Less stress compared to litigation', 'c) The relationship between the parties isn&#39;t overly damaged', 'd) All of the above', 'd) All of the above'),
(128, 17, 'What are some disadvantages of mediation?', 'a) Since the decision is at the discretion of the parties, there is a possibility that a settlement may not arise', 'b) It lacks the support of any judicial authority', 'c) The absence of formality', 'd) All of the above', 'd) All of the above'),
(129, 17, 'What is the 4P Crisis Management Model?', 'a) Prediction, Prevention, Preparation, Performance', 'b) Preparation, Prevention, Performance, Prediction', 'c) Prevention, Performance, Prediction, Preparation', 'd) Prediction, Preparation, Performance, Prevention', 'a) Prediction, Prevention, Preparation, Performance'),
(130, 17, 'What is the &#34;Alternative Dispute Resolution Act of 2004&#34; in the Philippines also known as?', 'a) Republic Act No. 9999', 'b) Republic Act No. 8888', 'c) Republic Act No. 7777', 'd) Republic Act No. 9285', 'd) Republic Act No. 9285'),
(131, 18, 'What are strategies and techniques?', 'A. Concrete ways of accomplishing goals.', 'B. Goals that prioritize and focus efforts.', 'C. Both A and B.', 'D. None of the above.', 'C. Both A and B.'),
(132, 18, 'Which of the following is a strategy used in mediation?', 'A. Engaging in physical confrontation.', 'B. Avoiding communication with the parties.', 'C. Creating safe spaces for communication.', 'D. None of the above.', 'C. Creating safe spaces for communication.'),
(133, 18, 'What is the primary goal of convening processes in mediation?', 'A. To resolve the conflict without the parties&#39; involvement.', 'B. To bring disputants to a preliminary meeting to discuss the issues and consider resolution options.', 'C. To create more conflict between the parties.', 'D. None of the above.', 'B. To bring disputants to a preliminary meeting to discuss the issues and consider resolution options.'),
(134, 18, 'What is the purpose of conflict assessment in mediation?', 'A. To escalate the conflict.', 'B. To determine what is going on in the conflict.', 'C. To avoid resolution of the conflict.', 'D. None of the above.', 'B. To determine what is going on in the conflict.'),
(135, 18, 'Which of the following is a characteristic of ground rules in mediation?', 'A. Creating a confrontational environment.', 'B. Allowing interruptions during communication.', 'C. Giving every participant equal opportunity to speak.', 'D. None of the above.', 'C. Giving every participant equal opportunity to speak.'),
(136, 18, 'What is the role of reframing in mediation?', 'A. To reinforce parties&#39; initial views.', 'B. To redefine the way parties think about the dispute.', 'C. To escalate the conflict.', 'D. None of the above.', 'B. To redefine the way parties think about the dispute.'),
(137, 18, 'What is option identification in the mediation process?', 'A. A step to escalate the conflict.', 'B. Listing all options available to parties for advancing their interests.', 'C. Avoiding resolution of the conflict.', 'D. None of the above.', 'B. Listing all options available to parties for advancing their interests.'),
(138, 18, 'What is the purpose of caucus in mediation?', 'A. To facilitate communication between the parties.', 'B. To keep mediation moving forward by addressing problems that occur during the process.', 'C. To escalate the conflict.', 'D. None of the above.', 'B. To keep mediation moving forward by addressing problems that occur during the process.'),
(139, 18, 'Which of the following is a negotiating strategy for schizophrenic individuals?', 'A. Convincing them of the reality.', 'B. Attempting to understand.', 'C. Staring or getting too close.', 'D. None of the above.', 'B. Attempting to understand.'),
(140, 18, 'What is the main difference between crisis and emergency?', 'A. Crisis requires immediate interventions, while emergency does not.', 'B. Emergency requires immediate interventions, while crisis does not.', 'C. Both crisis and emergency require immediate interventions.', 'D. None of the above.', 'B. Emergency requires immediate interventions, while crisis does not.'),
(141, 19, 'What are the three parts of the psyche according to Freud&#39;s personality theory?', 'A. Id, ego, and superego', 'B. Ego, subconscious, and unconscious', 'C. Conscious, subconscious, and unconscious', 'D. Id, superego, and subconscious', 'A. Id, ego, and superego'),
(142, 19, 'Which of the following best describes the subconscious level of the human mind?', 'A. It stores recent memories for quick recall.', 'B. It is where all memories and past experiences reside.', 'C. It serves as the scanner for perceiving events.', 'D. It is the storage point for basic urges and desires.', 'A. It stores recent memories for quick recall.'),
(143, 19, 'According to the Italian or Positivist School, what should be punished?', 'A. The crime', 'B. The person', 'C. The situation', 'D. The resistance to temptation', 'B. The person'),
(144, 19, 'What is the main principle of the Classical School of criminology?', 'A. Let the punishment fit the crime.', 'B. Let the punishment fit the criminal.', 'C. Punishment should deter crime.', 'D. Punishment should be humane.', 'A. Let the punishment fit the crime.'),
(145, 19, 'What is the main principle of the Classical School of criminology?', 'A. Let the punishment fit the crime.', 'B. Let the punishment fit the criminal.', 'C. Punishment should deter crime.', 'D. Punishment should be humane.', 'A. Let the punishment fit the crime.'),
(146, 19, 'According to the Conflict Perspective, what causes crime?', 'A. Biological factors', 'B. Psychological factors', 'C. Economic and political forces', 'D. Socialization and upbringing', 'C. Economic and political forces'),
(147, 19, 'Which theory suggests that criminals are a lower form of life, nearer to their apelike ancestors?', 'A. Cheater theory', 'B. R/K Selection theory', 'C. Evolutionary theory', 'D. Born criminal theory', 'D. Born criminal theory'),
(148, 19, 'What is the main idea behind Biosocial Theory?', 'A. Crime is a product of socialization.', 'B. Crime is a function of competition for limited resources.', 'C. Crime is a result of both biological and social factors.', 'D. Crime is an adaptive behavior in human evolution.', 'C. Crime is a result of both biological and social factors.'),
(149, 19, 'What does the Latent Trait Theory suggest?', 'A. Every individual has inborn criminal traits.', 'B. Criminal behavior is a dynamic process.', 'C. Criminal behavior is influenced by social experiences.', 'D. Criminal behavior changes dramatically over a person&#39;s life span.', 'A. Every individual has inborn criminal traits.'),
(150, 19, 'Which family study is associated with Richard Louis Dugdale?', 'A. Jukes Family', 'B. Kallikak Family', 'C. Goddard Family', 'D. Hooton Family', 'A. Jukes Family'),
(151, 19, 'What does Phrenology study?', 'A. Facial features and their relation to human behavior', 'B. The conformation of the skull as indicative of mental faculties', 'C. The physical qualities of offenders', 'D. The relationship between body physique and behavior', 'B. The conformation of the skull as indicative of mental faculties'),
(152, 20, 'According to Freud&#39;s personality theory, which part of the psyche operates according to the reality principle?', 'A. Id', 'B. Ego', 'C. Superego', 'D. Subconscious', 'B. Ego'),
(153, 20, 'What is the main principle of the Classical School of criminology?', 'A. Let the punishment fit the crime.', 'B. Let the punishment fit the criminal.', 'C. Punishment should deter crime.', 'D. Punishment should be humane.', 'A. Let the punishment fit the crime.'),
(154, 20, 'D. Punishment should be humane.', 'A. Biological factors', 'B. Psychological factors', 'C. Economic and political forces', 'D. Socialization and upbringing', 'C. Economic and political forces'),
(155, 20, 'Which theory suggests that criminals are a lower form of life, nearer to their apelike ancestors?', 'A. Cheater theory', 'B. R/K Selection theory', 'C. Evolutionary theory', 'D. Born criminal theory', 'D. Born criminal theory'),
(156, 20, 'What is the main idea behind Biosocial Theory?', 'A. Crime is a product of socialization.', 'B. Crime is a function of competition for limited resources.', 'C. Crime is a result of both biological and social factors.', 'D. Crime is an adaptive behavior in human evolution.', 'C. Crime is a result of both biological and social factors.'),
(157, 20, 'What does the Latent Trait Theory suggest?', 'A. Every individual has inborn criminal traits.', 'B. Criminal behavior is a dynamic process.', 'C. Criminal behavior is influenced by social experiences.', 'D. Criminal behavior changes dramatically over a person&#39;s life span.', 'A. Every individual has inborn criminal traits.'),
(158, 20, 'Which family study is associated with Richard Louis Dugdale?', 'A. Jukes Family', 'B. Kallikak Family', 'C. Goddard Family', 'D. Hooton Family', 'A. Jukes Family'),
(159, 20, 'What does Phrenology study?', 'A. Facial features and their relation to human behavior', 'B. The conformation of the skull as indicative of mental faculties', 'C. The physical qualities of offenders', 'D. The relationship between body physique and behavior', 'B. The conformation of the skull as indicative of mental faculties'),
(160, 20, 'According to the Italian or Positivist School, what should be punished?', 'A. The crime', 'B. The person', 'C. The situation', 'D. The resistance to temptation', 'B. The person'),
(161, 20, 'Which theory explains the existence of aggression and violent behavior as positive adaptive behaviors in human evolution?', 'A. Biosocial Theory', 'B. Evolutionary Theory', 'C. Life-Course Theory', 'D. Latent Trait Theory', 'B. Evolutionary Theory'),
(162, 21, '1', 'a', 'b', 'c', 'd', 'a'),
(163, 21, '1+1', '5', '4', '3', '2', '2'),
(164, 21, '3+0', '1', '2', '3', '4', '3'),
(165, 21, '2+2', '1', '2', '3', '4', '2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quizresponses`
--

CREATE TABLE `tbl_quizresponses` (
  `response_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `picked_response` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_quizresponses`
--

INSERT INTO `tbl_quizresponses` (`response_id`, `quiz_id`, `question_id`, `student_id`, `picked_response`) VALUES
(270, 17, 126, '02-1920-03919', 'c) Retributive justice involves the community, while restorative justice involves only the victim and offender.'),
(271, 17, 123, '02-1920-03919', 'd) A process where parties in a conflict use force to reach an agreement'),
(272, 17, 122, '02-1920-03919', 'b) To reach an agreement acceptable to all parties'),
(273, 17, 127, '02-1920-03919', 'c) The relationship between the parties isn\'t overly damaged'),
(274, 17, 129, '02-1920-03919', 'a) Prediction, Prevention, Preparation, Performance'),
(275, 17, 130, '02-1920-03919', 'c) Republic Act No. 7777'),
(276, 17, 121, '02-1920-03919', 'a) A process where a neutral person assists parties in reaching a resolution'),
(277, 17, 124, '02-1920-03919', 'd) To assist parties in communicating and reaching a resolution'),
(278, 17, 128, '02-1920-03919', 'b) It lacks the support of any judicial authority'),
(279, 17, 125, '02-1920-03919', 'd) A process where parties in a conflict use force to reach an agreement'),
(280, 7, 50, '02-1920-03919', 'A. The making of laws'),
(281, 7, 51, '02-1920-03919', 'C. Members of a society, by and large, agree on what is right.'),
(282, 7, 52, '02-1920-03919', 'B. False'),
(283, 7, 54, '02-1920-03919', 'D.  The information they yield applies to individuals of many age ranges'),
(284, 7, 53, '02-1920-03919', 'False'),
(285, 21, 165, '02-1819-05847', '2'),
(286, 21, 163, '02-1819-05847', '2'),
(287, 21, 162, '02-1819-05847', 'c');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

CREATE TABLE `tbl_section` (
  `section_id` varchar(50) NOT NULL,
  `teacher_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_section`
--

INSERT INTO `tbl_section` (`section_id`, `teacher_id`) VALUES
('CRIM-02G', '02-1920-03952'),
('CRIM-02B', '02-1920-03954'),
('CRIM-LEA2', '02-1920-03954'),
('CRIM-02D', '02-2324-03955'),
('CRIM-CLJ1', '02-2324-03955'),
('Advance Class', '02-2324-03956'),
('CRIM-02A', '02-2324-03957'),
('CRIM-CLJ2', '02-2324-03957'),
('CRIM-CLJ3', '02-2324-03957'),
('CRIM-CLJ5', '02-2324-03957'),
('CRIM-03', '02-9999-01059');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_studentclasses`
--

CREATE TABLE `tbl_studentclasses` (
  `primaryID` int(11) NOT NULL,
  `section_name` varchar(50) NOT NULL,
  `student_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_studentclasses`
--

INSERT INTO `tbl_studentclasses` (`primaryID`, `section_name`, `student_id`) VALUES
(6, 'CRIM-02A', '02-1920-03919'),
(7, 'CRIM-02B', '02-1920-03919'),
(10, 'CRIM-03', '02-1819-05847');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE `tbl_students` (
  `id` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `image` varchar(100) NOT NULL,
  `isActive` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`id`, `firstname`, `lastname`, `gender`, `email`, `password`, `image`, `isActive`) VALUES
('02-1819-05847', 'Piolo', 'Pascual', 'male', 'papap@gmail.com', '5ee61127121530dd8abec3acbffd662fb2a4b8ba', '', 'active'),
('02-1920-03919', 'Domskie', 'Kionisala', 'male', 'doen.coc@phinmaed.com', '9efceace4fc08a290ac0ef1564e58436ba02c564', '65fafa8dc8bff.jpg', 'active'),
('02-1999-03866', 'Amy', 'Enario', 'female', 'amja.enario.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-08175', 'Althea', 'Estrada', 'female', 'almo.estrada.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-13506', 'Paula', 'Dao-on', 'female', 'padu.daoon.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-14723', 'Jesson', 'Diaz', 'male', 'jeca.diaz.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-15794', 'Charles', 'Galendez', 'male', 'chba.galendez.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-34838', 'James', 'Demata', 'male', 'jama.demata.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-35142', 'Michelle', 'Gadot', 'female', 'mide.gadot.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-38449', 'Jeoffrey', 'Ga', 'male', 'jehe.ga.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-40017', 'Pamela', 'Damasing', 'female', 'paor.damasing.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-40229', 'Angeline', 'Delada', 'female', 'anya.delada.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-40599', 'Haiku', 'Eballe', 'male', 'haba.eballe.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-49513', 'Princess', 'Elardo', 'female', 'prir.elardo.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-52003', 'Cliedhyle', 'Elloren', 'female', 'clca.elloren.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-59341', 'kim', 'Estrada', 'female', 'kite.estrada.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-64644', 'Zakeesha', 'Eduarte', 'female', 'zaan.eduarte.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-66550', 'Bea', 'Ebalig', 'female', 'bead.ebalig.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-72010', 'Nole', 'Diango', 'male', 'noqu.diango.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-72836', 'Alexandra', 'Depotado', 'female', 'alit.depotado.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-72874', 'Francis', 'Gaid', 'male', 'frma.gaid.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-74126', 'Katherine', 'Gerosa', 'female', 'kaji.gerosa.coc@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-74875', 'Ryann', 'Deloso', 'male', 'ryha.deloso.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-83892', 'Sophia', 'Dugang', 'female', 'soth.dugang.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-84513', 'Jecel', 'Gamil', 'female', 'jebo.gamil.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-85861', 'Limbo', 'Doria', 'male', 'lira.doria.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-1999-97733', 'Fernando', 'Denoso', 'male', 'feli.denoso.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2020-20976', 'Kentche', 'Abregana', 'male', 'keja.abregana.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2020-22191', 'Queenie', 'Aguilar', 'female', 'quca.aguilar.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2020-41159', 'Clent', 'Alaba', 'male', 'cllu.alaba.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2020-42057', 'Eunice', 'Abuhan', 'female', 'euab.abuhan.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2020-49807', 'April', 'Abriol', 'female', 'apca.abriol.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2020-69648', 'Danica', 'Abel', 'female', 'dasa.abel.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2020-70139', 'Juney', 'Abejo', 'male', 'juba.abejo.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2020-87051', 'Rey', 'Agsinao', 'male', 'reti.agsinao.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2020-99157', 'Ariel', 'Aguillon', 'male', 'arba.aguillon.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2021-09414', 'Marc', 'Bajuyo', 'male', 'masa.bajuyo.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2021-21863', 'Noel', 'Bajuyo', 'male', 'noob.bajuyo.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2021-37571', 'Christian', 'Bagongon', 'male', 'chba.bagongon.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2021-51308', 'Revie', 'Balolot', 'female', 'resa.balolot.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2021-58332', 'Ajay', 'Balili', 'male', 'ajra.balili.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2021-69506', 'Eldon', 'Bajuyo', 'male', 'elta.bajuyo.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2021-75365', 'Vince', 'Baculio', 'male', 'vies.baculio.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2021-82325', 'Hanny', 'Bagas', 'female', 'hata.bagas.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2021-93846', 'Cristian', 'Banawan', 'male', 'crda.banawan.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2021-96573', 'Maeryl', 'Baculio', 'female', 'mala.baculio.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2022-13807', 'Rose', 'Behiga', 'female', 'rome.behiga.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2022-15820', 'Khyla', 'Bongcayao', 'female', 'khda.bongcayao.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2022-35896', 'John', 'Bingat', 'male', 'joro.bingat.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2022-42028', 'Angela', 'Bendero', 'female', 'ante.bendero.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2022-42190', 'Michael', 'Birol', 'male', 'mill.birol.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2022-49289', 'Junel', 'Baterna', 'male', 'juca.baterna.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2022-56424', 'Vincent', 'Billones', 'male', 'vino.billones.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2022-69309', 'John', 'Baquirin', 'male', 'joam.baquirin.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2022-71785', 'Jay', 'Bernadez', 'male', 'jall.bernadez.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active'),
('02-2022-79317', 'Carl', 'Bongolto', 'male', 'capa.bongolto.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teachers`
--

CREATE TABLE `tbl_teachers` (
  `teacher_id` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `gender` varchar(30) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `active` varchar(30) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_teachers`
--

INSERT INTO `tbl_teachers` (`teacher_id`, `firstname`, `lastname`, `gender`, `email`, `password`, `active`, `image`) VALUES
('02-1920-03952', 'Shan', 'Gorra', 'male', 'shma.gorra.coc@phinmaed.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 'inactive', 'nj.jpg'),
('02-1920-03954', 'Paul', 'Orencio', 'Male', 'joda.orencio.coc@phinmaed.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 'active', 'm8dvDn8mHJIxh7iH.jpg'),
('02-2324-03955', 'Hanni', 'Pham', 'Female', 'hanp.pham.coc@phinmaed.com', 'aec6cc652d5d9078fad2b42349c4e21036491bfd', 'active', 'default.png'),
('02-2324-03956', 'Danielle', 'Marsh', 'Female', 'danm.marsh.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', 'default.png'),
('02-2324-03957', 'Min Ji', 'Kim', 'Female', 'mink.kim.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', 'default.png'),
('02-2324-03958', 'Haerin', 'Kang', 'Female', 'haek.kang.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', 'default.png'),
('02-2324-03959', 'Hye In', 'Lee', 'Female', 'hyel.lee.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', 'default.png'),
('02-9999-01059', 'Jhana', 'Osanastre', 'female', 'jhana.jsanastre@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_audit`
--
ALTER TABLE `tbl_audit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_bookmark`
--
ALTER TABLE `tbl_bookmark`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_classlessons`
--
ALTER TABLE `tbl_classlessons`
  ADD PRIMARY KEY (`classlesson_id`),
  ADD KEY `section_name` (`section_name`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `tbl_dean`
--
ALTER TABLE `tbl_dean`
  ADD UNIQUE KEY `dean_id` (`dean_id`);

--
-- Indexes for table `tbl_learningmaterials`
--
ALTER TABLE `tbl_learningmaterials`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `tbl_lessons`
--
ALTER TABLE `tbl_lessons`
  ADD PRIMARY KEY (`lesson_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tbl_program_head`
--
ALTER TABLE `tbl_program_head`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `tbl_quizattempt`
--
ALTER TABLE `tbl_quizattempt`
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `student_id_2` (`student_id`);

--
-- Indexes for table `tbl_quizquestions`
--
ALTER TABLE `tbl_quizquestions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `tbl_quizresponses`
--
ALTER TABLE `tbl_quizresponses`
  ADD PRIMARY KEY (`response_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `tbl_section`
--
ALTER TABLE `tbl_section`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `tbl_studentclasses`
--
ALTER TABLE `tbl_studentclasses`
  ADD PRIMARY KEY (`primaryID`),
  ADD KEY `section_name` (`section_name`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_teachers`
--
ALTER TABLE `tbl_teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_audit`
--
ALTER TABLE `tbl_audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_classlessons`
--
ALTER TABLE `tbl_classlessons`
  MODIFY `classlesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_learningmaterials`
--
ALTER TABLE `tbl_learningmaterials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tbl_lessons`
--
ALTER TABLE `tbl_lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_quizattempt`
--
ALTER TABLE `tbl_quizattempt`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tbl_quizquestions`
--
ALTER TABLE `tbl_quizquestions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `tbl_quizresponses`
--
ALTER TABLE `tbl_quizresponses`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=288;

--
-- AUTO_INCREMENT for table `tbl_studentclasses`
--
ALTER TABLE `tbl_studentclasses`
  MODIFY `primaryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_audit`
--
ALTER TABLE `tbl_audit`
  ADD CONSTRAINT `tbl_audit_ibfk_1` FOREIGN KEY (`dean_id`) REFERENCES `tbl_dean` (`dean_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_audit_ibfk_3` FOREIGN KEY (`admin_id`) REFERENCES `tbl_admin` (`admin_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_bookmark`
--
ALTER TABLE `tbl_bookmark`
  ADD CONSTRAINT `tbl_bookmark_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_students` (`id`);

--
-- Constraints for table `tbl_classlessons`
--
ALTER TABLE `tbl_classlessons`
  ADD CONSTRAINT `tbl_classlessons_ibfk_1` FOREIGN KEY (`section_name`) REFERENCES `tbl_section` (`section_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_classlessons_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `tbl_lessons` (`lesson_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD CONSTRAINT `tbl_comments_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `tbl_learningmaterials` (`material_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_students` (`id`),
  ADD CONSTRAINT `tbl_comments_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `tbl_teachers` (`teacher_id`);

--
-- Constraints for table `tbl_learningmaterials`
--
ALTER TABLE `tbl_learningmaterials`
  ADD CONSTRAINT `tbl_learningmaterials_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `tbl_lessons` (`lesson_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_lessons`
--
ALTER TABLE `tbl_lessons`
  ADD CONSTRAINT `tbl_lessons_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_lessons_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `tbl_teachers` (`teacher_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  ADD CONSTRAINT `tbl_quiz_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `tbl_lessons` (`lesson_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_quizattempt`
--
ALTER TABLE `tbl_quizattempt`
  ADD CONSTRAINT `tbl_quizattempt_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `tbl_quiz` (`quiz_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_quizattempt_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `tbl_students` (`id`);

--
-- Constraints for table `tbl_quizquestions`
--
ALTER TABLE `tbl_quizquestions`
  ADD CONSTRAINT `tbl_quizquestions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `tbl_quiz` (`quiz_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_quizresponses`
--
ALTER TABLE `tbl_quizresponses`
  ADD CONSTRAINT `tbl_quizresponses_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `tbl_quiz` (`quiz_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_quizresponses_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `tbl_quizquestions` (`question_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_quizresponses_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `tbl_students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_section`
--
ALTER TABLE `tbl_section`
  ADD CONSTRAINT `tbl_section_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `tbl_teachers` (`teacher_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_studentclasses`
--
ALTER TABLE `tbl_studentclasses`
  ADD CONSTRAINT `tbl_studentclasses_ibfk_1` FOREIGN KEY (`section_name`) REFERENCES `tbl_section` (`section_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_studentclasses_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `tbl_students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
