-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2024 at 06:34 PM
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
-- Database: `weather`
--

-- --------------------------------------------------------

--
-- Table structure for table `weather_api`
--

CREATE TABLE `weather_api` (
  `ID` int(11) NOT NULL,
  `location_searched` varchar(255) NOT NULL,
  `time_searched` time(6) NOT NULL,
  `temperature` decimal(5,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `weather_icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weather_api`
--

INSERT INTO `weather_api` (`ID`, `location_searched`, `time_searched`, `temperature`, `description`, `weather_icon`) VALUES
(11, 'london', '14:18:51.000000', 11.32, 'broken clouds', '04d'),
(12, 'paris', '14:18:56.000000', 10.20, 'light rain', '10d'),
(13, 'milan', '14:19:00.000000', 9.49, 'light rain', '10d'),
(14, 'new york', '14:19:04.000000', 5.97, 'fog', '50d'),
(15, 'kuala lumpur', '14:19:14.000000', 26.73, 'few clouds', '02n'),
(16, 'dubai', '14:19:21.000000', 22.23, 'clear sky', '01d'),
(17, 'melborne', '14:19:27.000000', 16.60, 'overcast clouds', '04d'),
(18, 'lagos, nigeria', '15:08:22.000000', 35.67, 'clear sky', '01d'),
(19, 'california', '16:08:10.000000', 13.70, 'clear sky', '01d'),
(20, 'lagos, nigera', '16:08:28.000000', 34.51, 'clear sky', '01d'),
(21, 'cairo', '16:09:34.000000', 20.42, 'few clouds', '02d'),
(22, 'London', '16:11:22.000000', 11.29, 'broken clouds', '04d'),
(23, 'dakar, senegal', '16:13:04.000000', 34.49, 'clear sky', '01d'),
(24, 'tulum, mexico', '16:28:39.000000', 24.75, 'light rain', '10d'),
(25, 'peru, chile', '16:30:36.000000', 3.78, 'clear sky', '01d'),
(26, 'london', '16:33:56.000000', 11.27, 'broken clouds', '04d'),
(27, 'alaska', '16:39:23.000000', -14.41, 'overcast clouds', '04n'),
(28, 'london', '17:08:05.000000', 10.90, 'light rain', '10d'),
(29, 'hong kong', '17:17:17.000000', 14.49, 'scattered clouds', '03n'),
(30, 'london', '18:21:17.000000', 10.21, 'moderate rain', '10n'),
(31, 'dublin', '18:25:21.000000', 9.00, 'clear sky', '01d'),
(32, 'berlin', '18:58:34.000000', 10.06, 'clear sky', '01n'),
(33, 'paris', '19:08:21.000000', 7.50, 'light rain', '10n'),
(35, 'vienna, austria', '17:59:57.000000', 10.27, 'clear sky', '01n'),
(36, 'dubai', '18:09:01.000000', 19.00, 'light rain', '10n'),
(37, 'sydney ', '18:10:12.000000', 21.45, 'scattered clouds', '03n'),
(38, 'milan', '18:10:37.000000', 10.66, 'few clouds', '02n'),
(39, 'zagreb', '18:21:37.000000', 10.11, 'few clouds', '02n'),
(40, 'new york', '18:21:45.000000', 6.92, 'clear sky', '01d'),
(41, 'london', '18:34:22.000000', 7.49, 'clear sky', '01n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `weather_api`
--
ALTER TABLE `weather_api`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `weather_api`
--
ALTER TABLE `weather_api`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
