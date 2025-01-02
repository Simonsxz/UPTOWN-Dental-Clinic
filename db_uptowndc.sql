-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 10:48 AM
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
-- Database: `db_uptowndc`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_familyfolder`
--

CREATE TABLE `tbl_familyfolder` (
  `id` int(11) NOT NULL,
  `folder_id` varchar(255) NOT NULL,
  `folder_name` varchar(255) NOT NULL,
  `folder_head` varchar(255) NOT NULL,
  `folder_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_familyfolder`
--

INSERT INTO `tbl_familyfolder` (`id`, `folder_id`, `folder_name`, `folder_head`, `folder_created`) VALUES
(1, 'UPDC-FAMILY-000001', 'Simon', 'Manuel Simon', '2025-01-02 09:47:06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patientaccount`
--

CREATE TABLE `tbl_patientaccount` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `patient_fullName` varchar(255) NOT NULL,
  `patient_firstVisit` date NOT NULL,
  `patient_doctor` varchar(255) NOT NULL,
  `patient_address` text NOT NULL,
  `patient_DOB` date NOT NULL,
  `patient_age` int(255) NOT NULL,
  `patient_gender` varchar(255) NOT NULL,
  `patient_height` text NOT NULL,
  `patient_weight` text NOT NULL,
  `patient_status` varchar(255) NOT NULL,
  `patient_occupation` varchar(255) NOT NULL,
  `patient_religion` varchar(255) NOT NULL,
  `patient_contact` int(255) NOT NULL,
  `patient_facebook` text NOT NULL,
  `patient_nationality` varchar(255) NOT NULL,
  `patient_referrredby` text NOT NULL,
  `patient_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `patient_family` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_patientaccount`
--

INSERT INTO `tbl_patientaccount` (`id`, `patient_id`, `patient_fullName`, `patient_firstVisit`, `patient_doctor`, `patient_address`, `patient_DOB`, `patient_age`, `patient_gender`, `patient_height`, `patient_weight`, `patient_status`, `patient_occupation`, `patient_religion`, `patient_contact`, `patient_facebook`, `patient_nationality`, `patient_referrredby`, `patient_created`, `patient_family`) VALUES
(1, 'UPDC-PT-000001', 'Mj Simon', '2025-01-10', 'Dr. Silva', 'dasd', '2025-01-09', 22, 'male', '56', '57', 'Single', 'Wfh', 'Muslim', 213213213, 'Mj SImon', 'Filipno', 'N/A', '2025-01-02 08:25:19', 'Simon');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_useraccount`
--

CREATE TABLE `tbl_useraccount` (
  `id` int(11) NOT NULL,
  `user_ID` varchar(20) DEFAULT NULL,
  `user_fName` varchar(50) DEFAULT NULL,
  `user_lName` varchar(50) DEFAULT NULL,
  `user_userName` varchar(50) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_role` varchar(20) DEFAULT NULL,
  `user_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_useraccount`
--

INSERT INTO `tbl_useraccount` (`id`, `user_ID`, `user_fName`, `user_lName`, `user_userName`, `user_password`, `user_role`, `user_created`) VALUES
(4, 'UP-DC-4', 'Mj', 'Simon', 'mjsimon', '$2y$10$FR.0.ilhN/6qZhryoUkMveY4q3rwZMT9Fyxkyqx3WqHnNhDjBeQgO', 'admin', '2024-12-26 04:15:24'),
(5, 'UP-DC-5', 'dasd', 'ad', 'adasd', '$2y$10$iy2ckVR0KhR1gmPDGeEhxezs3zqOvRW2LgdVFGX80IdqPTUgbdZ9u', 'doctor', '2024-12-26 04:15:33'),
(7, 'UP-DC-7', '123123', '12312', 'asdasd', '$2y$10$wHFNykuIc142gOiF6p/fsuSvIwGZw.4SbST3An8cYUtP3Z2.kKhQi', 'admin', '2024-12-26 04:15:54'),
(10, 'UP-DC-10', 'Mj', 'Simon', 'mjsimon', '$2y$10$Zc07is7g5wSW1lvZ8k6raeSRydEBlRYqQjfLeZNmh4cAbrPOS7.6K', 'admin', '2025-01-02 02:06:14'),
(11, 'UP-DC-11', 'Manuel', 'Simon', 'admin', '$2y$10$x8MBiPz74vY91YRlGxjYxuy4w8Q5jFW5gKRU/Fakv48MZqx5KFlDy', 'admin', '2025-01-02 03:07:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_familyfolder`
--
ALTER TABLE `tbl_familyfolder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_patientaccount`
--
ALTER TABLE `tbl_patientaccount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_useraccount`
--
ALTER TABLE `tbl_useraccount`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_ID` (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_familyfolder`
--
ALTER TABLE `tbl_familyfolder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_patientaccount`
--
ALTER TABLE `tbl_patientaccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_useraccount`
--
ALTER TABLE `tbl_useraccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
