-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2025 at 09:54 AM
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
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `updationDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `updationDate`) VALUES
(1, 'admin', 'admin123', '17-02-2025 01:40:50 PM');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `doctorSpecialization` varchar(255) DEFAULT NULL,
  `doctorId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `consultancyFees` int(11) DEFAULT NULL,
  `appointmentDate` varchar(255) DEFAULT NULL,
  `appointmentTime` varchar(255) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Completed','Cancelled') DEFAULT 'Pending',
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `visitStatus` enum('Visited','Not Visited','Pending') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `doctorSpecialization`, `doctorId`, `userId`, `consultancyFees`, `appointmentDate`, `appointmentTime`, `postingDate`, `status`, `updationDate`, `visitStatus`) VALUES
(78, 'Orthopedics', 12, 6, 150, '2025-02-20', '12:00 PM', '2025-02-17 08:32:34', 'Completed', '2025-02-17 08:33:15', 'Visited'),
(79, 'ENT', 13, 6, 150, '2025-02-25', '12:00 PM', '2025-02-17 08:34:34', 'Completed', '2025-02-17 08:35:42', 'Visited');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `specilization` varchar(255) DEFAULT NULL,
  `doctorName` varchar(255) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `docFees` varchar(255) DEFAULT NULL,
  `contactno` bigint(11) DEFAULT NULL,
  `docEmail` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `specilization`, `doctorName`, `address`, `docFees`, `contactno`, `docEmail`, `password`, `creationDate`, `updationDate`) VALUES
(12, 'Orthopedics', 'Aman sharma', 'pokharaa', '150', 9846582621, 'aman@gmail.com', 'bd00eb0f2a3ce174d021c6c7a6163eba', '2025-02-17 08:00:35', '2025-02-17 08:41:36'),
(13, 'ENT', 'krish subedi', 'pokahara', '150', 9846582621, 'krish@gmail.com', 'f673d9991a246dbce15d315e7716bc1f', '2025-02-17 08:14:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctorslog`
--

CREATE TABLE `doctorslog` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `userip` binary(16) DEFAULT NULL,
  `loginTime` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctorslog`
--

INSERT INTO `doctorslog` (`id`, `uid`, `username`, `userip`, `loginTime`, `logout`, `status`) VALUES
(30, NULL, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 08:24:16', NULL, 0),
(31, 8, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:22:26', NULL, 1),
(32, 8, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:44:45', '19-12-2024 03:14:46 PM', 1),
(33, NULL, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:50:17', NULL, 0),
(34, 9, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:56:55', NULL, 1),
(35, NULL, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 10:20:05', NULL, 0),
(36, NULL, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 10:20:27', NULL, 0),
(37, 8, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 10:20:35', NULL, 1),
(38, 8, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-20 10:27:41', NULL, 1),
(39, 8, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-20 10:35:51', NULL, 1),
(40, 8, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-20 10:36:02', NULL, 1),
(41, NULL, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-22 04:05:54', NULL, 0),
(42, 8, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-22 04:06:01', NULL, 1),
(43, 8, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-25 14:37:20', NULL, 1),
(44, 8, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-25 15:33:05', NULL, 1),
(45, 8, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-26 06:50:38', '26-12-2024 12:58:17 PM', 1),
(46, NULL, 'kisorsharmasubedi@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 07:52:23', NULL, 0),
(47, NULL, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 07:58:44', NULL, 0),
(48, 12, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 08:01:21', NULL, 1),
(49, 13, 'krish@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 08:21:20', NULL, 1),
(50, 12, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 08:31:36', '17-02-2025 02:04:39 PM', 1),
(51, 13, 'krish@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 08:34:56', NULL, 1),
(52, 12, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 08:40:44', '17-02-2025 02:11:04 PM', 1),
(53, 12, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 08:41:45', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctorspecilization`
--

CREATE TABLE `doctorspecilization` (
  `id` int(11) NOT NULL,
  `specilization` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctorspecilization`
--

INSERT INTO `doctorspecilization` (`id`, `specilization`, `creationDate`, `updationDate`) VALUES
(1, 'Orthopedics', '2024-04-09 18:09:46', '2024-05-14 09:26:47'),
(3, 'Obstetrics and Gynecology', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(4, 'Dermatology', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(5, 'Pediatrics', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(6, 'Radiology', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(7, 'General Surgery', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(8, 'Ophthalmology', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(9, 'Anesthesia', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(10, 'Pathology', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(11, 'ENT', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(12, 'Dental Care', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(13, 'Dermatologists', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(14, 'Endocrinologists', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(18, 'Neurologists', '2025-02-17 07:22:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblcontactus`
--

CREATE TABLE `tblcontactus` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contactno` bigint(12) DEFAULT NULL,
  `message` mediumtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `LastupdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `IsRead` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcontactus`
--

INSERT INTO `tblcontactus` (`id`, `fullname`, `email`, `contactno`, `message`, `PostingDate`, `AdminRemark`, `LastupdationDate`, `IsRead`) VALUES
(6, 'Samir sharma', 's@gmail.com', 9846582621, 'hello this is for checking purpoise \r\n', '2025-02-17 07:03:58', 'read', '2025-02-17 07:32:13', 1),
(7, 'hh', 'h@gmail.com', 9846582621, 'hh', '2025-02-17 07:33:11', 'read it', '2025-02-17 07:35:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblmedicalhistory`
--

CREATE TABLE `tblmedicalhistory` (
  `ID` int(10) NOT NULL,
  `PatientID` int(10) DEFAULT NULL,
  `BloodPressure` varchar(200) DEFAULT NULL,
  `BloodSugar` varchar(200) NOT NULL,
  `Weight` varchar(100) DEFAULT NULL,
  `Temperature` varchar(200) DEFAULT NULL,
  `MedicalPres` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblmedicalhistory`
--

INSERT INTO `tblmedicalhistory` (`ID`, `PatientID`, `BloodPressure`, `BloodSugar`, `Weight`, `Temperature`, `MedicalPres`, `CreationDate`) VALUES
(8, 8, '122/70', '200', '70', '99', 'he have some serious issues', '2025-02-17 08:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `tblpage`
--

CREATE TABLE `tblpage` (
  `ID` int(10) NOT NULL,
  `PageType` varchar(200) DEFAULT NULL,
  `PageTitle` varchar(200) DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT current_timestamp(),
  `OpenningTime` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpage`
--

INSERT INTO `tblpage` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `UpdationDate`, `OpenningTime`) VALUES
(1, 'aboutus', 'About Us', '<ul style=\"padding: 0px; margin-right: 0px; margin-bottom: 1.313em; margin-left: 1.655em;\" times=\"\" new=\"\" roman\";=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" center;=\"\" background-color:=\"\" rgb(255,=\"\" 246,=\"\" 246);\"=\"\"><li style=\"text-align: left;\"><b><i><font size=\"5\" face=\"helvetica\">Welcome to the Doctor Appointment Management System, created by Ananta Sharma and Kisor Sharma, pursuing a Bachelor\'s degree in Computer Applications (Fourth Semester). This system is designed to streamline the appointment booking process for both patients and doctors. With a user-friendly interface, it ensures efficient scheduling and management of medical consultations. Built using modern web technologies, it enhances accessibility and convenience for users. Our goal is to provide a seamless digital healthcare experience through this innovative platform.</font></i></b></li></ul>', NULL, NULL, '2020-05-20 07:21:52', NULL),
(2, 'contactus', 'Contact Details', 'D-204, Hole Town South West, Delhi-110096,India', 'info@gmail.com', 1122334455, '2020-05-20 07:24:07', '9 am To 8 Pm');

-- --------------------------------------------------------

--
-- Table structure for table `tblpatient`
--

CREATE TABLE `tblpatient` (
  `ID` int(10) NOT NULL,
  `Docid` int(10) DEFAULT NULL,
  `PatientName` varchar(200) DEFAULT NULL,
  `PatientContno` bigint(10) DEFAULT NULL,
  `PatientEmail` varchar(200) DEFAULT NULL,
  `PatientGender` varchar(50) DEFAULT NULL,
  `PatientAdd` mediumtext DEFAULT NULL,
  `PatientAge` int(10) DEFAULT NULL,
  `PatientMedhis` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpatient`
--

INSERT INTO `tblpatient` (`ID`, `Docid`, `PatientName`, `PatientContno`, `PatientEmail`, `PatientGender`, `PatientAdd`, `PatientAge`, `PatientMedhis`, `CreationDate`, `UpdationDate`) VALUES
(8, 12, 'Ananta Sharma', 984658261, 'kisorsharmasubedi@gmail.com', 'male', 'Pokhara', 22, 'nothing', '2025-02-17 08:33:27', NULL),
(9, 13, 'Ananta Sharma', 984658261, 'kisorsharmasubedi@gmail.com', 'male', 'Pokhara', 22, 'ntg', '2025-02-17 08:35:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `userip` binary(16) DEFAULT NULL,
  `loginTime` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `uid`, `username`, `userip`, `loginTime`, `logout`, `status`) VALUES
(5, NULL, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 15:06:03', NULL, 0),
(6, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 15:11:41', NULL, 1),
(7, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 15:35:06', NULL, 1),
(8, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 15:35:14', NULL, 1),
(9, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 15:36:38', NULL, 1),
(10, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 15:38:06', NULL, 1),
(11, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 15:42:00', '16-12-2024 09:26:39 PM', 1),
(12, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 15:56:54', NULL, 1),
(13, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 15:57:03', NULL, 1),
(14, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 15:57:09', NULL, 1),
(15, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 16:00:44', NULL, 1),
(16, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 16:01:49', NULL, 1),
(17, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 16:02:47', NULL, 1),
(18, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 16:04:28', NULL, 1),
(19, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 16:08:41', NULL, 1),
(20, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 16:50:37', NULL, 1),
(21, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-16 17:01:26', NULL, 1),
(22, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-17 01:32:11', NULL, 1),
(23, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-17 01:32:48', '17-12-2024 07:03:22 AM', 1),
(24, NULL, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-17 01:34:55', NULL, 0),
(25, NULL, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-17 01:35:12', NULL, 0),
(26, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-17 01:35:22', NULL, 1),
(27, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-17 02:34:16', NULL, 1),
(28, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-18 11:55:54', NULL, 1),
(29, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-18 11:56:19', NULL, 1),
(30, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-18 13:23:09', NULL, 1),
(31, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 06:54:31', NULL, 1),
(32, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 08:01:03', '19-12-2024 01:31:31 PM', 1),
(33, NULL, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 08:01:41', NULL, 0),
(34, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 08:01:49', NULL, 1),
(35, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 08:06:57', '19-12-2024 01:45:48 PM', 1),
(36, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 08:16:02', NULL, 1),
(37, NULL, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 08:22:20', NULL, 0),
(38, NULL, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 08:22:30', NULL, 0),
(39, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 08:23:27', NULL, 1),
(40, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 08:39:28', NULL, 1),
(41, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:20:55', NULL, 1),
(42, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:44:57', '19-12-2024 03:14:59 PM', 1),
(43, NULL, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:49:44', NULL, 0),
(44, NULL, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:49:57', NULL, 0),
(45, NULL, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:54:30', NULL, 0),
(46, NULL, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:54:39', NULL, 0),
(47, NULL, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:54:48', NULL, 0),
(48, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:54:57', '19-12-2024 03:24:58 PM', 1),
(49, NULL, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:55:48', NULL, 0),
(50, NULL, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:55:56', NULL, 0),
(51, NULL, 'ananta@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:56:08', NULL, 0),
(52, NULL, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:56:33', NULL, 0),
(53, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 09:57:10', NULL, 1),
(54, NULL, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 10:21:59', NULL, 0),
(55, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 10:22:12', NULL, 1),
(56, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-19 17:07:16', NULL, 1),
(57, NULL, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-22 03:31:37', NULL, 0),
(58, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-22 03:31:47', '22-12-2024 09:34:59 AM', 1),
(59, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-22 04:05:13', '22-12-2024 09:35:17 AM', 1),
(60, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-22 04:07:50', NULL, 1),
(61, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-25 14:19:56', NULL, 1),
(62, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-25 15:26:58', NULL, 1),
(63, 4, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-26 07:29:05', NULL, 1),
(64, 3, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2024-12-26 07:35:25', NULL, 1),
(65, NULL, 'a@gmaIl.com', 0x3a3a3100000000000000000000000000, '2025-02-17 06:49:51', NULL, 0),
(66, NULL, 'bant98476@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 06:50:09', NULL, 0),
(67, 5, 'kisorsharmasubedi@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 07:52:46', '17-02-2025 01:26:38 PM', 1),
(68, 7, 'a@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 07:58:51', NULL, 1),
(69, NULL, 'aman@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 08:00:49', NULL, 0),
(70, 6, 'kisorsharmasubedi@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 08:31:19', '17-02-2025 02:06:54 PM', 1),
(71, NULL, 'kisorsharmasubedi@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 08:37:01', NULL, 0),
(72, 6, 'kisorsharmasubedi@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 08:37:12', '17-02-2025 02:07:20 PM', 1),
(73, 6, 'kisorsharmasubedi@gmail.com', 0x3a3a3100000000000000000000000000, '2025-02-17 08:40:01', '17-02-2025 02:10:04 PM', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullName` varchar(255) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `regDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullName`, `address`, `city`, `gender`, `email`, `password`, `regDate`, `updationDate`) VALUES
(6, 'Ananta Sharma', 'Pokhara,bagar', 'Pokhara', 'male', 'kisorsharmasubedi@gmail.com', 'f840c92c476343dcc6cc423ffb5c5376', '2025-02-17 07:56:59', '2025-02-17 08:39:52'),
(7, 'kisor sharma  subedi', 'Pokhara ,bagar', 'Pokhara', 'male', 'ant@gmail.com', '713dec21e7e5c37c0ca6d128c2ddd860', '2025-02-17 07:58:15', '2025-02-17 08:26:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctorslog`
--
ALTER TABLE `doctorslog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctorspecilization`
--
ALTER TABLE `doctorspecilization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcontactus`
--
ALTER TABLE `tblcontactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblmedicalhistory`
--
ALTER TABLE `tblmedicalhistory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpage`
--
ALTER TABLE `tblpage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpatient`
--
ALTER TABLE `tblpatient`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `doctorslog`
--
ALTER TABLE `doctorslog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `doctorspecilization`
--
ALTER TABLE `doctorspecilization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblcontactus`
--
ALTER TABLE `tblcontactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblmedicalhistory`
--
ALTER TABLE `tblmedicalhistory`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblpatient`
--
ALTER TABLE `tblpatient`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
