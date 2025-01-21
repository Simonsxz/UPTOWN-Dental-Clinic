-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2025 at 04:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

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
-- Stand-in structure for view `tbl_familydata`
-- (See below for the actual view)
--
CREATE TABLE `tbl_familydata` (
`folder_id` varchar(255)
,`folder_name` varchar(255)
,`folder_head` varchar(255)
,`patient_id` varchar(255)
,`patient_fullName` varchar(255)
,`patient_family` varchar(511)
);

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
(1, 'UPDC-FAMILY-000001', 'Simon', 'Manuel Simon', '2025-01-02 09:47:06'),
(2, 'UPDC-FAMILY-000002', 'Lopena', 'Jodi Lopena', '2025-01-06 07:31:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_medicalhistory`
--

CREATE TABLE `tbl_medicalhistory` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `patient_prescription` varchar(255) NOT NULL,
  `aids` tinyint(1) DEFAULT 0,
  `arthritis` tinyint(1) DEFAULT 0,
  `rheumatism` tinyint(1) DEFAULT 0,
  `artificial_heart` tinyint(1) DEFAULT 0,
  `valves` tinyint(1) DEFAULT 0,
  `asthma` tinyint(1) DEFAULT 0,
  `fainting` tinyint(1) DEFAULT 0,
  `blood_disease` tinyint(1) DEFAULT 0,
  `cancer` tinyint(1) DEFAULT 0,
  `chemical_dependency` tinyint(1) DEFAULT 0,
  `circulatory_problems` tinyint(1) DEFAULT 0,
  `cortisone_treatment` tinyint(1) DEFAULT 0,
  `persistent_cough` tinyint(1) DEFAULT 0,
  `cough_blood` tinyint(1) DEFAULT 0,
  `diabetes` tinyint(1) DEFAULT 0,
  `epilepsy` tinyint(1) DEFAULT 0,
  `mitral_valve_prolapse` tinyint(1) DEFAULT 0,
  `headaches` tinyint(1) DEFAULT 0,
  `heart_murmur` tinyint(1) DEFAULT 0,
  `heart_problems` tinyint(1) DEFAULT 0,
  `hemophilia` tinyint(1) DEFAULT 0,
  `high_blood_pressure` tinyint(1) DEFAULT 0,
  `hepatitis` tinyint(1) DEFAULT 0,
  `hiv_positive` tinyint(1) DEFAULT 0,
  `jaw_pain` tinyint(1) DEFAULT 0,
  `kidney_disease` tinyint(1) DEFAULT 0,
  `liver_disease` tinyint(1) DEFAULT 0,
  `back_problem` tinyint(1) DEFAULT 0,
  `pacemaker` tinyint(1) DEFAULT 0,
  `psychiatric_care` tinyint(1) DEFAULT 0,
  `radiation_treatment` tinyint(1) DEFAULT 0,
  `respiratory_disease` tinyint(1) DEFAULT 0,
  `rheumatic_fever` tinyint(1) DEFAULT 0,
  `anemia` tinyint(1) DEFAULT 0,
  `skin_rash` tinyint(1) DEFAULT 0,
  `stroke` tinyint(1) DEFAULT 0,
  `swelling_feet_ankle` tinyint(1) DEFAULT 0,
  `thyroid_problems` tinyint(1) DEFAULT 0,
  `nervous_problem` tinyint(1) DEFAULT 0,
  `tobacco_habit` tinyint(1) DEFAULT 0,
  `tonsilitis` tinyint(1) DEFAULT 0,
  `ulcer` tinyint(1) DEFAULT 0,
  `chemotherapy` tinyint(1) DEFAULT 0,
  `scarlet_fever` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_medicalhistory`
--

INSERT INTO `tbl_medicalhistory` (`id`, `patient_id`, `patient_prescription`, `aids`, `arthritis`, `rheumatism`, `artificial_heart`, `valves`, `asthma`, `fainting`, `blood_disease`, `cancer`, `chemical_dependency`, `circulatory_problems`, `cortisone_treatment`, `persistent_cough`, `cough_blood`, `diabetes`, `epilepsy`, `mitral_valve_prolapse`, `headaches`, `heart_murmur`, `heart_problems`, `hemophilia`, `high_blood_pressure`, `hepatitis`, `hiv_positive`, `jaw_pain`, `kidney_disease`, `liver_disease`, `back_problem`, `pacemaker`, `psychiatric_care`, `radiation_treatment`, `respiratory_disease`, `rheumatic_fever`, `anemia`, `skin_rash`, `stroke`, `swelling_feet_ankle`, `thyroid_problems`, `nervous_problem`, `tobacco_habit`, `tonsilitis`, `ulcer`, `chemotherapy`, `scarlet_fever`, `created_at`) VALUES
(1, 'UPDC-PT-000004', 'Pasta', 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2025-01-21 14:59:22');

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
(3, 'UPDC-PT-000003', 'Jojo Simon', '0000-00-00', 'Dr. Silva', 'dasd', '2025-01-03', 22, 'female', '55', '55', 'Single', 'Wfh', 'Muslim', 12312312, 'Mj SImon', 'Filipino', 'N/A', '2025-01-07 05:02:49', 'Simon (Manuel Simon)'),
(4, 'UPDC-PT-000004', 'Manuel Simon', '0000-00-00', '12', 'dasd', '2025-01-01', 22, 'male', '22', '222', '22', '22', '22', 12312312, 'Mj SImon', 'Filipino', '22', '2025-01-07 05:02:52', 'Simon (Manuel Simon)'),
(5, 'UPDC-PT-000005', 'Manuel Simon', '0000-00-00', '12', 'dasd', '2025-01-01', 22, 'male', '22', '222', '22', '22', '22', 12312312, 'Mj SImon', 'Filipino', '22', '2025-01-07 05:02:54', 'Simon (Manuel Simon)'),
(6, 'UPDC-PT-000006', 'Mj Simon', '0000-00-00', '5', '1231', '2025-01-01', 22, 'female', '23', '22', '22', '22', '22', 12312312, 'Mj SImon', 'Filipino', '2', '2025-01-07 05:02:57', 'Simon (Manuel Simon)'),
(7, 'UPDC-PT-000007', 'Jodi Lopena', '0000-00-00', '5', '1231', '2025-01-01', 22, 'male', '22', '2', '22', '22', '22', 32, 'Mj SImon', 'Filipino', '22', '2025-01-06 07:31:49', 'Lopena (Jodi Lopena)');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patienthistory`
--

CREATE TABLE `tbl_patienthistory` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `patient_prescription` varchar(255) NOT NULL,
  `patient_doctor` text NOT NULL,
  `patient_payment` int(255) NOT NULL,
  `prescription_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_patienthistory`
--

INSERT INTO `tbl_patienthistory` (`id`, `patient_id`, `patient_prescription`, `patient_doctor`, `patient_payment`, `prescription_date`) VALUES
(4, 'UPDC-PT-000004', 'Pasta', 'Dr. silva', 2000, '2025-01-21 14:33:47'),
(5, 'UPDC-PT-000003', 'Antibiotics', 'Dr. Adams', 1500, '2025-01-21 13:48:45'),
(6, 'UPDC-PT-000004', 'X-ray', 'Dr. Lee', 2500, '2025-01-12 01:30:00'),
(7, 'UPDC-PT-000004', 'Blood Test', 'Dr. Kumar', 1000, '2025-01-14 08:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patientmedhistory`
--

CREATE TABLE `tbl_patientmedhistory` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `patient_prescription` varchar(255) NOT NULL,
  `medhistory_lastvisit` date NOT NULL,
  `medhistory_genphysician` text NOT NULL,
  `medhistory_serious` text NOT NULL,
  `medhistory_ifyesserious` text NOT NULL,
  `medhistory_bloodtrans` varchar(255) NOT NULL,
  `medhistory_ifyesdate` text NOT NULL,
  `medhistory_pregnant` text NOT NULL,
  `medhistory_birthcontrol` text NOT NULL,
  `medhistory_takingmed` text NOT NULL,
  `medhistory_ifyesmed` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_patientmedhistory`
--

INSERT INTO `tbl_patientmedhistory` (`id`, `patient_id`, `patient_prescription`, `medhistory_lastvisit`, `medhistory_genphysician`, `medhistory_serious`, `medhistory_ifyesserious`, `medhistory_bloodtrans`, `medhistory_ifyesdate`, `medhistory_pregnant`, `medhistory_birthcontrol`, `medhistory_takingmed`, `medhistory_ifyesmed`) VALUES
(1, 'UPDC-PT-000004', 'Pasta', '2025-01-10', 'Dr. Smith', 'No', 'N/A', 'No', 'N/A', 'No', 'No', 'No', 'N/A');

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
(11, 'UP-DC-11', 'Manuel', 'Simon', 'admin', '$2y$10$x8MBiPz74vY91YRlGxjYxuy4w8Q5jFW5gKRU/Fakv48MZqx5KFlDy', 'admin', '2025-01-02 03:07:48'),
(12, 'UP-DC-12', 'doctor', 'doctor', 'doctor', '$2y$10$F2HcJ1mlVoBRDGRMsByExuy/yyrsHsRk5Vun/dePJWKj2DH4gNIEK', 'doctor', '2025-01-03 04:33:25');

-- --------------------------------------------------------

--
-- Structure for view `tbl_familydata`
--
DROP TABLE IF EXISTS `tbl_familydata`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tbl_familydata`  AS SELECT `f`.`folder_id` AS `folder_id`, `f`.`folder_name` AS `folder_name`, `f`.`folder_head` AS `folder_head`, `p`.`patient_id` AS `patient_id`, `p`.`patient_fullName` AS `patient_fullName`, concat(`f`.`folder_name`,' ',`f`.`folder_head`) AS `patient_family` FROM (`tbl_patientaccount` `p` join `tbl_familyfolder` `f` on(trim(lcase(replace(replace(`p`.`patient_family`,'(',''),')',''))) = trim(lcase(concat(`f`.`folder_name`,' ',`f`.`folder_head`))))) WHERE `p`.`patient_id` is not null AND `f`.`folder_id` is not null ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_familyfolder`
--
ALTER TABLE `tbl_familyfolder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_medicalhistory`
--
ALTER TABLE `tbl_medicalhistory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_patientaccount`
--
ALTER TABLE `tbl_patientaccount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_patienthistory`
--
ALTER TABLE `tbl_patienthistory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_patientmedhistory`
--
ALTER TABLE `tbl_patientmedhistory`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_medicalhistory`
--
ALTER TABLE `tbl_medicalhistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_patientaccount`
--
ALTER TABLE `tbl_patientaccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_patienthistory`
--
ALTER TABLE `tbl_patienthistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_patientmedhistory`
--
ALTER TABLE `tbl_patientmedhistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_useraccount`
--
ALTER TABLE `tbl_useraccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
