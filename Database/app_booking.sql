-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2023 at 09:28 AM
-- Server version: 10.11.2-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Admin_ID` int(11) NOT NULL,
  `Admin_Name` varchar(250) NOT NULL,
  `Admin_Email` varchar(50) NOT NULL,
  `Admin_Password` varchar(10) NOT NULL,
  `Admin_PhoneNo` varchar(12) NOT NULL,
  `Admin_Address` varchar(255) NOT NULL,
  `Admin_Bio` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_ID`, `Admin_Name`, `Admin_Email`, `Admin_Password`, `Admin_PhoneNo`, `Admin_Address`, `Admin_Bio`) VALUES
(1, 'Kensey Barbar', 'kensey23@dr.com', '@K123', '0163456789', '9 Uoa Centre Office Block Jln Pinang, 50450 Kuala Lumpur', 'I am an admin in the Medic Hospital for 3 years with many experiences in this administrator field.'),
(2, 'Thivyah Vijayan', 'vthiv14@dr.com', 'Tv14', '0123456789', 'KL road', 'I have been working on different field as admin for almost 5 years.');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `App_ID` int(11) NOT NULL,
  `Apt_ID` varchar(250) NOT NULL,
  `Pat_ID` int(11) NOT NULL,
  `Doctor_ID` int(11) NOT NULL,
  `Dept_ID` int(11) NOT NULL,
  `App_Date` date NOT NULL,
  `App_Time` time NOT NULL,
  `App_Message` varchar(100) NOT NULL,
  `Prescription` varchar(250) NOT NULL,
  `App_Status` tinyint(4) NOT NULL COMMENT '1 = Active\r\n0 = Inactive',
  `App_CreatedAt` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`App_ID`, `Apt_ID`, `Pat_ID`, `Doctor_ID`, `Dept_ID`, `App_Date`, `App_Time`, `App_Message`, `Prescription`, `App_Status`, `App_CreatedAt`) VALUES
(1, 'APT-1', 1, 1, 1, '2023-11-02', '15:00:00', 'qwertyuiop', 'Testing', 1, '2023-10-25 19:00:39'),
(2, 'APT-2', 2, 4, 4, '2023-11-28', '10:30:00', 'Need to check a chemical reaction in the body.', '', 1, '2023-10-19 18:41:24'),
(3, 'APT-3', 1, 3, 3, '2023-11-30', '10:00:00', 'Need to check the spine', '', 1, '2023-11-02 05:52:44'),
(4, 'APT-4', 2, 4, 4, '2023-11-24', '10:00:00', 'Check the cancer cell', '', 1, '2023-11-02 05:58:21'),
(5, 'APT-5', 1, 4, 4, '2023-12-06', '10:00:00', 'Breast Cancer need treatment', '', 1, '2023-11-02 06:20:16'),
(6, 'APT-6', 3, 5, 2, '2023-12-12', '09:30:00', 'Regular checkup', '', 1, '2023-11-02 06:32:26'),
(7, 'APT-7', 3, 9, 2, '2023-12-23', '10:10:00', 'Need to do check up on heart', '', 1, '2023-11-28 07:11:48'),
(8, 'APT-8', 3, 3, 3, '2023-12-12', '11:00:00', 'Regular checkup', '', 1, '2023-11-28 07:36:40'),
(9, 'APT-9', 4, 10, 4, '2023-12-20', '10:00:00', 'Checkup on checking the cancer cell in the brain.', '', 1, '2023-11-28 18:38:51'),
(10, 'APT-10', 3, 4, 4, '2023-12-27', '11:00:00', 'Regular check up on tumor cell', '', 1, '2023-11-28 18:54:55');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `Dept_ID` int(11) NOT NULL,
  `Dept_Name` varchar(250) NOT NULL,
  `Dept_Description` text NOT NULL,
  `Dept_Status` tinyint(4) NOT NULL COMMENT '1=Active\r\n0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Dept_ID`, `Dept_Name`, `Dept_Description`, `Dept_Status`) VALUES
(1, 'Allergology', 'Deals with the study, treatment, diagnosis and prevention of cancer. ', 1),
(2, 'Cardiology', 'Deals with diseases and abnormalities of the heart', 1),
(3, 'Neurology', 'Handles nerve system', 1),
(4, 'Oncology', 'Deals with the study, treatment, diagnosis and prevention of cancer', 1),
(5, 'Endocrinology', 'handle bones', 1),
(6, 'ENT', 'Deals with diseases affecting the ear, nose, and throat', 1),
(7, 'Dietary', 'Responsible for the health teaching in regard to proper diet of the patient', 1),
(8, 'Opthalmology', 'A surgical subspecialty within medicine that deals with the diagnosis and treatment of eye disorders.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `Doctor_ID` int(11) NOT NULL,
  `Employee_ID` varchar(50) NOT NULL,
  `Dept_ID` int(11) NOT NULL,
  `Doctor_Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(10) NOT NULL,
  `Doctor_DOB` date NOT NULL,
  `Doctor_PhoneNo` varchar(12) NOT NULL,
  `Doctor_Address` varchar(250) NOT NULL,
  `Doctor_JoiningDate` date NOT NULL,
  `Doctor_Gender` varchar(10) NOT NULL,
  `Doctor_Bio` varchar(500) NOT NULL,
  `Profile_Image` varchar(255) DEFAULT NULL,
  `Doctor_Status` tinyint(4) NOT NULL COMMENT '1= Active, 0= Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`Doctor_ID`, `Employee_ID`, `Dept_ID`, `Doctor_Name`, `Email`, `Password`, `Doctor_DOB`, `Doctor_PhoneNo`, `Doctor_Address`, `Doctor_JoiningDate`, `Doctor_Gender`, `Doctor_Bio`, `Profile_Image`, `Doctor_Status`) VALUES
(1, 'DR-N1', 1, 'Sonica Berg', 'sonica@dr.com', 'Soni@123', '1980-06-18', '0123456789', 'China Mountain Road', '2013-07-01', 'Female', 'MBBS graduated.', 'Soni.jpg', 1),
(2, 'DR-N2', 3, 'Calvin Carlo', 'calvin@dr.com', 'Calvin@123', '1984-06-20', '0123456789', 'Waze 15, Mountain Road', '2011-05-09', 'Male', 'Specialties in Women health services, Pregnancy care, Surgical procedures and Specialty care', 'Calvin Carlo_652571971d64a.jpg', 1),
(3, 'DR-N3', 3, 'Cristino Murphy', 'cristino@dr.com', 'Cris450', '1988-10-20', '0123456788', 'Bear 15 Mountain Road', '2014-06-04', 'Male', 'MBBS in Gynecology and have 5 years of experience.\r\nCurrently working on a thesis.', 'Cristino Murphy_65257284078a1.jpg', 1),
(4, 'DR-N4', 4, 'Alia Reddy', 'alia@dr.com', '@alia25', '1981-07-22', '0123456789', 'Maze 20, Mountain Road, KL', '2017-04-03', 'Female', 'MBBS in psychotherapy', 'Alia Reddy_6525731ee5326.jpg', 1),
(5, 'DR-N5', 2, 'Mark Anthony', 'mark15@dr.com', '@M15', '1977-07-14', '0132467795', '48, Jalan Maxwell', '2016-04-01', 'Male', 'MBBS in Manipal and has 5 years experience in this field.', 'Mark Anthony_6542f8075a0ec.jpg', 1),
(9, 'DR-N6', 2, 'Tony Taylor', 'tony29@dr.com', 'Tony@29', '1986-09-29', '0123456789', '25, Jalan Hang Tuah', '2011-10-01', 'Male', 'MD, CABM, FRCP, FESC, FACC is a board-certified consultant cardiologist with expertise in interventional cardiology.', 'Toni Taylor.jpg', 1),
(10, 'DR-N10', 4, 'Bertha Magers', 'berthaM27@dr.com', 'bertha27', '1990-06-27', '0123456789', '18, Jalan Hang Lekiu', '2014-05-01', 'Female', 'Graduated from both the University of St Andrews and University of Edinburgh where he obtained his medical degree (MBChB).', 'Bertha_Magers.jpg', 1),
(11, 'DR-N11', 1, 'Steven Paul', 'steven11@dr.com', 'steven11', '1978-02-11', '0123456789', '20, Jalan Tun Rahman', '2009-06-01', 'Male', 'M.B., B.Ch., is an Allergist and Clinical Immunologist who provides care for pediatric and adult patients with allergic disease, asthma and immunodeficiency.', 'Steven_Paul.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `Pat_ID` int(11) NOT NULL,
  `Pat_Firstname` varchar(50) NOT NULL,
  `Pat_Lastname` varchar(50) NOT NULL,
  `Pat_Email` varchar(50) NOT NULL,
  `Pat_Password` varchar(10) NOT NULL,
  `Pat_PhoneNo` varchar(12) NOT NULL,
  `Pat_DOB` varchar(10) NOT NULL,
  `Pat_Address` varchar(255) NOT NULL,
  `Pat_Status` tinyint(4) NOT NULL COMMENT '1 = Active \r\n0 = Inactive	',
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`Pat_ID`, `Pat_Firstname`, `Pat_Lastname`, `Pat_Email`, `Pat_Password`, `Pat_PhoneNo`, `Pat_DOB`, `Pat_Address`, `Pat_Status`, `Created_At`) VALUES
(1, 'Thivyah', 'Vijayan', 'vthiv@gmail.com', '@thiv14', '0123456789', '14/04/1997', 'No 21, Jalan Waxell, Taman Wax Street', 1, '2023-11-02 05:51:37'),
(2, 'Vijay', 'Kumar', 'vijay27@patient.com', 'Vijay@30', '012-345678', '1988/10/17', 'KL 15 Road, 68100 Bt Cvs', 1, '2023-11-03 08:51:09'),
(3, 'Jim', 'Carter', 'jimc@gmail.com', '@JC12', '012-3456789', '15/06/1991', '24, Sunway Road', 1, '2023-11-28 07:39:14'),
(4, 'Mohana', 'Vijay', 'mohana@pat.com', 'Moh24', '012-3214698', '1992-07-16', '15, Jalan Maxwell', 1, '2023-11-03 08:25:02');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `Schedule_ID` int(11) NOT NULL,
  `Doctor_ID` int(11) NOT NULL,
  `Dept_ID` int(11) NOT NULL,
  `Schedule_Title` varchar(100) NOT NULL,
  `Schedule_Day` text NOT NULL,
  `Schedule_Date` date NOT NULL,
  `Schedule_StartTime` time NOT NULL,
  `Schedule_EndTime` time NOT NULL,
  `Schedule_Status` tinyint(4) NOT NULL COMMENT '1= Active, 0= Inactive',
  `Schedule_CreatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`Schedule_ID`, `Doctor_ID`, `Dept_ID`, `Schedule_Title`, `Schedule_Day`, `Schedule_Date`, `Schedule_StartTime`, `Schedule_EndTime`, `Schedule_Status`, `Schedule_CreatedAt`) VALUES
(1, 1, 1, 'New Timetable added', 'Sunday, Monday, Tuesday, Wednesday', '2023-11-28', '21:00:00', '08:00:00', 1, '2023-11-28 14:17:58'),
(2, 4, 4, 'New Timetable added', 'Tuesday, Wednesday, Thursday', '2023-11-28', '07:00:00', '15:30:00', 1, '2023-11-28 14:18:48'),
(3, 11, 1, 'New timetable added', 'Sunday, Monday, Tuesday', '2023-11-28', '07:00:00', '15:30:00', 1, '2023-11-28 14:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `webuser`
--

CREATE TABLE `webuser` (
  `email` varchar(255) NOT NULL,
  `usertype` varchar(50) NOT NULL COMMENT '1=Admin, 2=Doctor, 3=Patient'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `webuser`
--

INSERT INTO `webuser` (`email`, `usertype`) VALUES
('kensey23@dr.com', '1'),
('vthiv14@dr.com', '1'),
('sonica@dr.com', '2'),
('calvin@dr.com', '2'),
('cristino@dr.com', '2'),
('alia@dr.com', '2'),
('vthiv@gmail.com', '3'),
('vijay27@patient.com', '3'),
('jimc@gmail.com', '3'),
('markanthony@dr.com', '2'),
('mark15@dr.com', '2'),
('mohana@pat.com', '3'),
('tony29@dr.com', '2'),
('berthaM27@dr.com', '2'),
('steven11@dr.com', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`App_ID`),
  ADD KEY `Pat_ID` (`Pat_ID`),
  ADD KEY `Doctor_ID` (`Doctor_ID`),
  ADD KEY `Dept_ID` (`Dept_ID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`Dept_ID`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`Doctor_ID`),
  ADD KEY `Dept_ID` (`Dept_ID`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`Pat_ID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`Schedule_ID`),
  ADD KEY `Doctor_ID` (`Doctor_ID`),
  ADD KEY `Dept_ID` (`Dept_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `App_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `Dept_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `Doctor_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `Pat_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `Schedule_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`Pat_ID`) REFERENCES `patient` (`Pat_ID`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`Doctor_ID`) REFERENCES `doctor` (`Doctor_ID`),
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`Dept_ID`) REFERENCES `department` (`Dept_ID`);

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`Dept_ID`) REFERENCES `department` (`Dept_ID`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`Doctor_ID`) REFERENCES `doctor` (`Doctor_ID`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`Dept_ID`) REFERENCES `department` (`Dept_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
