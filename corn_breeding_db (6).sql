-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2024 at 03:00 PM
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
-- Database: `corn_breeding_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_corn_breeding_data`
--

CREATE TABLE `tbl_corn_breeding_data` (
  `cbd_id` int(11) NOT NULL,
  `name_of_cut_corn_variety` varchar(100) NOT NULL,
  `users_id` int(50) NOT NULL,
  `first_corn_variety` int(50) NOT NULL,
  `second_corn_variety` int(50) NOT NULL,
  `version` varchar(50) NOT NULL,
  `fruit_height` varchar(20) NOT NULL,
  `stem_height` varchar(20) NOT NULL,
  `flower_day` varchar(20) NOT NULL,
  `male_flowering_day` varchar(20) NOT NULL,
  `flowering_age_gap` varchar(10) DEFAULT NULL,
  `number_of_stalks` varchar(10) DEFAULT NULL,
  `number_of_male_flower_stalks` varchar(10) DEFAULT NULL,
  `male_flowering_age` varchar(10) DEFAULT NULL,
  `flowering_age` varchar(10) DEFAULT NULL,
  `leaf_angle` varchar(10) DEFAULT NULL,
  `the_tail_on_the_end_of_the_fruit` varchar(11) DEFAULT NULL,
  `fruit_length` varchar(10) DEFAULT NULL,
  `fertility` varchar(10) DEFAULT NULL,
  `original_size` varchar(11) DEFAULT NULL,
  `stem_length` varchar(10) DEFAULT NULL,
  `root_system` varchar(10) DEFAULT NULL,
  `germination_rate` varchar(10) DEFAULT NULL,
  `albino_birth_level` varchar(11) DEFAULT NULL,
  `worm_damage_level` varchar(11) DEFAULT NULL,
  `strength` varchar(11) DEFAULT NULL,
  `age_gap_between_male_and_female_flowers` varchar(11) DEFAULT NULL,
  `seuthern_rast` varchar(11) DEFAULT NULL,
  `peeled_fruit_diameter` varchar(11) NOT NULL,
  `disease_level` varchar(11) DEFAULT NULL COMMENT 'not sure',
  `peel_length` varchar(11) DEFAULT NULL,
  `number_of_rows_of_seeds_per_fruit` varchar(11) DEFAULT NULL,
  `fruit_peel` varchar(11) DEFAULT NULL,
  `weight` varchar(11) DEFAULT NULL,
  `worm` varchar(11) DEFAULT NULL,
  `seedling_vigor` varchar(10) DEFAULT NULL,
  `row_of_corn_kernels` varchar(10) DEFAULT NULL,
  `number_of_roots` varchar(10) DEFAULT NULL,
  `tip_length` varchar(100) DEFAULT NULL,
  `total` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_corn_breeding_data_images`
--

CREATE TABLE `tbl_corn_breeding_data_images` (
  `id` int(11) NOT NULL,
  `cbd_id` int(11) NOT NULL,
  `image_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(169, 'big bom', 0);

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
(3, 'phanun', 'sok', 'admin', '$2y$10$lfmToY2Fdeacoa8mtyuRHOFW4eY0Ksa.60HnRP5XYl1nRwGKKeJOe', 'nun@gmail.com', '0123456789', '../profile_image/671a0807504ee.1729759239_blank_profile.jpg', 'admin', 'active', '2024-11-03 08:21:58'),
(7, 'Devith', 'Ku', 'user', '$2y$10$5IXPfugT0On.qfO4whZu0unVBH.leu9hQNzGyNwz.pOmjLkCJnk3a', 'user@gmail.com', '123456789', '../profile_image/6727290042230.1730619648_blank_profile.jpg', 'user', 'active', '2024-11-03 07:40:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_corn_breeding_data`
--
ALTER TABLE `tbl_corn_breeding_data`
  ADD PRIMARY KEY (`cbd_id`),
  ADD KEY `name_of_cut_corn_variety` (`name_of_cut_corn_variety`),
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
  MODIFY `cbd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `tbl_corn_breeding_data_images`
--
ALTER TABLE `tbl_corn_breeding_data_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_corn_varieties`
--
ALTER TABLE `tbl_corn_varieties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

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
