-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2017 at 06:19 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gradeserverplus`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignmentId` int(20) NOT NULL,
  `max_score` int(20) NOT NULL,
  `weight` int(20) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignmentId`, `max_score`, `weight`, `name`) VALUES
(1, 100, 50, 'exam1'),
(3, 100, 50, 'exam2'),
(4, 100, 40, 'exam1'),
(5, 100, 60, 'exam2');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courseId` int(20) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`courseId`, `name`) VALUES
(2, 'CMSC389N'),
(6, 'CMSC216');

-- --------------------------------------------------------

--
-- Table structure for table `course_assignments`
--

CREATE TABLE `course_assignments` (
  `id` int(11) NOT NULL,
  `courseId` int(20) NOT NULL,
  `assignmentId` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `course_assignments`
--

INSERT INTO `course_assignments` (`id`, `courseId`, `assignmentId`) VALUES
(1, 2, 1),
(2, 2, 3),
(3, 6, 4),
(4, 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `userId` int(20) NOT NULL,
  `assignmentId` int(20) NOT NULL,
  `score` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `userId`, `assignmentId`, `score`) VALUES
(1, 1, 1, 60),
(2, 1, 3, 60),
(3, 2, 4, 60),
(4, 2, 5, 70),
(5, 3, 1, 10),
(6, 3, 3, 20),
(7, 3, 4, 100),
(8, 4, 4, 40),
(9, 4, 5, 100),
(10, 5, 4, 75),
(11, 5, 5, 80),
(12, 6, 4, 90),
(13, 6, 5, 75),
(14, 7, 4, 100),
(15, 7, 5, 82),
(16, 8, 4, 34),
(17, 8, 5, 45),
(18, 9, 4, 65),
(19, 9, 5, 62),
(20, 10, 4, 72),
(21, 10, 5, 78);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `image` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `name`, `password`, `image`) VALUES
(1, 'a', '0cc175b9c0f1b6a831c399e269772661', ''),
(2, 'b', '92eb5ffee6ae2fec3ad71c777531578f', ''),
(3, 'c', '4a8a08f09d37b73795649038408b5f33', ''),
(4, 'd', '8277e0910d750195b448797616e091ad', ''),
(5, 'e', 'e1671797c52e15f763380b45e841ec32', ''),
(6, 'f', '8fa14cdd754f91cc6554c9e71929cce7', ''),
(7, 'g', 'b2f5ff47436671b6e533d8dc3614845d', ''),
(8, 'h', '2510c39011c5be704182423e3a695e91', ''),
(9, 'i', '865c0c0b4ab0e063e5caa3387c1a8741', ''),
(10, 'j', '363b122c528f54df4a0446b6bab05515', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int(11) NOT NULL,
  `userId` int(20) NOT NULL,
  `courseId` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user_courses`
--

INSERT INTO `user_courses` (`id`, `userId`, `courseId`) VALUES
(1, 1, 2),
(2, 2, 2),
(3, 2, 6),
(4, 3, 2),
(5, 3, 6),
(6, 4, 6),
(7, 5, 6),
(8, 6, 6),
(9, 7, 6),
(10, 8, 6),
(11, 9, 6),
(12, 10, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignmentId`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`courseId`);

--
-- Indexes for table `course_assignments`
--
ALTER TABLE `course_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courseId` (`courseId`),
  ADD KEY `assignmentId` (`assignmentId`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `assignmentId` (`assignmentId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `courseId` (`courseId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignmentId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `courseId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `course_assignments`
--
ALTER TABLE `course_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_assignments`
--
ALTER TABLE `course_assignments`
  ADD CONSTRAINT `course_assignments_ibfk_1` FOREIGN KEY (`courseId`) REFERENCES `courses` (`courseId`),
  ADD CONSTRAINT `course_assignments_ibfk_2` FOREIGN KEY (`assignmentId`) REFERENCES `assignments` (`assignmentId`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`assignmentId`) REFERENCES `assignments` (`assignmentId`),
  ADD CONSTRAINT `grades_ibfk_3` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

--
-- Constraints for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD CONSTRAINT `user_courses_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `user_courses_ibfk_2` FOREIGN KEY (`courseId`) REFERENCES `courses` (`courseId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
