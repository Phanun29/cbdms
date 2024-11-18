-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2024 at 09:13 AM
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
-- Database: `db_cbdms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_corn_breeding_data`
--

CREATE TABLE `tbl_corn_breeding_data` (
  `cbd_id` int(11) NOT NULL,
  `name_of_cut_corn_variety` text NOT NULL,
  `users_id` int(10) NOT NULL,
  `first_corn_variety` int(10) NOT NULL,
  `second_corn_variety` int(10) NOT NULL,
  `version` varchar(50) NOT NULL,
  `កម្ពស់ផ្លែ` text DEFAULT NULL,
  `កម្ពស់ដើម` text DEFAULT NULL,
  `អាយុចេញផ្កាញី` text DEFAULT NULL,
  `អាយុចេញផ្កាឈ្មោល` text DEFAULT NULL,
  `អត្រាដំណុះ` text DEFAULT NULL,
  `អត្រាកើត albino` text DEFAULT NULL,
  `កម្រិតបំផ្លាញរបស់ដង្កូវ` text DEFAULT NULL,
  `ភាពរឹងមាំ` text DEFAULT NULL,
  `ដង្កូវ` text DEFAULT NULL,
  `គម្លាតអាយុផ្កាញីនិងឈ្មោល` text DEFAULT NULL,
  `ចំនួនទងផ្កាឈ្មោល` text DEFAULT NULL,
  `ប្រវែងទងផ្កាឈ្មោល` text DEFAULT NULL,
  `ប្រវែងផ្លែទាំងសំបក` text DEFAULT NULL,
  `ភាពមានកន្ទុយលើចុងផ្លែ` text DEFAULT NULL,
  `ភាពជាប់ផ្លែ` text DEFAULT NULL,
  `កើតជំងឺ Seuthern rast` text DEFAULT NULL,
  `កម្រិតការកើតជំងឺ` text DEFAULT NULL,
  `ប្រវែងគល់ផ្លែ` text DEFAULT NULL,
  `ប្រព័ន្ធឬស` text DEFAULT NULL,
  `ចំនួនដើមរលំ` text DEFAULT NULL,
  `មុំស្លឹក` text DEFAULT NULL,
  `ទំហំដើម` text DEFAULT NULL,
  `អង្កត់ផ្ចិតផ្លែបកសំបក` text DEFAULT NULL,
  `ប្រវែងផ្លែបកសំបក` text DEFAULT NULL,
  `ចំនួនជួរគ្រាប់ក្នុងមួយផ្លែ` text DEFAULT NULL,
  `ចំនួនគ្រាប់ក្នុងមួយជួរ` text DEFAULT NULL,
  `ការរៀងជួររបស់គ្រាប់` text DEFAULT NULL,
  `រូបរាងផ្លែ` text DEFAULT NULL,
  `ពណ៌គ្រាប់` text DEFAULT NULL,
  `ភាពរឹងមាំរបស់កូន` text DEFAULT NULL,
  `រាងជួរបស់គ្រាប់` text DEFAULT NULL,
  `សំបកផ្លែ` text DEFAULT NULL,
  `ទម្ងន់` text DEFAULT NULL,
  `ចំនួនជួរក្នុងមួយផ្លែ` text DEFAULT NULL,
  `ប្រវែងចុងស្នៀត` text DEFAULT NULL,
  `ប្រវែងផ្លែ` text DEFAULT NULL,
  `ចំនួនឬស` text DEFAULT NULL,
  `ចំនួនទងផ្កា` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_corn_breeding_data`
--

INSERT INTO `tbl_corn_breeding_data` (`cbd_id`, `name_of_cut_corn_variety`, `users_id`, `first_corn_variety`, `second_corn_variety`, `version`, `កម្ពស់ផ្លែ`, `កម្ពស់ដើម`, `អាយុចេញផ្កាញី`, `អាយុចេញផ្កាឈ្មោល`, `អត្រាដំណុះ`, `អត្រាកើត albino`, `កម្រិតបំផ្លាញរបស់ដង្កូវ`, `ភាពរឹងមាំ`, `ដង្កូវ`, `គម្លាតអាយុផ្កាញីនិងឈ្មោល`, `ចំនួនទងផ្កាឈ្មោល`, `ប្រវែងទងផ្កាឈ្មោល`, `ប្រវែងផ្លែទាំងសំបក`, `ភាពមានកន្ទុយលើចុងផ្លែ`, `ភាពជាប់ផ្លែ`, `កើតជំងឺ Seuthern rast`, `កម្រិតការកើតជំងឺ`, `ប្រវែងគល់ផ្លែ`, `ប្រព័ន្ធឬស`, `ចំនួនដើមរលំ`, `មុំស្លឹក`, `ទំហំដើម`, `អង្កត់ផ្ចិតផ្លែបកសំបក`, `ប្រវែងផ្លែបកសំបក`, `ចំនួនជួរគ្រាប់ក្នុងមួយផ្លែ`, `ចំនួនគ្រាប់ក្នុងមួយជួរ`, `ការរៀងជួររបស់គ្រាប់`, `រូបរាងផ្លែ`, `ពណ៌គ្រាប់`, `ភាពរឹងមាំរបស់កូន`, `រាងជួរបស់គ្រាប់`, `សំបកផ្លែ`, `ទម្ងន់`, `ចំនួនជួរក្នុងមួយផ្លែ`, `ប្រវែងចុងស្នៀត`, `ប្រវែងផ្លែ`, `ចំនួនឬស`, `ចំនួនទងផ្កា`) VALUES
(79, 'Namvang x Pumpoy s12', 3, 43, 18, 's12', '1', '2', '3', '4', '5', NULL, '7', '8', '9', '10', '11', '12', '13', '14', '15', NULL, '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38'),
(81, 'Namvang x Violet s23', 3, 43, 46, 's23', '9', '7', '6', '6', '', NULL, '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_corn_breeding_data_images`
--

CREATE TABLE `tbl_corn_breeding_data_images` (
  `id` int(11) NOT NULL,
  `cbd_id` int(11) NOT NULL,
  `image_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_corn_breeding_data_images`
--

INSERT INTO `tbl_corn_breeding_data_images` (`id`, `cbd_id`, `image_path`) VALUES
(57, 81, '../uploads/81/673af4cfb6ff8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_corn_varieties`
--

CREATE TABLE `tbl_corn_varieties` (
  `id` int(11) NOT NULL,
  `corn_varieties_name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_corn_varieties`
--

INSERT INTO `tbl_corn_varieties` (`id`, `corn_varieties_name`, `status`) VALUES
(18, 'Pumpoy', 0),
(28, '8 pew', 0),
(43, 'Namvang', 0),
(44, 'Samly', 0),
(45, 'Bigwhith', 0),
(46, 'Violet', 0),
(169, 'big bom', 0),
(211, 'Namvang x Pumpoy s12', 1),
(213, 'Namvang x Violet s23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `users_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_type` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`users_id`, `first_name`, `last_name`, `username`, `password`, `email`, `phone_number`, `image`, `user_type`, `status`, `created_at`) VALUES
(3, '', 'Admin', 'admin', '$2y$10$lfmToY2Fdeacoa8mtyuRHOFW4eY0Ksa.60HnRP5XYl1nRwGKKeJOe', 'nun@gmail.com', '', '../profile_image/673af60f6176e.1731917327_6727290042230.1730619648_blank_profile.jpg', 'admin', 'active', '2024-11-18 08:08:47'),
(7, '', 'User', 'user', '$2y$10$5IXPfugT0On.qfO4whZu0unVBH.leu9hQNzGyNwz.pOmjLkCJnk3a', 'user@gmail.com', '', '../profile_image/6727290042230.1730619648_blank_profile.jpg', 'user', 'active', '2024-11-18 06:17:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_corn_breeding_data`
--
ALTER TABLE `tbl_corn_breeding_data`
  ADD PRIMARY KEY (`cbd_id`),
  ADD KEY `name_of_cut_corn_variety` (`name_of_cut_corn_variety`(768)),
  ADD KEY `add_by` (`users_id`),
  ADD KEY `tbl_ticket_ibfk_1` (`first_corn_variety`),
  ADD KEY `tbl_ticket_ibfk_2` (`second_corn_variety`);

--
-- Indexes for table `tbl_corn_breeding_data_images`
--
ALTER TABLE `tbl_corn_breeding_data_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cbd_id` (`cbd_id`);

--
-- Indexes for table `tbl_corn_varieties`
--
ALTER TABLE `tbl_corn_varieties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `corn_varieties_name` (`corn_varieties_name`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`users_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_corn_breeding_data`
--
ALTER TABLE `tbl_corn_breeding_data`
  MODIFY `cbd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `tbl_corn_breeding_data_images`
--
ALTER TABLE `tbl_corn_breeding_data_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tbl_corn_varieties`
--
ALTER TABLE `tbl_corn_varieties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_corn_breeding_data`
--
ALTER TABLE `tbl_corn_breeding_data`
  ADD CONSTRAINT `tbl_ticket_ibfk_29_id` FOREIGN KEY (`users_id`) REFERENCES `tbl_users` (`users_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_ticket_ibfk_29_second` FOREIGN KEY (`second_corn_variety`) REFERENCES `tbl_corn_varieties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_ticket_ibfk_fiirst` FOREIGN KEY (`first_corn_variety`) REFERENCES `tbl_corn_varieties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_corn_breeding_data_images`
--
ALTER TABLE `tbl_corn_breeding_data_images`
  ADD CONSTRAINT `tbl_corn_breeding_data_images_ibfk_1` FOREIGN KEY (`cbd_id`) REFERENCES `tbl_corn_breeding_data` (`cbd_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
