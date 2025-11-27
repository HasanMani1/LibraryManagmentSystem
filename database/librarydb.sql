-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 27 Eki 2025, 13:38:08
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
(5, 1, 'Logged in successfully', '2025-10-27 14:15:12');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `book`
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
-- Tablo için tablo yapısı `book_category`
--

CREATE TABLE `book_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `approved_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `borrowing_status`
--

CREATE TABLE `borrowing_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contact_message`
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

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `event_attendance`
--

CREATE TABLE `event_attendance` (
  `attendance_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attended` tinyint(1) DEFAULT 0,
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `event_proposal`
--

CREATE TABLE `event_proposal` (
  `proposal_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `proposed_by` int(11) NOT NULL,
  `approver_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `message` text NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `channel` varchar(100) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notification_type`
--

CREATE TABLE `notification_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Hasan Mani Bulli', '21330969@emu.edu.tr', '$2y$10$Ky4yCy4ClKShEWYAs92yxuSIj8EuChYYPPkhqZ92mHNQPA7aXbHSm', 1, NULL, NULL, NULL, '2025-10-27 10:29:09'),
(2, 'Bartu Bulli', 'test123@gmail.com', '$2y$10$OMzdSi3NKnRER/EQcJut7.NqfwMx3kk9o/ZEUNYaZpoU2DvntIelm', 4, NULL, NULL, NULL, '2025-10-27 10:43:31'),
(3, 'Halide Sarıçizmeli', 'halide@emu.edu.tr', '$2y$10$pv6tIsd3AkwuLNDjlbvdbOAJDOkMpiaQRt8Icg6ApJMxXnAqTSg5i', 3, NULL, NULL, NULL, '2025-10-27 11:18:40'),
(5, 'Ahmet Kutucu', 'kutucu@gmail.com', '$2y$10$Gdx6KObZ4IQs5O3NTUcAQ.0cDk.tzvD./BvNprYHD85gO93m8/voi', 2, NULL, NULL, NULL, '2025-10-27 12:43:26'),
(6, 'Ali Veli', '2564218@emu.edu.tr', '$2y$10$Vm3cp5xb3hfQFTMpm2oIneCiCXKCbpnAL4RTOlx8qBtMmg9u.TjDi', 4, NULL, NULL, NULL, '2025-10-27 13:44:56');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `notify_when_available` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Tablo için indeksler `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
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
-- Tablo için indeksler `event_proposal`
--
ALTER TABLE `event_proposal`
  ADD PRIMARY KEY (`proposal_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `proposed_by` (`proposed_by`),
  ADD KEY `approver_id` (`approver_id`);

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Tablo için indeksler `notification_type`
--
ALTER TABLE `notification_type`
  ADD PRIMARY KEY (`type_id`);

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
  ADD KEY `user_id` (`user_id`),
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
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `book_category`
--
ALTER TABLE `book_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `book_donation`
--
ALTER TABLE `book_donation`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `book_inventory`
--
ALTER TABLE `book_inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `book_management_log`
--
ALTER TABLE `book_management_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `book_rating`
--
ALTER TABLE `book_rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `borrowing`
--
ALTER TABLE `borrowing`
  MODIFY `borrowing_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `borrowing_status`
--
ALTER TABLE `borrowing_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `contact_message`
--
ALTER TABLE `contact_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `ebook`
--
ALTER TABLE `ebook`
  MODIFY `ebook_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `event_attendance`
--
ALTER TABLE `event_attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `event_proposal`
--
ALTER TABLE `event_proposal`
  MODIFY `proposal_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `notification_type`
--
ALTER TABLE `notification_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `recommendation`
--
ALTER TABLE `recommendation`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Tablo için AUTO_INCREMENT değeri `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `contact_message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Tablo kısıtlamaları `event_proposal`
--
ALTER TABLE `event_proposal`
  ADD CONSTRAINT `event_proposal_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_proposal_ibfk_2` FOREIGN KEY (`proposed_by`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_proposal_ibfk_3` FOREIGN KEY (`approver_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `login_history`
--
ALTER TABLE `login_history`
  ADD CONSTRAINT `login_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `notification_type` (`type_id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
