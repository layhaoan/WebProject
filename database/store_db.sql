-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2025 at 12:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `types` varchar(210) NOT NULL,
  `status` varchar(210) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(120) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `types`, `status`, `price`, `description`, `image`) VALUES
(4, 'ប្រហិតសាច់គោខ្មែរ', 'ប្រហិតសាច់គោខ្មែរ', 'In Stock', 5, 'ថ្ងៃសៅរ៍ចុងសប្ដាហ៍មានការជួបជុំ កុំភ្លេចប្រហិតសាច់គោប្រហិតសាច់គោបងម៉ានីណា ធានាថាបានញុំាហើយជាប់មាត់ ចង់ញុំាទៀតម៉ង', '543162358_122138688002884743_3120835678739377650_n.jpg'),
(5, 'Tours', 'Tours', 'Explore', 13, 'The beach is beautiful for travel and discover', 'andrew-coelho-m6tAqZvy4RM-unsplash.jpg'),
(6, 'Temple', 'Tours', 'Other', 12, 'Temple buildig some thouthand years in cambodia for respect to buddist', 'allphoto-bangkok-gWibfY1Gmwc-unsplash.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_email` varchar(210) NOT NULL,
  `customer_phone` int(11) NOT NULL,
  `customer_address` varchar(210) NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `total_amount`, `total`, `order_date`) VALUES
(3, 'Sandy beaches', 'st12@gmail.com', 967696345, 'Street 58P, Kok kleang Village in Phnom Penh', NULL, 50.30, '2025-09-15 10:26:44'),
(4, 'Haoan', 'haoan12@gmail.com', 967696345, 'Kok kleang, Dey hoy,', NULL, 19.09, '2025-09-15 10:30:23'),
(5, 'Njonh', 'nj@gmail.com', 967696345, 'Phnom Penh Hanoi Friendship Blvd (1019), Phnom Penh 12255', NULL, 45.00, '2025-09-15 14:47:31');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `cost_price` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_name`, `quantity`, `price`, `cost_price`, `subtotal`, `image`) VALUES
(4, 3, 'ប្រហិតសាច់គោខ្មែរ', 3, 5.10, 0, 15, ''),
(5, 3, 'Angkor Wat', 1, 35.00, 0, 35, ''),
(6, 4, 'ប្រហិតសាច់គោខ្មែរ', 1, 5.10, 0, 5, ''),
(7, 4, 'សាប៊ូបោកសម្លៀកបំពាក់ AREX', 1, 13.99, 0, 14, ''),
(8, 5, 'Tours', 1, 45.00, 0, 45, '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `types` varchar(40) NOT NULL,
  `qaunlity` int(40) NOT NULL,
  `description` varchar(210) NOT NULL,
  `discount` int(20) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `types`, `qaunlity`, `description`, `discount`, `status`, `image`, `created_at`) VALUES
(24, 'ប្រហិតសាច់គោខ្មែរ', 5.10, 'Food', 12, 'ធ្វើអីក៏ឆ្ងាញ់ ប្រហិតសាច់គោខ្មែរសុទ្ធ ផលិតដោយកូនខ្មែរ គាំទ្រផលិតផលក្នុងស្រុក ជួយសេដ្ឋកិច្ចជាតិ', 10, 'Sales', '544908975_122138687462884743_2470948001708929890_n.jpg', '2025-09-10 07:42:45'),
(25, 'សាប៊ូបោកសម្លៀកបំពាក់ AREX', 13.99, 'សាប៊ូបោកខោអាវ', 12, 'អស់បារម្ភរឿងស្នាមប្រឡាក់ បងប្អូនសាកប្រើម្ដងដឹងតែជាប់ចិត្តហ្មង សាប៊ូបោកសម្លៀកបំពាក់ AREX គុណភាពល្អ ស្តង់ដាអ៉ឺរ៉ុប', 12, 'Sales', '545329227_1338951268234529_5256804620061393594_n.jpg', '2025-09-10 07:45:52'),
(27, 'Poster Design', 15.00, 'Poster', 1, 'Create poster for use upload to social media like Facebook, Instagram,', 10, 'New', 'Instagram post - 1 (1).png', '2025-09-10 07:54:37'),
(29, 'Angkor Wat', 35.00, 'Tours', 10, 'Angkor, also known as Yasodharapura, was the capital city of the Khmer Empire, located in present-day Cambodia. The city and empire flourished from approximately the 9th to the 15th centuries.', 10, 'New', 'roth-chanvirak-7KQmtTT1DPU-unsplash.jpg', '2025-09-10 08:13:18'),
(30, 'Sandy beaches', 45.00, 'Tours', 1, 'A beach is a landform characterized by loose particles, such as sand, pebbles, or shells, that form along a body of water, separating it from inland areas.', 10, 'New', 'clem-onojeghuo-7rrgPPljqYU-unsplash.jpg', '2025-09-10 08:15:46'),
(31, 'Phnom Penh City', 50.00, 'Tours', 12, 'Phnom Penh, Cambodia’s busy capital, sits at the junction of the Mekong and Tonlé Sap rivers. It was a hub for both the Khmer Empire and French colonialists. On its walkable riverfront, lined with parks, restau', 8, 'New', 'allphoto-bangkok-snsPfG7tIcA-unsplash.jpg', '2025-09-10 08:18:21'),
(32, 'Mountain', 50.00, 'Tours', 1, 'Combine a visit to the ancient royal capital of Mt Oudong with a sightseeing tour of Phnom Penh on this full-day tour.', 20, 'Other', 'dario-jud-7eeTeRSxY0g-unsplash.jpg', '2025-09-10 08:27:22'),
(34, 'Tours', 22.00, 'Tours', 1, 'Angkor National Museum will take visitors through the journey back in time from the creation to the highest point of Khmer civilization.', 12, 'New', 'YC-National-Museum-00734.jpg', '2025-09-10 09:10:58'),
(35, 'Tours', 20.00, 'Tours', 1, 'Combine a visit to the ancient royal capital of Mt Oudong with a sightseeing tour of Phnom Penh on this full-day tour.', 10, 'Explore', 'alex-santiago-CPv7g7CK-K0-unsplash.jpg', '2025-09-10 09:20:29'),
(36, 'Tours', 45.00, 'Tours', 1, 'A beach is a landform characterized by loose particles, such as sand, pebbles, or shells, that form along a body of water, separating it from inland areas.', 11, 'Explore', 'samielle-stoyl-q2rFjBBheIE-unsplash.jpg', '2025-09-10 09:21:06'),
(37, 'Temple', 5.10, 'Tours', 1, 'Angkor, also known as Yasodharapura, was the capital city of the Khmer Empire, located in present-day Cambodia. The city and empire flourished from approximately the 9th to the 15th centuries.', 12, 'Other', 'allphoto-bangkok-gWibfY1Gmwc-unsplash.jpg', '2025-09-10 09:22:10'),
(39, 'Tours', 20.00, 'Tours', 1, 'Combine a visit to the ancient royal capital of Mt Oudong with a sightseeing tour of Phnom Penh on this full-day tour.', 10, 'Other', 'dawn-lio-rTlvynvA_uQ-unsplash.jpg', '2025-09-11 09:30:57'),
(41, 'Sandy beaches', 45.00, 'Tours', 1, 'A beach is a landform characterized by loose particles, such as sand, pebbles, or shells, that form along a body of water, separating it from inland areas.', 10, 'Other', 'aritra-roy-Pd-t0rv-u4Y-unsplash.jpg', '2025-09-11 09:32:40'),
(42, 'Tours', 45.00, 'Tours', 1, 'Combine a visit to the ancient royal capital of Mt Oudong with a sightseeing tour of Phnom Penh on this full-day tour.Combine a visit to the ancient royal capital of Mt Oudong with a sightseeing tour of Phnom P', 12, 'Explore', 'karsten-winegeart-613pTZEFf2U-unsplash.jpg', '2025-09-11 09:33:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
