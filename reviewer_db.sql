-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2023 at 07:16 AM
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
(4, 'CRIM-02A', 27),
(5, 'CRIM-02B', 27),
(6, 'CRIM-02B', 28);

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

--
-- Dumping data for table `tbl_comments`
--

INSERT INTO `tbl_comments` (`comment_id`, `material_id`, `user_id`, `teacher_id`, `comment`, `date`) VALUES
(12, 19, '02-1234-5678', '02-1920-03954', 'alert(1)', '2023-11-24 11:15:28');

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
(19, 27, 'INTRODUCTION TO LAW ENFORCEMENT ADMINISTRATION Chapter 1', 'INTRODUCTION TO LAW ENFORCEMENT ADMINISTRATION Chapter 1', '24112023031917.pdf', '24112023031917.png', '2023-11-24', 'active'),
(20, 27, 'INTRODUCTION TO LAW ENFORCEMENT ADMINISTRATION Chapter 2', 'INTRODUCTION TO LAW ENFORCEMENT ADMINISTRATION Chapter 2', '19122023052729.pdf', '19122023052729.png', '2023-12-19', 'active');

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
(27, 2, '02-1920-03954', 'INTRODUCTION TO LAW ENFORCEMENT ADMINISTRATION Chapter 1', 'INTRODUCTION TO LAW ENFORCEMENT ADMINISTRATION', '24112023031707.png', '2023-11-24', 'active'),
(28, 2, '02-1920-03954', 'INTRODUCTION TO LAW ENFORCEMENT ADMINISTRATION Chapter 2', 'INTRODUCTION TO LAW ENFORCEMENT ADMINISTRATION Chapter 2', '27112023040911.png', '2023-11-27', 'active');

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
  `retryAfter` int(11) NOT NULL,
  `quiz_created` datetime NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_quiz`
--

INSERT INTO `tbl_quiz` (`quiz_id`, `lesson_id`, `status`, `quiz_title`, `quiz_description`, `quiz_type`, `retryAfter`, `quiz_created`, `last_updated`) VALUES
(1, 27, 'active', 'INTRODUCTION TO LAW ENFORCEMENT ADMINISTRATION Chapter 1 PRE-TEST', 'Do you love newjeans?', 'pre-test', 7200, '2023-12-18 18:20:09', '2023-12-25 10:25:53'),
(4, 27, 'active', 'INTRODUCTION TO NEW JEANS POST-TEST', 'INTRODUCTION TO NEW JEANS Chapter 1 POST-TEST', 'post-test', 10800, '2023-12-19 13:33:26', '2023-12-26 13:08:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quizattempt`
--

CREATE TABLE `tbl_quizattempt` (
  `attempt_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `attempt_status` varchar(50) NOT NULL,
  `attempt_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_quizattempt`
--

INSERT INTO `tbl_quizattempt` (`attempt_id`, `quiz_id`, `student_id`, `attempt_status`, `attempt_score`) VALUES
(26, 4, '02-1234-5678', 'completed', 1);

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
(30, 4, 'Is Minji Cute?', 'Yes', 'No', 'Maybe', 'I don&#39;t know', 'Yes'),
(31, 4, 'Who is Paul&#39;s bias in New Jeans?', 'Hanni Pham', 'Minji Kim', 'Danielle Marsh', 'Haerin Kang', 'Hanni Pham'),
(32, 4, 'Who has the representative color of yellow?', 'Hanni Pham', 'Minji Kim', 'Danielle Marsh', 'Haerin Kang', 'Minji Kim'),
(33, 4, 'If given a chance, Who would like to go out on a date with?', 'Hanni Pham', 'Minji Kim', 'Danielle Marsh', 'Haerin Kang', 'Minji Kim'),
(35, 4, 'What is Hye In&#39;s lastname?', 'Park', 'Kim', 'Hyun', 'Lee', 'Lee'),
(36, 4, 'What is Minji&#39;s lastname?', 'Park', 'Kim', 'Hyun', 'Lee', 'Kim'),
(37, 4, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Park', 'Kim', 'Hyun', 'Lee', 'Hyun');

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
(109, 4, 33, '02-1234-5678', 'Minji Kim'),
(110, 4, 32, '02-1234-5678', ''),
(111, 4, 31, '02-1234-5678', ''),
(112, 4, 37, '02-1234-5678', ''),
(113, 4, 30, '02-1234-5678', ''),
(114, 4, 35, '02-1234-5678', ''),
(115, 4, 36, '02-1234-5678', '');

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
('CRIM-02A', '02-1920-03954'),
('CRIM-02B', '02-1920-03954');

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
(3, 'CRIM-02A', '02-1234-5678'),
(4, 'CRIM-02A', '02-1718-01059');

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
('02-1234-5678', 'Dominic', 'Kionisala', 'Male', 'domskie@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '653bcd1503a85.png', 'active'),
('02-1718-01059', 'Dexter', 'Maghanoy', 'Male', 'depa.maghanoy.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'dexter.jpg', 'active'),
('12-4567-89012', 'Hanni', 'Pham', 'female', 'hannipham@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'default.png', 'active'),
('34-9012-34567', 'Min Ji', 'Kim', 'female', 'minjikim@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd9', 'default.png', 'active'),
('56-7890-12345', 'Danielle', 'Marsh', 'female', 'danielle_marsh@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd10', 'default.png', 'active'),
('78-2345-67890', 'Haerin', 'Kang', 'female', 'kang.haerin@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd11', 'default.png', 'active'),
('90-2109-87654', 'Jihyo', 'Park', 'female', 'god_jihyo@koreaboo.net', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd21', 'default.png', 'active'),
('90-2345-67890', 'Nayeon', 'Im', 'female', 'nayeon_@rocketmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd15', 'default.png', 'active'),
('90-3456-78901', 'Mina', 'Myoui', 'female', 'mina@mail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd17', 'default.png', 'active'),
('90-4321-09876', 'Tzuyu', 'Chou', 'female', 'tzuyucute_@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd19', 'default.png', 'active'),
('90-5678-12345', 'Sana', 'Minatozaki', 'female', 'sanaminatozaki@example.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd13', 'default.png', 'active'),
('90-6543-21098', 'Momo', 'Hirai', 'female', 'momo_hirai@japanesemail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd18', 'default.png', 'active'),
('90-6789-01234', 'Hye In', 'Lee', 'female', 'gracelee@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd12', 'default.png', 'active'),
('90-7890-12345', 'Chaeyoung', 'Son', 'female', 'chae@mail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd20', 'default.png', 'active'),
('90-8765-43210', 'Jeongyeon', 'Yoo', 'female', 'jeongyeon.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd16', 'default.png', 'active'),
('90-9876-54321', 'Dahyun', 'Kim', 'female', 'dahyunkim@example.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd14', 'default.png', 'active');

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
('02-2324-03959', 'Hye In', 'Lee', 'Female', 'hyel.lee.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

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
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_classlessons`
--
ALTER TABLE `tbl_classlessons`
  MODIFY `classlesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_learningmaterials`
--
ALTER TABLE `tbl_learningmaterials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_lessons`
--
ALTER TABLE `tbl_lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_quizattempt`
--
ALTER TABLE `tbl_quizattempt`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_quizquestions`
--
ALTER TABLE `tbl_quizquestions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_quizresponses`
--
ALTER TABLE `tbl_quizresponses`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `tbl_studentclasses`
--
ALTER TABLE `tbl_studentclasses`
  MODIFY `primaryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

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
  ADD CONSTRAINT `tbl_comments_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `tbl_learningmaterials` (`material_id`),
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
