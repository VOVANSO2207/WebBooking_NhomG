-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th3 14, 2025 lúc 07:30 AM
-- Phiên bản máy phục vụ: 8.0.31
-- Phiên bản PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `booking_hotel`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `booking_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `room_id` int NOT NULL,
  `promotion_id` int NOT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date NOT NULL,
  `total_price` double NOT NULL,
  `status` enum('confirmed','cancelled','pending') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`booking_id`)
) ENGINE=MyISAM AUTO_INCREMENT=180 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `room_id`, `promotion_id`, `check_in`, `check_out`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(179, 40, 21, 177, '2024-11-30', '2024-12-01', 554040, 'confirmed', '2024-11-29 10:15:52', '2024-11-29 10:16:34'),
(178, 40, 21, 0, '2024-11-30', '2024-12-01', 615600, 'pending', '2024-11-29 10:15:03', '2024-11-29 10:15:03'),
(177, 40, 21, 0, '2024-11-30', '2024-12-01', 615600, 'pending', '2024-11-29 10:14:35', '2024-11-29 10:14:35'),
(176, 40, 24, 177, '2024-11-30', '2024-12-01', 1341360, 'confirmed', '2024-11-29 10:11:48', '2024-11-29 10:12:19'),
(175, 40, 15, 0, '2024-11-30', '2024-12-01', 11852663.8932, 'pending', '2024-11-29 10:09:47', '2024-11-29 10:09:47'),
(174, 40, 15, 0, '2024-11-30', '2024-12-01', 11852663.8932, 'pending', '2024-11-29 10:06:39', '2024-11-29 10:06:39'),
(173, 40, 15, 0, '2024-11-30', '2024-12-01', 11852663.8932, 'pending', '2024-11-29 10:04:56', '2024-11-29 10:04:56'),
(172, 40, 15, 0, '2024-11-30', '2024-12-01', 11852663.8932, 'pending', '2024-11-29 10:04:19', '2024-11-29 10:04:19'),
(171, 40, 15, 0, '2024-11-30', '2024-12-01', 11852663.8932, 'pending', '2024-11-29 10:03:59', '2024-11-29 10:03:59'),
(170, 41, 21, 177, '2024-11-23', '2024-11-24', 554040, 'confirmed', '2024-11-22 18:32:54', '2024-11-22 18:33:01'),
(169, 41, 24, 177, '2024-11-23', '2024-11-24', 1341360, 'confirmed', '2024-11-22 18:29:43', '2024-11-22 18:30:04'),
(168, 41, 21, 0, '2024-11-23', '2024-11-24', 615600, 'pending', '2024-11-22 18:19:17', '2024-11-22 18:19:17'),
(167, 40, 24, 177, '2024-11-23', '2024-11-24', 1341360, 'confirmed', '2024-11-22 17:46:19', '2024-11-22 17:46:43'),
(166, 40, 21, 177, '2024-11-23', '2024-11-24', 554040, 'confirmed', '2024-11-22 17:38:48', '2024-11-22 17:38:55'),
(165, 40, 25, 0, '2024-11-23', '2024-11-24', 1555200, 'confirmed', '2024-11-22 17:33:05', '2024-11-22 17:33:48'),
(164, 41, 25, 0, '2024-11-23', '2024-11-24', 1555200, 'cancelled', '2024-11-22 12:50:33', '2024-11-22 18:06:50'),
(163, 41, 25, 0, '2024-11-23', '2024-11-24', 1555200, 'cancelled', '2024-11-22 12:49:51', '2024-11-22 18:06:20'),
(162, 41, 25, 177, '2024-11-23', '2024-11-24', 1399680, 'confirmed', '2024-11-22 12:48:48', '2024-11-22 12:49:05'),
(161, 41, 21, 177, '2024-11-25', '2024-11-28', 1662120, 'confirmed', '2024-11-22 12:42:38', '2024-11-22 12:43:09'),
(160, 41, 21, 0, '2024-11-25', '2024-11-28', 1846800, 'confirmed', '2024-11-22 12:33:06', '2024-11-22 12:34:17'),
(159, 41, 21, 0, '2024-11-25', '2024-11-28', 1846800, 'pending', '2024-11-22 12:18:55', '2024-11-22 12:18:55'),
(158, 41, 21, 0, '2024-11-25', '2024-11-28', 1846800, 'pending', '2024-11-22 12:08:13', '2024-11-22 12:08:13'),
(157, 41, 21, 0, '2024-11-25', '2024-11-28', 1846800, 'pending', '2024-11-22 12:07:35', '2024-11-22 12:07:35'),
(156, 41, 21, 0, '2024-11-25', '2024-11-28', 1846800, 'pending', '2024-11-22 12:07:20', '2024-11-22 12:07:20'),
(119, 40, 12, 0, '2024-11-21', '2024-11-22', 3175200, 'confirmed', '2024-11-20 10:26:25', '2024-11-20 10:26:25'),
(120, 40, 12, 0, '2024-11-21', '2024-11-22', 3175200, 'confirmed', '2024-11-20 10:31:56', '2024-11-20 10:31:56'),
(121, 40, 12, 0, '2024-11-21', '2024-11-22', 3175200, 'confirmed', '2024-11-20 10:34:12', '2024-11-20 10:34:18'),
(122, 40, 12, 0, '2024-11-21', '2024-11-22', 3175200, 'confirmed', '2024-11-20 10:44:06', '2024-11-20 10:44:12'),
(123, 40, 12, 178, '2024-11-21', '2024-11-22', 3175200, 'pending', '2024-11-20 17:43:09', '2024-11-20 17:43:09'),
(124, 40, 12, 178, '2024-11-21', '2024-11-22', 3175200, 'pending', '2024-11-20 17:43:27', '2024-11-20 17:43:27'),
(155, 41, 21, 0, '2024-11-25', '2024-11-28', 1846800, 'pending', '2024-11-22 12:03:29', '2024-11-22 12:03:29'),
(154, 41, 21, 0, '2024-11-25', '2024-11-28', 1846800, 'pending', '2024-11-22 11:57:13', '2024-11-22 11:57:13'),
(153, 41, 21, 0, '2024-11-25', '2024-11-28', 1846800, 'pending', '2024-11-22 11:53:40', '2024-11-22 11:53:40'),
(152, 41, 24, 0, '2024-11-23', '2024-11-24', 1490400, 'confirmed', '2024-11-22 10:45:51', '2024-11-22 10:45:56'),
(151, 41, 24, 0, '2024-11-23', '2024-11-24', 1490400, 'confirmed', '2024-11-22 10:43:27', '2024-11-22 10:43:32'),
(150, 40, 12, 0, '2024-11-23', '2024-11-24', 3175200, 'confirmed', '2024-11-22 10:42:13', '2024-11-22 10:42:19'),
(149, 40, 21, 0, '2024-11-22', '2024-11-23', 615600, 'confirmed', '2024-11-22 10:41:07', '2024-11-22 10:41:13'),
(148, 40, 21, 0, '2024-11-22', '2024-11-23', 615600, 'confirmed', '2024-11-22 10:36:24', '2024-11-22 10:41:00'),
(147, 41, 24, 0, '2024-11-22', '2024-11-23', 1490400, 'confirmed', '2024-11-22 09:58:18', '2024-11-22 09:58:38'),
(146, 41, 25, 177, '2024-11-24', '2024-11-26', 2799360, 'confirmed', '2024-11-22 07:40:37', '2024-11-22 07:40:59'),
(145, 41, 21, 0, '2024-11-24', '2024-11-26', 1231200, 'confirmed', '2024-11-22 07:38:02', '2024-11-22 07:38:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `city_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cities`
--

INSERT INTO `cities` (`city_id`, `city_name`) VALUES
(1, 'Hà Nội'),
(2, 'Hồ Chí Minh'),
(3, 'Đà Nẵng'),
(4, 'Nha Trang'),
(5, 'Huế'),
(6, 'Cần Thơ'),
(7, 'Vũng Tàu'),
(8, 'Đà Lạt'),
(9, 'Hạ Long'),
(10, 'Biên Hòa'),
(11, 'Ninh Thuận '),
(12, 'Bình Thuận '),
(13, 'Quảng Nam '),
(14, 'Lào Cai');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `favorite_hotels`
--

DROP TABLE IF EXISTS `favorite_hotels`;
CREATE TABLE IF NOT EXISTS `favorite_hotels` (
  `favorite_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `hotel_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`favorite_id`),
  KEY `favorite_hotels_hotel_id_foreign` (`hotel_id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `favorite_hotels`
--

INSERT INTO `favorite_hotels` (`favorite_id`, `user_id`, `hotel_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL),
(2, 2, 3, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 2, NULL, NULL),
(5, 5, 5, NULL, NULL),
(6, 6, 3, NULL, NULL),
(7, 7, 4, NULL, NULL),
(8, 8, 1, NULL, NULL),
(9, 9, 5, NULL, NULL),
(10, 10, 6, NULL, NULL),
(11, 1, 2, NULL, NULL),
(12, 2, 3, NULL, NULL),
(13, 3, 1, NULL, NULL),
(14, 4, 2, NULL, NULL),
(15, 5, 5, NULL, NULL),
(16, 6, 3, NULL, NULL),
(17, 7, 4, NULL, NULL),
(18, 8, 1, NULL, NULL),
(19, 9, 5, NULL, NULL),
(26, 14, 1, '2024-11-06 06:13:58', '2024-11-06 06:13:58'),
(32, 14, 2, '2024-11-06 10:22:24', '2024-11-06 10:22:24'),
(33, 29, 2, '2024-11-08 03:33:06', '2024-11-08 03:33:06'),
(29, 14, 4, '2024-11-06 08:53:32', '2024-11-06 08:53:32'),
(34, 31, 1, '2024-11-08 07:12:33', '2024-11-08 07:12:33'),
(35, 31, 2, '2024-11-08 07:12:36', '2024-11-08 07:12:36'),
(36, 33, 2, '2024-11-09 10:14:37', '2024-11-09 10:14:37'),
(37, 34, 1, '2024-11-09 19:21:18', '2024-11-09 19:21:18'),
(38, 38, 1, '2024-11-10 00:59:36', '2024-11-10 00:59:36'),
(39, 38, 2, '2024-11-10 00:59:39', '2024-11-10 00:59:39'),
(42, 34, 6, '2024-11-10 02:45:11', '2024-11-10 02:45:11'),
(43, 34, 4, '2024-11-10 04:04:59', '2024-11-10 04:04:59'),
(44, 39, 1, '2024-11-11 04:03:17', '2024-11-11 04:03:17'),
(45, 39, 2, '2024-11-11 04:03:18', '2024-11-11 04:03:18'),
(49, 39, 3, '2024-11-15 18:55:59', '2024-11-15 18:55:59'),
(51, 40, 1, '2024-11-16 23:33:30', '2024-11-16 23:33:30'),
(52, 40, 2, '2024-11-20 07:31:51', '2024-11-20 07:31:51'),
(53, 40, 3, '2024-11-20 07:31:52', '2024-11-20 07:31:52'),
(59, 41, 2, '2024-11-20 20:12:39', '2024-11-20 20:12:39'),
(58, 41, 1, '2024-11-20 20:12:38', '2024-11-20 20:12:38'),
(60, 41, 3, '2024-11-20 20:13:03', '2024-11-20 20:13:03'),
(75, 41, 4, '2024-11-22 11:35:34', '2024-11-22 11:35:34'),
(77, 41, 5, '2024-11-27 17:38:43', '2024-11-27 17:38:43'),
(78, 47, 1, '2024-11-27 17:43:16', '2024-11-27 17:43:16'),
(79, 47, 3, '2024-11-27 17:43:29', '2024-11-27 17:43:29'),
(81, 48, 1, '2025-02-23 03:45:04', '2025-02-23 03:45:04'),
(82, 48, 2, '2025-02-23 03:45:07', '2025-02-23 03:45:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hotels`
--

DROP TABLE IF EXISTS `hotels`;
CREATE TABLE IF NOT EXISTS `hotels` (
  `hotel_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `hotel_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`hotel_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hotels`
--

INSERT INTO `hotels` (`hotel_id`, `hotel_name`, `location`, `city_id`, `description`, `rating`, `created_at`, `updated_at`) VALUES
(1, 'Khách sạn Sài Gòn Star', 'Quận 1, TP.HCM', 2, '<p><strong>Kh&aacute;ch sạn 4 sao tại trung t&acirc;m Quận 1 với dịch vụ chất lượng.</strong>Nằm giữa v&ugrave;ng đất nhiệt đới, khu nghỉ dưỡng sở hữu hồ bơi nước mặn rộng lớn, nơi du kh&aacute;ch c&oacute; thể bơi lội hoặc thư gi&atilde;n dưới &aacute;nh mặt trời. C&aacute;c ph&ograve;ng nghỉ được thiết kế với ban c&ocirc;ng lớn, gi&uacute;p bạn tận hưởng khung cảnh đầm ph&aacute; xanh m&aacute;t. Ngo&agrave;i ra, khu vực spa, ph&ograve;ng gym v&agrave; c&aacute;c lớp học yoga l&agrave; những tiện &iacute;ch tuyệt vời để t&aacute;i tạo năng lượng.Kh&aacute;ch sạn đ&ocirc; thị hiện đại tọa lạc gần c&aacute;c trung t&acirc;m thương mại v&agrave; giải tr&iacute; lớn. Được thiết kế d&agrave;nh ri&ecirc;ng cho giới trẻ năng động, c&aacute;c ph&ograve;ng nghỉ tại đ&acirc;y c&oacute; phong c&aacute;ch sống động với những bức tranh tường đầy m&agrave;u sắc. Du kh&aacute;ch c&oacute; thể thư gi&atilde;n tại quầy bar tầng thượng với tầm nh&igrave;n to&agrave;n cảnh th&agrave;nh phố.</p>', '3.00', NULL, '2024-11-22 18:21:06'),
(2, 'Khách sạn Hà Nội Elegance', '47 Hoàn Kiếm', 1, '<p>Kh&aacute;ch sạn boutique tại H&agrave; Nội với view hồ Ho&agrave;n Kiếm.Nằm ẩn m&igrave;nh giữa rừng n&uacute;i xanh m&aacute;t, kh&aacute;ch sạn l&agrave; nơi ho&agrave;n hảo để tho&aacute;t khỏi sự ồn &agrave;o của cuộc sống thường nhật. C&aacute;c ph&ograve;ng nghỉ được thiết kế với phong c&aacute;ch gần gũi, sử dụng vật liệu gỗ tự nhi&ecirc;n để tạo sự ấm &aacute;p. Du kh&aacute;ch c&oacute; thể thưởng ngoạn cảnh n&uacute;i non h&ugrave;ng vĩ, đi bộ đường m&ograve;n, hoặc tham gia c&aacute;c buổi yoga buổi s&aacute;ng để t&aacute;i tạo năng lượng.Kh&aacute;ch sạn 5 sao với kiến tr&uacute;c sang trọng, nội thất được chăm ch&uacute;t từng chi tiết. Nằm tại khu vực s&ocirc;i động của th&agrave;nh phố, Golden Palm Hotel mang đến trải nghiệm đẳng cấp với c&aacute;c ph&ograve;ng hội nghị, nh&agrave; h&agrave;ng quốc tế, v&agrave; quầy bar phục vụ cocktail đ&ecirc;m. Đ&acirc;y l&agrave; sự lựa chọn ho&agrave;n hảo cho cả doanh nh&acirc;n v&agrave; du kh&aacute;ch t&igrave;m kiếm sự tiện nghi v&agrave; phong c&aacute;ch</p>', '5.00', NULL, '2024-11-22 19:25:03'),
(3, 'Khách sạn Đà Nẵng Golden Bay', '50 Sơn Trà, Đà Nẵng', 3, '<p>Kh&aacute;ch sạn 5 sao với bể bơi v&agrave;ng 24k, view biển tuyệt đẹp.Khu nghỉ dưỡng y&ecirc;n tĩnh n&eacute;p m&igrave;nh b&ecirc;n bờ vịnh, mang lại kh&ocirc;ng gian ho&agrave;n hảo để thư gi&atilde;n. Với c&aacute;c bungalow ri&ecirc;ng biệt được x&acirc;y dựng bằng vật liệu th&acirc;n thiện m&ocirc;i trường, kh&aacute;ch sạn tạo cảm gi&aacute;c gần gũi với thi&ecirc;n nhi&ecirc;n. Du kh&aacute;ch c&oacute; thể ch&egrave;o thuyền kayak tr&ecirc;n vịnh hoặc thưởng thức c&aacute;c bữa tiệc BBQ ngo&agrave;i trời.Một kh&aacute;ch sạn sang trọng với tầm nh&igrave;n to&agrave;n cảnh th&agrave;nh phố về đ&ecirc;m. C&aacute;c ph&ograve;ng nghỉ được trang bị nội thất cao cấp, với cửa sổ k&iacute;nh suốt từ trần đến s&agrave;n để tối ưu h&oacute;a cảnh quan. Nh&agrave; h&agrave;ng trong kh&aacute;ch sạn phục vụ c&aacute;c m&oacute;n ăn quốc tế, trong khi quầy bar tr&ecirc;n tầng thượng l&agrave; nơi l&yacute; tưởng để ngắm sao v&agrave; thư gi&atilde;n.</p>', '4.90', NULL, '2024-11-22 19:23:15'),
(4, 'Khách sạn Nha Trang Beach', 'Nha Trang, Khánh Hòa', 4, '<p>Kh&aacute;ch sạn ven biển Nha Trang với view nh&igrave;n ra biển.</p>', '4.30', NULL, '2024-11-11 09:22:54'),
(5, 'Khách sạn Phú Quốc Resort', 'Dương Đông, Phú Quốc', 5, 'Resort nghỉ dưỡng 5 sao với bãi biển riêng tại Phú Quốc.', '4.80', NULL, NULL),
(6, 'Khách sạn Vinpearl Luxury', 'Vũng Tàu, Bà Rịa - Vũng Tàu', 6, '<p>Kh&aacute;ch sạn sang trọng b&ecirc;n bờ biển tại Vũng T&agrave;u.</p>', '4.60', NULL, '2024-11-09 10:10:25'),
(7, 'Khách sạn Lotte Hà Nội', 'Ba Đình, Hà Nội', 1, '<p>Kh&aacute;ch sạn cao cấp tại H&agrave; Nội với view to&agrave;n cảnh th&agrave;nh phố.</p>', '4.90', NULL, '2024-11-22 08:08:07'),
(8, 'Khách sạn Hội An Heritage', 'Hội An, Quảng Nam', 13, '<p>Kh&aacute;ch sạn 4 sao với kiến tr&uacute;c cổ k&iacute;nh đặc trưng của Hội An.</p>', '4.40', NULL, '2024-11-22 08:09:30'),
(9, 'Khách sạn Sapa Paradise', 'Sapa, Lào Cai', 14, '<p>Kh&aacute;ch sạn tr&ecirc;n n&uacute;i với view nh&igrave;n ra ruộng bậc thang v&agrave; thung lũng.</p>', '4.60', NULL, '2024-11-22 08:09:58'),
(10, 'Khách sạn Hạ Long Bay View', 'Hạ Long, Quảng Ninh', 9, '<p>Kh&aacute;ch sạn với view nh&igrave;n ra vịnh Hạ Long nổi tiếng.</p>', '4.70', NULL, '2024-11-11 09:21:43'),
(11, 'Khách sạn Sài Gòn Star', 'Quận 1, TP.HCM', 2, '<p>Kh&aacute;ch sạn 4 sao tại trung t&acirc;m Quận 1 với dịch vụ chất lượng.</p>', '4.50', NULL, '2024-11-22 08:16:41'),
(12, 'Khách sạn Hà Nội Elegance', 'Hoàn Kiếm, Hà Nội', 1, '<p>Kh&aacute;ch sạn boutique tại H&agrave; Nội với view hồ Ho&agrave;n Kiếm.</p>', '4.70', NULL, '2024-11-22 08:17:08'),
(13, 'Khách sạn Đà Nẵng Golden Bay', 'Sơn Trà, Đà Nẵng', 3, '<p>Kh&aacute;ch sạn 5 sao với bể bơi v&agrave;ng 24k, view biển tuyệt đẹp.</p>', '4.90', NULL, '2024-11-22 08:17:27'),
(14, 'Khách sạn Nha Trang Beach', 'Nha Trang, Khánh Hòa', 4, 'Khách sạn ven biển Nha Trang với view nhìn ra biển.', '4.30', NULL, NULL),
(15, 'Khách sạn Phú Quốc Resort', 'Dương Đông, Phú Quốc', 5, 'Resort nghỉ dưỡng 5 sao với bãi biển riêng tại Phú Quốc.', '4.80', NULL, NULL),
(16, 'Khách sạn Vinpearl Luxury', 'Vũng Tàu, Bà Rịa - Vũng Tàu', 6, 'Khách sạn sang trọng bên bờ biển tại Vũng Tàu.', '4.60', NULL, NULL),
(17, 'Khách sạn Lotte Hà Nội', 'Ba Đình, Hà Nội', 2, 'Khách sạn cao cấp tại Hà Nội với view toàn cảnh thành phố.', '4.90', NULL, NULL),
(18, 'Khách sạn Hội An Heritage', 'Hội An, Quảng Nam', 7, 'Khách sạn 4 sao với kiến trúc cổ kính đặc trưng của Hội An.', '4.40', NULL, NULL),
(19, 'Khách sạn Sapa Paradise', 'Sapa, Lào Cai', 8, 'Khách sạn trên núi với view nhìn ra ruộng bậc thang và thung lũng.', '4.60', NULL, NULL),
(20, 'Khách sạn Hạ Long Bay View', 'Hạ Long, Quảng Ninh', 9, 'Khách sạn với view nhìn ra vịnh Hạ Long nổi tiếng.', '4.70', NULL, NULL),
(21, 'Saigon Ninh Chữ Hotel Resort', '30 Đường chinh , khu phố 5', 11, '<p>Biệt thự nghỉ dưỡng sang trọng tọa lạc giữa khu vườn nhiệt đới xanh m&aacute;t. Mỗi căn biệt thự đều c&oacute; hồ bơi ri&ecirc;ng, s&acirc;n hi&ecirc;n v&agrave; kh&ocirc;ng gian sống rộng r&atilde;i, l&yacute; tưởng cho c&aacute;c cặp đ&ocirc;i hoặc gia đ&igrave;nh muốn c&oacute; kh&ocirc;ng gian ri&ecirc;ng tư. Du kh&aacute;ch sẽ được tận hưởng c&aacute;c liệu ph&aacute;p spa độc quyền v&agrave; bữa tối l&atilde;ng mạn dưới &aacute;nh nến b&ecirc;n hồ.Nằm tr&ecirc;n con đường y&ecirc;n tĩnh, kh&aacute;ch sạn boutique nhỏ xinh mang phong c&aacute;ch hiện đại nhưng kh&ocirc;ng k&eacute;m phần gần gũi. C&aacute;c ph&ograve;ng nghỉ được thiết kế trang nh&atilde; với cửa sổ lớn để đ&oacute;n &aacute;nh s&aacute;ng tự nhi&ecirc;n. Kh&aacute;ch sạn cung cấp dịch vụ c&aacute; nh&acirc;n h&oacute;a để mỗi kỳ nghỉ của du kh&aacute;ch trở n&ecirc;n độc đ&aacute;o v&agrave; đ&aacute;ng nhớ.</p>', '5.00', '2024-11-21 09:00:56', '2024-11-29 11:01:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hotel_amenities`
--

DROP TABLE IF EXISTS `hotel_amenities`;
CREATE TABLE IF NOT EXISTS `hotel_amenities` (
  `amenity_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `amenity_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`amenity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hotel_amenities`
--

INSERT INTO `hotel_amenities` (`amenity_id`, `amenity_name`, `description`) VALUES
(1, 'Wi-Fi miễn phí', 'Khách sạn cung cấp Wi-Fi miễn phí tốc độ cao.'),
(2, 'Hồ bơi ngoài trời', 'Hồ bơi ngoài trời với view biển tuyệt đẹp.'),
(3, 'Nhà hàng 24/7', 'Nhà hàng phục vụ thực đơn đa dạng, hoạt động suốt 24 giờ.'),
(4, 'Spa và massage', 'Dịch vụ spa và massage chuyên nghiệp cho khách lưu trú.'),
(5, 'Phòng tập gym', 'Phòng tập gym đầy đủ trang thiết bị hiện đại.'),
(6, 'Dịch vụ đưa đón sân bay', 'Dịch vụ đưa đón sân bay miễn phí cho khách lưu trú.'),
(7, 'Bãi biển riêng', 'Khách sạn có bãi biển riêng chỉ dành cho khách lưu trú.'),
(8, 'Phòng hội nghị', 'Phòng hội nghị hiện đại với sức chứa lên đến 200 người.'),
(9, 'Dịch vụ giặt ủi', 'Dịch vụ giặt ủi nhanh chóng, tiện lợi cho khách hàng.'),
(10, 'Bar trên tầng thượng', 'Bar trên tầng thượng với view toàn cảnh thành phố.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hotel_amenity_hotel`
--

DROP TABLE IF EXISTS `hotel_amenity_hotel`;
CREATE TABLE IF NOT EXISTS `hotel_amenity_hotel` (
  `hotel_id` int UNSIGNED NOT NULL,
  `amenity_id` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hotel_amenity_hotel`
--

INSERT INTO `hotel_amenity_hotel` (`hotel_id`, `amenity_id`) VALUES
(1, 2),
(1, 3),
(2, 2),
(2, 1),
(3, 2),
(3, 4),
(8, 2),
(8, 3),
(9, 3),
(4, 3),
(2, 5),
(3, 5),
(21, 1),
(21, 2),
(21, 3),
(21, 4),
(21, 6),
(21, 7),
(21, 8),
(21, 9),
(21, 10),
(1, 1),
(1, 4),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(2, 3),
(2, 4),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(22, 1),
(22, 2),
(22, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hotel_images`
--

DROP TABLE IF EXISTS `hotel_images`;
CREATE TABLE IF NOT EXISTS `hotel_images` (
  `image_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `hotel_id` int NOT NULL,
  `image_url` char(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`image_id`),
  KEY `hotel_images_image_url_foreign` (`image_url`)
) ENGINE=MyISAM AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hotel_images`
--

INSERT INTO `hotel_images` (`image_id`, `hotel_id`, `image_url`) VALUES
(1, 1, '1729697989_au-lac-charner-hotel.jpg'),
(2, 1, '1729730246_535569598.jpg'),
(73, 3, '1732266587_le-tan-b0010881.jpg'),
(69, 2, '1732265878_mat-tien-b0010979.jpg'),
(128, 21, '1732324515_278471276.jpg'),
(72, 3, '1732266587_le-tan-4w9a7981.jpg'),
(127, 21, '1732324515_266335751.jpg'),
(77, 4, '1732267535_pt-3.jpg'),
(9, 5, '1729759318_vanda-hotel-family-junior-suite1.jpg'),
(10, 5, '1729759318_vanda-hotel-family-junior-suite1.jpg'),
(11, 1, '1729759318_vanda-hotel-family-junior-suite1.jpg'),
(12, 1, '1729759318_vanda-hotel-family-junior-suite1.jpg'),
(68, 2, '1732265878_mat-tien-4w9a8084.jpg'),
(67, 2, '1732265878_le-tan-b0010883.jpg'),
(71, 3, '1732266587_ho-boi-4w9a8014.jpg'),
(70, 3, '1732266587_ho-boi-4w9a7987.jpg'),
(76, 4, '1732267535_pt-2.jpg'),
(75, 4, '1732267535_pt-1.jpg'),
(19, 5, '1729759318_vanda-hotel-family-junior-suite1.jpg'),
(20, 5, '1729759318_vanda-hotel-family-junior-suite1.jpg'),
(79, 6, '1732288025_1732204856_le-tan-b0010881.jpg'),
(85, 7, '1732288087_ho-boi-4w9a7987.jpg'),
(94, 8, '1732288170_264144137.jpg'),
(93, 8, '1732288170_257959581.jpg'),
(92, 8, '1732288170_16260062_20071716540091610640.jpg'),
(91, 8, '1732288170_48278_BJ7EPFZ6U8_mu-ng-thanh-luxury-sai.jpg'),
(98, 9, '1732288198_266337013.jpg'),
(97, 9, '1732288198_264144137.jpg'),
(96, 9, '1732288198_257959581.jpg'),
(104, 10, '1732288247_Binh-Thuan-3.jpg'),
(103, 10, '1732288247_26574183.jpg'),
(102, 10, '1732288247_18-4.jpg'),
(126, 21, '1732324515_266335748.jpg'),
(125, 21, '1732324515_266335649.jpg'),
(124, 21, '1732324515_266335638.jpg'),
(66, 2, '1732265878_le-tan-b0010881.jpg'),
(65, 2, '1732265878_img21.jpg'),
(74, 3, '1732266587_sanh-chinh-10.jpg'),
(78, 4, '1732267535_pt-4.jpg'),
(80, 6, '1732288025_1732204856_mat-tien-4w9a8084.jpg'),
(81, 6, '1732288025_1732264710.jpg'),
(82, 6, '1732288025_1732264760.jpg'),
(83, 6, '1732288025_1732264777.jpg'),
(84, 6, '1732288025_1732264794.jpg'),
(86, 7, '1732288087_ho-boi-4w9a8014.jpg'),
(87, 7, '1732288087_img21.jpg'),
(88, 7, '1732288088_le-tan-4w9a7981.jpg'),
(89, 7, '1732288088_le-tan-b0010881.jpg'),
(90, 7, '1732288088_sanh-chinh-10.jpg'),
(95, 8, '1732288170_266337013.jpg'),
(99, 9, '1732288198_266338754.jpg'),
(100, 9, '1732288198_278471276.jpg'),
(101, 9, '1732288198_oOI3pWnSTvWhFRluMXnCOQ-3-Reception Desk 1.jpg'),
(105, 10, '1732288247_du-lich-1701353092-9545-1701353936.jpg'),
(106, 10, '1732288247_khach-san-binh-thuan-hai-yen-resort.jpg'),
(107, 11, '1732288601_du-lich-1701353092-9545-1701353936.jpg'),
(108, 11, '1732288601_khach-san-binh-thuan-hai-yen-resort.jpg'),
(109, 11, '1732288601_khach-san-mui-ne-5-sao_54.jpg'),
(110, 11, '1732288601_Resort-Binh-Thuan-36.jpg'),
(111, 11, '1732288601_the-anam-mui-ne-resort-0.jpg'),
(112, 12, '1732288628_18-4.jpg'),
(113, 12, '1732288628_Binh-Thuan-3.jpg'),
(114, 12, '1732288628_du-lich-1701353092-9545-1701353936.jpg'),
(115, 12, '1732288628_khach-san-binh-thuan-hai-yen-resort.jpg'),
(116, 12, '1732288628_khach-san-binh-thuan-sea-links-beach-resort.jpg'),
(117, 12, '1732288628_the-anam-mui-ne-resort-0.jpg'),
(118, 13, '1732288647_487028735.jpg'),
(119, 13, '1732288647_BI-Travel-Top-Resort-Tai-Ninh-Thuan.jpg'),
(120, 13, '1732288647_caption (1).jpg'),
(121, 13, '1732288647_caption.jpg'),
(122, 13, '1732288647_images (1).jpg'),
(123, 13, '1732288647_images.jpg'),
(129, 22, '1732903509_room10.jpg'),
(130, 22, '1732903509_room11.jpg'),
(131, 22, '1732903509_room12.jpg'),
(132, 22, '1732903509_room13.jpg'),
(133, 22, '1732903509_thiet-ka-nha-pho-2.jpg'),
(134, 22, '1732903509_vanda-hotel-family-junior-suite1.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_10_17_102412_create_hotels_table', 1),
(2, '2024_10_17_102413_create_users_table', 1),
(3, '2024_10_17_102414_create_reviews_table', 1),
(4, '2024_10_17_102415_create_favorite_hotels_table', 1),
(5, '2024_10_17_102416_create_hotel_amenities_table', 1),
(6, '2024_10_17_102417_create_order_history_table', 1),
(7, '2024_10_17_102418_create_rooms_table', 1),
(8, '2024_10_17_102419_create_room_amenities_table', 1),
(9, '2024_10_17_102420_create_promotions_table', 1),
(10, '2024_10_17_102421_create_room_images_table', 1),
(11, '2024_10_17_102422_create_booking_table', 1),
(12, '2024_10_17_102423_create_hotel_images_table', 1),
(13, '2024_10_17_102424_create_payments_table', 1),
(14, '2024_10_17_102425_create_review_images_table', 1),
(15, '2024_10_17_102426_create_notifications_table', 1),
(16, '2024_10_17_104336_create_cities_table', 1),
(17, '2024_10_17_104338_create_posts_table', 1),
(18, '2024_10_17_104339_create_roles_table', 1),
(19, '2024_10_17_233610_room_type', 1),
(20, '2024_10_18_102201_create_sessions_table', 1),
(21, '2024_10_24_005338_create_room_amenity_room_table', 1),
(22, '2024_10_25_160607_create_hotel_amenity_hotel', 2),
(23, '2024_10_26_083450_add_fulltext_index_to_posts', 2),
(24, '2024_10_26_084200_add_fulltext_index_to_promotion_code_in_promotions_table', 2),
(25, '2024_10_26_194913_add_fulltext_index_to_rooms_table', 2),
(26, '2024_10_29_013419_create_cache_table', 3),
(27, '2024_11_03_155445_add_fulltext_index_to_room_types_table', 4),
(28, '2024_11_01_125051_create_website_visits_table', 5),
(29, '2024_11_05_033310_add_fulltext_indexes_to_room_amenities_table', 6),
(30, '2024_11_05_103153_add_fulltext_index_to_room_amenities', 7),
(31, '2024_11_10_112914_add_pro_description_to_promotions_table', 8),
(32, '2024_11_11_140432_add_pro_title_to_promotions_table', 8),
(33, '2024_11_16_143419_create_review_likes_table', 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`notification_id`),
  KEY `notifications_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bạn có một đơn hàng mới đang chờ xác nhận.', 'chưa đọc', NULL, NULL),
(2, 2, 'Đơn hàng của bạn đã được gửi đi.', 'chưa đọc', NULL, NULL),
(3, 3, 'Bạn có tin nhắn mới từ hỗ trợ khách hàng.', 'đã đọc', NULL, NULL),
(4, 4, 'Yêu cầu đổi mật khẩu của bạn đã thành công.', 'chưa đọc', NULL, NULL),
(5, 5, 'Cập nhật hệ thống sẽ diễn ra vào lúc 00:00 ngày mai.', 'đã đọc', NULL, NULL),
(6, 6, 'Bạn đã đạt được hạng thành viên VIP.', 'chưa đọc', NULL, NULL),
(7, 7, 'Thông báo khuyến mãi đặc biệt cho khách hàng thân thiết.', 'đã đọc', NULL, NULL),
(8, 8, 'Đơn hàng của bạn đã bị hủy.', 'chưa đọc', NULL, NULL),
(9, 9, 'Sản phẩm trong giỏ hàng của bạn đang giảm giá.', 'đã đọc', NULL, NULL),
(10, 10, 'Phiếu giảm giá của bạn sắp hết hạn.', 'chưa đọc', NULL, NULL),
(11, 1, 'Bạn có một đơn hàng mới đang chờ xác nhận.', 'chưa đọc', NULL, NULL),
(12, 2, 'Đơn hàng của bạn đã được gửi đi.', 'chưa đọc', NULL, NULL),
(13, 3, 'Bạn có tin nhắn mới từ hỗ trợ khách hàng.', 'đã đọc', NULL, NULL),
(14, 4, 'Yêu cầu đổi mật khẩu của bạn đã thành công.', 'chưa đọc', NULL, NULL),
(15, 5, 'Cập nhật hệ thống sẽ diễn ra vào lúc 00:00 ngày mai.', 'đã đọc', NULL, NULL),
(16, 6, 'Bạn đã đạt được hạng thành viên VIP.', 'chưa đọc', NULL, NULL),
(17, 7, 'Thông báo khuyến mãi đặc biệt cho khách hàng thân thiết.', 'đã đọc', NULL, NULL),
(18, 8, 'Đơn hàng của bạn đã bị hủy.', 'chưa đọc', NULL, NULL),
(19, 9, 'Sản phẩm trong giỏ hàng của bạn đang giảm giá.', 'đã đọc', NULL, NULL),
(20, 10, 'Phiếu giảm giá của bạn sắp hết hạn.', 'chưa đọc', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_histories`
--

DROP TABLE IF EXISTS `order_histories`;
CREATE TABLE IF NOT EXISTS `order_histories` (
  `history_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `booking_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`history_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_histories`
--

INSERT INTO `order_histories` (`history_id`, `user_id`, `booking_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 2, NULL, NULL),
(3, 3, 3, NULL, NULL),
(4, 4, 4, NULL, NULL),
(5, 5, 5, NULL, NULL),
(6, 6, 6, NULL, NULL),
(7, 7, 7, NULL, NULL),
(8, 8, 8, NULL, NULL),
(9, 9, 9, NULL, NULL),
(10, 10, 10, NULL, NULL),
(11, 1, 1, NULL, NULL),
(12, 2, 2, NULL, NULL),
(13, 3, 3, NULL, NULL),
(14, 4, 4, NULL, NULL),
(15, 5, 5, NULL, NULL),
(16, 6, 6, NULL, NULL),
(17, 7, 7, NULL, NULL),
(18, 8, 8, NULL, NULL),
(19, 9, 9, NULL, NULL),
(20, 10, 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `payment_status` enum('Completed','Pending','Failed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `payment_date` datetime NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `payments_payment_status_foreign` (`payment_status`)
) ENGINE=MyISAM AUTO_INCREMENT=174 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `payment_status`, `payment_method`, `amount`, `payment_date`) VALUES
(1, 1, 'Completed', '', 150, '2024-10-24 02:02:36'),
(2, 2, 'Pending', '', 200.5, '2024-10-24 02:02:36'),
(3, 3, 'Failed', '', 100.75, '2024-10-24 02:02:36'),
(4, 4, 'Completed', '', 250, '2024-10-24 02:02:36'),
(5, 5, 'Completed', '', 300, '2024-10-24 02:02:36'),
(6, 6, 'Pending', '', 120, '2024-10-24 02:02:36'),
(7, 7, 'Completed', '', 90.5, '2024-10-24 02:02:36'),
(8, 8, 'Failed', '', 180, '2024-10-24 02:02:36'),
(9, 9, 'Completed', '', 150.25, '2024-10-24 02:02:36'),
(10, 10, 'Pending', '', 200, '2024-10-24 02:02:36'),
(11, 1, 'Completed', '', 150, '2024-10-24 02:06:03'),
(12, 2, 'Pending', '', 200.5, '2024-10-24 02:06:03'),
(13, 3, 'Failed', '', 100.75, '2024-10-24 02:06:03'),
(76, 76, 'Completed', 'vnpay', 3175200, '2024-11-19 15:49:53'),
(75, 75, 'Completed', 'vnpay', 3175200, '2024-11-19 15:45:46'),
(83, 86, 'Pending', 'check_in', 3175200, '2024-11-19 16:57:52'),
(82, 85, 'Pending', 'check_in', 3175200, '2024-11-19 16:55:43'),
(81, 84, 'Pending', 'vnpay', 3175200, '2024-11-19 16:48:04'),
(93, 99, 'Pending', 'check_in', 3175200, '2024-11-20 04:42:51'),
(92, 98, 'Pending', 'check_in', 3175200, '2024-11-20 04:41:52'),
(91, 97, 'Pending', 'check_in', 3175200, '2024-11-20 04:41:03'),
(90, 96, 'Pending', 'check_in', 3175200, '2024-11-20 04:40:29'),
(89, 95, 'Pending', 'check_in', 3175200, '2024-11-19 17:30:13'),
(88, 94, 'Pending', 'check_in', 3175200, '2024-11-19 17:26:27'),
(87, 93, 'Completed', 'vnpay', 3175200, '2024-11-19 17:24:58'),
(86, 89, 'Pending', 'check_in', 3175200, '2024-11-19 17:17:40'),
(85, 88, 'Pending', 'check_in', 3175200, '2024-11-19 17:16:34'),
(84, 87, 'Pending', 'check_in', 3175200, '2024-11-19 17:05:55'),
(80, 83, 'Pending', 'cod', 3175200, '2024-11-19 16:14:40'),
(79, 81, 'Pending', 'cod', 3175200, '2024-11-19 16:13:55'),
(78, 79, 'Pending', 'cod', 3175200, '2024-11-19 16:13:38'),
(77, 77, 'Completed', 'vnpay', 3175200, '2024-11-19 15:50:39'),
(74, 74, 'Completed', 'vnpay', 3175200, '2024-11-19 15:38:49'),
(73, 73, 'Completed', 'vnpay', 3175200, '2024-11-19 15:32:04'),
(72, 72, 'Completed', 'vnpay', 3175200, '2024-11-19 15:00:04'),
(94, 100, 'Pending', 'check_in', 3175200, '2024-11-20 05:15:44'),
(95, 101, 'Pending', 'check_in', 3175200, '2024-11-20 08:01:53'),
(96, 102, 'Pending', 'check_in', 3175200, '2024-11-20 08:21:55'),
(97, 103, 'Pending', 'vnpay', 3175200, '2024-11-20 08:33:17'),
(98, 104, 'Completed', 'vnpay', 160650000, '2024-11-20 08:36:30'),
(99, 105, 'Pending', 'check_in', 3175200, '2024-11-20 08:46:52'),
(100, 106, 'Pending', 'check_in', 3175200, '2024-11-20 08:48:10'),
(101, 107, 'Pending', 'check_in', 3175200, '2024-11-20 08:55:02'),
(102, 108, 'Completed', 'vnpay', 5715360, '2024-11-20 09:02:09'),
(103, 109, 'Completed', 'vnpay', 6350400, '2024-11-20 09:07:27'),
(104, 110, 'Completed', 'vnpay', 6350400, '2024-11-20 09:11:17'),
(105, 111, 'Pending', 'check_in', 2857680, '2024-11-20 14:29:25'),
(106, 112, 'Pending', 'check_in', 3175200, '2024-11-20 15:39:25'),
(107, 113, 'Pending', 'check_in', 3175200, '2024-11-20 15:41:50'),
(108, 114, 'Pending', 'check_in', 3175200, '2024-11-20 15:51:29'),
(109, 115, 'Pending', 'check_in', 3175200, '2024-11-20 15:52:38'),
(110, 116, 'Pending', 'check_in', 3175200, '2024-11-20 15:58:17'),
(111, 117, 'Pending', 'check_in', 160650000, '2024-11-20 15:59:35'),
(112, 118, 'Pending', 'check_in', 3175200, '2024-11-20 17:24:54'),
(113, 119, 'Pending', 'check_in', 3175200, '2024-11-20 17:26:25'),
(114, 120, 'Pending', 'check_in', 3175200, '2024-11-20 17:31:56'),
(115, 121, 'Pending', 'check_in', 3175200, '2024-11-20 17:34:12'),
(116, 122, 'Pending', 'check_in', 3175200, '2024-11-20 17:44:06'),
(117, 123, 'Pending', 'vnpay', 2794176, '2024-11-21 00:43:09'),
(118, 124, 'Pending', 'vnpay', 2794176, '2024-11-21 00:43:27'),
(119, 125, 'Pending', 'vnpay', 2857680, '2024-11-21 01:19:04'),
(120, 126, 'Pending', 'check_in', 2857680, '2024-11-21 02:31:32'),
(121, 127, 'Pending', 'check_in', 14580000, '2024-11-21 02:56:41'),
(122, 128, 'Pending', 'check_in', 13122000, '2024-11-21 02:57:25'),
(123, 129, 'Pending', 'check_in', 13122000, '2024-11-21 02:59:59'),
(124, 130, 'Pending', 'check_in', 13122000, '2024-11-21 03:02:58'),
(125, 131, 'Pending', 'vnpay', 13122000, '2024-11-21 03:03:33'),
(126, 132, 'Pending', 'check_in', 14580000, '2024-11-21 03:06:56'),
(127, 133, 'Completed', 'vnpay', 13122000, '2024-11-21 03:19:02'),
(128, 134, 'Pending', 'check_in', 13122000, '2024-11-21 03:22:16'),
(129, 135, 'Pending', 'check_in', 14580000, '2024-11-21 03:26:07'),
(130, 136, 'Pending', 'vnpay', 14580000, '2024-11-21 03:30:17'),
(131, 137, 'Completed', 'vnpay', 1490400, '2024-11-22 09:30:24'),
(132, 138, 'Pending', 'vnpay', 1490400, '2024-11-22 10:28:28'),
(133, 139, 'Pending', 'vnpay', 1490400, '2024-11-22 10:28:44'),
(134, 140, 'Pending', 'vnpay', 1490400, '2024-11-22 10:41:18'),
(135, 141, 'Pending', 'vnpay', 1490400, '2024-11-22 10:41:29'),
(136, 142, 'Pending', 'vnpay', 1490400, '2024-11-22 10:47:16'),
(137, 143, 'Pending', 'vnpay', 1490400, '2024-11-22 10:47:48'),
(138, 144, 'Completed', 'vnpay', 1490400, '2024-11-22 10:51:16'),
(139, 145, 'Completed', 'vnpay', 1231200, '2024-11-22 14:38:38'),
(140, 146, 'Completed', 'vnpay', 2799360, '2024-11-22 14:40:59'),
(141, 147, 'Completed', 'vnpay', 1490400, '2024-11-22 16:58:38'),
(142, 148, 'Pending', 'check_in', 615600, '2024-11-22 17:36:24'),
(143, 149, 'Pending', 'check_in', 615600, '2024-11-22 17:41:07'),
(144, 150, 'Pending', 'check_in', 3175200, '2024-11-22 17:42:13'),
(145, 151, 'Pending', 'check_in', 1490400, '2024-11-22 17:43:27'),
(146, 152, 'Pending', 'check_in', 1490400, '2024-11-22 17:45:51'),
(147, 153, 'Pending', 'vnpay', 1846800, '2024-11-22 18:53:40'),
(148, 154, 'Pending', 'vnpay', 1846800, '2024-11-22 18:57:13'),
(149, 155, 'Pending', 'vnpay', 1846800, '2024-11-22 19:03:29'),
(150, 156, 'Pending', 'vnpay', 1846800, '2024-11-22 19:07:20'),
(151, 157, 'Pending', 'vnpay', 1846800, '2024-11-22 19:07:35'),
(152, 158, 'Pending', 'vnpay', 1846800, '2024-11-22 19:08:13'),
(153, 159, 'Pending', 'vnpay', 1846800, '2024-11-22 19:18:55'),
(154, 160, 'Completed', 'vnpay', 1846800, '2024-11-22 19:34:17'),
(155, 161, 'Completed', 'vnpay', 1662120, '2024-11-22 19:43:09'),
(156, 162, 'Completed', 'vnpay', 1399680, '2024-11-22 19:49:05'),
(157, 163, 'Pending', 'vnpay', 1555200, '2024-11-22 19:49:51'),
(158, 164, 'Pending', 'vnpay', 1555200, '2024-11-22 19:50:33'),
(159, 165, 'Completed', 'vnpay', 1555200, '2024-11-23 00:33:48'),
(160, 166, 'Pending', 'check_in', 554040, '2024-11-23 00:38:48'),
(161, 167, 'Completed', 'vnpay', 1341360, '2024-11-23 00:46:43'),
(162, 168, 'Pending', 'vnpay', 615600, '2024-11-23 01:19:17'),
(163, 169, 'Completed', 'vnpay', 1341360, '2024-11-23 01:30:04'),
(164, 170, 'Pending', 'check_in', 554040, '2024-11-23 01:32:54'),
(165, 171, 'Pending', 'vnpay', 11852663.8932, '2024-11-29 17:03:59'),
(166, 172, 'Pending', 'vnpay', 11852663.8932, '2024-11-29 17:04:19'),
(167, 173, 'Pending', 'vnpay', 11852663.8932, '2024-11-29 17:04:56'),
(168, 174, 'Pending', 'vnpay', 11852663.8932, '2024-11-29 17:06:39'),
(169, 175, 'Pending', 'vnpay', 11852663.8932, '2024-11-29 17:09:47'),
(170, 176, 'Completed', 'vnpay', 1341360, '2024-11-29 17:12:19'),
(171, 177, 'Pending', 'vnpay', 615600, '2024-11-29 17:14:35'),
(172, 178, 'Pending', 'vnpay', 615600, '2024-11-29 17:15:03'),
(173, 179, 'Completed', 'vnpay', 554040, '2024-11-29 17:16:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_desc` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `url_seo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `description`, `content`, `meta_desc`, `status`, `url_seo`, `img`, `created_at`, `updated_at`) VALUES
(72, 'Top 20 địa điểm du lịch nổi tiếng ở TPHCM du khách không nên', '<h2>Top 20+ địa điểm du lịch nổi tiếng ở TPHCM du kh&aacute;ch kh&ocirc;ng n&ecirc;n bỏ qua</h2>', '<p dir=\"ltr\">Với sự kết hợp giữa vẻ đẹp của thi&ecirc;n nhi&ecirc;n, kiến tr&uacute;c độc đ&aacute;o, văn h&oacute;a nổi bật v&agrave; sự phong ph&uacute; trong ẩm thực, TP.HCM l&agrave; một trong những điểm du lịch h&agrave;ng đầu tại Việt Nam. Du kh&aacute;ch sẽ c&oacute; thể tận hưởng những trải nghiệm độc đ&aacute;o v&agrave; kh&aacute;m ph&aacute; những điều mới mẻ trong th&agrave;nh phố n&agrave;y. C&ugrave;ng Visithcmc điểm qua 20 địa điểm nổi tiếng ở TPHCM m&agrave; kh&aacute;ch du lịch n&ecirc;n gh&eacute; qua d&ugrave; chỉ một lần.</p>\r\n\r\n<h2>1. Chợ Bến Th&agrave;nh</h2>\r\n\r\n<p dir=\"ltr\">Chợ Bến Th&agrave;nh l&agrave; một trong những điểm đến hấp dẫn kh&ocirc;ng thể bỏ qua khi bạn đến TPHCM. Với hơn 3000 gian h&agrave;ng, v&agrave; l&agrave; nơi quy tụ rất nhiều mặt h&agrave;ng từ quần &aacute;o, gi&agrave;y d&eacute;p, t&uacute;i x&aacute;ch cho đến đồ lưu niệm v&agrave; thực phẩm đặc sản. Bạn c&oacute; thể t&igrave;m thấy những chiếc &aacute;o d&agrave;i truyền thống đẹp mắt hoặc những m&oacute;n đồ handmade độc đ&aacute;o. Ngo&agrave;i ra, Chợ Bến Th&agrave;nh cũng nổi tiếng với những m&oacute;n ăn đường phố hấp dẫn như b&aacute;nh x&egrave;o, b&aacute;nh cuốn, hay hủ tiếu Nam Vang. Đ&acirc;y l&agrave; nơi tuyệt vời để kh&aacute;m ph&aacute; văn h&oacute;a v&agrave; ẩm thực của người S&agrave;i G&ograve;n.</p>\r\n\r\n<p dir=\"ltr\">- Địa chỉ: Phường Bến Th&agrave;nh, Quận 1, Th&agrave;nh phố Hồ Ch&iacute; Minh</p>\r\n\r\n<p dir=\"ltr\">- Giờ mở cửa: 7h30 - 18h</p>\r\n\r\n<p dir=\"ltr\">- Gi&aacute; v&eacute; tham khảo: Miễn ph&iacute;</p>\r\n\r\n<p dir=\"ltr\">Xem th&ecirc;m&nbsp;<a href=\"https://www.visithcmc.vn/news/kham-pha-cho-ben-thanh-diem-den-khong-the-bo-qua-o-tp-ho-chi-minh\">Kh&aacute;m ph&aacute; Chợ Bến Th&agrave;nh TPHCM Từ A-Z (5 ph&uacute;t đọc)</a></p>\r\n\r\n<p dir=\"ltr\">&nbsp;</p>\r\n\r\n<hr />\r\n<h2>2. C&ocirc;ng vi&ecirc;n Tao Đ&agrave;n</h2>\r\n\r\n<p dir=\"ltr\">Với diện t&iacute;ch rộng lớn v&agrave; c&acirc;y xanh um t&ugrave;m, C&ocirc;ng vi&ecirc;n Tao Đ&agrave;n l&agrave; điểm đến l&yacute; tưởng để tho&aacute;t khỏi sự ồn &agrave;o v&agrave; n&aacute;o nhiệt của th&agrave;nh phố. C&ocirc;ng vi&ecirc;n n&agrave;y c&oacute; nhiều tiện &iacute;ch như s&acirc;n chơi trẻ em, khu vực tập thể dục ngo&agrave;i trời v&agrave; đường chạy bộ xung quanh ao c&aacute;. Bạn c&oacute; thể dạo chơi trong kh&ocirc;ng gian y&ecirc;n b&igrave;nh của c&ocirc;ng vi&ecirc;n, ngắm nh&igrave;n hoa l&aacute; v&agrave; h&iacute;t thở kh&ocirc;ng kh&iacute; trong l&agrave;nh. Nếu bạn muốn t&igrave;m một nơi để thư gi&atilde;n sau những ng&agrave;y l&agrave;m việc căng thẳng, C&ocirc;ng vi&ecirc;n Tao Đ&agrave;n l&agrave; lựa chọn ho&agrave;n hảo.</p>\r\n\r\n<p dir=\"ltr\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img src=\"https://lh4.googleusercontent.com/sz1w3kvVK3-aX0mIqtlsjvNHcgL5f1Zcxi4t6OY39fqBC5XX1Dr0Jr3RvOjlFUznC9cM-8pEHu_wLBeF4OGGLDk5fu7nPBhRj7HZdW-D4V3IIG2jGWuGTDEV4-V9-XoL_oCvCKdqnz0ipZsm3QBbuIc\" style=\"height:340px; width:602px\" /></p>\r\n\r\n<p dir=\"ltr\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\">- Địa chỉ: Phường Bến Th&agrave;nh, Quận 1, Th&agrave;nh phố Hồ Ch&iacute; Minh</p>\r\n\r\n<p dir=\"ltr\">- Giờ mở cửa: 7h - 22h</p>\r\n\r\n<p dir=\"ltr\">- Gi&aacute; v&eacute; tham khảo: Miễn ph&iacute;</p>\r\n\r\n<p dir=\"ltr\">Xem th&ecirc;m&nbsp;<a href=\"https://www.visithcmc.vn/news/kham-pha-cong-vien-tao-dan-oc-dao-xanh-giua-long-thanh-pho\">Kh&aacute;m ph&aacute; C&ocirc;ng Vi&ecirc;n Tao Đ&agrave;n - Ốc đảo xanh giữa l&ograve;ng th&agrave;nh phố</a></p>\r\n\r\n<hr />\r\n<h2>3. Nh&agrave; thờ Đức B&agrave;</h2>\r\n\r\n<p dir=\"ltr\">Nh&agrave; thờ Đức B&agrave; l&agrave; một biểu tượng của TPHCM v&agrave; một trong những c&ocirc;ng tr&igrave;nh kiến tr&uacute;c nổi tiếng nhất của th&agrave;nh phố. Với kiến tr&uacute;c h&ugrave;ng vĩ v&agrave; điểm nhấn l&agrave; những cửa sổ nghệ thuật đẹp mắt, nh&agrave; thờ n&agrave;y l&agrave; điểm đến thu h&uacute;t rất nhiều du kh&aacute;ch h&agrave;ng năm. B&ecirc;n trong, bạn c&oacute; thể chi&ecirc;m ngưỡng những bức tranh tường v&agrave; tượng gỗ cầu kỳ, tạo n&ecirc;n một kh&ocirc;ng gian t&ocirc;n gi&aacute;o trang nghi&ecirc;m. Nh&agrave; thờ Đức B&agrave; cũng l&agrave; một di t&iacute;ch lịch sử quan trọng, đại diện cho sự gắn kết văn h&oacute;a v&agrave; t&ocirc;n gi&aacute;o trong lịch sử ph&aacute;t triển của th&agrave;nh phố.</p>\r\n\r\n<p dir=\"ltr\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img src=\"https://lh4.googleusercontent.com/xMNioNmaZwNMIy5-vCWvOZRahKpGhL-DjGtnmct1BO3GpXFFlfd5bDkM-PdfXd64GTaEjawYuGBg6ASGG-eBfNiXGKQsN8xhRoUr-Cb6EvSwjZxkYMZhiB8zQLaQ9MgAHSdJzN-Eew0h0wajp-G8Ijo\" style=\"height:400px; width:602px\" /></p>\r\n\r\n<p dir=\"ltr\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\">- Địa chỉ: 01 C&ocirc;ng x&atilde; Paris, Bến Ngh&eacute;, Quận 1, Th&agrave;nh phố Hồ Ch&iacute; Minh</p>\r\n\r\n<p dir=\"ltr\">- Giờ mở cửa: 5h30 - 17h (Bạn n&ecirc;n tr&aacute;nh giờ l&agrave;m lễ nh&agrave; thờ để c&oacute; thể tham quan một c&aacute;ch trọn vẹn nhất)</p>\r\n\r\n<p dir=\"ltr\">- Gi&aacute; v&eacute; tham khảo: Miễn ph&iacute;</p>\r\n\r\n<hr />\r\n<h2>4. Bảo t&agrave;ng Th&agrave;nh phố Hồ Ch&iacute; Minh</h2>\r\n\r\n<p dir=\"ltr\">Bảo t&agrave;ng Th&agrave;nh phố Hồ Ch&iacute; Minh l&agrave; một điểm đến th&uacute; vị để t&igrave;m hiểu về lịch sử v&agrave; văn h&oacute;a của th&agrave;nh phố. Được x&acirc;y dựng theo lối kiến tr&uacute;c phục hưng, nơi đ&acirc;y kh&ocirc;ng chỉ lưu giữ những tư liệu c&ugrave;ng hiện vật lịch sử của Th&agrave;nh phố Hồ Ch&iacute; Minh m&agrave; c&ograve;n l&agrave; nơi trưng b&agrave;y c&aacute;c cổ vật, n&eacute;t văn h&oacute;a của &ocirc;ng cha ta thời xưa. B&ecirc;n cạnh đ&oacute;, với khu&ocirc;n vi&ecirc;n rộng lớn được bao phủ bởi rất nhiều c&acirc;y xanh đem đến cảm gi&aacute;c trong l&agrave;nh, thư gi&atilde;n tr&aacute;nh xa được những ồn &agrave;o của phố thị. Đ&acirc;y l&agrave; một điểm dừng ch&acirc;n l&yacute; tưởng để t&igrave;m hiểu v&agrave; kh&aacute;m ph&aacute; lịch sử, văn h&oacute;a của con người tại Th&agrave;nh phố mang t&ecirc;n B&aacute;c.</p>\r\n\r\n<p dir=\"ltr\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img src=\"https://lh3.googleusercontent.com/AnNezJ95rWNObmzE3oas_DTxQtDwGQm1krzrkOr9ubumabmyhZQnu4cP6HkPOJYgSrdly-2Ewo0l0mlSBEbGzLHy7LAwp3IIOAsn78sv-955HCuztS8-hg20NiuK-02A9ueAXgh-JN9Y5WZCmWS4kn0\" style=\"height:275px; width:602px\" /></p>\r\n\r\n<p dir=\"ltr\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\">- Địa chỉ: 65 L&yacute; Tự Trọng, Bến Ngh&eacute;, Quận 1, Th&agrave;nh phố Hồ Ch&iacute; Minh</p>\r\n\r\n<p dir=\"ltr\">- Giờ mở cửa:</p>\r\n\r\n<ul>\r\n	<li dir=\"ltr\">\r\n	<p dir=\"ltr\">Thứ ba, thứ tư, thứ năm, thứ bảy, chủ nhật: 8h - 12h, 14h - 16h30</p>\r\n	</li>\r\n	<li dir=\"ltr\">\r\n	<p dir=\"ltr\">Thứ hai v&agrave; thứ s&aacute;u: 8h - 12h</p>\r\n	</li>\r\n</ul>\r\n\r\n<p dir=\"ltr\">- Gi&aacute; v&eacute; tham khảo:&nbsp;</p>\r\n\r\n<ul>\r\n	<li dir=\"ltr\">\r\n	<p dir=\"ltr\">40.000đ cho du kh&aacute;ch quốc tế</p>\r\n	</li>\r\n	<li dir=\"ltr\">\r\n	<p dir=\"ltr\">Kh&aacute;ch Việt Nam được miễn ph&iacute;</p>\r\n	</li>\r\n</ul>\r\n\r\n<hr />\r\n<h2>5. Dinh Độc Lập</h2>\r\n\r\n<p dir=\"ltr\">Dinh Độc Lập được khởi c&ocirc;ng x&acirc;y dựng ng&agrave;y 1/7/1962 theo đồ &aacute;n thiết kế của kiến tr&uacute;c sư Ng&ocirc; Viết Thụ. Nơi đ&acirc;y lưu giữ những dấu mốc đ&aacute;ng tự h&agrave;o của d&acirc;n tộc trong cuộc chiến tranh bảo vệ đất nước v&agrave;o thế kỷ trước. Đặc biệt l&agrave; sự kiện kết th&uacute;c chiến tranh tại miền Nam, thống nhất đất nước v&agrave;o ng&agrave;y 30 th&aacute;ng 4 năm 1975. Đến năm 1976, Dinh Độc Lập được gọi là Hội trường Th&ocirc;́ng Nh&acirc;́t. Ng&agrave;y nay, khi đến tham quan Dinh Độc Lập, để t&igrave;m hiểu th&ecirc;m nhiều chi tiết lịch sử th&uacute; vị, du kh&aacute;ch c&oacute; thể tham quan khu vực trưng b&agrave;y th&ocirc;ng tin v&agrave; tư liệu về Dinh Norodom (1868) trước, rồi sau đ&oacute; di chuyển qua khu vực tham quan ph&ograve;ng th&ocirc;ng tin về to&agrave; nh&agrave; ch&iacute;nh Dinh Độc Lập (1966) để h&agrave;nh tr&igrave;nh trọn vẹn hơn. B&ecirc;n trong dinh c&ograve;n c&oacute; cửa h&agrave;ng qu&agrave; lưu niệm, nh&agrave; h&agrave;ng v&agrave; qu&aacute;n c&agrave; ph&ecirc; để phục vụ du kh&aacute;ch tham quan.</p>\r\n\r\n<p dir=\"ltr\">&nbsp;Dinh Độc Lập, 135 đường Nam Kỳ Khởi Nghĩa, Phường Bến Th&agrave;nh, Quận 1, Th&agrave;nh phố Hồ Ch&iacute; Minh.<br />\r\nThời gian hoạt động (từ Thứ 2 đến Chủ Nhật): 8:00 &ndash; 13:00.<br />\r\nWebsite:&nbsp;<a href=\"http://www.dinhdoclap.gov.vn/\">www.dinhdoclap.gov.vn</a>&nbsp;</p>\r\n\r\n<p dir=\"ltr\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\"><img src=\"https://lh3.googleusercontent.com/zEKzZBVplA4mBq6TBgW1Ofi6cmh_6sEta7Q4U6zPTgQoC79arEjbeNvPXmABlAvrxylWPeX4wJWe-EoBKnECC0w625cg0ylNIIXbwFoY2RR-rEMuIAV0L27XwhVvsxX516shsSX3I7qHkt9Xh13A6go\" style=\"height:451px; width:602px\" /></p>\r\n\r\n<p dir=\"ltr\">&nbsp;</p>\r\n\r\n<p dir=\"ltr\">- Địa chỉ: Số 135 đường Nam Kỳ Khởi Nghĩa, th&agrave;nh phố Hồ Ch&iacute; Minh</p>\r\n\r\n<p dir=\"ltr\">- Giờ mở cửa: 8h - 16h30</p>\r\n\r\n<p dir=\"ltr\">- Gi&aacute; v&eacute; tham khảo: 10.000đ - 65.000đ</p>', 'địa điểm du lịch nổi tiếng ở TPHCM', 1, 'Top-20-đia-điem-du-lich-noi-tieng-o-TPHCM-du-khach-khong-nen', '1732291847.jpg', '2024-11-22 09:10:47', '2024-11-22 09:10:47'),
(73, 'Khám phá Huế qua hình ảnh 360 độ', '<p>Nhắc đến du lịch Huế kh&ocirc;ng thể kh&ocirc;ng nhớ tới c&aacute;c cung điện, đền đ&agrave;i mang hơi thở cổ k&iacute;nh v&agrave; truyền thống của một thời huy ho&agrave;ng xưa kia. Bao đời nay cố đ&ocirc; Huế lu&ocirc;n được nhớ tới như một v&ugrave;ng đất của sự mộng mơ, thanh tao v&agrave; dịu d&agrave;ng. Thế nhưng Huế đ&acirc;u chỉ gắn liền với hai chữ &ldquo;lịch sử&rdquo;, nơi đ&acirc;y c&ograve;n được mẹ thi&ecirc;n nhi&ecirc;n ưu &aacute;i ban tặng cho mu&ocirc;n v&agrave;n cảnh đẹp của biển, của s&ocirc;ng, của n&uacute;i,&hellip; qua bao đời vẫn đẹp như thuở ban đầu.</p>', '<h2><strong>An Hien Garden<br />\r\n&nbsp;</strong></h2>\r\n\r\n<p><iframe height=\"500px\" sandbox=\"\" src=\"https://vr360.vietravel.net/vietnam/hue/an-hien-garden/\" width=\"870px\"></iframe></p>\r\n\r\n<p><br />\r\nL&agrave; một trong những nh&agrave; vườn nổi tiếng nhất ở<a href=\"https://travel.com.vn/mien-trung/tour-hue.aspx\" target=\"_blank\" title=\"Tour Huế\">&nbsp;Huế</a>, An Hi&ecirc;n được x&acirc;y dựng v&agrave;o cuối thế kỷ thứ 19. Ban đầu, ng&ocirc;i nh&agrave; thuộc về c&ocirc;ng ch&uacute;a thứ 18 của vua Dục &ETH;ức. Năm 1920, An Hi&ecirc;n thuộc quyền quản l&yacute; của &ocirc;ng T&ugrave;ng Lễ. Năm 1936, Nguyễn Đ&igrave;nh Chi l&agrave; chủ sở hữu của ng&ocirc;i nh&agrave; được b&aacute;n lại từ &ocirc;ng T&ugrave;ng Lễ. Năm 1940, Nguyễn Đ&igrave;nh Chi qua đời v&agrave; để lại khu nh&agrave; vườn cho b&agrave; Đ&agrave;o Thị Xu&acirc;n Yến (vợ &ocirc;ng) quản l&yacute;. B&agrave; Đ&agrave;o Thị Xu&acirc;n Yến cũng l&agrave; chủ sở hữu d&agrave;i nhất v&agrave; l&agrave; người đưa nh&agrave; vườn An Hi&ecirc;n ra ph&aacute;t triển mạnh hơn cả. Mặc d&ugrave; đ&atilde; trải qua hơn một thế kỷ tồn tại, nhưng kh&ocirc;ng gian kiến ​​tr&uacute;c của ng&ocirc;i nh&agrave; vẫn giữ được đặc t&iacute;nh cổ xưa của n&oacute; cho đến nay .<br />\r\n<br />\r\nKhu&ocirc;n vi&ecirc;n nh&agrave; vườn An Hi&ecirc;n hiện nay c&oacute; h&igrave;nh gần như vu&ocirc;ng v&agrave; c&oacute; diện t&iacute;ch 4.608 m2, mặt nh&igrave;n về hướng Nam, ph&iacute;a trước c&oacute; s&ocirc;ng Hương chảy ngang, bao gồm nhiều kiến tr&uacute;c d&acirc;n dụng lớn nhỏ, được x&acirc;y dựng theo lối kiến tr&uacute;c truyền thống của Việt Nam v&agrave; của xứ Huế.<br />\r\n<br />\r\nLối v&agrave;o nh&agrave; vườn An Hi&ecirc;n l&agrave; một cổng v&ograve;m nhỏ được x&acirc;y dựng bằng gạch v&ocirc;i vữa. Dọc theo lối đi v&agrave;o l&agrave; hai d&atilde;y c&acirc;y mận trắng đan tầng v&agrave;o nhau cao v&uacute;t v&agrave; che b&oacute;ng m&aacute;t. Rẽ tr&aacute;i v&agrave; vượt qua chiếc b&igrave;nh phong cổ k&iacute;nh trang tr&iacute; chữ Thọ, l&agrave; một hồ nước h&igrave;nh chữ nhật được bao phủ ho&agrave;n to&agrave;n bởi hoa s&uacute;ng, hoa sen v&agrave; những c&acirc;y cảnh xung quanh.<br />\r\n<br />\r\nKiến tr&uacute;c ch&iacute;nh của nh&agrave; vườn An Hi&ecirc;n l&agrave; một ng&ocirc;i nh&agrave; 3 gian 2 ch&aacute;i, nằm gần như ở trung t&acirc;m v&agrave; được đi&ecirc;u khắc tinh tế. To&agrave;n bộ cấu tr&uacute;c khung trong nh&agrave; đều được l&agrave;m bằng gỗ. Những hoa văn, họa tiết được chạm trổ tinh tế bao quanh cột ch&iacute;nh, hệ thống v&igrave; k&egrave;o của ng&ocirc;i nh&agrave;. M&aacute;i lợp ng&oacute;i liệt nhiều lớp, bờ n&oacute;c hai b&ecirc;n đắp rồng chầu, ở giữa đỉnh m&aacute;i c&oacute; h&igrave;nh hoa sen. Đặc biệt, c&aacute;c đồ nội thất cổ xưa trong ng&ocirc;i nh&agrave; lu&ocirc;n gọn g&agrave;ng v&agrave; ngăn nắp. Kh&aacute;m ph&aacute; nh&agrave; vườn An Hi&ecirc;n chắc chắn sẽ l&agrave; một trong những điều kh&oacute; qu&ecirc;n nhất khi trở về với xứ Huế mộng mơ.<br />\r\n&nbsp;</p>\r\n\r\n<h2><strong>Cầu Trường Tiền</strong></h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><iframe height=\"500px\" sandbox=\"\" src=\"https://vr360.vietravel.net/vietnam/hue/cau-truong-tien/\" width=\"870px\"></iframe></p>\r\n\r\n<p><br />\r\nCầu Tr&agrave;ng Tiền (hay c&ograve;n được gọi l&agrave; Cầu Trường Tiền) bắc qua S&ocirc;ng Hương với những nhịp cầu cong cong mềm mại, uyển chuyển v&agrave; l&agrave; một trong những biểu tượng đặc trưng của cố đ&ocirc; Huế. Cầu Tr&agrave;ng Tiền c&ograve;n gắn liền với lịch sử hơn 100 năm v&agrave; chứng kiến biết bao thăng trầm của lịch sử d&acirc;n tộc, địa điểm&nbsp;<a href=\"https://travel.com.vn/\" target=\"_blank\" title=\"Du lich\">du lịch</a>&nbsp;Huếtham quan chứng nh&acirc;n lịch sử. Ng&agrave;y nay, cầu được lắp đặt một hệ thống &aacute;nh s&aacute;ng hiện đại, mỗi khi chiều bu&ocirc;ng lại toả s&aacute;ng lung linh rực rỡ nhiều m&agrave;u sắc.<br />\r\n&nbsp;</p>\r\n\r\n<h2><strong>Ch&ugrave;a Thi&ecirc;n Mụ</strong></h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><iframe height=\"500px\" sandbox=\"\" src=\"https://vr360.vietravel.net/vietnam/hue/chua-thien-mu/\" width=\"870px\"></iframe></p>\r\n\r\n<p><br />\r\nDanh thắng kh&ocirc;ng thể bỏ qua trong h&agrave;nh tr&igrave;nh du lịch Huế. Được x&acirc;y dựng từ những năm 1.600 v&agrave; được bảo tồn qua nhiều lần, ch&ugrave;a Thi&ecirc;n Mụ thu h&uacute;t nhiều du kh&aacute;ch bởi vẻ nguy nga tr&aacute;ng lệ nhưng cũng kh&ocirc;ng k&eacute;m phần thanh tịnh, n&ecirc;n thơ. Để đến Ch&ugrave;a Thi&ecirc;n Mụ, bạn c&oacute; thể đi đ&ograve; dọc theo s&ocirc;ng Hương, v&ocirc; c&ugrave;ng l&atilde;ng mạn.<br />\r\n&nbsp;</p>\r\n\r\n<h2><strong>Đại nội kinh th&agrave;nh Huế</strong></h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><iframe height=\"500px\" sandbox=\"\" src=\"https://vr360.vietravel.net/vietnam/hue/dai-noi-kinh-thanh-hue/\" width=\"870px\"></iframe></p>\r\n\r\n<p><br />\r\nHo&agrave;ng th&agrave;nh nằm b&ecirc;n trong kinh th&agrave;nh Huế l&agrave; địa điểm đầu ti&ecirc;n bạn n&ecirc;n gh&eacute; qua khi du lịch Huế.&nbsp; Sau hơn 100 năm, những c&ocirc;ng tr&igrave;nh kiến tr&uacute;c đồ sộ ở Đại Nội chỉ c&ograve;n lại &iacute;t ỏi chiếm kh&ocirc;ng đầy một nửa con số ban đầu nhưng vẫn mang trong m&igrave;nh n&eacute;t uy nghi của triều đ&igrave;nh phong kiến một thời. Đại Nội kh&aacute; rộng, bạn n&ecirc;n d&agrave;nh&nbsp; thời gian khoảng 1 buổi hoặc 1 ng&agrave;y để kh&aacute;m ph&aacute; hết.<br />\r\n&nbsp;</p>\r\n\r\n<h2><strong>Khu phố T&acirc;y</strong></h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><iframe height=\"500px\" sandbox=\"\" src=\"https://vr360.vietravel.net/vietnam/hue/khu-pho-tay/\" width=\"870px\"></iframe></p>\r\n\r\n<p><br />\r\nNgười ta biết đến Huế như một cố đ&ocirc; trầm mặc, chậm r&atilde;i v&agrave; c&oacute; ch&uacute;t g&igrave; đ&oacute; tĩnh lặng nhưng c&oacute; lẽ đ&oacute; chỉ l&agrave; một phần nổi của vẻ đẹp xứ Huế. Ở đ&acirc;u đ&oacute; phần ngoại th&agrave;nh, Huế vẫn c&oacute; một phố T&acirc;y n&aacute;o nhiệt với những qu&aacute;n bar v&agrave; bữa tiệc ngo&agrave;i trời. Ch&iacute;nh điều n&agrave;y đ&atilde; khiến du kh&aacute;ch th&ecirc;m y&ecirc;u v&agrave; d&agrave;nh sự thương mến cho xứ Huế nhiều hơn cả!<br />\r\n<br />\r\nPhố T&acirc;y kh&ocirc;ng phải chỉ c&oacute; T&acirc;y, phố T&acirc;y c&oacute; cả những con người Huế ch&acirc;n thực, với giọng n&oacute;i đậm đ&agrave; chất dịu d&agrave;ng. Phố T&acirc;y của Huế ấy vậy m&agrave; lại khiến người du kh&aacute;ch thương mến đến kh&ocirc;n c&ugrave;ng. Tại nơi đ&acirc;y người ta kh&ocirc;ng phải qu&aacute; xa hoa hay sang trọng, phố T&acirc;y Huế chỉ đơn giản l&agrave; c&aacute;i n&ocirc;i nu&ocirc;i nấng những mối quan hệ &Acirc;u - &Aacute;. Một lời ch&agrave;o, một c&aacute;i cạn ly bia, l&agrave; người lạ cũng trở n&ecirc;n th&acirc;n quen.<br />\r\n&nbsp;</p>\r\n\r\n<h2><strong>Lăng C&ocirc;</strong></h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><iframe height=\"500px\" sandbox=\"\" src=\"https://vr360.vietravel.net/vietnam/hue/lang-co/\" width=\"870px\"></iframe></p>\r\n\r\n<p><br />\r\nKh&ocirc;ng chỉ c&oacute; những di t&iacute;ch lịch sử v&agrave; văn ho&aacute; cổ k&iacute;nh, th&agrave;nh phố Huế c&ograve;n sở hữu những b&atilde;i biển đẹp l&agrave;m m&ecirc; say nhiều kh&aacute;ch du lịch. Biển Lăng C&ocirc; l&agrave; một b&atilde;i biển c&oacute; phong cảnh thuộc v&agrave;o loại đẹp nhất Việt Nam với b&atilde;i c&aacute;t trắng d&agrave;i mi&ecirc;n man &ocirc;m lấy bờ biển xanh trong vắt l&agrave; một trong những địa điểm du lịch Huế lựa chọn h&agrave;ng đầu. Xung quanh bờ biển l&agrave; những c&aacute;nh rừng h&ugrave;ng vĩ xanh m&aacute;t tr&ecirc;n nền n&uacute;i non h&ugrave;ng vĩ, chắc chắn sẽ l&agrave;m trải nghiệm du lịch Huế của bạn th&ecirc;m trọn vẹn.<br />\r\n&nbsp;</p>\r\n\r\n<h2><strong>Lăng Khải Định</strong></h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><iframe height=\"500px\" sandbox=\"\" src=\"https://vr360.vietravel.net/vietnam/hue/lang-khai-dinh/\" width=\"870px\"></iframe></p>\r\n\r\n<p><br />\r\nĐược x&acirc;y dựng tr&ecirc;n n&uacute;i Ch&acirc;u Chữ, Lăng Khải Định l&agrave; nơi y&ecirc;n nghỉ của vị ho&agrave;ng đế thứ 12 của triều nh&agrave; Nguyễn. Tuy c&oacute; k&iacute;ch thước khi&ecirc;m tốn hơn so với lăng của c&aacute;c vị vua tiền nhiệm nhưng lăng Khải Định lại được x&acirc;y một c&aacute;ch v&ocirc; c&ugrave;ng c&ocirc;ng phu v&agrave; tinh xảo trong thời gian đến 10 năm.<br />\r\n<br />\r\nLăng Khải Định l&agrave; c&ocirc;ng tr&igrave;nh lăng tẩm duy nhất c&oacute; kiến tr&uacute;c giao thoa giữa hai nền văn ho&aacute; Đ&ocirc;ng &ndash; T&acirc;y. Điều ấy được thể hiện qua những tấm ph&ugrave; đi&ecirc;u lộng lẫy được gh&eacute;p tỉ mỉ bằng s&agrave;nh sứ v&agrave; thuỷ tinh, những khay tr&agrave;, vương miện, c&ugrave;ng những vật dụng trang tr&iacute; hiện đại v&agrave;o thời bấy giờ như: vợt tennis, đ&egrave;n dầu...<br />\r\n&nbsp;</p>\r\n\r\n<h2><strong>Lăng Tự Đức</strong></h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><iframe height=\"500px\" sandbox=\"\" src=\"https://vr360.vietravel.net/vietnam/hue/lang-tu-duc/\" width=\"870px\"></iframe></p>\r\n\r\n<p><br />\r\nNằm trong một thung lũng hẹp thuộc l&agrave;ng Dương Xu&acirc;n Thượng, tổng Cư Ch&aacute;nh, Lăng Tự Đức (hay c&ograve;n được gọi l&agrave; Khi&ecirc;m Lăng) c&oacute; lẽ l&agrave; lăng đẹp nhất trong những lăng tẩm của c&aacute;c đời vua nh&agrave; Nguyễn bởi sự h&agrave;i ho&agrave; giữa khung cảnh thi&ecirc;n nhi&ecirc;n &ldquo;sơn thuỷ hữu t&igrave;nh&rdquo; v&agrave; kh&ocirc;ng gian kiến tr&uacute;c bao la, rộng lớn. Được bao bọc giữa bồn bề c&acirc;y cối xanh m&aacute;t v&agrave; nằm gần một hồ nước rộng lớn, lăng Tự Đức hiện l&ecirc;n với n&eacute;t cổ k&iacute;nh v&agrave; kiến tr&uacute;c cầu k&igrave; ho&agrave; m&igrave;nh trong thi&ecirc;n nhi&ecirc;n thật thơ mộng v&agrave; kh&ocirc;ng gian thanh b&igrave;nh đến lạ k&igrave;.</p>', 'KHAM PHA HUE', 1, 'Kham-pha-Hue-qua-hinh-anh-360-đo', '1732754730.jpg', '2024-11-27 17:45:30', '2024-11-27 17:45:30'),
(65, 'Mộng mơ xứ thân thương cùng tour Huế trong ngày hấp dẫn', '<p><em><strong>H&ograve;a m&igrave;nh v&agrave;o thi&ecirc;n nhi&ecirc;n tươi đẹp v&agrave; kh&aacute;m ph&aacute; văn h&oacute;a đặc sắc c&ugrave;ng tour Huế trong ng&agrave;y: Trải Nghiệm Sống L&agrave;nh &ndash; Đi Để Trở Về.</strong></em></p>', '<h4>Ch&ugrave;a Thi&ecirc;n Mụ &ndash; Chốn linh thi&ecirc;ng giữa l&ograve;ng Huế mơ</h4>\r\n\r\n<p><img alt=\"\" src=\"https://cdn3.ivivu.com/2024/09/Tour-Hue-trong-ngay-ivivu-1.png\" style=\"height:1080px; width:1920px\" /></p>\r\n\r\n<p>Ch&ugrave;a Thi&ecirc;n Mụ &ndash; Điểm tham quan nổi tiếng của xứ Huế</p>\r\n\r\n<p>Điểm dừng ch&acirc;n đầu ti&ecirc;n với&nbsp;<strong><em>tour Huế trong ng&agrave;y</em></strong>&nbsp;l&agrave; ch&ugrave;a Thi&ecirc;n Mụ. Một nơi kh&ocirc;ng thể bỏ lỡ khi đến với xứ Huế mộng mơ. Được xem l&agrave; c&ocirc;ng tr&igrave;nh giao h&ograve;a giữa t&ocirc;n gi&aacute;o, kiến tr&uacute;c v&agrave; thi&ecirc;n nhi&ecirc;n. Du kh&aacute;ch sẽ được đ&oacute;n nắng mai v&agrave; khởi động ng&agrave;y mới tại đ&acirc;y. Dạo bước b&ecirc;n cảnh quan xinh đẹp khi ch&ugrave;a được tọa lạc tr&ecirc;n đồi H&agrave; Kh&ecirc; v&agrave; n&eacute;p m&igrave;nh dịu d&agrave;ng cạnh s&ocirc;ng Hương.</p>\r\n\r\n<p><img alt=\"\" src=\"https://cdn3.ivivu.com/2024/09/Tour-Hue-trong-ngay-ivivu-2.gif\" style=\"height:563px; width:1000px\" /></p>\r\n\r\n<p>Biểu tượng văn h&oacute;a đặc sắc</p>\r\n\r\n<p><iframe height=\"167\" sandbox=\"\" scrolling=\"no\" src=\"https://www.ivivu.com/hothotel/?placeslug=hue&amp;number=1&amp;width=481&amp;wmode=transparent\" width=\"100%\"></iframe></p>\r\n\r\n<p>Được x&acirc;y dựng từ thời vua Gia Long, đến nay, nơi đ&acirc;y được xem l&agrave; ng&ocirc;i ch&ugrave;a cổ bậc nhất cố đ&ocirc; v&agrave; gắn với những c&acirc;u chuyện huyền thoại hấp dẫn. Cảnh sắc ch&ugrave;a trang nghi&ecirc;m, y&ecirc;n tĩnh. Sở hữu kiến tr&uacute;c độc đ&aacute;o, hoa văn được đi&ecirc;u khắc tinh xảo. Trong đ&oacute;, nổi bật với th&aacute;p Phước Duy&ecirc;n c&oacute; 7 tầng được x&acirc;y bằng gạch. L&agrave; một trong những biểu tượng văn h&oacute;a của th&agrave;nh phố.</p>\r\n\r\n<h4>S&ocirc;ng Hương &ndash; D&ograve;ng chảy dịu d&agrave;ng của xứ kinh kỳ</h4>\r\n\r\n<p><img alt=\"\" src=\"https://cdn3.ivivu.com/2024/09/Tour-Hue-trong-ngay-ivivu-3.png\" style=\"height:1080px; width:1920px\" /></p>\r\n\r\n<p>S&ocirc;ng Hương &ndash; Một biểu tượng của xứ Huế</p>\r\n\r\n<p>S&ocirc;ng Hương &ndash; Cầu Tr&agrave;ng Ti&ecirc;n từ l&acirc;u đ&atilde; trở th&agrave;nh 2 biểu tượng gắn liền với xứ Huế. Tiếp tục cuộc h&agrave;nh tr&igrave;nh v&agrave; mở ra g&oacute;c nh&igrave;n mới để ngắm nh&igrave;n th&agrave;nh phố. Dạo quanh tr&ecirc;n du thuyền b&ecirc;n s&ocirc;ng Hương y&ecirc;n ả v&agrave; cảm nhận trọn d&aacute;ng vẻ thanh b&igrave;nh nhẹ nh&agrave;ng đặc trưng của v&ugrave;ng đất n&agrave;y. Kh&ocirc;ng chỉ gắn chặt với lịch sử l&acirc;u đời m&agrave; nơi đ&acirc;y c&ograve;n sở hữu khung cảnh trữ t&igrave;nh l&atilde;ng mạn.</p>\r\n\r\n<p><img alt=\"\" src=\"https://cdn3.ivivu.com/2024/09/Tour-Hue-trong-ngay-ivivu-5.jpg\" style=\"height:692px; width:1024px\" /></p>\r\n\r\n<p>Điểm đến l&atilde;ng mạn thơ mộng bậc nhất xứ kinh kỳ. Ảnh: @Duy Anh</p>\r\n\r\n<p>Ngo&agrave;i ra, du kh&aacute;ch c&oacute; cơ hội tham gia hoạt động thả c&aacute; hồi hướng c&ocirc;ng đức, g&oacute;p phần t&aacute;i tạo nguồn lợi thuỷ hải sản tr&ecirc;n s&ocirc;ng Hương. H&ograve;a m&igrave;nh tận hưởng những gi&acirc;y ph&uacute;t thanh tao. Thong thả đạp xe b&ecirc;n bờ hồ v&agrave; h&iacute;t thở kh&ocirc;ng kh&iacute; trong l&agrave;nh cũng sẽ l&agrave; một trải nghiệm kh&oacute; qu&ecirc;n. Những t&acirc;m hồn y&ecirc;u th&iacute;ch văn học, hội họa cũng sẽ th&iacute;ch th&uacute; khi được trực tiếp kh&aacute;m ph&aacute; nơi tạo n&ecirc;n cảm hứng bất tận cho c&aacute;c t&aacute;c phẩm.</p>\r\n\r\n<h4>L&agrave;ng hương Thủy Xu&acirc;n &ndash; Hương trầm dấu ấn trăm năm</h4>\r\n\r\n<p>Từ xưa đến nay, người d&acirc;n l&agrave;ng hương Thủy Xu&acirc;n đ&atilde; theo nghề l&agrave;m hương khoảng 700 năm. Trong bối cảnh hiện đại, kết hợp những trang thiết bị hỗ trợ nhưng nơi đ&acirc;y vẫn giữ được những n&eacute;t cốt l&otilde;i trong c&aacute;ch l&agrave;m hương truyền thống. Kh&ocirc;ng chỉ duy tr&igrave; một l&agrave;ng nghề truyền thống, mang đến thu nhập cho người d&acirc;n m&agrave; với vẻ đẹp đặc sắc đ&acirc;y c&ograve;n trở th&agrave;nh điểm du lịch hấp dẫn.</p>\r\n\r\n<p><img alt=\"\" src=\"https://cdn3.ivivu.com/2024/09/Tour-Hue-trong-ngay-ivivu-6.jpg\" style=\"height:561px; width:841px\" /></p>\r\n\r\n<p>Địa điểm check in ngập tr&agrave;n sắc m&agrave;u</p>\r\n\r\n<p>Ngắm nh&igrave;n những b&oacute; hương ngập tr&agrave;n m&agrave;u sắc, du kh&aacute;ch sẽ kh&ocirc;ng thể bỏ lỡ những bức ảnh check in sống động kh&oacute; qu&ecirc;n. D&ugrave; chỉ vỏn vẹn 1 ng&agrave;y kh&aacute;m ph&aacute; nhưng nơi đ&acirc;y hứa hẹn sẽ đem đến cho bạn những khoảnh khắc đ&aacute;ng nhớ với điểm tham quan hội tụ nhiều yếu tố hấp dẫn trong&nbsp;<em><strong>tour Huế trong ng&agrave;y</strong></em>.</p>\r\n\r\n<h4>Đồi Vọng Cảnh &ndash; Bức tranh sơn thủy nơi cố đ&ocirc;</h4>\r\n\r\n<p><img alt=\"\" src=\"https://cdn3.ivivu.com/2024/09/Tour-Hue-trong-ngay-ivivu-8.jpg\" style=\"height:731px; width:1073px\" /></p>\r\n\r\n<p>Đồi Vọng Cảnh l&agrave; nơi l&yacute; tưởng để ngắm nh&igrave;n khung cảnh ho&agrave;ng h&ocirc;n</p>\r\n\r\n<p>Cảm nhận trọn vẹn hơn với vẻ đẹp thơ mộng của v&ugrave;ng đất di sản với đồi Vọng Cảnh. Nơi đ&acirc;y cũng được mệnh danh l&agrave; một trong những điểm đến đẹp nhất để ngắm khung cảnh ho&agrave;ng h&ocirc;n dần bu&ocirc;ng của th&agrave;nh phố Huế. Với khung cảnh được bao bọc bởi thi&ecirc;n nhi&ecirc;n xanh m&aacute;t, kh&ocirc;ng kh&iacute; m&aacute;t mẻ dễ chịu, sẽ mang đến cho bạn một nơi l&yacute; tưởng để thưởng trọn sự chuyển m&igrave;nh trong ng&agrave;y của tạo h&oacute;a.</p>\r\n\r\n<p><img alt=\"\" src=\"https://cdn3.ivivu.com/2024/09/Tour-Hue-trong-ngay-ivivu-9.jpg\" style=\"height:966px; width:1450px\" /></p>\r\n\r\n<p>Cảnh quan được bao bọc bởi thi&ecirc;n nhi&ecirc;n xanh m&aacute;t</p>\r\n\r\n<p>B&ecirc;n cạnh đ&oacute;, trong tour n&agrave;y, bạn sẽ c&oacute; 15 ph&uacute;t đi bộ v&agrave; thiền tại đ&acirc;y. Một dịp kh&ocirc;ng thể bỏ lỡ để chậm r&atilde;i lắng nghe hơi thở, sự chuyển động của từng gi&aacute;c quan h&ograve;a v&agrave;o &acirc;m thanh y&ecirc;n ả xung quanh. Đ&ocirc;i khi, những điều th&acirc;n thuộc v&agrave; gắn kết với ch&igrave;nh m&igrave;nh lại bị bỏ lỡ th&igrave; đ&acirc;y cơ hội để bạn chậm lại, t&igrave;m về b&ecirc;n trong với sự an nhi&ecirc;n.</p>', 'du lịch Huế', 1, 'Mong-mo-xu-than-thuong-cung-tour-Hue-trong-ngay-hap-dan', '1732287621.jpg', '2024-11-05 09:03:06', '2024-11-22 08:00:21'),
(66, 'Du lịch Đà Nẵng khám phá vẻ đẹp tinh tế lay động lòng người', '<p>H&atilde;y chuẩn bị bản th&acirc;n cho một cuộc phi&ecirc;u lưu tuyệt vời đến th&agrave;nh phố biển Đ&agrave; Nẵng, nơi sẽ mang đến cho bạn những trải nghiệm đ&aacute;ng nhớ kh&ocirc;ng thể bỏ qua. Du lịch Đ&agrave; Nẵng ngo&agrave;i những trải nghiệm với b&atilde;i c&aacute;t trắng d&agrave;i, vẻ đẹp &ldquo;h&uacute;t hồn&rdquo; của n&uacute;i rừng, nơi đ&acirc;y c&ograve;n đặc biệt với sự hiện đại v&agrave; đa dạng về văn h&oacute;a ẩm thực.</p>\r\n\r\n<p>&nbsp;</p>', '<h2>Đ&agrave; Nẵng kh&ocirc;ng chỉ l&agrave; điểm đến l&yacute; tưởng cho những ai y&ecirc;u th&iacute;ch biển cả m&agrave; c&ograve;n l&agrave; nơi thu h&uacute;t bất kỳ du kh&aacute;ch n&agrave;o bằng cảnh quan thi&ecirc;n nhi&ecirc;n tuyệt đẹp v&agrave; nhịp sống s&ocirc;i động. Với những kinh nghiệm <a href=\"https://goldensmiletravel.com/du-lich-da-nang\"><strong>du lịch Đ&agrave; Nẵng</strong></a> được chia sẻ bởi <a href=\"http://goldensmiletravel.com/\"><strong>Golden Smile Travel</strong></a>, bạn sẽ c&oacute; một chuyến đi th&uacute; vị v&agrave; kh&ocirc;ng thể qu&ecirc;n tại v&ugrave;ng đất xứ Quảng.</h2>\r\n\r\n<h2><span style=\"color:#e74c3c\">1. Du lịch Đ&agrave; Nẵng thời điểm n&agrave;o đẹp nhất?</span></h2>\r\n\r\n<p>Thời điểm c&oacute; lượng du kh&aacute;ch đ&ocirc;ng nhất tại Đ&agrave; Nẵng chủ yếu diễn ra v&agrave;o m&ugrave;a h&egrave;, bắt đầu từ khoảng đầu th&aacute;ng 4 cho tới cuối th&aacute;ng 8. Trong khoảng thời gian n&agrave;y, thời tiết ở Đ&agrave; Nẵng thường kh&ocirc; r&aacute;o, nắng đẹp v&agrave; &iacute;t mưa b&atilde;o, tạo điều kiện l&yacute; tưởng cho việc tận hưởng kh&ocirc;ng kh&iacute; biển, kh&aacute;m ph&aacute; n&uacute;i rừng v&agrave; tham gia c&aacute;c hoạt động ngo&agrave;i trời. Tuy nhi&ecirc;n, do lượng kh&aacute;ch du lịch tăng đột biến, gi&aacute; v&eacute; m&aacute;y bay v&agrave; c&aacute;c dịch vụ như kh&aacute;ch sạn cũng sẽ tăng l&ecirc;n một ch&uacute;t, v&igrave; vậy việc l&ecirc;n kế hoạch sớm l&agrave; cần thiết.&nbsp;</p>\r\n\r\n<p><img alt=\"du-lich-da-nang-mua-nao-dep-1710495150.jpg\" src=\"https://goldensmiletravel.com/uploads/images/2024/03/15/du-lich-da-nang-mua-nao-dep-1710495150.jpg\" style=\"height:420px; width:700px\" /></p>\r\n\r\n<p>Từ th&aacute;ng 4 đến th&aacute;ng 8 l&agrave; thời điểm l&yacute; tưởng nhất trong năm để đi du lịch Đ&agrave; Nằng. Ảnh: internet</p>\r\n\r\n<p>Với những&nbsp; th&aacute;ng c&ograve;n lại trong năm, mặc d&ugrave; kh&ocirc;ng phải l&agrave; thời điểm du lịch Đ&agrave; Nẵng l&yacute; tưởng nhất, nhưng v&ugrave;ng đất xứ Quảng n&agrave;y vẫn mang đến những trải nghiệm độc đ&aacute;o cho du kh&aacute;ch. Quan trọng l&agrave; bạn cần theo d&otilde;i t&igrave;nh h&igrave;nh thời tiết khi l&ecirc;n kế hoạch du lịch của m&igrave;nh để c&oacute; trải nghiệm tốt nhất.</p>\r\n\r\n<h2><span style=\"color:#e74c3c\">2. Chi ph&iacute; du lịch Đ&agrave; Nẵng bao nhi&ecirc;u?</span></h2>\r\n\r\n<p>Dựa tr&ecirc;n kinh nghiệm du lịch Đ&agrave; Nẵng, chi ph&iacute; cho một chuyến đi 3 ng&agrave;y 2 đ&ecirc;m đến th&agrave;nh phố biển n&agrave;y thường dao động khoảng 5.000.000 VNĐ/người. Tuy nhi&ecirc;n, chi ph&iacute; c&oacute; thể tăng l&ecirc;n khoảng 1.000.000 - 1.500.000 VND nếu bạn chọn những tour du lịch c&oacute; hướng dẫn vi&ecirc;n tại c&aacute;c điểm như B&agrave; N&agrave; Hills hay b&aacute;n đảo Sơn Tr&agrave;.</p>\r\n\r\n<p>&gt;&gt;&gt;&gt;&gt; Tham khảo b&agrave;i viết: <a href=\"https://goldensmiletravel.com/du-lich-hoa-binh\">Du lịch H&ograve;a B&igrave;nh - Tận hưởng cảnh sắc thi&ecirc;n nhi&ecirc;n đẹp đến ngỡ ng&agrave;ng</a></p>\r\n\r\n<p>Đ&acirc;y chỉ l&agrave; ước lượng tổng quan về chi ph&iacute; v&agrave; n&oacute; c&oacute; thể thay đổi t&ugrave;y thuộc v&agrave;o nhu cầu c&aacute; nh&acirc;n, lịch tr&igrave;nh thăm quan cụ thể v&agrave; sở th&iacute;ch ri&ecirc;ng của mỗi du kh&aacute;ch.</p>\r\n\r\n<p><img alt=\"chi-phi-du-lich-da-nang-bao-nhieu-1710495150.jpg\" src=\"https://goldensmiletravel.com/uploads/images/2024/03/15/chi-phi-du-lich-da-nang-bao-nhieu-1710495150.jpg\" style=\"height:420px; width:700px\" /></p>\r\n\r\n<p>T&ugrave;y v&agrave;o nhu cầu v&agrave; sở th&iacute;ch của mỗi c&aacute; nh&acirc;n m&agrave; chi ph&iacute; du lịch Đ&agrave; Nẵng sẽ thay đổi. Ảnh: internet</p>\r\n\r\n<h2><span style=\"color:#e74c3c\">3. C&aacute;c địa điểm du lịch Đ&agrave; Nẵng &ldquo;h&uacute;t hồn&rdquo; nhiều du kh&aacute;ch</span></h2>\r\n\r\n<h3>3.1. Cầu Rồng Đ&agrave; Nẵng</h3>\r\n\r\n<p>Cầu Rồng l&agrave; biểu tượng của th&agrave;nh phố Đ&agrave; Nẵng v&agrave; thể hiện cho sự li&ecirc;n kết với biển lớn, thật sự nơi đ&acirc;y rất tuyệt vời v&agrave;o buổi tối. Với 1,500 đ&egrave;n LED được s&aacute;ng l&ecirc;n v&agrave; kết hợp với hiệu ứng m&agrave;u sắc lấp l&aacute;nh, cầu Rồng trở n&ecirc;n đẹp đẽ v&agrave; ấn tượng hơn bao giờ hết.</p>\r\n\r\n<p>Khi bạn du lịch Đ&agrave; Nẵng, kh&ocirc;ng thể bỏ qua cơ hội xem m&agrave;n tr&igrave;nh diễn phun nước v&agrave; lửa đặc sắc v&agrave;o mỗi buổi tối những ng&agrave;y cuối tuần. Điều n&agrave;y tạo ra những trải nghiệm đặc biệt v&agrave; kh&ocirc;ng thể qu&ecirc;n cho du kh&aacute;ch.</p>\r\n\r\n<p><img alt=\"cau-rong-da-nang-1710495150.png\" src=\"https://goldensmiletravel.com/uploads/images/2024/03/15/cau-rong-da-nang-1710495150.png\" style=\"height:420px; width:700px\" /></p>\r\n\r\n<p>Buổi tối Cầu Rồng trở n&ecirc;n lung linh - điểm đến h&agrave;ng đầu khi du lịch Đ&agrave; Nẵng. Ảnh: internet</p>\r\n\r\n<h3>3.2. Ngũ H&agrave;nh Sơn&nbsp;</h3>\r\n\r\n<p>Ngũ H&agrave;nh Sơn l&agrave; một quần thể gồm 5 ngọn n&uacute;i đ&aacute; v&ocirc;i: Kim Sơn, Mộc Sơn, Thủy Sơn, Hỏa Sơn v&agrave; Thổ Sơn. Điểm tham quan n&agrave;y kh&ocirc;ng chỉ g&acirc;y ấn tượng bởi vẻ đẹp h&ugrave;ng vĩ của cảnh quan v&agrave; sự phong ph&uacute; của r&ecirc;u phong m&agrave; c&ograve;n bởi những kiến tr&uacute;c văn h&oacute;a đặc trưng, thấm đượm lịch sử.</p>\r\n\r\n<p>&gt;&gt;&gt;&gt;&gt; Tham khảo b&agrave;i viết: <a href=\"https://goldensmiletravel.com/du-lich-quang-ninh\">C&aacute;c địa điểm du lịch Quảng Ninh nổi tiếng đẹp m&ecirc; hoặc l&ograve;ng người</a></p>\r\n\r\n<p>Khi đến Ngũ H&agrave;nh Sơn trong chuyến du lịch Đ&agrave; Nẵng, du kh&aacute;ch c&oacute; thể lựa chọn giữa hai phương tiện để l&ecirc;n đỉnh n&uacute;i: thang m&aacute;y hoặc leo bộ qua c&aacute;c bậc thang. Tại đỉnh n&uacute;i, bạn c&oacute; thể ngắm nh&igrave;n to&agrave;n cảnh của th&agrave;nh phố, tạo n&ecirc;n một trải nghiệm ấn tượng trong l&ograve;ng du kh&aacute;ch.</p>\r\n\r\n<p><img alt=\"ngu-hanh-son-du-lich-da-nang-1710495150.jpg\" src=\"https://goldensmiletravel.com/uploads/images/2024/03/15/ngu-hanh-son-du-lich-da-nang-1710495150.jpg\" style=\"height:420px; width:700px\" /></p>\r\n\r\n<p>Ngũ H&agrave;nh Sơn - địa điểm du lịch văn h&oacute;a v&agrave; giải tr&iacute; đặc sắc tại Đ&agrave; Nẵng. Ảnh: internet</p>\r\n\r\n<h3>3.3. B&agrave; N&agrave; Hills</h3>\r\n\r\n<p>Khi được hỏi về c&aacute;c hoạt động du lịch Đ&agrave; Nẵng, B&agrave; N&agrave; Hills chắc chắn l&agrave; điểm đến nổi tiếng v&agrave; thu h&uacute;t nhất. Với vị tr&iacute; c&aacute;ch th&agrave;nh phố khoảng 35km, B&agrave; N&agrave; Hills được biết đến như chốn bồng lai ti&ecirc;n cảnh với một loạt c&aacute;c điểm tham quan đa dạng.</p>\r\n\r\n<p>Tại đ&acirc;y, du kh&aacute;ch sẽ được trải nghiệm kh&ocirc;ng gian kiến tr&uacute;c phương T&acirc;y, c&aacute;c địa điểm t&ocirc;n gi&aacute;o, v&agrave; phong cảnh hữu t&igrave;nh khi leo n&uacute;i tr&ecirc;n chuyến t&agrave;u hỏa độc đ&aacute;o. Ngo&agrave;i ra, B&agrave; N&agrave; Hills c&ograve;n c&oacute; nhiều khu vui chơi giải tr&iacute; đa dạng.</p>\r\n\r\n<p>Đặc biệt, kh&ocirc;ng thể kh&ocirc;ng nhắc đến Cầu V&agrave;ng - một c&ocirc;ng tr&igrave;nh kiến tr&uacute;c độc đ&aacute;o với b&agrave;n tay nổi bật giữa thi&ecirc;n nhi&ecirc;n n&uacute;i rừng. Đ&acirc;y cũng l&agrave; điểm &quot;sống ảo&quot; vẫn đang rất được y&ecirc;u th&iacute;ch tr&ecirc;n c&aacute;c trang mạng x&atilde; hội.</p>\r\n\r\n<p>Để kh&aacute;m ph&aacute; to&agrave;n bộ vẻ đẹp của B&agrave; N&agrave; Hills, bạn c&oacute; thể c&acirc;n nhắc tham gia tour du lịch 1 ng&agrave;y với sự hướng dẫn tận t&igrave;nh v&agrave; xe đưa đ&oacute;n từ kh&aacute;ch sạn.</p>\r\n\r\n<p><img alt=\"ba-na-hills-1710495150.jpg\" src=\"https://goldensmiletravel.com/uploads/images/2024/03/15/ba-na-hills-1710495150.jpg\" style=\"height:420px; width:700px\" /></p>\r\n\r\n<p>Tận hưởng kh&ocirc;ng gian đa sắc m&agrave;u, kiến tr&uacute;c phương T&acirc;y tại B&agrave; N&agrave; Hills. Ảnh: internet</p>\r\n\r\n<h3>3.4. Phố cổ Hội An</h3>\r\n\r\n<p>Phố cổ Hội An với vẻ đẹp cổ k&iacute;nh đ&atilde; tồn tại h&agrave;ng ngh&igrave;n năm v&agrave; sự giao thoa giữa Đ&ocirc;ng v&agrave; T&acirc;y, được UNESCO c&ocirc;ng nhận l&agrave; Di sản Văn h&oacute;a Thế giới. Nơi đ&acirc;y mang trong m&igrave;nh một kh&ocirc;ng gian độc đ&aacute;o, l&agrave;m cho du kh&aacute;ch cảm thấy như đang quay về cảng thị phồn hoa một thời.</p>\r\n\r\n<p>Dưới đ&acirc;y l&agrave; một số điểm đặc biệt của Hội An m&agrave; bạn chưa chắc đ&atilde; biết:</p>\r\n\r\n<p>- L&agrave;ng gốm Thanh H&agrave;: Đ&acirc;y l&agrave; nơi sản xuất gốm truyền thống từ thời xưa của Hội An, nơi du kh&aacute;ch c&oacute; thể tham quan qu&aacute; tr&igrave;nh l&agrave;m gốm v&agrave; mua những sản phẩm thủ c&ocirc;ng độc đ&aacute;o.</p>\r\n\r\n<p>- Ch&ugrave;a Cầu: Biểu tượng nổi tiếng của Hội An, ch&ugrave;a Cầu l&agrave; một c&acirc;y cầu gỗ cổ k&iacute;nh, được x&acirc;y dựng v&agrave;o thế kỷ 17 v&agrave; mang trong m&igrave;nh nhiều huyền thoại v&agrave; truyền thuyết.</p>\r\n\r\n<p>- Nh&agrave; cổ Ph&ugrave;ng Hưng: L&agrave; một trong những ng&ocirc;i nh&agrave; cổ lớn nhất Hội An, nh&agrave; cổ Ph&ugrave;ng Hưng l&agrave; một điểm dừng ch&acirc;n th&uacute; vị để kh&aacute;m ph&aacute; lịch sử v&agrave; kiến tr&uacute;c truyền thống của v&ugrave;ng đất n&agrave;y.</p>\r\n\r\n<p>- Chợ Hội An: Nơi n&agrave;y kh&ocirc;ng chỉ l&agrave; điểm mua sắm độc đ&aacute;o với c&aacute;c sản phẩm thủ c&ocirc;ng truyền thống m&agrave; c&ograve;n l&agrave; nơi để thưởng thức những m&oacute;n ăn đặc sản đường phố ngon miệng.</p>\r\n\r\n<p>Với những điểm đặc biệt n&agrave;y, Hội An chắc chắn sẽ mang lại cho du kh&aacute;ch những trải nghiệm đầy th&uacute; vị v&agrave; kh&aacute;m ph&aacute; sự đa dạng văn h&oacute;a của miền Trung Việt Nam.</p>\r\n\r\n<p><img alt=\"pho-co-hoi-an-1710495150.jpg\" src=\"https://goldensmiletravel.com/uploads/images/2024/03/15/pho-co-hoi-an-1710495150.jpg\" style=\"height:420px; width:700px\" /></p>\r\n\r\n<p>Phố Cổ Hội An - điểm đến check-in h&agrave;ng đầu của du kh&aacute;ch mỗi khi du lịch Đ&agrave; Nẵng</p>\r\n\r\n<h3>3.5. B&atilde;i biển Mỹ Kh&ecirc;&nbsp;</h3>\r\n\r\n<p>B&atilde;i biển Mỹ Kh&ecirc;, được coi l&agrave; một trong những b&atilde;i biển đẹp nhất tr&ecirc;n thế giới, sở hữu nước biển xanh trong, b&atilde;i c&aacute;t trắng mịn v&agrave; sạch sẽ, tạo n&ecirc;n một cảnh đẹp m&ecirc; hồn. Đến đ&acirc;y, du kh&aacute;ch kh&ocirc;ng chỉ c&oacute; cơ hội tận hưởng việc tắm biển m&agrave; c&ograve;n c&oacute; thể tham gia v&agrave;o c&aacute;c hoạt động th&uacute; vị như lướt v&aacute;n, đi thuyền kayak, hay trải nghiệm l&aacute;i moto nước.</p>\r\n\r\n<p>Đặc biệt, bạn kh&ocirc;ng thể bỏ qua cơ hội thưởng thức cảnh b&igrave;nh minh v&agrave; ho&agrave;ng h&ocirc;n tuyệt đẹp tại th&agrave;nh phố biển n&agrave;y. Những khoảnh khắc n&agrave;y sẽ để lại ấn tượng kh&oacute; qu&ecirc;n trong l&ograve;ng du kh&aacute;ch.</p>\r\n\r\n<p><img alt=\"bai-bien-my-khe-da-nang-1710495150.jpg\" src=\"https://goldensmiletravel.com/uploads/images/2024/03/15/bai-bien-my-khe-da-nang-1710495150.jpg\" style=\"height:420px; width:700px\" /></p>\r\n\r\n<p>Tận hưởng khung cảnh biển b&igrave;nh y&ecirc;n v&agrave; tuyệt đẹp của B&atilde;i biển Mỹ Kh&ecirc;. Ảnh: internet</p>\r\n\r\n<h2><span style=\"color:#e74c3c\">4. Du lịch Đ&agrave; Nẵng n&ecirc;n ăn g&igrave;? Những m&oacute;n ăn đặc sắc của xứ Quảng</span></h2>\r\n\r\n<h3>4.1. M&igrave; Quảng</h3>\r\n\r\n<p>M&igrave; Quảng l&agrave; m&oacute;n ăn c&oacute; nguồn gốc từ Quảng Nam, nhưng khi đến Đ&agrave; Nẵng, ai cũng kh&ocirc;ng thể kh&ocirc;ng thưởng thức m&oacute;n đặc sản n&agrave;y. M&oacute;n n&agrave;y bao gồm c&aacute;c nguy&ecirc;n liệu đơn giản v&agrave; quen thuộc như g&agrave;, thịt heo, t&ocirc;m... được nấu c&ugrave;ng với nước d&ugrave;ng thơm b&eacute;o. M&igrave; quảng khi được đưa v&agrave;o t&ocirc;, chan nước l&egrave;o, k&egrave;m theo một &iacute;t b&aacute;nh đa v&agrave; rau sống trộn đều, tạo n&ecirc;n một hương vị đặc trưng v&agrave; kh&ocirc;ng thể cưỡng lại.&nbsp;</p>\r\n\r\n<p><img alt=\"my-quang-da-nang-1710495150.jpg\" src=\"https://goldensmiletravel.com/uploads/images/2024/03/15/my-quang-da-nang-1710495150.jpg\" style=\"height:420px; width:700px\" /></p>\r\n\r\n<p>Du lịch Đ&agrave; Nẵng nhất định phải thưởng thức M&igrave; Quảng &ldquo;ngon nức l&ograve;ng&rdquo; thực kh&aacute;ch. Ảnh: internet</p>\r\n\r\n<h3>4.2. B&aacute;nh tr&aacute;ng cuốn thịt heo</h3>\r\n\r\n<p>B&aacute;nh tr&aacute;ng cuốn thịt heo l&agrave; một m&oacute;n ăn đặc trưng của ẩm thực Đ&agrave; Nẵng, mặc d&ugrave; c&oacute; vẻ đơn giản nhưng lại để lại ấn tượng s&acirc;u đậm trong l&ograve;ng du kh&aacute;ch. Miếng thịt heo 2 đầu mỡ luộc được th&aacute;i mỏng, kết hợp c&ugrave;ng một &iacute;t rau sống, dưa leo, đồ chua, sau đ&oacute; cuộn lại bằng b&aacute;nh tr&aacute;ng dẻo dai. Khi thưởng thức, thực kh&aacute;ch thường chấm c&ugrave;ng mắm n&ecirc;m thơm m&ugrave;i tỏi ớt, l&agrave;m tăng th&ecirc;m hương vị hấp dẫn cho m&oacute;n ăn.</p>\r\n\r\n<h3>4.3. B&uacute;n chả c&aacute; Đ&agrave; Nẵng</h3>\r\n\r\n<p>Một t&ocirc; b&uacute;n chả c&aacute; Đ&agrave; Nẵng chuẩn điệu thường được chế biến từ c&aacute;c nguy&ecirc;n liệu cơ bản như bắp cải, b&iacute; đỏ, c&agrave; chua, thơm,... được hầm c&ugrave;ng nước d&ugrave;ng v&agrave; n&ecirc;m nếm gia vị đặc trưng từ mắm ruốc. Điểm đặc biệt của m&oacute;n n&agrave;y l&agrave; chả c&aacute; hấp v&agrave; chả c&aacute; chi&ecirc;n thơm ngon v&agrave; ngọt vị.</p>\r\n\r\n<p><img alt=\"bun-cha-ca-da-nang-1710495150.jpg\" src=\"https://goldensmiletravel.com/uploads/images/2024/03/15/bun-cha-ca-da-nang-1710495150.jpg\" style=\"height:420px; width:700px\" /></p>\r\n\r\n<p>Thưởng thức m&oacute;n b&uacute;n chả c&aacute; - m&oacute;n ăn đặc sản của Đ&agrave; Nẵng. Ảnh: internet</p>\r\n\r\n<p>Để tăng th&ecirc;m hương vị v&agrave; sự tươi ngon cho m&oacute;n ăn, mỗi phần b&uacute;n thường được phục vụ k&egrave;m theo một rổ rau sống tươi ngon. Kết hợp c&ugrave;ng với vị ngon của b&uacute;n, chả c&aacute; v&agrave; rau sống, m&oacute;n b&uacute;n chả c&aacute; Đ&agrave; Nẵng đem lại trải nghiệm ẩm thực độc đ&aacute;o v&agrave; hấp dẫn cho du kh&aacute;ch.</p>\r\n\r\n<h3>4.4. Gỏi c&aacute; Nam &Ocirc;</h3>\r\n\r\n<p>Nếu bạn l&agrave; một người đam m&ecirc; ẩm thực thực thụ, khi du lịch Đ&agrave; Nẵng, bạn nhất định kh&ocirc;ng thể bỏ lỡ cơ hội thưởng thức gỏi c&aacute; Nam &Ocirc;. M&oacute;n n&agrave;y thường sử dụng c&aacute; tr&iacute;ch, được sơ chế kỹ lưỡng v&agrave; loại bỏ phần xương, sau đ&oacute; trộn đều với gừng, riềng, tỏi băm nhuyễn v&agrave; th&iacute;nh.</p>\r\n\r\n<p>Khi ăn, bạn c&oacute; thể kết hợp gỏi c&ugrave;ng b&aacute;nh tr&aacute;ng, rau sống v&agrave; một loại nước chấm đặc biệt. Mỗi miếng gỏi tươi ngon, kết hợp c&ugrave;ng với một ch&uacute;t bia lạnh, tạo n&ecirc;n một trải nghiệm thực kh&aacute;ch tuyệt vời trong một buổi chiều tại Đ&agrave; Nẵng.</p>\r\n\r\n<h3>4.5. B&ecirc; Thui Cầu Mống&nbsp;</h3>\r\n\r\n<p><img alt=\"be-thui-cau-mong-da-nang-1710495150.jpg\" src=\"https://goldensmiletravel.com/uploads/images/2024/03/15/be-thui-cau-mong-da-nang-1710495150.jpg\" style=\"height:420px; width:700px\" /></p>\r\n\r\n<p>Thịt b&ecirc; thui Cầu Mống - m&oacute;n ăn lạ miệng v&agrave; độc đ&aacute;o tại Đ&agrave; Nẵng. Ảnh: internet</p>\r\n\r\n<p>Thịt b&ecirc; thui Cầu Mống đ&atilde; trở n&ecirc;n nổi tiếng khắp nơi nhờ v&agrave;o vị ngon đậm đ&agrave; v&agrave; hấp dẫn của n&oacute;. Khi được phục vụ, thịt b&ecirc; thường được th&aacute;i th&agrave;nh l&aacute;t mỏng, vẫn c&ograve;n n&oacute;ng hổi, cuốn c&ugrave;ng một lớp b&aacute;nh tr&aacute;ng, rau sống, khế chua, dưa leo, ng&ograve; thơm v&agrave; chuối ch&aacute;t.</p>\r\n\r\n<p>Khi ng&acirc;m v&agrave;o ch&eacute;n mắm c&aacute; cơm, bạn sẽ cảm nhận được hương vị ngọt ng&agrave;o của thịt, h&ograve;a quyện với hương thơm của rau m&ugrave;i, v&agrave; cay cay của ớt, tạo ra một trải nghiệm ẩm thực độc đ&aacute;o v&agrave; kh&oacute; qu&ecirc;n.</p>\r\n\r\n<p>Với kinh nghiệm du lịch Đ&agrave; Nẵng chi tiết v&agrave; sự &quot;đắt gi&aacute;&quot; từ những th&ocirc;ng tin tr&ecirc;n, chắc chắn chuyến đi sắp tới sẽ l&agrave; một trải nghiệm đ&aacute;ng nhớ. H&atilde;y để <strong>Golden Smile Travel</strong> l&agrave; người bạn đồng h&agrave;nh đ&aacute;ng tin cậy trong việc gi&uacute;p bạn tiết kiệm v&agrave; tận hưởng mọi khoảnh khắc tuyệt vời tại th&agrave;nh phố xinh đẹp n&agrave;y. H&atilde;y chuẩn bị tinh thần cho một kỳ nghỉ ho&agrave;n hảo v&agrave; đầy trải nghiệm tại Đ&agrave; Nẵng!</p>', 'du lịch đà nẵng', 1, 'Du-lich-Đa-Nang-kham-pha-ve-đep-tinh-te-lay-đong-long-nguoi', '1732287604.jpg', '2024-11-06 00:13:56', '2024-11-22 08:00:04');
INSERT INTO `posts` (`post_id`, `title`, `description`, `content`, `meta_desc`, `status`, `url_seo`, `img`, `created_at`, `updated_at`) VALUES
(67, 'Top 10 địa điểm du lịch Mũi Né đặc sắc để khám phá', '<p>Sở hữu b&atilde;i biển trong xanh, những đồi c&aacute;t trắng trải d&agrave;i, khung cảnh thi&ecirc;n nhi&ecirc;n kết hợp h&agrave;i h&ograve;a với c&ocirc;ng tr&igrave;nh vui chơi nghỉ dưỡng v&agrave; dịch vụ chất lượng đ&atilde; gi&uacute;p Mũi N&eacute; trở th&agrave;nh một trong 21 địa điểm du lịch trọng điểm quốc gia của Việt Nam.</p>', '<h2 dir=\"auto\">1. B&atilde;i Rạng - một trong những b&atilde;i tắm đẹp nhất Việt Nam</h2>\r\n\r\n<p>Nhắc đến địa điểm du lịch Mũi N&eacute; đặc sắc th&igrave; trước ti&ecirc;n phải kể đến biển. H&atilde;y d&agrave;nh thời gian tắm m&igrave;nh dưới l&agrave;n nước trong xanh m&aacute;t rượi tại B&atilde;i Rạng. C&aacute;ch trung t&acirc;m th&agrave;nh phố Phan Thiết khoảng 5km về hướng Đ&ocirc;ng, bạn c&oacute; thể dễ d&agrave;ng di chuyển đến b&atilde;i tắm bằng xe &ocirc; t&ocirc; hoặc tản bộ.</p>\r\n\r\n<p><img alt=\"Bãi Rạng tại Mũi Né\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-2.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>B&atilde;i Rạng sạch, nước trong, rất th&iacute;ch hợp để tắm biển @internet</p>\r\n\r\n<p>Điểm nổi bật nhất tại nơi đ&acirc;y ch&iacute;nh l&agrave; b&atilde;i tắm si&ecirc;u sạch. H&agrave;ng dừa thẳng tắp, cao v&uacute;t g&oacute;p phần tạo n&ecirc;n cảnh quan xanh tươi v&agrave; bầu kh&ocirc;ng kh&iacute; trong l&agrave;nh.</p>\r\n\r\n<p><img alt=\"Bãi Rạng buổi sáng\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-3.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>Khung cảnh trong l&agrave;nh tại B&atilde;i Rạng @internet</p>\r\n\r\n<p>Bạn cần ch&uacute; &yacute; khoảng thời gian l&yacute; tưởng nhất để tắm biển Mũi N&eacute; l&agrave; từ th&aacute;ng 4 đến th&aacute;ng 8 h&agrave;ng năm. Đ&acirc;y l&agrave; l&uacute;c thời tiết kh&ocirc; r&aacute;o, &iacute;t mưa b&atilde;o, nắng đẹp, biển trong xanh, rất thuận tiện cho việc di chuyển v&agrave; tham gia c&aacute;c hoạt động dưới nước.</p>\r\n\r\n<p>Khi đến đ&acirc;y, bạn nhớ t&igrave;m v&agrave; thưởng thức những m&oacute;n ngon v&ugrave;ng biển như nhum, cua ho&agrave;ng đế, chả c&aacute;, b&aacute;nh rế&hellip; nữa nh&eacute;!</p>\r\n\r\n<h2 dir=\"auto\">2. H&ograve;n Rơm</h2>\r\n\r\n<p>H&ograve;n Rơm l&agrave; một ngọn n&uacute;i nhỏ, c&aacute;ch trung t&acirc;m th&agrave;nh phố Phan Thiết khoảng 12 km về hướng Đ&ocirc;ng Bắc. Biển H&ograve;n Rơm &ecirc;m s&oacute;ng, trong xanh, rất th&iacute;ch hợp để tắm biển.</p>\r\n\r\n<p><strong>Đọc th&ecirc;m:</strong> <a href=\"https://www.traveloka.com/vi-vn/explore/destination/khu-du-lich-lang-tre-mui-ne/191233?funnel_source=content_article&amp;funnel_id=WP_125348\" rel=\"noreferrer noopener\" target=\"_blank\"><strong>Kh&aacute;m ph&aacute; khu du lịch L&agrave;ng Tre Mũi N&eacute; - C&oacute; điểm g&igrave; thu h&uacute;t?</strong></a></p>\r\n\r\n<p><img alt=\"Hòn Rơm tại Mũi Né\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-4.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>H&ograve;n Rơm cũng l&agrave; một trong những b&atilde;i biển đẹp tại Mũi N&eacute; @internet</p>\r\n\r\n<p>Điểm đặc biệt nhất của nơi đ&acirc;y ch&iacute;nh l&agrave; d&aacute;ng vẻ hoang sơ hiếm c&oacute;, phần lớn diện t&iacute;ch tại H&ograve;n Rơm chưa được khai th&aacute;c x&acirc;y dựng dịch vụ du lịch n&ecirc;n bạn vẫn c&oacute; cơ hội chi&ecirc;m ngưỡng vẻ đẹp mộc mạc của cảnh sắc. H&ograve;n Rơm cũng l&agrave; nơi được xem l&agrave; nơi ngắm b&igrave;nh minh v&agrave; ho&agrave;ng h&ocirc;n đẹp nhất nh&igrave; tại Mũi N&eacute;. Ngo&agrave;i ra, bạn cũng c&oacute; thể thử cắm trại qua đ&ecirc;m tại đ&acirc;y nữa đấy!</p>\r\n\r\n<h2 dir=\"auto\">3. Suối Ti&ecirc;n</h2>\r\n\r\n<p>Ngay b&ecirc;n cạnh H&ograve;n Rơm l&agrave; Suối Ti&ecirc;n - địa điểm check-in tại Mũi N&eacute; kh&ocirc;ng thể bỏ qua. Suối Ti&ecirc;n thực chất l&agrave; một khe nước nhỏ đổ ra biển. Điều khiến nơi đ&acirc;y trở n&ecirc;n nổi tiếng ch&iacute;nh l&agrave; v&aacute;ch nhũ c&aacute;t m&agrave;u đỏ cam rực rỡ bị mưa gi&oacute; b&agrave;o m&ograve;n tạo ra h&igrave;nh th&ugrave; rất lạ mắt.</p>\r\n\r\n<p><img alt=\"Suối Tiên - địa điểm du lịch Mũi Né lý tưởng\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-5.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>Khung cảnh đẹp như tranh vẽ với 2 tone m&agrave;u đối lập của v&aacute;ch n&uacute;i c&aacute;t v&agrave; c&acirc;y xanh tạo n&ecirc;n khung cảnh ấn tượng @internet</p>\r\n\r\n<p>Chốn bồng lai ti&ecirc;n cảnh n&agrave;y kh&ocirc;ng những thu h&uacute;t hội đam m&ecirc; kh&aacute;m ph&aacute; m&agrave; c&ograve;n l&agrave; địa điểm chụp h&igrave;nh cưới của nhiều cặp đ&ocirc;i v&igrave; khung cảnh v&ocirc; c&ugrave;ng ảo diệu m&agrave; kh&ocirc;ng nơi n&agrave;o c&oacute; được.</p>\r\n\r\n<h2 dir=\"auto\">4. Đồi c&aacute;t trắng</h2>\r\n\r\n<p>Đồi c&aacute;t trắng c&ograve;n được biết đến với t&ecirc;n gọi Đồi C&aacute;t Bay hay Đồi C&aacute;t Hồng. Đ&acirc;y lại l&agrave; một đặc sản hiếm c&oacute; kh&oacute; t&igrave;m v&agrave; l&agrave; điểm check-in tại Mũi N&eacute; si&ecirc;u hot. Tại đ&acirc;y, bạn c&oacute; thể bắt gặp 18 m&agrave;u sắc của c&aacute;t như đỏ, trắng hồng, trắng x&aacute;m, trắng, đen, đỏ đen&hellip; V&agrave; v&agrave;o mỗi thời điểm trong ng&agrave;y, gi&oacute; sẽ khiến h&igrave;nh th&ugrave; của những đồi c&aacute;t n&agrave;y thay đổi li&ecirc;n tục.</p>\r\n\r\n<p><strong>Đọc th&ecirc;m:</strong> <a href=\"https://www.traveloka.com/vi-vn/explore/destination/suoi-tien-mui-ne-acc/190660?funnel_source=content_article&amp;funnel_id=WP_125348\" rel=\"noreferrer noopener\" target=\"_blank\"><strong>Kh&aacute;m ph&aacute; &ldquo;th&aacute;nh địa sống ảo&rdquo; Suối Ti&ecirc;n Mũi N&eacute;</strong></a></p>\r\n\r\n<p><img alt=\"Đồi cát trắng tại Mũi Né\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-6-1024x760.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>Đồi c&aacute;t trắng - đặc sản du lịch biển Mũi N&eacute;, bạn nhất định phải check-in ở đ&acirc;y nh&eacute; @internet</p>\r\n\r\n<p>Bạn c&oacute; thể d&agrave;nh thời gian đầu ng&agrave;y thức dậy thật sớm, đi bộ l&ecirc;n đồi c&aacute;t v&agrave; đ&oacute;n b&igrave;nh minh tại đ&acirc;y. Sau đ&oacute;, bạn cũng c&oacute; thể tham gia chơi trượt v&aacute;n c&aacute;t hoặc l&aacute;i m&ocirc; t&ocirc; địa h&igrave;nh rất vui nhộn.</p>\r\n\r\n<p><img alt=\"Trượt cát tại đồi cát trắng\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-7-1024x658.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>Bạn nhớ thử một lần trượt c&aacute;t tại đ&acirc;y nha @internet</p>\r\n\r\n<p>Lưu &yacute; d&agrave;nh cho bạn: thời gian thăm th&uacute; đồi c&aacute;t l&yacute; tưởng nhất l&agrave; từ 6 đến 8 giờ s&aacute;ng h&agrave;ng ng&agrave;y v&igrave; khung giờ n&agrave;y nắng kh&ocirc;ng qu&aacute; ch&oacute;i chang.</p>\r\n\r\n<h2 dir=\"auto\">5. Hải đăng K&ecirc; G&agrave;</h2>\r\n\r\n<p>Nếu khởi h&agrave;nh từ TP.HCM th&igrave; bạn sẽ gặp hải đăng K&ecirc; G&agrave; trước. Ngọn hải đăng hơn 100 năm tuổi n&agrave;y được thiết kế bởi một kế tr&uacute;c sư người Ph&aacute;p, to&agrave;n bộ vật liệu x&acirc;y dựng cũng đều được nhập khẩu từ Ph&aacute;p. Sau ngần ấy thời gian, ngọn hải đăng vẫn đứng vững, tỏa &aacute;nh s&aacute;ng chỉ dẫn cho t&agrave;u thuyền di chuyển trong v&ugrave;ng biển khi đ&ecirc;m về.</p>\r\n\r\n<p><img alt=\"Hải đăng Kê Gà nhìn từ xa\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-8.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>Ngọn Hải Đăng K&ecirc; G&agrave; giữa biển cả m&ecirc;nh m&ocirc;ng @internet</p>\r\n\r\n<p>Để tham quan hải đăng K&ecirc; G&agrave; bạn cần thu&ecirc; ca-n&ocirc; ra đảo. Sau đ&oacute; chinh phục hơn 180 bậc thang để đến ngọn hải đăng. Từ tr&ecirc;n cao, bạn c&oacute; thể ph&oacute;ng tầm mắt ngắm nh&igrave;n v&ugrave;ng biển xinh đẹp. Từ hải đăng xuống, bạn c&oacute; thể kh&aacute;m ph&aacute; th&ecirc;m v&ugrave;ng đồng cỏ ở ph&iacute;a b&ecirc;n phải h&ograve;n đảo. B&atilde;i cỏ xanh mướt với view hướng thẳng ngọn hải đăng tạo n&ecirc;n background tuyệt đẹp để bạn check-in đấy!</p>\r\n\r\n<p><img alt=\"Check-in cùng Hải đăng Kê Gà\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-9.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>B&atilde;i đ&aacute; v&agrave; b&atilde;i cỏ tạo n&ecirc;n background check-in si&ecirc;u đẹp @internet</p>\r\n\r\n<p>Tr&ecirc;n bờ gần ngọn hải đăng cũng c&oacute; c&aacute;c qu&aacute;n ăn b&igrave;nh d&acirc;n với nhiều m&oacute;n hải sản tươi ngon, bạn c&oacute; thể thưởng thức.</p>\r\n\r\n<h2 dir=\"auto\">6. N&uacute;i T&agrave; C&uacute;</h2>\r\n\r\n<p>Nếu bạn y&ecirc;u vận động, th&iacute;ch đi bộ, trekking th&igrave; n&uacute;i T&agrave; C&uacute; với độ cao khoảng 650 m so với mực nước biển rất ph&ugrave; hợp đấy! Dọc theo tuyến đường dẫn l&ecirc;n n&uacute;i T&agrave; C&uacute; l&agrave; những loại c&acirc;y ra hoa rất đẹp, nổi trội nhất l&agrave; bằng lăng. Điểm nhất của chuyến trekking l&agrave; tượng Phật nhập niết b&agrave;n khổng lồ với tư thế nằm ở tr&ecirc;n đỉnh n&uacute;i.</p>\r\n\r\n<p><strong>Đọc th&ecirc;m:</strong> <a href=\"https://www.traveloka.com/vi-vn/explore/culinary/10-dac-san-mui-ne/146302?funnel_source=content_article&amp;funnel_id=WP_125348\" rel=\"noreferrer noopener\" target=\"_blank\"><strong>10 Đặc sản Mũi N&eacute; khiến du kh&aacute;ch &ldquo;u m&ecirc;&quot; ngay từ lần đầu nếm thử</strong></a></p>\r\n\r\n<p><img alt=\"Núi Tà Cú thanh bình\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-10.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>Khung cảnh thanh b&igrave;nh nh&igrave;n từ ch&ugrave;a tr&ecirc;n n&uacute;i T&agrave; C&uacute; @internet</p>\r\n\r\n<p>Nếu bạn kh&ocirc;ng c&oacute; qu&aacute; nhiều thời gian để chinh phục 1000 bậc thang dẫn l&ecirc;n n&uacute;i th&igrave; c&oacute; thể chọn di chuyển bằng c&aacute;p treo. Chỉ với 15 ph&uacute;t di chuyển l&agrave; bạn sẽ đến nơi. Tr&ecirc;n c&aacute;p treo, bạn cũng c&oacute; thể chi&ecirc;m ngưỡng cảnh đẹp xung quanh.</p>\r\n\r\n<p><img alt=\"Tượng Phật tại núi Tà Cú\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-11-1024x576.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>Tượng Phật niết b&agrave;n tr&ecirc;n n&uacute;i, nếu đi c&aacute;p treo bạn c&oacute; thể ngắm nh&igrave;n pho tượng từ t&iacute;t đằng xa @internet</p>\r\n\r\n<p>Tr&ecirc;n n&uacute;i T&agrave; C&uacute; l&agrave; tổ hợp c&aacute;c ch&ugrave;a như ch&ugrave;a Long Đo&agrave;n, ch&ugrave;a Tổ, ch&ugrave;a Linh Sơn Trường Thọ&hellip; B&ecirc;n cạnh đ&oacute;, bạn c&ograve;n c&oacute; cơ hội tham gia c&acirc;u c&aacute;, chơi đạp vịt hoặc lựa chọn tiếp tục trekking để đến đỉnh cao nhất của n&uacute;i ở cột mốc 694 m.</p>\r\n\r\n<p><img alt=\"Cáp treo dẫn lên núi núi Tà Cú\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-12.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>C&aacute;p treo dẫn l&ecirc;n n&uacute;i @internet</p>\r\n\r\n<h2 dir=\"auto\">8. B&atilde;i đ&aacute; Cổ Thạch</h2>\r\n\r\n<p>B&atilde;i đ&aacute; Cổ Thạch nằm trong khu du lịch Ch&ugrave;a Cổ Thạch, x&atilde; B&igrave;nh Thạnh, huyện Tuy Phong, B&igrave;nh Thuận. Điểm đặc sắc của b&atilde;i đ&aacute; ch&iacute;nh l&agrave; h&igrave;nh th&ugrave; lạ mắt của những vi&ecirc;n đ&aacute; với m&agrave;u sắc v&ocirc; c&ugrave;ng phong ph&uacute;. Theo thời gian, dưới sự m&agrave;i m&ograve;n của s&oacute;ng biển, nắng v&agrave; gi&oacute;, những tảng đ&aacute; lớn cũng được m&agrave;i giũa th&agrave;nh h&igrave;nh d&aacute;ng rất độc đ&aacute;o.</p>\r\n\r\n<p><img alt=\"Đá tại bãi đá Cổ Thạch\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-13.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>C&ugrave;ng ngắm nh&igrave;n sự đa dạng m&agrave;u sắc của đ&aacute; tại b&atilde;i đ&aacute; Cổ Thạch @internet</p>\r\n\r\n<p>H&agrave;ng năm, v&agrave;o độ th&aacute;ng 2 đến th&aacute;ng 3 ch&iacute;nh l&agrave; l&uacute;c b&atilde;i đ&aacute; kho&aacute;c l&ecirc;n m&igrave;nh lớp &aacute;o xanh r&ecirc;u mướt mắt, huyền ảo. Đ&acirc;y được xem l&agrave; khoảng thời gian v&agrave;ng để bạn săn những bức ảnh để đời tại b&atilde;i đ&aacute;. Ch&uacute; &yacute; d&agrave;nh cho bạn: m&ugrave;a r&ecirc;u mọc g&acirc;y trơn trượt, trong l&uacute;c t&aacute;c nghiệp chụp ảnh, bạn ch&uacute; &yacute; khi di chuyển để đảm bảo an to&agrave;n cho bản th&acirc;n.</p>\r\n\r\n<p><img alt=\"Cổ Thạch mùa rêu\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-14.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>Cổ Thạch m&ugrave;a r&ecirc;u hệt như chốn bồng lai ti&ecirc;n cảnh @internet</p>\r\n\r\n<p>Khi đ&atilde; đến b&atilde;i đ&aacute;, bạn c&oacute; thể kết hợp tham quan một số địa điểm l&acirc;n cận như:</p>\r\n\r\n<p><strong>Ch&ugrave;a Cổ Thạch</strong>: với tầm nh&igrave;n hướng biển, bao qu&aacute;t b&atilde;i đ&aacute; Cổ Thạch r&ecirc;u phong. Ng&ocirc;i ch&ugrave;a được x&acirc;y dựng v&agrave;o khoảng thế kỷ 19, l&agrave; c&ocirc;ng tr&igrave;nh t&ocirc;n gi&aacute;o c&oacute; &yacute; nghĩa quan trọng đối với người d&acirc;n trong v&ugrave;ng.</p>\r\n\r\n<p><img alt=\"Chùa Cổ Thạch\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-15.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>Ch&ugrave;a Cổ Thạch với view hướng biển @internet</p>\r\n\r\n<p><strong>Đồi c&aacute;t sa mạc</strong>: nếu vẫn c&ograve;n lưu luyến vẻ đẹp bất tận của những đồi c&aacute;t th&igrave; bạn h&atilde;y d&agrave;nh thời gian kh&aacute;m ph&aacute; b&atilde;i c&aacute;t sa mạc tại Cổ Thạch, tham gia c&aacute;c tr&ograve; chơi trượt c&aacute;t th&uacute; vị.</p>\r\n\r\n<p><strong>Lăng &Ocirc;ng Nam Hải</strong>: truyền thống thờ c&aacute; &Ocirc;ng được h&igrave;nh th&agrave;nh v&agrave; lưu truyền qua nhiều thế hệ tại c&aacute;c l&agrave;ng ch&agrave;i Việt Nam. Tại Cổ Thạch, để ghi nhớ c&ocirc;ng ơn cứu mạng, dẫn đường của lo&agrave;i c&aacute; linh thi&ecirc;ng n&agrave;y, người d&acirc;n đ&atilde; lập n&ecirc;n lăng &Ocirc;ng Nam Hải v&agrave; thờ phụng cho đến ng&agrave;y nay. H&agrave;ng năm, tại đ&acirc;y đều diễn ra lễ hội lăng &Ocirc;ng, được tổ chức v&agrave;o ng&agrave;y 6 th&aacute;ng 6 &Acirc;m lịch.</p>\r\n\r\n<p><strong>Tắm b&ugrave;n kho&aacute;ng Vĩnh Hảo</strong>: c&oacute; lẽ bạn từng nghe qua nước kho&aacute;ng Vĩnh Hảo phải kh&ocirc;ng? Nguồn gốc của n&oacute; xuất ph&aacute;t từ suối kho&aacute;ng tại x&atilde; Vĩnh Hải, huyện Tuy Phong n&agrave;y đ&acirc;y. Khu vực tắm b&ugrave;n kho&aacute;ng được trang bị kh&aacute; khang trang, hiện đại. Bạn c&oacute; thể thoải m&aacute;i tắm b&ugrave;n, thư gi&atilde;n cơ thể, t&aacute;i tạo phục hồi da.</p>\r\n\r\n<p><img alt=\"Tắm bùn tại suối khoáng Vĩnh Hảo\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-16-1024x683.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>Dịch vụ tắm b&ugrave;n kho&aacute;ng tại suối kho&aacute;ng Vĩnh Hảo @internet</p>\r\n\r\n<h2 dir=\"auto\">9. Trường Dục Thanh</h2>\r\n\r\n<p>Đ&acirc;y l&agrave; một địa điểm du lịch Mũi N&eacute; mang đậm dấu ấn lịch sử. Tại ng&ocirc;i trường n&agrave;y, v&agrave;o năm 1910, thanh ni&ecirc;n Nguyễn Tất Th&agrave;nh l&uacute;c bấy giờ l&agrave; một gi&aacute;o vi&ecirc;n vừa dạy học, vừa truyền b&aacute; tinh thần y&ecirc;u nước.</p>\r\n\r\n<p><img alt=\"Cổng trường Dục Thanh\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-17.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>Cổng trường Dục Thanh @internet</p>\r\n\r\n<p>Theo thời gian, từng gian ph&ograve;ng, nếp nh&agrave;, b&agrave;n ghế, ly uống nước&hellip; đều được bảo quản v&agrave; giữ g&igrave;n tốt. Đến tham quan nơi đ&acirc;y, bạn như quay ngược thời gian về qu&aacute; khứ với căn ph&ograve;ng v&aacute;ch gỗ, d&atilde;y b&agrave;n học cũ sờn hay khung cảnh vườn trường xanh mướt.</p>\r\n\r\n<p><img alt=\"Bên trong Trường Dục Thanh\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-18-1024x767.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>Quang cảnh b&ecirc;n trong trường @internet</p>\r\n\r\n<p>Ng&ocirc;i trường tọa lạc tại số 39 đường Trưng Nhị, P. Đức Nghĩa, Phan Thiết.</p>\r\n\r\n<h2 dir=\"auto\">10. L&acirc;u đ&agrave;i rượu vang</h2>\r\n\r\n<p>Chuyển tiếp cuộc h&agrave;nh tr&igrave;nh kh&aacute;m ph&aacute; c&aacute;c địa điểm tham quan hấp dẫn tại Mũi N&eacute;, ch&uacute;ng ta h&atilde;y c&ugrave;ng kh&aacute;m ph&aacute; l&acirc;u đ&agrave;i rượu vang mang đậm n&eacute;t ch&acirc;u &Acirc;u tại khu nghỉ dưỡng đẳng cấp Links City.</p>\r\n\r\n<p><img alt=\"Lâu đài rượu vang tại Mũi Né\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-19.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>Chẳng cần đi ch&acirc;u &Acirc;u, bạn vẫn c&oacute; thể chi&ecirc;m ngưỡng trang trại nho v&agrave; hầm rượu vang tại Việt Nam</p>\r\n\r\n<p>Khu vực c&oacute; tổng diện t&iacute;ch l&ecirc;n đến 12,000 ha, nổi bật nhất l&agrave; t&ograve;a l&acirc;u đ&agrave;i nguy nga, tr&aacute;ng lệ được lấy cảm hứng từ thung lũng rượu vang nổi tiếng thế giới: Napa thuộc tiểu bang California của nước Mỹ.</p>\r\n\r\n<p><img alt=\"Lâu đài rượu vang nhìn từ trên cao\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-20.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>G&oacute;c nh&igrave;n to&agrave;n cảnh l&acirc;u đ&agrave;i v&agrave; s&acirc;n vườn từ tr&ecirc;n cao @internet</p>\r\n\r\n<p>L&acirc;u đ&agrave;i c&oacute; tổng cộng 3 tầng: 1 hầm, 1 trệt, 1 lầu với c&ocirc;ng năng ri&ecirc;ng biệt. Bạn sẽ được t&igrave;m hiểu c&aacute;c c&ocirc;ng đoạn chế biến, đ&oacute;ng chai rượu vang v&agrave; tất nhi&ecirc;n l&agrave; thưởng thức những ngụm rượu vang hảo hạng nữa.</p>\r\n\r\n<p><img alt=\"Khung cảnh dưới hầm rượu\" src=\"https://ik.imagekit.io/tvlk/blog/2022/03/dia-diem-du-lich-mui-ne-21.jpg?tr=dpr-2,w-675\" /></p>\r\n\r\n<p>Khung cảnh huyền ảo b&ecirc;n dưới hầm rượu @internet</p>\r\n\r\n<h2 dir=\"auto\">B&iacute; quyết di chuyển đến thi&ecirc;n đường biển Mũi N&eacute;</h2>\r\n\r\n<p>Muốn kh&aacute;m ph&aacute; vẻ đẹp hoang sơ v&agrave; kh&ocirc;ng gian tĩnh lặng của Mũi N&eacute; - điểm đến hấp dẫn ở miền Nam Việt Nam, việc lựa chọn phương tiện di chuyển đ&uacute;ng đắn l&agrave; một phần kh&ocirc;ng thể thiếu của kế hoạch du lịch của bạn. V&agrave; giữa những phương tiện kh&aacute;c nhau, việc di chuyển bằng m&aacute;y bay kh&ocirc;ng chỉ tiết kiệm thời gian m&agrave; c&ograve;n mang lại trải nghiệm thoải m&aacute;i v&agrave; tiện lợi.</p>', 'top 10 du lich mũi né', 1, 'Top-10-đia-điem-du-lich-Mui-Ne-đac-sac-đe-kham-pha', '1732287578.jpg', '2024-11-06 00:16:47', '2024-11-22 07:59:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotions`
--

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE IF NOT EXISTS `promotions` (
  `promotion_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `promotion_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_amount` double NOT NULL,
  `pro_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `pro_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`promotion_id`)
) ENGINE=MyISAM AUTO_INCREMENT=181 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `promotions`
--

INSERT INTO `promotions` (`promotion_id`, `promotion_code`, `discount_amount`, `pro_description`, `start_date`, `end_date`, `created_at`, `updated_at`, `pro_title`) VALUES
(175, 'HAPPY2025GO', 10, 'Ưu đãi lớn nhất chào đón năm mới, chỉ trong tháng 1.', '2024-12-04', '2024-12-05', '2024-11-19 06:21:32', '2024-11-19 06:21:32', 'Chào năm mới 2025 Giảm ngay 1.000.000'),
(137, 'VOUCHER005', 5, '12313313', '2024-11-19', '2024-11-20', '2024-10-25 20:29:25', '2024-11-19 05:55:43', 'Ưu đãi siêu hot Sử dụng mã giảm giá hotel hè'),
(173, 'SALE2023CD67', 8, 'Dành riêng cho khách hàng đặt phòng lần đầu trên hệ thống.', '2024-11-22', '2024-11-23', '2024-11-19 06:19:31', '2024-11-19 06:25:37', 'Chào mừng khách hàng mới - Giảm 500k'),
(174, 'HOLIDAY600XY', 6, 'Ưu đãi đặc biệt trong dịp lễ, không giới hạn khách sạn', '2024-11-28', '2024-11-30', '2024-11-19 06:20:26', '2024-11-19 06:20:26', 'Giảm 600k dịp lễ hội du lịch cho gia đình'),
(172, 'PROMO12345AB', 10, 'Voucher áp dụng cho tất cả sản phẩm, không giới hạn số lần sử dụng', '2024-11-19', '2024-11-20', '2024-11-19 06:18:50', '2024-11-19 06:18:50', 'Ưu đãi tháng 11 Giảm 50k cho đơn hàng từ 500k'),
(176, 'YEAREND800XZ', 8, 'Giảm giá cực sốc, áp dụng cho tất cả sản phẩm cuối năm.', '2024-11-19', '2024-11-30', '2024-11-19 06:22:16', '2024-11-19 06:22:16', 'Ưu đãi độc quyền cuối năm - Giảm ngay 800k'),
(177, 'XMAS25MNAS', 10, 'Món quà đặc biệt từ chúng tôi dành cho bạn trong mùa lễ.', '2024-12-20', '2024-12-25', '2024-11-19 06:23:12', '2024-11-19 06:23:12', 'Giảm 25% mùa Giáng Sinh - Tưng bừng lễ hội'),
(180, 'HOTSUMMER120', 30, 'Ưu đãi tháng 12 hot Ưu đãi tháng 12 hot Ưu đãi tháng 12 hot Ưu đãi tháng 12 hot Ưu đãi tháng 12 hot Ưu đãi tháng 12 hot Ưu đãi tháng 12 hot', '2024-11-29', '2024-11-30', '2024-11-27 17:42:45', '2024-11-27 17:42:45', 'Ưu đãi tháng 12 hot 12313 1231313'),
(179, 'MOMO12312313i', 10, 'KOÁOKDOAKDOKDOSKADOKDOKSAODKA KDOSAODASODK ODK d', '2024-11-19', '2024-11-21', '2024-11-20 03:21:10', '2024-11-20 03:21:10', 'Ưu đãi tháng 12 hot Ưu đãi tháng 12 hot Ưu đãi tháng 12 hot Ưu đãi tháng 12 hot Ưu đãi tháng 12 hot');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `review_id` int NOT NULL AUTO_INCREMENT,
  `hotel_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` decimal(8,2) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`review_id`),
  KEY `reviews_hotel_id_foreign` (`hotel_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`review_id`, `hotel_id`, `user_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(26, 3, 40, '5.00', 'Fantastic stay! I loved everything about this hotel.', NULL, NULL),
(27, 4, 40, '1.00', 'Terrible experience. I will not return.', NULL, NULL),
(28, 4, 40, '4.00', 'Nice place but a bit noisy at night.', NULL, NULL),
(29, 5, 40, '3.00', 'Good for a quick stay, but I expected more amenities.', NULL, NULL),
(30, 5, 40, '5.00', 'I had a wonderful time! Highly recommend this hotel.', NULL, NULL),
(31, 2, 39, '1.00', 'Khách sạn này đẹp quá 😍', '2024-11-16 10:39:21', '2024-11-16 10:39:21'),
(39, 2, 40, '5.00', '🎉', '2024-11-29 19:24:52', '2024-11-29 19:24:52'),
(36, 2, 41, '4.00', 'NICe 😂', '2024-11-22 18:29:27', '2024-11-22 18:29:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `review_images`
--

DROP TABLE IF EXISTS `review_images`;
CREATE TABLE IF NOT EXISTS `review_images` (
  `image_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `review_id` int NOT NULL,
  `image_url` char(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `review_images`
--

INSERT INTO `review_images` (`image_id`, `review_id`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 1, 'review1_image1.jpg', NULL, NULL),
(2, 1, 'review1_image2.jpg', NULL, NULL),
(3, 2, 'review2_image1.jpg', NULL, NULL),
(4, 2, 'review2_image2.jpg', NULL, NULL),
(5, 3, 'review3_image1.jpg', NULL, NULL),
(6, 4, 'review4_image1.jpg', NULL, NULL),
(7, 4, 'review4_image2.jpg', NULL, NULL),
(8, 5, 'review5_image1.jpg', NULL, NULL),
(9, 5, 'review5_image2.jpg', NULL, NULL),
(10, 6, 'review6_image1.jpg', NULL, NULL),
(11, 31, 'review_images/TuU7o89tGc_1731778761.jpg', '2024-11-16 10:39:21', '2024-11-16 10:39:21'),
(12, 32, 'review_images/0FEPOfy7m2_1731779322.jpg', '2024-11-16 10:48:42', '2024-11-16 10:48:42'),
(13, 32, 'review_images/Zphv6HVeoE_1731779322.jpg', '2024-11-16 10:48:42', '2024-11-16 10:48:42'),
(14, 32, 'review_images/UhQddwcEf6_1731779322.jpg', '2024-11-16 10:48:42', '2024-11-16 10:48:42'),
(15, 33, 'review_images/C0fqJFwWkE_1731779453.jpg', '2024-11-16 10:50:53', '2024-11-16 10:50:53'),
(16, 33, 'review_images/lPgeM0DHpp_1731779453.jpg', '2024-11-16 10:50:53', '2024-11-16 10:50:53'),
(17, 37, 'review_images/Yy3grL9bJl_1732900795.jpg', '2024-11-29 10:19:55', '2024-11-29 10:19:55'),
(18, 38, 'review_images/mHFojYXpvY_1732933241.png', '2024-11-29 19:20:41', '2024-11-29 19:20:41'),
(19, 38, 'review_images/kgn2o81YYF_1732933241.png', '2024-11-29 19:20:41', '2024-11-29 19:20:41'),
(20, 38, 'review_images/OyrtYAh8Yw_1732933241.jpg', '2024-11-29 19:20:41', '2024-11-29 19:20:41'),
(21, 38, 'review_images/pRc4JbPH1i_1732933241.jpg', '2024-11-29 19:20:41', '2024-11-29 19:20:41'),
(22, 38, 'review_images/zmo4MJzXtV_1732933241.jpg', '2024-11-29 19:20:41', '2024-11-29 19:20:41'),
(23, 38, 'review_images/fZOm3aZvt8_1732933241.jpg', '2024-11-29 19:20:41', '2024-11-29 19:20:41'),
(24, 38, 'review_images/j7HYTMbyia_1732933241.jpg', '2024-11-29 19:20:41', '2024-11-29 19:20:41'),
(25, 38, 'review_images/a2kANbQ75K_1732933241.jpg', '2024-11-29 19:20:41', '2024-11-29 19:20:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `review_likes`
--

DROP TABLE IF EXISTS `review_likes`;
CREATE TABLE IF NOT EXISTS `review_likes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `review_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `review_likes_review_id_user_id_unique` (`review_id`,`user_id`),
  KEY `review_likes_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `review_likes`
--

INSERT INTO `review_likes` (`id`, `review_id`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 31, 39, '2024-11-16 10:39:53', '2024-11-16 10:39:53'),
(14, 36, 41, '2024-11-27 17:36:19', '2024-11-27 17:36:19'),
(7, 32, 40, '2024-11-16 10:49:52', '2024-11-16 10:49:52'),
(10, 33, 40, '2024-11-16 22:38:12', '2024-11-16 22:38:12'),
(15, 35, 41, '2024-11-27 17:36:20', '2024-11-27 17:36:20'),
(16, 31, 41, '2024-11-27 17:36:21', '2024-11-27 17:36:21'),
(24, 37, 40, '2024-11-29 19:14:35', '2024-11-29 19:14:35'),
(25, 36, 40, '2024-11-29 19:14:35', '2024-11-29 19:14:35'),
(27, 39, 40, '2024-11-29 19:24:58', '2024-11-29 19:24:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `room_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `hotel_id` int NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `discount_percent` int NOT NULL,
  `capacity` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_type_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`room_id`, `hotel_id`, `name`, `price`, `discount_percent`, `capacity`, `description`, `room_type_id`, `created_at`, `updated_at`) VALUES
(1, 4, 'Phòng LabuRa Hải Âu 1', 15000000, 10, 2, '<p>Ph&ograve;ng Deluxe với tầm nh&igrave;n ra biển tại Đ&agrave; Nẵng.</p>', 1, NULL, '2024-11-22 02:25:35'),
(2, 8, 'Phòng LabuRa Hải Âu 2', 960000, 5, 3, '<p>Khu nghỉ dưỡng ven biển với khung cảnh thơ mộng, nổi bật với thiết kế h&ograve;a quyện giữa hiện đại v&agrave; thi&ecirc;n nhi&ecirc;n. Du kh&aacute;ch c&oacute; thể tận hưởng l&agrave;n gi&oacute; biển m&aacute;t l&agrave;nh ngay từ ban c&ocirc;ng ph&ograve;ng m&igrave;nh, tham gia c&aacute;c hoạt động thể thao dưới nước, hoặc thư gi&atilde;n tại hồ bơi v&ocirc; cực hướng biển. Nh&agrave; h&agrave;ng của resort phục vụ c&aacute;c m&oacute;n hải sản tươi sống, được chế biến bởi đầu bếp h&agrave;ng đầu.</p>', 1, NULL, '2024-11-22 18:16:16'),
(3, 9, 'Mountain View Retreat', 2008960, 10, 4, '<p>Ph&ograve;ng gia đ&igrave;nh c&oacute; hai giường tại H&agrave; Nội.Nằm ẩn m&igrave;nh giữa rừng n&uacute;i xanh m&aacute;t, kh&aacute;ch sạn l&agrave; nơi ho&agrave;n hảo để tho&aacute;t khỏi sự ồn &agrave;o của cuộc sống thường nhật. C&aacute;c ph&ograve;ng nghỉ được thiết kế với phong c&aacute;ch gần gũi, sử dụng vật liệu gỗ tự nhi&ecirc;n để tạo sự ấm &aacute;p. Du kh&aacute;ch c&oacute; thể thưởng ngoạn cảnh n&uacute;i non h&ugrave;ng vĩ, đi bộ đường m&ograve;n, hoặc tham gia c&aacute;c buổi yoga buổi s&aacute;ng để t&aacute;i tạo năng lượng.</p>', 1, NULL, '2024-11-22 18:16:56'),
(5, 22, 'Phòng ấm cúng Hồ Chí Minh', 1200000, 10, 5, '<p>Kh&aacute;ch sạn 5 sao với kiến tr&uacute;c sang trọng, nội thất được chăm ch&uacute;t từng chi tiết. Nằm tại khu vực s&ocirc;i động của th&agrave;nh phố, Golden Palm Hotel mang đến trải nghiệm đẳng cấp với c&aacute;c ph&ograve;ng hội nghị, nh&agrave; h&agrave;ng quốc tế, v&agrave; quầy bar phục vụ cocktail đ&ecirc;m. Đ&acirc;y l&agrave; sự lựa chọn ho&agrave;n hảo cho cả doanh nh&acirc;n v&agrave; du kh&aacute;ch t&igrave;m kiếm sự tiện nghi v&agrave; phong c&aacute;ch.</p>', 3, NULL, '2024-11-29 11:05:09'),
(6, 22, 'Phòng Superior Hồ Chí Minh', 1800000, 25, 3, '<p>Ph&ograve;ng Superior với ban c&ocirc;ng tại Hồ Ch&iacute; Minh.</p>', 1, NULL, '2024-11-29 11:05:09'),
(7, 1, 'Phòng Penthouse Nha Trang', 220, 30, 2, '<p>Ph&ograve;ng Penthouse với tầm nh&igrave;n to&agrave;n cảnh tại Nha Trang.</p>', 1, NULL, '2024-11-22 18:34:47'),
(8, 21, 'Phòng kinh tế Nha Trang', 140, 5, 4, '<p>Ph&ograve;ng kinh tế d&agrave;nh cho kh&aacute;ch du lịch tại Nha Trang.</p>', 1, NULL, '2024-11-29 11:01:56'),
(9, 8, 'Phòng hiện đại Đà Lạt', 175000000, 15, 3, '<p>Ph&ograve;ng hiện đại c&oacute; Wi-Fi miễn ph&iacute; tại Đ&agrave; Lạt.</p>', 2, NULL, '2024-11-22 18:16:16'),
(10, 5, 'Phòng Executive Đà Lạt', 210, 20, 2, '<p>Ph&ograve;ng Executive c&oacute; kh&ocirc;ng gian l&agrave;m việc tại Đ&agrave; Lạt.</p>', 2, NULL, '2024-11-11 09:17:11'),
(12, 21, 'The Serenity Hotel', 800000, 2, 3, '<p>Kh&aacute;ch sạn nằm ngay trung t&acirc;m th&agrave;nh phố với thiết kế hiện đại v&agrave; phong c&aacute;ch tối giản. Với c&aacute;c ph&ograve;ng nghỉ rộng r&atilde;i, được trang bị đầy đủ tiện nghi cao cấp, kh&aacute;ch sạn mang đến kh&ocirc;ng gian y&ecirc;n b&igrave;nh giữa l&ograve;ng đ&ocirc; thị sầm uất. Đặc biệt, khu spa v&agrave; nh&agrave; h&agrave;ng tầng thượng l&agrave; điểm nhấn cho những du kh&aacute;ch muốn tận hưởng kỳ nghỉ thư gi&atilde;n v&agrave; ẩm thực đặc sắc.</p>', 5, '2024-10-23 19:50:22', '2024-11-29 11:01:56'),
(15, 1, 'Beachfront Bungalow', 12331111, 11, 2, '<p>Bungalow nằm s&aacute;t b&atilde;i biển, được x&acirc;y dựng theo phong c&aacute;ch nhiệt đới với m&aacute;i l&aacute; truyền thống, c&oacute; s&acirc;n hi&ecirc;n ri&ecirc;ng v&agrave; ghế thư gi&atilde;n.</p>', 1, '2024-11-06 19:04:39', '2024-11-22 18:34:47'),
(16, 21, 'Deluxe Garden Room', 11112223, 12, 20, '<p>Ph&ograve;ng hướng vườn với kh&ocirc;ng gian y&ecirc;n tĩnh, nội thất gỗ tự nhi&ecirc;n, trang bị giường cỡ lớn, tivi m&agrave;n h&igrave;nh phẳng v&agrave; ph&ograve;ng tắm hiện đại.</p>', 1, '2024-11-10 00:17:08', '2024-11-29 11:01:56'),
(19, 0, 'Family Suite', 213213, 10, 2, '<p>Ph&ograve;ng d&agrave;nh cho gia đ&igrave;nh với diện t&iacute;ch rộng, 2 ph&ograve;ng ngủ ri&ecirc;ng biệt, khu vực bếp mini v&agrave; ban c&ocirc;ng rộng nh&igrave;n ra vườn hoặc biển.</p>', 1, '2024-11-20 03:05:17', '2024-11-21 09:02:56'),
(20, 9, 'Aniise Villa Resort', 500000, 10, 3, '<p>Biệt thự sang trọng nằm s&aacute;t biển, được thiết kế với phong c&aacute;ch hiện đại, c&oacute; ban c&ocirc;ng ri&ecirc;ng v&agrave; khu vực tiếp kh&aacute;ch. Ph&ograve;ng th&iacute;ch hợp cho những ai muốn tận hưởng cảnh b&igrave;nh minh tr&ecirc;n biển mỗi s&aacute;ng.</p>', 2, '2024-11-21 08:21:46', '2024-11-22 18:16:56'),
(21, 2, 'Beachfront Bungalow', 600000, 5, 5, '<p>Bungalow nằm s&aacute;t b&atilde;i biển, được x&acirc;y dựng theo phong c&aacute;ch nhiệt đới với m&aacute;i l&aacute; truyền thống, c&oacute; s&acirc;n hi&ecirc;n ri&ecirc;ng v&agrave; ghế thư gi&atilde;n.</p>', 3, '2024-11-21 08:35:29', '2024-11-22 19:25:03'),
(22, 21, 'Superior Double Room', 800000, 6, 3, '<p>Ph&ograve;ng ti&ecirc;u chuẩn với giường đ&ocirc;i thoải m&aacute;i, ph&ugrave; hợp cho c&aacute;c cặp đ&ocirc;i hoặc du kh&aacute;ch đi c&ocirc;ng t&aacute;c. C&oacute; cửa sổ lớn đ&oacute;n &aacute;nh s&aacute;ng tự nhi&ecirc;n.</p>', 4, '2024-11-21 08:36:42', '2024-11-29 11:01:56'),
(23, 22, 'Panorama Sea View', 1200000, 10, 6, '<p>Ph&ograve;ng c&oacute; cửa k&iacute;nh lớn từ trần đến s&agrave;n, mang đến tầm nh&igrave;n to&agrave;n cảnh biển Ninh Chữ tuyệt đẹp. Nội thất sang trọng v&agrave; kh&ocirc;ng gian tho&aacute;ng đ&atilde;ng l&agrave; điểm nhấn.</p>', 1, '2024-11-21 08:37:42', '2024-11-29 11:05:09'),
(24, 2, 'Standard Twin Room', 1500000, 8, 3, '<ul>\r\n	<li>\r\n	<p>Ph&ograve;ng ti&ecirc;u chuẩn với 2 giường đơn, thiết kế tối giản nhưng kh&ocirc;ng k&eacute;m phần thoải m&aacute;i. Ph&ugrave; hợp cho bạn b&egrave; hoặc đồng nghiệp đi du lịch c&ugrave;ng nhau.</p>\r\n	</li>\r\n</ul>', 5, '2024-11-21 08:38:29', '2024-11-22 19:25:03'),
(25, 2, 'Honeymoon Suite', 1800000, 20, 4, '<p>Ph&ograve;ng được thiết kế l&atilde;ng mạn với &aacute;nh s&aacute;ng dịu nhẹ, giường cỡ lớn trang tr&iacute; hoa tươi v&agrave; bồn tắm ri&ecirc;ng c&oacute; view hướng biển. Ho&agrave;n hảo cho c&aacute;c cặp đ&ocirc;i mới cưới.</p>', 4, '2024-11-21 08:40:44', '2024-11-22 19:25:03'),
(26, 22, 'Mountain Retreat Room', 900000, 0, 2, '<p>Ph&ograve;ng thiết kế theo phong c&aacute;ch tối giản, c&oacute; cửa sổ lớn nh&igrave;n ra d&atilde;y n&uacute;i N&uacute;i Ch&uacute;a. Nội thất chủ yếu sử dụng vật liệu từ tre v&agrave; gỗ t&aacute;i chế.</p>', 1, '2024-11-21 08:45:02', '2024-11-29 11:05:09'),
(32, 3, 'Deluxe Ocean View Room', 800000, 2, 3, '<p>Ph&ograve;ng rộng r&atilde;i với ban c&ocirc;ng hướng biển, được trang bị giường king-size, bồn tắm hiện đại, v&agrave; khu vực l&agrave;m việc ri&ecirc;ng.Ph&ograve;ng rộng r&atilde;i với ban c&ocirc;ng hướng biển, được trang bị giường king-size, bồn tắm hiện đại, v&agrave; khu vực l&agrave;m việc ri&ecirc;ng.</p>', 6, '2024-11-22 19:18:18', '2024-11-22 19:23:15'),
(33, 3, 'Executive Suite', 560000, 2, 3, '<p>Suite sang trọng với kh&ocirc;ng gian ph&ograve;ng kh&aacute;ch ri&ecirc;ng, ph&ograve;ng ngủ lớn v&agrave; ph&ograve;ng tắm tiện nghi. Đ&acirc;y l&agrave; lựa chọn ho&agrave;n hảo cho những chuyến c&ocirc;ng t&aacute;c d&agrave;i ng&agrave;y.Suite sang trọng với kh&ocirc;ng gian ph&ograve;ng kh&aacute;ch ri&ecirc;ng, ph&ograve;ng ngủ lớn v&agrave; ph&ograve;ng tắm tiện nghi. Đ&acirc;y l&agrave; lựa chọn ho&agrave;n hảo cho những chuyến c&ocirc;ng t&aacute;c d&agrave;i ng&agrave;y.</p>', 2, '2024-11-22 19:18:51', '2024-11-22 19:23:15'),
(34, 3, 'Family Connecting Room', 7800000, 5, 6, '<p>Ph&ograve;ng l&yacute; tưởng cho gia đ&igrave;nh với hai kh&ocirc;ng gian ngủ ri&ecirc;ng biệt, được kết nối qua cửa th&ocirc;ng nhau.Ph&ograve;ng cao cấp với lối đi trực tiếp ra hồ bơi, trang bị nội thất sang trọng v&agrave; đầy đủ tiện nghi.</p>', 4, '2024-11-22 19:19:38', '2024-11-29 11:14:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_amenities`
--

DROP TABLE IF EXISTS `room_amenities`;
CREATE TABLE IF NOT EXISTS `room_amenities` (
  `amenity_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `amenity_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`amenity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `room_amenities`
--

INSERT INTO `room_amenities` (`amenity_id`, `amenity_name`, `description`) VALUES
(1, 'Điều Hòa', 'Hệ thống điều hòa không khí mát mẻ và thoải mái.'),
(2, 'WiFi Miễn Phí', 'Truy cập internet không dây tốc độ cao.'),
(3, 'Truyền Hình', 'TV màn hình phẳng với các kênh cáp.'),
(4, 'Minibar', 'Minibar được cung cấp đầy đủ đồ ăn nhẹ và đồ uống.'),
(5, 'Dịch Vụ Phòng', 'Dịch vụ phòng 24 giờ có sẵn.'),
(6, 'Bao Gồm Bữa Sáng', 'Bữa sáng miễn phí được bao gồm trong thời gian lưu trú.'),
(7, 'Truy Cập Phòng Tập', 'Truy cập vào trung tâm thể dục trong suốt thời gian lưu trú.'),
(8, 'Hồ Bơi', 'Truy cập vào hồ bơi ngoài trời.'),
(9, 'Dịch Vụ Giặt Là', 'Dịch vụ giặt là có sẵn theo yêu cầu.'),
(10, 'Đỗ Xe', 'Đỗ xe miễn phí cho khách.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_amenity_room`
--

DROP TABLE IF EXISTS `room_amenity_room`;
CREATE TABLE IF NOT EXISTS `room_amenity_room` (
  `room_id` int UNSIGNED NOT NULL,
  `amenity_id` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `room_amenity_room`
--

INSERT INTO `room_amenity_room` (`room_id`, `amenity_id`) VALUES
(1, 3),
(1, 2),
(1, 1),
(2, 4),
(2, 1),
(3, 3),
(3, 2),
(34, 5),
(32, 3),
(5, 5),
(12, 9),
(12, 8),
(12, 7),
(12, 2),
(15, 4),
(19, 3),
(15, 3),
(16, 4),
(16, 3),
(16, 1),
(7, 2),
(7, 10),
(8, 1),
(8, 3),
(8, 4),
(9, 1),
(9, 3),
(10, 1),
(10, 4),
(6, 3),
(6, 2),
(19, 2),
(20, 1),
(20, 3),
(20, 9),
(21, 1),
(21, 2),
(21, 3),
(22, 2),
(22, 3),
(22, 4),
(23, 6),
(23, 9),
(23, 10),
(24, 1),
(24, 3),
(24, 4),
(25, 1),
(25, 2),
(25, 3),
(25, 9),
(25, 10),
(26, 4),
(26, 5),
(26, 6),
(26, 7),
(26, 9),
(26, 10),
(33, 5),
(33, 3),
(33, 2),
(33, 1),
(32, 2),
(32, 1),
(34, 4),
(34, 3),
(34, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_images`
--

DROP TABLE IF EXISTS `room_images`;
CREATE TABLE IF NOT EXISTS `room_images` (
  `image_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_id` int NOT NULL,
  `image_url` char(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploaded_at` datetime NOT NULL,
  PRIMARY KEY (`image_id`),
  KEY `room_images_room_id_foreign` (`room_id`)
) ENGINE=MyISAM AUTO_INCREMENT=210 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `room_images`
--

INSERT INTO `room_images` (`image_id`, `room_id`, `image_url`, `uploaded_at`) VALUES
(177, 1, '1732266786_535569598.jpg', '2024-11-22 09:13:06'),
(176, 1, '1732266786_78667432.jpg', '2024-11-22 09:13:06'),
(3, 2, 'room2_image3.jpg', '2024-10-24 02:06:03'),
(4, 2, 'room2_image4.jpg', '2024-10-24 02:06:03'),
(5, 3, 'room3_image5.jpg', '2024-10-24 02:06:03'),
(6, 3, 'room3_image6.jpg', '2024-10-24 02:06:03'),
(190, 3, '1732324362_r-pt-5.jpg', '2024-11-23 01:12:42'),
(189, 3, '1732324362_r-pt-4.jpg', '2024-11-23 01:12:42'),
(23, 5, '1729787401_au-lac-charner-hotel.jpg', '2024-10-24 16:30:01'),
(83, 20, '1732202506_khach-san-binh-thuan-gan-bien-1.jpg', '2024-11-21 15:21:46'),
(15, 12, '1729759318_au-lac-charner-hotel.jpg', '2024-10-24 08:41:58'),
(14, 12, '1729759318_535569598.jpg', '2024-10-24 08:41:58'),
(16, 12, '1729759318_images.jpg', '2024-10-24 08:41:58'),
(17, 12, '1729759318_vanda-hotel-family-junior-suite1.jpg', '2024-10-24 08:41:58'),
(188, 3, '1732324362_r-pt-3.jpg', '2024-11-23 01:12:42'),
(82, 20, '1732202506_cmv-welcom-center_interior-12.jpg', '2024-11-21 15:21:46'),
(81, 20, '1732202506_Binh-Thuan-6.jpg', '2024-11-21 15:21:46'),
(80, 19, '1732097117_images.jpg', '2024-11-20 10:05:17'),
(34, 15, '1730945079_78667432.jpg', '2024-11-07 02:04:39'),
(35, 15, '1730945079_535569598.jpg', '2024-11-07 02:04:39'),
(92, 21, '1732203329_img1088.jpg', '2024-11-21 15:35:29'),
(91, 16, '1732202992_khach-san-binh-thuan-gan-bien-1.jpg', '2024-11-21 15:29:52'),
(90, 16, '1732202992_cmv-welcom-center_interior-12.jpg', '2024-11-21 15:29:52'),
(39, 7, '1731341746_khach-san-Ha-Noi-ivivu-2.jpg', '2024-11-11 16:15:46'),
(40, 7, '1731341746_room10.jpg', '2024-11-11 16:15:46'),
(41, 7, '1731341746_room11.jpg', '2024-11-11 16:15:46'),
(42, 7, '1731341746_room12.jpg', '2024-11-11 16:15:46'),
(43, 8, '1731341781_78667432.jpg', '2024-11-11 16:16:21'),
(44, 8, '1731341781_535569598.jpg', '2024-11-11 16:16:21'),
(45, 8, '1731341781_images.jpg', '2024-11-11 16:16:21'),
(46, 8, '1731341781_room11.jpg', '2024-11-11 16:16:21'),
(47, 8, '1731341781_room12.jpg', '2024-11-11 16:16:21'),
(48, 8, '1731341781_room13.jpg', '2024-11-11 16:16:21'),
(49, 9, '1731341805_78667432.jpg', '2024-11-11 16:16:45'),
(50, 9, '1731341805_535569598.jpg', '2024-11-11 16:16:45'),
(51, 9, '1731341805_khach-san-Ha-Noi-ivivu-2.jpg', '2024-11-11 16:16:45'),
(52, 9, '1731341805_room10.jpg', '2024-11-11 16:16:45'),
(53, 9, '1731341805_room11.jpg', '2024-11-11 16:16:45'),
(54, 9, '1731341805_room13.jpg', '2024-11-11 16:16:45'),
(55, 9, '1731341805_vanda-hotel-family-junior-suite1.jpg', '2024-11-11 16:16:45'),
(56, 10, '1731341831_535569598.jpg', '2024-11-11 16:17:11'),
(57, 10, '1731341831_images.jpg', '2024-11-11 16:17:11'),
(58, 10, '1731341831_khach-san-Ha-Noi-ivivu-2.jpg', '2024-11-11 16:17:11'),
(59, 10, '1731341831_room10.jpg', '2024-11-11 16:17:11'),
(60, 10, '1731341831_room13.jpg', '2024-11-11 16:17:11'),
(79, 19, '1732097117_535569598.jpg', '2024-11-20 10:05:17'),
(78, 19, '1732097117_78667432.jpg', '2024-11-20 10:05:17'),
(67, 6, '1731341884_78667432.jpg', '2024-11-11 16:18:04'),
(68, 6, '1731341884_535569598.jpg', '2024-11-11 16:18:04'),
(69, 6, '1731341884_au-lac-charner-hotel.jpg', '2024-11-11 16:18:04'),
(70, 6, '1731341884_banner-showroom-vuoncayviet-mobile-7-7.jpg', '2024-11-11 16:18:04'),
(71, 6, '1731341884_khach-san-Ha-Noi-ivivu-2.jpg', '2024-11-11 16:18:04'),
(72, 6, '1731341884_room10.jpg', '2024-11-11 16:18:04'),
(73, 6, '1731341884_vanda-hotel-family-junior-suite1.jpg', '2024-11-11 16:18:04'),
(84, 20, '1732202506_khach-san-binh-thuan-the-cliff-resort-residences-1.jpg', '2024-11-21 15:21:46'),
(85, 20, '1732202506_Sea-Links-City-800x500.jpg', '2024-11-21 15:21:46'),
(93, 21, '1732203329_img1113.jpg', '2024-11-21 15:35:29'),
(94, 22, '1732203402_266335638.jpg', '2024-11-21 15:36:42'),
(95, 22, '1732203402_266335649.jpg', '2024-11-21 15:36:42'),
(96, 22, '1732203402_266335748.jpg', '2024-11-21 15:36:42'),
(97, 22, '1732203402_266335751.jpg', '2024-11-21 15:36:42'),
(98, 22, '1732203402_278471276.jpg', '2024-11-21 15:36:42'),
(99, 23, '1732203462_257917874.jpg', '2024-11-21 15:37:42'),
(100, 23, '1732203462_264144140.jpg', '2024-11-21 15:37:42'),
(101, 23, '1732203462_266337013.jpg', '2024-11-21 15:37:42'),
(102, 23, '1732203462_266337025.jpg', '2024-11-21 15:37:42'),
(103, 23, '1732203462_306045681.jpg', '2024-11-21 15:37:42'),
(104, 24, '1732203509_257128509.jpg', '2024-11-21 15:38:29'),
(105, 24, '1732203509_257964426.jpg', '2024-11-21 15:38:29'),
(106, 24, '1732203509_257966862.jpg', '2024-11-21 15:38:29'),
(107, 24, '1732203509_264144141.jpg', '2024-11-21 15:38:29'),
(108, 24, '1732203509_266337653.jpg', '2024-11-21 15:38:29'),
(109, 25, '1732203644_r-pt-1.jpg', '2024-11-21 15:40:44'),
(110, 25, '1732203644_r-pt-3.jpg', '2024-11-21 15:40:44'),
(111, 25, '1732203644_r-pt-4.jpg', '2024-11-21 15:40:44'),
(112, 25, '1732203644_r-pt-5.jpg', '2024-11-21 15:40:44'),
(113, 25, '1732203644_r-pt-6.jpg', '2024-11-21 15:40:44'),
(114, 26, '1732203902_266335638.jpg', '2024-11-21 15:45:02'),
(115, 26, '1732203902_266335649.jpg', '2024-11-21 15:45:02'),
(116, 26, '1732203902_266335748.jpg', '2024-11-21 15:45:02'),
(117, 26, '1732203902_266335751.jpg', '2024-11-21 15:45:02'),
(118, 26, '1732203902_278471276.jpg', '2024-11-21 15:45:02'),
(195, 32, '1732328298_133138862.jpg', '2024-11-23 02:18:18'),
(181, 1, '1732266786_room11.jpg', '2024-11-22 09:13:06'),
(194, 32, '1732328298_1331fc9cd2200b7e5231.jpg', '2024-11-23 02:18:18'),
(179, 1, '1732266786_khach-san-Ha-Noi-ivivu-2.jpg', '2024-11-22 09:13:06'),
(178, 1, '1732266786_images.jpg', '2024-11-22 09:13:06'),
(187, 3, '1732324362_r-pt-1.jpg', '2024-11-23 01:12:42'),
(180, 1, '1732266786_room10.jpg', '2024-11-22 09:13:06'),
(193, 32, '1732328298_6-Vip-Suite.jpg', '2024-11-23 02:18:18'),
(192, 32, '1732328298_6u7b2128_29_30_tonemapped(1).jpg', '2024-11-23 02:18:18'),
(191, 3, '1732324362_r-pt-6.jpg', '2024-11-23 01:12:42'),
(196, 33, '1732328331_133138862.jpg', '2024-11-23 02:18:51'),
(197, 33, '1732328331_45861472324_5298bd0d44_o.jpg', '2024-11-23 02:18:51'),
(198, 33, '1732328331_room-vip-scaled.jpg', '2024-11-23 02:18:51'),
(199, 33, '1732328331_Vip-room.jpg', '2024-11-23 02:18:51'),
(200, 34, '1732328378_bob-signature-vip-room-cao-lanh1-6609.jpg', '2024-11-23 02:19:38'),
(201, 34, '1732328378_IVORY-Suite-CK046r.jpg', '2024-11-23 02:19:38'),
(202, 34, '1732328378_mama-vip-room-1700.jpg', '2024-11-23 02:19:38'),
(203, 34, '1732328378_Phong-an-VIP-4-scaled.jpg', '2024-11-23 02:19:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_types`
--

DROP TABLE IF EXISTS `room_types`;
CREATE TABLE IF NOT EXISTS `room_types` (
  `room_type_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`room_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `room_types`
--

INSERT INTO `room_types` (`room_type_id`, `name`) VALUES
(1, 'Phòng Đơn'),
(2, 'Phòng Đôi'),
(3, 'Phòng Gia Đình'),
(4, 'Phòng Sang Trọng'),
(5, 'Phòng Superior'),
(6, 'Phòng Executive'),
(7, 'Phòng Deluxe'),
(8, 'Phòng Kinh Tế'),
(9, 'Phòng Cổ Điển'),
(10, 'Phòng Hiện Đại 2'),
(45, 'cvcvcvcvc');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('72Pm3YyWQjSwwD9c6I8ydZXZ63F3DKuI5QoQE5qt', 50, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoidlZITGVFOWI4bEZjVU9DOFVMcklHMkxZMUEwRVAyYkx2d1Z0QWFUaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjUwO3M6MTM6Im5vdGlmaWNhdGlvbnMiO2E6MDp7fXM6MTM6InJlY2VudF9ob3RlbHMiO2E6MTp7aTowO2k6MTt9fQ==', 1741771485);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `avatar` char(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `phone_number`, `role_id`, `status`, `avatar`, `created_at`, `updated_at`) VALUES
(47, '21211TT0527', 'tlich077@gmail.com', '$2y$12$8S8HW7jpisK2zuW7iB4tUu/7u3WRR1LKIfAp6lc44yKz0fvmPZXCq', '0987587459', 1, 1, '1732902675.jpg', '2024-11-27 17:39:40', '2024-11-29 10:51:15'),
(46, 'staynest3', 'st3@gmail.com', '$2y$12$v9i6yzMgS4rIdzhx/5MtduWrRnr2.iCV7EsAWeru5c4DOK9r4PJ8a', '0987452586', 2, 1, '1732902686.jpg', '2024-11-22 18:05:49', '2024-11-29 10:51:26'),
(45, 'staynest2', 'st2@gmail.com', '$2y$12$7KqZ/7SfhMYm/.7SQ7NGmuaGS2FX.zI0KjFfDefsYFvAsL28WiY/u', '0874587452', 2, 1, '1732902861.jpg', '2024-11-22 18:05:23', '2024-11-29 10:54:21'),
(44, 'staynest1', 'st@gmail.com', '$2y$12$n8hMIEfMNCGyNooH4ql7quYMAYPbgrO18qIZv6f8cB0qtp.eGIRdy', '0987542145', 2, 1, '1732902872.jpg', '2024-11-22 18:05:01', '2024-11-29 10:54:32'),
(9, 'lisa_williams', 'lisa@example.com', '$2y$12$zTVC4S0C5UXcGjvNnGVk4uQ/hCVWDFlWOLnjPk1EdoTDIyQGQBe5S', '0223344556', 1, 1, '1732902895.jpg', NULL, '2024-11-29 10:54:55'),
(48, 'vovanso', 'vovanso2004@gmail.com', '$2y$12$Cytet/BsZSaP2MfrEPIB0Ohvgef16/eIuTZ8oHil40OQ6j/.azUiy', '0942423640', 2, 1, '1740307478_banner-kho-lanh.png', '2025-02-23 03:42:38', '2025-02-23 03:44:38'),
(49, 'test123', 'test@gmail.com', '$2y$12$Vz9ek9zxDbIBRofb.BSVf.Tn38FopiBJMhfHNAB0dB8AIbwwKubdW', '0985632365', 2, 1, 'user-profile.png', '2025-03-08 09:15:46', '2025-03-08 09:15:46'),
(50, 'superadmin', 'admin@gmail.com', '$2y$12$lGXVJYPcZGy3K4RnKuzY5eIDUkArHa44lmQE8d4OjFRuxIOsT0i0K', '0956533256', 2, 1, '1741499786_baner-kho-lanh-3.png', '2025-03-08 22:55:04', '2025-03-08 22:56:26'),
(43, 'xinchao', 'xinaf@gmail.c', '$2y$12$kl4dmyr5ZaiAC2Km9z7Xx.sz2CBZAzl0Lz5oUv1We5R67ttS1/zpC', '0656898984', 2, 1, '1732902882.jpg', '2024-11-22 00:52:29', '2024-11-29 10:54:42'),
(39, 'vansoss', 'ad@gmail.com', '$2y$12$ZpTTIdTieqjxFNeJW4Nuou/9ymJCVpMgQdm2FYYJ3AKu1khOS8puW', '0125487541', 2, 1, '1731720095_user1.jpg', '2024-11-10 20:42:14', '2024-11-15 18:21:35'),
(40, 'admin', '22211tt3830@mail.tdc.edu.vn', '$2y$12$DplhaheZ1No4F3xIzSVoJukgsZRzBrbI4lov8djcrcssNDIaTlwsm', '0987587452', 1, 1, '1732116335_user2.jpg', '2024-11-16 10:42:34', '2024-11-29 10:38:25'),
(41, 'vo van so', '22211tt3830@mail.tdc.edu.vn', '$2y$12$8S8HW7jpisK2zuW7iB4tUu/7u3WRR1LKIfAp6lc44yKz0fvmPZXCq', '0978785412', 2, 1, '1732298834_user1.jpg', '2024-11-20 19:26:00', '2024-11-22 11:07:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `website_visits`
--

DROP TABLE IF EXISTS `website_visits`;
CREATE TABLE IF NOT EXISTS `website_visits` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `visit_date` date NOT NULL,
  `count` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `website_visits_visit_date_unique` (`visit_date`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `website_visits`
--

INSERT INTO `website_visits` (`id`, `visit_date`, `count`, `created_at`, `updated_at`) VALUES
(1, '2024-11-13', 2, NULL, NULL),
(2, '2024-11-04', 14, '2024-11-04 02:27:41', '2024-11-04 09:18:17'),
(3, '2024-11-05', 12, '2024-11-04 17:19:04', '2024-11-05 08:16:41'),
(4, '2024-11-06', 14, '2024-11-06 05:09:48', '2024-11-06 11:34:35'),
(5, '2024-11-07', 13, '2024-11-06 17:43:52', '2024-11-07 16:57:38'),
(6, '2024-11-08', 5, '2024-11-07 17:33:34', '2024-11-07 23:45:56'),
(7, '2024-11-09', 6, '2024-11-08 17:12:22', '2024-11-09 10:15:28'),
(8, '2024-11-10', 1, '2024-11-10 00:16:01', '2024-11-10 00:16:01'),
(9, '2024-11-11', 8, '2024-11-11 06:13:50', '2024-11-11 09:20:09'),
(10, '2024-11-12', 1, '2024-11-11 18:34:51', '2024-11-11 18:34:51'),
(11, '2024-11-14', 4, '2024-11-13 17:54:48', '2024-11-14 08:46:16'),
(12, '2024-11-19', 1, '2024-11-19 09:01:01', '2024-11-19 09:01:01'),
(13, '2024-11-20', 19, '2024-11-20 00:54:30', '2024-11-20 08:02:00'),
(14, '2024-11-21', 20, '2024-11-20 17:41:32', '2024-11-21 12:11:18'),
(15, '2024-11-22', 10, '2024-11-21 19:26:01', '2024-11-22 10:24:03'),
(16, '2024-11-23', 4, '2024-11-22 17:18:36', '2024-11-22 18:34:31'),
(17, '2024-11-28', 5, '2024-11-27 17:40:10', '2024-11-27 19:53:41'),
(18, '2024-11-29', 7, '2024-11-29 10:02:40', '2024-11-29 10:44:20'),
(19, '2024-11-30', 2, '2024-11-29 19:14:11', '2024-11-29 19:18:24');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts` ADD FULLTEXT KEY `posts_title_description_fulltext` (`title`,`description`);

--
-- Chỉ mục cho bảng `promotions`
--
ALTER TABLE `promotions` ADD FULLTEXT KEY `promotions_promotion_code_fulltext` (`promotion_code`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms` ADD FULLTEXT KEY `rooms_name_description_fulltext` (`name`,`description`);

--
-- Chỉ mục cho bảng `room_amenities`
--
ALTER TABLE `room_amenities` ADD FULLTEXT KEY `room_amenities_amenity_name_fulltext` (`amenity_name`);
ALTER TABLE `room_amenities` ADD FULLTEXT KEY `room_amenities_description_fulltext` (`description`);
ALTER TABLE `room_amenities` ADD FULLTEXT KEY `room_amenities_amenity_name_description_fulltext` (`amenity_name`,`description`);

--
-- Chỉ mục cho bảng `room_types`
--
ALTER TABLE `room_types` ADD FULLTEXT KEY `room_types_name_fulltext` (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
