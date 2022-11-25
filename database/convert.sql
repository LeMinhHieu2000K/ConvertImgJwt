-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2022 at 03:34 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `convert`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `img`
--

CREATE TABLE `img` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `extension` varchar(255) NOT NULL,
  `size` int(255) NOT NULL,
  `formatSize` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `imgafter`
--

CREATE TABLE `imgafter` (
  `id` int(255) NOT NULL,
  `id_img` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `formatSizeBefore` varchar(255) NOT NULL,
  `formatSizeAfter` varchar(255) NOT NULL,
  `decleare` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `imgclient`
--

CREATE TABLE `imgclient` (
  `id` int(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '99999999999', NULL, '$2y$10$VeHu9MgmIKV5xfb188j2i./wThX0s9pmKU2c/f.We57rNoT4MjdpG', 'Admin', NULL, '2022-11-21 03:45:44', '2022-11-21 03:45:44'),
(7, 'hieu', 'huple84@gmail.com', '945653718', NULL, '$2y$10$wMEVHsaGy3oceYYAXbuIO.D9QgpMry2XZE5QNDq9DuA5wboGmABku', 'user', NULL, '2022-11-24 04:03:12', '2022-11-24 04:03:12');

-- --------------------------------------------------------

--
-- Table structure for table `verification_codes`
--

CREATE TABLE `verification_codes` (
  `id` int(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `expire_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `verification_codes`
--

INSERT INTO `verification_codes` (`id`, `user_id`, `otp`, `expire_at`, `created_at`, `updated_at`) VALUES
(1, 1, '947443', '2022-11-24 01:15:07', '2022-11-24 01:14:59', '2022-11-24 01:15:07'),
(2, 1, '739319', '2022-11-24 01:15:40', '2022-11-24 01:15:36', '2022-11-24 01:15:40'),
(3, 5, '496326', '2022-11-24 01:27:59', '2022-11-24 01:27:29', '2022-11-24 01:27:59'),
(4, 5, '601618', '2022-11-24 01:39:31', '2022-11-24 01:29:31', '2022-11-24 01:29:31'),
(5, 5, '773762', '2022-11-24 01:49:32', '2022-11-24 01:39:32', '2022-11-24 01:39:32'),
(6, 5, '589342', '2022-11-24 02:07:21', '2022-11-24 01:57:21', '2022-11-24 01:57:21'),
(7, 7, '864760', '2022-11-24 04:52:19', '2022-11-24 04:48:50', '2022-11-24 04:52:19'),
(8, 7, '156286', '2022-11-24 04:53:49', '2022-11-24 04:53:46', '2022-11-24 04:53:49'),
(9, 7, '396253', '2022-11-24 08:29:54', '2022-11-24 08:19:54', '2022-11-24 08:19:54'),
(10, 7, '726169', '2022-11-24 08:43:04', '2022-11-24 08:33:04', '2022-11-24 08:33:04'),
(11, 7, '324999', '2022-11-24 09:01:27', '2022-11-24 08:51:27', '2022-11-24 08:51:27'),
(12, 7, '534519', '2022-11-24 09:16:15', '2022-11-24 09:06:15', '2022-11-24 09:06:15'),
(13, 7, '926495', '2022-11-24 09:19:59', '2022-11-24 09:19:52', '2022-11-24 09:19:59'),
(14, 7, '180305', '2022-11-24 09:21:49', '2022-11-24 09:21:45', '2022-11-24 09:21:49'),
(15, 7, '535817', '2022-11-24 09:33:38', '2022-11-24 09:23:38', '2022-11-24 09:23:38'),
(16, 7, '989642', '2022-11-24 09:44:54', '2022-11-24 09:35:39', '2022-11-24 09:44:54'),
(17, 7, '318280', '2022-11-24 09:49:49', '2022-11-24 09:49:45', '2022-11-24 09:49:49'),
(18, 7, '958685', '2022-11-24 10:05:00', '2022-11-24 09:55:00', '2022-11-24 09:55:00'),
(19, 7, '851200', '2022-11-24 10:17:23', '2022-11-24 10:07:23', '2022-11-24 10:07:23'),
(20, 7, '364502', '2022-11-24 10:53:08', '2022-11-24 10:48:33', '2022-11-24 10:53:08'),
(21, 7, '357491', '2022-11-24 10:54:57', '2022-11-24 10:54:53', '2022-11-24 10:54:57'),
(22, 7, '159718', '2022-11-24 10:55:50', '2022-11-24 10:55:47', '2022-11-24 10:55:50'),
(23, 7, '892672', '2022-11-24 10:56:59', '2022-11-24 10:56:55', '2022-11-24 10:56:59'),
(24, 7, '397063', '2022-11-24 10:59:10', '2022-11-24 10:59:06', '2022-11-24 10:59:10'),
(25, 7, '451296', '2022-11-24 19:01:03', '2022-11-24 18:55:29', '2022-11-24 19:01:03'),
(26, 7, '615546', '2022-11-24 19:15:34', '2022-11-24 19:15:30', '2022-11-24 19:15:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `img`
--
ALTER TABLE `img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `imgafter`
--
ALTER TABLE `imgafter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `imgclient`
--
ALTER TABLE `imgclient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `verification_codes`
--
ALTER TABLE `verification_codes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `img`
--
ALTER TABLE `img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=530;

--
-- AUTO_INCREMENT for table `imgafter`
--
ALTER TABLE `imgafter`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `imgclient`
--
ALTER TABLE `imgclient`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `verification_codes`
--
ALTER TABLE `verification_codes`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
