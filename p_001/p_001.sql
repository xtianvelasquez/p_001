-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2024 at 05:59 PM
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
-- Database: `p_001`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE `admin_info` (
  `ad_username` varchar(100) DEFAULT NULL,
  `ad_password` varchar(100) DEFAULT NULL,
  `ad_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_info`
--

INSERT INTO `admin_info` (`ad_username`, `ad_password`, `ad_name`) VALUES
('admin', 'adminpassword', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `customer_info`
--

CREATE TABLE `customer_info` (
  `customer_id` int(5) UNSIGNED ZEROFILL NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `age` int(5) DEFAULT NULL,
  `contact_num` varchar(15) DEFAULT NULL,
  `email_add` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_info`
--

INSERT INTO `customer_info` (`customer_id`, `first_name`, `last_name`, `age`, `contact_num`, `email_add`) VALUES
(00020, 'Karen', 'Escarcha', 19, '+639123456789', 'karen_escarcha@gmail.com'),
(00021, 'Cassandra', 'Elizalde', 18, '+639123456789', 'cassy.eli@gmail.com'),
(00022, 'Carissa', 'Gernale', 23, '+639123456789', 'carissagenrale198@gmail.com'),
(00026, 'Camille', 'Razal', 31, '+631234567890', 'camillerzl@gmail.com'),
(00027, 'Jerold', 'Razal', 35, '+639123456789', 'jrldrzl@gmail.com'),
(00028, 'Jerold', 'Razal', 35, '+639123456789', 'jrldrzl@gmail.com'),
(00029, 'Jerold', 'Razal', 35, '+639123456789', 'jrldrzl@gmail.com'),
(00030, 'Christian', 'Velasquez', 21, '+639123456789', 'christian.velasquez.1220@gmail.com'),
(00034, 'Camille', 'Razal', 30, '+631234567890', 'camillerzl@gmail.com'),
(00037, 'Christian', 'Velasquez', 21, '+639123456789', 'christian.velasquez.1220@gmail.com'),
(00038, 'Karina', 'Magat', 18, '+639123456789', 'kamagat2017@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_info`
--

CREATE TABLE `reservation_info` (
  `reservation_id` int(5) UNSIGNED ZEROFILL NOT NULL,
  `reservation_date` date DEFAULT NULL,
  `reservation_time` varchar(10) DEFAULT NULL,
  `num_guest` int(5) DEFAULT NULL,
  `reservation_floor` varchar(10) DEFAULT NULL,
  `reservation_table` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation_info`
--

INSERT INTO `reservation_info` (`reservation_id`, `reservation_date`, `reservation_time`, `num_guest`, `reservation_floor`, `reservation_table`) VALUES
(00020, '2024-02-10', '10:30 AM', 12, 'Floor 2', 'Table 5'),
(00021, '2024-02-14', '6:00 PM', 2, 'Floor 3', 'Table 1'),
(00022, '2024-02-24', '11:00 AM', 4, 'Floor 1', 'Table 1'),
(00026, '2024-02-26', '2:00 PM', 5, 'Floor 3', 'Table 8'),
(00027, '2024-02-10', '5:30 PM', 6, 'Floor 2', 'Table 10'),
(00028, '2024-02-28', '6:00 PM', 6, 'Floor 2', 'Table 9'),
(00029, '2024-02-21', '5:30 PM', 6, 'Floor 1', 'Table 5'),
(00030, '2024-02-15', '1:00 PM', 10, 'Floor 2', 'Table 2'),
(00034, '2024-02-10', '5:30 PM', 7, 'Floor 3', 'Table 1'),
(00037, '2024-02-17', '10:00 AM', 3, 'Floor 2', 'Table 2'),
(00038, '2024-03-06', '12:00 PM', 1, 'Floor 2', 'Table 2');

-- --------------------------------------------------------

--
-- Table structure for table `terms_conditions`
--

CREATE TABLE `terms_conditions` (
  `tc_num` int(11) DEFAULT NULL,
  `tc_title` varchar(1000) DEFAULT NULL,
  `tc_description` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terms_conditions`
--

INSERT INTO `terms_conditions` (`tc_num`, `tc_title`, `tc_description`) VALUES
(1, 'Customer Arrival', 'To provide the highest level of service for all of our customers, we kindly ask that you arrive prepared to be seated at the time of your reservation. After being detained for ten minutes, the table might be given to another customer.'),
(2, 'Notification', 'We will notify you by email or text message a day before your reservation about your pending reservation at our restaurant.'),
(3, 'Outsider Foods', 'Outside food and beverages are not allowed inside our restaurant, but we do permit food from our restaurants to be taken out.'),
(4, 'Number of Guest/s', 'The number of guest/s who attend your reservation that exceeds the number of guest/s you select into our reservation form will be charged PHP 100 per head. Likewise, any damage to the property of our restaurant caused by customers will be charged accordingly as well.'),
(5, 'Cancelation Policy', 'There is strictly no cancellation of reservations. However, if absolutely needed, please contact us 5 hours or more before the time of reservation; this is for us to allocate your slots to other customers.'),
(6, 'Customer Personal Information', 'our first and last name, age, contact number, email address, home address, and allergies are among the personally identifiable data we will gather. BenHub will use your data in a private manner and will only use it for appropriate business purposes.'),
(7, 'Personal Information Security', 'We will only keep your personal information for as long as it takes to complete the tasks for which it was originally obtained. After our transactions, we will quickly remove it. Additionally, we\'ll implement technical security measures to prevent the loss, unauthorized use, or alteration of your personal data.'),
(8, 'Third Party Websites', 'The privacy policies or procedures of websites operated by third parties are not subject to our control. As a result, you should make sure to read the relevant privacy policies before visiting such sites since we have no control over the data that is sent to or collected by these third parties.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_info`
--
ALTER TABLE `customer_info`
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `reservation_info`
--
ALTER TABLE `reservation_info`
  ADD PRIMARY KEY (`reservation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservation_info`
--
ALTER TABLE `reservation_info`
  MODIFY `reservation_id` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_info`
--
ALTER TABLE `customer_info`
  ADD CONSTRAINT `customer_info_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `reservation_info` (`reservation_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
