-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2025 at 02:31 PM
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
-- Database: `librarydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_blockage`
--

CREATE TABLE `account_blockage` (
  `block_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `block_date` datetime DEFAULT current_timestamp(),
  `reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
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
(83, 8, 'Logged in successfully', '2025-11-29 15:23:55');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(150) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `book_type` varchar(100) DEFAULT NULL,
  `availability_status` varchar(50) DEFAULT 'Available',
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_category`
--

CREATE TABLE `book_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_donation`
--

CREATE TABLE `book_donation` (
  `donation_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `approver_id` int(11) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `approved_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_inventory`
--

CREATE TABLE `book_inventory` (
  `inventory_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `copy_number` int(11) DEFAULT NULL,
  `book_condition` varchar(100) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_management_log`
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
-- Table structure for table `book_rating`
--

CREATE TABLE `book_rating` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `rating_value` int(11) DEFAULT NULL CHECK (`rating_value` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `borrowing`
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

-- --------------------------------------------------------

--
-- Table structure for table `borrowing_status`
--

CREATE TABLE `borrowing_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_message`
--

CREATE TABLE `contact_message` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ebook`
--

CREATE TABLE `ebook` (
  `ebook_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `file_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event`
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
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `title`, `description`, `status`, `capacity`, `approver_id`, `created_at`) VALUES
(4, 'Book Reading', 'Study Session', 'Pending', 30, NULL, '2025-10-29 04:00:55'),
(5, 'Author and guest talks', 'Host in-person lectures, readings, and presentations by authors and other experts.', 'Pending', 30, NULL, '2025-10-29 04:35:25'),
(6, 'Book competition', 'Book giveaway and winner gets a prize.', 'Pending', 30, NULL, '2025-10-29 11:34:17'),
(7, 'Social Gathering', 'Meet and greet', 'Pending', 50, NULL, '2025-11-25 11:12:05');

-- --------------------------------------------------------

--
-- Table structure for table `event_attendance`
--

CREATE TABLE `event_attendance` (
  `attendance_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attended` tinyint(1) DEFAULT 0,
  `feedback` text DEFAULT NULL,
  `feedback_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_feedback`
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
-- Dumping data for table `event_feedback`
--

INSERT INTO `event_feedback` (`id`, `event_name`, `rating`, `comments`, `email`, `created_at`) VALUES
(1, 'Book competition', 4, 'I really loved it, if it is hosted once again l would gladly come and see the event.', '', '2025-11-25 16:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `event_proposal`
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
-- Dumping data for table `event_proposal`
--

INSERT INTO `event_proposal` (`proposal_id`, `title`, `description`, `capacity`, `status_s`, `create_at`, `event_id`, `proposed_by`, `approver_id`, `status`, `created_at`) VALUES
(10, 'IT Serminar', 'Carrier Guidance', 50, 'Pending', '2025-10-28 16:39:54', 0, 8, NULL, 'Rejected', '2025-10-28 18:19:10'),
(11, 'Society Games', 'Sports', 200, 'Pending', '2025-10-28 16:45:01', 3, 8, NULL, 'Approved', '2025-10-28 18:45:01'),
(12, 'Book Reading', 'Study Session', 30, 'Pending', '2025-10-29 02:00:55', 4, 8, NULL, 'Approved', '2025-10-29 04:00:55'),
(13, 'Author and guest talks', 'Host in-person lectures, readings, and presentations by authors and other experts.', 30, 'Pending', '2025-10-29 02:35:25', 5, 8, NULL, 'Approved', '2025-10-29 04:35:25'),
(14, 'Meet the author from the past', 'This is a creative and engaging event where students research a historical author.', 25, 'Pending', '2025-10-29 09:34:17', 6, 8, NULL, 'Approved', '2025-10-29 11:34:17'),
(15, 'Social Gathering', 'Meet and greet', 50, 'Pending', '2025-11-25 09:12:05', 7, 8, NULL, 'Approved', '2025-11-25 11:12:05'),
(17, 'Book meeting', 'Book reading and breakdown', 25, 'Pending', '2025-11-25 10:03:07', 0, 8, NULL, 'Pending', '2025-11-25 12:03:07');

-- --------------------------------------------------------

--
-- Table structure for table `library_timing`
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
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `login_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_type`
--

CREATE TABLE `notification_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recommendation`
--

CREATE TABLE `recommendation` (
  `rec_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `suggested_by` int(11) NOT NULL,
  `display_on_dashboard` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reminder`
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
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Librarian'),
(3, 'Teacher'),
(4, 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `user`
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
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `password`, `role_id`, `reset_token`, `token_expiry`, `remember_me_token`, `created_at`) VALUES
(1, 'Hasan Mani Bulli', '21330969@emu.edu.tr', '$2y$10$Ky4yCy4ClKShEWYAs92yxuSIj8EuChYYPPkhqZ92mHNQPA7aXbHSm', 1, NULL, NULL, NULL, '2025-10-27 10:29:09'),
(2, 'Bartu Bulli', 'test123@gmail.com', '$2y$10$OMzdSi3NKnRER/EQcJut7.NqfwMx3kk9o/ZEUNYaZpoU2DvntIelm', 4, NULL, NULL, NULL, '2025-10-27 10:43:31'),
(3, 'Halide Sarıçizmeli', 'halide@emu.edu.tr', '$2y$10$pv6tIsd3AkwuLNDjlbvdbOAJDOkMpiaQRt8Icg6ApJMxXnAqTSg5i', 3, NULL, NULL, NULL, '2025-10-27 11:18:40'),
(5, 'Ahmet Kutucu', 'kutucu@gmail.com', '$2y$10$Gdx6KObZ4IQs5O3NTUcAQ.0cDk.tzvD./BvNprYHD85gO93m8/voi', 2, NULL, NULL, NULL, '2025-10-27 12:43:26'),
(6, 'Ali Veli', '2564218@emu.edu.tr', '$2y$10$Vm3cp5xb3hfQFTMpm2oIneCiCXKCbpnAL4RTOlx8qBtMmg9u.TjDi', 4, NULL, NULL, NULL, '2025-10-27 13:44:56'),
(8, 'Do-it', 'doit@gmail.com', '$2y$10$/.bsuAiznvMpV/C4WFTDKuFDviV.kA9xaS7NX.EWvynnmM5GrY/A2', 1, NULL, NULL, NULL, '2025-10-27 22:36:58'),
(10, 'Arther', '21900005@emu.edu.tr', '$2y$10$P9e5VZRllI8im8tcEoUKG.lPdMm.5DdUhanijeY.x/iRSj8wZ9NGS', 4, NULL, NULL, NULL, '2025-10-29 11:15:09'),
(11, 'Arther', '2612345@emu.edu.tr', '$2y$10$C/dl7AAkXJRpSksFW0C1UeeoPK4KSQ.UJ5vFxVyzlBJsIERkLUYh.', 4, NULL, NULL, NULL, '2025-10-29 11:23:31');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `notify_when_available` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_blockage`
--
ALTER TABLE `account_blockage`
  ADD PRIMARY KEY (`block_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `book_category`
--
ALTER TABLE `book_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `book_donation`
--
ALTER TABLE `book_donation`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `approver_id` (`approver_id`);

--
-- Indexes for table `book_inventory`
--
ALTER TABLE `book_inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `book_management_log`
--
ALTER TABLE `book_management_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `performed_by` (`performed_by`);

--
-- Indexes for table `book_rating`
--
ALTER TABLE `book_rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `borrowing`
--
ALTER TABLE `borrowing`
  ADD PRIMARY KEY (`borrowing_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `inventory_id` (`inventory_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `borrowing_status`
--
ALTER TABLE `borrowing_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `contact_message`
--
ALTER TABLE `contact_message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ebook`
--
ALTER TABLE `ebook`
  ADD PRIMARY KEY (`ebook_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `approver_id` (`approver_id`);

--
-- Indexes for table `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `event_feedback`
--
ALTER TABLE `event_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_proposal`
--
ALTER TABLE `event_proposal`
  ADD PRIMARY KEY (`proposal_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `proposed_by` (`proposed_by`),
  ADD KEY `approver_id` (`approver_id`);

--
-- Indexes for table `library_timing`
--
ALTER TABLE `library_timing`
  ADD PRIMARY KEY (`timing_id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`login_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `notification_type`
--
ALTER TABLE `notification_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `recommendation`
--
ALTER TABLE `recommendation`
  ADD PRIMARY KEY (`rec_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `suggested_by` (`suggested_by`);

--
-- Indexes for table `reminder`
--
ALTER TABLE `reminder`
  ADD PRIMARY KEY (`reminder_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_blockage`
--
ALTER TABLE `account_blockage`
  MODIFY `block_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_category`
--
ALTER TABLE `book_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_donation`
--
ALTER TABLE `book_donation`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_inventory`
--
ALTER TABLE `book_inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_management_log`
--
ALTER TABLE `book_management_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_rating`
--
ALTER TABLE `book_rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `borrowing`
--
ALTER TABLE `borrowing`
  MODIFY `borrowing_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `borrowing_status`
--
ALTER TABLE `borrowing_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_message`
--
ALTER TABLE `contact_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ebook`
--
ALTER TABLE `ebook`
  MODIFY `ebook_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `event_attendance`
--
ALTER TABLE `event_attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_feedback`
--
ALTER TABLE `event_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_proposal`
--
ALTER TABLE `event_proposal`
  MODIFY `proposal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `library_timing`
--
ALTER TABLE `library_timing`
  MODIFY `timing_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_type`
--
ALTER TABLE `notification_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recommendation`
--
ALTER TABLE `recommendation`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reminder`
--
ALTER TABLE `reminder`
  MODIFY `reminder_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_blockage`
--
ALTER TABLE `account_blockage`
  ADD CONSTRAINT `account_blockage_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `book_category` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `book_donation`
--
ALTER TABLE `book_donation`
  ADD CONSTRAINT `book_donation_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_donation_ibfk_2` FOREIGN KEY (`approver_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `book_inventory`
--
ALTER TABLE `book_inventory`
  ADD CONSTRAINT `book_inventory_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_management_log`
--
ALTER TABLE `book_management_log`
  ADD CONSTRAINT `book_management_log_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_management_log_ibfk_2` FOREIGN KEY (`performed_by`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_rating`
--
ALTER TABLE `book_rating`
  ADD CONSTRAINT `book_rating_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_rating_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `borrowing`
--
ALTER TABLE `borrowing`
  ADD CONSTRAINT `borrowing_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `borrowing_ibfk_2` FOREIGN KEY (`inventory_id`) REFERENCES `book_inventory` (`inventory_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `borrowing_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `borrowing_status` (`status_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `contact_message`
--
ALTER TABLE `contact_message`
  ADD CONSTRAINT `contact_message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ebook`
--
ALTER TABLE `ebook`
  ADD CONSTRAINT `ebook_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`approver_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD CONSTRAINT `event_attendance_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_attendance_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_proposal`
--
ALTER TABLE `event_proposal`
  ADD CONSTRAINT `event_proposal_ibfk_2` FOREIGN KEY (`proposed_by`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_proposal_ibfk_3` FOREIGN KEY (`approver_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `login_history`
--
ALTER TABLE `login_history`
  ADD CONSTRAINT `login_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `notification_type` (`type_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `recommendation`
--
ALTER TABLE `recommendation`
  ADD CONSTRAINT `recommendation_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recommendation_ibfk_2` FOREIGN KEY (`suggested_by`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reminder`
--
ALTER TABLE `reminder`
  ADD CONSTRAINT `reminder_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
