-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2022 at 12:10 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loan`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_loan`
--

CREATE TABLE `t_loan` (
  `intId` int(10) UNSIGNED NOT NULL,
  `loanAmount` decimal(10,2) NOT NULL,
  `loanTerm` int(5) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `tokenNumber` varchar(45) DEFAULT NULL,
  `deletedFlag` bit(1) NOT NULL DEFAULT b'0',
  `loanStatus` tinyint(3) DEFAULT 0,
  `payStatus` tinyint(3) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_loan`
--

INSERT INTO `t_loan` (`intId`, `loanAmount`, `loanTerm`, `createdOn`, `tokenNumber`, `deletedFlag`, `loanStatus`, `payStatus`) VALUES
(1, '15000.00', 5, '2022-08-18 09:35:14', 'AS2208181660815313', b'0', 0, 0),
(2, '30000.00', 3, '2022-08-18 09:35:46', 'AS2208181660815346', b'0', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_loan_payment`
--

CREATE TABLE `t_loan_payment` (
  `intId` int(11) UNSIGNED NOT NULL,
  `loanId` int(10) NOT NULL,
  `loanAmount` decimal(10,2) NOT NULL,
  `paymentDate` datetime DEFAULT NULL,
  `paymentStaus` tinyint(2) DEFAULT 0,
  `paidAmount` decimal(10,2) DEFAULT 0.00,
  `paidOn` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_loan_payment`
--

INSERT INTO `t_loan_payment` (`intId`, `loanId`, `loanAmount`, `paymentDate`, `paymentStaus`, `paidAmount`, `paidOn`) VALUES
(1, 1, '3000.00', '2022-08-25 00:00:00', 0, '0.00', NULL),
(2, 1, '3000.00', '2022-09-01 00:00:00', 0, '0.00', NULL),
(3, 1, '3000.00', '2022-09-08 00:00:00', 0, '0.00', NULL),
(4, 1, '3000.00', '2022-09-15 00:00:00', 0, '0.00', NULL),
(5, 1, '3000.00', '2022-09-22 00:00:00', 0, '0.00', NULL),
(6, 2, '10000.00', '2022-08-25 00:00:00', 1, '10000.00', '2022-08-18 09:39:58'),
(7, 2, '10000.00', '2022-09-01 00:00:00', 1, '10000.00', '2022-08-18 09:40:36'),
(8, 2, '10000.00', '2022-09-08 00:00:00', 1, '10000.00', '2022-08-18 09:40:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_loan`
--
ALTER TABLE `t_loan`
  ADD PRIMARY KEY (`intId`);

--
-- Indexes for table `t_loan_payment`
--
ALTER TABLE `t_loan_payment`
  ADD PRIMARY KEY (`intId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_loan`
--
ALTER TABLE `t_loan`
  MODIFY `intId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_loan_payment`
--
ALTER TABLE `t_loan_payment`
  MODIFY `intId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
