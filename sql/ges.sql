-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2022 at 01:03 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ges`
--

-- --------------------------------------------------------

--
-- Table structure for table `manual_entry`
--

CREATE TABLE `manual_entry` (
  `id` int(11) NOT NULL,
  `datein` date DEFAULT NULL,
  `timein` time DEFAULT NULL,
  `dateout` date DEFAULT NULL,
  `timeout` time DEFAULT NULL,
  `purpose` varchar(100) DEFAULT NULL,
  `addl_person` int(10) NOT NULL,
  `vehno` text DEFAULT NULL,
  `userid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

CREATE TABLE `rank` (
  `rank` text NOT NULL,
  `id` int(5) NOT NULL,
  `category_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rank`
--

INSERT INTO `rank` (`rank`, `id`, `category_id`) VALUES
('MR', 18, '2'),
('MRS', 19, '2'),
('MS', 20, '2'),
('OS', 21, '3'),
('MSGR', 22, '3'),
('STENO', 23, '3'),
('COOK', 24, '3'),
('LDC', 25, '3'),
('UDC', 26, '3'),
('BARBER', 27, '3'),
('SAFAIWALA', 28, '3'),
('WASHERMAN', 29, '3'),
('GARDENER', 30, '3'),
('CSBO', 31, '3'),
('CMD', 32, '3'),
('PROJECTIONIST', 33, '3'),
('ER', 34, '3'),
('STEWARD', 35, '3'),
('MTS', 36, '3'),
('C/SAFAIWALA', 37, '3'),
('TAILOR', 38, '3'),
('MR', 39, '4'),
('MRS', 40, '4');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member`
--

CREATE TABLE `tbl_member` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_member`
--

INSERT INTO `tbl_member` (`id`, `username`, `password`, `email`, `create_at`) VALUES
(4, 'admin', '$2y$10$cPmFTNOeiRlyBH/i/TTZF.ltHFeXGlfqZxCAKdRuM.BBloe3ecKPi', 'abcd@gmail.com', '2022-09-17 11:02:10');

-- --------------------------------------------------------

--
-- Table structure for table `user_category`
--

CREATE TABLE `user_category` (
  `category_name` text NOT NULL,
  `id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_category`
--

INSERT INTO `user_category` (`category_name`, `id`) VALUES
('CIVIL', 2),
('CIV_ADM', 3),
('MES', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_detail`
--

CREATE TABLE `user_detail` (
  `unique_id` varchar(25) NOT NULL,
  `rank` varchar(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `user_type` int(1) NOT NULL,
  `user_category` varchar(10) NOT NULL,
  `photo` text NOT NULL,
  `id` text NOT NULL,
  `stay_loc` varchar(11) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `usertype` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `usertype`) VALUES
(1, 'PERMANENT'),
(2, 'TEMPORARY');

-- --------------------------------------------------------

--
-- Table structure for table `veh_entry`
--

CREATE TABLE `veh_entry` (
  `sno` int(100) NOT NULL,
  `veh_no` text NOT NULL,
  `driver` text NOT NULL,
  `co_driver` text NOT NULL,
  `dandaman` text DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `misc_detail` text DEFAULT NULL,
  `km_out` int(10) NOT NULL,
  `km_in` int(10) NOT NULL,
  `date_out` date NOT NULL,
  `time_out` time NOT NULL,
  `date_in` date NOT NULL,
  `time_in` time NOT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manual_entry`
--
ALTER TABLE `manual_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rank`
--
ALTER TABLE `rank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_member`
--
ALTER TABLE `tbl_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_category`
--
ALTER TABLE `user_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_detail`
--
ALTER TABLE `user_detail`
  ADD PRIMARY KEY (`unique_id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`) USING HASH;

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `veh_entry`
--
ALTER TABLE `veh_entry`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manual_entry`
--
ALTER TABLE `manual_entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `tbl_member`
--
ALTER TABLE `tbl_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `veh_entry`
--
ALTER TABLE `veh_entry`
  MODIFY `sno` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
