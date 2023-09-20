-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2023 at 05:05 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `basic_banking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `current_balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `email`, `current_balance`) VALUES
(1, 'Omar Alaa', 'omar.alaa11@mail.com', '4451.00'),
(2, 'Ahmed Essam', 'ahmed.essam15@gmail.com', '5549.00'),
(3, 'John Magdy', 'john.magdy21@yahoo.com', '1200.00'),
(4, 'Mohamed Ali', 'mohamed.ali545@mail.com', '5500.00'),
(5, 'Kareem Mohamed', 'kareem.mohamed213@gmail.com', '3100.00'),
(6, 'Ola Gamal', 'ola.gamal12@yahoo.com', '3400.00'),
(7, 'Ziad Khaled', 'ziad.khaled888@mail.com', '2800.00'),
(8, 'Yossef Karam', 'yossef.karam189@gmail.com', '7100.00'),
(9, 'Ahmed Khaled', 'ahmed.khaled541@yahoo.com', '4700.00'),
(10, 'Esraa Fahmy', 'esraa.fahmy365@mail.com', '3000.00');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `transfer_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`transfer_id`, `sender_id`, `receiver_id`, `amount`, `timestamp`) VALUES
(1, 1, 5, '1000.00', '2023-09-19 13:33:59'),
(2, 5, 3, '300.00', '2023-09-19 13:35:01'),
(3, 1, 2, '500.00', '2023-09-19 14:56:20'),
(4, 1, 9, '100.00', '2023-09-19 15:01:22'),
(5, 1, 1, '100.00', '2023-09-19 15:09:05'),
(6, 1, 2, '100.00', '2023-09-19 15:55:32'),
(7, 1, 2, '50.00', '2023-09-19 16:11:44'),
(8, 1, 3, '0.00', '2023-09-20 11:03:21'),
(9, 1, 2, '-1.00', '2023-09-20 11:07:32'),
(10, 4, 5, '100.00', '2023-09-20 11:56:25'),
(11, 8, 2, '100.00', '2023-09-20 11:57:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`transfer_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `transfer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `transfers_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `customers` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
