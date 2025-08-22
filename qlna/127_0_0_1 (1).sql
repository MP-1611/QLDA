-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2025 at 04:24 PM
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
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2025-08-18 14:24:06', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `qlna_uth`
--
CREATE DATABASE IF NOT EXISTS `qlna_uth` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `qlna_uth`;

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
(4, 2, 4, 'kjhg', NULL),
(5, 3, 1, 'Nấu nước dùng từ xương heo.', NULL),
(6, 3, 2, 'Thêm sả, lá chanh, ớt, gia vị lẩu Thái.', NULL),
(7, 3, 3, 'Cho hải sản, rau, nấm vào nấu chín.', NULL),
(8, 4, 1, 'Pha nước lẩu từ dấm, nước dừa.', NULL),
(9, 4, 2, 'Cho hành tây, sả vào nấu.', NULL),
(10, 4, 3, 'Nhúng thịt bò, rau, ăn kèm bún.', NULL),
(11, 5, 1, 'Nấu nước dùng với xương heo.', NULL),
(12, 5, 2, 'Thêm lá giang tạo vị chua.', NULL),
(13, 5, 3, 'Cho cá kèo, rau vào nhúng ăn.', NULL),
(14, 6, 1, 'Nấu nước dùng xương heo.', NULL),
(15, 6, 2, 'Thêm kim chi, gochujang tạo vị cay.', NULL),
(16, 6, 3, 'Cho hải sản, nấm, rau vào.', NULL),
(17, 7, 1, 'Nấu nước ngọt từ củ cải, cà rốt.', NULL),
(18, 7, 2, 'Cho các loại nấm vào.', NULL),
(19, 7, 3, 'Thêm đậu hũ, rau, nêm vừa ăn.', NULL),
(20, 8, 1, 'Ướp thịt với mật ong, tỏi, sả.', NULL),
(21, 8, 2, 'Nướng than hồng hoặc lò nướng.', NULL),
(22, 8, 3, 'Trở đều tay cho vàng óng.', NULL),
(23, 9, 1, 'Ướp gà với muối ớt, sả.', NULL),
(24, 9, 2, 'Nướng than hoặc lò cho chín đều.', NULL),
(25, 9, 3, 'Ăn kèm muối tiêu chanh.', NULL),
(26, 10, 1, 'Làm sạch cá, ướp gia vị.', NULL),
(27, 10, 2, 'Gói cá với giấy bạc.', NULL),
(28, 10, 3, 'Nướng than hoặc lò.', NULL),
(29, 11, 1, 'Ướp sườn với sốt BBQ.', NULL),
(30, 11, 2, 'Nướng lò hoặc than hồng.', NULL),
(31, 11, 3, 'Phết thêm sốt khi nướng.', NULL),
(32, 12, 1, 'Ướp tôm với muối ớt.', NULL),
(33, 12, 2, 'Xiên que hoặc nướng trực tiếp.', NULL),
(34, 12, 3, 'Ăn nóng với muối chanh.', NULL),
(35, 13, 1, 'Trộn hải sản với miến, mộc nhĩ, rau củ.', NULL),
(36, 13, 2, 'Cuốn nhân vào bánh đa nem.', NULL),
(37, 13, 3, 'Chiên lửa vừa cho vàng giòn đều.', NULL),
(38, 14, 1, 'Bào khoai sợi, rửa sạch tinh bột.', NULL),
(39, 14, 2, 'Bọc khoai quanh thân tôm.', NULL),
(40, 14, 3, 'Nhúng bột mỏng rồi chiên vàng giòn.', NULL),
(41, 15, 1, 'Cuộn phô mai trong thịt bò.', NULL),
(42, 15, 2, 'Lăn qua bột mì, trứng, bột xù.', NULL),
(43, 15, 3, 'Chiên ngập dầu đến khi phô mai tan chảy.', NULL),
(44, 16, 1, 'Tẩm gà với ít bột bắp.', NULL),
(45, 16, 2, 'Chiên gà vàng giòn.', NULL),
(46, 16, 3, 'Làm sốt nước mắm đường, áo đều gà.', NULL),
(47, 17, 1, 'Nhào bột mì, cán mỏng, cắt tam giác.', NULL),
(48, 17, 2, 'Nấu nhân rau củ với cà ri.', NULL),
(49, 17, 3, 'Gói nhân, gập vỏ tam giác.', NULL),
(50, 17, 4, 'Chiên vàng giòn, chấm sốt chua cay.', NULL),
(51, 18, 1, 'Ướp bò với dầu hào, bột bắp.', NULL),
(52, 18, 2, 'Phi thơm gừng, tỏi, cho bò xào nhanh.', NULL),
(53, 18, 3, 'Thêm sốt nước tương + đường nâu.', NULL),
(54, 18, 4, 'Rắc hành lá, dùng nóng.', NULL),
(55, 19, 1, 'Luộc mì chín tới, để ráo.', NULL),
(56, 19, 2, 'Xào hải sản với bột cà ri.', NULL),
(57, 19, 3, 'Cho mì, giá, hẹ vào đảo đều.', NULL),
(58, 19, 4, 'Nêm nước tương, dầu mè.', NULL),
(59, 20, 1, 'Xào gà với ớt khô, tiêu.', NULL),
(60, 20, 2, 'Thêm hành, ớt chuông đảo đều.', NULL),
(61, 20, 3, 'Làm sốt từ xì dầu + giấm.', NULL),
(62, 20, 4, 'Trộn đậu phộng cuối cùng.', NULL),
(63, 21, 1, 'Luộc mì udon sơ.', NULL),
(64, 21, 2, 'Xào thịt, tôm với rau củ.', NULL),
(65, 21, 3, 'Cho mì vào, thêm shoyu, mirin.', NULL),
(66, 21, 4, 'Đảo nhanh tay cho thấm.', NULL),
(67, 22, 1, 'Làm sốt me: me + đường thốt nốt.', NULL),
(68, 22, 2, 'Xào tôm đến khi chuyển màu.', NULL),
(69, 22, 3, 'Thêm sốt me, ớt bột vào.', NULL),
(70, 22, 4, 'Rắc hành, ngò trước khi ăn.', NULL),
(71, 23, 1, 'Xào thịt ba rọi với tỏi.', NULL),
(72, 23, 2, 'Thêm cá, nước mắm, nước màu.', NULL),
(73, 23, 3, 'Kho lửa nhỏ cho thấm vị.', NULL),
(74, 23, 4, 'Thêm ớt cay khi gần cạn.', NULL),
(75, 24, 1, 'Luộc sơ thịt, trứng.', NULL),
(76, 24, 2, 'Kho với nước dừa + gia vị.', NULL),
(77, 24, 3, 'Đun nhỏ lửa đến khi mềm nhừ.', NULL),
(78, 24, 4, 'Ăn kèm cơm trắng.', NULL),
(79, 25, 1, 'Xếp riềng lát dưới đáy nồi.', NULL),
(80, 25, 2, 'Cho cá, nghệ, sả, ớt vào.', NULL),
(81, 25, 3, 'Kho với mẻ + nước mắm.', NULL),
(82, 25, 4, 'Đun lửa nhỏ đến khi sánh.', NULL),
(83, 26, 1, 'Áp chảo bò cho săn.', NULL),
(84, 26, 2, 'Cho rau củ, rượu vang, nước dùng.', NULL),
(85, 26, 3, 'Ninh lửa nhỏ vài giờ.', NULL),
(86, 26, 4, 'Ăn kèm bánh mì hoặc cơm.', NULL),
(87, 27, 1, 'Xào gà với gừng, hành.', NULL),
(88, 27, 2, 'Thêm nước mắm, ít nước.', NULL),
(89, 27, 3, 'Kho lửa nhỏ cho săn thịt.', NULL),
(90, 27, 4, 'Nêm tiêu, ớt cay.', NULL),
(91, 28, 1, 'Làm sạch cá, để nguyên con.', NULL),
(92, 28, 2, 'Cho gừng, hành vào bụng cá.', NULL),
(93, 28, 3, 'Hấp cá 15 phút, rưới xì dầu.', NULL),
(94, 28, 4, 'Rắc hành, ngò trước khi ăn.', NULL),
(95, 29, 1, 'Xếp tôm, sả vào nồi.', NULL),
(96, 29, 2, 'Đổ nước dừa ngập nửa tôm.', NULL),
(97, 29, 3, 'Hấp nhanh lửa lớn 10 phút.', NULL),
(98, 29, 4, 'Ăn kèm muối tiêu chanh.', NULL),
(99, 30, 1, 'Nhào bột, ủ nở 1 giờ.', NULL),
(100, 30, 2, 'Trộn nhân thịt, mộc nhĩ.', NULL),
(101, 30, 3, 'Gói nhân, đặt trứng cút trong.', NULL),
(102, 30, 4, 'Hấp chín khoảng 20 phút.', NULL),
(103, 31, 1, 'Lót muối dưới đáy nồi.', NULL),
(104, 31, 2, 'Nhồi lá chanh, sả vào gà.', NULL),
(105, 31, 3, 'Đặt gà lên, đậy kín hấp khô.', NULL),
(106, 31, 4, 'Chặt miếng, ăn với muối tiêu.', NULL),
(107, 32, 1, 'Ướp cá với muối, tiêu, dầu olive.', NULL),
(108, 32, 2, 'Xếp cá vào khay, rưới rượu vang.', NULL),
(109, 32, 3, 'Thêm cà chua bi, ô liu, hành tây.', NULL),
(110, 32, 4, 'Hấp cách thủy hoặc lò hơi 15 phút.', NULL),
(111, 32, 5, 'Rắc thì là tươi khi ăn.', NULL),
(112, 33, 1, 'Luộc rau củ, xào nấm riêng.', NULL),
(113, 33, 2, 'Bày cơm, xếp rau củ, trứng lên trên.', NULL),
(114, 33, 3, 'Thêm gochujang, dầu mè.', NULL),
(115, 33, 4, 'Trộn đều khi ăn.', NULL),
(116, 34, 1, 'Trải cơm lên lá rong biển.', NULL),
(117, 34, 2, 'Xếp rau củ, đậu hũ vào.', NULL),
(118, 34, 3, 'Cuộn chặt, cắt khoanh.', NULL),
(119, 34, 4, 'Ăn kèm kimchi chay.', NULL),
(120, 35, 1, 'Nấu nước dashi từ kombu, nấm.', NULL),
(121, 35, 2, 'Hòa miso vào nước nóng (không sôi).', NULL),
(122, 35, 3, 'Thêm đậu hũ, rong biển.', NULL),
(123, 35, 4, 'Rắc hành lá, ăn nóng.', NULL),
(124, 36, 1, 'Pha bột tempura với nước đá.', NULL),
(125, 36, 2, 'Nhúng rau củ vào bột, chiên nhanh.', NULL),
(126, 36, 3, 'Vớt ra giấy thấm dầu.', NULL),
(127, 36, 4, 'Ăn kèm nước chấm tentsuyu.', NULL),
(128, 37, 1, 'Xào nấm, cà tím, bí ngòi với dầu olive.', NULL),
(129, 37, 2, 'Trải lớp mì → sốt cà → rau củ → sốt bechamel → phô mai.', NULL),
(130, 37, 3, 'Lặp nhiều lớp đến đầy khuôn.', NULL),
(131, 37, 4, 'Nướng 180°C khoảng 35–40 phút.', NULL),
(132, 37, 5, 'Ăn nóng, rắc lá oregano.', NULL),
(133, 38, 1, 'Tách lòng đỏ, đánh với đường đến bông mịn.', NULL),
(134, 38, 2, 'Thêm mascarpone, đánh tiếp đến khi mượt.', NULL),
(135, 38, 3, 'Đánh lòng trắng trứng bông mềm, trộn nhẹ vào hỗn hợp mascarpone.', NULL),
(136, 38, 4, 'Nhúng nhanh ladyfinger vào espresso pha rượu, xếp lớp dưới.', NULL),
(137, 38, 5, 'Trải kem mascarpone lên trên, xen kẽ nhiều lớp.', NULL),
(138, 38, 6, 'Rắc bột cacao phủ mặt.', NULL),
(139, 38, 7, 'Làm lạnh 4–6h trước khi dùng.', NULL),
(140, 39, 1, 'Đánh trứng và đường đến bông, trộn bột mì + cacao.', NULL),
(141, 39, 2, 'Thêm bơ tan chảy, nướng bánh 170°C khoảng 35 phút.', NULL),
(142, 39, 3, 'Đánh bông kem tươi.', NULL),
(143, 39, 4, 'Cắt bánh thành 3–4 lớp.', NULL),
(144, 39, 5, 'Phết syrup Kirsch, thêm cherry, phủ kem ở mỗi tầng.', NULL),
(145, 39, 6, 'Trang trí chocolate bào và cherry trên cùng.', NULL),
(146, 40, 1, 'rộn bánh quy vụn với bơ, ép vào khuôn.', NULL),
(147, 40, 2, 'Nướng sơ 180°C trong 10 phút.', NULL),
(148, 40, 3, 'Đánh lòng đỏ với sữa đặc, thêm nước chanh, vỏ chanh.', NULL),
(149, 40, 4, 'Đổ hỗn hợp vào đế bánh, nướng 160°C trong 15 phút.', NULL),
(150, 40, 5, 'Làm lạnh 3h.', NULL),
(151, 40, 6, 'Trang trí kem tươi và lát chanh trước khi ăn.', NULL),
(152, 41, 1, 'Đánh trứng với đường đến bông, trộn bột mì + vani.', NULL),
(153, 41, 2, 'Nướng bánh 175°C trong 30 phút.', NULL),
(154, 41, 3, 'Trộn 3 loại sữa thành hỗn hợp.', NULL),
(155, 41, 4, 'Khi bánh còn ấm, chọc lỗ, rưới sữa ngập bánh.', NULL),
(156, 41, 5, 'Để thấm lạnh 4h.', NULL),
(157, 41, 6, 'Phủ kem tươi, trang trí trái cây.', NULL),
(164, 42, 1, 'Đun kem với vani đến ấm nóng, không sôi.', NULL),
(165, 42, 2, 'Đánh lòng đỏ với đường đến sệt, từ từ rót kem vào.', NULL),
(166, 42, 3, 'Lọc hỗn hợp, đổ vào khuôn ramekin.', NULL),
(167, 42, 4, 'Nướng cách thủy 150°C khoảng 35–40 phút.', NULL),
(168, 42, 5, 'Làm lạnh ít nhất 3h.', NULL),
(169, 42, 6, 'Rắc đường, dùng torch đốt caramel hóa mặt.', NULL);

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
(2, 'Lẩu cá', 'd,mnbvcx', NULL, NULL, NULL, 1, 4, 'hinh/hau1.jpg', NULL, '2025-08-17 23:29:41'),
(3, 'Lẩu Thái Chua Cay', 'Đặc sản Thái Lan với vị chua cay đậm đà', NULL, NULL, NULL, 1, 4, 'https://sgtt.thesaigontimes.vn/wp-content/uploads/2025/01/2024_1_23_638416491645237808_mach-ban-cach-nau-lau-thai-bang-goi-gia-vi_960.jpg', NULL, '2025-08-18 20:01:02'),
(4, 'Lẩu Bò Nhúng Dấm', ' Lẩu truyền thống Việt Nam chua dịu, ngọt thịt bò\r\n', NULL, NULL, NULL, 1, 4, 'https://digiticket.vn/blog/wp-content/uploads/2021/11/lau-bo-nhung-dam-sai-gon-1.jpg', NULL, '2025-08-18 20:02:16'),
(5, 'Lẩu Cá Kèo Lá Giang', 'Món dân dã miền Tây với vị chua thanh', NULL, NULL, NULL, 1, 4, 'https://www.nhahangquangon.com/wp-content/uploads/2013/11/lau-ca-keo-la-giang.jpg', NULL, '2025-08-18 20:02:50'),
(6, 'Lẩu Hải Sản Kim Chi', 'Hương vị Hàn Quốc chua cay đặc trưng', NULL, NULL, NULL, 1, 4, 'https://daynauan.info.vn/wp-content/uploads/2018/06/lau-kim-chi-hai-san.jpg', NULL, '2025-08-18 20:03:30'),
(7, 'Lẩu Nấm Chay', 'Thanh đạm, tốt cho sức khỏe, hợp ăn chay', NULL, NULL, NULL, 1, 4, 'https://cdn.tgdd.vn/2021/02/CookProduct/1114-1200x676.jpg', NULL, '2025-08-18 20:04:35'),
(8, 'Thịt Nướng Mật Ong', 'Món nướng Việt Nam với vị ngọt thơm đặc trưng', NULL, NULL, NULL, 2, 4, 'https://cdn-i.vtcnews.vn/resize/th/upload/2020/10/25/thit-ba-chi-nuong-14325936.jpg', NULL, '2025-08-18 20:09:02'),
(9, 'Gà Nướng Muối Ớt', 'Hương vị Tây Nguyên cay nồng hấp dẫn', NULL, NULL, NULL, 2, 4, 'https://heyyofoods.com/wp-content/uploads/2023/12/2-5.jpg', NULL, '2025-08-18 20:09:46'),
(10, 'Cá Nướng Giấy Bạc', 'Cá nướng phong cách miền biển dân dã', NULL, NULL, NULL, 2, 4, 'https://cdn.tgdd.vn/2021/01/CookProductThumb/recipe44675-cook-step3-636814308073250898copy-620x620.jpg', NULL, '2025-08-18 20:10:28'),
(11, 'Sườn Nướng BBQ', 'Hương vị Mỹ, vị ngọt sốt BBQ đậm đà', NULL, NULL, NULL, 2, 4, 'https://bizweb.dktcdn.net/100/317/602/products/10.jpg?v=1664783933313', NULL, '2025-08-18 20:11:03'),
(12, 'Tôm Nướng Muối Ớt', 'Đặc sản ven biển, cay mặn hấp dẫn', NULL, NULL, NULL, 2, 4, 'https://nghebep.com/wp-content/uploads/2018/01/cach-lam-tom-nuong-muoi-ot.jpg', NULL, '2025-08-18 20:11:36'),
(13, 'Chả Giò Hải Sản', 'Món chiên tiệc sang trọng, nhân hải sản thơm ngọt', NULL, NULL, NULL, 3, 4, 'https://i.ytimg.com/vi/Yd31kGDC4Aw/maxresdefault.jpg', NULL, '2025-08-18 20:13:55'),
(14, 'Tôm Chiên Hoàng Bào', 'Món Hoa cầu kỳ, tôm cuốn khoai chiên vàng óng', NULL, NULL, NULL, 3, 4, 'https://storage.quannhautudo.com/data/thumb_800/Data/images/product/2024/05/202405301025551126.webp', NULL, '2025-08-18 20:14:52'),
(15, 'Bò Cuộn Phô Mai Chiên', 'Món Âu biến tấu, nhân phô mai béo ngậy', NULL, NULL, NULL, 3, 4, 'https://cdn.tgdd.vn/Files/2020/05/31/1259774/2-cach-lam-bo-cuon-pho-mai-chien-xu-va-sot-nam-thom-ngon-beo-ngay-22.jpg', NULL, '2025-08-18 20:15:32'),
(16, 'Cánh Gà Chiên Nước Mắm', 'Đặc sản miền Nam, vị mặn ngọt hòa quyện', NULL, NULL, NULL, 3, 4, 'https://i.ytimg.com/vi/IY7ZjL7MimM/sddefault.jpg', NULL, '2025-08-18 20:16:09'),
(17, 'Bánh Cà Ri Chiên (Samosa Ấn Độ)', 'Món Ấn Độ nổi tiếng, vỏ giòn nhân cay', NULL, NULL, NULL, 3, 4, 'https://toptentravel.com.vn/Data/Sites/1/News/4767/cach-lam-banh-samosa-5.jpg', NULL, '2025-08-18 20:16:39'),
(18, 'Bò Xào Kiểu Mông Cổ', 'Món Á nổi tiếng, sốt đậm đà, thơm hành gừng', NULL, NULL, NULL, 4, 4, 'https://huongsen.vn/wp-content/uploads/2019/06/thit-bo-xao-1.jpg', NULL, '2025-08-18 20:17:59'),
(19, 'Mì Xào Hải Sản Singapore', 'Hương vị Đông Nam Á, cay thơm cà ri', NULL, NULL, NULL, 4, 4, 'https://i1.wp.com/wp.thuytadamsen.vn/wp-content/uploads/2019/05/mi-xao-singapore.jpg?fit=550%2C366', NULL, '2025-08-18 20:18:45'),
(20, 'Gà Xào Kung Pao (Tứ Xuyên)', 'Món Trung Hoa cay nồng, đậu phộng giòn béo', NULL, NULL, NULL, 4, 4, 'https://logistics-solution.com/wp-content/uploads/2024/05/ga-kung-pao-5.jpg', NULL, '2025-08-18 20:19:15'),
(21, 'Mì Udon Xào Nhật Bản', 'Món Nhật đậm vị nước tương ngọt mặn', NULL, NULL, NULL, 4, 4, 'https://ibuki.vn/wp-content/uploads/2021/10/mi-udon.jpg', NULL, '2025-08-18 20:19:44'),
(22, 'Tôm Xào Me Kiểu Thái', 'Vị chua ngọt hài hòa, đậm chất Thái Lan', NULL, NULL, NULL, 4, 4, 'https://cdn.eva.vn/upload/3-2023/images/2023-07-07/tom-sot-me-dam-da-voi-cach-lam-don-gian-ngon-tuyet-rat-dua-com-tom-sot-me-eva-008-1688694566-646-width601height461.jpg', NULL, '2025-08-18 20:20:18'),
(23, 'Cá Kho Tộ Miền Nam', 'Món dân gian Việt, kho đậm đà với nước màu', NULL, NULL, NULL, 5, 4, 'https://cdn.tgdd.vn/Files/2019/09/02/1194292/cach-lam-ca-loc-kho-to-ngon-com-chuan-vi-mien-nam-202201041313092690.jpg', NULL, '2025-08-18 20:20:46'),
(24, ' Thịt Kho Tàu', 'Món Tết Việt Nam, thịt mềm, trứng béo', NULL, NULL, NULL, 5, 4, 'https://cdn.eva.vn/upload/2-2023/images/2023-06-30/cach-lam-thit-kho-tau-thom-ngon-dam-vi-mem-tan-ngay-trong-mieng-thit-kho-tau-eva-001-1688095146-890-width600height400.jpg', NULL, '2025-08-18 20:21:37'),
(25, 'Cá Kho Riềng (miền Bắc)', 'Vị thơm cay riềng, đậm chất Bắc bộ', NULL, NULL, NULL, 5, 4, 'https://cdn.eva.vn/upload/3-2023/images/2023-07-04/cach-lam-ca-kho-rieng-sa-thom-ngon-khong-tanh-chuan-vi-mien-bac-cach-lam-ca-kho-rieng-sa-eva-009-1688441585-796-width600height450.jpg', NULL, '2025-08-18 20:22:05'),
(26, 'Bò Kho Kiểu Pháp (Boeuf Bourguignon)', 'Món Pháp hầm rượu vang đỏ đậm vị', NULL, NULL, NULL, 5, 4, 'https://file.hstatic.net/200000692767/file/boeuf-bourguignon__4_.jpg', NULL, '2025-08-18 20:22:35'),
(27, 'Gà Kho Gừng', 'Món truyền thống Bắc Bộ, vị cay ấm', NULL, NULL, NULL, 5, 4, 'https://homestory.com.vn/wp-content/uploads/2023/06/cach-lam-ga-kho-gung-thom-nong-a.jpg', NULL, '2025-08-18 20:23:00'),
(28, 'Cá Chép Hấp Xì Dầu', 'Món Hoa thanh tao, thịt cá ngọt mềm', NULL, NULL, NULL, 6, 4, 'https://cdn.24h.com.vn/upload/4-2018/images/2018-10-27/1540575879-750-35695428_612662525798810_2409419877883314176_n-1540575651-width960height540.jpg', NULL, '2025-08-18 20:24:02'),
(29, 'Tôm Hấp Nước Dừa', 'Món Nam Bộ dân dã, ngọt tự nhiên', NULL, NULL, NULL, 6, 4, 'https://cdn.pastaxi-manager.onepas.vn/content/uploads/articles/hoamkt35/Blog/tom-hap-nuoc-dua.jpg', NULL, '2025-08-18 20:24:30'),
(30, 'Bánh Bao Hấp Nhân Thịt', 'Món Hoa phổ biến, mềm xốp thơm ngon', NULL, NULL, NULL, 6, 4, 'https://www.huongnghiepaau.com/wp-content/uploads/2019/01/banh-bao-nhan-thit.jpg', NULL, '2025-08-18 20:25:09'),
(31, 'Gà Hấp Muối Nguyên Con', 'Gà dai ngọt, giữ trọn hương vị tự nhiên', NULL, NULL, NULL, 6, 4, 'https://i.ytimg.com/vi/q6B2F8OjKdo/maxresdefault.jpg', NULL, '2025-08-18 20:26:31'),
(32, 'Cá Hấp Kiểu Địa Trung Hải', 'Món Âu thanh tao, cá hấp với rượu vang trắng và thảo mộc', NULL, NULL, NULL, 6, 4, 'https://poseidon-web.s3.zsoft.solutions/app/media/uploaded-files/180824-phong-cach-am-thuc-dia-trung-hai-buffet-poseidon.2.jpg', NULL, '2025-08-18 20:27:15'),
(33, 'Bibimbap Chay (Hàn Quốc)', 'Cơm trộn Hàn Quốc chay, nhiều loại rau củ', NULL, NULL, NULL, 7, 4, 'https://cdn.tgdd.vn/2021/09/CookRecipe/Avatar/com-tron-chay-sot-tuong-ot-thumbnail.jpg', NULL, '2025-08-18 20:27:49'),
(34, 'Kimbap Chay', 'Cơm cuộn rong biển Hàn, nhân rau củ thanh đạm', NULL, NULL, NULL, 7, 4, 'https://cdn11.dienmaycholon.vn/filewebdmclnew/public/userupload/files/kien-thuc/cach-lam-kimbap-chay/cach-lam-kimbap-chay-5.jpg', NULL, '2025-08-18 20:28:21'),
(35, 'Miso Soup ', 'Canh miso Nhật thanh mát, đậu hũ, rong biển', NULL, NULL, NULL, 7, 4, 'https://storage.googleapis.com/onelife-public/blog.onelife.vn/2021/11/cach-lam-sup-miso-rau-cu-mon-chay-834862445844.jpg', NULL, '2025-08-18 20:28:55'),
(36, 'Tempura Rau Củ', 'Món chiên giòn Nhật, rau củ phủ bột tempura', NULL, NULL, NULL, 7, 4, 'https://file.hstatic.net/200000118173/article/tempura-rau-cu-chien-gion_c9a66f33ea0940e5bfa31f335b99928d.jpg', NULL, '2025-08-18 20:29:25'),
(37, 'Lasagna Chay', 'Món Ý phức tạp, nhiều lớp mì, sốt cà và phô mai chay', NULL, NULL, NULL, 7, 4, 'https://media-cdn-v2.laodong.vn/Storage/NewsPortal/2022/5/6/1041951/Easy-Vegetarian-Lasa.jpg', NULL, '2025-08-18 20:30:27'),
(38, 'Tiramisu', 'Món tráng miệng biểu tượng của Ý, cà phê & mascarpone', NULL, NULL, NULL, 8, 4, 'https://www.bunsenburnerbakery.com/wp-content/uploads/2025/03/easy-tiramisu-29.jpg', NULL, '2025-08-18 20:32:01'),
(39, 'Schwarzwälder Kirschtorte – Black Forest Cake', 'Bánh chocolate nhiều tầng, cherry và rượu anh đào tinh tế đặc sản của nước Đức', NULL, NULL, NULL, 8, 4, 'https://i0.wp.com/jennyisbaking.com/wp-1c174-content/uploads/2017/06/DSC01499.jpg?w=1080&ssl=1', NULL, '2025-08-18 20:32:57'),
(40, 'Key Lime Pie (Mỹ – Florida)', 'Bánh chanh Mỹ nổi tiếng, vị chua ngọt mát lạnh', NULL, NULL, NULL, 8, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSwP6tmCi3yG-sxPHls395bFpJfE5QhaLGGUA&s', NULL, '2025-08-18 20:33:48'),
(41, 'Tres Leches Cake (Mexico / Mỹ Latin)', 'Bánh sữa ẩm mềm, thấm 3 loại sữa ngọt béo', NULL, NULL, NULL, 8, 4, 'https://www.mexicoinmykitchen.com/wp-content/uploads/2014/09/Three-milk-Cake-recipe-Mexican-.jpg', NULL, '2025-08-18 20:34:31'),
(42, 'Crème Brûlée (Pháp)', 'Món Pháp cổ điển, kem nướng mịn, caramel giòn', NULL, NULL, NULL, 8, 4, 'https://www.hoidaubepaau.com/wp-content/uploads/2016/03/creme-brulee.jpg', NULL, '2025-08-18 20:35:02');

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
(4, 2, 'mnb', NULL),
(5, 3, 'Tôm, mực, cá, nghêu', NULL),
(6, 3, 'Nấm kim châm, rau muống', NULL),
(7, 3, 'Sả, ớt, chanh, lá chanh', NULL),
(8, 3, 'Gia vị lẩu Thái, nước mắm', NULL),
(9, 4, 'Thịt bò thái lát mỏng', NULL),
(10, 4, 'Dấm gạo, dừa tươi', NULL),
(11, 4, 'Rau sống, bún', NULL),
(12, 4, 'Hành tây, sả, ớt', NULL),
(13, 5, 'Cá kèo', NULL),
(14, 5, 'Lá giang', NULL),
(15, 5, 'Rau đắng, bạc hà', NULL),
(16, 5, 'Gia vị, nước mắm', NULL),
(17, 6, 'Tôm, mực, nghêu', NULL),
(18, 6, 'Kim chi, đậu hũ', NULL),
(19, 6, 'Hành tây, nấm, rau cải thảo', NULL),
(20, 6, 'Gia vị Hàn Quốc (gochujang)', NULL),
(21, 7, 'Nấm kim châm, nấm hương, nấm rơm', NULL),
(22, 7, 'Đậu hũ, rau cải', NULL),
(23, 7, 'Cà rốt, củ cải trắng', NULL),
(24, 7, 'Gia vị chay', NULL),
(25, 8, 'Thịt ba chỉ hoặc thịt vai', NULL),
(26, 8, 'Mật ong', NULL),
(27, 8, 'Tỏi, sả, hành tím', NULL),
(28, 8, 'Nước mắm, hạt nêm', NULL),
(29, 9, 'Gà nguyên con', NULL),
(30, 9, 'Muối hột, ớt băm', NULL),
(31, 9, 'Sả, lá chanh', NULL),
(32, 9, 'Dầu ăn', NULL),
(33, 10, 'Cá diêu hồng', NULL),
(34, 10, 'Hành, thì là, gừng', NULL),
(35, 10, 'Nấm, cà chua', NULL),
(36, 10, 'Muối, tiêu, dầu ăn', NULL),
(37, 11, 'Sườn non heo', NULL),
(38, 11, 'Sốt BBQ', NULL),
(39, 11, 'Tỏi, tiêu xay', NULL),
(40, 11, 'Dầu olive', NULL),
(41, 12, 'Tôm sú tươi', NULL),
(42, 12, 'Muối, ớt, tỏi băm', NULL),
(43, 12, 'Dầu ăn', NULL),
(44, 12, 'Rau ăn kèm', NULL),
(45, 13, 'Tôm, cua, mực xay nhuyễn', NULL),
(46, 13, 'Bánh đa nem', NULL),
(47, 13, 'Miến, mộc nhĩ, cà rốt', NULL),
(48, 13, 'Trứng gà, hành tây', NULL),
(49, 13, 'Gia vị, dầu ăn', NULL),
(50, 14, 'Tôm sú bóc vỏ', NULL),
(51, 14, 'Khoai lang hoặc khoai môn bào sợi', NULL),
(52, 14, 'Bột năng, trứng', NULL),
(53, 14, 'Dầu ăn', NULL),
(54, 15, 'Thịt bò lát mỏng', NULL),
(55, 15, 'Phô mai mozzarella', NULL),
(56, 15, 'Bột chiên xù, bột mì, trứng', NULL),
(57, 15, 'Tiêu, dầu ăn', NULL),
(58, 16, 'Cánh gà', NULL),
(59, 16, 'Nước mắm, đường, tỏi băm', NULL),
(60, 16, 'Bột bắp', NULL),
(61, 16, 'Dầu ăn', NULL),
(62, 17, 'Bột mì (làm vỏ)', NULL),
(63, 17, 'Khoai tây, đậu Hà Lan, cà rốt', NULL),
(64, 17, 'Bột cà ri, bột nghệ', NULL),
(65, 17, 'Dầu ăn', NULL),
(66, 18, 'Thịt bò thái lát mỏng', NULL),
(67, 18, 'Hành lá, gừng, tỏi', NULL),
(68, 18, 'Nước tương, đường nâu, rượu gạo', NULL),
(69, 18, 'Dầu hào, bột bắp', NULL),
(70, 19, 'Mì gạo hoặc mì trứng', NULL),
(71, 19, 'Tôm, mực, sò điệp', NULL),
(72, 19, 'Bột cà ri, giá, hẹ', NULL),
(73, 19, 'Nước tương, dầu mè', NULL),
(74, 20, 'Thịt gà phi lê', NULL),
(75, 20, 'Ớt khô, tiêu Tứ Xuyên', NULL),
(76, 20, 'Hành tây, ớt chuông', NULL),
(77, 20, 'Đậu phộng rang', NULL),
(78, 20, 'Xì dầu, giấm đen', NULL),
(79, 21, 'Mì udon tươi', NULL),
(80, 21, 'Bắp cải, cà rốt, hành tây', NULL),
(81, 21, 'Tôm, thịt ba chỉ', NULL),
(82, 21, 'Nước tương Nhật (shoyu), mirin', NULL),
(83, 22, 'Tôm sú', NULL),
(84, 22, 'Nước cốt me, đường thốt nốt', NULL),
(85, 22, 'Ớt bột, hành lá, ngò rí', NULL),
(86, 22, 'Dầu ăn', NULL),
(87, 23, 'Cá basa hoặc cá lóc', NULL),
(88, 23, 'Nước màu, nước mắm', NULL),
(89, 23, 'Tỏi, hành tím, ớt', NULL),
(90, 23, 'Thịt ba rọi (tùy chọn)', NULL),
(91, 24, 'Thịt ba chỉ', NULL),
(92, 24, 'Trứng gà hoặc vịt', NULL),
(93, 24, 'Nước dừa tươi', NULL),
(94, 24, 'Nước mắm, đường', NULL),
(95, 25, 'Cá trắm hoặc cá trôi', NULL),
(96, 25, 'Riềng, nghệ, sả', NULL),
(97, 25, 'Nước mắm, mẻ chua', NULL),
(98, 25, 'Ớt, hành khô', NULL),
(99, 26, 'Thịt bò gân', NULL),
(100, 26, 'Cà rốt, khoai tây, hành tây', NULL),
(101, 26, 'Rượu vang đỏ, nước dùng bò', NULL),
(102, 26, 'Lá thyme, nguyệt quế', NULL),
(103, 27, 'Thịt gà chặt miếng', NULL),
(104, 27, 'Gừng tươi', NULL),
(105, 27, 'Hành tím, ớt', NULL),
(106, 27, 'Nước mắm, tiêu', NULL),
(107, 28, 'Cá chép', NULL),
(108, 28, 'Xì dầu, dầu mè', NULL),
(109, 28, 'Gừng, hành lá, ngò rí', NULL),
(110, 28, 'Ớt đỏ trang trí', NULL),
(111, 29, 'Tôm sú', NULL),
(112, 29, 'Nước dừa xiêm', NULL),
(113, 29, 'Sả, gừng', NULL),
(114, 29, 'Muối, tiêu', NULL),
(115, 30, 'Bột mì, men nở', NULL),
(116, 30, 'Thịt băm, trứng cút', NULL),
(117, 30, 'Mộc nhĩ, hành tây', NULL),
(118, 30, 'Gia vị', NULL),
(119, 31, 'Gà ta nguyên con', NULL),
(120, 31, 'Muối hột', NULL),
(121, 31, 'Lá chanh, sả', NULL),
(122, 31, 'Gừng', NULL),
(123, 32, 'Cá tuyết hoặc cá hồi phi lê', NULL),
(124, 32, 'Rượu vang trắng', NULL),
(125, 32, 'Cà chua bi, ô liu đen', NULL),
(126, 32, 'Hành tây, tỏi, thì là tươi (dill)', NULL),
(127, 32, 'Dầu olive, muối, tiêu', NULL),
(128, 33, 'Cơm trắng', NULL),
(129, 33, 'Cà rốt, rau bina, giá đỗ, nấm shiitake', NULL),
(130, 33, 'Trứng ốp la (tùy chọn chay trứng)', NULL),
(131, 33, 'Tương ớt gochujang, dầu mè', NULL),
(132, 34, 'Cơm trộn mè, muối, dầu mè', NULL),
(133, 34, 'Rong biển lá', NULL),
(134, 34, 'Cà rốt, dưa leo, rau bina', NULL),
(135, 34, 'Trứng cuộn hoặc đậu hũ chiên', NULL),
(136, 35, 'Nước dashi chay (tảo kombu, nấm)', NULL),
(137, 35, 'Miso trắng', NULL),
(138, 35, 'Đậu hũ non', NULL),
(139, 35, 'Rong biển wakame, hành lá', NULL),
(140, 36, 'Khoai lang, bí đỏ, nấm, đậu que', NULL),
(141, 36, 'Bột tempura, nước đá lạnh', NULL),
(142, 36, 'Dầu chiên', NULL),
(143, 36, 'Nước chấm tentsuyu (xì dầu + mirin + dashi)', NULL),
(144, 37, 'Lá mì lasagna', NULL),
(145, 37, 'Nấm, cà tím, bí ngòi, rau bina', NULL),
(146, 37, 'Sốt cà chua, sốt bechamel chay (sữa hạnh nhân + bột mì + dầu olive)', NULL),
(147, 37, 'Phô mai chay (hoặc mozzarella vegan)', NULL),
(148, 38, 'Bánh ladyfinger (savoiardi)', NULL),
(149, 38, '300g phô mai mascarpone', NULL),
(150, 38, '3 quả trứng gà', NULL),
(151, 38, '100g đường cát', NULL),
(152, 38, '250ml cà phê espresso đậm đặc', NULL),
(153, 38, '30ml rượu Marsala (hoặc rượu rum nâu)', NULL),
(154, 38, '30g bột cacao nguyên chất', NULL),
(155, 39, '200g bột mì + 50g cacao', NULL),
(156, 39, '6 trứng gà', NULL),
(157, 39, '150g đường + 50g bơ', NULL),
(158, 39, '300ml kem whipping', NULL),
(159, 39, '200g cherry ngâm rượu Kirsch', NULL),
(160, 39, 'Chocolate bào trang trí', NULL),
(161, 40, '200g bánh quy Graham, nghiền vụn', NULL),
(162, 40, '80g bơ tan chảy', NULL),
(163, 40, '4 lòng đỏ trứng', NULL),
(164, 40, '1 lon sữa đặc (400g)', NULL),
(165, 40, '120ml nước chanh key lime tươi', NULL),
(166, 40, 'Vỏ chanh bào nhuyễn', NULL),
(167, 40, 'Kem tươi trang trí', NULL),
(168, 41, '150g bột mì', NULL),
(169, 41, '5 trứng gà', NULL),
(170, 41, '120g đường', NULL),
(171, 41, '1 thìa vani', NULL),
(172, 41, '1 hộp sữa đặc', NULL),
(173, 41, '1 hộp sữa bốc hơi (evaporated milk)', NULL),
(174, 41, '200ml sữa tươi nguyên kem', NULL),
(175, 41, 'Kem tươi đánh bông, trái cây trang trí', NULL),
(181, 42, '500ml kem whipping', NULL),
(182, 42, '5 lòng đỏ trứng', NULL),
(183, 42, '100g đường', NULL),
(184, 42, '1 quả vani (hoặc tinh chất vani)', NULL),
(185, 42, 'Đường cát phủ mặt', NULL);

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
  MODIFY `step_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `cong_thuc_nau_an`
--
ALTER TABLE `cong_thuc_nau_an`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

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
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
