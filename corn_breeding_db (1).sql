-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 08:07 PM
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
  `add_by` int(50) NOT NULL,
  `first_corn_variety` varchar(50) NOT NULL,
  `second_corn_variety` varchar(50) NOT NULL,
  `version` int(10) NOT NULL,
  `fruit_height` varchar(20) NOT NULL,
  `stem_height` varchar(20) NOT NULL,
  `flower_day` varchar(20) NOT NULL,
  `male_flowering_day` varchar(20) NOT NULL,
  `flowering_age_gap` int(10) DEFAULT NULL,
  `number_of_stalks` int(10) DEFAULT NULL,
  `number_of_male_flower_stalks` int(10) DEFAULT NULL,
  `male_flowering_age` int(10) DEFAULT NULL,
  `flowering_age` int(10) DEFAULT NULL,
  `leaf_angle` int(10) DEFAULT NULL,
  `the_tail_on_the_end_of_the_fruit` int(11) DEFAULT NULL,
  `fruit_length` int(10) DEFAULT NULL,
  `fertility` int(10) DEFAULT NULL,
  `original_size` int(11) DEFAULT NULL,
  `stem_length` int(10) DEFAULT NULL,
  `root_system` int(10) DEFAULT NULL,
  `germination_rate` int(10) DEFAULT NULL,
  `albino_birth_level` int(11) DEFAULT NULL,
  `worm_damage_level` int(11) DEFAULT NULL,
  `strength` int(11) DEFAULT NULL,
  `age_gap_between_male_and_female_flowers` int(11) DEFAULT NULL,
  `seuthern_rast` int(11) DEFAULT NULL,
  `peeled_fruit_diameter` int(11) DEFAULT NULL,
  `disease_level` int(11) DEFAULT NULL COMMENT 'not sure',
  `peel_length` int(11) DEFAULT NULL,
  `number_of_rows_of_seeds_per_fruit` int(11) DEFAULT NULL,
  `fruit_peel` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `worm` int(11) DEFAULT NULL,
  `seedling_vigor` varchar(10) DEFAULT NULL,
  `row_of_corn_kernels` varchar(10) DEFAULT NULL,
  `number_of_roots` varchar(10) DEFAULT NULL,
  `tip_length` float DEFAULT NULL,
  `total` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_corn_breeding_data_images`
--

CREATE TABLE `tbl_corn_breeding_data_images` (
  `id` int(11) NOT NULL,
  `name_of_cut_corn_variety` varchar(100) NOT NULL,
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
(46, 'Violet', 0);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`users_id`, `first_name`, `last_name`, `username`, `password`, `email`, `phone_number`, `image`, `user_type`, `status`, `created_at`) VALUES
(3, 'phanun', 'sok', 'nun', '$2y$10$nJPhsNtlNazXMBXu.ik1YuTlLnekrMCeH0zZsg.X.v0nc/oGT5LeG', 'nun@gmail.com', '0123456789', '../profile_image/670cbd9a7b55c.1728888218_20240830_114603.jpg', 'admin', 'active', '2024-09-14 08:45:54'),
(7, '', 'user', 'user', '$2y$10$5IXPfugT0On.qfO4whZu0unVBH.leu9hQNzGyNwz.pOmjLkCJnk3a', 'user@gmail.com', '123456789', '../profile_image/66efe7a8d3f6e.1726998440_20240830_114603.jpg', 'user', 'active', '2024-09-22 08:47:26'),
(8, 'zion1', 'briliance', 'nunph', '$2y$10$g8Cm5Ga7KB7BrsECbCc.A..OidIj3nXXTo7afsjbInm8munfrsRDe', 'broakzinll290@gmail.com', '965101579', '../profile_image/66f1816de1038.1727103341_20240830_114603.jpg', 'admin', 'active', '2024-09-22 09:57:26'),
(9, '', '', 'ffad', '$2y$10$MPUafbBo.YqRj/Si/RqpRukIDRoT5ipQuCRbni6QqjgO1vAgeSDR6', '', '', '', '', '', '2024-10-15 07:04:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_corn_breeding_data`
--
ALTER TABLE `tbl_corn_breeding_data`
  ADD PRIMARY KEY (`cbd_id`),
  ADD KEY `name_of_cut_corn_variety` (`name_of_cut_corn_variety`),
  ADD KEY `add_by` (`add_by`),
  ADD KEY `tbl_ticket_ibfk_1` (`first_corn_variety`),
  ADD KEY `tbl_ticket_ibfk_2` (`second_corn_variety`);

--
-- Indexes for table `tbl_corn_breeding_data_images`
--
ALTER TABLE `tbl_corn_breeding_data_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_corn_breeding_data_images_ibfk_1` (`name_of_cut_corn_variety`);

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
  MODIFY `cbd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tbl_corn_breeding_data_images`
--
ALTER TABLE `tbl_corn_breeding_data_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_corn_varieties`
--
ALTER TABLE `tbl_corn_varieties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_corn_breeding_data`
--
ALTER TABLE `tbl_corn_breeding_data`
  ADD CONSTRAINT `tbl_ticket_ibfk_1` FOREIGN KEY (`first_corn_variety`) REFERENCES `tbl_corn_varieties` (`corn_varieties_name`),
  ADD CONSTRAINT `tbl_ticket_ibfk_2` FOREIGN KEY (`second_corn_variety`) REFERENCES `tbl_corn_varieties` (`corn_varieties_name`),
  ADD CONSTRAINT `tbl_ticket_ibfk_29_id` FOREIGN KEY (`add_by`) REFERENCES `tbl_users` (`users_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_corn_breeding_data_images`
--
ALTER TABLE `tbl_corn_breeding_data_images`
  ADD CONSTRAINT `tbl_corn_breeding_data_images_ibfk_1` FOREIGN KEY (`name_of_cut_corn_variety`) REFERENCES `tbl_corn_breeding_data` (`name_of_cut_corn_variety`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
