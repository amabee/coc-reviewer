-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2024 at 12:51 PM
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
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_audit`
--

INSERT INTO `tbl_audit` (`id`, `action`, `table_name`, `log_message`, `student_id`, `teacher_id`, `admin_id`, `dean_id`, `ph_id`, `timestamp`) VALUES
(70, 'Update', 'tbl_teachers', 'Changed status from \'active\' to \'inactive\'', NULL, '02-2324-03958', '0101-5552-4177', NULL, NULL, '2024-01-12 08:07:01'),
(71, 'Update', 'tbl_teachers', 'Changed status from \'active\' to \'inactive\'', NULL, '02-2324-03957', '0101-5552-4177', NULL, NULL, '2024-01-12 08:07:03'),
(72, 'Update', 'tbl_teachers', 'Changed status from \'active\' to \'inactive\'', NULL, '02-2324-03956', '0101-5552-4177', NULL, NULL, '2024-01-12 08:07:05'),
(73, 'Update', 'tbl_teachers', 'Changed status from \'active\' to \'inactive\'', NULL, '02-2324-03955', '0101-5552-4177', NULL, NULL, '2024-01-12 08:07:06'),
(74, 'Update', 'tbl_teachers', 'Changed status from \'inactive\' to \'active\'', NULL, '02-2324-03955', '0101-5552-4177', NULL, NULL, '2024-01-12 08:07:13'),
(75, 'Update', 'tbl_teachers', 'Changed status from \'inactive\' to \'active\'', NULL, '02-2324-03956', '0101-5552-4177', NULL, NULL, '2024-01-12 08:07:14'),
(76, 'Update', 'tbl_teachers', 'Changed status from \'inactive\' to \'active\'', NULL, '02-2324-03957', '0101-5552-4177', NULL, NULL, '2024-01-12 08:07:16'),
(77, 'Update', 'tbl_teachers', 'Changed status from \'inactive\' to \'active\'', NULL, '02-2324-03958', '0101-5552-4177', NULL, NULL, '2024-01-12 08:07:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bookmark`
--

CREATE TABLE `tbl_bookmark` (
  `user_id` varchar(30) NOT NULL,
  `lesson_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(10, 'CRIM-02A', 31),
(11, 'CRIM-02B', 31);

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
('1920-2324-12345', 'Paul', 'Smith', 'Sho', 'Male', 'pssm.sho.coc@phinmaed.com', '', 'active');

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
(21, 31, 'Intro to lea chapter 1', 'Intro to lea chapter 1', '08012024171531.pdf', '08012024171531.jpg', '2024-01-09', 'active');

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
(31, 2, '02-1920-03954', 'Intro to lea', 'Intro to lea', '08012024073525.jpg', '2024-01-08', 'active');

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
(5, 31, 'active', 'Intro to lea Pre-test', 'wtf?', 'pre-test', 10, 5, 3600, '2024-01-08 14:35:47', '2024-01-08 18:00:22'),
(6, 31, 'active', 'Intro to lea Post-test', 'Intro to lea Post-test', 'post-test', 10, 5, 3600, '2024-01-08 14:40:54', '2024-01-08 18:02:05');

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
(42, 5, '02-1234-5678', 'completed', 1, 1),
(48, 6, '02-1234-5678', 'failed', 3, 1);

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
(38, 5, 'Why Minji?', 'Cute', 'Gorgeous', 'Nice', 'Sexy', 'Gorgeous'),
(39, 6, 'Is Minji Cute?', 'Yes', 'No', 'Maybe', 'Dunno', 'Yes'),
(40, 6, 'Who is newjeans&#39; leader?', 'Haerin', 'Hye In', 'Danielle', 'Minji', 'Minji'),
(41, 6, '1+1', '1', '2', '3', '4', '2'),
(42, 6, 'What is right?', 'Human Right', 'Direction', 'Correct', 'Opposite of Left', 'Direction'),
(43, 6, 'Is it possible to drink soda during coffee break?', 'Yes', 'No', 'Depends', 'Maybe', 'Maybe'),
(44, 6, 'Can you take dinner in a lunchbox?', 'Yes', 'No', 'Maybe', 'Dunno', 'Yes'),
(45, 6, 'If the poison expires, is it still poisonous?', 'No', 'Maybe', 'Yes', 'HAHA DUNNO', 'HAHA DUNNO'),
(46, 6, '5*5', '4', '25', '20', '10', '25'),
(47, 6, 'Who is paul&#39;s bias in newjeans?', 'Hanni', 'Minji', 'Haerin', 'Danielle', 'Minji'),
(48, 6, 'Last name of newjeans&#39;s Hanni?', 'Park', 'Kim', 'Pham', 'Ngoc', 'Pham'),
(49, 6, 'Who is newjeans&#39;s maknae?', 'Haerin', 'Hye In', 'Hanni', 'Danielle', 'Hye In');

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
(123, 5, 38, '02-1234-5678', 'Cute'),
(124, 5, 38, '02-1234-5678', 'Gorgeous'),
(125, 5, 38, '02-1234-5678', 'Gorgeous'),
(126, 6, 39, '02-1234-5678', 'Yes'),
(127, 6, 46, '02-1234-5678', '25'),
(128, 6, 47, '02-1234-5678', 'Minji'),
(129, 6, 48, '02-1234-5678', 'Pham'),
(130, 6, 43, '02-1234-5678', 'Depends'),
(131, 6, 42, '02-1234-5678', 'Human Right'),
(132, 6, 49, '02-1234-5678', 'Hanni'),
(133, 6, 40, '02-1234-5678', 'Danielle'),
(134, 6, 45, '02-1234-5678', 'HAHA DUNNO'),
(135, 6, 44, '02-1234-5678', 'No'),
(136, 6, 46, '02-1234-5678', '10'),
(137, 6, 40, '02-1234-5678', 'Hye In'),
(138, 6, 45, '02-1234-5678', 'Yes'),
(139, 6, 41, '02-1234-5678', '2'),
(140, 6, 39, '02-1234-5678', 'Dunno'),
(141, 6, 49, '02-1234-5678', 'Hye In'),
(142, 6, 47, '02-1234-5678', 'Hanni'),
(143, 6, 44, '02-1234-5678', 'No'),
(144, 6, 42, '02-1234-5678', 'Opposite of Left'),
(145, 6, 43, '02-1234-5678', 'Depends'),
(146, 6, 39, '02-1234-5678', 'Yes'),
(147, 6, 48, '02-1234-5678', 'Pham'),
(148, 6, 40, '02-1234-5678', 'Hye In'),
(149, 6, 47, '02-1234-5678', 'Danielle'),
(150, 6, 42, '02-1234-5678', 'Human Right'),
(151, 6, 44, '02-1234-5678', 'Dunno'),
(152, 6, 46, '02-1234-5678', '25'),
(153, 6, 49, '02-1234-5678', 'Haerin'),
(154, 6, 41, '02-1234-5678', '4'),
(155, 6, 43, '02-1234-5678', 'Yes'),
(156, 6, 42, '02-1234-5678', 'Opposite of Left'),
(157, 6, 47, '02-1234-5678', 'Minji'),
(158, 6, 44, '02-1234-5678', 'Dunno'),
(159, 6, 49, '02-1234-5678', 'Danielle'),
(160, 6, 39, '02-1234-5678', 'Dunno'),
(161, 6, 46, '02-1234-5678', '10'),
(162, 6, 45, '02-1234-5678', 'HAHA DUNNO'),
(163, 6, 41, '02-1234-5678', '4'),
(164, 6, 43, '02-1234-5678', 'Maybe'),
(165, 6, 48, '02-1234-5678', 'Ngoc'),
(166, 6, 40, '02-1234-5678', 'Minji'),
(167, 6, 43, '02-1234-5678', 'Maybe'),
(168, 6, 48, '02-1234-5678', 'Ngoc'),
(169, 6, 41, '02-1234-5678', '4'),
(170, 6, 39, '02-1234-5678', 'Dunno'),
(171, 6, 46, '02-1234-5678', '10'),
(172, 6, 42, '02-1234-5678', 'Opposite of Left'),
(173, 6, 45, '02-1234-5678', 'HAHA DUNNO'),
(174, 6, 49, '02-1234-5678', 'Danielle'),
(175, 6, 44, '02-1234-5678', 'Dunno'),
(176, 6, 44, '02-1234-5678', 'Dunno'),
(177, 6, 43, '02-1234-5678', 'Maybe'),
(178, 6, 48, '02-1234-5678', 'Ngoc'),
(179, 6, 47, '02-1234-5678', 'Danielle'),
(180, 6, 49, '02-1234-5678', 'Danielle'),
(181, 6, 39, '02-1234-5678', 'Dunno'),
(182, 6, 41, '02-1234-5678', '4'),
(183, 6, 45, '02-1234-5678', 'HAHA DUNNO'),
(184, 6, 42, '02-1234-5678', 'Opposite of Left'),
(185, 6, 46, '02-1234-5678', '10'),
(186, 6, 43, '02-1234-5678', 'Maybe'),
(187, 6, 44, '02-1234-5678', 'Dunno'),
(188, 6, 42, '02-1234-5678', 'Opposite of Left'),
(189, 6, 49, '02-1234-5678', 'Danielle'),
(190, 6, 40, '02-1234-5678', 'Hye In'),
(191, 6, 39, '02-1234-5678', 'Dunno'),
(192, 6, 45, '02-1234-5678', 'HAHA DUNNO'),
(193, 6, 46, '02-1234-5678', '10'),
(194, 6, 41, '02-1234-5678', '4'),
(195, 6, 47, '02-1234-5678', 'Danielle'),
(196, 5, 38, '02-1234-5678', 'Gorgeous'),
(197, 5, 38, '02-1234-5678', 'Gorgeous'),
(198, 5, 38, '02-1234-5678', 'Gorgeous'),
(199, 6, 41, '02-1234-5678', '2'),
(200, 6, 43, '02-1234-5678', 'Yes'),
(201, 6, 45, '02-1234-5678', 'HAHA DUNNO'),
(202, 6, 39, '02-1234-5678', 'Yes'),
(203, 6, 49, '02-1234-5678', 'Hye In'),
(204, 6, 47, '02-1234-5678', 'Minji'),
(205, 6, 46, '02-1234-5678', '25'),
(206, 6, 44, '02-1234-5678', 'Yes'),
(207, 6, 40, '02-1234-5678', 'Minji'),
(208, 6, 42, '02-1234-5678', 'Direction'),
(209, 5, 38, '02-1234-5678', 'Gorgeous'),
(210, 6, 45, '02-1234-5678', 'Maybe'),
(211, 6, 40, '02-1234-5678', 'Minji'),
(212, 6, 44, '02-1234-5678', 'Dunno'),
(213, 6, 48, '02-1234-5678', 'Ngoc'),
(214, 6, 39, '02-1234-5678', 'Dunno'),
(215, 6, 43, '02-1234-5678', 'Maybe'),
(216, 6, 47, '02-1234-5678', 'Danielle'),
(217, 6, 41, '02-1234-5678', '3'),
(218, 6, 46, '02-1234-5678', '4'),
(219, 6, 49, '02-1234-5678', 'Hye In'),
(220, 6, 44, '02-1234-5678', 'Dunno'),
(221, 6, 47, '02-1234-5678', 'Danielle'),
(222, 6, 40, '02-1234-5678', 'Minji'),
(223, 6, 41, '02-1234-5678', '4'),
(224, 6, 49, '02-1234-5678', 'Hanni'),
(225, 6, 42, '02-1234-5678', 'Direction'),
(226, 6, 46, '02-1234-5678', '4'),
(227, 6, 45, '02-1234-5678', 'HAHA DUNNO'),
(228, 6, 48, '02-1234-5678', 'Pham'),
(229, 6, 39, '02-1234-5678', 'Yes'),
(230, 6, 42, '02-1234-5678', 'Human Right'),
(231, 6, 40, '02-1234-5678', 'Haerin'),
(232, 6, 48, '02-1234-5678', 'Kim'),
(233, 6, 41, '02-1234-5678', '2'),
(234, 6, 44, '02-1234-5678', 'Maybe'),
(235, 6, 43, '02-1234-5678', 'Yes'),
(236, 6, 46, '02-1234-5678', '25'),
(237, 6, 47, '02-1234-5678', 'Danielle'),
(238, 6, 45, '02-1234-5678', 'HAHA DUNNO'),
(239, 6, 49, '02-1234-5678', 'Hanni'),
(240, 6, 46, '02-1234-5678', '10'),
(241, 6, 43, '02-1234-5678', 'Depends'),
(242, 6, 41, '02-1234-5678', '4'),
(243, 6, 49, '02-1234-5678', 'Hanni'),
(244, 6, 45, '02-1234-5678', 'HAHA DUNNO'),
(245, 6, 44, '02-1234-5678', 'Maybe'),
(246, 6, 47, '02-1234-5678', 'Minji'),
(247, 6, 42, '02-1234-5678', 'Opposite of Left'),
(248, 6, 39, '02-1234-5678', 'Yes'),
(249, 6, 40, '02-1234-5678', 'Danielle'),
(250, 6, 49, '02-1234-5678', 'Haerin'),
(251, 6, 44, '02-1234-5678', 'Dunno'),
(252, 6, 48, '02-1234-5678', 'Ngoc'),
(253, 6, 43, '02-1234-5678', 'Maybe'),
(254, 6, 41, '02-1234-5678', '2'),
(255, 6, 42, '02-1234-5678', 'Correct'),
(256, 6, 45, '02-1234-5678', 'Yes'),
(257, 6, 47, '02-1234-5678', 'Danielle'),
(258, 6, 40, '02-1234-5678', 'Danielle'),
(259, 6, 46, '02-1234-5678', '10'),
(260, 6, 43, '02-1234-5678', 'Maybe'),
(261, 6, 47, '02-1234-5678', 'Haerin'),
(262, 6, 49, '02-1234-5678', 'Hanni'),
(263, 6, 46, '02-1234-5678', '10'),
(264, 6, 44, '02-1234-5678', 'Dunno'),
(265, 6, 40, '02-1234-5678', 'Minji'),
(266, 6, 45, '02-1234-5678', 'HAHA DUNNO'),
(267, 6, 42, '02-1234-5678', 'Opposite of Left'),
(268, 6, 39, '02-1234-5678', 'Dunno'),
(269, 6, 41, '02-1234-5678', '3');

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
('CRIM-02A', '02-1920-03954'),
('CRIM-02B', '02-1920-03954'),
('CRIM-02D', '02-2324-03955'),
('Advance Class', '02-2324-03956'),
('CRIM-02C', '02-2324-03956'),
('CRIM-02E', '02-2324-03957'),
('CRIM-02F', '02-2324-03959');

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
(4, 'CRIM-02A', '02-1718-01059'),
(5, 'CRIM-02A', '02-1234-5678');

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
('02-1234-5678', 'Dominic', 'Kionisala', 'male', 'doen.kionisala.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '653bcd1503a85.png', 'active'),
('02-1718-01059', 'Dexter', 'Maghanoy', 'male', 'depa.maghanoy.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'dexter.jpg', 'active'),
('02-1920-03955', 'Hanni', 'Pham', 'Female', 'hanni_pham@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'default.png', 'active'),
('02-1920-03956', 'Minji', 'Kim', 'Female', 'minji.kim@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'default.png', 'active'),
('02-1920-03957', 'Kang', 'Haerin', 'Female', 'haerin_kang@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'default.png', 'active'),
('02-1920-03958', 'Danielle', 'Marsh', 'Female', 'marsh_danielle@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'default.png', 'active'),
('02-1920-03959', 'Hye In', 'Lee', 'Female', 'leehyein.nj@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'default.png', 'active'),
('02-1920-03960', 'Sana', 'Minatozaki', 'Female', 'sana_ke@rocketmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'default.png', 'active'),
('02-1920-03962', 'Da Hyun', 'Kim', 'Female', 'dahyunaaa@koreaboo.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'default.png', 'active');

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
('02-1920-03952', 'Shan', 'Gorra', 'Male', 'shma.gorra.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', 'nj.jpg'),
('02-1920-03954', 'John Paul', 'Orencio', 'Male', 'joda.orencio.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', 'nj.jpg'),
('02-2324-03955', 'Hanni', 'Pham', 'Female', 'hanp.pham.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', 'default.png'),
('02-2324-03956', 'Danielle', 'Marsh', 'Female', 'danm.marsh.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', 'default.png'),
('02-2324-03957', 'Min Ji', 'Kim', 'Female', 'mink.kim.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', 'default.png'),
('02-2324-03958', 'Haerin', 'Kang', 'Female', 'haek.kang.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', 'default.png'),
('02-2324-03959', 'Hye In', 'Lee', 'Female', 'hyel.lee.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', 'default.png'),
('14512312', 'Kazuma', 'Nakamura', 'female', 'nakamura_kazuha@japanmail.com', '$2y$10$yTi5vyA4QU2qlZTMI/TqxOYpZnIFUtzlzqdCglcRvXSNKiJY.xive', 'active', ''),
('2425-8559-99852', 'Eun Chae', 'Hong', 'female', 'eun.chae@gmail.com', '$2y$10$dET8hx2s8l7i0lTGrTqp8.kMrN5JBCFWN94jqbpcmWFTY.USOrw8G', 'active', 'default.png'),
('29928', 'Da Hyun', 'Kim', 'female', 'kim_dahyun@rocketmail.com', '$2y$10$1YvuSAt1.gLTAcYkCvzzuO04VrPlZd2PQ2SN9pRw5vJkqBBaUkGAe', 'active', ''),
('789987', 'Chae Won', 'Kim', 'female', 'kimmy_chae@koreaboo.net', '$2y$10$IT1S1HnJ75UdM36EpVboBe/ynxoX5V.X1p0XColxb95IPQ84JewHy', 'active', 'default.png'),
('900', 'Yunjin', 'Huh', 'female', 'ynjin_lesserafim@gmail.com', '$2y$10$PlyTR4PEgaXGIK/x.IzJE.Bf6xQbL1D/9VX0kwcbja5TvdvIgJ1gm', 'active', '');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `dean_id` (`dean_id`),
  ADD KEY `ph_id` (`ph_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `teacher_id` (`teacher_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_classlessons`
--
ALTER TABLE `tbl_classlessons`
  MODIFY `classlesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_learningmaterials`
--
ALTER TABLE `tbl_learningmaterials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_lessons`
--
ALTER TABLE `tbl_lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_quizattempt`
--
ALTER TABLE `tbl_quizattempt`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_quizquestions`
--
ALTER TABLE `tbl_quizquestions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tbl_quizresponses`
--
ALTER TABLE `tbl_quizresponses`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT for table `tbl_studentclasses`
--
ALTER TABLE `tbl_studentclasses`
  MODIFY `primaryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_audit`
--
ALTER TABLE `tbl_audit`
  ADD CONSTRAINT `tbl_audit_ibfk_1` FOREIGN KEY (`dean_id`) REFERENCES `tbl_dean` (`dean_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_audit_ibfk_2` FOREIGN KEY (`ph_id`) REFERENCES `tbl_program_head` (`faculty_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_audit_ibfk_3` FOREIGN KEY (`admin_id`) REFERENCES `tbl_admin` (`admin_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_audit_ibfk_4` FOREIGN KEY (`teacher_id`) REFERENCES `tbl_teachers` (`teacher_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_audit_ibfk_5` FOREIGN KEY (`student_id`) REFERENCES `tbl_students` (`id`) ON DELETE CASCADE;

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
