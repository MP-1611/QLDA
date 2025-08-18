-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2025 at 05:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlna_uth`
--

-- --------------------------------------------------------

--
-- Table structure for table `bao_cao`
--

CREATE TABLE `bao_cao` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','resolved') DEFAULT NULL,
  `reported_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `binh_luan`
--

CREATE TABLE `binh_luan` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cac_buoc_nau_an`
--

CREATE TABLE `cac_buoc_nau_an` (
  `step_id` int(11) NOT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `step_number` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cac_buoc_nau_an`
--

INSERT INTO `cac_buoc_nau_an` (`step_id`, `recipe_id`, `step_number`, `description`, `image_url`) VALUES
(1, 2, 1, 'lkjhgfd', NULL),
(2, 2, 2, 'jhgfcx', NULL),
(3, 2, 3, 'knbvc', NULL),
(4, 2, 4, 'kjhg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cong_thuc_nau_an`
--

CREATE TABLE `cong_thuc_nau_an` (
  `recipe_id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cook_time` int(11) DEFAULT NULL,
  `servings` int(11) DEFAULT NULL,
  `difficulty` enum('easy','medium','hard') DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cong_thuc_nau_an`
--

INSERT INTO `cong_thuc_nau_an` (`recipe_id`, `title`, `description`, `cook_time`, `servings`, `difficulty`, `category_id`, `author_id`, `image_url`, `video_url`, `created_at`) VALUES
(2, 'Lẩu cá', 'd,mnbvcx', NULL, NULL, NULL, 1, 4, 'hinh/hau1.jpg', NULL, '2025-08-17 23:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `danh_gia`
--

CREATE TABLE `danh_gia` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `rating_value` int(11) DEFAULT NULL CHECK (`rating_value` between 1 and 5),
  `rated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danh_muc_mon_an`
--

CREATE TABLE `danh_muc_mon_an` (
  `category_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `danh_muc_mon_an`
--

INSERT INTO `danh_muc_mon_an` (`category_id`, `name`, `description`) VALUES
(1, 'Lẩu', 'Các món ăn dạng lẩu.'),
(2, 'Nướng', 'Các món ăn được chế biến bằng cách nướng.'),
(3, 'Chiên', 'Các món ăn được chế biến bằng cách chiên.'),
(4, 'Xào', 'Các món ăn được chế biến bằng cách xào.'),
(5, 'Kho', 'Các món ăn được chế biến bằng cách kho.'),
(6, 'Hấp', 'Các món ăn được chế biến bằng cách hấp.'),
(7, 'Chay', 'Các món ăn được chế biến từ thực vật.'),
(8, 'Tráng miệng', 'Các món ăn dùng để tráng miệng sau bữa ăn.');

-- --------------------------------------------------------

--
-- Table structure for table `mon_an_yeu_thich`
--

CREATE TABLE `mon_an_yeu_thich` (
  `favorite_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `saved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nguyen_lieu`
--

CREATE TABLE `nguyen_lieu` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `ingredient_name` varchar(100) DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nguyen_lieu`
--

INSERT INTO `nguyen_lieu` (`id`, `recipe_id`, `ingredient_name`, `quantity`) VALUES
(1, 2, ';lkjhgfd', NULL),
(2, 2, 'lkjhgfd', NULL),
(3, 2, 'ytrds', NULL),
(4, 2, 'mnb', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `thong_tin_nguoi_dung`
--

CREATE TABLE `thong_tin_nguoi_dung` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT NULL,
  `status` enum('active','banned') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thong_tin_nguoi_dung`
--

INSERT INTO `thong_tin_nguoi_dung` (`user_id`, `username`, `email`, `password_hash`, `avatar_url`, `role`, `status`, `created_at`, `last_login`) VALUES
(1, NULL, 'vyvy123@gmail.com', '$2y$10$XalKsZ7C4CQJfbiX/lmVReXv8W0hInokzg0jxOgTokUFsariJcwwe', NULL, 'user', 'active', '2025-08-04 14:03:17', '2025-08-04 14:07:49'),
(2, 'dzi', 'ntyv2306@gmail.com', '$2y$10$MiEzcqdZnS2Ox13XFr7Dzu./16UHzDw9nS7s/y6K1uL.TCeAtmFDa', NULL, 'user', 'active', '2025-08-12 19:19:55', '2025-08-18 09:58:22'),
(3, NULL, 'ntyv2306@gmail.com', '$2y$10$HSaKyQ70oZoBoXss4IIBguGQT3WCUScWylcQCQiEQb2kP9VvPw/J.', NULL, 'user', 'active', '2025-08-12 19:21:18', '2025-08-12 19:21:18'),
(4, 'phuoc', 'tmp123@gmail.com', '$2y$10$Znp4mjFZi2euyaMR1ZL7aOENsQ3qJDtX/BILbm7hVJtFw/jypKMMS', NULL, 'admin', 'active', '2025-08-17 23:16:05', '2025-08-18 09:33:03'),
(5, NULL, 'tmp123@gmail.com', '$2y$10$dwyTo0QRxyJZTwvHNBac4up3W4CAIVH6aUzZKqvBgW2FQACEcRQkq', NULL, 'user', 'active', '2025-08-17 23:16:56', '2025-08-17 23:16:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bao_cao`
--
ALTER TABLE `bao_cao`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `cac_buoc_nau_an`
--
ALTER TABLE `cac_buoc_nau_an`
  ADD PRIMARY KEY (`step_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `cong_thuc_nau_an`
--
ALTER TABLE `cong_thuc_nau_an`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `danh_muc_mon_an`
--
ALTER TABLE `danh_muc_mon_an`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `mon_an_yeu_thich`
--
ALTER TABLE `mon_an_yeu_thich`
  ADD PRIMARY KEY (`favorite_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `nguyen_lieu`
--
ALTER TABLE `nguyen_lieu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Indexes for table `thong_tin_nguoi_dung`
--
ALTER TABLE `thong_tin_nguoi_dung`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bao_cao`
--
ALTER TABLE `bao_cao`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `binh_luan`
--
ALTER TABLE `binh_luan`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cac_buoc_nau_an`
--
ALTER TABLE `cac_buoc_nau_an`
  MODIFY `step_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cong_thuc_nau_an`
--
ALTER TABLE `cong_thuc_nau_an`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `danh_gia`
--
ALTER TABLE `danh_gia`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `danh_muc_mon_an`
--
ALTER TABLE `danh_muc_mon_an`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mon_an_yeu_thich`
--
ALTER TABLE `mon_an_yeu_thich`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nguyen_lieu`
--
ALTER TABLE `nguyen_lieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `thong_tin_nguoi_dung`
--
ALTER TABLE `thong_tin_nguoi_dung`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bao_cao`
--
ALTER TABLE `bao_cao`
  ADD CONSTRAINT `bao_cao_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `thong_tin_nguoi_dung` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bao_cao_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `cong_thuc_nau_an` (`recipe_id`) ON DELETE CASCADE;

--
-- Constraints for table `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD CONSTRAINT `binh_luan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `thong_tin_nguoi_dung` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `binh_luan_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `cong_thuc_nau_an` (`recipe_id`) ON DELETE CASCADE;

--
-- Constraints for table `cac_buoc_nau_an`
--
ALTER TABLE `cac_buoc_nau_an`
  ADD CONSTRAINT `cac_buoc_nau_an_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `cong_thuc_nau_an` (`recipe_id`) ON DELETE CASCADE;

--
-- Constraints for table `cong_thuc_nau_an`
--
ALTER TABLE `cong_thuc_nau_an`
  ADD CONSTRAINT `cong_thuc_nau_an_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `danh_muc_mon_an` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cong_thuc_nau_an_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `thong_tin_nguoi_dung` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD CONSTRAINT `danh_gia_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `thong_tin_nguoi_dung` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `danh_gia_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `cong_thuc_nau_an` (`recipe_id`) ON DELETE CASCADE;

--
-- Constraints for table `mon_an_yeu_thich`
--
ALTER TABLE `mon_an_yeu_thich`
  ADD CONSTRAINT `mon_an_yeu_thich_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `thong_tin_nguoi_dung` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mon_an_yeu_thich_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `cong_thuc_nau_an` (`recipe_id`) ON DELETE CASCADE;

--
-- Constraints for table `nguyen_lieu`
--
ALTER TABLE `nguyen_lieu`
  ADD CONSTRAINT `nguyen_lieu_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `cong_thuc_nau_an` (`recipe_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
