-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2024 at 02:24 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hinoyog`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `product_name`, `price`, `total`, `payment_method`, `created_at`, `product_id`) VALUES
(34, 'Realme 12', 9000.00, 9000.00, 'GCash', '2024-06-03 04:24:00', 12);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `rrp` decimal(10,0) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL,
  `img` text NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `price`, `rrp`, `quantity`, `img`, `date_added`, `user_id`) VALUES
(13, 'Keihen Carburetor', 'Slide type where a cable or linkage lifts the air control slide with its attached fuel metering needle.', 500, 600, 15, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQDUHT5uHCiuNlxM1UgxIbZBp49jvPdso1c8g&s', '2024-06-03 20:13:08', 0),
(14, 'Shock Absorber', 'Pump-like devices which keep your vehicle\'s tires in contact with the road surface by controlling the rebound of its suspension springs.', 1200, 1350, 10, 'data:image/jpeg;base64,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', '2024-06-03 20:17:38', 0),
(15, 'Brake Pod', 'Brake pads are a component of disc brakes used in automotive and other applications.', 550, 700, 20, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZD5La4iqawhOWCnwPl87o8C2apgsMXO018w&s', '2024-06-03 20:18:55', 0),
(16, 'Leo Tire', 'Leo Tire keeps on creating and developing new designs and sizes in order to meet the demands of the various riders and users as well as the demands of various OEM companies.', 600, 900, 20, 'https://media.karousell.com/media/photos/products/2020/7/28/leo_tire_1595919611_7d1cb2f8_progressive.jpg', '2024-06-03 20:21:36', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `created_at`) VALUES
(5, 'rushel', '$2y$10$aCOnY6pmuuvwxFtrSIuEEePdYhvn2tfbcoxkkaphamSw6urkYOvpC', '2024-06-03 20:10:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
