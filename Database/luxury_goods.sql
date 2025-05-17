-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2025 at 02:53 PM
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
-- Database: `luxury_goods`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `make` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `fuel` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `mainimage` varchar(255) DEFAULT NULL,
  `dealer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `make`, `model`, `year`, `fuel`, `price`, `description`, `mainimage`, `dealer_id`) VALUES
(1, 'Toyota', 'Camry', 2020, 'Petrol', 25000000.00, 'A reliable and fuel-efficient sedan.', 'images/toyota_camry.avif', 1),
(2, 'Honda', 'Civic', 2021, 'Diesel', 9700000.00, 'A stylish and performance-focused compact car. ', 'images/honda_civic.jpg', 2),
(3, 'Ford', 'Focus', 2019, 'Hybrid', 10000000.00, 'An eco-friendly car with excellent handling.', 'images/ford_focus.jpg', 4),
(4, 'BMW', '3 Series', 2022, 'Electric', 24500000.00, 'A luxury electric car with cutting-edge features.', 'images/bmw_3series.jpg', 5),
(5, 'Audi', 'A4', 2021, 'Petrol', 14000000.00, 'Audi A4 is a compact luxury sedan combining performance, safety features, and a premium interior.', 'images/audi_a4.avif', 3),
(6, 'Byd', 'Model 8', 2020, 'Electric', 25000000.00, 'The BYD Model 8 is an all-electric sedan with a sleek design, offering excellent range, advanced safety features, and a comfortable ride. 123', 'images/BYD-Song-L-2024.jpg', 3),
(8, 'Byd', 'Song Plus 25', 2025, 'Electric', 30000000.00, 'The BYD song-plus-dmi-en is an all-electric sedan with a sleek design, offering excellent range, advanced safety features, and a comfortable ride.', 'images/BYD-Song-L-Side-Single-BYD.webp', 3),
(9, 'Toyota ', 'KDH', 2021, 'Diesel', 14500000.00, 'The Toyota KDH is a versatile diesel-powered van designed for commercial use, offering spacious interiors, durability, and great fuel efficiency.', 'images/KDH.jpg', 2),
(10, 'Benz', 'C-Class', 2020, 'Electric', 25000000.00, 'The Mercedes-Benz C-Class offers elegance and comfort with a smooth drive and high-end technology.\"\r\n ', 'images/Mercedes-Benz-C-Class-Review-web.jpg', 5),
(11, 'Ford', 'Mustang', 2020, 'Diesel', 30000000.00, 'The Ford Mustang is an iconic American muscle car with a V8 engine and thrilling performance capabilities. test', 'images/2022-ford-mustang-shelby-gt500-02-1636734552.jpg', 1),
(12, 'Honda', 'Insight ', 2020, 'Petrol', 11000000.00, 'The Honda insight is an iconic American muscle car with a V8 engine and thrilling performance capabilities', 'images/01_l3.jpg', 4),
(13, 'Mitsubishi', 'Outlander', 2022, 'Diesel', 14500000.00, 'The Mitsubishi Outlander is a mid-sized SUV with a spacious interior, a variety of seating configurations, and a range of engine options. It has a classic design with chiseled lines and a distinctive rear design. ', 'images/2024-mitsubishi-outlander-phev-gallery-tw.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Pasindu', 'Pasinavod@gmail.com', 'sdak asdksfs', '2025-01-16 15:08:50'),
(2, 'Pasindu', 'Pasinavod@gmail.com', 'sdak asdksfs', '2025-01-16 17:06:25');

-- --------------------------------------------------------

--
-- Table structure for table `dealers`
--

CREATE TABLE `dealers` (
  `dealer_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dealers`
--

INSERT INTO `dealers` (`dealer_id`, `name`, `phone`, `email`, `username`, `password`) VALUES
(1, 'Best Car Deals', '071-456-7890', 'contact@bestcardeals.com', 'testb', 'testb'),
(2, 'AutoWorld', '076-654-3210', 'info@autoworld.com', 'testa', 'testa'),
(3, 'City Motors', '011-123-4567', 'support@citymotors.com', 'testd', 'testd'),
(4, 'United Motors', '031-987-6543', 'sales@luxuryrides.com', 'testc', 'testc'),
(5, 'Car Paradise ', '074-555-4321', 'info@carkingdom.com', 'teste', 'teste');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `phone`, `email`, `username`, `password`) VALUES
(1, 'Pasindu', '0761867694', 'pasinavod@gmail.com', 'test', 'test\r\n'),
(2, 'senesh', '0785493049', 'Sene@malee.com', 'sene', '123sene'),
(5, 'Navodya', '0785493049', '123@345.com', 'pasindu', '123pasi'),
(6, 'Pasindu Navodya', '0785493049', 'Pasindu@navodya.com', 'test1', 'test1'),
(7, 'Salinda', '0761282981', 'salinda@ccs.sab.ac.lk', 'salinda', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dealer` (`dealer_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dealers`
--
ALTER TABLE `dealers`
  ADD PRIMARY KEY (`dealer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dealers`
--
ALTER TABLE `dealers`
  MODIFY `dealer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `fk_dealer` FOREIGN KEY (`dealer_id`) REFERENCES `dealers` (`dealer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
