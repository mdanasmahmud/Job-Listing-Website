-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2023 at 03:38 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cse471_job_listing`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `company_logo` varchar(100) DEFAULT NULL,
  `company_details` text DEFAULT NULL,
  `account_type` varchar(100) NOT NULL,
  `company_document` varchar(100) DEFAULT NULL,
  `account_creation_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `always_null` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `email`, `password`, `company_logo`, `company_details`, `account_type`, `company_document`, `account_creation_date`, `always_null`) VALUES
(1, 'Bkash Company', 'abid@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '9781506711980.jpg', 'Test Bkash Company', 'company', 'Group12_Sec5_UseCaseDiagram.pdf', '2023-04-24 22:29:54', NULL),
(2, 'alsolin', 'alsolin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 'company', NULL, '0000-00-00 00:00:00', NULL),
(8, 'company', 'company@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 'company', NULL, '2023-04-18 19:28:16', NULL),
(9, 'sample1', 'sample1@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'protibadi app.PNG', NULL, 'company', '20101149_Activity 13_CSE472.pdf', '2023-04-22 23:29:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs_posted`
--

CREATE TABLE `jobs_posted` (
  `job_id` int(100) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `job_company_id` int(100) NOT NULL,
  `job_details` text NOT NULL,
  `job_type` varchar(100) NOT NULL,
  `job_category` varchar(100) NOT NULL,
  `job_salary` int(100) NOT NULL,
  `job_creation_date` date NOT NULL,
  `job_expiration_date` date NOT NULL,
  `job_post_status` varchar(100) NOT NULL,
  `bkash_transaction` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs_posted`
--

INSERT INTO `jobs_posted` (`job_id`, `job_title`, `job_company_id`, `job_details`, `job_type`, `job_category`, `job_salary`, `job_creation_date`, `job_expiration_date`, `job_post_status`, `bkash_transaction`) VALUES
(2, 'Pathao IT', 2, 'This is for the business people, IT', 'Full Time', 'IT', 30000, '2023-04-01', '2023-04-01', 'Approved', ''),
(3, 'Foodpanda Manager', 1, 'This is for the business people', 'Full Time', 'Manager', 30000, '2023-04-01', '2023-04-01', 'Approved', ''),
(4, 'Google Manager', 2, 'This is for the business people', 'Part Time', 'Manager', 60000, '2023-04-01', '2023-04-01', 'Approved', ''),
(5, 'Tesla Data Entry', 2, 'This is for the business people', 'Part Time', 'Data Entry', 70000, '2023-04-01', '2023-04-08', 'Pending', ''),
(6, 'Walton IT', 8, 'IT Job Section from Walton', 'Full Time', 'IT', 20000, '0000-00-00', '2023-04-29', 'Pending', ''),
(7, 'Walton Manager', 8, 'IT Job Section from Walton', 'Full Time', 'Manager', 20000, '2023-04-19', '2023-04-29', 'Pending', ''),
(8, 'Subway Manager', 2, 'Manager for sub way', 'Full Time', 'Manager', 20000, '2023-04-19', '2023-04-20', 'Pending', ''),
(9, 'Bracu Teacher', 2, 'Teacher for Brac University', 'Full Time', 'Teacher', 98000, '2023-04-19', '2023-04-30', 'Pending', ''),
(10, 'Bkash IT', 1, 'Bkash IT', 'Full Time', 'IT', 40000, '2023-04-25', '2023-04-28', 'Pending', NULL),
(11, 'Bkash Sales Manager', 1, 'Sales Manager for Bkash', 'Full Time', 'Manager', 57777, '2023-04-25', '2023-04-28', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_application`
--

CREATE TABLE `job_application` (
  `application_id` int(11) NOT NULL,
  `job_post_id` int(11) NOT NULL,
  `job_seeker_id` int(11) NOT NULL,
  `application_status` varchar(100) NOT NULL DEFAULT 'Pending',
  `job_application_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_application`
--

INSERT INTO `job_application` (`application_id`, `job_post_id`, `job_seeker_id`, `application_status`, `job_application_date`) VALUES
(1, 4, 1, 'Approve', '2023-04-19 12:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `job_seeker`
--

CREATE TABLE `job_seeker` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `portfolio` text DEFAULT NULL,
  `security_answer` varchar(100) NOT NULL,
  `nid_picture` varchar(100) DEFAULT NULL,
  `account_creation_date` date NOT NULL,
  `bookmarked_company` varchar(100) DEFAULT NULL,
  `account_type` varchar(100) NOT NULL,
  `always_null` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_seeker`
--

INSERT INTO `job_seeker` (`id`, `name`, `email`, `password`, `picture`, `portfolio`, `security_answer`, `nid_picture`, `account_creation_date`, `bookmarked_company`, `account_type`, `always_null`) VALUES
(16, 'final test', 'finaltest@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '5.jpg', NULL, 'c988fa7c33ce43962b9803702b747a35', '342052966_938380127361192_3258785781992226560_n.jpg', '0000-00-00', NULL, 'job_seeker', NULL),
(17, 'final1', 'final@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', NULL, 'c988fa7c33ce43962b9803702b747a35', '', '0000-00-00', NULL, 'job_seeker', NULL),
(19, 'admin', 'admin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '', NULL, 'c988fa7c33ce43962b9803702b747a35', '', '0000-00-00', NULL, 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(100) NOT NULL,
  `message_sender_id` int(100) NOT NULL,
  `message_receiver_id` int(100) NOT NULL,
  `message_detail` varchar(100) NOT NULL,
  `message_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `message_sender_id`, `message_receiver_id`, `message_detail`, `message_time`) VALUES
(2, 1, 17, 'Hey is the message working?', '2023-04-23 11:07:57'),
(4, 1, 17, 'second message', '2023-04-23 12:12:12'),
(5, 1, 16, 'third message', '2023-04-23 12:16:39'),
(6, 17, 1, 'Final1 to company named Bkash', '2023-04-23 13:51:44'),
(7, 1, 17, 'is this working?', '2023-04-23 15:07:28'),
(8, 1, 17, 'Horay!', '2023-04-23 15:07:33'),
(11, 1, 19, 'qw', '2023-04-23 16:14:10'),
(14, 19, 1, 'working?', '2023-04-23 16:38:59'),
(15, 1, 19, '321', '2023-04-23 16:40:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_posted`
--
ALTER TABLE `jobs_posted`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `job_application`
--
ALTER TABLE `job_application`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `job_seeker`
--
ALTER TABLE `job_seeker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jobs_posted`
--
ALTER TABLE `jobs_posted`
  MODIFY `job_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `job_application`
--
ALTER TABLE `job_application`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `job_seeker`
--
ALTER TABLE `job_seeker`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
