-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2016 at 09:06 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `image` varchar(150) NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`, `image`) VALUES
(2, 'Duncan Muthami', 'Duncan', 'Duncan', '82f4acbc70e0f895c6a49aa85df8807798fb4fcc1460120566.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE IF NOT EXISTS `assignments` (
`id` int(11) NOT NULL,
  `assignmentName` varchar(50) NOT NULL,
  `courseId` int(11) NOT NULL,
  `unitCode` varchar(50) NOT NULL,
  `teacherId` int(11) NOT NULL,
  `filePath` varchar(150) NOT NULL,
  `dateSubmitted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateDue` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `assignmentName`, `courseId`, `unitCode`, `teacherId`, `filePath`, `dateSubmitted`, `dateDue`) VALUES
(4, 'Take Away ', 1, 'BIT4431', 3, 'GPM - Vol.2.pdf', '2016-04-08 16:46:23', '2016-04-29 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
`id` int(11) NOT NULL,
  `CourseCode` varchar(10) NOT NULL,
  `CourseName` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `CourseCode`, `CourseName`) VALUES
(1, 'BIT', 'Bsc. INFORMATION TECHNOLOGY '),
(2, 'CSC', 'Bsc. COMPUTER SCIENCE'),
(3, 'HRM', 'HUMAN RESOURCE MANAGEMENT'),
(4, 'WW', 'WOOD WORK');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE IF NOT EXISTS `materials` (
`id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `url` varchar(150) NOT NULL,
  `courseId` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
`id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `recepient` int(11) NOT NULL,
  `message` text NOT NULL,
  `readStatus` tinyint(1) NOT NULL DEFAULT '0',
  `dateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender`, `recepient`, `message`, `readStatus`, `dateCreated`) VALUES
(23, 10, 11, 'Hi,hope you are doing fine', 0, '2016-04-08 17:40:49'),
(25, 10, 13, 'Hi', 0, '2016-04-11 09:48:18');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE IF NOT EXISTS `quiz` (
`id` int(11) NOT NULL,
  `quizName` varchar(50) NOT NULL,
  `courseId` int(11) NOT NULL,
  `unitCode` varchar(50) NOT NULL,
  `teacherId` int(11) NOT NULL,
  `filePath` varchar(150) NOT NULL,
  `dateSubmitted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateDue` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `quizName`, `courseId`, `unitCode`, `teacherId`, `filePath`, `dateSubmitted`, `dateDue`) VALUES
(9, 'CAT 1', 1, 'BIT4431', 3, 'GUIDEMasteringProcurement.pdf', '2016-04-08 17:06:01', '2016-04-28 00:00:00'),
(10, 'CAT2', 1, 'BIT4431', 3, 'it_3.pdf', '2016-04-08 17:10:31', '2016-04-21 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
`id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `username` varchar(40) NOT NULL,
  `gender` enum('MALE','FEMALE') NOT NULL,
  `course` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `coursePeriod` int(11) NOT NULL,
  `dateRegistered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `fname`, `lname`, `password`, `username`, `gender`, `course`, `location`, `coursePeriod`, `dateRegistered`, `image`) VALUES
(10, 'Dismus', 'Kiplimo', 'Dis', 'Dis', 'MALE', '1', 'Nairobi', 8, '2016-04-08 15:52:06', '43a9944b8dfb3252def544c8134bfd78d4fed43c1460405172.jpg'),
(11, 'Kristine', 'Wambui', 'Kristine', 'Kristine', 'MALE', '3', 'Kenya', 8, '2016-04-08 16:20:11', 'f08bef9cb79a526d113cfaee782ffd3f11482aff1460121611.jpg'),
(12, 'Jelimo', 'Kiptai', 'Jelimo', 'Jelimo', 'FEMALE', '2', 'S.Africa', 8, '2016-04-08 16:23:14', '2f1432a53b3476dfe79f0a9654b3c2491c48a4811460121794.jpg'),
(13, 'Katalina', 'Alycia', 'Katalina', 'Katalina', 'FEMALE', '4', 'United States', 4, '2016-04-08 16:26:17', '9764a661428702e9b599024ed6dc011b268d70a51460121977.jpg'),
(14, 'Jimmy', 'Moses', 'Jimmy', 'Jimmy', 'MALE', '1', 'South Africa', 6, '2016-04-10 20:41:50', 'ee8641a76cfc871d2a8800301a88cbeb7d9872e51460312723.jpg'),
(15, 'Ruth', 'Wambui', 'Ruth', 'Ruth', 'FEMALE', '3', 'United States', 8, '2016-04-10 22:20:22', '2d37d6968796c2998ce16ea31c55fd5c2c3826931460316022.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `submittedassignments`
--

CREATE TABLE IF NOT EXISTS `submittedassignments` (
`id` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `teacherId` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `marks` int(11) NOT NULL,
  `status` enum('MARKED','UNMARKED') DEFAULT 'UNMARKED',
  `dateSubmitted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fileUrl` varchar(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `submittedassignments`
--

INSERT INTO `submittedassignments` (`id`, `studentId`, `courseId`, `teacherId`, `name`, `marks`, `status`, `dateSubmitted`, `fileUrl`) VALUES
(2, 10, 1, 3, '(BIT4431) Take Away ', 20, 'MARKED', '2016-04-08 16:57:23', 'gpr-94_e.pdf'),
(3, 10, 1, 3, '(BIT4431) Take Away ', 0, 'UNMARKED', '2016-04-08 17:44:01', 'Management Assignment.docx');

-- --------------------------------------------------------

--
-- Table structure for table `submittedquiz`
--

CREATE TABLE IF NOT EXISTS `submittedquiz` (
`id` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `teacherId` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `marks` int(11) NOT NULL,
  `status` enum('MARKED','UNMARKED') DEFAULT 'UNMARKED',
  `dateSubmitted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fileUrl` varchar(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `submittedquiz`
--

INSERT INTO `submittedquiz` (`id`, `studentId`, `courseId`, `teacherId`, `name`, `marks`, `status`, `dateSubmitted`, `fileUrl`) VALUES
(3, 10, 1, 3, '(BIT4431) CAT 1', 0, 'UNMARKED', '2016-04-08 17:15:10', 'resource1.pdf'),
(4, 10, 1, 3, '(BIT4431) CAT 1', 0, 'UNMARKED', '2016-04-08 17:16:46', 'ASC-075287668-3030-01.pdf'),
(5, 10, 1, 3, '(BIT4431) CAT2', 26, 'MARKED', '2016-04-08 17:18:14', 'Food-Plan-2014-FINAL.pdf'),
(6, 10, 1, 3, '(BIT4431) CAT 1', 25, 'MARKED', '2016-04-08 17:20:04', 'foodbeverage.pdf'),
(7, 10, 1, 3, '(BIT4431) CAT2', 29, 'MARKED', '2016-04-08 17:21:42', 'Prototype.docx'),
(8, 10, 1, 3, '(BIT4431) CAT2', 21, 'MARKED', '2016-04-08 17:22:09', 'Audit Assignment..docx');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
`id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `gender` enum('MALE','FEMALE') NOT NULL DEFAULT 'MALE',
  `courseToTeach` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` enum('VERIFIED','UNVERIFIED') NOT NULL DEFAULT 'UNVERIFIED',
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `fname`, `lname`, `gender`, `courseToTeach`, `title`, `username`, `password`, `status`, `image`) VALUES
(3, 'Alycia', 'Crews', 'FEMALE', 1, 'Prof', 'Alycia', 'Alycia', 'VERIFIED', 'c8a73040680ad285f87853daaaa4c90db15bcb981460120366.jpg'),
(4, 'Bonnie', 'Villa', 'FEMALE', 2, 'Doctor', 'Bonnie', 'Bonnie', 'VERIFIED', '7c190451cd74c24c5e2b2c52a249047bc9da310c1460120782.jpg'),
(5, 'Cassandra', 'Palmer', 'FEMALE', 3, 'Prof', 'Cassandra', 'Cassandra', 'VERIFIED', 'a597b82e06a51a6bf2f15f727425a35d6c50a0401460120894.jpg'),
(6, 'Celestine', 'Emer', 'FEMALE', 4, 'Prof', 'Celestine', 'Emer', 'UNVERIFIED', 'ac3c22e1b85b80b10f9bebeeeda6d1dddeadd8c31460122184.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE IF NOT EXISTS `units` (
`id` int(11) NOT NULL,
  `unitCode` varchar(10) NOT NULL,
  `unitName` varchar(50) NOT NULL,
  `courseId` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unitCode`, `unitName`, `courseId`) VALUES
(1, 'BIT4431', 'MICROECONOMICS', 1),
(2, 'DEVELOPMEN', 'HRM 211', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submittedassignments`
--
ALTER TABLE `submittedassignments`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submittedquiz`
--
ALTER TABLE `submittedquiz`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `submittedassignments`
--
ALTER TABLE `submittedassignments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `submittedquiz`
--
ALTER TABLE `submittedquiz`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
