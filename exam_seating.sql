-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 09:23 AM
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
-- Database: `exam_seating`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'sam', '56fafa8964024efa410773781a5f9e93');

-- --------------------------------------------------------

--
-- Table structure for table `allocations`
--

CREATE TABLE `allocations` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `column_number` int(11) NOT NULL,
  `seat_number` int(11) NOT NULL,
  `confirmed` tinyint(1) DEFAULT 0,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `floor_number` int(11) NOT NULL,
  `room_number` varchar(20) NOT NULL,
  `columns` int(11) NOT NULL,
  `seats_per_column` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `floor_number`, `room_number`, `columns`, `seats_per_column`) VALUES
(1, 1, '101', 3, 20),
(2, 1, '102', 3, 20),
(3, 1, '103', 2, 20),
(4, 2, '104', 3, 15),
(5, 2, '105', 3, 20),
(6, 2, '106', 3, 20),
(7, 3, '107', 2, 20),
(8, 3, '108', 3, 20),
(9, 3, '109', 3, 20),
(10, 3, '109', 3, 20);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `roll_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `subject`, `roll_number`) VALUES
(1, 'ABHI RAJU R', '', '1AY23AI001'),
(2, 'ABHILASH B V', '', '1AY23AI002'),
(3, 'ABHIRAG DAS', '', '1AY23AI003'),
(4, 'ABHISHEK KUMAR', '', '1AY23AI004'),
(5, 'ABRAHAM MARK SUNIL', '', '1AY23AI005'),
(6, 'ADARSH K N', '', '1AY23AI006'),
(7, 'ADITHYAN VIJAYAN', '', '1AY23AI008'),
(8, 'AISHWARYA T', '', '1AY23AI009'),
(9, 'AISHWARYA VANKE', '', '1AY23AI010'),
(10, 'AKSHAT DHIMAN', '', '1AY23AI011'),
(11, 'AMISHA K S', '', '1AY23AI012'),
(12, 'AMITH A S', '', '1AY23AI013'),
(13, 'ANAND RAJ', '', '1AY23AI014'),
(14, 'ANANTHA KRISHNA K', '', '1AY23AI015'),
(15, 'ANIRUDH HANCHATE', '', '1AY23AI016'),
(16, 'ANUGRAH KRISHNAA SREEJITH', '', '1AY23AI017'),
(17, 'APOORVA SHARMA', '', '1AY23AI018'),
(18, 'ARJUN V', '', '1AY23AI019'),
(19, 'AYUSH H MANE', '', '1AY23AI020'),
(20, 'B INDIRA', '', '1AY23AI021'),
(21, 'BALAJI SAGAR B S', '', '1AY23AI022'),
(22, 'BASAVARAJ RATHOD', '', '1AY23AI023'),
(23, 'BHARATH C N', '', '1AY23AI024'),
(24, 'BHARATH N', '', '1AY23AI025'),
(25, 'BHAVYA SRI GILAKALA', '', '1AY23AI026'),
(26, 'BHAVYASHREE S', '', '1AY23AI027'),
(27, 'BHOUMAN K', '', '1AY23AI028'),
(28, 'CHAITANYA', '', '1AY23AI029'),
(29, 'CHANDANA S B', '', '1AY23AI030'),
(30, 'CHANDRU S', '', '1AY23AI031'),
(31, 'CHARAN P', '', '1AY23AI032'),
(32, 'CHETHAN G S', '', '1AY23AI033'),
(33, 'CHINMAY BHARAMADE', '', '1AY23AI034'),
(34, 'DARSHAN REDDY C P', '', '1AY23AI035'),
(35, 'DHAIRYA SHARMA', '', '1AY23AI036'),
(36, 'DHANUSH S CHAPPARAD', '', '1AY23AI037'),
(37, 'FAZAL AHAMMED S', '', '1AY23AI038'),
(38, 'G VEERABHADRA', '', '1AY23AI039'),
(39, 'GIRISH SHRISHAIL ALADI', '', '1AY23AI040'),
(40, 'GOUTAM JITRI', '', '1AY23AI042'),
(41, 'GOWTHAM K S', '', '1AY23AI043'),
(42, 'H M SAMIKSHA', '', '1AY23AI044'),
(43, 'HARISH V', '', '1AY23AI045'),
(44, 'HARSH GUPTA', '', '1AY23AI046'),
(45, 'HARSHAVARDHAN S A NAIK', '', '1AY23AI047'),
(46, 'HIREMATH SHIV', '', '1AY23AI048'),
(47, 'INFANA A', '', '1AY23AI049'),
(48, 'ISHAL S', '', '1AY23AI050');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `name`) VALUES
(1, 'BCS401', 'ADA'),
(2, 'BAD402', 'AI'),
(3, 'BCS403', 'DBMS'),
(4, 'BCS405C', 'OT'),
(5, 'BCS405A', 'DMS'),
(6, 'BDSL56B', 'MongoDB'),
(7, 'BDSL56C', 'MERN');

-- --------------------------------------------------------

--
-- Table structure for table `subject_selections`
--

CREATE TABLE `subject_selections` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `allocations`
--
ALTER TABLE `allocations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roll_number` (`roll_number`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_selections`
--
ALTER TABLE `subject_selections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `allocations`
--
ALTER TABLE `allocations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=626;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `subject_selections`
--
ALTER TABLE `subject_selections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=586;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `allocations`
--
ALTER TABLE `allocations`
  ADD CONSTRAINT `allocations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `allocations_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `allocations_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `subject_selections`
--
ALTER TABLE `subject_selections`
  ADD CONSTRAINT `subject_selections_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `subject_selections_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
