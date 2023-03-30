-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2023 at 11:38 AM
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
  `nid_picture` varchar(100) DEFAULT NULL,
  `account_creation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `email`, `password`, `company_logo`, `company_details`, `account_type`, `nid_picture`, `account_creation_date`) VALUES
(1, 'Anas Mahmud Abid', 'abid@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 'company', NULL, '0000-00-00');

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
  `job_salary` int(11) NOT NULL,
  `job_location` varchar(100) NOT NULL,
  `job_creation_date` date NOT NULL,
  `job_expiration_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs_posted`
--

INSERT INTO `jobs_posted` (`job_id`, `job_title`, `job_company_id`, `job_details`, `job_type`, `job_category`, `job_salary`, `job_location`, `job_creation_date`, `job_expiration_date`) VALUES
(1, 'Bkash', 1, '0', 'Full Time', '0', 70000, '0', '0000-00-00', '0000-00-00');

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
  `account_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_seeker`
--

INSERT INTO `job_seeker` (`id`, `name`, `email`, `password`, `picture`, `portfolio`, `security_answer`, `nid_picture`, `account_creation_date`, `bookmarked_company`, `account_type`) VALUES
(1, 'Anas Mahmud Abid', 'abid@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 'c988fa7c33ce43962b9803702b747a35', NULL, '0000-00-00', NULL, 'job_seeker');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(100) NOT NULL,
  `message_box_id` int(100) NOT NULL,
  `message_sender_id` int(100) NOT NULL,
  `message_receiver_id` int(100) NOT NULL,
  `message_detail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(100) NOT NULL,
  `notification_title` varchar(100) NOT NULL,
  `notification_details` varchar(100) NOT NULL,
  `notification_link` varchar(100) NOT NULL,
  `notification_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs_posted`
--
ALTER TABLE `jobs_posted`
  MODIFY `job_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `job_seeker`
--
ALTER TABLE `job_seeker`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
