-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 30 Ara 2025, 00:29:13
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `librarydb`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `account_blockage`
--

CREATE TABLE `account_blockage` (
  `block_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `block_date` datetime DEFAULT current_timestamp(),
  `reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `activity_log`
--

CREATE TABLE `activity_log` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `activity_log`
--

INSERT INTO `activity_log` (`log_id`, `user_id`, `action`, `timestamp`) VALUES
(1, 1, 'Logged in successfully', '2025-10-27 14:14:22'),
(2, 1, 'Logged out', '2025-10-27 14:14:43'),
(3, 5, 'Logged in successfully', '2025-10-27 14:15:03'),
(4, 5, 'Logged out', '2025-10-27 14:15:06'),
(5, 1, 'Logged in successfully', '2025-10-27 14:15:12'),
(6, 8, 'Logged in successfully', '2025-10-27 22:42:34'),
(7, 8, 'Logged in successfully', '2025-10-28 08:27:02'),
(8, 8, 'Logged out', '2025-10-28 08:28:53'),
(9, 8, 'Logged in successfully', '2025-10-28 08:29:09'),
(10, 8, 'Logged in successfully', '2025-10-28 11:47:18'),
(11, 8, 'Logged in successfully', '2025-10-28 13:49:45'),
(12, 8, 'Logged out', '2025-10-28 13:50:25'),
(13, 8, 'Logged in successfully', '2025-10-28 17:06:14'),
(14, 8, 'Logged out', '2025-10-28 17:06:40'),
(15, 8, 'Logged in successfully', '2025-10-28 17:06:52'),
(16, 8, 'Logged in successfully', '2025-10-28 19:38:05'),
(17, 8, 'Logged in successfully', '2025-10-28 19:39:27'),
(18, 8, 'Logged out', '2025-10-29 01:32:33'),
(19, 8, 'Logged in successfully', '2025-10-29 01:32:41'),
(20, 8, 'Logged out', '2025-10-29 01:34:44'),
(21, 8, 'Logged in successfully', '2025-10-29 01:35:18'),
(22, 8, 'Logged in successfully', '2025-10-29 01:35:50'),
(23, 8, 'Logged in successfully', '2025-10-29 01:51:35'),
(24, 8, 'Logged in successfully', '2025-10-29 02:34:05'),
(25, 8, 'Logged in successfully', '2025-10-29 03:43:29'),
(26, 8, 'Logged out', '2025-10-29 04:24:40'),
(27, 8, 'Logged in successfully', '2025-10-29 04:24:42'),
(28, 8, 'Logged in successfully', '2025-10-29 04:49:59'),
(29, 8, 'Logged out', '2025-10-29 04:50:14'),
(30, 8, 'Logged in successfully', '2025-10-29 09:07:41'),
(31, 8, 'Logged in successfully', '2025-10-29 11:00:19'),
(32, 8, 'Logged out', '2025-10-29 11:11:09'),
(33, 8, 'Logged in successfully', '2025-10-29 11:33:27'),
(34, 8, 'Logged out', '2025-10-29 12:40:47'),
(35, 8, 'Logged in successfully', '2025-10-29 12:40:49'),
(36, 8, 'Added new user: Arther', '2025-10-29 12:42:21'),
(37, 8, 'Logged out', '2025-10-29 12:42:36'),
(40, 8, 'Logged in successfully', '2025-10-29 12:43:45'),
(41, 8, 'Added new user: Chantel', '2025-10-29 12:44:27'),
(42, 8, 'Logged out', '2025-10-29 12:44:32'),
(46, 8, 'Logged in successfully', '2025-10-29 12:57:19'),
(49, 8, 'Logged in successfully', '2025-10-29 13:06:20'),
(50, 8, 'Logged out', '2025-10-29 13:09:03'),
(58, 8, 'Logged in successfully', '2025-10-29 18:42:51'),
(59, 8, 'Deleted user ID: 13', '2025-10-29 18:44:06'),
(60, 8, 'Deleted user ID: 12', '2025-10-29 18:44:19'),
(61, 8, 'Deleted user ID: 9', '2025-10-29 18:44:38'),
(62, 8, 'Logged in successfully', '2025-10-29 20:16:18'),
(63, 8, 'Logged in successfully', '2025-11-25 10:16:11'),
(64, 8, 'Logged in successfully', '2025-11-25 11:24:40'),
(65, 8, 'Logged out', '2025-11-25 11:26:17'),
(66, 10, 'Logged in successfully', '2025-11-25 11:26:52'),
(67, 8, 'Logged in successfully', '2025-11-25 18:19:05'),
(68, 8, 'Logged in successfully', '2025-11-25 18:19:15'),
(69, 10, 'Logged in successfully', '2025-11-27 14:10:11'),
(70, 10, 'Logged in successfully', '2025-11-27 14:10:34'),
(71, 10, 'Logged in successfully', '2025-11-27 14:50:29'),
(72, 8, 'Logged in successfully', '2025-11-27 15:13:54'),
(73, 10, 'Logged in successfully', '2025-11-27 15:18:36'),
(74, 8, 'Logged in successfully', '2025-11-27 15:22:08'),
(75, 10, 'Logged in successfully', '2025-11-27 15:56:42'),
(76, 8, 'Logged in successfully', '2025-11-27 15:57:44'),
(77, 10, 'Logged in successfully', '2025-11-27 18:18:19'),
(78, 10, 'Logged out', '2025-11-27 18:25:11'),
(79, 10, 'Logged in successfully', '2025-11-27 18:44:43'),
(80, 10, 'Logged out', '2025-11-27 19:01:13'),
(81, 8, 'Logged in successfully', '2025-11-29 14:58:34'),
(82, 8, 'Logged out', '2025-11-29 15:05:18'),
(83, 8, 'Logged in successfully', '2025-11-29 15:23:55'),
(84, 8, 'Logged out', '2025-12-02 10:27:06'),
(85, 8, 'Logged in successfully', '2025-12-02 10:27:32'),
(86, 8, 'Logged out', '2025-12-02 10:27:39'),
(87, 8, 'Logged in successfully', '2025-12-02 10:31:26'),
(88, 8, 'Logged out', '2025-12-02 11:17:47'),
(89, 8, 'Logged in successfully', '2025-12-02 11:18:00'),
(90, 8, 'Logged out', '2025-12-02 11:23:05'),
(91, 14, 'Logged in successfully', '2025-12-02 11:27:12'),
(92, 14, 'Logged out', '2025-12-02 11:46:15'),
(93, 8, 'Logged in successfully', '2025-12-02 20:46:33'),
(94, 8, 'Logged out', '2025-12-02 21:03:00'),
(95, 14, 'Logged in successfully', '2025-12-02 21:03:15'),
(96, 14, 'Logged out', '2025-12-02 21:06:11'),
(97, 8, 'Logged in successfully', '2025-12-02 21:09:19'),
(98, 8, 'Logged out', '2025-12-02 21:09:49'),
(99, 10, 'Logged in successfully', '2025-12-03 12:59:46'),
(100, 8, 'Logged in successfully', '2025-12-03 19:28:53'),
(101, 8, 'Logged out', '2025-12-03 19:29:12'),
(102, 14, 'Logged in successfully', '2025-12-03 19:29:19'),
(103, 14, 'Logged out', '2025-12-03 19:33:58'),
(104, 14, 'Logged out', '2025-12-03 19:33:58'),
(105, 14, 'Logged in successfully', '2025-12-03 19:34:09'),
(106, 8, 'Logged in successfully', '2025-12-03 23:51:56'),
(107, 8, 'Logged out', '2025-12-03 23:52:50'),
(108, 14, 'Logged in successfully', '2025-12-03 23:53:00'),
(109, 14, 'Logged out', '2025-12-03 23:54:21'),
(110, 14, 'Logged in successfully', '2025-12-03 23:59:36'),
(111, 14, 'Logged out', '2025-12-04 00:32:06'),
(112, 8, 'Logged in successfully', '2025-12-04 00:32:48'),
(113, 8, 'Logged out', '2025-12-04 01:42:16'),
(114, 8, 'Logged in successfully', '2025-12-04 01:42:30'),
(115, 8, 'Logged out', '2025-12-04 01:43:19'),
(116, 15, 'Logged in successfully', '2025-12-06 17:25:25'),
(117, 15, 'Borrowed book copy ID: 1', '2025-12-06 17:44:41'),
(118, 15, 'Logged in successfully', '2025-12-06 17:45:06'),
(119, 15, 'Returned book copy ID: 1', '2025-12-06 17:45:54'),
(120, 15, 'Borrowed book copy ID: 1', '2025-12-06 17:46:21'),
(121, 15, 'Returned borrow ID: 3', '2025-12-06 17:46:47'),
(122, 15, 'Requested to borrow book copy ID: 1', '2025-12-06 17:58:47'),
(123, 15, 'Approved borrow request ID: 4', '2025-12-06 18:05:40'),
(124, 15, 'Logged in successfully', '2025-12-06 19:07:14'),
(125, 15, 'Returned book copy ID: 1', '2025-12-06 19:07:34'),
(126, 15, 'Requested to borrow book copy ID: 1', '2025-12-06 19:08:17'),
(127, 15, 'Rejected borrow request ID: 5', '2025-12-06 19:10:33'),
(128, 15, 'Rated book ID: 1 (3 stars)', '2025-12-06 19:35:34'),
(129, 15, 'Logged in successfully', '2025-12-06 19:36:07'),
(130, 15, 'Logged in successfully', '2025-12-06 20:09:39'),
(131, 15, 'Logged in successfully', '2025-12-06 20:25:55'),
(132, 15, 'Logged in successfully', '2025-12-06 21:17:37'),
(133, 15, 'Logged in successfully', '2025-12-06 21:22:55'),
(134, 10, 'Logged in successfully', '2025-12-11 13:00:48'),
(135, 10, 'Logged out', '2025-12-11 13:01:27'),
(136, 8, 'Logged in successfully', '2025-12-11 13:01:35'),
(137, 8, 'Logged out', '2025-12-11 13:03:51'),
(138, 10, 'Logged in successfully', '2025-12-11 13:04:02'),
(139, 10, 'Logged out', '2025-12-11 13:11:42'),
(140, 8, 'Logged in successfully', '2025-12-11 13:11:51'),
(141, 8, 'Logged out', '2025-12-11 13:12:37'),
(142, 14, 'Logged in successfully', '2025-12-11 13:12:50'),
(143, 14, 'Logged out', '2025-12-11 13:13:22'),
(144, 10, 'Logged in successfully', '2025-12-11 13:13:31'),
(145, 10, 'Logged out', '2025-12-11 13:14:02'),
(146, 8, 'Logged in successfully', '2025-12-11 13:14:12'),
(147, 8, 'Logged out', '2025-12-11 13:16:08'),
(148, 1, 'Logged in successfully', '2025-12-13 22:01:03'),
(149, 1, 'Logged out', '2025-12-13 22:04:25'),
(150, 2, 'Logged in successfully', '2025-12-14 11:27:42'),
(151, 2, 'Logged out', '2025-12-14 11:29:37'),
(152, 1, 'Logged in successfully', '2025-12-14 11:29:42'),
(153, 1, 'Logged in successfully', '2025-12-14 11:48:05'),
(154, 1, 'Logged out', '2025-12-14 11:56:13'),
(155, 2, 'Logged in successfully', '2025-12-14 11:56:32'),
(156, 2, 'Sent a contact message', '2025-12-14 12:04:25'),
(157, 2, 'Sent a contact message', '2025-12-14 12:05:29'),
(158, 2, 'Sent a contact message', '2025-12-14 12:05:54'),
(159, 2, 'Logged out', '2025-12-14 12:06:18'),
(160, 1, 'Logged in successfully', '2025-12-14 12:06:22'),
(161, 1, 'Logged out', '2025-12-14 12:15:31'),
(162, 2, 'Logged in successfully', '2025-12-14 12:15:37'),
(163, 2, 'Sent a contact message', '2025-12-14 12:55:11'),
(164, 1, 'Logged in successfully', '2025-12-14 12:55:24'),
(165, 1, 'Logged out', '2025-12-14 13:09:08'),
(166, 2, 'Logged in successfully', '2025-12-14 13:12:08'),
(167, 2, 'Logged in successfully', '2025-12-14 13:51:40'),
(168, 2, 'Logged out', '2025-12-14 14:02:47'),
(169, 5, 'Logged in successfully', '2025-12-14 14:03:29'),
(170, 5, 'Logged out', '2025-12-14 14:07:40'),
(171, 2, 'Logged in successfully', '2025-12-14 14:09:02'),
(172, 2, 'Logged out', '2025-12-14 14:10:13'),
(173, 3, 'Logged in successfully', '2025-12-14 14:10:22'),
(174, 3, 'Logged out', '2025-12-14 14:12:03'),
(175, 5, 'Logged in successfully', '2025-12-14 14:12:32'),
(176, 5, 'Logged out', '2025-12-14 14:15:00'),
(177, 1, 'Logged in successfully', '2025-12-14 14:15:06'),
(178, 1, 'Logged out', '2025-12-14 14:22:05'),
(179, 15, 'Logged in successfully', '2025-12-15 20:01:45'),
(180, 15, 'Logged in successfully', '2025-12-15 20:03:53'),
(181, 15, 'User Registered', '2025-12-15 20:06:45'),
(182, 16, 'Logged in successfully', '2025-12-15 20:07:04'),
(183, 16, 'Logged in successfully', '2025-12-15 20:42:51'),
(184, 16, 'Logged in successfully', '2025-12-15 20:52:28'),
(185, 16, 'Logged out', '2025-12-15 21:18:07'),
(186, 15, 'Logged in successfully', '2025-12-15 21:18:21'),
(187, 16, 'Logged in successfully', '2025-12-15 21:19:32'),
(188, 15, 'Logged in successfully', '2025-12-15 21:25:21'),
(189, 15, 'Logged in successfully', '2025-12-15 21:31:10'),
(190, 15, 'Logged in successfully', '2025-12-15 21:34:08'),
(191, 15, 'Rejected donation ID: 1', '2025-12-15 21:43:45'),
(192, 16, 'Logged in successfully', '2025-12-15 21:45:23'),
(193, 15, 'Logged in successfully', '2025-12-15 21:48:07'),
(194, 15, 'Approved donation ID: 2', '2025-12-15 21:48:17'),
(195, 16, 'Logged in successfully', '2025-12-15 22:12:03'),
(196, 16, 'Logged in successfully', '2025-12-15 22:27:33'),
(197, 10, 'Logged in successfully', '2025-12-16 11:37:52'),
(198, 10, 'Logged out', '2025-12-16 11:42:27'),
(199, 8, 'Logged in successfully', '2025-12-16 11:42:36'),
(200, 10, 'Logged in successfully', '2025-12-16 12:31:47'),
(201, 10, 'Logged out', '2025-12-16 13:12:20'),
(202, 10, 'Logged in successfully', '2025-12-16 13:19:27'),
(203, 14, 'Logged in successfully', '2025-12-16 13:34:31'),
(204, 14, 'Logged out', '2025-12-16 13:40:25'),
(205, 10, 'Logged in successfully', '2025-12-16 13:40:47'),
(206, 10, 'Logged out', '2025-12-16 13:40:56'),
(207, 1, 'Logged in successfully', '2025-12-21 14:42:08'),
(208, 2, 'Logged in successfully', '2025-12-21 15:04:06'),
(209, 2, 'Added book ID 1 to wishlist', '2025-12-21 15:04:44'),
(210, 2, 'Removed book ID 1 from wishlist', '2025-12-21 15:08:43'),
(211, 2, 'Added book ID 1 to wishlist', '2025-12-21 15:09:35'),
(212, 2, 'Removed book ID 1 from wishlist', '2025-12-21 15:15:49'),
(213, 2, 'Added book ID 1 to wishlist', '2025-12-21 15:15:58'),
(214, 2, 'Requested to borrow book copy ID: 1', '2025-12-21 15:27:12'),
(215, 2, 'Logged out', '2025-12-21 15:28:41'),
(216, 1, 'Logged in successfully', '2025-12-21 15:28:46'),
(217, 1, 'Approved borrow request ID: 6', '2025-12-21 15:29:07'),
(218, 1, 'Logged out', '2025-12-21 15:29:51'),
(219, 2, 'Logged in successfully', '2025-12-21 15:29:59'),
(220, 2, 'Returned book copy ID: 1', '2025-12-21 15:31:42'),
(221, 2, 'Rated book ID: 1 (5 stars)', '2025-12-21 15:31:59'),
(222, 2, 'Logged out', '2025-12-21 15:32:30'),
(223, 1, 'Logged in successfully', '2025-12-21 15:32:40'),
(224, 1, 'Logged out', '2025-12-21 15:55:54'),
(225, 2, 'Logged in successfully', '2025-12-21 15:56:01'),
(226, 2, 'Removed book ID 1 from wishlist', '2025-12-21 15:56:07'),
(227, 2, 'Added book ID 1 to wishlist', '2025-12-21 15:56:13'),
(228, 2, 'Removed book ID 1 from wishlist', '2025-12-21 15:56:18'),
(229, 3, 'Logged in successfully', '2025-12-21 16:29:27'),
(230, 3, 'Logged in successfully', '2025-12-21 16:46:29'),
(231, 3, 'Recommended book ID 1', '2025-12-21 16:48:54'),
(232, 3, 'Added book ID 1 to wishlist', '2025-12-21 16:51:01'),
(233, 3, 'Removed book ID 1 from wishlist', '2025-12-21 16:54:15'),
(234, 3, 'Recommended book ID 1', '2025-12-21 16:57:15'),
(235, 3, 'Logged out', '2025-12-21 17:00:27'),
(236, 2, 'Logged in successfully', '2025-12-21 17:00:32'),
(237, 2, 'Added book ID 1 to wishlist', '2025-12-21 17:01:59'),
(238, 2, 'Removed book ID 1 from wishlist', '2025-12-21 17:02:56'),
(239, 2, 'Added book ID 1 to wishlist', '2025-12-21 17:03:00'),
(240, 2, 'Removed book ID 1 from wishlist', '2025-12-21 17:03:10'),
(241, 2, 'Added book ID 1 to wishlist', '2025-12-21 17:03:17'),
(242, 2, 'Removed book ID 1 from wishlist', '2025-12-21 17:03:49'),
(243, 2, 'Added book ID 1 to wishlist', '2025-12-21 17:03:57'),
(244, 2, 'Logged out', '2025-12-21 17:08:11'),
(245, 16, 'Logged in successfully', '2025-12-21 19:36:21'),
(246, 16, 'Requested to borrow book copy ID: 1', '2025-12-21 19:52:30'),
(247, 16, 'Added new user: aliyu', '2025-12-21 20:13:40'),
(248, 17, 'Logged in successfully', '2025-12-21 20:14:16'),
(249, 15, 'Logged in successfully', '2025-12-21 20:17:36'),
(250, 15, 'Requested to borrow book copy ID: 1', '2025-12-21 20:32:41'),
(251, 15, 'Requested to borrow book copy ID: 1', '2025-12-21 20:33:10'),
(252, 15, 'Logged out', '2025-12-21 20:33:58'),
(253, 17, 'Logged in successfully', '2025-12-21 20:34:13'),
(254, 17, 'Requested to borrow book copy ID: 1', '2025-12-21 20:34:34'),
(255, 15, 'Logged in successfully', '2025-12-21 20:35:05'),
(256, 15, 'Approved borrow request ID: 10', '2025-12-21 20:35:13'),
(257, 17, 'Logged in successfully', '2025-12-21 20:35:37'),
(258, 15, 'Logged in successfully', '2025-12-21 20:37:37'),
(259, 15, 'Logged out', '2025-12-21 20:52:15'),
(260, 17, 'Logged in successfully', '2025-12-21 20:52:38'),
(261, 17, 'Logged out', '2025-12-21 20:53:39'),
(262, 15, 'Logged in successfully', '2025-12-21 20:54:04'),
(263, 15, 'Rejected donation ID 4', '2025-12-21 20:54:15'),
(264, 15, 'Rejected donation ID 3', '2025-12-21 20:55:07'),
(265, 15, 'Approved donation ID 5', '2025-12-21 21:04:28'),
(266, 15, 'Logged out', '2025-12-21 21:04:41'),
(267, 17, 'Logged in successfully', '2025-12-21 21:04:49'),
(268, 17, 'Returned book copy ID: 1', '2025-12-21 21:24:07'),
(269, 17, 'Logged out', '2025-12-21 21:24:16'),
(270, 15, 'Logged in successfully', '2025-12-21 21:24:27'),
(271, 15, 'Logged in successfully', '2025-12-21 21:45:14'),
(272, 17, 'Logged in successfully', '2025-12-21 22:12:47'),
(273, 17, 'Requested to borrow book copy ID: 9', '2025-12-21 22:13:06'),
(274, 17, 'Logged out', '2025-12-21 22:13:14'),
(275, 15, 'Logged in successfully', '2025-12-21 22:13:27'),
(276, 15, 'Rejected borrow ID: 9', '2025-12-21 22:13:51'),
(277, 15, 'Rejected borrow ID: 8', '2025-12-21 22:13:54'),
(278, 15, 'Approved borrow ID: 11', '2025-12-21 22:13:58'),
(279, 15, 'Logged out', '2025-12-21 22:14:11'),
(280, 17, 'Logged in successfully', '2025-12-21 22:14:18'),
(281, 17, 'Logged out', '2025-12-21 22:22:13'),
(282, 15, 'Logged in successfully', '2025-12-21 22:23:07'),
(283, 15, 'Logged out', '2025-12-21 22:35:37'),
(284, 17, 'Logged in successfully', '2025-12-21 22:37:35'),
(285, 17, 'Requested to borrow inventory ID: 1', '2025-12-21 22:37:55'),
(286, 8, 'Logged in successfully', '2025-12-22 10:39:06'),
(287, 8, 'Logged out', '2025-12-22 10:40:08'),
(288, 10, 'Logged in successfully', '2025-12-22 10:40:18'),
(289, 10, 'Logged out', '2025-12-22 11:05:24'),
(290, 14, 'Logged in successfully', '2025-12-22 11:06:24'),
(291, 14, 'Recommended book ID 3', '2025-12-22 11:07:14'),
(292, 14, 'Logged out', '2025-12-22 11:09:50'),
(293, 10, 'Logged in successfully', '2025-12-22 11:23:50'),
(294, 10, 'Logged out', '2025-12-22 11:40:07'),
(295, 8, 'Logged in successfully', '2025-12-22 11:40:25'),
(296, 8, 'Approved borrow ID: 12', '2025-12-22 11:41:34'),
(297, 8, 'Logged out', '2025-12-22 11:42:59'),
(298, 10, 'Logged in successfully', '2025-12-22 11:43:08'),
(299, 10, 'Logged out', '2025-12-22 11:47:11'),
(300, 14, 'Logged in successfully', '2025-12-22 11:47:28'),
(301, 14, 'Logged out', '2025-12-22 11:54:12'),
(302, 10, 'Logged in successfully', '2025-12-22 11:54:20'),
(303, 10, 'Logged in successfully', '2025-12-22 12:33:28'),
(304, 10, 'Requested to borrow inventory ID: 10', '2025-12-22 12:33:49'),
(305, 10, 'Logged out', '2025-12-22 12:38:51'),
(306, 8, 'Logged in successfully', '2025-12-22 12:39:02'),
(307, 8, 'Approved donation ID 6', '2025-12-22 12:39:20'),
(308, 8, 'Approved borrow ID: 13', '2025-12-22 12:39:33'),
(309, 8, 'Logged out', '2025-12-22 12:39:38'),
(310, 10, 'Logged in successfully', '2025-12-22 12:39:47'),
(311, 10, 'Logged out', '2025-12-22 12:41:18'),
(312, 14, 'Logged in successfully', '2025-12-22 12:41:29'),
(313, 14, 'Logged out', '2025-12-22 12:54:55'),
(314, 8, 'Logged in successfully', '2025-12-22 12:55:10'),
(315, 8, 'Logged out', '2025-12-22 13:14:32'),
(316, 14, 'Logged in successfully', '2025-12-22 13:14:49'),
(317, 14, 'Logged out', '2025-12-22 13:18:35'),
(318, 14, 'Logged in successfully', '2025-12-22 13:18:48'),
(319, 14, 'Logged out', '2025-12-22 13:20:17'),
(320, 10, 'Logged in successfully', '2025-12-22 13:20:25'),
(321, 10, 'Logged out', '2025-12-22 13:24:41'),
(322, 14, 'Logged in successfully', '2025-12-22 15:42:46'),
(323, 14, 'Logged out', '2025-12-22 15:50:36'),
(324, 10, 'Logged in successfully', '2025-12-22 15:50:43'),
(325, 10, 'Logged out', '2025-12-22 15:51:01'),
(326, 8, 'Logged in successfully', '2025-12-22 15:51:08'),
(327, 8, 'Logged out', '2025-12-22 15:51:35'),
(328, 14, 'Logged in successfully', '2025-12-22 15:51:45'),
(329, 14, 'Logged out', '2025-12-22 15:57:31'),
(330, 8, 'Logged in successfully', '2025-12-22 15:57:41'),
(331, 8, 'Logged out', '2025-12-22 15:58:45'),
(332, 14, 'Logged in successfully', '2025-12-22 15:58:56'),
(333, 14, 'Logged out', '2025-12-22 16:06:00'),
(334, 8, 'Logged in successfully', '2025-12-22 16:06:12'),
(335, 8, 'Logged out', '2025-12-22 16:10:08'),
(336, 14, 'Logged in successfully', '2025-12-22 16:10:34'),
(337, 14, 'Logged out', '2025-12-22 16:28:36'),
(338, 8, 'Logged in successfully', '2025-12-22 17:26:00'),
(339, 8, 'Logged out', '2025-12-22 17:27:35'),
(340, 14, 'Logged in successfully', '2025-12-22 17:27:43'),
(341, 14, 'Logged out', '2025-12-22 17:36:57'),
(342, 8, 'Logged in successfully', '2025-12-22 17:37:05'),
(343, 8, 'Logged out', '2025-12-22 18:00:31'),
(344, 14, 'Logged in successfully', '2025-12-22 18:00:39'),
(345, 14, 'Logged out', '2025-12-22 18:06:27'),
(346, 8, 'Logged in successfully', '2025-12-22 18:06:35'),
(347, 8, 'Logged out', '2025-12-22 18:08:17'),
(348, 2, 'Logged in successfully', '2025-12-23 15:33:08'),
(349, 2, 'Logged out', '2025-12-23 15:35:14'),
(350, 5, 'Logged in successfully', '2025-12-23 15:35:47'),
(351, 5, 'Updated library capacity to 99', '2025-12-23 15:36:55'),
(352, 5, 'Logged out', '2025-12-23 15:36:58'),
(353, 2, 'Logged in successfully', '2025-12-23 15:37:04'),
(354, 2, 'Logged out', '2025-12-23 15:45:28'),
(355, 5, 'Logged in successfully', '2025-12-23 15:45:36'),
(356, 5, 'Logged out', '2025-12-23 15:46:03'),
(357, 1, 'Logged in successfully', '2025-12-23 15:46:16'),
(358, 1, 'Logged out', '2025-12-23 16:01:14'),
(359, 2, 'Logged in successfully', '2025-12-23 16:01:49'),
(360, 2, 'Requested to borrow inventory ID: 11', '2025-12-23 16:09:14'),
(361, 2, 'Removed book ID 1 from wishlist', '2025-12-23 16:11:08'),
(362, 2, 'Added book ID 4 to wishlist', '2025-12-23 16:11:13'),
(363, 2, 'Logged out', '2025-12-23 16:14:46'),
(364, 3, 'Logged in successfully', '2025-12-23 16:14:57'),
(365, 3, 'Logged out', '2025-12-23 16:17:39'),
(366, 5, 'Logged in successfully', '2025-12-23 16:17:44'),
(367, 5, 'Returned borrow ID: 7', '2025-12-23 16:20:17'),
(368, 5, 'Logged out', '2025-12-23 16:37:34'),
(369, 1, 'Logged in successfully', '2025-12-23 16:37:41'),
(370, 1, 'Updated library capacity to 55', '2025-12-23 16:41:58'),
(371, 1, 'Logged out', '2025-12-23 16:45:43'),
(372, 5, 'Logged in successfully', '2025-12-23 16:45:53'),
(373, 5, 'Logged out', '2025-12-23 17:29:06'),
(374, 2, 'Logged in successfully', '2025-12-23 17:29:12'),
(375, 2, 'Logged in successfully', '2025-12-23 18:14:02'),
(376, 2, 'Logged out', '2025-12-23 18:18:11'),
(377, 5, 'Logged in successfully', '2025-12-23 18:18:16'),
(378, 5, 'Logged out', '2025-12-23 18:19:45'),
(379, 2, 'Logged in successfully', '2025-12-23 18:19:51'),
(380, 2, 'Logged out', '2025-12-23 18:31:47'),
(381, 1, 'Logged in successfully', '2025-12-23 18:32:00'),
(382, 1, 'Updated library capacity to 100', '2025-12-23 18:32:07'),
(383, 1, 'Logged out', '2025-12-23 18:32:10'),
(384, 2, 'Logged in successfully', '2025-12-23 18:32:18'),
(385, 2, 'Logged out', '2025-12-23 18:34:14'),
(386, 8, 'Logged in successfully', '2025-12-23 19:14:38'),
(387, 8, 'Logged out', '2025-12-23 19:16:00'),
(388, 5, 'Logged in successfully', '2025-12-23 19:17:03'),
(389, 5, 'Logged out', '2025-12-23 19:20:31'),
(390, 14, 'Logged in successfully', '2025-12-23 19:20:40'),
(391, 14, 'Logged out', '2025-12-23 19:22:23'),
(392, 5, 'Logged in successfully', '2025-12-23 19:23:13'),
(393, 5, 'Logged in successfully', '2025-12-23 19:29:42'),
(394, 5, 'Logged out', '2025-12-23 19:32:56'),
(395, 8, 'Logged in successfully', '2025-12-23 19:33:06'),
(396, 8, 'Logged out', '2025-12-23 19:34:14'),
(397, 5, 'Logged in successfully', '2025-12-23 19:34:28'),
(398, 5, 'Logged out', '2025-12-23 19:35:49'),
(399, 10, 'Logged in successfully', '2025-12-23 19:35:59'),
(400, 10, 'Logged out', '2025-12-23 19:36:22'),
(401, 8, 'Logged in successfully', '2025-12-23 19:36:31'),
(402, 8, 'Logged out', '2025-12-23 19:37:36'),
(403, 17, 'Logged in successfully', '2025-12-23 22:10:38'),
(404, 15, 'Logged in successfully', '2025-12-23 22:43:18'),
(405, 15, 'Logged out', '2025-12-23 23:16:24'),
(406, 17, 'Logged in successfully', '2025-12-23 23:16:38'),
(407, 17, 'Logged out', '2025-12-23 23:19:58'),
(408, 15, 'Logged in successfully', '2025-12-23 23:20:30'),
(409, 15, 'Logged out', '2025-12-23 23:21:01'),
(410, 17, 'Logged in successfully', '2025-12-23 23:21:08'),
(411, 17, 'Logged in successfully', '2025-12-23 23:21:09'),
(412, 17, 'Logged in successfully', '2025-12-23 23:50:07'),
(413, 17, 'Logged in successfully', '2025-12-24 21:50:40'),
(414, 15, 'Logged in successfully', '2025-12-24 22:11:45'),
(415, 15, 'Logged in successfully', '2025-12-24 22:12:02'),
(416, 17, 'Logged in successfully', '2025-12-24 22:51:00'),
(417, 17, 'Logged in successfully', '2025-12-24 23:11:33'),
(418, 17, 'Logged in successfully', '2025-12-28 13:09:15'),
(419, 17, 'Logged in successfully', '2025-12-28 14:03:20'),
(420, 17, 'Logged in successfully', '2025-12-28 15:06:34'),
(421, 17, 'Logged in successfully', '2025-12-28 16:12:28'),
(422, 17, 'Logged out', '2025-12-28 16:46:50'),
(423, 16, 'Logged in successfully', '2025-12-28 16:46:57'),
(424, 16, 'Logged out', '2025-12-28 16:55:48'),
(425, 17, 'Logged in successfully', '2025-12-28 16:55:55'),
(426, 17, 'Logged out', '2025-12-28 17:10:58'),
(427, 16, 'Logged in successfully', '2025-12-28 17:11:06'),
(428, 16, 'Logged out', '2025-12-28 17:11:13'),
(429, 2, 'Logged in successfully', '2025-12-28 20:01:56'),
(430, 2, 'Logged in successfully', '2025-12-28 20:38:07'),
(431, 5, 'Logged in successfully', '2025-12-28 21:15:23'),
(432, 5, 'Logged out', '2025-12-28 21:17:00'),
(433, 2, 'Logged in successfully', '2025-12-28 21:17:07'),
(434, 2, 'Logged out', '2025-12-28 21:43:02'),
(435, 2, 'Logged in successfully', '2025-12-28 21:43:37'),
(436, 2, 'Logged out', '2025-12-28 21:54:08'),
(437, 1, 'Logged in successfully', '2025-12-28 21:54:19'),
(438, 1, 'Logged out', '2025-12-28 21:57:19'),
(439, 1, 'Logged in successfully', '2025-12-28 22:25:36'),
(440, 1, 'Logged out', '2025-12-28 22:26:20'),
(441, 1, 'Logged in successfully', '2025-12-28 22:27:42'),
(442, 1, 'Logged out', '2025-12-28 22:27:50'),
(443, 2, 'Logged in successfully', '2025-12-28 22:27:57'),
(444, 2, 'Logged out', '2025-12-28 22:39:32'),
(445, 5, 'Logged in successfully', '2025-12-28 22:39:38'),
(446, 5, 'Logged out', '2025-12-28 22:43:38'),
(447, 3, 'Logged in successfully', '2025-12-28 22:43:47'),
(448, 3, 'Logged out', '2025-12-28 22:45:09'),
(449, 1, 'Logged in successfully', '2025-12-28 22:45:30'),
(450, 1, 'Logged out', '2025-12-28 22:45:57'),
(451, 2, 'Logged in successfully', '2025-12-28 22:46:04'),
(452, 2, 'Logged out', '2025-12-28 22:46:13'),
(453, 1, 'Logged in successfully', '2025-12-29 11:35:10'),
(454, 1, 'Logged in successfully', '2025-12-29 13:10:29'),
(455, 1, 'Updated library capacity to 90', '2025-12-29 13:28:42'),
(456, 1, 'Updated library capacity to 90', '2025-12-29 13:28:49'),
(457, 1, 'Updated library capacity to 90', '2025-12-29 13:28:50'),
(458, 1, 'Logged in successfully', '2025-12-29 14:11:57'),
(459, 1, 'Logged out', '2025-12-29 14:16:23'),
(460, 5, 'Logged in successfully', '2025-12-29 14:16:31'),
(461, 5, 'Logged out', '2025-12-29 14:17:54'),
(462, 1, 'Logged in successfully', '2025-12-29 14:18:00'),
(463, 1, 'Logged out', '2025-12-29 14:29:04'),
(464, 5, 'Logged in successfully', '2025-12-29 14:29:49'),
(465, 5, 'Logged in successfully', '2025-12-29 15:55:27'),
(466, 5, 'Logged out', '2025-12-29 15:59:33'),
(467, 2, 'Logged in successfully', '2025-12-29 15:59:49'),
(468, 2, 'Logged in successfully', '2025-12-29 16:31:18'),
(469, 2, 'Logged out', '2025-12-29 16:59:49'),
(470, 3, 'Logged in successfully', '2025-12-29 16:59:57'),
(471, 3, 'Added book ID 1 to wishlist', '2025-12-29 17:01:00'),
(472, 3, 'Requested to borrow inventory ID: 1', '2025-12-29 17:01:55'),
(473, 3, 'Logged out', '2025-12-29 17:02:36'),
(474, 1, 'Logged in successfully', '2025-12-29 17:02:40'),
(475, 1, 'Approved borrow ID: 15', '2025-12-29 17:02:48'),
(476, 1, 'Logged out', '2025-12-29 17:02:52'),
(477, 3, 'Logged in successfully', '2025-12-29 17:03:21'),
(478, 3, 'Returned book copy ID: 1', '2025-12-29 17:03:50'),
(479, 2, 'Logged in successfully', '2025-12-29 17:21:05'),
(480, 2, 'Logged out', '2025-12-29 17:21:31'),
(481, 3, 'Logged in successfully', '2025-12-29 17:21:42'),
(482, 3, 'Logged out', '2025-12-29 17:28:10'),
(483, 2, 'Logged in successfully', '2025-12-29 17:28:14'),
(484, 2, 'Logged out', '2025-12-29 17:28:46'),
(485, 3, 'Logged in successfully', '2025-12-29 17:28:55'),
(486, 3, 'Added book ID 5 to wishlist', '2025-12-29 17:42:42'),
(487, 3, 'Added book ID 4 to wishlist', '2025-12-29 17:42:50'),
(488, 3, 'Added book ID 3 to wishlist', '2025-12-29 17:42:50'),
(489, 3, 'Removed book ID 4 from wishlist', '2025-12-29 17:43:06'),
(490, 3, 'Removed book ID 3 from wishlist', '2025-12-29 17:43:08'),
(491, 3, 'Removed book ID 5 from wishlist', '2025-12-29 17:43:10'),
(492, 3, 'Removed book ID 1 from wishlist', '2025-12-29 17:43:11'),
(493, 3, 'Added book ID 4 to wishlist', '2025-12-29 17:44:39'),
(494, 3, 'Logged out', '2025-12-29 17:51:34'),
(495, 2, 'Logged in successfully', '2025-12-29 17:52:59'),
(496, 2, 'Logged out', '2025-12-29 18:05:12'),
(497, 1, 'Logged in successfully', '2025-12-29 18:07:34'),
(498, 1, 'Logged out', '2025-12-29 18:09:25'),
(499, 5, 'Logged in successfully', '2025-12-29 18:09:36'),
(500, 5, 'Logged out', '2025-12-29 18:12:20'),
(501, 1, 'Logged in successfully', '2025-12-29 18:12:24'),
(502, 1, 'Logged out', '2025-12-29 18:13:06'),
(503, 5, 'Logged in successfully', '2025-12-29 18:13:12'),
(504, 5, 'Logged out', '2025-12-29 18:14:20'),
(505, 2, 'Logged in successfully', '2025-12-29 18:14:28'),
(506, 2, 'Added book ID 1 to wishlist', '2025-12-29 18:15:49'),
(507, 2, 'Requested to borrow inventory ID: 12', '2025-12-29 18:18:09'),
(508, 2, 'Logged out', '2025-12-29 18:21:35'),
(509, 3, 'Logged in successfully', '2025-12-29 18:21:44'),
(510, 3, 'Logged out', '2025-12-29 18:23:38'),
(511, 15, 'Logged in successfully', '2025-12-29 19:26:32'),
(512, 17, 'Logged in successfully', '2025-12-29 20:48:27'),
(513, 16, 'Logged in successfully', '2025-12-29 21:13:16'),
(514, 16, 'Logged out', '2025-12-29 21:15:30'),
(515, 17, 'Logged in successfully', '2025-12-29 21:21:11'),
(516, 17, 'Added book ID 6 to wishlist', '2025-12-29 21:21:46'),
(517, 17, 'Logged out', '2025-12-29 21:29:29'),
(518, 15, 'Logged in successfully', '2025-12-29 21:39:37'),
(519, 15, 'Logged out', '2025-12-29 21:44:20'),
(520, 17, 'Logged in successfully', '2025-12-29 21:44:27'),
(521, 17, 'Logged out', '2025-12-29 21:45:31'),
(522, 15, 'Logged in successfully', '2025-12-29 21:45:59'),
(523, 15, 'Logged out', '2025-12-29 22:05:28'),
(524, 17, 'Logged in successfully', '2025-12-29 22:05:39'),
(525, 17, 'Requested to borrow inventory ID 15', '2025-12-29 23:57:48'),
(526, 17, 'Requested to borrow inventory ID 55', '2025-12-29 23:58:07'),
(527, 17, 'Logged in successfully', '2025-12-29 23:58:25'),
(528, 17, 'Returned book copy ID: 9', '2025-12-29 23:58:37'),
(529, 17, 'Logged in successfully', '2025-12-30 00:21:20'),
(530, 17, 'Logged out', '2025-12-30 00:22:51'),
(531, 15, 'Logged in successfully', '2025-12-30 00:23:05'),
(532, 15, 'Rejected donation ID 7', '2025-12-30 00:23:16'),
(533, 15, 'Logged out', '2025-12-30 00:24:05'),
(534, 17, 'Logged in successfully', '2025-12-30 00:24:12'),
(535, 17, 'Requested to borrow inventory ID 74', '2025-12-30 00:36:11'),
(536, 17, 'Logged out', '2025-12-30 00:36:21'),
(537, 15, 'Logged in successfully', '2025-12-30 00:36:36'),
(538, 15, 'Rejected donation ID 8', '2025-12-30 00:36:48'),
(539, 2, 'Logged in successfully', '2025-12-30 01:05:21'),
(540, 2, 'Logged out', '2025-12-30 01:06:15'),
(541, 1, 'Logged in successfully', '2025-12-30 01:06:29'),
(542, 1, 'Logged out', '2025-12-30 01:08:00'),
(543, 5, 'Logged in successfully', '2025-12-30 01:08:05'),
(544, 5, 'Logged out', '2025-12-30 01:08:45'),
(545, 3, 'Logged in successfully', '2025-12-30 01:09:39'),
(546, 3, 'Logged out', '2025-12-30 01:13:21'),
(547, 2, 'Logged in successfully', '2025-12-30 01:13:40'),
(548, 2, 'Logged out', '2025-12-30 01:15:46'),
(549, 5, 'Logged in successfully', '2025-12-30 01:15:57'),
(550, 5, 'Logged out', '2025-12-30 01:16:26'),
(551, 1, 'Logged in successfully', '2025-12-30 01:18:33'),
(552, 1, 'Logged out', '2025-12-30 01:21:13'),
(553, 3, 'Logged in successfully', '2025-12-30 01:21:21'),
(554, 3, 'Logged out', '2025-12-30 01:21:44');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date_marked` date NOT NULL,
  `marked_by` varchar(100) NOT NULL,
  `status` enum('Present','Absent') DEFAULT 'Present',
  `timestamp_marked` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(150) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `book_type` enum('Ebook','Hardcopy') NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `availability_status` varchar(50) DEFAULT 'Available',
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `book`
--

INSERT INTO `book` (`book_id`, `title`, `author`, `isbn`, `book_type`, `description`, `cover_image`, `availability_status`, `category_id`, `created_at`) VALUES
(1, 'THE BOOK OF TIME TIME', 'Major', '213-45', 'Hardcopy', NULL, NULL, 'Available', 52, '2025-12-06 17:27:38'),
(3, 'The What', 'Miles', '213-43', 'Ebook', 'A peom', 'uploads/books/6952defd71234.png', 'Available', 15, '2025-12-21 21:04:27'),
(4, 'The Leadership Pipeline', 'Tim John', '324-11', 'Hardcopy', 'Explains leadership and how to be one', 'uploads/books/6952ded28febf.jpg', 'Available', 1, '2025-12-22 12:39:20'),
(5, 'STATE OF THE WALLET', 'DAINEL TANASE', '322-11', 'Ebook', 'Help in finance', 'uploads/books/6952de7ec1723.jpg', 'Available', 11, '2025-12-24 22:50:30'),
(6, 'Basic Sceince', 'John  O.', '553-90', 'Ebook', 'physics', 'uploads/books/6952de5db86e9.jpg', 'Available', 5, '2025-12-29 19:44:16'),
(7, 'Introduction  to Computers', 'Jules Biggs', '353-22', 'Hardcopy', 'introduction to computer', 'uploads/books/6952dd3828443.jpg', 'Available', 1, '2025-12-29 19:47:20'),
(8, 'Introduction to Technology', 'Malcom King', '345-12', 'Ebook', 'What is technology', 'uploads/books/6952dd118f6bb.jpg', 'Available', 2, '2025-12-29 19:52:06'),
(9, 'Environmental Studies', 'Adil Hamza', '456-66', 'Hardcopy', 'The study of nature', 'uploads/books/6952dce460f6f.jpg', 'Available', 32, '2025-12-29 19:54:44'),
(10, 'Plants and Nature', 'Sophia Martinez', '768-99', 'Hardcopy', 'Introduces domestic and wild animals with simple explanations.', 'uploads/books/6952dccc7c5c1.jpg', 'Available', 32, '2025-12-29 19:59:47'),
(11, 'Essay Writing Practice', 'Rachel Adams', '112-44', 'Hardcopy', 'Helps students improve handwritting and sentence writting', 'uploads/books/6952dcb292b4a.jpg', 'Available', 13, '2025-12-29 20:03:19'),
(12, 'World Map and Countries', 'Steven Clark', '434-75', 'Hardcopy', 'Introduces continents, countries, and basic geography', 'uploads/books/6952dc9b68df3.jpg', 'Available', 20, '2025-12-29 20:05:35'),
(13, 'Software Engineering Principles', 'Andrew K. Wilson', '468-76', 'Ebook', 'Explains software development life  cycles, requirement analysis, and system design', 'uploads/books/6952dc7f79528.jpg', 'Available', 38, '2025-12-29 20:11:53'),
(14, 'Cybersecurity Fundamentals', 'Michael J. Turner', '867-44', 'Ebook', 'Explains security threats, encryption basics, and safe computing practices', 'uploads/books/6952dc684df18.jpg', 'Available', 35, '2025-12-29 20:15:26'),
(15, 'Human-Computer Interaction', 'Natalie W. Chen', '325-56', 'Ebook', 'Introducs usability, interface design, and user experience principles', 'uploads/books/6952dc4c812ce.jpg', 'Available', 2, '2025-12-29 20:18:53'),
(16, 'Priciples of Business', 'Richard L. Howard', '568-39', 'Ebook', 'Introduces planning, organizing, leading, and controlling in organizations.', 'uploads/books/6952dc3651a4c.jpg', 'Available', 10, '2025-12-29 20:22:34'),
(17, 'Intorduction to Law', 'Michael R. Turner', '345-77', 'Hardcopy', 'Explains legal systems, laws, and basic legal principles.', 'uploads/books/6952dc1b89ce4.jpg', 'Available', 26, '2025-12-29 20:24:50'),
(18, 'The Silent Campus', 'Daniel R. Moore', '476-88', 'Hardcopy', 'A mystery novel set in a university where a hidden secret slowly unfolds.', 'uploads/books/6952d9dea1435.jpg', 'Available', 51, '2025-12-29 20:28:55'),
(19, 'Echoes of Tomorrow', 'Mike A. Collins', '356-46', 'Ebook', 'A science-fiction story exploring future education and technology', 'uploads/books/6952d9b4d7cc8.jpg', 'Available', 51, '2025-12-29 20:31:13'),
(20, 'Ehics and Society', 'Peter L. Morgan', '543-45', 'Hardcopy', 'Dicusses moral responsibility, ethics, and social values.', 'uploads/books/6952d99bb13a4.jpg', 'Available', 52, '2025-12-29 20:33:29'),
(21, 'Ink and Silence', 'Oliver J. Hayes', '654-34', 'Ebook', 'Peoms focused on solitude, thought, and human emotion.', 'uploads/books/6952d9754c70d.jpg', 'Available', 15, '2025-12-29 20:36:17'),
(22, 'The Quiet Line', 'Farah L. Brooks', '345-33', 'Hardcopy', 'Minimalist poetry capturing moments of reflection and clarity.', 'uploads/books/6952d962c3422.jpg', 'Available', 15, '2025-12-29 20:40:21'),
(23, 'The cow', 'Major Musa', '790-09', 'Ebook', 'Story book', 'uploads/books/6952fe3e7d89b.png', 'Available', 15, '2025-12-30 00:18:38');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `book_category`
--

CREATE TABLE `book_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `book_category`
--

INSERT INTO `book_category` (`category_id`, `category_name`) VALUES
(1, 'Computer Science'),
(2, 'Information Technology'),
(3, 'Engineering'),
(4, 'Mathematics'),
(5, 'Physics'),
(6, 'Chemistry'),
(7, 'Biology'),
(8, 'Medicine'),
(9, 'Economics'),
(10, 'Business & Management'),
(11, 'Accounting'),
(12, 'Education'),
(13, 'English Literature'),
(14, 'World Literature'),
(15, 'Poetry'),
(16, 'Drama'),
(17, 'Linguistics'),
(18, 'Creative Writing'),
(19, 'History'),
(20, 'Geography'),
(21, 'Political Science'),
(22, 'International Relations'),
(23, 'Sociology'),
(24, 'Psychology'),
(25, 'Philosophy'),
(26, 'Law'),
(27, 'Religious Studies'),
(28, 'Islamic Studies'),
(29, 'Christian Studies'),
(30, 'African Studies'),
(31, 'Cultural Studies'),
(32, 'Environmental Science'),
(33, 'Data Science'),
(34, 'Artificial Intelligence'),
(35, 'Cybersecurity'),
(36, 'Robotics'),
(37, 'Networking'),
(38, 'Software Engineering'),
(39, 'Reference'),
(40, 'Encyclopedia'),
(41, 'Dictionary'),
(42, 'Research Methods'),
(43, 'Journals'),
(44, 'Thesis & Dissertations'),
(45, 'Fine Arts'),
(46, 'Graphic Design'),
(47, 'Photography'),
(48, 'Music'),
(49, 'Film & Media Studies'),
(50, 'Architecture'),
(51, 'Fiction'),
(52, 'Non-Fiction'),
(53, 'Biography'),
(54, 'Autobiography'),
(55, 'Self-Help'),
(56, 'Motivation'),
(57, 'Leadership'),
(58, 'Entrepreneurship'),
(59, 'Children’s Books'),
(60, 'Young Adult'),
(61, 'Comics & Graphic Novels');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `book_donation`
--

CREATE TABLE `book_donation` (
  `donation_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `approver_id` int(11) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `approved_date` datetime DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `book_type` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `copies` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `book_donation`
--

INSERT INTO `book_donation` (`donation_id`, `donor_id`, `book_title`, `status`, `approver_id`, `is_approved`, `approved_date`, `author`, `isbn`, `book_type`, `description`, `cover_image`, `category_id`, `copies`, `created_at`) VALUES
(1, 15, 'The Boys', 'Rejected', 15, 0, '2025-12-15 21:43:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 00:34:35'),
(2, 16, 'THEE ONE', 'Approved', 15, 1, '2025-12-15 21:48:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 00:34:35'),
(3, 15, 'The What', 'Rejected', 15, 0, '2025-12-21 20:55:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 00:34:35'),
(4, 15, 'The What', 'Rejected', 15, 0, '2025-12-21 20:54:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 00:34:35'),
(5, 17, 'The What', 'Approved', 15, 1, '2025-12-21 21:04:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 00:34:35'),
(6, 10, 'The Leadership Pipeline', 'Approved', 8, 1, '2025-12-22 12:39:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 00:34:35'),
(7, 17, 'iyio7', 'Rejected', 15, 0, '2025-12-30 00:23:16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-30 00:34:35'),
(8, 17, 'hgvhv', 'Rejected', 15, 0, '2025-12-30 00:36:48', 'nbb', '213-43', 'Ebook', 'jhjg', NULL, 30, 6, '2025-12-30 00:35:06');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `book_inventory`
--

CREATE TABLE `book_inventory` (
  `inventory_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `copy_number` int(11) DEFAULT NULL,
  `book_condition` varchar(100) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `book_inventory`
--

INSERT INTO `book_inventory` (`inventory_id`, `book_id`, `copy_number`, `book_condition`, `is_available`) VALUES
(1, 1, 1, 'Good', 1),
(2, 1, 2, 'Good', 1),
(3, 1, 3, 'Good', 1),
(4, 1, 4, 'Good', 1),
(5, 1, 5, 'Good', 1),
(6, 1, 6, 'Good', 1),
(7, 1, 7, 'Good', 1),
(8, 1, 8, 'Good', 1),
(9, 3, 1, 'Good', 1),
(10, 3, 2, 'Good', 0),
(11, 3, 3, 'Good', 1),
(12, 4, 1, 'Good', 1),
(13, 5, 1, 'Good', 1),
(14, 5, 2, 'Good', 1),
(15, 6, 1, 'Good', 1),
(16, 6, 2, 'Good', 1),
(17, 6, 3, 'Good', 1),
(18, 7, 1, 'Good', 1),
(19, 8, 1, 'Good', 1),
(20, 8, 2, 'Good', 1),
(21, 8, 3, 'Good', 1),
(22, 9, 1, 'Good', 1),
(23, 9, 2, 'Good', 1),
(24, 9, 3, 'Good', 1),
(25, 9, 4, 'Good', 1),
(26, 9, 5, 'Good', 1),
(27, 10, 1, 'Good', 1),
(28, 10, 2, 'Good', 1),
(29, 10, 3, 'Good', 1),
(30, 10, 4, 'Good', 1),
(31, 10, 5, 'Good', 1),
(32, 10, 6, 'Good', 1),
(33, 10, 7, 'Good', 1),
(34, 10, 8, 'Good', 1),
(35, 10, 9, 'Good', 1),
(36, 10, 10, 'Good', 1),
(37, 11, 1, 'Good', 1),
(38, 11, 2, 'Good', 1),
(39, 11, 3, 'Good', 1),
(40, 11, 4, 'Good', 1),
(41, 12, 1, 'Good', 1),
(42, 12, 2, 'Good', 1),
(43, 12, 3, 'Good', 1),
(44, 12, 4, 'Good', 1),
(45, 12, 5, 'Good', 1),
(46, 12, 6, 'Good', 1),
(47, 12, 7, 'Good', 1),
(48, 12, 8, 'Good', 1),
(49, 13, 1, 'Good', 1),
(50, 13, 2, 'Good', 1),
(51, 13, 3, 'Good', 1),
(52, 13, 4, 'Good', 1),
(53, 13, 5, 'Good', 1),
(54, 13, 6, 'Good', 1),
(55, 14, 1, 'Good', 1),
(56, 14, 2, 'Good', 1),
(57, 14, 3, 'Good', 1),
(58, 14, 4, 'Good', 1),
(59, 14, 5, 'Good', 1),
(60, 15, 1, 'Good', 1),
(61, 15, 2, 'Good', 1),
(62, 15, 3, 'Good', 1),
(63, 16, 1, 'Good', 1),
(64, 16, 2, 'Good', 1),
(65, 17, 1, 'Good', 1),
(66, 17, 2, 'Good', 1),
(67, 17, 3, 'Good', 1),
(68, 17, 4, 'Good', 1),
(69, 17, 5, 'Good', 1),
(70, 17, 6, 'Good', 1),
(71, 18, 1, 'Good', 1),
(72, 18, 2, 'Good', 1),
(73, 18, 3, 'Good', 1),
(74, 19, 1, 'Good', 1),
(75, 19, 2, 'Good', 1),
(76, 19, 3, 'Good', 1),
(77, 19, 4, 'Good', 1),
(78, 20, 1, 'Good', 1),
(79, 20, 2, 'Good', 1),
(80, 20, 3, 'Good', 1),
(81, 20, 4, 'Good', 1),
(82, 20, 5, 'Good', 1),
(83, 20, 6, 'Good', 1),
(84, 21, 1, 'Good', 1),
(85, 21, 2, 'Good', 1),
(86, 21, 3, 'Good', 1),
(87, 21, 4, 'Good', 1),
(88, 21, 5, 'Good', 1),
(89, 21, 6, 'Good', 1),
(90, 21, 7, 'Good', 1),
(91, 22, 1, 'Good', 1),
(92, 22, 2, 'Good', 1),
(93, 22, 3, 'Good', 1),
(94, 22, 4, 'Good', 1),
(95, 23, 1, 'Good', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `book_management_log`
--

CREATE TABLE `book_management_log` (
  `log_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `performed_by` int(11) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `book_rating`
--

CREATE TABLE `book_rating` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `rating_value` int(11) DEFAULT NULL CHECK (`rating_value` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `book_rating`
--

INSERT INTO `book_rating` (`rating_id`, `user_id`, `book_id`, `rating_value`, `comment`, `created_at`) VALUES
(1, 15, 1, 3, 'very good', '2025-12-06 19:35:33'),
(2, 2, 1, 5, 'sadsadasasd', '2025-12-21 15:31:59');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `borrowing`
--

CREATE TABLE `borrowing` (
  `borrowing_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `borrow_date` datetime DEFAULT current_timestamp(),
  `due_date` datetime DEFAULT NULL,
  `returned_date` datetime DEFAULT NULL,
  `qrcode_used` tinyint(1) DEFAULT 0,
  `status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `borrowing`
--

INSERT INTO `borrowing` (`borrowing_id`, `user_id`, `inventory_id`, `borrow_date`, `due_date`, `returned_date`, `qrcode_used`, `status_id`) VALUES
(2, 15, 1, '2025-12-06 00:00:00', '2025-12-10 00:00:00', '2025-12-06 00:00:00', 0, 2),
(3, 15, 1, '2025-12-06 00:00:00', '2025-12-13 00:00:00', '2025-12-06 17:46:47', 0, 2),
(4, 15, 1, '2025-12-06 00:00:00', '2025-12-13 00:00:00', '2025-12-06 00:00:00', 0, 2),
(5, 15, 1, '2025-12-06 00:00:00', '2025-12-20 00:00:00', NULL, 0, 5),
(6, 2, 1, '2025-12-21 00:00:00', '2025-12-22 00:00:00', '2025-12-21 00:00:00', 0, 2),
(7, 16, 1, '2025-12-21 00:00:00', '2025-12-31 00:00:00', '2025-12-23 16:20:17', 0, 2),
(8, 15, 1, '2025-12-21 00:00:00', '2025-12-25 00:00:00', NULL, 0, 5),
(9, 15, 1, '2025-12-21 00:00:00', '2025-12-25 00:00:00', NULL, 0, 5),
(10, 17, 1, '2025-12-21 00:00:00', '2025-12-31 00:00:00', '2025-12-21 00:00:00', 0, 2),
(11, 17, 9, '2025-12-21 00:00:00', '2025-12-22 00:00:00', '2025-12-29 00:00:00', 0, 2),
(12, 17, 1, '2025-12-21 00:00:00', '2025-12-23 00:00:00', NULL, 0, 1),
(13, 10, 10, '2025-12-22 00:00:00', '2025-12-22 00:00:00', NULL, 0, 1),
(14, 2, 11, '2025-12-23 00:00:00', '2025-12-26 00:00:00', NULL, 0, 4),
(15, 3, 1, '2025-12-29 00:00:00', '2025-12-30 00:00:00', '2025-12-29 00:00:00', 0, 2),
(16, 2, 12, '2025-12-29 00:00:00', '2026-01-01 00:00:00', NULL, 0, 4),
(17, 17, 15, '2025-12-29 00:00:00', '2025-12-30 00:00:00', NULL, 0, 4),
(18, 17, 55, '2025-12-29 00:00:00', '2026-01-08 00:00:00', NULL, 0, 4),
(19, 17, 74, '2025-12-30 00:00:00', '2026-01-01 00:00:00', NULL, 0, 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `borrowing_status`
--

CREATE TABLE `borrowing_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `borrowing_status`
--

INSERT INTO `borrowing_status` (`status_id`, `status_name`) VALUES
(1, 'Borrowed'),
(2, 'Returned'),
(3, 'Overdue'),
(4, 'Pending Approval'),
(5, 'Rejected');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contact_message`
--

CREATE TABLE `contact_message` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `contact_message`
--

INSERT INTO `contact_message` (`message_id`, `user_id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 2, 'Bartu Bulli', 'test123@gmail.com', 'New Books', 'We need more books', '2025-12-14 10:04:25'),
(2, 2, 'Bartu Bulli', 'test123@gmail.com', 'New Books', 'We need more books', '2025-12-14 10:05:29'),
(3, 2, 'Bartu Bulli', 'test123@gmail.com', 'New Books', 'We need more books', '2025-12-14 10:05:54'),
(4, 2, 'Bartu Bulli', 'test123@gmail.com', 'New Books', 'Yeni kitap isderdik', '2025-12-14 10:55:11');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ebook`
--

CREATE TABLE `ebook` (
  `ebook_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `file_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(100) DEFAULT 'Pending',
  `capacity` int(11) DEFAULT NULL,
  `approver_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `event`
--

INSERT INTO `event` (`event_id`, `title`, `description`, `status`, `capacity`, `approver_id`, `created_at`) VALUES
(9, 'Book Reveal', 'New book introduction', 'Pending', 50, NULL, '2025-12-03 20:49:40'),
(10, 'New Book Unveiling', 'New books being introduced to the library', 'Pending', 50, NULL, '2025-12-22 12:56:00'),
(25, 'Poetry slam', 'Event where poets perform original spoken word pieces.', 'Pending', 50, NULL, '2025-12-22 15:57:50'),
(26, 'Book Tastings', 'Students sample various books to find new favorites.', 'Pending', 29, NULL, '2025-12-22 16:06:17'),
(27, 'Book Swap', 'Students bring a gently booked that they read to trade for another.', 'Pending', 24, NULL, '2025-12-23 19:33:44'),
(28, 'Book Displaying', 'Creating dynamic displays(re-designing shelfs)', 'Pending', 15, NULL, '2025-12-23 19:33:55'),
(29, 'Author Meet Up', 'Meet and greet', 'Pending', 24, NULL, '2025-12-28 22:45:38'),
(30, 'Book Buddy Programs', 'Older students read with younger ones.', 'Pending', 34, NULL, '2025-12-28 22:45:41'),
(31, 'Book Buddy Programs', 'Older students read with younger ones.', 'Pending', 40, NULL, '2025-12-28 22:45:43');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `event_attendance`
--

CREATE TABLE `event_attendance` (
  `attendance_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attended` tinyint(1) DEFAULT 0,
  `feedback` text DEFAULT NULL,
  `feedback_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `event_attendance`
--

INSERT INTO `event_attendance` (`attendance_id`, `event_id`, `user_id`, `attended`, `feedback`, `feedback_time`) VALUES
(4, 9, 2, 1, 'Great event', '2025-12-03 22:30:08'),
(5, 29, 2, 1, NULL, NULL),
(6, 30, 3, 1, NULL, NULL),
(7, 27, 3, 1, NULL, NULL),
(8, 26, 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `event_feedback`
--

CREATE TABLE `event_feedback` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `comments` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `event_feedback`
--

INSERT INTO `event_feedback` (`id`, `event_name`, `rating`, `comments`, `email`, `created_at`) VALUES
(1, 'Book competition', 4, 'I really loved it, if it is hosted once again l would gladly come and see the event.', '', '2025-11-25 16:45:20');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `event_proposal`
--

CREATE TABLE `event_proposal` (
  `proposal_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `capacity` int(11) NOT NULL,
  `status_s` enum('Pending','Approved','Rejected') NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `event_id` int(11) NOT NULL,
  `proposed_by` int(11) DEFAULT NULL,
  `approver_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `event_proposal`
--

INSERT INTO `event_proposal` (`proposal_id`, `title`, `description`, `capacity`, `status_s`, `create_at`, `event_id`, `proposed_by`, `approver_id`, `status`, `created_at`) VALUES
(1, 'Book Reveal', 'New book introduction', 50, 'Pending', '2025-12-03 18:49:40', 9, 14, NULL, 'Approved', '2025-12-03 20:49:40'),
(2, 'New Book Unveiling', 'New books being introduced to the library', 50, 'Pending', '2025-12-22 11:14:19', 24, 14, NULL, 'Approved', '2025-12-22 13:14:19'),
(3, 'Poetry Slam', 'Event where poets perform original spoken word pieces for an audience.', 50, 'Pending', '2025-12-22 13:51:25', 0, 14, NULL, 'Rejected', '2025-12-22 15:50:30'),
(4, 'Poetry slam', 'Event where poets perform original spoken word pieces.', 50, 'Pending', '2025-12-22 13:57:50', 25, 14, NULL, 'Approved', '2025-12-22 15:57:50'),
(5, 'Book Tastings', 'Students sample various books to find new favorites.', 30, 'Pending', '2025-12-22 14:06:17', 26, 14, NULL, 'Approved', '2025-12-22 16:06:17'),
(6, 'Book Buddy Programs', 'Older students read with younger ones.', 35, 'Pending', '2025-12-28 20:45:43', 31, 14, NULL, 'Approved', '2025-12-28 22:45:43'),
(7, 'Book Buddy Programs', 'Older students read with younger ones.', 35, 'Pending', '2025-12-28 20:45:41', 30, 14, NULL, 'Approved', '2025-12-28 22:45:41'),
(8, 'Author Meet Up', 'Meet and greet', 25, 'Pending', '2025-12-28 20:45:38', 29, 14, NULL, 'Approved', '2025-12-28 22:45:38'),
(9, 'Book Swap', 'Students bring a gently booked that they read to trade for another.', 25, 'Pending', '2025-12-23 17:33:44', 27, 5, NULL, 'Approved', '2025-12-23 19:33:44'),
(10, 'Book Displaying', 'Creating dynamic displays(re-designing shelfs)', 15, 'Pending', '2025-12-23 17:33:50', 0, 5, NULL, 'Rejected', '2025-12-23 19:31:34'),
(11, 'Book Displaying', 'Creating dynamic displays(re-designing shelfs)', 15, 'Pending', '2025-12-23 17:33:55', 28, 5, NULL, 'Approved', '2025-12-23 19:33:55');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `library_capacity`
--

CREATE TABLE `library_capacity` (
  `capacity_id` int(11) NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `current_occupancy` int(11) NOT NULL,
  `last_updated` datetime DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `library_capacity`
--

INSERT INTO `library_capacity` (`capacity_id`, `max_capacity`, `current_occupancy`, `last_updated`, `updated_by`) VALUES
(1, 100, 90, '2025-12-29 13:28:50', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `library_hours`
--

CREATE TABLE `library_hours` (
  `id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `open_time` time NOT NULL,
  `close_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `library_hours`
--

INSERT INTO `library_hours` (`id`, `day`, `open_time`, `close_time`) VALUES
(1, 'Monday', '08:00:00', '23:00:00'),
(2, 'Tuesday', '08:00:00', '23:00:00'),
(3, 'Wednesday', '08:00:00', '23:00:00'),
(4, 'Thursday', '08:00:00', '23:00:00'),
(5, 'Friday', '08:00:00', '23:00:00'),
(6, 'Saturday', '09:00:00', '20:00:00'),
(7, 'Sunday', '00:00:00', '00:00:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `library_timing`
--

CREATE TABLE `library_timing` (
  `timing_id` int(11) NOT NULL,
  `day_of_week` varchar(20) NOT NULL,
  `open_time` time NOT NULL,
  `close_time` time NOT NULL,
  `holiday` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `login_history`
--

CREATE TABLE `login_history` (
  `login_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `notification`
--

INSERT INTO `notification` (`notification_id`, `user_id`, `title`, `message`, `is_read`, `created_at`) VALUES
(1, 17, 'Borrow Request Approved', 'Your request to borrow \'THE BOOK OF TIME TIME\' has been approved. Please collect the book.', 0, '2025-12-21 18:35:13'),
(2, 15, 'Book Donation Rejected', 'Your donated book \'The What\' was rejected. Please contact the library for details.', 0, '2025-12-21 18:54:15'),
(3, 15, 'Book Donation Rejected', 'Your donated book \'The What\' was rejected. Please contact the library for details.', 0, '2025-12-21 18:55:06'),
(4, 17, 'Book Donation Approved', 'Thank you! Your donated book \'The What\' has been approved and added to the library.', 0, '2025-12-21 19:04:28'),
(5, 1, 'Book Returned', 'User ID 17 has returned the book: \'THE BOOK OF TIME TIME\'.', 0, '2025-12-21 19:24:07'),
(6, 8, 'Book Returned', 'User ID 17 has returned the book: \'THE BOOK OF TIME TIME\'.', 1, '2025-12-21 19:24:07'),
(7, 15, 'Book Returned', 'User ID 17 has returned the book: \'THE BOOK OF TIME TIME\'.', 0, '2025-12-21 19:24:07'),
(8, 5, 'Book Returned', 'User ID 17 has returned the book: \'THE BOOK OF TIME TIME\'.', 0, '2025-12-21 19:24:08'),
(9, 15, 'Borrow Request Rejected', 'Your request to borrow \'THE BOOK OF TIME TIME\' was rejected.', 0, '2025-12-21 20:13:51'),
(10, 15, 'Borrow Request Rejected', 'Your request to borrow \'THE BOOK OF TIME TIME\' was rejected.', 0, '2025-12-21 20:13:54'),
(11, 17, 'Borrow Request Approved', 'Your request to borrow \'The What\' has been approved.', 0, '2025-12-21 20:13:58'),
(12, 17, 'Borrow Request Approved', 'Your request to borrow \'THE BOOK OF TIME TIME\' has been approved.', 0, '2025-12-22 09:41:34'),
(13, 10, 'Book Donation Approved', 'Thank you! Your donated book \'The Leadership Pipeline\' has been approved and added to the library.', 0, '2025-12-22 10:39:20'),
(14, 10, 'Borrow Request Approved', 'Your request to borrow \'The What\' has been approved.', 0, '2025-12-22 10:39:33'),
(15, 14, 'Approved Library Event', 'Your proposed library event \'New Book Unveiling\' has been approved.', 0, '2025-12-22 11:14:19'),
(16, 14, 'Approved Library Event', 'Your proposed library event \'Poetry slam\' has been approved.', 0, '2025-12-22 13:57:50'),
(17, 14, 'Approved Library Event', 'Your proposed library event \'Book Tastings\' has been approved.', 0, '2025-12-22 14:06:18'),
(18, 1, 'New Event Proposal Submitted', 'A new event proposal titled \'Book Buddy Programs\' has been submitted and is awaiting approval.', 0, '2025-12-22 15:36:53'),
(19, 1, 'New Event Proposal Submitted', 'A new event proposal titled \'Author Meet Up\' has been submitted and is awaiting approval.', 1, '2025-12-22 16:06:24'),
(20, 1, 'New Event Proposal Submitted', 'A new event proposal titled \'Book Swap\' has been submitted and is awaiting approval.', 1, '2025-12-23 17:26:39'),
(21, 1, 'New Event Proposal Submitted', 'A new event proposal titled \'Book Displaying\' has been submitted and is awaiting approval.', 1, '2025-12-23 17:31:34'),
(22, 1, 'New Event Proposal Submitted', 'A new event proposal titled \'Book Displaying\' has been submitted and is awaiting approval.', 0, '2025-12-23 17:32:46'),
(23, 5, 'Approved Library Event', 'Your proposed library event \'Book Swap\' has been approved.', 1, '2025-12-23 17:33:44'),
(24, 5, 'Event Proposal Rejected', 'Your event proposal \'Book Displaying\' has been rejected.', 0, '2025-12-23 17:33:50'),
(25, 5, 'Approved Library Event', 'Your proposed library event \'Book Displaying\' has been approved.', 0, '2025-12-23 17:33:55'),
(26, 14, 'Approved Library Event', 'Your proposed library event \'Author Meet Up\' has been approved.', 0, '2025-12-28 20:45:38'),
(27, 14, 'Approved Library Event', 'Your proposed library event \'Book Buddy Programs\' has been approved.', 0, '2025-12-28 20:45:41'),
(28, 14, 'Approved Library Event', 'Your proposed library event \'Book Buddy Programs\' has been approved.', 0, '2025-12-28 20:45:43'),
(29, 3, 'Borrow Request Approved', 'Your request to borrow \'THE BOOK OF TIME TIME\' has been approved.', 0, '2025-12-29 15:02:48'),
(30, 1, 'Book Returned', 'User ID 3 has returned the book: \'THE BOOK OF TIME TIME\'.', 0, '2025-12-29 15:03:50'),
(31, 8, 'Book Returned', 'User ID 3 has returned the book: \'THE BOOK OF TIME TIME\'.', 0, '2025-12-29 15:03:50'),
(32, 15, 'Book Returned', 'User ID 3 has returned the book: \'THE BOOK OF TIME TIME\'.', 0, '2025-12-29 15:03:50'),
(33, 5, 'Book Returned', 'User ID 3 has returned the book: \'THE BOOK OF TIME TIME\'.', 0, '2025-12-29 15:03:50'),
(34, 1, 'Book Returned', 'User ID 17 has returned the book: \'The What\'.', 0, '2025-12-29 21:58:38'),
(35, 8, 'Book Returned', 'User ID 17 has returned the book: \'The What\'.', 0, '2025-12-29 21:58:38'),
(36, 15, 'Book Returned', 'User ID 17 has returned the book: \'The What\'.', 0, '2025-12-29 21:58:38'),
(37, 5, 'Book Returned', 'User ID 17 has returned the book: \'The What\'.', 0, '2025-12-29 21:58:38'),
(38, 17, 'Book Donation Rejected', 'Your donated book \'iyio7\' was rejected. Please contact the library for details.', 0, '2025-12-29 22:23:16'),
(39, 17, 'Book Donation Rejected', 'Your donated book \'hgvhv\' was rejected. Please contact the library for details.', 0, '2025-12-29 22:36:48');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `recommendation`
--

CREATE TABLE `recommendation` (
  `rec_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `suggested_by` int(11) NOT NULL,
  `display_on_dashboard` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `recommendation`
--

INSERT INTO `recommendation` (`rec_id`, `book_id`, `suggested_by`, `display_on_dashboard`) VALUES
(3, 3, 14, 1),
(11, 1, 3, 1),
(12, 14, 16, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reminder`
--

CREATE TABLE `reminder` (
  `reminder_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `reminder_type` varchar(100) DEFAULT NULL,
  `is_sent` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Librarian'),
(3, 'Teacher'),
(4, 'Student');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_number` varchar(50) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `course` varchar(250) NOT NULL,
  `year_level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `remember_me_token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `password`, `role_id`, `reset_token`, `token_expiry`, `remember_me_token`, `created_at`) VALUES
(1, 'Hasan Mani Bulli', '21330969@emu.edu.tr', '$2y$10$poiwEAUXCArLAuCzxRrMReBj3yWhJcxMdc7uR0zM39i4QLChPdPA.', 1, NULL, NULL, NULL, '2025-10-27 10:29:09'),
(2, 'Bartu Bulli', 'test123@gmail.com', '$2y$10$oJX4Q1Rfw6Vru/.Yfv2rsezhS56rsnjggiWVEUMnsVYMdZs/tA0h2', 4, NULL, NULL, NULL, '2025-10-27 10:43:31'),
(3, 'Halide Sarıçizmeli', 'halide@emu.edu.tr', '$2y$10$aF4fhs3ypQIi9RideGmxGuEEtBDCg6GI1x0Db2UMJJbS6fpnN/MfG', 3, NULL, NULL, NULL, '2025-10-27 11:18:40'),
(5, 'Ahmet Kutucu', 'kutucu@gmail.com', '$2y$10$v0Fi2IcwRz4z.lQ04Jauke9fsQzC0iIl0CkAg40ZfEzjHjN26fo/a', 2, NULL, NULL, NULL, '2025-10-27 12:43:26'),
(6, 'Ali Veli', '2564218@emu.edu.tr', '$2y$10$Vm3cp5xb3hfQFTMpm2oIneCiCXKCbpnAL4RTOlx8qBtMmg9u.TjDi', 4, NULL, NULL, NULL, '2025-10-27 13:44:56'),
(8, 'Do-it', 'doit@gmail.com', '$2y$10$/.bsuAiznvMpV/C4WFTDKuFDviV.kA9xaS7NX.EWvynnmM5GrY/A2', 1, NULL, NULL, NULL, '2025-10-27 22:36:58'),
(10, 'Arther', '21900005@emu.edu.tr', '$2y$10$P9e5VZRllI8im8tcEoUKG.lPdMm.5DdUhanijeY.x/iRSj8wZ9NGS', 4, NULL, NULL, NULL, '2025-10-29 11:15:09'),
(11, 'Arther', '2612345@emu.edu.tr', '$2y$10$C/dl7AAkXJRpSksFW0C1UeeoPK4KSQ.UJ5vFxVyzlBJsIERkLUYh.', 4, NULL, NULL, NULL, '2025-10-29 11:23:31'),
(14, 'Arther Doit', 'arther@emu.edu.tr', '$2y$10$4hThaUAnfeFp1zPuyDljyu/6YKqTXzLelfu1d0tGG7XDeNbTnlS2C', 3, NULL, NULL, NULL, '2025-12-02 11:24:08'),
(15, 'Aliyu Adamu Musa', '22900908@emu.edu.tr', '$2y$10$IyXp2TiA3oaExPLKnbHVXe31EzRCZ2x/wm7c.DPboyslwSJO8R38u', 1, NULL, NULL, NULL, '2025-12-06 17:24:43'),
(16, 'alee', 'AA@emu.edu.tr', '$2y$10$JbdxzgBDSHAt2AmIrkabXOjJGQ1.QE4Gk2S14PPw6NTYiXwzqz8Zy', 3, NULL, NULL, NULL, '2025-12-15 20:06:45'),
(17, 'aliyu', 'aliyu@emu.edu.tr', '$2y$10$EYJdPm5j.1TrZ0lRovIP1e3ssUxtcEsnDWuebPW5FSB.sTSUCdJX6', 4, NULL, NULL, NULL, '2025-12-21 20:13:40');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `user_id`, `book_id`, `created_at`) VALUES
(10, 2, 4, '2025-12-23 16:11:13'),
(15, 3, 4, '2025-12-29 17:44:39'),
(16, 2, 1, '2025-12-29 18:15:49'),
(17, 17, 6, '2025-12-29 21:21:46');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `account_blockage`
--
ALTER TABLE `account_blockage`
  ADD PRIMARY KEY (`block_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Tablo için indeksler `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD UNIQUE KEY `isbn_2` (`isbn`),
  ADD KEY `category_id` (`category_id`);

--
-- Tablo için indeksler `book_category`
--
ALTER TABLE `book_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Tablo için indeksler `book_donation`
--
ALTER TABLE `book_donation`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `approver_id` (`approver_id`);

--
-- Tablo için indeksler `book_inventory`
--
ALTER TABLE `book_inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Tablo için indeksler `book_management_log`
--
ALTER TABLE `book_management_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `performed_by` (`performed_by`);

--
-- Tablo için indeksler `book_rating`
--
ALTER TABLE `book_rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Tablo için indeksler `borrowing`
--
ALTER TABLE `borrowing`
  ADD PRIMARY KEY (`borrowing_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `inventory_id` (`inventory_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Tablo için indeksler `borrowing_status`
--
ALTER TABLE `borrowing_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Tablo için indeksler `contact_message`
--
ALTER TABLE `contact_message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `ebook`
--
ALTER TABLE `ebook`
  ADD PRIMARY KEY (`ebook_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Tablo için indeksler `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `approver_id` (`approver_id`);

--
-- Tablo için indeksler `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `event_feedback`
--
ALTER TABLE `event_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `event_proposal`
--
ALTER TABLE `event_proposal`
  ADD PRIMARY KEY (`proposal_id`);

--
-- Tablo için indeksler `library_capacity`
--
ALTER TABLE `library_capacity`
  ADD PRIMARY KEY (`capacity_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Tablo için indeksler `library_hours`
--
ALTER TABLE `library_hours`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `library_timing`
--
ALTER TABLE `library_timing`
  ADD PRIMARY KEY (`timing_id`);

--
-- Tablo için indeksler `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`login_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `recommendation`
--
ALTER TABLE `recommendation`
  ADD PRIMARY KEY (`rec_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `suggested_by` (`suggested_by`);

--
-- Tablo için indeksler `reminder`
--
ALTER TABLE `reminder`
  ADD PRIMARY KEY (`reminder_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Tablo için indeksler `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Tablo için indeksler `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Tablo için indeksler `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `account_blockage`
--
ALTER TABLE `account_blockage`
  MODIFY `block_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=555;

--
-- Tablo için AUTO_INCREMENT değeri `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Tablo için AUTO_INCREMENT değeri `book_category`
--
ALTER TABLE `book_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Tablo için AUTO_INCREMENT değeri `book_donation`
--
ALTER TABLE `book_donation`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `book_inventory`
--
ALTER TABLE `book_inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- Tablo için AUTO_INCREMENT değeri `book_management_log`
--
ALTER TABLE `book_management_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `book_rating`
--
ALTER TABLE `book_rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `borrowing`
--
ALTER TABLE `borrowing`
  MODIFY `borrowing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `borrowing_status`
--
ALTER TABLE `borrowing_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `contact_message`
--
ALTER TABLE `contact_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `ebook`
--
ALTER TABLE `ebook`
  MODIFY `ebook_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Tablo için AUTO_INCREMENT değeri `event_attendance`
--
ALTER TABLE `event_attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `event_feedback`
--
ALTER TABLE `event_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `event_proposal`
--
ALTER TABLE `event_proposal`
  MODIFY `proposal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `library_capacity`
--
ALTER TABLE `library_capacity`
  MODIFY `capacity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `library_hours`
--
ALTER TABLE `library_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `library_timing`
--
ALTER TABLE `library_timing`
  MODIFY `timing_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `login_history`
--
ALTER TABLE `login_history`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Tablo için AUTO_INCREMENT değeri `recommendation`
--
ALTER TABLE `recommendation`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `reminder`
--
ALTER TABLE `reminder`
  MODIFY `reminder_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `account_blockage`
--
ALTER TABLE `account_blockage`
  ADD CONSTRAINT `account_blockage_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Tablo kısıtlamaları `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `book_category` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `book_donation`
--
ALTER TABLE `book_donation`
  ADD CONSTRAINT `book_donation_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_donation_ibfk_2` FOREIGN KEY (`approver_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `book_inventory`
--
ALTER TABLE `book_inventory`
  ADD CONSTRAINT `book_inventory_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `book_management_log`
--
ALTER TABLE `book_management_log`
  ADD CONSTRAINT `book_management_log_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_management_log_ibfk_2` FOREIGN KEY (`performed_by`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `book_rating`
--
ALTER TABLE `book_rating`
  ADD CONSTRAINT `book_rating_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_rating_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `borrowing`
--
ALTER TABLE `borrowing`
  ADD CONSTRAINT `borrowing_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `borrowing_ibfk_2` FOREIGN KEY (`inventory_id`) REFERENCES `book_inventory` (`inventory_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `borrowing_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `borrowing_status` (`status_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `contact_message`
--
ALTER TABLE `contact_message`
  ADD CONSTRAINT `contact_message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL;

--
-- Tablo kısıtlamaları `ebook`
--
ALTER TABLE `ebook`
  ADD CONSTRAINT `ebook_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`approver_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD CONSTRAINT `event_attendance_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_attendance_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `library_capacity`
--
ALTER TABLE `library_capacity`
  ADD CONSTRAINT `library_capacity_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`);

--
-- Tablo kısıtlamaları `login_history`
--
ALTER TABLE `login_history`
  ADD CONSTRAINT `login_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `recommendation`
--
ALTER TABLE `recommendation`
  ADD CONSTRAINT `recommendation_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recommendation_ibfk_2` FOREIGN KEY (`suggested_by`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `reminder`
--
ALTER TABLE `reminder`
  ADD CONSTRAINT `reminder_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
