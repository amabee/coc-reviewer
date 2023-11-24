-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2023 at 12:30 AM
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
(18, 16, 'INTRODUCTION TO LAW ENFORCEMENT ADMINISTRATION Chapter 1', 'INTRODUCTION TO LAW ENFORCEMENT ADMINISTRATION Chapter 1', '17112023123956.pdf', '17112023123956.jpg', '2023-11-17', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lessons`
--

CREATE TABLE `tbl_lessons` (
  `lesson_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `teacher_id` varchar(30) NOT NULL,
  `lesson_title` varchar(50) NOT NULL,
  `lesson_desc` varchar(1000) NOT NULL,
  `thumb` varchar(128) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_lessons`
--

INSERT INTO `tbl_lessons` (`lesson_id`, `category_id`, `teacher_id`, `lesson_title`, `lesson_desc`, `thumb`, `date`, `status`) VALUES
(16, 2, '02-1920-03954', 'INTRODUCTION TO LAW ENFORCEMENT ADMINISTRATION', 'INTRODUCTION TO LAW ENFORCEMENT ADMINISTRATION: A comprehensive guide to law enforcement administration.', '17112023123836.png', '2023-11-17', 'active');

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
  `student_id` varchar(50) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_studentclasses`
--

INSERT INTO `tbl_studentclasses` (`primaryID`, `section_name`, `student_id`, `lesson_id`, `material_id`) VALUES
(3, 'CRIM-02A', '02-1234-5678', 16, 18),
(4, 'CRIM-02A', '02-1718-01059', 16, 18);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE `tbl_students` (
  `id` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`id`, `firstname`, `lastname`, `email`, `password`, `image`) VALUES
('02-1234-5678', 'Dominic', 'Kionisala', 'domskie@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '653bcd1503a85.png'),
('02-1718-01059', 'Dexter', 'Maghanoy', 'depa.maghanoy.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'dexter.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teachers`
--

CREATE TABLE `tbl_teachers` (
  `teacher_id` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `active` varchar(30) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_teachers`
--

INSERT INTO `tbl_teachers` (`teacher_id`, `firstname`, `lastname`, `email`, `password`, `active`, `image`) VALUES
('02-1920-03952', 'Shan', 'Gorra', 'shma.gorra.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', 'nj.jpg'),
('02-1920-03954', 'John Paul', 'Orencio', 'joda.orencio.coc@phinmaed.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'active', 'nj.jpg');

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
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `material_id` (`material_id`);

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
  ADD KEY `student_id` (`student_id`),
  ADD KEY `lesson_id` (`lesson_id`),
  ADD KEY `material_id` (`material_id`);

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
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_learningmaterials`
--
ALTER TABLE `tbl_learningmaterials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_lessons`
--
ALTER TABLE `tbl_lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
-- Constraints for table `tbl_section`
--
ALTER TABLE `tbl_section`
  ADD CONSTRAINT `tbl_section_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `tbl_teachers` (`teacher_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_studentclasses`
--
ALTER TABLE `tbl_studentclasses`
  ADD CONSTRAINT `tbl_studentclasses_ibfk_1` FOREIGN KEY (`section_name`) REFERENCES `tbl_section` (`section_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_studentclasses_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `tbl_students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_studentclasses_ibfk_3` FOREIGN KEY (`lesson_id`) REFERENCES `tbl_lessons` (`lesson_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_studentclasses_ibfk_4` FOREIGN KEY (`material_id`) REFERENCES `tbl_learningmaterials` (`material_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
